<?php

namespace App\Http\Controllers;

use App\Models\CatalogoUnidad;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use assets\js\components\charts;


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
                          <button  class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            Opciones
                          </button>
                          <div class="dropdown-menu">
                           
                          </div>
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
                //'folio_solicitud' =>  helper::folioSolicitud(),
                //'destino' => 1,
                //'id_inspector' => $request->id_inspector,
                //'folio' => $request->folio
                
            ]);


        session()->flash('status', 'Solicitud guardada correctamente.');
        return redirect()->route('informes.index');//Ruta del index
     }

    //Este manda a la vista del editar, siempre te llevas el id de la tabla
    public function edit($id_informe)
{
    $informe = CatalogoUnidad::findOrFail($id_informe);
    return view('informes.editar_informes', ['informe' => $informe]);
}
    
  //Aqui se edita el informe
    public function update(Request $request, $id_informe)
    {

    // $informe = CatalogoUnidad::findOrFail($id_informe);
   //  $informe->update([
     //'id_inspector' => $request->id_inspector,
     //'id_gerente' => $request->id_gerente,
     //'folio' => $request->folio
     //]);


       // session()->flash('status', 'Solicitud modificada correctamente.');
        // return redirect()->route('informes.index');
    } 
}

