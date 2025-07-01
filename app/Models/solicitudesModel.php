<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class solicitudesModel extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud';
    protected $fillable = [
        'id_empresa',
        'id_tipo',
        'folio',
        'fecha_solicitud',
        'fecha_visita',
        'id_instalacion',
        'id_predio',
        'info_adicional',
        'caracteristicas'
    ];

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'solicitud'; // Devuelve el nombre que desees
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function inspeccion()
    {
        return $this->hasOne(inspecciones::class, 'id_solicitud', 'id_solicitud');
    }

    public function inspector()
    {
        return $this->hasOneThrough(User::class, inspecciones::class, 'id_solicitud', 'id', 'id_solicitud', 'id_inspector');
    }

    public function instalacion()
    {
        return $this->hasOne(instalaciones::class, 'id_instalacion', 'id_instalacion');
    }

    public function predios()
    {
        return $this->hasOne(Predios::class, 'id_predio', 'id_predio');
    }

    public function tipo_solicitud()
    {
        return $this->hasOne(solicitudTipo::class, 'id_tipo', 'id_tipo');
    }
    public function marcas()
    {
        return $this->hasMany(marcas::class, 'id_empresa', 'id_empresa');
    }

    public function instalaciones()
    {
        return $this->belongsTo(instalaciones::class, 'id_instalacion', 'id_instalacion');
    }

public function getIdLoteGranelAttribute()
{
    $caracteristicas = json_decode($this->caracteristicas, true);

    // Busca directamente en la raíz del JSON
    if (isset($caracteristicas['id_lote_granel'])) {
        return $caracteristicas['id_lote_granel'];
    }

    // Busca en los lotes relacionados a través de la tabla intermedia
    if ($this->lotes_envasado_granel && $this->lotes_envasado_granel->isNotEmpty()) {
        // Devuelve SOLO el primer id_lote_granel, nunca un array
        return $this->lotes_envasado_granel->pluck('id_lote_granel')->first();
    }

    // Devuelve null si no se encuentra
    return null;
}

public function getIdLoteGranel2Attribute()
{
    // Asumiendo que la relación se llama lotesGranel
    if ($this->lotesGranel && $this->lotesGranel->isNotEmpty()) {
        return $this->lotesGranel;
    }

    // Si tienes datos en JSON también
    $caracteristicas = json_decode($this->caracteristicas, true);
    if (isset($caracteristicas['id_lote_granel'])) {
        $ids = (array) $caracteristicas['id_lote_granel'];
        return LotesGranel::whereIn('id_lote_granel', $ids)->get();
    }

    return collect();
}

    public function getTipoAnalisisAttribute()
    {
        return json_decode($this->caracteristicas, true)['tipo_analisis'] ?? null;
    }


    public function lote_granel()
    {
        return $this->belongsTo(LotesGranel::class, 'id_lote_granel', 'id_lote_granel');
    }


    public function getIdLoteEnvasadoAttribute()
    {
        $caracteristicas = json_decode($this->caracteristicas, true);
        $ids = [];

        // Verifica si hay uno directamente en la raíz
        if (isset($caracteristicas['id_lote_envasado'])) {
            $ids[] = $caracteristicas['id_lote_envasado'];
        }

        // Verifica dentro del array "detalles"
        if (isset($caracteristicas['detalles']) && is_array($caracteristicas['detalles'])) {
            foreach ($caracteristicas['detalles'] as $detalle) {
                if (isset($detalle['id_lote_envasado'])) {
                    $ids[] = $detalle['id_lote_envasado'];
                }
            }
        }

        // Elimina duplicados (por si acaso)
        return array_unique($ids);
    }




public function lote_envasado()
{
    return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado', 'id_lote_envasado');
}

// En Solicitud
public function lotes_envasado()
{
    $ids = $this->id_lote_envasado; // ya es array gracias al accessor
    return lotes_envasado::whereIn('id_lote_envasado', $ids)->get();
}

    public function getInstalacionVigilanciaAttribute()
    {
        $caracteristicas = json_decode($this->caracteristicas, true);
        return $caracteristicas['instalacion_vigilancia'] ?? null; // Devuelve null si no existe la clave
    }


    public function instalacion_destino()
    {
        return $this->belongsTo(instalaciones::class, 'instalacion_vigilancia', 'id_instalacion');
    }


    public function lotes_envasado_granel()
    {
        return $this->hasMany(lotes_envasado_granel::class,'id_lote_envasado', 'id_lote_envasado');
    }

    public function categorias_mezcal()
{
    $caracteristicas = json_decode($this->attributes['caracteristicas'], true);
    $ids = $caracteristicas['categorias'] ?? [];
    return categorias::whereIn('id_categoria', $ids)->get();
}

public function clases_agave()
{
    $caracteristicas = json_decode($this->attributes['caracteristicas'], true);
    $ids = $caracteristicas['clases'] ?? [];
    return clases::whereIn('id_clase', $ids)->get();
}




    public function documentacion($id_documento)
{
    return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_solicitud')->where('id_documento', $id_documento);
}

    public function documentacion_completa()
    {
        return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_solicitud');
    }

    public function etiqueta()
    {
        $caracteristicas = is_string($this->caracteristicas)
            ? json_decode($this->caracteristicas, true)
            : $this->caracteristicas;

        $idEtiqueta = is_array($caracteristicas)
            ? ($caracteristicas['id_etiqueta'] ?? null)
            : ($caracteristicas->id_etiqueta ?? null);

        if ($idEtiqueta) {
            return Documentacion_url::where('id_relacion', $idEtiqueta)
                ->where('id_documento', 60)
                ->value('url'); // Devuelve directamente la URL si existe
        }

        return null; // Retorna null si no hay etiqueta
    }

    public function corrugado()
    {
        $caracteristicas = is_string($this->caracteristicas)
            ? json_decode($this->caracteristicas, true)
            : $this->caracteristicas;

        $idEtiqueta = is_array($caracteristicas)
            ? ($caracteristicas['id_etiqueta'] ?? null)
            : ($caracteristicas->id_etiqueta ?? null);

        if ($idEtiqueta) {
            return Documentacion_url::where('id_relacion', $idEtiqueta)
                ->where('id_documento', 75)
                ->value('url'); // Devuelve directamente la URL si existe
        }

        return null; // Retorna null si no hay etiqueta
    }



    public function ultima_validacion_oc()
    {
        return $this->hasOne(solicitudesValidacionesModel::class, 'id_solicitud', 'id_solicitud')
                ->where('tipo_validacion', 'oc')
                ->orderByDesc('fecha_realizo'); // Ordenar por la fecha más reciente
    }

    public function ultima_validacion_ui()
    {
        return $this->hasOne(solicitudesValidacionesModel::class, 'id_solicitud', 'id_solicitud')
                ->where('tipo_validacion', 'ui')
                ->orderByDesc('fecha_realizo'); // Ordenar por la fecha más reciente
    }



    // Accesor para obtener el id de la dirección destinataria desde el JSON
    public function getIdDireccionDestinoAttribute()
    {
        $caracteristicas = json_decode($this->caracteristicas, true);

        return $caracteristicas['direccion_destinatario'] ?? null;
    }

    // Relación con el modelo Direcciones
    public function direccion_destino()
    {
        return $this->belongsTo(direcciones::class, 'id_direccion_destino', 'id_direccion');
    }


      // Accesor para obtener el id de la dirección destinataria desde el JSON
      public function getIdInstalacionEnvasadoAttribute()
      {
          $caracteristicas = json_decode($this->caracteristicas, true);

          return $caracteristicas['id_instalacion_envasado'] ?? null;
      }

      // Relación con el modelo Direcciones
      public function instalacion_envasado()
      {
          return $this->belongsTo(instalaciones::class, 'id_instalacion_envasado', 'id_instalacion');
      }

      public function certificadoExportacion()
    {
        return $this->inspeccion?->dictamenExportacion?->certificado;
    }


    ///MULTIPLES LOTES ENVASADO
    public function lotesEnvasadoDesdeJson()
    {
        $caracteristicas = json_decode($this->caracteristicas, true);

        $ids = collect($caracteristicas['detalles'] ?? [])
            ->pluck('id_lote_envasado')
            ->filter()
            ->unique()
            ->values()
            ->all();

        return lotes_envasado::whereIn('id_lote_envasado', $ids)->get();
    }

    ///OBTENER COLLECCION CARACTERISTICAS
    public function caracteristicasDecodificadas(): array
    {
        return $this->caracteristicas ? json_decode($this->caracteristicas, true) : [];
    }



}
