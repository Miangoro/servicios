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
                $data = Convenio::select('id_convenio', 'clave', 'nombre_proyecto', 'investigador_responsable', 'duracion', 'tipo_duracion')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('acciones', function($row){
                        $btn = '<div class="btn-group" role="group" aria-label="Acciones">';
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id_convenio.'" data-original-title="Editar" class="edit btn btn-primary btn-sm mx-1 editConvenio">Editar</a>';
                        $btn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id_convenio.'" data-original-title="Eliminar" class="btn btn-danger btn-sm mx-1 deleteConvenio">Eliminar</a>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['acciones'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            // Loguea el error para poderlo revisar en el archivo de logs de Laravel
            Log::error('Error al obtener convenios para DataTables: ' . $e->getMessage());

            // Devuelve una respuesta JSON con el error para que el cliente lo maneje
            return response()->json([
                'error' => 'No se pudieron cargar los datos del convenio. Por favor, intente de nuevo más tarde.',
                'message' => $e->getMessage()
            ], 500); // Código de estado HTTP 500 (Internal Server Error)
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
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'clave' => 'required|string|max:255|unique:catalogo_convenio,clave',
                'nombre_proyecto' => 'required|string|max:255',
                'investigador_responsable' => 'required|string|max:255',
                'duracion' => 'required|numeric',
                'tipo_duracion' => 'required|string|in:mes,año,semanas,dias',
            ]);

            // Se crea un nuevo convenio directamente con los datos validados
            $convenio = Convenio::create($validatedData);

            // Retornar una respuesta JSON de éxito con el nuevo registro
            return response()->json([
                'success' => true,
                'message' => '¡El convenio se ha registrado correctamente!',
                'data' => $convenio,
            ], 201);

        } catch (ValidationException $e) {
            // Retornar errores de validación como una respuesta JSON
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            // Manejar errores específicos de la base de datos (por ejemplo, clave duplicada)
            return response()->json([
                'success' => false,
                'message' => 'La clave del convenio ya existe. Por favor, ingrese una clave diferente.',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            // Retornar un error genérico como una respuesta JSON para otros errores
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error inesperado al guardar el convenio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}