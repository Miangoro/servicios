<div class="modal fade" id="modalAddServiciosCatalogo">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="exportarVentasModalLabel">Agregar servicio de catálogo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddServiciosCatalogo" method="GET">
                <div class="modal-body">
                    <span class="mb-5">Información principal</span>
                    <div class="row col-md-12 mb-5">
                        <div class="form-floating form-floating-outline col-md-4">
                            <select id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true">
                                <option value="">Seleccione una clave</option>
                            </select>
                        </div>
                        <div class="form-floating form-floating-outline col-md-4">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Escriba una clave adicional (opcional)" aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Clave adicional</label>
                        </div>

                        <div class="form-floating form-floating-outline col-md-4">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Escriba el nombre del servicio" aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Nombre del servicio</label>
                        </div>
                    </div>
                    
                     <div class="row col-md-12 mb-5">
                        <div class="form-floating form-floating-outline col-md-4">
                            <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                <option value="">Seleccione la duración</option>
                                <option>1 día</option>
                                <option>2 días</option>
                            </select>
                            <label for="selectpickerBasic">Duración</label>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>