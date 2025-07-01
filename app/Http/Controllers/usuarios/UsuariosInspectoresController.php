<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class UsuariosInspectoresController extends Controller
{
       /**
   * Redirecciona a la vista de usuarios inspectores.
   *
   */
  public function inspectores()
  {
    $roles = Role::All();
    return view('usuarios.find_usuarios_inspectores_view',compact('roles'));
  }



  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

   public function pdfAsignacionUsuario($id)
    {     Carbon::setLocale('es'); // Establece la localización a español
        $currentDate = Carbon::now();

    // Obtener el día
    $dia = $currentDate->day;
    $mes = $currentDate->translatedFormat('F');
    $anio = $currentDate->year;
        $res = User::with('empresa')->where('id', $id)->first();
        $pdf = Pdf::loadView('pdfs.AsignacionUsuario',['datos'=>$res,'dia'=>$dia,'mes'=>$mes,'anio'=>$anio]);
        return $pdf->stream('F7.1-01-46 Carta de asignación de usuario y contraseña para plataforma del OC Ed. 0, Vigente.pdf');


    }

  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'email',
      4 => 'firma',
      5 => 'email_verified_at',
      6 => 'razon_social',
      7 => 'puesto'
    ];

    $search = [];

    $users_temp = User::where("tipo",2)->get();
    $totalData = $users_temp->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = User::where("tipo",2)->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = User::where('id', 'LIKE', "%{$search}%")
        ->where("tipo",3)
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWhere('puesto', 'LIKE', "%{$search}%")
        ->orWhere('estatus', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
        ->where("tipo",2)
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWhere('puesto', 'LIKE', "%{$search}%")
        ->orWhere('estatus', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email ;
        $nestedData['firma'] = $user->firma ?? 'N/A';
        $nestedData['password_original'] = $user->password_original ;
        $nestedData['razon_social'] = 'No aplica';
        $nestedData['puesto'] = $user->puesto;
        $nestedData['foto_usuario'] = $user->profile_photo_path ?? '';
        $nestedData['estatus'] = $user->estatus;
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
      $userID = $request->id;

      // Variable para el path de la firma
      $firmaPath = null;

      // Si se ha subido una firma, procesarla
      if ($request->hasFile('firma')) {
          $file = $request->file('firma');
          if ($file->isValid()) {
              // Generar nombre único para la firma
              $fileName = 'firma_' . str_replace(' ', '_', $request->name) . '_' . time() . '.' . $file->getClientOriginalExtension();

              // Guardar la firma en la carpeta 'public/firmas'
              $firmaPath = $file->storeAs('firmas', $fileName, 'public');
              $firmaPath = basename($firmaPath);  // Guardar solo el nombre del archivo
          } else {
              return response()->json(['message' => 'El archivo no es válido'], 422);
          }
      }

      if ($userID) {
          // Obtener el inspector existente
          $existingUser = User::find($userID);

          // Si se está subiendo una nueva firma, eliminar la firma anterior si existe
          if ($firmaPath && $existingUser && $existingUser->firma) {
              $previousFirmaPath = storage_path('app/public/firmas/' . $existingUser->firma);
              if (file_exists($previousFirmaPath)) {
                  unlink($previousFirmaPath);  // Eliminar la firma anterior
              }
          }

          // Si no hay nueva firma, mantener la firma existente
          if (!$firmaPath && $existingUser) {
              $firmaPath = $existingUser->firma;
          }

          // Actualizar o crear el inspector
          $users = User::updateOrCreate(
              ['id' => $userID],
              [
                  'name' => $request->name,
                  'email' => $request->email,
                  'estatus' => $request->estatus,
                  'firma' => $firmaPath,  // Guardar la ruta de la firma
                  'tipo' => 2,  // Tipo de inspector
                  'puesto' => $request->puesto,
              ]
          );
          $users->syncRoles($request->rol_id); 
          return response()->json('Modificado');
      } else {
          // Crear un nuevo inspector si el correo no existe
          $userEmail = User::where('email', $request->email)->first();

          if (!$userEmail) {
              $pass = Str::random(10);

              $users = User::create([
                  'name' => $request->name,
                  'email' => $request->email,
                  'estatus' => $request->estatus,
                  'password_original' => $pass,
                  'password' => bcrypt($pass),
                  'tipo' => 2,  // Tipo de inspector
                  'firma' => $firmaPath,  // Guardar la ruta de la firma si existe
                  'puesto' => $request->puesto,
              ]);
              $users->syncRoles($request->rol_id); 
              return response()->json('Registrado');
          } else {
              return response()->json(['message' => 'Ya existe'], 422);
          }
      }
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id): JsonResponse
  {
    $user = User::findOrFail($id);
    $user->rol = $user->getRoleNames()->first(); // o ->toArray() si quieres todos
    return response()->json($user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::find($id);

    if ($user) {
      // Verificar si el usuario tiene una firma
      if ($user->firma) {
          // Ruta de la firma
          $firmaPath = storage_path('app/public/firmas/' . $user->firma);

          // Eliminar la firma si existe
          if (file_exists($firmaPath)) {
              unlink($firmaPath);
          }
      }

      // Eliminar el registro del usuario
      $user->delete();

      return response()->json(['message' => 'Personal eliminado y firma borrada'], 200);
  }

  return response()->json(['message' => 'Personal no encontrado'], 404);
}

}
