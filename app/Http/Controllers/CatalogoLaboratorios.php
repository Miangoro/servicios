<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\FacadesRoute;
use App\Models\CatalogoLaboratorio;
use Yajra\DataTables\DataTables;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use assets\js\components\charts;

class CatalogoLaboratorios extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $sql = CatalogoLaboratorio::all();//Nombre del modelo
           return DataTables::of($sql)->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '
                    <div class="dropdown">
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
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteLab(' . $row->id_unidad . ')">'.
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

    //Manda a la vista de agregar 

    public function add_catalogo_laboratorio()
    {
    
        return view('catalogo.add_catalogo_laboratorio');

    }

    // Registrar datos
    public function store(Request $request)
    {

        $informes = CatalogoLaboratorio::create([
                'laboratorio' => $request->nombre,
                'descripcion' => $request->descripcion,
                'clave' => $request->clave,
                'habilitado' => 1,
                'id_usuario' => 1,
                
            ]);

        session()->flash('status', 'Solicitud guardada correctamente.');
        return redirect()->route('laboratorios.index');
    }

    //Este manda a la vista del editar, siempre te llevas el id de la tabla
    public function edit($id_informe)
{
    $informe = CatalogoLaboratorio::findOrFail($id_informe);
    return view('informes.editar_informes', ['informe' => $informe]);
}

        //Aqui se edita el informe
    public function update(Request $request, $id_informe)
    {

     $informe = CatalogoLaboratorio::findOrFail($id_informe);
     $informe->update([
     //'id_inspector' => $request->id_inspector,
     //'id_gerente' => $request->id_gerente,
     //'folio' => $request->folio
     ]);


        session()->flash('status', 'Solicitud modificada correctamente.');
        return redirect()->route('informes.index');
    }

}
