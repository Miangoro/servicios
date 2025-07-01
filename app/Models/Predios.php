<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Predios extends Model
{
    //use LogsActivity, TranslatableActivityLog, HasFactory;
    use HasFactory;

    // Puedes especificar la tabla si no sigue la convención
    protected $table = 'predios';

    protected $primaryKey = 'id_predio'; // Clave primaria de la tabla

    // Define los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'id_predio',
        'id_empresa',
        'nombre_productor',
        'num_predio',
        'nombre_predio',
        'ubicacion_predio',
        'tipo_predio',
        'puntos_referencia',
        'cuenta_con_coordenadas',
        'superficie',
        'estatus',
        'fecha_emision',
        'fecha_vigencia'

    ];

    public function getLogName2(): string
    {
        return 'predio'; // Devuelve el nombre que desees
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }
    public function tipo()
    {
        return $this->belongsTo(tipos::class, 'id_tipo');
    }

    public function catalogo_tipo_agave()
    {
        return $this->belongsTo(tipos::class, 'id_predio', 'id_tipo');
    }

    public function plantaciones()
    {
        return $this->hasMany(predio_plantacion::class, 'id_tipo');
    }

      // Relación con PredioCoordenadas
      public function coordenadas()
      {
          return $this->hasMany(PredioCoordenadas::class, 'id_predio');
      }
      // Relación con PredioPlantacion
      public function predio_plantaciones()
    {
        return $this->hasMany(predio_plantacion::class, 'id_predio');
    }

        // Relación con el modelo Documentacion_url
        public function documentos()
        {
            return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_predio');
        }

        // Relación con el modelo Documentacion_url
        public function actas_produccion()
        {
            return $this->hasMany(actas_produccion::class, 'id_predio', 'nom_predio');
        }

        public function solicitudes()
        {
            return $this->hasMany(solicitudesModel::class, 'id_predio', 'id_predio');
        }


}
