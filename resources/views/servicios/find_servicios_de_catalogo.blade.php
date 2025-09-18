@extends('layouts/layoutMaster')

@section('title', 'Servicios de catálogo')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/spinkit/spinkit.scss',
        'resources/assets/vendor/libs/tagify/tagify.scss',
        'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
        'resources/assets/vendor/libs/typeahead-js/typeahead.scss'
    ])
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/tagify/tagify.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/typeahead-js/typeahead.js',
    'resources/assets/vendor/libs/bloodhound/bloodhound.js'
    ])
@endsection

@section('page-script')
@vite(['resources/js/serviciosCatalogo.js',
    'resources/assets/js/forms-selects.js',
    'resources/assets/js/forms-tagify.js',
    'resources/assets/js/forms-typeahead.js'
])

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
#tablaServiciosCatalogo th:nth-child(2) {
    min-width: 150px; /* Ancho mínimo para la columna de Clave */
}

#tablaServiciosCatalogo th:nth-child(5) {
    min-width: 150px; /* Ancho mínimo para la columna de Laboratorio */
}

#tablaServiciosCatalogo th:nth-child(8) {
    min-width: 120px; /* Ancho mínimo para la columna de Estatus */
}

#tablaServiciosCatalogo th:nth-child(9) {
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
                <h3 class="mb-3"><b>Servicios de Catálogo del CIDAM</b></h3>
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
                        <button type="button" class="btn btn-info waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#exportModalCatalogo">
                            <i class="ri-file-excel-2-line align-middle"></i>
                            Exportar
                        </button>
                        <a href="{{ route('serviciosCatalogo.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="ri-add-line align-middle"></i>
                            Agregar Servicio
                        </a>
                    </div>
                </div>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="table-responsive p-3">
                <table id="tablaServiciosCatalogo" class="table table-flush table-bordered tablaServiciosCatalogo_datatable table-striped table-sm dt-responsive nowrap w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>NO</th>
                            <th>Clave</th>
                            <th>Servicios</th>
                            <th>Precio</th>
                            <th>Laboratorio</th>
                            <th>Método</th>
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
<div class="modal fade" id="editServicioCatalogoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content" id="editServicioCatalogoModalContent">
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
<div class="modal fade" id="viewServicioCatalogoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="viewServicioCatalogoModalContent">
            </div>
    </div>
</div>


@endsection