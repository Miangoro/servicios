<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\serviciosModel;
use App\Models\serviciosTrackingModel;
use App\Models\serviciosLabModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ServiciosCatalogoController extends Controller
{
    public function index(Request $request)
    {
                if ($request->ajax()) {
            $sql = serviciosModel::all()
                ->orderBy('id_servicio', 'desc')
                ->get();

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
                        </li>

                        <li>
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

    public function show($id)
    {
        // Lógica para mostrar un servicio específico
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación de un nuevo servicio
    }

    public function store(Request $request)
    {
        // Lógica para almacenar un nuevo servicio
    }

    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición de un servicio existente
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un servicio existente
    }

    public function destroy($id)
    {
        // Lógica para eliminar un servicio existente
    }
}
