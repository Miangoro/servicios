<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalRegularModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

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
                })->editColumn('descripcion', function ($row) {
                    if ($row->descripcion === null) {
                        return 'Sin descripción';
                    }
                    return Str::limit(($row->descripcion), 500);
                })->addColumn('foto_html', function($row) {
                $url = asset($row->foto);
                
                    return '<img src="' .  $url . '" alt="Foto de empleado" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">';
                
            })
                ->rawColumns(['action', 'descripcion', 'foto_html'])
                ->make(true);
        }

        return view('personal.find_personal_regular');
    }

    public function create()
    {
        $usuarios = User::where('tipo', 1)->get();
        return view('personal.agregar_personal_regular', compact('usuarios'));
    }

    // En tu PersonalRegularController.php

    public function store(Request $request)
    {
        try {
            $descripcion = $request->descripcionEmpleado;
            $descripcionLimpia = trim(strip_tags($descripcion));

            if ($descripcionLimpia === '') {
                $descripcion = null;
            }

            $fotoPath = null;

            // En tu PersonalRegularController.php
            if ($request->hasFile('fotoEmpleado')) {
                $uploadedImage = $request->file('fotoEmpleado');

                $folder = 'uploads';
                $filename = time() . '.' . $uploadedImage->getClientOriginalExtension();

                $uploadedImage->move(public_path($folder), $filename);

                $fotoPath = $folder . '/' . $filename;
            }
            PersonalRegularModel::create([
                'nombre' => $request->nombreEmpleado,
                'folio' => $request->folioEmpleado,
                'foto' => $fotoPath,
                'correo' => $request->correoEmpleado,
                'id_usuario' => $request->idUsuario,
                'fecha_ingreso' => $request->fechaIngreso,
                'descripcion' => $descripcion,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json(['success' => 'Empleado agregado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al agregar empleado: ' . $e->getMessage());
            return response()->json(['error' => 'Error al agregar empleado.'], 500);
        }
    }
}
