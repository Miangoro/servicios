<!-- resources/views/_partials/_modals/modal-add-visualizar-Historial.blade.php -->
@php use Illuminate\Support\Facades\Storage; @endphp

<!-- El contenido de esta vista se cargará dinámicamente dentro de la modal principal -->

<div class="modal-header bg-primary pb-4">
    <h4 class="modal-title text-white" id="viewEmpresaModalLabel">Visualizar Empresa: {{ $empresa->nombre ?? 'Cargando...' }}</h4>
    <button type="button" class="btn-close btn-close-red" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form id="visualizarhistorialForm" class="row g-5">
        <input type="hidden" id="idHistorialView" name="id_historial_view" value="{{ $empresa->id }}">

        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <select id="modalAddressRegimenView" name="regimen_view" class="select2 form-select" data-allow-clear="true" disabled>
                    <option value="">Selecciona un Regímen</option>
                    @isset($regimenes)
                        @foreach($regimenes as $regimen)
                            <option value="{{ $regimen->id }}" {{ (isset($empresa) && $empresa->regimen == $regimen->id) ? 'selected' : '' }}>
                                {{ $regimen->regimen }}
                            </option>
                        @endforeach
                    @endisset
                </select>
                <label for="modalAddressRegimenView">Regímen Fiscal</label>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <select id="modalAddressCreditoView" name="credito_view" class="select2 form-select" data-allow-clear="true" disabled>
                    <option value="">Selecciona una Opción</option>
                    <option value="Con Crédito" {{ strtolower($empresa->credito) == 'con crédito' ? 'selected' : '' }}>Con Crédito</option>
                    <option value="Sin Crédito" {{ strtolower($empresa->credito) == 'sin crédito' || $empresa->credito == '0' ? 'selected' : '' }}>Sin Crédito</option>
                </select>
                <label for="modalAddressCreditoView">Crédito</label>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressRazonSocialView" name="nombre_view" class="form-control" value="{{ old('nombre', $empresa->nombre) }}" disabled />
                <label for="modalAddressRazonSocialView">Razón Social (Nombre de la empresa)</label>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressRFCView" name="rfc_view" class="form-control" value="{{ old('rfc', $empresa->rfc) }}" disabled />
                <label for="modalAddressRFCView">RFC</label>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressEstadoView" name="estado_view" class="form-control" value="{{ old('estado', $empresa->estado) }}" disabled />
                <label for="modalAddressEstadoView">Estado</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressMunicipioView" name="municipio_view" class="form-control" value="{{ old('municipio', $empresa->municipio) }}" disabled />
                <label for="modalAddressMunicipioView">Ciudad o municipio</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressLocalidadView" name="localidad_view" class="form-control" value="{{ old('localidad', $empresa->localidad) }}" disabled />
                <label for="modalAddressLocalidadView">Localidad</label>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressCalleView" name="calle_view" class="form-control" value="{{ old('calle', $empresa->calle) }}" disabled />
                <label for="modalAddressCalleView">Calle</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressNoView" name="no_exterior_view" class="form-control" value="{{ old('no_exterior', $empresa->noext) }}" disabled />
                <label for="modalAddressNoView">No</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressColoniaView" name="colonia_view" class="form-control" value="{{ old('colonia', $empresa->colonia) }}" disabled />
                <label for="modalAddressColoniaView">Colonia</label>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressCodigoView" name="codigo_postal_view" class="form-control" value="{{ old('codigo_postal', $empresa->codigo_postal) }}" disabled />
                <label for="modalAddressCodigoView">CP</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressTelefonoView" name="telefono_view" class="form-control" value="{{ old('telefono', $empresa->telefono) }}" disabled />
                <label for="modalAddressTelefonoView">Teléfono</label>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressCorreoView" name="correo_view" class="form-control" value="{{ old('correo', $empresa->correo) }}" disabled />
                <label for="modalAddressCorreoView">Correo</label>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <label for="constanciaView" class="form-label">Constancia de Situación Fiscal (PDF)</label>
            @if ($empresa->constancia)
                <p><a href="{{ Storage::url($empresa->constancia) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ri-file-pdf-line me-1"></i> Ver Constancia Actual</a></p>
            @else
                <p class="text-muted">No hay constancia cargada.</p>
            @endif
        </div>

        <div class="col-12 mt-5">
            <h5 class="mb-3">Contactos Adicionales</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;" class="text-center">#</th>
                            <th style="width: 25%;">Contacto</th>
                            <th style="width: 25%;">Celular</th>
                            <th style="width: 25%;">Correo</th>
                            <th style="width: 10%;">Estatus</th>
                            <th style="width: 10%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody id="contact-rows-container-view">
                        @if($empresa->clientesContactos->count() > 0)
                            @foreach($empresa->clientesContactos as $index => $contact)
                                <tr class="contact-row-view">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="form-floating form-floating-outline mb-0">
                                            <input type="text" class="form-control" value="{{ $contact->nombre_contacto }}" disabled />
                                            <label>Contacto</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-floating form-floating-outline mb-0">
                                            <input type="text" class="form-control" value="{{ $contact->telefono_contacto }}" disabled />
                                            <label>Celular</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-floating form-floating-outline mb-0">
                                            <input type="email" class="form-control" value="{{ $contact->correo_contacto }}" disabled />
                                            <label>Correo</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-floating form-floating-outline mb-0">
                                            <select class="form-select form-select-sm" disabled>
                                                <option value="0" {{ $contact->status == '0' ? 'selected' : '' }}>Sin contactar</option>
                                                <option value="1" {{ $contact->status == '1' ? 'selected' : '' }}>Contactado</option>
                                            </select>
                                            <label>Estatus</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-floating form-floating-outline mb-0">
                                            <textarea class="form-control form-control-sm h-px-40" disabled>{{ $contact->observaciones }}</textarea>
                                            <label>Observaciones</label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="6" class="text-center">No hay contactos registrados.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex mt-6 justify-content-center">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </form>
</div>

<style>
    .btn-close-red {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23dc3545'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") !important;
        opacity: 1 !important;
    }
    .btn-close-red:hover {
        opacity: 0.75 !important;
    }
</style>
