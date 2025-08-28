<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exportar Servicios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="exportForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="clave" class="form-label">Clave:</label>
                        <select class="form-select" id="clave" name="clave">
                            <option value="">Seleccione una clave</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="laboratorio" class="form-label">Laboratorio:</label>
                        <select class="form-select" id="laboratorio" name="laboratorio">
                            <option value="">Seleccione un laboratorio</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="estatus" class="form-label">Estatus:</label>
                        <select class="form-select" id="estatus" name="estatus">
                            <option value="">Seleccione un estatus</option>
                            <option value="acreditado">Acreditado</option>
                            <option value="no_acreditado">No Acreditado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_exportacion" class="form-label">Exportar:</label>
                        <select class="form-select" id="tipo_exportacion" name="tipo_exportacion">
                            <option value="todos">Todos los servicios</option>
                            <option value="filtrados">Servicios filtrados</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-file-excel-2-line align-middle"></i>
                        Exportar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
