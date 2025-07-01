<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraHologramas extends Model
{
    use HasFactory;
    protected $table = 'bitacora_hologramas';
    protected $primaryKey = 'id_bitacora_hologramas';
    protected $fillable = [
     'fecha',
    'lote_a_granel'
   ];
}
