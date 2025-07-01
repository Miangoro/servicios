
@extends('layouts/layoutMaster')

@section('title', 'Lotes a granel')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss','resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss','resources/assets/vendor/libs/spinkit/spinkit.scss'])
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
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',

])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/catalogo_lotes.js'])
@endsection


@section('content')
    <!-- Users List Table -->
    <div class="card">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="card-header pb-0">
            <h3 class="card-title mb-0 fw-bold">Lotes a granel</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>tipo lote</th>
                        <th>No. de lote</th>
                        <th>Características</th>
                        <th>FQs</th>
                        <th>%Alc. Vol.</th>
                        <th>Volumen restante</th>
                        <th>Certificado</th>
                        <th>estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    @include('_partials/_modals/modal-add-lotes-granel')
    @include('_partials/_modals/modal-edit-lotes-granel')
    <!-- /Modal -->
@endsection
