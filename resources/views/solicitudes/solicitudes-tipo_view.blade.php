@extends('layouts/layoutMaster')

@section('title', 'Tipos de Solicitudes')

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
@vite(['resources/js/solicitudes-tipo.js'])
@endsection

@section('content')

<style>
.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.card-hover:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    border: 2px solid #2EAC6B !important;
    cursor: pointer; 
}

.card-title {
    font-size: 1.25rem;
    font-weight: 500;
}

.card {
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin-bottom: 20px; 
}

.tab-pane {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.card-title {
    font-size: 20px;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container mt-5">
  <div class="card shadow-sm border-light">
    <div class="card-body">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="tab-mezcal-tab" data-bs-toggle="tab" href="#tab-mezcal" role="tab">Mezcal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab-alcoholicas-tab" data-bs-toggle="tab" href="#tab-alcoholicas" role="tab">Otras bebidas de mezcal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab-no-alcoholicas-tab" data-bs-toggle="tab" href="#tab-no-alcoholicas" role="tab">Otras bebidas alcohólicas</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <!-- Pestaña Mezcal -->
        <div class="tab-pane fade show active" id="tab-mezcal" role="tabpanel">
          <h5 class="card-title">Mezcal</h5>
          <p class="card-text">Información sobre mezcal y opciones relacionadas.</p>
          <div class="row g-6 mb-6" id="tab-mezcal-content">
            <!-- Mensaje de carga -->
            <div class="col-md-12 text-center" id="loading-message">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
              </div>
              <p class="mt-3">Cargando...</p>
            </div>
          </div>
        </div>
        
        <!-- Pestaña Otras Bebidas de Mezcal -->
        <div class="tab-pane fade" id="tab-alcoholicas" role="tabpanel">
          <h5 class="card-title">Otras bebidas de mezcal</h5>
          <p class="card-text">Información sobre otras bebidas alcohólicas y opciones relacionadas.</p>
          <div class="row g-6 mb-6" id="tab-alcoholicas-content">
            <div class="col-md-4">
              <div class="card text-center">
                <div class="card-body">
                  <i class="fas fa-cocktail fa-3x mb-3"></i> <!-- Ícono -->
                  <p class="card-text">Descripción de otras bebidas de mezcal</p>
                </div>
              </div>
            </div>
            <!-- Agrega más cards aquí según sea necesario -->
          </div>
        </div>
        
        <!-- Pestaña Otras Bebidas Alcohólicas -->
        <div class="tab-pane fade" id="tab-no-alcoholicas" role="tabpanel">
          <h5 class="card-title">Otras bebidas alcohólicas</h5>
          <p class="card-text">Información sobre otras bebidas no alcohólicas y opciones relacionadas.</p>
          <div class="row g-6 mb-6" id="tab-no-alcoholicas-content">
            <div class="col-md-4">
              <div class="card text-center">
                <div class="card-body">
                  <i class="fas fa-beer fa-3x mb-3"></i> <!-- Ícono -->
                  <p class="card-text">Descripción de otras bebidas alcohólicas</p>
                </div>
              </div>
            </div>
            <!-- End Card -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    var obtenerSolicitudesTiposUrl = "{{ route('obtener.solicitudes.tipos') }}";
</script>

@include('_partials._modals.modal-add-solicitud-dictamen-instalaciones')

@endsection
