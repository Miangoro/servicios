<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marcas extends Model
{

      use HasFactory;

      protected $table = 'marcas';
      protected $primaryKey = 'id_marca';
      protected $fillable = [
          'id_marca',
          'folio',
          'marca',
          'id_empresa',
          'id_norma',
          'etiquetado'
      ];

      public function empresa()
      {
          return $this->belongsTo(empresa::class, 'id_empresa');
      }
      public function documentacion_url()
      {
          return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_marca');
      }


      public function catalogo_norma_certificar()
      {
          return $this->belongsTo(catalogo_norma_certificar::class, 'id_norma', 'id_norma');
      }
          // Relación con la tabla de solicitudes
    public function solicitudes()
    {
        return $this->hasMany(solicitudesModel::class, 'id_empresa', 'id_empresa');
    }
    // Definir las relaciones con las tablas de tipos, clases y categorías
    public function tipos()
    {
        return $this->hasMany(tipos::class, 'id_tipo', 'id_tipo');
    }

    public function clases()
    {
        return $this->hasMany(clases::class, 'id_clase', 'id_clase');
    }

    public function categorias()
    {
        return $this->hasMany(categorias::class, 'id_categoria', 'id_categoria');
    }
        public function direccion()
    {
        return $this->hasMany(Destinos::class, 'id_direccion', 'id_direccion');
    }

    public function etiquetas()
    {
        return $this->hasMany(etiquetas::class, 'id_marca');
    }


}
