<?php

namespace App\Http\Controllers\documentacion;

use App\Http\Controllers\Controller;
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\empresa;
use App\Models\instalaciones;
use App\Models\marcas;
use App\Models\Predios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class documentacionController extends Controller
{
  public function index()
  {

    $documentos = Documentacion::where('subtipo', '=', 'Todas')->get();
    $productor_agave = Documentacion::where('subtipo', '=', 'Generales Productor')->get();

      //Permiso de empresa
    $empresas = Auth::check() && Auth::user()->tipo == 3
    ? Empresa::with('empresaNumClientes')
        ->where('id_empresa', Auth::user()->empresa?->id_empresa)
        ->get()
    : Empresa::with('empresaNumClientes')
        ->where('tipo', 2)
        ->get();
    $instalaciones = instalaciones::where('tipo', '=', 2)->get();

    return view("documentacion.documentacion_view", ["documentos" => $documentos, "productor_agave" => $productor_agave, "empresas" => $empresas]);
  }

  public function getNormas(Request $request)
  {
    $id_empresa = $request->input('cliente_id');

    if (!$id_empresa) {
      return response()->json(['tabs' => '', 'contents' => '']);
    }

    $normas = DB::select("
            SELECT n.id_norma, n.norma AS nombre
            FROM catalogo_norma_certificar n 
            JOIN empresa_num_cliente e ON n.id_norma = e.id_norma 
            WHERE n.id_norma != 3 AND e.id_empresa = ?
        ", [$id_empresa]);



    $tabs = '';
    $contents = '';
    $tabsNormas = '';
    $contenido = '';
    $documentosActividad = '';
    $contenidoInstalaciones = '';
    $contenidoInstalacionesGenerales = '';



    foreach ($normas as $index => $norma) {
      $tabsActividades = '';
      $tabsGenerales = '';
      $contenidoActividades = '';
      $contenidoGenerales = '';


      $actividades = DB::select("
      SELECT a.id_actividad, a.actividad  
      FROM catalogo_actividad_cliente a 
      JOIN empresa_actividad_cliente na 
      ON a.id_actividad = na.id_actividad 
      WHERE a.id_norma = ? AND na.id_empresa = ?
    ", [$norma->id_norma, $id_empresa]);

    $logo = [
      'Productor de Agave' => 'Productor de agave.png',
      'Productor de Mezcal' => 'Productor de mezcal.png',
      'Envasador de Mezcal' => 'Envasador de mezcal.png',
      'Comercializador de Mezcal' => 'Comercializador de mezcal.png',
    
  ];

      foreach ($actividades as $indexA => $actividad) {

        $activeClassA = $indexA == 0 ? 'active' : '';
        $showClassA = $indexA == 0 ? 'show' : '';
        $contenidoDocumentos = "";
        $contenidoDocumentosPredios = "";
        $contenidoDocumentosGenerales = "";
        $contenidoDocumentosMarcas = "";
        $contenidoInstalaciones = '';
        $contenidoPredios = '';
        $contenidoInstalacionesGenerales = '';
        $act_instalacion = '';

        $tabsGenerales = '
            <li class="nav-item">
                <a style="width: 100% !important;" href="javascript:void(0);" class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-0" aria-controls="navs-orders-id-0" aria-selected="true">
                  <div>
                    <img style="height:45px" src="' . asset('assets/img/modulo_documentacion/Documentos generales.png') . '" alt=" Documentos Generales" class="img-fluid">
                  </div>
                  Documentos Generales
                </a>
              </li>';
              


        $tabsActividades = $tabsActividades . '
            <li class="nav-item">
                <a style="width: 100% !important;" href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-' . $actividad->id_actividad . '" aria-controls="navs-orders-id-' . $actividad->id_actividad . '" aria-selected="true">
                  <div>
                    <img  style="height:45px" src="' . asset('assets/img/modulo_documentacion/'.$logo[$actividad->actividad]) . '" alt="Mobile" class="img-fluid">
                  </div>
                  ' . $actividad->actividad . '
                </a>
              </li>';

        if ($actividad->id_actividad == 1) {
          $documentosActividad = "Generales Productor";
          $act_instalacion = "Producción de agave"; 
        }

        if ($actividad->id_actividad == 2) {
          $documentosActividad = "Generales Productor Mezcal";
          $act_instalacion = "Productora";
        }

        if ($actividad->id_actividad == 3) {
          $documentosActividad = "Generales Envasador";
          $act_instalacion = "Envasadora";
        }

        if ($actividad->id_actividad == 4) {
          $documentosActividad = "Generales Comercializador";
          $act_instalacion = "Comercializadora";
        }

        if ($actividad->id_actividad == 6) {
          $documentosActividad = "Generales Envasador Mezcal";
        }

        if ($actividad->id_actividad == 7) {
          $documentosActividad = "Generales Comercializador Mezcal";
          $documentosActividadMarca =  "->orWhere('subtipo', 'Marcas')";
        }



        $documentos2 = Documentacion::where('subtipo', 'Todas')
          ->with('documentacionUrls') // Eager loading de la relación
          ->get();

        $empresa = empresa::with('empresaNumClientes')->where('id_empresa', $id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
          return !empty($numero);
      });
        $razonSocial = $empresa->razon_social;
        $direccion_fiscal = $empresa->domicilio_fiscal;



        foreach ($documentos2 as $indexD => $documento) {

          $urls = $documento->documentacionUrls->where('id_empresa', $id_empresa);

          $mostrarDocumento = '---';
          
          if ($urls->isNotEmpty()) {
              $mostrarDocumento = '';
          
              foreach ($urls as $urlData) {
                  $mostrarDocumento .= '<i onclick="abrirModal(\'files/' . $numeroCliente . '/' . $urlData->url . '\','.$urlData->id.')" data-id="'.$urlData->id.'" class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"  data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i> ';
              }
          }
          

          $contenidoDocumentosGenerales = $contenidoDocumentosGenerales . '<tr>
                      <td>' . ($indexD + 1) . '</td>
                      <td class="text-wrap text-break"><b>' . $documento->nombre . '</b></td>
                      <td  class="text-end p-1">
                          <input class="form-control form-control-sm" type="file" id="file' . $documento->id_documento . '" data-id="' . $documento->id_documento . '" name="url[]">
                                <input value="' . $documento->id_documento . '" class="form-control" type="hidden" name="id_documento[]">
                                <input value="' . $documento->nombre . '" class="form-control" type="hidden" name="nombre_documento[]">
                                <input value="0" class="form-control" type="hidden" name="id_relacion[]">
                      </td>
                      <td  id="mostrar' . $documento->id_documento . '" class="text-end fw-medium">   
                      
                         ' . $mostrarDocumento . '
                      
                     </td>
                      <td class="text-success fw-medium text-end">----</td>
                    </tr>';
        }

       

        $empresa = empresa::with('empresaNumClientes')->where('id_empresa', $id_empresa)->first();
        
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
          return !empty($numero);
      });
        $razonSocial = $empresa->razon_social;
        $direccion_fiscal = $empresa->domicilio_fiscal;



        $instalaciones = Instalaciones::where('id_empresa', '=', $id_empresa)->where('tipo', 'like', '%'.$act_instalacion.'%')->get(); //Se va a ocultar los tipo 1 que son para predios

        $predios = Predios::where('id_empresa', '=', $id_empresa)
     // Excluir los de tipo 1
    ->orderBy('created_at', 'desc') // Ordenar por los más recientes
    ->take(10) // Limitar a 10 registros
    ->get();






        $contenidoInstalacionesGenerales = '
       
        <div class="table-responsive text-nowrap col-md-12 mb-5 ">
              <table class="table table-sm table-bordered table-striped">
                <thead class="bg-secondary text-white">
                  <tr>
                    <th colspan="5" class="bg-transparent border-bottom bg-info text-center text-white fs-3"><b>Documentación general</b><br><b style="font-size:12px" class="badge bg-primary">'.$direccion_fiscal.'</b></th>
                  </tr>
                  <tr>
                    <th class="bg-transparent border-bottom">#</th>
                    <th class="bg-transparent border-bottom">Descripción del documento</th>
                    <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                    <th class="text-end bg-transparent border-bottom">Documento</th>
                    <th class="text-end bg-transparent border-bottom">Validar</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" style="font-size:12px">
                    ' . $contenidoDocumentosGenerales . '
                </tbody>
              </table>
            </div>';

       /*  $instalaciones = Instalaciones::where('id_empresa', '=', $id_empresa)
                ->where('tipo', 'like', $act_instalacion);

$instalaciones->toSql();


print_r($instalaciones->getBindings());*/

if ($act_instalacion == 'Producción de agave') {
//Esto es para los prediods
foreach ($predios as $indexI => $predio) {

  $documentos = Documentacion::where('subtipo', $documentosActividad)
  ->with('documentacionUrls')
  ->get();
  $contenidoDocumentosPredios = '';



foreach ($documentos as $indexD => $documento) {
  

  $urls = $documento->documentacionUrls->where('id_relacion', $predio->id_predio);

  $mostrarDocumento = '---';
  
  if ($urls->isNotEmpty()) {
      $mostrarDocumento = '';
  
      foreach ($urls as $urlData) {
          $mostrarDocumento .= '<i onclick="abrirModal(\'files/' . $numeroCliente . '/' . $urlData->url . '\')" class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i> ';
      }
  }
  

  $contenidoDocumentosPredios = $contenidoDocumentosPredios . '
      <tr>
        <td>' . ($indexD + 1) . '</td>
        <td class="text-wrap text-break"><b>' . $documento->nombre . '</b></td>
        <td class="text-end">
            <input class="form-control form-control-sm" type="file" id="file' . $documento->id_documento . '" data-id="' . $documento->id_documento . '" name="url[]">
                  <input value="' . $documento->id_documento . '" class="form-control" type="hidden" name="id_documento[]">
                  <input value="' . $documento->nombre . '" class="form-control" type="hidden" name="nombre_documento[]">'.'<input type="hidden" name="id_relacion[]" value="' . $predio->id_predio . '">'.'
        </td>
        <td id="mostrar' . $documento->id_documento . '" class="text-end fw-medium">   
        
          ' . $mostrarDocumento . '
        
        </td>
        <td class="text-success fw-medium text-end">----</td>
      </tr>
      ';
}
  $contenidoPredios = $contenidoPredios . '

<div class="table-responsive text-nowrap col-md-6 mb-5 ">
    <table class="table table-sm table-bordered table-striped">
      <thead class="bg-secondary text-white">
        <tr>
          <th colspan="5" class="bg-transparent border-bottom bg-info text-center text-white fs-4"><span class="fs-6">Predio:</span><br> <b style="font-size:12px" class="badge bg-primary">' . $predio->nombre_predio . '</b></th>
        </tr>
        <tr>
          <th class="bg-transparent border-bottom">#</th>
          <th class="bg-transparent border-bottom">Descripción del documento</th>
          <th class="text-end bg-transparent border-bottom">Subir archivo</th>
          <th class="text-end bg-transparent border-bottom">Documento</th>
          <th class="text-end bg-transparent border-bottom">Validar</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0" style="font-size:12px">
          ' . $contenidoDocumentosPredios . '
      </tbody>
    </table>
  </div>';
}

}


if ($act_instalacion != 'Produccion de agave') {

        //Estp es para las instalaciones
        foreach ($instalaciones as $indexI => $instalacion) {

          $documentos = Documentacion::where('subtipo', $documentosActividad)
          ->with('documentacionUrls')
          ->get();
          $contenidoDocumentos = '';

        
       
        foreach ($documentos as $indexD => $documento) {
          

          $urls = $documento->documentacionUrls->where('id_relacion', $instalacion->id_instalacion);

        $mostrarDocumento = '---';

        if ($urls->isNotEmpty()) {
            $mostrarDocumento = '';

            foreach ($urls as $urlData) {
                $mostrarDocumento .= '<i onclick="abrirModal(\'files/' . $numeroCliente . '/' . $urlData->url . '\')" class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i> ';
            }
        }

          $contenidoDocumentos = $contenidoDocumentos . '
              <tr>
                <td>' . ($indexD + 1) . '</td>
                <td class="text-wrap text-break"><b>' . $documento->nombre . '</b></td>
                <td class="text-end">
                    <input class="form-control form-control-sm" type="file" id="file' . $documento->id_documento . '" data-id="' . $documento->id_documento . '" name="url[]">
                          <input value="' . $documento->id_documento . '" class="form-control" type="hidden" name="id_documento[]">
                          <input value="' . $documento->nombre . '" class="form-control" type="hidden" name="nombre_documento[]">'.'<input type="hidden" name="id_relacion[]" value="' . $instalacion->id_instalacion . '">'.'
                </td>
                <td id="mostrar' . $documento->id_documento . '" class="text-end fw-medium">   
                
                  ' . $mostrarDocumento . '
                
                </td>
                <td class="text-success fw-medium text-end">----</td>
              </tr>
              ';
        }
          $contenidoInstalaciones = $contenidoInstalaciones . '
     
      <div class="table-responsive text-nowrap col-md-12 mb-5 ">
            <table class="table table-sm table-bordered table-striped">
              <thead class="bg-secondary text-white">
                <tr>
                  <th colspan="5" class="bg-transparent border-bottom bg-info text-center text-white fs-4"><span class="fs-6">Instalación:</span><br> <b style="font-size:12px" class="badge bg-primary">' . $instalacion->direccion_completa . '</b></th>
                </tr>
                <tr>
                  <th class="bg-transparent border-bottom">#</th>
                  <th class="bg-transparent border-bottom">Descripción del documento</th>
                  <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                  <th class="text-end bg-transparent border-bottom">Documento</th>
                  <th class="text-end bg-transparent border-bottom">Validar</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" style="font-size:12px">
                  ' . $contenidoDocumentos . '
              </tbody>
            </table>
          </div>';
        }

      }

        
      $marcas = marcas::where('id_empresa', '=', $id_empresa)->get();
      $contenidoMarcas = '';

      if ($act_instalacion == 'Comercializadora') {

        
        foreach ($marcas as $indexII => $marca) {

          $documentos3 = Documentacion::where('tipo', 'Marcas')
          ->with(['documentacionUrls' => function ($query) use ($marca) {
              $query->where('id_relacion', $marca->id_marca); // Filtrar registros de la relación
          }])
          ->get();
      
          $contenidoDocumentosMarcas = '';
          foreach ($documentos3 as $indexD => $documento) {

            $urls = $documento->documentacionUrls;

          $mostrarDocumento = '---';

          if ($urls->isNotEmpty()) {
              $mostrarDocumento = '';

              foreach ($urls as $urlData) {
                  $mostrarDocumento .= '<i onclick="abrirModal(\'files/' . $numeroCliente . '/' . $urlData->url . '\')" class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i> ';
              }
          }

  
            $contenidoDocumentosMarcas = $contenidoDocumentosMarcas . '<tr>
                        <td>' . ($indexD + 1) . '</td>
                        <td class="text-wrap text-break"><b>' . $documento->nombre . '</b></td>
                        <td class="text-end">
                            <input class="form-control form-control-sm" type="file" id="file' . $documento->id_documento . '" data-id="' . $documento->id_documento . '" name="url[]">
                                  <input value="' . $documento->id_documento . '" class="form-control" type="hidden" name="id_documento[]">
                                  <input value="' . $documento->nombre . '" class="form-control" type="hidden" name="nombre_documento[]">
                                 <input type="hidden" name="id_relacion[]" value="' . $marca->id_marca . '">
                        </td>
                        <td id="mostrar' . $documento->id_documento . '" class="text-end fw-medium">   
                        
                           ' . $mostrarDocumento . '
                        
                       </td>
                        <td class="text-success fw-medium text-end">----</td>
                      </tr>';
          }
        
          $id_relacion_array = ''; // Inicializar la cadena para los inputs en cada iteración


          // Generar los inputs para `id_relacion` por cada `documento3`
          //foreach ($documentos3 as $documento) {
              $id_relacion_array .= '<input type="hidden" name="id_relacion[]" value="' . htmlspecialchars($marca->id_marca) . '">';
         // }

          $contenidoMarcas =  $contenidoMarcas . ' 
           
            <div class="table-responsive text-nowrap col-md-6 mb-5 ">

           
                  <table class="table table-striped table-sm table-bordered">
                    <thead class="bg-secondary text-white">
                      <tr>
                        <th colspan="5" class="bg-transparent border-bottom bg-info text-center text-white fs-6">Marca:<br><b><span style="font-size:12px" class="badge bg-warning">' . $marca->marca . '</span></b></th>
                      </tr>
                      <tr>
                        <th class="bg-transparent border-bottom">#</th>
                        <th class="bg-transparent border-bottom">Descripción del documento</th>
                        <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                        <th class="text-end bg-transparent border-bottom">Documento</th>
                        <th class="text-end bg-transparent border-bottom">Validar</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" style="font-size:12px">
                   
                        ' . $contenidoDocumentosMarcas . '
                    </tbody>
                  </table>
                </div>';
        }
      }

      $contenidoActividades = $contenidoActividades . '
      <div class="tab-pane fade" id="navs-orders-id-' . $actividad->id_actividad . '" role="tabpanel">
       <div class="row p-5">
       ' . $contenidoPredios . '
        ' . $contenidoInstalaciones . '
        ' . $contenidoMarcas . '
      </div> 
      </div>';






      }




      $contenidoGenerales =  '<div class="tab-pane fade show active" id="navs-orders-id-0" role="tabpanel">
      <div class="row p-5"> 
       ' . $contenidoInstalacionesGenerales . '
     </div> 
     </div>';






      $tabId = 'norma-' . $norma->id_norma;
      $activeClass = $index == 0 ? 'active' : '';
      $showClass = $index == 0 ? 'show' : '';
      $norma =  $norma->nombre;
      $tabsNormas = $tabsNormas . ' <li class="nav-item">
                  <button type="button" class="nav-link ' . $activeClass . '" role="tab" data-bs-toggle="tab" data-bs-target="#' . $tabId . '" aria-controls="' . $tabId . '" aria-selected="true">' . $norma . '</button>
                </li>';

      $contenido = $contenido . '
            <div class="tab-pane fade ' . $showClass . ' ' . $activeClass . '" id="' . $tabId . '" role="tabpanel">
                  <div class="row">                     
  <!-- Top Referral Source Mobile  -->
  <div class="col-xxl-12">
    <div class="card"> 
     
      <div class="card-header d-flex justify-content-between">
        <div>
          <h5 class="card-title mb-1">' . $numeroCliente . ' ' . $razonSocial . ' (' . $norma . ')</h5>

          <input name="numCliente" type="hidden" value="' . $numeroCliente . '">
          
        </div>
        
      </div>
      <div class="card-body pb-0">
        <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap align-items-center" role="tablist">
         ' . $tabsGenerales . '  ' . $tabsActividades . '
        </ul>
      </div>
      <div class="tab-content p-0">
       ' . $contenidoGenerales . '  ' . $contenidoActividades . '
        
      </div>
    </div>
  </div>
  <!--/ Top Referral Source Mobile -->

 

  </div>
                           
                </div>';
    }

    $tabs = '<div class="nav-align-top">
              <ul class="nav nav-tabs nav-fill" role="tablist">
                  ' . $tabsNormas . '
              </ul>
              <div class="tab-content border-0 pb-0 px-6 mx-1">
                  ' . $contenido . '
                
              </div>
            </div>';

    return response()->json(['tabs' => $tabs, 'contents' => $contents]);
  }


  /* public function getNormas(Request $request)
    {
        $id_empresa = $request->input('cliente_id');
        $normas = DB::select("SELECT n.id_norma,norma FROM catalogo_norma_certificar n JOIN empresa_norma_certificar e ON (n.id_norma = e.id_norma) WHERE id_empresa = ?",[$id_empresa]);
        return response()->json($normas);
    }*/

  public function getActividades(Request $request)
  {
    $id_empresa = $request->input('cliente_id');
    $id_norma = $request->input('norma_id');

    if (!$id_empresa || !$id_norma) {
      return response()->json([]);
    }

    $actividades = DB::select("
            SELECT a.id_actividad, a.actividad  
            FROM catalogo_actividad_cliente a 
            JOIN empresa_actividad_cliente na 
            ON a.id_actividad = na.id_actividad 
            WHERE a.id_norma = ? AND na.id_empresa = ?
        ", [$id_norma, $id_empresa]);

    return response()->json($actividades);
  }

  public function upload(Request $request)
  {

 
  

    if ($request->hasFile('url')) {
      $numeroCliente = $request->numCliente;
      $i = 0;
      $uploadedFiles = [];
      $documento_id = [];
      $id = [];
      foreach ($request->file('url') as $index => $file) {
        $filename = str_replace('/', '-', $request->nombre_documento[$index]) . '_' . time().$i. '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');
        $uploadedFiles[] = $filename;
        $documento_id[] = $request->id_documento[$index];

        $documentacion_url = new Documentacion_url();
        $documentacion_url->id_relacion = isset($request->id_relacion[$index]) ? $request->id_relacion[$index] : 0;

        $documentacion_url->id_documento = $request->id_documento[$index];
        $documentacion_url->nombre_documento = str_replace('/', '-', $request->nombre_documento[$index]);
        $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
        $documentacion_url->id_empresa = $request->id_empresa;
        $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null; // Usa null si no hay fecha
        $documentacion_url->save();
        $id[] = $documentacion_url->id;
        $i++;
      }
    }


    return response()->json(['success' => $request, 'files' => $uploadedFiles,'id_documento' => $documento_id,'id'=>$id, 'folder'=>$numeroCliente]);
  }

  public function eliminarDocumento($id)
    {
        // Buscar el documento por su ID
        $documento = Documentacion_url::find($id);

        if ($documento) {
            // Eliminar el archivo de almacenamiento (si es necesario)
          /*  if (Storage::exists($documento->ruta)) {
                Storage::delete($documento->ruta);
            }*/

            // Eliminar el documento de la base de datos
            $documento->delete();

            // Retornar una respuesta exitosa
            return response()->json(['success' => true, 'message' => 'Documento eliminado exitosamente.']);
        }

        // Si no se encuentra el documento, retornar un error
        return response()->json(['success' => false, 'message' => 'Documento no encontrado.'], 404);
    }
}
