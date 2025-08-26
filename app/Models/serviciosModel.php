<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class serviciosModel extends Model
{
    protected $table = 'servicios_servicios';
    protected $primaryKey = 'id_servicio';
    protected $fillable = [
        'id_servicio',
        'precio',
        'habilitado',
        'nombre',
        'id_usuario',
        'fecha_registro',
        'duracion',
        'especificaciones',
        'clave',
        'clave_adicional',
        'tipo_duracion',
        'id_habilitado',
        'tipo_servicio',
        'url_requisitos',
        'resumen',
        'tags',
        'metodo',
        'tipo_muestra',
        'prueba',
        'analisis',
        'unidades',
        'id_acreditacion',
        'id_categoria',
        'cant_muestra'
    ];

    

}
