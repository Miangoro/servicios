<div class="modal fade" id="editSolicitudDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de dictaminación de instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <p class="solicitud badge bg-primary"></p>
                <form id="addEditSolicitud">
                    @csrf

                    <div class="row">
                        <input type="hidden" name="id_solicitud" id="edit_id_solicitud">
                        <input type="hidden" name="form_type" value="dictaminacion">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerInstalacion()" id="edit_id_empresa" name="id_empresa"
                                    class="select2 form-select edit_id_empresa"
                                    data-error-message="por favor selecciona la empresa">
                                    <option value="" disabled selected>Selecciona la empresa</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    id="edit_fecha_visita" name="fecha_visita" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="form-select select2" id="edit_id_instalacion" name="id_instalacion"
                                    aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                    <!-- Aquí se llenarán las opciones con instalaciones del cliente -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="instalacion_id">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6 select2-dark">
                                <select id="edit_categoria_in" name="categorias[]" class="form-select select2"
                                    data-placeholder="Seleccione una o más categorias" multiple>
                                    @foreach ($categorias as $cate)
                                        <option value="{{ $cate->id_categoria }}">{{ $cate->categoria }}</option>
                                    @endforeach
                                </select>
                                <label for="">Categorías de mezcal</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4 select2-dark">
                                <select id="edit_clases_in" name="clases[]" class="form-select select2"
                                    data-placeholder="Seleccione una o más clases" multiple>
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                <label for="">Clases de mezcal</label>
                            </div>
                        </div>

                        <!-- Nuevo select para renovación -->
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="edit_renovacion_in" name="renovacion" id="renovacion" class="form-select">
                                    <option value="" disabled selected>Seleccione una opción</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                                <label for="renovacion">¿Es renovación?</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea id="edit_info_adicional" name="info_adicional" class="form-control h-px-150"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnEditDicIns"><i class="ri-pencil-fill"></i> Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function obtenerInstalacion() {
        var empresa = $(".edit_id_empresa").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {

            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = "";
                    let seleccionado = "";
                    var instalacion_id = $("#instalacion_id").val();

                    for (let index = 0; index < response.instalaciones.length; index++) {
                        // Limpia el campo tipo usando la función limpiarTipo
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);

                        if (instalacion_id == response.instalaciones[index].id_instalacion) {
                            seleccionado = "selected";
                        } else {
                            seleccionado = ""; // Asegúrate de limpiar este valor si no coincide
                        }

                        contenido = '<option ' + seleccionado + ' value="' + response.instalaciones[index]
                            .id_instalacion + '">' +
                            tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>' + contenido;
                    }

                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }

                    $('#edit_id_instalacion').html(contenido);
                },
                error: function() {
                    console.error('Error al cargar las instalaciones.');
                }
            });
        }
    }

    // Reutiliza la función limpiarTipo
    function limpiarTipo(tipo) {
        try {
            // Convierte el JSON string a un array y únelos en una cadena limpia
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            // Si no es JSON válido, regresa el valor original
            return tipo;
        }
    }
</script>
