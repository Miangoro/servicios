<?php

namespace App\Http\Controllers;

use App\Models\EncuestasModel;
use App\Models\OpcionesModel;
use App\Models\PreguntasModel;
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
                ->addColumn('action', function ($row) {

                    $btn = '
                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_encuesta . '">' .
                        '<li>
                                <a class="dropdown-item" href="' . route('encuestas.show', $row->id_encuesta) . '">' .
                        '<i class="ri-search-fill ri-20px text-normal"></i> Ver' .
                        '</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-normal" href="' . route('encuestas.edit', $row->id_encuesta) . '">' .
                        '<i class="ri-file-edit-fill ri-20px text-info"></i> Editar' .
                        '</a>
                            </li>'
                        . '</ul>
                          
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('catalogo.encuestas');
    }


    public function create()
    {
        return view('catalogo.crear_encuesta', [
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
        return view('catalogo.crear_encuesta', [
            'encuesta' => $encuesta,
            'mode' => 'view'
        ]);
    }

    public function edit(EncuestasModel $encuesta)
    {
        $encuesta->load('preguntas');
        return view('catalogo.crear_encuesta', [
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
            // Paso 1: Actualizar la información básica de la encuesta
            $encuesta->update([
                'encuesta' => $request->title,
                'tipo' => $request->target_type,
                'updated_at' => now()
            ]);

            // Paso 2: Eliminar preguntas y sus opciones existentes
            // Se elimina todo lo relacionado con esta encuesta para luego crearlo de nuevo.
            $encuesta->preguntas()->each(function ($pregunta) {
                $pregunta->opciones()->delete();
                $pregunta->delete();
            });

            // Paso 3: Crear las nuevas preguntas y sus opciones
            foreach ($request->questions as $index => $questionData) {
                // Aquí se crea la pregunta con el ID de la encuesta, solucionando el error
                $nuevaPregunta = PreguntasModel::create([
                    'id_encuesta' => $encuesta->id_encuesta, // <-- ¡Este es el cambio clave!
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
}
