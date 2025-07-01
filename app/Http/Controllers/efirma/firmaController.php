<?php

namespace App\Http\Controllers\efirma;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpCfdi\Credentials\Credential;

use Illuminate\Support\Facades\Storage;

class firmaController extends Controller
{
    public function firmarCadena(Request $request)
    {
        try {
            // Obtener el ID del usuario autenticado
            $userId = 9;

            // Rutas de los archivos en storage
            $cerPath = storage_path("app/public/firmas/efirma/{$userId}.cer");
            $keyPath = storage_path("app/public/firmas/efirma/{$userId}.key");

            // Verificar que los archivos existen
            if (!file_exists($cerPath) || !file_exists($keyPath)) {
                return response()->json(['error' => 'No se encontraron los archivos de la firma'], 404);
            }

            // Obtener la contraseña y la cadena original
            $password = 'Mejia2307'; //$request->input('password');
            $cadenaOriginal = 'prueba jeje'; //$request->input('cadena_original');

            // Crear la credencial con los archivos
            $credential = Credential::openFiles($cerPath, $keyPath, $password);

            // Firmar la cadena
            $firma = base64_encode($credential->sign($cadenaOriginal));

            return response()->json([
                'cadena_original' => $cadenaOriginal,
                'firma' => $firma,
                'rfc' => $credential->certificate()->rfc(),
                'nombre' => $credential->certificate()->legalName(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo firmar la cadena: ' . $e->getMessage(),
            ], 500);
        }
    }
}
