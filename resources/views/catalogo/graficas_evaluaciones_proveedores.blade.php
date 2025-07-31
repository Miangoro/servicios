@extends('layouts/layoutMaster')

@section('title', 'Proveedores')

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
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
    @vite(['resources/js/Proveedores.js'])

@endsection

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 pb-1">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <button type="button" class="add-new btn btn-secondary waves-effect waves-light">
                                    <i class="ri-arrow-reply-solid ri-16px me-0 me-sm-2 align-baseline"></i>
                                    <span class="d-none d-sm-inline-block">Regresar</span>
                                </button>
                                <h3 class="mb-0"><b>Gráficas de las encuestas de satisfacción del proveedor</b></h3>
                                <span>Número de compras:</span>
                                <span>Número de evaluaciones:</span>

                            </div>
                            <div class="col-6 text-right">
                            </div>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="d-grid">
                        <div class="col-xl-6 col-12 mb-6">
                            <div class="card">
                                <div class="card-header header-elements">
                                    <h5 class="card-title mb-0">Latest Statistics</h5>
                                    <div class="card-action-element ms-auto py-0">
                                        <div class="dropdown">
                                            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i class="ri-calendar-2-line"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="javascript:void(0);"
                                                        class="dropdown-item d-flex align-items-center">Today</a></li>
                                                <li><a href="javascript:void(0);"
                                                        class="dropdown-item d-flex align-items-center">Yesterday</a></li>
                                                <li><a href="javascript:void(0);"
                                                        class="dropdown-item d-flex align-items-center">Last 7 Days</a></li>
                                                <li><a href="javascript:void(0);"
                                                        class="dropdown-item d-flex align-items-center">Last 30 Days</a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a href="javascript:void(0);"
                                                        class="dropdown-item d-flex align-items-center">Current Month</a>
                                                </li>
                                                <li><a href="javascript:void(0);"
                                                        class="dropdown-item d-flex align-items-center">Last Month</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="barChart" class="chartjs" data-height="400"></canvas>
                                </div>
                            </div>
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