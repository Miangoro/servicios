<?php

namespace App\Mail;

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoCertificado extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject($this->details['asunto']) 
                    ->view('emails.CorreoCertificados')
                    ->with([
                        'nombreRevisor' => $this->details['nombreRevisor'], 
                        'num_certificado' => $this->details['num_certificado'], 
                        'fecha_emision' => $this->details['fecha_emision'], 
                        'fecha_vigencia' => $this->details['fecha_vigencia'],
                        'razon_social' => $this->details['razon_social'], 
                        'numero_cliente' => $this->details['numero_cliente'], 
                        'tipo_certificado' => $this->details['tipo_certificado'], 
                        'observaciones' => $this->details['observaciones'], 
                        'url' => $this->details['url'], 
                    ]);
    }    
}
