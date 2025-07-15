<?php

namespace App\Http\Controllers;

use App\Models\CatalogoUnidad;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use assets\js\components\charts;
use Illuminate\Validation\ValidationException;

class CatalogoUnidades extends Controller
{

public function index(Request $request)
    {
        if($request->ajax()){
            $sql = CatalogoUnidad::all();//Nombre del modelo
           return DataTables::of($sql)->addIndexColumn()
                ->addColumn('action', function($row){

                  $btn = '
                    <div class="d-flex align-items-center gap-50">
                        <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_unidad . '">'.
                            '<li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editUnidad('.$row->id_unidad.')">
                               <i class="ri-edit-box-line ri-20px text-info"></i>Editar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteUnidad(' . $row->id_unidad . ')">'.
                                    '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar </a>'.
                                '</a>
                            </li>'
                        .'</ul>
                          
                    </div>';
                 

                return $btn;
                   })


            ->rawColumns(['action'])
            ->make(true);
        }
       
        return view('catalogo.unidades');  
        
    }

    //Manda a la vista de agregar 

    public function add_NombreDeSUVista()
    {
    
        return view('informes.add_informes');

    }

    // Registrar datos
    public function store(Request $request)
   
    
    {


        $informes = CatalogoUnidad::create([
                     'nombre' => $request ->nombreUnidad,
                    'habilitado' => 1,
                    'id_usuario' => 1,
            ]);


        session()->flash('status', 'Solicitud guardada correctamente.');
        return redirect()->route('unidades.index');//Ruta del index
     }
     

    //Este manda a la vista del editar, siempre te llevas el id de la tabla
  public function getUnidad($id)
{
    try {
        $unidad = CatalogoUnidad::findOrFail($id);
        
        return response()->json([
            'id_unidad' => $unidad->id_unidad,
            'nombre_Unidad' => $unidad->nombre // Asegúrate que coincida con el formulario
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Unidad no encontrada: ' . $e->getMessage()
        ], 404);
    }
}

public function update(Request $request, $id)
{
    try {
        $request->validate([
            'nombre_Unidad' => 'required|string|max:255',
        ]);

        $unidad = CatalogoUnidad::findOrFail($id);
        $unidad->nombre = $request->nombre_Unidad;
        $unidad->save();

        return response()->json([
            'message' => 'Unidad actualizada correctamente',
            'data' => $unidad
        ]);

    } catch (ValidationException $e) {
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al actualizar: ' . $e->getMessage()
        ], 500);
    }
}

public function destroy($id)
    {
        try {
            $Unidad = CatalogoUnidad::findOrFail($id);
            $Unidad->delete();
            return response()->json(['message' => 'Unidad eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al intentar eliminar la Unidad: ' . $e->getMessage()], 500);
        }
    }
     
}

