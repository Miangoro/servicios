<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\CatalogoLaboratorio;
use App\Models\CatalogoClave;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;
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
            $data = Servicio::with(['laboratorios' => function ($query) {
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
                    // Se utiliza la ruta con el ID del servicio
                    $btn .= '<a href="'.route('servicios.show', $row->id_servicio).'" class="btn btn-sm btn-info me-1" title="Ver"><i class="ri-eye-line"></i></a>';
                    $btn .= '<a href="'.route('servicios.edit', $row->id_servicio).'" class="btn btn-sm btn-warning me-1" title="Editar"><i class="ri-edit-2-line"></i></a>';
                    $btn .= '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-eliminar" title="Eliminar" data-id="' . $row->id_servicio . '"><i class="ri-delete-bin-line"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['acciones'])
                ->make(true);
        }
        
        $claves_laboratorio = CatalogoLaboratorio::pluck('clave')->unique()->sort()->values();
        $precios = Servicio::pluck('precio')->unique()->sort();
        $laboratorios = CatalogoLaboratorio::all();

        return view('servicios.find_servicios_especializados_view', compact('laboratorios', 'claves_laboratorio', 'precios'));
    }

    /**
     * Muestra los detalles de un servicio específico.
     * @param Servicio $servicio
     * @return \Illuminate\View\View
     */
    public function show(Servicio $servicio)
    {
        $servicio->load('laboratorios');
        
        return view('servicios.show', compact('servicio'));
    }

    /**
     * Muestra el formulario para agregar un nuevo servicio.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $claves = CatalogoLaboratorio::all();
        $laboratorios = CatalogoLaboratorio::all();
        
        return view('servicios.find_agregar_servicios_especializados_view', compact('claves', 'laboratorios'));
    }

    /**
     * Almacena un nuevo servicio en la base de datos.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Reglas de validación. La regla 'clave' se eliminará ya que ahora se genera automáticamente.
        $rules = [
            'clave_adicional' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'duracion' => 'required|string|max:255',
            'requiere_muestra' => ['required', Rule::in(['si', 'no'])],
            'descripcion_muestra' => 'nullable|string',
            'acreditacion' => 'nullable|string|max:255',
            'id_habilitado' => 'nullable|string|max:255',
            'analisis' => 'required|string|max:255',
            'unidades' => 'required|string|max:255',
            'metodo' => 'nullable|string|max:255',
            'cant_muestra' => 'nullable|string|max:255',
            'prueba' => 'nullable|string',
            'precios_laboratorio' => 'required|array|min:1',
            'precios_laboratorio.*' => 'required|numeric',
            'laboratorios_responsables' => 'required|array|min:1',
            'laboratorios_responsables.*' => 'required|exists:catalogo_laboratorios,id_laboratorio',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();

        try {
            // Se obtiene la clave del laboratorio responsable. Si se selecciona más de uno,
            // usaremos el primero para generar la clave del servicio.
            $idPrimerLaboratorio = $request->laboratorios_responsables[0];
            $laboratorioPrincipal = CatalogoLaboratorio::findOrFail($idPrimerLaboratorio);
            $claveBase = $laboratorioPrincipal->clave;

            // Busca el último servicio registrado con esa clave base
            $ultimoServicio = Servicio::where('clave', 'like', "{$claveBase}-%")->latest('id_servicio')->first();
            $contador = 1;

            if ($ultimoServicio) {
                // Si existe, extrae el número y lo incrementa
                $ultimaClave = $ultimoServicio->clave;
                $partes = explode('-', $ultimaClave);
                if (count($partes) > 1 && is_numeric(end($partes))) {
                    $contador = (int)end($partes) + 1;
                }
            }

            // Genera la nueva clave del servicio
            $nuevaClave = "{$claveBase}-{$contador}";
            
            $servicio = new Servicio();
            $servicio->clave = $nuevaClave; // Asigna la clave generada
            $servicio->especificaciones = $request->input('especificaciones');
            $servicio->nombre = $request->input('nombre');
            $servicio->precio = $request->input('precio');
            $servicio->duracion = $request->input('duracion');
            $servicio->tipo_muestra = $request->input('tipo_muestra');
            $servicio->cant_muestra = $request->input('cant_muestra', 0);
            
            $servicio->id_habilitado = $request->input('id_habilitado', 0); 
            $servicio->id_acreditacion = $request->input('id_acreditacion', 0);
            $servicio->id_categoria = $request->input('id_categoria', 0);

            $servicio->analisis = $request->input('analisis');
            $servicio->unidades = $request->input('unidades');
            $servicio->metodo = $request->input('metodo');
            $servicio->prueba = $request->input('prueba');
            
            $servicio->tipo_servicio = 2;
            $servicio->id_usuario = auth()->id() ?? 1;

            $servicio->save();

            $laboratoriosData = collect($request->laboratorios_responsables)
                ->mapWithKeys(function ($idLaboratorio, $index) use ($request) {
                    return [$idLaboratorio => ['precio' => $request->precios_laboratorio[$index]]];
                })->toArray();

            $servicio->laboratorios()->sync($laboratoriosData);

            DB::commit();

            return redirect()->route('servicios.index')->with('success', 'Servicio agregado con éxito. La clave generada es: ' . $nuevaClave);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('servicios.index')->with('error', 'Ocurrió un error al guardar el servicio: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para editar un servicio existente.
     * @param Servicio $servicio
     * @return \Illuminate\View\View
     */
    public function edit(Servicio $servicio)
    {
        $servicio->load('laboratorios');
        $claves = CatalogoLaboratorio::all();
        $laboratorios = CatalogoLaboratorio::all();
        
        return view('servicios.edit', compact('servicio', 'claves', 'laboratorios'));
    }

    /**
     * Actualiza un servicio existente en la base de datos.
     * @param Request $request
     * @param Servicio $servicio
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Servicio $servicio)
    {
        $rules = [
            'clave' => [
                'required',
                'string',
                'max:255',
                // Validación para que la clave sea única, ignorando el servicio actual
                Rule::unique('servicios_servicios', 'clave')->ignore($servicio->id_servicio, 'id_servicio'),
            ],
            'clave_adicional' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'duracion' => 'required|string|max:255',
            'requiere_muestra' => ['required', Rule::in(['si', 'no'])],
            'descripcion_muestra' => 'nullable|string',
            'id_acreditacion' => 'required|in:0,1',
            'nombre_acreditacion' => 'nullable|string|max:255',
            'descripcion_acreditacion' => 'nullable|string',
            'id_habilitado' => 'required|in:1,2,3',
            'analisis' => 'required|string|max:255',
            'unidades' => 'required|string|max:255',
            'prueba' => 'required|string',
            'precios_laboratorio' => 'required|array|min:1',
            'precios_laboratorio.*' => 'required|numeric',
            'laboratorios_responsables' => 'required|array|min:1',
            'laboratorios_responsables.*' => 'required|exists:catalogo_laboratorios,id_laboratorio',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Error de validación', 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            $servicio->clave = $request->input('clave');
            $servicio->clave_adicional = $request->input('clave_adicional');
            $servicio->nombre = $request->input('nombre');
            $servicio->precio = $request->input('precio');
            $servicio->duracion = $request->input('duracion');
            $servicio->requiere_muestra = $request->input('requiere_muestra');
            $servicio->descripcion_muestra = $request->input('descripcion_muestra');
            $servicio->id_acreditacion = $request->input('id_acreditacion');
            $servicio->nombre_acreditacion = $request->input('nombre_acreditacion');
            $servicio->descripcion_acreditacion = $request->input('descripcion_acreditacion');
            $servicio->id_habilitado = $request->input('id_habilitado');
            $servicio->analisis = $request->input('analisis');
            $servicio->unidades = $request->input('unidades');
            $servicio->prueba = $request->input('prueba');

            $servicio->save();

            $laboratoriosData = collect($request->laboratorios_responsables)
                ->mapWithKeys(function ($idLaboratorio, $index) use ($request) {
                    return [$idLaboratorio => ['precio' => $request->precios_laboratorio[$index]]];
                })->toArray();

            $servicio->laboratorios()->sync($laboratoriosData);

            DB::commit();

            return redirect()->route('servicios.index')->with('success', 'Servicio actualizado con éxito.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('servicios.index')->with('error', 'Ocurrió un error al actualizar el servicio: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un servicio de la base de datos.
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
     * Exporta los servicios filtrados a un archivo de Excel.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel(Request $request)
    {
        $query = Servicio::query();

        if ($request->input('activar_clave') == 'on' && $request->input('clave') !== 'todos') {
            $query->where('clave', $request->input('clave'));
        }

        if ($request->input('activar_estatus') == 'on' && !empty($request->input('estatus'))) {
            $query->where('id_habilitado', $request->input('estatus'));
        }
        
        if ($request->input('activar_acreditado') == 'on' && $request->input('acreditado') !== '0') {
            $query->where('id_acreditacion', $request->input('acreditado')); 
        }

        if ($request->input('activar_laboratorio_nombre') == 'on' && $request->input('laboratorio_nombre') !== 'todos') {
            $query->whereHas('laboratorios', function ($q) use ($request) {
                $q->where('catalogo_laboratorios.laboratorio', 'like', '%' . $request->input('laboratorio_nombre') . '%');
            });
        }

        if ($request->input('activar_precio') == 'on' && $request->input('precio') !== 'todos') {
            $query->where('precio', $request->input('precio'));
        }

        $servicios = $query->with('laboratorios')->get();

        return Excel::download(new ServiciosExport($servicios), 'servicios.xlsx');
    }
}
