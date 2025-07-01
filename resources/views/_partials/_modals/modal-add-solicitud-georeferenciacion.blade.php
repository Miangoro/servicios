<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addSolicitudGeoreferenciacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva solicitud de georeferenciación</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-8">
                <form id="addRegistrarSolicitudGeoreferenciacion">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerPredios2(this.value);" name="id_empresa"
                                    class="select2 form-select id_empresa" required id="id_empresa_georefere">
                                    <option selected disabled value="">Selecciona cliente</option>
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
                                    name="fecha_visita" id="fecha_visita_geo" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <select onchange="obtenerDatosPredios(this.value);" class="select2 form-select id_predio"
                                name="id_predio" aria-label="id_predio" id="id_predio_georefe">
                                <option value="" disabled selected>Lista de predios</option>
                            </select>
                            <label for="id_predio">Domicilio del predio a inspeccionar</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="Dirección del punto de reunión" class="form-control" type="text"
                                    name="punto_reunion" id="punto_reunion_georefere" />
                                <label for="num_anterior">Dirección del punto de reunión</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150 info_adicional" id="info"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary me-1 d-none" type="button" id="btnSpinnerGeoreferenciacion">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Registrando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnRegistrarGeo"><i
                                class="ri-add-line me-1"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function obtenerPredios2(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    // Cargar los detalles en el modal
                    var contenido = "";
                    for (let index = 0; index < response.predios.length; index++) {
                        contenido = '<option value="' + response.predios[index].id_predio + '">' + response
                            .predios[index].nombre_predio + ' | ' + response
                            .predios[index].ubicacion_predio + '</option>' + contenido;
                    }
                    if (response.predios.length == 0) {
                        contenido = '<option value="">Sin predios registrados</option>';
                    }
                    $('.id_predio').html(contenido);
                    if (response.predios.length != 0) {
                        obtenerDatosPredios($(".id_predio").val());
                    } else {
                        $('.info_adicional').val("");
                    }


                },
                error: function() {
                    //alert('Error al cargar los lotes a granel.');
                }
            });
        }
    }

    function obtenerDatosPredios(id_predio) {
        if (id_predio !== "" && id_predio !== null && id_predio !== undefined) {
            $.ajax({
                url: '/domicilios-predios/' + id_predio + '/edit',
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    var info_adicional =
                        'Predio: ' + response.predio.nombre_predio + '. ' +
                        'Punto de referencia: ' + response.predio.puntos_referencia + '. ' +
                        'Superficie: ' + response.predio.superficie + 'H';
                    $('.info_adicional').val(info_adicional);
                },
                error: function() {

                }
            });
        }
    }
</script>
