<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class serviciosEspecializadosController extends Controller
{
    /**
     * Muestra una vista con los servicios especializados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Puedes pasar datos a la vista aquí si lo necesitas
        // $servicios = Servicio::all();

        return view('servicios.find_servicios_especializados_view');
    }
}