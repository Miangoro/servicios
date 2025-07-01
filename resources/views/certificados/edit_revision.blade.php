@extends('layouts/layoutMaster')

@section('title', 'Revisión de certificado')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection
<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/certificados_personal.js'])
@endsection

@php
    use App\Helpers\Helpers;
@endphp

<style>
    td {
        padding: 0.04rem !important;
    }

    th {
        color: black !important;
        font-weight: bold !important;
        font-size: 15px !important;
    }
</style>
@section('content')

    <div class="container mt-3 mb-3">
        <div class="card shadow-sm border-0 rounded-3" style="max-width: 100%; margin: auto;">
            <div class="card-header bg-primary text-white text-center py-2">
                <h5 class="mb-0 text-white">Editar revisión de certificado personal</h5>
            </div>
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Tipo de certificado</p>
                        <h5 class="fw-semibold mb-2">{{ $tipo }}</h5>
                        @if ($datos->es_correccion === 'si')
                            <span class="badge bg-danger">Es corrección</span>
                        @endif

                        @if ($datos->certificado->certificadoReexpedido())
                            @php
                                $nuevoId = $datos->certificado->certificadoReexpedido()?->id_certificado;
                                $urlConNuevoId = $nuevoId ? preg_replace('/\d+$/', $nuevoId, $url) : null;
                            @endphp


                            <p>Este certificado sustituye al certificado <a target="_blank"
                                    href="{{ $urlConNuevoId ?? 'N/A' }}">{{ $datos->certificado->certificadoReexpedido()->num_certificado }}</a>
                                @php
                                    $obs = json_decode($datos->certificado->certificadoReexpedido()?->observaciones);
                                @endphp

                                @if (!empty($obs?->observaciones))
                                    <p><strong>Motivo:</strong> {{ $obs->observaciones }}</p>
                                @endif



                            </p>
                        @endif
                        @if ($datos->observaciones)
                            <p><strong>Observaciones:</strong> {{ $datos->observaciones }}</p>
                        @endif
                        @if (!empty($datos->evidencias) && count($datos->evidencias) > 0)
                            @foreach ($datos->evidencias as $evidencia)
                                @if (!empty($evidencia))
                                    <b>{{ $evidencia->nombre_documento }}</b>
                                    <a target="_blank" href="/storage/revisiones/{{ $evidencia->url }}">
                                        <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                    </a>
                                @endif
                            @endforeach
                        @endif

                    </div>
                    <div>
                        <p class="text-muted mb-1">Cliente</p>
                        <h5 class="fw-semibold mb-2">
                            {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</h5>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Revisor</p>
                        <h5 class="fw-semibold mb-0">{{ $datos->user->name ?? 'N/A' }}</h5>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Certificado</p>
                        <a target="_blank" href="{{ $url ?? 'N/A' }}"><i
                                class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- DataTable with Buttons -->
    <form id="formularioEditar" method="POST">
        @csrf
        <input type="hidden" id="id_revision" name="id_revision" value="{{ $datos->id_revision }}">
        <input type="hidden" name="numero_revision" value="{{ $datos->numero_revision }}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-datatable table-responsive pt-0">
                        <table class="table table-bordered table-sm table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pregunta</th>
                                    <th>Documento</th>
                                    <th>Respuesta</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($preguntas as $index => $pregunta)

                                    @php
                                        $respuesta = $respuestas_map[$pregunta->id_pregunta] ?? null;
                                        $respuesta_actual = $respuesta['respuesta'] ?? null;
                                    @endphp
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th>{{ $pregunta->pregunta }} <input value="{{ $pregunta->id_pregunta }}"
                                                type="hidden" name="id_pregunta[]"></th>

                                        @if ($pregunta->documentacion?->documentacionUrls && $pregunta->id_documento != 69)
                                            @php
                                                $cliente = $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere(
                                                    'numero_cliente',
                                                    '!=',
                                                    null,
                                                );
                                                $documento = $datos->obtenerDocumentosClientes(
                                                    $pregunta->id_documento,
                                                    $datos->certificado->dictamen->inspeccione->solicitud->empresa
                                                        ->id_empresa,
                                                );
                                            @endphp

                                            <td>
                                                @if ($pregunta->documentacion?->documentacionUrls && $pregunta->id_documento != 69 && $cliente && $documento)
                                                    <a target="_blank"
                                                        href="{{ '../files/' . $cliente->numero_cliente . '/' . $documento }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin documento</span>
                                                @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'nombre_empresa')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</b>
                                            </td>
                                        @elseif ($pregunta->filtro == 'num_certificado')
                                            <td><b
                                                    class="text-danger">{{ $datos->certificado->num_certificado ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'direccion_fiscal')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'solicitud_exportacion')
                                            <td>
                                                <a target="_blank"
                                                    href="/solicitud_certificado_exportacion/{{ $datos->certificado->id_certificado ?? 'N/A' }}">
                                                    <i
                                                        class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                </a>
                                            </td>
                                        @elseif($pregunta->filtro == 'domicilioEnvasado')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->instalacion_envasado->direccion_completa ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'pais')
                                            <td><b>C.P.:
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->cp ?? 'N/A' }}
                                                    País: México</b></td>
                                        @elseif($pregunta->filtro == 'destinatario')
                                            <td><b>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->destinatario ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->direccion ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'N/A' }}
                                                </b></td>
                                        @elseif($pregunta->filtro == 'solicitud')
                                            <td>
                                                <a target="_blank"
                                                    href="/solicitud_de_servicio/{{ $datos->certificado->dictamen->inspeccione->id_solicitud ?? 'N/A' }}">
                                                    <i
                                                        class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                </a>
                                                <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->folio ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'categoria_clase')
                                            <td><b>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'N/A' }}<br>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->clase->clase ?? 'N/A' }}
                                                    @foreach ($datos->certificado->dictamen->inspeccione->solicitud->lote_granel->tiposRelacionados as $tipo)
                                                        <br>
                                                        {{ $tipo->nombre }} <i>({{ $tipo->cientifico }})</i>
                                                    @endforeach
                                                    <br>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->marca->marca ?? 'N/A' }}
                                                </b></td>
                                        @elseif($pregunta->filtro == 'volumen')
                                            <td><b>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->presentacion ?? 'N/A' }}
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->unidad ?? '' }}

                                                </b></td>
                                        @elseif($pregunta->filtro == 'volumen_granel')
                                            <td><b>
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->volumen ?? 'N/A' }}
                                                    L

                                                </b></td>
                                        @elseif($pregunta->filtro == 'cont_alc')
                                            <td><b>{{ round($datos->certificado->dictamen->inspeccione->solicitud->lote_granel->cont_alc) ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'nbotellas')
                                            @php
                                                $caracteristicas = json_decode(
                                                    $datos->certificado->dictamen->inspeccione->solicitud
                                                        ->caracteristicas,
                                                    true,
                                                );
                                                $detalle = $caracteristicas['detalles'][0] ?? null;
                                            @endphp

                                            <td>
                                                <b>
                                                    {{ $detalle['cantidad_botellas'] ?? 'N/A' }} Botellas<br>
                                                    {{ $detalle['cantidad_cajas'] ?? 'N/A' }} Cajas
                                                </b>
                                            </td>
                                        @elseif($pregunta->filtro == 'lotes')
                                            <td><b>GRANEL:
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote ?? 'N/A' }}</b><br>
                                                <b>ENVASADO:
                                                    {{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->nombre ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'lote_granel')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'nanalisis')
                                            @php
                                                $folioFq =
                                                    $datos->certificado->dictamen->inspeccione->solicitud->lote_granel
                                                        ->folio_fq ?? '';

                                                // Explota y limpia
                                                $folios = collect(explode(',', $folioFq))
                                                    ->map(fn($f) => trim($f))
                                                    ->filter()
                                                    ->values();

                                                $primerFolio = $folios->get(0, 'N/A');
                                                $segundoFolio = $folios->get(1, 'N/A');
                                            @endphp
                                            <td>


                                                @foreach ($datos->certificado->dictamen->inspeccione->solicitud->lote_granel->fqs as $documento)
                                                    <a target="_blank"
                                                        href="/files/{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente }}/fqs/{{ $documento->url }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                    </a>
                                                @endforeach
                                                <b>{{ $primerFolio }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'nanalisis_ajuste')
                                            <td><b>{{ $segundoFolio }}</b></td>
                                        @elseif($pregunta->filtro == 'aduana')
                                            <td><b>
                                                    {{ json_decode($datos->certificado->dictamen->inspeccione->solicitud->caracteristicas, true)['aduana_salida'] ?? 'N/A' }}
                                                    2208.90.05.00
                                                    <br>
                                                    @foreach ($datos->certificado->dictamen->inspeccione->solicitud->documentacion(55)->get() as $documento)
                                                        <a target="_blank"
                                                            href="/files/{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere(
                                                                'numero_cliente',
                                                                '!=',
                                                                null,
                                                            )->numero_cliente }}/{{ $documento->url }}">
                                                            <i
                                                                class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                        </a>
                                                    @endforeach
                                                    {{ json_decode($datos->certificado->dictamen->inspeccione->solicitud->caracteristicas, true)['no_pedido'] ?? 'N/A' }}

                                                </b><br></td>
                                        @elseif($pregunta->filtro == 'domicilio_insta')
                                            <td>
                                                <b>
                                                    {{ $datos->certificado->dictamen->instalaciones->direccion_completa ??
                                                        ($datos->certificado->dictamen->inspeccione->solicitud->instalaciones->direccion_completa ?? 'NA') }}
                                                </b>
                                            </td>
                                        @elseif($pregunta->filtro == 'correo')
                                            <td>
                                                <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->correo ?? 'N/A' }}</b><br>
                                                <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->empresa->telefono ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'fechas')
                                            <td>
                                                <b>{{ $datos?->certificado?->fecha_emision ? Helpers::formatearFecha($datos->certificado->fecha_emision) : 'NA' }}</b><br>
                                                <b>{{ $datos?->certificado?->fecha_vigencia ? Helpers::formatearFecha($datos->certificado->fecha_vigencia) : 'NA' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'num_dictamen')
                                            @php
                                                // Determina tipo y URL del certificado
                                                $tipo = 'Desconocido';
                                                $url = null;

                                                $dictamen = $datos->certificado?->dictamen;

                                                if ($datos->tipo_certificado == 1 && $datos->certificado?->dictamen) {
                                                    // Certificado normal con dictamen
                                                    $id_dictamen = $datos->certificado->dictamen->tipo_dictamen ?? null;

                                                    switch ($id_dictamen) {
                                                        case 1:
                                                            $tipo = 'Instalaciones de productor';
                                                            $url = '/dictamen_productor/' . $dictamen->id_dictamen;
                                                            break;
                                                        case 2:
                                                            $tipo = 'Instalaciones de envasador';
                                                            $url = '/dictamen_envasador/' . $dictamen->id_dictamen;
                                                            break;
                                                        case 3:
                                                            $tipo = 'Instalaciones de comercializador';
                                                            $url =
                                                                '/dictamen_comercializador/' . $dictamen->id_dictamen;
                                                            break;
                                                        case 4:
                                                            $tipo = 'Instalaciones de almacén y bodega';
                                                            $url = '/dictamen_almacen/' . $dictamen->id_dictamen;
                                                            break;
                                                        case 5:
                                                            $tipo = 'Instalaciones de área de maduración';
                                                            $url = '/dictamen_bodega/' . $dictamen->id_dictamen;
                                                            break;
                                                        default:
                                                            $tipo = 'Desconocido';
                                                    }
                                                } elseif ($datos->tipo_certificado == 2) {
                                                    $tipo = 'Granel';
                                                    $url = '/dictamen_granel/' . $dictamen->id_dictamen;
                                                } elseif ($datos->tipo_certificado == 3) {
                                                    $tipo = 'Exportación';
                                                    $url = '/dictamen_envasado/' . $dictamen->id_dictamen;
                                                }

                                            @endphp

                                            <td>
                                                @if ($dictamen)
                                                    @if ($url)
                                                        <a target="_blank" href="{{ $url }}">
                                                            <i
                                                                class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                        </a>
                                                    @else
                                                        <span>Dictamen no disponible</span>
                                                    @endif
                                                @else
                                                    <span>Dictamen no disponible</span>
                                                @endif
                                                <b>{{ $dictamen->num_dictamen }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'certificado_granel')
                                            <td> <a target="_blank"
                                                    href="/Pre-certificado-granel/{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->certificadoGranel->id_certificado }}">
                                                    <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                </a>
                                                Granel:
                                                <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->nombre_lote ?? 'N/A' }}</b>

                                                <br>
                                                <a target="_blank"
                                                    href="/dictamen_envasado/{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->dictamenEnvasado->id_dictamen }}">
                                                    <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                </a>

                                                Envasado:
                                                <b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->nombre ?? 'N/A' }}</b>

                                            </td>
                                        @elseif($pregunta->filtro == 'categoria')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'ingredientes')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->ingredientes ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'edad')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->edad ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'marca')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_envasado->marca->marca ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'clase')
                                            <td><b>{{ $datos->certificado->dictamen->inspeccione->solicitud->lote_granel->clase->clase ?? 'N/A' }}</b>
                                            </td>
                                        @elseif($pregunta->filtro == 'tipo_maguey')
                                            <td>
                                                <b>
                                                    @forelse ($datos->certificado->dictamen->inspeccione->solicitud->lote_granel->tiposRelacionados as $tipo)
                                                        {{ $tipo->nombre }} (<i>{{ $tipo->cientifico }}</i>),
                                                    @empty
                                                        N/A
                                                    @endforelse
                                                </b>
                                            </td>
                                        @elseif($pregunta->filtro == 'responsable')
                                            <td><b>{{ $datos->certificado->firmante->name ?? 'N/A' }}</b></td>
                                        @elseif($pregunta->filtro == 'direccion_cidam')
                                            <td><b>Kilómetro 8. Antigua carretera a Pátzcuaro, S/N.
                                                    Col. Otra no especificada en el catálogo.
                                                    C.P. 58341. Morelia, Michoacán. México.</b></td>
                                        @elseif($pregunta->filtro == 'alcance')
                                            <td><b> NOM070-SCFI-2016, Bebidas Alcohólicas-Mezcal-Especificaciones.</b></td>
                                        @elseif($pregunta->filtro == 'cliente')
                                            <td><b>
                                                    {{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->filter(fn($cliente) => !empty($cliente->numero_cliente))->first()?->numero_cliente ?? 'Sin asignar' }}
                                                </b></td>
                                        @elseif($pregunta->filtro == 'acta')
                                            <td>
                                                @if ($datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud))
                                                    <a target="_blank"
                                                        href="{{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere(
                                                            'numero_cliente',
                                                            '!=',
                                                            null,
                                                        )?->numero_cliente
                                                            ? '../files/' .
                                                                $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere(
                                                                    'numero_cliente',
                                                                    '!=',
                                                                    null,
                                                                )->numero_cliente .
                                                                '/actas/' .
                                                                $datos->obtenerDocumentoActa($pregunta->id_documento, $datos->certificado->dictamen->inspeccione->id_solicitud)
                                                            : 'NA' }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                    <b>{{ $datos->certificado->dictamen->inspeccione->num_servicio }}</b>
                                                @else
                                                    <span class="text-muted">Sin acta</span>
                                                @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'etiqueta')
                                            <td>
                                                @if ($datos->certificado->dictamen->inspeccione->solicitud->etiqueta())
                                                    <a target="_blank"
                                                        href="{{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere(
                                                            'numero_cliente',
                                                            '!=',
                                                            null,
                                                        )?->numero_cliente
                                                            ? '../files/' .
                                                                $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere(
                                                                    'numero_cliente',
                                                                    '!=',
                                                                    null,
                                                                )->numero_cliente .
                                                                '/' .
                                                                $datos->certificado->dictamen->inspeccione->solicitud->etiqueta()
                                                            : 'NA' }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin etiqueta</span>
                                                @endif
                                            </td>
                                        @elseif($pregunta->filtro == 'corrugado')
                                            <td>
                                                @if ($datos->certificado->dictamen->inspeccione->solicitud->corrugado())
                                                    <a target="_blank"
                                                        href="{{ $datos?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere(
                                                            'numero_cliente',
                                                            '!=',
                                                            null,
                                                        )?->numero_cliente
                                                            ? '../files/' .
                                                                $datos->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere(
                                                                    'numero_cliente',
                                                                    '!=',
                                                                    null,
                                                                )->numero_cliente .
                                                                '/' .
                                                                $datos->certificado->dictamen->inspeccione->solicitud->corrugado()
                                                            : 'NA' }}">
                                                        <i
                                                            class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">Sin corrugado</span>
                                                @endif
                                            </td>
                                        @else
                                            <td>Sin datos</td>
                                        @endif
                                        <td>
                                            <div class="resp">
                                                <select class="form-select form-select-sm" aria-label="Elige la respuesta"
                                                    name="respuesta[]">
                                                    <option value="" disabled
                                                        {{ $respuesta_actual == null ? 'selected' : '' }}>Seleccione
                                                    </option>
                                                    <option value="C"
                                                        {{ $respuesta_actual == 'C' ? 'selected' : '' }}>C</option>
                                                    <option value="NC"
                                                        {{ $respuesta_actual == 'NC' ? 'selected' : '' }}>NC</option>
                                                    <option value="NA"
                                                        {{ $respuesta_actual == 'NA' ? 'selected' : '' }}>NA</option>
                                                </select>

                                            </div>
                                        </td>

                                        <td>
                                            <textarea name="observaciones[{{ $index }}]" rows="1" name="" id="" class="form-control"
                                                placeholder="Observaciones">{{ $respuesta['observacion'] ?? '' }}</textarea>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-4">
                                                        <iframe width="100%" height="80%" id="pdfViewerDictamenFrame" src="{{ $url }}" frameborder="0"
                                                            style="border-radius: 10px; overflow: hidden;">
                                                        </iframe>
                                                    </div>-->

            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-primary me-2 waves-effect waves-light"><i
                        class="ri-pencil-fill"></i> Editar {{ $datos->numero_revision }}ª revisión</button>
                <a href="/revision/personal" class="btn btn-danger waves-effect"><i
                        class="ri-close-line"></i>Cancelar</a>
            </div>

        </div>
    </form>


@endsection
