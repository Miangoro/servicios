
        <!-- Modal para agregar nuevo predio -->
        <div class="modal fade" id="modalEditDestino" tabindex="-1" aria-labelledby="modalEditDestinoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalEditDestinoLabel" class="modal-title">Editar dirección de destino</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="EditDestinoForm">
                            @csrf
                            <input type="hidden" class="mb-4" id="edit_destinos_id" name="id_direccion">

                            <!-- Tipo de Dirección -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="edit_tipo_direccion" name="tipo_direccion" class="form-select">
                                            <option value="" disabled selected>Selecciona el tipo de dirección</option>
                                            <option value="1">Para exportación</option>
                                            <option value="2">Para venta nacional</option>
                                            <option value="3">Para envío de hologramas</option>
                                        </select>
                                        <label for="tipo_direccion">Tipo de Dirección</label>
                                    </div>
                                </div>

                                <!-- Select de Empresa Cliente -->
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="edit_id_empresa" name="id_empresa" class=" form-select">
                                            <option value="" disabled selected>Selecciona la empresa cliente
                                            </option>
                                            @foreach ($empresas as $empresa)
                                                @if ($empresa->tipo == 2)
                                                    <option value="{{ $empresa->id_empresa }}">
                                                        {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }} | {{ $empresa->razon_social }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <label for="id_empresa">Empresa Cliente</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Domicilio Completo -->
                            <div class="form-floating form-floating-outline mb-4">
                                <textarea class="form-control" id="edit_direccion" name="direccion" placeholder="Domicilio completo"  autocomplete="off"></textarea>
                                <label for="direccion">Domicilio Completo</label>
                            </div>
                            <!-- Campos adicionales para exportación -->
                            <div id="exportacionFieldsEdit" style="display: none;">
                                <div class="row mb-4">
                                    <!-- Nombre del Destinatario -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_destinatario"
                                                name="destinatario" placeholder="Nombre del destinatario"  autocomplete="off">
                                            <label for="destinatario">Nombre del Destinatario</label>
                                        </div>
                                    </div>
                                {{-- </div>

                                <div class="row mb-4"> --}}
                                    <!-- Aduana de Despacho -->
                                    {{-- <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_aduana" name="aduana"
                                                placeholder="Aduana de despacho"  autocomplete="off">
                                            <label for="aduana">Aduana de Despacho</label>
                                        </div>
                                    </div> --}}

                                    <!-- País de Destino -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_pais_destino"
                                                name="pais_destino" placeholder="País de destino"  autocomplete="off">
                                            <label for="pais_destino">País de Destino</label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Campos adicionales para envío de hologramas -->
                            <div id="hologramasFieldsEdit" style="display: none;">
                                <div class="row mb-4">
                                    <!-- Correo -->
                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input type="email" class="form-control" id="edit_correo_recibe"
                                                name="correo_recibe" placeholder="Correo electrónico"  autocomplete="off">
                                            <label for="correo_recibe">Correo Electrónico</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <!-- Nombre Completo del Recibe Hologramas -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_nombre_recibe"
                                                name="nombre_recibe"  autocomplete="off"
                                                placeholder="Nombre completo del receptor de hologramas">
                                            <label for="nombre_recibe">Nombre Completo del Recibe Hologramas</label>
                                        </div>
                                    </div><!-- Celular -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="edit_celular_recibe"
                                                name="celular_recibe" placeholder="Número de teléfono"  autocomplete="off">
                                            <label for="celular_recibe">Celular</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        