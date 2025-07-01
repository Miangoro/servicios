<div class="modal fade" id="addMuestreoLoteAgranel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva solicitud de muestreo de Lote a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-8">
                <form id="addMuestreoLoteAgranelForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_muestreo"
                                    onchange="obtenerInstalacionesMuestreo();"
                                    name="id_empresa" class="id_empresa_muestreo select2 form-select" required>
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
                                    id="fecha_visita_muestreoLo" name="fecha_visita" autocomplete="off" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select select2" id="id_instalacion_muestreoLo" name="id_instalacion"
                                    aria-label="id_instalacion">
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="obtenerDatosGranelesMuestreo();" id="id_lote_granel_muestreo"
                                    name="id_lote_granel_muestreo" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>

                                </select>
                                <label for="id_lote_granel_muestreo">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="tipo_analisis" name="destino_lote" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="1">Análisis completo</option>{{-- Análisis completo --}}
                                    <option value="2">Ajuste de grado alcohólico</option>{{-- Ajuste de grado alcohólico --}}
                                </select>
                                <label for="destino_lote">Tipo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="id_categoria_muestreo" name="id_categoria_muestreo"
                                    placeholder="Ingresa una Categoria" readonly style="pointer-events: none;" />
                                <label for="id_categoria_muestreo">Ingresa Categoria</label>
                            </div>
                            <input type="hidden" id="id_categoria_muestreo_id" name="id_categoria_muestreo">
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="id_clase_muestreo"
                                    name="" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_muestreo">Ingresa Clase</label>
                            </div>
                            <input type="hidden" id="id_clase_muestreo_id" name="id_clase_muestreo">

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control bg-light text-muted marca"
                                id="id_tipo_maguey_muestreo" placeholder="Ingresa un tipo de Maguey" readonly
                                style="pointer-events: none;" />
                            <label for="id_tipo_maguey_muestreo">Ingresa Tipo de Maguey</label>
                        </div>
                        <input type="hidden" id="id_tipo_maguey_muestreo_ids" name="id_tipo_maguey_muestreo[]">
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="analisis_muestreo"
                                    name="analisis_muestreo" placeholder="Ingresa Análisis fisicoquímico" autocomplete="off"/>
                                <label for="analisis_muestreo">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="volumen_muestreo"
                                    name="volumen_muestreo" placeholder="Ingresa el volumen" />
                                <label for="volumen_muestreo">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="id_certificado_muestreo"
                                    name="id_certificado_muestreo"
                                    placeholder="Ingresa el Certificado de NOM a granel" autocomplete="off"/>
                                <label for="id_certificado_muestreo">Ingresa Certificado de NOM a granel</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="info_adicional" placeholder="Observaciones..." autocomplete="off"></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad (NO. DE GARRAFAS Y
                                CONTENEDORES):</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnRegistrMLote"><i class="ri-add-line"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtenerInstalacionesMuestreo() {
        var empresa = $("#id_empresa_muestreo").val();

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
                    $('#id_instalacion_muestreoLo').html(contenido);
                    var contenidogranel = "";

                    // Iterar sobre los lotes a granel recibidos
                    if (response.lotes_granel && response.lotes_granel.length > 0) {
                        response.lotes_granel.forEach(function(lote) {
                            contenidogranel += '<option value="' + lote.id_lote_granel + '">' +
                                lote.nombre_lote + '</option>';
                        });
                    } else {
                        contenidogranel = '<option value="">Sin lotes registrados</option>';
                    }

                    // Insertar el contenido en el select
                    $('#id_lote_granel_muestreo').html(contenidogranel);
                    obtenerDatosGranelesMuestreo();
                },
                error: function() {}
            });
        }
    }

    function limpiarTipo(tipo) {
        if (tipo.startsWith('[') && tipo.endsWith(']')) {
            try {
                return JSON.parse(tipo).join(', ');
            } catch (e) {
                return tipo;
            }
        }
        return tipo;
    }

    function obtenerDatosGranelesMuestreo() {
        var lote_granel_id = $("#id_lote_granel_muestreo").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    // Asignar la categoría
                    $('#id_categoria_muestreo').val(response.categoria ? response.categoria.categoria : '');
                    $('#id_categoria_muestreo_id').val(response.categoria ? response.categoria
                        .id_categoria : '');
                    // Asignar la clase
                    $('#id_clase_muestreo').val(response.clase ? response.clase.clase : '');
                    $('#id_clase_muestreo_id').val(response.clase ? response.clase.id_clase :
                        ''); // Campo oculto para el ID

                    // Asignar los tipos (nombre visible y ID oculto)
                    if (response.tipo && response.tipo.length > 0) {
                        // Mostrar los nombres concatenados en el input visible
                        var tiposNombres = response.tipo.map(function(tipo) {
                            return tipo.nombre + ' (' + tipo.cientifico + ')';
                        }).join(', '); // Esto es para mostrar los nombres de los tipos
                        $('#id_tipo_maguey_muestreo').val(tiposNombres);

                        // Crear un array de los IDs seleccionados (sin concatenarlos)
                        var tiposIds = response.tipo.map(function(tipo) {
                            return tipo.id_tipo; // Obtener solo el ID
                        });

                        // Asignar directamente los IDs separados por coma al campo oculto
                        $('#id_tipo_maguey_muestreo_ids').val(tiposIds.join(
                            ',')); // Unir IDs por coma (sin comillas adicionales)
                    } else {
                        // Limpiar ambos campos si no hay datos
                        $('#id_tipo_maguey_muestreo').val('');
                        $('#id_tipo_maguey_muestreo_ids').val(''); // Limpiar el campo oculto
                    }
                    // Otros datos
                    $('#analisis_muestreo').val(response.lotes_granel.folio_fq || '');
                    $('#volumen_muestreo').val(response.lotes_granel.cont_alc || '');
                    $('#id_certificado_muestreo').val(response.lotes_granel.folio_certificado || '');
                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                }
            });
        }
    }
</script>
