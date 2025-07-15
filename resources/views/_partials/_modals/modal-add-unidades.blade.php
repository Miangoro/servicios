<div class="modal fade" id="agregarUnidades" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-custom-green-modal-header">
                <h4 class="modal-title" id="agregarUnidadesLabel">Registrar Nueva Unidad</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarUnidad" class="row g-3">
                    @csrf 
                    <div class="form-floating form-floating-outline mb-3"> <input type="text" id="nombreUnidad" name="nombreUnidad" class="form-control" placeholder=" " />
                        <label for="nombreUnidad">Nombre de la Unidad</label>
                    </div>

                    <div class="col-12 text-end mt-4"> 
                        <hr class="mb-3"> 
                        <button type="submit" class="btn btn-primary me-2"> 
                            <i class="ri-add-line"></i> Registrar
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="ri-close-line"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



