<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\activarHologramasModelo;
use App\Models\empresa;
use App\Models\empresaNumCliente;
use App\Models\marcas;
use Illuminate\Http\Request;

class HologramasValidacion extends Controller
{
  public function index2($folio)
  {
    $pageConfigs = ['myLayout' => 'blank'];

    $numero_cliente = substr($folio, 0, 12); // Extrae los primeros 13 caracteres
    $cliente = empresaNumCliente::with('empresa')
      ->where('numero_cliente', $numero_cliente)
      ->first();

    $folio_marca = substr($folio, 14, 1);
    $marca = marcas::where('folio', $folio_marca)->where('id_empresa', $cliente->id_empresa)->first();


    $folio_numerico = (int) substr($folio, -6); // Suponiendo que los últimos 6 dígitos son el número del folio
    $ya_activado = false;
    $datosHolograma = null;

    $activaciones = activarHologramasModelo::with('solicitudHolograma')
      ->whereHas('solicitudHolograma', function ($query) use ($marca) {
        $query->where('id_marca', $marca->id_marca);
      })
      ->get();




    foreach ($activaciones as $activacion) {
      $folios_activados = json_decode($activacion->folios, true);

      for ($i = 0; $i < count($folios_activados['folio_inicial']); $i++) {
        $activado_folio_inicial = (int) $folios_activados['folio_inicial'][$i];
        $activado_folio_final = (int) $folios_activados['folio_final'][$i];

        if ($folio_numerico >= $activado_folio_inicial && $folio_numerico <= $activado_folio_final) {
          $ya_activado = true;
          $datosHolograma = $activacion; // Aquí se guarda el modelo actual
          break 2; // Salimos de ambos bucles
        }
      }
    }



    return view('content.pages.pages-hologramas-validacion', compact('pageConfigs', 'folio', 'cliente', 'marca', 'ya_activado', 'datosHolograma'));
  }


  public function validar_dictamen()
  {

    return view('content.pages.visualizador_dictamen_qr');
  }
}
