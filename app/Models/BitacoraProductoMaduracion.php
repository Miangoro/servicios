<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProductoMaduracion extends Model
{

    use HasFactory;

       protected $table = 'bitacora_producto_maduracion';
       protected $primaryKey = 'id_bitacora_maduracion';
       protected $fillable = [
      'fecha',
       'lote_a_granel'
      ];

}
