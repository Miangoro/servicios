<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class predio_plantacion extends Model
{
    use HasFactory;

    protected $table = 'predio_plantacion';
    protected $primaryKey = 'id_plantacion';
    protected $fillable = [
        'id_plantacion',
        'id_predio',
        'id_inspeccion',
        'id_tipo',
        'num_plantas',
        'anio_plantacion',
        'tipo_plantacion',
    ];

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function tipo()
    {
        return $this->belongsTo(tipos::class, 'id_tipo');
    }
    public function predio()
    {
        return $this->belongsTo(Predios::class, 'id_predio');
    }


    public function guias()
    {
        return $this->hasMany(solicitudHolograma::class, 'num_plantas', 'numero_plantas');
    }
    // En el modelo PredioPlantacion
    public function inspeccion()
    {
        return $this->belongsTo(Predios_Inspeccion::class, 'id_inspeccion', 'id_inspeccion');
    }
}
