<?php

namespace App\Http\Controllers;

use App\Models\empresas_clientes;
use App\Models\clientes_contacto;
use App\Models\catalogos_regimenes;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClientesExport;

class historialClienteController extends Controller
{
    public function editModal($id)
    {
        try {
            $empresa = empresas_clientes::with('clientesContactos')->findOrFail($id);
            $regimenes = catalogos_regimenes::all();

            return view('_partials._modals.modal-add-edit-Historial', compact('empresa', 'regimenes'));
        } catch (\Exception $e) {
            Log::error('Error al cargar modal de edición de empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['error' => 'No se pudo cargar la empresa para editar: ' . $e->getMessage()], 404);
        }
    }

    public function viewModal($id)
    {
        try {
            $empresa = empresas_clientes::with('clientesContactos')->findOrFail($id);
            $regimenes = catalogos_regimenes::all();

            return view('_partials._modals.modal-add-visualizar-Historial', compact('empresa', 'regimenes'));
        } catch (\Exception $e) {
            Log::error('Error al cargar modal de visualización de empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['error' => 'No se pudo cargar la empresa para visualizar: ' . $e->getMessage()], 404);
        }
    }

    public function exportView()
    {
        $regimenes = catalogos_regimenes::all();
        $clientes = empresas_clientes::select('id', 'nombre')->get();

        // Eliminamos dd($clientes) ya que el problema es la vista incorrecta o el include
        // dd($clientes); 

        // CAMBIO IMPORTANTE AQUÍ: Apuntamos al archivo modal-export-clientes.blade.php
        return view('_partials._modals.modal-export-clientes', compact('regimenes', 'clientes'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'rfc' => 'required|string|max:13|unique:empresas_clientes,rfc',
                'regimen' => 'required|string|max:255',
                'credito' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
                'municipio' => 'required|string|max:255',
                'localidad' => 'required|string|max:255',
                'calle' => 'required|string|max:255',
                'no_exterior' => 'required|string|max:255',
                'colonia' => 'required|string|max:255',
                'codigo_postal' => 'required|string|max:20',
                'telefono' => 'required|string|max:20',
                'correo' => 'required|email|max:255',
                'constancia' => 'nullable|file|mimes:pdf|max:2048',
                'contactos' => 'nullable|array',
                'contactos.*.contacto' => 'nullable|string|max:255',
                'contactos.*.celular' => 'nullable|string|max:20',
                'contactos.*.correo' => 'nullable|email|max:255',
            ]);

            $empresa = new empresas_clientes();
            $validatedData['noext'] = $validatedData['no_exterior'];
            unset($validatedData['no_exterior']);

            $empresa->fill(Arr::except($validatedData, ['constancia', 'contactos']));
            $empresa->tipo = 0;

            if ($request->hasFile('constancia')) {
                $path = $request->file('constancia')->store(date('Y/m/d'), 'public');
                $empresa->constancia = $path;
                Log::info('PDF subido. Ruta guardada en DB: ' . $path);
            } else {
                $empresa->constancia = null;
            }

            $empresa->save();

            if ($request->has('contactos') && is_array($request->input('contactos'))) {
                foreach ($request->input('contactos') as $contactData) {
                    if (!empty($contactData['contacto']) || !empty($contactData['celular']) || !empty($contactData['correo'])) {
                        clientes_contacto::create([
                            'cliente_id' => $empresa->id,
                            'nombre_contacto' => $contactData['contacto'] ?? null,
                            'telefono_contacto' => $contactData['celular'] ?? null,
                            'correo_contacto' => $contactData['correo'] ?? '',
                            'status' => 1,
                            'observaciones' => null,
                        ]);
                    }
                }
            }

            return response()->json(['message' => 'Empresa registrada con éxito.', 'empresa' => $empresa], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al almacenar empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error interno del servidor al registrar la empresa: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $empresa = empresas_clientes::findOrFail($id);

            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'rfc' => 'required|string|max:13|unique:empresas_clientes,rfc,' . $id,
                'regimen' => 'required|string|max:255',
                'credito' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
                'municipio' => 'required|string|max:255',
                'localidad' => 'required|string|max:255',
                'calle' => 'required|string|max:255',
                'no_exterior' => 'required|string|max:255',
                'colonia' => 'required|string|max:255',
                'codigo_postal' => 'required|string|max:20',
                'telefono' => 'required|string|max:20',
                'correo' => 'required|email|max:255',
                'constancia' => 'nullable|file|mimes:pdf|max:2048',
                'contactos' => 'nullable|array',
                'contactos.*.contacto' => 'nullable|string|max:255',
                'contactos.*.celular' => 'nullable|string|max:20',
                'contactos.*.correo' => 'nullable|email|max:255',
                'contactos.*.status' => 'nullable|integer|in:0,1',
                'contactos.*.observaciones' => 'nullable|string|max:500',
                'motivo_edicion' => 'required|string|max:1000',
            ]);

            if ($request->hasFile('constancia')) {
                if ($empresa->constancia && Storage::disk('public')->exists($empresa->constancia)) {
                    Storage::disk('public')->delete($empresa->constancia);
                    Log::info('PDF anterior eliminado: ' . $empresa->constancia);
                }
                $path = $request->file('constancia')->store(date('Y/m/d'), 'public');
                $empresa->constancia = $path;
                Log::info('PDF actualizado. Nueva ruta guardada en DB: ' . $path);
            }
            else if ($request->input('constancia_cleared')) {
                if ($empresa->constancia && Storage::disk('public')->exists($empresa->constancia)) {
                    Storage::disk('public')->delete($empresa->constancia);
                    Log::info('PDF existente eliminado por solicitud del usuario.');
                }
                $empresa->constancia = null;
            }

            $validatedData['noext'] = $validatedData['no_exterior'];
            unset($validatedData['no_exterior']);

            $empresa->update(Arr::except($validatedData, ['constancia', 'contactos', 'motivo_edicion']));
            $empresa->save();

            $empresa->clientesContactos()->delete();

            if ($request->has('contactos') && is_array($request->input('contactos'))) {
                foreach ($request->input('contactos') as $contactData) {
                    if (!empty($contactData['contacto']) || !empty($contactData['celular']) || !empty($contactData['correo'])) {
                        clientes_contacto::create([
                            'cliente_id' => $empresa->id,
                            'nombre_contacto' => $contactData['contacto'] ?? null,
                            'telefono_contacto' => $contactData['celular'] ?? null,
                            'correo_contacto' => $contactData['correo'] ?? '',
                            'status' => 1,
                            'observaciones' => null,
                        ]);
                    }
                }
            }

            Log::info('Empresa ' . $empresa->id . ' actualizada. Motivo: ' . ($request->input('motivo_edicion') ?? 'No especificado'));

            return response()->json(['message' => 'Empresa actualizada con éxito.', 'empresa' => $empresa]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al actualizar empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error interno del servidor al actualizar la empresa: ' . $e->getMessage()], 500);
        }
    }
    
    public function darDeBaja(Request $request, $id)
    {
        try {
            $empresa = empresas_clientes::findOrFail($id);
            $empresa->estatus = 0; 
            $empresa->save();
            Log::info('Empresa ' . $empresa->id . ' ha sido dada de baja.');
            return response()->json(['message' => 'Empresa dada de baja con éxito.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Empresa no encontrada para dar de baja: ' . $id);
            return response()->json(['message' => 'Empresa no encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Error al dar de baja la empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error al dar de baja la empresa: ' . $e->getMessage()], 500);
        }
    }

    public function darDeAlta(Request $request, $id)
    {
        try {
            $empresa = empresas_clientes::findOrFail($id);
            $empresa->estatus = 1;
            $empresa->save();
            Log::info('Empresa ' . $empresa->id . ' ha sido dada de alta.');
            return response()->json(['message' => 'Empresa dada de alta con éxito.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Empresa no encontrada para dar de alta: ' . $id);
            return response()->json(['message' => 'Empresa no encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Error al dar de alta la empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error al dar de alta la empresa: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $empresa = empresas_clientes::findOrFail($id);
            if ($empresa->constancia && Storage::disk('public')->exists($empresa->constancia)) {
                Storage::disk('public')->delete($empresa->constancia);
                Log::info('PDF eliminado al borrar empresa: ' . $empresa->constancia);
            }
            $empresa->clientesContactos()->delete();
            $empresa->delete();

            return response()->json(['message' => 'Empresa eliminada con éxito.'], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Empresa no encontrada para eliminar: ' . $id);
            return response()->json(['message' => 'Empresa no encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Error al eliminar empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error al eliminar la empresa: ' . $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql = empresas_clientes::query();

            return DataTables::of($sql)->addIndexColumn()
                ->addColumn('constancia', function($row){
                    if (!empty($row->constancia) && str_ends_with($row->constancia, '.pdf')) {
                        return Storage::url($row->constancia);
                    }
                    return null;
                })
                ->addColumn('action', function($row){
                    if ($row->estatus === 0) {
                        return '<span class="badge bg-danger-light text-danger">Dado de baja</span>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success-light" onclick="darDeAltaUnidad(' . $row->id . ')">
                                        <i class="ri-check-line me-1"></i>
                                        Dar de alta
                                    </button>
                                </div>';
                    }

                    $btn = '<div class="dropdown">
                                <button class="btn btn-sm btn-success-light dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton_' . $row->id . '">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="viewUnidad('.$row->id.')">
                                            <i class="ri-search-line ri-20px text-secondary"></i>Visualizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="editUnidad('.$row->id.')">
                                            <i class="ri-edit-box-line ri-20px text-info"></i>Editar
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="darDeBajaUnidad(' . $row->id . ')">
                                                <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Dar de baja
                                            </a>
                                        </li>
                                    </ul>
                                </div>';
                        return $btn;
                    })
                    ->rawColumns(['constancia', 'action'])
                    ->make(true);
            }

            $totalClientes = empresas_clientes::count();
            $personasFisicas = empresas_clientes::where('tipo', 0)->count();
            $otrosRegimenes = empresas_clientes::where('tipo', '!=', 0)->count();

            $regimenes = catalogos_regimenes::all();

            $porcentajeFisicas = ($totalClientes > 0) ? ($personasFisicas / $totalClientes * 100) : 0;
            $porcentajeOtros = ($totalClientes > 0) ? ($otrosRegimenes / $totalClientes * 100) : 0;

            return view('clientes.find_clientes_empresas_view', compact(
                'regimenes',
                'totalClientes',
                'personasFisicas',
                'otrosRegimenes',
                'porcentajeFisicas',
                'porcentajeOtros'
            ));
        }

        public function countCompanies()
        {
            try {
                $total = empresas_clientes::count();
                $personasFisicas = empresas_clientes::where('tipo', 0)->count();
                $otrosRegimenes = empresas_clientes::where('tipo', '!=', 0)->count();

                $porcentajeFisicas = ($total > 0) ? ($personasFisicas / $total * 100) : 0;
                $porcentajeOtros = ($total > 0) ? ($otrosRegimenes / $total * 100) : 0;

                return response()->json([
                    'total' => $total,
                    'fisicas' => $personasFisicas,
                    'otros' => $otrosRegimenes,
                    'porcentajeFisicas' => number_format($porcentajeFisicas, 2),
                    'porcentajeOtros' => number_format($porcentajeOtros, 2),
                ]);
            } catch (\Exception $e) {
                Log::error('Error al obtener el conteo de empresas: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
                return response()->json(['error' => 'No se pudo obtener el conteo de empresas'], 500);
            }
        }

        public function exportExcel(Request $request)
        {
            try {
                Log::info('Solicitud de exportación recibida:', $request->all());

                $query = empresas_clientes::query()->with('catalogoRegimen');

                if ($request->filled('cliente') && $request->input('cliente') !== 'todos') {
                    Log::info('Aplicando filtro por cliente ID:', ['cliente_id' => $request->input('cliente')]);
                    $query->where('id', $request->input('cliente')); 
                } else {
                    Log::info('Filtro por cliente no aplicado o es "todos".');
                }

                if ($request->has('enableFiltroRegimen') && $request->input('enableFiltroRegimen') === 'on' && $request->filled('regimen_fiscal') && $request->input('regimen_fiscal') !== 'todos') {
                    Log::info('Aplicando filtro por régimen:', ['regimen_valor' => $request->input('regimen_fiscal')]);
                    $query->where('regimen', $request->input('regimen_fiscal')); 
                } else {
                    Log::info('Filtro por régimen no aplicado o es "todos" o checkbox no marcado.');
                }

                // Se elimina el filtro de Estado de Pago
                Log::info('Filtro por estado de pago eliminado por solicitud del usuario.');

                if ($request->has('enableFiltroCredito') && $request->input('enableFiltroCredito') === 'on' && $request->filled('credito') && $request->input('credito') !== 'todos') {
                    Log::info('Aplicando filtro por crédito:', ['credito_valor' => $request->input('credito')]);
                    $query->where('credito', $request->input('credito'));
                } else {
                    Log::info('Filtro por crédito no aplicado o es "todos" o checkbox no marcado.');
                }

                if ($request->filled('dia') && $request->input('dia') !== 'todos') {
                    Log::info('Aplicando filtro por día:', ['dia' => $request->input('dia')]);
                    $query->whereDay('created_at', $request->input('dia'));
                } else {
                    Log::info('Filtro por día no aplicado o es "todos".');
                }
                if ($request->filled('mes') && $request->input('mes') !== 'todos') {
                    Log::info('Aplicando filtro por mes:', ['mes' => $request->input('mes')]);
                    $query->whereMonth('created_at', $request->input('mes'));
                } else {
                    Log::info('Filtro por mes no aplicado o es "todos".');
                }
                if ($request->filled('anio') && $request->input('anio') !== 'todos') {
                    Log::info('Aplicando filtro por año:', ['anio' => $request->input('anio')]);
                    $query->whereYear('created_at', $request->input('anio'));
                } else {
                    Log::info('Filtro por año no aplicado o es "todos".');
                }

                $clientes = $query->get();

                // dd($clientes); 

                $filenameParts = ['clientes_export'];

                if ($request->filled('cliente') && $request->input('cliente') !== 'todos') {
                    $clienteSeleccionado = empresas_clientes::find($request->input('cliente'));
                    if ($clienteSeleccionado) {
                        $filenameParts[] = 'cliente_' . str_replace(' ', '_', $clienteSeleccionado->nombre);
                    } else {
                        $filenameParts[] = 'cliente_ID_' . $request->input('cliente');
                    }
                }

                if ($request->has('enableFiltroRegimen') && $request->input('enableFiltroRegimen') === 'on' && $request->filled('regimen_fiscal') && $request->input('regimen_fiscal') !== 'todos') {
                    $regimen = catalogos_regimenes::find($request->input('regimen_fiscal'));
                    if ($regimen) {
                        $filenameParts[] = 'regimen_' . str_replace(' ', '_', $regimen->regimen);
                    }
                }

                // Se elimina la parte del nombre del archivo para el filtro de Estado de Pago

                if ($request->has('enableFiltroCredito') && $request->input('enableFiltroCredito') === 'on' && $request->filled('credito') && $request->input('credito') !== 'todos') {
                    $filenameParts[] = 'credito_' . str_replace(' ', '_', $request->input('credito'));
                }

                if ($request->filled('dia') || $request->filled('mes') || $request->filled('anio')) {
                    $dateParts = [];
                    if ($request->filled('anio') && $request->input('anio') !== 'todos') $dateParts[] = $request->input('anio');
                    if ($request->filled('mes') && $request->input('mes') !== 'todos') $dateParts[] = str_pad($request->input('mes'), 2, '0', STR_PAD_LEFT);
                    if ($request->filled('dia') && $request->input('dia') !== 'todos') $dateParts[] = str_pad($request->input('dia'), 2, '0', STR_PAD_LEFT);
                    if (!empty($dateParts)) {
                        $filenameParts[] = 'fecha_' . implode('-', $dateParts);
                    }
                }

                $filename = implode('_', $filenameParts) . '.xlsx';

                return Excel::download(new ClientesExport($clientes, $request), $filename);

            } catch (\Exception $e) {
                Log::error('Error al exportar clientes a Excel: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
                return response()->json(['message' => 'Error al exportar clientes: ' . $e->getMessage()], 500);
            }
        }
    }
