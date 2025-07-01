<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use App\Models\Documentacion_url;
use App\Models\empresa;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;
use Illuminate\Support\Facades\Log;

class insertar_datos_bd_actas extends Controller
{
    public function insertarActasDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerActas.php';

        // Realiza la solicitud GET a la API
        $response = Http::get($url);

        // Verifica si la solicitud fue exitosa
        if ($response->successful()) {
            // Decodifica los datos JSON
            $data = $response->json();

            // Verifica si existen los datos en la respuesta
            if (isset($data['datos'])) {
                $solicitudes = $data['datos'];

                foreach ($solicitudes as $solicitud) {
                    if (!empty($solicitud['folio'])) {
                        $sol = solicitudesModel::with("empresa")->where('folio', $solicitud['folio'])->first();
                    } else {
                        $sol = null;
                    }
                
                    if ($sol) {
                        // Crear instancia de Documentacion_url
                        $documentacion_url = new Documentacion_url();
                        $documentacion_url->id_relacion = $sol->id_solicitud;
                        $documentacion_url->id_documento = 69;
                        $documentacion_url->id_empresa = $sol->id_empresa;
                
                        // Obtener URL remota
                        $fileUrl = "https://oc.erpcidam.com/apps/solicitudes/pdfs/" . $solicitud['url']; // Construye la URL completa
                        
                        // Obtener solo el nombre del archivo
                        $fileName = basename($fileUrl);
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // "pdf"
                        $nombreArchivo = str_replace('/', '-','Acta de inspección '.$sol->inspeccion?->num_servicio) . '_' . time() . '.' . $fileExtension;

                        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $sol->id_empresa)->first();
                        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                            return !empty($numero);
                        });
                
                        // Definir la carpeta de almacenamiento
                        $storagePath = "uploads/{$numeroCliente}/actas";
                
                        // Ruta final en storage/app/public/
                        $destinationPath = storage_path("app/public/{$storagePath}/{$nombreArchivo}");
                
                        // Crear la carpeta si no existe
                        if (!file_exists(storage_path("app/public/{$storagePath}"))) {
                            mkdir(storage_path("app/public/{$storagePath}"), 0777, true);
                        }
                
                        // Descargar el archivo desde la URL y guardarlo en el servidor
                        $fileContent = file_get_contents($fileUrl);
                        if ($fileContent !== false) {
                            file_put_contents($destinationPath, $fileContent);
                
                            // Guardar la ruta en la base de datos
                            $documentacion_url->nombre_documento = 'Acta de inspección '.$sol->inspeccion?->num_servicio;
                            $documentacion_url->url =  $nombreArchivo;
                            $documentacion_url->fecha_vigencia = null;
                            $documentacion_url->save();
                        } else {
                            Log::error("No se pudo descargar el archivo desde: {$fileUrl}");
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
