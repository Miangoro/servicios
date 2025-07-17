@extends('layouts/layoutMaster')

@section('title', 'Unidades')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
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

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/tipos.js'])
<script src="{{ asset('js/unidades.js') }}"></script>

@endsection

@section('content')
<style>
  /* Aplica solo a la clase que contiene la tabla */
.lab_datatable td {
    white-space: nowrap;
}

</style>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
    <div class="row align-items-start">  <!-- Cambiado de align-items-center a align-items-start -->
        <div class="col-6">
            <h3 class="mb-3"><b>Catálogo de Unidades</b></h3>  <!-- Añadido mb-3 para margen inferior -->
            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#agregarUnidades">
                <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                <span class="d-none d-sm-inline-block">Nueva Unidad</span>
            </button>
        </div>
        <div class="col-6 text-right">
            <!-- Contenido derecho si es necesario -->
        </div>
    </div>
</div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                
                <div class="table-responsive p-3">
                    <table id= "tablaUnidades" class="table table-flush table-bordered unidades_datatable table-striped table-sm">
                       
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 80px;">NO.</th>   <th>NOMBRE</th> 
                                <th class="text-center" style="width: 120px;">Acciones</th> </tr>
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


<!-- FormValidation -->
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Tu archivo de unidades -->
<script src="{{ asset('assets/js/unidades.js') }}"></script>

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


@endpush

@endsection
@include('_partials/_modals/modal-add-unidades')
@include('_partials/_modals/modal-add-edit-unidades')