<div class="modal fade" id="addInspeccionLiberacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva solicitud de inspección de liberación a barrica/contenedor
                    de vidrio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form id="addInspeccionLiberacionForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_liberacion"
                                    onchange="obtenerInstalacionesLiberacion(); obtenerGranelesLiberacion(this.value);"
                                    name="id_empresa" class="id_empresa_liberacion select2 form-select" required>
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
                                    id="fecha_visita_liberacion" name="fecha_visita" autocomplete="off"/>
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select select2" id="id_instalacion_liberacion" name="id_instalacion"
                                    aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="obtenerDatosGranelesLiberacion();" id="id_lote_granel_liberacion"
                                    name="id_lote_granel_liberacion" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel_liberacion">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="id_categoria_liberacion" name="" placeholder="Ingresa una Categoria"
                                    readonly style="pointer-events: none;" />
                                <label for="id_categoria_liberacion">Ingresa Categoria</label>
                            </div>
                            <input type="hidden" id="id_categoria_liberacion_id" name="id_categoria_liberacion">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="id_clase_liberacion"
                                    name="" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_liberacion">Ingresa Clase</label>
                            </div>
                            <input type="hidden" id="id_clase_liberacion_id" name="id_clase_liberacion">
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="id_edad_liberacion"
                                    name="id_edad_liberacion" placeholder="Ingresa una Edad" readonly
                                    style="pointer-events: none;" />
                                <label for="id_edad_liberacion">Ingresa Edad</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control bg-light text-muted"
                                id="id_tipo_maguey_liberacion" name="" placeholder="Ingresa un tipo de Maguey"
                                readonly style="pointer-events: none;" />
                            <label for="id_tipo_maguey_liberacion">Ingresa Tipo de Maguey</label>
                        </div>
                        <input type="hidden" id="id_tipo_maguey_liberacion_ids" name="id_tipo_maguey_liberacion">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="analisis_liberacion"
                                    name="analisis_liberacion" placeholder="Ingresa Análisis fisicoquímico"autocomplete="off"/>
                                <label for="analisis_liberacion">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="volumen_liberacion"
                                    name="volumen_liberacion" placeholder="Ingresa el volumen" />
                                <label for="volumen_liberacion">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="tipo_lote_lib" name="tipo_lote_lib" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="Liberación de producto en barrica">Liberación de producto en barrica
                                    </option>
                                    <option value="Liberación de producto en contenedor de vidrio">Liberación de
                                        producto en contenedor de vidrio</option>
                                </select>
                                <label for="tipo_lote_lib">Tipo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker" type="text"
                                    id="fecha_inicio_libe_inspe" name="fecha_inicio_lib" autocomplete="off"/>
                                <label for="fecha_inicio_lib">Fecha de inicio ingreso/liberación </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker" type="text"
                                    id="fecha_termino_libe_inspe" name="fecha_termino_lib" autocomplete="off"/>
                                <label for="fecha_termino_lib">Fecha de término ingreso/liberación
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="material_liberacion"
                                    name="material_liberacion" placeholder="Material de los recipientes" autocomplete="off"/>
                                <label for="material_liberacion">Material de los recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="capacidad_liberacion"
                                    name="capacidad_liberacion" placeholder="Capacidad de recipientes" autocomplete="off"/>
                                <label for="capacidad_liberacion">Capacidad de recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="num_recipientes_lib"
                                    name="num_recipientes_lib" placeholder="Número de recipientes" />
                                <label for="num_recipientes_lib">Número de recipientes</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="tiempo_dura_lib"
                                    name="tiempo_dura_lib" placeholder="Tiempo de maduración" autocomplete="off"/>
                                <label for="tiempo_dura_lib">Tiempo de maduración</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="id_certificado_liberacion"
                                    name="id_certificado_liberacion" placeholder="Certificado de NOM a granel" autocomplete="off"/>
                                <label for="id_certificado_liberacion">Certificado de NOM a granel </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="info_adicional" placeholder="Observaciones..."autocomplete="off"></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad (NO. DE GARRAFAS Y
                                CONTENEDORES):</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnAddLiberacion"><i class="ri-add-line"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtenerInstalacionesLiberacion() {
        var empresa = $("#id_empresa_liberacion").val();
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
                    $('#id_instalacion_liberacion').html(contenido);
                },
                error: function() {}
            });
        }
    }

    function obtenerGranelesLiberacion(empresa) {
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
                    $('#id_lote_granel_liberacion').html(contenido);
                    obtenerDatosGranelesLiberacion();
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

    function obtenerDatosGranelesLiberacion() {
        var lote_granel_id = $("#id_lote_granel_liberacion").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    $('#id_categoria_liberacion_id').val(response.categoria ? response.categoria
                        .id_categoria : '');
                    $('#id_categoria_liberacion').val(response.categoria ? response.categoria.categoria :
                        '');
                    $('#id_clase_liberacion_id').val(response.clase ? response.clase.id_clase : '');
                    $('#id_clase_liberacion').val(response.clase ? response.clase.clase : '');

                    if (response.tipo && response.tipo.length > 0) {
                        var tiposConcatenados = response.tipo.map(function(tipo) {
                            return tipo.nombre + ' (' + tipo.cientifico + ')';
                        }).join(', '); // Unir con coma
                        $('#id_tipo_maguey_liberacion').val(tiposConcatenados);
                        // Crear un array de los IDs seleccionados (sin concatenarlos)
                        var tiposIdsLib = response.tipo.map(function(tipo) {
                            return tipo.id_tipo; // Obtener solo el ID
                        });
                        $('#id_tipo_maguey_liberacion_ids').val(tiposIdsLib.join(','));

                    } else {
                        $('#id_tipo_maguey_liberacion').val('');
                    }
                    $('#id_edad_liberacion').val(response.lotes_granel.edad);
                    $('#analisis_liberacion').val(response.lotes_granel.folio_fq);
                    $('#volumen_liberacion').val(response.lotes_granel.cont_alc);
                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                }
            });
        }
    }

    /* Limpiar campos al cerrar el modal
    $('#addInspeccionLiberacion').on('hidden.bs.modal', function() {
        $('#id_empresa_liberacion').val('').trigger('change');
        $('#id_instalacion_liberacion').html(
            '<option value="" selected>Lista de instalaciones</option>');
        $('#id_lote_granel_liberacion').val('').trigger('change');
        $('#id_categoria_liberacion').val('').prop('readonly', true);
        $('#id_clase_liberacion').val('').prop('readonly', true);
        $('#id_edad_liberacion').val('').prop('readonly', true);
        $('#id_tipo_maguey_liberacion').val('').prop('readonly', true);
        $('#analisis_liberacion').val('');
        $('#volumen_liberacion').val('');
        $('#tipo_lote_lib').val('').trigger('change');
        $('#fecha_inicio_libe').val('');
        $('#fecha_termino_lib').val('');
        $('#material_liberacion').val('');
        $('#capacidad_liberacion').val('');
        $('#num_recipientes_lib').val('');
        $('#tiempo_dura_lib').val('');
        $('#id_certificado_liberacion').val('');
        $('#info_adicional').val('');
        formValidator.resetForm(true);
    });*/
</script>
