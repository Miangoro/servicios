<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\FacadesRoute;
use App\Models\CatalogoLaboratorio;
use App\Models\CatalogoUnidad;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CatalogoLaboratorios extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql = CatalogoLaboratorio::orderBy('id_laboratorio', 'desc')->get();

            return DataTables::of($sql)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '
                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_laboratorio . '">'.
                            '<li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editLab(' . $row->id_laboratorio . ')">'.
                                    '<i class="ri-file-edit-fill ri-20px text-info"></i> Editar' .
                                '</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteLab(' . $row->id_laboratorio . ')">'.
                                    '<i class="ri-delete-bin-2-fill ri-20px text-danger"></i> Eliminar' .
                                '</a>
                            </li>'
                        .'</ul>
                    </div>';
                    return $btn;
                })

                ->editColumn('descripcion', function($row) {
                    if($row->descripcion === null){
                      return 'Sin descripción';  
                    }
                    return Str::limit(($row->descripcion), 5000);
                    
                })
                ->rawColumns(['action', 'descripcion'])
                ->make(true);
        }

        return view('catalogo.find_catalogo_laboratorios');
    }

    // Registrar datos
    public function store(Request $request)
    {
        try{
            $descripcion = $request->descripcionCampo;
            // quita etiquetas vacías y espacios
            $descripcionLimpia = trim(strip_tags($descripcion));

            if ($descripcionLimpia === '') {
                $descripcion = null;
            }
        $laboratorio = CatalogoLaboratorio::create([
                'laboratorio' => $request->nombre,
                'clave' => $request->clave,
                'descripcion' => $descripcion,
                'habilitado' => 1,
                'id_usuario' => Auth::id(),
                'id_unidad' => $request->selectUnidades,
            ]);

        session()->flash('status', 'Solicitud guardada correctamente.');
        return redirect()->route('laboratorios.index');

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al intentar agregar ' . $e->getMessage()], 500);
        }
    }

    //Este manda a la vista del editar, siempre te llevas el id de la tabla
    public function getLaboratorio($id)
    {
        try {
            $laboratorio = CatalogoLaboratorio::find($id);

            if (!$laboratorio) {
                return response()->json(['error' => 'Laboratorio no encontrado.'], 404);
            }
            return response()->json([
                'id_laboratorio' => $laboratorio->id_laboratorio,
                'nombre' => $laboratorio->laboratorio,
                'clave' => $laboratorio->clave,
                'id_unidad' => $laboratorio->id_unidad,
                'descripcion' => $laboratorio->descripcion,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el laboratorio: ' . $e->getMessage()], 500);
        }
    }

    //obtener las unidades para el select
    public function getUnidades(Request $request)
    {
        $unidades = CatalogoUnidad::pluck('nombre', 'id_unidad');
        return response()->json($unidades);
    }

        //Aqui se edita el registro
    public function update(Request $request, $id)
    {
        try {
            $descripcion = $request->descripcion;
            // quita etiquetas vacías y espacios
            $descripcionLimpia = trim(strip_tags($descripcion));

            if ($descripcionLimpia === '') {
                $descripcion = null;
            }

            //Encontrar el laboratorio o fallar si no existe
            $laboratorio = CatalogoLaboratorio::findOrFail($id);
            $laboratorio->update([
                'laboratorio' => $request->laboratorio,
                'clave' => $request->clave,
                'descripcion' => $descripcion,
                'id_unidad' => $request->selectUnidadesEdit,
            ]);
            return response()->json(['message' => 'Laboratorio modificado correctamente.']);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al intentar modificar el laboratorio: ' . $e->getMessage()], 500);
        }
    }

     public function destroy($id)
    {
        try {
            $laboratorio = CatalogoLaboratorio::findOrFail($id);
            $laboratorio->delete();
            return response()->json(['message' => 'Laboratorio eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al intentar eliminar el laboratorio: ' . $e->getMessage()], 500);
        }
    }

}
