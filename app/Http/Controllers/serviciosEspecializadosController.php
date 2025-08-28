<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\CatalogoLaboratorio;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\Rule;

class serviciosEspecializadosController extends Controller
{
    // ... (El método index no necesita cambios)

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


    // ... (El método create no necesita cambios)

    public function create()
    {
        $claves = CatalogoLaboratorio::all();
        $laboratorios = CatalogoLaboratorio::all();
        
        return view('servicios.find_agregar_servicios_especializados_view', compact('claves', 'laboratorios'));
    }


    public function store(Request $request)
    {
        $rules = [
            'clave' => 'required|string|max:255',
            'clave_adicional' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'duracion' => 'required|string|max:255',
            'requiere_muestra' => ['required', Rule::in(['si', 'no'])],
            'tipo_muestra' => 'nullable|string',
            'acreditacion' => 'nullable|string|max:255',
            'id_habilitado' => 'nullable|string|max:255',
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
            'laboratorios_responsables.*' => 'required|exists:catalogo_laboratorios,id_laboratorio',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();

        try {
            $servicio = new Servicio();
            $servicio->clave = $request->input('clave');
            $servicio->especificaciones = $request->input('especificaciones'); // Correcto: la tabla tiene esta columna
            $servicio->nombre = $request->input('nombre');
            $servicio->precio = $request->input('precio');
            $servicio->duracion = $request->input('duracion');
            $servicio->tipo_muestra = $request->input('tipo_muestra');
            $servicio->cant_muestra = $request->input('cant_muestra', 0);
            
            // Asignación de valores por defecto si no están presentes
            $servicio->id_habilitado = $request->input('id_habilitado', 0); 
            $servicio->id_acreditacion = $request->input('id_acreditacion', 0);
            $servicio->id_categoria = $request->input('id_categoria', 0);

            $servicio->analisis = $request->input('analisis');
            $servicio->unidades = $request->input('unidades');
            $servicio->metodo = $request->input('metodo');
            $servicio->prueba = $request->input('prueba');
            
            $requisitos = array_filter($request->input('requisitos', []));
            $servicio->requisitos = count($requisitos) > 0 ? json_encode($requisitos) : null;
            
            if ($request->hasFile('file_requisitos')) {
                $file = $request->file('file_requisitos');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('requisitos_archivos', $filename, 'public');
                $servicio->url_requisitos = $filePath;
            }

            $servicio->tipo_servicio = 2;
            $servicio->id_usuario = auth()->id() ?? 1;

            $servicio->save();

            $laboratoriosData = [];
            if ($request->has('laboratorios_responsables')) {
                foreach ($request->laboratorios_responsables as $index => $idLaboratorio) {
                    if (isset($request->precios_laboratorio[$index])) {
                        $laboratoriosData[$idLaboratorio] = ['precio' => $request->precios_laboratorio[$index]];
                    }
                }
            }

            $servicio->laboratorios()->sync($laboratoriosData);

            DB::commit();

            return redirect()->route('servicios.index')->with('success', 'Servicio agregado con éxito.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('servicios.index')->with('error', 'Ocurrió un error al guardar el servicio: ' . $e->getMessage());
        }
    }
}