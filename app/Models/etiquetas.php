<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etiquetas extends Model
{
    use HasFactory;
    protected $table = 'etiquetas';
    protected $primaryKey = 'id_etiqueta';
    protected $fillable = [
        'id_marca',
        'sku',
        'id_categoria',
        'id_clase',
        'id_tipo',
        'presentacion',
        'unidad',
        'alc_vol'
    ];

    public function marca()
    {
        return $this->belongsTo(marcas::class, 'id_marca');
    }

    public function destinos()
    {
        return $this->belongsToMany(direcciones::class, 'etiquetas_destino', 'id_etiqueta', 'id_direccion');
    }

    public function categoria()
    {
        return $this->belongsTo(categorias::class, 'id_categoria');
    }

    public function clase()
    {
        return $this->belongsTo(clases::class, 'id_clase');
    }

    public function tipo()
    {
        return $this->belongsTo(tipos::class, 'id_tipo');
    }

    public function url_etiqueta()
    {
        return $this->belongsTo(Documentacion_url::class, 'id_etiqueta','id_relacion')->where('id_documento',60);
    }

    public function url_corrugado()
    {
        return $this->belongsTo(Documentacion_url::class, 'id_etiqueta','id_relacion')->where('id_documento',75);
    }
}
