@extends('layouts/layoutMaster')

@section('title', 'Usuarios inspectores')

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
@vite(['resources/js/usuarios-inspectores.js'])
@endsection

@section('content')


<!-- Users List Table -->
<div class="card">
  <div class="card-header pb-0">
    <h3 class="card-title mb-0">Usuarios inspectores</h3>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead>
        <tr>
          <th></th>
          <th>Id</th>
          <th>Usuario</th>
          <th>Correo</th>
          <th>Contraseña</th>
          <th>Puesto</th>
          <th>Firma</th>
          <th>Estatus</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Registrar Usuario</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 h-100">
      <form class="add-new-user pt-0" id="addNewUserForm">
        <input type="hidden" name="id" id="user_id">
        <div class="form-floating form-floating-outline mb-5">
          <input type="text" class="form-control" id="add-user-fullname" placeholder="Ana Gómez" name="name" aria-label="Ana Gómez" />
          <label for="add-user-fullname">Nombre completo</label>
        </div>
        <div class="form-floating form-floating-outline mb-5">
          <input type="text" id="add-user-email" class="form-control" placeholder="ana.gmz@example.com" aria-label="ana.gmz@example.com" name="email" />
          <label for="add-user-email">Correo</label>
        </div>
        <div class="form-floating form-floating-outline mb-5">
          <input type="text" id="add-user-puesto" class="form-control" placeholder="puesto" name="puesto" />
          <label for="add-user-puesto">Puesto</label>
        </div>
        <div id="statusDnone" class="d-none">
          <div class="form-floating form-floating-outline mb-5">
            <select id="add-estatus" class="form-select" name="estatus" aria-label="Estatus">
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
            <label for="add-estatus">Estatus</label>
          </div>
        </div>
        {{-- subir firma --}}
        <div class="form-floating form-floating-outline mb-5">
          <input id="subir-firma" type="file" class="form-control" aria-label="Firma" name="firma" accept="image/jpg,png" />
          <label for="subir-firma">Subir Firma</label>
        </div>

        <div class="form-floating form-floating-outline mb-5">
          <select id="rol_id" name="rol_id" data-placeholder="Selecciona un rol" class="select2 form-select" aria-label="Default select example" >
              <option value="" disabled>Sleecciona un rol</option>
              @foreach ($roles as $rol)
                  <option value="{{ $rol->name }}">{{ $rol->name }}</option>
              @endforeach
          </select>
          <label for="id_contacto">Rol</label>
        </div>


        <button type="submit" id="registrar-editar" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
<!-- /Modal -->
@endsection
