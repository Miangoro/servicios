<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\categorias;
use App\Models\clases;
use App\Models\inspecciones;
use App\Models\empresa;
use App\Models\Documentacion_url;
use App\Models\LotesGranel;
use App\Models\Dictamen_Granel;
use App\Models\CertificadosGranel;
use App\Models\tipos;
use App\Models\User;
///Extensiones
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\Storage;


class DictamenGranelController extends Controller  {


    public function UserManagement()
    {
        $inspecciones = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 3);
            })->orderBy('id_inspeccion', 'desc')->get();
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $inspectores = User::where('tipo', 2)->get(); // Obtener solo los usuarios con tipo '2' (inspectores)
        $lotesGranel = LotesGranel::all();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = tipos::all(); // Obtén todos los tipos de agave

        // Pasar los datos a la vista
        return view('dictamenes.find_dictamen_granel', compact('inspecciones', 'empresas', 'lotesGranel', 'inspectores','categorias','clases','tipos'));
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


    $query = Dictamen_Granel::query()
    ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_granel.id_inspeccion')
    ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
    ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
    ->select('dictamenes_granel.*', 'empresa.razon_social');

    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;
    $totalData = $baseQuery->count();// totalData (sin búsqueda)


    // Búsqueda Global
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('dictamenes_granel.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(dictamenes_granel.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    // Ordenamiento especial para num_dictamen con formato 'UMG-###'
    if ($orderColumn === 'num_dictamen') {
        $query->orderByRaw("
            CASE
                WHEN num_dictamen LIKE 'UMG-%/%' THEN 0
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
            $nestedData['num_dictamen'] = $dictamen->num_dictamen ?? 'No encontrado';
            $nestedData['estatus'] = $dictamen->estatus ?? 'No encontrado';
            $id_sustituye = json_decode($dictamen->observaciones, true) ['id_sustituye'] ?? null;
            $nestedData['sustituye'] = $id_sustituye ? Dictamen_Granel::find($id_sustituye)->num_dictamen ?? 'No encontrado' : null;
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
            $urls = $dictamen->inspeccione?->solicitud?->documentacion(69)?->pluck('url')?->toArray() ?? null;
            $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';

            ///caractetisticas->id_lote_granel->nombre_lote
            $nestedData['id_lote_granel'] = $dictamen->lote_granel->nombre_lote ?? 'N/A';
            $nestedData['folio_fq'] = $dictamen->lote_granel->folio_fq ?? 'N/A';


            $caracteristicasJson = $dictamen->inspeccione?->solicitud?->caracteristicas;
            $caracteristicas = $caracteristicasJson ? json_decode($caracteristicasJson, true) : [];

            $idLoteGranel = $caracteristicas['id_lote_granel'] ?? null;
    $loteGranel = null;
    $nombreLote = 'No encontrado';
    $folioFq = null;

    if (!empty($idLoteGranel)) {
        $loteGranel = LotesGranel::find($idLoteGranel);
        if ($loteGranel) {
            $nombreLote = $loteGranel->nombre_lote;
            $folioFq = $loteGranel->folio_fq;
        }
    }
    $nestedData['nombre_lote'] = $nombreLote;

            /*$loteGranel = LotesGranel::find($idLoteGranel); // Busca el lote a granel
            $nestedData['nombre_lote'] = $loteGranel ? $loteGranel->nombre_lote : 'No encontrado';
            $folioFq = $loteGranel?->folio_fq ?? null;*/

            //$folioFq = $loteGranel?->folio_fq ?? null;

            if ($folioFq) {
                // Separa por coma y elimina espacios alrededor de cada folio
                $folios = array_filter(array_map('trim', explode(',', $folioFq))); // array_filter elimina vacíos

                // Si hay más de uno, únelos con coma; si no, usa el primero o 'N/A'
                $formatoFolios = count($folios) > 0 ? implode(', ', $folios) : 'N/A';

                // Obtener el segundo folio si existe
                $segundoFolio = $folios[1] ?? 'N/A';
            } else {
                $formatoFolios = 'N/A';
                $segundoFolio = 'N/A';
            }

            // Ejemplo de asignación
            $nestedData['analisis'] = $formatoFolios;
            // o solo segundo si quieres:
            // $nestedData['analisis'] = $segundoFolio;




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
    ]);

        // Crear una nuevo registro
        $new = new Dictamen_Granel();
        $new->num_dictamen = $validated['num_dictamen'];
        $new->id_inspeccion = $validated['id_inspeccion'];
        $new->fecha_emision = $validated['fecha_emision'];
        $new->fecha_vigencia = $validated['fecha_vigencia'];
        $new->id_firmante = $validated['id_firmante'];
        $new->save();

        $inspeccion = Inspecciones::with('solicitud.lote_granel')->find($new->id_inspeccion);

        $id_lote_granel = null;
        if ($inspeccion && $inspeccion->solicitud && $inspeccion->solicitud->lote_granel) {
            $id_lote_granel = $inspeccion->solicitud->lote_granel->id_lote_granel;
            $lote = LotesGranel::find($id_lote_granel);
            $lote->nombre_lote = $request->nombre_lote;
            $lote->folio_fq = rtrim($request->folio_fq, ', ');
            $lote->volumen = $request->volumen;
            $lote->cont_alc = $request->cont_alc;
            $lote->edad = $request->edad;
            $lote->ingredientes = $request->ingredientes;
            $lote->id_categoria = $request->id_categoria;
            $lote->id_clase = $request->id_clase;
            $lote->id_tipo = json_encode($request->id_tipo); 
            $lote->save(); 

            $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            $documentos = [
                'analisis_completo' => [
                    'nombre_documento' => 'Análisis fisicoquímicos',
                    'id_documento' => 58,
                    'prefijo' => 'analisis_fisicoquimicos_'
                ],
                'analisis_ajuste' => [
                    'nombre_documento' => 'Fisicoquímicos de ajuste de grado',
                    'id_documento' => 134,
                    'prefijo' => 'analisis_fisicoquimicos_ajuste_'
                ]
            ];

            foreach ($documentos as $inputName => $info) {
                $file = $request->file($inputName);

                if ($file) {
                    $filename = $info['prefijo'] . uniqid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs("uploads/{$numeroCliente}/fqs", $filename, 'public');

                    $documentacion_url = Documentacion_url::where('id_relacion', $id_lote_granel)
                        ->where('id_documento', $info['id_documento'])
                        ->first();

                    if ($documentacion_url) {
                        $oldPath = "uploads/{$numeroCliente}/fqs/" . $documentacion_url->url;
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    } else {
                        $documentacion_url = new Documentacion_url([
                            'id_relacion' => $id_lote_granel,
                            'id_documento' => $info['id_documento'],
                            'id_empresa' => $lote->id_empresa
                        ]);
                    }

                    $documentacion_url->nombre_documento = $info['nombre_documento'];
                    $documentacion_url->url = $filename;
                    $documentacion_url->save();
                }
            }



        }



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
        $eliminar = Dictamen_Granel::findOrFail($id_dictamen);
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
        // Cargar el dictamen específico
        $editar = Dictamen_Granel::findOrFail($id_dictamen);

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
        $validated = $request->validate([
            'num_dictamen' => 'required|string|max:70',
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);

        $actualizar = Dictamen_Granel::findOrFail($id_dictamen);
        $actualizar->update([// Actualizar
            'num_dictamen' => $validated['num_dictamen'],
            'id_inspeccion' => $validated['id_inspeccion'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_firmante' => $validated['id_firmante'],
        ]);

        $inspeccion = Inspecciones::with('solicitud.lote_granel')->find($validated['id_inspeccion']);

        $id_lote_granel = null;
        if ($inspeccion && $inspeccion->solicitud && $inspeccion->solicitud->lote_granel) {
            $id_lote_granel = $inspeccion->solicitud->lote_granel->id_lote_granel;
            $lote = LotesGranel::find($id_lote_granel);
            $lote->nombre_lote = $request->nombre_lote;
            $lote->folio_fq = rtrim($request->folio_fq, ', ');
            $lote->volumen = $request->volumen;
            $lote->cont_alc = $request->cont_alc;
            $lote->edad = $request->edad;
            $lote->ingredientes = $request->ingredientes;
            $lote->id_categoria = $request->id_categoria;
            $lote->id_clase = $request->id_clase;
            $lote->id_tipo = json_encode($request->id_tipo); 
            $lote->save(); 

            $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            $documentos = [
                'analisis_completo' => [
                    'nombre_documento' => 'Análisis fisicoquímicos',
                    'id_documento' => 58,
                    'prefijo' => 'analisis_fisicoquimicos_'
                ],
                'analisis_ajuste' => [
                    'nombre_documento' => 'Fisicoquímicos de ajuste de grado',
                    'id_documento' => 134,
                    'prefijo' => 'analisis_fisicoquimicos_ajuste_'
                ]
            ];

            foreach ($documentos as $inputName => $info) {
                $file = $request->file($inputName);

                if ($file) {
                    $filename = $info['prefijo'] . uniqid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs("uploads/{$numeroCliente}/fqs", $filename, 'public');

                    $documentacion_url = Documentacion_url::where('id_relacion', $id_lote_granel)
                        ->where('id_documento', $info['id_documento'])
                        ->first();

                    if ($documentacion_url) {
                        $oldPath = "uploads/{$numeroCliente}/fqs/" . $documentacion_url->url;
                        if (Storage::disk('public')->exists($oldPath)) {
                            Storage::disk('public')->delete($oldPath);
                        }
                    } else {
                        $documentacion_url = new Documentacion_url([
                            'id_relacion' => $id_lote_granel,
                            'id_documento' => $info['id_documento'],
                            'id_empresa' => $lote->id_empresa
                        ]);
                    }

                    $documentacion_url->nombre_documento = $info['nombre_documento'];
                    $documentacion_url->url = $filename;
                    $documentacion_url->save();
                }
            }
        }

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
                'id_dictamen' => 'required|exists:dictamenes_granel,id_dictamen',
                'id_inspeccion' => 'required|integer',
                'num_dictamen' => 'required|string|min:8',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $reexpedir = Dictamen_Granel::findOrFail($request->id_dictamen);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);//Decodifica el JSON actual
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

            // Crear un nuevo registro de reexpedición
            $new = new Dictamen_Granel();
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
public function MostrarDictamenGranel($id_dictamen)
{
    // Obtener los datos del dictamen específico
    $data = Dictamen_Granel::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
    }

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
    $firmaDigital = Helpers::firmarCadena($data->num_dictamen . '|' . $data->fecha_emision . '|' . $data->inspeccione?->num_servicio, $pass, $data->id_firmante);  // 9 es el ID del usuario en este ejemplo

    $fecha_emision = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->inspeccione->fecha_servicio);
    $watermarkText = $data->estatus == 1;
    $id_sustituye = json_decode($data->observaciones, true)['id_sustituye'] ?? null;
    $nombre_id_sustituye = $id_sustituye ? Dictamen_Granel::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';
    //origen
    if ( empty($data->inspeccione->solicitud->lote_granel->lote_original_id) ){
        $estado = $data->inspeccione->solicitud->instalacion->estados->nombre ?? 'NA';
    }else{
        //$estado = $certificado->dictamen->inspeccione->solicitud->lote_granel->lote_original_id->lotes;
        $id_lote = json_decode($data->inspeccione->solicitud->lote_granel->lote_original_id, true);
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

    $pdf = Pdf::loadView('pdfs.dictamen_granel_ed7', [
        'data' => $data,
        'estado' => $estado,
        'fecha_servicio' => $fecha_servicio,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64
    ]);

    return $pdf->stream('Dictamen de Cumplimiento NOM Mezcal a Granel F-UV-04-16.pdf');
}

/*
///FQ'S
public function foliofq($id_dictamen)
{
    try {
        Log::info('ID del Dictamen: ' . $id_dictamen);

        // Buscar el dictamen
        $dictamen = Dictamen_Granel::find($id_dictamen);
        if (!$dictamen) {
            Log::error('Registro no encontrado para el ID: ' . $id_dictamen);
            return response()->json(['success' => false, 'message' => 'No encontrado'], 404);
        }

        // Buscar el lote a granel asociado con el dictamen
        $lote = LotesGranel::find($dictamen->id_lote_granel);
        if (!$lote) {
            Log::error('Registro no encontrado para el ID: ' . $dictamen->id_lote_granel);
            return response()->json(['success' => false, 'message' => 'No encontrado'], 404);
        }

        Log::info('Registro no encontrado: ' . $lote->nombre_lote);

        // Obtener los documentos asociados al lote a granel
        $documentos = Documentacion_url::where('id_relacion', $lote->id_lote_granel)->get();
        Log::info('Documentos obtenidos: ', $documentos->toArray());

        // Mapear documentos con URL
        $documentosConUrl = $documentos->map(function ($documento) {
            return [
                'id_documento' => $documento->id_documento,
                'nombre' => $documento->nombre_documento,
                'url' => $documento->url,
                'tipo' => $documento->nombre_documento
            ];
        });

        // Obtener la empresa asociada
        $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
        if (!$empresa) {
            Log::error('Registro no encontrado para el ID: ' . $lote->id_empresa);
            return response()->json(['success' => false, 'message' => 'No encontrado'], 404);
        }

        Log::info('Registro encontrado: ' . $empresa->nombre_empresa);

        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

        // Obtener la URL del archivo para "otro organismo"
        // Corregido
        $documentoOtroOrganismo = $documentos->firstWhere('tipo', 'Certificado de lote a granel:  - ');
        $archivoUrlOtroOrganismo = $lote->tipo_lote == '2' && $documentoOtroOrganismo ? $documentoOtroOrganismo['url'] : '';

        Log::info('Archivo URL Otro Organismo: ' . $archivoUrlOtroOrganismo);

        return response()->json([
            'success' => true,
            'lote' => $lote,
            'documentos' => $documentosConUrl,
            'numeroCliente' => $numeroCliente,
            'archivo_url_otro_organismo' => $archivoUrlOtroOrganismo
        ]);
        //} catch (ModelNotFoundException $e) {
    } catch (\Exception $e) {
        Log::error('Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error en la solicitud'], 500);
    } catch (\Exception $e) {
        Log::error('Error inesperado: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error inesperado'], 500);
    }
}
*/

    public function getDatosLotes($id_inspeccion)
    {

        $datos = inspecciones::with('solicitud.lote_granel.fqs','solicitud.empresa.empresaNumClientes')->find($id_inspeccion);
        return response()->json($datos); // Retorna en formato JSON
    }



}//end-classController
