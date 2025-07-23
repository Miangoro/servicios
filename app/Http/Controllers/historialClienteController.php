<?php

namespace App\Http\Controllers;

use App\Models\empresas_clientes;
use App\Models\historialCliente;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use assets\js\components\charts;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class historialClienteController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $sql = empresas_clientes::get(); // Obtiene todos los registros del modelo
            return DataTables::of($sql)->addIndexColumn()
                ->addColumn('constancia', function($row){ // Añadir columna para la constancia
                    if (!empty($row->constancia) && str_ends_with($row->constancia, '.pdf')) {
                        // Asume que las constancias están en la carpeta 'storage/app/public/constancias'
                        // y son accesibles vía una ruta pública o un enlace de almacenamiento.
                        // Si tu ruta es diferente, ajusta 'asset()' o 'Storage::url()'
                        // Para este ejemplo, asumimos que el campo 'constancia' ya contiene la ruta relativa correcta desde 'public' o 'storage'.
                        $pdfUrl = asset($row->constancia); // Ajusta esto si tu estructura de archivos es diferente

                        // CAMBIO AQUÍ: Usamos una etiqueta <img> en lugar de un icono de fuente
                        // DEBES REEMPLAZAR 'https://placehold.co/32x32/007bff/ffffff?text=PDF' con la URL REAL de tu icono de PDF
                        return '<a href="' . $pdfUrl . '" target="_blank" class="btn btn-sm btn-outline-info d-flex align-items-center justify-content-center" title="Ver Constancia" style="width: 40px; height: 40px; padding: 0; border-radius: 50%; overflow: hidden;">' .
                                    '<img src="https://placehold.co/32x32/007bff/ffffff?text=PDF" alt="PDF Icon" style="width: 100%; height: 100%; object-fit: contain;">' .
                               '</a>';
                    }
                    return ''; // Si no es un PDF o está vacío, no mostrar nada
                })
                ->addColumn('action', function($row){
                    // Genera el HTML para los botones de acción
                    $btn = '
                        <div class="d-flex align-items-center gap-50">
                            <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id . '">'.
                                '<li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editUnidad('.$row->id.')">
                                    <i class="ri-edit-box-line ri-20px text-info"></i>Editar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteUnidad(' . $row->id . ')">'.
                                        '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar </a>'.
                                    '</a>
                                </li>'
                            .'</ul>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['constancia', 'action']) // Indica a DataTables que estas columnas contienen HTML sin escapar
                ->make(true); // Construye la respuesta JSON para DataTables
        }

        // Si no es una solicitud AJAX, simplemente retorna la vista
        return view('clientes.find_clientes_empresas_view');
    }
}