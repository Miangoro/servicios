@extends('layouts.layoutMaster')

@section('title', 'Revisión Personal')

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
    'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js'
])
@endsection

@section('page-script')
@vite(['resources/js/certificados_personal.js'])
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<div class="row g-6 mb-6 justify-content-center">
    <div class="col-sm-6 col-md-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column"> 
                <div class="d-flex justify-content-between">
                    <div class="me-1">
                        <p class="text-heading mb-1 fw-bold">Instalaciones</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasInstalaciones['totalCertificados'] }}</h4>
                            <p class="text-success mb-1">({{ number_format($EstadisticasInstalaciones['porcentaje'], 0) }}%)</p>
                        </div>
                        <small class="mb-0">Certificados Asignados</small>
                    </div>
                    <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded-3">
                            <div class="ri-home-gear-line ri-26px"></div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-auto"> 
                    <div class="me-1">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasInstalaciones['certificadosPendientes'] }}</h4>
                            <p class="text-danger mb-1">({{ number_format($EstadisticasInstalaciones['porcentajePendientes'], 0) }}%)</p>
                        </div>
                        <small class="mb-0">Certificados Pendientes</small>
                    </div>
                    <div class="me-1">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasInstalaciones['certificadosRevisados'] }}</h4>
                            <p class="text-info mb-1">({{ number_format($EstadisticasInstalaciones['porcentajeRevisados'], 0) }}%)</p>
                        </div>
                        <small class="mb-0">Certificados Revisados</small>
                    </div>
                </div>

            </div>
        </div>        
    </div>
    
    <div class="col-sm-6 col-md-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <div class="me-1">
                        <p class="text-heading mb-1 fw-bold">Granel</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasGranel['totalCertificados'] }}</h4>
                            <p class="text-success mb-1">({{ number_format($EstadisticasGranel['porcentaje'], 0) }}%)</p>
                        </div>
                         <small class="mb-0">Certificados Asignados</small>
                    </div>
                    <div class="avatar">
                        <div class="avatar-initial bg-label-success rounded-3">
                            <div class="ri-box-3-line ri-26px"></div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-auto"> 
                    <div class="me-1">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasGranel['certificadosPendientes'] }}</h4>
                            <p class="text-danger mb-1">({{ number_format($EstadisticasGranel['porcentajePendientes'], 0) }}%)</p>
                        </div>
                        <small class="mb-0">Certificados Pendientes</small>
                    </div>
                    <div class="me-1">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasGranel['certificadosRevisados'] }}</h4>
                            <p class="text-info mb-1">({{ number_format($EstadisticasGranel['porcentajeRevisados'], 0) }}%)</p>
                        </div>
                        <small class="mb-0">Certificados Revisados</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="col-sm-6 col-md-6 col-xl-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between">
                    <div class="me-1">
                        <p class="text-heading mb-1 fw-bold">Exportación</p>
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasExportacion['totalCertificados'] }}</h4>
                            <p class="text-success mb-1">({{ number_format($EstadisticasExportacion['porcentaje'], 0) }}%)</p>
                        </div>
                         <small class="mb-0">Certificados Asignados</small>
                    </div>
                    <div class="avatar">
                        <div class="avatar-initial bg-label-success rounded-3">
                            <div class="ri-flight-takeoff-line ri-26px"></div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-auto"> 
                    <div class="me-1">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasExportacion['certificadosPendientes'] }}</h4>
                            <p class="text-danger mb-1">({{ number_format($EstadisticasExportacion['porcentajePendientes'], 0) }}%)</p>
                        </div>
                        <small class="mb-0">Certificados Pendientes</small>
                    </div>
                    <div class="me-1">
                        <div class="d-flex align-items-center">
                            <h4 class="mb-1 me-2">{{ $EstadisticasExportacion['certificadosRevisados'] }}</h4>
                            <p class="text-info mb-1">({{ number_format($EstadisticasExportacion['porcentajeRevisados'], 0) }}%)</p>
                        </div>
                        <small class="mb-0">Certificados Revisados</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Revisión de certificados por parte del personal</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Certificado</th>
                    <th>Revisor</th>
                    <th>Fecha asignación</th>
                    <th>Fecha revisión</th>
                    <th>Bitácora</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

{{-- @include('_partials/_modals/modal-cuest-certificados-personal') --}}
@include('_partials/_modals/modal-pdfs-frames')
@include('_partials/_modals/modal-aprobacion-revision-personal')
@include('_partials/_modals/modal-historial')
@endsection