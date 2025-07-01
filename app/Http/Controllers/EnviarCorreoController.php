<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CorreoEjemplo;
use Illuminate\Support\Facades\Mail;

class EnviarCorreoController extends Controller
{
    public function enviarCorreo()
    {
        $details = [
            'title' => 'Correo de Prueba',
            'body' => 'Este es un correo de prueba enviado desde Laravel.'
        ];

        // Destinatario a quien se enviará el correo
        Mail::to('mromero@cidam.org')->send(new CorreoEjemplo($details));


        return 'Correo enviado';
    }
}
