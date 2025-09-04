@extends('layouts.layoutMaster')

@section('title', 'Registrar nueva cotización de servicios')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss'
])
<style>
    :root {
      --primary-color: #28a745;
      --secondary-color: #6c757d;
      --success-color: #28a745;
      --light-bg: #f8f9fa;
    }

    body {
      background-color: #f5f6f8;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 20px;
      padding-bottom: 40px;
    }

    .card {
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border: none;
      margin-bottom: 40px;
    }

    .card-header {
      background-color: var(--primary-color);
      color: white;
      border-radius: 10px 10px 0 0 !important;
      padding: 16px 24px;
      font-weight: 600;
    }

    .card-body {
      padding: 24px;
    }

    .form-label {
      font-weight: 600;
      color: #343a40;
      margin-bottom: 8px;
    }

    .input-group {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      position: relative;
    }

    .input-group-text.square {
      background-color: var(--success-color);
      color: white;
      border: none;
      width: 45px;
      height: 45px;
      justify-content: center;
      display: flex;
      align-items: center;
      position: absolute;
      left: 0;
      top: 0;
      z-index: 2;
      border-radius: 6px 0 0 6px;
    }

    .form-select, .select2-container .select2-selection--single {
      border: 1px solid #ced4da;
      padding-left: 55px;
      height: 45px;
      cursor: pointer;
      border-radius: 6px;
    }

    .form-select:focus, .select2-selection:focus {
      box-shadow: 0 0 0 0.25rem rgba(59, 125, 221, 0.25);
      border-color: #86b7fe;
    }

    .btn-success {
      background-color: var(--success-color);
      border: none;
      padding: 10px 24px;
      font-weight: 600;
      border-radius: 6px;
    }

    .btn-danger {
      background-color: #dc3545;
      border: none;
      padding: 10px 24px;
      font-weight: 600;
      border-radius: 6px;
    }

    .btn-group-custom {
      margin-top: 32px;
      margin-bottom: 16px;
    }

    .section-title {
      font-size: 1.25rem;
      color: var(--primary-color);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--light-bg);
    }

    .required-field::after {
      content: " *";
      color: #dc3545;
    }

    .text-center.mb-4 {
      margin-bottom: 2rem;
    }

    .form-text {
      font-size: 0.875rem;
      color: var(--secondary-color);
      margin-top: 0.25rem;
    }

    /* Adjustments for Select2 with the new design */
    .select2-container .select2-selection--single {
      border: 1px solid #ced4da;
      padding-left: 55px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 25px;
      padding-left: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 43px;
    }

    @media (max-width: 768px) {
      .card-body {
        padding: 16px;
      }

      .btn-group-custom {
        flex-direction: column;
        gap: 12px;
      }

      .btn-group-custom .btn {
        width: 100%;
      }
    }
</style>
@endsection

@section('vendor-script')
@vite([
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js'
])
@endsection

@section('page-script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa los selects con búsqueda (Select2)
        $('.selectpicker').select2({
            minimumResultsForSearch: 3,
            width: '100%',
            templateResult: function(data) {
                // Para truncar el texto largo en las opciones
                if (!data.id) return data.text;
                var $result = $('<span class="truncate-text">' + data.text + '</span>');
                return $result;
            }
        });

        // Agrega tooltips para opciones largas
        $(document).on('mouseenter', '.select2-selection__rendered', function(e) {
            if (this.offsetWidth < this.scrollWidth) {
                $(this).attr('title', $(this).text());
            } else {
                $(this).removeAttr('title');
            }
        });

        // Agrega estilos a los selects
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.addEventListener('focus', function() {
                this.style.backgroundColor = 'var(--light-bg)';
            });

            select.addEventListener('blur', function() {
                this.style.backgroundColor = '';
            });
        });

        document.getElementById('add-contact-row-agregar').addEventListener('click', function() {
            const template = document.getElementById('contact-row-template');
            const newRow = template.content.cloneNode(true);
            const container = document.getElementById('contact-rows-container-agregar');
            const index = container.children.length;

            // Actualiza los nombres de los campos con el índice correcto
            const inputs = newRow.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace('INDEX', index);
                }
            });

            container.appendChild(newRow);
        });

        document.getElementById('contact-rows-container-agregar').addEventListener('click', function(e) {
            if (e.target.closest('.remove-contact-row')) {
                e.target.closest('.contact-row').remove();
            }
        });

        // CÓDIGO MODIFICADO PARA CARGAR Y SELECCIONAR EL PRIMER CONTACTO
        $('#empresa').on('select2:select', function (e) {
            const empresaId = e.params.data.id;
            const contactoSelect = $('#contacto');

            // Limpia el select de contacto y muestra un mensaje de carga
            contactoSelect.empty().append($('<option></option>').val('').text('Cargando...'));
            contactoSelect.prop('disabled', true); // Deshabilita el select durante la carga

            // Si se selecciona "PÚBLICO EN GENERAL", no se buscarán contactos
            if (empresaId === 'publico_general') {
                contactoSelect.empty().append($('<option></option>').val('').text('Seleccione una empresa o complete los datos manualmente.'));
                contactoSelect.prop('disabled', false); // Habilita el select
                contactoSelect.trigger('change');
                return;
            }

            // Realiza la petición AJAX al servidor para obtener los contactos
            fetch(`/cotizaciones/get-contactos/${empresaId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al cargar contactos');
                    }
                    return response.json();
                })
                .then(data => {
                    // Limpia el select de contacto de nuevo
                    contactoSelect.empty();

                    if (data.length > 0) {
                        // Agrega una opción por cada contacto recibido
                        data.forEach((contacto, index) => {
                            const optionText = `${contacto.nombre_contacto} - ${contacto.correo_contacto}`;
                            // Establece el primer contacto como seleccionado
                            const isFirst = index === 0;
                            const newOption = new Option(optionText, contacto.id, isFirst, isFirst);
                            contactoSelect.append(newOption);
                        });
                        
                        // Si hay datos, Select2 debería seleccionar el primero automáticamente.
                        // Forzamos el cambio para asegurarnos de que se muestre en la interfaz.
                        contactoSelect.trigger('change');

                    } else {
                        contactoSelect.append($('<option></option>').val('').text('No se encontraron contactos para esta empresa'));
                        contactoSelect.trigger('change');
                    }
                    contactoSelect.prop('disabled', false); // Habilita el select al terminar la carga
                })
                .catch(error => {
                    console.error('Error:', error);
                    contactoSelect.empty().append($('<option></option>').val('').text('Error al cargar contactos'));
                    contactoSelect.prop('disabled', false); // Habilita el select
                    contactoSelect.trigger('change');
                });
        });
    });
</script>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color: var(--primary-color);">Registrar nueva cotización de servicios</h2>
                <p class="text-muted">Complete la información requerida para generar una nueva cotización</p>
            </div>

            <form action="{{ route('cotizaciones.store') }}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Información del cliente
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <label for="empresa" class="form-label required-field">Seleccionar empresa</label>
                                <div class="input-group">
                                    <button type="button" class="input-group-text square border-0" data-bs-toggle="modal" data-bs-target="#agregarEmpresa">
                                        <i class="ri-add-box-line"></i>
                                    </button>
                                    <select class="form-select selectpicker" data-live-search="true" id="empresa" name="empresa" required title="Seleccione una empresa">
                                        <option value="publico_general" selected>PUBLICO EN GENERAL</option>
                                        @isset($empresas)
                                            @foreach($empresas as $empresa)
                                                <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="contacto" class="form-label required-field">Seleccionar contacto</label>
                                <div class="input-group">
                                    <span class="input-group-text square"><i class="ri-user-line"></i></span>
                                    <select class="form-select selectpicker" data-live-search="true" id="contacto" name="contacto" required title="Seleccione un contacto">
                                        <option value="" selected>Seleccione una empresa primero</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Lista de servicios
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-5">
                                <label for="servicios_catalogo" class="form-label">Seleccionar servicios de catálogo</label>
                                <select class="form-select" id="servicios_catalogo" name="servicios_catalogo">
                                    <option value="">Selecciona una opción</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-5">
                                <label for="servicios_especializados" class="form-label">Seleccionar servicios especializados</label>
                                <select class="form-select" id="servicios_especializados" name="servicios_especializados">
                                    <option value="">Selecciona una opción</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-3 mb-4">
                                <label for="costo_envio" class="form-label">¿Costo de envío o viáticos?</label>
                                <select class="form-select" id="costo_envio" name="costo_envio">
                                    <option value="no_aplica" selected>No aplica</option>
                                    <option value="si_aplica">Sí aplica</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-4">
                                <label for="convenio" class="form-label">Convenio/proyecto</label>
                                <select class="form-select" id="convenio" name="convenio">
                                    <option value="no_aplica" selected>No aplica</option>
                                    <option value="convenio1">Convenio 2023-001</option>
                                    <option value="convenio2">Proyecto Alpha</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-4">
                                <label for="pago_efectivo" class="form-label">¿Pago en efectivo?</label>
                                <select class="form-select" id="pago_efectivo" name="pago_efectivo">
                                    <option value="no" selected>No</o>
                                    <option value="si">Sí</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-4">
                                <label for="necesita_factura" class="form-label required-field">¿Necesita factura?</label>
                                <select class="form-select" id="necesita_factura" name="necesita_factura" required>
                                    <option value="" selected>Seleccione una opción</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center btn-group-custom">
                    <button type="submit" class="add-new btn btn-primary waves-effect waves-light me-3">
                        <i class="ri-arrow-right-circle-line me-2"></i>Siguiente
                    </button>
                    <a href="#" class="btn btn-danger">
                        <i class="ri-close-circle-line me-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="agregarEmpresa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h4 class="modal-title text-white" id="agregarEmpresaLabel">Registrar Nueva Empresa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarContacto" class="row g-5" action="{{ route('empresas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 col-md-6">
                        <div class="form-floating form-floating-outline">
                            <select id="modalAddressRegimen" name="regimen" class="select2 form-select" data-allow-clear="true">
                                <option value="">Selecciona un Regímen</option>
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

                    <div class="col-12 mt-5">
                        <h5 class="mb-3">Contactos Adicionales</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;" class="text-center">
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
        <td class="d-none">
            <div class="form-floating form-floating-outline mb-0">
                <select class="form-select form-control-sm" name="contactos[INDEX][status]">
                    <option value="0">Sin contactar</option>
                    <option value="1">Contactado</option>
                </select>
                <label>Estatus</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
        <td class="d-none">
            <div class="form-floating form-floating-outline mb-0">
                <textarea class="form-control form-control-sm h-px-40" name="contactos[INDEX][observaciones]" placeholder="Observaciones"></textarea>
                <label>Observaciones</label>
            </div>
            <div class="invalid-feedback"></div>
        </td>
    </tr>
</template>
@endsection
