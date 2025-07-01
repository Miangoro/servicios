@php
    $configData = Helper::appClasses();
    $isMenu = false;
    $navbarHideToggle = false;
    $isNavbar = false;

@endphp

@extends('layouts.layoutMaster')

@section('title', 'Solicitud de información del cliente')


<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss', 'resources/assets/vendor/fonts/personalizados/style.css', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])

    <!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/jquery/jquery.js', /* 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js', */ 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js'])
@section('content')

    <style>
        body {
            background-image: url(assets/img/branding/fondo.png);
        }

        .bs-stepper-header {
            background-color: #0c1444;
            color: white;
        }

        .bs-stepper .step-trigger {
            color: white;
        }

        .light-style .bs-stepper.wizard-icons .bs-stepper-header .bs-stepper-label {
            color: white;
        }

        .custom-option.active {
            border: 2px solid #8eb3ae;
            /* El color del borde usa la variable definida */
        }
    </style>
    <div class="card">
        <img alt="Organismo de certificación" src="{{ asset('assets/img/branding/Banner solicitud_información.png') }}"
            alt="timeline-image" class="card-img-top " style="object-fit: cover;">
        <div class="bs-stepper wizard-icons wizard-icons-example">


            <div class="bs-stepper-header">
                <div class="step" data-target="#account-details">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <i class="ri-user-fill fs-1"></i>
                        </span>
                        <span class="bs-stepper-label">Información del cliente</span>
                    </button>
                </div>
                <div class="line">
                    <i class="ri-arrow-right-s-line"></i>
                </div>
                <div class="step" data-target="#social-links">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <i class="icon-produto-certificado fs-1"></i>
                        </span>
                        <span class="bs-stepper-label">Producto a certificar</span>
                    </button>
                </div>
                <div class="line">
                    <i class="ri-arrow-right-s-line"></i>
                </div>
                <div class="step" data-target="#address">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <i class="ri-map-pin-fill fs-1"></i>
                        </span>
                        <span class="bs-stepper-label">Dirección</span>
                    </button>
                </div>
                <div class="line">
                    <i class="ri-arrow-right-s-line"></i>
                </div>
                <div class="step" data-target="#personal-info-icon">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <i class="ri-information-2-fill fs-2"></i>
                        </span>
                        <span class="bs-stepper-label">Información del producto</span>
                    </button>
                </div>
            </div>


            <div class="bs-stepper-content">
                <form action="{{ url('/solicitud-cliente-registrar') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <!-- información del cliente -->
                    <div id="account-details" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Información del cliente</h6>
                            <small>información del cliente.</small>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control" name="regimen" id="regimen">
                                        <option value="Persona física">Persona física</option>
                                        <option value="Persona moral">Persona moral</option>
                                    </select>
                                    <label for="username">Régimen fiscal</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input maxlength="13" type="text" name="rfc" class="form-control"
                                        placeholder="Introduce el RFC" required />
                                    <label for="username">RFC</label>
                                </div>
                            </div>
                            <div style="display: none" id="representante" class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input id="nombreRepresentante" type="text" name="representante" class="form-control"
                                        placeholder="Introduce el nombre del representante legal" />
                                    <label for="username">Representante legal</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="username" name="razon_social" class="form-control"
                                        placeholder="Introduce tu nombre completo" required />
                                    <label for="username">Nombre del cliente/empresa</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" id="email" name="correo" class="form-control"
                                        placeholder="Introduce tu correo electrónico" aria-label="john.doe" required />
                                    <label for="email">Correo Electrónico</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="telefono" name="telefono"
                                        class="form-control phone-number-mask"
                                        placeholder="Introduce tu numero de teléfono" required
                                        title="El teléfono debe tener 10 dígitos numéricos." />
                                    <label for="username">Teléfono</label>
                                </div>
                            </div>
                            <hr>
                            <!-- botones  -->
                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-danger btn-prev" disabled> <i
                                        class="ri-arrow-left-line me-sm-1"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next"> <span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span> <i
                                        class="ri-arrow-right-line"></i></button>
                            </div>
                        </div>

                    </div>

                    <!-- Social Links Producto que se va a certificar-->
                    <div id="social-links" class="content">
                        <!-- 1. Delivery Type -->
                        <h6>Producto(s) que se va a certificar</h6>
                        <div class="row gy-3 align-items-start">
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                        <span class="custom-option-body">
                                            <i class="icon-mezcal fs-1"></i>
                                            <small>Mezcal.</small>
                                        </span>
                                        <input name="producto[]" value="1" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon1" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon2">
                                        <span class="custom-option-body">
                                            <i class="icon-bebida-mezcal"></i>
                                            <small>Bebida preparada con Mezcal</small>
                                        </span>
                                        <input name="producto[]" value="2" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon2" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon3">
                                        <span class="custom-option-body">
                                            <i class="ri-goblet-fill"></i>
                                            <small>Cóctel que contiene Mezcal</small>
                                        </span>
                                        <input name="producto[]" value="3" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon3" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon4">
                                        <span class="custom-option-body">
                                            <i class="icon-licor"></i>
                                            <small>Licor y/o crema que contiene Mezcal</small>
                                        </span>
                                        <input name="producto[]" value="4" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon4" />
                                    </label>
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon65">
                                        <span class="custom-option-body">
                                            <i class="ri-goblet-2-fill"></i>
                                            <small>Otras bebidas alcoholicas</small>
                                        </span>
                                        <input name="producto[]" value="5" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon65" />
                                    </label>
                                </div>
                            </div>

                        </div>
                        <hr>

                        <!-- 2. Delivery Type -->
                        <h6 class="my-4">Documentos normativos para los cuales busca la certificación:</h6>
                        <div class="row gy-3 align-items-start">
                            <div class="col-md">
                                <div class=" custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon5">
                                        <span class="custom-option-body">
                                            <small>NOM-070-SCFI-2016</small>
                                        </span>
                                        <input name="norma[]" class="form-check-input" type="checkbox" value="1"
                                            id="customRadioIcon5" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class=" custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon6">
                                        <span class="custom-option-body">
                                            <small>NOM-251-SSA1-2009</small>
                                        </span>
                                        <input name="norma[]" class="form-check-input" type="checkbox" value="2"
                                            id="customRadioIcon6" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class=" custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon7">
                                        <span class="custom-option-body">
                                            <small>NMX-V-052-NORMEX-2016</small>
                                        </span>
                                        <input name="norma[]" class="form-check-input" type="checkbox" value="3"
                                            id="customRadioIcon7" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class=" custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon68">
                                        <span class="custom-option-body">
                                            <small>NOM-199-SCFI-2017</small>
                                        </span>
                                        <input name="norma[]" class="form-check-input" type="checkbox" value="4"
                                            id="customRadioIcon68" />
                                    </label>
                                </div>
                            </div>


                        </div>
                        <hr>
                        {{-- secciones ocultas --}}
                        <div id="nom070-section" style="display: none;">
                            <h6 class="my-4">Actividad del cliente NOM-070-SCFI-2016:</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon8">
                                            <span class="custom-option-body">
                                                <i class="icon-agave"></i>
                                                <small>Productor de Agave</small>
                                            </span>
                                            <input name="actividad[]" class="form-check-input" type="checkbox"
                                                value="1" id="customRadioIcon8" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon9">
                                            <span class="custom-option-body">
                                                <i class="icon-envasador"></i>
                                                <small>Envasador de Mezcal</small>
                                            </span>
                                            <input name="actividad[]" class="form-check-input" type="checkbox"
                                                value="2" id="customRadioIcon9" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon10">
                                            <span class="custom-option-body">
                                                <i class="icon-productor-tequila"></i>
                                                <small>Productor de Mezcal</small>
                                            </span>
                                            <input name="actividad[]" class="form-check-input" type="checkbox"
                                                value="3" id="customRadioIcon10" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon11">
                                            <span class="custom-option-body">
                                                <i class="icon-comercializador"></i>
                                                <small>Comercializador de Mezcal</small>
                                            </span>
                                            <input name="actividad[]" class="form-check-input" type="checkbox"
                                                value="4" id="customRadioIcon11" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        {{-- secciones ocultas --}}
                        <div id="nom199-section" class="d-none">
                            <h6 class="my-4">Clasificación de Bebida(s) Alcohólica(s):</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon20">
                                            <span class="custom-option-body">
                                                <i class="ri-beer-fill"></i>
                                                <small>Bebidas
                                                    Alcohólicas
                                                    Fermentadas
                                                    (2% a 20% Alc.
                                                    Vol.)</small>
                                            </span>
                                            <input name="clasificacion[]" class="form-check-input" type="checkbox"
                                                value="1" id="customRadioIcon20" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon21">
                                            <span class="custom-option-body">
                                                <i class="ri-goblet-fill"></i>
                                                <small>Bebidas
                                                    Alcohólicas
                                                    Destiladas (32%
                                                    a 55% Alc. Vol.)</small>
                                            </span>
                                            <input name="clasificacion[]" class="form-check-input" type="checkbox"
                                                value="2" id="customRadioIcon21" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon22">
                                            <span class="custom-option-body">
                                                <i class="ri-goblet-fill"></i>
                                                <small>Licores o
                                                    cremas (13.5%
                                                    a 55% Alc. Vol.)</small>
                                            </span>
                                            <input name="clasificacion[]" class="form-check-input" type="checkbox"
                                                value="3" id="customRadioIcon22" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon23">
                                            <span class="custom-option-body">
                                                <i class="ri-goblet-2-fill"></i>
                                                <small>Bebidas
                                                    Alcohólicas
                                                    Destiladas
                                                    (32% a 55%
                                                    Alc. Vol.)</small>
                                            </span>
                                            <input name="clasificacion[]" class="form-check-input" type="checkbox"
                                                value="4" id="customRadioIcon23" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon24">
                                            <span class="custom-option-body">
                                                <i class="ri-goblet-fill"></i>
                                                <small>Cócteles (12%
                                                    a 32% Alc.
                                                    Vol.)
                                                </small>
                                            </span>
                                            <input name="clasificacion[]" class="form-check-input" type="checkbox"
                                                value="5" id="customRadioIcon24" />
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon25">
                                            <span class="custom-option-body">
                                                <i class="ri-goblet-fill"></i>
                                                <small>Bebidas alcohólicas preparadas (2% a 12% Alc. Vol.)
                                                </small>
                                            </span>
                                            <input name="clasificacion[]" class="form-check-input" type="checkbox"
                                                value="6" id="customRadioIcon25" />
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <hr>
                        </div>


                        {{-- Sección de Clasificación de Bebidas Alcohólicas --}}
                        <div id="clasificacion-bebidas-section" class="d-none">
                            <h6 class="my-4">Bebidas Alcohólicas Fermentadas (2% a 20% Alc. Vol.)</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon26">
                                            <span class="custom-option-body">
                                                <small>Cerveza</small>
                                            </span>
                                            <input name="bebida[1][]" class="form-check-input" type="checkbox"
                                                value="Cerveza" id="customRadioIcon26" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon27">
                                            <span class="custom-option-body">
                                                <small>_____Ale</small>
                                            </span>
                                            <input name="bebida[1][]" class="form-check-input" type="checkbox"
                                                value="_____Ale" id="customRadioIcon27" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon28">
                                            <span class="custom-option-body">
                                                <small>Pulque</small>
                                            </span>
                                            <input name="bebida[1][]" class="form-check-input" type="checkbox"
                                                value="pulque" id="customRadioIcon28" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon29">
                                            <span class="custom-option-body">
                                                <small>Sake</small>
                                            </span>
                                            <input name="bebida[1][]" class="form-check-input" type="checkbox"
                                                value="sake" id="customRadioIcon29" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon30">
                                            <span class="custom-option-body">
                                                <small>Sidra</small>
                                            </span>
                                            <input name="bebida[1][]" class="form-check-input" type="checkbox"
                                                value="Sidra" id="customRadioIcon30" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon31">
                                            <span class="custom-option-body">
                                                <small>Vino</small>
                                            </span>
                                            <input name="bebida[1][]" class="form-check-input" type="checkbox"
                                                value="vino" id="customRadioIcon31" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon32">
                                            <span class="custom-option-body">
                                                <small>Otro (Especifique):</small>
                                            </span>
                                            <input class="form-check-input" type="checkbox" id="customRadioIcon32" />
                                        </label>
                                    </div>
                                    <!-- Campo de texto para especificar -->
                                    <div id="otroBebidaInput" class="mt-2" style="display: none;">
                                        <input type="text" name="bebida[1][]" class="form-control"
                                            placeholder="Especifique la bebida o producto">
                                    </div>

                                </div>
                            </div>
                            <hr>
                        </div>



                        {{-- Sección de Clasificación de Bebidas Alcohólicas --}}
                        <div id="clasificacion-bebidas-section-2" class="d-none">
                            <h6 class="my-4">Bebidas Alcohólicas Destiladas (32% a 55% Alc. Vol.)</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon33">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Aguardiente</small>
                                            </span>
                                            <input name="bebida[2][]" class="form-check-input" type="checkbox"
                                                value="Aguardiente" id="customRadioIcon33" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon34">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Armagnac</small>
                                            </span>
                                            <input name="bebida[2][]" class="form-check-input" type="checkbox"
                                                value="Armagnac" id="customRadioIcon34" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon35">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Bacanora</small>
                                            </span>
                                            <input name="bebida[2][]" class="form-check-input" type="checkbox"
                                                value="Bacanora" id="customRadioIcon35" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon36">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Brandy</small>
                                            </span>
                                            <input name="bebida[2][]" class="form-check-input" type="checkbox"
                                                value="Brandy" id="customRadioIcon36" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon37">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Cachaca</small>
                                            </span>
                                            <input name="bebida[2][]" class="form-check-input" type="checkbox"
                                                value="Cachaca" id="customRadioIcon37" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon38">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Comiteco</small>
                                            </span>
                                            <input name="bebida[2][]" class="form-check-input" type="checkbox"
                                                value="Comiteco" id="customRadioIcon38" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon39">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Ginebra</small>
                                            </span>
                                            <input name="bebida[2][]" class="form-check-input" type="checkbox"
                                                value="Ginebra" id="customRadioIcon39" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        {{-- Sección de Clasificación de Bebidas Alcohólicas --}}
                        <div id="clasificacion-bebidas-section-3" class="d-none">
                            <h6 class="my-4">Licores o cremas (13.5% a 55% Alc. Vol.)</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon40">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Anís</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Anis" id="customRadioIcon40" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon41">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Amaretto</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Amaretto" id="customRadioIcon41" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon42">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Crema o licor de cassis</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Crema o licor de cassis" id="customRadioIcon42" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon43">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Crema o licor de café</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Crema o licor de café" id="customRadioIcon43" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon44">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Crema o licor de cacao</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Crema o licor de cacao" id="customRadioIcon44" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon45">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Crema o licor de menta</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Crema o licor de menta" id="customRadioIcon45" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon46">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Fernet</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Fernet" id="customRadioIcon46" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon47">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Irish cream</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Irish cream" id="customRadioIcon47" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon48">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Licor amargo</small>
                                            </span>
                                            <input name="bbebida[3][]" class="form-check-input" type="checkbox"
                                                value="Licor amargo" id="customRadioIcon48" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon49">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Licores de frutas</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Licores de frutas" id="customRadioIcon49" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon50">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Sambuca</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Sambuca" id="customRadioIcon50" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon51">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Xtabentún</small>
                                            </span>
                                            <input name="bebida[3][]" class="form-check-input" type="checkbox"
                                                value="Xtabentun" id="customRadioIcon51" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon52">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Otro (Especifique):</small>
                                            </span>
                                            <input class="form-check-input" type="checkbox" id="customRadioIcon52" />
                                        </label>
                                    </div>

                                    <!-- Campo de texto para especificar -->
                                    <div id="otroBebidaInput52" class="mt-2" style="display: none;">
                                        <input type="text" name="bebida[3][]" class="form-control"
                                            placeholder="Especifique la bebida o producto">
                                    </div>

                                </div>
                            </div>
                            <hr>
                        </div>



                        {{-- Sección de Clasificación de Bebidas Alcohólicas --}}
                        <div id="clasificacion-bebidas-section-4" class="d-none">
                            <h6 class="my-4">Bebidas Alcohólicas Destiladas (32% a 55% Alc. Vol.)</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon53">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Kirsch</small>
                                            </span>
                                            <input name="bebida[4][]" class="form-check-input" type="checkbox"
                                                value="Kirsch<" id="customRadioIcon53" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon54">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Poire o Perry</small>
                                            </span>
                                            <input name="bebida[4][]" class="form-check-input" type="checkbox"
                                                value="Poire o Perry" id="customRadioIcon54" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon55">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Ron</small>
                                            </span>
                                            <input name="bebida[4][]" class="form-check-input" type="checkbox"
                                                value="Ron" id="customRadioIcon55" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon56">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Raicilla</small>
                                            </span>
                                            <input name="bebida[4][]" class="form-check-input" type="checkbox"
                                                value="Raicilla" id="customRadioIcon56" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon57">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Sambuca</small>
                                            </span>
                                            <input name="bebida[4][]" class="form-check-input" type="checkbox"
                                                value="Sambuca" id="customRadioIcon57" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon58">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Sotol</small>
                                            </span>
                                            <input name="bebida[4][]" class="form-check-input" type="checkbox"
                                                value="Sotol" id="customRadioIcon58" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon59">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Vodka</small>
                                            </span>
                                            <input name="bebida[4][]" class="form-check-input" type="checkbox"
                                                value="Vodka" id="customRadioIcon59" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon60">
                                            <span class="custom-option-body">
                                                <i class="ri-wine-fill"></i>
                                                <small>Whisky o Whiskey</small>
                                            </span>
                                            <input name="bebida[4][]" class="form-check-input" type="checkbox"
                                                value="Whisky o Whiskey" id="customRadioIcon60" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        {{-- Sección de Clasificación de Cócteles --}}
                        <div id="clasificacion-cocteles-section-5" class="d-none">
                            <h6 class="my-4">Cócteles (12% a 32% Alc. Vol.)</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-floating form-floating-outline">
                                        <input name="bebida[5][]" class="form-control" type="text" id="inputCoctel61"
                                            placeholder="Cóctel de" />
                                        <label for="inputCoctel61"><small>Cóctel de</small></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating form-floating-outline">
                                        <input name="bebida[5][]" class="form-control" type="text" id="inputCoctel62"
                                            placeholder="Cóctel sabor de" />
                                        <label for="inputCoctel62"><small>Cóctel sabor de</small></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating form-floating-outline">
                                        <input name="bebida[5][]" class="form-control" type="text" id="inputCoctel63"
                                            placeholder="Cóctel de o al" />
                                        <label for="inputCoctel63"><small>Cóctel de o al</small></label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating form-floating-outline">
                                        <input name="bebida[5][]" class="form-control" type="text" id="inputCoctel64"
                                            placeholder="Cóctel con" />
                                        <label for="inputCoctel64"><small>Cóctel con</small></label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        {{-- Sección de Clasificación de Bebidas Alcohólicas Preparadas --}}
                        <div id="clasificacion-bebidas-section-6" class="d-none">
                            <h6 class="my-4">Bebidas alcohólicas preparadas (2% a 12% Alc. Vol.)</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-floating form-floating-outline">

                                        <input name="bebida[6][]" class="form-control" type="text" id="inputBebida65"
                                            placeholder="Bebida alcohólica preparada de" />
                                        <label for="inputBebida65" class="custom-option-body"><small>Bebida alcohólica
                                                preparada de</small></label>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <div class="form-floating form-floating-outline">
                                        <input name="bebida[6][]" class="form-control" type="text" id="inputBebida66"
                                            placeholder="Bebida alcohólica preparada de o al" />
                                        <label for="inputBebida66">
                                            <small>Bebida alcohólica preparada de o al</small>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md">
                                    <div class="form-floating form-floating-outline">
                                        <input name="bebida[6][]" class="form-control" type="text" id="inputBebida67"
                                            placeholder="Bebida alcohólica preparada sabor de" />
                                        <label for="inputBebida67">
                                            <small>Bebida alcohólica preparada sabor de</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating form-floating-outline">
                                        <input name="bebida[6][]" class="form-control" type="text" id="inputBebida68"
                                            placeholder="Bebida alcohólica preparada con" />
                                        <label for="inputBebida68">
                                            <small>Bebida alcohólica preparada con</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        {{-- fin de la secciones ocultas --}}
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-danger btn-prev">
                                <i class="ri-arrow-left-line me-sm-1"></i>
                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none">Siguiente</span>
                                <i class="ri-arrow-right-line"></i>
                            </button>
                        </div>
                    </div>


                    {{-- direccion --}}
                    <div id="address" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Domicilio Fiscal</h6>
                            <small>Ingrese los datos del primer domicilio fiscal</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="localidad1" name="domicilio_fiscal"
                                        required placeholder=" ">
                                    <label for="localidad1">Domicilio completo</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control select2" name="estado_fiscal" id="estado" required>
                                        <option disabled selected value="">selecciona un estado</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                                        @endforeach
                                    </select>
                                    <label for="estado">Estado</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 offset-md-6 d-flex justify-content-end align-items-center flex-column">
                                <div class="text-light small fw-medium mb-2">Seleccionar</div>
                                <label class="switch">
                                    <input type="checkbox" class="switch-input" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                    <span class="switch-label">Usar la misma dirección fiscal</span>
                                </label>
                            </div>
                        </div>
                        <hr>
                        {{-- se generan las direcciones --}}

                        <div id="domiProductAgace" style="display: none;">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Domicilio de Productor de Agave:</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="localidad2" name="localidad2"
                                            placeholder=" ">
                                        <label for="localidad2">Domicilio completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control custom-select" name="estado2" id="estado2">
                                            <option disabled selected>selecciona un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                                            @endforeach
                                        </select>
                                        <label for="estado2">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        <div id="domiEnvasaMezcal" style="display: none;">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Domicilio de Envasador de Mezcal:</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="localidad3"
                                            name="domicilio_envasadora" placeholder=" ">
                                        <label for="localidad3">Domicilio completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control custom-select" name="estado_envasadora"
                                            id="estado3">
                                            <option disabled selected>selecciona un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                                            @endforeach
                                        </select>
                                        <label for="estado3">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        <div id="domiProductMezcal" style="display: none;">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Domicilio de Productor de Mezcal:</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="localidad4"
                                            name="domicilio_productora" placeholder=" ">
                                        <label for="localidad4">Domicilio completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control custom-select" name="estado_productora"
                                            id="estado4">
                                            <option disabled selected>selecciona un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                                            @endforeach
                                        </select>
                                        <label for="estado4">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div id="domiComerMezcal" style="display: none;">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Domicilio de Comercializador de Mezcal:</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="localidad5"
                                            name="domicilio_comercializadora" placeholder=" ">
                                        <label for="localidad5">Domicilio completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control custom-select" name="estado_comercializadora"
                                            id="estado5">
                                            <option disabled selected>selecciona un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                                            @endforeach
                                        </select>
                                        <label for="estado5">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        {{--  --}}

                        <div class="col-12 d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-danger btn-prev">
                                <i class="ri-arrow-left-line me-sm-1"></i>
                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none">Siguiente</span>
                                <i class="ri-arrow-right-line"></i>
                            </button>
                        </div>
                    </div>


                    <!-- Información sobre los Procesos y productos a certificar por el cliente -->
                    <div id="personal-info-icon" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Información sobre los Procesos y productos a certificar por el cliente</h6>
                        </div>
                        <div class="row g-5">
                            <div class="col-4">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control" id="certificacion" name="certificacion"
                                        aria-label="¿Cuenta con una Certificación de Sistema de Gestión de Calidad?">
                                        <option  disabled selected value="">¿Cuenta con una Certificación de Sistema
                                            de Gestión de Calidad?</option>
                                        <option value="si">Sí</option>
                                        <option value="no">No</option>
                                    </select>
                                    <label for="certificacion">¿Cuenta con una Certificación de Sistema de Gestión de
                                        Calidad?</label>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="¿Cual?" name="¿Cual?"
                                        autocomplete="off" placeholder="¿Cual?">
                                    <label for="¿Cual?">¿Cual?</label>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="emiteCertificacion"
                                        name="emiteCertificacion" autocomplete="off"
                                        placeholder="¿Quién emite Certificación?">
                                    <label for="¿Quién emite Certificación?">¿Quién emite Certificación?</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-5 mt-3">
                            <div class="col-12">
                                <div class="form-floating form-floating-outline mb-6">
                                    <textarea maxlength="2000" class="form-control h-px-100" id="certification-details" name="info_procesos" required
                                        placeholder=""></textarea>
                                    <label for="certification-details">Describa los procesos y productos a
                                        certificar</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- botones  -->
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-danger btn-prev"> <i
                                    class="ri-arrow-left-line me-sm-1"></i>
                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <button class="btn btn-primary btn-submit">Enviar solicitud</button>
                        </div>
                        <!--   -->
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection

@section('page-script')

    @vite(['resources/assets/vendor/libs/cleavejs/cleave.js'])
    @vite(['resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
    @vite(['resources/assets/js/solicitud-cliente.js'])
