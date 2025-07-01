<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificados extends Model
{
    use HasFactory;
    protected $table = 'certificados';
    protected $primaryKey = 'id_certificado';

    protected $fillable = [
        'id_dictamen',
        'id_firmante',
        'id_empresa',
        'num_certificado',
        'fecha_emision',
        'fecha_vigencia',
        'maestro_mezcalero',
        'num_autorizacion',
        'estatus',
        'observaciones'
    ];

    // Relación con el modelo Dictamen_instalaciones
    public function dictamen()
    {
        return $this->belongsTo(Dictamen_instalaciones::class, 'id_dictamen', 'id_dictamen');
    }

    // Relación con el modelo User (Firmante)
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id');
    }

    // Relación con el modelo Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id');
    }

    public function revisorPersonal()
    {
        return $this->hasOne(Revisor::class, 'id_certificado')
            ->where('tipo_revision', 1)
            ->where('tipo_certificado', 1);
    }

    public function revisorConsejo()
    {
        return $this->hasOne(Revisor::class, 'id_certificado')
            ->where('tipo_revision', 2)
            ->where('tipo_certificado', 1);
    }
    
    public function certificadoReexpedido()
    {
        $datos = json_decode($this->observaciones, true);
        if (isset($datos['id_sustituye'])) {
            return Certificados::find($datos['id_sustituye']);
        }
        return null;
    }

    
}
