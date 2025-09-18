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
        'firma',
        'firma_correo',
        'nombre',
        'id_usuario',
        'fecha_ingreso',
        'descripcion',
        'correo',
        'created_at',
        'updated_at'
    ];
}
