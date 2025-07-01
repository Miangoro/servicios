<?php

namespace App\Http\Controllers\bitacoras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BitacoraProductoMaduracion;
use App\Helpers\Helpers;

class BitacoraProductoMaduracionController extends Controller
{
  public function UserManagement()
  {
    $bitacora = BitacoraProductoMaduracion::all();
      return view('Bitacoras.BitacoraProductoMaduracion_view', compact('bitacora'));
  }

  public function index(Request $request)
  {
      $columns = [
          1 => 'id_bitacora_maduracion',
          2 => 'fecha',
          3 => 'lote_a_granel'
      ];


      $search = [];
      $totalData = BitacoraProductoMaduracion::count(); // Cambiado por el modelo correcto
      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      if (empty($request->input('search.value'))) {
          $users = BitacoraProductoMaduracion::offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();
      } else {
          $search = $request->input('search.value');

          $users = BitacoraProductoMaduracion::where('id_bitacora_maduracion', 'LIKE', "%{$search}%")
              ->orWhere('fecha', 'LIKE', "%{$search}%")
              ->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();

          $totalFiltered = BitacoraProductoMaduracion::where('id_bitacora_maduracion', 'LIKE', "%{$search}%")
              ->orWhere('fecha', 'LIKE', "%{$search}%")
              ->count();
      }

      $data = [];

      if (!empty($users)) {
          $ids = $start;

          foreach ($users as $user) {
              $nestedData['id_bitacora_maduracion'] = $user->id_bitacora_maduracion; // Ajusta el nombre de la columna según tu base de datos
              $nestedData['fake_id'] = ++$ids;
              $nestedData['fecha'] = Helpers::formatearFecha($user->fecha);
              $nestedData['lote_a_granel'] = $user->lote_a_granel; // Ajusta el nombre de la columna según tu base de datos

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


}
