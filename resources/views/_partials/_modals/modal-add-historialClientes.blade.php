<!-- resources/views/_partials/_modals/modal-add-edit-Historial.blade.php -->
<!-- Este es el contenido de la modal de AGREGAR, que se carga directamente o se incluye en otra vista -->

<div class="modal fade" id="agregarEmpresa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h4 class="modal-title text-white" id="agregarEmpresaLabel">Registrar Nueva Empresa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarContacto" class="row g-5" action="{{ route('empresas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf {{-- Protección CSRF --}}

                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select id="modalAddressRegimen" name="regimen" class="select2 form-select" data-allow-clear="true">
                                <option value="">Selecciona un Regímen</option>
                                {{-- Itera sobre los regímenes fiscales obtenidos de la base de datos --}}
                                {{-- Asegúrate de que la variable $regimenes se pase a la vista que incluye esta modal --}}
                                @isset($regimenes)
                                    @foreach($regimenes as $regimen)
                                        <option value="{{ $regimen->id }}">{{ $regimen->regimen }}</option>
                                    @endforeach
                                @endisset
                            </select>
                            <label for="modalAddressRegimen">Regímen Fiscal </label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select id="modalAddressCredito" name="credito" class="select2 form-select" data-allow-clear="true">
                                <option value="">Selecciona una Opción</m>
                                <option value="Con Crédito">Con Crédito</option>
                                <option value="Sin Crédito">Sin Crédito</option>
                            </select>
                            <label for="modalAddressCredito">Crédito</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressRazonSocial" name="nombre" class="form-control" placeholder=" " />
                            <label for="modalAddressRazonSocial">Razón Social (Nombre de la empresa) </label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressRFC" name="rfc" class="form-control" placeholder=" " />
                            <label for="modalAddressRFC">RFC *</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressEstado" name="estado" class="form-control" placeholder=" " />
                            <label for="modalAddressEstado">Estado</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressMunicipio" name="municipio" class="form-control" placeholder=" " />
                            <label for="modalAddressMunicipio">Ciudad o municipio</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressLocalidad" name="localidad" class="form-control" placeholder=" " />
                            <label for="modalAddressLocalidad">Localidad</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressCalle" name="calle" class="form-control" placeholder=" " />
                            <label for="modalAddressCalle">Calle</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressNo" name="no_exterior" class="form-control" placeholder=" # " />
                            <label for="modalAddressNo">No</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressColonia" name="colonia" class="form-control" placeholder=" " />
                            <label for="modalAddressColonia">Colonia</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressCodigo" name="codigo_postal" class="form-control" placeholder=" " />
                            <label for="modalAddressCodigo">CP</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressTelefono" name="telefono" class="form-control" placeholder=" " />
                            <label for="modalAddressTelefono">Teléfono</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="modalAddressCorreo" name="correo" class="form-control" placeholder=" " />
                            <label for="modalAddressCorreo">Correo</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="file" id="modalAddressConstancia" name="constancia" class="form-control" placeholder=" " />
                            <label for="modalAddressConstancia">Constancia de situación fiscal</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Sección de Contactos Dinámicos --}}
                    <div class="col-12 mt-5">
                        <h5 class="mb-3">Contactos Adicionales</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;" class="text-center"> {{-- Columna para el botón '+' --}}
                                            <button type="button" class="btn btn-success btn-sm" id="add-contact-row-agregar">
                                                <i class="ri-add-line"></i>
                                            </button>
                                        </th>
                                        <th style="width: 30%;">Contacto</th>
                                        <th style="width: 30%;">Celular</th>
                                        <th style="width: 35%;">Correo</th>
                                    </tr>
                                </thead>
                                <tbody id="contact-rows-container-agregar">
                                    {{-- Las filas de contacto se añadirán aquí dinámicamente --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" id="agregar-empresa-btn" class="btn btn-primary me-2">
                            <i class="ri-add-line"></i> Agregar Empresa
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="ri-close-line"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Template para una nueva fila de contacto (oculto) --}}
<template id="contact-row-template">
    <tr class="contact-row">
        <td class="text-center"> {{-- Columna para el botón '-' --}}
            <button type="button" class="btn btn-danger btn-sm remove-contact-row">
                <i class="ri-delete-bin-7-line"></i>
            </button>
        </td>
        <td>
            <div class="form-floating form-floating-outline mb-0">
                <input type="text" class="form-control" name="contactos[INDEX][contacto]" placeholder="Nombre del Contacto" />
                <label>Contacto</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
        <td>
            <div class="form-floating form-floating-outline mb-0">
                <input type="text" class="form-control" name="contactos[INDEX][celular]" placeholder="Celular" />
                <label>Celular</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
        <td>
            <div class="form-floating form-floating-outline mb-0">
                <input type="email" class="form-control" name="contactos[INDEX][correo]" placeholder="Correo Electrónico" />
                <label>Correo</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
        {{-- Los campos de estatus y observaciones solo se mostrarán en la modal de edición --}}
        <td class="d-none"> {{-- Oculto por defecto --}}
            <div class="form-floating form-floating-outline mb-0">
                <select class="form-select form-control-sm" name="contactos[INDEX][status]">
                    <option value="0">Sin contactar</option>
                    <option value="1">Contactado</option>
                </select>
                <label>Estatus</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
        <td class="d-none"> {{-- Oculto por defecto --}}
            <div class="form-floating form-floating-outline mb-0">
                <textarea class="form-control form-control-sm h-px-40" name="contactos[INDEX][observaciones]" placeholder="Observaciones"></textarea>
                <label>Observaciones</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
    </tr>
</template>
