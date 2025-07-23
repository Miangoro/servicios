<div class="modal fade" id="agregarLab" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h4 class="modal-title text-white" id="agregarLabLabel">Agregar Proveedor</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 col-12">
                <form id="agregarProveedorForm" class="row g-5">
                    @csrf
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="nombreProveedor" name="nombreProveedor" class="form-control"
                                placeholder="Nombre del proveedor" />
                            <label for="nombreProveedor">Nombre</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="direccionProveedor" name="direccionProveedor" class="form-control"
                                placeholder="Dirección del proveedor" />
                            <label for="direccionProveedor">Dirección</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="rfcProveedor" name="rfcProveedor" class="form-control"
                                placeholder="RFC del proveedor" />
                            <label for="rfcProveedor">RFC</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="claveInterbancaria" name="claveInterbancaria" class="form-control"
                                placeholder="Clabe Interbancaria" />
                            <label for="claveInterbancaria">Clabe</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="file" id="datosBancarios" name="datosBancarios" class="form-control" />
                            <label for="datosBancarios">Datos bancarios</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <select id="selectTipoCompra" class="form-select data-submit" name="selectTipoCompra"
                            data-fvalidate="notEmpty">
                            <option value="">Tipo de compra</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-12">

                        <div class="card-body">
                            <div class="form-repeater">
                                <div class="col-md-12 d-flex flex-direction-row">
                                    <h5 class="card-header">Contactos</h5>
                                    <div class="mb-5 me-1">
                                        <button type="button" class="btn btn-primary" data-repeater-create>
                                            <i class="ri-add-line me-1"></i>
                                            <span class="align-middle"></span>
                                        </button>
                                    </div>
                                </div>
                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="mb-6 col-lg-6 col-xl-4 col-12 mb-0">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="form-repeater-1-1" class="form-control"
                                                        placeholder="Nombre del contacto" />
                                                    <label for="form-repeater-1-1">Nombre</label>
                                                </div>
                                            </div>
                                            <div class="mb-6 col-lg-6 col-xl-3 col-12 mb-0">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="form-repeater-1-1" class="form-control"
                                                        placeholder="Número de celular" />
                                                    <label for="form-repeater-1-1">Celular</label>
                                                </div>
                                            </div>
                                            <div class="mb-6 col-lg-6 col-xl-4 col-12 mb-0">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="text" id="form-repeater-1-1" class="form-control"
                                                        placeholder="Correo electrónico" />
                                                    <label for="form-repeater-1-1">Correo</label>
                                                </div>
                                            </div>
                                            <div class="mb-6 col-lg-12 col-xl-1 col-12 d-flex align-items-center mb-0">
                                                <button type="button" class="btn btn-outline-danger btn-xl"
                                                    data-repeater-delete>
                                                    <i class="ri-close-line ri-24px me-1"></i>
                                                    <span class="align-middle"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <hr class="mt-0">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
                            <i class="ri-add-line"></i> Agregar
                        </button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ri-close-line"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>