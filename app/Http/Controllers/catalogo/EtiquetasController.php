<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\marcas;
use App\Models\empresa;
use App\Models\catalogo_norma_certificar;
use App\Models\tipos;
use App\Models\clases;
use App\Models\categorias;
use App\Models\direcciones;
use App\Helpers\Helpers;
use App\Models\etiquetas;
use App\Models\etiquetas_destino;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;//Permiso empresa



class EtiquetasController extends Controller
{
    /*Crea la solicitud JSEON*/
public function UserManagement()
{
    $empresaId = null;

    // Solo si el usuario es tipo 3 (empresa)
    if (auth()->user()->tipo == 3) {
        $empresaId = auth()->user()->empresa?->id_empresa;
    }

    // Marcas filtradas por empresa
    $marcasQuery = marcas::with('empresa');
    if ($empresaId) {
        $marcasQuery->where('id_empresa', $empresaId);
    }
    $marcas = $marcasQuery->get();

    // Empresas (clientes) filtradas
    $empresasQuery = empresa::where('tipo', 2);
    if ($empresaId) {
        $empresasQuery->where('id_empresa', $empresaId);
    }
    $clientes = $empresasQuery->with('empresaNumClientes')->get();

    // Direcciones solo de la empresa si es tipo 3
    $destinosQuery = direcciones::query();
    if ($empresaId) {
        $destinosQuery->where('id_empresa', $empresaId);
    }
    $destinos = $destinosQuery->get();

    return view('catalogo.find_etiquetas', [
       'empresas' => $clientes,
        'tipos' => tipos::all(),
        'clases' => clases::all(),
        'categorias' => categorias::all(),
        'destinos' => $destinos,
        'marcas' => $marcas,
    ]);
}

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_etiqueta',
            2 => 'sku',
            3 => 'presentacion',
            4 => 'unidad',
            5 => 'alc_vol',
        ];

        //Permiso de empresa
        $empresaId = null;
        if (Auth::check() && Auth::user()->tipo == 3) {
            $empresaId = Auth::user()->empresa?->id_empresa;
        }

     $totalData = etiquetas::when($empresaId, function ($q) use ($empresaId) {
        $q->whereHas('marca', function ($q2) use ($empresaId) {
            $q2->where('id_empresa', $empresaId);
        });
      })->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        if (empty($search)) {
        $sql = etiquetas::with('destinos', 'marca', 'categoria', 'clase', 'tipo', 'marca.empresa.empresaNumClientes', 'url_etiqueta')
            ->when($empresaId, function ($q) use ($empresaId) {
                $q->whereHas('marca', function ($q2) use ($empresaId) {
                    $q2->where('id_empresa', $empresaId);
                });
            })
            ->offset($start)
            ->limit($limit)
            ->get();
        } else {
              $filteredQuery = etiquetas::with('destinos', 'marca', 'marca.empresa')
        ->when($empresaId, function ($q) use ($empresaId) {
            $q->whereHas('marca', function ($q2) use ($empresaId) {
                $q2->where('id_empresa', $empresaId);
            });
        })
        ->where(function ($q) use ($search) {
            $q->where('sku', 'LIKE', "%{$search}%")
                ->orWhere('presentacion', 'LIKE', "%{$search}%")
                ->orWhere('alc_vol', 'LIKE', "%{$search}%")
                ->orWhereHas('marca', function ($q) use ($search) {
                    $q->where('marca', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('destinos', function ($q) use ($search) {
                    $q->where('destinatario', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('categoria', function ($q) use ($search) {
                    $q->where('categoria', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('clase', function ($q) use ($search) {
                    $q->where('clase', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('tipo', function ($q) use ($search) {
                    $q->where('nombre', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('marca.empresa', function ($q) use ($search) {
                    $q->where('razon_social', 'LIKE', "%{$search}%");
                });
        });

    $sql = $filteredQuery
        ->offset($start)
        ->limit($limit)
        ->get();

    $totalFiltered = $filteredQuery->count();
        }

        $data = [];

        if (!empty($sql)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($sql as $etiqueta) {
                $nestedData['id_etiqueta'] = $etiqueta->id_etiqueta;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['marca'] = $etiqueta->marca->marca;
                $nestedData['sku'] = $etiqueta->sku ?? "--";
                $nestedData['presentacion'] = $etiqueta->presentacion;
                $nestedData['unidad'] = $etiqueta->unidad;
                $nestedData['alc_vol'] = $etiqueta->alc_vol." %Alc.Vol.";
                $nestedData['categoria'] = $etiqueta->categoria->categoria;
                $nestedData['clase'] = $etiqueta->clase->clase;
                /* $nestedData['tipo'] = $etiqueta->tipo
            ? $etiqueta->tipo->nombre . " (" . $etiqueta->tipo->cientifico . ")"
            : 'No especificado'; */
        //TIPOS DE agave
        $tiposNombres = tipos::pluck(DB::raw("CONCAT(nombre, ' (', cientifico, ')')"), 'id_tipo')->toArray();
            if ($etiqueta->id_tipo && $etiqueta->id_tipo !== 'N/A') {
                $idTipos = json_decode($etiqueta->id_tipo, true);

                if (is_array($idTipos)) {
                    $nombresTipos = array_map(fn($id) => $tiposNombres[$id] ?? 'Desconocido', $idTipos);
                    $nestedData['tipo'] = implode(', ', $nombresTipos);
                } else {
                    $nestedData['tipo'] = 'Desconocido';
                }
            } else {
                $nestedData['tipo'] = 'No especificado';
            }

                $nestedData['numero_cliente'] = $etiqueta->marca->empresa->empresaNumClientes
                    ?->pluck('numero_cliente')
                    ?->first(fn($num) => !empty($num)) ?? "";
                $nestedData['razon_social'] = $etiqueta->marca->empresa->razon_social;
                $nestedData['url_etiqueta'] = $etiqueta->url_etiqueta->url ?? "Sin documento";
                $direcciones = $etiqueta->destinos->map(function ($destino) {
                    return '• ' . $destino->destinatario; // Agregar viñeta antes de la dirección
                })->toArray(); // Convertimos la colección en un array

                $nestedData['destinos'] = implode('<br>', $direcciones); // Unimos las direcciones con un salto de línea
                $data[] = $nestedData;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }


    /*Metodo para actualizar*/
    public function store(Request $request)
    {
        // Verificar si estamos editando o creando una nueva etiqueta
        $etiqueta = $request->id_etiqueta ? etiquetas::find($request->id_etiqueta) : new etiquetas();

        // Si estamos editando y la etiqueta no existe, retornar error
        if ($request->id_etiqueta && !$etiqueta) {
            return response()->json(['error' => 'Etiqueta no encontrada.'], 404);
        }

        // Obtener el número de cliente asociado a la empresa
        $empresa = marcas::with("empresa.empresaNumClientes")->where("id_marca", $request->id_marca)->first();
        $numeroCliente = $empresa->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        // Asignar valores al modelo
        $etiqueta->id_marca = $request->id_marca;
        $etiqueta->id_empresa = $request->id_empresa;
        $etiqueta->sku = $request->sku ?? '';
        $etiqueta->id_categoria = $request->id_categoria;
        $etiqueta->id_clase = $request->id_clase;
        //$etiqueta->id_tipo = $request->id_tipo;
        $etiqueta->id_tipo = json_encode($request['id_tipo']);
        $etiqueta->presentacion = $request->presentacion;
        $etiqueta->unidad = $request->unidad;
        $etiqueta->alc_vol = $request->alc_vol;
        $etiqueta->botellas_caja = $request->botellas_caja ?? null;
        $etiqueta->save();

        // Eliminar destinos previos si es edición
        if ($request->id_etiqueta) {
            etiquetas_destino::where('id_etiqueta', $etiqueta->id_etiqueta)->delete();
        }

        // Guardar nuevos destinos
        foreach ($request->id_destino as $destino) {
            $direccion = new etiquetas_destino();
            $direccion->id_direccion = $destino;
            $direccion->id_etiqueta = $etiqueta->id_etiqueta;
            $direccion->save();
        }

        // Manejar la carga de documentos
        if ($request->hasFile('url_etiqueta')) {
            $file = $request->file('url_etiqueta');
            $filename = $request->nombre_documento_etiqueta . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/' . $numeroCliente . '/' . $filename;

            // Buscar si ya existe un documento para esta etiqueta
            $documentacion_url = Documentacion_url::where('id_relacion', $etiqueta->id_etiqueta)->where('id_documento',60)->first();

            if ($documentacion_url) {
                // Eliminar el archivo anterior si existe
                $oldFilePath = 'uploads/' . $numeroCliente . '/' . $documentacion_url->url;
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            } else {
                // Si no existe un registro, creamos uno nuevo
                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion = $etiqueta->id_etiqueta;
                $documentacion_url->id_documento = $request->id_documento_etiqueta;
                $documentacion_url->id_empresa = $empresa->id_empresa;
            }

            // Guardar el nuevo archivo
            $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

            // Actualizar la información del documento
            $documentacion_url->nombre_documento = $request->nombre_documento_etiqueta;
            $documentacion_url->url = $filename;
            $documentacion_url->save();
        }


           // Manejar la carga de documentos
           if ($request->hasFile('url_corrugado')) {
            $file = $request->file('url_corrugado');
            $filename = $request->nombre_documento_corrugado . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/' . $numeroCliente . '/' . $filename;

            // Buscar si ya existe un documento para esta etiqueta
            $documentacion_url = Documentacion_url::where('id_relacion', $etiqueta->id_etiqueta)->where('id_documento',75)->first();

            if ($documentacion_url) {
                // Eliminar el archivo anterior si existe
                $oldFilePath = 'uploads/' . $numeroCliente . '/' . $documentacion_url->url;
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            } else {
                // Si no existe un registro, creamos uno nuevo
                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion = $etiqueta->id_etiqueta;
                $documentacion_url->id_documento = $request->id_documento_corrugado;
                $documentacion_url->id_empresa = $empresa->id_empresa;
            }

            // Guardar el nuevo archivo
            $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

            // Actualizar la información del documento
            $documentacion_url->nombre_documento = $request->nombre_documento_corrugado;
            $documentacion_url->url = $filename;
            $documentacion_url->save();
        }


        return response()->json(['success' => $request->id_etiqueta ? 'Etiqueta actualizada exitosamente.' : 'Etiqueta registrada exitosamente.']);
    }


    //Metodo para editar las marcas
    public function edit_etiqueta($id_etiqueta)
    {
        $etiqueta = etiquetas::with('destinos')->findOrFail($id_etiqueta);
        $documentacion_urls = Documentacion_url::where('id_relacion', $id_etiqueta)->where('id_documento',60)->get(); // Obtener los documentos asociados a la marca
        $documentacion_urls_corrugado = Documentacion_url::where('id_relacion', $id_etiqueta)->where('id_documento',75)->get(); // Obtener los documentos asociados a la marca
        $empresa = marcas::with("empresa.empresaNumClientes")->where("id_marca", $etiqueta->id_marca)->first();
        $numeroCliente = $empresa->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        return response()->json([
            'etiqueta' => $etiqueta,
            'documentacion_urls' => $documentacion_urls, // Incluir la fecha de vigencia en los datos
            'documentacion_urls_corrugado' => $documentacion_urls_corrugado, // Incluir la fecha de vigencia en los datos
            'numeroCliente' => $numeroCliente
        ]);
    }

    // Método para actualizar una marca existente
    public function update(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:60',
            'cliente' => 'required|integer|exists:empresa,id_empresa',
        ]);

        try {
            $marca = marcas::findOrFail($request->input('id_marca'));
            $marca->marca = $request->marca;

            $marca->id_empresa = $request->cliente;
            $marca->id_norma = $request->edit_id_norma;
            $marca->save();

            return response()->json(['success' => 'Marca actualizada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la marca'], 500);
        }
    }


    //funcion para eliminar
    public function destroy($id_etiqueta)
    {
        $etiqueta = etiquetas::findOrFail($id_etiqueta);

        // Eliminar relaciones
        //$etiqueta->destinos()->delete();
        $etiqueta->url_etiqueta()->delete();
        $etiqueta->url_corrugado()->delete();

        // Eliminar la etiqueta principal
        $etiqueta->delete();
        return response()->json(['success' => 'Etiqueta eliminada correctamente']);
    }

    public function getDestinosPorEmpresa($id_empresa)
    {
        $destinos = direcciones::where('id_empresa', $id_empresa)->get();
         $marcas = marcas::where('id_empresa', $id_empresa)->get();

        return response()->json([
            'destinos' => $destinos,
            'marcas' => $marcas
        ]);

    }


}
