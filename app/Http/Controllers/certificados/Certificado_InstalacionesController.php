<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Revisor;
use App\Models\Documentacion_url;
use App\Models\instalaciones;
use App\Models\empresa;
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Certificado_InstalacionesController extends Controller
{

    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::where('estatus', '!=', 1)
            ->orderBy('id_dictamen', 'desc')
            ->get();
        $users = User::where('tipo', 1)->get();
        $revisores = Revisor::all();
        return view('certificados.find_certificados_instalaciones', compact('dictamenes', 'users', 'revisores'));
    }


public function index(Request $request)
{
    //Permiso de empresa
    $empresaId = null;
    if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaId = Auth::user()->empresa?->id_empresa;
    }

    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses
    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        1 => 'num_certificado',
        2 => 'folio',
        3 => 'razon_social',
        4 => '',
        5 => 'fecha_emision',
        6 => 'estatus',
    ];

    $limit = $request->input('length');
    $start = $request->input('start');
    $orderColumnIndex = $request->input('order.0.column');
    $orderDirection = $request->input('order.0.dir') ?? 'asc';
    $orderColumn = $columns[$orderColumnIndex] ?? 'num_certificado';// Por defecto

    $search = $request->input('search.value');


    $query = Certificados::query()
        ->leftJoin('dictamenes_instalaciones', 'dictamenes_instalaciones.id_dictamen', '=', 'certificados.id_dictamen')
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_instalaciones.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->leftJoin('instalaciones', 'instalaciones.id_instalacion', '=', 'dictamenes_instalaciones.id_instalacion')
        ->select('certificados.*', 'empresa.razon_social');

    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;
    $totalData = $baseQuery->count();


    // Mapeo de nombres a valores numéricos de tipo certificado
    $tiposCertificados = [
        'productor' => 1,
        'envasador' => 2,
        'comercializador' => 3,
        'almacén y bodega' => 4,
        'área de maduración' => 5,
    ];
    // Búsqueda Global
    if (!empty($search)) {
        // Convertir a minúsculas sin tildes para comparar
        $searchNormalized = mb_strtolower(trim($search), 'UTF-8');
        // También elimina tildes para mejor comparación
        $searchNormalized = strtr($searchNormalized, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u'
        ]);
        // Buscar coincidencia de nombre
        $tipoCertificadoValor = null;
        foreach ($tiposCertificados as $nombre => $valor) {
            $nombreNormalizado = strtr(mb_strtolower($nombre, 'UTF-8'), [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u'
            ]);
            if (strpos($searchNormalized, $nombreNormalizado) !== false) {
                $tipoCertificadoValor = $valor;
                break;
            }
        }

        $query->where(function ($q) use ($search, $tipoCertificadoValor){
            $q->where('certificados.num_certificado', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_instalaciones.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(certificados.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"])
            ->orWhere('instalaciones.direccion_completa', 'LIKE', "%{$search}%");

            // Si se encontró un valor válido para el tipo_dictamen, agregarlo
            if (!is_null($tipoCertificadoValor)) {
                $q->orWhere('dictamenes_instalaciones.tipo_dictamen', $tipoCertificadoValor);
            }

        });

        $totalFiltered = $query->count();
    }  else {
        $totalFiltered = $totalData;
    }

    // Ordenamiento especial para num_certificado con formato 'CIDAM C-INS25-###'
    if ($orderColumn === 'num_certificado') {
        $query->orderByRaw("
            CASE
                WHEN num_certificado LIKE 'CIDAM C-INS25-%' THEN 0
                ELSE 1
            END ASC,
            CAST(
                SUBSTRING_INDEX(
                    SUBSTRING(num_certificado, LOCATE('CIDAM C-INS25-', num_certificado) + 14),
                    '-', 1
                ) AS UNSIGNED
            ) $orderDirection
        ");
    } elseif (!empty($orderColumn)) {
        $query->orderBy($orderColumn, $orderDirection);
    }


    // Paginación
    $certificados = $query
        ->with([// 1 consulta por cada tabla relacionada en conjunto (menos busqueda adicionales de query en BD)
            'dictamen',// Relación directa
            'dictamen.inspeccione',// Relación anidada: dictamen > inspeccione
            'dictamen.inspeccione.solicitud',
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.inspeccione.solicitud.empresa.empresaNumClientes',
            'revisorPersonal.user',
            'revisorConsejo.user',
        ])->offset($start)->limit($limit)->get();


        // Map data for DataTables
        /*$data = $certificados->map(function ($certificado, $index) use ($request) {
            $empresa = $certificado->dictamen->instalaciones->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                : 'N/A';

                $fechaActual = Carbon::now()->startOfDay(); // Asegúrate de trabajar solo con fechas, sin horas
                $fechaVigencia = Carbon::parse($certificado->fecha_vencimiento)->startOfDay();

                if ($fechaActual->isSameDay($fechaVigencia)) {
                    $restantes = "<span class='badge bg-danger'>Hoy se vence este dictamen</span>";
                } else {
                    $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);

                    if ($diasRestantes > 0) {
                        if($diasRestantes > 15){
                            $res = "<span class='badge bg-label-success'>$diasRestantes días de vigencia.</span>";
                        }else{
                            $res = "<span class='badge bgl-label-warning'>$diasRestantes días de vigencia.</span>";
                        }
                        $restantes = $res;
                    } else {
                        $restantes = "<span class='badge bg-label-danger'>Vencido hace " . abs($diasRestantes) . " días.</span>";
                    }
                }

            return [
                'id_certificado' => $certificado->id_certificado,
                'id_dictamen' => $certificado->id_dictamen,
                'fake_id' => $request->input('start') + $index + 1,
                'num_certificado' => $certificado->num_certificado,
                'razon_social' => $empresa->razon_social ?? 'N/A',
                'domicilio_instalacion' => $certificado->dictamen->instalaciones->direccion_completa ?? "N/A",
                'numero_cliente' => $numero_cliente,
                'num_autorizacion' => $certificado->num_autorizacion ?? 'N/A',
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento),
                'maestro_mezcalero' => $certificado->maestro_mezcalero ?? 'N/A',
                'num_dictamen' => $certificado->dictamen->num_dictamen,
                'num_servicio' => $certificado->dictamen->inspeccione->num_servicio ?? 'Sin definir',
                'tipo_dictamen' => $certificado->dictamen->tipo_dictamen,
                'id_revisor' => $certificado->revisor && $certificado->revisor->user ? $certificado->revisor->user->name : 'Sin asignar',
                'id_revisor2' => $certificado->revisor && $certificado->revisor->user2 ? $certificado->revisor->user2->name : 'Sin asignar',
                'id_firmante' => $certificado->firmante->name ?? 'Sin asignar',
                'estatus' => $certificado->estatus,
                'diasRestantes' => $restantes,

            ];
        });*/
        $data = [];
        if (!empty($certificados)) {
            foreach ($certificados as $certificado) {
                $nestedData['id_certificado'] = $certificado->id_certificado ?? 'No encontrado';
                $nestedData['num_certificado'] = $certificado->num_certificado ?? 'No encontrado';
                $nestedData['id_dictamen'] = $certificado->dictamen->id_dictamen ?? 'No encontrado';
                $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'No encontrado';
                $nestedData['tipo_dictamen'] = $certificado->dictamen->tipo_dictamen ?? 'No encontrado';
                $nestedData['direccion_completa'] = $certificado->dictamen->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrado';
                $nestedData['estatus'] = $certificado->estatus ?? 'No encontrado';
                $id_sustituye = json_decode($certificado->observaciones, true)['id_sustituye'] ?? null;
                $nestedData['sustituye'] = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : null;
                $nestedData['fecha_emision'] = Helpers::formatearFecha($certificado->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($certificado->fecha_vigencia);
                ///Folio y no. servicio
                $nestedData['num_servicio'] = $certificado->dictamen->inspeccione->num_servicio ?? 'No encontrado';
                $nestedData['folio_solicitud'] = $certificado->dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
                //Nombre y Numero empresa
                $empresa = $certificado->dictamen->inspeccione->solicitud->empresa ?? null;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                        ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
                //Revisiones
                $nestedData['revisor_personal'] = $certificado->revisorPersonal->user->name ?? null;
                $nestedData['numero_revision_personal'] = $certificado->revisorPersonal->numero_revision ?? null;
                $nestedData['decision_personal'] = $certificado->revisorPersonal->decision?? null;
                $nestedData['respuestas_personal'] = $certificado->revisorPersonal->respuestas ?? null;
                $nestedData['revisor_consejo'] = $certificado->revisorConsejo->user->name ?? null;
                $nestedData['numero_revision_consejo'] = $certificado->revisorConsejo->numero_revision ?? null;
                $nestedData['decision_consejo'] = $certificado->revisorConsejo->decision ?? null;
                $nestedData['respuestas_consejo'] = $certificado->revisorConsejo->respuestas ?? null;
                ///dias vigencia
                $fechaActual = Carbon::now()->startOfDay(); //Asegúrate de trabajar solo con fechas, sin horas
                $fechaVigencia = Carbon::parse($certificado->fecha_vigencia)->startOfDay();
                    if ($fechaActual->isSameDay($fechaVigencia)) {
                        $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este certificado</span>";
                    } else {
                        $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);
                        if ($diasRestantes > 0) {
                            if ($diasRestantes > 15) {
                                $res = "<span class='badge bg-success'>$diasRestantes días de vigencia.</span>";
                            } else {
                                $res = "<span class='badge bg-warning'>$diasRestantes días de vigencia.</span>";
                            }
                            $nestedData['diasRestantes'] = $res;
                        } else {
                            $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Vencido hace " . abs($diasRestantes) . " días.</span>";
                        }
                    }
                ///solicitud y acta
                $nestedData['id_solicitud'] = $certificado->dictamen->inspeccione->solicitud->id_solicitud ?? 'No encontrado';
                $urls = $certificado->dictamen?->inspeccione?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
                $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';
                //Certificado Firmado
                switch ($certificado?->dictamen?->tipo_dictamen) {// Determinar el tipo de dictamen
                    case 1:
                        $id_documento = 127; // Productor
                        break;
                    case 2:
                        $id_documento = 128; // Envasador
                        break;
                    case 3:
                        $id_documento = 129; // Comercializador
                        break;
                    default:
                        $id_documento = null;
                }
                $documentacion = Documentacion_url::where('id_relacion', $certificado?->dictamen?->id_instalacion)
                    ->where('id_documento', $id_documento)->where('id_doc', $certificado->id_certificado) ->first();
                $nestedData['pdf_firmado'] = $documentacion?->url
                    ? asset("files/{$numero_cliente}/certificados_instalaciones/{$documentacion->url}") : null;


                $data[] = $nestedData;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
}



    ///FUNCION REGISTRAR
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            //'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);

        //Busca el dictamen y carga la relacion con modelo dictamen->solicitud
        $dictamen = Dictamen_instalaciones::find($validatedData['id_dictamen']);
        $id_instalacion = $dictamen->inspeccione->solicitud->instalaciones->id_instalacion ?? null;
        if (!$id_instalacion) {
            return response()->json(['error' => 'No se encontró la instalacion asociada a la solicitud'], 404);
        }

        //$certificado =
        Certificados::create([
            'id_dictamen' => $validatedData['id_dictamen'],
            'num_certificado' => $validatedData['num_certificado'],
            'fecha_emision' => $validatedData['fecha_emision'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'maestro_mezcalero' => $validatedData['maestro_mezcalero'] ?: null,
            //'num_autorizacion' => $validatedData['num_autorizacion'] ?: null,
            'id_firmante' => $validatedData['id_firmante']
        ]);

        $instalacion = instalaciones::find($id_instalacion);
        $instalacion->folio = $validatedData['num_certificado'];
        $instalacion->fecha_emision = $validatedData['fecha_emision'];
        $instalacion->fecha_vigencia = $validatedData['fecha_vigencia'];
        $instalacion->update();

        /*
        $id_instalacion = $certificado->dictamen->inspeccione->solicitud->id_instalacion;
        $instalaciones = instalaciones::find($id_instalacion);
        $instalaciones->folio = $certificado->num_certificado;
        $instalaciones->fecha_emision = $certificado->fecha_emision;
        $instalaciones->fecha_vigencia = $certificado->fecha_vigencia;
        $instalaciones->save();

            // Obtener información de la empresa
            $numeroCliente = $certificado->dictamen->instalaciones->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            // Manejo de archivos si se suben
                $directory = 'uploads/' . $numeroCliente;
                $path = storage_path('app/public/' . $directory);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                    $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);

                    $filename = $nombreDocumento .  '.pdf' ;
                    $filePath = storage_path('app/public/' . $directory . '/' . $filename);
                    if($certificado->dictamen->tipo_dictamen==1){
                    $id_documento =127;
                    $this->pdf_certificado_productor($certificado->id_certificado,true,$filePath);
                    }
                    if($certificado->dictamen->tipo_dictamen==2){
                    $id_documento =128;
                    $this->pdf_certificado_envasador($certificado->id_certificado,true,$filePath);
                    }
                    if($certificado->dictamen->tipo_dictamen==3){
                    $id_documento =128;
                    $this->pdf_certificado_comercializador($certificado->id_certificado,true,$filePath);
                    }

                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion =  $certificado->dictamen->id_instalacion;
                    $documentacion_url->id_documento = $id_documento ?? null;
                    $documentacion_url->nombre_documento = $nombreDocumento;
                    $documentacion_url->url = $filename;
                    $documentacion_url->id_empresa =  $certificado->dictamen->instalaciones->id_empresa;
                    $documentacion_url->save();

        */
        return response()->json(['message' => 'Registrado correctamente.']);
    }



    ///FUNCION ELIMINAR
    public function destroy($id_certificado)
    {
        try {
            $certificado = Certificados::findOrFail($id_certificado);
            // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
            Revisor::where('id_certificado', $id_certificado)->delete();
            // Luego, eliminar el certificado
            $certificado->delete();

            return response()->json(['message' => 'Eliminado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al eliminar.'], 500);
        }
    }



    ///FUNCION PARA OBTENER LOS REGISTROS
    public function edit($id)
    {
        try {
            $certificado = Certificados::find($id);

            if ($certificado) {
                //return response()->json($certificado);
                return response()->json([
                    'id_certificado' => $certificado->id_certificado,
                    'id_dictamen' => $certificado->id_dictamen,
                    'tipo_dictamen' => $certificado->dictamen->tipo_dictamen ?? null,
                    'num_certificado' => $certificado->num_certificado,
                    'fecha_emision' => $certificado->fecha_emision,
                    'fecha_vigencia' => $certificado->fecha_vigencia,
                    'id_firmante' => $certificado->id_firmante,
                    'maestro_mezcalero' => $certificado->maestro_mezcalero,
                    //'num_autorizacion' => $certificado->num_autorizacion,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al obtener', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al obtener los datos.'], 500);
        }
    }

    ///FUNCION ACTUALIZAR
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'nullable|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            //'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);

        try {
            $certificado = Certificados::findOrFail($id);

        //Busca el dictamen y carga la relacion con modelo dictamen->solicitud
        $dictamen = Dictamen_instalaciones::find($validated['id_dictamen']);
        $id_instalacion = $dictamen->inspeccione->solicitud->instalaciones->id_instalacion ?? null;
        if (!$id_instalacion) {
            return response()->json(['error' => 'No se encontró la instalacion asociada a la solicitud'], 404);
        }

            /*
            // Obtener información de la empresa
            $numeroCliente = $certificado->dictamen->instalaciones->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                    return !empty($numero);
                });

            $directory = 'uploads/' . $numeroCliente;
                $path = storage_path('app/public/' . $directory);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

            $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);
            $certificado_actual = Documentacion_url::where('nombre_documento', $nombreDocumento)->first();
            // dd($certificado_actual);

            if ($certificado_actual) {
                // Elimina el archivo físico si existe

                if (Storage::exists('public/' . $directory . '/' . $certificado_actual->url)) {
                    Storage::delete('public/' . $directory . '/' . $certificado_actual->url);
                }

                // Elimina el registro de la base de datos
                $certificado_actual->delete();
            }
            */

            $certificado->id_dictamen = $validated['id_dictamen'];
            $certificado->num_certificado = $validated['num_certificado'];
            $certificado->fecha_emision = $validated['fecha_emision'];
            $certificado->fecha_vigencia = $validated['fecha_vigencia'];
            $certificado->maestro_mezcalero = $validated['maestro_mezcalero'] ?: null;
            //$certificado->num_autorizacion = $validated['num_autorizacion'] ?: null;
            $certificado->id_firmante = $validated['id_firmante'];
            $certificado->save();


            $instalacion = instalaciones::find($id_instalacion);
            $instalacion->folio = $validated['num_certificado'];
            $instalacion->fecha_emision = $validated['fecha_emision'];
            $instalacion->fecha_vigencia = $validated['fecha_vigencia'];
            $instalacion->update();


            /*
            $id_instalacion = $certificado->dictamen->id_instalacion;
            $instalaciones = instalaciones::find($id_instalacion);
            $instalaciones->folio = $certificado->num_certificado;
            $instalaciones->fecha_emision = $certificado->fecha_emision;
            $instalaciones->fecha_vigencia = $certificado->fecha_vigencia;
            $instalaciones->save();


                $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);
                $filename = $nombreDocumento.'.pdf' ;
                $filePath = storage_path('app/public/' . $directory . '/' . $filename);
                if($certificado->dictamen->tipo_dictamen==1){
                $id_documento =127;
                $this->pdf_certificado_productor($certificado->id_certificado,true,$filePath);
                }
                if($certificado->dictamen->tipo_dictamen==2){
                $id_documento =128;
                $this->pdf_certificado_envasador($certificado->id_certificado,true,$filePath);
                }
                if($certificado->dictamen->tipo_dictamen==3){
                $id_documento =128;
                $this->pdf_certificado_comercializador($certificado->id_certificado,true,$filePath);
                }


                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion =  $certificado->dictamen->id_instalacion;
                $documentacion_url->id_documento = $id_documento ?? null;
                $documentacion_url->nombre_documento = $nombreDocumento;
                $documentacion_url->url = $filename;
                $documentacion_url->id_empresa =  $certificado->dictamen->instalaciones->id_empresa;
                $documentacion_url->save();
            */

            return response()->json(['message' => 'Actualizado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al actualizar', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al actualizar.'], 500);
        }
    }



    ///FUNCION REEXPEDIR
    public function reexpedir(Request $request)
    {
        try {
            $request->validate([
                'accion_reexpedir' => 'required|in:1,2',
                'observaciones' => 'nullable|string',
            ]);

            if ($request->accion_reexpedir == '2') {
                $request->validate([
                    'id_certificado' => 'required|exists:certificados,id_certificado',
                    'id_dictamen' => 'required|integer',
                    'num_certificado' => 'required|string|max:25',
                    'fecha_emision' => 'required|date',
                    'fecha_vigencia' => 'required|date',
                    'maestro_mezcalero' => 'nullable|string|max:60',
                    //'num_autorizacion' => 'nullable|integer',
                    'id_firmante' => 'required|integer',
                ]);
            }

            $reexpedir = Certificados::findOrFail($request->id_certificado);

            if ($request->accion_reexpedir == '1') {
                $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones; //Actualiza solo 'observaciones'
                $reexpedir->observaciones = json_encode($observacionesActuales);
                $reexpedir->save();

                return response()->json(['message' => 'Cancelado correctamente.']);
            } else if ($request->accion_reexpedir == '2') {
                $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
                $reexpedir->observaciones = json_encode($observacionesActuales);
                $reexpedir->save();

                // Crear un nuevo registro de reexpedición
                $new = new Certificados();
                $new->id_dictamen = $request->id_dictamen;
                $new->num_certificado = $request->num_certificado;
                $new->fecha_emision = $request->fecha_emision;
                $new->fecha_vigencia = $request->fecha_vigencia;
                $new->id_firmante = $request->id_firmante;
                $new->estatus = 2;
                $new->observaciones = json_encode(['id_sustituye' => $request->id_certificado]);
                $new->maestro_mezcalero = $request->maestro_mezcalero ?: null;
                //$new->num_autorizacion = $request->num_autorizacion ?: null;
                $new->save();

                return response()->json(['message' => 'Registrado correctamente.']);
            }

            return response()->json(['message' => 'Procesado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al reexpedir', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al procesar.'], 500);
        }
    }



    // Funcion LLenar Select
    public function obtenerRevisores(Request $request)
    {
        $tipo = $request->get('tipo');
        $revisores = User::where('tipo', $tipo)->get(['id', 'name']);

        return response()->json($revisores);
    }

    ///FUNCION AGREGAR REVISOR
    public function storeRevisor(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tipoRevisor' => 'required|string|in:1,2',
                'nombreRevisor' => 'required|integer|exists:users,id',
                'numeroRevision' => 'required|string|max:50',
                'esCorreccion' => 'nullable|in:si,no',
                'observaciones' => 'nullable|string|max:255',
                'id_certificado' => 'required|integer|exists:certificados,id_certificado',
            ]);

            $user = User::find($validatedData['nombreRevisor']);
            if (!$user) {
                return response()->json(['message' => 'El revisor no existe.'], 404);
            }

            $certificado = Certificados::find($validatedData['id_certificado']);
            if (!$certificado) {
                return response()->json(['message' => 'El certificado no existe.'], 404);
            }

            $revisor = Revisor::where('id_certificado', $validatedData['id_certificado'])
                ->where('tipo_certificado', 1)
                ->where('tipo_revision', $validatedData['tipoRevisor']) // buscar según tipo de revisión
                ->first();


            $message = ''; // Inicializar el mensaje

            if ($revisor) {
                if ($revisor->id_revisor == $validatedData['nombreRevisor']) {
                    $message = 'Revisor reasignado.';
                } else {
                    $revisor->id_revisor = $validatedData['nombreRevisor'];
                    $message = 'Revisor asignado exitosamente.';
                }
            } else {
                $revisor = new Revisor();
                $revisor->id_certificado = $validatedData['id_certificado'];
                $revisor->tipo_certificado = 1;
                $revisor->tipo_revision = $validatedData['tipoRevisor'];
                $revisor->id_revisor = $validatedData['nombreRevisor'];
                $message = 'Revisor asignado exitosamente.';
            }

            // Guardar los datos del revisor
            $revisor->tipo_certificado = 1;
            $revisor->decision = 'Pendiente';
            $revisor->numero_revision = $validatedData['numeroRevision'];
            $revisor->es_correccion = $validatedData['esCorreccion'] ?? 'no';
            $revisor->observaciones = $validatedData['observaciones'] ?? '';
            $revisor->save();


            $empresa = $certificado->dictamen->inspeccione->solicitud->empresa;
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            if ($request->hasFile('url')) {
            if ($revisor->id_revision) {
                // Buscar el registro existente


                    // Si no existe, crea una nueva instancia
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $revisor->id_revision;
                    $documentacion_url->id_documento = $request->id_documento;
                    $documentacion_url->id_empresa = $empresa->id_empresa;


                // Procesar el nuevo archivo
                $file = $request->file('url');
                $nombreLimpio = str_replace('/', '-', $request->nombre_documento);
                $filename = $nombreLimpio . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('revisiones/', $filename, 'public');

                // Actualizar los datos del registro
                $documentacion_url->nombre_documento = $nombreLimpio;
                $documentacion_url->url = $filename;
                $documentacion_url->save();

            }
        }

            if($validatedData['tipoRevisor']==1){
                $url_clic = '/add_revision/' . $revisor->id_revision;
            }else{
                 $url_clic = '/add_revision_consejo/' . $revisor->id_revision;
            }

            // Preparar datos para el correo
            $data1 = [
                'asunto' => 'Revisión de certificado ' . $certificado->num_certificado,
                'title' => 'Revisión de certificado',
                'message' => 'Se te ha asignado el certificado ' . $certificado->num_certificado,
                'url' => $url_clic,
                'nombreRevisor' => $user->name,
                'emailRevisor' => $user->email,
                'num_certificado' => $certificado->num_certificado,
                'fecha_emision' => Helpers::formatearFecha($certificado->fecha_emision),
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'razon_social' => $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar',
                'numero_cliente' => $numeroCliente ?? 'Sin asignar',
                'tipo_certificado' => 'Certificado de instalaciones',
                'observaciones' => $revisor->observaciones,
            ];

            // Notificación Local
            $users = User::whereIn('id', [$validatedData['nombreRevisor']])->get();
            foreach ($users as $notifiedUser) {
                $notifiedUser->notify(new GeneralNotification($data1));
            }

            // Correo a Revisores
            try {
                info('Enviando correo a: ' . $user->email);

                if (empty($user->email)) {
                    return response()->json(['message' => 'El correo del revisor no está disponible.'], 404);
                }

                Mail::to($user->email)->send(new CorreoCertificado($data1));
                info('Correo enviado a: ' . $user->email);
            } catch (\Exception $e) {
                Log::error('Error al enviar el correo: ' . $e->getMessage());
                return response()->json(['message' => 'Error al enviar el correo: ' . $e->getMessage()], 500);
            }

            return response()->json([
                'message' => $message ?? 'Revisor del OC asignado exitosamente',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al asignar el revisor: ' . $e->getMessage()], 500);
        }
    }



    ///PDF CERTIFICADOS
    public function pdf_certificado_productor($id_certificado, $conMarca = true, $rutaGuardado = null)
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ])->findOrFail($id_certificado);

        $empresa = $datos->dictamen->instalaciones->empresa ?? null;
        $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
            ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
        $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null; //obtiene el valor del JSON/sino existe es null
        $nombre_id_sustituye = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

        $watermarkText = $datos->estatus == 1;



        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado ?? 'No encontrado',
            'num_dictamen' => $datos->dictamen->num_dictamen ?? 'No encontrado',
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'domicilio_fiscal' => $empresa->domicilio_fiscal ?? 'No encontrado',
            'rfc' => $empresa->rfc ?? 'No encontrado',
            'telefono' => $empresa->telefono ?? 'No encontrado',
            'correo' => $empresa->correo ?? 'No encontrado',
            'watermarkText' => $watermarkText,
            'id_sustituye' => $nombre_id_sustituye,
            ///
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa ?? 'No encontrado',
            'razon_social' => $empresa->razon_social ?? 'No encontrado',
            'maestro_mezcalero' => is_null($datos->maestro_mezcalero)
                ? '---------------------------------------------------------------------------------------------------------------------'
                : (trim($datos->maestro_mezcalero) === ''
                ? '---------------------------------------------------------------------------------------------------------------------'
                : $datos->maestro_mezcalero),
            'num_autorizacion' => $empresa->registro_productor ?? 'No encontrado',
            'numero_cliente' => $numero_cliente,
            'representante_legal' => $empresa->representante ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name ?? 'No encontrado',
            'puesto_firmante' => $datos->firmante->puesto ?? 'No encontrado',
            'firma_firmante' => $datos->firmante->firma ?? 'No encontrado',
            'categorias' => $datos->dictamen?->inspeccione?->solicitud?->categorias_mezcal()?->pluck('categoria')->implode(', ') ?? 'No encontrado',
            'clases' => $datos->dictamen?->inspeccione?->solicitud?->clases_agave()?->pluck('clase')->implode(', ') ?? 'No encontrado',
        ];

        /*if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.certificado_productor_mezcal', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }*/

      $edicion = '';

      if ($datos->fecha_emision >= '2025-04-01') {
          $edicion = $conMarca ? 'pdfs.certificado_productor_ed6' : 'pdfs.certificado_productor_ed6_sin_marca';
      } else {
          $edicion = $conMarca ? 'pdfs.certificado_productor_ed5' : 'pdfs.certificado_productor_ed5_sin_marca';
      }

      return Pdf::loadView($edicion, $pdfData)
          ->stream('Certificado como Productor de Mezcal NOM-070-SCFI-2016 F7.1-01-35.pdf');


    }


    public function pdf_certificado_envasador($id_certificado, $conMarca = true, $rutaGuardado = null)
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.instalaciones.empresa',
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ])->findOrFail($id_certificado);


        $empresa = $datos->dictamen->instalaciones->empresa ?? null;
        $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
            ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
        $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null; //obtiene el valor del JSON/sino existe es null
        $nombre_id_sustituye = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

        $watermarkText = $datos->estatus == 1;

        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado ?? 'No encontrado',
            'num_autorizacion' => $datos->num_autorizacion ?? 'No encontrado',
            'num_dictamen' => $datos->dictamen->num_dictamen ?? 'No encontrado',
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'domicilio_fiscal' => $empresa->domicilio_fiscal ?? 'No encontrado',
            'rfc' => $empresa->rfc ?? 'No encontrado',
            'telefono' => $empresa->telefono ?? 'No encontrado',
            'correo' => $empresa->correo ?? 'No encontrado',
            'watermarkText' => $watermarkText,
            'id_sustituye' => $nombre_id_sustituye,
            //
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa ?? 'No encontrado',
            'razon_social' => $empresa->razon_social ?? 'No encontrado',
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,
            'representante_legal' => $empresa->representante ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name ?? 'No encontrado',
            'puesto_firmante' => $datos->firmante->puesto ?? 'No encontrado',
            'firma_firmante' => $datos->firmante->firma ?? 'No encontrado',
            'categorias' => $datos->dictamen?->inspeccione?->solicitud?->categorias_mezcal()?->pluck('categoria')->implode(', ') ?? 'No encontrado',
            'clases' => $datos->dictamen?->inspeccione?->solicitud?->clases_agave()?->pluck('clase')->implode(', ') ?? 'No encontrado',
        ];


        /*if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.certificado_envasador', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }*/
         if ($datos->fecha_emision >= "2025-04-01") {
              $edicion = $conMarca ? 'pdfs.certificado_envasador_ed5' : 'pdfs.certificado_envasador_ed5_sin_marca';
        } else {
              $edicion = $conMarca ? 'pdfs.certificado_envasador_ed4' : 'pdfs.certificado_envasador_ed4_sin_marca';
        }
        return Pdf::loadView($edicion, $pdfData)
            ->stream('Certificado como Envasador de Mezcal NOM-070-SCFI-2016 F7.1-01-36.pdf');
}


    public function pdf_certificado_comercializador($id_certificado, $conMarca = true, $rutaGuardado = null)
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ])->findOrFail($id_certificado);

        $empresa = $datos->dictamen->instalaciones->empresa ?? null;
        $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
            ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
        $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null; //obtiene el valor del JSON/sino existe es null
        $nombre_id_sustituye = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

        $watermarkText = $datos->estatus == 1;

        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado ?? 'No encontrado',
            'num_autorizacion' => $datos->num_autorizacion ?? 'No encontrado',
            'num_dictamen' => $datos->dictamen->num_dictamen ?? 'No encontrado',
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'domicilio_fiscal' => $empresa->domicilio_fiscal ?? 'No encontrado',
            'rfc' => $empresa->rfc ?? 'No encontrado',
            'telefono' => $empresa->telefono ?? 'No encontrado',
            'correo' => $empresa->correo ?? 'No encontrado',
            'watermarkText' => $watermarkText,
            'id_sustituye' => $nombre_id_sustituye,
            //
            'razon_social' => $empresa->razon_social ?? 'No encontrado',
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,
            'representante_legal' => $empresa->representante ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name ?? 'No encontrado',
            'puesto_firmante' => $datos->firmante->puesto ?? 'No encontrado',
            'firma_firmante' => $datos->firmante->firma ?? 'No encontrado',
            'categorias' => $datos->dictamen?->inspeccione?->solicitud?->categorias_mezcal()?->pluck('categoria')->implode(', ') ?? 'No encontrado',
            'clases' => $datos->dictamen?->inspeccione?->solicitud?->clases_agave()?->pluck('clase')->implode(', ') ?? 'No encontrado',
            // Nuevos campos
            'marcas' => $datos->dictamen?->inspeccione?->solicitud?->marcas()?->pluck('marca')->implode(', ') ?? 'No encontrado',
            'domicilio_unidad' => $datos->dictamen->instalaciones->direccion_completa ?? 'No encontrado',
            'convenio_corresponsabilidad' => $empresa->convenio_corresp ?? 'No encontrado',
        ];

        /*if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.certificado_comercializador', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }*/

    if ($datos->fecha_emision >= "2025-04-01") {
        $edicion = $conMarca ? 'pdfs.certificado_comercializador_ed6' : 'pdfs.certificado_comercializador_ed6_sin_marca';
    } else {
        $edicion = $conMarca ? 'pdfs.certificado_comercializador_ed5' : 'pdfs.certificado_comercializador_ed5_sin_marca';
    }

    return Pdf::loadView($edicion, $pdfData)
        ->stream('Certificado como Comercializador de Mezcal NOM-070-SCFI-2016 F7.1-01-37.pdf');
    }





    ///SUBIR CERTIFICADO FIRMADO
    public function subirCertificado(Request $request)
    {
        $request->validate([
            'id_certificado' => 'required|exists:certificados,id_certificado',
            'documento' => 'required|mimes:pdf|max:3072',
        ]);

        $certificado = Certificados::findOrFail($request->id_certificado);

        // Limpiar num_certificado para evitar crear carpetas por error
        $nombreCertificado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificado->num_certificado ?? 'No encontrado');
        // Generar nombre de archivo con num_certificado + cadena aleatoria
        $nombreArchivo = $nombreCertificado.'_'. uniqid() .'.pdf'; //uniqid() para asegurar nombre único


        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->instalaciones->empresa->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });
        // Ruta de carpeta física donde se guardará
        $rutaCarpeta = "public/uploads/{$numeroCliente}/certificados_instalaciones";

        // Guardar nuevo archivo
        $upload = Storage::putFileAs($rutaCarpeta, $request->file('documento'), $nombreArchivo);
        if (!$upload) {
            return response()->json(['message' => 'Error al subir el archivo.'], 500);
        }

        // Eliminar archivo y registro anterior si existe
        $id_instalacion = $certificado->dictamen?->id_instalacion;
        // Validar que el id_instalacion exista
        if (is_null($id_instalacion)) {
            return response()->json([
                'message' => 'No se encontró el ID de instalacion relacionado. No se puede continuar.'
            ], 422);
        }

        // Determinar id_documento y nombre_documento según tipo_dictamen
        $tipoDictamen = $certificado->dictamen->tipo_dictamen;
        switch ($tipoDictamen) {
            case 1:
                $id_documento = 127;
                $nombre_documento = "Certificado como productor";
                break;
            case 2:
                $id_documento = 128;
                $nombre_documento = "Certificado como envasador";
                break;
            case 3:
                $id_documento = 129;
                $nombre_documento = "Certificado como comercializador";
                break;
            default:
                return response()->json(['message' => 'Tipo de instalacion desconocido.'], 422);
        }

        // Buscar si ya existe un registro para esa isntalacion y tipo de documento
        $documentacion = Documentacion_url::where('id_relacion', $id_instalacion)
            ->where('id_documento', $id_documento)
            ->where('id_doc', $certificado->id_certificado)//id del certificado
            ->first();

        if ($documentacion) {
            $ArchivoAnterior = "public/uploads/{$numeroCliente}/certificados_instalaciones/{$documentacion->url}";
            if (Storage::exists($ArchivoAnterior)) {
                Storage::delete($ArchivoAnterior);
            }
        }

        // Crear o actualizar registro
        Documentacion_url::updateOrCreate(
            [
                'id_relacion' => $id_instalacion,
                'id_documento' => $id_documento,
                'id_doc' => $certificado->id_certificado,//id del certificado
            ],
            [
                'nombre_documento' => $nombre_documento,
                'url' => "{$nombreArchivo}",
                'id_empresa' => $certificado->dictamen->instalaciones->empresa->id_empresa,
            ]
        );

        return response()->json(['message' => 'Documento actualizado correctamente.']);
    }


    ///OBTENER CERTIFICADO FIRMADO
    public function CertificadoFirmado($id)
    {
        $certificado = Certificados::findOrFail($id);

        // Obtener la instalacion
        $id_instalacion = $certificado->dictamen?->id_instalacion;

        if (is_null($id_instalacion)) {
            return response()->json([
                'documento_url' => null,
                'nombre_archivo' => null,
                'message' => 'No se encontró el ID de instalacion relacionado.',
            ], 404);
        }

        // Determinar tipo_dictamen y su correspondiente id_documento
        $tipoDictamen = $certificado->dictamen->tipo_dictamen;
        switch ($tipoDictamen) {
            case 1:
                $id_documento = 127; // Productor
                break;
            case 2:
                $id_documento = 128; // Envasador
                break;
            case 3:
                $id_documento = 129; // Comercializador
                break;
            default:
                return response()->json([
                    'documento_url' => null,
                    'nombre_archivo' => null,
                    'message' => 'Tipo de instalacion desconocido.',
                ], 422);
        }

        // Buscar documento asociado a instalacion
        $documentacion = Documentacion_url::where('id_relacion', $id_instalacion)
            ->where('id_documento', $id_documento)
            ->where('id_doc', $certificado->id_certificado)
            ->first();

        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->instalaciones->empresa->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        if ($documentacion) {
            $rutaArchivo = "{$numeroCliente}/certificados_instalaciones/{$documentacion->url}";

            if (Storage::exists("public/uploads/{$rutaArchivo}")) {
                return response()->json([
                    'documento_url' => Storage::url($rutaArchivo), // genera URL pública
                    'nombre_archivo' => basename($documentacion->url),
                ]);
            }else {
                return response()->json([
                    'documento_url' => null,
                    'nombre_archivo' => null,
                    'message' => 'Archivo físico no encontrado.',
                ], 404);
            }
        }

        return response()->json([
            'documento_url' => null,
            'nombre_archivo' => null,
            'message' => 'Ningun registro en la BD.',
        ]);
    }






}//end-classController
