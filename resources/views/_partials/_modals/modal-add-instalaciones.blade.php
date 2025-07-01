<!-- MODAL AGREGAR -->
<div class="modal fade" id="modalAddInstalacion" aria-labelledby="modalAddInstalacionLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 id="modalAddInstalacionLabel" class="modal-title text-white">Nueva Instalación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="addNewInstalacionForm">
                    @csrf

                    <div class="form-floating form-floating-outline mb-4">
                        <select id="id_empresa" name="id_empresa" class="form-select select2" required>
                            <option value="" disabled selected>Selecciona el cliente</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->id_empresa }}">{{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }} | {{ $empresa->razon_social }}</option>
                            @endforeach
                        </select>
                        <label for="id_empresa">Cliente</label>
                    </div>
                
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Select de Tipo de Instalación -->
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="select2 form-select" id="tipo" name="tipo[]" aria-label="Tipo de Instalación" multiple>
                                    <option value="Productora">Productora</option>
                                    <option value="Envasadora">Envasadora</option>
                                    <option value="Comercializadora">Comercializadora</option>
                                    <option value="Almacen y bodega">Almacén y bodega</option>
                                    <option value="Area de maduracion">Área de maduración</option>
                                </select>
                                <label for="tipo">Tipo de Instalación</label>
                            </div>
                        </div>
                            <!-- Input de Estado -->
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select select2" id="estado" name="estado" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-3 d-none" id="eslabon-select">
                        <select class="form-select" id="eslabon" name="eslabon">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Productora">Productora</option>
                            <option value="Envasadora">Envasadora</option>
                            <option value="Comercializadora">Comercializadora</option>
                        </select>
                        <label for="eslabon">Elige el eslabón al que pertenece</label>
                    </div>                        

                    <!-- Input de Dirección Completa -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="direccion" placeholder="Ingrese la dirección completa" name="direccion_completa" aria-label="Dirección Completa" required>
                        <label for="direccion">Dirección Completa</label>
                    </div>

                    <!-- Input de Responsable de Instalación -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="responsable" placeholder="Ingrese el nombre del responsable de la instalación" name="responsable" aria-label="Responsable de Instalación" required>
                        <label for="responsable_instalacion">Responsable de Instalación</label>
                    </div>

                    <!-- Select de Tipo de Certificación -->
                    <div class="form-floating form-floating-outline mb-3 mt-4">
                        <select class="form-select" id="certificacion" name="certificacion" aria-label="Tipo de Certificación" required>
                            <option value="" disabled selected>Seleccione el tipo de certificación</option>
                            <option value="oc_cidam">Certificación por OC CIDAM</option>
                            <option value="otro_organismo">Certificado por otro organismo</option>
                        </select>
                        <label for="certificacion">Tipo de Certificación</label>
                    </div>

                    <!-- Campos adicionales para "Certificado por otro organismo" -->
                    <div id="certificado-otros" class="d-none mt-4">

                        <div class="col-md-12 mb-3">
                            <div class="form-floating form-floating-outline">
                                {{-- subida de archivos --}}
                            </div>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="folio" placeholder="Folio/Número del certificado" name="folio" aria-label="Folio/Número del certificado">
                            <label for="folio_certificado">Folio/Número del certificado</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select" id="id_organismo" name="id_organismo" data-placeholder="Seleccione un organismo de certificación" aria-label="Organismo de Certificación">
                                <option value="" disabled selected>Seleccione un organismo de certificación</option>
                                @foreach($organismos as $organismo)
                                    <option value="{{ $organismo->id_organismo }}">{{ $organismo->organismo }}</option>
                                @endforeach
                            </select>
                            <label for="id_organismo">Organismo de Certificación</label>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input  placeholder="YYYY-MM-DD" type="text" class="form-control flatpickr-datetime" id="fecha_emision" name="fecha_emision" aria-label="Fecha de Emisión">
                                    <label for="fecha_emision">Fecha de Emisión</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input  placeholder="YYYY-MM-DD" type="text" class="form-control flatpickr-datetime" id="fecha_vigencia" name="fecha_vigencia" aria-label="Fecha de Vigencia">
                                    <label for="fecha_vigencia">Fecha de Vigencia</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i>
                            Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>




<!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditInstalacion" aria-labelledby="modalEditInstalacionLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 id="modalEditInstalacionLabel" class="modal-title text-white">Editar Instalación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editInstalacionForm">
                    @csrf

                    <div class="form-floating form-floating-outline mb-4">
                        <select id="edit_id_empresa" name="edit_id_empresa" class="form-select select2" required>
                            <option value="" disabled selected>Selecciona el cliente</option>
                            @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->id_empresa }}">{{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }} | {{ $empresa->razon_social }}</option>
                            @endforeach
                        </select>
                        <label for="edit_id_empresa">Cliente</label>
                    </div>

                    <div class="row">
                            <div class="col-md-6">
                                <!-- Select de Tipo de Instalación -->
                                <div class="form-floating form-floating-outline mb-3">
                                    <select class="select2 form-select" id="edit_tipo" name="edit_tipo[]" aria-label="Tipo de Instalación" multiple>
                                        <option value="Productora">Productora</option>
                                        <option value="Envasadora">Envasadora</option>
                                        <option value="Comercializadora">Comercializadora</option>
                                        <option value="Almacen y bodega">Almacén y bodega</option>
                                        <option value="Area de maduracion">Área de maduración</option>
                                    </select>
                                    <label for="edit_tipo">Tipo de Instalación</label>
                                </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Input de Estado -->
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select select2" id="edit_estado" name="edit_estado" required>
                                    <option value="" disabled selected>Seleccione un estado</option>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_estado">Estado</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-3 d-none" id="edit_eslabon-select">
                        <select class="form-select" id="edit_eslabon" name="edit_eslabon">
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="Productora">Productora</option>
                            <option value="Envasadora">Envasadora</option>
                            <option value="Comercializadora">Comercializadora</option>
                        </select>
                        <label for="eslabon">Elige el eslabón al que pertenece</label>
                    </div>     

                    <!-- Input de Dirección Completa -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_direccion" placeholder="Ingrese la dirección completa" name="edit_direccion" aria-label="Dirección Completa" required>
                        <label for="edit_direccion">Dirección Completa</label>
                    </div>

                    <!-- Input de Responsable de Instalación -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_responsable" placeholder="Ingrese el nombre del responsable de la instalación" name="edit_responsable" aria-label="Responsable de Instalación" required>
                        <label for="edit_responsable">Responsable de Instalación</label>
                    </div>

                    <!-- Select de Tipo de Certificación -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select" id="edit_certificacion" name="edit_certificacion" aria-label="Tipo de Certificación" required>
                            <option value="" disabled selected>Seleccione el tipo de certificación</option>
                            <option value="oc_cidam">Certificación por OC CIDAM</option>
                            <option value="otro_organismo">Certificado por otro organismo</option>
                        </select>
                        <label for="edit_certificacion">Tipo de Certificación</label>
                    </div>

                    <!-- Campos adicionales para "Certificado por otro organismo" -->
                    <div id="edit_certificado_otros" class="d-none">
                        <div class="col-md-12 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control form-control-sm" type="file" id="edit_file" name="edit_url[]">
                                <input value="0" class="form-control" type="hidden" name="edit_id_documento[]">
                                <input value="Certificado de instalaciones" class="form-control" type="hidden" name="edit_nombre_documento[]">
                                <label for="edit_certificado_instalaciones">Adjuntar Certificado de Instalaciones</label>
                            </div>
                            <div id="archivo_url_display" class="mt-2 text-primary"></div>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="edit_folio" placeholder="Folio/Número del certificado" name="edit_folio" aria-label="Folio/Número del certificado">
                            <label for="edit_folio">Folio/Número del certificado</label>
                        </div>

                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select" id="edit_id_organismo" name="edit_id_organismo" data-placeholder="Seleccione un organismo de certificación" aria-label="Organismo de Certificación">
                                <option value="" disabled selected>Seleccione un organismo de certificación</option>
                                @foreach($organismos as $organismo)
                                    <option value="{{ $organismo->id_organismo }}">{{ $organismo->organismo }}</option>
                                @endforeach
                            </select>
                            <label for="edit_id_organismo">Organismo de Certificación</label>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control flatpickr-datetime" id="edit_fecha_emision" name="edit_fecha_emision" aria-label="Fecha de Emisión">
                                    <label for="edit_fecha_emision">Fecha de Emisión</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control flatpickr-datetime" id="edit_fecha_vigencia" name="edit_fecha_vigencia" aria-label="Fecha de Vigencia">
                                    <label for="edit_fecha_vigencia">Fecha de Vigencia</label>
                                </div>
                            </div>
                        </div>
                    </div>

                  
                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-pencil-fill"></i>
                            Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                            class="ri-close-line"></i> Cancelar</button>
                    </div>
            </form>
            </div>
        </div>
    </div>
</div>