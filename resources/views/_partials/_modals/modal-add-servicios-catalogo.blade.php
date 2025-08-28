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
                            <input type="text" class="form-control" id="" placeholder="Escriba el nombre del servicio" aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Nombre del servicio</label>
                        </div>
                    </div>
                    
                    <div class="row col-md-12 mb-5">

                        <div class="form-floating form-floating-outline col-md-4">
                            <input type="text" class="form-control" id="" placeholder="Escriba la duración del servicio" aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Duración del servicio</label>
                        </div>

                        <div class="form-floating form-floating-outline col-md-4">
                            <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                <option>Seleccione una opción</option>
                                <option>Sí</option>
                                <option>No</option>
                            </select>
                            <label for="selectpickerBasic">¿Se requiere muestra?</label>
                        </div>

                        <div class="form-floating form-floating-outline col-md-4">
                            <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                <option>Habilitado</option>
                                <option>No habilitado</option>
                                <option>Observado</option>
                            </select>
                            <label for="selectpickerBasic">Estatus</label>
                        </div>

                    </div>

                    <div class="row col-md-12 mb-5">

                        <div class="form-floating form-floating-outline col-md-4">
                            <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                <option>No acreditado</option>
                                <option>Acreditado para alimentos</option>
                                <option>Acreditado para sanidad</option>
                                <option>Acreditado para información comercial</option>
                            </select>
                            <label for="selectpickerBasic">Acreditación</label>
                        </div>

                        <div class="form-floating form-floating-outline col-md-4">
                            <input type="text" class="form-control" id="" placeholder="" aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Análisis</label>
                        </div>

                        <div class="form-floating form-floating-outline col-md-4">
                            <input type="text" class="form-control" id="" placeholder="Escriba la duración del servicio" aria-describedby="floatingInputHelp" />
                            <label for="floatingInput">Duración del servicio</label>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>