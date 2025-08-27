<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalRegularModel extends Model
{
    protected $table = 'personal_regular';
    protected $primaryKey = 'id_empleado';
    protected $fillable = [
        'folio',
        'foto',
        'nombre',
        'fecha_ingreso',
        'descripcion',
        'correo',
    ];
}
