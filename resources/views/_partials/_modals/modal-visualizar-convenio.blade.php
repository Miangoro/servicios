<div class="modal fade" id="viewConvenioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary pb-4">
        <h4 class="modal-title text-white" id="viewConvenioModalLabel">Detalle del Convenio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3">
          <div class="col-12 mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="ri-key-2-line"></i></span>
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="viewClave" class="form-control" readonly />
                    <label for="viewClave">Clave</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="ri-flask-line"></i></span>
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="viewNombreProyecto" class="form-control" readonly />
                    <label for="viewNombreProyecto">Nombre del Proyecto</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 mb-3">
            <div class="row g-3">
              <div class="col-md-4">
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="ri-user-line"></i></span>
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="viewInvestigador" class="form-control" readonly />
                    <label for="viewInvestigador">Investigador responsable</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                  <input type="number" id="viewDuracion" class="form-control" readonly />
                  <label for="viewDuracion">Duración</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                  <select id="viewTipoDuracion" class="form-select" disabled>
                    <option value="" disabled>Selecciona una opción</option>
                    <option value="mes">Mes</option>
                    <option value="año">Año</option>
                    <option value="semanas">Semanas</option>
                    <option value="dias">Días</option>
                  </select>
                  <label for="viewTipoDuracion">Tipo Duración</label>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 text-end mt-4">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
              <i class="ri-close-line"></i> Cerrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
