@extends('layouts/layoutMaster')

@section('title', 'Servicios de catálogo')

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
        'resources/assets/vendor/libs/tagify/tagify.scss',
        'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
        'resources/assets/vendor/libs/typeahead-js/typeahead.scss'
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/tagify/tagify.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/typeahead-js/typeahead.js',
    'resources/assets/vendor/libs/bloodhound/bloodhound.js'
    ])
@endsection

@section('page-script')
@vite(['resources/js/serviciosCatalogo.js',
  'resources/assets/js/forms-selects.js',
  'resources/assets/js/forms-tagify.js',
  'resources/assets/js/forms-typeahead.js'
])

@endsection

@section('content')

<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>

<div class="container-fluid mt--7">

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0 pb-1">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h3 class="mb-0"><b>Servicios de Catálogo del CIDAM</b></h3>
                            <button id="addServicioBTN" type="button" class="add-new btn btn-primary waves-effect waves-light">
                                <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                                <span class="d-none d-sm-inline-block">Agregar servicio</span>
                            </button>
                            <button type="button" class="add-new btn btn-info waves-effect waves-light" id="exportarExcelBtn">
                                <span class="iconify me-0 me-sm-2" data-icon="ri:file-excel-2-fill" data-inline="false"></span>
                                <span class="d-none d-sm-inline-block">Exportar Excel</span>
                            </button>
                        </div>
                        <div class="col-6 text-right">
                        </div>
                    </div>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="table-responsive p-3">
                    <table id="tablaServiciosCatalogo" class="table table-flush table-bordered servCat_datatable table-striped table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-white">No.</th>
                                <th scope="col" class="text-white">Clave de catálogo</th>
                                <th scope="col" class="text-white">Servicio</th>
                                <th scope="col" class="text-white">Precio</th>
                                <th scope="col" class="text-white">Laboratorio</th>
                                <th scope="col" class="text-white">Método</th>
                                <th scope="col" class="text-white">Duración</th>
                                <th scope="col" class="text-white">Estatus</th>
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

@include('_partials/_modals/modal-export-servicios-catalogo')
@include('_partials/_modals/modal-add-servicios-catalogo')
@endsection