@extends('layouts/layoutMaster')

@section('title', 'Trámites IMPI')

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
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
//Animacion "loading"
  'resources/assets/vendor/libs/spinkit/spinkit.scss'
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
  'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/impi.js'])
@endsection


@section('content')

<div class="card">
 
  <div class="card-header pb-0">
    <h3 class="card-title mb-0">Historial de Trámites ante el IMPI</h3>
  </div>

    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                  <th></th>
                  <th>folio</th>
                  <th>fecha de solicitud</th>
                  <th>cliente</th>
                  <th>Trámite</th>
                  <th>contraseña</th>
                  <th>pago IMPI</th>
                  <th>contacto</th>
                  <th>observaciones</th>
                  <th>estatus</th>
                  <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>

</div><!--CARD-->

<!-- Modal -->
@include('_partials/_modals/modal-add-impi')
@include('_partials/_modals/modal-add-impi-evento')
<!-- /Modal -->

@endsection
