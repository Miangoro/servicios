<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatalogoProveedor;
use App\Models\ProveedoresContactos;
use App\Models\EvaluacionProveedor;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
                    return $banco . "<br>" . $clave;
                })
                ->addColumn('Contacto', function($row){
                    if ($row->contactos->isNotEmpty()) {
                        $contacto = $row->contactos->first();
                        return "Nombre del contacto: " . $contacto->contacto . "<br>" .
                               "Teléfono: " . $contacto->telefono;
                    }
                    return "Sin contacto registrado"; // mensaje si no hay contactos
                })
                ->addColumn('Evaluacion del Proveedor', function($row){
                    // Obtiene la evaluación más reciente (basado en 'fecha_evaluacion' o similar)
                    $ultimaEvaluacion = $row->evaluaciones->sortByDesc('fecha_evaluacion')->first();

                    if ($ultimaEvaluacion && $ultimaEvaluacion->p_nueve) {
                        $evaluacionTexto = $ultimaEvaluacion->p_nueve;
                        $claseCss = 'badge'; // Clase base para todas las etiquetas

                        // Asigna clases CSS específicas basadas en el valor de p_nueve
                        if (str_contains(strtolower($evaluacionTexto), 'confiable')) {
                            $claseCss .= ' bg-success'; // Clase de Bootstrap 5 para fondo verde
                        } elseif (str_contains(strtolower($evaluacionTexto), 'medianamente')) {
                            $claseCss .= ' bg-warning text-dark'; // Clase de Bootstrap 5 para fondo amarillo
                        } elseif (str_contains(strtolower($evaluacionTexto), 'no confiable')) {
                            $claseCss .= ' bg-danger'; // Clase de Bootstrap 5 para fondo rojo
                        } else {
                            $claseCss .= ' bg-secondary'; // Clase por defecto si no coincide
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
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editProveedor(' . $row->id_proveedor . ')">'. // Ajustado a editProveedor
                                    '<i class="fas fa-edit me-2"></i> Editar'.
                                '</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteProveedor(' . $row->id_proveedor . ')">'. // Ajustado a deleteProveedor
                                    '<i class="fas fa-trash-alt me-2"></i> Eliminar'.
                                '</a>
                            </li>'.
                        '</ul>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['Datos Bancarios', 'Contacto', 'Evaluacion del Proveedor', 'action']) // Indica qué columnas contienen HTML
                ->make(true);
        }

        return view('catalogo.find_catalogo_proveedores');
    }

}