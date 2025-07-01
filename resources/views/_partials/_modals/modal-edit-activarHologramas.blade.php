<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="edit_activarHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar activación de hologramas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="edit_activarHologramasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_solicitudActivacion" name="edit_id_solicitudActivacion"
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
                                <select onchange="cargarInfoServicioEdit();" id="edit_id_inspeccion" name="edit_id_inspeccion"
                                    class="form-select select2" aria-label="Default select example">
                                    <option value="" disabled selected>Elige un numero de inspección</option>
                                    @foreach ($inspeccion as $insp)
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} |
                                            {{ $insp->solicitud->folio }} | {{ $insp->solicitud->tipo_solicitud->tipo }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="edit_id_inspeccion">No. de servicio</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div id="contenedorActa"></div>
                        </div>
                                                
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_folio_activacion"
                                    placeholder="Introduce el folio" name="edit_folio_activacion"
                                    aria-label="Nombre del lote" />
                                <label for="edit_folio_activacion">Folio de activación:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_no_lote_agranel"
                                    placeholder="Introduce el nombre del lote" name="edit_no_lote_agranel"
                                    aria-label="Nombre del lote" />
                                <label for="edit_no_lote_agranel">No. de lote granel:</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_certificado_granel"
                                    placeholder="Introduce el folio del certificado granel" name="edit_certificado_granel"
                                    aria-label="Certificado granel" />
                                <label for="edit_certificado_granel">Certificado granel:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class=" form-select" id="edit_categoria" name="edit_categoria" aria-label="categoría">
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
                                <select class=" form-select" id="edit_clase" name="edit_clase" aria-label="edit_clase">
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                <label for="clase">Clase</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select multiple class=" form-select select2" id="edit_id_tipo" name="edit_id_tipo"
                                    aria-label="tipo">
                                    <option value="" disabled>Elige un tipo</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }} ({{ $tipo->cientifico }})</option>
                                    @endforeach
                                </select>
                                <label for="edit_id_tipo">Tipo Agave</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" step="0.01"
                                    placeholder="Contenido neto por botellas (ml/L):" id="edit_cont_neto" name="edit_cont_neto" />
                                <label for="edit_cont_neto">Contenido neto por botellas (ml/L):</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="unidad" name="unidad" aria-label="Unidad">
                                    <option value="Litros">Litros</option>
                                    <option value="Mililitros">Mililitros</option>
                                    <option value="Centilitros">Centilitros</option>
                                </select>
                                <label for="unidad">Unidad</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="No. de lote de envasado:"
                                    id="edit_no_lote_envasado" name="edit_no_lote_envasado" />
                                <label for="edit_no_lote_envasado">No. de lote de envasado:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="No de análisis de laboratorio:"
                                    id="edit_no_analisis" name="edit_no_analisis" />
                                <label for="edit_no_analisis">No de análisis de laboratorio:</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Contenido Alcohólico:"
                                    id="edit_contenido" name="edit_contenido" />
                                <label for="edit_contenido">Contenido Alcohólico:</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Edad"
                                    id="edit_edad" name="edit_edad" />
                                <label for="edit_edad">Edad:</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" placeholder="Lugar de producción:"
                                    id="edit_lugar_produccion" name="edit_lugar_produccion" />
                                <label for="edit_lugar_produccion">Lugar de producción: </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="text" step="0.01"
                                    placeholder="Lugar de envasado:" id="edit_lugar_envasado" name="edit_lugar_envasado" />
                                <label for="edit_lugar_envasado">Lugar de envasado:</label>
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
                        <tbody id="edit_contenidoRango">
                            <tr class="folio-row">
                                <td>
                                    <button type="button" class="btn btn-danger remove-row" disabled>
                                        <i class="ri-delete-bin-5-fill"></i>
                                    </button>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm folio_inicial"
                                        name="rango_inicial[]" min="0" placeholder="Rango inicial">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm folio_final"
                                        name="rango_final[]" min="0" placeholder="Rango final">
                                </td>
                                <td class="subtotal"></td>
                                <td>
                                    <div class="mensaje alert" style="display:none;"></div>
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
                        <button id="btnRegistrar" type="submit" class="btn btn-primary">Editar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function cargarInfoServicioEdit() {
        var id_inspeccion = $('#id_inspeccion').val();
        if (id_inspeccion) {
            $.ajax({
                url: '/getDatosInpeccion/' + id_inspeccion,
                method: 'GET',
                dataType: 'json', // Especificar que la respuesta es JSON
                success: function(response) {
                    // Agregar el enlace dentro de un contenedor específico
                    $('#contenedorActa').html(`
            <a id="url_acta" target="_blank" href="/files/${response.numero_cliente}/${response.url_acta[0]}">
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
