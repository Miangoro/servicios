<?php

namespace App\Http\Controllers\certificados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\Certificado_Exportacion;
use App\Models\Dictamen_Exportacion;
use App\Models\User;
use App\Models\empresa;
use App\Models\Revisor;
use App\Models\lotes_envasado;
use App\Models\activarHologramasModelo;
use App\Models\Documentacion_url;
use App\Models\Dictamen_Envasado;
//Clase de exportacion
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CertificadosExport;
use App\Mail\CorreoCertificado;
use App\Models\CertificadosGranel;
use App\Notifications\GeneralNotification;
///Extensiones
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;//Permiso empresa
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

class Certificado_ExportacionController extends Controller
{

    public function UserManagement()
    {
        //$certificado = Certificado_Exportacion::all(); // Obtener todos los datos
        // Obtener solo los dictámenes que NO tienen certificado
        $dictamen = Dictamen_Exportacion::with('inspeccione.solicitud')
            ->where('estatus', '!=', 1)
            ->whereDoesntHave('certificado') // Solo los dictámenes sin certificado
            ->orderBy('id_dictamen', 'desc')
            ->get();
 
        $users = User::where('tipo',1)->get(); //Solo Prrsonal OC
        $empresa = empresa::where('tipo', 2)->get();
        $revisores = Revisor::all();
        $hologramas = activarHologramasModelo::all();

        return view('certificados.find_certificados_exportacion', compact('dictamen', 'users', 'empresa', 'revisores', 'hologramas'));
    }
///FUNCION PARA OBTENER N° DE LOTES PARA HOLOGRAMAS
public function contarLotes($id)
{
    $dictamen = Dictamen_Exportacion::with('inspeccione.solicitud')->findOrFail($id);

    $solicitud = $dictamen->inspeccione->solicitud ?? null;
    if (!$solicitud || !$solicitud->caracteristicas) {
        return response()->json(['count' => 0]);
    }

    $caracteristicas = json_decode($solicitud->caracteristicas, true);

    $count = collect($caracteristicas['detalles'] ?? [])->pluck('id_lote_envasado')->filter()->count();

    return response()->json(['count' => $count]);
}




public function index(Request $request)
{
    //Permiso de empresa
    $empresaId = null;
    if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaId = Auth::user()->empresa?->id_empresa;
    }

    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para nombres meses

    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        0 => '',
        1 => 'num_certificado',
        2 => 'dictamenes_exportacion.num_dictamen', //nombre de mi tabla y atributo
        3 => 'razon_social',
        4 => '', //caracteristicas
        5 => 'certificados_exportacion.fecha_emision',
        6 => 'estatus',
        7 => '',// acciones
    ];
      
    /*$totalData = Certificado_Exportacion::count();
    $totalFiltered = $totalData; */
    $limit = $request->input('length');
    $start = $request->input('start');

    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'asc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'num_certificado'; // Por defecto

    $search = $request->input('search.value');//Define la búsqueda global.


    //1)$query = Certificado_Exportacion::query();
    /*2)$query = Certificado_Exportacion::select('certificados_exportacion.*')
    ->leftJoin('dictamenes_exportacion', 'certificados_exportacion.id_dictamen', '=', 'dictamenes_exportacion.id_dictamen');
    */
    $query = Certificado_Exportacion::query()
        ->leftJoin('dictamenes_exportacion', 'dictamenes_exportacion.id_dictamen', '=', 'certificados_exportacion.id_dictamen')
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_exportacion.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->select('certificados_exportacion.*', 'empresa.razon_social')//especifica la columna obtenida
        /*->where(function ($q) use ($search) {
            $q->where('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhere('certificados_exportacion.num_certificado', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_exportacion.num_dictamen', 'LIKE', "%{$search}%");
        })*/;
    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;// Clonamos el query antes de aplicar búsqueda, paginación u ordenamiento
    $totalData = $baseQuery->count();// totalData (sin búsqueda)


    // Búsqueda Global
    if (!empty($search)) {//solo se aplica si hay búsqueda global
        /*1)$query->where(function ($q) use ($search) {
            $q->where('num_certificado', 'LIKE', "%{$search}%")
              ->orWhere('id_certificado', 'LIKE', "%{$search}%");
        });*/
        $query->where(function ($q) use ($search) {
            $q->where('certificados_exportacion.num_certificado', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_exportacion.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(certificados_exportacion.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }


    // Ordenamiento especial para num_certificado con formato 'CIDAM C-EXP25-###'
    if ($orderColumn === 'num_certificado') {
        $query->orderByRaw("
            CASE
                WHEN num_certificado LIKE 'CIDAM C-EXP25-%' THEN 0
                ELSE 1
            END ASC,
            CAST(
                SUBSTRING_INDEX(
                    SUBSTRING(num_certificado, LOCATE('CIDAM C-EXP25-', num_certificado) + 14),
                    '-', 1
                ) AS UNSIGNED
            ) $orderDirection
        ");
    } elseif (!empty($orderColumn)) {
        $query->orderBy($orderColumn, $orderDirection);
    }

    
    //dd($query->toSql(), $query->getBindings());ver que manda
    // Paginación
    //1)$certificados = $query->offset($start)->limit($limit)->get();
    $certificados = $query
        ->with([// 1 consulta por cada tabla relacionada en conjunto (menos busqueda de query adicionales en BD)
            'dictamen',// Relación directa
            'dictamen.inspeccione',// Relación anidada: dictamen > inspeccione
            'dictamen.inspeccione.solicitud',// dictamen > inspeccione > solicitud
            // solicitud > empresa > empresaNumClientes
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.inspeccione.solicitud.empresa.empresaNumClientes',
            // Revisores
            'revisorPersonal.user',
            'revisorConsejo.user',
        ])->offset($start)->limit($limit)->get();



    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($certificados)) {
        foreach ($certificados as $certificado) {
            $nestedData['id_certificado'] = $certificado->id_certificado ?? 'No encontrado';
            $nestedData['num_certificado'] = $certificado->num_certificado ?? 'No encontrado';
            $nestedData['id_dictamen'] = $certificado->dictamen->id_dictamen ?? 'No encontrado';
            $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'No encontrado';
            $nestedData['estatus'] = $certificado->estatus ?? 'No encontrado';
            $id_sustituye = json_decode($certificado->observaciones, true) ['id_sustituye'] ?? null;
            $nestedData['sustituye'] = $id_sustituye ? Certificado_Exportacion::find($id_sustituye)->num_certificado ?? 'No encontrado' : null;
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
            $fechaActual = Carbon::now()->startOfDay();//Obtener la fecha actual sin horas
            $fechaVigencia = Carbon::parse($certificado->fecha_vigencia)->startOfDay();
                if ($fechaActual->isSameDay($fechaVigencia)) {
                    $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este certificado</span>";
                } else {
                    $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);//diferencia de "dias" actual a vigencia
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
            //Lote envasado
            $lotes_env = $certificado->dictamen?->inspeccione?->solicitud?->lotesEnvasadoDesdeJson();//obtener todos los lotes
            $nestedData['combinado'] = $lotes_env?->count() > 1 ? true : false;
            $nestedData['nombre_lote_envasado'] = $lotes_env?->pluck('nombre')->implode(', ') ?? 'No encontrado';
            //Lote granel
            $lotes_granel = $lotes_env?->flatMap(function ($lote) {
                return $lote->lotesGranel; // Relación definida en el modelo lotes_envasado
                })->unique('id_lote_granel');//elimina duplicados
            $nestedData['nombre_lote_granel'] = $lotes_granel?->pluck('nombre_lote')//extrae cada "nombre"
                ->implode(', ') ?? 'No encontrado';//une y separa por coma
            //caracteristicas
            $nestedData['marca'] = $lotes_env?->first()?->marca->marca ?? 'No encontrado';
            $caracteristicas = $certificado->dictamen?->inspeccione?->solicitud?->caracteristicasDecodificadas() ?? [];
            $nestedData['n_pedido'] = $caracteristicas['no_pedido'] ?? 'No encontrado';
            $nestedData['cajas'] = collect($caracteristicas['detalles'] ?? [])->first()['cantidad_cajas'] ?? 'No encontrado';
            $nestedData['botellas'] = collect($caracteristicas['detalles'] ?? [])->first()['cantidad_botellas'] ?? 'No encontrado';
            //visto bueno
            $nestedData['vobo'] = $certificado->vobo ? json_decode($certificado->vobo, true) : null;
            //Certificado Firmado
            $documentacion = Documentacion_url::where('id_relacion', $certificado->id_certificado)
                ->where('id_documento', 135)->first();
            $nestedData['pdf_firmado'] = $documentacion?->url
                ? asset("files/{$numero_cliente}/certificados_exportacion/{$documentacion->url}") : null;
            


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


///FUNCION EXPORTAR EXCEL
public function exportar(Request $request)
{
    //try {
        $filtros = $request->only(['id_empresa', 'anio', 'estatus', 'mes']);
        return Excel::download(new CertificadosExport($filtros), 'reporte_certificados.xlsx');
    /*} catch (\Exception $e) {
        Log::error('Error al generar el reporte: ' . $e->getMessage());
        return response()->json(['message' => 'Error al generar el reporte. Verifica los filtros e intenta nuevamente.', 'code' => 500]);
    }*/
}



///FUNCION REGISTRAR
public function store(Request $request)
{
    try {
    $validated = $request->validate([
        'id_dictamen' => 'required|exists:dictamenes_exportacion,id_dictamen',
        'num_certificado' => 'required|string|max:40',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        'id_firmante' => 'required|exists:users,id',

        'hologramas.*.tipo' => 'array', // select multiple
        'hologramas' => 'array', // input dinámico
        'hologramas.*.descripcion' => 'nullable|string',
    ]);

        $idHologramas = [];
        $oldHologramas = [];

        foreach ($request->hologramas ?? [] as $index => $holo) {
            // Para el select múltiple
            $rangoAgrupado = [];
            if (!empty($holo['tipo'])) {
                foreach ($holo['tipo'] as $valor) {
                    // Separa ID y folios
                    [$id, $inicio, $final] = explode('|', $valor);
                    $rangoAgrupado[] = ['inicial' => $inicio, 'final' => $final];
                }

                // Guarda el ID del primer elemento del grupo (puedes ajustar si quieres múltiples)
                $idHologramas['folio' . ($index + 1)] = [
                    'id' => $id,
                    'rangos' => $rangoAgrupado
                ];
            }

            // Para el input
            $oldHologramas["folio" . ($index + 1)] = $holo['descripcion'] ?? '';
        }


        // Crear un registro
        $new = new Certificado_Exportacion();
        $new->id_dictamen = $validated['id_dictamen'];
        $new->num_certificado = $validated['num_certificado'];
        $new->fecha_emision = $validated['fecha_emision'];
        $new->fecha_vigencia = $validated['fecha_vigencia'];
        $new->id_firmante = $validated['id_firmante'];
        
        $new->id_hologramas = json_encode($idHologramas);
        $new->old_hologramas = json_encode($oldHologramas);
        $new->save();

        return response()->json(['message' => 'Registrado correctamente.']);
    } catch (\Exception $e) {
        
        return response()->json(['error' => 'Error al registrar.'. $e], 500);
    }
}


///FUNCION ELIMINAR
public function destroy($id_certificado)
{
    try {
        $eliminar = Certificado_Exportacion::findOrFail($id_certificado);
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
public function edit($id_certificado)
{
    try {
        //$editar = Certificado_Exportacion::findOrFail($id_certificado);
        $editar = Certificado_Exportacion::with('dictamen.inspeccione.solicitud')->findOrFail($id_certificado);

        return response()->json([
            'id_certificado' => $editar->id_certificado,
            'id_dictamen' => $editar->id_dictamen,
            'num_certificado' => $editar->num_certificado,
            'fecha_emision' => $editar->fecha_emision,
            'fecha_vigencia' => $editar->fecha_vigencia,
            'id_firmante' => $editar->id_firmante,

            'id_hologramas' => $editar->id_hologramas ?? '{}',
            'old_hologramas' => $editar->old_hologramas ?? '{}',

            // SIN tener que guardarlo en base de datos
            'folio' => $editar->dictamen->inspeccione->solicitud->folio ?? '',
            'num_dictamen' => $editar->dictamen->num_dictamen ?? ''
        ]);
    } catch (\Exception $e) {
        Log::error('Error al obtener', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al obtener los datos.'], 500);
    }
}

///FUNCION ACTUALIZAR
public function update(Request $request, $id_certificado)
{
    $request->validate([
        'num_certificado' => 'required|string|max:40',
        'id_dictamen' => 'required|integer',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        'id_firmante' => 'required|integer',

        'hologramas.*.tipo' => 'array',
        'hologramas' => 'array',
        'hologramas.*.descripcion' => 'nullable|string',
    ]);

    $idHologramas = [];
    $oldHologramas = [];

    foreach ($request->hologramas ?? [] as $index => $holo) {
        $rangoAgrupado = [];
        if (!empty($holo['tipo'])) {
            foreach ($holo['tipo'] as $valor) {
                [$id, $inicio, $final] = explode('|', $valor);
                $rangoAgrupado[] = ['inicial' => $inicio, 'final' => $final];
            }

            $idHologramas['folio' . ($index + 1)] = [
                'id' => $id,
                'rangos' => $rangoAgrupado
            ];
        }

        $oldHologramas['folio' . ($index + 1)] = $holo['descripcion'] ?? '';
    }


    try {
        $actualizar = Certificado_Exportacion::findOrFail($id_certificado);

        $actualizar->num_certificado = $request->num_certificado;
        $actualizar->id_dictamen = $request->id_dictamen;
        $actualizar->fecha_emision = $request->fecha_emision;
        $actualizar->fecha_vigencia = $request->fecha_vigencia;
        $actualizar->id_firmante = $request->id_firmante;

        $actualizar->id_hologramas = json_encode($idHologramas);
        $actualizar->old_hologramas = json_encode($oldHologramas);
        $actualizar->save();

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
                'id_certificado' => 'required|exists:certificados_exportacion,id_certificado',
                'id_dictamen' => 'required|integer',
                'num_certificado' => 'required|string|min:8',
                'fecha_emision' => 'nullable|date',
                'fecha_vigencia' => 'nullable|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $reexpedir = Certificado_Exportacion::findOrFail($request->id_certificado);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1;
            //$certificado->observaciones = $request->observaciones;
                // Decodificar el JSON actual
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                // Actualiza solo 'observaciones' sin modificar 'id_certificado_sustituye'
                $observacionesActuales['observaciones'] = $request->observaciones;
                // Volver a codificar el array y asignarlo a $certificado->observaciones
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save();
            return response()->json(['message' => 'Cancelado correctamente.']);

        } elseif ($request->accion_reexpedir == '2') {
            $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save();

            // Crear un nuevo registro de reexpedición
            $new = new Certificado_Exportacion();
            $new->num_certificado = $request->num_certificado;
            $new->id_dictamen = $request->id_dictamen;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_certificado]);
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
            'id_certificado' => 'required|integer|exists:certificados_exportacion,id_certificado',
        ]);

        $user = User::find($validatedData['nombreRevisor']);
        if (!$user) {
            return response()->json(['message' => 'El revisor no existe.'], 404);
        }

        $certificado = Certificado_Exportacion::find($validatedData['id_certificado']);
        if (!$certificado) {
            return response()->json(['message' => 'El certificado no existe.'], 404);
        }

        $revisor = Revisor::where('id_certificado', $validatedData['id_certificado'])
                ->where('tipo_certificado', 3)
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
                $revisor->tipo_certificado = 3; //El 2 corresponde al certificado de granel
                $revisor->tipo_revision = $validatedData['tipoRevisor'];
                $revisor->id_revisor = $validatedData['nombreRevisor'];
                $message = 'Revisor asignado exitosamente.';
            }
        // Guardar los datos del revisor
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


///PDF CERTIFICADO
public function MostrarCertificadoExportacion($id_certificado)
{
    $data = Certificado_Exportacion::find($id_certificado);//Obtener datos del certificado

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    //$fecha = Helpers::formatearFecha($data->fecha_emision);
    //$fecha = Carbon::createFromFormat('Y-m-d H:i:s', $data->fecha_emision);//fecha y hora
    $fecha_emision = !empty($data->fecha_emision) ? Carbon::parse($data->fecha_emision)->translatedFormat('d/m/Y')
    : '--------';
    $fecha_vigencia = !empty($data->fecha_vigencia) ? Carbon::parse($data->fecha_vigencia)->translatedFormat('d/m/Y')
    : '--------';
    $empresa = $data->dictamen->inspeccione->solicitud->empresa ?? null;
    $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
        ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
        ->id && !empty($item->numero_cliente)) ?->numero_cliente ?? 'No encontrado' : 'N/A';
    //Determinar si la marca de agua debe ser visible
    $watermarkText = $data->estatus == 1;
    //Obtener un valor específico del JSON
    $id_sustituye = json_decode($data->observaciones, true)//Decodifica el JSON actual
    ['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ?//verifica si la variable $id_sustituye tiene valor asociado
    //Busca el registro del certificado que tiene el id igual a $id_sustituye
    Certificado_Exportacion::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

    $datos = $data->dictamen->inspeccione->solicitud->caracteristicas ?? null; //Obtener Características Solicitud
        $caracteristicas =$datos ? json_decode($datos, true) : []; //Decodificar el JSON
        $aduana_salida = $caracteristicas['aduana_salida'] ?? '';
        $no_pedido = $caracteristicas['no_pedido'] ?? '';
        $detalles = $caracteristicas['detalles'] ?? [];//Acceder a detalles (que es un array)
        // Acceder a los detalles
            //$botellas = $detalle['cantidad_botellas'][0] ?? '';
            $botellas = $detalles[0]['cantidad_botellas'] ?? '';
            $cajas = $detalles[0]['cantidad_cajas'] ?? '';
            //$cajas = $detalle['cantidad_cajas'][0] ?? '';
            /*$presentacion = '';
            if (!empty($detalles) && isset($detalles[0]['presentacion'])) {
                $pres = $detalles[0]['presentacion'];
                $presentacion = is_array($pres) ? ($pres[0] ?? '') : $pres;
            }*/
            //$presentacion = $detalles[0]['presentacion'][0] ?? '';
        // Obtener todos los IDs de los lotes
        $loteIds = collect($detalles)->pluck('id_lote_envasado')->filter()->all();//elimina valor vacios y devuelve array
        // Buscar los lotes envasados
        $lotes = !empty($loteIds) ? lotes_envasado::whereIn('id_lote_envasado', $loteIds)->get()
            : collect(); // Si no hay IDs, devolvemos una colección vacía
        /*$lotes = collect();//mutliples lotes
        foreach (json_decode($datos)->detalles as $detalle) {
            $lote = Lotes_Envasado::find($detalle->id_lote_envasado);//compara el valor "id_lote_envasado" con "Lotes_Envasado"
            if ($lote) {
                $lotes->push($lote);//Agregar el lote a la colección
            }
        }*/

    //return response()->json(['message' => 'No se encontraron características.', $data], 404)

    //$pdf = Pdf::loadView('pdfs.certificado_exportacion_ed12', [//formato del PDF
    $pdf =  [
        'data' => $data,//declara todo = {{ $data->inspeccione->num_servicio }}
        'lotes' =>$lotes,
        'expedicion' => $fecha_emision,
        'vigencia' => $fecha_vigencia,
        'n_cliente' => $numero_cliente,
        'empresa' => $data->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'domicilio' => $data->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'No encontrado',
        'estado' => $data->dictamen->inspeccione->solicitud->empresa->estados->nombre ?? 'No encontrado',
        'rfc' => $data->dictamen->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'cp' => $data->dictamen->inspeccione->solicitud->empresa->cp ?? 'No encontrado',
        'convenio' =>  $lotes[0]->lotesGranel[0]->empresa->convenio_corresp ?? 'NA',
        'DOM' => $lotes[0]->lotesGranel[0]->empresa->registro_productor ?? 'NA',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        'nombre_destinatario' => $data->dictamen->inspeccione->solicitud->direccion_destino->destinatario ?? 'No encontrado',
        'dom_destino' => $data->dictamen->inspeccione->solicitud->direccion_destino->direccion ?? 'No encontrado',
        'pais' => $data->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'No encontrado',
        'envasadoEN' => $data->dictamen->inspeccione->solicitud->instalacion_envasado->direccion_completa ?? 'No encontrado',
        ///caracteristicas
        'aduana' => $aduana_salida ?? 'No encontrado',
        'n_pedido' => $no_pedido ?? 'No encontrado',
        'botellas' => $botellas ?? 'No encontrado',
        'cajas' => $cajas ?? 'No encontrado',
        //'presentacion' => $presentacion ?? 'No encontrado',
    ];

    if ( $data->fecha_emision >= '2025-07-01' ) {
        $edicion = 'pdfs.certificado_exportacion_ed13';
    }else{
        $edicion = 'pdfs.certificado_exportacion_ed12';
    }
    //nombre al descargar
    //return $pdf->stream('F7.1-01-23 Ver 12. Certificado de Autenticidad de Exportación de Mezcal.pdf');
    return Pdf::loadView($edicion, $pdf)->stream('F7.1-01-23 Ver 12. Certificado de Autenticidad de Exportación de Mezcal.pdf');
}

///PDF SOLICITUD CERTIFICADO
public function MostrarSolicitudCertificadoExportacion($id_certificado)
{
    $data = Certificado_Exportacion::find($id_certificado);
    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    //$fecha = Carbon::createFromFormat('Y-m-d H:i:s', $data->fecha_emision);//fecha y hora
    /*$fecha_emision = Carbon::parse($data->fecha_emision);
        $fecha1 = $fecha_emision->translatedFormat('d/m/Y');
    $fecha_vigencia = Carbon::parse($data->fecha_vigencia);
        $fecha2 = $fecha_vigencia->translatedFormat('d/m/Y');*/
    $empresa = $data->dictamen->inspeccione->solicitud->empresa ?? null;
    $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
        ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
        ->id && !empty($item->numero_cliente)) ?->numero_cliente ?? 'No encontrado' : 'N/A';
    $id_sustituye = json_decode($data->observaciones, true)//Decodifica el JSON
        ['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ?//verifica si $id_sustituye tiene valor
        //Busca el registro del certificado que tiene el id igual a $id_sustituye
        Certificado_Exportacion::find($id_sustituye)->num_certificado ?? '' : '';
    $watermarkText = $data->estatus == 1;//Determinar si marca de agua es visible

    $datos = $data->dictamen?->inspeccione?->solicitud?->caracteristicas; //Obtener Características Solicitud
        $caracteristicas =$datos ? json_decode($datos, true) : []; //Decodificar el JSON
        $aduana_salida = $caracteristicas['aduana_salida'] ?? '';
        $no_pedido = $caracteristicas['no_pedido'] ?? '';
        $detalles = $caracteristicas['detalles'] ?? [];//Acceder a detalles (que es un array)
        foreach ($detalles as $detalle) {// Acceder a los detalles
            $botellas = $detalle['cantidad_botellas'] ?? '';
            $cajas = $detalle['cantidad_cajas'] ?? '';
            $presentacion = $detalle['presentacion'] ?? '';
        }
        $loteIds = collect($detalles)->pluck('id_lote_envasado')->filter()->all();//elimina valor vacios y devuelve array
        $lotes = !empty($loteIds) ? lotes_envasado::whereIn('id_lote_envasado', $loteIds)->get()
            : collect(); // Si no hay IDs, devolvemos una colección vacía

    //return response()->json(['message' => 'No se encontraron características.', $data], 404);

    //$pdf = Pdf::loadView('pdfs.solicitud_certificado_exportacion_ed10', [//formato del PDF
    $pdf = [
        'data' => $data,
        'lotes' =>$lotes,
        'fecha_solicitud' => Helpers::formatearFecha($data->dictamen->inspeccione->solicitud->fecha_solicitud) ?? 'No encontrado',
        'n_cliente' => $numero_cliente,
        'empresa' => $empresa->razon_social ?? 'No encontrado',
        'domicilio_inspeccion' => $data->dictamen->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrado',
        'fecha_propuesta' => Helpers::formatearFecha($data->dictamen->inspeccione->solicitud->fecha_visita) ?? 'No encontrado',
        'resp_instalacion' => $data->dictamen->inspeccione->solicitud->instalacion->responsable ?? 'No encontrado',
        'info_adicional' => $data->dictamen->inspeccione->solicitud->info_adicional ?? ' ',


        'estado' => $data->dictamen->inspeccione->solicitud->empresa->estados->nombre ?? 'No encontrado',
        'rfc' => $data->dictamen->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'cp' => $data->dictamen->inspeccione->solicitud->empresa->cp ?? 'No encontrado',
        'convenio' => $data->dictamen->inspeccione->solicitud->empresa->convenio_corresp ?? 'NA',
        'DOM' => $data->dictamen->inspeccione->solicitud->empresa->registro_productor ?? 'NA',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,

        'nombre_destinatario' => $data->dictamen->inspeccione->solicitud->direccion_destino->destinatario ?? 'No encontrado',
        'dom_destino' => $data->dictamen->inspeccione->solicitud->direccion_destino->direccion ?? 'No encontrado',
        'pais' => $data->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'No encontrado',

        'folio' => isset($data->dictamen->inspeccione->solicitud->folio) &&
           preg_match('/^([A-Z\-]+)(\d+)$/', $data->dictamen->inspeccione->solicitud->folio, $m)
           ? $m[1] . str_pad(((int)$m[2]) + 1, strlen($m[2]), '0', STR_PAD_LEFT)
           : 'No encontrado',
        ///caracteristicas
        'aduana' => $aduana_salida ?? 'No encontrado',
        'n_pedido' => $no_pedido ?? 'No encontrado',
        'botellas' => $botellas ?? 'No encontrado',
        'cajas' => $cajas ?? 'No encontrado',
        //'presentacion' => $presentacion ?? 'No encontrado', se tomara directod el lote
    ];

    if ( $data->fecha_emision >= '2025-06-01' ) {
        $edicion = 'pdfs.solicitud_certificado_exportacion_ed11';
    }else{
        $edicion = 'pdfs.solicitud_certificado_exportacion_ed10';
    }
    //nombre al descargar
    //return $pdf->stream('Solicitud de emisión de Certificado Combinado para Exportación NOM-070-SCFI-2016 F7.1-01-55.pdf');
    return Pdf::loadView($edicion, $pdf)->stream('Solicitud de emisión de Certificado Combinado para Exportación NOM-070-SCFI-2016 F7.1-01-55.pdf');
}





///SUBIR CERTIFICADO FIRMADO
public function subirCertificado(Request $request)
{
    $request->validate([
        'id_certificado' => 'required|exists:certificados_exportacion,id_certificado',
        'documento' => 'required|mimes:pdf|max:3072',
    ]);

    $certificado = Certificado_Exportacion::findOrFail($request->id_certificado);

    // Limpiar num_certificado para evitar crear carpetas por error
    $nombreCertificado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificado->num_certificado ?? 'No encontrado');
    // Generar nombre de archivo con num_certificado + cadena aleatoria
    $nombreArchivo = $nombreCertificado.'_'. uniqid() .'.pdf'; //uniqid() para asegurar nombre único

    
    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });
    // Ruta de carpeta física donde se guardará
    $rutaCarpeta = "public/uploads/{$numeroCliente}/certificados_exportacion";
   
    // Guardar nuevo archivo
    $upload = Storage::putFileAs($rutaCarpeta, $request->file('documento'), $nombreArchivo);
    if (!$upload) {
        return response()->json(['message' => 'Error al subir el archivo.'], 500);
    }


    // Buscar si ya existe un registro para ese lote y tipo de documento
    $documentacion_url = Documentacion_url::where('id_documento', 135)
        ->where('id_relacion', $certificado->id_certificado)//id del certificado
        ->first();

    if ($documentacion_url) {
        $ArchivoAnterior = "public/uploads/{$numeroCliente}/certificados_exportacion/{$documentacion_url->url}";
        if (Storage::exists($ArchivoAnterior)) {
            Storage::delete($ArchivoAnterior);
        }
    }

    // Crear o actualizar registro
    Documentacion_url::updateOrCreate(
        [
            'id_documento' => 135,
            'id_relacion' => $certificado->id_certificado,//id del certificado
        ],
        [
            'nombre_documento' => "Certificado de exportación",
            'url' => "{$nombreArchivo}",
            'id_empresa' => $certificado->dictamen?->inspeccione?->solicitud?->id_empresa,
        ]
    );

    return response()->json(['message' => 'Documento actualizado correctamente.']);
}
///OBTENER CERTIFICADO FIRMADO
public function CertificadoFirmado($id)
{
    $certificado = Certificado_Exportacion::findOrFail($id);

    // Buscar documento asociado al lote
    $documentacion = Documentacion_url::where('id_documento', 135)
        ->where('id_relacion', $certificado->id_certificado)
        ->first();

    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)->first();
      $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });

    if ($documentacion) {
        $rutaArchivo = "{$numeroCliente}/certificados_exportacion/{$documentacion->url}";

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





///VER DOCUMENTACION
public function documentos($id)
{
    $certificado = Certificado_Exportacion::find($id);
    if (!$certificado) {
        return abort(404, 'Registro no encontrado.');
    }

    $caracteristicas = $certificado->dictamen?->inspeccione?->solicitud?->caracteristicasDecodificadas() ?? [];
    $id_etiqueta = $caracteristicas['id_etiqueta'] ?? null;
    $detalles = $caracteristicas['detalles'] ?? [];

    $documentosPorLote = [];

    foreach ($detalles as $detalle) {
        $id_lote_envasado = $detalle['id_lote_envasado'] ?? null;
        if (!$id_lote_envasado) {
            continue;
        }

        $lote_envasado = lotes_envasado::where('id_lote_envasado', $id_lote_envasado)->first();
        if (!$lote_envasado) {
            continue;
        }

        $id_lote_granel = $lote_envasado->lotesGranel->first()->id_lote_granel ?? null;
        if (!$id_lote_granel) {
            continue;
        }

        $empresaOrigen = empresa::with("empresaNumClientes")->where("id_empresa", $lote_envasado->lotesGranel->first()->id_empresa)->first();
        $clienteOrigen = $empresaOrigen->empresaNumClientes
            ->pluck('numero_cliente')
            ->filter()
            ->first();

        $dictamenEnvasado = Dictamen_Envasado::where('id_lote_envasado', $id_lote_envasado)->first();

        $certificadoGranel = Documentacion_url::where('id_relacion', $id_lote_granel)
            ->where('id_documento', 59)->first();

        $fqs = Documentacion_url::where('id_relacion', $id_lote_granel)
            ->where('id_documento', 58)->get()->pluck('url')->toArray();

        $fqs_ajuste = Documentacion_url::where('id_relacion', $id_lote_granel)
            ->where('id_documento', 134)->get()->pluck('url')->toArray();

        $documentosPorLote[] = [
            'id_lote_envasado' => $id_lote_envasado,
            'dictamen' => $dictamenEnvasado->id_dictamen_envasado ?? null,
            'certificadoGranel' => $certificadoGranel->url ?? null,
            'fqs' => $fqs,
            'fqs_ajuste' => $fqs_ajuste,
            'clienteOrigen' => $clienteOrigen,
        ];
    }


    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $certificado->dictamen->inspeccione->solicitud->id_empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes
        ->pluck('numero_cliente')
        ->filter()
        ->first();

    $etiquetaDoc = Documentacion_url::where('id_relacion', $id_etiqueta)
        ->where('id_documento', 60)->first();

    $corrugadoDoc = Documentacion_url::where('id_relacion', $id_etiqueta)
        ->where('id_documento', 75)->first();

    $proformaDoc = Documentacion_url::where('id_relacion', $certificado->dictamen?->inspeccione?->solicitud->id_solicitud)
        ->where('id_documento', 55)->first();


    return response()->json([
        'success' => true,
        'numeroCliente' => $numeroCliente,
        'documentos' => $documentosPorLote,
        'etiquetas' => $etiquetaDoc->url ?? null,
        'corrugado' => $corrugadoDoc->url ?? null,
        'proforma' => $proformaDoc->url ?? null,
    ]);
}






///VISTO BUENO
public function obtenerVobo($id)
{
    $certificado = Certificado_Exportacion::findOrFail($id);
    $vobo = $certificado->vobo ? json_decode($certificado->vobo, true) : null;

    // Obtener usuarios tipo 3 (clientes)
    $clientes = User::where('tipo', 3)->select('id', 'name')->get();

    return response()->json([
        'vobo' => $vobo,
        'id_usuario' => Auth::id(),
        'num_certificado' => $certificado->num_certificado,
        'clientes' => $clientes
    ]);
}

public function guardarVobo(Request $request)
{
    $certificado = Certificado_Exportacion::findOrFail($request->id_certificado);
    $vobo = $certificado->vobo ? json_decode($certificado->vobo, true) : [];

    $userId = Auth::id();

    if ($request->has('respuesta')) {
        $vobo[] = [
            'id_cliente' => $userId,
            'descripcion' => $request->descripcion,
            'respuesta' => $request->respuesta
        ];

        $user = User::find($userId);
        $respuesta = $request->respuesta == 1 ? 'Aprobado' : 'No aprobado';
        // NOTIFICACION PARA EL PERSONAL
        $personalEntry = collect($vobo)->firstWhere('id_personal');
        if ($personalEntry) {
            $receptor = User::find($personalEntry['id_personal']);

            if ($receptor) {
                $dataNotificacion = [
                    'title' => 'Revisión del cliente',
                    'asunto' => 'revisión' . $certificado->num_certificado,
                    'message' => 'Revisado por ' .$user->name. ' y el Vo.Bo. fué '.$respuesta.'<br>'
                        .$request->descripcion,
                    //'message' => $request->descripcion,
                    'url' => route('certificados-exportacion'),
                ];
                $receptor->notify(new GeneralNotification($dataNotificacion));
            }
        }

    } else {//NOTIFICACION PARA EL CLIENTE
        $vobo[] = [
            'id_personal' => $userId,
            'descripcion' => $request->descripcion,
            //'notificados' => $request->notificados
        ];

        // Notificar a los clientes seleccionados
        if ($request->has('notificados')) {
            foreach ($request->notificados as $clienteId) {
                $cliente = User::find($clienteId);
                if ($cliente) {
                    $dataNotificacion = [
                        'title' => 'Vo.Bo.',
                        'asunto' => 'Revisión ' . $certificado->num_certificado . ' pendiente',
                        'message' => $request->descripcion,
                        'url' => route('certificados-exportacion'),
                    ];
                    $cliente->notify(new GeneralNotification($dataNotificacion));
                }
            }
        }

    }

     
    activity()->disableLogging();//Desactivar TRAZABILIDAD para este registro
    $certificado->vobo = json_encode($vobo);
    $certificado->save();

    return response()->json(['success' => true]);
}







}//end-classController
