<?php

namespace App\Http\Controllers\dictamenes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dictamen_instalaciones;
use App\Models\clases;
use App\Models\categorias;
use App\Models\inspecciones;
use App\Models\empresa;
use App\Models\solicitudesModel;
use App\Models\User;
///Extensiones
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class DictamenInstalacionesController extends Controller
{

    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all(); // Obtener todos los datos
        $clases = clases::all();
        $users = User::where('tipo', 2)->get(); //Solo inspectores
        $categoria = categorias::all();
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 14);
        })->orderBy('id_inspeccion', 'desc')->get();

        $empresa = empresa::all();
        $soli = solicitudesModel::all();

        return view('dictamenes.find_dictamen_instalaciones', compact('dictamenes', 'clases', 'categoria', 'inspeccion', 'users'));
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
        1 => 'num_dictamen',
        2 => 'solicitudes.folio', 
        3 => 'razon_social', 
        4 => '', 
        5 => 'fecha_emision',
        6 => 'estatus',
    ];

    $limit = $request->input('length');
    $start = $request->input('start');
    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'asc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'num_dictamen'; // Por defecto
    
    $search = $request->input('search.value');//Define la búsqueda global.


    $query = Dictamen_instalaciones::query()
    ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_instalaciones.id_inspeccion')
    ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
    ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
    ->leftJoin('instalaciones', 'instalaciones.id_instalacion', '=', 'dictamenes_instalaciones.id_instalacion')
    ->select('dictamenes_instalaciones.*', 'empresa.razon_social');

    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;
    $totalData = $baseQuery->count();// totalData (sin búsqueda)


    // Mapeo de nombres a valores numéricos de tipo_dictamen
    $tiposDictamen = [
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
        $tipoDictamenValor = null;
        foreach ($tiposDictamen as $nombre => $valor) {
            $nombreNormalizado = strtr(mb_strtolower($nombre, 'UTF-8'), [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u'
            ]);
            if (strpos($searchNormalized, $nombreNormalizado) !== false) {
                $tipoDictamenValor = $valor;
                break;
            }
        }

        $query->where(function ($q) use ($search, $tipoDictamenValor) {
            $q->where('dictamenes_instalaciones.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(dictamenes_instalaciones.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"])
            ->orWhere('instalaciones.direccion_completa', 'LIKE', "%{$search}%");
            
            // Si se encontró un valor válido para el tipo_dictamen, agregarlo
            if (!is_null($tipoDictamenValor)) {
                $q->orWhere('dictamenes_instalaciones.tipo_dictamen', $tipoDictamenValor);
            }
        
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    // Ordenamiento especial para num_dictamen con formato 'UMC-###'
    if ($orderColumn === 'num_dictamen') {
        $query->orderByRaw("
            CASE
                WHEN num_dictamen LIKE 'UMC-%/%' THEN 0
                ELSE 1
            END ASC,
            CAST(SUBSTRING_INDEX(num_dictamen, '/', -1) AS UNSIGNED) $orderDirection, -- Año
            CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(num_dictamen, '/', 1), '-', -1) AS UNSIGNED) $orderDirection -- Número
        ");
    } elseif (!empty($orderColumn)) {
        $query->orderBy($orderColumn, $orderDirection);
    }

    
    // Paginación
    $dictamenes = $query
        ->with([// 1 consulta por cada tabla relacionada en conjunto (menos busqueda adicionales de query en BD)
            'inspeccione',// Relación directa
            'inspeccione.solicitud',// Relación anidada: inspeccione > solicitu
            'inspeccione.solicitud.empresa',
            'inspeccione.solicitud.empresa.empresaNumClientes',
        ])->offset($start)->limit($limit)->get();



        //MANDA LOS DATOS AL JS
        $data = [];
        if (!empty($dictamenes)) {
            foreach ($dictamenes as $dictamen) {
                $nestedData['id_dictamen'] = $dictamen->id_dictamen ?? 'No encontrado';
                $nestedData['tipo_dictamen'] = $dictamen->tipo_dictamen ?? 'No encontrado';
                $nestedData['num_dictamen'] = $dictamen->num_dictamen ?? 'No encontrado';
                $nestedData['estatus'] = $dictamen->estatus ?? 'No encontrado';
                $id_sustituye = json_decode($dictamen->observaciones, true)['id_sustituye'] ?? null;
                $nestedData['sustituye'] = $id_sustituye ? Dictamen_instalaciones::find($id_sustituye)->num_dictamen ?? 'No encontrado' : null;
                $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
                $nestedData['num_servicio'] = $dictamen->inspeccione->num_servicio ?? 'No encontrado';
                $nestedData['folio_solicitud'] = $dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
                $nestedData['direccion_completa'] = $dictamen->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrada';
                ///numero y nombre empresa
                $empresa = $dictamen->inspeccione->solicitud->empresa ?? null;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                    ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
                ///dias vigencia
                $fechaActual = Carbon::now()->startOfDay(); //trabajar solo fechas, sin horas
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
        // Busca la inspección y carga las relaciones necesarias
        $instalaciones = inspecciones::with(['solicitud.instalacion'])->find($request->id_inspeccion);

        // Verifica si la inspección y las relaciones existen
        if (!$instalaciones || !$instalaciones->solicitud || !$instalaciones->solicitud->instalacion) {
            return response()->json(['error' => 'No se encontró la instalación asociada a la inspección'], 404);
        }

        $validated = $request->validate([
            //$var->id_instalacion = $instalaciones->solicitud->instalacion->id_instalacion;
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'tipo_dictamen' => 'required|int',
            'num_dictamen' => 'required|string|max:40',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);
        // Crear un registro
        $new = new Dictamen_instalaciones();
        $new->id_instalacion = $instalaciones->solicitud->instalacion->id_instalacion;
        $new->id_inspeccion = $validated['id_inspeccion'];
        $new->tipo_dictamen = $validated['tipo_dictamen'];
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
        $eliminar = Dictamen_instalaciones::findOrFail($id_dictamen);
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
        $editar = Dictamen_instalaciones::findOrFail($id_dictamen);

        return response()->json([
            'id_dictamen' => $editar->id_dictamen,
            'id_inspeccion' => $editar->id_inspeccion,
            'tipo_dictamen' => $editar->tipo_dictamen,
            'num_dictamen' => $editar->num_dictamen,
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
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'tipo_dictamen' => 'required|int',
            'num_dictamen' => 'required|string|max:70',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);

        //carga las relaciones
        $instalaciones = inspecciones::with(['solicitud.instalacion'])->find($request->id_inspeccion);
        // Verifica si la relacione existen
        if (!$instalaciones || !$instalaciones->solicitud || !$instalaciones->solicitud->instalacion) {
            return response()->json(['error' => 'No se encontró la instalación asociada a la inspección'], 404);
        }
        // Obtener id_instalacion automáticamente desde la relación
        $id_instalacion = $instalaciones->solicitud->instalacion->id_instalacion ?? null;

        $actualizar = Dictamen_instalaciones::findOrFail($id_dictamen);
        $actualizar->update([// Actualizar
            'id_instalacion' => $id_instalacion,
            'id_inspeccion' => $validated['id_inspeccion'],
            'tipo_dictamen' => $validated['tipo_dictamen'],
            'num_dictamen' => $validated['num_dictamen'],
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
                'id_dictamen' => 'required|exists:dictamenes_instalaciones,id_dictamen',
                'id_inspeccion' => 'required|integer',
                'tipo_dictamen' => 'required|int',
                'num_dictamen' => 'required|string|min:8',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        //carga las relaciones
        $instalaciones = inspecciones::with(['solicitud.instalacion'])->find($request->id_inspeccion);
        // Verifica si la relacione existen
        if (!$instalaciones || !$instalaciones->solicitud || !$instalaciones->solicitud->instalacion) {
            return response()->json(['error' => 'No se encontró la instalación asociada a la inspección'], 404);
        }
        // Obtener id_instalacion automáticamente desde la relación
        $id_instalacion = $instalaciones->solicitud->instalacion->id_instalacion ?? null;
        $reexpedir = Dictamen_instalaciones::findOrFail($request->id_dictamen);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;//Actualiza solo 'observaciones'
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save();

            return response()->json(['message' => 'Cancelado correctamente.']);

        } else if ($request->accion_reexpedir == '2') {
            $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);
            // Validar que sea array, si no, inicializarlo
            /*if (!is_array($observacionesActuales)) {
                $observacionesActuales = [];
            }
            $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);*/
            $reexpedir->save();

            // Crear un nuevo registro de reexpedición
            $new = new Dictamen_instalaciones();
            $new->id_instalacion = $id_instalacion;
            $new->id_inspeccion = $request->id_inspeccion;
            $new->tipo_dictamen = $request->tipo_dictamen;
            $new->num_dictamen = $request->num_dictamen;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_dictamen]);
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



//PDF'S DICTAMEN DE INSTALACIONES
public function dictamen_productor($id_dictamen)
{
    $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);

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

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $firmaDigital = Helpers::firmarCadena($datos->num_dictamen . '|' . $datos->fecha_emision . '|' . $datos?->inspeccione?->num_servicio, 'Mejia2307', $datos->id_firmante);  // 9 es el ID del usuario en este ejemplo

    $watermarkText = $datos->estatus == 1;//Determinar si marca de agua es visible
    //Obtener un valor específico del JSON
    $id_sustituye = json_decode($datos->observaciones, true)//Decodifica el JSON actual
        ['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ?//verifica si la variable $id_sustituye tiene valor asociado
        //Busca el registro del certificado que tiene el id igual a $id_sustituye
        Dictamen_instalaciones::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';

    $pdf = Pdf::loadView('pdfs.dictamen_productor_ed10', [
        'datos' => $datos,
        'fecha_inspeccion' => $fecha_inspeccion,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,

        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64
    ])->setPaper('letter', 'portrait');

    return $pdf->stream($datos->num_dictamen .' Dictamen de cumplimiento de Instalaciones como productor.pdf');
}

public function dictamen_envasador($id_dictamen)
{
    $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);
    // URL que quieres codificar en el QR
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

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $firmaDigital = Helpers::firmarCadena($datos->num_dictamen . '|' . $datos->fecha_emision . '|' . $datos?->inspeccione?->num_servicio, 'Mejia2307', $datos->id_firmante);  // 9 es el ID del usuario en este ejemplo
    $watermarkText = $datos->estatus == 1;
    $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ? Dictamen_instalaciones::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';

    $pdf = Pdf::loadView('pdfs.dictamen_envasador_ed10', [
        'datos' => $datos,
        'fecha_inspeccion' => $fecha_inspeccion,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,

        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64
    ])->setPaper('letter', 'portrait');

    return $pdf->stream($datos->num_dictamen.' Dictamen de cumplimiento de Instalaciones como envasador.pdf');
}

public function dictamen_comercializador($id_dictamen)
{
    $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);
    // URL que quieres codificar en el QR
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

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $firmaDigital = Helpers::firmarCadena($datos->num_dictamen . '|' . $datos->fecha_emision . '|' . $datos?->inspeccione?->num_servicio, 'Mejia2307', $datos->id_firmante);  // 9 es el ID del usuario en este ejemplo
    $watermarkText = $datos->estatus == 1;
    $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ? Dictamen_instalaciones::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';

    $pdf = Pdf::loadView('pdfs.dictamen_comercializador_ed10', [
        'datos' => $datos,
        'fecha_inspeccion' => $fecha_inspeccion,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,

        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64
    ])->setPaper('letter', 'portrait');

    return $pdf->stream($datos->num_dictamen . ' Dictamen de cumplimiento de instalaciones como comercializador.pdf');
}

public function dictamen_almacen($id_dictamen)
{
    $datos = Dictamen_instalaciones::find($id_dictamen);

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

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $watermarkText = $datos->estatus == 1;
    $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ? Dictamen_instalaciones::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';

    // Solucion al problema de la cadena, como se guarda en la BD: ["Blanco o Joven","Reposado", "A\u00f1ejo"
    $categorias = json_decode($datos->categorias, true);
    $clases = json_decode($datos->clases, true);
    $firmaDigital = Helpers::firmarCadena($datos->num_dictamen . '|' . $datos->fecha_emision . '|' . $datos?->inspeccione?->num_servicio, 'Mejia2307', $datos->id_firmante);  // 9 es el ID del usuario en este ejemplo
    $pdf = Pdf::loadView('pdfs.dictamen_almacen_ed1', [
        'datos' => $datos,
        'fecha_inspeccion' => $fecha_inspeccion ?? '',
        'fecha_emision' => $fecha_emision ?? '',
        'fecha_vigencia' => $fecha_vigencia ?? '',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,

        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64
        ])->setPaper('letter', 'portrait');

    return $pdf->stream($datos->num_dictamen .' Dictamen de cumplimiento de Instalaciones almacén.pdf');
}

public function dictamen_maduracion($id_dictamen)
{
    $datos = Dictamen_instalaciones::find($id_dictamen);

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $watermarkText = $datos->estatus == 1;
    $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ? Dictamen_instalaciones::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';

    // Solucion al problema de la cadena, como se guarda en la BD: ["Blanco o Joven","Reposado", "A\u00f1ejo"
    $categorias = json_decode($datos->categorias, true);
    $clases = json_decode($datos->clases, true);

    $pdf = Pdf::loadView('pdfs.dictamen_maduracion_ed1', [
        'datos' => $datos,
        'fecha_inspeccion' => $fecha_inspeccion,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        'categorias' => $categorias,
        'clases' => $clases
    ]);

    return $pdf->stream('Dictamen de cumplimiento de Instalaciones del área de maduración.pdf');
}







}
