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
        <button class="btn btn-info dropdown-toggle" type="button" 
                id="dropdownMenuButton_' . $row->id_unidad . '"' . // ID único para cada botón
                ' data-bs-toggle="dropdown" aria-expanded="false">'. // Usar data-bs-toggle para Bootstrap 5
            '<i class="fas fa-gear"></i>&nbsp;Opciones
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_unidad . '">'. // Referencia al ID único del botón
            '<li>
                <a class="dropdown-item" href="javascript:void(0);" onclick="editUnidad(' . $row->id_unidad . ')">'. // Llama a una función JS para editar
                    '<i class="fas fa-edit me-2"></i> Editar'. // Icono de editar y margen derecho
                '</a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteUnidad(' . $row->id_unidad . ')">'. // Llama a una función JS para eliminar
                    '<i class="fas fa-trash-alt me-2"></i> Eliminar'. // Icono de eliminar y margen derecho
                '</a>
            </li>
            '
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
            $unidad = CatalogoUnidades::find($id);

            if (!$unidad) {
                return response()->json(['error' => 'Unidad no encontrada.'], 404);
            }

            return response()->json([
                'id_unidad'=> $unidad -> id_unidad,
                'nombre'=> $unidad -> nombre
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la Unidad: ' . $e->getMessage()], 500);
        }
    }
    
  //Aqui se edita el informe
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'Unidad' => 'required|string|max:255',
            ]);

            $unidad = CatalogoUnidad::find($id);
            $unidad->update([
                'Unidad' => $request->nombre, 

            ]);

           
            return response()->json(['message' => 'Laboratorio modificado correctamente.']);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Captura cualquier otro error inesperado y devuelve un mensaje de error 500
            return response()->json(['error' => 'Ocurrió un error al intentar modificar el laboratorio: ' . $e->getMessage()], 500);
        }
    }
     
}

