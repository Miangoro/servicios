@extends('layouts/layoutMaster')

@section('title', 'Servicios Especializados')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/spinkit/spinkit.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/tagify/tagify.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/typeahead-js/typeahead.scss'
])
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
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
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/tagify/tagify.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/typeahead-js/typeahead.js',
    'resources/assets/vendor/libs/bloodhound/bloodhound.js'
])
@endsection

@section('page-script')
@vite([
    'resources/js/servicios_especializados.js',
    'resources/assets/js/forms-selects.js',
    'resources/assets/js/forms-tagify.js',
    'resources/assets/js/forms-typeahead.js'
])
<script>
    // Define la URL de la ruta para la tabla
    var dataTableAjaxUrl = "{{ route('servicios.index') }}";

    document.addEventListener('DOMContentLoaded', function() {
        const exportarBtn = document.getElementById('exportarBtn');
        const exportForm = document.getElementById('exportForm');
        
        // Listener para el formulario de exportación
        exportForm?.addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario por defecto
            
            const formData = new FormData(exportForm);
            const data = {};
            formData.forEach((value, key) => (data[key] = value));

            // Envía la solicitud al controlador para generar y descargar el Excel
            window.location.href = "{{ route('servicios.export-excel') }}?" + new URLSearchParams(data).toString();

            const exportModal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
            if (exportModal) {
                exportModal.hide();
            }
        });

        // Manejo del click en el botón de toggle status
        $(document).on('click', '.toggle-status-btn', function() {
            const idServicio = $(this).data('id');
            const newStatus = $(this).data('status');
            const token = $('meta[name="csrf-token"]').attr('content');
            const url = `/servicios/toggle-status/${idServicio}`;

            Swal.fire({
                title: "¿Estás seguro?",
                text: "El estado del servicio será modificado.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, modificar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            _token: token,
                            status: newStatus
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    '¡Actualizado!',
                                    response.message,
                                    'success'
                                );
                                // Recarga la tabla para reflejar el cambio
                                $('#tablaServicios').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    'Error',
                                    response.message,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error',
                                'No se pudo actualizar el estado del servicio.',
                                'error'
                            );
                            console.error("Error en la solicitud AJAX:", error);
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

@section('content')
<style>
/* -------------------------------------------
    Ajustes de la tabla para DataTables
    ------------------------------------------- */

/* Estilos para el tamaño de letra del cuerpo de la tabla */
.table.table-sm tbody tr td {
    font-size: 0.85rem;
}

/* Permitir que el texto de las celdas se envuelva */
.table td, .table th {
    white-space: normal;
    overflow-wrap: break-word;
    word-break: break-word;
}

/* Anchos mínimos para las columnas para evitar el desbordamiento inicial */
#tablaServicios th:nth-child(5) {
    min-width: 150px; /* Ancho mínimo para la columna de Laboratorios */
}

#tablaServicios th:nth-child(8) {
    min-width: 120px; /* Ancho mínimo para la columna de Acciones */
}

/* Estilos para el estado del servicio */
.estatus-label {
    display: inline-block;
    padding: 0.25em 0.5em;
    font-size: 0.75em;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    border-radius: 0.25rem;
    color: white;
}

.estatus-label.habilitado {
    background-color: #28a745; /* Verde para habilitado */
}

.estatus-label.deshabilitado {
    background-color: #dc3545; /* Rojo para deshabilitado */
}
</style>
    
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-header border-0 pb-1">
                <h3 class="mb-3"><b>Servicios Especializados del CIDAM</b></h3>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <label for="buscar" class="me-2">Buscar:</label>
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" class="form-control" id="buscar" placeholder="" aria-label="Buscar">
                        </div>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1 justify-content-end">
                        <select id="select-page-length" class="form-select me-2" style="width: auto;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <button type="button" class="btn btn-info waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="ri-file-excel-2-line align-middle"></i>
                            Exportar
                        </button>
                        <a href="{{ route('servicios.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="ri-add-line align-middle"></i>
                            Agregar Servicio
                        </a>
                    </div>
                </div>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="table-responsive p-3">
                <table id="tablaServicios" class="table table-flush table-bordered tablaServicios_datatable table-striped table-sm dt-responsive nowrap w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>NO</th>
                            <th>Clave</th>
                            <th>Servicios</th>
                            <th>Precio</th>
                            <th>Laboratorios</th>
                            <th>Duración</th>
                            <th>Estatus</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Los datos de la tabla se cargarán con DataTables --}}
                    </tbody>
                </table>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="..."></nav>
            </div>
        </div>
    </div>
</div>

{{-- Modal para edición --}}
<div class="modal fade" id="editServicioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content" id="editServicioModalContent">
            <div class="modal-body text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2">Cargando formulario de edición...</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal para visualización --}}
<div class="modal fade" id="viewServicioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="viewServicioModalContent">
            </div>
    </div>
</div>

@include('_partials/_modals/modal-add-export_servcios_Especializados')
@endsection