<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class normas_catalo extends Model
{
    use HasFactory;
    protected $table = 'catalogo_norma_certificar';
    protected $primaryKey = 'id_norma';
    protected $fillable = [
        'norma',
    ];

    public function empresas()
    {
        return $this->belongsToMany(empresa::class, 'empresa_norma_certificar',  'id_norma', 'id_empresa');
    }

}
