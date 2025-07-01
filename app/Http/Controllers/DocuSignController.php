<?php

namespace App\Http\Controllers;

use App\Http\Controllers\certificados\Certificado_ExportacionController;
use App\Http\Controllers\Controller;
use App\Models\Certificado_Exportacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DocuSign\Services\SignatureClientService;
use DocuSign\Services\Examples\eSignature\SigningViaEmailService;


use DocuSign\eSign\Model\EnvelopeDefinition;
use DocuSign\eSign\Model\Document;
use DocuSign\eSign\Model\Signer;
use DocuSign\eSign\Model\SignHere;
use DocuSign\eSign\Model\Tabs;
use DocuSign\eSign\Api\EnvelopesApi;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use DocuSign\eSign\Client\ApiClient;


use DocuSign\eSign\Model\Recipients;
use DocuSign\eSign\Model\RecipientViewRequest;
use Illuminate\Support\Facades\Log;

class DocuSignController extends Controller
{   

    public function add_firmar_docusign(){

        $certificados = Certificado_Exportacion::All();
        return view('certificados.firmar_docusign', compact('certificados'));
    }

    public function authenticate()
    {
        $config = config('docusign');

        $clientId = $config['client_id'];
        $redirectUri = $config['redirect_uri'];
        $oauthBasePath = 'https://account-d.docusign.com'; // Sandbox
        $responseType = 'code';
        $scope = 'signature';

        $authorizationUrl = $oauthBasePath . "/oauth/auth?" . http_build_query([
            'response_type' => $responseType,
            'scope' => $scope,
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
        ]);

        return redirect($authorizationUrl);
    }

    public function callback(Request $request)
{
    $code = $request->query('code');
    $config = config('docusign');

    $apiClient = new ApiClient();
    $apiClient->getOAuth()->setOAuthBasePath("account-d.docusign.com");

    try {
        $token = $apiClient->generateAccessToken(
            $config['client_id'],
            $config['client_secret'],
            $code
        );

        Session::put('docusign_access_token', $token['access_token']);
        Session::put('docusign_token_expiry', time() + $token['expires_in']);

        return redirect()->route('home')->with('success', '¡Autenticado con DocuSign!');
    } catch (\Exception $e) {
        return redirect()->route('home')->with('error', 'Error obteniendo token: ' . $e->getMessage());
    }
}

    public function sendDocument(Request $request)
    {
        // Recuperar el token de la sesión
        $token = Session::get('docusign_access_token');
        $tokenExpiry = Session::get('docusign_token_expiry');
        
        
    
        if (!$token || time() > $tokenExpiry) {
            // Si no hay token o ha expirado, genera uno nuevo
            $token = $this->obtenerTokenDocuSign();
            if (strpos($token, 'Error:') !== false) {
                return response()->json(['error' => 'Error obteniendo token de acceso.'.$token], 401);
            }
    
            // Guardar token y tiempo de expiración en la sesión
            $expiryTime = time() + 3600; // 1 hora
            Session::put('docusign_access_token', $token);
            Session::put('docusign_token_expiry', $expiryTime);
        } 
    
        // Crea el cliente de API de DocuSign utilizando el token
        $apiClient = new ApiClient();
        $apiClient->getConfig()
            ->setHost("https://demo.docusign.net/restapi") // Usa "demo" o "www" dependiendo del entorno
            ->addDefaultHeader("Authorization", "Bearer " . $token);
        
        // Inicializa la clase EnvelopesApi
        $envelopeApi = new EnvelopesApi($apiClient);
    
        // Configura el documento
        $pathToFile = storage_path('app/public/Pre-certificado_CIDAM_C-EXP25-171.pdf');
        $document = new Document([
            'document_base64' => base64_encode(file_get_contents($pathToFile)),
            'name' => 'Pre-certificado CIDAM',
            'file_extension' => 'pdf',
            'document_id' => '2',
        ]);
    
        // Configura el firmante
        $signer = new Signer([
            'email' => $request->input('email', 'imendoza@erpcidam.com'), // Email del firmante
            'name' => $request->input('name', 'María Inés Mendoza Cisneros'), // Nombre del firmante
            'recipient_id' => '1', // Asegúrate de que sea único
        ]);
    
        // Lugar donde debe firmar el usuario
        $signHere = new SignHere([
            'anchor_string' => 'Signature',
            'anchor_units' => 'pixels',
            'anchor_x_offset' => '200',
            'anchor_y_offset' => '150',
        ]);
    
        // Asocia la posición de la firma al firmante
        $signer->setTabs(new Tabs(['sign_here_tabs' => [$signHere]]));
    
        // Configura el sobre (envelope)
        $envelopeDefinition = new EnvelopeDefinition([
            'email_subject' => 'Por favor, firme este documento',
            'documents' => [$document],
            'recipients' => ['signers' => [$signer]],
            'status' => 'sent', // Enviar inmediatamente
        ]);
    
        // Envía el sobre para firma
        try {
          
            // Reemplaza 'account_id' con tu ID de cuenta de DocuSign
            $envelopeSummary = $envelopeApi->createEnvelope('29412951', $envelopeDefinition);
          
            return response()->json($envelopeSummary);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    


    public function open($target)
    {
        switch (PHP_OS) {
            case 'Darwin':
                $opener = 'open';
                break;
            case 'WINNT':
                $opener = 'start ""';
                break;
            default:
                $opener = 'xdg-open';
        }

        return exec(sprintf('%s %s', $opener, escapeshellcmd($target)));
    }

    public function obtenerTokenDocuSign()
    {
        // Configuraciones de DocuSign desde el .env
        $clientId = env('DOCUSIGN_CLIENT_ID');
        $userId = env('DOCUSIGN_USER_ID');
        $privateKey = file_get_contents(env('DOCUSIGN_PRIVATE_KEY'));
        $authServer = env('DOCUSIGN_AUTH_SERVER') . '/oauth/token';
        $scopes = "signature impersonation";

        // Crear el JWT
        $now = Carbon::now()->timestamp;
        $exp = Carbon::now()->addMinutes(60)->timestamp; // Puede ajustar a 60 para una hora
        $payload = [
            'iss' => $clientId,
            'sub' => $userId,
            'aud' => 'account-d.docusign.com', // Cambiado aquí
            'iat' => $now,
            'exp' => $exp,
            'scope' => 'signature impersonation account envelopes documents'
        ];

        $jwt = JWT::encode($payload, $privateKey, 'RS256');

        // Hacer la solicitud HTTP para obtener el token
        $client = new Client();
        try {
            $response = $client->post($authServer, [
                'form_params' => [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion' => $jwt
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $token = $data['access_token'];
            Session::put('docusign_access_token', $token); // Almacena el token en la sesión

            //return $data;

        } catch (\Exception $e) {
            if (strpos($e->getMessage(), "consent_required") !== false) {
                $authorizationURL = 'https://account-d.docusign.com/oauth/auth?' . http_build_query([
                    'scope'         => $scopes,
                    'redirect_uri'  => "http://localhost:8000/test-docusign",
                    'client_id'     => $clientId,
                    'response_type' => 'code'
                ]);

                echo "It appears that you are using this integration key for the first time. Opening the following link in a browser window:\n";
                echo $authorizationURL . "\n\n";
                $this->open($authorizationURL);
                exit;
            }

            // Manejo de errores más específico
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            return 'Error: ' . $errorResponse['error'];
        }

        $authorizationURL = 'https://account-d.docusign.com/oauth/auth?' . http_build_query([
            'scope'         => $scopes,
            'redirect_uri'  => "http://localhost:8000/test-docusign",
            'client_id'     => $clientId,
            'response_type' => 'code'
        ]);

        echo "It appears that you are using this integration key for the first time. Opening the following link in a browser window:\n";
        echo $authorizationURL . "\n\n";





        /*  $apiClient = new ApiClient();
        $apiClient->getOAuth()->setOAuthBasePath("account-d.docusign.com");
        $response = $apiClient->requestJWTUserToken($clientId, $userId, $privateKey, $scopes, 60);

        if (isset($response)) {
            $access_token = $response[0]['access_token'];
            // retrieve our API account Id
            $info = $apiClient->getUserInfo($access_token);
            $account_id = $info[0]["accounts"][0]["account_id"];
            $args['base_path'] = "https://demo.docusign.net/restapi";
             $args['account_id'] = $account_id;
            $args['ds_access_token'] = $access_token;
        
        
        
          
            try {
               
        
                echo "Successfully sent envelope with envelope ID: " . $result['envelope_id'] . "\n";
            } catch (\Throwable $th) {
                var_dump($th);
                exit;
            }
        }
*/
    }

    public function sendDocument2(Request $request)
    {   
        $token = Session::get('docusign_access_token');
        //dd($token);
        $tokenExpiry = Session::get('docusign_token_expiry');
    
        if (!$token || time() > $tokenExpiry) {
            $token = $this->obtenerTokenDocuSign();
            if (strpos($token, 'Error:') !== false) {
                return response()->json(['error' => 'Error obteniendo token: ' . $token], 401);
            }
    
            Session::put('docusign_access_token', $token);
            Session::put('docusign_token_expiry', time() + 3600);
        }
    
        $apiClient = new ApiClient();
        $apiClient->getConfig()
            ->setHost("https://demo.docusign.net/restapi")
            ->addDefaultHeader("Authorization", "Bearer " . $token);
    
        $envelopeApi = new EnvelopesApi($apiClient);
    
        // 📄 Archivos a firmar (puedes agregar más aquí)
       /* $files = [
          
            storage_path('app/public/Pre-certificado_CIDAM_C-EXP25-167.pdf'),
            storage_path('app/public/Pre-certificado_CIDAM_C-EXP25-171.pdf'), 
      
        ];

        foreach ($files as $filePath) {
            $documents[] = new Document([
                'document_base64' =>base64_encode($filePath),
                'name' => basename($filePath),
                'file_extension' => 'pdf',
                'document_id' => (string) $documentId++,
            ]);
        }*/

       
        $documents = [];
        $documentId = 1;
        
        foreach ($request->id_certificado as $id_certificado) {
            // Llamada directa al método del controlador
   
            $response = app(Certificado_ExportacionController::class)
                        ->MostrarCertificadoExportacion($id_certificado);

                      
        
            // Validación básica del tipo de respuesta
            if (!$response instanceof \Symfony\Component\HttpFoundation\Response) {
                return response()->json([
                    'error' => "No se pudo generar el PDF para el ID $id_certificado"
                ], 500);
            }
        

            // Crear documento
            $documents[] = new Document([
                'document_base64' => base64_encode($response),
                'name' => 'Certificado ' . $id_certificado,
                'file_extension' => 'pdf',
                'document_id' => (string) $documentId++,
            ]);
        }

        
    
    
        $signer = new Signer([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'recipient_id' => '1',
            'client_user_id' => '1234' // Necesario para firma embebida
        ]);
    
        // Usamos la firma anclada solo para el primer documento
        $signHere = new SignHere([
            'anchor_string' => 'Signature',
            'anchor_units' => 'pixels',
            'anchor_x_offset' => '200',
            'anchor_y_offset' => '150',
        ]);
    
        $signer->setTabs(new Tabs(['sign_here_tabs' => [$signHere]]));
    
        $envelopeDefinition = new EnvelopeDefinition([
            'email_subject' => 'Por favor, firme estos documentos',
            'documents' => $documents,
            'recipients' => new Recipients(['signers' => [$signer]]),
            'status' => 'sent',
        ]);
    
        try {
            $accountId = '29412951'; // Tu accountId de DocuSign
            $envelopeSummary = $envelopeApi->createEnvelope($accountId, $envelopeDefinition);
    
            // 🔁 Crear vista para firma embebida
            $recipientViewRequest = new RecipientViewRequest([
                'authentication_method' => 'none',
                'client_user_id' => '1234',
                'recipient_id' => '1',
                'return_url' => route('firma.completada') . '?envelopeId=' . $envelopeSummary->getEnvelopeId(),
                'user_name' => $signer->getName(),
                'email' => $signer->getEmail(),
            ]);
    
            $viewUrl = $envelopeApi->createRecipientView($accountId, $envelopeSummary->getEnvelopeId(), $recipientViewRequest);
    
            // 👇 Redirigir automáticamente a la URL de firma
            return redirect()->away($viewUrl->getUrl());
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

public function firmaCompletada(Request $request)
{
    $envelopeId = $request->query('envelopeId');
    return view('certificados/firma_completada', compact('envelopeId'));
}

public function descargarDocumento($envelopeId)
{
    $token = Session::get('docusign_access_token');

    if (!$token) {
        return response()->json(['error' => 'Token inválido o expirado.'], 401);
    }

    $apiClient = new ApiClient();
    $apiClient->getConfig()
        ->setHost("https://demo.docusign.net/restapi")
        ->addDefaultHeader("Authorization", "Bearer " . $token);

    $envelopeApi = new EnvelopesApi($apiClient);
    $accountId = '29412951';

    try {
        // Obtener el ID del documento real
        $documents = $envelopeApi->listDocuments($accountId, $envelopeId);
        $documentList = $documents->getEnvelopeDocuments();

        if (empty($documentList)) {
            return response()->json(['error' => 'No se encontraron documentos en el sobre.']);
        }

        // Obtener el primer documento
        $documentId = $documentList[0]->getDocumentId();

        // Descargar el documento firmado
        $file = $envelopeApi->getDocument($accountId, $documentId, $envelopeId);
      

        $content = file_get_contents($file->getRealPath());

return response($content, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; filename="documento.pdf"',
]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al obtener documento firmado: ' . $e->getMessage()
        ], 500);
    }
}

public function sendDocumentAuto(Request $request)
{
    $token = Session::get('docusign_access_token');
    $tokenExpiry = Session::get('docusign_token_expiry');

    if (!$token || time() > $tokenExpiry) {
        $token = $this->obtenerTokenDocuSign();
        if (strpos($token, 'Error:') !== false) {
            return response()->json(['error' => 'Error obteniendo token: ' . $token], 401);
        }

        Session::put('docusign_access_token', $token);
        Session::put('docusign_token_expiry', time() + 3600);
    }

    $apiClient = new ApiClient();
    $apiClient->getConfig()
        ->setHost("https://demo.docusign.net/restapi")
        ->addDefaultHeader("Authorization", "Bearer " . $token);

    $envelopeApi = new \DocuSign\eSign\Api\EnvelopesApi($apiClient);

    $pathToFile = storage_path('app/public/Pre-certificado_CIDAM_C-EXP25-171.pdf');
    $document = new \DocuSign\eSign\Model\Document([
        'document_base64' => base64_encode(file_get_contents($pathToFile)),
        'name' => 'Pre-certificado CIDAM',
        'file_extension' => 'pdf',
        'document_id' => '1',
    ]);

    // 🧍 Firma automática usando InPersonSigner
    $signHere = new \DocuSign\eSign\Model\SignHere([
        'anchor_string' => 'Signature',
        'anchor_units' => 'pixels',
        'anchor_x_offset' => '200',
        'anchor_y_offset' => '150',
    ]);

    $tabs = new \DocuSign\eSign\Model\Tabs([
        'sign_here_tabs' => [$signHere]
    ]);

    $inPersonSigner = new \DocuSign\eSign\Model\InPersonSigner([
        'host_name' => 'Sistema CIDAM',
        'host_email' => 'imendoza@erpcidam.com',
        'signer_name' => $request->input('name', 'María Inés Mendoza'),
        'signer_email' => $request->input('email', 'imendoza@erpcidam.com'),
        'recipient_id' => '1',
        'routing_order' => '1',
        'tabs' => $tabs
    ]);

    $recipients = new \DocuSign\eSign\Model\Recipients([
        'in_person_signers' => [$inPersonSigner]
    ]);

    $envelopeDefinition = new \DocuSign\eSign\Model\EnvelopeDefinition([
        'email_subject' => 'Firma automática',
        'documents' => [$document],
        'recipients' => $recipients,
        'status' => 'sent'
    ]);

    try {
        $accountId = '29412951'; // Reemplaza con tu real si cambia
        $envelopeSummary = $envelopeApi->createEnvelope($accountId, $envelopeDefinition);
        $envelopeId = $envelopeSummary->getEnvelopeId();

        // ⏳ Esperar que el documento esté firmado
        $maxAttempts = 10;
        $delaySeconds = 5;

        for ($i = 0; $i < $maxAttempts; $i++) {
            $envelope = $envelopeApi->getEnvelope($accountId, $envelopeId);

            if ($envelope->getStatus() === 'completed') {
                break;
            }

            sleep($delaySeconds);
        }

        if ($envelope->getStatus() !== 'completed') {
            return response()->json(['error' => 'El documento no fue firmado automáticamente.'], 408);
        }

        // 📄 Obtener el documento firmado
        $documentId = '1';
        $pdfContents = $envelopeApi->getDocument($accountId, $documentId, $envelopeId);

        $content = file_get_contents($pdfContents->getRealPath());

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="documento_firmado.pdf"',
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}







public function estadoSobre($envelopeId)
{
    $token = Session::get('docusign_access_token');

    $apiClient = new ApiClient();
    $apiClient->getConfig()
        ->setHost("https://demo.docusign.net/restapi")
        ->addDefaultHeader("Authorization", "Bearer " . $token);

    $envelopeApi = new EnvelopesApi($apiClient);
    $accountId = '29412951';

    try {
        $envelope = $envelopeApi->getEnvelope($accountId, $envelopeId);
        return response()->json([
            'status' => $envelope->getStatus()
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
