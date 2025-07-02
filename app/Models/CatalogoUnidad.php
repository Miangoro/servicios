<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoUnidad extends Model
{
   // use HasFactory;

    public $timestamps = false;
    protected $table = 'catalogo_unidades';
    protected $primaryKey = 'id_unidad';
    protected $fillable = [
        'id_unidad',
        'nombre',
        'habilitado',
        'id_usuario',
      ];
}
