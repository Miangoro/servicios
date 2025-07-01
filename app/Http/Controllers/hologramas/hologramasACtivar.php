<?php

namespace App\Http\Controllers\hologramas;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\activarHologramasModelo;
use App\Models\empresa;
use App\Models\solicitudHolograma as ModelsSolicitudHolograma;
use App\Models\direcciones;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;
use App\Models\tipos;
use App\Models\categorias;
use App\Models\clases;
use App\Models\Documentacion_url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class hologramasActivar extends Controller
{
    public function find_hologramas_activar()
    {
        $Empresa = Empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 5)->Orwhere('id_tipo', 6)->Orwhere('id_tipo', 11)->Orwhere('id_tipo', 8);
        })
            ->orderBy('id_inspeccion', 'desc')
            ->get();
        $categorias = categorias::all();
        $tipos = tipos::all();
        $clases = clases::all();

        $ModelsSolicitudHolograma = ModelsSolicitudHolograma::all();
        $userCount = $ModelsSolicitudHolograma->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('hologramas.find_activar_hologramas_view', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'Empresa' => $Empresa,
            'ModelsSolicitudHolograma' => $ModelsSolicitudHolograma,
            'inspeccion' => $inspeccion,
            'categorias' => $categorias,
            'tipos' => $tipos,
            'clases' => $clases,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'folio_activacion',

        ];
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_solicitud';
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        if (auth()->user()->tipo =3){
          $empresaId = auth()->user()->empresa?->id_empresa;
        } else {
          $empresaId = null;
        }

    $query = activarHologramasModelo::when(['inspeccion', 'solicitudHolograma.marcas', 'solicitudHolograma.empresa'])
        ->when($empresaId, function ($q) use ($empresaId) {
            $q->whereHas('solicitudHolograma.empresa', function ($q2) use ($empresaId) {
                $q2->where('id_empresa', $empresaId);
            });
        });


        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('no_lote_agranel', 'LIKE', "%{$searchValue}%")
                    ->orWhere('folio_activacion', 'LIKE', "%{$searchValue}%");

                $q->orWhereHas('solicitudHolograma', function ($sql) use ($searchValue) {
                    $sql->where('folio', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('solicitudHolograma.marcas', function ($Marca) use ($searchValue) {
                    $Marca->where('marca', 'LIKE', "%{$searchValue}%");
                });
            });
        }

    $totalData = activarHologramasModelo::when($empresaId, function ($q) use ($empresaId) {
        $q->whereHas('solicitudHolograma.empresa', function ($q2) use ($empresaId) {
            $q2->where('id_empresa', $empresaId);
        });
    })->count();
        $totalFiltered = $query->count();

        $datos = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];

        if ($datos->isNotEmpty()) {
            $ids = $start;

            foreach ($datos as $dato) {

                $numero_cliente = optional(
                    $dato->solicitudHolograma->empresa->empresaNumClientes
                        ->firstWhere('numero_cliente', '!=', null)
                )->numero_cliente;

                $marca = $dato->solicitudHolograma->marcas->marca;
                $folioMarca = $dato->solicitudHolograma->marcas->folio;
                $folios = $dato->folios;
                $folios = json_decode($folios, true);
                $rangoFolios = [];

                for ($i = 0; $i < count($folios['folio_inicial']); $i++) {
                    $rangoFolios[] =
                    '<a target="_blank" href="/holograma/' . $numero_cliente . '-' .$dato->solicitudHolograma->tipo. $folioMarca.str_pad($folios['folio_inicial'][$i], 6, '0', STR_PAD_LEFT) . '">' .
                    $numero_cliente . '-'  .$dato->solicitudHolograma->tipo. $folioMarca. str_pad($folios['folio_inicial'][$i], 6, '0', STR_PAD_LEFT) .
                    '</a> a ' .
                    '<a target="_blank" href="/holograma/' . $numero_cliente . '-' .$dato->solicitudHolograma->tipo. $folioMarca. str_pad($folios['folio_final'][$i], 6, '0', STR_PAD_LEFT) . '">' .
                    $numero_cliente . '-' .$dato->solicitudHolograma->tipo. $folioMarca. str_pad($folios['folio_final'][$i], 6, '0', STR_PAD_LEFT) .
                    '</a>';

                }
                $mensaje = implode('<br>', $rangoFolios);


                $nestedData = [
                    'fake_id' => ++$ids,
                    'id' => $dato->id,
                    'folio_activacion' => $dato->folio_activacion,
                    'folio_solicitud' => $dato->solicitudHolograma->folio,
                    'num_servicio' => $dato->inspeccion->num_servicio,
                    'marca' => $marca,
                    'lote_granel' => $dato->no_lote_agranel,
                    'lote_envasado' => $dato->no_lote_envasado,
                    'folios' => $mensaje,

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


    public function activarHologramas(Request $request)
    {
        $solicitudes = $request->input('solicitudes'); // Array de solicitudes involucradas
        $folios = $request->input('folios'); // Array de folios seleccionados

        // Convertimos las cadenas en arrays (si es necesario)
        if (!is_array($solicitudes)) {
            $solicitudes = explode(',', $solicitudes);
        }
        if (!is_array($folios)) {
            $folios = explode(',', $folios);
        }

        // Activamos los hologramas
        $activarHologramas = new activarHologramasModelo();
        $activarHologramas->activarHologramasDesdeVariasSolicitudes($solicitudes, $folios);

        return response()->json(['message' => 'Hologramas activados correctamente']);
    }


    public function getDatosInpeccion($id_inspeccion)
    {

        $datos = inspecciones::with('solicitud.lote_envasado.lotesGranel.certificadoGranel')->find($id_inspeccion);

        $numeroCliente = $datos->solicitud->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });
        $datos->url_acta = $datos->solicitud->documentacion(69)->pluck('url')->toArray();
        $datos->numero_cliente = $numeroCliente;
        return response()->json($datos); // Retorna en formato JSON
    }

    public function verificarFolios(Request $request)
    {
        $folio_inicial = $request->input('folio_inicial');
        $folio_final = $request->input('folio_final');
        $id_solicitud = $request->input('id_solicitud');

        // Obtener el rango de folios de la solicitud
        $solicitud = ModelsSolicitudHolograma::where('id_solicitud', $id_solicitud)->first();

        if (!$solicitud) {
            return response()->json(['error' => 'La solicitud no existe.'], 400);
        }

        // Validar que el rango esté dentro del rango de la solicitud
        if ($folio_inicial < $solicitud->folio_inicial || $folio_final > $solicitud->folio_final) {
            return response()->json(['error' => 'El rango de folios está fuera del rango permitido por la solicitud.'], 400);
        }

        // Verificar si los folios ya fueron activados en otras activaciones
        $activaciones = activarHologramasModelo::where('id_solicitud', $id_solicitud)->get();

        foreach ($activaciones as $activacion) {
            $folios_activados = json_decode($activacion->folios, true);


            // Recorrer todos los rangos almacenados en el JSON
            for ($i = 0; $i < count($folios_activados['folio_inicial']); $i++) {
                $activado_folio_inicial = (int) $folios_activados['folio_inicial'][$i];
                $activado_folio_final = (int) $folios_activados['folio_final'][$i];

                // Verificar si al menos UN folio del nuevo rango ya está activado
                if (
                    ($folio_inicial >= $activado_folio_inicial && $folio_inicial <= $activado_folio_final) || // Folio inicial dentro de un rango activado
                    ($folio_final >= $activado_folio_inicial && $folio_final <= $activado_folio_final) ||     // Folio final dentro de un rango activado
                    ($folio_inicial <= $activado_folio_inicial && $folio_final >= $activado_folio_final)      // Rango nuevo envuelve al rango activado
                ) {
                    return response()->json(['error' => 'Entra dentro del rango activado ' . $activado_folio_inicial . ' y ' . $activado_folio_final . ' de la activación <b>' . $activacion->folio_activacion . '</b>'], 400);
                }
            }
        }


        return response()->json(['success' => 'El rango de folios está disponible.']);
    }

    //Registrar activar
    public function storeActivar(Request $request)
    {
        $loteEnvasado = new activarHologramasModelo();
        $loteEnvasado->folio_activacion = $request->folio_activacion;
        $loteEnvasado->id_inspeccion = $request->id_inspeccion;
        $loteEnvasado->no_lote_agranel = $request->no_lote_agranel;
        $loteEnvasado->certificado_granel = $request->certificado_granel;
        $loteEnvasado->edad = $request->edad;
        $loteEnvasado->categoria = $request->categoria;
        $loteEnvasado->no_analisis = $request->no_analisis;
        $loteEnvasado->cont_neto = $request->cont_neto;
        $loteEnvasado->unidad = $request->unidad;
        $loteEnvasado->clase = $request->clase;
        $loteEnvasado->contenido = $request->contenido;
        $loteEnvasado->no_lote_envasado = $request->no_lote_envasado;
        $loteEnvasado->id_tipo = $request->id_tipo;
        $loteEnvasado->lugar_produccion = $request->lugar_produccion;
        $loteEnvasado->lugar_envasado = $request->lugar_envasado;
        $loteEnvasado->id_solicitud = $request->id_solicitudActivacion;
        $loteEnvasado->folios = json_encode([
            'folio_inicial' => $request->rango_inicial,
            'folio_final' => $request->rango_final, // Puedes agregar otros valores también
        ]);
        $loteEnvasado->mermas = json_encode([
            'mermas' => $request->mermas,
        ]);
        //$loteEnvasado->folio_final = $request->id_solicitudActivacion;
        // Guardar el nuevo lote en la base de datos
        $loteEnvasado->save();
        return response()->json(['message' => 'Hologramas activados exitosamente']);
    }

      //Editar activos
      public function editActivados($id)
      {
          try {
              // Obtener el registro
              $activo = activarHologramasModelo::find($id);
              // Decodificar el JSON de los folios
              $folios = json_decode($activo->folios, true);
              // Añadir los valores de folio inicial y folio final
              $activo->folio_inicial = $folios['folio_inicial'] ?? null;
              $activo->folio_final = $folios['folio_final'] ?? null;
              $mermas = json_decode($activo->mermas, true);
              $activo->mermas = $mermas['mermas'] ?? null;

              return response()->json($activo); // Devolver el registro con los datos decodificados
          } catch (\Exception $e) {
              return response()->json(['error' => 'Error al obtener los hologramas activos'], 500);
          }
      }

          //Actualizar activos
    public function updateActivados(Request $request)
    {
        // Buscar el registro existente usando el ID
        try {
            $loteEnvasado = activarHologramasModelo::findOrFail($request->input('id'));
            $loteEnvasado->folio_activacion = $request->edit_folio_activacion;
            $loteEnvasado->id_solicitud = $request->edit_id_solicitudActivacion;
            $loteEnvasado->id_inspeccion = $request->edit_id_inspeccion;
            $loteEnvasado->no_lote_agranel = $request->edit_no_lote_agranel;
            $loteEnvasado->certificado_granel = $request->edit_certificado_granel;
            $loteEnvasado->edad = $request->edit_edad;
            $loteEnvasado->categoria = $request->edit_categoria;
            $loteEnvasado->no_analisis = $request->edit_no_analisis;
            $loteEnvasado->cont_neto = $request->edit_cont_neto;
            $loteEnvasado->unidad = $request->edit_unidad;
            $loteEnvasado->clase = $request->edit_clase;
            $loteEnvasado->contenido = $request->edit_contenido;
            $loteEnvasado->no_lote_envasado = $request->edit_no_lote_envasado;
            $loteEnvasado->id_tipo = $request->edit_id_tipo;
            $loteEnvasado->lugar_produccion = $request->edit_lugar_produccion;
            $loteEnvasado->lugar_envasado = $request->edit_lugar_envasado;
            // Actualizar los rangos de folios
            $loteEnvasado->folios = json_encode([
                'folio_inicial' => $request->edit_rango_inicial,
                'folio_final' => $request->edit_rango_final, // Puedes agregar otros valores también
            ]);
            $loteEnvasado->mermas = json_encode([
                'mermas' => $request->edit_mermas,
            ]);
            // Guardar los cambios en la base de datos
            $loteEnvasado->save();

            return response()->json(['success' => 'Hologramas activos actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar los hologramas activossiiiiii'], 500);
        }
    }

}
