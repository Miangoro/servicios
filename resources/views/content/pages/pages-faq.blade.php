@extends('layouts/layoutMaster')
@php
  $configData = Helper::appClasses();
@endphp

@section('title', 'FAQ - Pages')

<!-- Page -->
@section('page-style')
@vite('resources/assets/vendor/scss/pages/page-faq.scss')
@endsection

@section('content')
<div class="faq-header d-flex flex-column justify-content-center align-items-center h-px-300 position-relative overflow-hidden rounded-4">
  <img src="{{asset('assets/img/pages/header-'.$configData['style'].'.png')}}" class="scaleX-n1-rtl faq-banner-img h-px-300 z-n1" alt="background image" data-app-light-img="pages/header3.png" data-app-dark-img="pages/header-dark.png"/>
  <h4 class="text-center text-primary mb-2">  </h4>
  <p class="text-body text-center mb-0 px-4"></p>
  
</div>

<div class="row mt-6">
  <!-- Navigation -->
  <div class="col-lg-3 col-md-4 col-12 mb-md-0 mb-4">
    <div class="d-flex justify-content-between flex-column nav-align-left mb-2 mb-md-0">
      <ul class="nav nav-pills flex-column flex-nowrap">
        <li class="nav-item">
          <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment">
            <i class="ri-file-list-3-line"></i>
            <span class="align-middle">Certificación</span>
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#delivery">
            <i class="ri-file-text-line"></i>
            <span class="align-middle">Requisitos para el proceso</span>
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#cancellation">
            <i class="ri-refresh-line me-2"></i>
            <span class="align-middle">Proceso de certificación</span>
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#orders">
            <i class="ri-money-dollar-circle-line"></i>
            <span class="align-middle">Costos y documentación</span>
          </button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#product">
            <i class="ri-file-check-line"></i>
            <span class="align-middle">Post-certificación</span>
          </button>
        </li>
      </ul>
      <div class="d-none d-md-block">
        <div class="mt-4 text-center">
          <img src="{{asset('assets/img/illustrations/faq-illustration.png')}}" class="img-fluid" width="135" alt="FAQ Image">
        </div>
      </div>
    </div>
  </div>
  <!-- /Navigation -->

  <!-- FAQ's -->
  <div class="col-lg-9 col-md-8 col-12">
    <div class="tab-content p-0">
      <div class="tab-pane fade show active" id="payment" role="tabpanel">
        <div class="d-flex mb-4 gap-4">
          <div class="avatar avatar-md">
            <div class="avatar-initial bg-label-primary rounded-4">
              <i class="ri-file-list-3-line ri-30px"></i>
            </div>
          </div>
          <div>
            <h5 class="mb-0">
              <span class="align-middle">Certificación</span>
            </h5>
            <span>Informacion General</span>
          </div>
        </div>
        <div id="accordionPayment" class="accordion">
          <div class="accordion-item active">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionPayment-1" aria-controls="accordionPayment-1">
              ¿Qué es la certificación de mezcal?
              </button>
            </h2>

            <div id="accordionPayment-1" class="accordion-collapse collapse show">
              <div class="accordion-body">
              Es el proceso oficial para verificar que un producto cumple con la NOM-070-SCFI-2016, permitiendo su comercialización como “Mezcal”.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-2" aria-controls="accordionPayment-2">
              ¿Quién puede certificar mezcal?

              </button>
            </h2>
            <div id="accordionPayment-2" class="accordion-collapse collapse">
              <div class="accordion-body">
              Solo los organismos de certificación aprobados por la Dirección General de Normas (DGN) a través de la Secretaría de Economía y que cuenten con una acreditación vigente.

              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-3" aria-controls="accordionPayment-3">
              ¿Es obligatorio certificar el mezcal para venderlo?

              </button>
            </h2>
            <div id="accordionPayment-3" class="accordion-collapse collapse">
              <div class="accordion-body">
              Sí. Si se desea comercializar legalmente como “mezcal”, tanto en México como en el extranjero, es obligatorio.

                <a href="javascript:void(0);"></a>
                <span class="fw-medium"></span>
                <a href="javascript:void(0);"></a>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionPayment-4" aria-controls="accordionPayment-4">
              ¿Qué categorías de mezcal existen según la NOM?
              </button>
            </h2>
            <div id="accordionPayment-4" class="accordion-collapse collapse">
              <div class="accordion-body">
              <ul>
                  <li>Mezcal</li>
                  <li>Mezcal Artesanal</li>
                  <li>Mezcal Ancestral</li>
              </ul>
                  <p>Cada categoría tiene procesos específicos de producción regulados.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="tab-pane fade" id="delivery" role="tabpanel">
        <div class="d-flex mb-4 gap-4 align-items-center">
          <div class="avatar avatar-md">
            <span class="avatar-initial bg-label-primary rounded-4">
              <i class="ri-file-text-line ri-30px"></i>
            </span>
          </div>
          <div>
            <h5 class="mb-0">
              <span class="align-middle">Requisitos para iniciar el proceso</span>
            </h5>
            <span></span>
          </div>
        </div>
        <div id="accordionDelivery" class="accordion">
          <div class="accordion-item active">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionDelivery-1" aria-controls="accordionDelivery-1">
              ¿Qué necesito para comenzar la certificación?
              </button>
            </h2>

            <div id="accordionDelivery-1" class="accordion-collapse collapse show">
              <div class="accordion-body">
              <ul>
                  <li>Registro ante el SAT como productor</li>
                  <li>Planta en zona con Denominación de Origen Mezcal (DOM)</li>
                  <li>Trazabilidad del agave</li>
                  <li>Cumplimiento de procesos de la NOM-070</li>
              </ul>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionDelivery-2" aria-controls="accordionDelivery-2">
              ¿Puedo certificar un mezcal hecho con olla de barro o tahona?
              </button>
            </h2>
            <div id="accordionDelivery-2" class="accordion-collapse collapse">
              <div class="accordion-body">Sí. Siempre que el proceso cumpla con los lineamientos de la categoría correspondiente (artesanal o ancestral).
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="cancellation" role="tabpanel">
        <div class="d-flex mb-4 gap-4 align-items-center">
          <div class="avatar avatar-md">
            <span class="avatar-initial bg-label-primary rounded-4">
              <i class="ri-refresh-line me-2 ri-30px"></i>
            </span>
          </div>
          <div>
            <h5 class="mb-0"><span class="align-middle">Proceso de certificación</span></h5>
            <span></span>
          </div>
        </div>
        <div id="accordionCancellation" class="accordion">
          <div class="accordion-item active">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionCancellation-1" aria-controls="accordionCancellation-1">
              ¿Cómo es el proceso de certificación?
              </button>
            </h2>

            <div id="accordionCancellation-1" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <p>
                Implica revisión documental, visita de inspección, análisis de laboratorio y verificación del cumplimiento de la NOM-070.
                </p>
                <p class="mb-0">
                
                </p>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionCancellation-2" aria-controls="accordionCancellation-2">
              ¿Cuánto tiempo tarda la certificación?

              </button>
            </h2>
            <div id="accordionCancellation-2" class="accordion-collapse collapse">
              <div class="accordion-body">
              Entre 15 y 45 días, dependiendo del cumplimiento documental y operativo.
                <a href="javascript:void(0);"></a>
               
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-controls="accordionCancellation-3" data-bs-target="#accordionCancellation-3">
              ¿Qué sucede si mi lote no aprueba la certificación?

              </button>
            </h2>
            <div id="accordionCancellation-3" class="accordion-collapse collapse">
              <div class="accordion-body">
                <p>Recibirás un reporte de no conformidades para corregir y volver a presentar el lote. <a href="javascript:void(0);"></a></p>
                <p class="mb-0"> <span class="fw-medium"></span> </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="orders" role="tabpanel">
        <div class="d-flex mb-4 gap-4 align-items-center">
          <div class="avatar avatar-md">
            <span class="avatar-initial bg-label-primary rounded-4">
              <i class="ri-money-dollar-circle-line ri-30px"></i>
            </span>
          </div>
          <div>
            <h5 class="mb-0">
              <span class="align-middle">Costos y Documentación</span>
            </h5>
            <span></span>
          </div>
        </div>
        <div id="accordionOrders" class="accordion">
          <div class="accordion-item active">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionOrders-1" aria-controls="accordionOrders-1">
              ¿Cuál es el costo del proceso de certificación?
              </button>
            </h2>

            <div id="accordionOrders-1" class="accordion-collapse collapse show">
              <div class="accordion-body">
                <p>
                Varía según la cantidad de lotes, visitas y análisis requeridos. Puedes solicitar una cotización personalizada.
                </p>
                <p class="mb-0">
                   <span class="fw-medium"></span>
                </p>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionOrders-2" aria-controls="accordionOrders-2">
              ¿Qué documentos debo presentar?
              </button>
            </h2>
            <div id="accordionOrders-2" class="accordion-collapse collapse">
              <div class="accordion-body">
              <ul>
                  <li>RFC y datos fiscales</li>
                  <li>Evidencia de trazabilidad del agave</li>
                  <li>Registro de lotes</li>
                  <li>Fotografías o planos de la planta</li>
                  <li>Etiquetas y muestras del producto</li>
              </ul>
 <span class="fw-medium"></span> 
              </div>
            </div>
          </div>

          
        </div>
      </div>
      <div class="tab-pane fade" id="product" role="tabpanel">
        <div class="d-flex mb-4 gap-4 align-items-center">
          <div class="avatar avatar-md">
            <span class="avatar-initial bg-label-primary rounded-4">
              <i class="ri-file-check-line ri-30px"></i>
            </span>
          </div>
          <div>
            <h5 class="mb-0">
              <span class="align-middle">Post-certificación y comercialización</span>
            </h5>
            <span></span>
          </div>
        </div>
        <div id="accordionProduct" class="accordion">
          <div class="accordion-item active">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#accordionProduct-1" aria-controls="accordionProduct-1">
              ¿Qué puedo hacer después de certificar mi mezcal?

              </button>
            </h2>

            <div id="accordionProduct-1" class="accordion-collapse collapse show">
              <div class="accordion-body">
              <ul>
                  <li>Etiquetar con la Denominación de Origen</li>
                  <li>Comercializar como producto certificado</li>
                  <li>Exportar cumpliendo requisitos internacionales</li>
              </ul>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionProduct-2" aria-controls="accordionProduct-2">
              ¿La certificación tiene vigencia?
              </button>
            </h2>
            <div id="accordionProduct-2" class="accordion-collapse collapse">
              <div class="accordion-body">
              Sí, requiere mantenimiento con inspecciones y certificación por lote.
              <a href="javascript:void(0);"></a>
              </div>
            </div>
          </div>

          
        </div>
      </div>
    </div>
  </div>
  <!-- /FAQ's -->
</div>

<!-- Contact -->
<div class="row my-6">
  <div class="col-12 text-center my-6">
    <div class="badge bg-label-primary rounded-pill">¿Preguntas?</div>
    <h4 class="my-2">¿Tienes alguna pregunta?</h4>
    <p class="mb-0">Si no encontró su pregunta en nuestras preguntas frecuentes, puede ponerse en contacto con nosotros. ¡Le responderemos en breve!</p>
  </div>
</div>
<div class="row justify-content-center gap-sm-0 gap-6">
  <div class="col-sm-6">
    <div class="p-6 rounded-4 bg-faq-section d-flex align-items-center flex-column">
      <div class="avatar avatar-md">
        <span class="avatar-initial bg-label-primary rounded-3">
          <i class="ri-phone-line ri-30px"></i>
        </span>
      </div>
      <h5 class="mt-4 mb-1"><a class="text-heading" href="tel:+(810)25482568">+ (52) 443 299 0181</a></h5>
      <p class="mb-0">La mejor manera de obtener una respuesta rápida</p>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="p-6 rounded-4 bg-faq-section d-flex align-items-center flex-column">
      <div class="avatar avatar-md">
        <span class="avatar-initial bg-label-primary rounded-3">
          <i class="ri-mail-line ri-30px"></i>
        </span>
      </div>
      <h5 class="mt-4 mb-1"><a class="text-heading" href="mailto:help@help.com">organismocertificadorcidam@gmail.com</a></h5>
      <p class="mb-0">Siempre encantados de ayudarle</p>
    </div>
  </div>
</div>
<!-- /Contact -->
@endsection


