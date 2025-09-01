<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\CatalogoLaboratorio;
use App\Models\ServicioTracking;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Exports\ServiciosExport;
use Maatwebsite\Excel\Facades\Excel;

class ServiciosEspecializadosController extends Controller
{
    /**
     * Muestra la vista principal de servicios especializados con una tabla de datos.
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Servicio::with('laboratorios')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('laboratorio', function($row) {
                    if ($row->laboratorios->isNotEmpty()) {
                        return $row->laboratorios->map(function($lab) {
                            return "{$lab->laboratorio} ({$lab->pivot->precio})";
                        })->implode(', ');
                    } else {
                        return 'No hay laboratorios asignados';
                    }
                })
                ->addColumn('estatus', function($row) {
                    $clase = $row->id_habilitado ? 'habilitado' : 'deshabilitado';
                    $texto = $row->id_habilitado ? 'Habilitado' : 'Deshabilitado';
                    return '<span class="estatus-label ' . $clase . '">' . $texto . '</span>';
                })
                ->addColumn('acciones', function($row){
                    $btn = '<div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="'.route('servicios.show', $row->id_servicio).'">
                                        <i class="ri-eye-line me-2"></i>Visualizar
                                    </a></li>
                                    <li><a class="dropdown-item" href="'.route('servicios.edit', $row->id_servicio).'">
                                        <i class="ri-edit-line me-2"></i>Editar
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button class="dropdown-item toggle-status-btn" data-id="'.$row->id_servicio.'" data-status="'.($row->id_habilitado ? 0 : 1).'">
                                            <i class="'.($row->id_habilitado ? 'ri-close-line' : 'ri-check-line').' me-2"></i>'.($row->id_habilitado ? 'Deshabilitar' : 'Habilitar').'
                                        </button>
                                    </li>
                                </ul>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['acciones', 'laboratorio', 'estatus'])
                ->make(true);
        }
        
        $claves_laboratorio = CatalogoLaboratorio::pluck('clave')->unique()->sort()->values();
        $precios = Servicio::pluck('precio')->unique()->sort();
        $laboratorios = CatalogoLaboratorio::all();
        
        // Obtiene todas las claves únicas de la tabla de servicios
        $claves = Servicio::distinct()->pluck('clave')->sort();

        // Pasa las variables a la vista, incluyendo las claves de servicio
        return view('servicios.find_servicios_especializados_view', compact('laboratorios', 'claves_laboratorio', 'precios', 'claves'));
    }
    
    /**
     * Alterna el estado de habilitado de un servicio.
     * @param Request $request
     * @param int $id_servicio
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request, $id_servicio)
    {
        try {
            // Busca el servicio por su ID o lanza una excepción si no lo encuentra
            $servicio = Servicio::findOrFail($id_servicio);
            
            // Determina el nuevo estado: si está habilitado (1), se deshabilitará (0) y viceversa
            $newStatus = $servicio->id_habilitado == 1 ? 0 : 1;
            
            // Actualiza el campo id_habilitado con el nuevo estado
            $servicio->id_habilitado = $newStatus;
            $servicio->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado del servicio actualizado correctamente.',
                'newStatus' => $newStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Displays the details of a specific service.
     * @param Servicio $servicio
     * @return \Illuminate\View\View
     */
    public function show(Servicio $servicio)
    {
        // Carga la relación 'laboratorios' para la vista de visualización
        $servicio->load('laboratorios');
        
        return view('servicios.show', compact('servicio'));
    }

    /**
     * Displays the form to add a new service.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $claves = CatalogoLaboratorio::all();
        $laboratorios = CatalogoLaboratorio::all();
        
        return view('servicios.find_agregar_servicios_especializados_view', compact('claves', 'laboratorios'));
    }

    /**
     * Stores a new service in the database.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'clave_adicional' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'duracion' => 'required|string|max:255',
            'requiere_muestra' => ['required', Rule::in(['si', 'no'])],
            'especificaciones' => 'nullable|string',
            'acreditacion' => 'required|string|max:255',
            'id_habilitado' => 'nullable|in:1,0',
            'analisis' => 'required|string|max:255',
            'unidades' => 'required|string|max:255',
            'metodo' => 'nullable|string|max:255',
            'prueba' => 'nullable|string',
            'precios_laboratorio' => 'required|array|min:1',
            'precios_laboratorio.*' => 'required|numeric',
            'laboratorios_responsables' => 'required|array|min:1',
            'laboratorios_responsables.*' => 'required|exists:catalogo_laboratorios,id_laboratorio',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();

        try {
            $idPrimerLaboratorio = $request->laboratorios_responsables[0];
            $laboratorioPrincipal = CatalogoLaboratorio::findOrFail($idPrimerLaboratorio);
            $claveBase = $laboratorioPrincipal->clave;

            $ultimoServicio = Servicio::where('clave', 'like', "{$claveBase}-%")->latest('id_servicio')->first();
            $contador = 1;

            if ($ultimoServicio) {
                $ultimaClave = $ultimoServicio->clave;
                $partes = explode('-', $ultimaClave);
                if (count($partes) > 1 && is_numeric(end($partes))) {
                    $contador = (int)end($partes) + 1;
                }
            }

            $nuevaClave = "{$claveBase}-{$contador}";
            
            $servicio = new Servicio();
            $servicio->clave = $nuevaClave;
            $servicio->especificaciones = $request->input('especificaciones');
            $servicio->nombre = $request->input('nombre');
            $servicio->precio = $request->input('precio');
            $servicio->duracion = $request->input('duracion');
            $servicio->id_requiere_muestra = ($request->input('requiere_muestra') === 'si') ? 1 : 0;
            
            if ($request->input('requiere_muestra') === 'si') {
                $servicio->descripcion_muestra = $request->input('descripcion_muestra');
            } else {
                $servicio->descripcion_muestra = '0';
            }
            
            $servicio->id_habilitado = $request->input('id_habilitado', 0);
            
            if ($request->input('acreditacion') === 'Acreditado') {
                $servicio->id_acreditacion = 1;
                $servicio->nombre_acreditacion = $request->input('nombre_acreditacion');
                $servicio->descripcion_acreditacion = $request->input('descripcion_acreditacion');
            } else {
                $servicio->id_acreditacion = 0;
                $servicio->nombre_acreditacion = '0';
                $servicio->descripcion_acreditacion = '0';
            }

            $servicio->id_categoria = $request->input('id_categoria', 0);
            $servicio->analisis = $request->input('analisis');
            $servicio->unidades = $request->input('unidades');
            $servicio->metodo = $request->input('metodo');
            $servicio->prueba = $request->input('prueba');
            $servicio->tipo_servicio = 2;
            $servicio->id_usuario = auth()->id() ?? 1;

            $servicio->save();

            $precios_laboratorio = $request->input('precios_laboratorio');
            $laboratorios_responsables = $request->input('laboratorios_responsables');
            $laboratoriosData = [];

            foreach ($laboratorios_responsables as $key => $idLaboratorio) {
                if (isset($precios_laboratorio[$key])) {
                    $laboratoriosData[$idLaboratorio] = ['precio' => $precios_laboratorio[$key]];
                }
            }
            
            $servicio->laboratorios()->sync($laboratoriosData);
            
            DB::commit();

            // Corrected: Redirect to the index view with a success message
            return redirect()->route('servicios.index')->with('success', 'Servicio agregado con éxito. La clave generada es: ' . $nuevaClave);

        } catch (\Exception $e) {
            DB::rollback();
            // Redirect back with an error message in case of failure
            return redirect()->back()->with('error', 'Ocurrió un error al guardar el servicio: ' . $e->getMessage());
        }
    }


   /**
 * Displays the form to edit an existing service. Modificado
 * @param Servicio $servicio
 * @return \Illuminate\View\View
 */
public function edit(Servicio $servicio)
{
    $servicio->load('laboratorios');
    $claves = CatalogoLaboratorio::all();
    $laboratorios = CatalogoLaboratorio::all();
    
    // Asegúrate de que el campo se está pasando correctamente
    return view('servicios.edit', compact('servicio', 'claves', 'laboratorios'));
}

    /**
     * Updates an existing service in the database.
     * @param Request $request
     * @param Servicio $servicio
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Servicio $servicio)
    {
        $rules = [
            'clave' => [
                'required',
                'string',
                'max:255',
                Rule::unique('servicios_servicios', 'clave')->ignore($servicio->id_servicio, 'id_servicio'),
            ],
            'clave_adicional' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'duracion' => 'required|string|max:255',
            'requiere_muestra' => ['required', Rule::in(['si', 'no'])],
            'descripcion_muestra' => 'nullable|string',
            'especificaciones' => 'nullable|string',
            'acreditacion' => 'required|string|max:255',
            'nombre_acreditacion' => 'nullable|string|max:255',
            'descripcion_acreditacion' => 'nullable|string',
            'id_habilitado' => 'required|in:1,0,2',
            'analisis' => 'required|string|max:255',
            'unidades' => 'required|string|max:255',
            'prueba' => 'nullable|string',
            'metodo' => 'nullable|string|max:255',
            'precios_laboratorio' => 'required|array|min:1',
            'precios_laboratorio.*' => 'required|numeric',
            'laboratorios_responsables' => 'required|array|min:1',
            'laboratorios_responsables.*' => 'required|exists:catalogo_laboratorios,id_laboratorio',
            'motivo_edicion' => 'required|string|min:10',
        ];

        $validator = Validator::make($request->all(), $rules);

        // Si la validación falla, regresa con los errores para mostrar un mensaje
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $servicio->update([
                'clave' => $request->input('clave'),
                'clave_adicional' => $request->input('clave_adicional'),
                'nombre' => $request->input('nombre'),
                'precio' => $request->input('precio'),
                'duracion' => $request->input('duracion'),
                'id_requiere_muestra' => ($request->input('requiere_muestra') === 'si') ? 1 : 0,
                'descripcion_muestra' => ($request->input('requiere_muestra') === 'si') ? $request->input('descripcion_muestra') : '0',
                'especificaciones' => $request->input('especificaciones'),
                'id_acreditacion' => ($request->input('acreditacion') === 'Acreditado') ? 1 : 0,
                'nombre_acreditacion' => ($request->input('acreditacion') === 'Acreditado') ? $request->input('nombre_acreditacion') : '0',
                'descripcion_acreditacion' => ($request->input('acreditacion') === 'Acreditado') ? $request->input('descripcion_acreditacion') : '0',
                'id_habilitado' => $request->input('id_habilitado'),
                'analisis' => $request->input('analisis'),
                'unidades' => $request->input('unidades'),
                'prueba' => $request->input('prueba'),
                'metodo' => $request->input('metodo'),
            ]);

            $precios_laboratorio = $request->input('precios_laboratorio');
            $laboratorios_responsables = $request->input('laboratorios_responsables');
            $laboratoriosData = [];
            
            foreach ($laboratorios_responsables as $key => $idLaboratorio) {
                if (isset($precios_laboratorio[$key])) {
                    $laboratoriosData[$idLaboratorio] = ['precio' => $precios_laboratorio[$key]];
                }
            }

            $servicio->laboratorios()->sync($laboratoriosData);
            
            DB::table('servicios_tracking_servicios')->insert([
                'id_servicio' => $servicio->id_servicio,
                'nombre' => 'Edición de Servicio',
                'observaciones' => $request->input('motivo_edicion'),
                'id_usuario' => auth()->id() ?? 1,
                'id_evento' => 2,
                'fecha_registro' => now(),
            ]);

            DB::commit();

            // Redirección en caso de éxito
            return redirect()->route('servicios.index')->with('success', 'El servicio se actualizó correctamente.');

        } catch (\Exception $e) {
            DB::rollback();
            // Redirección en caso de error
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el servicio: ' . $e->getMessage());
        }
    }

    /**
     * Deletes a service from the database.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            $servicio->delete();

            return response()->json(['success' => true, 'message' => 'Servicio eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el servicio: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Exports the filtered services to an Excel file.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(Request $request)
    {
        $query = Servicio::query();

        if ($request->filled('clave') && $request->input('clave') !== 'todos') {
            $query->where('clave', $request->input('clave'));
        }

        if ($request->filled('estatus') && $request->input('estatus') !== 'todos') {
            $query->where('id_habilitado', $request->input('estatus'));
        }
        
        if ($request->filled('acreditado') && $request->input('acreditado') !== '0') {
            $query->where('id_acreditacion', $request->input('acreditado')); 
        }

        if ($request->filled('nombre_laboratorio') && $request->input('nombre_laboratorio') !== 'todos') {
            $query->whereHas('laboratorios', function ($q) use ($request) {
                $q->where('catalogo_laboratorios.id_laboratorio', $request->input('nombre_laboratorio'));
            });
        }

        if ($request->filled('precio') && $request->input('precio') !== 'todos') {
            $query->where('precio', $request->input('precio'));
        }

        $servicios = $query->with('laboratorios')->get();
        $nombreArchivo = $request->input('nombre_archivo', 'servicios.xlsx');

        return Excel::download(new ServiciosExport($servicios), $nombreArchivo);
    }
}