@extends('layouts/layoutMaster')

@section('title', 'ClientesEmpresas')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    //'resources/assets/vendor/libs/form-validation/form-validation.scss',
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
    'resources/assets/js/forms-selects.js',
    'resources/assets/js/forms-tagify.js',
    'resources/assets/js/forms-typeahead.js'
])
<script>
    // Define variables JavaScript con las URLs de las rutas
    var dataTableAjaxUrl = "{{ route('clientes.empresas.index') }}";
    var dataTableInactivosAjaxUrl = "{{ route('clientes.empresas.inactivos') }}";
    var estadisticasClientesUrl = "{{ route('clientes.empresas.estadisticas') }}";
    var darBajaUrl = "{{ route('clientes.empresas.darBaja', ':id') }}";
    var darAltaUrl = "{{ route('clientes.empresas.darAlta', ':id') }}";

    /**
     * Función para cargar las estadísticas de clientes
     */
    function cargarEstadisticasClientes() {
        $('.stats-card-loading').show();
        
        $.ajax({
            url: estadisticasClientesUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    animateCounter('#clientesActivosCount', response.clientesActivos);
                    animateCounter('#personasFisicasCount', response.personasFisicas);
                    animateCounter('#otrosRegimenesCount', response.otrosRegimenes);
                    animateCounter('#clientesInactivosCount', response.clientesInactivos);
                    
                    // Animar el contador total
                    const total = response.total;
                    animateCounter('#totalEmpresasCount', total);
                } else {
                    console.error('Error en la respuesta:', response.message);
                    mostrarValoresPorDefecto();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar estadísticas:', error);
                mostrarValoresPorDefecto();
            },
            complete: function() {
                $('.stats-card-loading').hide();
            }
        });
    }

    /**
     * Función para animar el conteo de números
     */
    function animateCounter(selector, targetValue) {
        const element = $(selector);
        const startValue = 0;
        const duration = 1000;
        const increment = targetValue / (duration / 16);
        let currentValue = startValue;

        const timer = setInterval(function() {
            currentValue += increment;
            if (currentValue >= targetValue) {
                currentValue = targetValue;
                clearInterval(timer);
            }
            element.text(Math.floor(currentValue));
        }, 16);
    }

    /**
     * Función para mostrar valores por defecto en caso de error
     */
    function mostrarValoresPorDefecto() {
        $('#clientesActivosCount').text('0');
        $('#personasFisicasCount').text('0');
        $('#otrosRegimenesCount').text('0');
        $('#clientesInactivosCount').text('0');
        $('#totalEmpresasCount').text('0');
    }

    /**
     * Función para manejar la baja de un cliente.
     */
    function darDeBajaUnidad(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡El cliente será marcado como inactivo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, dar de baja',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: darBajaUrl.replace(':id', id),
                    type: 'PUT',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Dado de baja!',
                            text: 'El cliente ha sido marcado como inactivo.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        // Recargar todas las tablas y las estadísticas
                        $('#tablaHistorial').DataTable().ajax.reload(null, false);
                        if ($.fn.DataTable.isDataTable('#tablaInactivos')) {
                            $('#tablaInactivos').DataTable().ajax.reload(null, false);
                        }
                        cargarEstadisticasClientes();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al dar de baja al cliente.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            }
        });
    }

    /**
     * Función para manejar el alta de un cliente.
     */
    function darDeAltaUnidad(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡El cliente será marcado como activo!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, dar de alta',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: darAltaUrl.replace(':id', id),
                    type: 'PUT',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Dado de alta!',
                            text: 'El cliente ha sido marcado como activo.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                        // Recargar todas las tablas y las estadísticas
                        $('#tablaHistorial').DataTable().ajax.reload(null, false);
                        if ($.fn.DataTable.isDataTable('#tablaInactivos')) {
                            $('#tablaInactivos').DataTable().ajax.reload(null, false);
                        }
                        cargarEstadisticasClientes();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al dar de alta al cliente.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            }
        });
    }

    $(document).ready(function() {
        cargarEstadisticasClientes();
        
        // Inicializar la tabla de clientes activos con un filtro de búsqueda
        var tablaHistorial = $('#tablaHistorial').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
            dom: '<"row"<"col-sm-12 col-md-6 d-flex justify-content-start"f><"col-sm-12 col-md-6 d-flex justify-content-end align-items-center"l<"botones_datatable_clientes d-flex align-items-center">>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: dataTableAjaxUrl,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre_empresa', name: 'nombre_empresa' },
                { data: 'rfc', name: 'rfc' },
                { data: 'calle', name: 'calle' },
                { data: 'colonia', name: 'colonia' },
                { data: 'localidad', name: 'localidad' },
                { data: 'municipio', name: 'municipio' },
                { data: 'estado', name: 'estado' },
                { data: 'regimen_fiscal', name: 'regimen_fiscal' },
                { data: 'credito', name: 'credito' },
                { data: 'constancia_fiscal', name: 'constancia_fiscal' },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ],
            autoWidth: false,
            scrollX: false,
            // Eliminamos la configuración de anchos fijos de DataTables
            // columnDefs: [
            //     { width: '5%', targets: 0 },
            //     { width: '10%', targets: 1 },
            //     ...
            // ],
            initComplete: function () {
                // Clona los botones originales
                var addButton = $('#agregarClienteBtn').clone();
                var exportButton = $('#exportarClientesBtn').clone();
                
                // Mueve los botones al nuevo contenedor de DataTables
                $('.botones_datatable_clientes').append(addButton);
                $('.botones_datatable_clientes').append(exportButton);
                
                // Agrega la clase de margen al botón de exportar
                exportButton.addClass('ms-2');
                
                // Elimina los botones originales para evitar duplicados
                $('#agregarClienteBtn').remove();
                $('#exportarClientesBtn').remove();
                
                // Oculta el texto "Mostrar" y los "registros"
                $('.dataTables_length label').contents().filter(function() {
                    return this.nodeType === 3;
                }).remove();
                
                // Mueve el filtro de búsqueda para alinear el botón y el mostrar
                var searchDiv = $('.dataTables_filter');
                searchDiv.css({
                    display: 'flex',
                    alignItems: 'center',
                    gap: '10px'
                });
            }
        });
    });
</script>

@vite(['resources/js/historial_clientes.js'])
@endsection

@section('content')
<style>
/* -------------------------------------------
    Ajustes de la tabla
    ------------------------------------------- */

/* Estilos para el tamaño de letra del cuerpo de la tabla */
.table.table-sm tbody tr td {
    font-size: 0.85rem; /* Ajusta el tamaño de la letra para que no sea tan pequeña */
}

/* Estilos para las celdas de la tabla */
.table td, .table th {
    white-space: normal;
    overflow-wrap: break-word;
    word-break: break-word;
    font-size: 0.85rem;
}

/* -------------------------------------------
    Fin de ajustes de la tabla
    ------------------------------------------- */

/* Estilos para mostrar la cantidad total de clientes */
.total-clientes-count {
    font-size: 1.5rem;
    font-weight: normal;
    color: #4B4B4B;
    margin-top: 0.5rem;
    margin-bottom: 1rem;
}

/* Estilos para las tarjetas de estadísticas */
.stats-container {
    margin-bottom: 1.5rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
}

.stats-card {
    background: #ffffff;
    border-radius: 10px;
    padding: 1.25rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    border: 1px solid #f1f5f9;
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--card-accent-color, #e2e8f0), var(--card-accent-color, #e2e8f0));
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.stats-card.activos {
    --card-accent-color: #10b981;
}

.stats-card.fisicas {
    --card-accent-color: #3b82f6;
}

.stats-card.otros {
    --card-accent-color: #8b5cf6;
}

.stats-card.inactivos {
    --card-accent-color: #ef4444;
}

.stats-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.stats-card-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    margin: 0;
    line-height: 1.4;
}

.stats-card-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.stats-card-icon.green {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    color: #059669;
}

.stats-card-icon.blue {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    color: #2563eb;
}

.stats-card-icon.purple {
    background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
    color: #7c3aed;
}

.stats-card-icon.red {
    background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
    color: #dc2626;
}

.stats-card-content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.stats-card-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-card-percentage {
    display: none; /* Oculta los porcentajes */
}

.stats-card-loading {
    display: none;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
}

.spinner {
    width: 24px;
    height: 24px;
    border: 2px solid #e2e8f0;
    border-top: 2px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-card {
        padding: 1rem;
    }
    
    .stats-card-number {
        font-size: 1.75rem;
    }
    
    .stats-card-icon {
        width: 32px;
        height: 32px;
        font-size: 1.125rem;
    }
}
</style>

<div class="container-fluid mt--7">
    <div class="stats-container">
        <div class="stats-grid">
            <div class="stats-card activos">
                <div class="stats-card-header">
                    <h6 class="stats-card-title">Clientes activos</h6>
                    <div class="stats-card-icon green">
                        <i class="ri-user-follow-line"></i>
                    </div>
                </div>
                <div class="stats-card-content">
                    <h2 class="stats-card-number" id="clientesActivosCount">{{ $clientesActivos ?? 0 }}</h2>
                    <div class="stats-card-percentage" id="porcentajeActivos" style="display: none;">
                        <i class="ri-arrow-up-line"></i>
                        0%
                    </div>
                </div>
                <div class="stats-card-loading">
                    <div class="spinner"></div>
                </div>
            </div>

            <div class="stats-card fisicas">
                <div class="stats-card-header">
                    <h6 class="stats-card-title">Personas Físicas</h6>
                    <div class="stats-card-icon blue">
                        <i class="ri-user-star-line"></i>
                    </div>
                </div>
                <div class="stats-card-content">
                    <h2 class="stats-card-number" id="personasFisicasCount">{{ $personasFisicas ?? 0 }}</h2>
                    <div class="stats-card-percentage" id="porcentajePersonasFisicas" style="display: none;">
                        <i class="ri-arrow-up-line"></i>
                        0%
                    </div>
                </div>
                <div class="stats-card-loading">
                    <div class="spinner"></div>
                </div>
            </div>

            <div class="stats-card otros">
                <div class="stats-card-header">
                    <h6 class="stats-card-title">Otros regímenes</h6>
                    <div class="stats-card-icon purple">
                        <i class="ri-group-line"></i>
                    </div>
                </div>
                <div class="stats-card-content">
                    <h2 class="stats-card-number" id="otrosRegimenesCount">{{ $otrosRegimenes ?? 0 }}</h2>
                    <div class="stats-card-percentage" id="porcentajeOtrosRegimenes" style="display: none;">
                        <i class="ri-arrow-up-line"></i>
                        0%
                    </div>
                </div>
                <div class="stats-card-loading">
                    <div class="spinner"></div>
                </div>
            </div>

            <div class="stats-card inactivos">
                <div class="stats-card-header">
                    <h6 class="stats-card-title">Clientes inactivos</h6>
                    <div class="stats-card-icon red">
                        <i class="ri-user-unfollow-line"></i>
                    </div>
                </div>
                <div class="stats-card-content">
                    <h2 class="stats-card-number" id="clientesInactivosCount">{{ $clientesInactivos ?? 0 }}</h2>
                    <div class="stats-card-percentage" id="porcentajeInactivos" style="display: none;">
                        <i class="ri-arrow-up-line"></i>
                        0%
                    </div>
                </div>
                <div class="stats-card-loading">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0 pb-1">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h3 class="mb-3"><b>Historial Clientes</b></h3>
                            <div class="total-clientes-count">
                                Clientes total registrados: <span id="totalEmpresasCount">{{ ($clientesActivos ?? 0) + ($clientesInactivos ?? 0) }}</span>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="table-responsive p-3">
                    {{-- Botones que serán movidos por JavaScript --}}
                    <div style="display: none;">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarHistorialModal" id="agregarClienteBtn">
                            <span class="d-none d-sm-inline-block">Agregar cliente</span>
                        </a>
                        <button class="btn btn-secondary" id="exportarClientesBtn" data-bs-toggle="modal" data-bs-target="#exportarClientesModal">
                            <span class="d-none d-sm-inline-block">Exportar</span>
                        </button>
                    </div>
                    <table id="tablaHistorial" class="table table-flush table-bordered tablaHistorial_datatable table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th>Empresa</th>
                                <th>RFC</th>
                                <th>Calle</th>
                                <th>Colonia</th>
                                <th>Localidad</th>
                                <th>Municipio</th>
                                <th>Estado</th>
                                <th>Régimen Fiscal</th>
                                <th>Crédito</th>
                                <th>Constancia</th>
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

@include('_partials/_modals/modal-add-historialClientes')
<div class="modal fade" id="editHistorialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-add-new-role">
        <div class="modal-content" id="editHistorialModalContent">
            <div class="modal-body text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2">Cargando formulario de edición...</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewHistorialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="viewHistorialModalContent">
            </div>
    </div>
</div>

@include('_partials/_modals/modal-add-export_clientes_empresas')
@include('_partials/_modals/modal-add-view-pdf')
@endsection