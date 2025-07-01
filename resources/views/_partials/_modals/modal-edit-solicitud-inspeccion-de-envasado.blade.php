<div class="modal fade" id="editInspeccionEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de inspección de envasado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <p class="solicitud badge bg-primary"></p>
                <form id="editInspeccionEnvasadoForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_inspeccion">
                    <input type="hidden" name="form_type" value="inspeccionenvasado">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_inspeccion"
                                    onchange="editobtenerInstalacionesInspecciones();" name="id_empresa"
                                    class="id_empresa_inspeccion select2 form-select" required>
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    id="edit_fecha_visita" name="fecha_visita" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select select2" id="edit_id_instalacion_inspeccion"
                                    name="id_instalacion" aria-label="id_instalacion" required>
                                    <option value="" disabled selected>Lista de instalaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-4">
                        <p id="estado_datos_cliente" class="mb-0 address-subtitle text-primary">
                        </p>
                        <div id="spinner_datos_cliente" style="display: none;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <select onchange="editobtenerDatosGranelesInspecciones();"
                                id="edit_id_lote_envasado_inspeccion" name="edit_id_lote_envasado_inspeccion"
                                class="select2 form-select">
                                <option value="" disabled selected>Selecciona lote envasado</option>
                            </select>
                            <label for="edit_id_lote_envasado_inspeccion">Lote envasado</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_categoria_inspeccion" name="id_categoria_inspeccion"
                                    placeholder="Ingresa una Categoria" readonly style="pointer-events: none;" />
                                <label for="id_categoria_inspeccion">Ingresa Categoria</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_clase_inspeccion" name="id_clase_inspeccion"
                                    placeholder="Ingresa una Clase" readonly style="pointer-events: none;" />
                                <label for="id_clase_inspeccion">Ingresa Clase</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control bg-light text-muted"
                                id="edit_id_tipo_maguey_inspeccion" name="id_tipo_maguey_inspeccion"
                                placeholder="Ingresa un tipo de Maguey" readonly style="pointer-events: none;" />
                            <label for="id_tipo_maguey_inspeccion">Ingresa Tipo de Maguey</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="edit_id_marca"
                                    name="id_marca" placeholder="Ingresa una Categoria" readonly
                                    style="pointer-events: none;" />
                                <label for="id_marca">Ingresa Marca</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control text-muted bg-light"
                                    id="edit_volumen_inspeccion" name="volumen_inspeccion"
                                    placeholder="Ingresa el volumen" readonly style="pointer-events: none;" />
                                <label for="volumen_inspeccion">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control text-muted bg-light"
                                    id="edit_analisis_inspeccion" name="analisis_inspeccion"
                                    placeholder="Ingresa Análisis fisicoquímico" readonly
                                    style="pointer-events: none;" />
                                <label for="analisis_inspeccion">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_tipo_inspeccion" name="id_tipo_inspeccion"
                                    class="form-select text-muted bg-light" readonly style="pointer-events: none;">
                                    <option class="text-muted" value="" disabled selected>Selecciona un tipo
                                    </option>
                                    <option value="Con etiqueta" class="text-muted">Con etiqueta</option>
                                    <option value="Sin etiqueta" class="text-muted">Sin etiqueta</option>
                                </select>
                                <label for="id_tipo_inspeccion">Tipo</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control bg-light text-muted"
                                    id="edit_id_cantidad_bote" name="id_cantidad_bote"
                                    placeholder="Cantidad de botellas" readonly style="pointer-events: none;" />
                                <label for="id_cantidad_bote">Cantidad de botellas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="edit_id_certificado_inspeccion"
                                    name="id_certificado_inspeccion" readonly style="pointer-events: none;"
                                    placeholder="Ingresa el Certificado de NOM a granel"/>
                                <label for="id_certificado_inspeccion">Ingresa Certificado de NOM a granel</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_id_cantidad_caja"
                                    name="id_cantidad_caja" placeholder="Cantidad de cajas" />
                                <label for="id_cantidad_caja">Cantidad de cajas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control datepicker" id="edit_id_inicio_envasado"
                                    name="id_inicio_envasado" placeholder="Inicio de envasado" autocomplete="off" />
                                <label for="id_inicio_envasado">Inicio de envasado</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control datepicker" id="edit_id_previsto"
                                    name="id_previsto" placeholder="Termino previsto del envasado"
                                    autocomplete="off" />
                                <label for="id_previsto">Termino previsto del envasado</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="edit_info_adicional"
                                placeholder="Observaciones..."autocomplete="off"></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad (NO. DE GARRAFAS Y
                                CONTENEDORES):</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="enviarInspec"><i
                                class="ri-pencil-fill"></i> Editar</button>
                        <button type="reset" class="btn btn-danger " data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editobtenerInstalacionesInspecciones() {
        var empresa = $("#edit_id_empresa_inspeccion").val();
        $('#enviarInspec').prop('disabled', true);
        $('#estado_datos_cliente').text('Cargando datos...').css('color', 'black');
        $('#spinner_datos_cliente').show();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    var contenido = "";
                    for (let index = 0; index < response.instalaciones.length; index++) {
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);
                        contenido = '<option value="' + response.instalaciones[index].id_instalacion +
                            '">' +
                            tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>' +
                            contenido;
                    }
                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }
                    $('#edit_id_instalacion_inspeccion').html(contenido);
                    const idInstala = $('#edit_id_instalacion_inspeccion').data(
                        'selected');
                    if (idInstala) {
                        $('#edit_id_instalacion_inspeccion')
                            .val(idInstala)
                            .trigger('change');
                    }

                    let contenidoE = '';

                    response.lotes_envasado.forEach(lote => {
                        const nombreLote = lote.nombre;
                        const loteGranel = lote.lotes_envasado_granel?.[0]?.lotes_granel?.[0]?.nombre_lote || '';
                        
                        contenidoE += `<option value="${lote.id_lote_envasado}">
                            ${nombreLote} Granel: ${loteGranel}
                        </option>`;
                    });
                    if (response.lotes_envasado.length == 0) {
                        contenidoE = '<option value="">Sin lotes registrados</option>';
                    } else {}
                    $('#edit_id_lote_envasado_inspeccion').html(contenidoE);

                    const idInenvasadoSeleccionado = $('#edit_id_lote_envasado_inspeccion').data(
                        'selected');
                    if (idInenvasadoSeleccionado) {
                        $('#edit_id_lote_envasado_inspeccion')
                            .val(idInenvasadoSeleccionado)
                            .trigger('change');
                    }

                    // Ocultar mensaje o cambiarlo
                    $('#enviarInspec').prop('disabled', false);
                    $('#spinner_datos_cliente').hide();
                    $('#estado_datos_cliente').text('');
                },
                error: function() {
                    $('#enviarInspec').prop('disabled', true);
                    $('#spinner_datos_cliente').hide();
                    $('#estado_datos_cliente').text('Error al cargar los datos').css('color', 'red');
                }
            });
        }
    }


    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }

    function editobtenerDatosGranelesInspecciones() {
        var lote_granel_id = $("#edit_id_lote_envasado_inspeccion").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatosLoteEnvasado/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    $('#edit_id_categoria_inspeccion').val(response.primer_lote_granel ? response
                        .primer_lote_granel.nombre_categoria : '');
                    $('#edit_id_clase_inspeccion').val(response.primer_lote_granel ? response
                        .primer_lote_granel
                        .nombre_clase : '');
                    $('#edit_id_tipo_maguey_inspeccion').val(response.primer_lote_granel ? response
                        .primer_lote_granel.tipos_nombres : '');
                    $('#edit_analisis_inspeccion').val(response.primer_lote_granel.folio_fq || '');
                    $('#edit_volumen_inspeccion').val(response.primer_lote_granel.cont_alc || '');
                    $('#edit_id_certificado_inspeccion').val(response.primer_lote_granel
                        .folio_certificado ||
                        '');
                    $('#edit_id_cantidad_bote').val(response.lotes_envasado.cant_botellas || '');
                    $('#edit_id_tipo_inspeccion').val(response.lotes_envasado.tipo || '');
                    $('#edit_id_marca').val(response.lotes_envasado?.marca?.marca || '');

                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                    $('#edit_id_categoria_inspeccion, #edit_id_clase_inspeccion, #edit_id_tipo_maguey_inspeccion, #edit_analisis_inspeccion, #edit_volumen_inspeccion, #edit_id_certificado_inspeccion, #edit_id_cantidad_bote, #edit_id_tipo_inspeccion, #edit_id_marca')
                        .val('').trigger('change');
                },

            });
        } else {
            $('#edit_id_categoria_inspeccion, #edit_id_clase_inspeccion, #edit_id_tipo_maguey_inspeccion, #edit_analisis_inspeccion, #edit_volumen_inspeccion, #edit_id_certificado_inspeccion, #edit_id_cantidad_bote, #edit_id_tipo_inspeccion, #edit_id_marca')
                .val('').trigger('change');
        }
    }
</script>
