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
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class marcasCatalogoController extends Controller
{
    /*Crea la solicitud JSEON*/
    public function UserManagement()
    {
        // Obtener listado de clientes (empresas)
        $clientes = Empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        $documentos = Documentacion::where('id_documento', '=', '82')
            ->orWhere('id_documento', '=', '80')
            ->orWhere('id_documento', '=', '121')
            ->orWhere('id_documento', '=', '107')
            ->orWhere('id_documento', '=', '38')
            ->orWhere('id_documento', '=', '39')
            ->orWhere('id_documento', '=', '40')
            ->get();

        // Otros datos que puedas querer pasar a la vista
        $marcas = marcas::all();
        //$direcciones = direcciones::where('id_empresa',$marca->id_empresa)->get();
        $catalogo_norma_certificar = catalogo_norma_certificar::all();
        $tipos = tipos::all();
        $clases = clases::all();
        $categorias = categorias::all();
        $userCount = $marcas->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('catalogo.find_catalago_marcas', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'clientes' => $clientes, // Pasa la lista de clientes a la vista
            'documentos' => $documentos,
            'catalogo_norma_certificar' => $catalogo_norma_certificar,
            'tipos' => $tipos,
            'clases' => $clases,
            'categorias' => $categorias,





        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_marca',
            2 => 'folio',
            3 => 'marca',
            4 => 'id_empresa',
            5 => 'id_norma',
        ];
              if (auth()->user()->tipo == 3) {
                  $empresaId = auth()->user()->empresa?->id_empresa;
              } else {
                  $empresaId = null;
              }

        $search = [];

        $totalData = marcas::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        if (empty($search)) {
            $users = marcas::with('empresa')
            ->when($empresaId, function ($query) use ($empresaId) {
              $query->where('id_empresa', $empresaId);
                }) // Incluye la relación empresa
                ->offset($start)
                ->limit($limit)
                //  ->orderBy($order, $dir)
                ->get();
            $totalFiltered = marcas::when($empresaId, function ($query) use ($empresaId) {
            $query->where('id_empresa', $empresaId);

        })->count();
      } else {
    $users = marcas::with('empresa.empresaNumClientes', 'catalogo_norma_certificar')
        ->when($empresaId, function ($query) use ($empresaId) {
            $query->where('id_empresa', $empresaId);
        })
        ->where(function ($q) use ($search) {
            $q->where('id_marca', 'LIKE', "%{$search}%")
              ->orWhere('folio', 'LIKE', "%{$search}%")
              ->orWhere('marca', 'LIKE', "%{$search}%")
              ->orWhereHas('empresa', function ($q) use ($search) {
                  $q->where('razon_social', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('empresa.empresaNumClientes', function ($q) use ($search) {
                  $q->where('numero_cliente', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('catalogo_norma_certificar', function ($q) use ($search) {
                  $q->where('norma', 'LIKE', "%{$search}%");
              });
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

    $totalFiltered = marcas::when($empresaId, function ($query) use ($empresaId) {
            $query->where('id_empresa', $empresaId);
        })
        ->where(function ($q) use ($search) {
            $q->where('id_marca', 'LIKE', "%{$search}%")
              ->orWhere('folio', 'LIKE', "%{$search}%")
              ->orWhere('marca', 'LIKE', "%{$search}%")
              ->orWhereHas('empresa', function ($q) use ($search) {
                  $q->where('razon_social', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('empresa.empresaNumClientes', function ($q) use ($search) {
                  $q->where('numero_cliente', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('catalogo_norma_certificar', function ($q) use ($search) {
                  $q->where('norma', 'LIKE', "%{$search}%");
              });
        })
        ->count();
}

        $data = [];

        if (!empty($users)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_marca'] = $user->id_marca;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['folio'] = $user->folio;
                $nestedData['marca'] = $user->marca;
                $nestedData['id_empresa'] = $user->id_empresa;
                $nestedData['id_norma'] = $user->catalogo_norma_certificar->norma ?? 'Sin norma';
                $numeroCliente =
                    $user->empresa->empresaNumClientes[0]->numero_cliente ??
                    $user->empresa->empresaNumClientes[1]->numero_cliente ??
                    $user->empresa->empresaNumClientes[2]->numero_cliente;
                $razonSocial = $user->empresa ? $user->empresa->razon_social : '';
                $nestedData['razon_social'] = '<b>' . $numeroCliente . '</b><br>' . $razonSocial;
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
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->cliente)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        if ($request->id) {
            // Actualizar marca existente
            $marca = marcas::findOrFail($request->id);
            $marca->id_empresa = $request->cliente;
            $marca->marca = $request->marca;
            $marca->id_norma = $request->id_norma;
            //$marca->folio = Helpers::generarFolioMarca($request->cliente);
            $marca->save();

            // Actualizar documentos existentes o agregar nuevos
            if ($request->has('id_documento')) {
                foreach ($request->id_documento as $index => $id_documento) {
                    $documento = Documentacion_url::where('id_relacion', $marca->id_marca)
                        ->where('id_documento', $id_documento)
                        ->first();

                    if ($documento) {
                        // Actualizar archivo y fecha de vigencia si están presentes
                        if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                            // Eliminar el archivo anterior
                            Storage::disk('public')->delete('uploads/' . $numeroCliente . '/' . $documento->url);
                            // Subir el nuevo archivo
                            $file = $request->file('url')[$index];
                            $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                            $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');
                            // Actualizar en la base de datos
                            $documento->url = $filename;
                        }

                        // Actualizar fecha de vigencia solo si está presente en la solicitud
                        if (!empty($request->fecha_vigencia[$index])) {
                            $documento->fecha_vigencia = $request->fecha_vigencia[$index];
                        }
                        $documento->save();
                    } else {
                        // Agregar nuevo documento si no existe
                        if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                            $file = $request->file('url')[$index];
                            $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                            $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                            $documentacion_url = new Documentacion_url();
                            $documentacion_url->id_relacion = $marca->id_marca;
                            $documentacion_url->id_documento = $id_documento;
                            $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                            $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                            $documentacion_url->id_empresa = $request->cliente;
                            $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null;
                            $documentacion_url->save();
                        }
                    }
                }
            }
        } else {
            // Crear nueva marca
            $marca = new marcas();
            $marca->id_empresa = $request->cliente;
            $marca->marca = $request->marca;
            $marca->id_norma = $request->id_norma;
            $marca->folio = Helpers::generarFolioMarca($request->cliente);
            $marca->save();
            // Almacenar nuevos documentos solo si se envían
            if ($request->hasFile('url')) {
                foreach ($request->file('url') as $index => $file) {
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $marca->id_marca;
                    $documentacion_url->id_documento = $request->id_documento[$index];
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $request->cliente;
                    $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null; // Usa null si no hay fecha
                    $documentacion_url->save();
                }
            }
        }
        return response()->json(['success' => 'Marca registrada exitosamente.']);
    }

    //Metodo para editar las marcas
    public function edit($id)
    {
        $marca = Marcas::findOrFail($id);
        $documentacion_urls = Documentacion_url::where('id_relacion', $id)->get(); // Obtener los documentos asociados a la marca
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $marca->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        return response()->json([
            'marca' => $marca,
            'documentacion_urls' => $documentacion_urls, // Incluir la fecha de vigencia en los datos
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

    public function marcas()
    {
        $clientes = empresa::where('tipo', 1)->get();
        $opciones = marcas::all();
        return view('catalogo.find_catalago_marcas', compact('opciones', 'clientes'));
    }

    //funcion para eliminar
    public function destroy($id_marca)
    {
        $clase = marcas::findOrFail($id_marca);
        $clase->delete();
        return response()->json(['success' => 'Clase eliminada correctamente']);
    }

    public function updateEtiquetas(Request $request)
    {
        try {
            // Validación de los campos requeridos
            $request->validate([
                'id_direccion' => 'required|array',
                'id_marca' => 'required|exists:marcas,id_marca',
                'sku' => 'array',
                'id_tipo' => 'array',
                'presentacion' => 'array',
                'unidad' => 'array',
                'id_clase' => 'array',
                'id_categoria' => 'array',
                'alc_vol' => 'array',
                'id_documento' => 'array',
                'url_etiqueta' => 'array',
                'url_corrugado' => 'array',
            ]);

            // Obtener datos del formulario
            $direcciones = $request->id_direccion;
            $totalElementos = count($direcciones);
            $idUnico = $request->id_unico ?? [];

            // Completar IDs únicos si faltan
            for ($i = count($idUnico); $i < $totalElementos; $i++) {
                $idUnico[] = Str::uuid()->toString();
            }

            // Actualizar el lote envasado con datos etiquetados
            $loteEnvasado = marcas::findOrFail($request->id_marca);
            $loteEnvasado->etiquetado = json_encode([
                'id_unico' => $idUnico,
                'id_direccion' => $direcciones,
                'sku' => $request->sku,
                'id_tipo' => $request->id_tipo,
                'presentacion' => $request->presentacion,
                'unidad' => $request->unidad,
                'id_clase' => $request->id_clase,
                'id_categoria' => $request->id_categoria,
                'alc_vol' => $request->alc_vol,
            ]);
            $loteEnvasado->save();

            // Obtener el número de cliente
            $empresa = empresa::with('empresaNumClientes')
                ->where('id_empresa', $loteEnvasado->id_empresa)
                ->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')
                ->first(fn($numero) => !empty($numero));

            // Documentos actuales
            $documentosActuales = Documentacion_url::where('id_relacion', $loteEnvasado->id_marca)
                ->whereIn('id_documento', [60, 75])
                ->pluck('id_doc', 'id_documento')
                ->toArray();
                $imprimir = 'No entra a nada';

                foreach ($idUnico as $item) {
                    $idUnico1[] = $item;
                    $idUnico1[] = $item; // Duplicamos el valor
                }


            // Procesar cada documento enviado
            foreach ($request->id_documento as $index => $id_documento) {



                if ($id_documento ==60 AND !isset($idUnico1[$index]) AND !isset($request->url_etiqueta[$index])) {
                    continue;
                }

                if ($id_documento == 75 AND !isset($idUnico1[$index]) AND !isset($request->url_corrugado[$index])) {
                    continue;
                }

               // $imprimir = $imprimir.'-entro aunque sea al for'.$idUnico1[$index].' y '.$id_documento;

                $currentIdUnico = $idUnico1[$index];
                $documento = Documentacion_url::where('id_doc', $currentIdUnico)
                    ->where('id_documento', $id_documento)
                    ->where('id_relacion', $loteEnvasado->id_marca)
                    ->first();

                if ($documento) {
                    // Actualizar documento existente
                    $imprimir = $imprimir.'---entro al editar'.$id_documento.' '.$currentIdUnico;
                    $this->updateDocument($documento, $request, $index, $numeroCliente,$imprimir);
                } else {
                    // Crear un nuevo documento
                    //$imprimir = $imprimir.'---entro al registrar'.$id_documento.' '.$currentIdUnico;
                    $this->createNewDocuments($loteEnvasado, $currentIdUnico, $request, $index, $numeroCliente);
                }
            }

            return response()->json(['success' => 'Etiquetas actualizadas correctamente']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar las etiquetas',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }

    }

    protected function updateDocument($documento, $request, $index, $numeroCliente,$imprimir)
    {   $imprimir = 'a editar';
        if (isset($request->file('url')[$index]) && $documento->id_documento==60) {
            $file = $request->file('url')[$index];
            $filename = 'etiquetas_editado' . time() . $index . '.' . $file->getClientOriginalExtension();
            $file->storeAs("uploads/$numeroCliente", $filename, 'public');
            $documento->url = $filename;
            $documento->save();
        }

        if (isset($request->file('url')[$index]) && $documento->id_documento==75) {
            $file = $request->file('url')[$index];
            $filename = 'corrugado_editado' . time() . $index . '.' . $file->getClientOriginalExtension();
            $file->storeAs("uploads/$numeroCliente", $filename, 'public');
            $documento->url = $filename;
            $documento->save();
        }
    }

    protected function createNewDocuments($loteEnvasado, $currentIdUnico, $request, $index, $numeroCliente)
    {
        $imprimir = 'a registrar';
        if (isset($request->file('url')[$index])) {
            $file = $request->file('url')[$index];
            $filename = $request->nombre_documento[$index].'_' . time() . $index . '.' . $file->getClientOriginalExtension();
            $file->storeAs("uploads/$numeroCliente", $filename, 'public');

            Documentacion_url::create([
                'id_relacion' => $loteEnvasado->id_marca,
                'id_doc' => $currentIdUnico,
                'id_documento' => $request->id_documento[$index],
                'nombre_documento' => $request->nombre_documento[$index],
                'url' => $filename,
                'id_empresa' => $loteEnvasado->id_empresa,
            ]);
        }


    }






    //Editar etiquetas solo para quie se guarde
    public function editEtiquetas($id)
    {
        $marca = Marcas::findOrFail($id);
        $tipos = tipos::all();
        $clases = clases::all();
        $direcciones = direcciones::where('id_empresa',$marca->id_empresa)->where('tipo_direccion',1)->get();
        $categorias = categorias::all();
        $documentacion_urls = Documentacion_url::where('id_relacion', $id)->get();
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $marca->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        $etiquetado = json_decode($marca->etiquetado, true);
        $marca->id_direccion = $etiquetado['id_direccion'] ?? null;
        $marca->sku = $etiquetado['sku'] ?? null;
        $marca->id_tipo = $etiquetado['id_tipo'] ?? null;
        $marca->presentacion = $etiquetado['presentacion'] ?? null;
        $marca->id_clase = $etiquetado['id_clase'] ?? null;
        $marca->id_categoria = $etiquetado['id_categoria'] ?? null;
        $marca->id_unico = $etiquetado['id_unico'] ?? null;
        $marca->alc_vol = $etiquetado['alc_vol'] ?? null;
        $marca->unidad = $etiquetado['unidad'] ?? null;

        return response()->json([
            'direcciones' => $direcciones,
            'marca' => $marca,
            'tipos' => $tipos,
            'clases' => $clases,
            'categorias' => $categorias,
            'documentacion_urls' => $documentacion_urls, // Incluir la fecha de vigencia en los datos
            'numeroCliente' => $numeroCliente
        ]);
    }
}
