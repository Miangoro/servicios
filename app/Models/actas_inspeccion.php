<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_inspeccion extends Model
{
    use HasFactory;

    protected $table = 'actas_inspeccion'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_acta'; // Clave primaria de la tabla
    protected $fillable = [
        'id_acta',
        'id_inspeccion',
        'num_acta',
        'categoria_acta',
        'lugar_inspeccion',
        'fecha_inicio',
        'id_empresa',
        'encargado',
        'num_credencial_encargado',
        'testigos',
        'fecha_fin',
        'no_conf_infraestructura',
        'no_conf_equipo',


 
    ];
    
    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }


    public function inspecciones()
    {
        return $this->belongsTo(inspecciones::class,'id_inspeccion', 'id_inspeccion');
    }


    public function actas_testigo()
    {
        return $this->hasMany(actas_testigo::class,'id_acta', 'id_acta');
    }


    public function acta_produccion_mezcal()
    {
        return $this->hasMany(acta_produccion_mezcal::class,'id_acta', 'id_acta');
    }


    public function actas_equipo_mezcal()
    {
        return $this->hasMany(actas_equipo_mezcal::class,'id_acta', 'id_acta');
    }

    public function actas_equipo_envasado()
    {
        return $this->hasMany(actas_equipo_envasado::class,'id_acta', 'id_acta');
    }

    public function actas_unidad_comercializacion()
    {
        return $this->hasMany(actas_unidad_comercializacion::class,'id_acta', 'id_acta');
    }

    public function actas_unidad_envasado()
    {
        return $this->hasMany(actas_unidad_envasado::class,'id_acta', 'id_acta');
    }

    public function actas_produccion()
    {
        return $this->hasMany(actas_produccion::class,'id_acta', 'id_acta');
    }
    
    
}
