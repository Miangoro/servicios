<!-- Modal Asignar Revisor -->
<div class="modal fade" id="asignarRevisorModal" tabindex="-1" aria-labelledby="asignarRevisorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="asignarRevisorModalLabel">Asignar revisor <span id="folio_certificado"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="asignarRevisorForm">

                    <!-- Revisión por parte de -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select" id="tipoRevisor" name="tipoRevisor"
                            aria-label="Revisión por parte de" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Personal del organismo certificador</option>
                            <option value="2">Miembro del consejo para la decisión de la certificación</option>
                        </select>
                        <label for="tipoRevisor">Revisión por parte de</label>
                    </div>

                    <!-- Selecciona el nombre del revisor -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="nombreRevisor" name="nombreRevisor"
                            aria-label="Selecciona el nombre del revisor" required>
                            <option value="" disabled selected>Seleccione un revisor</option>
                        </select>
                        <label for="formValidationSelect2">Selecciona un revisor</label>
                    </div>

                    <!-- Selecciona el número de revisión -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select" id="numeroRevision" name="numeroRevision"
                            aria-label="Selecciona el número de revisión" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Primera revisión</option>
                            <option value="2">Segunda revisión</option>
                        </select>
                        <label for="numeroRevision">Selecciona el número de revisión</label>
                    </div>

                    <!-- ¿Es una corrección? -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="esCorreccion" name="esCorreccion">
                        <label class="form-check-label" for="esCorreccion">¿Es una corrección?</label>
                    </div>

                    <!-- Observaciones o indicaciones -->
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones o indicaciones que le ayuden al
                            revisor:</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                            placeholder="Escribe observaciones o indicaciones (opcional)"></textarea>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control form-control-sm" id="nombre_documento"
                            name="nombre_documento" placeholder="Nombre del documento">
                        <label for="nombre_documento">Nombre del documento</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <input type="file" class="form-control form-control-sm" id="archivo_documento" name="url"
                            placeholder="Archivo">
                        <label for="archivo_documento">Archivo</label>
                    </div>

                    <input type="hidden" name="id_documento" value="133">



                    <!-- Botón de enviar -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ri-user-add-line"></i> Asignar revisor</button>
                        <button type="button" class="btn btn-danger"  
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                    <input type="hidden" name="id_certificado" id="id_certificado">
                </form>
            </div>
        </div>
    </div>
</div>
