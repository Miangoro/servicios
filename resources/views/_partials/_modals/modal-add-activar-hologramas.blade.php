<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="activarHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Activar hologramas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="activarHologramasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_solicitudActivacion" name="id_solicitudActivacion"
                                    class="form-select select2" aria-label="Default select example">
                                    <option value="" disabled selected>Elige la solicitud de entrega</option>
                                    @foreach ($ModelsSolicitudHolograma as $solicitud)
                                        <option value="{{ $solicitud->id_solicitud }}">{{ $solicitud->folio }} |
                                            {{ $solicitud->marcas->marca }} |
                                            {{ number_format($solicitud->folio_inicial) }} -
                                            {{ number_format($solicitud->folio_final) }}</option>
                                    @endforeach
                                </select>
                                <label for="id_solicitud">Solicitud de entrega</label>
                            </div>
                        </div>

                        
                        

                        <div class="col-md-10">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="cargarInfoServicio();" id="id_inspeccion" name="id_inspeccion"
                                    class="form-select select2" aria-label="Default select example">
                                    <option value="" disabled selected>Elige un numero de inspección</option>
                                    @foreach ($inspeccion as $insp)
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} |
                                            {{ $insp->solicitud->folio }} | {{ $insp->solicitud->tipo_solicitud->tipo }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_inspeccion">No. de servicio</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div id="contenedorActa"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="folio_activacion"
                                    placeholder="Introduce el folio" name="folio_activacion"
                                    aria-label="Nombre del lote" />
                                <label for="folio_activacion">Folio de activación:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="no_lote_agranel"
                                    placeholder="Introduce el nombre del lote" name="no_lote_agranel"
                                    aria-label="Nombre del lote" />
                                <label for="no_lote_agranel">No. de lote granel:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="certificado_granel"
                                    placeholder="Introduce el folio del certificado granel" name="certificado_granel"
                                    aria-label="Certificado granel" />
                                <label for="certificado_granel">Certificado granel:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class=" form-select" id="categoria" name="categoria" aria-label="categoría">
                                    <option value="" disabled selected>Elige una categoría</option>
                                    @foreach ($categorias as $cate)
                                        <option value="{{ $cate->id_categoria }}">{{ $cate->categoria }}</option>
                                    @endforeach
                                </select>
                                <label for="categoria">Categoría Mezcal</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="clase" name="clase" aria-label="Clase">
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                <label for="clase">Clase</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select multiple class=" form-select select2" id="id_tipo" name="id_tipo"
                                    aria-label="tipo">
                                    <option value="" disabled>Elige un tipo</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }} ({{ $tipo->cientifico }})</option>
                                    @endforeach
                                </select>
                                <label for="id_tipo">Tipo Agave</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" step="0.01"
                                    placeholder="Contenido neto por botellas (ml/L):" id="cont_neto" name="cont_neto" />
                                <label for="cont_neto">Contenido neto por botellas (ml/L):</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="unidad" name="unidad" aria-label="Unidad">
                                    <option value="L">Litros</option>
                                    <option value="mL">Mililitros</option>
                                    <option value="cL">Centilitros</option>
                                </select>
                                <label for="unidad">Unidad</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="No. de lote de envasado:"
                                    id="no_lote_envasado" name="no_lote_envasado" />
                                <label for="no_lote_envasado">No. de lote de envasado:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="No de análisis de laboratorio:"
                                    id="no_analisis" name="no_analisis" />
                                <label for="no_analisis">No de análisis de laboratorio:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Contenido Alcohólico:"
                                    id="contenido" name="contenido" />
                                <label for="contenido">Contenido Alcohólico:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Edad"
                                    id="edad" name="edad" />
                                <label for="edad">Edad:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Lugar de producción:"
                                    id="lugar_produccion" name="lugar_produccion" />
                                <label for="lugar_produccion">Lugar de producción: </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" step="0.01"
                                    placeholder="Lugar de envasado:" id="lugar_envasado" name="lugar_envasado" />
                                <label for="lugar_envasado">Lugar de envasado:</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Activar</h4>
                        <p class="address-subtitle"></p>
                    </div>
                    <div style="display: none;" id="mensaje" role="alert"></div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><button type="button" class="btn btn-primary add-row-add"> <i
                                            class="ri-add-line"></i>
                                    </button></th>
                                <th>Rango inicial</th>
                                <th>Rango final</th>
                                <th>Total</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody id="contenidoRango">
                            <tr class="folio-row">
                                <th>
                                    <button type="button" class="btn btn-danger remove-row" disabled>
                                        <i class="ri-delete-bin-5-fill"></i>
                                    </button>
                                </th>
                                <td>
                                    <input type="number" class="form-control form-control-sm folio_inicial"
                                        name="rango_inicial[]" min="0" placeholder="Rango inicial">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm folio_final"
                                        name="rango_final[]" min="0" placeholder="Rango final">
                                </td>
                                <th class="subtotal"></th>
                                <td>
                                    <div class="mensaje alert" style="display:none;"></div>
                                    <!-- Se movió dentro de la fila -->
                                </td>
                            </tr>
                        </tbody>

                    </table>

                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Mermas (Opcional)</h4>
                        <p class="address-subtitle"></p>
                    </div>
                    {{--                     <div style="display: none;" id="mensaje" role="alert"></div>
 --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><button type="button" class="btn btn-primary add-row-addmermas"> <i
                                            class="ri-add-line"></i>
                                    </button></th>
                                <th>Mermas</th>
                            </tr>
                        </thead>
                        <tbody id="contenidoMermas">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button id="btnRegistrar" type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function cargarInfoServicio() {
       
         var id_inspeccion = $('#id_inspeccion').val();
        if (id_inspeccion) {
            $.ajax({
                url: '/getDatosInpeccion/' + id_inspeccion,
                method: 'GET',
                dataType: 'json', // Especificar que la respuesta es JSON
                success: function(response) {
                    // Agregar el enlace dentro de un contenedor específico
                    $('#contenedorActa').html(`
            <a id="url_acta" target="_blank" href="/files/${response.numero_cliente}/actas/${response.url_acta[0]}">
                <i class="ri-file-pdf-2-fill text-danger ri-40px cursor-pointer"></i>
            </a>
            `);
                     $('#folio_activacion').val(response.num_servicio);
                     $('#no_lote_agranel').val(response.solicitud.lote_envasado.lotes_granel[0].nombre_lote);
                    $('#certificado_granel').val(response.solicitud.lote_envasado.lotes_granel[0].certificadoGranel?.num_certificado);
                     $('#categoria').val(response.solicitud.lote_envasado.lotes_granel[0].id_categoria).trigger('change');
                     $('#clase').val(response.solicitud.lote_envasado.lotes_granel[0].id_clase).trigger('change');
                     $('#id_tipo').val(response.solicitud.lote_envasado.lotes_granel[0].tipo_lote).trigger('change');
                    $('#cont_neto').val(response.solicitud.lote_envasado.presentacion);
                    $('#unidad').val(response.solicitud.lote_envasado.unidad).trigger('change');
                    $('#no_analisis').val(response.solicitud.lote_envasado.lotes_granel[0].folio_fq);
                    $('#contenido').val(response.solicitud.lote_envasado.lotes_granel[0].cont_alc);
                    $('#no_lote_envasado').val(response.solicitud.lote_envasado.nombre);
                    $('#lugar_envasado').val(response.solicitud.instalacion?.direccion_completa);
                    $('#edad').val(response.solicitud.lote_envasado.lotes_granel[0].edad);

                },
                error: function(xhr) {
                    console.error('Error al obtener marcas:', xhr);
                    $('#tabla_marcas tbody').html(
                    '<tr><td colspan="8">Error al cargar los datos</td></tr>');
                }
            });
        }
    }
</script>
