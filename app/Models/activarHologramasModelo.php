<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activarHologramasModelo extends Model
{
    use HasFactory;

    protected $table = 'activar_hologramas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_inspeccion',
        'folio_activacion',
        'no_lote_agranel',
        'categoria',
        'no_analisis',
        'cont_neto',
        'unidad',
        'clase',
        'contenido',
        'no_lote_envasado',
        'id_tipo',
        'lugar_produccion',
        'lugar_envasado',
        'id_solicitud',
        'folios',



    ];

    public function inspeccion()
    {
        return $this->belongsTo(inspecciones::class, 'id_inspeccion');
    }

    public function categorias()
    {
        return $this->belongsTo(categorias::class, 'categoria','id_categoria');
    }

    public function clases()
    {
        return $this->belongsTo(clases::class, 'clase','id_clase');
    }

    public function solicitudHolograma()
    {
        return $this->belongsTo(solicitudHolograma::class, 'id_solicitud');
    }

    public function tipos()
    {
        return $this->hasMany(tipos::class, 'id_tipo','id_tipo');
    }

public function activarHologramasDesdeVariasSolicitudes($solicitudes, $folios)
{
    // Buscamos si alguno de estos folios ya ha sido activado
    $foliosExistentes = $this->whereRaw("FIND_IN_SET(folios, ?) > 0", [implode(',', $folios)])->pluck('folios')->toArray();
    $foliosExistentes = array_unique(explode(',', implode(',', $foliosExistentes))); // Convertimos en un array único

    // Filtramos solo los folios que aún no han sido activados
    $foliosNuevos = array_diff($folios, $foliosExistentes);

    if (!empty($foliosNuevos)) {
        // Creamos una nueva activación
        $this->create([
            'id_solicitud' => implode(',', $solicitudes),  // Guardamos múltiples solicitudes en una sola activación
            'folios'       => implode(',', $foliosNuevos),
            'estado'       => 'activado'
        ]);
    }
}


}