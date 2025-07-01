<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredioCoordenadas extends Model
{
    use HasFactory;
        // Puedes especificar la tabla si no sigue la convención
        protected $table = 'predios_coordenadas';

        protected $primaryKey = 'id_coordenada'; // Clave primaria de la tabla

        // Define los campos que se pueden llenar de forma masiva
        protected $fillable = [
            'id_predio',
            'id_inspeccion',
            'latitud',
            'longitud'

        ];

        public function PredioCoordenadas()
        {
            return $this->belongsTo(Guias::class, 'id_guia');
        }
        // Define la relación inversa
        public function predio()
        {
            return $this->belongsTo(Predios::class, 'id_predio');
        }

        // En el modelo PredioCoordenadas
        public function inspeccion()
        {
            return $this->belongsTo(Predios_Inspeccion::class, 'id_inspeccion', 'id_inspeccion');
        }
}
