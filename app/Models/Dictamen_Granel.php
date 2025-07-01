<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Dictamen_Granel extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'dictamenes_granel';
    protected $primaryKey = 'id_dictamen';
    protected $fillable = [
        'num_dictamen',
        'id_empresa',
        'id_inspeccion',
        'id_lote_granel',
        'fecha_emision',
        'fecha_vigencia',
        'fecha_servicio',
        'estatus',
        'observaciones',
        'id_firmante'
    ];

    public function inspeccione()
    {
        return $this->belongsTo(inspecciones::class, 'id_inspeccion');
    }

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'dictamen de granel'; // Devuelve el nombre que desees
    }

    Public function certificado()
    {
        return $this->belongsTo(CertificadosGranel::class, 'id_dictamen', 'id_dictamen');   
    }  


    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id');
    }

    
}
