<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresas_clientes extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'empresas_clientes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'codigo',
        'nombre',
        'rfc',
        'credito',
        'regimen',
        'calle',
        'colonia',
        'estado',
        'localidad',
        'municipio',
        'constancia',
        'noext',
        'codigo_postal',
        'correo',
        'telefono'
      ];

}
