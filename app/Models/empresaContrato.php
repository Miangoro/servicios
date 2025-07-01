<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresaContrato extends Model
{
    protected $table = 'empresa_contrato';
    protected $primaryKey = 'id_contrato';
    use HasFactory;
    protected $fillable = [
        'id_empresa',
        'fecha_cedula',
        'idcif',
        'clave_ine',
        'sociedad_mercantil',
        'num_instrumento',
        'vol_instrumento',
        'fecha_instrumento',
        'num_notario',
        'num_permiso'
    ];

    public function normas()
    {
        return $this->hasMany(Norma::class, 'id_empresa', 'id_empresa');  
    }
}

