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
    'resources/assets/vendor/libs/typeahead-js/typeahead.scss',
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
</script>


@endsection

@section('content')
<style>
/* -------------------------------------------
    Ajustes de la tabla
    ------------------------------------------- */

/* Estilos para el tamaño de letra del cuerpo de la tabla */
.table.table-sm tbody tr td {
    font-size: 0.85rem;
}

/* Estilos para las celdas de la tabla */
.table td, .table th {
    white-space: normal;
    overflow-wrap: break-word;
    word-break: break-word;
    font-size: 0.85rem;
}
</style>
    
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0 pb-1">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="mb-3"><b>Servicios Especializados del CIDAM</b></h3>
                        </div>
                    </div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="table-responsive p-3">
                    {{-- Botones que serán movidos por JavaScript --}}
                    <div id="botones_ocultos" style="display: none;">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarServicioModal" id="agregarServicioBtn">
                            <span class="d-none d-sm-inline-block">Agregar Servicio</span>
                        </a>
                        <button class="btn btn-secondary" id="exportarServiciosBtn" data-bs-toggle="modal" data-bs-target="#exportarServiciosModal">
                            <span class="d-none d-sm-inline-block">Exportar</span>
                        </button>
                    </div>
                    <table id="tablaServicios" class="table table-flush table-bordered tablaServicios_datatable table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>Clave</th>
                                <th>Servicios</th>
                                <th>Precio</th>
                                <th>Laboratorio (S)</th>
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
</div>


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

<div class="modal fade" id="viewServicioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="viewServicioModalContent">
            </div>
    </div>
</div>
@include('_partials._modals.modal-add-agregar_servicios_especializados')
@include('_partials._modals.modal-add-export_clientes_empresas')
@include('_partials._modals.modal-add-view-pdf')
@endsection