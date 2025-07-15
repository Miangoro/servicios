<!-- Add Role Modal -->
<div class="modal fade" id="editUnidadesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role"">
    <div class="modal-content">

      
      <div class="modal-header bg-custom-green-modal-header">
        <h4 class="modal-title" id="agregarUnidadesLabel">Registrar Nueva Unidad</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="editarunidad" class="row g-3" onsubmit="return false">
          @csrf 
          @method('PUT')
          <input type="hidden" id="idUnidad" name="id_unidad"/>
           <div class="col-12 mb-3"> 
          <div class="form-floating form-floating-outline">
                <input type="text" id="nombre_Unidad" name="nombre_Unidad" class="form-control" placeholder="Enter a role name" tabindex="-1" />
                <label for="nombre_Unidad">Nombre de la Unidad</label>
            </div>
            </div>
          <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" id="registrar-editar" class="btn btn-primary me-sm-3 me-1 data-submit"><i
                                class="ri-add-line"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="offcanvas"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>
        </form>
      </div>

    </div>
  </div>
</div>





