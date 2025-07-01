<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Certificado_Exportacion;
use App\Models\Certificados;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Envasado;
use App\Models\Dictamen_Exportacion;
use App\Models\Dictamen_Granel;
use App\Models\Dictamen_instalaciones;
use App\Models\inspecciones;
use App\Models\LotesGranel;
use App\Models\solicitudesModel;
use App\Models\solicitudTipo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function index()
  {
    //$datos = solicitudesModel::All();
    $solicitudesSinInspeccion = solicitudesModel::doesntHave('inspeccion')->where('fecha_solicitud','>','2024-12-31')->count();
    $solicitudesSinActa = solicitudesModel::whereNotIn('id_tipo', [12, 13, 15])
    ->where('fecha_solicitud', '>', '2024-12-31')
    ->where(function ($query) {
        $query->doesntHave('documentacion_completa')
              ->orWhereDoesntHave('documentacion_completa', function ($q) {
                  $q->where('id_documento', 69);
              });
    })
    ->get();






    $hoy = Carbon::today(); // Solo la fecha, sin hora.
    $fechaLimite = $hoy->copy()->addDays(5); // Fecha límite en 5 días.


    $dictamenesInstalacion = Dictamen_instalaciones::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $dictamenesGranel = Dictamen_granel::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    //$dictamenesEnvasado = Dictamen_Envasado::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $dictamenesExportacion = Dictamen_Exportacion::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $dictamenesPorVencer = $dictamenesInstalacion
      ->merge($dictamenesGranel)
      //->merge($dictamenesEnvasado)
      ->merge($dictamenesExportacion);

    $certificadosInstalacion = Certificados::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $certificadosGranel = CertificadosGranel::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $certificadosExportacion = Certificado_Exportacion::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $certificadosPorVencer = $certificadosInstalacion
      ->merge($certificadosGranel)
      ->merge($certificadosExportacion);


    $dictamenesInstalacionesSinCertificado = Dictamen_instalaciones::whereDoesntHave('certificado')->where('fecha_emision','>','2024-12-31')->get();
    $dictamenesGranelesSinCertificado = Dictamen_Granel::whereDoesntHave('certificado')->where('fecha_emision','>','2024-12-31')->get();
    $dictamenesExportacionSinCertificado  = Dictamen_Exportacion::whereDoesntHave('certificado')->where('fecha_emision','>','2024-12-31')->get();

    $lotesSinFq = LotesGranel::whereDoesntHave('fqs')->get();

    $certificadoGranelSinEscaneado = CertificadosGranel::whereDoesntHave('certificadoEscaneado')->get();
    


// Traer las inspecciones futuras con su inspector
$inspecciones = inspecciones::with('inspector')
    ->whereHas('inspector') // asegura que tenga inspector
    ->where('fecha_servicio', '>', Carbon::parse('2024-12-31'))
    ->get()
    ->unique('num_servicio') // <-- omite duplicados por num_servicio
    ->groupBy(function ($inspeccion) {
        return $inspeccion->inspector->id; // agrupamos por ID del inspector
    });

// Preparar el resultado
$inspeccionesInspector = $inspecciones->map(function ($grupo) {
    $inspector = $grupo->first()->inspector;
    return [
        'nombre' => $inspector->name,
        'foto' => $inspector->profile_photo_path,
        'total_inspecciones' => $grupo->count(),
    ];
})->sortByDesc('total_inspecciones'); 


    return view('content.dashboard.dashboards-analytics', compact('certificadoGranelSinEscaneado','lotesSinFq','inspeccionesInspector','solicitudesSinInspeccion', 'solicitudesSinActa', 'dictamenesPorVencer', 'certificadosPorVencer', 'dictamenesInstalacionesSinCertificado', 'dictamenesGranelesSinCertificado','dictamenesExportacionSinCertificado'));
  }

  public function estadisticasCertificados(Request $request)
  {
    $year = $request->input('year', now()->year);

    // Helper para contar por mes
    $contarPorMes = function ($query) use ($year) {
      return $query->whereYear('fecha_emision', $year)
        ->selectRaw('MONTH(fecha_emision) as mes, COUNT(*) as total')
        ->groupBy('mes')
        ->pluck('total', 'mes')
        ->toArray();
    };

    $instalaciones = $contarPorMes(Certificados::query());
    $granel = $contarPorMes(CertificadosGranel::query());
    $exportacion = $contarPorMes(Certificado_Exportacion::query());

    // Asegura que haya un valor para cada mes (1-12), aunque sea 0
    $formatearDatos = function ($datos) {
      $meses = array_fill(1, 12, 0); // meses del 1 al 12
      foreach ($datos as $mes => $total) {
        $meses[$mes] = $total;
      }
      return array_values($meses); // ordenados por mes
    };

    return response()->json([
      'instalaciones' => $formatearDatos($instalaciones),
      'granel' => $formatearDatos($granel),
      'exportacion' => $formatearDatos($exportacion),
    ]);
  }

  public function estadisticasServicios(Request $request)
  {
      $year = $request->input('year', now()->year);
  
      // Trae todos los tipos de servicio con su ID y nombre
      $tipos = solicitudTipo::pluck('tipo', 'id_tipo'); // [1 => 'Instalaciones', 2 => 'Granel', ...]
  
      $formatearDatos = function ($datos) {
          $meses = array_fill(1, 12, 0);
          foreach ($datos as $mes => $total) {
              $meses[$mes] = $total;
          }
          return array_values($meses);
      };
  
      $inspecciones = [];
  
      foreach ($tipos as $id => $nombre) {
          $datos = inspecciones::whereHas('solicitud', function ($query) use ($id) {
                  $query->where('id_tipo', $id);
              })
              ->whereYear('fecha_servicio', $year)
              ->selectRaw('MONTH(fecha_servicio) as mes, COUNT(*) as total')
              ->groupBy('mes')
              ->pluck('total', 'mes')
              ->toArray();
  
          $inspecciones[$nombre] = $formatearDatos($datos);
      }
  
      return response()->json([
          'inspecciones' => $inspecciones
      ]);
  }
  



}
