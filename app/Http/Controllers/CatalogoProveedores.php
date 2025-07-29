<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatalogoProveedor;
use App\Models\ProveedoresContactos;
use App\Models\EvaluacionProveedor;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CatalogoProveedores extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql = CatalogoProveedor::with(['contactos', 'evaluaciones'])
                ->orderBy('id_proveedor', 'desc')
                ->get();

            return DataTables::of($sql)
                ->addIndexColumn()
                ->addColumn('Datos Bancarios', function($row){
                    $banco = $row->n_banco ? "Nombre del banco: " . $row->n_banco : "Nombre del banco: Sin datos";
                    $clave = $row->clave ? "Clave interbancaria: " . $row->clave : "Clave interbancaria: Sin datos";
                    return $banco . "<br>" . $clave . "<br>";
                })
                ->addColumn('Contacto', function ($row) {
                    $contacto = $row->contactos->first();
                    if ($contacto) {
                        return 'Nombre: ' . e($contacto->contacto) . '<br>' .
                               'Teléfono: ' . e($contacto->telefono) . '<br>' .
                               'Email: ' . e($contacto->correo ?? 'N/A');
                    }
                    return 'Sin contacto registrado';
                })
                ->addColumn('Evaluacion del Proveedor', function($row){
                    $ultimaEvaluacion = $row->evaluaciones->sortByDesc('fecha_evaluacion')->first();

                    if ($ultimaEvaluacion && $ultimaEvaluacion->p_nueve) {
                        $evaluacionTexto = $ultimaEvaluacion->p_nueve;
                        $claseCss = 'badge';

                        if (str_contains(strtolower($evaluacionTexto), 'confiable')) {
                            $claseCss .= ' bg-success';
                        } elseif (str_contains(strtolower($evaluacionTexto), 'medianamente')) {
                            $claseCss .= ' bg-warning text-dark';
                        } elseif (str_contains(strtolower($evaluacionTexto), 'no confiable')) {
                            $claseCss .= ' bg-danger';
                        } else {
                            $claseCss .= ' bg-secondary';
                        }

                        return "<span class=\"{$claseCss}\">{$evaluacionTexto}</span>";
                    }
                    return "Sin compras registradas";
                })
                ->addColumn('action', function($row){
                    $btn = '
                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-gear me-2"></i> Opciones
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_proveedor . '">'.
                            '<li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editProveedor(' . $row->id_proveedor . ')">'.
                                    '<i class="fas fa-edit me-2"></i> Editar'.
                                '</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteProveedor(' . $row->id_proveedor . ')">'.
                                    '<i class="fas fa-trash-alt me-2"></i> Eliminar'.
                                '</a>
                            </li>'.
                        '</ul>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['Datos Bancarios', 'Contacto', 'Evaluacion del Proveedor', 'action'])
                ->make(true);
        }

        return view('catalogo.find_catalogo_proveedores');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $urlAdjuntoPath = null;
            if ($request->hasFile('urlAdjunto')) {
                $urlAdjuntoPath = $request->file('urlAdjunto')->store('proveedor_adjuntos', 'public');
            }

            $proveedor = CatalogoProveedor::create([
                'razon_social' => $request->nombreProveedor,
                'direccion' => $request->direccionProveedor,
                'rfc' => $request->rfcProveedor,
                'd_bancarios' => "",
                'n_banco' => $request->nombreBanco,
                'clave' => $request->clabeInterbancaria,
                'tipo' => $request->selectTipoCompra,
                'url_adjunto' => $urlAdjuntoPath,
                'fecha_registro' => now(),
                'habilitado' => 1,
                'id_usuario' => Auth::id()
            ]);

            $this->storeContacts($request, $proveedor->id_proveedor);

            DB::commit();

            session()->flash('status', 'Proveedor y contactos guardados correctamente.');
            return response()->json(['message' => 'Proveedor y contactos agregados correctamente.'], 200);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al intentar agregar el proveedor o sus contactos. Detalles: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Almacena los contactos de un proveedor específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $proveedorId El ID del proveedor al que se asociarán los contactos.
     * @return void
     */
    protected function storeContacts(Request $request, $proveedorId)
{
    $contactosData = $request->input('contactos', []);

    if (!empty($contactosData)) {
        $nuevosContactos = [];
        foreach ($contactosData as $index => $contactoItem) {
            // Verifica existencia de claves
            if (!isset($contactoItem['nombre'], $contactoItem['telefono'])) {
                throw new \Exception("Falta el nombre o teléfono en el contacto en índice $index");
            }

            $nuevosContactos[] = [
                'id_proveedor' => $proveedorId,
                'contacto' => $contactoItem['nombre'],
                'telefono' => $contactoItem['telefono'],
                'correo' => $contactoItem['email'] ?? null,
                'cargo' => "",
                'fecha_registro' => now(),
                'habilitado' => 1,
                'id_usuario' => Auth::id()
            ];
        }

        ProveedoresContactos::insert($nuevosContactos);
    }
}

}