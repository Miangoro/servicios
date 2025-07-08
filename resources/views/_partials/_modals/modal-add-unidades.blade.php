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

<div class="modal fade" id="agregarUnidades" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      
      <div class="modal-header bg-custom-green-modal-header">
        <h4 class="modal-title" id="agregarUnidadesLabel">Registrar Nueva Unidad</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="addNewAddressForm" class="row g-3" onsubmit="return false">
          
           <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressLastName" name="modalAddressLastName" class="form-control" placeholder=" " />
              <label for="modalAddressLastName">Nombre de la Unidad</label>
            </div>

          <div class="col-12 text-end mt-4"> 
            <hr class="mb-3"> 
            <button type="submit" class="btn btn-primary me-2"> 
                <i class="fas fa-plus me-2"></i> Registrar
            </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                <i class="fas fa-times me-2"></i> Cancelar
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>