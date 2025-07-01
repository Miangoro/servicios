<?php

namespace App\Http\Controllers\catalogo;

use App\Models\lotes_envasado;
use App\Models\empresa;
use App\Models\marcas;
use App\Models\LotesGranel;
use App\Models\instalaciones;
use App\Http\Controllers\Controller;
use App\Models\lotes_envasado_granel;
use Illuminate\Http\Request;
use App\Models\Documentacion_url;
use App\Models\empresaNumCliente;

use App\Models\tipos;
use App\Models\clases;
use App\Models\categorias;
use App\Models\Destinos;

use App\Models\Exception;
use Exception as GlobalException;

class lotesEnvasadoController extends Controller
{
    public function UserManagement()
    {
        $clientes = empresa::where('tipo', 2)->get();
        $marcas = marcas::all();
        $lotes_granel = LotesGranel::all();
        $lotes_envasado = lotes_envasado::all();
        $Instalaciones = instalaciones::all();
        $clases = clases::all();
        $categorias = categorias::all();

        $tipos = tipos::all();
        $marcas = marcas::all();
        $userCount = $lotes_envasado->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('catalogo.find_lotes_envasados', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'clientes' => $clientes,
            'marcas' => $marcas,
            'lotes_granel' => $lotes_granel,
            'lotes_envasado' => $lotes_envasado,
            'Instalaciones' => $Instalaciones,
            'clases' => $clases,
            'categorias' => $categorias,
            'tipos' => $tipos,

        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_lote_envasado',
            2 => 'id_empresa',
            3 => 'nombre',
            4 => 'sku',
            5 => 'id_marca',
            6 => 'destino_lote',
            7 => 'cant_botellas',
            8 => 'presentacion',
            9 => 'unidad',
            10 => 'volumen_total',
            11 => 'lugar_envasado',
        ];
              if (auth()->user()->tipo == 3) {
                  $empresaId = auth()->user()->empresa?->id_empresa;
              } else {
                  $empresaId = null;
              }

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = 'id_lote_envasado';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = lotes_envasado::with(['empresa.empresaNumClientes', 'marca', 'Instalaciones', 'lotes_envasado_granel']); // Cargar relaciones necesarias
        if ($empresaId) {
            $query->where('id_empresa', $empresaId);
        }
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('destino_lote', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nombre', 'LIKE', "%{$searchValue}%")
                    ->orWhere('sku', 'LIKE', "%{$searchValue}%")
                    ->orWhere('estatus', 'LIKE', "%{$searchValue}%");

                $q->orWhereHas('marca', function ($qMarca) use ($searchValue) {
                    $qMarca->where('marca', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('Instalaciones', function ($qDireccion) use ($searchValue) {
                    $qDireccion->where('direccion_completa', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('empresa', function ($qEmpresa) use ($searchValue) {
                    $qEmpresa->where('razon_social', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('lotes_envasado_granel.lotes_granel', function ($qEmpresa) use ($searchValue) {
                    $qEmpresa->where('nombre_lote', 'LIKE', "%{$searchValue}%");
                });


                $q->orWhereHas('empresa.empresaNumClientes', function ($q) use ($searchValue) {
                    $q->where('numero_cliente', 'LIKE', "%{$searchValue}%");
                });
            });
        }

        $totalData = lotes_envasado::count();
        $totalFiltered = $query->count();

        $users = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        if ($users->isNotEmpty()) {
            $ids = $start;

            foreach ($users as $user) {

                $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $user->id_empresa)->first();

$numero_cliente = $empresa?->empresaNumClientes?->pluck('numero_cliente')->first(fn($numero) => !empty($numero));

                $sku = json_decode($user->sku, true); // Decodifica el JSON en un array
                $inicial = isset($sku['inicial']) ? $sku['inicial'] : 0; // Obtén el valor de 'inicial' del JSON
                $nuevo = isset($sku['nuevo']) ? $sku['nuevo'] : 0; // Obtén el valor de 'inicial' del JSON
                $cantt_botellas = isset($sku['cantt_botellas']) ? $sku['cantt_botellas'] : $user->cant_botellas;
                $nombres_lote = lotes_envasado_granel::where('id_lote_envasado', $user->id_lote_envasado)
                    ->with('loteGranel') // Carga la relación
                    ->get()
                    ->pluck('loteGranel.nombre_lote'); // Obtén los nombres de los lotes



                $nestedData = [
                    'id_lote_envasado' => $user->id_lote_envasado,
                    'fake_id' => ++$ids,
                    'id_empresa' => $numero_cliente,
                    'id_marca' => $user->marca->marca ?? '',
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'nombre' => $user->nombre,
                    'cant_botellas' => $user->cant_botellas,
                    'presentacion' => $user->presentacion,
                    'unidad' => $user->unidad,
                    'destino_lote' => $user->destino_lote,
                    'volumen_total' => $user->volumen_total,
                    'lugar_envasado' => $user->Instalaciones->direccion_completa ?? '',
                    'sku' => $user->sku,
                    'inicial' => $inicial,
                    'nuevo' => $nuevo,
                    'cantt_botellas' => $cantt_botellas,
                    'estatus' => $user->estatus,
                    'id_lote_granel' => $nombres_lote,

                ];
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

    //Metodo para eliminar
    public function destroy($id_lote_envasado)
    {
        $clase = lotes_envasado::findOrFail($id_lote_envasado);
        $clase->delete();
        return response()->json(['success' => 'Lote envasado eliminada correctamente']);
    }

    //Metodo para egistrar
public function store(Request $request)
{
    try {
        // Crear lote envasado
        $lotes = new lotes_envasado();
        $lotes->id_empresa = $request->id_empresa;
        $lotes->nombre = $request->nombre;
        $lotes->sku = json_encode(['inicial' => $request->sku]);
        $lotes->id_marca = $request->id_marca;
        $lotes->destino_lote = $request->destino_lote;
        $lotes->cant_botellas = $request->cant_botellas;
        $lotes->cant_bot_restantes = $request->cant_botellas;
        $lotes->presentacion = $request->presentacion;
        $lotes->unidad = $request->unidad;
        $lotes->volumen_total = $request->volumen_total;
        $lotes->vol_restante = $request->volumen_total;
        $lotes->lugar_envasado = $request->lugar_envasado;
        $lotes->tipo = $request->tipo;
        $lotes->save();

        // Guardar relaciones con lotes a granel (si las hay)
        if ($request->has('id_lote_granel') && is_array($request->id_lote_granel)) {
            for ($i = 0; $i < count($request->id_lote_granel); $i++) {
                $volumenParcial = $request->volumen_parcial[$i] ?? 0;

                // Si hay algún lote seleccionado, se guarda la relación
                if ($volumenParcial > 0) {
                    $envasado = new lotes_envasado_granel();
                    $envasado->id_lote_envasado = $lotes->id_lote_envasado;
                    $envasado->id_lote_granel = $request->id_lote_granel[$i];
                    $envasado->volumen_parcial = $volumenParcial;
                    $envasado->save();

                    // Actualiza volumen restante del lote a granel
                    $loteGranel = LotesGranel::find($request->id_lote_granel[$i]);
                    if ($loteGranel) {
                        $loteGranel->volumen_restante -= $volumenParcial;
                        $loteGranel->save();
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Lote envasado registrado exitosamente.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}



    //Editar lotes envasados
    public function edit($id)
    {
        try {
            $envasado_granel = lotes_envasado::with(['lotes_envasado_granel.loteGranel'])->findOrFail($id);
            $sku = json_decode($envasado_granel->sku, true);
            // Añadir los valores de folio inicial y folio final
            $envasado_granel->inicial = $sku['inicial'] ?? null;
            // Extraer el nombre_lote de cada lote_granel relacionado
            $envasado_granel->lotes_envasado_granel->each(function ($loteGranel) {
                $loteGranel->nombre_lote = $loteGranel->loteGranel->nombre_lote ?? 'N/A';
            });
            // Retornar el objeto JSON
            return response()->json($envasado_granel);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el lote envasado'], 500);
        }


    }

    //Actualizar lotes envasados
    public function update(Request $request)
    {
        try {
            // Buscar el lote existente
            $lotes = lotes_envasado::findOrFail($request->input('id'));

            // 1. Restaurar volumen_restante de los lotes a granel originales
            $relacionesOriginales = lotes_envasado_granel::where('id_lote_envasado', $lotes->id_lote_envasado)->get();
            foreach ($relacionesOriginales as $relacion) {
                $loteGranel = LotesGranel::find($relacion->id_lote_granel);
                if ($loteGranel) {
                    $loteGranel->volumen_restante += $relacion->volumen_parcial;
                    $loteGranel->save();
                }
            }

            lotes_envasado_granel::where('id_lote_envasado', $lotes->id_lote_envasado)->delete();

            // Actualizar los campos del lote envasado
            $lotes->id_empresa = $request->edit_cliente;
            $lotes->nombre = $request->edit_nombre;

            // Decodificar el JSON existente
            $skuData = json_decode($lotes->sku, true) ?: [];
            // Actualizar solo el campo 'inicial' con el nuevo valor del request
            $skuData['inicial'] = $request->edit_sku;
            // Re-codificar el array a JSON y guardarlo en el campo 'sku'
            $lotes->sku = json_encode($skuData);
            // Guardar los cambios en la base de datos
            /* $lotes->save(); */

            $lotes->id_marca = $request->edit_marca;
            $lotes->destino_lote = $request->edit_destino_lote;
            $lotes->cant_botellas = $request->edit_cant_botellas;
            $lotes->presentacion = $request->edit_presentacion;
            $lotes->unidad = $request->edit_unidad;
            $lotes->volumen_total = $request->edit_volumen_total;
            $lotes->lugar_envasado = $request->edit_Instalaciones;
            $lotes->tipo = $request->tipo;
            $lotes->save();

            // Eliminar los registros de `lotes_envasado_granel` relacionados con este lote
            /* lotes_envasado_granel::where('id_lote_envasado', $lotes->id_lote_envasado)->delete(); */

            // Guardar los testigos relacionados si existen
        // 4. Guardar los nuevos testigos relacionados y actualizar volumen_restante
        if ($request->has('id_lote_granel') && is_array($request->id_lote_granel) && $request->has('volumen_parcial') && is_array($request->volumen_parcial)) {
            for ($i = 0; $i < count($request->id_lote_granel); $i++) {
                if (isset($request->id_lote_granel[$i]) && isset($request->volumen_parcial[$i])) {
                    $envasado = new lotes_envasado_granel();
                    $envasado->id_lote_envasado = $lotes->id_lote_envasado;
                    $envasado->id_lote_granel = $request->id_lote_granel[$i];
                    $envasado->volumen_parcial = $request->volumen_parcial[$i];
                    $envasado->save();

                    // Restar el nuevo volumen parcial al lote a granel
                    $loteGranel = LotesGranel::find($request->id_lote_granel[$i]);
                    if ($loteGranel) {
                        $loteGranel->volumen_restante -= $request->volumen_parcial[$i];
                        if ($loteGranel->volumen_restante < 0) {
                            return response()->json([
                                'success' => false,
                                'message' => 'El volumen del lote a granel no puede ser negativo.'
                            ], 400);
                        }
                        $loteGranel->save();
                    }
                }
            }
        }

            return response()->json(['success' => 'Lote envasado actualizado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //Modificar SKU
    public function editSKU($id)
    {
        try {
            // Aquí obtienes el acta de inspección junto con sus testigos
            $edicionsku = lotes_envasado::findOrFail($id);
            $sku = json_decode($edicionsku->sku, true);

            // Añadir los valores de folio inicial y folio final
            $edicionsku->inicial = $sku['inicial'] ?? null;
            $edicionsku->observaciones = $sku['observaciones'] ?? null;
            $edicionsku->nuevo = $sku['nuevo'] ?? null;
            $edicionsku->cantt_botellas = $sku['cantt_botellas'] ?? null;

            return response()->json($edicionsku);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el sku'], 500);
        }
    }

    //Actualizar SKU
    public function updateSKU(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $sku_nuevo = lotes_envasado::findOrFail($request->input('id'));
            $sku_nuevo->sku = json_encode([
                'inicial' => $request->edictt_sku,
                'observaciones' => $request->observaciones,
                'nuevo' => $request->nuevo, // Puedes agregar otros valores también
                'cantt_botellas' => $request->cantt_botellas, // Puedes agregar otros valores también
            ]);
            $sku_nuevo->save();
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Reclasificación  actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envió'], 500);
        }
    }

    //Metodo obtener etiquetas
    public function obtenerMarcasPorEmpresa($id_empresa)
    {
        $marcas = marcas::where('id_empresa', $id_empresa)->get();

        foreach ($marcas as $marca) {
            $etiquetado = is_string($marca->etiquetado) ? json_decode($marca->etiquetado, true) : $marca->etiquetado;

            if (is_null($etiquetado) || !is_array($etiquetado)) {
                $marca->tipo_nombre = [];
                $marca->clase_nombre = [];
                $marca->categoria_nombre = [];
                $marca->direccion_nombre = [];
                $marca->etiquetado = [];
                continue;
            }

            $tipos = isset($etiquetado['id_tipo']) ? tipos::whereIn('id_tipo', $etiquetado['id_tipo'])->pluck('nombre')->toArray() : [];
            $clases = isset($etiquetado['id_clase']) ? clases::whereIn('id_clase', $etiquetado['id_clase'])->pluck('clase')->toArray() : [];
            $categorias = isset($etiquetado['id_categoria']) ? categorias::whereIn('id_categoria', $etiquetado['id_categoria'])->pluck('categoria')->toArray() : [];

            $direcciones = [];
            if (isset($etiquetado['id_direccion']) && is_array($etiquetado['id_direccion'])) {
                foreach ($etiquetado['id_direccion'] as $id_direccion) {
                    $direccion = Destinos::where('id_direccion', $id_direccion)->value('direccion');
                    $direcciones[] = $direccion ?? 'N/A';
                }
            }

            // Obtener los documentos asociados a la marca
            $documentos = Documentacion_url::where('id_empresa', $marca->id_empresa)
                                            ->where('id_relacion', $marca->id_marca)
                                            ->get();

            // Agregar los datos procesados al resultado
            $marca->tipo_nombre = $tipos;
            $marca->clase_nombre = $clases;
            $marca->categoria_nombre = $categorias;
            $marca->direccion_nombre = $direcciones;
            $marca->etiquetado = $etiquetado;
            $marca->documentos = $documentos; // Agregar documentos a la marca
        }

        return response()->json($marcas);
    }


}
