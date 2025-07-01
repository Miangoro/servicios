<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificados;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Granel;
use App\Models\Dictamen_instalaciones;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;
use App\Models\LotesGranel;

class insertar_datos_bd_certificados_granel extends Controller
{
    public function insertarCertificadosGranelDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerCertificadosGranel.php';

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
                        $dictamenes = Dictamen_Granel::where('num_dictamen', $solicitud['n_dictamen'])->first();
                        $id_lote = LotesGranel::where('nombre_lote', $solicitud['n_lote'])->first();
                         $id_lote->id_lote_granel ?? '0';
                        
                    } else {
                        $dictamenes = null; // O maneja este caso según corresponda
                    }
                    

                    if ($dictamenes) {
                        
                        echo $solicitud['n_certificado'].'<br>';

                        //if ($solicitud['n_servicio'] ==$inspecciones->n) {
                            $id_solicitud = CertificadosGranel::create([
                                'id_dictamen'             => $dictamenes->id_dictamen,
                                'num_certificado'             => $solicitud['n_certificado'],
                                'fecha_emision'   => $solicitud['fecha_expedicion'],
                                'fecha_vigencia'   => $solicitud['fecha_vigencia'],
                                'id_firmante' => ($solicitud['firma_oc'] ?? 0) != 0 ? $solicitud['firma_oc'] : 3,
                                'id_lote_granel'   => $id_lote->id_lote_granel ?? 0,
                            ]);

                                $id_lote_granel = $id_lote->id_lote_granel ?? 0;
                                    $lote = LotesGranel::find($id_lote_granel);

                                    if ($lote) {
                                        $lote->folio_certificado = $solicitud['n_certificado'] ?? '';
                                        $lote->fecha_emision = $solicitud['fecha_expedicion'] ?? '';
                                        $lote->fecha_vigencia = $solicitud['fecha_vigencia'] ?? '';
                                        $lote->update();
                                    } 
                           
                        //}
                    }
                }

                return response()->json(['message' => 'Solicitudes insertadas correctamente sss']);
            } else {
                return response()->json(['message' => 'No se encontraron datos en la API'], 404);
            }
        } else {
            return response()->json(['message' => 'Error al conectar con la API'], 500);
        }
    }
}
