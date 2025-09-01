<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalRegularModel;
use App\Models\User;
use Yajra\DataTables\DataTables;

class PersonalRegularController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql = PersonalRegularModel::orderBy('id_empleado', 'desc')->get();
            
            return DataTables::of($sql)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_empleado . '">' .
                        '<li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="visualizar(' . $row->id_empleado . ')">' .
                        '<i class="ri-search-fill ri-20px text-normal"></i> Visualizar' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="editProveedor(' . $row->id_empleado . ')">' .
                        '<i class="ri-file-edit-fill ri-20px text-info"></i> Editar' .
                        '</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="deleteProv(' . $row->id_empleado . ')">' .
                        '<i class="ri-delete-bin-2-fill ri-20px text-danger"></i> Eliminar' .
                        '</a>
                        </li>' .
                        '</ul>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('personal.find_personal_regular');
    }

    public function create(){
        $usuarios = User::where( 'tipo', 1);
        return view('personal.agregar_personal_regular', compact('usuarios'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            // Guarda imagen en storage/app/public/uploads
            $path = $request->file('file')->store('uploads', 'public');

            $model = new PersonalRegularModel();
            $model->foto = $path;
            $model->save();
        }

        return redirect()->back()->with('success', 'Imagen subida correctamente');
    }


}

