<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\empresaNumCliente;
use App\Models\predio_plantacion;
use App\Models\PredioCoordenadas;
use App\Models\Predios;
use App\Models\Predios_Inspeccion;
use App\Models\PrediosCaracteristicasMaguey;
use App\Models\solicitudesModel;
use App\Models\tipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class insertar_datos_bd_predios extends Controller
{
    public function insertarPrediosDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerPredios.php';

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
                    $id_empresa = empresaNumCliente::where('numero_cliente', trim($solicitud['folio']))->value('id_empresa');

                    if($id_empresa){
                    // Crear el registro del predio
                    $idPredio = Predios::create([
                        'id_empresa'             =>  $id_empresa,
                        'nombre_productor'       => 'Sin definir',
                        'num_predio'             => 'Sin asignar',
                        'nombre_predio'          => $solicitud['nombre_predio'],
                        'ubicacion_predio'       => $solicitud['municipio'] . ', ' . $solicitud['estado'],
                        'tipo_predio'            => $solicitud['tipo_predio'],
                        'puntos_referencia'      => $solicitud['puntos_referencia'],
                        'cuenta_con_coordenadas' => 'No',
                        'superficie'             => $solicitud['superficie'],
                        'estatus'                => 'Pendiente',
                    ]);
                
                    // Dividir las plantaciones por comas
                    $plantaciones = explode(',', $solicitud['maguey_caracteristicas']);
                    
                    foreach ($plantaciones as $plantacion) {
                        $datosPlantacion = explode('|', $plantacion);
                        if (count($datosPlantacion) === 4) {
                        // Dividir los datos de cada plantación por el carácter '|'
                        list($nombre_maguey, $num_plantas, $tipo_plantacion, $edad) = $datosPlantacion;

                        $idTipo = tipos::where('nombre', trim($nombre_maguey))->value('id_tipo');
                
                        // Crear el registro de la plantación
                        predio_plantacion::create([
                            'id_predio'       => $idPredio->id_predio, // Usar el ID generado para el predio
                            'id_tipo'         => $idTipo ?? 0,  
                            'num_plantas'     => $num_plantas,
                            'anio_plantacion' => $edad, // Ajustar si tienes el año en algún campo adicional
                            'tipo_plantacion' => ($tipo_plantacion === 'COMERCIAL') ? 'Cultivado' : $tipo_plantacion,
                        ]);

                        
                    }
                    }

                     // Dividir las coordenadas por comas
                     $coordenadas = explode(',', $solicitud['coordenadas']);

                    if($solicitud['fecha']){

                    // Crear el registro de inspección de predio
                    $idInspeccion = Predios_Inspeccion::create([
                        'id_predio'       => $idPredio->id_predio, // Usar el ID generado para el predio
                        'ubicacion_predio'       => $solicitud['municipio'] . ', ' . $solicitud['estado'],
                        'localidad'       => $solicitud['localidad'],
                        'municipio'       => $solicitud['municipio'],
                        'distrito'       => $solicitud['municipio'],
                        'nombre_paraje'       => $solicitud['nombre_paraje'],
                        'zona_dom'       => $solicitud['predio_zona'],
                        'superficie'       => $solicitud['superficie'],
                        'fecha_inspeccion'       => $solicitud['fecha'],
                    ]);

                    // Crear el registro de inspección de predio
                    PrediosCaracteristicasMaguey::create([
                        'id_predio'       => $idPredio->id_predio, 
                        'id_inspeccion'       => $idInspeccion->id_inspeccion, 
                      
                    ]);

                    $idPredio->num_predio = $solicitud['numero_predio'] ?? "";
                    $idPredio->fecha_emision = $solicitud['fecha_emision'] ?? "";
                    $idPredio->fecha_vigencia = $solicitud['vigencia'] ?? "";
                    $idPredio->estatus = $solicitud['numero_predio'] ? 'Vigente' : 'Inspeccionado';
                    $idPredio->cuenta_con_coordenadas = $coordenadas  ? 'Si' : 'No';

                    $idPredio->save();

                }

                        
                    
                         foreach ($coordenadas as $coordenada) {
                             $datosCoordenadas = explode('|', $coordenada);
                             if (count($datosCoordenadas) === 2) {
                             // Dividir los datos de cada plantación por el carácter '|'
                             list($latitud, $longitud) = $datosCoordenadas;
     
               
                     
                             // Crear el registro de la plantación
                             PredioCoordenadas::create([
                                 'id_predio'       => $idPredio->id_predio, // Usar el ID generado para el predio
                                 'latitud'         => $latitud,  
                                 'longitud'     => $longitud,
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
