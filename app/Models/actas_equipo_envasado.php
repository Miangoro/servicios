<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_equipo_envasado extends Model
{
    use HasFactory;

    protected $table = 'actas_equipo_envasado'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_equipo_envasado'; // Clave primaria de la tabla
    protected $fillable = [
        'id_equipo_envasado',
        'id_acta',
        'equipo_envasado',
        'cantidad_envasado',
        'capacidad_envasado',
        'tipo_material_envasado',

        


 
    ];
    

    public function actas_inspeccion()
    {
        return $this->hasMany(actas_inspeccion::class,'id_acta', 'id_acta');
    }
    
}
