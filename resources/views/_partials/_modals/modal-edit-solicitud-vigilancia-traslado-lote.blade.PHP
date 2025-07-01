<div class="modal fade" id="editVigilanciaTraslado" tabindex="-1" ria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de vigilancia en el traslado del lote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <p class="solicitud badge bg-primary"></p>
                <form id="editVigilanciaTrasladoForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_traslado">
                    <input type="hidden" name="form_type" value="vigilanciatraslado">
                    <div class="row">
                        <input type="hidden" id="instalacion_id_traslado">
                        <input type="hidden" id="lote_id_traslado">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_traslado"
                                    onchange="editobtenerInstalacionesTraslado(); editobtenerGranelesTraslado(this.value);"
                                    name="id_empresa" class="id_empresa_traslado select2 form-select" required>
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
                                <select class=" form-select select2" id="edit_id_instalacion_traslado"
                                    name="id_instalacion" aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <select id="edit_instalacion_vigilancia" name="instalacion_vigilancia"
                                class="select2 form-select">
                                @foreach ($instalaciones as $instalaciones)
                                    <option value="{{ $instalaciones->id_instalacion }}">
                                        {{ $instalaciones->direccion_completa }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="instalacion_vigilancia">Dirección de destino</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="editobtenerDatosGranelesTarslado();" id="edit_id_lote_granel_traslado"
                                    name="id_lote_granel_traslado" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel_traslado">Lote a granel</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_categoria_traslado" name="id_categoria_traslado"
                                    placeholder="Ingresa una Categoria" readonly style="pointer-events: none;" />
                                <label for="id_categoria_traslado">Categoría de mezcal</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_clase_traslado" name="id_clase_traslado" placeholder="Ingresa una Clase"
                                    readonly style="pointer-events: none;" />
                                <label for="id_clase_traslado">Clase</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_tipo_maguey_traslado" name="id_tipo_maguey_traslado[0]"
                                    placeholder="Ingresa un tipo de Maguey" readonly style="pointer-events: none;" />
                                <label for="id_tipo_maguey_traslado">Tipo de Maguey</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_id_certificado_traslado"
                                    name="id_certificado_traslado"
                                    placeholder="Ingresa el Certificado de NOM a granel" />
                                <label for="id_certificado_traslado">Certificado de NOM a granel</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_analisis_traslado"
                                    name="analisis_traslado" placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis_traslado">Análisis fisicoquímico</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_volumen_traslado"
                                    name="volumen_traslado" placeholder="Ingresa el volumen" step="0.01" />
                                <label for="volumen_traslado">%Alc. Vol.</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_id_salida" name="id_salida"
                                    placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="id_salida">Identificador de contenedor de salida
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_id_contenedor"
                                    name="id_contenedor" placeholder="Ingresa el volumen" />
                                <label for="id_contenedor">Identificador de contenedor de recepción</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_id_sobrante" name="id_sobrante"
                                    placeholder="Ingresa el Certificado de NOM a granel" />
                                <label for="id_sobrante">Sobrante en contenedor de salida </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_vol_actual" name="id_vol_actual"
                                    placeholder="Ingresa el volumen actual" readonly style="pointer-events: none;" />
                                <label for="id_vol_actual">Volumen actual del lote</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input onkeyup="obtenerSobranteEdit(this.value)" type="number" class="form-control "
                                    id="edit_id_vol_traslado" name="id_vol_traslado"
                                    placeholder="Ingresa una Categoria" step="0.01" />
                                <label for="id_vol_traslado">Volumen trasladado</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="edit_id_vol_res"
                                    name="id_vol_res" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_vol_res">Volumen sobrante del lote </label>
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
                        <button type="submit" class="btn btn-primary" id="btnEditVigiLote"><i class="ri-pencil-fill"></i> Editar</button>
                        <button type="reset" class="btn btn-danger " data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-fill"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editobtenerInstalacionesTraslado() {
        var empresa = $("#edit_id_empresa_traslado").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {

                    var contenido = "";
                    let seleccionado = "";
                    var instalacion_id = $("#instalacion_id_traslado").val();
                    for (let index = 0; index < response.instalaciones.length; index++) {
                        if (instalacion_id == response.instalaciones[index].id_instalacion) {
                            seleccionado = "selected";
                        } else {
                            seleccionado = "";
                        }
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);
                        contenido = '<option ' + seleccionado + ' value="' + response.instalaciones[index]
                            .id_instalacion +
                            '">' +
                            tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>' +
                            contenido;
                    }
                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }
                    $('#edit_id_instalacion_traslado').html(contenido);
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

    function obtenerSobranteEdit(trasladado) {
        $('#edit_id_vol_res').val($('#edit_id_vol_actual').val() - trasladado);
    }

    function editobtenerGranelesTraslado(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = "";
                    let seleccionado = "";
                    var lote_id = $("#lote_id_traslado").val();
                    for (let index = 0; index < response.lotes_granel.length; index++) {
                        if (lote_id == response.lotes_granel[index].id_lote_granel) {
                            seleccionado = "selected";
                        } else {
                            seleccionado = "";
                        }
                        contenido = '<option ' + seleccionado + ' value="' + response.lotes_granel[index]
                            .id_lote_granel + '">' +
                            response
                            .lotes_granel[index].nombre_lote + '</option>' + contenido;
                    }
                    if (response.lotes_granel.length == 0) {
                        contenido = '<option value="">Sin lotes registrados</option>';
                    } else {}
                    $('#edit_id_lote_granel_traslado').html(contenido);
                },
                error: function() {}
            });
        }
    }

    function editobtenerDatosGranelesTarslado() {
        var lote_granel_id = $("#edit_id_lote_granel_traslado").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    $('#edit_id_categoria_traslado').val(response.categoria ? response.categoria.categoria :
                        '');
                    $('#edit_id_clase_traslado').val(response.clase ? response.clase.clase : '');
                    if (response.tipo && response.tipo.length > 0) {
                        var tiposConcatenados = response.tipo.map(function(tipo) {
                            return tipo.nombre + ' (' + tipo.cientifico + ')';
                        }).join(', '); // Unir con coma
                        $('#edit_id_tipo_maguey_traslado').val(tiposConcatenados);
                    } else {
                        $('#edit_id_tipo_maguey_traslado').val('');
                    }
                    $('#edit_analisis_traslado').val(response.lotes_granel.folio_fq);
                    $('#edit_volumen_traslado').val(response.lotes_granel.cont_alc);
                    $('#edit_id_vol_actual').val(response.lotes_granel.volumen);
                    $('#edit_id_vol_res').val(response.lotes_granel.volumen_restante);

                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                }
            });
        }
    }
</script>
