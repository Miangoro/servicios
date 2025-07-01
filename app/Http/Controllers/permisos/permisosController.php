<?php

namespace App\Http\Controllers\permisos;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class permisosController extends Controller
{


  /**
   *Redirecciona a la vista de usuarios clientes.
   *
   */
  public function find_permisos()
  {

    return view('permisos.find_permisos_view');
  }


  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'created_at',
    ];

    $search = [];

    $users_temp = Permission::query();
    $totalData = $users_temp->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $res = Permission::query()
        ->offset($start)
        ->limit($limit)

        ->get();
    } else {
      $search = $request->input('search.value');

      $res = Permission::query()
        ->where(function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();


      $totalFiltered = Permission::query()
        ->where('name', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($res)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($res as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        $nestedData['created_at'] = Helpers::formatearFechaHora($user->created_at);
        $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } else {
      return response()->json([
        'message' => 'Internal Server Error',
        'code' => 500,
        'data' => [],
      ]);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $id = $request->permiso_id;

    if ($id) {
      // update the value
      $role = Permission::updateOrCreate(
        ['id' => $id],
        ['name' => $request->name]
      );

      return response()->json('Modificado');
    } else {
      // Verifica si el nombre ya existe
      $existingRole = Permission::where('name', $request->name)->first();

      if (!$existingRole) {
        // crear nuevo rol
        $role = Permission::create([
          'name' => $request->name
        ]);

        return response()->json('Registrado');
      } else {
        return response()->json(['message' => 'ya existe'], 422);
      }
    }
  }


  public function show($id)
  {
    
  }

  public function edit($id): JsonResponse
  {
    $user = Permission::findOrFail($id);
    return response()->json($user);
  }

  public function update(Request $request, $id) {}


  public function destroy($id)
  {
    $users = Permission::where('id', $id)->delete();
  }
}
