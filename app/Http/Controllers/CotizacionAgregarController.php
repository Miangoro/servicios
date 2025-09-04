<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\catalogos_regimenes;
use App\Models\empresas_clientes;
use App\Models\clientes_contacto; // Asegúrate de que este modelo exista y esté importado.

class CotizacionAgregarController extends Controller
{
    /**
     * Muestra el formulario para crear una nueva cotización.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Obtiene todos los regímenes de la tabla catalogos_regimenes
        $regimenes = catalogos_regimenes::all();

        // Obtiene todos los clientes de la tabla empresas_clientes
        $empresas = empresas_clientes::all();

        // Pasa las variables $regimenes y $empresas a la vista
        return view('cotizaciones.agregar', compact('regimenes', 'empresas'));
    }

    /**
     * Almacena una nueva cotización en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'cliente' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'monto' => 'required|numeric|min:0',
            // Agrega aquí más reglas de validación para otros campos
        ]);

        // Procesa los datos y guarda la cotización en la base de datos
        // Por ejemplo, usando un modelo de Eloquent:
        // Cotizacion::create($request->all());

        // Redirige al usuario a otra página después de guardar
        return redirect()->route('cotizaciones.index')->with('success', 'Cotización agregada exitosamente.');
    }

    /**
     * Obtiene los contactos de una empresa por su ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactos(int $id)
    {
        // Busca todos los contactos que pertenezcan a la empresa con el ID proporcionado
        // Importante: Se modificaron los campos seleccionados para que coincidan con la vista
        $contactos = clientes_contacto::where('cliente_id', $id)->get(['id', 'nombre_contacto', 'correo_contacto']);

        return response()->json($contactos);
    }
}
