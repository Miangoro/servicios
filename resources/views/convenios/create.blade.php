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
{{-- Se incluye únicamente el archivo de convenios, ya que es el que inicializa la tabla --}}
@vite(['resources/js/convenios.js'])
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
                    <h3 class="mb-0"><b>Catálogo de Convenios</b></h3>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="table-responsive p-3">
                    <div id="tablaConvenios_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 d-flex align-items-center justify-content-start">
                                <div id="tablaConvenios_filter" class="dataTables_filter">
                                    <label>Buscar:
                                        <input type="search" class="form-control form-control-sm" placeholder="" aria-controls="tablaConvenios">
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 d-flex align-items-center justify-content-end">
                                <div class="dataTables_length me-2" id="tablaConvenios_length">
                                    <label>
                                        <select name="tablaConvenios_length" aria-controls="tablaConvenios" class="form-select form-select-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </label>
                                </div>
                                <button id="agregarConvenioBtn" type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#agregarConvenios">
                                    <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                    <span class="d-none d-sm-inline-block">+ Agregar Convenio</span>
                                </button>
                            </div>
                        </div>
                        <table id="tablaConvenios" class="table table-flush table-bordered convenios_datatable table-striped table-sm">
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
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="..."></nav>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection