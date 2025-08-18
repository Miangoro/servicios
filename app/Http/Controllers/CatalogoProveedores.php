<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatalogoProveedor;
use App\Models\ProveedoresContactos;
use App\Models\RespuestasCerradas;
use App\Models\OpcionesModel;
use App\Models\EncuestasModel;
use App\Models\EvaluacionProveedor;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CatalogoProveedores extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sql = CatalogoProveedor::with(['contactos', 'evaluaciones'])
                ->orderBy('id_proveedor', 'desc')
                ->get();

            return DataTables::of($sql)
                ->addIndexColumn()
                ->addColumn('Datos Bancarios', function ($row) {
                    $banco = $row->n_banco ? "Nombre del banco: " . $row->n_banco : "Nombre del banco: Sin datos";
                    $clave = $row->clave ? "Clave interbancaria: " . $row->clave : "Clave interbancaria: Sin datos";
                    return $banco . "<br>" . $clave . "<br>";
                })
                ->addColumn('Contacto', function ($row) {
                    $contacto = $row->contactos->first();
                    if ($contacto) {
                        return 'Nombre: ' . e($contacto->contacto) . '<br>' .
                            'Teléfono: ' . e($contacto->telefono) . '<br>' .
                            'Email: ' . e($contacto->correo ?? 'N/A');
                    }
                    return 'Sin contacto registrado';
                })->addColumn('tipo', function ($row) {
                    if ($row->tipo === 1) {
                        return 'Producto';
                    } elseif ($row->tipo === 2) {
                        return 'Servicio';
                    } elseif ($row->tipo === 3) {
                        return 'Productos y Servicios';
                    }
                    return 'Sin tipo de compra';
                })
                ->addColumn('Evaluacion del Proveedor', function ($row) {
                    $ultimaEvaluacion = $row->evaluaciones->sortByDesc('fecha_evaluacion')->first();

                    if ($ultimaEvaluacion && $ultimaEvaluacion->p_nueve) {
                        $evaluacionTexto = $ultimaEvaluacion->p_nueve;
                        $claseCss = 'badge';

                        if (str_contains(strtolower($evaluacionTexto), 'confiable')) {
                            $claseCss .= ' bg-success';
                        } elseif (str_contains(strtolower($evaluacionTexto), 'medianamente')) {
                            $claseCss .= ' bg-warning text-dark';
                        } elseif (str_contains(strtolower($evaluacionTexto), 'no confiable')) {
                            $claseCss .= ' bg-danger';
                        } else {
                            $claseCss .= ' bg-secondary';
                        }

                        return "<span class=\"{$claseCss}\">{$evaluacionTexto}</span>";
                    }
                    return "Sin compras registradas";
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton_' . $row->id_proveedor . '">' .
                        '<li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="visualizar(' . $row->id_proveedor . ')">' .
                        '<i class="ri-search-fill ri-20px text-normal"></i> Visualizar' .
                        '</a>
                        </li>' .

                        '<li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="editProveedor(' . $row->id_proveedor . ')">' .
                        '<i class="ri-file-edit-fill ri-20px text-info"></i> Editar' .
                        '</a>
                        </li>

                        <li>
                                <a class="dropdown-item" href="' . route('proveedores.graficas', $row->id_proveedor) . '">' .
                        '<i class="ri-bar-chart-box-fill ri-20px text-primary"></i> Ver gráficas de evaluación' .
                        '</a>
                        </li>

                        <li>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="deleteProv(' . $row->id_proveedor . ')">' .
                        '<i class="ri-delete-bin-2-fill ri-20px text-danger"></i> Eliminar' .
                        '</a>
                        </li>'
                         .

                        '</ul>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['Datos Bancarios', 'Contacto', 'Evaluacion del Proveedor', 'action'])
                ->make(true);
        }

        return view('catalogo.find_catalogo_proveedores');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $urlAdjuntoPath = null;
            if ($request->hasFile('urlAdjunto')) {
                $urlAdjuntoPath = $request->file('urlAdjunto')->store(now(), 'public');
            }

            $proveedor = CatalogoProveedor::create([
                'razon_social' => $request->nombreProveedor,
                'direccion' => $request->direccionProveedor,
                'rfc' => $request->rfcProveedor,
                'd_bancarios' => "",
                'n_banco' => $request->nombreBanco,
                'clave' => $request->clabeInterbancaria,
                'tipo' => $request->selectTipoCompra,
                'url_adjunto' => $urlAdjuntoPath,
                'fecha_registro' => now(),
                'habilitado' => 1,
                'id_usuario' => Auth::id()
            ]);

            $this->storeContacts($request, $proveedor->id_proveedor);

            DB::commit();

            session()->flash('status', 'Proveedor y contactos guardados correctamente.');
            return response()->json(['message' => 'Proveedor y contactos agregados correctamente.'], 200);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al intentar agregar el proveedor o sus contactos. Detalles: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Almacena los contactos de un proveedor específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $proveedorId El ID del proveedor al que se asociarán los contactos.
     * @return void
     */
    protected function storeContacts(Request $request, $proveedorId)
    {
        $contactosData = $request->input('contactos', []);

        if (!empty($contactosData)) {
            $nuevosContactos = [];
            foreach ($contactosData as $index => $contactoItem) {
                // Verifica existencia de claves
                if (!isset($contactoItem['nombre'], $contactoItem['telefono'])) {
                    throw new \Exception("Falta el nombre o teléfono en el contacto en índice $index");
                }

                $nuevosContactos[] = [
                    'id_proveedor' => $proveedorId,
                    'contacto' => $contactoItem['nombre'],
                    'telefono' => $contactoItem['telefono'],
                    'correo' => $contactoItem['email'] ?? null,
                    'cargo' => "",
                    'fecha_registro' => now(),
                    'habilitado' => 1,
                    'id_usuario' => Auth::id()
                ];
            }

            ProveedoresContactos::insert($nuevosContactos);
        }
    }

    public function getProveedor($id)
    {
        try {
            $proveedor = CatalogoProveedor::with('contactos')->find($id);

            if (!$proveedor) {
                return response()->json(['error' => 'Proveedor no encontrado.'], 404);
            }

            return response()->json([
                'id_proveedor' => $proveedor->id_proveedor,
                'razon_social' => $proveedor->razon_social,
                'direccion' => $proveedor->direccion,
                'rfc' => $proveedor->rfc,
                'n_banco' => $proveedor->n_banco,
                'clave' => $proveedor->clave,
                'url_adjunto' => $proveedor->url_adjunto,
                'tipo' => $proveedor->tipo,
                'contactos' => $proveedor->contactos // Envía contactos
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el proveedor: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $proveedor = CatalogoProveedor::findOrFail($id);

            $proveedorData = [
                'razon_social' => $request->input('nombreProveedorEdit'),
                'direccion'    => $request->input('direccionProveedorEdit'),
                'rfc'          => $request->input('rfcProveedorEdit'),
                'n_banco'      => $request->input('nombreBancoEdit'),
                'clave'        => $request->input('clabeInterbancariaEdit'),
                'tipo'         => $request->input('selectTipoCompraEdit'),
                'id_usuario'   => Auth::id()
            ];

            // Manejar la subida del archivo (si se proporciona uno nuevo)
            if ($request->hasFile('urlAdjuntoEdit')) {
                // Eliminar el archivo antiguo para no acumular basura
                if ($proveedor->url_adjunto) {
                    Storage::disk('public')->delete($proveedor->url_adjunto);
                }
                $proveedorData['url_adjunto'] = $request->file('urlAdjuntoEdit')->store('proveedor_adjuntos', 'public');
            }

            $proveedor->update($proveedorData);

            // Eliminar contactos marcados
            if ($request->has('contactos_eliminados')) {
                ProveedoresContactos::whereIn('id_contacto', $request->input('contactos_eliminados'))->delete();
            }

            // Actualizar contactos existentes
            if ($request->has('contactos_edit')) {
                foreach ($request->input('contactos_edit') as $contactId => $contactData) {
                    $contacto = ProveedoresContactos::find($contactId);
                    if ($contacto) {
                        $contacto->update([
                            'contacto' => $contactData['nombre'],
                            'telefono' => $contactData['telefono'],
                            'correo'   => $contactData['email'] ?? null,
                        ]);
                    }
                }
            }

            // Crear contactos nuevos
            if ($request->has('contactos_nuevos')) {
                foreach ($request->input('contactos_nuevos') as $contactData) {
                    ProveedoresContactos::create([
                        'id_proveedor' => $proveedor->id_proveedor,
                        'contacto'     => $contactData['nombre'],
                        'telefono'     => $contactData['telefono'],
                        'correo'       => $contactData['email'] ?? null,
                        'cargo'        => '',
                        'fecha_registro' => now(),
                        'habilitado'   => 1,
                        'id_usuario'   => Auth::id()
                    ]);
                }
            }

            DB::commit();

            return response()->json(['message' => 'Proveedor actualizado correctamente.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al actualizar el proveedor.'], 500);
        }
    }

         public function destroy($id)
    {
        try {
            $proveedor = CatalogoProveedor::findOrFail($id);
            $proveedor->delete();

            return response()->json(['message' => 'Proveedor eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al intentar eliminar el proveedor: ' . $e->getMessage()], 500);
        }
    }

   public function graficas($id)
    {
        
        try {
            // Obtenemos las respuestas con sus relaciones anidadas
            $respuestas = RespuestasCerradas::where('id_evaluado', $id)
                ->with(['opcion.pregunta.encuesta'])
                ->get();
                Log::info('Respuestas crudas:', $respuestas->toArray());

            
            // Si no hay respuestas, retornamos la vista con un array vacío
            if ($respuestas->isEmpty()) {
                return view('catalogo.graficas_evaluaciones_proveedores', [
                    'datosGraficas' => [],
                    'id_evaluado' => $id
                ]);
            }
            
            // Filtramos las respuestas para asegurarnos de que tengan todas las relaciones
            $respuestasValidas = $respuestas->filter(function($respuesta) {
                return $respuesta->opcion && $respuesta->opcion->pregunta && $respuesta->opcion->pregunta->encuesta;
            });
            
            // Si después de filtrar no hay respuestas válidas, retornamos array vacío
            if ($respuestasValidas->isEmpty()) {
                 return view('catalogo.graficas_evaluaciones_proveedores', [
                    'datosGraficas' => [],
                    'id_evaluado' => $id
                ]);
            }
            
            // Agrupamos las respuestas válidas por el ID de la encuesta
            $respuestasPorEncuesta = $respuestasValidas->groupBy('opcion.pregunta.id_encuesta');

            $datosGraficas = [];
            foreach ($respuestasPorEncuesta as $id_encuesta => $respuestasDeEncuesta) {
                $nombre_encuesta = $respuestasDeEncuesta->first()->opcion->pregunta->encuesta->encuesta;
                
                $datosGraficas[$id_encuesta] = [
                    'nombre_encuesta' => $nombre_encuesta,
                    'preguntas' => []
                ];

                // Agrupamos las respuestas por pregunta dentro de cada encuesta
                $respuestasPorPregunta = $respuestasDeEncuesta->groupBy('opcion.pregunta.id_pregunta');

                foreach ($respuestasPorPregunta as $id_pregunta => $respuestasDePregunta) {
                    $pregunta = $respuestasDePregunta->first()->opcion->pregunta;
                    
                    $datosPregunta = [
                        'nombre_pregunta' => $pregunta->pregunta,
                        'id_pregunta' => $pregunta->id_pregunta,
                        'opciones' => []
                    ];

                    // Obtenemos las opciones de la pregunta
                    $opciones = OpcionesModel::where('id_pregunta', $id_pregunta)->get();

                    foreach ($opciones as $opcion) {
                        // Contamos las respuestas para esta opción específica y este evaluado
                        $conteo = RespuestasCerradas::where('id_evaluado', $id)
                            ->where('id_opcion', $opcion->id_opcion)
                            ->count();
                        
                        $datosPregunta['opciones'][] = [
                            'nombre_opcion' => $opcion->opcion,
                            'conteo' => $conteo
                        ];
                    }
                    
                    // Solo agregamos la pregunta si tiene al menos una respuesta
                    if (collect($datosPregunta['opciones'])->sum('conteo') > 0) {
                        $datosGraficas[$id_encuesta]['preguntas'][] = $datosPregunta;
                    }
                }
            }

            Log::info('Respuestas encontradas:', $datosGraficas);



            // Retornamos la vista con los datos preparados
            return view('catalogo.graficas_evaluaciones_proveedores', [
                'datosGraficas' => $datosGraficas,
                'id_evaluado' => $id
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las gráficas: ' . $e->getMessage()], 500);
        }
    }
}
