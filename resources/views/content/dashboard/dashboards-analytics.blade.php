@php
    $configData = Helper::appClasses();
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Inicio')



@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/swiper/swiper.scss'])
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-statistics.scss', 'resources/assets/vendor/scss/pages/cards-analytics.scss', 'resources/assets/vendor/scss/pages/ui-carousel.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/swiper/swiper.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/dashboards-analytics.js', 'resources/assets/js/ui-carousel.js'])
@endsection




@section('content')
    <div class="row g-6">
        <!-- Gamification Card -->
        <!-- <div class="col-md-12 col-xxl-8">
                <div class="card">
                  <div class="d-flex align-items-end row">
                    <div class="col-md-6 order-2 order-md-1">
                      <div class="card-body">
                        <h4 class="card-title mb-4">Bienvenid@ <span class="fw-bold">
            @if (Auth::check())
    {{ Auth::user()->name }}
@else
    John Doe
    @endif!
            </span> 🎉</h4>
                        <p class="mb-0">Personal del organismo certificador cidam</p><br>
                        <a href="javascript:;" class="btn btn-primary">Ver pendientes</a>
                      </div>
                    </div>
                    <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                      <div class="card-body pb-0 px-0 pt-2">
                        <img src="{{ asset('assets/img/illustrations/illustration-john-' . $configData['style'] . '.png') }}" height="186" class="scaleX-n1-rtl" alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png" data-app-dark-img="illustrations/illustration-john-dark.png">
                        <img  height="186" class="scaleX-n1-rtl" alt="View Profile" src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}" >
                      </div>
                    </div>
                  </div>
                </div>
              </div>-->
        <!--/ Gamification Card -->

        <!-- Statistics Total Order -->
        <!--  <div class="col-xxl-2 col-sm-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                      <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded-3">
                          <i class="ri-shopping-cart-2-line ri-24px"></i>
                        </div>
                      </div>
                      <div class="d-flex align-items-center">
                        <p class="mb-0 text-success me-1">+22%</p>
                        <i class="ri-arrow-up-s-line text-success"></i>
                      </div>
                    </div>
                    <div class="card-info mt-5">
                      <h5 class="mb-1">50</h5>
                      <p>Certificados de exportación</p>
                      <div class="badge bg-label-secondary rounded-pill">Último mes</div>
                    </div>
                  </div>
                </div>
              </div>-->
        <!--/ Statistics Total Order -->

        <!-- Sessions line chart -->
        <!--<div class="col-xxl-2 col-sm-6">
                <div class="card h-100">
                  <div class="card-header pb-0">
                    <div class="d-flex align-items-center mb-1 flex-wrap">
                      <h5 class="mb-0 me-1">$38.5k</h5>
                      <p class="mb-0 text-success">+62%</p>
                    </div>
                    <span class="d-block card-subtitle">Sessions</span>
                  </div>
                  <div class="card-body">
                    <div id="sessions"></div>
                  </div>
                </div>
              </div>-->
        <!--/ Sessions line chart -->

        <div class="row my-2">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="row g-0 align-items-center">
                        <!-- Texto de bienvenida -->
                        <div class="col-md-4 p-4">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    👋 Bienvenido a la nueva Plataforma
                                </h4>
                                <h5 class="fw-bold text-primary mb-2">
                                    @if (Auth::check())
                                        {{ Auth::user()->name }}
                                    @else
                                        Sin usuario logeado
                                    @endif
                                </h5>
                                <p class="text-muted fs-5">
                                    @if (Auth::check() && Auth::user()->puesto)
                                        {{ Auth::user()->puesto }}
                                    @elseif(Auth::user()->empresa)
                                        {{ Auth::user()->empresa->razon_social }}
                                    @else
                                        Miembro del consejo
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Imagen decorativa -->
                        <div class="col-md-8 text-center d-none d-md-block">
                            <div class="swiper text-white" id="swiper-with-arrows">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide"
                                        style="background-image:url({{ asset('assets/img/pages/header3.png') }})"></div>
                                    <div class="swiper-slide"
                                        style="background-image:url({{ asset('assets/img/elements/1.jpg') }})">Slide 2</div>
                                </div>
                                <div class="swiper-button-next swiper-button-white custom-icon">
                                </div>
                                <div class="swiper-button-prev swiper-button-white custom-icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <div class="row g-6">
            @can('Estadísticas ui')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-primary"><i
                                            class="ri-group-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $solicitudesSinInspeccion }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de asignar inspector</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#modalSolicitudesSinActa">  
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-list-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $solicitudesSinActa->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de subir acta</h6>

                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#modalSolicitudesSinActa">  
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-list-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $lotesSinFq->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Lotes pendientes de subir FQ</h6>
                            
                        </div>
                    </div>
                </div>
            @endcan




            @can('Estadísticas ui')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-border-shadow-danger h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger"><i
                                            class="ri-close-circle-fill ri-24px"></i></span>
                                </div>
                                <h5 class="mb-0">

                                    @foreach ($dictamenesPorVencer as $dictamen)
                                        {{ $dictamen->num_dictamen }} <small
                                            class="text-muted">{{ $dictamen->fecha_vigencia }}</small> <br>
                                    @endforeach
                                </h5>
                            </div>
                            <h6 class="mb-0 fw-normal">Dictámenes por vencer</h6>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Estadísticas oc')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#modalDictamenesInstalacionesPendientes">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger"><i
                                            class="ri-file-warning-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $dictamenesInstalacionesSinCertificado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de crear certificado de instalaciones</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#modalDictamenesGranelPendientes">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger"><i
                                            class="ri-file-warning-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $dictamenesGranelesSinCertificado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de crear certificado de graneles</h6>
                            <hr>
                            <!-- BOTÓN o DIV CLICKABLE para abrir el modal -->
                    <div class="d-flex align-items-center mb-2 cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#modalDictamenesExportacionPendientes">
                        <div class="avatar me-4">
                            <span class="avatar-initial rounded-3 bg-label-danger">
                                <i class="ri-file-warning-line ri-24px"></i>
                            </span>
                        </div>
                        <h4 class="mb-0">{{ $dictamenesExportacionSinCertificado->count() }}</h4>
                    </div>
                    <h6 class="mb-0 fw-normal">Pendiente de crear certificado de exportación</h6>

                        </div>
                    </div>
                </div>
            @endcan

            @can('Estadísticas oc')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-border-shadow-info h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger"><i
                                            class='ri-close-circle-fill ri-24px'></i></span>
                                </div>
                                <h5 class="mb-0">

                                    @foreach ($certificadosPorVencer as $certificado)
                                        {{ $certificado->num_certificado }} <small
                                            class="text-muted">{{ $certificado->fecha_vigencia }}</small> <br>
                                    @endforeach

                                </h5>
                            </div>
                            <h6 class="mb-0 fw-normal">Certificados por vencer</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#modalSolicitudesSinActa">  
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-list-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $certificadoGranelSinEscaneado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Certificados pendientes de subir escaneado</h6>
                            <p class="mb-0">
                                <!--<span class="me-1 fw-medium">-2.5%</span>
                                    <small class="text-muted">than last week</small>-->
                            </p>
                        </div>
                    </div>
                </div>
            @endcan
            @can('Estadísticas ui')
            <div class="col-md-6 col-xxl-3">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Inspecciones por inspector 2025</h5>
                        <div class="dropdown">
                            <!-- <button class="btn text-body-secondary p-0" type="button" id="meetingSchedule" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base ri ri-more-2-line"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="meetingSchedule">
                <a class="dropdown-item waves-effect" href="javascript:void(0);">Last 28 Days</a>
                <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Month</a>
                <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Year</a>
              </div>-->
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">

                            @foreach ($inspeccionesInspector as $inspector)
                                <li class="d-flex align-items-center mb-4 pb-2">
                                    <div class="avatar flex-shrink-0 me-4">
                                        <img src="{{ asset('storage/' . $inspector['foto']) }}"
                                            alt="Foto de {{ $inspector['nombre'] }}" class="rounded-3" width="50">
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $inspector['nombre'] }}</h6>
                                            <small class="d-flex align-items-center">
                                                <!-- <i class="icon-base ri ri-calendar-line icon-16px"></i>
                      <span class="ms-2">21 Jul | 08:20-10:30</span>-->
                                            </small>
                                        </div>
                                        <div class="badge bg-label-primary rounded-pill">
                                            {{ $inspector['total_inspecciones'] }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endcan
            @can('Estadísticas oc')
                <!-- Line Chart -->
                <div class="col-6 mb-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">Certificados emitidos por mes</h5>
                                <div class="mb-0">
                                    <label for="selectAnio" class="form-label">Selecciona un año:</label>
                                    <select id="selectAnio" class="form-select w-auto">
                                        @for ($i = now()->year; $i >= 2022; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="lineChart"></div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('Estadísticas ui')
                <!-- Line Chart -->
                <div class="col-6 mb-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">Servicios realizados por mes</h5>
                                <div class="mb-0">
                                    <label for="selectAnio2" class="form-label">Selecciona un año:</label>
                                    <select id="selectAnio2" class="form-select w-auto">
                                        @for ($i = now()->year; $i >= 2022; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="lineChart2"></div>
                        </div>
                    </div>
                </div>
            @endcan
            
        </div>

<!-- Modal -->
<div class="modal fade" id="modalDictamenesExportacionPendientes" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Dictámenes sin certificado de exportación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        @if($dictamenesExportacionSinCertificado->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Inspector</th>
                            <th>Dictamen</th>
                            <!--<th>Acciones</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dictamenesExportacionSinCertificado as $dictamen)
                            <tr>
                                <td>{{ $dictamen->num_dictamen }}</td>
                                <td>{{ $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($dictamen->fecha_emision)->format('d/m/Y') }}</td>
                                <td>{{ $dictamen->firmante->name ?? 'N/A' }}</td>
                                <th><a target="_Blank" href="/dictamen_exportacion/{{ $dictamen->id_dictamen }}"><i class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i></a></th>
                                <!--<td>
                                    <a href="" class="btn btn-sm btn-primary" target="_blank">
                                        Ver
                                    </a>
                                </td>-->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No hay dictámenes pendientes.</p>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDictamenesGranelPendientes" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Dictámenes sin certificado de Granel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        @if($dictamenesGranelesSinCertificado->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Inspector</th>
                            <th>Dictamen</th>
                            <!--<th>Acciones</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dictamenesGranelesSinCertificado as $dictamen)
                            <tr>
                                <td>{{ $dictamen->num_dictamen }}</td>
                                <td>{{ $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($dictamen->fecha_emision)->format('d/m/Y') }}</td>
                                <td>{{ $dictamen->inspeccione->inspector->name ?? 'N/A' }}</td>
                                <th><a target="_Blank" href="/dictamen_granel/{{ $dictamen->id_dictamen }}"><i class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i></a></th>
                                <!--<td>
                                    <a href="" class="btn btn-sm btn-primary" target="_blank">
                                        Ver
                                    </a>
                                </td>-->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No hay dictámenes pendientes.</p>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDictamenesInstalacionesPendientes" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Dictámenes sin certificado de Instalaciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        @if($dictamenesInstalacionesSinCertificado->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Inspector</th>
                            <th>Dictamen</th>
                            <!--<th>Acciones</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dictamenesInstalacionesSinCertificado as $dictamen)
                            <tr>
                                <td>{{ $dictamen->num_dictamen }}</td>
                                <td>{{ $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($dictamen->fecha_emision)->format('d/m/Y') }}</td>
                                <td>{{ $dictamen->inspeccione->inspector->name ?? 'N/A' }}</td>
                                @php
                                    if($dictamen->tipo_dictamen == 1){
                                        $pdf_dictamen = "/dictamen_productor/". $dictamen->id_dictamen;
                                    }

                                    if($dictamen->tipo_dictamen == 2){
                                        $pdf_dictamen = "/dictamen_envasador/".$dictamen->id_dictamen;
                                    }

                                    if($dictamen->tipo_dictamen == 3){
                                        $pdf_dictamen = "/dictamen_comercializador/".$dictamen->id_dictamen;
                                    } 

                                    if($dictamen->tipo_dictamen == 4){
                                        $pdf_dictamen = "/dictamen_almacen/".$dictamen->id_dictamen;
                                    }
                                @endphp
                                <th><a target="_Blank" href="{{ $pdf_dictamen }}"><i class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i></a></th>
                                <!--<td>
                                    <a href="" class="btn btn-sm btn-primary" target="_blank">
                                        Ver
                                    </a>
                                </td>-->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No hay dictámenes pendientes.</p>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSolicitudesSinActa" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Solicitudes pendientes de subir acta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        @if($solicitudesSinActa->count())
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Tipo</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Inspector</th>
                            <!--<th>Acciones</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudesSinActa as $solicitud)
                            <tr>
                                <td>{{ $solicitud->folio }}</td>
                                <td>{{ $solicitud->tipo_solicitud->tipo }}</td>
                                <td>{{ $solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}</td>
                                <td>{{ $solicitud->inspeccion->inspector->name ?? 'Sin asignar' }}</td>
                                <!--<td>
                                    <a href="" class="btn btn-sm btn-primary" target="_blank">
                                        Ver
                                    </a>
                                </td>-->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No hay dictámenes pendientes.</p>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


    @endsection
