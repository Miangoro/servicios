<div class="modal fade" id="EditProv" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h4 class="modal-title text-white" id="editarProveedorText">Editar Proveedor</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 col-12">
                <form id="editarProveedorForm" class="row g-5">
                    @csrf
                    @method('PUT')
                    <div class="col-12 col-md-4">
                        <input type="hidden" id="id_proveedor_edit" name="idProveedorEdit"/>
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="nombre_Proveedor_Edit" name="nombreProveedorEdit" class="form-control"
                                placeholder="Nombre del proveedor" />
                            <label for="nombreProveedor">Nombre</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="direccion_Proveedor_Edit" name="direccionProveedorEdit" class="form-control"
                                placeholder="Dirección del proveedor" />
                            <label for="direccion_Proveedor">Dirección</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="rfc_Proveedor_Edit" name="rfcProveedorEdit" class="form-control"
                                placeholder="RFC del proveedor" />
                            <label for="rfc_Proveedor">RFC</label>
                        </div>
                    </div>
                    <div>
                        <h5 class="card-header">Datos Bancarios</h5>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="n_Banco_Edit" name="nombreBancoEdit" class="form-control"
                                placeholder="Nombre del banco" />
                            <label for="n_Banco">Nombre del banco</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="clabe_Interbancaria_Edit" name="clabeInterbancariaEdit" class="form-control"
                                placeholder="Clabe Interbancaria" />
                            <label for="clabe_Interbancaria_Edit">Clabe</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="file" id="url_Adjunto_Edit" name="urlAdjuntoEdit" class="form-control" />
                            <label for="url_Adjunto">Datos bancarios</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <select id="select_Tipo_Compra_Edit" class="form-select form-floating form-floating-outline"
                            name="selectTipoCompraEdit">
                            <option value="">Tipo de compra</option>
                            <option value="1">Productos</option>
                            <option value="2">Servicios</option>
                            <option value="3">Ambos</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <h5 class="card-header">Contactos</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="editContactosTable">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th><button type="button" class="btn  btn-primary" id="EditContactRow">
                                                <i class="ri-add-line me-1"></i>
                                            </button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" id="EditProveedorSubmit" class="btn btn-primary me-sm-3 me-1 data-submit">
                            <i class="ri-add-line"></i> Guardar
                        </button>
                        <button type="reset" id="cancelarBtn" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ri-close-line"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>