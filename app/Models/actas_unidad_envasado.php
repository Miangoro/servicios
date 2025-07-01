<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_unidad_envasado extends Model
{
    use HasFactory;

    protected $table = 'actas_unidad_envasado'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_envasado'; // Clave primaria de la tabla
    protected $fillable = [
        'id_envasado',
        'areas',
        'id_acta',
        'respuestas',
    ];
    

    public function actas_inspeccion()
    {
        return $this->hasMany(actas_inspeccion::class,'id_acta', 'id_acta');
    }
    
}
