@extends('layouts.layoutMaster')

@section('title', 'Solicitudes')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/pickr/pickr-themes.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])

@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'resources/assets/vendor/libs/cleavejs/cleave.js',
        'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
        'resources/assets/vendor/libs/flatpickr/flatpickr.js',
        'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
        'resources/assets/vendor/libs/pickr/pickr.js',
        'resources/assets/vendor/libs/flatpickr/l10n/es.js', // Archivo local del idioma
    ])
@endsection



@section('page-script')
    @vite(['resources/js/solicitudes.js'])
    @vite(['resources/js/solicitudes-tipo.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const certificacionSelectAdd = document.getElementById('certificacion');
            const certificadoOtrosDivAdd = document.getElementById('certificado-otros');
            const tipoSelectAdd = document.getElementById('tipo');
            const modalAddInstalacion = document.getElementById('modalAddInstalacion');

            const certificacionSelectEdit = document.getElementById('edit_certificacion');
            const certificadoOtrosDivEdit = document.getElementById('edit_certificado_otros');
            const tipoSelectEdit = document.getElementById('edit_tipo');
            const modalEditInstalacion = document.getElementById('modalEditInstalacion');

            function toggleCertificadoOtros(selectElement, divElement) {
                if (selectElement.value === 'otro_organismo') {
                    divElement.classList.remove('d-none');
                } else {
                    divElement.classList.add('d-none');
                }
            }

            function updateDocumentFields(tipoSelect, divElement) {
                const hiddenIdDocumento = divElement.querySelector('input[name="id_documento[]"]');
                const hiddenNombreDocumento = divElement.querySelector('input[name="nombre_documento[]"]');
                const fileCertificado = divElement.querySelector('input[type="file"]');

                switch (tipoSelect.value) {
                    case 'productora':
                        hiddenIdDocumento.value = '127';
                        hiddenNombreDocumento.value = 'Certificado de instalaciones';
                        fileCertificado.setAttribute('id', 'file-127');
                        break;
                    case 'envasadora':
                        hiddenIdDocumento.value = '128';
                        hiddenNombreDocumento.value = 'Certificado de envasadora';
                        fileCertificado.setAttribute('id', 'file-128');
                        break;
                    case 'comercializadora':
                        hiddenIdDocumento.value = '129';
                        hiddenNombreDocumento.value = 'Certificado de comercializadora';
                        fileCertificado.setAttribute('id', 'file-129');
                        break;
                    default:
                        hiddenIdDocumento.value = '';
                        hiddenNombreDocumento.value = '';
                        fileCertificado.removeAttribute('id');
                        break;
                }
            }

            function setupEventListeners() {
                // Add modal event listeners
                certificacionSelectAdd.addEventListener('change', function() {
                    toggleCertificadoOtros(certificacionSelectAdd, certificadoOtrosDivAdd);
                });

                tipoSelectAdd.addEventListener('change', function() {
                    updateDocumentFields(tipoSelectAdd, certificadoOtrosDivAdd);
                });

                modalAddInstalacion.addEventListener('shown.bs.modal', function() {
                    certificacionSelectAdd.value = '';
                    $(certificacionSelectAdd).trigger('change');
                    tipoSelectAdd.value = '';
                    $(tipoSelectAdd).trigger('change');
                    certificadoOtrosDivAdd.classList.add('d-none');
                });

                modalAddInstalacion.addEventListener('hidden.bs.modal', function() {
                    certificacionSelectAdd.value = '';
                    $(certificacionSelectAdd).trigger('change');
                    tipoSelectAdd.value = '';
                    $(tipoSelectAdd).trigger('change');
                    certificadoOtrosDivAdd.classList.add('d-none');
                });

                // Edit modal event listeners
                if (certificacionSelectEdit) {
                    certificacionSelectEdit.addEventListener('change', function() {
                        toggleCertificadoOtros(certificacionSelectEdit, certificadoOtrosDivEdit);
                    });
                }

                if (tipoSelectEdit && certificadoOtrosDivEdit) {
                    tipoSelectEdit.addEventListener('change', function() {
                        updateDocumentFields(tipoSelectEdit, certificadoOtrosDivEdit);
                    });
                }
                if (modalEditInstalacion) {
                    modalEditInstalacion.addEventListener('shown.bs.modal', function() {
                        if (certificacionSelectEdit) {
                            certificacionSelectEdit.value = '';
                            $(certificacionSelectEdit).trigger('change');
                        }
                        if (tipoSelectEdit) {
                            tipoSelectEdit.value = '';
                            $(tipoSelectEdit).trigger('change');
                        }
                        if (certificadoOtrosDivEdit) {
                            certificadoOtrosDivEdit.classList.add('d-none');
                        }
                    });
                }
                if (modalEditInstalacion) {
                    modalEditInstalacion.addEventListener('hidden.bs.modal', function() {
                        if (certificacionSelectEdit) {
                            certificacionSelectEdit.value = '';
                            $(certificacionSelectEdit).trigger('change');
                        }
                        if (tipoSelectEdit) {
                            tipoSelectEdit.value = '';
                            $(tipoSelectEdit).trigger('change');
                        }
                        if (certificadoOtrosDivEdit) {
                            certificadoOtrosDivEdit.classList.add('d-none');
                        }
                    });
                }

            }

            setupEventListeners();
        });

          window.puedeAgregarSolicitud = @json(auth()->user()->can('Registrar solicitudes'));
          window.puedeEditarSolicitud= @json(auth()->user()->can('Editar solicitudes'));
          window.puedeEliminarSolicitud = @json(auth()->user()->can('Eliminar solicitudes'));
          window.puedeValidarSolicitud = @json(auth()->user()->can('Validar solicitudes'));
          window.puedeExportarSolicitud = @json(auth()->user()->can('Exportar solicitudes'));
    </script>


    <style>
        .text-primary {
            color: #262b43 !important;
        }
    </style>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="mb-0 fw-bold">Solicitudes de servicios</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table style="font-size: 14px" class="datatables-solicitudes table table-bordered  table-hover">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>Folio</th>
                        <th>No. de servicio</th>
                        <th>Cliente</th>
                        <th>Fecha de solicitud</th>
                        <th>Solicitud</th>
                        <th>Domicilio de inspección</th>
                        <th>Fecha y hora de visita estimada</th>
                        <th>Inspector asignado</th>
                        <th>Características</th>
                        <th>Fecha y hora de inspección</th>
                        <th>Formato de solicitud</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>





        <!-- Modal -->
        @include('_partials._modals.modal-pdfs-frames')
        @include('_partials._modals.modal-solicitudes')
        @include('_partials._modals.modal-expediente-servicio')
        @include('_partials._modals.modal-trazabilidad')
        @include('_partials._modals.modal-validad-solicitud')
        @include('_partials._modals.modal-add-solicitud-dictamen-instalaciones')
        @include('_partials._modals.modal-add-solicitud-vigilancia-en-produccion')
        @include('_partials._modals.modal-add-solicitud-vigilancia-traslado-lote')
        @include('_partials._modals.modal-add-solicitud-muestreo-lote-agranel')
        @include('_partials._modals.modal-add-solicitud-inspeccion-de-envasado')
        @include('_partials._modals.modal-add-solicitud-muestreo-lote-envasado')
        @include('_partials._modals.modal-add-solicitud-inspeccion-ingreso-barricada')
        @include('_partials._modals.modal-add-solicitud-liberacion-producto-terminado')
        @include('_partials._modals.modal-add-solicitud-inspeccion-de-liberacion')
        @include('_partials._modals.modal-add-solicitud-pedidos-para-exportacion')
        @include('_partials._modals.modal-add-solicitud-emision-certificado-venta-nacional')
        @include('_partials._modals.modal-add-solicitud-inspeccion-emision-certificado-NOM')
        @include('_partials._modals.modal-add-solicitud-georeferenciacion')
        @include('_partials._modals.modal-add-solicitud-muestreo-agave')



        @include('_partials._modals.modal-export-excel')

        @include('_partials._modals.modal-add-instalaciones')
        @include('_partials._modals.modal-edit-solicitudes-georeferenciacion')
        @include('_partials._modals.modal-edit-solicitud-dictamen-instalaciones')
        @include('_partials._modals.modal-edit-solicitud-vigilancia-produccion')
        @include('_partials._modals.modal-edit-solicitud-muestreo-lote-agranel')
        @include('_partials._modals.modal-edit-solicitud-vigilancia-traslado-lote')
        @include('_partials._modals.modal-edit-solicitud-inspeccion-ingreso-barricada')
        @include('_partials._modals.modal-edit-solicitud-inspeccion-de-liberacion')
        @include('_partials._modals.modal-edit-solicitud-inspeccion-de-envasado')
        @include('_partials._modals.modal-edit-solicitud-pedidos-para-exportacion')
        @include('_partials._modals.modal-edit-solicitud-muestreo-agave')
        @include('_partials._modals.modal-edit-solicitud-liberación-producto-terminado')
        @include('_partials._modals.modal-edit-solicitud-emision-certificado-venta-nacional')


        <!-- /Modal -->

    </div>
@endsection

<script>
    function abrirModal(id_solicitud, tipo, nombre_empresa) {

        /* $.ajax({
             url: '/lista_empresas/' + id_empresa,
             method: 'GET',
             success: function(response) {
                 // Cargar los detalles en el modal
                 var contenido = "";

               for (let index = 0; index < response.normas.length; index++) {
                 contenido = '<input value="'+response.normas[index].id_norma+'" type="hidden" name="id_norma[]"/><div class="col-12 col-md-12 col-sm-12"><div class="form-floating form-floating-outline"><input type="text" id="numero_cliente'+response.normas[index].id_norma+'" name="numero_cliente[]" class="form-control" placeholder="Introducir el número de cliente" /><label for="modalAddressFirstName">Número de cliente para la norma '+response.normas[index].norma+'</label></div></div><br>' + contenido;
                 console.log(response.normas[index].norma);
               }

                 $('#expedienteServicio').modal('show');
             },
             error: function() {
                 alert('Error al cargar los detalles de la empresa.');
             }
         });*/
        $('.solicitud').text(tipo);
        $('.nombre_empresa').text(nombre_empresa);
        $('#expedienteServicio').modal('show');

    }

    function abrirModalValidarSolicitud(id_solicitud, tipo, nombre_empresa) {

        /* $.ajax({
             url: '/lista_empresas/' + id_empresa,
             method: 'GET',
             success: function(response) {
                 // Cargar los detalles en el modal
                 var contenido = "";

               for (let index = 0; index < response.normas.length; index++) {
                 contenido = '<input value="'+response.normas[index].id_norma+'" type="hidden" name="id_norma[]"/><div class="col-12 col-md-12 col-sm-12"><div class="form-floating form-floating-outline"><input type="text" id="numero_cliente'+response.normas[index].id_norma+'" name="numero_cliente[]" class="form-control" placeholder="Introducir el número de cliente" /><label for="modalAddressFirstName">Número de cliente para la norma '+response.normas[index].norma+'</label></div></div><br>' + contenido;
                 console.log(response.normas[index].norma);
               }

                 $('#expedienteServicio').modal('show');
             },
             error: function() {
                 alert('Error al cargar los detalles de la empresa.');
             }
         });*/
        $('.solicitud').text(tipo);
        $('.nombre_empresa').text(nombre_empresa);
        $('#addSolicitudValidar').modal('show');

    }

    function abrirModalTrazabilidad(id_solicitud, tipo, nombre_empresa) {
        // Asignar valores en el modal
        $("#id_solicitud").val(id_solicitud);
        $('.solicitud').text(tipo);

        // Construir la URL para la solicitud AJAX
        var url = baseUrl + 'trazabilidad/' + id_solicitud;

        // Hacer la solicitud AJAX para obtener los logs
        $.get(url, function(data) {
            if (data.success) {
                // Recibir los logs y mostrarlos en el modal
                var logs = data.logs;
                var logsContainer = $('#logsContainer');
                logsContainer.empty(); // Limpiar el contenedor de logs

                // Iterar sobre los logs y agregarlos al contenedor
                logs.forEach(function(log) {
                    logsContainer.append(`

                <li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header mb-3">
                        <h6 class="mb-0">${log.description}</h6>
                        <small class="text-muted">${log.created_at}</small>
                        </div>
                        <p class="mb-2">  ${log.contenido}</p>
                        <div class="d-flex align-items-center mb-1">

                        </div>
                    </div>
                    </li><hr>
                `);
                });

                // Mostrar el modal
                $('#trazabilidad').modal('show');
            }
        }).fail(function(xhr) {
            console.error(xhr.responseText);
        });
    }


    function abrirModalSubirResultados(id_solicitud) {

        $("#id_solicitud").val(id_solicitud);
        $('#subirResultados').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Función para obtener parámetros de la URL
        function getParameterByName(name) {
            const url = window.location.href;
            const regex = new RegExp(`[?&]${name}(=([^&#]*)|&|#|$)`);
            const results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Verificar si el modal debe abrirse
        const modalToOpen = getParameterByName('abrirModal');
        if (modalToOpen === 'nuevaSolicitud') {
            $('#verSolicitudes').modal('show'); // Abrir modal
        }
    });
</script>
