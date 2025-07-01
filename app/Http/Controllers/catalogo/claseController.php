<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\clases;

class ClaseController extends Controller
{

    public function UserManagement()
    {
        $empresas = clases::all();
        $userCount = $empresas->count();
        $verified = 5;
        $notVerified = 10;
        $usersUnique = $empresas->unique(['clases']);
        $userDuplicates = 40;

        return view('catalogo.Catalogo_Clases', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_clase',
            2 => 'clase'
        ];

        $search = [];

        $totalData = clases::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = clases::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = clases::where('id_clase', 'LIKE', "%{$search}%")
                ->orWhere('clase', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = clases::where('id_clase', 'LIKE', "%{$search}%")
                ->orWhere('clase', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_clase'] = $user->id_clase; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['fake_id'] = ++$ids;
                $nestedData['clase'] = $user->clase; // Ajusta el nombre de la columna según tu base de datos

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


    // Función para eliminar una clase
    public function destroy($id_clase)
    {
        try {
            $clase = clases::findOrFail($id_clase);
            $clase->delete();

            return response()->json(['success' => 'Clase eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la clase'], 500);
        }
    }

    // Función para agregar una nueva clase
    public function store(Request $request)
    {
        $request->validate([
            'clase' => 'required|string|max:255',
        ]);

        try {
            $clase = new clases();
            $clase->clase = $request->clase;
            $clase->save();
            return response()->json(['success' => 'Clase agregada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar la clase'], 500);
        }
    }

//funcion para llenar el campo del formulario
    public function edit($id_clase)
    {
        try {
            $clase = clases::findOrFail($id_clase);
            return response()->json($clase);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la clase'], 500);
        }
    }

    // Función para actualizar una clase existente
    public function update(Request $request, $id_clase)
{
    $request->validate([
        'edit_clase' => 'required|string|max:255',
    ]);

    try {
        $clase = clases::findOrFail($id_clase);
        $clase->clase = $request->edit_clase;
        $clase->save();

        return response()->json(['success' => 'Clase actualizada correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al actualizar la clase'], 500);
    }
}


}
