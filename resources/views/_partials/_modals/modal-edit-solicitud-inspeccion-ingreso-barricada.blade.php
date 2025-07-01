<div class="modal fade" id="editInspeccionIngresoBarricada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de inspección ingreso a barrica/ contenedor de vidrio
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <p class="solicitud badge bg-primary"></p>
                <form id="editInspeccionIngresoBarricadaForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_barricada">
                    <input type="hidden" name="form_type" value="muestreobarricada">
                    <input type="hidden" id="instalacion_ingreso">
                    <input type="hidden" id="lote_ingreso">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_barricada"
                                    onchange="editobtenerInstalacionesBarricada(); editobtenerGranelesBarricada(this.value);"
                                    name="id_empresa" class="id_empresa_barricada select2 form-select" required>
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
                                <select class=" form-select select2" id="edit_id_instalacion_barricada"
                                    name="id_instalacion" aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="editobtenerDatosGranelesBarricada();"
                                    id="edit_id_lote_granel_barricada" name="id_lote_granel_barricada"
                                    class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel_barricada">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_volumen_ingresado"
                                    name="volumen_ingresado" placeholder="Volumen ingresado" />
                                <label for="edit_volumen_ingresado">Volumen ingresado</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_categoria_barricada" name="" placeholder="Ingresa una Categoria"
                                    readonly style="pointer-events: none;" />
                                <label for="id_categoria_barricada">Categoría de mezcal</label>
                            </div>
                            <input type="hidden" id="edit_id_categoria_barricada_id" name="id_categoria_barricada">
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_clase_barricada" name="" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_barricada">Clase</label>
                            </div>
                            <input type="hidden" id="edit_id_clase_barricada_id" name="id_clase_barricada">
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control text-muted bg-light"
                                    id="edit_id_certificado_barricada" name="id_certificado_barricada" disabled
                                    placeholder="Certificado de NOM a granel" />
                                <label for="id_certificado_barricada">Certificado de NOM a granel </label>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="edit_id_tipo_maguey_barricada" name=""
                                    placeholder="Ingresa un tipo de Maguey" readonly style="pointer-events: none;" />
                                <label for="id_tipo_maguey_barricada">Tipo de Maguey</label>
                            </div>
                            <input type="hidden" id="edit_id_tipo_maguey_barricada_ids"
                                name="id_tipo_maguey_barricada">
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_analisis_barricada"
                                    name="analisis_barricada" placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis_barricada">Análisis fisicoquímico</label>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_alc_vol_barrica"
                                    name="alc_vol_barrica" placeholder="Ingresa el volumen" />
                                <label for="edit_alc_vol_barrica">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_tipo_lote" name="tipo_lote" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="Ingreso de producto en barrica">Ingreso de producto en barrica
                                    </option>
                                    <option value="Ingreso de producto en contenedor de vidrio">Ingreso de producto en
                                        contenedor de vidrio</option>
                                </select>
                                <label for="tipo_lote">Tipo</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker" type="text"
                                    id="edit_fecha_inicio" name="fecha_inicio" readonly />
                                <label for="fecha_inicio">Fecha de inicio del ingreso </label>
                            </div>
                        </div>


                    </div>


                    <div class="row">


                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker" type="text"
                                    id="edit_fecha_termino" name="fecha_termino" readonly />
                                <label for="fecha_termino">Fecha de término del ingreso
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_material" name="material"
                                    placeholder="Material de los recipientes" autocomplete="off" />
                                <label for="material">Material de los recipientes</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_num_recipientes"
                                    name="num_recipientes" placeholder="Número de recipientes" />
                                <label for="num_recipientes">Número de recipientes</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_capacidad" name="capacidad"
                                    placeholder="Capacidad de recipientes" autocomplete="off" />
                                <label for="capacidad">Capacidad de recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_tiempo_maduracion"
                                    name="tiempo_maduracion" placeholder="Tiempo de maduración" autocomplete="off" />
                                <label for="Tiempo de maduración">Tiempo de maduración</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="edit_info_adicional"
                                placeholder="Observaciones..."autocomplete="off"></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad:</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnEditIngresoBarrica"><i
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
    function editobtenerInstalacionesBarricada() {
        var empresa = $("#edit_id_empresa_barricada").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {

                    var contenido = "";
                    var contenido = "";
                    let seleccionado = "";
                    var instalacion_id = $("#instalacion_ingreso").val();
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
                    $('#edit_id_instalacion_barricada').html(contenido);
                },
                error: function() {}
            });
        }
    }

    function editobtenerGranelesBarricada(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = "";
                    let seleccionado = "";
                    var lote_id = $("#lote_ingreso").val();
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
                    $('#edit_id_lote_granel_barricada').html(contenido);

                    const idgranellote = $('#edit_id_lote_granel_barricada').data('selected');
                    if (idgranellote) {
                        $('#edit_id_lote_granel_barricada').val(idgranellote).trigger('change');
                    } else if (response.lotes_granel.length == 0) {
                        console.log('no hay se');
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

    function editobtenerDatosGranelesBarricada() {
        var lote_granel_id = $("#edit_id_lote_granel_barricada").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    $('#edit_id_categoria_barricada').val(response.categoria ? response.categoria
                        .categoria :
                        '');
                    $('#edit_id_categoria_barricada_id').val(response.categoria ? response.categoria
                        .id_categoria :
                        '');
                    $('#edit_id_clase_barricada').val(response.clase ? response.clase.clase : '');
                    $('#edit_id_clase_barricada_id').val(response.clase ? response.clase.id_clase : '');
                    if (response.tipo && response.tipo.length > 0) {
                        var tiposConcatenados = response.tipo.map(function(tipo) {
                            return tipo.nombre + ' (' + tipo.cientifico + ')';
                        }).join(', '); // Unir con coma
                        $('#edit_id_tipo_maguey_barricada').val(tiposConcatenados);

                        var edittiposIdss = response.tipo.map(function(tipo) {
                            return tipo.id_tipo; // Obtener solo el ID
                        });
                        $('#edit_id_tipo_maguey_barricada_ids').val(edittiposIdss.join(','));
                    } else {
                        $('#edit_id_tipo_maguey_barricada').val('');
                        $('#edit_id_tipo_maguey_barricada_ids').val();
                    }
                    $('#edit_id_edad').val(response.lotes_granel.edad);
                    $('#edit_analisis_barricada').val(response.lotes_granel.folio_fq);
                    $('#edit_alc_vol_barrica').val(response.lotes_granel.cont_alc);
                    $('#edit_volumen_ingresado').val(response.lotes_granel.volumen_restante);
                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                }
            });
        }
    }
</script>
