@extends('layouts/layoutMaster')

@section('title', 'ClientesEmpresas')

<!-- Vendor Styles -->
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

<!-- Vendor Scripts -->
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
    // Define una variable JavaScript con la URL de la ruta de DataTables
    // Esto asegura que Blade procese la ruta correctamente antes de que el JS se ejecute
    var dataTableAjaxUrl = "{{ route('clientes.empresas.index') }}";
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


</style>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-start">
                        <div class="col-6">
                            <h3 class="mb-3"><b>Historial Clientes</b></h3>
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#agregarEmpresa">
                                <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                <span class="d-none d-sm-inline-block">Agregar Cliente</span>
                            </button>
                        </div>
                        <div class="col-6 text-right">
                            <!-- Contenido derecho si es necesario -->
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
                            <!-- DataTables llenará este tbody vía AJAX -->
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
@include('_partials/_modals/modal-add-edit-unidades')

@endsection