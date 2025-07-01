@extends('layouts.layoutMaster')

@section('title', 'Catálogo Instalaciones')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
    'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
    'resources/assets/vendor/libs/pickr/pickr-themes.scss',
   'resources/assets/vendor/libs/spinkit/spinkit.scss'
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
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
    'resources/assets/vendor/libs/flatpickr/flatpickr.js',
    'resources/assets/vendor/libs/pickr/pickr.js',
    'resources/assets/vendor/libs/flatpickr/l10n/es.js' // Archivo local del idioma
])
@endsection

@section('page-script')
@vite(['resources/js/instalaciones.js'])

@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Users List Table -->
<div class="card"> 
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Instalaciones</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th>#</th>                                
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Responsable</th>
                    <th>Estado</th>
                    <th>Dirección</th>
                    <th>Folio</th>
                    <!--<th>Organismo</th>-->
                    <th>Certificados de instalaciones</th>
                    <!--<th>Fechas</th>-->
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>

<!-- Modal -->
@include('_partials._modals.modal-pdfs-frames')
@include('_partials/_modals/modal-add-instalaciones')
@endsection
