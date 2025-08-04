@extends('layouts/layoutMaster')

@section('title', 'ClientesEmpresas')

@section('vendor-style')
    {{-- Animacion "loading" --}}
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/spinkit/spinkit.scss',
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
    // Define la URL para obtener el conteo total de empresas
    var totalEmpresasUrl = "{{ route('empresas.count') }}";
    // Define la URL para la acción de dar de baja un cliente
    var darBajaUrl = "{{ route('clientes.empresas.darBaja', ':id') }}";
</script>
<script>
    /**
     * Función para manejar la baja de un cliente.
     * Muestra una alerta de confirmación y, si se acepta, realiza una petición para cambiar el estado del cliente.
     * @param {string} id - El ID del cliente a dar de baja.
     */
    function handleBaja(id) {
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
                // Realiza la petición AJAX para dar de baja al cliente
                $.ajax({
                    url: darBajaUrl.replace(':id', id),
                    type: 'POST', // Usa POST para la compatibilidad con el método HTTP PUT de Laravel
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'PUT' // Usar PUT para la ruta
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
                        // Recarga la tabla para reflejar los cambios
                        $('#tablaHistorial').DataTable().ajax.reload();
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

    // --- COMENTARIO IMPORTANTE PARA EL DESARROLLADOR ---
    // En el archivo resources/js/historial_clientes.js, debes modificar la
    // definición de las columnas de DataTables. Específicamente, en la columna
    // de 'Acciones', cambia el botón 'Eliminar' por uno que llame a la
    // función `handleBaja(id)` que hemos definido aquí.
    // Por ejemplo:
    // ...
    // {
    //     data: 'acciones',
    //     name: 'acciones',
    //     orderable: false,
    //     searchable: false,
    //     render: function(data, type, row) {
    //         return '<div class="d-inline-flex">' +
    //             '<a href="javascript:;" onclick="handleBaja(' + row.id + ')" class="dropdown-item text-danger">' +
    //             '<i class="ri-delete-bin-7-line me-1"></i> Dar de baja' +
    //             '</a>' +
    //             '</div>';
    //     }
    // }
    // ...
</script>
@vite(['resources/js/historial_clientes.js'])
@endsection

@section('content')

<style>
.constancia{
    width: auto;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Estilos para mostrar la cantidad total de clientes */
.total-clientes-count {
    font-size: 1.5rem; /* Tamaño de fuente para que se vea prominente */
    font-weight: normal; /* Hace la letra más delgada */
    color: #4B4B4B; /* Un gris oscuro para que sea legible */
    margin-top: 0.5rem; /* Espacio superior para separarlo del título */
    margin-bottom: 1rem; /* Espacio inferior para separarlo del botón */
}
</style>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="mb-4">
                <div class="row g-4 justify-content-start w-100">
                    <div class="col-md-3">
                        <div class="card bg-white shadow-sm p-4 d-flex align-items-start" style="min-width: 220px; border-radius: 1rem;">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <h5 class="card-title text-muted mb-0" style="font-size: 1rem; font-weight: 500;">Clientes activos</h5>
                                <div class="text-success opacity-75" style="width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; background-color: rgba(0, 128, 0, 0.1); border-radius: 50%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="12" cy="6" r="4"/>
                                            <circle cx="18" cy="16" r="4"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.667 16l.833 1l1.833-1.889"/>
                                            <path d="M15 13.327A13.6 13.6 0 0 0 12 13c-4.418 0-8 2.015-8 4.5S4 22 12 22c5.687 0 7.331-1.018 7.807-2.5"/>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <h3 class="card-text fw-bold mb-0" style="font-size: 1.5rem; display: inline;">305</h3>
                                <span class="text-success" style="font-size: 0.8rem; margin-left: 0.5rem;">82.88%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-white shadow-sm p-4 d-flex align-items-start" style="min-width: 220px; border-radius: 1rem;">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <h5 class="card-title text-muted mb-0" style="font-size: 1rem; font-weight: 500;">Personas físicas</h5>
                                <div class="text-blue-500 opacity-75" style="width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; background-color: rgba(0, 0, 255, 0.1); border-radius: 50%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                        <path fill="#36b7f2" d="M16 4c-3.855 0-7 3.145-7 7c0 2.379 1.21 4.484 3.031 5.75C7.926 18.352 5 22.352 5 27h2c0-4.398 3.191-8.074 7.375-8.844L15 20h2l.625-1.844C21.809 18.926 25 22.602 25 27h2c0-4.648-2.926-8.648-7.031-10.25C21.789 15.484 23 13.379 23 11c0-3.855-3.145-7-7-7m0 2c2.773 0 5 2.227 5 5s-2.227 5-5 5s-5-2.227-5-5s2.227-5 5-5m-1 15l-1 6h4l-1-6z"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="card-text fw-bold mt-2 mb-0" style="font-size: 1.5rem;">233</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-white shadow-sm p-4 d-flex align-items-start" style="min-width: 220px; border-radius: 1rem;">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <h5 class="card-title text-muted mb-0" style="font-size: 1rem; font-weight: 500;">Otros regímenes</h5>
                                <div class="text-blue-500 opacity-75" style="width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; background-color: rgba(0, 0, 255, 0.1); border-radius: 50%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.774 18c.75 0 1.345-.471 1.88-1.13c1.096-1.35-.703-2.43-1.389-2.957c-.697-.537-1.476-.842-2.265-.913m-1-2a2.5 2.5 0 0 0 0-5M3.226 18c-.75 0-1.345-.471-1.88-1.13c-1.096-1.35.703-2.43 1.389-2.957C3.432 13.376 4.21 13.07 5 13m.5-2a2.5 2.5 0 0 1 0-5m2.584 9.111c-1.022.632-3.701 1.922-2.07 3.536C6.813 19.436 7.7 20 8.817 20h6.368c1.117 0 2.004-.564 2.801-1.353c1.632-1.614-1.047-2.904-2.069-3.536a7.46 7.46 0 0 0-7.832 0M15.5 7.5a3.5 3.5 0 1 1-7 0a3.5 3.5 0 0 1 7 0"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="card-text fw-bold mt-2 mb-0" style="font-size: 1.5rem;">135</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-white shadow-sm p-4 d-flex align-items-start" style="min-width: 220px; border-radius: 1rem;">
                            <div class="d-flex w-100 align-items-center justify-content-between">
                                <h5 class="card-title text-muted mb-0" style="font-size: 1rem; font-weight: 500;">Clientes inactivos</h5>
                                <div class="text-danger opacity-75" style="width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center; background-color: rgba(242, 83, 54, 0.1); border-radius: 50%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="#f25336" fill-rule="evenodd" d="M12 1.25a4.75 4.75 0 1 0 0 9.5a4.75 4.75 0 0 0 0-9.5M8.75 6a3.25 3.25 0 1 1 6.5 0a3.25 3.25 0 0 1-6.5 0" clip-rule="evenodd"/>
                                        <path fill="#f25336" d="M17.197 14.136a.75.75 0 0 0-1.06 1.061l.802.803l-.802.803a.75.75 0 0 0 1.06 1.06l.803-.802l.803.803a.75.75 0 0 0 1.06-1.061L19.062 16l.803-.803a.75.75 0 0 0-1.06-1.06L18 14.94z"/>
                                        <path fill="#f25336" fill-rule="evenodd" d="M12 12.25c.969 0 1.902.092 2.775.263a4.75 4.75 0 1 1 5.596 7.604c-.374.81-1.072 1.453-2.251 1.892c-1.31.487-3.252.741-6.12.741c-2.026 0-3.58-.127-4.774-.369c-1.19-.24-2.07-.605-2.7-1.117c-1.278-1.042-1.277-2.5-1.276-3.662V17.5c0-1.634 1.17-2.96 2.726-3.836c1.58-.888 3.71-1.414 6.024-1.414M4.75 17.5c0-.851.622-1.775 1.961-2.528c1.316-.74 3.184-1.222 5.29-1.222c.605 0 1.193.04 1.755.115A4.75 4.75 0 0 0 17.31 20.7c-1.07.337-2.733.55-5.31.55c-1.975 0-3.42-.125-4.477-.339c-1.06-.214-1.68-.509-2.05-.81c-.684-.557-.724-1.293-.724-2.601M18 12.75a3.25 3.25 0 1 0 0 6.5a3.25 3.25 0 0 0 0-6.5" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-2">
                                <h3 class="card-text fw-bold mb-0" style="font-size: 1.5rem; display: inline;">63</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-start mt-4">
                        <div class="col-6">
                            <h3 class="mb-3"><b>Historial Clientes</b></h3>
                            {{-- Aquí se mostrará la cantidad de clientes registrados --}}
                            <div class="total-clientes-count">
                                Clientes total registrados: <span id="totalEmpresasCount">{{ $totalClientes ?? 0 }}</span>
                            </div>
                            <div class="d-flex gap-2"> {{-- Contenedor flex para los botones --}}
                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#agregarEmpresa">
                                    <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                    <span class="d-none d-sm-inline-block">Agregar Cliente</span>
                                </button>
                                {{-- Botón modificado para abrir el modal --}}
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
{{-- Eliminado el include que causaba el error --}}

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

{{-- Incluyendo la vista parcial del modal de exportación --}}
@include('_partials/_modals/modal-add-export_clientes_empresas')

@include('_partials/_modals/modal-add-view-pdf')

@endsection
