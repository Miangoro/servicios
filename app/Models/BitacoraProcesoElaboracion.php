<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProcesoElaboracion extends Model
{
    use HasFactory;
    protected $table = 'bitacora_proceso_elaboracion';
    protected $primaryKey = 'id_bitacora_elaboracion';
    protected $fillable = [
     'fecha',
    'lote_a_granel'
   ];
}
