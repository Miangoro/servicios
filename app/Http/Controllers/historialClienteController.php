<?php

namespace App\Http\Controllers;

use App\Models\empresas_clientes;
use App\Models\clientes_contacto;
use App\Models\CatalogoRegimen;
use App\Models\catalogos_regimenes;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class historialClienteController extends Controller
{
    /**
     * Muestra el formulario de edición para una empresa específica dentro de una modal.
     * Retorna la vista parcial del formulario HTML pre-rellenada.
     */
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

    /**
     * Muestra el formulario de visualización (solo lectura) para una empresa específica dentro de una modal.
     * Retorna la vista parcial del formulario HTML pre-rellenada en modo 'view'.
     */
    public function viewModal($id) // Nuevo método para visualización
    {
        try {
            $empresa = empresas_clientes::with('clientesContactos')->findOrFail($id);
            $regimenes = catalogos_regimenes::all();

            // Pasa la empresa y los regímenes a la nueva vista de visualización
            return view('_partials._modals.modal-add-visualizar-Historial', compact('empresa', 'regimenes'));
        } catch (\Exception $e) {
            Log::error('Error al cargar modal de visualización de empresa: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['error' => 'No se pudo cargar la empresa para visualizar: ' . $e->getMessage()], 404);
        }
    }

    /**
     * Muestra la vista con opciones para exportar los datos de clientes/empresas.
     * Esta vista puede contener filtros, botones para diferentes formatos (Excel, PDF, etc.).
     *
     * @return \Illuminate\View\View
     */
    public function exportView()
    {
        // Se ha actualizado el nombre de la vista según tu indicación
        return view('_partials._modals.modal-add-export_clientes_empresas');
    }

    /**
     * Almacena una nueva empresa en la base de datos.
     */
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

    /**
     * Actualiza los datos de la empresa en la base de datos.
     */
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
                            'status' => $contactData['status'] ?? 0,
                            'observaciones' => $contactData['observaciones'] ?? null,
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

    /**
     * Elimina una empresa de la base de datos.
     */
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

    /**
     * Obtiene los datos de las empresas para DataTables.
     */
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
                    $btn = '
                        <div class="d-flex align-items-center gap-50">
                            <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id . '">'.
                                '<li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="viewUnidad('.$row->id.')">
                                    <i class="ri-search-line ri-20px text-secondary"></i>Visualizar
                                    </a>
                                </li>'.
                                '<li>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="editUnidad('.$row->id.')">
                                    <i class="ri-edit-box-line ri-20px text-info"></i>Editar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteUnidad(' . $row->id . ')">'.
                                        '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar </a>'.
                                    '</a>
                                </li>'
                            .'</ul>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['constancia', 'action'])
                ->make(true);
        }

        $totalClientes = empresas_clientes::count();
        $regimenes = catalogos_regimenes::all();

        return view('clientes.find_clientes_empresas_view', compact('regimenes', 'totalClientes'));
    }

    /**
     * Obtiene el conteo total de empresas registradas.
     * Este método será llamado vía AJAX para actualizar el contador en tiempo real.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countCompanies()
    {
        try {
            $total = empresas_clientes::count();
            return response()->json(['total' => $total]);
        } catch (\Exception $e) {
            Log::error('Error al obtener el conteo de empresas: ' . $e->getMessage() . ' en ' . $e->getFile() . ' línea ' . $e->getLine());
            return response()->json(['error' => 'No se pudo obtener el conteo de empresas'], 500);
        }
    }
}