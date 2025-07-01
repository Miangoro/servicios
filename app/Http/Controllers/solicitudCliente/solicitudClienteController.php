<?php

namespace App\Http\Controllers\solicitudCliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\empresa_producto;
use App\Models\empresa_norma;
use App\Models\empresa_actividad;
use App\Models\solicitud_informacion;
use App\Models\empresa_clasificacion_bebidas;
use App\Models\catalogo_clasificacion_bebidas;
use App\Models\estados;
use App\Mail\correoEjemplo;
use App\Models\Instalaciones;
use Illuminate\Support\Facades\Mail;

class solicitudClienteController extends Controller
{
  public function index()
  {
    $estados = estados::orderBy('nombre')->get(['id', 'nombre AS estado']);

    return view('solicitudes.solicitudCliente', compact('estados'));
  }


  public function RegistroExitoso()
  {
    return view('solicitudes.Registro_exitoso');
  }

  public function registrar(Request $request)
  {
/* dd($request->all()); */
    $empresa = new empresa();
    $empresa->razon_social = $request->razon_social;
    $empresa->domicilio_fiscal = $request->domicilio_fiscal;
    $empresa->estado = $request->estado_fiscal;
    /*$empresa->calle = $request->calle1;
    $empresa->num = $request->numero1;
    $empresa->colonia = $request->colonia1;
    $empresa->municipio = $request->municipio1;
    $empresa->cp = $request->cp1;*/
    $empresa->regimen = $request->regimen;
    $empresa->correo = $request->correo;
    $empresa->telefono = $request->telefono;
    $empresa->tipo = 1; //en este caso siempre es 1 porque es un cliente prospecto
    $empresa->rfc = $request->rfc;
    $empresa->representante = $request->representante  ?: 'No aplica';
    $empresa->save();
    $id_empresa = $empresa->id_empresa;

    for ($i = 0; $i < count($request->producto); $i++) {
      $producto = new empresa_producto();
      $producto->id_producto = $request->producto[$i];
      $producto->id_empresa = $id_empresa;
      $producto->save();
    }

    for ($i = 0; $i < count($request->norma); $i++) {
      $norma = new empresa_norma();
      $norma->id_norma = $request->norma[$i];
      $norma->id_empresa = $id_empresa;
      $norma->save();
    }

    if (!empty($request->domicilio_productora) && !empty($request->estado_productora)) {
      $productora = new instalaciones();
      $productora->direccion_completa = $request->domicilio_productora;
      $productora->estado = $request->estado_productora;
      $productora->id_empresa = $id_empresa;
      $productora->tipo = 'Productora';
      $productora->save();
    }

    if (!empty($request->domicilio_envasadora) && !empty($request->estado_envasadora)) {
      $envasadora = new instalaciones();
      $envasadora->direccion_completa = $request->domicilio_envasadora;
      $envasadora->estado = $request->estado_envasadora;
      $envasadora->id_empresa = $id_empresa;
      $envasadora->tipo = 'Envasadora';
      $envasadora->save();
    }

    if (!empty($request->domicilio_comercializadora) && !empty($request->estado_comercializadora)) {
      $comercializadora = new instalaciones();
      $comercializadora->direccion_completa = $request->domicilio_comercializadora;
      $comercializadora->estado = $request->estado_comercializadora;
      $comercializadora->id_empresa = $id_empresa;
      $comercializadora->tipo = 'Comercializadora';
      $comercializadora->save();
    }


/*     for ($i = 0; $i < count($request->actividad); $i++) {
      $actividad = new empresa_actividad();
      $actividad->id_actividad = $request->actividad[$i];
      $actividad->id_empresa = $id_empresa;
      $actividad->save();
    } */

        if (!empty($request->actividad) && is_array($request->actividad)) {
        foreach ($request->actividad as $id_actividad) {
            $actividad = new empresa_actividad();
            $actividad->id_actividad = $id_actividad;
            $actividad->id_empresa = $id_empresa;
            $actividad->save();
        }
    }
if (is_array($request->clasificacion)) {
    foreach ($request->clasificacion as $id_clasificacion) {

        if (
            isset($request->bebida[$id_clasificacion]) &&
            is_array($request->bebida[$id_clasificacion])
        ) {
            foreach ($request->bebida[$id_clasificacion] as $nombre) {

                if (!empty($nombre)) {
                    $bebida = new empresa_clasificacion_bebidas();
                    $bebida->id_clasificacion = $id_clasificacion;
                    $bebida->nombre = $nombre;
                    $bebida->id_empresa = $id_empresa;
                    $bebida->save();
                }

            }
        }

    }
}


    $solicitud = new solicitud_informacion();
    $solicitud->id_empresa = $id_empresa;
    $solicitud->info_procesos = $request->info_procesos;
    $solicitud->save();

    $details = [
      'title' => "Solicitud de información al cliente",
      'nombre' => $empresa->razon_social,
      'contenido' => "Tu solicitud fué enviada con éxito, a la brevedad posible un miembro del equipo se contactará contigo."
    ];


    //Mail::to($request->correo)->send(new correoEjemplo($details));



    return view('solicitudes.Registro_exitoso');
  }


}
