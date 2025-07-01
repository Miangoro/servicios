<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lotes_envasado_granel extends Model
{   
    use HasFactory;
    protected $table = 'lotes_envasado_granel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_lote_envasado',
        'id_lote_granel',
        'volumen_parcial',
    ];

    public function loteEnvasado()
    {
        return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado', 'id_lote_envasado');
    }




    public function lotes_granel()
    {
        return $this->hasMany(LotesGranel::class, 'id_lote_granel','id_lote_granel');
    }


    public function lotes_envasado()
    {
        return $this->belongsTo(lotes_envasado::class,'id_lote_envasado', 'id_lote_envasado');
    }


    public function loteGranel()
    {
        return $this->belongsTo(LotesGranel::class, 'id_lote_granel','id_lote_granel');
    }
    
    
    

}
