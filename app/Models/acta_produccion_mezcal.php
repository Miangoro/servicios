<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class acta_produccion_mezcal extends Model
{
    use HasFactory;

    protected $table = 'acta_produccion_mezcal'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    protected $fillable = [
        'id',
        'area',
        'id_acta',
        'respuesta',
    ];
    

    public function actas_inspeccion()
    {
        return $this->hasMany(actas_inspeccion::class,'id_acta', 'id_acta');
    }
    
}
