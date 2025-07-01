<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dictamen_Envasado;
use App\Models\Dictamen_instalaciones;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;
use App\Models\lotes_envasado;
use App\Models\lotes_envasado_granel;
use App\Models\LotesGranel;
use App\Models\marcas;

class insertar_datos_bd_lotes_envasado extends Controller
{
    public function insertarLotesEnvasadoDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerLotesEnvasado.php';

        // Realiza la solicitud GET a la API
        $response = Http::get($url);

        // Verifica si la solicitud fue exitosa
        if ($response->successful()) {
            // Decodifica los datos JSON
            $data = $response->json();

            // Verifica si existen los datos en la respuesta
            if (isset($data['datos'])) {
                $solicitudes = $data['datos'];

                // Recorre cada solicitud y crea un registro en la base de datos
                foreach ($solicitudes as $solicitud) {
                    /* if($solicitud['id_cliente']==11 OR $solicitud['id_cliente']==32){
                       
                    }*/

                    $firma = $solicitud['firma'];

                    if ($firma === "../img/Firma Inspector Erik.png") {
                        echo $id_firmante = 9;
                    } 
                    elseif ($firma === "../img/firma_firma karen.png") {
                        echo $id_firmante = 6;
                    }elseif (in_array($firma, ["../img/firma_mario.png", "../img/firma_mayra.png"])) {
                        echo $id_firmante = 14;
                    } else {
                        echo $id_firmante = 14;
                    }

                   
                    $id_empresa = empresaNumCliente::where('numero_cliente', trim($solicitud['folio']))->value('id_empresa');
                    $id_marca = marcas::where('marca', trim($solicitud['marca']))->value('id_marca');
                    $id_lote_granel = LotesGranel::where('nombre_lote', trim($solicitud['granel']))->value('id_lote_granel');

                    if ($id_empresa) {

                       
                        

                        //if ($solicitud['n_servicio'] ==$inspecciones->n) {
                            $id_envasado = lotes_envasado::create([
                                'id_empresa'   => $id_empresa,
                                'nombre'  => $solicitud['n_lote_envasado'],
                                'sku'    => json_encode(['inicial' => $solicitud['sku_dictamen'] ?? $solicitud['no_pedido'],]),
                                'id_marca'   => $id_marca ?? 0,
                                'destino_lote'  => 1,
                                'cant_botellas'        => $solicitud['n_botellas'],
                                'cant_bot_restantes'        => $solicitud['n_botellas'],
                                'presentacion'        => $solicitud['presentacion_e'],
                                'unidad'        => $solicitud['unidad'],
                                'volumen_total'        => $solicitud['volumen'],
                                'volumen_restante'        => $solicitud['volumen'],
                                'lugar_envasado'        => 0,
                                'tipo'        => 'Con etiqueta'
                                
                            ]);
                            if($id_lote_granel){
                                lotes_envasado_granel::create([
                                    'id_lote_envasado'   => $id_envasado->id_lote_envasado,
                                    'id_lote_granel'  => $id_lote_granel,
                                    'volumen_parcial'    => $solicitud['volumen'],
                                ]);
                            }

                            if (!empty($solicitud['n_servicio'])) {
                                $inspecciones = inspecciones::where('num_servicio', $solicitud['n_servicio'])->first();
                                
                            } else {
                                $inspecciones = null; // O maneja este caso según corresponda
                            }

                            if($inspecciones){
                                Dictamen_Envasado::create([
                                    'id_lote_envasado'   => $id_envasado->id_lote_envasado,
                                    'num_dictamen'   => $solicitud['n_dictamen'],
                                    'id_inspeccion'  => $inspecciones->id_inspeccion,
                                    'fecha_emision'    => $solicitud['fecha_emision'],
                                    'fecha_vigencia'    => $solicitud['fecha_vigencia'],
                                    'id_firmante' => $id_firmante,
                                    'estatus' => 0
                                ]);
                            }

                         /*   if($id_lote_granel){
                                lotes_envasado_granel::update([
                                    'id_lote_envasado'   => $id_envasado->id_lote_envasado,
                                    'id_lote_granel'  => $id_lote_granel,
                                    'volumen_parcial'    => $solicitud['volumen'],
                                ]);
                            }*/
                            
                            
                           
                        //}
                    }
                }

                return response()->json(['message' => 'Solicitudes insertadas correctamente']);
            } else {
                return response()->json(['message' => 'No se encontraron datos en la API'], 404);
            }
        } else {
            return response()->json(['message' => 'Error al conectar con la API'], 500);
        }
    }
}
