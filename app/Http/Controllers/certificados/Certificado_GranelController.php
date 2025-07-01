<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Granel;
use App\Models\User;
use App\Models\tipos;
use App\Models\Revisor;
use App\Models\LotesGranel;
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use App\Models\Documentacion_url;
use App\Models\empresa;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Certificado_GranelController extends Controller
{
    public function UserManagement()
    {
        $certificados = CertificadosGranel::all();
        $dictamenes = Dictamen_Granel::with('inspeccione.solicitud')
            ->whereHas('inspeccione.solicitud', function ($query) {
            $query->where('id_tipo', '!=', 2);
            })
            ->where('estatus','!=',1)
            ->orderBy('id_dictamen', 'desc')
            ->get();
        $users = User::where('tipo',1)->get();
        $revisores = Revisor::all();
        return view('certificados.find_certificados_granel', compact('certificados' , 'dictamenes' , 'users', 'revisores'));
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


    $query = CertificadosGranel::query()
        ->leftJoin('dictamenes_granel', 'dictamenes_granel.id_dictamen', '=', 'certificados_granel.id_dictamen')
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_granel.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->leftJoin('lotes_granel', 'lotes_granel.id_lote_granel', '=', 'certificados_granel.id_lote_granel')
        ->select('certificados_granel.*', 'empresa.razon_social');

        
    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;
    // totalData (sin búsqueda)
    $totalData = $baseQuery->count();

    
    // Búsqueda Global
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('certificados_granel.num_certificado', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_granel.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(certificados_granel.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"])
            ->orWhere('lotes_granel.nombre_lote', 'LIKE', "%{$search}%")
            ->orWhere('lotes_granel.folio_fq', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    // Ordenamiento especial para num_certificado con formato 'CIDAM C-GRA25-###'
    if ($orderColumn === 'num_certificado') {
        $query->orderByRaw("
            CASE
                WHEN num_certificado LIKE 'CIDAM C-GRA25-%' THEN 0
                ELSE 1
            END ASC,
            CAST(
                SUBSTRING_INDEX(
                    SUBSTRING(num_certificado, LOCATE('CIDAM C-GRA25-', num_certificado) + 14),
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


        
    $data = [];
    if (!empty($certificados)) {
        foreach ($certificados as $certificado) {
            $nestedData['id_certificado'] = $certificado->id_certificado ?? 'No encontrado';
            $nestedData['num_certificado'] = $certificado->num_certificado ?? 'No encontrado';
            $nestedData['id_dictamen'] = $certificado->dictamen->id_dictamen ?? 'No encontrado';
            $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'No encontrado';
            $nestedData['estatus'] = $certificado->estatus ?? 'No encontrado';
            $id_sustituye = json_decode($certificado->observaciones, true) ['id_sustituye'] ?? null;
            $nestedData['sustituye'] = $id_sustituye ? CertificadosGranel::find($id_sustituye)->num_certificado ?? 'No encontrado' : null;
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
            //Lote granel
            $caracteristicas = json_decode($certificado->dictamen?->inspeccione?->solicitud?->caracteristicas, true);
                $idLote = $caracteristicas['id_lote_granel'] ?? null;
            $loteGranel = LotesGranel::find($idLote);
            $nestedData['nombre_lote'] = $loteGranel?->nombre_lote ?? 'No encontrado';
            $nestedData['n_analisis'] = $loteGranel?->folio_fq ?? 'No encontrado';
            //Certificado Firmado
            $documentacion = Documentacion_url::where('id_relacion', $idLote)
                ->where('id_documento', 59)->where('id_doc', $certificado->id_certificado) ->first();
            $nestedData['pdf_firmado'] = $documentacion?->url
                ? asset("files/{$numero_cliente}/certificados_granel/{$documentacion->url}") : null;
            
        
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
    try {
    $validated = $request->validate([
        'id_dictamen' => 'required|integer',
        'num_certificado' => 'required|string',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|integer',
    ]);

    $dictamen = Dictamen_Granel::with('inspeccione.solicitud')->find($validated['id_dictamen']);
    $idLoteGranel = $dictamen->inspeccione->solicitud->id_lote_granel ?? null;


    $new = CertificadosGranel::create([
        'id_dictamen' => $validated['id_dictamen'],
        'num_certificado' => $validated['num_certificado'],
        'fecha_emision' => $validated['fecha_emision'],
        'fecha_vigencia' => $validated['fecha_vigencia'],
        'id_firmante' => $validated['id_firmante'],
        'id_lote_granel' => $idLoteGranel
    ]);

        $lote = LotesGranel::find($idLoteGranel);
        $lote->folio_certificado = $validated['num_certificado'];
        $lote->fecha_emision = $validated['fecha_emision'];
        $lote->fecha_vigencia = $validated['fecha_vigencia'];
        $lote->update();

        return response()->json(['message' => 'Registrado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al registrar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al registrar.'], 500);
    }
}



///FUNCION ELIMINAR
public function destroy($id_certificado)
{
    try {
        // Buscar el certificado
        $eliminar = CertificadosGranel::findOrFail($id_certificado);

        // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
        Revisor::where('id_certificado', $id_certificado)->delete();

        // Luego, eliminar el certificado
        $eliminar->delete();

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
    $certificado = CertificadosGranel::find($id);

    if ($certificado) {
        return response()->json($certificado);
    }

    return response()->json(['error' => 'Error al obtener los datos.'], 500);
}

///FUNCION ACTUALIZAR
public function update(Request $request, $id_certificado)
{
    $validated = $request->validate([
        'id_firmante' => 'required|integer',
        'id_dictamen' => 'required|integer',
        'num_certificado' => 'required|string',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
    ]);

    try {
        $actualizar = CertificadosGranel::findOrFail($id_certificado);

        $dictamen = Dictamen_Granel::with('inspeccione.solicitud')->find($validated['id_dictamen']);
        $idLoteGranel = $dictamen->inspeccione->solicitud->id_lote_granel ?? null;


        $actualizar->update([
            'id_firmante' => $validated['id_firmante'],
            'id_dictamen' => $validated['id_dictamen'],
            'num_certificado' => $validated['num_certificado'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_lote_granel' => $idLoteGranel
        ]);

        $lote = LotesGranel::find($idLoteGranel);
        $lote->folio_certificado = $validated['num_certificado'];
        $lote->update();

        return response()->json(['message' => 'Actualizado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al actualizar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al actualizar.'], 500);
    }
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
            'id_certificado' => 'required|integer|exists:certificados_granel,id_certificado',
        ]);

        $user = User::find($validatedData['nombreRevisor']);
        if (!$user) {
            return response()->json(['message' => 'El revisor no existe.'], 404);
        }

        $certificado = CertificadosGranel::find($validatedData['id_certificado']);
        if (!$certificado) {
            return response()->json(['message' => 'El certificado no existe.'], 404);
        }

         $revisor = Revisor::where('id_certificado', $validatedData['id_certificado'])
                ->where('tipo_certificado', 2)
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
               
                $revisor->tipo_revision = $validatedData['tipoRevisor'];
                $revisor->id_revisor = $validatedData['nombreRevisor'];
                $message = 'Revisor asignado exitosamente.';
            }
        // Guardar los datos del revisor
         $revisor->tipo_certificado = 2; //El 2 corresponde al certificado de granel
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
            'id_firmante' => 'required|integer',
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'observaciones' => 'nullable|string',
            ]);
        }

        $reexpedir = CertificadosGranel::findOrFail($request->id_certificado);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1;
            $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save();
            return response()->json(['message' => 'Cancelado correctamente.']);

        } elseif ($request->accion_reexpedir == '2') {
            $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save();

            // Crear un nuevo registro de certificado (reexpedición)
            $new = new CertificadosGranel();
            $new->id_dictamen = $request->id_dictamen;
            $new->num_certificado = $request->num_certificado;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_certificado]);
            // Guarda el nuevo certificado
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



///PDF CERTIFICADO
public function CertificadoGranel($id_certificado, $conMarca = true)
{
    $certificado = CertificadosGranel::find($id_certificado);

    if (!$certificado) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    setlocale(LC_TIME, 'es_ES.UTF-8'); // Asegúrate de tener el locale en español
    $fecha = Carbon::parse($certificado->fecha_emision);
    $fecha_emision = $fecha->format('d') . '/' . ucfirst($fecha->translatedFormat('F')) . '/' . $fecha->format('Y');
    $fecha2 = Carbon::parse($certificado->fecha_vigencia);
    $fecha_vigencia = $fecha2->format('d') . '/' . ucfirst($fecha2->translatedFormat('F')) . '/' . $fecha2->format('Y');
    
    $watermarkText = $certificado->estatus === 1;
    $id_sustituye = json_decode($certificado->observaciones, true)['id_sustituye'] ?? null; //obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ? CertificadosGranel::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';
    //origen
    if ( empty($certificado->dictamen->inspeccione->solicitud->lote_granel->lote_original_id) ){
        $estado = $certificado->dictamen->inspeccione->solicitud->instalacion->estados->nombre ?? 'No encontrado';
    }else{
        //$estado = $certificado->dictamen->inspeccione->solicitud->lote_granel->lote_original_id->lotes;
        $id_lote = json_decode($certificado->dictamen->inspeccione->solicitud->lote_granel->lote_original_id, true);
        // Paso 2: Obtener el primer ID del array 'lotes'
        $ultimoId = end($id_lote['lotes']) ?? null;

        $certificadoGranel = CertificadosGranel::where('id_lote_granel', $ultimoId)->first();

            if ($certificadoGranel) {
                $estado = $certificadoGranel->dictamen->inspeccione->solicitud->instalacion->estados->nombre ?? 'No encontrado';
            } else {
                $estado = "OAXACA";
                //return response()->json([ 'message' => 'No se encontró Certificado Granel con ese lote granel.' ]);
            }
    }

    
    // Datos para el PDF
    $pdfData = [
        'data' => $certificado,
        'num_certificado' => $certificado->num_certificado ?? 'No encontrado',
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'razon_social' => $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'representante' => $certificado->dictamen->inspeccione->solicitud->empresa->representante ?? 'No encontrado',
        'domicilio_fiscal' => $certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'No encontrado',
        'rfc' => $certificado->dictamen->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'direccion_completa' => $certificado->dictamen->inspeccione->solicitud->instalaciones->direccion_completa ?? 'No encontrado',
        'nombre_firmante' => $certificado->user->name ?? 'No encontrado',
        'puesto_firmante' => $certificado->user->puesto ?? 'No encontrado',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        //lote
        //'estado' => $certificado->dictamen->inspeccione->solicitud->instalacion->estados->nombre ?? 'No encontrado',
        'estado' => $estado,
        'categoria' => $certificado->dictamen->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'No encontrado',
        'clase' => $certificado->dictamen->inspeccione->solicitud->lote_granel->clase->clase ?? 'No encontrado',
        'nombre_lote' => $certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote?? 'No encontrado',
        'n_analisis' => $certificado->dictamen->inspeccione->solicitud->lote_granel->folio_fq ?? 'No encontrado',
        'volumen' => $certificado->dictamen->inspeccione->solicitud->lote_granel->volumen_restante ?? 'No encontrado',
        'cont_alc' => $certificado->dictamen->inspeccione->solicitud->lote_granel->cont_alc?? 'No encontrado',
        'tipo_maguey' => $certificado->dictamen->inspeccione->solicitud->lote_granel ?? 'No encontrado',
        'edad' => $certificado->dictamen->inspeccione->solicitud->lote_granel->edad ?? '-----',
        'ingredientes' => $certificado->dictamen->inspeccione->solicitud->lote_granel->ingredientes ?? '-----',
        'num_dictamen' => $certificado->dictamen->num_dictamen ?? 'No encontrado',
    ];

    // Generar y mostrar el PDF
    //return Pdf::loadView('pdfs.certificado_granel_ed7', $pdfData)->stream("Certificado NOM de Mezcal a Granel NOM-070-SCFI-2016F7.1-01-07.pdf");
    // Seleccionar la vista según si lleva marca o no
    $documento = $conMarca
        ? 'pdfs.certificado_granel_ed7'
        : 'pdfs.certificado_granel_ed7_sin_marca'; // asegúrate de que el archivo se llame así

    return Pdf::loadView($documento, $pdfData)
        ->stream("Certificado NOM de Mezcal a Granel NOM-070-SCFI-2016F7.1-01-07.pdf");
}




///SUBIR CERTIFICADO FIRMADO
public function subirCertificado(Request $request)
{
    $request->validate([
        'id_certificado' => 'required|exists:certificados_granel,id_certificado',
        'documento' => 'required|mimes:pdf|max:3072',
    ]);

    $certificado = CertificadosGranel::findOrFail($request->id_certificado);

    // Limpiar num_certificado para evitar crear carpetas por error
    $nombreCertificado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificado->num_certificado ?? 'No encontrado');
    // Generar nombre de archivo con num_certificado + cadena aleatoria
    $nombreArchivo = $nombreCertificado.'_'. uniqid() .'.pdf'; //uniqid() para asegurar nombre único

    
    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });
    // Ruta de carpeta física donde se guardará
    $rutaCarpeta = "public/uploads/{$numeroCliente}/certificados_granel";
   
    // Guardar nuevo archivo
    $upload = Storage::putFileAs($rutaCarpeta, $request->file('documento'), $nombreArchivo);
    if (!$upload) {
        return response()->json(['message' => 'Error al subir el archivo.'], 500);
    }

     // Eliminar archivo y registro anterior si existe
    $caracteristicas = json_decode($certificado->dictamen?->inspeccione?->solicitud?->caracteristicas, true);
        $idLote = $caracteristicas['id_lote_granel'] ?? null;

    // Validar que el id_lote_granel exista
    if (is_null($idLote)) {
        return response()->json([
            'message' => 'No se encontró el ID de lote relacionado. No se puede continuar.'
        ], 422);
    }

    // Buscar si ya existe un registro para ese lote y tipo de documento
    $documentacion_url = Documentacion_url::where('id_relacion', $idLote)
        ->where('id_documento', 59)
        ->where('id_doc', $certificado->id_certificado)//id del certificado
        ->first();

    if ($documentacion_url) {
        $ArchivoAnterior = "public/uploads/{$numeroCliente}/certificados_granel/{$documentacion_url->url}";
        if (Storage::exists($ArchivoAnterior)) {
            Storage::delete($ArchivoAnterior);
        }
    }

    // Crear o actualizar registro
    Documentacion_url::updateOrCreate(
        [
            'id_relacion' => $idLote,
            'id_documento' => 59,
            'id_doc' => $certificado->id_certificado,//id del certificado
        ],
        [
            'nombre_documento' => "Certificado NOM a granel",
            'url' => "{$nombreArchivo}",
            'id_empresa' => $certificado->dictamen?->inspeccione?->solicitud?->id_empresa,
        ]
    );

    return response()->json(['message' => 'Documento actualizado correctamente.']);
}

///OBTENER CERTIFICADO FIRMADO
public function CertificadoFirmado($id)
{
    $certificado = CertificadosGranel::findOrFail($id);

    // Obtener id_lote_granel desde las características
    $caracteristicas = json_decode($certificado->dictamen?->inspeccione?->solicitud?->caracteristicas, true);
    $idLote = $caracteristicas['id_lote_granel'] ?? null;

    /*if (is_null($idLote)) {
        return response()->json([
            'documento_url' => null,
            'nombre_archivo' => null,
            'message' => 'No se encontró el ID de lote relacionado.',
        ], 404);
    }*/

    // Buscar documento asociado al lote
    $documentacion = Documentacion_url::where('id_relacion', $idLote)
        ->where('id_documento', 59)
        ->where('id_doc', $certificado->id_certificado)
        ->first();

    
    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)->first();
      $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });

    if ($documentacion) {
        $rutaArchivo = "{$numeroCliente}/certificados_granel/{$documentacion->url}";

        if (Storage::exists("public/uploads/{$rutaArchivo}")) {
            return response()->json([
                'documento_url' => Storage::url($rutaArchivo), // genera URL pública
                'nombre_archivo' => basename($documentacion->url),
            ]);
        }else {
            return response()->json([
                'documento_url' => null,
                'nombre_archivo' => null,
            ], 404);
        }
    }

    return response()->json([
        'documento_url' => null,
        'nombre_archivo' => null,
        //'message' => 'Documento no encontrado.',
    ]);
}





}//end-classController
