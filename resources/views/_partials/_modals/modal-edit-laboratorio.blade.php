<!-- Add New Address Modal -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>

.modal-header.bg-custom-green-modal-header {
    background-color: rgb(88, 213, 117); 
    color: white; 
    border-bottom: none; 
    
    
    padding-top: 0.75rem;   
    padding-bottom: 0.75rem; 
    
    padding-left: 1.5rem; 
    padding-right: 1.5rem; 
    
    
    border-top-left-radius: var(--bs-modal-border-radius, 0.3rem);
    border-top-right-radius: var(--bs-modal-border-radius, 0.3rem);
}


.modal-header.bg-custom-green-modal-header .modal-title {
    color: white; 
    margin-bottom: 0;
}


.modal-header.bg-custom-green-modal-header .btn-close {
    filter: invert(1) grayscale(1) brightness(2); 
    margin: -0.5rem -0.5rem -0.5rem auto; 
}


.modal-content {
    border-top: 5px solid rgb(88, 213, 117); 
    border-radius: var(--bs-modal-border-radius, 0.3rem); 
}

</style>

<div class="modal fade" id="editLabModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      
      <div class="modal-header bg-custom-green-modal-header">
        <h4 class="modal-title" id="agregarLabLabel">Editar Laboratorio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <form id="editLaboratorio" class="row g-5" >
          @csrf
          @method('PUT')
          <input type="hidden" id="id_laboratorio_modal" name="id_laboratorio">
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="nombre_laboratorio_modal" name="laboratorio" class="form-control" placeholder="Nombre laboratorio" required/>
              <label for="nombre_laboratorio_modal">Nombre</label>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="clave_laboratorio_modal" name="clave" class="form-control" placeholder="Doe" />
              <label for="clave_laboratorio_modal">Clave</label>
            </div>
          </div>
           <div class="col-12">
            <div class="form-floating form-floating-outline">
              <input type="text" id="descripcion_laboratorio_modal" name="descripcion" class="form-control" placeholder="12, Business Park" />
              <label for="descripcion_laboratorio_modal">Descripción</label>
            </div>
          </div>
          
          <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
            <button type="submit" class="btn btn-primary">Editar</button>
            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>