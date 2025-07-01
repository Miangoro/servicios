<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instalaciones extends Model
{
    use HasFactory;

    protected $table = 'instalaciones';

    protected $primaryKey = 'id_instalacion';

    protected $fillable = [
        'id_empresa',
        'tipo',
        'estado',
        'direccion_completa',
        'certificacion',
        'responsable',
        'folio',
        'id_organismo',
        'fecha_emision',
        'fecha_vigencia',
        'eslabon'
    ];

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function organismos()
    {
        return $this->belongsTo(organismos::class, 'id_organismo');
    }

    public function estados()
    {
        return $this->belongsTo(estados::class, 'estado');
    }

    public function getFechaEmisionAttribute($value)
    {
        return $value ? $value : 'N/A';
    }

    public function getFechaVigenciaAttribute($value)
    {
    return $value ? $value : 'N/A';
    }

    public function documentos()
    {

        return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_instalacion');
    }

    public function documentos_certificados_instalaciones()
    {

        return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_instalacion')
        ->whereIn('id_documento', [127, 128, 129, 130, 131]);
    }

    public function dictamen()
    {
        return $this->belongsTo(Dictamen_instalaciones::class, 'id_instalacion', 'id_instalacion');
    }

    public function certificado_instalacion()
    {
        return $this->hasOne(Dictamen_instalaciones::class, 'id_instalacion', 'id_instalacion')
            ->with('certificado');
    }

}
