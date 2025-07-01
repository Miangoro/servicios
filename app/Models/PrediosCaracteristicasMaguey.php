<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrediosCaracteristicasMaguey extends Model
{
    use HasFactory;
    protected $table = 'predios_caracteristicas_maguey'; // Nombre de la tabla
    protected $primaryKey = 'id_caracteristica'; // Clave primaria

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'id_predio',
        'id_inspeccion',
        'no_planta',
        'altura',
        'diametro',
        'numero_hojas',
    ];
    public function inspeccion()
    {
        return $this->belongsTo(Predios_Inspeccion::class, 'id_inspeccion', 'id_inspeccion');
    }

    public function predio()
    {
        return $this->belongsTo(Predios::class, 'id_predio', 'id_predio');
    }


}
