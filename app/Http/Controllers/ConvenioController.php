<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Convenio; // Asume que tienes un modelo llamado 'Convenio'

class ConvenioController extends Controller
{
    /**
     * Muestra el formulario para crear un nuevo convenio.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('convenios.create');
    }

    /**
     * Almacena un nuevo convenio en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        // 2. Crear una nueva instancia del modelo Convenio
        $convenio = new Convenio();
        $convenio->nombre = $request->input('nombre');
        $convenio->descripcion = $request->input('descripcion');
        $convenio->fecha_inicio = $request->input('fecha_inicio');
        $convenio->fecha_fin = $request->input('fecha_fin');
        // ... puedes añadir más campos aquí

        // 3. Guardar en la base de datos
        $convenio->save();

        // 4. Redirigir al usuario con un mensaje de éxito
        return redirect()->route('convenios.create')->with('success', '¡El convenio se ha creado correctamente!');
    }
}