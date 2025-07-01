<?php

namespace App\Http\Controllers\hologramas;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\activarHologramasModelo;
use App\Models\empresa;
use App\Models\solicitudHolograma as ModelsSolicitudHolograma;
use App\Models\direcciones;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;
use App\Models\tipos;
use App\Models\categorias;
use App\Models\clases;
use App\Models\Documentacion_url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class solicitudHolograma extends Controller
{
    public function UserManagement()
    {
        $Empresa = Empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 5);
        })
            ->orderBy('id_inspeccion', 'desc')
            ->get();
        $categorias = categorias::all();
        $tipos = tipos::all();
        $clases = clases::all();

        $ModelsSolicitudHolograma = ModelsSolicitudHolograma::all();
        $userCount = $ModelsSolicitudHolograma->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('hologramas.find_solicitud_hologramas_view', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'Empresa' => $Empresa,
            'ModelsSolicitudHolograma' => $ModelsSolicitudHolograma,
            'inspeccion' => $inspeccion,
            'categorias' => $categorias,
            'tipos' => $tipos,
            'clases' => $clases,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_solicitud',
            2 => 'folio',
            3 => 'id_empresa',
            4 => 'id_solicitante',
            5 => 'id_marca',
            6 => 'cantidad_hologramas',
            7 => 'id_direccion',
            8 => 'comentarios',
            9 => 'tipo_pago',
            10 => 'fecha_envio',
            11 => 'costo_envio',
            12 => 'no_guia'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_solicitud';
        $dir = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');
        
        //Permiso de empresa
        $empresaId = null;
        if (Auth::check() && Auth::user()->tipo == 3) {
            $empresaId = Auth::user()->empresa?->id_empresa;
        }


        $query = ModelsSolicitudHolograma::with(['empresa.empresaNumClientes', 'user', 'marcas'])
        ->when($empresaId, function ($q) use ($empresaId) {
            $q->where('id_empresa', $empresaId);
        });
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('estatus', 'LIKE', "%{$searchValue}%")
                    ->orWhere('folio', 'LIKE', "%{$searchValue}%")
                    ->orWhere('id_empresa', 'LIKE', "%{$searchValue}%");

                $q->orWhereHas('empresa', function ($Nombre) use ($searchValue) {
                    $Nombre->where('razon_social', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('empresa.empresaNumClientes', function ($q) use ($searchValue) {
                    $q->where('numero_cliente', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('user', function ($Solicitante) use ($searchValue) {
                    $Solicitante->where('name', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('marcas', function ($Marca) use ($searchValue) {
                    $Marca->where('marca', 'LIKE', "%{$searchValue}%");
                });
            });
        }

        $totalData = ModelsSolicitudHolograma::when($empresaId, function ($q) use ($empresaId) {
            $q->where('id_empresa', $empresaId);
        })->count();
        $totalFiltered = $query->count();

        $users = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];

        if ($users->isNotEmpty()) {
            $ids = $start;

            foreach ($users as $user) {
                $numero_cliente = \App\Models\empresaNumCliente::where('id_empresa', $user->id_empresa)
                ->whereNotNull('numero_cliente')
                ->value('numero_cliente');


                $direccion = \App\Models\direcciones::where('id_direccion', $user->id_direccion)->value('direccion');
                $name = \App\Models\User::where('id', $user->id_solicitante)->value('name');

                $razon_social = $user->empresa ? $user->empresa->razon_social : '';

                // Concatenar razon_social y numero_cliente
                $razonSocialFormatted = '<b>' . $numero_cliente . '</b><br>' . $razon_social;

                $nestedData = [
                    'fake_id' => ++$ids,
                    'id_solicitud' => $user->id_solicitud,
                    'folio' => $user->folio,
                    'id_empresa' => $user->id_empresa,
                    'id_solicitante' => $name,
                    'id_marca' => $user->marcas->marca ?? '',
                    'cantidad_hologramas' => $user->cantidad_hologramas,
                    'id_direccion' => $direccion,
                    'comentarios' => $user->comentarios,
                    'tipo_pago' => $user->tipo_pago,
                    'fecha_envio' => $user->fecha_envio,
                    'costo_envio' => $user->costo_envio,
                    'no_guia' => $user->no_guia,
                    'estatus' => $user->estatus,
                    'folio_inicial' => '<a target="_blank" href="' . url('/holograma/'.$numero_cliente.'-'.$user->tipo.$user->marcas->folio.str_pad($user->folio_inicial, 7, '0', STR_PAD_LEFT)) . '">' . $numero_cliente.'-'.$user->tipo.$user->marcas->folio.str_pad($user->folio_inicial, 7, '0', STR_PAD_LEFT) . '</a>',

                    'folio_final' => '<a target="_Blank" href="'.url('/holograma/'.$numero_cliente.'-'.$user->tipo.$user->marcas->folio.str_pad($user->folio_final, 7, '0', STR_PAD_LEFT)).'">'.$numero_cliente.'-'.$user->tipo.$user->marcas->folio.str_pad($user->folio_final, 7, '0', STR_PAD_LEFT).'</a>',
                    'activados' => $user->cantidadActivados($user->id_solicitud),
                    'restantes' => max(0, ($user->cantidad_hologramas - $user->cantidadActivados($user->id_solicitud) - $user->cantidadMermas($user->id_solicitud))),
                    'mermas' => $user->cantidadMermas($user->id_solicitud),
                    'razon_social' => $razonSocialFormatted, // Aquí asignamos la clave correctamente
                    'razon_social_pdf' => $user->empresa ? $user->empresa->razon_social : '',
                ];
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

    //Metodo para eliminar
    public function destroy($id_solicitud)
    {
        $clase = ModelsSolicitudHolograma::findOrFail($id_solicitud);
        $clase->delete();
        return response()->json(['success' => 'Clase eliminada correctamente']);
    }

    //Metodo para registrar
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        // Validar los datos recibidos del formulario
        $request->validate([
            'id_empresa' => 'required|integer',
            'id_marca' => 'required|integer',
            'tipo' => 'required|in:A,J',
            'cantidad_hologramas' => 'required|integer',
            'id_direccion' => 'required|integer',
            'comentarios' => 'nullable|string|max:1000',
        ]);
        // Obtener el último folio_final registrado con la misma id_empresa e id_marca
        $ultimoFolio = ModelsSolicitudHolograma::where('id_empresa', $request->id_empresa)
            ->where('id_marca', $request->id_marca)
            ->where('tipo',$request->tipo)
            ->orderBy('folio_final', 'desc')
            ->value('folio_final');
        // Si existe un registro previo, usar su folio_final + 1 como el nuevo folio_inicial, de lo contrario iniciar en 1
        $folioInicial = $ultimoFolio ? $ultimoFolio + 1 : 1;


        // Obtener el último run_folio creado
        $ultimoFolio = \App\Models\solicitudHolograma::latest('folio')->first();
        // Extraer el número del último run_folio y calcular el siguiente número
        if ($ultimoFolio) {
            $ultimoNumero = intval(substr($ultimoFolio->folio, 4, 6)); // Extrae 000001 de SOL-GUIA-000001/24
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        $anoActual = Carbon::now()->now()->year;
        // Formatear el nuevo run_folio
        $nuevoFolio = sprintf('INV-%06d-%d', $nuevoNumero, $anoActual);
        // Crear una nueva instancia del modelo Hologramas
        $holograma = new ModelsSolicitudHolograma();
        $holograma->folio = $nuevoFolio;
        $holograma->id_empresa = $request->id_empresa;
        $holograma->id_marca = $request->id_marca;
        $holograma->tipo = $request->tipo;
        $holograma->id_solicitante = Auth::user()->id; // Obtiene el ID del usuario actual
        $holograma->cantidad_hologramas = $request->cantidad_hologramas;
        $holograma->id_direccion = $request->id_direccion;
        $holograma->comentarios = $request->comentarios;
        $holograma->folio_inicial = $folioInicial;
        // Calcular el folio final
        $holograma->folio_final = $folioInicial + $request->cantidad_hologramas - 1;
        // Guardar el nuevo registro en la base de datos
        $holograma->save();
        // Retornar una respuesta JSON indicando éxito
        return response()->json(['success' => 'Solicitud de Hologramas registrada correctamente']);
    }

    // Método para obtener una guía por ID
    public function edit($id_solicitud)
    {
        try {
            $holograma = ModelsSolicitudHolograma::findOrFail($id_solicitud);
            return response()->json($holograma);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la guía'], 500);
        }
    }

    // Método para actualizar un registro existente
    public function update(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));
            // Actualiza los campos con los datos del formulario
            $holograma->folio = $request->input('edit_folio');
            $holograma->id_empresa = $request->input('edit_id_empresa');
            $holograma->id_marca = $request->input('edit_id_marca');
            $holograma->tipo = $request->tipo;
            $holograma->id_solicitante = Auth::user()->id; // Actualiza el ID del solicitante con el ID del usuario actual
            $holograma->cantidad_hologramas = $request->input('edit_cantidad_hologramas');
            $holograma->id_direccion = $request->input('edit_id_direccion');
            $holograma->comentarios = $request->input('edit_comentarios');
            // Solo modificar el folio_final si el folio_inicial es 1

                // Si no es el primer registro, recalcular folio_inicial y folio_final basado en el último registro de la misma empresa y marca
                $ultimoFolio = ModelsSolicitudHolograma::where('id_empresa', $request->input('edit_id_empresa'))
                    ->where('id_marca', $request->input('edit_id_marca'))
                    ->where('id_solicitud', '!=', $holograma->id_solicitud) // Excluir el registro actual
                    ->where('tipo',$request->tipo)
                    ->orderBy('folio_final', 'desc') // Ordenar por el folio_final más alto
                    ->value('folio_final'); // Obtener el valor del folio_final más alto
                // Si existe un registro previo, usar su folio_final + 1 como el nuevo folio_inicial

                $folioInicial = $ultimoFolio ? $ultimoFolio + 1 : 1;
                $holograma->folio_inicial = $folioInicial;
                $holograma->folio_final = $folioInicial + $request->input('edit_cantidad_hologramas') - 1;

            // Guarda los cambios en la base de datos
            $holograma->save();
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud'], 500);
        }
    }



    //Metodo apra Actualizar y Editar PAGO
    public function update2(Request $request) //Este es para adjuntar comprobante de pago
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));
            $holograma->tipo_pago = $request->input('tipo_pago'); // Nuevo campo tipo_pago
            $holograma->estatus = 'Pagado';

            $holograma->save();

            // Metodo para guardar el archivo PDF
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

            foreach ($request->id_documento as $index => $id_documento) {
                if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                    $file = $request->file('url')[$index];
                    $extension = $file->getClientOriginalExtension();
                    $filename = "Comprobante_de_pago" . '.' . $extension; // Nombre del archivo con extensión
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                    // Guarda la información del archivo en la base de datos
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $holograma->id_solicitud;
                    $documentacion_url->id_documento = $id_documento;
                    $documentacion_url->nombre_documento = 'Comprobante de pago'; // Nombre del archivo
                    $documentacion_url->url = $filename; // Solo el nombre del archivo
                    $documentacion_url->id_empresa = $request->empresa;
                    $documentacion_url->save();
                }
            }

            return response()->json(['success' => 'Solicitud de pago actualizada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la solicitud de pago'], 500);
        }
    }


    //Metodo apra Actualizar y Editar Guia
    public function update3(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));
            $holograma->fecha_envio = $request->input('fecha_envio');
            $holograma->costo_envio = $request->input('costo_envio');
            $holograma->no_guia = $request->input('no_guia');
            $holograma->estatus = 'Enviado';


            $holograma->save();
            //metodo para guardar pdf
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                return !empty($numero);
            });

          /*  foreach ($request->id_documento as $index => $id_documento) {
                // Agregar nuevo documento si no existe
                if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                    $file = $request->file('url')[$index];
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $holograma->id_solicitud;
                    $documentacion_url->id_documento = $id_documento;
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $request->empresa;
                    $documentacion_url->save();
                }
            }*/
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud de envio actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envio'], 500);
        }
    }


    public function updateAsignar(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));
            $holograma->folio_inicial = $request->input('asig_folio_inicial');
            $holograma->folio_final = $request->input('asig_folio_final');
            $holograma->estatus = 'Asignado';


            $holograma->save();
            //metodo para guardar pdf

            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud de envio actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envio'], 500);
        }
    }


    //METODO NO USADO POR EL MOMENTO DE RECEPCION
    /*     public function updateRecepcion(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));

            $holograma->estatus = 'Completado';


            $holograma->save();
            //metodo para guardar pdf

            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });



            foreach ($request->id_documento as $index => $id_documento) {
                // Agregar nuevo documento si no existe
                if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                    $file = $request->file('url')[$index];
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $holograma->id_solicitud;
                    $documentacion_url->id_documento = $id_documento;
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $request->empresa;
                    $documentacion_url->save();
                }
            }
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud de envio actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envio'], 500);
        }
    } */

    //Metodo para cargar el pdf
    public function ModelsSolicitudHolograma($id)
    {
        // Cargar la solicitud de holograma con la relación de la empresa
        $datos = ModelsSolicitudHolograma::with('empresa', 'direcciones', 'user', 'empresanumcliente')->findOrFail($id);

        // Pasar los datos a la vista del PDF
        $pdf = Pdf::loadView('pdfs.solicitudDeHologramas', ['datos' => $datos]);

        // Generar y devolver el PDF
        return $pdf->stream($datos->folio.'.pdf');
    }


    //Ver activos
    public function editActivos($id)
    {
        try {
            // Obtener los registros con un join para traer el num_servicio de inspecciones
            $activaciones = activarHologramasModelo::where('activar_hologramas.id_solicitud', $id)
                ->join('inspecciones', 'activar_hologramas.id_inspeccion', '=', 'inspecciones.id_inspeccion')
                ->select('activar_hologramas.*', 'inspecciones.num_servicio')
                ->get();

            // Decodificar el JSON de los folios en cada registro
            $activaciones->transform(function ($item) {
                $folios = json_decode($item->folios, true); // Decodifica el JSON
                $item->folio_inicial = $folios['folio_inicial'] ?? null;
                $item->folio_final = $folios['folio_final'] ?? null;
                $mermas = json_decode($item->mermas, true); // Decodifica el JSON
                $item->mermas = $mermas['mermas'] ?? null;




                return $item;
            });

            return response()->json($activaciones);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las activaciones'], 500);
        }
    }


    //Editar activos
    public function editActivados($id)
    {
        try {
            // Obtener el registro
            $activo = activarHologramasModelo::find($id);
            // Decodificar el JSON de los folios
            $folios = json_decode($activo->folios, true);
            // Añadir los valores de folio inicial y folio final
            $activo->folio_inicial = $folios['folio_inicial'] ?? null;
            $activo->folio_final = $folios['folio_final'] ?? null;
            $mermas = json_decode($activo->mermas, true);
            $activo->mermas = $mermas['mermas'] ?? null;

            return response()->json($activo); // Devolver el registro con los datos decodificados
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los hologramas activos'], 500);
        }
    }



    //Actualizar activos
    public function updateActivar(Request $request)
    {
        // Buscar el registro existente usando el ID
        try {
            $loteEnvasado = activarHologramasModelo::findOrFail($request->input('id'));
            $loteEnvasado->folio_activacion = $request->folio_activacion;
            $loteEnvasado->id_solicitud = $request->edit_id_solicitud;
            $loteEnvasado->id_inspeccion = $request->edit_id_inspeccion;
            $loteEnvasado->no_lote_agranel = $request->edit_no_lote_agranel;
            $loteEnvasado->categoria = $request->edit_categoria;
            $loteEnvasado->no_analisis = $request->edit_no_analisis;
            $loteEnvasado->cont_neto = $request->edit_cont_neto;
            $loteEnvasado->unidad = $request->edit_unidad;
            $loteEnvasado->clase = $request->edit_clase;
            $loteEnvasado->contenido = $request->edit_contenido;
            $loteEnvasado->no_lote_envasado = $request->edit_no_lote_envasado;
            $loteEnvasado->id_tipo = $request->edit_id_tipo;
            $loteEnvasado->lugar_produccion = $request->edit_lugar_produccion;
            $loteEnvasado->lugar_envasado = $request->edit_lugar_envasado;
            // Actualizar los rangos de folios
            $loteEnvasado->folios = json_encode([
                'folio_inicial' => $request->edit_rango_inicial,
                'folio_final' => $request->edit_rango_final, // Puedes agregar otros valores también
            ]);
            $loteEnvasado->mermas = json_encode([
                'mermas' => $request->edit_mermas,
            ]);
            // Guardar los cambios en la base de datos
            $loteEnvasado->save();

            return response()->json(['success' => 'Hologramas activos actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar los hologramas activos'], 500);
        }
    }





}
