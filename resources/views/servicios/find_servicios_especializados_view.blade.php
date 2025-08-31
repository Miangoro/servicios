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

            // Aquí puedes agregar la lógica para enviar los datos a una ruta de Laravel
            // que se encargará de generar y descargar el archivo Excel
            console.log('Datos a exportar:', data);
    
            const exportModal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
            if (exportModal) {
                exportModal.hide();
            }
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
                        <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="ri-file-excel-2-line align-middle"></i>
                            Exportar
                        </button>
                        <a href="{{ route('servicios.create') }}" class="btn btn-success">
                            <i class="ri-add-line align-middle"></i>
                            Agregar Cliente
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
                        <tr>
                            <td>1</td>
                            <td>SAB</td>
                            <td>juan mezcal</td>
                            <td>100</td>
                            <td>Sabritas (100) - Clave: SAB</td>
                            <td>2</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>FITO</td>
                            <td>adrian</td>
                            <td>700</td>
                            <td>Fitopatología (200) - Clave: FITO, Laboratorio (500) - Clave: LAB</td>
                            <td>3 días</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>ABCD</td>
                            <td>juan mezcal</td>
                            <td>100</td>
                            <td>School (100) - Clave: ABCD</td>
                            <td>2</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>SAB</td>
                            <td>lola mezcal</td>
                            <td>100</td>
                            <td>Sabritas (100) - Clave: SAB</td>
                            <td>2</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>LAB</td>
                            <td>lola mezcal</td>
                            <td>100</td>
                            <td>Laboratorio (100) - Clave: LAB</td>
                            <td>2</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>ABCD</td>
                            <td>Andres mezcal</td>
                            <td>100</td>
                            <td>School (100) - Clave: ABCD</td>
                            <td>2</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>LUP</td>
                            <td>adrian</td>
                            <td>100</td>
                            <td>María Guadalupe (100) - Clave: LUP</td>
                            <td>dgdgdgdg</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>LAB</td>
                            <td>adrian</td>
                            <td>100</td>
                            <td>Laboratorio (100) - Clave: LAB</td>
                            <td>rdtfj</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>LAB</td>
                            <td>adrian</td>
                            <td>100</td>
                            <td>Laboratorio (100) - Clave: LAB</td>
                            <td>rdtfj</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>ABCD</td>
                            <td>Trina mezcal</td>
                            <td>50</td>
                            <td>School (50) - Clave: ABCD</td>
                            <td>2</td>
                            <td>1</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Visualizar</a></li>
                                        <li><a class="dropdown-item" href="#">Editar</a></li>
                                        <li><a class="dropdown-item" href="#">Deshabilitar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
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