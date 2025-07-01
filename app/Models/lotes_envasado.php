<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lotes_envasado extends Model
{
    use HasFactory;
    protected $table = 'lotes_envasado';
    protected $primaryKey = 'id_lote_envasado';
    protected $fillable = [
        'id_lote_envasado',
        'id_empresa',
        'nombre',
        'sku',
        'id_marca',
        'destino_lote',
        'cant_botellas',
        'cant_bot_restante',
        'presentacion',
        'unidad',
        'volumen_total',
        'vol_restante',
        'lugar_envasado',
        'estatus',

    ];

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa', 'id_empresa');
    }

    public function Instalaciones()
    {
        return $this->belongsTo(instalaciones::class, 'lugar_envasado', 'id_instalacion');
    }
    
    public function marca(){
        return $this->belongsTo(marcas::class, 'id_marca', 'id_marca');
    }
    public function lotesGranel()
    {
        return $this->belongsToMany(LotesGranel::class, 'lotes_envasado_granel', 'id_lote_envasado', 'id_lote_granel');
    }
    

    public function lotes_envasado_granel()
    {
        return $this->hasMany(lotes_envasado_granel::class,'id_lote_envasado', 'id_lote_envasado');
    }

    public function dictamenEnvasado()
{
    return $this->belongsTo(Dictamen_Envasado::class, 'id_lote_envasado', 'id_lote_envasado');
}
    

    

}
