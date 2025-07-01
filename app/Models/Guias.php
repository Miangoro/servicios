<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guias extends Model
{
    use HasFactory;

    protected $table = 'guias'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_guia'; // Clave primaria de la tabla
    protected $fillable = [
        'id_guia',
        'id_plantacion',
        'run_folio',
        'folio', // Asegúrate de que el nombre del campo sea correcto en la tabla
        'id_empresa',
        'id_predio',
        'numero_plantas',
        'numero_guias',
        'num_anterior',
        'num_comercializadas',
        'mermas_plantas',
        'edad',
        'art',
        'kg_magey',
        'no_lote_pedido',
        'fecha_corte',
        'observaciones',
        'nombre_cliente',
        'no_cliente',
        'fecha_ingreso',
        'domicilio',

    ];
    

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function predio()
    {
        return $this->belongsTo(predio_plantacion::class, 'num_plantas', 'numero_plantas');
    }

    public function predios()
    {
        return $this->belongsTo(Predios ::class, 'id_predio');
    }
}
