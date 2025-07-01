@extends('layouts/layoutMaster')
@section('title', 'Lotes envasado')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/lotes_envasado.js'])
@endsection

@section('content')

    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Listas de Lotes envasados</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Datos del cliente</th>
                        <th>Lotes</th>
                        <th>Marca</th>
                        <th>Numero de botellas</th>
                        <th>Presentación</th>
                        <th>Volumen</th>
                        <th>Destino lote</th>
                        <th>Lugar de envasado</th>
                        <th>No. de pedido/SKU</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    
    @include('_partials/_modals/modal-add-lotesEnvasado')
    @include('_partials/_modals/modal-edit-lotesSKU')
    @include('_partials._modals/modal-edit-lotesEnvasado')
    <!-- /Modal -->
@endsection
