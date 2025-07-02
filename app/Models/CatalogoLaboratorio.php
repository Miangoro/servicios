<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoLaboratorio extends Model
{
    //use HasFactory;

    public $timestamps = false;
    protected $table = 'catalogo_laboratorios';
    protected $primaryKey = 'id_laboratorio';
    protected $fillable = [
        'id_laboratorio',
        'laboratorio',
        'descripción',
        'clave',
        'habilitado',
        'id_usuario'
      ];
}
