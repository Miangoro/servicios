<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Convenio;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class ConvenioController extends Controller
{
    /**
     * Muestra la vista principal del catálogo de convenios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('convenios.find_convenio');
    }

    /**
     * Procesa la solicitud AJAX de DataTables para obtener los convenios.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getConvenios(Request $request)
    {
        try {
            if ($request->ajax()) {
                $convenios = Convenio::select('id_convenio', 'clave', 'nombre_proyecto', 'investigador_responsable', 'duracion', 'tipo_duracion');
                
                return DataTables::of($convenios)
                    ->addIndexColumn()
                    ->addColumn('acciones', function($row){
                        $btn = '
                        <div class="dropdown">
                            <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" type="button" id="dropdownMenuButton' . $row->id_convenio . '" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id_convenio . '">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="visualizarConvenio('.$row->id_convenio.')">
                                        <i class="ri-search-fill ri-20px text-normal me-2"></i>Visualizar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item btn-edit" href="javascript:void(0)" data-id="' . $row->id_convenio . '"
                                        data-clave="' . htmlspecialchars($row->clave) . '"
                                        data-nombre="' . htmlspecialchars($row->nombre_proyecto) . '"
                                        data-investigador="' . htmlspecialchars($row->investigador_responsable) . '"
                                        data-duracion="' . $row->duracion . '"
                                        data-tipo-duracion="' . htmlspecialchars($row->tipo_duracion) . '">
                                        <i class="ri-file-edit-fill ri-20px text-info"></i>Editar
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger btn-delete" href="javascript:void(0)" data-id="' . $row->id_convenio . '">
                                        <i class="ri-delete-bin-2-fill ri-20px text-danger"></i> Eliminar
                                    </a>
                                </li>
                            </ul>
                        </div>';
                        return $btn;
                    })
                    ->rawColumns(['acciones'])
                    ->make(true);
            }
            
            return redirect()->route('convenios.index');
            
        } catch (\Exception $e) {
            Log::error('Error al obtener convenios para DataTables: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'No se pudieron cargar los datos del convenio.',
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('convenios.index')->with('error', 'No se pudieron cargar los datos.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo convenio.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('convenios.find_convenio');
    }

    /**
     * Almacena un nuevo convenio en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'clave' => 'required|string|max:255|unique:catalogo_convenio,clave',
                'nombre_proyecto' => 'required|string|max:255',
                'investigador_responsable' => 'required|string|max:255',
                'duracion' => 'required|numeric',
                'tipo_duracion' => 'required|string|in:mes,año,semanas,dias',
            ]);

            $convenio = Convenio::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => '¡El convenio se ha registrado correctamente!',
                'data' => $convenio,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'La clave del convenio ya existe. Por favor, ingrese una clave diferente.',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error inesperado al guardar el convenio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra el convenio especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $convenio = Convenio::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $convenio
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al visualizar convenio: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'No se pudo encontrar el convenio solicitado.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Actualiza el convenio especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Convenio  $convenio
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Convenio $convenio)
    {
        try {
            // Se definen las reglas de validación para los campos
            $rules = [
                'nombre_proyecto' => 'required|string|max:255',
                'investigador_responsable' => 'required|string|max:255',
                'duracion' => 'required|numeric',
                'tipo_duracion' => 'required|string|in:mes,año,semanas,dias',
            ];

            // Solo validar la clave si está presente en la solicitud y no está vacía
            // Usamos $convenio->id_convenio que ahora es conocido por el modelo
            if ($request->filled('clave') && $request->clave !== $convenio->clave) {
                 $rules['clave'] = 'string|max:255|unique:catalogo_convenio,clave,' . $convenio->id_convenio . ',id_convenio';
            }
            
            // Validar los datos
            $validatedData = $request->validate($rules);
            
            // Actualizar el modelo con los datos validados
            $convenio->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => '¡El convenio se ha actualizado correctamente!',
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al actualizar convenio: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error inesperado al actualizar el convenio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Elimina el convenio especificado de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $convenio = Convenio::findOrFail($id);
            $convenio->delete();

            return response()->json([
                'success' => true,
                'message' => '¡El convenio se ha eliminado correctamente!',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error inesperado al eliminar el convenio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}