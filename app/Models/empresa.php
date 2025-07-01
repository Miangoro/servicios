<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class empresa extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;
    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';
    protected $fillable = [
        'id_empresa',
        'razon_social',
        'domicilio_fiscal',
        'tipo',
        'cp'
      ];

      public function getLogName2(): string
      {
          return 'cliente'; // Devuelve el nombre que desees
      }

      public function empresaNumClientes()
    {
        return $this->hasMany(empresaNumCliente::class, 'id_empresa', 'id_empresa')
                ->whereNotNull('numero_cliente');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_empresa');
    }

    public function instalaciones()
    {
        return $this->hasMany(instalaciones::class, 'id_empresa');
    }


    public function guiasEmpresa()
    {
        return $this->hasMany(Guias::class, 'id_empresa');
    }

    public function obtenerInstalaciones(){
        return instalaciones::where('id_empresa', $this->id_empresa)->get();
    }

    public function lotes_granel(){
        return LotesGranel::where('id_empresa', $this->id_empresa)->get();
    }

    public function todos_lotes_granel()
    {
        // Obtener las empresas maquiladoras donde esta empresa es maquilador
        $idsEmpresas = maquiladores_model::where('id_maquiladora', $this->id_empresa)
            ->pluck('id_maquilador')
            ->toArray(); // Convertir la colección en array
    
        // Agregar la empresa actual al array
        $idsEmpresas[] = $this->id_empresa;
    
        // Obtener todos los lotes de granel de esas empresas
        return LotesGranel::whereIn('id_empresa', $idsEmpresas)->get();
    }
    
    public function lotes_envasado()
    {
    // Aquí deberías implementar la lógica para obtener los lotes envasados
    return lotes_envasado::where('id_empresa', $this->id_empresa)->with('lotes_envasado_granel.lotes_granel','dictamenEnvasado')->get();
    }

    public function todos_lotes_envasado()
    {
        // Obtener los IDs de maquiladoras asociadas a la empresa
        $idsMaquiladoras = maquiladores_model::where('id_maquiladora', $this->id_empresa)
            ->pluck('id_maquilador')
            ->toArray();

        // Buscar los lotes de envasado correspondientes, incluyendo relaciones anidadas
        return lotes_envasado::whereIn('id_empresa', $idsMaquiladoras)->with('lotes_envasado_granel.lotes_granel','dictamenEnvasado')->orderByDesc('id_lote_envasado')
            ->get();
    }

/*
    public function marcas(){
        return marcas::where('id_empresa', $this->id_empresa)->get();
    } */
    public function marcas()
    {
        return $this->hasMany(marcas::class, 'id_empresa', 'id_empresa');
    }

    public function todasLasMarcas()
    {
        // Obtener los IDs de las empresas que tienen a esta empresa como maquilador
        $idsEmpresas = maquiladores_model::where('id_maquilador', $this->id_empresa)
            ->pluck('id_maquiladora')
            ->push($this->id_empresa); // Agrega la empresa actual

        // Obtener todas las marcas de esas empresas
        return marcas::whereIn('id_empresa', $idsEmpresas);
    }





    public function guias(){
        return Guias::where('id_empresa', $this->id_empresa)->get();
    }

    public function predios(){
        return Predios::where('id_empresa', $this->id_empresa)->get();
    }

    public function solicitudHolograma(){
        return solicitudHolograma::where('id_empresa', $this->id_empresa)->get();
    }

    public function actas_inspeccion()
    {
        return $this->hasMany(actas_inspeccion::class, 'id_empresa');
    }

    public function direcciones(){
        return direcciones::where('id_empresa', $this->id_empresa)->get();
    }

    public function predio_plantacion(){
        return Predios::where('id_empresa', $this->id_empresa)
        ->join('predio_plantacion AS pl', 'predios.id_predio', '=', 'pl.id_predio')
        ->join('catalogo_tipo_agave AS t', 'pl.id_tipo', '=', 't.id_tipo')
        ->select('pl.id_plantacion','t.nombre', 't.cientifico', 'pl.num_plantas', 'pl.anio_plantacion', 'predios.nombre_predio', 'predios.superficie')
        ->get();
    }

    public function solicitudes()
    {
        return $this->hasMany(solicitudesModel::class, 'id_empresa','id_empresa');
    }

    public function contratos()
    {
        return $this->hasMany(empresaContrato::class, 'id_empresa', 'id_empresa');
    }

    public function normas()
    {
        return $this->belongsToMany(normas_catalo::class, 'empresa_num_cliente', 'id_empresa', 'id_norma');
    }

    public function maquiladora()
    {
        return $this->belongsTo(maquiladores_model::class, 'id_empresa', 'id_maquilador');
    }

    public function actividades()
    {
        // Relación con el modelo empresa_actividad
        return $this->hasMany(EmpresaActividad::class, 'id_empresa');
    }

    public function catalogoActividades()
    {
        // Relación a través de empresa_actividad hacia catalogo_actividad_cliente
        return $this->hasManyThrough(
            catalogo_actividad_cliente::class, // El modelo al que queremos acceder
            empresa_actividad::class,          // El modelo intermedio
            'id_empresa',                     // Clave foránea en empresa_actividad
            'id_actividad',                   // Clave foránea en catalogo_actividad_cliente
            'id_empresa',                     // Clave local en empresa
            'id_actividad'                    // Clave local en empresa_actividad
        );
    }


    public function estados()
    {
        return $this->belongsTo(estados::class, 'estado', 'id');
    }




}
