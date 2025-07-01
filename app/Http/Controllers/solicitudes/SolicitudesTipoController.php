<?php

namespace App\Http\Controllers\Solicitudes;

use App\Http\Controllers\Controller;
use App\Models\empresa;
use Illuminate\Http\Request;
use App\Models\solicitudTipo;

class SolicitudesTipoController extends Controller
{
    public function UserManagement()
    {
        $solicitudesTipos = solicitudTipo::orderBy('orden', 'asc')->get();
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        return view('solicitudes.solicitudes-tipo_view', compact('solicitudesTipos','empresas'));
    }

    public function getSolicitudesTipos()
    {
        try {
            $solicitudesTipos = solicitudTipo::orderBy('orden', 'asc')->get();
            return response()->json($solicitudesTipos);
        } catch (\Exception $e) {
            \Log::error('Error al obtener tipos de solicitud: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener los tipos de solicitud.'], 500);
        }
    }

}
