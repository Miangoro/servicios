<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Destinos;
use App\Models\Documentacion_url;
use App\Models\empresa;
use App\Models\Instalaciones;
use App\Models\LotesGranel;
use App\Models\tipos;
use App\Models\guias;
use App\Models\lotes_envasado;
use App\Models\maquiladores_model;
use App\Models\normas;
use App\Models\solicitudesModel;
use App\Models\Dictamen_Envasado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getFuncionesController extends Controller
{
    public function datosComunes($id_empresa)
    {
        $normas = DB::table('empresa_norma_certificar AS n')
        ->join('catalogo_norma_certificar AS c', 'n.id_norma', '=', 'c.id_norma')
        ->select('c.norma', 'c.id_norma') // Selecciona las columnas necesarias
        ->where('c.id_norma', '!=' ,2)
        ->where('n.id_empresa', $id_empresa)
        ->get();


        // Lógica común que se necesita en diferentes vistas
        return [
            'empresas' => empresa::all(),
            'normas' => $normas,
            'direcciones_destino' => Destinos::where("id_empresa",$id_empresa),

        ];
    }

    private function renderVista($vista,$id_empresa)
    {
        $data = $this->datosComunes($id_empresa);
        //return view($vista, $data);
        return response()->json($data);
    }

    public function find_clientes_prospecto($id)
    {
        $id_empresa = $id;
        return $this->renderVista('_partials._modals.modal-add-aceptar-cliente',$id_empresa);
    }

    public function usuariosInspectores()
    {
        $inspectores = User::all();
        return $this->renderVista('_partials._modals.modal-add-asignar-inspector',$inspectores);
    }


    public function getDatos(empresa $empresa)
    {
        // Obtener las marcas de la empresa
        //$marcas = $empresa->marcas()->get();  // Llamamos a `get()` para obtener los datos reales
        $marcas = $empresa->todasLasMarcas()->get();

        // Depurar las marcas

        $idsMaquiladoras = maquiladores_model::where('id_maquiladora', $empresa->id_empresa)
            ->pluck('id_maquilador')
            ->toArray();
        $idsEmpresas = array_merge([$empresa->id_empresa], $idsMaquiladoras);


        return response()->json([
            'instalaciones' => $empresa->obtenerInstalaciones(),
            'lotes_granel' => $empresa->todos_lotes_granel(),
            'marcas' => $marcas,
            'guias' => $empresa->guias(),
            'predios' => $empresa->predios(),
            'predio_plantacion' => $empresa->predio_plantacion(),
            'direcciones' => $empresa->direcciones(),
            /* 'lotes_envasado' => $empresa->todos_lotes_envasado(), */
            'lotes_envasado' => lotes_envasado::whereIn('id_empresa', $idsEmpresas)
            ->with('lotes_envasado_granel.lotes_granel', 'dictamenEnvasado')
            ->orderByDesc('id_lote_envasado')
            ->get(),
            'direcciones_destino' => Destinos::where("id_empresa", $empresa->id_empresa)->where('tipo_direccion', 1)->get(),
            'instalaciones_produccion' => Instalaciones::where('tipo', 'like', '%Productora%')->where("id_empresa", $empresa->id_empresa)->get(),
            'instalaciones_comercializadora' => Instalaciones::where('tipo', 'like', '%Comercializadora%')->where("id_empresa", $empresa->id_empresa)->get(),
            'instalaciones_envasadora' => Instalaciones::where('tipo', 'like', '%Envasadora%')->whereIn('id_empresa', $idsEmpresas)->get(),
        ]);
    }

    public function getDatos2($id_lote_granel)
    {
        $loteGranel = LotesGranel::find($id_lote_granel);

        if (!$loteGranel) {
            return response()->json(['error' => 'Lote Granel no encontrado'], 404);
        }

        // Obtener la marca asociada a la empresa relacionada con el lote_granel
        $marca = $loteGranel->empresa ? $loteGranel->empresa->marcas()->pluck('marca')->first() : null;

        // Obtener ids de tipos desde el JSON (id_tipo)
        $idTipos = json_decode($loteGranel->id_tipo, true);

        // Si no hay tipos, devolvemos un valor vacío
        if (!$idTipos || !is_array($idTipos)) {
            return response()->json([
                'categoria' => $loteGranel->categoria,
                'clase' => $loteGranel->clase,
                'tipo' => [],
                'marca' => $marca, // Incluir la marca aquí
                'lotes_granel' => $loteGranel
            ]);
        }

        // Buscar los datos de cada tipo relacionado
        $tipos = tipos::whereIn('id_tipo', $idTipos)
        ->get(['id_tipo', 'nombre', 'cientifico']); // Incluye 'id_tipo' en la consulta

    return response()->json([
        'categoria' => $loteGranel->categoria,
        'clase' => $loteGranel->clase,
        'tipo' => $tipos, // Enviar la lista de tipos encontrados
        'marca' => $marca, // Incluir la marca aquí
        'lotes_granel' => $loteGranel
    ]);

    }

public function getDictamenesEnvasado($id_empresa)
{
    $dictamenes = Dictamen_Envasado::with(['inspeccion.solicitud', 'lote_envasado'])
        ->whereHas('lote_envasado', function ($query) use ($id_empresa) {
            $query->where('id_empresa', $id_empresa);
        })
        ->get();

    $formateados = $dictamenes->map(function ($d) {
        $solicitud = $d->inspeccion->solicitud ?? null;

        return [
            'id_dictamen_envasado' => $d->id_dictamen_envasado,
            'num_dictamen' => $d->num_dictamen,
            'folio' => $solicitud->folio ?? 'Sin folio',
            'lote_nombre' => $d->lote_envasado->nombre ?? 'Sin nombre',
            'id_instalacion' => $solicitud->id_instalacion ?? '',
            'fecha_visita' => $solicitud->fecha_visita ?? '',
        ];
    });

    return response()->json($formateados);
}

      public function obtenerDatosInspeccion($idDictamen)
    {

  $dictamen = Dictamen_Envasado::with([
        'inspeccion.solicitud' // Asegúrate de tener bien definidas las relaciones
    ])->findOrFail($idDictamen);

    $inspeccion = $dictamen->inspeccion;
    $solicitud = $inspeccion->solicitud ?? null;

    return response()->json([
        'id_inspeccion' => $inspeccion->id ?? null,
        'id_solicitud' => $inspeccion->id_solicitud ?? null,
        'id_inspector' => $inspeccion->id_inspector ?? null,
        'num_servicio' => $inspeccion->num_servicio ?? null,
        'fecha_servicio' => $inspeccion->fecha_servicio ?? null,
        'estatus_inspeccion' => $inspeccion->estatus_inspeccion ?? null,
        'observaciones' => $inspeccion->observaciones ?? null,
        'id_instalacion' => $solicitud->id_instalacion ?? null,
        'fecha_visita' => $solicitud->fecha_visita ?? null,
        'id_lote_envasado' => $dictamen->id_lote_envasado,
    ]);
    }

    public function getDatosLoteEnvasado($idLoteEnvasado)
    {
        // Obtener el lote envasado específico por ID, con las relaciones necesarias
        $loteEnvasado = lotes_envasado::with([
            'marca',
            'lotesGranel.categoria',
            'lotesGranel.clase',
            'lotesGranel.certificadoGranel'
        ])->find($idLoteEnvasado);

        // Si no se encuentra el lote envasado, devolver un error
        if (!$loteEnvasado) {
            return response()->json(['error' => 'Lote envasado no encontrado'], 404);
        }

        // Obtener el primer lote granel (si hay más de uno)
        $primerLoteGranel = $loteEnvasado->lotesGranel->first(); // Obtén el primer elemento si hay varios

        // Si no hay ningún lote granel, devolver un error
        if (!$primerLoteGranel) {
            return response()->json(['error' => 'Lote granel no encontrado'], 404);
        }

        $idTipos = json_decode($primerLoteGranel->id_tipo, true);

        // Validar si se pudo decodificar correctamente y si es un arreglo
        if (!$idTipos || !is_array($idTipos)) {
            $idTipos = []; // Si no hay tipos, asignar un arreglo vacío
        }

        // Buscar los datos de los tipos en la base de datos usando los IDs obtenidos
        $tipos = tipos::whereIn('id_tipo', $idTipos)
            ->get(['id_tipo', 'nombre', 'cientifico'])
            ->map(function ($tipo) {
                // Concatenar el nombre con el nombre científico en el formato requerido
                $tipo->nombre = $tipo->nombre . ' (' . $tipo->cientifico . ')';
                unset($tipo->cientifico); // Eliminar el campo 'cientifico', ya que está incluido en 'nombre'
                return $tipo;
            });

            return response()->json([
              'lotes_envasado' => $loteEnvasado,
              'marca' => $loteEnvasado->marca,
              'primer_lote_granel' => [
                  'id_categoria' => $primerLoteGranel->categoria ? $primerLoteGranel->categoria->id_categoria : '', // ID de la categoría
                  'nombre_categoria' => $primerLoteGranel->categoria ? $primerLoteGranel->categoria->categoria : '', // Nombre de la categoría
                  'id_clase' => $primerLoteGranel->clase ? $primerLoteGranel->clase->id_clase : '', // ID de la clase
                  'nombre_clase' => $primerLoteGranel->clase ? $primerLoteGranel->clase->clase : '', // Nombre de la clase
                  'folio_fq' => $primerLoteGranel->folio_fq,
                  'cont_alc' => $primerLoteGranel->cont_alc,
                  'folio_certificado' => $primerLoteGranel->certificadoGranel && $primerLoteGranel->certificadoGranel->num_certificado
                      ? $primerLoteGranel->certificadoGranel->num_certificado
                      : ($primerLoteGranel->folio_certificado ?? null),
                  'tipos' => $tipos,
                  'tipos_ids' => $idTipos, // Solo los IDs
                  'tipos_nombres' => $tipos->pluck('nombre'),
              ]
          ]);
    }


public function getDocumentosSolicitud($id_solicitud)
{
    if (!$id_solicitud) {
        return response()->json([
            'success' => false,
            'message' => 'ID de solicitud no válido.'
        ], 400);
    }

    // Cargar la solicitud con la relación empresa y empresaNumClientes
    $solicitud = solicitudesModel::with(['empresa', 'empresa.empresaNumClientes'])->find($id_solicitud);

    if (!$solicitud) {
        return response()->json([
            'success' => false,
            'message' => 'Solicitud no encontrada.'
        ], 404);
    }

    // Obtener número de cliente
    $numero_cliente = 'N/A';
    if ($solicitud->empresa && $solicitud->empresa->empresaNumClientes->isNotEmpty()) {
        $cliente = $solicitud->empresa->empresaNumClientes
            ->first(fn($item) => !empty($item->numero_cliente));
        $numero_cliente = $cliente?->numero_cliente ?? 'No encontrado';
    }

    // Obtener documentos relacionados
    $documentos = Documentacion_url::where('id_relacion', $id_solicitud)
        ->get(['nombre_documento as nombre', 'url', 'id_documento']);


        $caracteristicas = is_string($solicitud->caracteristicas)
            ? json_decode($solicitud->caracteristicas, true)
            : $solicitud->caracteristicas;

        $idEtiqueta = is_array($caracteristicas)
            ? ($caracteristicas['id_etiqueta'] ?? null)
            : ($caracteristicas->id_etiqueta ?? null);

        if ($idEtiqueta) {
            $url_etiqueta = Documentacion_url::where('id_relacion', $idEtiqueta)
            ->where('id_documento', 60)
            ->value('url'); // Obtiene directamente el valor del campo 'url'
        }


        if ($idEtiqueta) {
            $url_corrugado = Documentacion_url::where('id_relacion', $idEtiqueta)
            ->where('id_documento', 75)
            ->value('url'); // Obtiene directamente el valor del campo 'url'
        }

        $idLote = $solicitud->lote_granel?->id_lote_granel;


        $ids = $solicitud->id_lote_envasado; // array de IDs

                  $numero_cliente_lote = 'N/A';
        $empresa = empresa::find($solicitud->lote_granel->id_empresa);
        $cliente = $empresa->empresaNumClientes
            ->first(fn($item) => !empty($item->numero_cliente));
        $numero_cliente_lote = $cliente?->numero_cliente ?? 'No encontrado';

  $certificados = collect();

foreach ($ids as $id) {
    $lote = lotes_envasado::find($id);
    if ($lote) {
        foreach ($lote->lotesGranel as $granel) {
            if ($granel->certificadoGranel) {
                $certificados->push($granel->certificadoGranel);
            }
        }
    }
}


$urls_certificados = collect();

foreach ($certificados as $certificado) {
    $url = Documentacion_url::where('id_relacion', $certificado->id_lote_granel)
        ->where('id_documento', 59)
        ->value('url');

    if ($url) {
        $urls_certificados->push($url);
    }
}


$fqs = collect();

foreach ($certificados as $certificado) {
    $documentos2 = Documentacion_url::where('id_relacion', $certificado->id_lote_granel)
        ->whereIn('id_documento', [58, 134])
        ->get(['url', 'nombre_documento']);

    foreach ($documentos2 as $documento) {
        $fqs->push([
            'url' => $documento->url,
            'nombre_documento' => $documento->nombre_documento
        ]);
    }
}








    return response()->json([
        'success' => true,
        'data' => $documentos,
        'numero_cliente' => $numero_cliente,
        'fqs' => $fqs,
        'numero_cliente_lote' => $numero_cliente_lote,
        'url_etiqueta' => $url_etiqueta ?? '',
        'url_corrugado' => $url_corrugado ?? '',
        'url_certificado' => $urls_certificados ?? '',
        'url_fqs' => $url_fqs ?? '',
        'id_lote_envasado' => $certificados ?? '',

            ]);
}





    public function getDatosSolicitud($id_solicitud)
{
   // Realizamos la consulta base sin las relaciones condicionales
$solicitudQuery = solicitudesModel::with([
    'empresa.empresaNumClientes',
    'instalacion.certificado_instalacion',
    'predios',
    'marcas',


]);

// Cargamos la solicitud
$solicitud = $solicitudQuery->where("id_solicitud", $id_solicitud)->first();

if ($solicitud && $solicitud->id_tipo != 11 && $solicitud->id_tipo != 5) {
    // Si el id_tipo no es 11, agregamos las relaciones adicionales
    $solicitud->load([
    'lote_granel' => function ($query) {
        $query->with(['categoria', 'clase', 'certificadoGranel']);
    }
]);
}

$solicitud = $solicitudQuery->where("id_solicitud", $id_solicitud)->first();

if ($solicitud  && $solicitud->id_tipo != 5) {
    $solicitud->load([
        'lote_granel' => function ($query) {
            $query->with(['categoria', 'clase', 'certificadoGranel','empresa.empresaNumClientes']);
        }
    ]);
}

// ⚠️ Aquí cargas los lotes envasado manualmente con sus relaciones
$lotesEnvasado = lotes_envasado::with([
    'lotesGranel.clase',
    'lotesGranel.categoria',
    'marca',
    'dictamenEnvasado',
    'lotesGranel.certificadoGranel',
    'lotesGranel.empresa.empresaNumClientes'
])->whereIn('id_lote_envasado', $solicitud->id_lote_envasado)->get();



    if (!$solicitud) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró la solicitud.',
        ]);
    }

    // Manejar tipos relacionados
    $tipos = "No hay tipos relacionados disponibles.";
    if (!empty($solicitud->lote_granel) && !empty($solicitud->lote_granel->tiposRelacionados)) {
        $tipos = collect($solicitud->lote_granel->tiposRelacionados)
            ->map(fn($tipo) => $tipo->nombre . " (" . $tipo->cientifico . ")")
            ->join(', ');
    }

    // Obtener documentos relacionados
    $documentos = Documentacion_url::where("id_empresa", $solicitud->empresa->id_empresa)->where('id_documento','!=',55)->where('id_documento','!=',60)->where('id_documento','!=',69)->get();

    if ($solicitud && $solicitud->id_tipo == 11) {
        $caracteristicas = is_string($solicitud->caracteristicas)
            ? json_decode($solicitud->caracteristicas, true)
            : $solicitud->caracteristicas;

        $idEtiqueta = is_array($caracteristicas)
            ? ($caracteristicas['id_etiqueta'] ?? null)
            : ($caracteristicas->id_etiqueta ?? null);

        if ($idEtiqueta) {
            $url_etiqueta = Documentacion_url::where('id_relacion', $idEtiqueta)
            ->where('id_documento', 60)
            ->value('url'); // Obtiene directamente el valor del campo 'url'
        }


        if ($idEtiqueta) {
            $url_corrugado = Documentacion_url::where('id_relacion', $idEtiqueta)
            ->where('id_documento', 75)
            ->value('url'); // Obtiene directamente el valor del campo 'url'
        }

    }

 if ($solicitud && $solicitud->id_tipo == 3) {
    $caracteristicas = is_string($solicitud->caracteristicas)
        ? json_decode($solicitud->caracteristicas, true)
        : $solicitud->caracteristicas;

    $id_lote_granel = is_array($caracteristicas)
        ? ($caracteristicas['id_lote_granel'] ?? null)
        : ($caracteristicas->id_lote_granel ?? null);

    if ($id_lote_granel) {
        // Buscar solicitud con ese id_lote_granel dentro del campo json 'caracteristicas'
        $id_solicitud = solicitudesModel::where('id_tipo', 3)
            ->get()
            ->first(function ($item) use ($id_lote_granel) {
                $car = is_string($item->caracteristicas)
                    ? json_decode($item->caracteristicas, true)
                    : $item->caracteristicas;

                return is_array($car) && ($car['id_lote_granel'] ?? null) == $id_lote_granel;
            });


    }
}

        if ($solicitud) {
            $url_acta = Documentacion_url::where('id_relacion', $solicitud->id_solicitud)
                ->where('id_documento', 69)
                ->value('url');
        }

        if ($solicitud) {
            $url_proforma = Documentacion_url::where('id_relacion', $solicitud->id_solicitud)
                ->where('id_documento', 55)
                ->value('url');
        }

        if ($solicitud->lote_granel) {
            $url_certificado_granel = Documentacion_url::where('id_relacion', $solicitud->lote_granel->id_lote_granel)
                ->where('id_documento', 59)
                ->value('url');

            $url_fqs = Documentacion_url::where('id_relacion', $solicitud->lote_granel->id_lote_granel)
    ->where(function ($query) {
        $query->where('id_documento', 58)
              ->orWhere('id_documento', 134);
    })
    ->value('url');

        }



    // Obtener guías si están definidas en características
      $guias = [];
      $caracteristicas = is_string($solicitud->caracteristicas)
          ? json_decode($solicitud->caracteristicas, true)
          : $solicitud->caracteristicas;

      if (isset($caracteristicas['id_guia']) && is_array($caracteristicas['id_guia'])) {
          $guias = guias::whereIn('id_guia', $caracteristicas['id_guia'])->get();
      }



    return response()->json([
        'success' => true,
        'data' => $solicitud,
        'documentos' => $documentos,
        'url_etiqueta' => $url_etiqueta ?? '',
        'url_corrugado' => $url_corrugado ?? '',
        'url_acta' => $url_acta ?? '',
        'url_proforma' => $url_proforma ?? '',
        'url_certificado_granel' => $url_certificado_granel ?? '',
        'url_fqs' => $url_fqs ?? '',
        'fecha_visita_formateada' => Helpers::formatearFechaHora($solicitud->fecha_visita),
        'tipos_agave' => $tipos,
        'lotesEnvasado' => $lotesEnvasado,
        'guias' => $guias,
    ]);
}



    //Este por ahora no se usa para nada, pero lo dejo para un futuro
    public function obtenerDocumentosClientes($id_cliente)
    {
    $documento = Documentacion_url::where("id_empresa", "=", $id_cliente)
                                  ->first(); // Devuelve el primer registro que coincida



        if ($documento) {
            return response()->json([
                'success' => true,
                'data' => $documento,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró documento.',
            ]);
        }
    }










}
