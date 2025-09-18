<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\serviciosModel;
use App\Models\serviciosTrackingModel;
use App\Models\serviciosLabModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Servicio;

class ServiciosCatalogoController extends Controller
{
    /**
     * Muestra la lista de servicios del catálogo y maneja las peticiones AJAX para DataTables.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql = Servicio::orderBy('id_servicio', 'desc')->get();

            return DataTables::of($sql)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_servicio . '">' .
                        '<li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="visualizar(' . $row->id_servicio . ')">' .
                        '<i class="ri-search-fill ri-20px text-normal"></i> Visualizar' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="editProveedor(' . $row->id_servicio . ')">' .
                        '<i class="ri-file-edit-fill ri-20px text-info"></i> Editar' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="deleteProv(' . $row->id_servicio . ')">' .
                        '<i class="ri-delete-bin-2-fill ri-20px text-danger"></i> Eliminar' .
                        '</a>
                        </li>'
                        .
                        '</ul>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('servicios.find_servicios_de_catalogo');
    }

    /**
     * Muestra el formulario para crear un nuevo servicio de catálogo.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $claves = DB::table('catalogo_laboratorios')->get();
        $laboratorios = DB::table('catalogo_laboratorios')->get();

        return view('servicios.find_agregar_servicios_catalogo_view', compact('claves', 'laboratorios'));
    }

    /**
     * Muestra la vista para ver un servicio específico.
     */
    public function show($id)
    {
        // Lógica para mostrar un servicio específico
    }

    /**
     * Almacena un nuevo servicio de catálogo en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'clave' => 'required|string|max:255',
            'clave_adicional' => 'nullable|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'duracion' => 'nullable|string|max:255',
            'requiere_muestra' => 'nullable|string',
            'acreditacion' => 'nullable|string',
            'id_habilitado' => 'required|boolean',
            'analisis' => 'required|string',
            'unidades' => 'nullable|string|max:255',
            'nombre_acreditacion' => 'nullable|string|max:255',
            'descripcion_acreditacion' => 'nullable|string|max:255',
            'prueba' => 'required|string',
            'descripcion_muestra' => 'nullable|string',
            'archivo_requisitos' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
            'precios_laboratorio' => 'required|array',
            'precios_laboratorio.*' => 'required|numeric',
            'laboratorios_responsables' => 'required|array',
            'laboratorios_responsables.*' => 'required|exists:catalogo_laboratorios,id_laboratorio',
        ]);

        // Depuración: Verificar qué clave se está recibiendo
        \Log::info('Clave recibida: ' . $validatedData['clave']);

        $servicio = new serviciosModel();

        // Asignar valores del formulario al modelo
        $servicio->clave = $validatedData['clave'];
        $servicio->clave_adicional = $validatedData['clave_adicional'];
        $servicio->nombre = $validatedData['nombre'];
        $servicio->precio = $validatedData['precio'];
        $servicio->duracion = $validatedData['duracion'];
        $servicio->requiere_muestra = $validatedData['requiere_muestra'] == 'si' ? true : false;
        $servicio->acreditacion = $validatedData['acreditacion'];
        $servicio->id_habilitado = $validatedData['id_habilitado'];
        $servicio->analisis = $validatedData['analisis'];
        $servicio->unidades = $validatedData['unidades'];
        $servicio->nombre_acreditacion = $validatedData['nombre_acreditacion'];
        $servicio->descripcion_acreditacion = $validatedData['descripcion_acreditacion'];
        $servicio->prueba = $validatedData['prueba'];
        $servicio->descripcion_muestra = $validatedData['descripcion_muestra'];
        $servicio->tipo_servicio = 1;

        // Manejar archivo de requisitos
        if ($request->hasFile('archivo_requisitos')) {
            $path = $request->file('archivo_requisitos')->store('public/servicios');
            $servicio->archivo_requisitos = str_replace('public/', '', $path);
        }

        // Guardar el servicio
        $servicio->save();

        // Guardar precios por laboratorio
        $preciosLab = $request->input('precios_laboratorio');
        $laboratoriosResp = $request->input('laboratorios_responsables');

        for ($i = 0; $i < count($preciosLab); $i++) {
            serviciosLabModel::create([
                'id_servicio' => $servicio->id_servicio,
                'id_laboratorio' => $laboratoriosResp[$i],
                'precio_lab' => $preciosLab[$i],
            ]);
        }
        
        // Registrar en el tracking
        serviciosTrackingModel::create([
            'id_servicio' => $servicio->id_servicio,
            'accion' => 'Servicio de catálogo creado',
            'usuario' => Auth::id(),
        ]);

        return redirect()->route('serviciosCatalogo.index')->with('success', 'Servicio de catálogo agregado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un servicio existente.
     *
     * @return \Illuminate\View\View
     */
    public function edit($id): View
    {
        $servicio = Servicio::findOrFail($id);
        return view('serviciosCatalogo.edit', compact('servicio'));
    }

    /**
     * Actualiza un servicio existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Lógica para actualizar un servicio existente
    }

    /**
     * Elimina un servicio existente de la base de datos.
     */
    public function destroy($id)
    {
        // Lógica para eliminar un servicio existente
    }
}