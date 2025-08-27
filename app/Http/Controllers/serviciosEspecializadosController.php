<?php

namespace App\Http\Controllers;

use App\Models\serviciosModel;
use App\Models\CatalogoLaboratorio;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Exception;

class serviciosEspecializadosController extends Controller
{
    /**
     * Muestra una vista con los servicios especializados y devuelve los datos para la tabla.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = serviciosModel::with(['laboratorios' => function ($query) {
                $query->select('catalogo_laboratorios.id_laboratorio', 'catalogo_laboratorios.laboratorio', 'catalogo_laboratorios.clave');
            }])->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('laboratorio', function($row) {
                    return $row->laboratorios->map(function($lab) {
                        return "{$lab->laboratorio} ({$lab->pivot->precio}) - Clave: {$lab->clave}";
                    })->implode(', ');
                })
                ->addColumn('acciones', function($row){
                    $btn = '<div class="d-flex justify-content-center">';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm btn-info me-1" title="Ver"><i class="ri-eye-line"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm btn-warning me-1" title="Editar"><i class="ri-edit-2-line"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger" title="Eliminar"><i class="ri-delete-bin-line"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['acciones'])
                ->make(true);
        }

        $laboratorios = CatalogoLaboratorio::all();
        return view('servicios.find_servicios_especializados_view', compact('laboratorios'));
    }

    /**
     * Almacena un nuevo servicio en la base de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 1. Definir las reglas de validación con los nombres de los campos correctos
        $rules = [
            'clave' => 'required|string|max:255',
            'clave_adicional' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'duracion' => 'required|string|max:255',
            'tipo_muestra' => ['required', Rule::in(['si', 'no'])],
            // Las siguientes validaciones se ignoran para forzar el valor 1, pero se mantienen para referencia
            'acreditacion' => 'nullable|string|max:255',
            'id_habilitado' => 'nullable|string|max:255',
            // Agregamos la validación para id_categoria
            'id_categoria' => 'nullable|string|max:255',
            'analisis' => 'required|string|max:255',
            'unidades' => 'required|string|max:255',
            'metodo' => 'nullable|string|max:255',
            'cant_muestra' => 'nullable|string|max:255',
            'prueba' => 'nullable|string',
            'requisitos.*' => 'nullable|string',
            'file_requisitos' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'precios_laboratorio' => 'required|array|min:1',
            'precios_laboratorio.*' => 'required|numeric',
            'laboratorios_responsables' => 'required|array|min:1',
            'laboratorios_responsables.*' => 'required|string|exists:catalogo_laboratorios,laboratorio',
        ];

        // Crear una instancia del validador
        $validator = Validator::make($request->all(), $rules);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422); 
        }
        
        // Iniciar una transacción de base de datos
        DB::beginTransaction();

        try {
            // 2. Mapear y crear un nuevo servicio con los nombres de los campos corregidos
            $servicio = new serviciosModel();
            $servicio->clave = $request->input('clave');
            $servicio->especificaciones = $request->input('clave_adicional');
            $servicio->nombre = $request->input('nombre');
            $servicio->precio = $request->input('precio');
            $servicio->duracion = $request->input('duracion');
            $servicio->tipo_muestra = $request->input('tipo_muestra');
            $servicio->cant_muestra = $request->input('cant_muestra');
            
            // --- MODIFICACIÓN CLAVE: FORZAMOS EL VALOR A 1 SEGÚN LO SOLICITADO ---
            $servicio->id_habilitado = 1; 
            $servicio->id_acreditacion = 1;
            $servicio->id_categoria = 1;
            // --------------------------------------------------------------------

            $servicio->analisis = $request->input('analisis');
            $servicio->unidades = $request->input('unidades');
            $servicio->metodo = $request->input('metodo');
            $servicio->prueba = $request->input('prueba');
            
            $requisitos = $request->input('requisitos', []);
            $servicio->requisitos = json_encode(array_filter($requisitos));

            // Subir el archivo si existe
            if ($request->hasFile('file_requisitos')) {
                $file = $request->file('file_requisitos');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('requisitos_archivos', $filename, 'public');
                $servicio->url_requisitos = $filePath;
            }

            // Establecer valores adicionales
            $servicio->tipo_servicio = 2;
            $servicio->id_usuario = auth()->id() ?? 1;
            
            $servicio->save();

            // 3. Guardar los precios y laboratorios en la tabla intermedia
            $laboratoriosData = [];
            if ($request->has('laboratorios_responsables')) {
                // Obtener los IDs de los laboratorios por su nombre
                $laboratorios = CatalogoLaboratorio::whereIn('laboratorio', $request->laboratorios_responsables)->pluck('id_laboratorio', 'laboratorio');
                foreach ($request->laboratorios_responsables as $index => $laboratorioNombre) {
                    $idLaboratorio = $laboratorios[$laboratorioNombre] ?? null;
                    if ($idLaboratorio && isset($request->precios_laboratorio[$index])) {
                        $laboratoriosData[$idLaboratorio] = ['precio' => $request->precios_laboratorio[$index]];
                    }
                }
            }

            $servicio->laboratorios()->sync($laboratoriosData);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Servicio agregado con éxito!'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al guardar el servicio: ' . $e->getMessage()], 500);
        }
    }
}
