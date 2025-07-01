<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;

class insertar_datos_bd extends Controller
{
    public function insertarSolicitudesDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerSolicitudes.php';

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

                    $id_empresa = empresaNumCliente::where('numero_cliente', trim($solicitud['num_cliente']))->value('id_empresa');
                    if ($id_empresa) {



                        if ($solicitud['id_subtipo'] == 23) {
                            $solicitud['id_subtipo'] = 7;
                        }
                        if ($solicitud['id_subtipo'] == 24) {
                            $solicitud['id_subtipo'] = 8;
                        }
                        if ($solicitud['id_subtipo'] == 27) {
                            $solicitud['id_subtipo'] = 9;
                        }
                        if ($solicitud['id_subtipo'] == 38) {
                            $solicitud['id_subtipo'] = 10;
                        }
                        if ($solicitud['id_subtipo'] == 43) {
                            $solicitud['id_subtipo'] = 11;
                        }
                        if ($solicitud['id_subtipo'] == 40) {
                            $solicitud['id_subtipo'] = 14;
                        }

                        if ($solicitud['id_subtipo'] == 42) {
                            $solicitud['id_subtipo'] = 15;
                        }

                        if ($solicitud['id_inspector'] == 137) {
                            $solicitud['id_inspector'] = 9; //Erik
                        }
                        if ($solicitud['id_inspector'] == 286 || $solicitud['id_inspector'] == 380) {
                            $solicitud['id_inspector'] = 6; //karen
                        }
                      
                        if ($solicitud['id_inspector'] == 649) {
                            $solicitud['id_inspector'] = 10; //Ray
                        }
                        if ($solicitud['id_inspector'] == 35 || $solicitud['id_inspector'] == 138) {
                            $solicitud['id_inspector'] = 11; //Guadalupe
                        }

                        if ($solicitud['id_inspector'] == 283) {
                            $solicitud['id_inspector'] = 12; //Amayrany
                        }

                        if ($solicitud['id_inspector'] == 123) {
                            $solicitud['id_inspector'] = 13; //Daniela jarquin
                        }

                        if ($solicitud['id_inspector'] == 100) {
                            $solicitud['id_inspector'] = 14; //Mario
                        }

                        if ($solicitud['id_inspector'] == 637) {
                            $solicitud['id_inspector'] = 15; //Idalia
                        }

                        if ($solicitud['id_inspector'] == 638) {
                            $solicitud['id_inspector'] = 16; //Alma delia
                        }

                        if ($solicitud['id_inspector'] == 639) {
                            $solicitud['id_inspector'] = 17; //Johan
                        }

                        if ($solicitud['id_inspector'] == 640) {
                            $solicitud['id_inspector'] = 18; //Luis angel
                        }

                        if ($solicitud['id_inspector'] == 80) {
                            $solicitud['id_inspector'] = 19; //Raúl
                        }

                       /* if ($solicitud['id_inspector'] == 9 ) {
                            $solicitud['id_inspector'] = 20; //Lidia
                        }*/

                        if ($solicitud['id_inspector'] == 261 ) {
                            $solicitud['id_inspector'] = 21; //Sandy
                        }

                        if ($solicitud['id_inspector'] == 249 ) {
                            $solicitud['id_inspector'] = 22; //nyx
                        }

                        if ($solicitud['id_inspector'] == 449 ) {
                            $solicitud['id_inspector'] = 23; //Salvador
                        }


                        if ($solicitud['id_inspector'] == '' || $solicitud['id_inspector'] == 0) {
                            $solicitud['id_inspector'] = 0; //Administrador
                        }

                        if ($solicitud['id_subtipo'] != 30) {
                            $id_solicitud = solicitudesModel::create([
                                'id_empresa'             => $id_empresa,
                                'folio'             => $solicitud['folio'],
                                'fecha_solicitud'   => $solicitud['fecha_solicitud'],
                                'fecha_visita'   => $solicitud['fecha_visita'] . ' ' . $solicitud['hora_visita'],
                                'id_tipo'             => $solicitud['id_subtipo'],
                            ]);
                            if($solicitud['num_servicio'] !=''){
                                inspecciones::create([
                                    'id_solicitud'         => $id_solicitud->id_solicitud,
                                    'id_inspector'             => $solicitud['id_inspector'],
                                    'num_servicio'   => $solicitud['num_servicio'] ?? "Sin asignar",
                                    'fecha_servicio'   => $solicitud['fecha_inspeccion'] . ' ' . $solicitud['hora_inspeccion'],
                                    'estatus_inspeccion'             => $solicitud['estatus_inspeccion'] ?? 1,
                                ]);
                            }
                        }
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
