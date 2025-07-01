<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Predios_Inspeccion extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'predios_inspeccion';
    protected $primaryKey = 'id_inspeccion';
    protected $fillable = [
      'id_predio',
      'ubicacion_predio',
      'localidad',
      'municipio',
      'distrito',
      'id_estado',
      'nombre_paraje',
      'zona_dom',
      'marco_plantacion',
      'distancia_surcos',
      'distancia_plantas',
      'superficie',
    ];

    public function getLogName2(): string
    {
        return 'inspección'; // Devuelve el nombre que desees
    }

    // Relación con PredioCoordenadas
    public function coordenadas()
    {
        return $this->hasMany(PredioCoordenadas::class, 'id_inspeccion', 'id_inspeccion');
    }

    // Relación con PredioPlantacion
    public function plantaciones()
    {
        return $this->hasMany(predio_plantacion::class, 'id_inspeccion', 'id_inspeccion');
    }

    public function estados()
    {
        return $this->belongsTo(estados::class, 'id_estado');
    }

    public function inspecciones()
    {
        return $this->belongsTo(inspecciones::class, 'id_inspeccion');
    }

    public function predio()
    {
        return $this->belongsTo(Predios::class, 'id_predio');
    }



}
