<?php

namespace App\Http\Controllers;

use App\Models\EncuestasModel;
use App\Models\OpcionesModel;
use App\Models\PreguntasModel;
use App\Models\User;
use App\Models\CatalogoProveedor;
use App\Models\RespuestasAbiertas;
use App\Models\RespuestasCerradas;;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EncuestasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql = EncuestasModel::orderBy('id_encuesta', 'desc')->get();
            return DataTables::of($sql)->addIndexColumn()
                ->addColumn('tipo', function ($row) {
                    if ($row->tipo === 1) {
                        return 'Evaluación de Personal';
                    } elseif ($row->tipo === 2) {
                        return 'Evaluación de Clientes';
                    } elseif ($row->tipo === 3) {
                        return 'Evaluación de Proveedores';
                    }
                    return 'Sin tipo de evaluación';
                })
                ->addColumn('action', function ($row) {
                    $idUsuario = Auth::id();

                    // Verificar si ya respondió (buscando en RespuestasAbiertas o RespuestasCerradas)
                    $yaRespondio = RespuestasAbiertas::where('id_usuario', $idUsuario)
                        ->whereIn('id_pregunta', function ($q) use ($row) {
                            $q->select('id_pregunta')
                                ->from('preguntas')
                                ->where('id_encuesta', $row->id_encuesta);
                        })
                        ->exists()
                        ||
                        RespuestasCerradas::where('id_usuario', $idUsuario)
                        ->whereIn('id_opcion', function ($q) use ($row) {
                            $q->select('id_opcion')
                                ->from('preguntas_opciones')
                                ->whereIn('id_pregunta', function ($q2) use ($row) {
                                    $q2->select('id_pregunta')
                                        ->from('preguntas')
                                        ->where('id_encuesta', $row->id_encuesta);
                                });
                        })
                        ->exists();

                    $btn = '<div class="dropdown d-flex justify-content-center">
                    <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_encuesta . '">';

                    if ($yaRespondio) {
                        // Mostrar opción de Ver respuestas
                        $btn .= '<li>
                            <a class="dropdown-item" href="' . route('encuestas.verRespuestas', $row->id_encuesta) . '">
                                <i class="ri-search-fill ri-20px text-normal"></i> Ver respuestas
                            </a>
                        </li>';
                    } else {
                        
                        // Mostrar opción de Responder

                    }
                                            $btn .= '<li>
                            <a class="dropdown-item" href="' . route('encuestas.answer', $row->id_encuesta) . '">
                                <i class="ri-file-check-fill ri-20px text-primary"></i> Responder
                            </a>
                        </li>';

                    // Siempre mostrar editar si aplica
                    $btn .= '<li>
                        <a class="dropdown-item text-normal" href="' . route('encuestas.edit', $row->id_encuesta) . '">
                            <i class="ri-file-edit-fill ri-20px text-info"></i> Editar
                        </a>
                    </li>
                    </ul></div>';

                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('encuestas.encuestas');
    }


    public function create()
    {
        return view('encuestas.crear_encuesta', [
            'encuesta' => new EncuestasModel(),
            'mode' => 'create'
        ]);
    }

    public function store(Request $request)
    {

        DB::transaction(function () use ($request) {
            // Crear la encuesta
            $encuesta = EncuestasModel::create([
                'encuesta' => $request->title,
                'tipo' => $request->target_type,
                'id_usuario' => Auth::id(),
                'created_at' => now()
            ]);

            // Recorrer las preguntas y guardarlas
            foreach ($request->questions as $index => $questionData) {
                $pregunta = PreguntasModel::create([
                    'id_encuesta' => $encuesta->id_encuesta,
                    'pregunta' => $questionData['question_text'],
                    'tipo_pregunta' => $questionData['question_type'],
                ]);

                // Si la pregunta tiene opciones, guardarlas
                if ($questionData['question_type'] !== 'open' && isset($questionData['options'])) {
                    foreach ($questionData['options'] as $optionText) {
                        OpcionesModel::create([
                            'id_pregunta' => $pregunta->id_pregunta,
                            'opcion' => $optionText,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('encuestas.index')->with('success', 'Encuesta creada exitosamente');
    }


    public function show(EncuestasModel $encuesta)
    {
        $encuesta->load('preguntas');
        return view('encuestas.crear_encuesta', [
            'encuesta' => $encuesta,
            'mode' => 'view'
        ]);
    }

    public function edit(EncuestasModel $encuesta)
    {
        $encuesta->load('preguntas');
        return view('encuestas.crear_encuesta', [
            'encuesta' => $encuesta,
            'mode' => 'edit'
        ]);
    }

    public function update(Request $request, EncuestasModel $encuesta)
    {
        // Validación de datos
        $request->validate([
            'title' => 'required|string|max:255',
            'target_type' => 'required|in:1,2,3',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:1,2,3',
            'questions.*.options' => 'nullable|array'
        ]);

        DB::transaction(function () use ($request, $encuesta) {
            $encuesta->update([
                'encuesta' => $request->title,
                'tipo' => $request->target_type,
                'updated_at' => now()
            ]);

            $encuesta->preguntas()->each(function ($pregunta) {
                $pregunta->opciones()->delete();
                $pregunta->delete();
            });

            foreach ($request->questions as $index => $questionData) {
                $nuevaPregunta = PreguntasModel::create([
                    'id_encuesta' => $encuesta->id_encuesta,
                    'pregunta' => $questionData['question_text'],
                    'tipo_pregunta' => $questionData['question_type'],
                ]);

                if (isset($questionData['options']) && is_array($questionData['options'])) {
                    foreach ($questionData['options'] as $opcionTexto) {
                        OpcionesModel::create([
                            'id_pregunta' => $nuevaPregunta->id_pregunta,
                            'opcion' => $opcionTexto,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('encuestas.index')->with('success', 'Encuesta actualizada exitosamente');
    }

 public function answer($id)
    {
        $encuesta = EncuestasModel::with('preguntas.opciones')->findOrFail($id);

        $evaluados = match ($encuesta->tipo) {
            1 => User::where('tipo', 1)->get(),
            2 => User::where('tipo', 3)->get(),
            3 => CatalogoProveedor::all(),
            default => collect(),
        };

        return view('encuestas.responder_encuesta', [
            'encuesta' => $encuesta,
            'modoLectura' => false, // Modo responder
            'respuestasUsuario' => [],
            'evaluados' => $evaluados,
            'evaluadoNombre' => null // No es necesario en este modo, pero se inicializa para evitar errores
        ]);
    }

    public function storeRespuestas(Request $request)
    {
        $request->validate([
            'id_encuesta' => 'required|exists:encuestas,id_encuesta',
            'aEvaluar' => 'required',
            'respuestas' => 'required|array',
        ]);

        $idUsuario = Auth::id();
        $idEvaluado = $request->aEvaluar;

        foreach ($request->respuestas as $id_pregunta => $respuesta) {
            $pregunta = PreguntasModel::findOrFail($id_pregunta);
            
            // Usar el tipo de la pregunta para el modelo correcto
            if ($pregunta->tipo_pregunta == 1) {
                RespuestasAbiertas::create([
                    'id_pregunta' => $id_pregunta,
                    'respuesta' => $respuesta,
                    'id_evaluado' => $idEvaluado,
                    'id_usuario' => $idUsuario,
                    'created_at' => now()
                ]);

            } elseif ($pregunta->tipo_pregunta == 2) {
                 RespuestasCerradas::create([
                    'id_opcion' => $respuesta,
                    'id_evaluado' => $idEvaluado,
                    'id_usuario' => $idUsuario,
                    'created_at' => now()
                ]);

            } elseif ($pregunta->tipo_pregunta == 3) {
                foreach ($respuesta as $id_opcion) {
                    RespuestasCerradas::create([
                        'id_opcion' => $id_opcion,
                        'id_evaluado' => $idEvaluado,
                        'id_usuario' => $idUsuario,
                        'created_at' => now()
                    ]);
                }
            }
        }

        return redirect()->route('encuestas.index')->with('success', 'Respuestas guardadas correctamente');
    }

    public function verRespuestas($idEncuesta)
    {
        $encuesta = EncuestasModel::with(['preguntas.opciones'])->findOrFail($idEncuesta);
        $idUsuario = Auth::id();

        // Obtener la respuesta para obtener el id_evaluado
        $primeraRespuesta = RespuestasAbiertas::where('id_usuario', $idUsuario)
            ->whereIn('id_pregunta', $encuesta->preguntas->pluck('id_pregunta'))
            ->first();

        if (!$primeraRespuesta) {
            $primeraRespuesta = RespuestasCerradas::where('id_usuario', $idUsuario)
                ->whereIn('id_opcion', function($query) use ($encuesta) {
                    $query->select('id_opcion')
                          ->from('preguntas_opciones')
                          ->whereIn('id_pregunta', $encuesta->preguntas->pluck('id_pregunta'));
                })
                ->first();
        }

        $evaluadoNombre = null;
        if ($primeraRespuesta) {
            switch ($encuesta->tipo) {
                case 1:
                case 2:
                    $evaluado = User::find($primeraRespuesta->id_evaluado);
                    $evaluadoNombre = $evaluado->name ?? 'N/A';
                    break;
                case 3:
                    $evaluado = CatalogoProveedor::find($primeraRespuesta->id_evaluado);
                    $evaluadoNombre = $evaluado->razon_social ?? 'N/A';
                    break;
            }
        }

        // respuestas del usuario
        $respuestasAbiertas = RespuestasAbiertas::where('id_usuario', $idUsuario)
            ->whereIn('id_pregunta', $encuesta->preguntas->where('tipo_pregunta', 1)->pluck('id_pregunta'))
            ->get()
            ->keyBy('id_pregunta');

        $respuestasCerradas = RespuestasCerradas::where('id_usuario', $idUsuario)
            ->whereIn('id_opcion', function ($q) use ($encuesta) {
                $q->select('id_opcion')
                  ->from('preguntas_opciones')
                  ->whereIn('id_pregunta', $encuesta->preguntas->whereIn('tipo_pregunta', [2, 3])->pluck('id_pregunta'));
            })
            ->get();
        
        // Mapear en un formato que el blade pueda leer igual que en modo responder
        $respuestasUsuario = [];
        foreach ($encuesta->preguntas as $pregunta) {
            if ($pregunta->tipo_pregunta == 1 && isset($respuestasAbiertas[$pregunta->id_pregunta])) {
                $respuestasUsuario[$pregunta->id_pregunta] = $respuestasAbiertas[$pregunta->id_pregunta]->respuesta;
            } elseif ($pregunta->tipo_pregunta == 2) {
                $opcionSeleccionada = $respuestasCerradas->first(function ($r) use ($pregunta) {
                    return OpcionesModel::find($r->id_opcion)->id_pregunta === $pregunta->id_pregunta;
                });
                if ($opcionSeleccionada) {
                    $respuestasUsuario[$pregunta->id_pregunta] = $opcionSeleccionada->id_opcion;
                }
            } elseif ($pregunta->tipo_pregunta == 3) {
                $opcionesSeleccionadas = $respuestasCerradas->filter(function ($r) use ($pregunta) {
                    return OpcionesModel::find($r->id_opcion)->id_pregunta === $pregunta->id_pregunta;
                })->pluck('id_opcion')->toArray();
                if (!empty($opcionesSeleccionadas)) {
                    $respuestasUsuario[$pregunta->id_pregunta] = $opcionesSeleccionadas;
                }
            }
        }

        return view('encuestas.responder_encuesta', [
            'encuesta' => $encuesta,
            'modoLectura' => true, // Modo solo lectura
            'respuestasUsuario' => $respuestasUsuario,
            'evaluadoNombre' => $evaluadoNombre,
            'evaluados' => collect()
        ]);
    }

}
