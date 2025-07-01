<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipos extends Model
{
    use HasFactory;
    protected $table = 'catalogo_equipos'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_equipo'; // Clave primaria de la tabla
    protected $fillable = [
        'id_equipo',
        'equipo',
 
    ];
    
}
