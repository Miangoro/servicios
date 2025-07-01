<div class="modal fade" id="editMuestreoLoteAgranel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud muestreo de Lote a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <p class="solicitud badge bg-primary"></p>
                <form id="editMuestreoLoteAgranelForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_muestreo">
                    <input type="hidden" name="form_type" value="muestreoloteagranel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_muestreo"
                                    onchange="EditobtenerInstalacionesMuestreo(); editobtenerGranelesMuestreo(this.value);"
                                    name="id_empresa" class="select2 form-select">
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
                                    id="edit_fecha_visita" name="fecha_visita" autocomplete="off"/>
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select select2" id="edit_id_instalacion_muestreo"
                                    name="id_instalacion" aria-label="id_instalacion">
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="editobtenerDatosGranelesMuestreo();" id="edit_id_lote_granel_muestreo"
                                    name="id_lote_granel_muestreo" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel_muestreo">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_destino_lote" name="tipo_analisis" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="1">Análisis completo</option>
                                    <option value="2">Ajuste de grado alcohólico</option>
                                </select>
                                <label for="destino_lote">Tipo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_categoria_muestreo" placeholder="Ingresa una Categoria" readonly
                                    style="pointer-events: none;" />
                                <label for="id_categoria_muestreo">Ingresa Categoria</label>
                            </div>
                            <input type="hidden" id="edit_id_categoria_muestreo_id" name="id_categoria_muestreo">
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_clase_muestreo" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_muestreo">Ingresa Clase</label>
                            </div>
                            <input id="edit_id_clase_muestreo_id" type="hidden" name="id_clase_muestreo">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control bg-light text-muted"
                                id="edit_id_tipo_maguey_muestreo" placeholder="Ingresa un tipo de Maguey" readonly
                                style="pointer-events: none;" />
                            <label for="id_tipo_maguey_muestreo">Ingresa Tipo de Maguey</label>
                        </div>
                        <input type="hidden" id="edit_id_tipo_maguey_muestreo_ids" name="id_tipo_maguey_muestreo[0]">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_analisis_muestreo"
                                    name="analisis_muestreo" placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis_muestreo">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_volumen_muestreo"
                                    name="volumen_muestreo" placeholder="Ingresa el volumen" />
                                <label for="volumen_muestreo">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_id_certificado_muestreo"
                                    name="id_certificado_muestreo"
                                    placeholder="Ingresa el Certificado de NOM a granel" />
                                <label for="id_certificado_muestreo">Ingresa Certificado de NOM a granel</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="edit_info_adicional"
                                placeholder="Observaciones..."></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad (NO. DE GARRAFAS Y
                                CONTENEDORES):</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnEditMLote"><i class="ri-pencil-fill"></i> Editar</button>
                        <button type="reset" class="btn btn-danger " id="ejemploo" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function EditobtenerInstalacionesMuestreo() {
        var empresa = $("#edit_id_empresa_muestreo").val();
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
                    $('#edit_id_instalacion_muestreo').html(contenido);
                    const idInstalacionSeleccionada = $('#edit_id_instalacion_muestreo').data('selected');
                    if (idInstalacionSeleccionada) {
                        $('#edit_id_instalacion_muestreo')
                            .val(idInstalacionSeleccionada)
                            .trigger('change');
                    }
                },
                error: function() {}
            });
        }
    }

    function editobtenerGranelesMuestreo(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = "";
                    for (let index = 0; index < response.lotes_granel.length; index++) {
                        contenido = '<option value="' + response.lotes_granel[index].id_lote_granel + '">' +
                            response
                            .lotes_granel[index].nombre_lote + '</option>' + contenido;
                    }
                    if (response.lotes_granel.length == 0) {
                        contenido = '<option value="">Sin lotes registrados</option>';
                    } else {}
                    $('#edit_id_lote_granel_muestreo').html(contenido);

                    // Mantener el dato del select
                    const idloteSeleccionada = $('#edit_id_lote_granel_muestreo').data('selected');
                    console.log('El lote seleccionado es el: ' + idloteSeleccionada);
                    if (idloteSeleccionada) {
                        $('#edit_id_lote_granel_muestreo')
                            .val(idloteSeleccionada)
                            .trigger('change');
                    }
                },
                error: function() {}
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

    function editobtenerDatosGranelesMuestreo() {

        var lote_granel_id = $("#edit_id_lote_granel_muestreo").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    $('#edit_id_categoria_muestreo').val(response.categoria ? response.categoria.categoria :
                        '');
                    $('#edit_id_categoria_muestreo_id').val(response.categoria ? response.categoria
                        .id_categoria : '');
                    $('#edit_id_clase_muestreo').val(response.clase ? response.clase.clase : '');
                    $('#edit_id_clase_muestreo_id').val(response.clase ? response.clase.id_clase :
                        ''); // Campo oculto para el ID

                    if (response.tipo && response.tipo.length > 0) {
                        var tiposConcatenados = response.tipo.map(function(tipo) {
                            return tipo.nombre + ' (' + tipo.cientifico + ')';
                        }).join(', '); // Unir con coma
                        $('#edit_id_tipo_maguey_muestreo').val(tiposConcatenados);

                        var tiposIdsEdit = response.tipo.map(function(tipo) {
                            return tipo.id_tipo; // Obtener solo el ID
                        });
                        $('#edit_id_tipo_maguey_muestreo_ids').val(tiposIdsEdit.join(','));
                    } else {
                        $('#edit_id_tipo_maguey_muestreo').val('');
                        $('#edit_id_tipo_maguey_muestreo_ids').val('');
                    }
                    $('#edit_analisis_muestreo').val(response.lotes_granel.folio_fq);
                    $('#edit_volumen_muestreo').val(response.lotes_granel.cont_alc);
                    $('#edit_id_certificado_muestreo').val(response.lotes_granel.folio_certificado);
                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                }
            });
        }
    }
</script>
