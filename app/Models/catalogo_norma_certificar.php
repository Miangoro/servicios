<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogo_norma_certificar extends Model
{

      use HasFactory;
  
      protected $table = 'catalogo_norma_certificar';
      protected $primaryKey = 'id_norma ';
      protected $fillable = [
          'id_norma',
          'norma',

      ];
  
      public function empresa()
      {
          return $this->belongsTo(empresa::class, 'id_empresa');
      }
      public function documentacion_url()
      {
          return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_marca');
      }
      
}
