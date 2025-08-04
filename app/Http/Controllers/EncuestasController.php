<?php

namespace App\Http\Controllers;

use App\Models\EncuestasModel;
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
                                <a class="dropdown-item" href="javascript:void(0);" onclick="viewEnc(' . $row->id_encuesta . ')">' .
                        '<i class="ri-search-fill ri-20px text-normal"></i> Ver' .
                        '</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="editEnc(' . $row->id_encuesta . ')">' .
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_type' => 'required|in:personal,clientes,proveedores',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:open,closed,multiple',
            'questions.*.options' => 'nullable|array'
        ]);

        DB::transaction(function () use ($request) {
            $survey = EncuestasModel::create([
                'title' => $request->title,
                'description' => $request->description,
                'target_type' => $request->target_type,
                'status' => 'draft'
            ]);

            foreach ($request->questions as $index => $questionData) {
                PreguntasModel::create([
                    'survey_id' => $survey->id,
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'options' => $questionData['options'] ?? [],
                    'order' => $index + 1
                ]);
            }
        });

        return redirect()->route('encuestas.index')->with('success', 'Encuesta creada exitosamente');
    }

    public function show(EncuestasModel $encuesta)
    {
        $encuesta->load('questions');
        return view('encuestas.crear_encuesta', [
            'encuesta' => $encuesta,
            'mode' => 'view'
        ]);
    }

    public function edit(EncuestasModel $encuesta)
    {
        $encuesta->load('questions');
        return view('encuestas.crear_encuesta', [
            'encuesta' => $encuesta,
            'mode' => 'edit'
        ]);
    }

    public function update(Request $request, EncuestasModel $survey)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_type' => 'required|in:personal,clientes,proveedores',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:open,closed,multiple',
            'questions.*.options' => 'nullable|array'
        ]);

        DB::transaction(function () use ($request, $survey) {
            $survey->update([
                'title' => $request->title,
                'description' => $request->description,
                'target_type' => $request->target_type
            ]);

            // Eliminar preguntas existentes
            $survey->questions()->delete();

            // Crear nuevas preguntas
            foreach ($request->questions as $index => $questionData) {
                PreguntasModel::create([
                    'survey_id' => $survey->id,
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'options' => $questionData['options'] ?? [],
                    'order' => $index + 1
                ]);
            }
        });

        return redirect()->route('encuestas.index')->with('success', 'Encuesta actualizada exitosamente');
    }
}
