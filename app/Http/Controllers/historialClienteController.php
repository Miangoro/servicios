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
    /**
     * Obtiene el ID del régimen de 'Personas Físicas con Actividades Empresariales y Profesionales'
     * o similares.
     *
     * @return int|null
     */
    private function getPersonasFisicasId(): ?int
    {
        return catalogos_regimenes::where('regimen', 'LIKE', '%Personas Físicas con Actividades Empresariales y Profesionales%')
            ->orWhere('regimen', 'LIKE', '%Personas Fisicas con Actividades Empresariales y Profesionales%')
            ->value('id');
    }

    /**
     * Obtiene y formatea las estadísticas del dashboard.
     *
     * @return array
     */
    private function getDashboardStats(): array
    {
        $clientesActivos = empresas_clientes::whereNull('estado_cliente')->count();
        $clientesInactivos = empresas_clientes::where('estado_cliente', 0)->count();

        $idRegimenPF = $this->getPersonasFisicasId();

        $personasFisicas = 0;
        if ($idRegimenPF) {
            $personasFisicas = empresas_clientes::where('regimen', $idRegimenPF)
                ->whereNull('estado_cliente')
                ->count();
        } else {
            $personasFisicas = empresas_clientes::whereNull('estado_cliente')
                ->whereHas('catalogoRegimen', function ($query) {
                    $query->where('regimen', 'LIKE', '%Personas Físicas con Actividades Empresariales%');
                })
                ->count();
        }

        $otrosRegimenes = $clientesActivos - $personasFisicas;
        $total = $clientesActivos + $clientesInactivos;
        $porcentajeActivos = ($total > 0) ? ($clientesActivos / $total * 100) : 0;

        return [
            'clientesActivos' => $clientesActivos,
            'clientesInactivos' => $clientesInactivos,
            'personasFisicas' => $personasFisicas,
            'otrosRegimenes' => $otrosRegimenes,
            'total' => $total,
            'porcentajeActivos' => number_format($porcentajeActivos, 1)
        ];
    }

    /**
     * Muestra el modal de edición para una empresa específica.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function editModal(int $id)
    {
        try {
            $empresa = empresas_clientes::with('clientesContactos')->findOrFail($id);
            $regimenes = catalogos_regimenes::all();
            
            // Se pasa la variable `$regimenes` a la vista
            return view('_partials._modals.modal-add-edit-Historial', compact('empresa', 'regimenes'));
        } catch (\Exception $e) {
            Log::error('Error al cargar modal de edición de empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['error' => 'No se pudo cargar la empresa para editar: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Muestra el modal de visualización para una empresa específica.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function viewModal(int $id)
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

    /**
     * Muestra la vista para el modal de exportación.
     * Esta función ahora solo es llamada desde index o mediante AJAX.
     *
     * @return \Illuminate\View\View
     */
    public function exportView()
    {
        $empresas = empresas_clientes::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        $regimenes = catalogos_regimenes::all();
        
        return view('_partials._modals.modal-add-export_clientes_empresas', compact('regimenes', 'empresas'));
    }

    /**
     * Obtiene una lista de clientes para ser utilizada en select boxes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getClientes(): \Illuminate\Http\JsonResponse
    {
        $clientes = empresas_clientes::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return response()->json($clientes);
    }

    /**
     * Almacena una nueva empresa en la base de datos con un código secuencial.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
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
            
            // Asignar los datos validados al modelo, excepto los que se manejan por separado
            $empresa->fill(Arr::except($validatedData, ['constancia', 'contactos']));
            $empresa->noext = $validatedData['no_exterior'];
            $empresa->tipo = 0;
            $empresa->estado_cliente = null;
            $empresa->codigo = ''; // Temporalmente vacío para poder generar el ID

            if ($request->hasFile('constancia')) {
                $path = $request->file('constancia')->store(date('Y/m/d'), 'public');
                $empresa->constancia = $path;
                Log::info('PDF subido. Ruta guardada en DB: ' . $path);
            } else {
                $empresa->constancia = null;
            }

            $empresa->save();

            // Generar el código basado en el ID y guardar la empresa de nuevo
            $empresa->codigo = 'CC' . $empresa->id;
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

            $stats = $this->getDashboardStats();

            return response()->json([
                'message' => 'Empresa registrada con éxito.', 
                'empresa' => $empresa,
                'stats' => $stats
            ], 201);
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

    /**
     * Obtiene estadísticas de clientes para las tarjetas del dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function estadisticas(): \Illuminate\Http\JsonResponse
    {
        try {
            $stats = $this->getDashboardStats();
            return response()->json(array_merge(['success' => true], $stats));
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de clientes: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => $e->getMessage(),
                'clientesActivos' => 0,
                'clientesInactivos' => 0,
                'personasFisicas' => 0,
                'otrosRegimenes' => 0,
                'total' => 0,
                'porcentajeActivos' => '0.0'
            ], 500);
        }
    }

    /**
     * Actualiza una empresa existente.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
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
            
            // Asignar los datos validados al modelo, excepto los archivos y contactos
            $empresa->fill(Arr::except($validatedData, ['constancia', 'contactos', 'motivo_edicion']));
            $empresa->noext = $validatedData['no_exterior'];
            
            if ($request->hasFile('constancia')) {
                if ($empresa->constancia && Storage::disk('public')->exists($empresa->constancia)) {
                    Storage::disk('public')->delete($empresa->constancia);
                    Log::info('PDF anterior eliminado: ' . $empresa->constancia);
                }
                $path = $request->file('constancia')->store(date('Y/m/d'), 'public');
                $empresa->constancia = $path;
                Log::info('PDF actualizado. Nueva ruta guardada en DB: ' . $path);
            } elseif ($request->input('constancia_cleared')) {
                if ($empresa->constancia && Storage::disk('public')->exists($empresa->constancia)) {
                    Storage::disk('public')->delete($empresa->constancia);
                    Log::info('PDF existente eliminado por solicitud del usuario.');
                }
                $empresa->constancia = null;
            }

            $empresa->save();

            // Sincroniza los contactos existentes con los nuevos.
            $existingContactIds = $empresa->clientesContactos->pluck('id')->toArray();
            $newContactIds = [];

            if ($request->has('contactos') && is_array($request->input('contactos'))) {
                foreach ($request->input('contactos') as $contactData) {
                    if (!empty($contactData['contacto']) || !empty($contactData['celular']) || !empty($contactData['correo'])) {
                        // Si el contacto ya tiene un ID, lo actualiza. De lo contrario, lo crea.
                        if (isset($contactData['id']) && in_array($contactData['id'], $existingContactIds)) {
                            $contacto = clientes_contacto::findOrFail($contactData['id']);
                            $contacto->update([
                                'nombre_contacto' => $contactData['contacto'] ?? null,
                                'telefono_contacto' => $contactData['celular'] ?? null,
                                'correo_contacto' => $contactData['correo'] ?? '',
                                'status' => $contactData['status'] ?? 1,
                                'observaciones' => $contactData['observaciones'] ?? null,
                            ]);
                            $newContactIds[] = $contacto->id;
                        } else {
                            $contacto = clientes_contacto::create([
                                'cliente_id' => $empresa->id,
                                'nombre_contacto' => $contactData['contacto'] ?? null,
                                'telefono_contacto' => $contactData['celular'] ?? null,
                                'correo_contacto' => $contactData['correo'] ?? '',
                                'status' => 1,
                                'observaciones' => null,
                            ]);
                            $newContactIds[] = $contacto->id;
                        }
                    }
                }
            }

            // Elimina los contactos que ya no están en la lista de la solicitud.
            $contactsToDelete = array_diff($existingContactIds, $newContactIds);
            clientes_contacto::destroy($contactsToDelete);

            Log::info('Empresa ' . $empresa->id . ' actualizada. Motivo: ' . ($request->input('motivo_edicion') ?? 'No especificado'));

            $stats = $this->getDashboardStats();

            return response()->json([
                'message' => 'Empresa actualizada con éxito.', 
                'empresa' => $empresa,
                'stats' => $stats
            ]);
        } catch (ValidationException $e) {
            Log::error('Error de validación al actualizar empresa ' . $id . '. Motivo: ' . ($request->input('motivo_edicion') ?? 'No especificado') . '. Errores: ' . json_encode($e->errors()));
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al actualizar empresa: . ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error interno del servidor al actualizar la empresa: ' . $e->getMessage()], 500);
        }
    }
        
    /**
     * Cambia el estado de una empresa a 'dada de baja' (estado_cliente = 0).
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function darDeBaja(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $empresa = empresas_clientes::findOrFail($id);
            $empresa->estado_cliente = 0; 
            $empresa->save();

            Log::info('Empresa ' . $empresa->id . ' ha sido dada de baja.');
            
            $stats = $this->getDashboardStats();

            return response()->json([
                'message' => 'Empresa dada de baja con éxito.',
                'stats' => $stats
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Empresa no encontrada para dar de baja: ' . $id);
            return response()->json(['message' => 'Empresa no encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Error al dar de baja la empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error al dar de baja la empresa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Cambia el estado de una empresa a 'dada de alta' (estado_cliente = NULL).
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function darDeAlta(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $empresa = empresas_clientes::findOrFail($id);
            $empresa->estado_cliente = null;
            $empresa->save();

            Log::info('Empresa ' . $empresa->id . ' ha sido dada de alta.');

            $stats = $this->getDashboardStats();

            return response()->json([
                'message' => 'Empresa dada de alta con éxito.',
                'stats' => $stats
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Empresa no encontrada para dar de alta: . ' . $id);
            return response()->json(['message' => 'Empresa no encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Error al dar de alta la empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error al dar de alta la empresa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Elimina una empresa y sus contactos asociados.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $empresa = empresas_clientes::findOrFail($id);
            if ($empresa->constancia && Storage::disk('public')->exists($empresa->constancia)) {
                Storage::disk('public')->delete($empresa->constancia);
                Log::info('PDF eliminado al borrar empresa: ' . $empresa->constancia);
            }

            $empresa->clientesContactos()->delete();
            $empresa->delete();

            $stats = $this->getDashboardStats();

            return response()->json([
                'message' => 'Empresa eliminada con éxito.',
                'stats' => $stats
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Empresa no encontrada para eliminar: ' . $id);
            return response()->json(['message' => 'Empresa no encontrada.'], 404);
        } catch (\Exception $e) {
            Log::error('Error al eliminar empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['message' => 'Error al eliminar la empresa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Procesa la tabla de datos para la vista.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql = empresas_clientes::query();
            return DataTables::of($sql)->addIndexColumn()
                ->addColumn('constancia', function ($row) {
                    if (!empty($row->constancia) && str_ends_with($row->constancia, '.pdf')) {
                        return Storage::url($row->constancia);
                    }
                    return null;
                })
                ->addColumn('action', function ($row) {
                    if ($row->estado_cliente === 0) {
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
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="viewUnidad(' . $row->id . ')">
                                            <i class="ri-search-line ri-20px text-secondary"></i>Visualizar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="editUnidad(' . $row->id . ')">
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
        
        // Obtiene todas las empresas, regímenes y estadísticas para pasarlas a la vista.
        $stats = $this->getDashboardStats();
        $regimenes = catalogos_regimenes::all();
        $empresas = empresas_clientes::select('id', 'nombre')->orderBy('nombre', 'asc')->get();

        // Combina los datos y los pasa a la vista principal.
        return view('clientes.find_clientes_empresas_view', array_merge(compact('regimenes', 'empresas'), $stats));
    }

    /**
     * Obtiene el conteo y porcentajes de los tipos de empresas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countCompanies(): \Illuminate\Http\JsonResponse
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

    /**
     * Exporta clientes a un archivo Excel con filtros.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function exportExcel(Request $request)
    {
        try {
            Log::info('Solicitud de exportación recibida:', $request->all());
            $query = empresas_clientes::query()->with('catalogoRegimen');
                                                
            $filtrosAplicados = [];
            
            if ($request->filled('empresa_id') && $request->input('empresa_id') !== 'todos') {
                $query->where('id', $request->input('empresa_id'));
                $empresa = empresas_clientes::find($request->input('empresa_id'));
                if ($empresa) {
                    $filtrosAplicados[] = "Empresa: " . $empresa->nombre;
                }
            }
            if ($request->boolean('enableFiltroRegimen') && $request->filled('regimen_fiscal') && $request->input('regimen_fiscal') !== 'todos') {
                $query->where('regimen', $request->input('regimen_fiscal'));
                $regimen = catalogos_regimenes::find($request->input('regimen_fiscal'));
                if ($regimen) {
                    $filtrosAplicados[] = "Régimen: " . $regimen->regimen;
                }
            }
            if ($request->boolean('enableFiltroCredito') && $request->filled('credito') && $request->input('credito') !== 'todos') {
                $creditoValue = $request->input('credito');
                if ($creditoValue === 'con_credito') {
                    $query->where('credito', 'Con Crédito');
                    $filtrosAplicados[] = "Crédito: Con Crédito";
                } elseif ($creditoValue === 'sin_credito') {
                    $query->whereIn('credito', ['Sin crédito', '0']);
                    $filtrosAplicados[] = "Crédito: Sin Crédito";
                }
            }
            $dateParts = [];
            if ($request->filled('dia') && $request->input('dia') !== 'todos') {
                $query->whereDay('created_at', $request->input('dia'));
                $dateParts[] = $request->input('dia');
            }
            if ($request->filled('mes') && $request->input('mes') !== 'todos') {
                $query->whereMonth('created_at', $request->input('mes'));
                $dateParts[] = $request->input('mes');
            }
            if ($request->filled('anio') && $request->input('anio') !== 'todos') {
                $query->whereYear('created_at', $request->input('anio'));
                $dateParts[] = $request->input('anio');
            }
            if (!empty($dateParts)) {
                $filtrosAplicados[] = "Fecha de registro: " . implode('-', $dateParts);
            }
            $clientes = $query->get();
            if ($clientes->isEmpty()) {
                $errorMessage = 'No se encontraron empresas con los filtros aplicados: ' . implode(', ', $filtrosAplicados);
                return redirect()->back()->with('error', $errorMessage);
            }
            $filename = 'clientes_export';
            if (!empty($filtrosAplicados)) {
                $filename .= '_' . str_replace([' ', ':'], ['_', ''], implode('_', $filtrosAplicados));
            }
            $filename .= '.xlsx';
            return Excel::download(new ClientesExport($clientes, $request), $filename);
        } catch (\Exception $e) {
            Log::error('Error al exportar clientes a Excel: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return redirect()->back()->with('error', 'Error al exportar clientes: ' . $e->getMessage());
        }
    }

    /**
     * Obtiene el listado de clientes inactivos para la tabla de datos.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerInactivos(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->ajax()) {
            $sql = empresas_clientes::where('estado_cliente', 0);
            return DataTables::of($sql)->addIndexColumn()
                ->addColumn('constancia', function ($row) {
                    if (!empty($row->constancia) && str_ends_with($row->constancia, '.pdf')) {
                        return Storage::url($row->constancia);
                    }
                    return null;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<span class="badge bg-danger-light text-danger">Dado de baja</span>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success-light" onclick="darDeAltaUnidad(' . $row->id . ')">
                                        <i class="ri-check-line me-1"></i>
                                        Dar de alta
                                    </button>
                                </div>';
                    return $btn;
                })
                ->rawColumns(['constancia', 'action'])
                ->make(true);
        }
        return response()->json(['error' => 'Solicitud no válida'], 400);
    }
}