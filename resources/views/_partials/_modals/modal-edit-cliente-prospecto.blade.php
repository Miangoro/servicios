<div class="modal fade" id="editClientesProspectos" tabindex="-1" aria-labelledby="modalEditClientesProspectosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 id="modalEditClientesProspectosLabel" class="modal-title">Editar Cliente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form id="editClienteForm">
                  @csrf
                  <input type="hidden" id="edit_id_cliente" name="id_cliente" value="">

                  <div class="row mb-4">
                      <div class="col-md-6 mb-4">
                          <div class="form-floating form-floating-outline">
                              <input type="text" id="edit_nombre_cliente" class="form-control" name="nombre_cliente" placeholder="Cliente" autocomplete="off">
                              <label for="edit_nombre_cliente">Nombre del cliente</label>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <select id="edit_regimen" class="form-select" name="regimen">
                              <option value="" disabled selected>Selecciona el régimen</option>
                              <option value="Persona física">Persona física</option>
                              <option value="Persona moral">Persona moral</option>
                          </select>
                          <label for="edit_regimen">Régimen</label>
                      </div>
                      </div>
                  </div>
                  <div class="row mb-4">
                      <div class="col">
                          <div class="form-floating form-floating-outline">
                              <input type="text" id="edit_domicilio_fiscal" class="form-control" name="domicilio_fiscal" placeholder="Domicilio fiscal" autocomplete="off">
                              <label for="edit_domicilio_fiscal">Domicilio fiscal</label>
                          </div>
                      </div>
                  </div>
                  <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary me-3">Actualizar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>

              </form>
          </div>
      </div>
  </div>
</div>
