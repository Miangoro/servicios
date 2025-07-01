<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class empresa_clasificacion_bebidas extends Model
{
        //
    use HasFactory;
    protected $table = 'empresa_clasificacion_bebidas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_clasificacion',
        'nombre',
        'id_empresa'
    ];

    public function clasificacion(){
        return $this->belongsTo(catalogo_clasificacion_bebidas::class, 'id_clasificacion', 'id_clasificacion');
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa', 'id_empresa');
    }

}
