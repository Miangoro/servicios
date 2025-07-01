<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\Dictamen_Exportacion;
use App\Models\inspecciones;
use App\Models\User;
use App\Models\empresa;
use App\Models\lotes_envasado;
use App\Models\instalaciones;
//Extensiones
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\GeneralNotification;
use Faker\Extension\Helper;
//firma electronica
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Illuminate\Support\Facades\Storage;


class DictamenExportacionController extends Controller
{

    public function UserManagement()
    {
        $dictamenes = Dictamen_Exportacion::all(); // Obtener todos los datos
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 11);
            })->orderBy('id_inspeccion', 'desc')->get();
        $users = User::where('tipo',2)->get(); //Solo inspectores
        $empresa = empresa::where('tipo', 2)->get(); //solo empresas tipo '2'

        // Pasar los datos a la vista
        return view('dictamenes.find_dictamen_exportacion', compact('dictamenes', 'inspeccion', 'users', 'empresa'));
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
        1 => 'num_dictamen',
        2 => 'folio', //nombre de mi tabla y atributo
        3 => 'razon_social', 
        4 => '', //caracteristicas
        5 => 'fecha_emision',
        6 => 'estatus',            
        7 => '',// acciones
    ];

    /*$totalData = Dictamen_Exportacion::count();
    $totalFiltered = $totalData;*/
    $limit = $request->input('length');
    $start = $request->input('start');
    
    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'asc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'num_dictamen'; // Por defecto
    
    $search = $request->input('search.value');//Define la búsqueda global.


    //1)$query = Dictamen_Exportacion::query();
    /*2)$query = Dictamen_Exportacion::select('inspecciones.*')
    ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_exportacion.id_inspeccion');
    */
    $query = Dictamen_Exportacion::query()
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_exportacion.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->select('dictamenes_exportacion.*', 'empresa.razon_social')//especifica la columna obtenida
        /*->where(function ($q) use ($search) {
            $q->where('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_exportacion.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%");
        })*/;

    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;// Clonamos el query antes de aplicar búsqueda, paginación u ordenamiento
    $totalData = $baseQuery->count();// totalData (sin búsqueda)

    
    // Búsqueda Global
    if (!empty($search)) {//solo se aplica si hay búsqueda global
        /*1)$query->where(function ($q) use ($search) {
            $q->where('num_dictamen', 'LIKE', "%{$search}%")
              ->orWhere('num_servicio', 'LIKE', "%{$search}%");
        });*/
        $query->where(function ($q) use ($search) {
            $q->where('dictamenes_exportacion.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(dictamenes_exportacion.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }


    // Ordenamiento especial para num_dictamen con formato 'UMEXP##-###'
    if ($orderColumn === 'num_dictamen') {
        $query->orderByRaw("
            CASE
                WHEN num_dictamen LIKE 'UMEXP25-%' THEN 0
                ELSE 1
            END ASC,
            CAST(SUBSTRING_INDEX(SUBSTRING(num_dictamen, 9), '-', 1) AS UNSIGNED) DESC,
            CHAR_LENGTH(SUBSTRING_INDEX(SUBSTRING(num_dictamen, 9), '-', -1)) ASC
        ");
    }

    
    //dd($query->toSql(), $query->getBindings());ver que manda
    // Paginación
    //1)$dictamenes = $query->offset($start)->limit($limit)->get();
    $dictamenes = $query
        ->with([// 1 consulta por cada tabla relacionada en conjunto (menos busqueda adicionales de query en BD)
            'inspeccione', // Relación directa
            'inspeccione.solicitud',// Relación anidada: inspeccione > solicitud
            'inspeccione.solicitud.empresa',
            'inspeccione.solicitud.empresa.empresaNumClientes',
        ])->offset($start)->limit($limit)->get();



    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($dictamenes)) {
        foreach ($dictamenes as $dictamen) {
            $nestedData['id_dictamen'] = $dictamen->id_dictamen ?? 'No encontrado';
            $nestedData['num_dictamen'] = $dictamen->num_dictamen ?? 'No encontrado';
            $nestedData['estatus'] = $dictamen->estatus ?? 'No encontrado';
            $id_sustituye = json_decode($dictamen->observaciones, true) ['id_sustituye'] ?? null;
            $nestedData['sustituye'] = $id_sustituye ? Dictamen_Exportacion::find($id_sustituye)->num_dictamen ?? 'No encontrado' : null;
            $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
            $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
            $nestedData['num_servicio'] = $dictamen->inspeccione->num_servicio ?? 'No encontrado';
            $nestedData['folio_solicitud'] = $dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
            ///numero y nombre empresa
            $empresa = $dictamen->inspeccione->solicitud->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
            $nestedData['numero_cliente'] = $numero_cliente;
            $nestedData['razon_social'] = $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
            ///dias vigencia
            $fechaActual = Carbon::now()->startOfDay(); //Asegúrate de trabajar solo con fechas, sin horas
            $nestedData['fecha_actual'] = $fechaActual;
            $nestedData['vigencia'] = $dictamen->fecha_vigencia;
            $fechaVigencia = Carbon::parse($dictamen->fecha_vigencia)->startOfDay();
                if ($fechaActual->isSameDay($fechaVigencia)) {
                    $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este dictamen</span>";
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
            $nestedData['id_solicitud'] = $dictamen->inspeccione->solicitud->id_solicitud ?? 'No encontrado';
            $urls = $dictamen->inspeccione?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
            $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';

             //Lote envasado
            $lotes_env = $dictamen->inspeccione?->solicitud?->lotesEnvasadoDesdeJson();//obtener todos los lotes
            $nestedData['combinado'] = $lotes_env?->count() > 1 ? true : false;
            $nestedData['nombre_lote_envasado'] = $lotes_env?->pluck('nombre')->implode(', ') ?? 'No encontrado';
            //Lote granel
            $lotes_granel = $lotes_env?->flatMap(function ($lote) {
                return $lote->lotesGranel; // Relación definida en el modelo lotes_envasado
                })->unique('id_lote_granel');//elimina duplicados
            $nestedData['nombre_lote_granel'] = $lotes_granel?->pluck('nombre_lote')//extrae cada "nombre"
                ->implode(', ') ?? 'No encontrado';//une y separa por coma


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
        'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
        'num_dictamen' => 'required|string|max:40',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|exists:users,id',
    ]);
        // Crear un registro
        $new = new Dictamen_Exportacion();
        $new->id_inspeccion = $validated['id_inspeccion'];
        $new->num_dictamen = $validated['num_dictamen'];
        $new->fecha_emision = $validated['fecha_emision'];
        $new->fecha_vigencia = $validated['fecha_vigencia'];
        $new->id_firmante = $validated['id_firmante'];
        $new->save();

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
public function destroy($id_dictamen)
{
    try {
        $eliminar = Dictamen_Exportacion::findOrFail($id_dictamen);
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
public function edit($id_dictamen)
{
    try {
        $editar = Dictamen_Exportacion::findOrFail($id_dictamen);

        return response()->json([
            'id_dictamen' => $editar->id_dictamen,
            'num_dictamen' => $editar->num_dictamen,
            'id_inspeccion' => $editar->id_inspeccion,
            'fecha_emision' => $editar->fecha_emision,
            'fecha_vigencia' => $editar->fecha_vigencia,
            'id_firmante' => $editar->id_firmante,
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
public function update(Request $request, $id_dictamen)
{
    try {
        // Validar los datos del formulario
        $validated = $request->validate([
            'num_dictamen' => 'required|string|max:70',
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);

        $actualizar = Dictamen_Exportacion::findOrFail($id_dictamen);
        $actualizar->update([// Actualizar
            'num_dictamen' => $validated['num_dictamen'],
            'id_inspeccion' => $validated['id_inspeccion'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_firmante' => $validated['id_firmante'],
        ]);

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
                'id_dictamen' => 'required|exists:dictamenes_exportacion,id_dictamen',
                'id_inspeccion' => 'required|integer',
                'num_dictamen' => 'required|string|min:8',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $reexpedir = Dictamen_Exportacion::findOrFail($request->id_dictamen);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1;
            // Decodificar el JSON actual
            $observacionesActuales = json_decode($reexpedir->observaciones, true);
            // Actualiza solo 'observaciones' sin modificar 'id_sustituye'
            $observacionesActuales['observaciones'] = $request->observaciones;
            // Volver a codificar el array y asignarlo a $certificado->observaciones
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
            $new = new Dictamen_Exportacion();
            $new->num_dictamen = $request->num_dictamen;
            $new->id_inspeccion = $request->id_inspeccion;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_dictamen]);
            $new->save();// Guardar

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



///PDF DICTAMEN
public function MostrarDictamenExportacion($id_dictamen)
{
    // Obtener los datos del dictamen
    //$data = Dictamen_Exportacion::with(['inspeccione','inspeccione.solicitud','inspeccione.inspector'])->find($id_dictamen);
    $data = Dictamen_Exportacion::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }
    //firma electronica
    $url = route('validar_dictamen', ['id_dictamen' => $id_dictamen]);
    $qrCode = new QrCode(
        data: $url,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::Low,
        size: 300,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        foregroundColor: new Color(0, 0, 0),
        backgroundColor: new Color(255, 255, 255)
    );
    // Escribir el QR en formato PNG
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    // Convertirlo a Base64
    $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

    if($data->id_firmante == 9){ //Erik
        $pass = 'Mejia2307';
    }
    if($data->id_firmante == 6){ //Karen velazquez
        $pass = '890418jks';
    }
    if($data->id_firmante == 7){ //Zaida
        $pass = 'ZA27CI09';
    }
    if($data->id_firmante == 14){ //Mario
        $pass = 'v921009villa';
    }
    $firmaDigital = Helpers::firmarCadena($data->num_dictamen . '|' . $data->fecha_emision . '|' . $data->inspeccione?->num_servicio, $pass, $data->id_firmante);


    // Verifica qué valor tiene esta variable
    $fecha_emision2 = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->fecha_servicio);
    $watermarkText = $data->estatus == 1;//Determinar si marca de agua es visible
    //Obtener un valor específico del JSON
    $id_sustituye = json_decode($data->observaciones, true)//Decodifica el JSON actual
        ['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ?//verifica si la variable $id_sustituye tiene valor asociado
        //Busca el registro del certificado que tiene el id igual a $id_sustituye
        Dictamen_Exportacion::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';

    $datos = $data->inspeccione->solicitud->caracteristicas ?? null; //Obtener Características Solicitud
        $caracteristicas =$datos ? json_decode($datos, true) : []; //Decodificar el JSON
        $aduana_salida = $caracteristicas['aduana_salida'] ?? '';
        $no_pedido = $caracteristicas['no_pedido'] ?? '';
        $envasado_en = $caracteristicas['id_instalacion_envasado'] ?? null;
            $E_productor = $envasado_en ? (instalaciones::find($envasado_en)?->estados?->nombre ?? 'No encontrado') : '';
        $detalles = $caracteristicas['detalles'] ?? [];//Acceder a detalles (que es un array)
        // Acceder a los detalles
            $botellas = $detalles[0]['cantidad_botellas'] ?? '';
            $cajas = $detalles[0]['cantidad_cajas'] ?? '';
            $presentacion = $detalles[0]['presentacion'][0] ?? '';
        // Obtener todos los IDs de los lotes
        $loteIds = collect($detalles)->pluck('id_lote_envasado')->filter()->all();//elimina valor vacios y devuelve array
        // Buscar los lotes envasados
        $lotes = !empty($loteIds) ? lotes_envasado::whereIn('id_lote_envasado', $loteIds)->get()
            : collect(); // Si no hay IDs, devolvemos una colección vacía

    //return response()->json(['message' => 'No se encontraron características.', $data], 404);


    $pdf = Pdf::loadView('pdfs.dictamen_exportacion_ed2', [//formato del PDF
        'data' => $data,//declara todo = {{ $data->inspeccione->num_servicio }}
        'lotes' =>$lotes,
        'producto' => $lotes->first()?->lotesGranel->first()?->categoria?->categoria ?? 'No encontrado',
        'no_dictamen' => $data->num_dictamen,
        'fecha_emision' => $fecha_emision2,
        'empresa' => $data->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'domicilio' => $data->inspeccione->solicitud->empresa->domicilio_fiscal ?? "No encontrado",
        'rfc' => $data->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'productor_autorizado' => $lotes[0]->lotesGranel[0]->empresa->registro_productor ?? '',
        'importador' => $data->inspeccione->solicitud->direccion_destino->destinatario ?? "No encontrado",
        //'direccion' => $data->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrado',
        'direccion' => $data->inspeccione->solicitud->direccion_destino->direccion ?? "No encontrado",
        'pais' => $data->inspeccione->solicitud->direccion_destino->pais_destino ?? "No encontrado",
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64,
        ///caracteristicas
        'aduana' => $aduana_salida ?? "No encontrado",
        'n_pedido' => $no_pedido ?? "No encontrado",
        //'envasado_en' => $envasado_en ?? "No encontrado",
        'envasado_en' => $E_productor,
        'botellas' => $botellas ?? "No encontrado",
        'cajas' => $cajas ?? "No encontrado",
        'presentacion' => $presentacion ?? "No encontrado",

        'fecha_servicio' => $fecha_servicio,
        'fecha_vigencia' => $fecha_vigencia,

    ]);
    //nombre al descarga
    return $pdf->stream('Dictamen de Cumplimiento para Producto de Exportación F-UV-04-18.pdf');
}





}//end-classController
