<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipos extends Model
{
    use HasFactory;
    protected $table = 'catalogo_tipo_agave';
    protected $primaryKey = 'id_tipo';
    protected $fillable = [
        'id_tipo',
        'nombre',
        'cientifico',
      ];


      public function acats()
      {
          return $this->hasMany(actas_produccion::class,'nombre', 'nombre');
      }
      
}
