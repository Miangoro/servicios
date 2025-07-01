<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addSolicitudMuestreoAgave" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva solicitud de muestreo de agave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form id="addRegistrarSolicitudMuestreoAgave">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerInstalacionesMuestreoAgave(); obtenerlasguias();"
                                    name="id_empresa" id="id_empresa_dic2mues" class="select2 form-select" >
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
                                    name="fecha_visita" id="fecha_visita_dic2" autocomplete="off" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select class="select2 form-select" id="id_instalacion_dic2" name="id_instalacion"
                                aria-label="id_instalacion">
                                <option value="" selected>Lista de instalaciones</option>
                            </select>
                            <label for="domicilio">Domicilio de la instalación de producción</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select multiple class="select2 form-select guiass" id="guiasmuestreo" name="id_guia[]"
                                aria-label="id_instalacion">
{{--                                 <option value="" disabled selected>Lista de guías de agave</option> --}}
                            </select>
                            <label for="guias">Guías de agave expedidas por OC CIDAM</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150" id="comentarios"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnRegistrarMA"><i class="ri-add-line"></i>
                            Registrar</button>
                        <button type="reset" class="btn btn-danger btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function obtenerInstalacionesMuestreoAgave() {
        var empresa = $("#id_empresa_dic2mues").val();
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
                    $('#id_instalacion_dic2').html(contenido);
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


    function obtenerlasguias() {
        var empresa = $("#id_empresa_dic2mues").val();
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
                        contenido = '';
                    }
                    $('#guiasmuestreo').html(contenido);
                },
                error: function() {
                    //alert('Error al cargar los lotes a granel.');
                }
            });
        }
    }
</script>
