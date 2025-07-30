@extends('layouts/layoutMaster')

@section('title', 'ClientesEmpresas')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        //Animacion "loading"
        'resources/assets/vendor/libs/spinkit/spinkit.scss',
    ])
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
    // *** AÑADIDO: Define la URL para obtener el conteo total de empresas ***
    var totalEmpresasUrl = "{{ route('empresas.count') }}";
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
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-start">
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
                                {{-- Nuevo Botón Exportar con el icono actualizado --}}
                                <a href="{{ route('clientes.empresas.export.view') }}" target="_blank" class="btn btn-info mt-2">
                                    <i class="ri-file-upload-line ri-16px me-0 me-sm-2 align-baseline"></i> {{-- ICONO ACTUALIZADO --}}
                                    <span class="d-none d-sm-inline-block">Exportar</span>
                                </a>
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

@include('_partials/_modals/modal-add-view-pdf')

@endsection