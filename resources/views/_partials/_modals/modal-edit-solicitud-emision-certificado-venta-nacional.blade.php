<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="editSolicitudEmisionCertificado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de emisión de certificado venta nacional
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form id="editEmisionCetificadoVentaNacionalForm">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="id_solicitud" id="id_solicitud_emision_v">
                            <input type="hidden" name="form_type" value="emisionCertificadoVentaNacional">

                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_empresa_solicitud_emision_venta"
                                    onchange="editObtenerDictamenesEnvasados();" name="id_empresa"
                                    class="select2 form-select">
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
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_dictamen_envasado" name="id_dictamen_envasado"
                                    class="select2 form-select" onchange="editObtenerDatosDictamenesEnvasados();">
                                </select>
                                <label for="id_dictamen_envasado">Dictamen envasado</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                      <input type="hidden" id="edit_id_lote_envasado_emision_v" name="id_lote_envasado">
                        <input type="datetime-local" id="edit_fecha_visita_emision_v" name="fecha_visita"
                            class="form-control d-none">
                        <input type="hidden" id="edit_id_instalacion_emision_v" name="id_instalacion">
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="edit_num_cajas" name="cantidad_cajas" class="form-control">
                                <label for="num_cajas">No. de Cajas</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="number" id="edit_num_botellas" name="cantidad_botellas"
                                    class="form-control" required>
                                <label for="num_botellas">No. de Botellas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-150" id="edit_comentarios_e_venta_n"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnEditremi"><i class="ri-pencil-fill"></i>
                            Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function editObtenerDictamenesEnvasados() {
        var empresa = $("#edit_id_empresa_solicitud_emision_venta").val();
        if (!empresa) return;

        $.ajax({
            url: '/obtener_dictamenes_envasado/' + empresa,
            method: 'GET',
            success: function(response) {
               let opciones  = '<option disabled selected value="">Selecciona un dictamen</option>';
                response.forEach(function(dictamen) {
                    opciones += '<option value="' + dictamen.id_dictamen_envasado + '">' +
                        'Dictamen: ' + dictamen.num_dictamen + ' | ' +
                        'Solicitud: ' + dictamen.folio + ' | ' +
                        'Lote envasado: ' + dictamen.lote_nombre +
                        '</option>';
                });
                $('#edit_id_dictamen_envasado').html(opciones).trigger('change');
                const idDICPrevio = $('#edit_id_dictamen_envasado').data('selected');
                if (idDICPrevio) {
                    $('#edit_id_dictamen_envasado').val(idDICPrevio).trigger('change');
                }
            },
            error: function() {
                alert('Error al obtener dictámenes envasados.');
            }
        });
    }

    function editObtenerDatosDictamenesEnvasados() {
        var idDictamen = $('#edit_id_dictamen_envasado').val();

            if (!idDictamen) {
        // No hacer nada si no hay dictamen seleccionado
        return;
    }

        $.ajax({
            url: '/obtener_datos_inspeccion_dictamen/' + idDictamen,
            method: 'GET',
            success: function(response) {
                // Asignación de los datos
                $('#edit_id_lote_envasado_emision_v').val(response.id_lote_envasado);
                $('#edit_id_instalacion_emision_v').val(response.id_instalacion);
                $('#edit_fecha_visita_emision_v').val(response.fecha_visita);
            },
            error: function() {
                console.log('Error al obtener datos de inspección.');
            }
        });
    }
</script>
