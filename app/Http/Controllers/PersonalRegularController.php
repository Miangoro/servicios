<?php

namespace App\Http\Controllers;

use App\Models\expedientePersonalModel;
use Illuminate\Http\Request;
use App\Models\PersonalRegularModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
                            <a class="dropdown-item" href="'  . route('personalRegular.expediente', $row->id_empleado) .'">' .
                        ' <span class="iconify text-primary" data-icon="fluent:document-add-20-filled" data-inline="false" style="font-size: 24px;"></span> Agregar expediente' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="visualizar(' . $row->id_empleado . ')">' .
                        '<span class="iconify text-primary" data-icon="streamline-ultimate:job-responsibility-bag-hand-bold" data-inline="false" style="font-size: 24px;"></span> Agregar nombramiento' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="visualizar(' . $row->id_empleado . ')">' .
                        '<span class="iconify text-primary" data-icon="fluent:document-search-20-filled" data-inline="false" style="font-size: 24px;"></span> Agregar conflicto de interés' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="editProveedor(' . $row->id_empleado . ')">' .
                        '<span class="iconify text-info" data-icon="fa7-solid:file-signature" data-inline="false" style="font-size: 24px;"></span> Resgistrar acuerdo de confidencialidad' .
                        '</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="deleteProv(' . $row->id_empleado . ')">' .
                        ' <span class="iconify" data-icon="heroicons:document-arrow-up-solid" data-inline="false" style="font-size: 24px;"></span> Subir documentación' .
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

            expedientePersonalModel::create([
                'id_empleado' => PersonalRegularModel::latest('id_empleado')->first()->id_empleado,
                'd_personales' => "",
                'profesion' => "",
                'experiencia' => "",
                'cursos' => "",
                'actividades' => "",
                'habilidades' => "",
                'habilitado' => "",
                'fecha_registro' => now(),
                'id_usuario' => Auth::id(),
            ]);

            return response()->json(['success' => 'Empleado agregado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al agregar empleado: ' . $e->getMessage());
            return response()->json(['error' => 'Error al agregar empleado.'], 500);
        }
    }

    public function expediente($id)
    {
        $empleado = expedientePersonalModel::where('id_empleado', $id)->first();

        return view('personal.agregar_expediente', compact('empleado'));
    }

    public function expedientePost(Request $request)
    {
        $data = $request->only([
            'd_personales',
            'profesion',
            'experiencia',
            'cursos',
            'actividades',
            'habilidades'
        ]);

        $expediente = expedientePersonalModel::where('id_empleado', $request->idEmpleado)->first();

        if (!$expediente) {
            return response()->json(['error' => 'Expediente no encontrado.'], 404);
        }

        $expediente->update($data);

        return response()->json(['success' => 'Expediente actualizado correctamente.']);
    }

}
