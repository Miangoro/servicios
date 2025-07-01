<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\TranslatableActivityLog;

class LotesGranel extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'lotes_granel';

    protected $primaryKey = 'id_lote_granel';  // Cambia esto al nombre correcto de la columna de identificación

    protected $fillable = [
        'id_empresa', 'id_tanque', 'nombre_lote', 'tipo_lote', 'folio_fq', 'volumen', 'volumen_restante',
        'cont_alc', 'id_categoria', 'id_clase', 'id_tipo', 'ingredientes',
        'edad', 'id_guia', 'folio_certificado', 'id_organismo',
        'fecha_emision', 'fecha_vigencia', 'estatus', 'lote_original_id'
    ];

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'lotes a granel'; // Devuelve el nombre que desees
    }

    public function lotesEnvasadoGranel()
    {
        return $this->hasMany(lotes_envasado_granel::class, 'id_lote_granel');
    }


    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function categoria()
    {
        return $this->belongsTo(categorias::class, 'id_categoria', 'id_categoria');
    }

    public function clase()
    {
        return $this->belongsTo(clases::class, 'id_clase', 'id_clase');
    }


   public function gettiposRelacionadosAttribute()
{
    $idTipos = json_decode($this->id_tipo, true);

    if (is_array($idTipos) && !empty($idTipos)) {
        $idTipos = array_map('intval', $idTipos); // Asegura que todos sean enteros

        return tipos::whereIn('id_tipo', $idTipos)
            ->orderByRaw('FIELD(id_tipo, ' . implode(',', $idTipos) . ')')
            ->get();
    }

    return collect();
}




    public function tipos()
    {
        return $this->hasMany(tipos::class, 'id_tipo', 'id_tipo');
    }



    public function organismo()
    {
        return $this->belongsTo(organismos::class, 'id_organismo');
    }

    public function guias()
    {
        return $this->belongsTo(Guias::class, 'id_guia');
    }

    public function lotesGuias()
    {
        return $this->hasMany(LotesGranelGuia::class, 'id_lote_granel');
    }
    /* lotes derivados de otro lote */
     /**
     * Obtiene el lote original del que se creó este lote.
     */
    public function loteOriginal()
    {
        return $this->belongsTo(LotesGranel::class, 'lote_original_id');
    }
    /**
     * Obtiene los lotes que se crearon a partir de este lote.
     */
    public function lotesDerivados()
    {
        return $this->hasMany(LotesGranel::class, 'lote_original_id');
    }


    public function certificadoGranel()
    {
        return $this->hasOne(CertificadosGranel::class, 'id_lote_granel', 'id_lote_granel');
    }


   public function fqs()
    {
        return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_lote_granel')
            ->where(function ($query) {
                $query->where('id_documento', 58)
                    ->orWhere('id_documento', 134);
            });
    }

 


}
