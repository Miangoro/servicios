<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\FacadesRoute;
use App\Models\CatalogoLaboratorio;
use App\Models\CatalogoUnidad;
use Yajra\DataTables\DataTables;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use assets\js\components\charts;
use Illuminate\Validation\ValidationException;

class CatalogoLaboratorios extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $sql = CatalogoLaboratorio::orderBy('id_laboratorio', 'desc')->get();//Nombre del modelo
           return DataTables::of($sql)->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '
                    <div class="dropdown d-flex justify-content-center">
                        <button  class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fas fa-gear me-2"></i> Opciones
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_laboratorio . '">'.
                            '<li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editLab(' . $row->id_laboratorio . ')">'.
                                    '<i class="fas fa-edit me-2"></i> Editar'.
                                '</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteLab(' . $row->id_laboratorio . ')">'.
                                    '<i class="fas fa-trash-alt me-2"></i> Eliminar'.
                                '</a>
                            </li>'
                        .'</ul>
                          
                    </div>';
                    return $btn;
                })
            ->rawColumns(['action'])
            ->make(true);
        }
       
        return view('catalogo.Laboratorios');  
        
    }

    // Registrar datos
    public function store(Request $request)
    {

        $laboratorio = CatalogoLaboratorio::create([
                'laboratorio' => $request->nombre,
                'clave' => $request->clave,
                'descripcion' => $request->descripcionCampo,
                'habilitado' => 1,
                'id_usuario' => 1,
                'id_unidad' => $request->selectUnidades,
            ]);

        session()->flash('status', 'Solicitud guardada correctamente.');
        return redirect()->route('laboratorios.index');
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
            // validación de los datos
            $request->validate([
                'laboratorio' => 'required|string|max:255',
                'clave' => 'nullable|string|max:50',
                'descripcion' => 'nullable|string|max:500',
            ]);

            //Encontrar el laboratorio o fallar si no existe
            $laboratorio = CatalogoLaboratorio::findOrFail($id);
            $laboratorio->update([
                'laboratorio' => $request->laboratorio,
                'clave' => $request->clave,
                'descripcion' => $request->descripcion,
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
