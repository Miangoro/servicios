<?php

namespace App\Http\Controllers\inspecciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Documentacion_url;
use App\Models\instalaciones;
use App\Models\empresa;
use App\Models\estados;
use App\Models\actas_inspeccion;
use App\Models\actas_testigo;
use App\Models\actas_produccion;
use App\Models\actas_equipo_mezcal;
use App\Models\actas_equipo_envasado;
use App\Models\acta_produccion_mezcal;
use App\Models\actas_unidad_comercializacion;
use App\Models\actas_unidad_envasado;
use App\Models\Predios;
use App\Models\tipos;
use App\Models\equipos;
use App\Models\solicitudTipo;

use App\Models\Organismos;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;
use App\Models\inspecciones;
use App\Models\solicitudesModel;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
/* clases de exportacion */
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SolicitudesExport;
use App\Exports\InspeccionesExport;


class inspeccionesController extends Controller
{
    public function UserManagement()
    {
        $solicitudesTipos = solicitudTipo::all();
        $instalaciones = instalaciones::all(); // Obtener todas las instalaciones
        $Predios = Predios::all(); // Obtener todas las instalaciones
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = estados::all(); // Obtener todos los estados
        $tipos = tipos::all(); // Obtener todos los estados
        $equipos = equipos::all(); // Obtener todos los estados
        $todasSolicitudes = solicitudesModel::select('id_solicitud', 'folio')
    ->whereYear('fecha_solicitud', '>=', 2025)
    ->orderBy('id_solicitud', 'desc')
    ->get();

      $solcitudesSinInspeccion = solicitudesModel::whereDoesntHave('inspeccion')
          ->whereYear('fecha_solicitud', '>=', 2025)
          ->orderBy('id_solicitud', 'desc')
          ->get();


        $inspectores = User::where('tipo', '=', '2')->get(); // Obtener todos los organismos
        return view('inspecciones.find_inspecciones_view', compact('solicitudesTipos','instalaciones', 'empresas', 'estados', 'inspectores', 'Predios', 'tipos', 'equipos','todasSolicitudes', 'solcitudesSinInspeccion'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_solicitud',
            2 => 'folio',
            3 => 'num_servicio',
            4 => 'razon_social',
            5 => '',//fecha_solicitud
            6 => 'tipo',
            7 => 'direccion_completa',
            8 => 'inspector',
            9 => 'fecha_servicio',
            10 => 'fecha_visita',
            11 => 'name',
            12 => 'id_inspeccion',
            13 => 'id_empresa',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderColumn = $columns[$orderIndex] ?? 'id_solicitud';
        $dir = $request->input('order.0.dir', 'asc');
        $search = $request->input('search.value');

        $query = solicitudesModel::with('tipo_solicitud', 'empresa', 'inspeccion', 'inspector', 'instalacion');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id_solicitud', 'LIKE', "%{$search}%")
                    ->orWhere('folio', 'LIKE', "%{$search}%")
                    ->orWhereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('inspeccion', function ($q) use ($search) {
                        $q->where('num_servicio', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('tipo_solicitud', function ($q) use ($search) {
                        $q->where('tipo', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('inspector', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        $totalData = solicitudesModel::count();
        $totalFiltered = $query->count();

        // Obtener datos paginados sin orden
        $solicitudes = $query->get();

        // Ordenar manualmente si es un campo de relación
        if ($orderColumn === 'folio') {
            // Ordenar por la parte numérica del folio "SOL-#####"
            $solicitudes = $solicitudes->sortBy(function ($item) {
                // Extraemos el número, asumiendo formato 'SOL-#####'
                return intval(substr($item->folio, 4));
            }, SORT_NUMERIC, $dir === 'desc');

        } elseif (in_array($orderColumn, ['num_servicio', 'razon_social', 'tipo', 'name'])) {
            $solicitudes = $solicitudes->sortBy(function ($item) use ($orderColumn) {
                switch ($orderColumn) {
                    case 'num_servicio':
                        return $item->inspeccion->num_servicio ?? '';
                    case 'razon_social':
                        return $item->empresa->razon_social ?? '';
                    case 'tipo':
                        return $item->tipo_solicitud->tipo ?? '';
                    case 'name':
                        return $item->inspector->name ?? '';
                }
            }, SORT_REGULAR, $dir === 'desc');

        } else {
            // Ordenar campos propios del modelo
            $solicitudes = $solicitudes->sortBy($orderColumn, SORT_REGULAR, $dir === 'desc');
        }

        // Paginar manualmente
        $solicitudes = $solicitudes->slice($start, $limit)->values();





        $data = [];

        if (!empty($solicitudes)) {
            $ids = $start;

            foreach ($solicitudes as $solicitud) {
                $empresa = $solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                    : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['id_inspeccion'] = $solicitud->inspeccion->id_inspeccion ?? '0';
                $nestedData['id_empresa'] = $solicitud->empresa->id_empresa ?? '0';
                $nestedData['id_solicitud'] = $solicitud->id_solicitud ?? 'N/A';
                $nestedData['id_acta'] = $solicitud->inspeccion->actas_inspeccion->id_acta ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $nestedData['folio'] = '<b class="text-primary">' . $solicitud->folio . '</b>';
                $nestedData['folio_info'] = $solicitud->folio;
                $nestedData['num_servicio_info'] = $solicitud->inspeccion->num_servicio ?? 'Sin asignar';
                $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? 'Sin asignar';
                $nestedData['razon_social'] = $solicitud->empresa->razon_social  ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud)  ?? 'N/A';
                $nestedData['tipo'] = $solicitud->tipo_solicitud->tipo  ?? 'N/A';
                $nestedData['direccion_completa'] = $solicitud->instalacion->direccion_completa  ?? 'N/A';
                $nestedData['tipo_instalacion'] = $solicitud->instalacion->tipo  ?? '';
                $nestedData['fecha_visita'] = Helpers::formatearFechaHora($solicitud->fecha_visita)  ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['inspector'] = $solicitud->inspector->name ?? '<span class="badge bg-danger">Sin asignar</span>'; // Maneja el caso donde el organismo sea nulo
                $nestedData['inspectorName'] = $solicitud->inspector->name ?? 'Sin inspector';
                $nestedData['foto_inspector'] = $solicitud->inspector->profile_photo_path ?? '';
                $nestedData['id_tipo'] = $solicitud->tipo_solicitud->id_tipo ?? 'N/A';

                $nestedData['fecha_servicio'] = $nestedData['fecha_servicio'] = $solicitud->inspeccion && $solicitud->inspeccion->fecha_servicio
                    ? Helpers::formatearFechaHora($solicitud->inspeccion->fecha_servicio)
                    : '<span class="badge bg-danger">Sin asignar</span>';

                $urls = $solicitud->documentacion(69)->pluck('url')->toArray();
                if ($solicitud->inspeccion?->dictamen) {
                    switch ($solicitud->inspeccion->dictamen->tipo_dictamen) {
                        case 1:
                            $tipo_dictamen = 'dictamen_productor';
                            break;
                        case 2:
                            $tipo_dictamen = 'dictamen_envasador';
                            break;
                        case 3:
                            $tipo_dictamen = 'dictamen_comercializador';
                            break;
                        case 4:
                            $tipo_dictamen = 'dictamen_almacen';
                            break;
                        default:
                            $tipo_dictamen = 'Sin tipo';
                            break;
                    }
                    $id = $solicitud->inspeccion->dictamen->id_dictamen;
                } elseif ($solicitud->inspeccion?->dictamenGranel) {
                    $tipo_dictamen = 'dictamen_granel';
                    $id = $solicitud->inspeccion->dictamenGranel->id_dictamen;
                } elseif ($solicitud->inspeccion?->dictamenEnvasado) {
                    $tipo_dictamen = 'dictamen_envasado';
                    $id = $solicitud->inspeccion->dictamenEnvasado->id_dictamen_envasado;
                }elseif ($solicitud->inspeccion?->dictamenExportacion) {
                    $tipo_dictamen = 'dictamen_exportacion';
                    $id = $solicitud->inspeccion->dictamenExportacion->id_dictamen;
                } else {
                    $tipo_dictamen = null;
                    $id = null;
                }

                $nestedData['url_dictamen'] = $id ? $tipo_dictamen . '/' . $id : 'Sin subir';



                // Comprobamos si $urls está vacío
                if (empty($urls)) {
                    // Si está vacío, asignamos la etiqueta de "Sin subir"
                    $nestedData['url_acta'] = 'Sin subir';
                } else {
                    // Si hay URLs, las unimos en una cadena separada por comas
                    $nestedData['url_acta'] = implode(', ', $urls);
                }





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

    public function destroy($id_instalacion)
    {
        try {
            $instalacion = instalaciones::findOrFail($id_instalacion);
            $instalacion->delete();

            return response()->json(['success' => 'Instalación eliminada correctamente']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Instalación no encontrada'], 404);
        }
    }


    public function edit($id_instalacion)
    {
        try {
            // Obtener la instalación y sus documentos asociados
            $instalacion = instalaciones::findOrFail($id_instalacion);

            // Obtener los documentos asociados
            $documentacion_urls = Documentacion_url::where('id_relacion', $id_instalacion)->get();

            // Extraer la URL del primer documento, si existe
            $archivo_url = $documentacion_urls->isNotEmpty() ? $documentacion_urls->first()->url : '';

            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $instalacion->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

            return response()->json([
                'success' => true,
                'instalacion' => $instalacion,
                'archivo_url' => $archivo_url, // Incluir la URL del archivo
                'numeroCliente' => $numeroCliente
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false], 404);
        }
    }

public function asignarInspector(Request $request)
{
    try {
        // Validar datos
        $request->validate([
            'id_solicitud' => 'required|integer',
            'id_inspector' => 'required|integer|exists:users,id',
            'num_servicio' => 'required|string',
            'fecha_servicio' => 'required|date',
            'observaciones' => 'nullable|string',
            'solInspecciones' => 'nullable|array'
        ]);

        // Inspección principal
        inspecciones::updateOrCreate(
            ['id_solicitud' => $request->id_solicitud],
            [
                'id_inspector' => $request->id_inspector,
                'num_servicio' => $request->num_servicio,
                'fecha_servicio' => $request->fecha_servicio,
                'estatus_inspeccion' => 1,
                'observaciones' => $request->observaciones ?? '',
            ]
        );

        // Aplicar la misma inspección a solicitudes adicionales
        $solicitudesAdicionales = $request->solInspecciones ?? [];

        foreach ($solicitudesAdicionales as $idAdicional) {
            inspecciones::updateOrCreate(
                ['id_solicitud' => $idAdicional],
                [
                    'id_inspector' => $request->id_inspector,
                    'num_servicio' => $request->num_servicio,
                    'fecha_servicio' => $request->fecha_servicio,
                    'estatus_inspeccion' => 1,
                    'observaciones' => $request->observaciones ?? '',
                ]
            );
        }

        // Notificar al inspector
        $users = User::whereIn('id', [$request->id_inspector])->get();

        $data1 = [
            'title' => 'Nueva inspección',
            'message' => 'Se te asignó la inspección ' . $request->num_servicio,
            'url' => 'inspecciones',
        ];

        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }

        return response()->json([
            'success' => true,
            'message' => 'Inspector asignado correctamente.'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Errores de validación.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}





    //Pdfs de inspecciones
    public function pdf_oficio_comision($id_inspeccion)
    {

        $datos = inspecciones::with(['inspector', 'solicitud.instalacion', 'solicitud.tipo_solicitud'])->find($id_inspeccion);

        $fecha_servicio = !empty($datos->fecha_servicio)
            ? Helpers::formatearFecha($datos->fecha_servicio)
            : null;

        if (Str::endsWith($datos?->solicitud?->folio, '-O')) {
            $id_inspector = User::find(6);
        } else {
            $id_inspector = User::find(9);
        }

        $pdf = Pdf::loadView('pdfs.oficioDeComision', [
                'datos' => $datos,
                'fecha_servicio' => $fecha_servicio,
                'id_inspector' => $id_inspector,
            ]);
        return $pdf->stream('F-UV-02-09 Oficio de Comisión Ed.5, Vigente.pdf');
    }

    public function pdf_orden_servicio($id_inspeccion)
    {
        $datos = inspecciones::with(['inspector', 'solicitud.instalacion', 'solicitud.empresa.empresaNumClientes'])->find($id_inspeccion);
        $fecha_servicio = !empty($datos->fecha_servicio)
            ? Helpers::formatearFecha($datos->fecha_servicio)
            : null;
        $pdf = Pdf::loadView('pdfs.ordenDeServicio', ['datos' => $datos, 'fecha_servicio' => $fecha_servicio]);
        return $pdf->stream('F-UV-02-01 Orden de servicio Ed. 5, Vigente.pdf');
    }


    public function agregarResultados(Request $request)
{
    $sol = solicitudesModel::find($request->id_solicitud);
    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $sol->empresa->id_empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });

    $mensaje = "";

    if ($request->hasFile('url')) {
        foreach ($request->file('url') as $index => $file) {
            if ($request->id_solicitud) {
                $documentacion_url = null;

                if ($request->id_documento[$index] == 69) {
                    $documentacion_url = Documentacion_url::where('id_relacion', $request->id_solicitud)
                        ->where('id_documento', 69)
                        ->first();
                }

                if ($documentacion_url) {
                    $existingFilePath = 'uploads/' . $numeroCliente . '/actas/' . $documentacion_url->url;
                    if (Storage::disk('public')->exists($existingFilePath)) {
                        Storage::disk('public')->delete($existingFilePath);
                    }
                } else {
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $request->id_solicitud;
                    $documentacion_url->id_documento = $request->id_documento[$index];
                    $documentacion_url->id_empresa = $sol->id_empresa;
                }

                // Guardar archivo
                $filename = str_replace('/', '-', $request->nombre_documento[$index]) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/' . $numeroCliente . '/actas/', $filename, 'public');

                $documentacion_url->nombre_documento = str_replace('/', '-', $request->nombre_documento[$index]);
                $documentacion_url->url = $filename;
                $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null;
                $documentacion_url->save();

                $mensaje = str_replace('/', '-', $request->nombre_documento[$index]) . ", " . $mensaje;

                // Insertar en solicitudes adicionales enviadas en el request
                $solicitudesAdicionales = $request->solicitudes_adicionales ?? [];

                foreach ($solicitudesAdicionales as $idAdicional) {
                    // Verificar si ya existe el registro



                        $nuevoDoc = new Documentacion_url();
                        $nuevoDoc->id_relacion = $idAdicional;
                        $nuevoDoc->id_documento = $request->id_documento[$index];
                        $nuevoDoc->id_empresa = $sol->id_empresa;
                        $nuevoDoc->nombre_documento = str_replace('/', '-', $request->nombre_documento[$index]);
                        $nuevoDoc->url = $filename;
                        $nuevoDoc->fecha_vigencia = $request->fecha_vigencia[$index] ?? null;
                        $nuevoDoc->save();

                }
            }
        }
    }

    // return response()->json(['success' => true, 'mensaje' => $mensaje]);
}


    // Método para obtener una guía por ID
    public function editActa($id_acta)
    {
        try {
            // Aquí obtienes el acta de inspección junto con sus testigos
            $acta = actas_inspeccion::with(
                'actas_testigo',
                'acta_produccion_mezcal',
                'actas_equipo_mezcal',
                'actas_unidad_envasado',
                'actas_unidad_comercializacion',
                'actas_equipo_envasado',
                'actas_produccion'
            )->findOrFail($id_acta);

            return response()->json($acta);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el acta por ID'], 500);
        }
    }

    public function getInspeccion($id_solicitud)
    {
        try {
            // Aquí obtienes el acta de inspección junto con sus testigos
            $datos = solicitudesModel::with('inspeccion', 'empresa')->where('id_solicitud', $id_solicitud)->first();
            return response()->json(['success' => true, 'data' => $datos]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los datos de la inspección'], 500);
        }
    }

    // Método para insertar el formulario de Acta de Inspección
    public function store(Request $request)
    {
        try {
            // Crear un nuevo registro en la tabla `actas_inspeccion`
            $acta = new actas_inspeccion();
            $acta->id_inspeccion = $request->id_inspeccion;
            $acta->id_empresa = $request->acta_id_empresa;
            $acta->num_acta = $request->num_acta;
            $acta->categoria_acta = $request->categoria_acta;
            $acta->testigos = $request->testigos;
            $acta->encargado = $request->encargado;
            $acta->num_credencial_encargado = $request->num_credencial_encargado;
            $acta->lugar_inspeccion = $request->lugar_inspeccion;
            $acta->fecha_inicio = $request->fecha_inicio;
            $acta->fecha_fin = $request->fecha_fin;
            $acta->no_conf_infraestructura = $request->no_conf_infraestructura;
            $acta->no_conf_equipo = $request->no_conf_equipo;

            // Guardar el registro en la base de datos
            $acta->save();

            // Guardar los testigos relacionados si existen
            if (isset($request->nombre_testigo) && is_array($request->nombre_testigo)) {
                for ($i = 0; $i < count($request->nombre_testigo); $i++) {
                    $testigo = new actas_testigo();
                    $testigo->id_acta = $acta->id_acta;  // Relacionar con la acta creada
                    $testigo->nombre_testigo = $request->nombre_testigo[$i];
                    $testigo->domicilio = $request->domicilio[$i];
                    $testigo->save();
                }
            }

            // Guardar las producciones relacionadas si existen
            if (isset($request->id_plantacion) && is_array($request->id_plantacion)) {
                for ($i = 0; $i < count($request->id_plantacion); $i++) {
                    $produccion = new actas_produccion();
                    $produccion->id_acta = $acta->id_acta;  // Relacionar con la acta creada
                    $produccion->id_plantacion = $request->id_plantacion[$i];
                    $produccion->plagas = $request->plagas[$i];
                    $produccion->save();
                }
            }

            // Guardar el equipo de mezcal relacionado si existe
            if (isset($request->equipo) && is_array($request->equipo)) {
                for ($i = 0; $i < count($request->equipo); $i++) {
                    $equiMezcal = new actas_equipo_mezcal();
                    $equiMezcal->id_acta = $acta->id_acta;  // Relacionar con la acta creada
                    $equiMezcal->equipo = !empty($request->equipo[$i]) ? $request->equipo[$i] : null;
                    $equiMezcal->cantidad = $request->cantidad[$i];
                    $equiMezcal->capacidad = $request->capacidad[$i];
                    $equiMezcal->tipo_material = $request->tipo_material[$i];
                    $equiMezcal->save();
                }
            }

            // Guardar el equipo de envasado relacionado si existe
            if (isset($request->equipo_envasado) && is_array($request->equipo_envasado)) {
                for ($i = 0; $i < count($request->equipo_envasado); $i++) {
                    $equiEnvasado = new actas_equipo_envasado();
                    $equiEnvasado->id_acta = $acta->id_acta;  // Relacionar con la acta creada
                    $equiEnvasado->equipo_envasado = !empty($request->equipo_envasado[$i]) ? $request->equipo_envasado[$i] : null;
                    $equiEnvasado->cantidad_envasado = $request->cantidad_envasado[$i];
                    $equiEnvasado->capacidad_envasado = $request->capacidad_envasado[$i];
                    $equiEnvasado->tipo_material_envasado = $request->tipo_material_envasado[$i];
                    $equiEnvasado->save();
                }
            }

            // Guardar las respuestas de las áreas de producción de mezcal si existen
            if (isset($request->respuesta) && is_array($request->respuesta)) {
                $area = ['Recepción (materia prima)', 'Área de pesado', 'Área de cocción', 'Área de maguey cocido', 'Área de molienda', 'Área de fermentación', 'Área de destilación', 'Almacén a graneles'];

                foreach ($request->respuesta as $rowIndex => $respuestasPorFila) {
                    foreach ($respuestasPorFila as $areaIndex => $respuesta) {
                        if (isset($area[$areaIndex])) {
                            $actaProduc = new acta_produccion_mezcal();
                            $actaProduc->id_acta = $acta->id_acta; // Relacionar con la acta creada
                            $actaProduc->area = $area[$areaIndex]; // Guardar el área correspondiente
                            $actaProduc->respuesta = !empty($respuesta) ? $respuesta : null; // Convertir vacío a null
                            $actaProduc->save();
                        }
                    }
                }
            }



            // Guardar las respuestas de las áreas de envasado si existen
            if (isset($request->respuestas) && is_array($request->respuestas)) {
                $areas = [
                    'Almacén de insumos',
                    'Almacén a gráneles',
                    'Sistema de filtrado',
                    'Área de envasado',
                    'Área de tiquetado',
                    'Almacén de producto terminado',
                    'Área de aseo personal'
                ];

                foreach ($request->respuestas as $rowIndex => $respuestasPorFilas) {
                    foreach ($respuestasPorFilas as $areaIndex => $respuestas) {
                        if (isset($areas[$areaIndex])) {
                            $actaUnidadEnvasado = new actas_unidad_envasado();
                            $actaUnidadEnvasado->id_acta = $acta->id_acta; // Relacionar con la acta creada
                            $actaUnidadEnvasado->areas = $areas[$areaIndex]; // Guardar el área correspondiente
                            $actaUnidadEnvasado->respuestas = !empty($respuestas) ? $respuestas : null; // Guardar la respuesta seleccionada (C, NC, NA)
                            $actaUnidadEnvasado->save();
                        }
                    }
                }
            }

            // Guardar las respuestas de comercialización si existen
            if (isset($request->respuestas_comercio) && is_array($request->respuestas_comercio)) {
                $comercializacion = [
                    'Bodega o almacén',
                    'Tarimas',
                    'Bitácoras',
                    'Otro:',
                    'Otro:'
                ];

                foreach ($request->respuestas_comercio as $rowIndex => $respuestasPorFilas2) {
                    foreach ($respuestasPorFilas2 as $areaIndex => $respuestas_comercio) {
                        if (isset($comercializacion[$areaIndex])) {
                            $actaUnidadComer = new actas_unidad_comercializacion();
                            $actaUnidadComer->id_acta = $acta->id_acta; // Relacionar con la acta creada
                            $actaUnidadComer->comercializacion = $comercializacion[$areaIndex]; // Guardar el área correspondiente
                            $actaUnidadComer->respuestas_comercio = !empty($respuestas_comercio) ? $respuestas_comercio : null; // Guardar la respuesta seleccionada (C, NC, NA)
                            $actaUnidadComer->save();
                        }
                    }
                }
            }

            return response()->json(['success' => 'Acta circunstanciada para Unidades de producción registrado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }




    //Metodo para llenar el pdf
    public function acta_circunstanciada_produccion($id_inspeccion)
    {


        $datos = inspecciones::with(
            'solicitud.empresa',
            'actas_inspeccion.actas_testigo',
            'inspector',
            'actas_inspeccion.acta_produccion_mezcal',
            'actas_inspeccion.actas_equipo_mezcal',
            'actas_inspeccion.actas_equipo_envasado',
            'actas_inspeccion.actas_unidad_comercializacion',
            'actas_inspeccion.actas_unidad_envasado',
            'actas_inspeccion.actas_produccion.predio_plantacion.predio.catalogo_tipo_agave',
            'empresa_num_cliente'
        )->find($id_inspeccion);
        $fecha_llenado = Helpers::formatearFecha($datos->actas_inspeccion->fecha_inicio);
        $hora_llenado = Helpers::extraerHora($datos->actas_inspeccion->fecha_inicio);
        $fecha_llenado_fin = Helpers::formatearFecha($datos->actas_inspeccion->fecha_fin);
        $hora_llenado_fin = Helpers::extraerHora($datos->actas_inspeccion->fecha_fin);
        $pdf = Pdf::loadView('pdfs.acta_circunstanciada_unidades_produccion', compact('datos', 'hora_llenado', 'fecha_llenado', 'fecha_llenado_fin', 'hora_llenado_fin'));
        return $pdf->stream('F-UV-02-02 ACTA CIRCUNSTANCIADA V6.pdf');
    }
    public function etiqueta_muestra($id_inspeccion)
    {
        $datos = inspecciones::where('id_solicitud', $id_inspeccion)->first();
        $pdf = Pdf::loadView('pdfs.Etiqueta_agave_art', ['datos' => $datos]);
        return $pdf->stream('Etiqueta para agave (%ART).pdf');
    }

    public function etiqueta_granel($id_inspeccion)
    {
        $datos = inspecciones::where('id_solicitud', $id_inspeccion)->first();
        // Renderizar el PDF por primera vez para obtener el total de páginas
        $pdf = Pdf::loadView('pdfs.Etiqueta_lotes_mezcal_granel', ['datos' => $datos]);
        $dompdf = $pdf->getDomPDF();
        $dompdf->render();
        // Obtener el total de páginas
        $totalPaginas = $dompdf->get_canvas()->get_page_count();
        // Pasar el total de páginas a la vista para la segunda renderización
        $pdfFinal = Pdf::loadView('pdfs.Etiqueta_lotes_mezcal_granel', [
            'totalPaginas' => $totalPaginas,
            'datos' => $datos
        ]);

        // Retornar el PDF final
        return $pdfFinal->stream('Etiqueta para lotes de mezcal a granel.pdf');
    }

    public function etiqueta_barrica($id_inspeccion)
    {
        $datos = inspecciones::where('id_solicitud', $id_inspeccion)->first();
        $pdf = Pdf::loadView('pdfs.Etiqueta_Barrica', ['datos' => $datos]);
        return $pdf->stream('Etiqueta_ingreso_a_barrica.pdf');
    }

    public function etiqueta($id_inspeccion)
    {
        $datos = inspecciones::where('id_solicitud', $id_inspeccion)->first();

        $pdf = Pdf::loadView('pdfs.Etiquetas_tapas_sellado',  ['datos' => $datos]);
        return $pdf->stream('Etiqueta-2401ESPTOB.pdf');
    }

        public function exportar(Request $request)
    {
        $filtros = $request->only(['id_empresa', 'anio', 'estatus', 'mes', 'id_soli']);
        // Pasar los filtros a la clase InspeccionesExport
        return Excel::download(new InspeccionesExport($filtros), 'reporte_inspecciones.xlsx');
    }
}
