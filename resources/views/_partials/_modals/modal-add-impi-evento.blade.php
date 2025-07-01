<!-- AGREGAR NUEVO EVENTO IMPUI MODAL -->
<div class="modal fade" id="addEvento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
        <div class="modal-content">

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Agregar evento al folio: </h4>
                </div>

                <form id="NuevoEvento">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" placeholder="Titulo"
                                    name="evento" aria-label="Nombre">
                                <label for="">Titulo</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-12">
                                <textarea name="descripcion" class="form-control h-px-100" 
                                        placeholder="Descripción"></textarea>
                                <label for="">Descripción</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="" class="form-select" name="estatus"
                                    aria-label="Default select example">
                                    <option value="1">Pendiente</option>
                                    <option value="2">Trámite</option>
                                    <option value="3">Trámite favorable</option>
                                    <option value="4">Trámite no favorable</option>
                                </select>
                                <label for="">Estatus</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="file" class="form-control" id="" placeholder="Titulo"
                                    name="anexo" >
                                <label for="">Anexo</label>
                            </div>
                        </div>
                    </div>


                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">crear</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
