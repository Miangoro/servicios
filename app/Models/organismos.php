<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organismos extends Model
{
    use HasFactory;

    protected $table = 'catalogo_organismos'; // Nombre de la tabla en la base de datos

    protected $primaryKey = 'id_organismo'; // Clave primaria de la tabla

    protected $fillable = ['organismo']; // Campos que se pueden asignar masivamente

}

