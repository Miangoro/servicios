<!-- resources/views/_partials/_modals/modal-add-edit-Historial.blade.php -->
@php use Illuminate\Support\Facades\Storage; @endphp {{-- ¡IMPORTANTE: Añadido para resolver "Class Storage not found"! --}}

<!-- El contenido de esta vista será cargado dinámicamente dentro de la modal principal -->

<div class="modal-header bg-primary pb-4">
    <h4 class="modal-title text-white" id="editEmpresaModalLabel">Editar Empresa: {{ $empresa->nombre ?? 'Cargando...' }}</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form id="editarhistorial" class="row g-5" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Importante para el método UPDATE --}}
        <input type="hidden" id="idHistorial" name="id_historial" value="{{ $empresa->id }}">

        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <select id="modalAddressRegimen" name="regimen" class="select2 form-select" data-allow-clear="true">
                    {{-- La opción por defecto "Selecciona un Regímen" se seleccionará si el régimen de la empresa es nulo, vacío o 0 --}}
                    <option value="" {{ (isset($empresa) && ($empresa->regimen === null || $empresa->regimen === '' || $empresa->regimen == 0)) ? 'selected' : '' }}>Selecciona un Regímen</option>
                    {{-- Itera sobre los regímenes fiscales obtenidos de la base de datos --}}
                    @isset($regimenes)
                        @foreach($regimenes as $regimen)
                            {{-- Compara el valor del régimen de la empresa con el ID del régimen del catálogo --}}
                            {{-- Asume que $empresa->regimen guarda el ID del régimen. Si guarda el nombre, cambia $regimen->id por $regimen->regimen --}}
                            <option value="{{ $regimen->id }}" {{ (isset($empresa) && $empresa->regimen == $regimen->id && $empresa->regimen !== null && $empresa->regimen !== '') ? 'selected' : '' }}>
                                {{ $regimen->regimen }} {{-- Muestra el nombre del régimen --}}
                            </option>
                        @endforeach
                    @endisset
                </select>
                <label for="modalAddressRegimen">Regímen Fiscal *</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <select id="modalAddressCredito" name="credito" class="select2 form-select" data-allow-clear="true">
                    <option value="">Selecciona una Opción</option>
                    <option value="Con Crédito" {{ old('credito', $empresa->credito) == 'Con Crédito' ? 'selected' : '' }}>Con Crédito</option>
                    <option value="Sin Crédito" {{ old('credito', $empresa->credito) == 'Sin Crédito' ? 'selected' : '' }}>Sin Crédito</option>
                </select>
                <label for="modalAddressCredito">Crédito </label>
            </div>
            <div class="invalid-feedback"></div>
        </div>

        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressRazonSocial" name="nombre" class="form-control" placeholder=" " value="{{ old('nombre', $empresa->nombre) }}" />
                <label for="modalAddressRazonSocial">Razón Social (Nombre de la empresa) *</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressRFC" name="rfc" class="form-control" placeholder=" " value="{{ old('rfc', $empresa->rfc) }}" />
                <label for="modalAddressRFC">RFC </label>
            </div>
            <div class="invalid-feedback"></div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressEstado" name="estado" class="form-control" placeholder=" " value="{{ old('estado', $empresa->estado) }}" />
                <label for="modalAddressEstado">Estado</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressMunicipio" name="municipio" class="form-control" placeholder=" " value="{{ old('municipio', $empresa->municipio) }}" />
                <label for="modalAddressMunicipio">Ciudad o municipio</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressLocalidad" name="localidad" class="form-control" placeholder=" " value="{{ old('localidad', $empresa->localidad) }}" />
                <label for="modalAddressLocalidad">Localidad</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressCalle" name="calle" class="form-control" placeholder=" " value="{{ old('calle', $empresa->calle) }}" />
                <label for="modalAddressCalle">Calle</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressNo" name="no_exterior" class="form-control" placeholder=" # " value="{{ old('no_exterior', $empresa->noext) }}" />
                <label for="modalAddressNo">No</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressColonia" name="colonia" class="form-control" placeholder=" " value="{{ old('colonia', $empresa->colonia) }}" />
                <label for="modalAddressColonia">Colonia</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressCodigo" name="codigo_postal" class="form-control" placeholder=" " value="{{ old('codigo_postal', $empresa->codigo_postal) }}" />
                <label for="modalAddressCodigo">CP</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressTelefono" name="telefono" class="form-control" placeholder=" " value="{{ old('telefono', $empresa->telefono) }}" />
                <label for="modalAddressTelefono">Teléfono</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressCorreo" name="correo" class="form-control" placeholder=" " value="{{ old('correo', $empresa->correo) }}" />
                <label for="modalAddressCorreo">Correo</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="file" id="modalAddressConstancia" name="constancia" class="form-control" />
                <label for="modalAddressConstancia">Constancia de situación fiscal</label>
            </div>
            <div class="invalid-feedback"></div>
            @if ($empresa->constancia)
                <small class="text-muted">Archivo actual: <a href="{{ Storage::url($empresa->constancia) }}" target="_blank">{{ basename($empresa->constancia) }}</a></small>
            @endif
        </div>

        {{-- Sección de Contactos Dinámicos --}}
        <div class="col-12 mt-5">
            <h5 class="mb-3">Contactos Adicionales</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;" class="text-center"> {{-- Columna para el botón '+' --}}
                                <button type="button" class="btn btn-success btn-sm" id="add-contact-row-editar">
                                    <i class="ri-add-line"></i>
                                </button>
                            </th>
                            <th style="width: 20%;">Contacto</th> {{-- Ajustado ancho --}}
                            <th style="width: 20%;">Celular</th> {{-- Ajustado ancho --}}
                            <th style="width: 20%;">Correo</th> {{-- Ajustado ancho --}}
                            <th style="width: 15%;">Estatus</th> {{-- NUEVA COLUMNA --}}
                            <th style="width: 20%;">Observaciones</th> {{-- NUEVA COLUMNA --}}
                        </tr>
                    </thead>
                    <tbody id="contact-rows-container-editar">
                        {{-- Las filas de contacto se añadirán aquí dinámicamente por JS --}}
                        @forelse($empresa->clientesContactos as $contact)
                        <tr class="contact-row">
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-contact-row">
                                    <i class="ri-delete-bin-7-line"></i>
                                </button>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline mb-0">
                                    <input type="text" class="form-control" name="contactos[{{ $loop->index }}][contacto]" placeholder="Nombre del Contacto" value="{{ $contact->nombre_contacto }}" />
                                    <label>Contacto</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline mb-0">
                                    <input type="text" class="form-control" name="contactos[{{ $loop->index }}][celular]" placeholder="Celular" value="{{ $contact->telefono_contacto }}" />
                                    <label>Celular</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline mb-0">
                                    <input type="email" class="form-control" name="contactos[{{ $loop->index }}][correo]" placeholder="Correo Electrónico" value="{{ $contact->correo_contacto }}" />
                                    <label>Correo</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td> {{-- Columna para Estatus --}}
                                <div class="form-floating form-floating-outline mb-0">
                                    <select class="form-select form-select-sm contact-status-select" name="contactos[{{ $loop->index }}][status]">
                                        <option value="0" {{ old('status', $contact->status) == '0' ? 'selected' : '' }}>Sin contactar</option>
                                        <option value="1" {{ old('status', $contact->status) == '1' ? 'selected' : '' }}>Contactado</option>
                                    </select>
                                    <label>Estatus</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td> {{-- Columna para Observaciones --}}
                                <div class="form-floating form-floating-outline mb-0">
                                    <textarea class="form-control form-control-sm h-px-40" name="contactos[{{ $loop->index }}][observaciones]" placeholder="Observaciones">{{ old('observaciones', $contact->observaciones) }}</textarea>
                                    <label>Observaciones</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                        </tr>
                        @empty
                        {{-- Renderiza una fila vacía si no hay contactos para que los campos de estatus y observaciones estén siempre visibles --}}
                        <tr class="contact-row">
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-contact-row">
                                    <i class="ri-delete-bin-7-line"></i>
                                </button>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline mb-0">
                                    <input type="text" class="form-control" name="contactos[0][contacto]" placeholder="Nombre del Contacto" />
                                    <label>Contacto</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline mb-0">
                                    <input type="text" class="form-control" name="contactos[0][celular]" placeholder="Celular" />
                                    <label>Celular</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline mb-0">
                                    <input type="email" class="form-control" name="contactos[0][correo]" placeholder="Correo Electrónico" />
                                    <label>Correo</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td> {{-- Columna para Estatus --}}
                                <div class="form-floating form-floating-outline mb-0">
                                    <select class="form-select form-select-sm contact-status-select" name="contactos[0][status]">
                                        <option value="0">Sin contactar</option>
                                        <option value="1">Contactado</option>
                                    </select>
                                    <label>Estatus</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                            <td> {{-- Columna para Observaciones --}}
                                <div class="form-floating form-floating-outline mb-0">
                                    <textarea class="form-control form-control-sm h-px-40" name="contactos[0][observaciones]" placeholder="Observaciones"></textarea>
                                    <label>Observaciones</label>
                                </div>
                                <div class="invalid-feedback"></div>
                            </td>
                        </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Motivo por el cual se está editando --}}
        <div class="col-12 mt-4">
            <div class="form-floating form-floating-outline">
                <textarea class="form-control h-px-100" id="motivoEdicion" name="motivo_edicion" placeholder="Motivo de la edición"></textarea>
                <label for="motivoEdicion">Motivo por el cual se está editando *</label>
            </div>
            <div class="invalid-feedback"></div>
        </div>

        <div class="d-flex mt-6 justify-content-center">
            <button type="submit" form="editarhistorial" id="actualizar-empresa-btn" class="btn btn-primary me-sm-3 me-1 data-submit">
                <i class="ri-add-line"></i> Actualizar Empresa
            </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                <i class="ri-close-line"></i> Cancelar
            </button>
        </div>
    </form>
</div>

{{-- Template para una nueva fila de contacto (oculto) --}}
<template id="contact-row-template">
    <tr class="contact-row">
        <td class="text-center">
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
        <td>
            <div class="form-floating form-floating-outline mb-0">
                <select class="form-select form-select-sm contact-status-select" name="contactos[INDEX][status]">
                    <option value="0">Sin contactar</option>
                    <option value="1">Contactado</option>
                </select>
                <label>Estatus</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
        <td>
            <div class="form-floating form-floating-outline mb-0">
                <textarea class="form-control form-control-sm h-px-40" name="contactos[INDEX][observaciones]" placeholder="Observaciones"></textarea>
                <label>Observaciones</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
    </tr>
</template>
