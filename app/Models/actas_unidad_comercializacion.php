<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_unidad_comercializacion extends Model
{
    use HasFactory;

    protected $table = 'actas_unidad_comercializacion'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_comercializacion'; // Clave primaria de la tabla
    protected $fillable = [
        'id_comercializacion',
        'id_acta',
        'comercializacion',
        'respuestas_comercio',
    ];
    

    public function actas_inspeccion()
    {
        return $this->hasMany(actas_inspeccion::class,'id_acta', 'id_acta');
    }
    
}
