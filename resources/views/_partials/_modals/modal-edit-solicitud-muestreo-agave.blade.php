<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="editSolicitudMuestreoAgave" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de muestreo de agave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <p class="solicitud badge bg-primary"></p>
                <form id="editRegistrarSolicitudMuestreoAgave">
                    <div class="row">
                        <input type="hidden" name="id_solicitud" id="edit_id_solicitud_muestr">
                        <input type="hidden" name="form_type" value="muestreoagave">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="editobtenerInstalacionesMuestreoAgaves(); obtenerlasguiass();"
                                    id="id_empresa_muestr" name="id_empresa"
                                    class="select2 form-select id_empresa_dic23" required>
                                    <option value="">Selecciona cliente</option>
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
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime"
                                    id="fecha_visita_muestr" type="text" name="fecha_visita" autocomplete="off" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select class="select2 form-select" id="id_instalacion_dic23" name="id_instalacion"
                                aria-label="id_instalacion">
                                <option value="" selected>Lista de instalaciones</option>
                            </select>
                            <label for="id_predio">Domicilio de la instalación de producción</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select multiple class="select2 form-select guiass" id="edit_id_guiass" name="id_guia[]"
                                aria-label="id_instalacion">
                                <option value="" disabled selected>Lista de guías de agave</option>
                            </select>
                            <label for="id_predio">Guías de agave expedidas por OC CIDAM</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150" id="edit_info_adicional_muestr"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnEditMA"><i class="ri-pencil-fill"></i>
                            Editar</button>
                        <button type="reset" class="btn btn-danger " data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function editobtenerInstalacionesMuestreoAgaves() {
        var empresa = $(".id_empresa_dic23").val();

        if (empresa !== "" && empresa !== null && empresa !== undefined) {

            // Hacer una petición AJAX para obtener los detalles de la empresa
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    var contenido = "";
                    for (let index = 0; index < response.instalaciones_produccion.length; index++) {
                        // Limpia el campo tipo usando la función limpiarTipo
                        var tipoLimpio = limpiarTipo(response.instalaciones_produccion[index].tipo);

                        contenido = '<option value="' + response.instalaciones_produccion[index]
                            .id_instalacion + '">' +
                            tipoLimpio + ' | ' + response.instalaciones_produccion[index]
                            .direccion_completa + '</option>' +
                            contenido;
                    }
                    if (response.instalaciones_produccion.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }
                    $('#id_instalacion_dic23').html(contenido);
                    // Verificar si hay un valor previo en `edit_id_predio`
                    const idPredioPrevio = $('#id_instalacion_dic23').data('selected');
                    if (idPredioPrevio) {
                        $('#id_instalacion_dic23').val(idPredioPrevio).trigger('change');
                    } else if (response.predios.length == 0) {
                        console.log('no hay se');
                    }
                },
                error: function() {
                    //alert('Error al cargar los lotes a granel.');
                }
            });
        }
    }
    // Función para limpiar el campo tipo
    function limpiarTipo(tipo) {
        try {
            // Convierte el JSON string a un array y únelos en una cadena limpia
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            // Si no es JSON válido, regresa el valor original
            return tipo;
        }
    }


    function obtenerlasguiass() {
        var empresa = $(".id_empresa_dic23").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {

            // Hacer una petición AJAX para obtener los detalles de la empresa
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    var contenido = "";
                    for (let index = 0; index < response.guias.length; index++) {
                        // Limpia el campo tipo usando la función limpiarTipo
                        contenido = '<option value="' + response.guias[index]
                            .id_guia + '">' + response.guias[index].folio + '</option>' + contenido;
                    }
                    if (response.guias.length == 0) {
                        contenido = '<option value="" disabled selected>Sin guias registradas</option>';
                    }
                    $('#edit_id_guiass').html(contenido);

                    const idPredioPrevio = $('#edit_id_guiass').data('selected');
                    if (idPredioPrevio) {
                        $('#edit_id_guiass').val(idPredioPrevio).trigger('change');
                    } else if (response.predios.length == 0) {
                        console.log('no hay se');
                    }
                },
                error: function() {
                    //alert('Error al cargar los lotes a granel.');
                }
            });
        }
    }
</script>
