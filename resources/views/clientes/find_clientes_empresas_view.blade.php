@extends('layouts/layoutMaster')

@section('title', 'ClientesEmpresas')

@section('vendor-style')
    {{-- Animacion "loading" --}}
   @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/spinkit/spinkit.scss'
])
    {{-- Agregado de la biblioteca de iconos Remixicon --}}
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
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
    ])
@endsection

@section('page-script')
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
        // Mostrar indicadores de carga
        $('.stats-card-loading').show();
        
        $.ajax({
            url: estadisticasClientesUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Actualizar los contadores en las tarjetas con animación
                    animateCounter('#clientesActivosCount', response.clientesActivos);
                    animateCounter('#personasFisicasCount', response.personasFisicas);
                    animateCounter('#otrosRegimenesCount', response.otrosRegimenes);
                    animateCounter('#clientesInactivosCount', response.clientesInactivos);
                    
                    const total = response.total;
                    $('#totalEmpresasCount').text(total);
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
                // Ocultar indicadores de carga
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
        const duration = 1000; // 1 segundo
        const increment = targetValue / (duration / 16); // 60 FPS
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
                        // Suponiendo que tienes una tabla de inactivos
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
                        // Suponiendo que tienes una tabla de inactivos
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

    // Cargar estadísticas al inicializar la página
    $(document).ready(function() {
        cargarEstadisticasClientes();
        
        // Inicializar la tabla de clientes activos
        $('#tablaHistorial').DataTable({
            // ... tus configuraciones de DataTables para clientes activos ...
        });

        // Inicializar la tabla de clientes inactivos (si la tienes)
        // Puedes descomentar y adaptar esto si manejas una tabla separada para inactivos
        /*
        $('#tablaInactivos').DataTable({
            processing: true,
            serverSide: true,
            ajax: dataTableInactivosAjaxUrl,
            columns: [
                // ... las columnas de tu tabla de inactivos ...
            ],
            // ... otras configuraciones
        });
        */
    });
</script>

@vite(['resources/js/historial_clientes.js'])
@endsection

@section('content')
<style>
/* ... (el mismo CSS que proporcionaste) ... */
.constancia{
    width: auto;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

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
                        <i class="ri-user-check-line"></i>
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
                        <i class="ri-building-2-line"></i>
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
                <div class="card-header border-0">
                    <div class="row align-items-start mt-4">
                        <div class="col-6">
                            <h3 class="mb-3"><b>Historial Clientes</b></h3>
                            <div class="total-clientes-count">
                                Clientes total registrados: <span id="totalEmpresasCount">{{ ($clientesActivos ?? 0) + ($clientesInactivos ?? 0) }}</span>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#agregarEmpresa">
                                    <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                    <span class="d-none d-sm-inline-block">Agregar Cliente</span>
                                </button>
                                <button type="button" class="btn btn-info mt-2" data-bs-toggle="modal" data-bs-target="#exportarVentasModal">
                                    <i class="ri-file-upload-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                    <span class="d-none d-sm-inline-block">Exportar</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            {{-- Puedes añadir algo aquí si lo necesitas --}}
                        </div>
                    </div>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="table-responsive p-3">
                    <table id="tablaHistorial" class="table table-flush table-bordered tablaHistorial_datatable table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>NO</th>
                                <th style="width: 80px;">Empresa</th>
                                <th>RFC</th>
                                <th>Calle</th>
                                <th>Colonia</th>
                                <th>Localidad</th>
                                <th>Municipio</th>
                                <th class="constancia" >Constancia</th>
                                <th class="text-center" style="width: 120px;">Acciones</th>
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