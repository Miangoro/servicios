<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslatableActivityLog;
use Spatie\Activitylog\Traits\LogsActivity;

class Certificado_Exportacion extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'certificados_exportacion';
    protected $primaryKey = 'id_certificado';
    protected $fillable = [
        'id_certificado',
        'num_certificado',
        'id_dictamen',
        'fecha_emision',
        'fecha_vigencia',
        'id_firmante',
        'estatus',
        'observaciones',
      ];

      protected $casts = [
    'hologramas' => 'array',
];

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'certificado de exportación'; // Devuelve el nombre que desees
    }

    // Relación con el modelo Dictamen_Exportacion (dictamenes)
    public function dictamen()
    {
        return $this->belongsTo(Dictamen_Exportacion::class, 'id_dictamen', 'id_dictamen');
    }

    // Relación con el modelo User (Firmante)
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id'); 
    }

    public function revisorPersonal()
    {
        return $this->hasOne(Revisor::class, 'id_certificado')
            ->where('tipo_revision', 1)
            ->where('tipo_certificado', 3);
    }

    public function revisorConsejo()
    {
        return $this->hasOne(Revisor::class, 'id_certificado')
            ->where('tipo_revision', 2)
            ->where('tipo_certificado', 3);
    }


    public function certificadoReexpedido()
    {
        $datos = json_decode($this->observaciones, true);
        if (isset($datos['id_sustituye'])) {
            return Certificados::find($datos['id_sustituye']);
        }
        return null;
    }


}
