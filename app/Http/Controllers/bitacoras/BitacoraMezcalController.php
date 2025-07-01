<?php

namespace App\Http\Controllers\bitacoras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\BitacoraMezcal;
use App\Models\empresa;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class BitacoraMezcalController extends Controller
{
    public function UserManagement()
    {
        $bitacora = BitacoraMezcal::all();
        $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        return view('bitacoras.BitacoraMezcal_view', compact('bitacora', 'empresas'));

    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'fecha',
            3 => 'id_lote_granel',
        ];

        $search = $request->input('search.value');
        $totalData = BitacoraMezcal::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'fecha';
        $dir = $request->input('order.0.dir');
        $query = BitacoraMezcal::query();

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('fecha', 'LIKE', "%{$search}%")
                    ->orWhere('id_lote_granel', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $bitacoras = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        $counter = $start + 1;

        foreach ($bitacoras as $bitacora) {
            $nestedData = [
                'fake_id' => $counter++,
                'fecha' => Helpers::formatearFecha($bitacora->fecha),
                'id' => $bitacora->id,
                'nombre_lote' => $bitacora->loteBitacora->nombre_lote ?? 'N/A',
/*                 'volumen_inicial' => $bitacora->volumen_inicial ?? 'N/A',
                'alcohol_inicial' => $bitacora->alcohol_inicial ?? 'N/A', */

                //Entradas
                'procedencia_entrada' => $bitacora->procedencia_entrada ?? 'N/A',
                'volumen_entrada' => $bitacora->volumen_entrada ?? 'N/A',
                'alcohol_entrada' => $bitacora->alcohol_entrada ?? 'N/A',
                'agua_entrada' => $bitacora->agua_entrada ?? 'N/A',
                // Salidas
                'volumen_salidas' => $bitacora->volumen_salidas ?? 'N/A',
                'alcohol_salidas' => $bitacora->alcohol_salidas ?? 'N/A',
                'destino_salidas' => $bitacora->destino_salidas ?? 'N/A',

                // Inventario final
                'volumen_final' => $bitacora->volumen_final ?? 'N/A',
                'alcohol_final' => $bitacora->alcohol_final ?? 'N/A',

                'observaciones' => $bitacora->observaciones ?? 'N/A',
                'firma_ui' => $bitacora->firma_ui ?? 'N/A',
            ];
            $data[] = $nestedData;
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }

    public function PDFBitacoraMezcal() {
        $bitacoras = BitacoraMezcal::with('loteBitacora')->orderBy('fecha', 'desc')->get();
      $pdf = Pdf::loadView('pdfs.Bitacora_Mezcal', compact('bitacoras'))
          ->setPaper([0, 0, 1190.55, 1681.75 ], 'landscape');

          return $pdf->stream('Bitácora Mezcal a Granel.pdf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
            'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
            'id_instalacion' => 'required|integer',
            'operacion_adicional' => 'nullable|string',
            'tipo_operacion' => 'required|string',
            'tipo_operacion' => 'required|string',
            'volumen_inicial' => 'nullable|numeric|min:0',
            'alcohol_inicial' => 'nullable|numeric|min:0',
            'procedencia_entrada' => 'nullable|string',
            'volumen_entrada'=> 'nullable|numeric|min:0',
            'alcohol_entrada' => 'nullable|numeric|min:0',
            'agua_entrada' => 'nullable|numeric|min:0',
            'volumen_salida' => 'nullable|numeric|min:0' ,
            'alc_vol_salida' => 'nullable|numeric|min:0',
            'destino' => 'nullable|string|max:255',
            'volumen_final' => 'required|numeric|',
            'alc_vol_final' => 'required|numeric|',
            'observaciones' => 'nullable|string|',
        ]);

        try {
            $bitacora = new BitacoraMezcal();
            $bitacora->fecha = $request->fecha;
            $bitacora->id_empresa = $request->id_empresa;
            $bitacora->id_instalacion = $request->id_instalacion;
            $bitacora->id_lote_granel = $request->id_lote_granel;
            $bitacora->tipo_operacion = $request->tipo_operacion;
            $bitacora->operacion_adicional = $request->operacion_adicional;
            $bitacora->volumen_inicial = $request->volumen_inicial;
            $bitacora->alcohol_inicial = $request->alcohol_inicial;
            $bitacora->procedencia_entrada  = $request->procedencia_entrada ?? 0;
            $bitacora->volumen_entrada  = $request->volumen_entrada ?? 0;
            $bitacora->alcohol_entrada  = $request->alcohol_entrada ?? 0;
            $bitacora->agua_entrada  = $request->agua_entrada ?? 0;
            $bitacora->volumen_salidas = $request->volumen_salida ?? 0;
            $bitacora->alcohol_salidas = $request->alc_vol_salida ?? 0;
            $bitacora->destino_salidas = $request->destino ?? 0;
            $bitacora->volumen_final = $request->volumen_final;
            $bitacora->alcohol_final = $request->alc_vol_final;
            $bitacora->observaciones = $request->observaciones;

            $bitacora->save();

            return response()->json(['success' => 'Bitácora registrada correctamente']);
        } catch (\Exception $e) {
          /*   Log::error('Error al registrar bitácora: ' . $e->getMessage()); */
          /*   return response()->json(['error' => 'Error al registrar la bitácora'], 500); */
          return response()->json(['error' => $e->getMessage()], 500);

        }
    }
    public function destroy($id_bitacora)
    {
        $bitacora = BitacoraMezcal::find($id_bitacora);

        if (!$bitacora) {
            return response()->json([
                'error' => 'Bitácora no encontrada.'
            ], 404);
        }

        $bitacora->delete();

        return response()->json([
            'success' => 'Bitácora eliminada correctamente.'
        ]);
    }

    public function edit($id_bitacora)
    {
        try {
            $bitacora = BitacoraMezcal::findOrFail($id_bitacora);
            $fecha_formateada = Carbon::parse($bitacora->fecha)->format('Y-m-d');
            return response()->json([
                'success' => true,
                'bitacora' => [
                    'id' => $bitacora->id,
                    'id_empresa' => $bitacora->id_empresa,
                    'id_instalacion' => $bitacora->id_instalacion,
                    'fecha' => $fecha_formateada, // para que el input date lo acepte
                    'id_lote_granel' => $bitacora->id_lote_granel,
                    'operacion_adicional' => $bitacora->operacion_adicional,
                    'volumen_inicial'    =>     $bitacora->volumen_inicial,
                    'alcohol_inicial'   =>     $bitacora->alcohol_inicial,
                    'tipo_operacion' => $bitacora->tipo_operacion,
                    'procedencia_entrada'  =>     $bitacora->procedencia_entrada,
                    'volumen_entrada'   =>    $bitacora->volumen_entrada,
                    'alcohol_entrada'  =>     $bitacora->alcohol_entrada,
                    'agua_entrada' => $bitacora->agua_entrada,
                    'volumen_salida' => $bitacora->volumen_salidas,
                    'alc_vol_salida' => $bitacora->alcohol_salidas,
                    'destino' => $bitacora->destino_salidas,
                    'volumen_final' => $bitacora->volumen_final,
                    'alc_vol_final' => $bitacora->alcohol_final,
                    'observaciones' => $bitacora->observaciones,
                    // agrega otros campos que necesites si existen
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al obtener bitácora para editar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'No se encontró la bitácora.'], 404);
        }
    }


      public function update(Request $request, $id_bitacora)
      {
       /*  dd($request); */
          $request->validate([
              'edit_bitacora_id' => 'required|exists:bitacora_mezcal,id',
              'id_empresa'       => 'required|exists:empresa,id_empresa',
              'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
              'id_instalacion' => 'required|integer',
              'operacion_adicional' => 'nullable|string',
              'tipo_operacion' => 'required|string',
              'volumen_inicial' => 'nullable|numeric|min:0',
              'alcohol_inicial' => 'nullable|numeric|min:0',
              'procedencia_entrada' => 'nullable|string',
              'volumen_entrada'=> 'nullable|numeric|min:0',
              'alcohol_entrada' => 'nullable|numeric|min:0',
              'agua_entrada' => 'nullable|numeric|min:0',
              'volumen_salida' => 'nullable|numeric|min:0' ,
              'alc_vol_salida' => 'nullable|numeric|min:0',
              'destino' => 'nullable|string|max:255',
              'volumen_final' => 'required|numeric|',
              'alc_vol_final' => 'required|numeric|',
              'observaciones'    => 'nullable|string',
          ]);

          $bitacora = BitacoraMezcal::findOrFail($id_bitacora);

          $bitacora->update([
              'id_empresa'       => $request->id_empresa,
              'id_lote_granel'   => $request->id_lote_granel,
              'id_instalacion'   => $request->id_instalacion,
              'fecha'            => $request->fecha,
              'operacion_adicional' => $request->operacion_adicional,
              'tipo_operacion' => $request->tipo_operacion,
              'volumen_inicial' => $request->volumen_inicial,
              'alcohol_inicial' => $request->alcohol_inicial ,
              'procedencia_entrada' => $request->procedencia_entrada ?? 0,
              'volumen_entrada'=> $request->volumen_entrada ?? 0,
              'alcohol_entrada' => $request->alcohol_entrada ?? 0,
              'agua_entrada' => $request->agua_entrada ?? 0,
              'volumen_salidas'   => $request->volumen_salida ?? 0,
              'alcohol_salidas'   => $request->alc_vol_salida ?? 0,
              'destino_salidas'  => $request->destino ?? 0,
              'volumen_final'    => $request->volumen_final,
              'alcohol_final'    => $request->alc_vol_final,
              'observaciones'    => $request->observaciones,
          ]);

          return response()->json(['success' => 'Bitácora actualizada correctamente.']);
      }

}
