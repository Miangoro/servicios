<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actas_produccion extends Model
{
    use HasFactory;

    protected $table = 'actas_produccion'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_produccion'; // Clave primaria de la tabla
    protected $fillable = [
        'id_produccion',
        'id_acta',
        'id_plantacion',
        'plagas',


 
    ];
    


    public function predio_plantacion()
    {
        return $this->belongsTo(predio_plantacion::class,'id_plantacion', 'id_plantacion');
    }
    

    public function predio()
    {
        return $this->belongsTo(Predios::class,'id_plantacion', 'id_predio');
    }
    

    public function predios()
    {
        return $this->belongsTo(Predios::class, 'id_empresa');
    }


    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function tipos()
    {
        return $this->belongsTo(tipos::class,'nombre', 'nombre');
    }

    public function actas_inspeccion()
    {
        return $this->hasMany(actas_inspeccion::class,'id_acta', 'id_acta');
    }
    
    
}
