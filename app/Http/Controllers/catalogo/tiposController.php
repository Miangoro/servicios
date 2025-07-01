<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tipos;


class tiposController extends Controller
{

  public function UserManagement()
    {
        $todos = Tipos::all(); // Obtener todos los datos
        return view('catalogo.tipos_view', compact('todos'));
    }


    public function index(Request $request)
    {
        $columns = [
            1 => 'id_tipo',
            2 => 'nombre',
            3 => 'cientifico',
        ];

        $search = [];
        
        $totalData = tipos::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = tipos::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = tipos::where('id_tipo', 'LIKE', "%{$search}%")
                ->orWhere('nombre', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = tipos::where('id_tipo', 'LIKE', "%{$search}%")
                ->orWhere('nombre', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_tipo'] = $user->id_tipo;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['nombre'] = $user->nombre;
                $nestedData['cientifico'] = $user->cientifico;

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
    public function destroy($id_tipo)
    {
        try {
            $eliminar = tipos::findOrFail($id_tipo);
            $eliminar->delete();

            return response()->json(['success' => 'Eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar'], 500);
        }
    }



    // Función para agregar registro
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cientifico' => 'required|string|max:255',
        ]);

        try {
            $var = new tipos();
            $var->nombre = $request->nombre;
            $var->cientifico = $request->cientifico;

            $var->save();//guardar en BD

            return response()->json(['success' => 'Registro agregada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar'], 500);
        }
    }

    
//funcion para llenar el campo del formulario
public function edit($id_tipo)
{
    try {
        $var1 = tipos::findOrFail($id_tipo);
        return response()->json($var1);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener la clase'], 500);
    }
}

// Función para EDITAR una clase existente
    public function update(Request $request, $id_tipo)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'cientifico' => 'required|string|max:255',
    ]);

    try {
        $var2 = tipos::findOrFail($id_tipo);
        $var2->nombre = $request->nombre;
        $var2->cientifico = $request->cientifico;
        $var2->save();

        return response()->json(['success' => 'Editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}




}
