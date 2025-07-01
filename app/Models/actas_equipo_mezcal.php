<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_equipo_mezcal extends Model
{
    use HasFactory;

    protected $table = 'actas_equipo_mezcal'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_mezcal'; // Clave primaria de la tabla
    protected $fillable = [
        'id_mezcal',
        'id_acta',
        'equipo',
        'cantidad',
        'capacidad',
        'tipo_material',

        


 
    ];
    
    public function actas_inspeccion()
    {
        return $this->hasMany(actas_inspeccion::class,'id_acta', 'id_acta');
    }

    
}
