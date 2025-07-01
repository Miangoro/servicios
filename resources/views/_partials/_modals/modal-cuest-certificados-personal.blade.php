@php
    use App\Helpers\Helpers;
@endphp

<!-- Modal -->
<div class="modal fade" id="fullscreenModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen" role="document">
        <div class="modal-content">
            <div style="border-bottom: 2px solid #E0E1E3; background-color: #F2F3F4;">
                <div class="modal-header" style="margin-bottom: 20px;">
                    <h5 class="modal-title custom-title" id="modalFullTitle" style="font-weight: bold;"></h5>
                    <span style="font-weight: normal; margin-left: 10px; color: #3498db; text-transform: uppercase; font-weight: bold;">
                        {{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A'}}
                    </span>
                    <span style="font-weight: normal; margin-left: 5px; color: #000000; text-transform: uppercase; font-weight: bold;">
                        / <!-- Guion en negro -->
                    </span>
                    <span style="font-weight: normal; margin-left: 5px; color: #e74c3c; text-transform: uppercase; font-weight: bold;">
                        {{ $revisor->user->name ?? 'N/A'}}
                    </span>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <div class="modal-body d-flex" >
                <!-- Contenido Principal -->
                <div class="main-content" style="flex: 1; padding: 15px; height: 100vh; display: flex; flex-direction: column; gap: 10px; margin-top: -20px;">

                    <div class="row">
                        <div class="col-md-7">
                            <div style="border: 1px solid #8DA399; padding: 20px; border-radius: 5px; margin-bottom: 30px;">
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    <div class="table-container" style="flex: 1; min-width: 250px;">
                                        <table class="table table-responsive table-sm table-bordered table-hover table-striped" style="font-size: 12px;">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th style="font-size: 11px;">#</th>
                                                    <th style="font-size: 11px;">Pregunta</th>
                                                    <th style="font-size: 11px;">Documento</th>
                                                    <th style="font-size: 11px;">Respuesta</th>
                                                    <th style="font-size: 11px;">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $contador = 1; @endphp

                                                <!-- Preguntas de tipo Revisor (Instalaciones) -->
                                                @if($preguntasRevisor->isNotEmpty())
                                                    <tbody id="revisor">
                                                        @foreach($preguntasRevisor as $index => $pregunta)
                                                            <tr>
                                                                <td>{{ $contador++ }}</td>
                                                                <td>{{ $pregunta->pregunta }}</td>

                                                                @if($pregunta->documentacion?->documentacionUrls && $pregunta->id_documento != 69)
                                                                    <td>
                                                                        <a target="_blank" href="{{ $revisor?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere('numero_cliente', '!=', null)?->numero_cliente
                                                                        ? '../files/' . $revisor->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente . '/' .
                                                                            $revisor->obtenerDocumentosClientes($pregunta->id_documento, $revisor->certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)
                                                                            : 'NA' }}">
                                                                           <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                                        </a>
                                                                    </td>
                                                                @elseif($pregunta->filtro == 'acta')
                                                                <td>
                                                                    @if($revisor->obtenerDocumentoActa($pregunta->id_documento, $revisor->certificado->dictamen->inspeccione->id_solicitud) )
                                                                    <b>{{ $revisor->certificado->dictamen->inspeccione->num_servicio }}</b>
                                                                    <a target="_blank" href="{{ $revisor?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->firstWhere('numero_cliente', '!=', null)?->numero_cliente
                                                                        ? '../files/' . $revisor->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->firstWhere('numero_cliente', '!=', null)->numero_cliente . '/' .
                                                                          $revisor->obtenerDocumentoActa($pregunta->id_documento, $revisor->certificado->dictamen->inspeccione->id_solicitud)
                                                                        : 'NA' }}">
                                                                        <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                                    </a>

                                                                    @endif
                                                                </td>
                                                                @elseif($pregunta->filtro == 'cliente')
                                                                <td><b>
                                                                    {{ $revisor?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes
                                                                        ->filter(fn($cliente) => !empty($cliente->numero_cliente))
                                                                        ->first()?->numero_cliente ?? 'Sin asignar' }}
                                                                </b></td>


                                                                @elseif($pregunta->filtro == 'nombre_empresa')
                                                                    <td><b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</b></td>

                                                                @elseif($pregunta->filtro == 'direccion_fiscal')
                                                                    <td><b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'N/A' }}</b></td>

                                                                @elseif($pregunta->filtro == 'solicitud')
                                                                    <td>
                                                                        <b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->folio ?? 'N/A' }}</b>
                                                                        <a target="_blank" href="/solicitud_de_servicio/{{ $revisor->certificado->dictamen->inspeccione->id_solicitud ?? 'N/A' }}">
                                                                            <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"></i>
                                                                        </a>
                                                                    </td>

                                                                @elseif($pregunta->filtro == 'num_certificado')
                                                                    <td><b class="text-danger">{{ $revisor->certificado->num_certificado ?? 'N/A' }}</b></td>

                                                                @elseif($pregunta->filtro == 'domicilio_insta')
                                                                    <td><b>{{ $revisor->certificado->dictamen->instalaciones->direccion_completa ?? 'N/A' }}</b></td>
                                                                @elseif($pregunta->filtro == 'correo')
                                                                    <td>
                                                                        <b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->correo ?? 'N/A' }}</b><br>
                                                                        <b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->telefono ?? 'N/A' }}</b>
                                                                    </td>
                                                                @elseif($pregunta->filtro == 'fechas')
                                                                    <td>
                                                                        <b>{{ $revisor?->certificado?->fecha_vigencia ? Helpers::formatearFecha($revisor->certificado->fecha_vigencia) : 'NA' }}</b><br>
                                                                        <b>{{ $revisor?->certificado?->fecha_vencimiento ? Helpers::formatearFecha($revisor->certificado->fecha_vencimiento) : 'NA' }}</b>
                                                                    </td>
                                                                @elseif($pregunta->filtro == 'num_dictamen')
                                                                <td>
                                                                    @php
                                                                        $dictamenRutas = [
                                                                            1 => "/dictamen_productor/",
                                                                            2 => "/dictamen_envasador/",
                                                                            3 => "/dictamen_comercializador/",
                                                                            4 => "/dictamen_almacen/",
                                                                            5 => "/dictamen_bodega/",
                                                                        ];

                                                                        $tipoDictamen = $revisor->certificado->dictamen->tipo_dictamen ?? null;
                                                                        $pdf_dictamen = $dictamenRutas[$tipoDictamen] ?? null;
                                                                    @endphp

                                                                    <b>{{ $revisor->certificado->dictamen->num_dictamen ?? 'N/A' }}</b>

                                                                    @if ($pdf_dictamen)
                                                                        <a target="_blank" href="{{ $pdf_dictamen.$revisor->certificado->dictamen->id_dictamen }}">
                                                                            <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                                        </a>
                                                                    @else
                                                                        <span>Dictamen no disponible</span>
                                                                    @endif
                                                                </td>

                                                                @elseif($pregunta->filtro == 'responsable')
                                                                    <td><b>{{ $revisor->certificado->firmante->name ?? 'N/A' }}</b></td>
                                                                @elseif($pregunta->filtro == 'direccion_cidam')
                                                                    <td><b>Kilómetro 8. Antigua carretera a Pátzcuaro, S/N.
                                                                        Col. Otra no especificada en el catálogo.
                                                                        C.P. 58341. Morelia, Michoacán. México.</b></td>
                                                                 @elseif($pregunta->filtro == 'alcance')
                                                                    <td><b> NOM070-SCFI-2016, Bebidas Alcohólicas-Mezcal-Especificaciones.</b></td>



                                                                @else
                                                                    <td>Sin datos</td>
                                                                @endif

                                                                <td>
                                                                    <select class="form-select form-select-sm" aria-label="Elige la respuesta" name="respuesta[{{ $index }}]">
                                                                        <option value="" selected></option>
                                                                        <option value="1">C</option>
                                                                        <option value="2">NC</option>
                                                                        <option value="3">NA</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea rows="1" name="" id="" class="form-control" placeholder="Observaciones"></textarea>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                @endif

                                                <!-- Preguntas de tipo RevisorGranel -->
                                                @if($preguntasRevisorGranel->isNotEmpty())
                                                    <tbody id="revisorGranel">
                                                        @foreach($preguntasRevisorGranel as $index => $pregunta)
                                                            <tr>
                                                                <td>{{ $contador++ }}</td>
                                                                <td>{{ $pregunta->pregunta }}</td>

                                                                @if($pregunta->documentacion?->documentacionUrls)
                                                                    <td>
                                                                        <a target="_blank" href="{{ $revisor?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->isNotEmpty() ?
                                                                            '../files/' . $revisor->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes[0]->numero_cliente . '/' .
                                                                            $revisor->obtenerDocumentosClientes($pregunta->id_documento, $revisor->certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)
                                                                            : 'NA' }}">
                                                                            <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                                        </a>
                                                                    </td>
                                                                @else
                                                                    <td>Sin datos</td>
                                                                @endif

                                                                <td>
                                                                    <select class="form-select form-select-sm" aria-label="Elige la respuesta" name="respuesta[{{ $index }}]">
                                                                        <option value="" selected>Selecciona</option>
                                                                        <option value="1">C</option>
                                                                        <option value="2">NC</option>
                                                                        <option value="3">NA</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea rows="1" name="" id="" class="form-control" placeholder="Observaciones"></textarea>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                @endif


                                                    <!-- Preguntas de tipo preguntasRevisorExportacion -->
                                                    @if($preguntasRevisorExportacion->isNotEmpty())
                                                    <tbody id="revisorExportacion">
                                                        @foreach($preguntasRevisorExportacion as $index => $pregunta)
                                                            <tr>
                                                                <td>{{ $contador++ }}</td>
                                                                <td>{{ $pregunta->pregunta }}</td>

                                                                @if($pregunta->filtro == 'num_certificado')
                                                                <td><b class="text-danger">{{ $revisor->certificado->num_certificado ?? 'N/A' }}</b></td>

                                                                @elseif($pregunta->filtro == 'direccion_fiscal')
                                                                    <td><b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'N/A' }}</b></td>

                                                                @elseif($pregunta->filtro == 'pais')
                                                                <td><b>México</b></td>

                                                                @elseif($pregunta->filtro == 'cp')
                                                                <td><b>{{ $revisor->certificado->dictamen->inspeccione->solicitud->empresa->cp ?? 'N/A' }}</b></td>

                                                                @elseif($pregunta->documentacion?->documentacionUrls)
                                                                    <td>
                                                                        <a target="_blank" href="{{ $revisor?->certificado?->dictamen?->inspeccione?->solicitud?->empresa?->empresaNumClientes->isNotEmpty() ?
                                                                            '../files/' . $revisor->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes[0]->numero_cliente . '/' .
                                                                            $revisor->obtenerDocumentosClientes($pregunta->id_documento, $revisor->certificado->dictamen->inspeccione->solicitud->empresa->id_empresa)
                                                                            : 'NA' }}">
                                                                            <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
                                                                        </a>
                                                                    </td>
                                                                @else
                                                                    <td>Sin datos</td>
                                                                @endif

                                                                <td>
                                                                    <select class="form-select form-select-sm" aria-label="Elige la respuesta" name="respuesta[{{ $index }}]">
                                                                        <option value="" selected>Selecciona</option>
                                                                        <option value="1">C</option>
                                                                        <option value="2">NC</option>
                                                                        <option value="3">NA</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea rows="1" name="" id="" class="form-control" placeholder="Observaciones"></textarea>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                @endif



                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center mt-3" id="Registrar">
                                    <button type="button" class="btn btn-primary" id="registrarRevision">
                                        Registrar Revisión
                                    </button>
                                </div>
                                <div class="text-center mt-3" id="Editar">
                                    <button type="button" class="btn btn-warning" id="editarRevision">
                                        Editar Respuestas
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 position-relative" style="height: 80%;">
                            <div id="modal-loading-spinner" class="text-center" style="display: none;
                                 position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 10;
                                 display: flex; justify-content: center; align-items: center;">
                                <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;">
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                    <div class="sk-circle-fade-dot"></div>
                                </div>
                            </div>
                            <input type="hidden" id="id_revision" value="">

                            <iframe width="100%" height="80%" id="pdfViewerDictamenFrame"
                                    src=""
                                    frameborder="0"
                                    style="border-radius: 10px; overflow: hidden;">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if($noCertificados)
    <script>
        const userName = "{{ auth()->user()->name }}";

        Swal.fire({
            icon: 'info',
            title: 'Sin Asignaciones',
            html: `<b>${userName}</b>, no tienes certificados asignados.`,
        });
    </script>
@endif
