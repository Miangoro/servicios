<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\inspecciones;
use App\Models\User;
use App\Models\empresa;
use App\Models\lotes_envasado;
use App\Models\Dictamen_Envasado;
use App\Models\marcas;
use App\Models\LotesGranel;
use App\Models\solicitudesModel;
///Extensiones
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use Illuminate\Support\Facades\Storage;


class DictamenEnvasadoController extends Controller
{

    public function UserManagement()
    {
        $inspecciones = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 5)->orwhere('id_tipo',8);
            })->orderBy('id_inspeccion', 'desc')->get();
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $inspectores = User::where('tipo', 2)->get(); // Obtener solo los usuarios con tipo '2' (inspectores)
        $marcas = marcas::all(); // Obtener todas las marcas
        $lotes_granel = LotesGranel::all();
        $envasado = lotes_envasado::all(); // Usa la clase correcta

        // Pasar los datos a la vista
        return view('dictamenes.find_dictamen_envasado', compact('inspecciones', 'empresas', 'envasado', 'inspectores',  'marcas', 'lotes_granel'));
    }


public function index(Request $request)
{
    $empresaId = null;
    if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaId = Auth::user()->empresa?->id_empresa;
    }

    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses
    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        1 => 'num_dictamen',
        2 => 'folio',
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


    $query = Dictamen_Envasado::query()
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_envasado.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->leftJoin('lotes_envasado', 'lotes_envasado.id_lote_envasado', '=', 'dictamenes_envasado.id_lote_envasado')
        ->leftJoin('lotes_envasado_granel', 'lotes_envasado_granel.id_lote_envasado', '=', 'lotes_envasado.id_lote_envasado')
        ->leftJoin('lotes_granel', 'lotes_granel.id_lote_granel', '=', 'lotes_envasado_granel.id_lote_granel')
        ->select('dictamenes_envasado.*', 'empresa.razon_social');

    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;
    $totalData = $baseQuery->count();// totalData (sin búsqueda)


    // Búsqueda Global
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('dictamenes_envasado.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(dictamenes_envasado.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"])
            ->orWhere('lotes_envasado.nombre', 'LIKE', "%{$search}%")
            ->orWhere('lotes_granel.nombre_lote', 'LIKE', "%{$search}%");
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    // Ordenamiento especial para num_dictamen con formato 'UME-###'
    if ($orderColumn === 'num_dictamen') {
        $query->orderByRaw("
            CASE
                WHEN num_dictamen LIKE 'UME-%/%' THEN 0
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
            'inspeccion',// Relación directa
            'inspeccion.solicitud',// Relación anidada: inspeccione > solicitu
            'inspeccion.solicitud.empresa',
            'inspeccion.solicitud.empresa.empresaNumClientes',
        ])->offset($start)->limit($limit)->get();



    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($dictamenes)) {
        foreach ($dictamenes as $dictamen) {
            $nestedData['id_dictamen_envasado'] = $dictamen->id_dictamen_envasado ?? 'No encontrado';
            $nestedData['num_dictamen'] = $dictamen->num_dictamen ?? 'No encontrado';
            $nestedData['estatus'] = $dictamen->estatus ?? 'No encontrado';
            $id_sustituye = json_decode($dictamen->observaciones, true) ['id_sustituye'] ?? null;
            $nestedData['sustituye'] = $id_sustituye ? Dictamen_envasado::find($id_sustituye)->num_dictamen ?? 'No encontrado' : null;
            $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
            $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
            $nestedData['num_servicio'] = $dictamen->inspeccion->num_servicio ?? 'No encontrado';
            $nestedData['folio_solicitud'] = $dictamen->inspeccion->solicitud->folio ?? 'No encontrado';
            $nestedData['fecha_servicio'] = Helpers::formatearFecha($dictamen->fecha_servicio);
            //$nestedData['id_lote_envasado'] = $dictamen->lote_envasado->nombre_lote ?? 'No encontrado';
            $nestedData['lote_envasado'] = $dictamen->lote_envasado->nombre ?? 'No encontrado';
            $nestedData['lote_granel'] = $dictamen->lote_envasado->lotesGranel->first()->nombre_lote ?? 'No encontrado';
            $nestedData['folio_fq'] = $dictamen->lote_envasado->lotesGranel->first()->folio_fq ?? 'No encontrado';
            $nestedData['tipo_maguey'] = $dictamen->lote_envasado->lotesGranel->first()?->tiposRelacionados
                ?->map(fn($t) => $t->nombre.' ('.$t->cientifico.')')->implode(', ') ?? 'No encontrado';
            $nestedData['marca'] = $dictamen->lote_envasado->marca->marca ?? 'No encontrado';
            $nestedData['presentacion'] =
                ($dictamen->lote_envasado->presentacion ?? 'No encontrado') . ' ' .
                ($dictamen->lote_envasado->unidad ?? 'No encontrado');
            $nestedData['sku'] = json_decode($dictamen->lote_envasado->sku, true)['inicial'] ?? 'No encontrado';
            ///numero y nombre empresa
            $empresa = $dictamen->inspeccion->solicitud->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
            $nestedData['numero_cliente'] = $numero_cliente;
            $nestedData['razon_social'] = $dictamen->inspeccion->solicitud->empresa->razon_social ?? 'No encontrado';
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
            $nestedData['id_solicitud'] = $dictamen->inspeccion->solicitud->id_solicitud ?? 'No encontrado';
            $urls = $dictamen->inspeccion?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
            $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';


            $data[] = $nestedData;
        }
    }

    return response()->json([//Devuelve los datos y el total de registros filtrados
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

            'nombre_lote' => 'nullable|string',
            'cant_botellas' => 'nullable|numeric',
            'presentacion' => 'nullable|string',
            'unidad' => 'nullable|string',
            'volumen_total' => 'nullable|numeric',
            'id_marca' => 'nullable|exists:marcas,id_marca',
        ]);

        $inspeccion = inspecciones::find($validated['id_inspeccion']);

        if (!$inspeccion || !$inspeccion->solicitud || !$inspeccion->solicitud->lote_envasado) {
            return response()->json(['error' => 'No se encontró el lote asociado a la solicitud'], 404);
        }

        $lote = $inspeccion->solicitud->lote_envasado;

        // Guardar el dictamen
        $dictamen = new Dictamen_Envasado();
        $dictamen->id_lote_envasado = $lote->id_lote_envasado;
        $dictamen->id_inspeccion = $validated['id_inspeccion'];
        $dictamen->num_dictamen = $validated['num_dictamen'];
        $dictamen->fecha_emision = $validated['fecha_emision'];
        $dictamen->fecha_vigencia = $validated['fecha_vigencia'];
        $dictamen->id_firmante = $validated['id_firmante'];
        $dictamen->save();

        // Actualizar datos del lote
        $lote->nombre = $validated['nombre_lote'] ?? $lote->nombre;
        $lote->cant_botellas = $validated['cant_botellas'] ?? $lote->cant_botellas;
        $lote->presentacion = $validated['presentacion'] ?? $lote->presentacion;
        $lote->unidad = $validated['unidad'] ?? $lote->unidad;
        $lote->volumen_total = $validated['volumen_total'] ?? $lote->volumen_total;
        $lote->id_marca = $validated['id_marca'] ?? $lote->id_marca;
        $lote->save();

        return response()->json(['message' => 'Dictamen registrado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al registrar dictamen', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al registrar.'], 500);
    }
}



///FUNCION ELIMINAR
public function destroy($id_dictamen_envasado)
{
    try {
        $eliminar = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
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
public function edit($id_dictamen_envasado)
{
    try {
        $editar = Dictamen_Envasado::findOrFail($id_dictamen_envasado);

        return response()->json([
            'id_dictamen' => $editar->id_dictamen_envasado,
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
public function update(Request $request, $id_dictamen_envasado)
{
    try {
        $validated = $request->validate([
            'num_dictamen' => 'required|string|max:70',
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',

            'nombre_lote' => 'nullable|string',
            'cant_botellas' => 'nullable|numeric',
            'presentacion' => 'nullable|string',
            'unidad' => 'nullable|string',
            'volumen_total' => 'nullable|numeric',
            'id_marca' => 'nullable|exists:marcas,id_marca',
        ]);

               $inspeccion = inspecciones::find($validated['id_inspeccion']);

        if (!$inspeccion || !$inspeccion->solicitud || !$inspeccion->solicitud->lote_envasado) {
            return response()->json(['error' => 'No se encontró el lote asociado a la solicitud'], 404);
        }

        $lote = $inspeccion->solicitud->lote_envasado;

        // Actualizar dictamen
        $dictamen = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
        $dictamen->id_lote_envasado = $lote->id_lote_envasado;
        $dictamen->num_dictamen = $validated['num_dictamen'];
        $dictamen->id_inspeccion = $validated['id_inspeccion'];
        $dictamen->fecha_emision = $validated['fecha_emision'];
        $dictamen->fecha_vigencia = $validated['fecha_vigencia'];
        $dictamen->id_firmante = $validated['id_firmante'];
        $dictamen->save();

        // Actualizar campos opcionales del lote si vienen
        $lote->nombre = $validated['nombre_lote'] ?? $lote->nombre;
        $lote->cant_botellas = $validated['cant_botellas'] ?? $lote->cant_botellas;
        $lote->presentacion = $validated['presentacion'] ?? $lote->presentacion;
        $lote->unidad = $validated['unidad'] ?? $lote->unidad;
        $lote->volumen_total = $validated['volumen_total'] ?? $lote->volumen_total;
        $lote->id_marca = $validated['id_marca'] ?? $lote->id_marca;
        $lote->save();

        return response()->json(['message' => 'Actualizado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al actualizar dictamen', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al actualizar.'], 500);
    }
}



///FUNCION REEXPEDIR
public function reexpedir(Request $request)
{
    //try {
        $request->validate([
            'accion_reexpedir' => 'required|in:1,2',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->accion_reexpedir == '2') {
            $request->validate([
                'id_dictamen_envasado' => 'required|exists:dictamenes_envasado,id_dictamen_envasado',
                'id_inspeccion' => 'required|integer',
                'num_dictamen' => 'required|string|min:8',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $reexpedir = Dictamen_Envasado::findOrFail($request->id_dictamen_envasado);

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
            $reexpedir->save();

        // Busca la inspección y carga la relacion con modelo inspeccion->solicitud
        $inspeccion = inspecciones::find($request->validate['id_inspeccion']);
        // Obtener el lote directamente
        $id_lote_envasado = $inspeccion->solicitud->lote_envasado->id_lote_envasado;
        if (!$id_lote_envasado) {
            return response()->json(['error' => 'No se encontró el lote asociado a la solicitud'], 404);
        }

            // Crear un nuevo registro de reexpedición
            $new = new Dictamen_Envasado();
            $new->id_lote_envasado = $id_lote_envasado;
            $new->num_dictamen = $request->num_dictamen;
            $new->id_inspeccion = $request->id_inspeccion;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_dictamen_envasado]);
            $new->save();

            return response()->json(['message' => 'Registrado correctamente.']);
        }

        return response()->json(['message' => 'Procesado correctamente.']);
    /*} catch (\Exception $e) {
        Log::error('Error al reexpedir', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al procesar.'], 500);
    }*/
}



///PDF DICTAMEN
public function MostrarDictamenEnvasado($id_dictamen)
{
    // Obtener los datos del dictamen con la relación de lotes a granel
    $data = Dictamen_Envasado::with(['lote_envasado.lotesGranel'])->find($id_dictamen);

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
    $firmaDigital = Helpers::firmarCadena($data->num_dictamen . '|' . $data->fecha_emision . '|' . $data->inspeccion?->num_servicio, $pass, $data->id_firmante);

    $loteEnvasado = $data->lote_envasado ?? null;
    $marca = $loteEnvasado ? $loteEnvasado->marca : null;
    $lotesGranel = $loteEnvasado ? $loteEnvasado->lotesGranel : collect(); // Si no hay, devuelve una colección vacía
    $fecha_emision = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->inspeccion?->fecha_servicio);
    $watermarkText = $data->estatus == 1;
    $id_sustituye = json_decode($data->observaciones, true)['id_sustituye'] ?? null;
    $nombre_id_sustituye = $id_sustituye ? Dictamen_Envasado::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';


    // Renderizar el PDF con los lotes a granel
    //$pdf = Pdf::loadView('pdfs.dictamen_envasado_ed6', [
    $pdf = [
        'data' => $data,
        'lote_envasado' => $loteEnvasado,
        'marca' => $marca,
        'lotesGranel' => $lotesGranel,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'fecha_servicio' => $fecha_servicio ?? '',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64
    ];

    if ($data->fecha_emision >= "2024-12-10") {
        $edicion = 'pdfs.dictamen_envasado_ed7';
    }else{
        $edicion = 'pdfs.dictamen_envasado_ed6';
    }
    //return $pdf->stream('F-UV-04-17 Ver 6 Dictamen de Cumplimiento NOM de Mezcal Envasado.pdf');
    return Pdf::loadView($edicion, $pdf)->stream('Dictamen de Cumplimiento NOM de Mezcal Envasado F-UV-04-17.pdf');

}


    public function getDatosLotesEnv($id_inspeccion)
    {
        $inspeccion = inspecciones::with('solicitud.empresa.empresaNumClientes')->find($id_inspeccion);
        $solicitud = $inspeccion->solicitud;

       /* $marcas = marcas::where('id_empresa', $solicitud->id_empresa)->get(); cambio este */
       /* por este */
        $marcas = $solicitud->empresa->todasLasMarcas()->get();

        $lote = $solicitud->lote_envasado;

        return response()->json([
            'inspeccion' => $inspeccion,
            'solicitud' => $solicitud,
            'lote_envasado' => $lote,
            'marcas' => $marcas,
        ]);
    }



}
