@extends('layouts/layoutMaster')

@section('title', 'Certificados de Exportación')

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
  //calendario1
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
  //calendario2
  'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
  'resources/assets/vendor/libs/pickr/pickr-themes.scss',
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
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
  //calendario1
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
  //calendario2
  'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/pickr/pickr.js',
  'resources/assets/vendor/libs/flatpickr/l10n/es.js' // Archivo local del idioma
])
@endsection

<!-- Page Scripts -->
@section('page-script')
  @vite(['resources/js/certificados_nacional.js'])
@endsection


@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Certificados de venta nacional</h3>
    </div>

    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>No. certificado / Solicitud</th>
                    <th>Solicitud /<br>no. servicio</th>
                    <th>Cliente</th>
                    <th>Características</th>
                    <th>Fechas</th>
                    <th>Estatus</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
        </table>
    </div>
    
</div>



<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
@include('_partials/_modals/modal-add-certificado-nacional')
@include('_partials/_modals/modal-reexpedir-certificado-nacional')
@include('_partials/_modals/modal-add-asignar-revisor')

{{-- 
@include('_partials/_modals/modal-trazabilidad-certificados') --}}
<!-- /Modal -->

@endsection
