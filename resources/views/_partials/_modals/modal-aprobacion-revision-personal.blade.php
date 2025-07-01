<!-- Modal -->
<div class="modal fade" id="modalAprobacion" tabindex="-1" aria-labelledby="modalAprobacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAprobacionLabel">Aprobación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="border-radius: 10px;">
                    <h4><p>CERTIFICADO: <span id="numero-certificado"></span></p></h4>
                </div>
                <form id="formAprobacion">
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="id_firmante" name="id_firmante" aria-label="Nombre Firmante" required>
                            <option value="" disabled selected>¿Quién aprueba?</option>
                            @foreach($users as $revisor)
                                <option value="{{ $revisor->id }}">{{ $revisor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-floating form-floating-outline me-2 flex-fill">
                            <select class="form-select" id="respuesta-aprobacion" name="respuesta-aprobacion" aria-label="Respuesta" required>
                                <option value="" disabled selected>Seleccione una decisión</option>
                                <option value="aprobado">Aprobado</option>
                                <option value="desaprobado">Desaprobado</option>
                            </select>
                            <label for="respuesta-aprobacion">Respuesta</label>
                        </div>

                        <div class="form-floating form-floating-outline flex-fill">
                            <input class="form-control datepicker" id="fecha-aprobacion" placeholder="yyyy-mm-dd" name="fecha-aprobacion" aria-label="Fecha de Aprobación" autocomplete="off" required>
                            <label for="fecha-aprobacion">Fecha de Aprobación</label>
                        </div>
                    </div>

                    <!-- Botones dentro del formulario -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2" id="btnRegistrar">Registrar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>