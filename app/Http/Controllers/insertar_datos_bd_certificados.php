<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;

class insertar_datos_bd_certificados extends Controller
{
    public function insertarCertificadosDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerCertificadosInstalaciones.php';

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
                   
                    if (!empty($solicitud['n_dictamen'])) {
                        $dictamenes = Dictamen_instalaciones::where('num_dictamen', $solicitud['n_dictamen'])->first();
                        
                    } else {
                        $dictamenes = null; // O maneja este caso según corresponda
                    }
                    

                    if ($dictamenes) {



                        //if ($solicitud['n_servicio'] ==$inspecciones->n) {
                            $id_solicitud = Certificados::create([
                                'id_dictamen'             => $dictamenes->id_dictamen,
                                'num_certificado'             => $solicitud['n_certificado'],
                                'fecha_emision'   => $solicitud['fecha_expedicion'],
                                'fecha_vigencia'   => $solicitud['fecha_vigencia'],
                                'id_firmante' => 3,
                               'maestro_mezcalero' => $solicitud['maestro_mezcalero'] == 0 ? '' : $solicitud['maestro_mezcalero'],
                               'num_autorizacion' => $solicitud['n_autorizacion'] == 0 ? '' : $solicitud['n_autorizacion'],
                            ]);
                           
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
