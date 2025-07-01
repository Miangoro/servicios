<?php

namespace App\Http\Controllers\documentacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documentacion;
use Exception;

class DocumentosController extends Controller
{
    public function UserManagement() {
        $documentacion = Documentacion::all();
        return view('documentacion.documentos_view', ['documentacion' => $documentacion]);
    }
    
    public function index(Request $request)
    {
        $columns = [
            1 => 'id_documento',
            2 => 'nombre',
            3 => 'tipo',
        ];
    
        $search = $request->input('search.value');
        $totalData = Documentacion::count();
        $totalFiltered = $totalData;
    
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id_documento';
        $dir = $request->input('order.0.dir');
    
        $query = Documentacion::query();
    
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('id_documento', 'LIKE', "%{$search}%")
                    ->orWhere('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('tipo', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }
    
        $documentacion = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    
        $data = [];
        $counter = $start + 1; // Iniciar el contador en el índice adecuado
    
        foreach ($documentacion as $documento) {
            $nestedData['fake_id'] = $counter++;
            $nestedData['id_documento'] = $documento->id_documento ?? 'N/A';
            $nestedData['nombre'] = $documento->nombre ?? 'N/A';
            $nestedData['tipo'] = $documento->tipo ?? 'N/A';
            $nestedData['actions'] = '<button class="btn btn-danger btn-sm delete-record" data-id="' . $documento->id_documento . '">Eliminar</button>';
    
            $data[] = $nestedData;
        }
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }    

//funcion para agregar registro
public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
    ]);

    $documento = new Documentacion();
    $documento->nombre = $request->nombre;
    $documento->tipo = $request->tipo;
    $documento->save();
    
    return response()->json(['success' => 'Categoría agregada correctamente']);
}
    
    public function destroy($id)
    {
        try {
            $documento = Documentacion::findOrFail($id);
            $documento->delete();
            return response()->json(['success' => true, 'message' => 'Registro eliminado correctamente.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el registro.']);
        }
    }

    public function edit($id)
    {
        $documento = Documentacion::find($id);
        if ($documento) {
            return response()->json($documento);
        }
        return response()->json(['message' => 'Documento no encontrado'], 404);
    }

    // Método para actualizar un documento
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string'
        ]);

        $documento = Documentacion::find($id);
        if ($documento) {
            $documento->update([
                'nombre' => $request->input('nombre'),
                'tipo' => $request->input('tipo')
            ]);
            return response()->json(['success' => 'Documento actualizado correctamente']);
        }
        return response()->json(['message' => 'Documento no encontrado'], 404);
    }
    
}
