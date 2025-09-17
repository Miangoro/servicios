<?php

namespace App\Http\Controllers;

use App\Models\expedientePersonalModel;
use Illuminate\Http\Request;
use App\Models\PersonalRegularModel;
use App\Models\User;
use App\Models\puestosModel;
use App\Models\personalNombramientoModel;
use App\Models\personalConflictoInteresModel;
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
                            <a class="dropdown-item" href="">' .
                        '<span class="iconify text-info" data-icon="ri-file-edit-fill" data-inline="false" style="font-size: 24px;"></span> Editar' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="'  . route('personalRegular.expediente', $row->id_empleado) .'">' .
                        ' <span class="iconify text-primary" data-icon="fluent:document-add-20-filled" data-inline="false" style="font-size: 24px;"></span> Agregar expediente' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="'  . route('personalRegular.nombramiento', $row->id_empleado) .'">' .
                        '<span class="iconify text-primary" data-icon="streamline-ultimate:job-responsibility-bag-hand-bold" data-inline="false" style="font-size: 24px;"></span> Agregar nombramiento' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="'  . route('personalRegular.conflictoInteres', $row->id_empleado) .'">' .
                        '<span class="iconify text-primary" data-icon="fluent:document-search-20-filled" data-inline="false" style="font-size: 24px;"></span> Agregar conflicto de interés' .
                        '</a>
                        </li>' .
                        '<li>
                            <a class="dropdown-item" href="'  . route('personalRegular.confidencialidad', $row->id_empleado) .'">' .
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
                })/*->addColumn('verExp', function ($row) {
                    $btnexp = '<button class="btn btn-sm btn-warning dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Ver expediente <i class="ri-arrow-down-s-fill ri-20px"></i></button>';
                    return $btnexp;
                })*/
                ->editColumn('descripcion', function ($row) {
                    if ($row->descripcion === null) {
                        return 'Sin descripción';
                    }
                    return Str::limit(($row->descripcion), 500);
                })->addColumn('foto_html', function($row) {
                $url = asset($row->foto);
                
                    return '<img src="' .  $url . '" alt="Foto de empleado" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">';
                
            })
                ->rawColumns(['action', /*'verExp',*/ 'descripcion', 'foto_html'])
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

    public function nombramiento($id)
    {
        $puestos = puestosModel::get('nombre');
        $empleado = PersonalRegularModel::where('id_empleado', $id)->first();
        $responsable = User::where('tipo', 1)->get();

        return view('personal.agregar_nombramiento', compact('empleado', 'puestos', 'responsable'));
    }

    public function nombramientoPost(Request $request)
    {

        personalNombramientoModel::create([
            'id_usuario' => $request->empleado_id,
            'puesto' => $request->puesto,
            'area' => $request->area,
            'responsable' => $request->responsable,
            'signatario' => $request->responsable,
            'suplente' => $request->suplente,
            'fecha_llenado' => $request->fechaNombramiento,
            'fecha_efectivo' => $request->fechaEfectivo,
            'id_registra' => Auth::id(),
            'id_v_nombramiento' => 1,
            'id_v_actividad' => 2,
            'estatus' => 'Vigente',
            'id_habilitado' => 1
        ]);

        return response()->json(['success' => 'Nombramiento agregado correctamente.']);
    }

    public function conflictoInteres($id)
    {
        $empleado = PersonalRegularModel::where('id_empleado', $id)->first();
        $area = personalNombramientoModel::where('id_usuario', $id)->latest('id_nombramiento')->first();

        return view('personal.agregar_conflicto_interes', compact('empleado', 'area'));
    }

     public function conflictoInteresPost(Request $request)
    {

        personalConflictoInteresModel::create([
            'fecha' => $request->fecha,
            'fecha_registro' => now(),
            'p_uno' => $request->negocio,
            'p_dos' => $request->negocio_cliente,
            'p_tres' => $request->relacion,
            'p_cuatro' => $request->familiar_negocio,
            'p_cinco' => $request->familiar_cliente,
            'p_seis' => $request->laborado,
            'p_siete' => $request->puesto,
            'p_ocho' => $request->fechaDL,
            'p_nueve' => $request->motivoSeparacion,
            'p_diez' => $request->masPuesto,
            'p_once' => $request->otroPuesto,
            'p_doce' => $request->parentesco,
            'version' => $request->version,
            'url_documento' => null,
            'comentarios' => null,
            'estatus' => 'Vigente',
            'habilitado' => 1,
            'id_usuario' => $request->id_empleado,
            'area' => $request->area
            
        ]);

        return response()->json(['success' => 'Conflicto de interés agregado correctamente.']);
    }

    public function confidencialidad($id)
    {
        $empleado = PersonalRegularModel::where('id_empleado', $id)->first();
        return view('personal.registrar_acuerdo_confidencialidad', compact('empleado'));
    }

}
