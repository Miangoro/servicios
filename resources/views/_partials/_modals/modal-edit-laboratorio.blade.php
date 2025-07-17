<!-- Add New Address Modal -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


<div class="modal fade" id="editLabModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      
      <div class="modal-header bg-primary pb-4">
        <h4 class="modal-title text-white" id="agregarLabLabel">Editar Laboratorio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <form id="editLaboratorio" class="row g-5" >
          @csrf
          @method('PUT')
          <input type="hidden" id="id_laboratorio_modal" name="id_laboratorio">
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="clave_laboratorio_modal" name="clave" class="form-control"/>
              <label for="clave_laboratorio_modal">Clave</label>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="nombre_laboratorio_modal" name="laboratorio" class="form-control"/>
              <label for="nombre_laboratorio_modal">Nombre</label>
            </div>
          </div>
          <div class="mb-4">
                        <select id="selectUnidadesEdit" class="form-select data-submit" name="selectUnidadesEdit" data-fvalidate="notEmpty">
                         <option value="">Seleccione una unidad</option>
                        </select>
                    </div>
           <div class="col-12">
              <div class="form-floating form-floating-outline mb-6">
                  <textarea class="form-control h-px-100" id="descripcion_laboratorio_modal" name="descripcion" placeholder="Descripción"></textarea>
                  <label for="descripcion_laboratorio_modal">Descripción</label>
              </div>
          </div>
          
          <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                  <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
                    <i class="ri-save-line"></i> Guardar
                  </button>
                  <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                     <i class="ri-close-line"></i> Cancelar
                  </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>