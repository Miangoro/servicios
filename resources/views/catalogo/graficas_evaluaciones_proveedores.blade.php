@extends('layouts/layoutMaster')

@section('title', 'Proveedores')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/spinkit/spinkit.scss',
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
        'resources/assets/vendor/libs/chartjs/chartjs.js'
    ])
@endsection

@section('page-script')
    @vite(['resources/js/verGraficasProveedores.js'])
    <script>
        // Aquí pasamos los datos de las gráficas al JS
        window.graficasData = @json($datosGraficas);
    </script>
@endsection

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 pb-1">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="d-flex flex-row align-items-center">
                                    <i class="ri-survey-fill ri-40px"></i>
                                    <h3 class="mb-0 m-1"><b>Gráficas de las encuestas de satisfacción del proveedor</b></h3>
                                </div>

                            </div>
                            <div class="col-6 text-right">
                            </div>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="card-body">
                        <div class="nav-align-top">
                            <ul class="nav nav-tabs" role="tablist" id="graficas-tabs">
                                @foreach($datosGraficas as $id_encuesta => $data)
                                    <li class="nav-item">
                                        <button type="button" class="nav-link {{ $loop->first ? 'active' : '' }}" role="tab" data-bs-toggle="tab" data-bs-target="#tab-{{ $id_encuesta }}" aria-controls="tab-{{ $id_encuesta }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            {{ $data['nombre_encuesta'] }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="graficas-tab-content">
                                @foreach($datosGraficas as $id_encuesta => $data)
                                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="tab-{{ $id_encuesta }}" role="tabpanel">
                                        <h4>Gráficas para la encuesta: {{ $data['nombre_encuesta'] }}</h4>
                                        <hr>
                                        
                                        <div class="row row-cols-1 row-cols-md-2 col-md-12">
                                            @foreach($data['preguntas'] as $pregunta)
                                                <div class="col-md-6">
                                                    <div class="card-header header-elements">
                                                        <h5 class="card-title mb-0">{{ $pregunta['nombre_pregunta'] }}</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <canvas id="chart-{{ $id_encuesta }}-{{ $pregunta['id_pregunta'] }}" 
                                                                class="chartjs" data-height="400"></canvas>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card-footer py-4 d-flex flex-row justify-content-center">
                                <button type="button" class="add-new btn btn-secondary waves-effect waves-light" onclick="history.back()">
                                     <i class="ri-arrow-left-fill"></i>
                                    <span class="d-none d-sm-inline-block">Regresar</span>
                                </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection