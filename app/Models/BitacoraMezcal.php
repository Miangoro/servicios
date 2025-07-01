<?php

namespace App\Models;
/* use App\Models\LotesGranel; */
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraMezcal extends Model
{
    use HasFactory;
    protected $table = 'bitacora_mezcal';
    protected $primaryKey = 'id';

    protected $fillable = [
        'fecha',
        'id_tanque',
        'id_empresa',
        'id_lote_granel',
        'id_instalacion',
        'operacion_adicional',
        'tipo_operacion',
        //INVENTARIO INICIAL
        'volumen_inicial',
        'alcohol_inicial',

        //ENTRADA
        'procedencia_entrada',
        'volumen_entrada',
        'alcohol_entrada',
        'agua_entrada',

        //SALIDAS
        'volumen_salidas',
        'alcohol_salidas',
        'destino_salidas',

        //INVENTARIO FINAL
        'volumen_final',
        'alcohol_final',

        'observaciones',
    ];
       public $timestamps = false;
       // En BitacoraMezcal.php
public function loteBitacora()
{
    return $this->belongsTo(LotesGranel::class, 'id_lote_granel', 'id_lote_granel');
}

}
