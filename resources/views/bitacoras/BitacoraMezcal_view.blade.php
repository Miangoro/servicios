@extends('layouts.layoutMaster')

@section('title', 'Bitácora Mezcal a Granel')

@section('vendor-style')
    <style>
        #filtroEmpresa+.select2-container .select2-selection__rendered,
        #filtroInstalacion+.select2-container .select2-selection__rendered {
            text-overflow: ellipsis !important;
            overflow: hidden !important;
            white-space: nowrap !important;
            min-width: 280px;
            max-width: 290px !important;
            font-size: 13px !important;
        }
    </style>
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js'])
@endsection

@section('page-script')
    <script>
        const opcionesEmpresas = `{!! collect($empresas)->map(function ($e) {
                $num = $e->empresaNumClientes[0]->numero_cliente ?? ($e->empresaNumClientes[1]->numero_cliente ?? '');
                return "<option value='{$e->id_empresa}'>{$num} | {$e->razon_social}</option>";
            })->implode('') !!}`;
    </script>
    @vite(['resources/js/bitacora_mezcal.js'])
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Users List Table -->

    <div class="card">
        <!-- Filtros externos al DataTable -->


        <div class="card-header pb-0 mb-1">
            <h3 class="card-title mb-0">Mezcal a Granel</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Datos Iniciales</th>
                        <th>Entradas</th>
                        <th>Salidas</th>
                        <th>Inventario Final</th>
                        {{--                     <th>Bitácora</th> --}}
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>




    <!-- Modal -->

    @include('_partials/_modals/modal-pdfs-frames')
    @include('_partials/_modals/modal-add-bitacoraMezcal')
    @include('_partials._modals.modal-edit-bitacoraMezcal')
    <!-- /Modal -->

@endsection
