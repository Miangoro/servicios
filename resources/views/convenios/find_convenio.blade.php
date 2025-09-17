@extends('layouts/layoutMaster')

@section('title', 'Convenios')

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
    @vite(['resources/js/convenios.js'])
@endsection

@section('content')
<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
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
                    <h3 class="mb-0"><b>Catálogo de Convenios</b></h3>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="table-responsive p-3">
                    <div id="tablaConvenios_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 d-flex align-items-center justify-content-start">
                                {{-- Aquí se genera automáticamente el "Mostrar X entradas" --}}
                            </div>
                            <div class="col-sm-12 col-md-6 d-flex align-items-center justify-content-end">
                                {{-- Aquí se genera automáticamente el campo de búsqueda --}}
                            </div>
                        </div>
                        <table id="tablaConvenios" class="table table-flush table-bordered convenios_datatable table-striped table-sm" data-url="{{ route('convenios.datatable') }}">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-white">No.</th>
                                    <th scope="col" class="text-white">Clave</th>
                                    <th scope="col" class="text-white">Nombre del Proyecto</th>
                                    <th scope="col" class="text-white">Investigador Responsable</th>
                                    <th scope="col" class="text-white">Duración</th>
                                    <th scope="col" class="text-white">Tipo Duración</th>
                                    <th scope="col" class="text-white" style="width: 120px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="..."></nav>
                </div>
            </div>
        </div>
    </div>
</div>

@include('_partials/_modals/modal-add-convenio')
@include('_partials/_modals/modal-edit-convenio')
@include('_partials/_modals/modal-visualizar-convenio')
@endsection