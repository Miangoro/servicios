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
   


    return view('content.dashboard.dashboards-analytics');
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
