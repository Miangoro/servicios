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
                    <div class="dropdown">
                        <button  class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fas fa-gear me-2"></i> Opciones
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_unidad . '">'.
                            '<li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editUnidad('.$row->id_unidad.')">
                                <i class="fas fa-edit me-2"></i> Editar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteUnidad(' . $row->id_unidad . ')">'.
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
     
}

