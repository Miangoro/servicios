<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Predios;
use App\Models\empresa;
use App\Models\tipos;
use App\Models\PredioCoordenadas;
use App\Models\predio_plantacion;
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\Predios_Inspeccion;
use App\Models\estados;
use App\Models\solicitudesModel;
use App\Models\inspecciones;
use App\Models\PrediosCaracteristicasMaguey;
use App\Notifications\GeneralNotification;
use App\Models\User;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;



class PrediosController extends Controller
{public function UserManagement()
{
    $empresaId = null;

    if (auth()->user()->tipo == 3) {
        $empresaId = auth()->user()->empresa?->id_empresa;
    }

    // Filtrar predios si el usuario es tipo 3
    $prediosQuery = Predios::with('empresa');

    if ($empresaId) {
        $prediosQuery->where('id_empresa', $empresaId);
    }

    $predios = $prediosQuery->get();

    // Filtrar empresas
    $empresasQuery = empresa::where('tipo', 2);

    if ($empresaId) {
        $empresasQuery->where('id_empresa', $empresaId);
    }

    $empresas = $empresasQuery->get();

    $tipos = tipos::all();
    $estados = estados::all();

    return view('domicilios.find_domicilio_predios_view', [
        'predios' => $predios,
        'empresas' => $empresas,
        'tipos' => $tipos,
        'estados' => $estados,
    ]);
}


    public function index(Request $request)
    {
        $columns = [
            1 => 'id_predio',
            2 => 'id_empresa',
            3 => 'num_predio',
            4 => 'nombre_predio',
            5 => 'ubicacion_predio',
            6 => 'tipo_predio',
            7 => 'puntos_referencia',
            8 => 'cuenta_con_coordenadas',
            9 => 'superficie',
            10 => 'estatus'
        ];

        $search = [];

        if (auth()->user()->tipo == 3) {
            $empresaId = auth()->user()->empresa?->id_empresa;
        } else {
            $empresaId = null;
        }


        // Obtener el total de registros filtrados
        $totalData = Predios::whereHas('empresa', function ($query)  use ($empresaId) {
            $query->where('tipo', 2);
                        if ($empresaId) {
                $query->where('id_empresa', $empresaId);
            }
        })->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id_predio';
        $dir = $request->input('order.0.dir') ?? 'asc';

        if (empty($request->input('search.value'))) {
            $predios = Predios::with('empresa') // Carga la relación
                ->whereHas('empresa', function ($query) use ($empresaId){
                    $query->where('tipo', 2);
                                        if ($empresaId) {
                            $query->where('id_empresa', $empresaId);
                        }
                })
                ->offset($start)
                ->limit($limit)
                ->orderByDesc('id_predio')

                ->get();
        } else {
            $search = $request->input('search.value');

            $predios = Predios::with('empresa')
                ->whereHas('empresa', function ($query) use($empresaId) {
                    $query->where('tipo', 2);
                    if ($empresaId) {
                        $query->where('id_empresa', $empresaId);
                    }
                })
                ->where(function ($query) use ($search) {
                    $query->whereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('empresa.empresaNumClientes', function ($subQuery) use ($search) {
                        $subQuery->where('numero_cliente', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('solicitudes', function ($q) use ($search) {
                        $q->where('folio', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('solicitudes.inspeccion', function ($q) use ($search) {
                        $q->where('num_servicio', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('num_predio', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_predio', 'LIKE', "%{$search}%")
                    ->orWhere('ubicacion_predio', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_predio', 'LIKE', "%{$search}%")
                    ->orWhere('puntos_referencia', 'LIKE', "%{$search}%")
                    ->orWhere('superficie', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderByDesc('id_predio')

                ->get();

            $totalFiltered = Predios::with('empresa')
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })
                ->where(function ($query) use ($search) {
                    $query->whereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('empresa.empresaNumClientes', function ($subQuery) use ($search) {
                        $subQuery->where('numero_cliente', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('solicitudes', function ($q) use ($search) {
                        $q->where('folio', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('solicitudes.inspeccion', function ($q) use ($search) {
                        $q->where('num_servicio', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('num_predio', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_predio', 'LIKE', "%{$search}%")
                    ->orWhere('ubicacion_predio', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_predio', 'LIKE', "%{$search}%")
                    ->orWhere('puntos_referencia', 'LIKE', "%{$search}%")
                    ->orWhere('superficie', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];

        if (!empty($predios)) {
            $ids = $start;

            foreach ($predios as $predio) {

              $hasSolicitud = $predio->solicitudes()->exists();
              $solicitud = $predio->solicitudes()->first();

                $nestedData['id_predio'] = $predio->id_predio;
                $nestedData['fake_id'] = ++$ids;
                $razonSocial = $predio->empresa ? $predio->empresa->razon_social : '';
                $numeroCliente =
                $predio->empresa->empresaNumClientes[0]->numero_cliente ??
                $predio->empresa->empresaNumClientes[1]->numero_cliente ??
                $predio->empresa->empresaNumClientes[2]->numero_cliente;

                $nestedData['id_empresa'] = '<b>'.$numeroCliente . '</b><br>' . $razonSocial;
                $nestedData['num_predio'] = $predio->num_predio ?? '';
                $nestedData['nombre_predio'] = $predio->nombre_predio;
                $nestedData['ubicacion_predio'] = $predio->ubicacion_predio ?? 'N/A';
                $nestedData['tipo_predio'] = $predio->tipo_predio;
                $nestedData['puntos_referencia'] = $predio->puntos_referencia  ?? 'N/A';
                $nestedData['cuenta_con_coordenadas'] = $predio->cuenta_con_coordenadas  ?? 'N/A';
                $nestedData['superficie'] = $predio->superficie;
                $nestedData['estatus']=$predio->estatus;
                $nestedData['hasSolicitud'] = $hasSolicitud;
                $nestedData['id_solicitud'] = $predio->solicitudes()->first()->id_solicitud ?? null;
                $nestedData['folio_solicitud'] = $predio->solicitudes()->first()->folio ?? null;
                $nestedData['num_servicio'] = $solicitud?->inspeccion?->num_servicio ?? 'Sin asignar';
                /* ACTAS INSPECCION */
                $documentoActaInspeccion = null;
                $urlActaInspeccion = null;

                if ($solicitud) {
                    $documentoActaInspeccion = DB::table('documentacion_url')
                        ->where('id_relacion', $solicitud->id_solicitud)
                        ->where('id_documento', 69)
                        ->first();

                    if ($documentoActaInspeccion && $numeroCliente) {
                        $urlActaInspeccion = asset('storage/uploads/' . $numeroCliente . '/actas/' . $documentoActaInspeccion->url);
                    }
                }

                $nestedData['url_acta_inspeccion'] = $urlActaInspeccion;
                /*  */

                $inspeccion = DB::table('predios_inspeccion')
                    ->where('id_predio', $predio->id_predio)
                    ->first();

                $documentoGeo = null;
                if ($inspeccion) {
                    $documentoGeo = DB::table('documentacion_url')
                        ->where('id_relacion', $inspeccion->id_inspeccion)
                        ->where('id_documento', 136)
                        ->first();
                }

                $urlDocumento = null;
                if ($documentoGeo && $numeroCliente) {
                    $urlDocumento = asset('storage/uploads/' . $numeroCliente . '/' . $documentoGeo->url);
                }
                $nestedData['url_documento_geo'] = $urlDocumento;
                  /* documento de registro predio */
                $documentoRegistroPredio = DB::table('documentacion_url')
              ->where('id_relacion', $predio->id_predio)
              ->where('id_documento', 137)
              ->first();
              $urlDocumentoRegistroPredio = null;
              if ($documentoRegistroPredio && $numeroCliente) {
                  $urlDocumentoRegistroPredio = asset('storage/uploads/' . $numeroCliente . '/' . $documentoRegistroPredio->url);
              }
              $nestedData['url_documento_registro_predio'] = $urlDocumentoRegistroPredio ?? null;

                $data[] = $nestedData;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }


        // Función para eliminar un predio
        public function destroy($id_predio)
        {
            try {
                $predio = Predios::findOrFail($id_predio);
                $predio->delete();

                return response()->json(['success' => 'Predio eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al eliminar el predio: ' . $e->getMessage()], 500);
            }
        }


        public function store(Request $request)
        {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'id_empresa' => 'required|exists:empresa,id_empresa',
                'nombre_productor' => 'required|string|max:70',
                'nombre_predio' => 'required|string',
                'ubicacion_predio' => 'nullable|string',
                'tipo_predio' => 'required|string',
                'puntos_referencia' => 'required|string',
                'tiene_coordenadas' => 'nullable|string|max:2',
                'superficie' => 'required|string',
                'url' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'id_documento' => 'required|integer',
                'nombre_documento' => 'required|string|max:255'
            ]);

            // Crear una nueva instancia del modelo Predios
            $predio = new Predios();
            $predio->id_empresa = $validatedData['id_empresa'];
            $predio->nombre_productor = $validatedData['nombre_productor'];
            $predio->nombre_predio = $validatedData['nombre_predio'];
            $predio->ubicacion_predio = $validatedData['ubicacion_predio'];
            $predio->tipo_predio = $validatedData['tipo_predio'];
            $predio->puntos_referencia = $validatedData['puntos_referencia'];
            $predio->cuenta_con_coordenadas = $validatedData['tiene_coordenadas'];
            $predio->superficie = $validatedData['superficie'];

            // Guardar el nuevo predio en la base de datos
            $predio->save();

            // Solo guardar coordenadas si tiene_coordenadas es 'Si'
            if ($validatedData['tiene_coordenadas'] === 'Si') {
              if ($request->has('latitud') && $request->has('longitud')) {
                  foreach ($request->latitud as $index => $latitud) {
                      if (!is_null($latitud) && !is_null($request->longitud[$index])) {
                          PredioCoordenadas::create([
                              'id_predio' => $predio->id_predio,
                              'latitud' => $latitud,
                              'longitud' => $request->longitud[$index],
                          ]);
                      }
                  }
              }
          }
            // Almacenar los datos de plantación en la tabla predio_plantacion, si existen
            if ($request->has('id_tipo')) {
                foreach ($request->id_tipo as $index => $id_tipo) {
                    if (!is_null($id_tipo) && !is_null($request->numero_plantas[$index]) && !is_null($request->edad_plantacion[$index]) && !is_null($request->tipo_plantacion[$index])) {
                        predio_plantacion::create([
                            'id_predio' => $predio->id_predio,
                            'id_tipo' => $id_tipo,
                            'num_plantas' => $request->numero_plantas[$index],
                            'anio_plantacion' => $request->edad_plantacion[$index],
                            'tipo_plantacion' => $request->tipo_plantacion[$index],
                        ]);
                    }
                }
            }

            // Obtener el número del cliente desde la tabla empresa_num_cliente
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $validatedData['id_empresa'])->first();
            $empresaNumCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            // Almacenar el documento si se envía
            if ($request->hasFile('url')) {
                $file = $request->file('url');

                // Generar un nombre único para el archivo
                $uniqueId = uniqid(); // Genera un identificador único
                $filename = $validatedData['nombre_documento'] . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();

                // Ruta de la subcarpeta usando numero_cliente
                $directory = $empresaNumCliente;

                // Verificar y crear la carpeta si no existe
                $path = storage_path('app/public/uploads/' . $directory);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Guardar el archivo en la subcarpeta
                $filePath = $file->storeAs($directory, $filename, 'public_uploads'); // Aquí se guarda en la ruta definida storage/public/uploads

                // Extraer solo el nombre del archivo para guardar en la base de datos
                $fileNameOnly = basename($filePath);

                // Crear una nueva instancia de Documentacion_url
                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_empresa = $validatedData['id_empresa'];
                $documentacion_url->url = $fileNameOnly; // Almacena solo el nombre del archivo
                $documentacion_url->id_relacion = $predio->id_predio; // Aquí puedes ajustar si es necesario
                $documentacion_url->id_documento = $validatedData['id_documento'];
                $documentacion_url->nombre_documento = $validatedData['nombre_documento'];

                $documentacion_url->save();
            }
            $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

            $data1 = [
                'title' => 'Nuevo registro de predio',
                'message' => 'Se ha registrado un nuevo predio: ' . $predio->nombre_predio . '.',
                'url' => 'predios-historial',
            ];
            foreach ($users as $user) {
              $user->notify(new GeneralNotification($data1));
          }


            // Retornar una respuesta
            return response()->json([
                'success' => true,
                'message' => 'Predio registrado exitosamente',
            ]);
        }





        public function edit($id_predio)
        {
            try {
                $predio = Predios::with(['coordenadas', 'predio_plantaciones', 'documentos'])->findOrFail($id_predio);
                $tipos = tipos::all();

                // Obtener el número del cliente
                $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $predio->id_empresa)->first();
                    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                        return !empty($numero);
                    });

                // Filtrar documentos para obtener solo el documento con id_documento igual a 34
                $documentos = $predio->documentos->filter(function ($documento) {
                    return $documento->id_documento == 34;
                })->map(function ($documento) {
                    return [
                        'nombre' => $documento->nombre_documento,
                        'url' => $documento->url // Solo nombre del archivo
                    ];
                });

              $documento = Documentacion_url::where('id_relacion', $id_predio)
                  ->where('id_documento', 137)
                  ->first();

                $urlDocumento = null;
                if ($documento && $numeroCliente) {
                    $urlDocumento = url("storage/uploads/{$numeroCliente}/" . $documento->url);
                }

                return response()->json([
                    'success' => true,
                    'predio' => $predio,
                    'coordenadas' => $predio->coordenadas,
                    'plantaciones' => $predio->predio_plantaciones,
                    'tipos' => $tipos,
                    'documentos' => $documentos,
                    'documento' => $documento, // Incluye el documento específico
                    'url_documento' => $urlDocumento, // URL del documento
                    'numeroCliente' => $numeroCliente // Incluye el número del cliente
                ]);
            } catch (ModelNotFoundException $e) {
                return response()->json(['success' => false], 404);
            }
        }

        public function update(Request $request, $id_predio)
        {
            try {


                // Validar los datos del formulario
                $validated = $request->validate([
                    'id_empresa' => 'required|exists:empresa,id_empresa',
                    'nombre_productor' => 'required|string|max:70',
                    'nombre_predio' => 'required|string',
                    'ubicacion_predio' => 'nullable|string',
                    'tipo_predio' => 'required|string',
                    'puntos_referencia' => 'required|string',
                    'tiene_coordenadas' => 'nullable|string|max:2',
                    'superficie' => 'required|string',
                    'latitud' => 'nullable|array',
                    'latitud.*' => 'nullable|numeric',
                    'longitud' => 'nullable|array',
                    'longitud.*' => 'nullable|numeric',
                    'id_tipo' => 'nullable|array',
                    'id_tipo.*' => 'required|exists:catalogo_tipo_agave,id_tipo',
                    'numero_plantas' => 'required|array',
                    'numero_plantas.*' => 'required|numeric',
                    'edad_plantacion' => 'required|array',
                    'edad_plantacion.*' => 'required|numeric',
                    'tipo_plantacion' => 'required|array',
                    'tipo_plantacion.*' => 'required|string',
                    'url' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                    'id_documento' => 'required|integer',
                    'nombre_documento' => 'required|string|max:255'
                ]);

                $predio = Predios::findOrFail($id_predio);

                // Obtener el documento actual
                $documentacion_url = Documentacion_url::where('id_relacion', $predio->id_predio)
                    ->where('id_documento', $validated['id_documento'])
                    ->first();

                $oldFileName = $documentacion_url ? $documentacion_url->url : null;

                // Si se carga un nuevo archivo
                if ($request->hasFile('url')) {
                    $file = $request->file('url');

                    // Generar un nombre único para el archivo
                    $uniqueId = uniqid();
                    $filename = $validated['nombre_documento'] . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();

                    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $validated['id_empresa'])->first();
                    $empresaNumCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                        return !empty($numero);
                    });
                    $directory = $empresaNumCliente;


                    // Guardar el nuevo archivo
                    $filePath = $file->storeAs($directory, $filename, 'public_uploads');

                    // Actualizar el registro en la base de datos
                    if ($documentacion_url) {
                        $documentacion_url->url = basename($filePath);
                        $documentacion_url->nombre_documento = $validated['nombre_documento'];
                        $documentacion_url->save();
                    } else {
                        // Si no existe registro, crear uno nuevo
                        Documentacion_url::create([
                            'id_empresa' => $validated['id_empresa'],
                            'url' => basename($filePath),
                            'id_relacion' => $predio->id_predio,
                            'id_documento' => $validated['id_documento'],
                            'nombre_documento' => $validated['nombre_documento'],
                        ]);
                    }

                    // Eliminar el archivo anterior
                    if ($oldFileName) {
                        $oldFilePath = storage_path('app/public/uploads/' . $empresaNumCliente . '/' . $oldFileName);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                }


                // Actualizar los demás datos del predio
                $predio->update([
                    'id_empresa' => $validated['id_empresa'],
                    'nombre_productor' => $validated['nombre_productor'],
                    'nombre_predio' => $validated['nombre_predio'],
                    'ubicacion_predio' => $validated['ubicacion_predio'],
                    'tipo_predio' => $validated['tipo_predio'],
                    'puntos_referencia' => $validated['puntos_referencia'],
                    'cuenta_con_coordenadas' => $validated['tiene_coordenadas'],
                    'superficie' => $validated['superficie'],
                ]);

                // Manejar coordenadas
                if ($validated['tiene_coordenadas'] == 'Si') {
                    // Eliminar coordenadas antiguas
                    $predio->coordenadas()->delete();

                    // Agregar nuevas coordenadas
                    if (!empty($validated['latitud']) && !empty($validated['longitud'])) {
                        foreach ($validated['latitud'] as $index => $latitud) {
                            $predio->coordenadas()->create([
                                'latitud' => $latitud,
                                'longitud' => $validated['longitud'][$index],
                            ]);
                        }
                    }
                } else {
                    // Si no se tienen coordenadas, elimina las coordenadas existentes
                    $predio->coordenadas()->delete();
                }

                // Manejar plantaciones
                // Manejar plantaciones
                if (!empty($validated['id_tipo'])) {
                    // Eliminar plantaciones antiguas
                    $predio->predio_plantaciones()->delete();

                    // Agregar nuevas plantaciones
                    foreach ($validated['id_tipo'] as $index => $tipo) {
                        // Asegúrate de que todos los datos necesarios estén presentes
                        $numeroPlantas = isset($validated['numero_plantas'][$index]) ? $validated['numero_plantas'][$index] : null;
                        $edadPlantacion = isset($validated['edad_plantacion'][$index]) ? $validated['edad_plantacion'][$index] : null;
                        $tipoPlantacion = isset($validated['tipo_plantacion'][$index]) ? $validated['tipo_plantacion'][$index] : null;

                        // Asegúrate de que el campo 'numero_plantas' sea manejado adecuadamente
                        $predio->predio_plantaciones()->create([
                            'id_tipo' => $tipo,
                            'num_plantas' => $numeroPlantas,
                            'anio_plantacion' => $edadPlantacion,
                            'tipo_plantacion' => $tipoPlantacion,
                        ]);
                    }
                } else {
                    // Si no se tienen plantaciones, elimina las plantaciones existentes
                    $predio->predio_plantaciones()->delete();
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Predio actualizado exitosamente',
                ]);
            } catch (\Exception $e) {
                Log::error('Error al actualizar el predio: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el predio: ' . $e->getMessage(),
                ], 500);
            }
        }

    public function editInspeccion($id_predio) {
        $inspeccion = Predios_Inspeccion::with('predio.empresa.empresaNumClientes')
            ->where('id_predio', $id_predio)
            ->first();

        if (!$inspeccion) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró inspección para este predio.',
            ]);
        }

        $documentacion = DB::table('documentacion_url')
            ->where('id_relacion', $inspeccion->id_inspeccion)
            ->where('id_documento', 136) // Cambiar según el tipo documento
            ->first();

        $numeroCliente = $inspeccion->predio->empresa->empresaNumClientes[0]->numero_cliente ?? null;

        $urlDocumento = null;
        if ($documentacion && $numeroCliente) {
            $urlDocumento = url("storage/uploads/{$numeroCliente}/" . $documentacion->url);
        }

        return response()->json([
            'success' => true,
            'data' => $inspeccion,
            'document_url' => $urlDocumento,
        ]);
    }




        public function PdfPreRegistroPredios($id_predio)
        {

            $datos = Predios::with([
                'predio_plantaciones.tipo',
                'solicitudes.inspeccion',
                'empresa.empresaNumClientes' => function ($query) {
                    $query->whereNotNull('numero_cliente')->where('numero_cliente', '!=', '');
                }
            ])->find($id_predio);

            $comunal = '___';
            $ejidal = '___';
            $propiedad = '___';
            $otro = '___';

            switch ($datos->tipo_predio) {
                case 'Comunal':
                    $comunal = 'X';
                    break;
                case 'Ejidal':
                    $ejidal = 'X';
                    break;
                case 'Propiedad privada':
                    $propiedad = 'X';
                    break;
                case 'Otro':
                    $otro = 'X';
                    break;
            }


            $pdf = Pdf::loadView('pdfs.Pre-registro_predios', ['datos'=>$datos, 'comunal' => $comunal, 'ejidal' => $ejidal, 'propiedad' => $propiedad, 'otro' => $otro]);
            return $pdf->stream('F-UV-21-01 Pre-registro de predios de maguey o agave Ed.1 Vigente.pdf');
        }

    /* Registro de predio inspección */
    public function inspeccion(Request $request, $id_predio)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'ubicacion_predio' => 'required|string|max:255',
            'localidad' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'distrito' => 'required|string|max:255',
            'estado' => 'required|exists:estados,id',
            'nombre_paraje' => 'required|string|max:255',
            'zona_dom' => 'required|string|in:si,no',
            'id_empresa' => 'required|exists:empresa,id_empresa', // Asegúrate de validar id_empresa
        ]);

        // Crear una nueva instancia del modelo Predios_Inspeccion
        $inspeccion = new Predios_Inspeccion();
        $inspeccion->id_predio = $id_predio;
        $inspeccion->ubicacion_predio = $validatedData['ubicacion_predio'];
        $inspeccion->localidad = $validatedData['localidad'];
        $inspeccion->municipio = $validatedData['municipio'];
        $inspeccion->distrito = $validatedData['distrito'];
        $inspeccion->id_estado = $validatedData['estado'];
        $inspeccion->nombre_paraje = $validatedData['nombre_paraje'];
        $inspeccion->zona_dom = $validatedData['zona_dom'];

        // Guardar el nuevo registro de inspección en la base de datos
        $inspeccion->save();

        // Recuperar el predio
        $predio = Predios::findOrFail($id_predio);

        // Cambiar el estatus a 'Inspeccionado'
        $predio->estatus = 'Inspeccionado';

        // Guardar los cambios en el predio
        $predio->save();

        // Obtener el número del cliente
      $empresaNumCliente = DB::table('empresa_num_cliente')
          ->where('id_empresa', $validatedData['id_empresa'])
          ->whereNotNull('numero_cliente')
          ->value('numero_cliente');


        if (!$empresaNumCliente) {
            return response()->json([
                'success' => false,
                'message' => 'Número de cliente no encontrado para el ID de empresa proporcionado.',
            ], 404);
        }

        // Obtener el nombre del documento donde id_documento es 70
        $nombreDocumento = DB::table('documentacion')
            ->where('id_documento', 136)
            ->value('nombre');

        if (!$nombreDocumento) {
            return response()->json([
                'success' => false,
                'message' => 'Nombre del documento no encontrado para el ID de documento 136.',
            ], 404);
        }

          if ($request->hasFile('inspeccion_geo_Doc') && $request->file('inspeccion_geo_Doc')->isValid()) {
          $file = $request->file('inspeccion_geo_Doc');

          // Generar nombre único para el archivo
          $uniqueId = uniqid();
          $filename = 'inspeccion_geo_referenciacion ' . $uniqueId . '.' . $file->getClientOriginalExtension();

          // Directorio: número de cliente
          $directory = $empresaNumCliente;
          $path = storage_path('app/public/uploads/' . $directory);

          // Crear carpeta si no existe
          if (!file_exists($path)) {
              mkdir($path, 0777, true);
          }

          // Guardar archivo
          $filePath = $file->storeAs('uploads/' . $directory, $filename, 'public');

          // Guardar en la tabla documentacion_url
          $documentacionUrl = new Documentacion_url();
          $documentacionUrl->id_empresa = $validatedData['id_empresa'];
          $documentacionUrl->url = $filename; // Aquí va la ruta del archivo
          $documentacionUrl->id_relacion = $inspeccion->id_inspeccion; // Asegúrate que exista esta variable
          $documentacionUrl->nombre_documento = $nombreDocumento; // Obtenido previamente (documento 135)
          $documentacionUrl->id_documento = 136;
          $documentacionUrl->save();
      }

        // Notificación y retorno de respuesta
        $predio = Predios::find($id_predio);
        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        $data1 = [
            'title' => 'Nuevo registro de inspección de predio',
            'message' => 'Se ha registrado una nueva inspección en el predio: ' . $predio->nombre_predio . ', con la orden de servicio ' . $inspeccion->no_orden_servicio,
            'url' => 'inspecciones-historial',
        ];

        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }

        // Retornar una respuesta exitosa
        return response()->json([
            'success' => true,
            'message' => 'Inspección registrada exitosamente.',
        ]);
    }

        public function inspeccion_update(Request $request, $id_predio)
        {
            $validatedData = $request->validate([
                'ubicacion_predio' => 'required|string|max:255',
                'localidad' => 'required|string|max:255',
                'municipio' => 'required|string|max:255',
                'distrito' => 'required|string|max:255',
                'estado' => 'required|exists:estados,id',
                'nombre_paraje' => 'required|string|max:255',
                'zona_dom' => 'required|string|in:si,no',
                'id_empresa' => 'required|exists:empresa,id_empresa',
            ]);

            $inspeccion = Predios_Inspeccion::where('id_predio', $id_predio)->first();

            if (!$inspeccion) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró inspección para este predio.',
                ], 404);
            }

            $inspeccion->ubicacion_predio = $validatedData['ubicacion_predio'];
            $inspeccion->localidad = $validatedData['localidad'];
            $inspeccion->municipio = $validatedData['municipio'];
            $inspeccion->distrito = $validatedData['distrito'];
            $inspeccion->id_estado = $validatedData['estado'];
            $inspeccion->nombre_paraje = $validatedData['nombre_paraje'];
            $inspeccion->zona_dom = $validatedData['zona_dom'];
            $inspeccion->save();

            $predio = Predios::findOrFail($id_predio);
            $predio->estatus = 'Inspeccionado';
            $predio->save();

            $empresaNumCliente = DB::table('empresa_num_cliente')
                ->where('id_empresa', $validatedData['id_empresa'])
                ->whereNotNull('numero_cliente')
                ->value('numero_cliente');

            if (!$empresaNumCliente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Número de cliente no encontrado.',
                ], 404);
            }

            $nombreDocumento = DB::table('documentacion')
                ->where('id_documento', 136)
                ->value('nombre');

            if (!$nombreDocumento) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nombre del documento no encontrado.',
                ], 404);
            }

            // 🧠 SOLO si se sube un nuevo archivo
            if ($request->hasFile('inspeccion_geo_Doc') && $request->file('inspeccion_geo_Doc')->isValid()) {
                $file = $request->file('inspeccion_geo_Doc');

                // Buscar el documento actual (si existe)
                $documentacionUrl = Documentacion_url::where('id_relacion', $inspeccion->id_inspeccion)
                    ->where('id_documento', 136)
                    ->first();

                $directory = $empresaNumCliente;
                $storageDisk = 'public';

                // Si ya existe un archivo, eliminarlo del disco
                if ($documentacionUrl && $documentacionUrl->url) {
                    Storage::disk($storageDisk)->delete('uploads/' . $directory . '/' . $documentacionUrl->url);
                }

                // Subir el nuevo archivo
                $uniqueId = uniqid();
                $filename = 'inspeccion_geo_referenciacion ' . $uniqueId . '.' . $file->getClientOriginalExtension();
                $file->storeAs('uploads/' . $directory, $filename, $storageDisk);

                // Si ya existía el registro: actualizarlo
                if ($documentacionUrl) {
                    $documentacionUrl->url = $filename;
                    $documentacionUrl->save();
                } else {
                    // Si no existía: crear uno nuevo
                    Documentacion_url::create([
                        'id_empresa' => $validatedData['id_empresa'],
                        'url' => $filename,
                        'id_relacion' => $inspeccion->id_inspeccion,
                        'nombre_documento' => $nombreDocumento,
                        'id_documento' => 136,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Inspección actualizada correctamente.',
            ]);
        }




    public function PDFInspeccionGeoreferenciacion($id_predio) {
      // Obtener la primera (y única) inspección relacionada con el predio
      $inspeccion = Predios_Inspeccion::where('id_predio', $id_predio)->first();

/*       if (!$inspeccion) {
          // Manejo de errores si no se encuentra la inspección
          return response()->json(['error' => 'No se encontró la inspección para este predio.'], 404);
      } */
      $predio = Predios::with(['empresa', 'empresa.empresaNumClientes'])->find($id_predio);

      // Obtener la solicitud relacionada a partir del id_predio
     // $solicitud = solicitudesModel::where('id_predio', $id_predio)->first();
      // Obtener la inspección relacionada a partir del id_solicitud de la solicitud
    //  $inspeccionData = inspecciones::where('id_solicitud', $solicitud->id_solicitud)->first();

      // Obtener todas las coordenadas relacionadas con la inspección
      $coordenadas = PredioCoordenadas::where('id_predio', $id_predio)->get();
      $caracteristicas = PrediosCaracteristicasMaguey::where('id_inspeccion', $inspeccion->id_inspeccion)->get();
      $plantacion = predio_plantacion::where('id_predio', $id_predio)->get();

      // Cargar la vista PDF con la inspección y las coordenadas
      $pdf = Pdf::loadView('pdfs.inspeccion_geo_referenciacion', [
          'inspeccion' => $inspeccion,
          'solicitud' => 'pendiente', // Pasar la solicitud
          'inspeccionData' => 'pendiente', // Pasar la inspección relacionada
          'coordenadas' => $coordenadas,
          'caracteristicas' => $caracteristicas,
          'plantacion' => $plantacion,
          'predio' => $predio,
              ]);

      // Generar y retornar el PDF
      return $pdf->stream('Registro de Predios Maguey Agave.pdf');
  }


    public function PDFRegistroPredios($id_predio) {
      $inspeccion = Predios_Inspeccion::where('id_predio', $id_predio)->first();
      $predio = Predios::with(['empresa', 'empresa.empresaNumClientes'])->find($id_predio);
      $vigencia = Helpers::formatearFecha($inspeccion->predio->fecha_vigencia);
      $emision = Helpers::formatearFecha($inspeccion->predio->fecha_emision);
    // Obtener la solicitud relacionada a partir del id_predio
    $solicitud = solicitudesModel::where('id_predio', $id_predio)->first();
    // Obtener la inspección relacionada a partir del id_solicitud de la solicitud
    //$inspeccionData = inspecciones::where('id_solicitud', $solicitud->id_solicitud)->first();

    // Obtener todas las coordenadas relacionadas con la inspección
    $coordenadas = PredioCoordenadas::where('id_predio', $id_predio)->get();
    $caracteristicas = PrediosCaracteristicasMaguey::where('id_inspeccion', $inspeccion->id_inspeccion)->get();
    $plantacion = predio_plantacion::where('id_predio', $id_predio)->get();

      $pdf = Pdf::loadView('pdfs.Registro_de_Predios_Maguey_Agave' , [
          'inspeccion' => $inspeccion,
          'vigencia' => $vigencia,
          'emision' => $emision,
          'inspeccionData' => '', // Pasar la inspección relacionada
          'predio' => $predio,
          'solicitud' => $solicitud, // Pasar la solicitud
          'coordenadas' => $coordenadas,
          'caracteristicas' => $caracteristicas,
          'plantacion' => $plantacion,
      ] );
      return $pdf->stream('F-UV-21-03 Registro de predios de maguey o agave Ed. 4 Vigente.pdf');
    }

public function registroPredio(Request $request, $id_predio)
{
    try {
        $validated = $request->validate([
            'num_predio' => 'required|string',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'fuv2103' => 'nullable|file|mimes:pdf,jpg,png|max:10240'
        ]);

        $predio = Predios::findOrFail($id_predio);
        $id_empresa = $predio->id_empresa;

        // Actualizar predio
        $predio->update([
            'num_predio' => $validated['num_predio'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'estatus' => 'Vigente'
        ]);

        // Obtener número de cliente
        $empresaNumCliente = DB::table('empresa_num_cliente')
            ->where('id_empresa', $id_empresa)
            ->whereNotNull('numero_cliente')
            ->value('numero_cliente');

        if (!$empresaNumCliente) {
            return response()->json([
                'success' => false,
                'message' => 'Número de cliente no encontrado.',
            ], 404);
        }

        // Obtener nombre del documento
        $nombreDocumento = DB::table('documentacion')
            ->where('id_documento', 137)
            ->value('nombre');

        if (!$nombreDocumento) {
            return response()->json([
                'success' => false,
                'message' => 'Nombre del documento no encontrado.',
            ], 404);
        }

        // Guardar archivo si viene
        if ($request->hasFile('fuv2103')) {
            $file = $request->file('fuv2103');
            $nombreArchivo = 'registro_predio_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $rutaCarpeta = 'public/uploads/' . $empresaNumCliente;

            $file->storeAs($rutaCarpeta, $nombreArchivo);

            // Registrar en documentacion_url
            Documentacion_url::create([
                'id_documento' => 137,
                'nombre_documento' => $nombreDocumento,
                'id_empresa' => $id_empresa,
                'url' => $nombreArchivo,
                'id_relacion' => $predio->id_predio,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Predio registrado correctamente.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}


  public function editRegistroPredio(Request $request, $id_predio)
  {
      try {
          // Validar los datos principales
          $validated = $request->validate([
              'num_predio' => 'required|string',
              'fecha_emision' => 'required|date',
              'fecha_vigencia' => 'required|date',
              'fuv2103' => 'nullable|file|mimes:pdf,jpg,png|max:10240'
          ]);

          $predio = Predios::findOrFail($id_predio);
          $id_empresa = $predio->id_empresa;

          // Actualizar datos del predio
          $predio->update([
              'num_predio' => $validated['num_predio'],
              'fecha_emision' => $validated['fecha_emision'],
              'fecha_vigencia' => $validated['fecha_vigencia'],
          ]);

          // Solo si se sube un archivo nuevo
          if ($request->hasFile('fuv2103')) {
              // Buscar documento anterior
              $documentoAnterior = Documentacion_url::where('id_documento', 137)
                  ->where('id_relacion', $predio->id_predio)
                  ->first();

              // Eliminar el archivo anterior si existe
              if ($documentoAnterior) {
                  $rutaAnterior = 'public/uploads/' . $documentoAnterior->id_empresa . '/' . $documentoAnterior->url;
                  if (Storage::exists($rutaAnterior)) {
                      Storage::delete($rutaAnterior);
                  }

                  // Eliminar el registro de la base de datos
                  $documentoAnterior->delete();
              }

              // Obtener número de cliente desde la tabla intermedia
              $numeroCliente = DB::table('empresa_num_cliente')
                  ->where('id_empresa', $id_empresa)
                  ->whereNotNull('numero_cliente')
                  ->value('numero_cliente');

              if (!$numeroCliente) {
                  return response()->json([
                      'success' => false,
                      'message' => 'Número de cliente no encontrado.',
                  ], 404);
              }

              // Obtener nombre del documento
              $nombreDocumento = DB::table('documentacion')
                  ->where('id_documento', 137)
                  ->value('nombre') ?? 'Registro de predios de maguey o agave';

              // Guardar el nuevo archivo
              $file = $request->file('fuv2103');
              $nombreArchivo = 'registro_predio_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
              $rutaCarpeta = 'public/uploads/' . $numeroCliente; // ajusta si usas relación directa
              $file->storeAs($rutaCarpeta, $nombreArchivo);

              // Guardar nuevo registro
              Documentacion_url::create([
                  'id_documento' => 137,
                  'nombre_documento' => $nombreDocumento,
                  'url' => $nombreArchivo,
                  'id_relacion' => $predio->id_predio,
                  'id_empresa' => $id_empresa,
              ]);
          }

          return response()->json([
              'success' => true,
              'message' => 'Predio actualizado correctamente.',
          ]);

      } catch (\Exception $e) {
          return response()->json([
              'success' => false,
              'message' => $e->getMessage(),
          ], 500);
      }
  }


  public function pdf_solicitud_servicios_070($id_predio)
  {
      // Busca la solicitud que tiene el id_predio proporcionado
    $datos = solicitudesModel::where('id_predio', $id_predio)->first();
       // Inicializa las variables con un valor vacío
    $muestreo_agave = '------------';
    $vigilancia_produccion = '------------';
    $muestreo_granel= '------------';
    $vigilancia_traslado= '------------';
    $inspeccion_envasado= '------------';
    $muestreo_envasado= '------------';
    $ingreso_barrica= '------------';
    $liberacion= '------------';
    $liberacion_barrica= '------------';
    $geo= '------------';
    $exportacion= '------------';
    $certificado_granel= '------------';
    $certificado_nacional= '------------';
    $dictaminacion = '------------';
    $renovacion_dictaminacion = '------------';
    // Verificar el valor de id_tipo y marcar la opción correspondiente
    if ($datos->id_tipo == 1) {
        $muestreo_agave = 'X';
    }
    if ($datos->id_tipo == 2) {
        $vigilancia_produccion = 'X';
    }
    if ($datos->id_tipo == 3) {
        $muestreo_granel= 'X';
    }
    if ($datos->id_tipo == 4) {
        $vigilancia_traslado= 'X';
    }
    if ($datos->id_tipo == 5) {
        $inspeccion_envasado= 'X';
    }
    if ($datos->id_tipo == 6) {
        $muestreo_envasado= 'X';
    }
    if ($datos->id_tipo == 7) {
        $ingreso_barrica= 'X';
    }
    if ($datos->id_tipo == 8) {
        $liberacion= 'X';
    }
    if ($datos->id_tipo == 9) {
        $liberacion_barrica= 'X';
    }
    if ($datos->id_tipo == 10) {
        $geo= 'X';
    }
    if ($datos->id_tipo == 11) {
        $exportacion= 'X';
    }
    if ($datos->id_tipo == 12) {
        $certificado_granel= 'X';
    }
    if ($datos->id_tipo == 13) {
        $certificado_nacional= 'X';
    }
    if ($datos->id_tipo == 14) {
        $dictaminacion = 'X';
    }
    if ($datos->id_tipo == 15) {
        $renovacion_dictaminacion = 'X';
    }
        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio', compact('datos','muestreo_agave','vigilancia_produccion','dictaminacion','muestreo_granel',
        'vigilancia_traslado','inspeccion_envasado','muestreo_envasado','ingreso_barrica','liberacion','liberacion_barrica','geo','exportacion','certificado_granel','certificado_nacional','dictaminacion','renovacion_dictaminacion'))
        ->setPaper([0, 0, 640, 830]); ;
        return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
    }




}
