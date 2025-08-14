@extends('layouts/layoutMaster')

@section('title', 'Unidades')

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
{{-- Se incluye únicamente el archivo de unidades, ya que es el que inicializa la tabla --}}
@vite(['resources/js/unidades.js'])
@endsection

@section('content')
<style>
    .columna-descripcion {
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
                <div class="card-header border-0 pb-1">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0"><b>Catálogo de Unidades</b></h3>
                            <button id=agregarUnidadBtn type="button" class="add-new btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#agregarUnidades">
                                <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                <span class="d-none d-sm-inline-block">Nueva Unidad</span>
                            </button>
                        </div>
                        <div class="col-6 text-right">
                        </div>
                    </div>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="table-responsive p-3">
                    <table id="tablaUnidades" class="table table-flush table-bordered unidades_datatable table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-white">No.</th>
                                <th scope="col" class="text-white">Nombre</th>
                                <th scope="col" class="text-white" style="width: 120px;">Acciones</th>
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

@include('_partials/_modals/modal-add-unidades')
@include('_partials/_modals/modal-add-edit-unidades')
@endsection