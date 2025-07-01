<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Revisor extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'certificados_revision';
    protected $primaryKey = 'id_revision';

    protected $fillable = [
        'tipo_revision',
        'id_revisor',
        'id_revisor2',
        'id_certificado',
        'numero_revision',
        'es_correccion',
        'observaciones',
        'respuestas',
        'decision',
        'id_aprobador',
        'aprobacion',
        'fecha_aprobacion',
        'tipo_certificado'
    ];

    public function getLogName2(): string
    {
        return 'Revisor'; // Devuelve el nombre que desees
    }

    public function certificadoNormal()
    {
        return $this->belongsTo(Certificados::class, 'id_certificado', 'id_certificado');
    }

    public function certificadoGranel()
    {
        return $this->belongsTo(CertificadosGranel::class, 'id_certificado', 'id_certificado');
    }

    public function certificadoExportacion()
    {
        return $this->belongsTo(Certificado_Exportacion::class, 'id_certificado', 'id_certificado');
    }

    public function getCertificadoAttribute()
    {
        switch ($this->tipo_certificado) {
            case 1:
                return $this->certificadoNormal;
            case 2:
                return $this->certificadoGranel;
            case 3:
                return $this->certificadoExportacion;
            default:
                return null;
        }
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'id_revisor', 'id'); // id_revisor es la clave foránea en la tabla revisores
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'id_aprobador');
    }

    public function obtenerDocumentosClientes($id_documento, $id_cliente)
    {
        $documento = Documentacion_url::where("id_documento", "=", $id_documento)
            ->where("id_empresa", "=", $id_cliente)
            ->first(); // Devuelve el primer registro que coincida

        return $documento ? $documento->url : null; // Devuelve solo el atributo `url` o `null` si no hay documento
    }

    public function obtenerDocumentoActa($id_documento, $id_solicitud)
    {
        $documento = Documentacion_url::where("id_documento", "=", $id_documento)
            ->where("id_relacion", "=", $id_solicitud)
            ->first(); // Devuelve el primer registro que coincida

        return $documento ? $documento->url : null; // Devuelve solo el atributo `url` o `null` si no hay documento
    }

     public function evidencias()
    {
        return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_revision')->where('id_documento',133);
    }
    public function certificado()
    {
        // Por defecto busca en certificadoNormal (ajusta si quieres otro comportamiento)
        return $this->belongsTo(Certificados::class, 'id_certificado', 'id_certificado');
    }
}
