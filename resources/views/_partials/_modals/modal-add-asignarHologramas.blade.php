<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="asignarHolograma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Visualiza el rango de hologramas</h4>
                    <p class="address-subtitle"><b style="color: red">Nota: </b> El personal imprime los hologramas y registra el rango de hologramas que esta imprimiendo</p>
                </div>
                <form id="asignarHologramaForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <input type="hidden" id="id_solicitudAsignar" name="id_solicitud">                   
                    <input type="hidden" id="empresaAsignar" name="empresa">
           
                    @csrf
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="number" id="asig_folio_inicial" name="asig_folio_inicial" placeholder="Número de hologramas solicitados" readonly required />
                            <label for="asig_folio_inicial">Número de hologramas solicitados</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control" type="number" id="asig_folio_final" name="asig_folio_final" placeholder="Número de hologramas solicitados" readonly required />
                            <label for="asig_folio_final">Número de hologramas solicitados</label>
                        </div>
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
