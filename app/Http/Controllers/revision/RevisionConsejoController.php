<?php

namespace App\Http\Controllers\revision;

use App\Http\Controllers\Controller;
use App\Models\Revisor;
use App\Models\RevisorGranel;
use App\Models\RevisorExportacion; //EXPORTACION
use App\Models\Certificados;
use App\Models\empresa;
use App\Models\User;
use App\Models\empresaNumCliente;
use App\Helpers\Helpers;
use App\Models\preguntas_revision;
/* controller */
use App\Http\Controllers\solicitudes\solicitudesController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//Autentificar
use Illuminate\Support\Facades\Log;


class RevisionConsejoController extends Controller
{
        public function userManagement()
    {
        //$userId = auth()->id();
        $userId = Auth::id();
        $EstadisticasInstalaciones = $this->calcularCertificados($userId, 1, 2); // Estadisticas Instalaciones
        $EstadisticasGranel = $this->calcularCertificados($userId, 2, 2); // Estadisticas Granel

        $revisorQuery = Revisor::with('certificadoNormal', 'certificadoGranel', 'certificadoExportacion')
            ->where('tipo_revision', 2); // Solo revisiones de miembro

        if ($userId != 1) {
            $revisorQuery->where('id_revisor', $userId);
        }
        $revisor = $revisorQuery->first();

        //EXPORTACION
        $EstadisticasExportacion = $this->calcularCertificados($userId, 3, 2);

        $users = User::where('tipo', 1)->get(); // Select Aprobacion
        $preguntasRevisor = preguntas_revision::where('tipo_revisor', 2)->where('tipo_certificado', 1)->get(); // Preguntas Instalaciones
        $preguntasRevisorGranel = preguntas_revision::where('tipo_revisor', 2)->where('tipo_certificado', 2)->get(); // Preguntas Granel
        $noCertificados = (!$revisor || !$revisor->certificado); // Alerta si no hay Certificados Asignados al Revisor

        return view('revision.revision_certificados_consejo_view', compact('revisor', 'preguntasRevisor', 'preguntasRevisorGranel', 'EstadisticasInstalaciones', 'EstadisticasGranel', 'users', 'noCertificados', 'EstadisticasExportacion'));
    }

        public function index(Request $request)
    {
        $columns = [
            1 => 'id_revision',
            2 => 'decision',
            3 => 'observaciones',
            4 => 'tipo_revision',
            5 => 'id_certificado',
            6 => 'num_certificado',
            7 => 'created_at',
            8 => 'decision'
        ];

        $search = $request->input('search.value');
        $userId = Auth::id();
        $tipoCertificado = $request->input('tipo_certificado');
        // Inicializar la consulta para Revisor y RevisorGranel
        $queryRevisor = Revisor::with([
            'certificadoNormal.dictamen',
            'certificadoGranel.dictamen',
            'certificadoExportacion.dictamen'
        ])->where('tipo_revision', 2); // Solo revisiones de miembro


        // Filtrar por usuario si no es admin (ID 8)
        if ($userId != 1 AND $userId !=2  AND $userId !=3  AND $userId !=4) {
            $queryRevisor->where('id_revisor', $userId);
        }
        if ($tipoCertificado) {
            $queryRevisor->where('tipo_certificado', $tipoCertificado);
        }

        // Filtros de búsqueda
       if ($search) {
      $queryRevisor->where(function ($q) use ($search, $tipoCertificado) {
          $q->orWhereHas('user', function ($q) use ($search) {
              $q->where('name', 'LIKE', "%{$search}%");
          })
          ->orWhere('observaciones', 'LIKE', "%{$search}%")
          ->orWhere('tipo_revision', 'LIKE', "%{$search}%");

          // Solo busca en el certificado correspondiente al tipo
          if ($tipoCertificado == 1) {
              $q->orWhereHas('certificadoNormal', function ($q) use ($search) {
                  $q->where('num_certificado', 'LIKE', "%{$search}%");
              });
          } elseif ($tipoCertificado == 2) {
              $q->orWhereHas('certificadoGranel', function ($q) use ($search) {
                  $q->where('num_certificado', 'LIKE', "%{$search}%");
              });
          } elseif ($tipoCertificado == 3) {
              $q->orWhereHas('certificadoExportacion', function ($q) use ($search) {
                  $q->where('num_certificado', 'LIKE', "%{$search}%");
              });
          }
      });
  }

        // Paginación y ordenación
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $order = $columns[$orderIndex] ?? 'id_revision';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';

        // Obtener los totales de registros por separado
        $totalDataRevisor = $queryRevisor->count();


        // Consultar los registros
        $revisores = $queryRevisor->offset($start)->limit($limit)->orderBy($order, $dir)->get();


        // Formatear los datos para la vista
        $dataRevisor = $revisores->map(function ($revisor) use (&$start) {
            $nameRevisor = $revisor->user->name ?? null;
            $tipoDictamen = $revisor->certificado && $revisor->certificado->dictamen ? $revisor->certificado->dictamen->tipo_dictamen : null;

            $tipoCertificado = "Sin definir";
            if ($revisor->tipo_certificado == 1) {

                switch ($tipoDictamen) {
                    case 1:
                        $tipoCertificado = 'Instalaciones de productor';
                        break;
                    case 2:
                        $tipoCertificado = 'Instalaciones de envasador';
                        break;
                    case 3:
                        $tipoCertificado = 'Instalaciones de comercializador';
                        break;
                    case 4:
                        $tipoCertificado = 'Instalaciones de almacén y bodega';
                        break;
                    case 5:
                        $tipoCertificado = 'Instalaciones de área de maduración';
                        break;
                    default:
                }
            }
            if ($revisor->tipo_certificado == 2) {
                $tipoCertificado = 'Granel';
            }
            if ($revisor->tipo_certificado == 3) {
                $tipoCertificado = 'Exportación';
            }


            $numDictamen = $revisor->certificado && $revisor->certificado->dictamen ? $revisor->certificado->dictamen->num_dictamen : null;
            $fechaVigencia = $revisor->certificado ? $revisor->certificado->fecha_vigencia : null;
            $fechaVencimiento = $revisor->certificado ? $revisor->certificado->fecha_vencimiento : null;
            $fechaCreacion = $revisor->created_at;
            $fechaActualizacion = $revisor->updated_at;

            return [
                'id_revision' => $revisor->id_revision,
                'fake_id' => ++$start,
                'id_revisor' => $nameRevisor,
                'id_revisor2' => $revisor->id_revisor2,
                'observaciones' => $revisor->observaciones,
                'num_certificado' => $revisor->certificado ? $revisor->certificado->num_certificado : null,
                'id_certificado' => $revisor->certificado ? $revisor->certificado->id_certificado : null,
                'tipo_dictamen' => $tipoDictamen,
                'num_dictamen' => $numDictamen,
                'fecha_vigencia' => Helpers::formatearFecha($fechaVigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($fechaVencimiento),
                'fecha_creacion' => Helpers::formatearFecha($fechaCreacion),
                'created_at' => Helpers::formatearFechaHora($revisor->created_at),
                'updated_at' => Helpers::formatearFechaHora($revisor->updated_at),
                'decision' => $revisor->decision,
                'num_revision' => $revisor->numero_revision,
                'tipo_revision' => $tipoCertificado,
            ];
        });





        // Total de resultados
        $totalData = $totalDataRevisor;

        // Devolver los resultados como respuesta JSON
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalData),
            'data' => array_merge($dataRevisor->toArray()), // Combinacion
        ]);
    }



    public function obtenerRespuestasConsejo($id_revision)
    {
        try {
            $revisor = Revisor::where('id_revision', $id_revision)->first();

            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }

            // Decodificar respuestas
            $historialRespuestas = json_decode($revisor->respuestas, true);

            // Verificar si es un array válido
            $ultimaRevision = is_array($historialRespuestas) ? end($historialRespuestas) : null;
            $decision = $revisor->decision;

            // Respuesta con datos o vacío si no hay historial
            return response()->json([
                'message' => 'Datos de la revisión más actual recuperados exitosamente.',
                'respuestas' => $ultimaRevision,
                'decision' => $decision,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json([
                'message' => 'Ocurrió un error al cargar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getCertificadoUrlConsejo($id_revision, $tipo)
    {
        $revisor = Revisor::with('certificado')->where('id_revision', $id_revision)->first();

        if ($revisor && $revisor->certificado) {
            $certificadoUrl = '';

            if ($tipo == 1 || $tipo == 5) {
                $certificadoUrl = "../certificado_productor_mezcal/{$revisor->certificado->id_certificado}";
            } elseif ($tipo == 2) {
                $certificadoUrl = "../certificado_envasador_mezcal/{$revisor->certificado->id_certificado}";
            } elseif ($tipo == 3 || $tipo == 4) {
                $certificadoUrl = "../certificado_comercializador/{$revisor->certificado->id_certificado}";
            } else {
                return response()->json(['certificado_url' => null]);
            }

            return response()->json(['certificado_url' => $certificadoUrl]);
        } else {
            return response()->json(['certificado_url' => null]);
        }
    }



    public function calcularCertificados($userId, $tipo_certificado, $tipo_revision = 2)
    {
        $totalCertificados = Revisor::where('id_revisor', $userId)->where('tipo_certificado', $tipo_certificado)->where('tipo_revision', $tipo_revision)->count();
        $totalCertificadosGlobal = Revisor::where('tipo_certificado', $tipo_certificado)->where('tipo_revision', $tipo_revision)->count();
        $porcentaje = $totalCertificados > 0 ? ($totalCertificados / $totalCertificadosGlobal) * 100 : 0;

        $certificadosPendientes = Revisor::where('id_revisor', $userId)->where('tipo_certificado', $tipo_certificado)
            ->where(function ($query) {
                $query->whereNull('decision')
                    ->orWhere('decision', '');
            })
            ->count();

        $certificadosRevisados = Revisor::where('id_revisor', $userId)->where('tipo_certificado', $tipo_certificado)
            ->whereNotNull('decision')
            ->count();

        $porcentajePendientes = $totalCertificados > 0 ? ($certificadosPendientes / $totalCertificados) * 100 : 0;
        $porcentajeRevisados = $totalCertificados > 0 ? ($certificadosRevisados / $totalCertificados) * 100 : 0;

        return [
            'totalCertificados' => $totalCertificados,
            'porcentaje' => $porcentaje,
            'certificadosPendientes' => $certificadosPendientes,
            'porcentajePendientes' => $porcentajePendientes,
            'certificadosRevisados' => $certificadosRevisados,
            'porcentajeRevisados' => $porcentajeRevisados
        ];
    }

    public function registrarAprobacionConsejo(Request $request)
    {
        $request->validate([
            'id_revisor' => 'required|exists:certificados_revision,id_revision',
            'id_aprobador' => 'required|exists:users,id',
            'aprobacion' => 'required|string|in:aprobado,desaprobado',
            'fecha_aprobacion' => 'required|date',
        ]);

        try {
            $revisor = Revisor::findOrFail($request->input('id_revisor'));
            $revisor->aprobacion = $request->input('aprobacion');
            $revisor->fecha_aprobacion = $request->input('fecha_aprobacion');
            $revisor->id_aprobador = $request->input('id_aprobador');
            $revisor->save();

            return response()->json([
                'message' => 'Aprobación registrada exitosamente.',
                'revisor' => $revisor
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al registrar la aprobación', ['exception' => $e]);
            return response()->json([
                'message' => 'Error al registrar la aprobación: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cargarAprobacionConsejo($id)
    {
        try {
            $revisor = Revisor::findOrFail($id);

            return response()->json([
                'revisor' => $revisor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al cargar la aprobación: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function editarRespuestasConsejo(Request $request)
    {
        try {
            $request->validate([
                'id_revision' => 'required|integer',
                'respuestas' => 'nullable|array',
                'observaciones' => 'nullable|array',
                'decision' => 'nullable|string',
            ]);

            $revisor = Revisor::where('id_revision', $request->id_revision)->first();
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }

            $historialRespuestas = json_decode($revisor->respuestas, true) ?? [];

            $numRevision = count($historialRespuestas);
            if ($numRevision < 1) {
                return response()->json(['message' => 'No hay revisiones para editar.'], 404);
            }

            $revisionKey = "Revision $numRevision";
            if (!isset($historialRespuestas[$revisionKey])) {
                return response()->json(['message' => 'No se encontró la última revisión para editar.'], 404);
            }

            $todasLasRespuestasSonC = true;
            foreach ($request->respuestas as $key => $nuevaRespuesta) {
                $nuevaObservacion = $request->observaciones[$key] ?? null;

                if ($nuevaRespuesta !== 'C') {
                    $todasLasRespuestasSonC = false;
                }

                if (isset($historialRespuestas[$revisionKey][$key])) {
                    $historialRespuestas[$revisionKey][$key]['respuesta'] = $nuevaRespuesta;
                    $historialRespuestas[$revisionKey][$key]['observacion'] = $nuevaObservacion;
                }
            }

            $revisor->respuestas = json_encode($historialRespuestas);
            $revisor->decision = $todasLasRespuestasSonC ? 'positiva' : 'negativa';
            $revisor->save();
            return response()->json(['message' => 'Revisión actualizada exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al editar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }







    public function add_revision_consejo($id_revision)
    {

        $datos = Revisor::with('certificadoNormal', 'certificadoGranel', 'certificadoExportacion')->where("id_revision", $id_revision)->first();
        $preguntas = preguntas_revision::where('tipo_revisor', 2)->where('tipo_certificado', $datos->tipo_certificado)->where('orden', $datos->numero_revision == 1 ? 0 : 1)->get();

        $id_dictamen = $datos->certificado->dictamen->tipo_dictamen ?? '';




        if ($datos->tipo_certificado == 1) { //Instalaciones

            switch ($id_dictamen) {
                case 1:
                    $tipo = 'Instalaciones de productor';
                    $url = "/certificado_productor_mezcal/" . $datos->id_certificado;
                    break;
                case 2:
                    $tipo = 'Instalaciones de envasador';
                    $url = "/certificado_envasador_mezcal/" . $datos->id_certificado;
                    break;
                case 3:
                    $tipo = 'Instalaciones de comercializador';
                    $url = "/certificado_comercializador/" . $datos->id_certificado;
                    break;
                case 4:
                    $tipo = 'Instalaciones de almacén y bodega';
                    $url = "/certificado_almacen/" . $datos->id_certificado;
                    break;
                case 5:
                    $tipo = 'Instalaciones de área de maduración';
                    $url = "/certificado_maduracion/" . $datos->id_certificado;
                    break;
                default:
                    $tipo = 'Desconocido';
            }
        } elseif ($datos->tipo_certificado == 2) { //Granel
            $url = "/Pre-certificado-granel/" . $datos->id_certificado;
            $tipo = "Granel";
        } elseif ($datos->tipo_certificado == 3) { //Exportación
            $url = "/certificado_exportacion/" . $datos->id_certificado;
            $tipo = "Exportación";

        }
        return view('certificados.add_revision_consejo', compact('datos', 'preguntas', 'url', 'tipo'));
    }
    public function registrar_revision_consejo(Request $request)
    {
        try {
            $request->validate([
                'id_revision' => 'required|integer',
                'respuesta' => 'required|array',
                'observaciones' => 'nullable|array',
                'id_pregunta' => 'required|array',
            ]);

            $revisor = Revisor::where('id_revision', $request->id_revision)->first();
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }

            // Obtener el historial de respuestas como array
            $historialRespuestas = $revisor->respuestas ?? [];

            // Asegurarse de que es un array, por si viene como JSON string
            if (is_string($historialRespuestas)) {
                $historialRespuestas = json_decode($historialRespuestas, true);
            }

            // Definir número de revisión
            $numRevision = count($historialRespuestas) + 1;
            $revisionKey = "Revision $numRevision";



            $nuevoRegistro = [];
            $todasLasRespuestasSonC = true;

            foreach ($request->respuesta as $key => $nuevaRespuesta) {
                $nuevaObservacion = $request->observaciones[$key] ?? null;
                $nuevaIdPregunta = $request->id_pregunta[$key] ?? null;

                if ($nuevaRespuesta == 'NC') {
                    $todasLasRespuestasSonC = false;
                }

                $nuevoRegistro[] = [ // Aquí usamos `[]` en lugar de `$key`
                    'id_pregunta' => $nuevaIdPregunta,
                    'respuesta' => $nuevaRespuesta,
                    'observacion' => $nuevaObservacion,
                ];
            }

            // Guardar respuestas en formato JSON (Laravel lo maneja automáticamente)
            $historialRespuestas[$revisionKey] = $nuevoRegistro;
            $revisor->fill([
                'respuestas' => $historialRespuestas,
                'decision' => $todasLasRespuestasSonC ? 'positiva' : 'negativa',
            ]);

            $revisor->save();

            return response()->json(['message' => 'Respuestas y decisión registradas exitosamente.'], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al registrar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function edit_revision_consejo($id_revision)
    {

        $datos = Revisor::with('certificadoNormal', 'certificadoGranel', 'certificadoExportacion')->where("id_revision", $id_revision)->first();
        $preguntas = preguntas_revision::where('tipo_revisor', 2)->where('tipo_certificado', $datos->tipo_certificado)->where('orden', $datos->numero_revision == 1 ? 0 : 1)->get();

        $respuestas_json = json_decode($datos->respuestas, true); // Convierte el campo JSON a array PHP
        $respuestas_revision = $respuestas_json['Revision '.$datos->numero_revision] ?? []; // O la clave correspondiente

        // Crear un array indexado por id_pregunta para fácil acceso
        $respuestas_map = collect($respuestas_revision)->keyBy('id_pregunta');

        $id_dictamen = $datos->certificado->dictamen->tipo_dictamen ?? '';




        if ($datos->tipo_certificado == 1) { //Instalaciones

            switch ($id_dictamen) {
                case 1:
                    $tipo = 'Instalaciones de productor';
                    $url = "/certificado_productor_mezcal/" . $datos->id_certificado;
                    break;
                case 2:
                    $tipo = 'Instalaciones de envasador';
                    $url = "/certificado_envasador_mezcal/" . $datos->id_certificado;
                    break;
                case 3:
                    $tipo = 'Instalaciones de comercializador';
                    $url = "/certificado_comercializador/" . $datos->id_certificado;
                    break;
                case 4:
                    $tipo = 'Instalaciones de almacén y bodega';
                    $url = "/certificado_almacen/" . $datos->id_certificado;
                    break;
                case 5:
                    $tipo = 'Instalaciones de área de maduración';
                    $url = "/certificado_maduracion/" . $datos->id_certificado;
                    break;
                default:
                    $tipo = 'Desconocido';
            }
        } elseif ($datos->tipo_certificado == 3) {
            $url = 'certificado_exportacion' . $datos->id_certificado;
            $tipo = 'Exportación';
        }
        if ($datos->tipo_certificado == 2) { //Granel
            $url = "/Pre-certificado-granel/" . $datos->id_certificado;
            $tipo = "Granel";
        }
        if ($datos->tipo_certificado == 3) { //Exportación
            $url = "/certificado_exportacion/" . $datos->id_certificado;
            $tipo = "Exportación";
        }
        return view('certificados.edit_revision_consejo', compact('datos', 'preguntas', 'url', 'tipo', 'respuestas_map'));
    }

    public function editar_revision_consejo(Request $request)
{
    try {
        $request->validate([
            'id_revision' => 'required|integer',
            'respuesta' => 'required|array',
            'observaciones' => 'nullable|array',
            'id_pregunta' => 'required|array',
          // Número de la revisión a editar
        ]);

        $revisor = Revisor::where('id_revision', $request->id_revision)->first();
        if (!$revisor) {
            return response()->json(['message' => 'El registro no fue encontrado.'], 404);
        }

        // Obtener el historial de respuestas como array
        $historialRespuestas = $revisor->respuestas ?? [];

        // Asegurarse de que es un array, por si viene como JSON string
        if (is_string($historialRespuestas)) {
            $historialRespuestas = json_decode($historialRespuestas, true);
        }

        $revisionKey = "Revision " . $request->numero_revision;

        // Verificar que la revisión exista
        if (!array_key_exists($revisionKey, $historialRespuestas)) {
            return response()->json(['message' => "La $revisionKey no existe."], 404);
        }

        $nuevoRegistro = [];
        $todasLasRespuestasSonC = true;

        foreach ($request->respuesta as $key => $nuevaRespuesta) {
            $nuevaObservacion = $request->observaciones[$key] ?? null;
            $nuevaIdPregunta = $request->id_pregunta[$key] ?? null;

            if ($nuevaRespuesta == 'NC') {
                $todasLasRespuestasSonC = false;
            }

            $nuevoRegistro[] = [
                'id_pregunta' => $nuevaIdPregunta,
                'respuesta' => $nuevaRespuesta,
                'observacion' => $nuevaObservacion,
            ];
        }

        // Actualizar la revisión específica
        $historialRespuestas[$revisionKey] = $nuevoRegistro;

        $revisor->fill([
            'respuestas' => $historialRespuestas,
            'decision' => $todasLasRespuestasSonC ? 'positiva' : 'negativa',
        ]);

        $revisor->save();

      return redirect('/revision/consejo');


    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Ocurrió un error al editar la revisión: ' . $e->getMessage(),
        ], 500);
    }
}





    public function cargarHistorialConsejo($id_revision)
    {
        try {
            $revisores = Revisor::where('id_revision', $id_revision)->get();

            if ($revisores->isEmpty()) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }

            // Cargar todas las preguntas una vez para optimizar
            $todasPreguntas = preguntas_revision::all()->keyBy('id_pregunta');

            $historialFormateado = [];

            foreach ($revisores as $revisor) {
                $respuestasPorRevision = json_decode($revisor->respuestas, true) ?? [];

                $formatoFinal = [];

                foreach ($respuestasPorRevision as $nombreRevision => $respuestas) {
                    $formatoRespuestas = [];

                    foreach ($respuestas as $r) {
                        $pregunta = $todasPreguntas[$r['id_pregunta']] ?? null;

                        $formatoRespuestas[] = [
                            'id_pregunta' => $r['id_pregunta'],
                            'pregunta' => $pregunta->pregunta ?? 'Pregunta no encontrada',
                            'respuesta' => $r['respuesta'] ?? null,
                            'observacion' => $r['observacion'] ?? null,
                        ];
                    }

                    $formatoFinal[] = [
                        'nombre_revision' => $nombreRevision,
                        'respuestas' => $formatoRespuestas,
                    ];
                }

                $historialFormateado[] = [
                    'revision' => $revisor->id_revision,
                    'respuestas' => $formatoFinal,
                ];
            }

            return response()->json([
                'message' => 'Historial de respuestas recuperado exitosamente.',
                'respuestas' => $historialFormateado,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al cargar el historial: ' . $e->getMessage(),
            ], 500);
        }
    }

        public function pdf_bitacora_revision_certificado_instalaciones($id)
    {

         $revisor = Revisor::findOrFail($id);

        // Decodificar el JSON correctamente
        $respuestasJson = json_decode($revisor->respuestas, true);

        // Asegurar que "Revisión 1" existe en el array
        $respuestas = collect(array_merge(
            $respuestasJson["Revision 1"] ?? [],
            $respuestasJson["Revision 2"] ?? [],
            $respuestasJson["Revision 3"] ?? []
        ));


        $preguntas = preguntas_revision::whereIn('id_pregunta', $respuestas->pluck('id_pregunta'))->get();


        // Unir las preguntas con sus respuestas
        $preguntasConRespuestas = $preguntas->map(function ($pregunta) use ($respuestas) {
            $respuesta = $respuestas->firstWhere('id_pregunta', $pregunta->id_pregunta);
            return [
                'id_pregunta' => $pregunta->id_pregunta,
                'pregunta' => $pregunta->pregunta,
                'respuesta' => $respuesta['respuesta'] ?? null,
                'observacion' => $respuesta['observacion'] ?? null,
            ];
        });



        $id_dictamen = $revisor->certificado->dictamen->tipo_dictamen;

        $tipo_certificado = '';
        if ($revisor->tipo_certificado == 1) { //Instalaciones

            switch ($id_dictamen) {
                case 1:
                    $tipo_certificado = 'Instalaciones de productor';
                    break;
                case 2:
                    $tipo_certificado = 'Instalaciones de envasador';
                    break;
                case 3:
                    $tipo_certificado = 'Instalaciones de comercializador';
                    break;
                case 4:
                    $tipo_certificado = 'Instalaciones de almacén y bodega';
                    break;
                case 5:
                    $tipo_certificado = 'Instalaciones de área de maduración';

                    break;
                default:
                    $tipo_certificado = 'Desconocido';
            }
        }
        if ($revisor->tipo_certificado == 2) { //Granel

            $tipo_certificado = "NOM a Granel";
        }
        if ($revisor->tipo_certificado == 3) { //Exportación

            $tipo_certificado = "Exportación";
        }





        $decision = $revisor->decision;
        $nameRevisor = $revisor->user->name ?? null;
        $firmaRevisor = $revisor->user->firma ?? '';
        $puestoRevisor = $revisor->user->puesto ?? null;
        $fecha = $revisor->updated_at;
        $id_aprobador = $revisor->aprobador->name ?? 'Sin asignar';
        $aprobacion = $revisor->aprobacion ?? 'Pendiente de aprobar';
        $fecha_aprobacion = $revisor->fecha_aprobacion;

        $razonSocial = $revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar';
        $numero_cliente = $revisor->certificado->dictamen->inspeccione->solicitud->empresa
        ->empresaNumClientes
        ->firstWhere('numero_cliente', '!=', null)
        ->numero_cliente ?? 'Sin asignar';


        $pdfData = [
            'numero_revision' => $revisor->numero_revision,
            'num_certificado' => $revisor->certificado->num_certificado,
            'tipo_certificado' => $tipo_certificado,
            'decision' => $decision,
            'id_revisor' => $nameRevisor,
            'firmaRevisor' => $firmaRevisor,
            'puestoRevisor' => $puestoRevisor,
            'razon_social' => $razonSocial,
            'fecha' => Helpers::formatearFecha($fecha),
            'numero_cliente' => $numero_cliente,
            'aprobacion' => $aprobacion,
            'id_aprobador' => $id_aprobador,
            'fecha_aprobacion' => Helpers::formatearFecha($fecha_aprobacion),
            'preguntas' => $preguntasConRespuestas
        ];

        $pdf = Pdf::loadView('pdfs.pdf_bitacora_revision_certificado_instalaciones',$pdfData)
            ->setPaper('letter'); // Define tamaño carta

        return $pdf->stream('Bitácora de revisión de certificados de Instalaciones NOM-070-SCFI-2016.pdf');
    }

    public function pdf_bitacora_revision_certificado_granel($id)
    {

        $revisor = Revisor::findOrFail($id);

        // Decodificar el JSON correctamente
        $respuestasJson = json_decode($revisor->respuestas, true);

        // Asegurar que "Revisión 1" existe en el array
        $respuestas = collect(array_merge(
            $respuestasJson["Revision 1"] ?? [],
            $respuestasJson["Revision 2"] ?? [],
            $respuestasJson["Revision 3"] ?? []
        ));


        $preguntas = preguntas_revision::whereIn('id_pregunta', $respuestas->pluck('id_pregunta'))->get();

        // Unir las preguntas con sus respuestas
        $preguntasConRespuestas = $preguntas->map(function ($pregunta) use ($respuestas) {
            $respuesta = $respuestas->firstWhere('id_pregunta', $pregunta->id_pregunta);
            return [
                'id_pregunta' => $pregunta->id_pregunta,
                'pregunta' => $pregunta->pregunta,
                'respuesta' => $respuesta['respuesta'] ?? null,
                'observacion' => $respuesta['observacion'] ?? null,
            ];
        });


        $tipo_certificado = "NOM a Granel";

        $decision = $revisor->decision;
        $nameRevisor = $revisor->user->name ?? null;
        $firmaRevisor = $revisor->user->firma ?? '';
        $puestoRevisor = $revisor->user->puesto ?? null;
        $fecha = $revisor->updated_at;
        $id_aprobador = $revisor->aprobador->name ?? 'Sin asignar';
        $aprobacion = $revisor->aprobacion ?? 'Pendiente de aprobar';
        $fecha_aprobacion = $revisor->fecha_aprobacion;

        $razonSocial = $revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar';
        $numero_cliente = $revisor->certificado->dictamen->inspeccione->solicitud->empresa
        ->empresaNumClientes
        ->firstWhere('numero_cliente', '!=', null)
        ->numero_cliente ?? 'Sin asignar';


        $pdfData = [
            'numero_revision' => $revisor->numero_revision,
            'num_certificado' => $revisor->certificado->num_certificado,
            'tipo_certificado' => $tipo_certificado,
            'decision' => $decision,
            'id_revisor' => $nameRevisor,
            'firmaRevisor' => $firmaRevisor,
            'puestoRevisor' => $puestoRevisor,
            'razon_social' => $razonSocial,
            'fecha' => Helpers::formatearFecha($fecha),
            'numero_cliente' => $numero_cliente,
            'aprobacion' => $aprobacion,
            'id_aprobador' => $id_aprobador,
            'fecha_aprobacion' => Helpers::formatearFecha($fecha_aprobacion),
            'preguntas' => $preguntasConRespuestas
        ];

            $pdf = Pdf::loadView('pdfs.pdf_bitacora_revision_certificado_granel', $pdfData)
            ->setPaper('letter'); // Define tamaño carta

        return $pdf->stream('Bitácora de revisión de certificado NOM a Granel NOM-070-SCFI-2016 F7.1-01-34.pdf');
    }

    public function pdf_bitacora_revision_certificado_exportacion($id)
    {
        $revisor = Revisor::findOrFail($id);

        // Decodificar el JSON correctamente
        $respuestasJson = json_decode($revisor->respuestas, true);

        // Asegurar que "Revisión 1" existe en el array
        $respuestas = collect(array_merge(
            $respuestasJson["Revision 1"] ?? [],
            $respuestasJson["Revision 2"] ?? [],
            $respuestasJson["Revision 3"] ?? []
        ));


        $preguntas = preguntas_revision::whereIn('id_pregunta', $respuestas->pluck('id_pregunta'))->get();

        // Unir las preguntas con sus respuestas
        $preguntasConRespuestas = $preguntas->map(function ($pregunta) use ($respuestas) {
            $respuesta = $respuestas->firstWhere('id_pregunta', $pregunta->id_pregunta);
            return [
                'id_pregunta' => $pregunta->id_pregunta,
                'pregunta' => $pregunta->pregunta,
                'respuesta' => $respuesta['respuesta'] ?? null,
                'observacion' => $respuesta['observacion'] ?? null,
            ];
        });


        $tipo_certificado = "NOM a Granel";

        $decision = $revisor->decision;
        $nameRevisor = $revisor->user->name ?? null;
        $firmaRevisor = $revisor->user->firma ?? '';
        $puestoRevisor = $revisor->user->puesto ?? null;
        $fecha = $revisor->updated_at;
        $id_aprobador = $revisor->aprobador->name ?? 'Sin asignar';
        $aprobacion = $revisor->aprobacion ?? 'Pendiente de aprobar';
        $fecha_aprobacion = $revisor->fecha_aprobacion;

        $razonSocial = $revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar';
        $numero_cliente = $revisor->certificado->dictamen->inspeccione->solicitud->empresa
        ->empresaNumClientes
        ->firstWhere('numero_cliente', '!=', null)
        ->numero_cliente ?? 'Sin asignar';


        $pdfData = [
            'numero_revision' => $revisor->numero_revision,
            'num_certificado' => $revisor->certificado->num_certificado,
            'tipo_certificado' => $tipo_certificado,
            'decision' => $decision,
            'id_revisor' => $nameRevisor,
            'firmaRevisor' => $firmaRevisor,
            'puestoRevisor' => $puestoRevisor,
            'razon_social' => $razonSocial,
            'fecha' => Helpers::formatearFecha($fecha),
            'numero_cliente' => $numero_cliente,
            'aprobacion' => $aprobacion,
            'id_aprobador' => $id_aprobador,
            'fecha_aprobacion' => Helpers::formatearFecha($fecha_aprobacion),
            'preguntas' => $preguntasConRespuestas
        ];

            $pdf = Pdf::loadView('pdfs.pdf_bitacora_revision_certificado_exportacion',$pdfData)
            ->setPaper('letter'); // Define tamaño carta

        return $pdf->stream('Bitácora de revisión de certificado de exportación NOM-070-SCFI-2016 F7.1-01-33.pdf');
    }

/*     public function mostrarSolicitudPDFDesdeRevision($id_revision)
    {
        $revision = Revisor::findOrFail($id_revision);
        $solicitud = $revision->certificado->dictamen->inspeccione->solicitud;

        return app(solicitudesController::class)
            ->pdf_solicitud_servicios_070($solicitud->id_solicitud);


    }
 */
}
