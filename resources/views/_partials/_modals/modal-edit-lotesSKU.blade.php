<div class="modal fade" id="reclasificacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-edit-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Reclasificación SKU</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="reclasificacionForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <input type="hidden" id="id_lote_envasado" name="id">
                    <input type="hidden" id="edictt_sku" name="edictt_sku">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" id="nuevo" class="form-control"
                                    placeholder="No. de pedido/SKU" aria-label="Nuevo SKU" name="nuevo" />
                                <label for="nuevo">Nuevo SKU</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" id="cantt_botellas" class="form-control"
                                    placeholder="No. de pedido/SKU" aria-label="No. de pedido/SKU" name="cantt_botellas" />
                                <label for="cantt_botellas">Cantidad de botellas</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <textarea name="observaciones" class="form-control h-px-100" id="observaciones" placeholder="Observaciones..."></textarea>
                        <label for="observaciones">Observaciones</label>
                    </div>

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>