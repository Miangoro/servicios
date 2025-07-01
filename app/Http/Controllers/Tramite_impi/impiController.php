<?php

namespace App\Http\Controllers\Tramite_impi;

use App\Http\Controllers\Controller;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Notifications\GeneralNotification;
use App\Models\Impi;
use App\Models\empresa;
use App\Models\Impi_evento;


class impiController extends Controller
{

    public function UserManagement()
    {
      $tramites = Impi::all();
      $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
      $evento = Impi_evento::all();
      return view('Tramite_impi.find_impi', compact('tramites', 'empresas'));
    }

    // Método para mostrar la vista principal de trámites
    public function index(Request $request)
    {
        $columns = [
        //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
            //1 => 'id_impi',
            1 => 'folio',
            2 => 'fecha_solicitud',
            3 => 'id_empresa',
            4 => 'tramite',
            5 => 'contrasena',
            6 => 'pago',
            7 => '',
            8 => 'observaciones',
            9 => 'estatus'
        ];
        
    $search = [];
    
    $totalData = Impi::count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    $search1 = $request->input('search.value');

      if (empty($request->input('search.value'))) {
        //ORDENAR EL BUSCADOR "thead"
        //$users = Impi::where("nombre", 2)->offset($start)
        $impi = Impi::where('id_impi', 'LIKE', "%{$request->input('search.value')}%")
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

      } else {
        //BUSCADOR
        $search = $request->input('search.value');
        /*$impi = Impi::where('id_impi', 'LIKE', "%{$search}%")
          ->where("nombre", 1)
          ->orWhere('tramite', 'LIKE', "%{$search}%")
  
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();*/
        //Definimos el nombre al valor de "Estatus"
        $map = [
            'Pendiente' => 1,
            'Tramite' => 2,
            'Tramite favorable' => 3,
            'Tramite no favorable' => 4,
            ];

    // Verificar si la búsqueda es uno de los valores mapeados
        $searchValue = strtolower(trim($search)); //minusculas
        $searchType = null;

    // Si el término es valor conocido, asignamos el valor corres
        if (isset($map[$searchValue])) {
            $searchType = $map[$searchValue];
        }

    // Consulta con filtros
        $query = Impi::where('id_impi', 'LIKE', "%{$search}%")
        ->where("id_impi", 1)
        ->orWhere('tramite', 'LIKE', "%{$search}%");

    // Si se proporciona un tipo_dictamen válido, filtramos
        if ($searchType !== null) {
            $query->where('estatus',  'LIKE', "%{$searchType}%");
        } else {
    // Si no se busca por tipo_dictamen, buscamos por otros campos
            $query->where('id_impi', 'LIKE', "%{$search}%")
                ->orWhere('tramite', 'LIKE', "%{$search}%")
                ->orWhere('fecha_solicitud', 'LIKE', "%{$search}%");
        }
        $impi = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
  
        $totalFiltered = Impi::where('id_impi', 'LIKE', "%{$search}%")
          ->where("id_impi", 1)
          ->orWhere('tramite', 'LIKE', "%{$search}%")
          ->orWhere('estatus', 'LIKE', "%{$search}%")
          ->count();
      }

      $data = [];


        if (!empty($impi)) {
            $ids = $start;

            foreach ($impi as $impi) {
            //MANDA LOS DATOS AL JS
                //$nestedData['fake_id'] = ++$ids;
                $nestedData['id_impi'] = $impi->id_impi;
                $nestedData['folio'] = $impi->folio;
                //$nestedData['fecha_solicitud'] = $impi->fecha_solicitud;
                //$nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($impi->fecha_solicitud) ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFecha($impi->fecha_solicitud);
                $nestedData['id_empresa'] = $impi->id_empresa;
                $nestedData['tramite'] = $impi->tramite;
                $nestedData['contrasena'] = $impi->contrasena;
                $nestedData['pago'] = $impi->pago;
                $nestedData['observaciones'] = $impi->observaciones;
                $nestedData['estatus'] = $impi->estatus;
                //empresa y folio
                $razonSocial = $impi->empresa ? $impi->empresa->razon_social : '';
                $numeroCliente = 
                $impi->empresaNumClientes[0]->numero_cliente ?? 
                $impi->empresaNumClientes[1]->numero_cliente ?? 
                $impi->empresaNumClientes[2]->numero_cliente;
                $nestedData['razon_social'] = '<b>'.$numeroCliente . '</b> <br>' . $razonSocial;
                //telefono y correo
                $tel = $impi->empresa->telefono;
                $email = $impi->empresa->correo;
                $nestedData['contacto'] = '<b>Teléfono: </b>' .$tel. '<br> <b>Correo: </b>' .$email;

                $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } else {
      return response()->json([
        'message' => 'Internal Server Error',
        'code' => 500,
        'data' => [],
      ]);
    }
}


 
        
///FUNCION PARA REGISTRAR
    public function store(Request $request)
    {
        // $request->validate([
        //     'contrasena' => 'string|max:255',
        //     'pago' => 'string|max:255',
        // ]);
        try {
    // Obtén el último registro para el folio
    $lastRecord = Impi::orderBy('folio', 'desc')// Ordena por folio de forma descendente
    ->first();
    // Si hay registro previo
    if ( !empty($lastRecord) ) {
    // Extrae el número del folio y suma 1
    preg_match('/-(\d+)$/', $lastRecord->folio, $matches);
    $nextFolioNumber = (int)$matches[1] + 1;
    } else {
    // Si no hay registros previos
    $nextFolioNumber = 1;
    }
    // Genera el folio
    $newFolio = 'TRÁMITE-' . str_pad($nextFolioNumber, 4, '0', STR_PAD_LEFT);

            $var = new Impi();
            //$var->folio = $request->folio;
            $var->folio = $newFolio;
            $var->fecha_solicitud = $request->fecha_solicitud;
            $var->id_empresa = $request->id_empresa;
            $var->tramite = $request->tramite;
            $var->contrasena = $request->contrasena;
            $var->pago = $request->pago;
            $var->observaciones = $request->observaciones;
            $var->estatus = $request->estatus;

            $var->save();//guardar en BD

            return response()->json(['success' => 'Registro agregado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar'], 500);
        }


        //EVENTO
        try {
            $var1 = new Impi_evento();
      
            $var1->evento = $request2->evento;
            $var1->descripcion = $request2->descripcion;
    
            $var1->save();//guardar en BD
    
            return response()->json(['success' => 'Registro agregado correctamente22']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar22'], 500);
    }

}







///FUNCION PARA ELIMINAR
public function destroy($id_impi)
{
    try {
        $eliminar = Impi::findOrFail($id_impi);
        $eliminar->delete();

        return response()->json(['success' => 'Eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar'], 500);
    }
}




//FUNCION PARA LLENAR EL FORMULARIO
public function edit($id_impi)
{
    try {
        $var1 = Impi::findOrFail($id_impi);

        //$categorias = json_decode($var1->categorias);  //Convertir array

        //return response()->json($var1);
        return response()->json([
            'id_impi' => $var1->id_impi,
            'tramite' => $var1->tramite,
            'fecha_solicitud' => $var1->fecha_solicitud,
            'id_empresa' => $var1->id_empresa,
            'contrasena' => $var1->contrasena,
            'pago' => $var1->pago,
            'estatus' => $var1->estatus,
            'observaciones' => $var1->observaciones,
            //'categorias' => $categorias,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener los datos'], 500);
    }
}

//FUNCION PARA EDITAR
public function update(Request $request, $id_impi) 
{
    try {
        $var2 = Impi::findOrFail($id_impi);
        $var2->id_impi = $request->id_impi;
        $var2->tramite = $request->tramite;
        $var2->fecha_solicitud = $request->fecha_solicitud;
        $var2->id_empresa = $request->id_empresa;
        $var2->contrasena = $request->contrasena;
        $var2->pago = $request->pago;
        $var2->estatus = $request->estatus;
        $var2->observaciones = $request->observaciones;
        $var2->save();

        return response()->json(['success' => 'Editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}






}//fin CONTROLLER