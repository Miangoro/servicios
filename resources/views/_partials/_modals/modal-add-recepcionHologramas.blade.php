<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addRecepcion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Recepción de Hologramas</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addRecepcionForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <input type="hidden" id="recepcion_id_solicitud" name="id_solicitud">                   
                    <input type="hidden" id="recepcion_empresa" name="empresa">
           
                    @csrf
 
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control form-control-sm" type="file" name="url[]">
                        <input value="51" class="form-control" type="hidden" name="id_documento[]">
                        <input value="Comprobante de pago" class="form-control" type="hidden"
                            name="nombre_documento[]">
                        <label for="Comprobante de pago">Adjuntar Comprobante de Pago</label>
                    </div> 

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancelar</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>




<script>
    
</script>
