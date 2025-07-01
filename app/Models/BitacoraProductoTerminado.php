<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProductoTerminado extends Model
{
    use HasFactory;
    protected $table = 'bitacora_producto_terminado';
    protected $primaryKey = 'id_bitacora_terminado';
    protected $fillable = [
     'fecha',
    'lote_a_granel'
   ];
}
