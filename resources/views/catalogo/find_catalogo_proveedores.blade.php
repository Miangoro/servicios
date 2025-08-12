@extends('layouts/layoutMaster')

@section('title', 'Proveedores')

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
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
@vite(['resources/js/Proveedores.js'])

@endsection

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0 pb-1">
                    <div class="row align-items-center">
                        <div class="col-md-12 d-flex flex-row">
                            <div class="col-md-6">
                                <h3 class="mb-0"><b>Catálogo de proveedores</b></h3>
                            </div>

                            <div class="col-md-6 d-flex justify-content-end">
                                <button id="agregarProveedorBtn" type="button" class="add-new btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#agregarProv">
                                    <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                    <span class="d-none d-sm-inline-block">Agregar Proveedor</span>
                                </button>
                            </div>

                        </div>
                        <div class="col-6 text-right">
                        </div>
                    </div>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="table-responsive p-3">
                    <table id="tablaProveedores" class="table table-flush table-bordered prov_datatable table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-white">#</th>
                                <th scope="col" class="text-white">Razón Solcial</th>
                                <th scope="col" class="text-white">Dirección</th>
                                <th scope="col" class="text-white">RFC</th>
                                <th scope="col" class="text-white">Datos Bancarios</th>
                                <th scope="col" class="text-white">Contacto</th>
                                <th scope="col" class="text-white">Tipo de Compra</th>
                                <th scope="col" class="text-white">Evaluación del Proveedor</th>
                                <th scope="col" class="text-white">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
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

@include('_partials/_modals/modal-add-new-proveedor')
@include('_partials/_modals/modal-edit-proveedor')
@endsection