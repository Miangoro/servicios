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

<div class="modal fade" id="editUnidadesModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      
      <div class="modal-header bg-custom-green-modal-header">
        <h4 class="modal-title" id="agregarUnidadesLabel">Registrar Nueva Unidad</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="editarunidad" class="row g-3">
          @csrf 
          @method('PUT')
          <input type="hidden" id="idUnidad" name="id_unidad"/>
            <div class="form-floating form-floating-outline">
                <input type="text" id="nombre_Unidad" name="nombre_Unidad" class="form-control" placeholder=" " />
                <label for="nombre_Unidad">Nombre de la Unidad</label>
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

<script>
// Define la función globalmente
window.editUnidad = function(id) {
    fetch(`/getUnidad/${id}`)
        .then(response => {
            if (!response.ok) throw new Error('Error en la red');
            return response.json();
        })
        .then(data => {
            if (data.error) throw new Error(data.error);
            
            // Rellena el formulario
            document.getElementById('idUnidad').value = data.id_unidad;
            document.getElementById('nombre_Unidad').value = data.nombre_Unidad;
            
            // Muestra el modal
            const modal = new bootstrap.Modal(document.getElementById('editUnidadesModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar: ' + error.message);
        });
};

// Maneja el envío del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editarunidad');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = document.getElementById('idUnidad').value;
            const formData = new FormData(form);
            
            fetch(`/unidades/${id}`, {
                method: 'POST', // Laravel necesita POST para rutas PUT
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) throw new Error(data.error);
                if (data.message) {
                    alert(data.message);
                    // Cierra el modal y recarga la tabla
                    bootstrap.Modal.getInstance(document.getElementById('editUnidadesModal')).hide();
                    $('#tablaLaboratorios').DataTable().ajax.reload(null, false);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar: ' + error.message);
            });
        });
    }
});
</script>



