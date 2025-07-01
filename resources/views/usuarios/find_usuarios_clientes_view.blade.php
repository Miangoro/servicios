@extends('layouts/layoutMaster')

@section('title', 'Usuarios clientes')

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
  'resources/assets/vendor/libs/spinkit/spinkit.scss'
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
@vite(['resources/js/usuarios-clientes.js'])
@endsection

@section('content')

<div class="row g-6 mb-6">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">Users</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-2">{{$totalUser}}</h4>
              <p class="text-success mb-1">(100%)</p>
            </div>
            <small class="mb-0">Total Users</small>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-primary rounded-3">
              <div class="ri-user-line ri-26px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">Verified Users</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-1">{{$verified}}</h4>
              <p class="text-success mb-1">(+95%)</p>
            </div>
            <small class="mb-0">Recent analytics</small>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-success rounded-3">
              <div class="ri-user-follow-line ri-26px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">Duplicate Users</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-1">{{$userDuplicates}}</h4>
              <p class="text-danger mb-1">(0%)</p>
            </div>
            <small class="mb-0">Recent analytics</small>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-danger rounded-3">
              <div class="ri-group-line ri-26px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="me-1">
            <p class="text-heading mb-1">Verification Pending</p>
            <div class="d-flex align-items-center">
              <h4 class="mb-1 me-1">{{$notVerified}}</h4>
              <p class="text-success mb-1">(+6%)</p>
            </div>
            <small class="mb-0">Recent analytics</small>
          </div>
          <div class="avatar">
            <div class="avatar-initial bg-label-warning rounded-3">
              <div class="ri-user-unfollow-line ri-26px"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- Users List Table -->
<div class="card">
  <div class="card-header pb-0">
    <h3 class="card-title mb-0">Usuarios clientes</h3>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead>
        <tr>
          <th></th>
          <th>Id</th>
          <th>Usuario</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th>Contraseña</th>
          <th>Cliente</th>
          <th>Carta de asignación</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header border-bottom bg-primary">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title text-white">Titulo Agregar</h5>
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
          <input id="add-user-tel" type="tel" class="form-control" placeholder="Teléfono" aria-label="" name="telefono" />
          <label for="">Teléfono</label>
        </div>
       
        <div class="form-floating form-floating-outline mb-5">
          <select name="id_empresa" id="id_empresa" class="select2 form-select" data-placeholder="Seleccione el cliente">
            <option value="" disabled selected>NULL</option>
              @foreach ($empresas as $empresa)
                <option value="{{ $empresa->id_empresa }}">
                  @if(isset($empresa->empresaNumClientes[0]) && $empresa->empresaNumClientes[0]->numero_cliente)
                  {{ $empresa->empresaNumClientes[0]->numero_cliente }}
              @elseif(isset($empresa->empresaNumClientes[1]))
                  {{ $empresa->empresaNumClientes[1]->numero_cliente }}
              @else
                  N/A
              @endif
              

                | {{ $empresa->razon_social }}</option>
              @endforeach
          </select>
          <label for="country">Cliente</label>
        </div>

        <div class="form-floating form-floating-outline mb-5">
          <select id="id_contacto" name="id_contacto" data-placeholder="Selecciona una persona de contacto" class="select2 form-select" aria-label="Default select example" >
              <option value="" disabled selected>NULL</option>
              @foreach ($usuarios as $usuario)
                  <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
              @endforeach
          </select>
          <label for="id_contacto">Persona de contacto CIDAM</label>
        </div>

        <div class="d-flex mt-6 justify-content-center">
          <button type="submit" id="registrar-editar" class="btn btn-primary me-sm-3 me-1 data-submit"><i class="ri-add-line"></i> Registrar</button>
          <button type="reset" class="btn btn-danger" data-bs-dismiss="offcanvas"><i class="ri-close-line"></i> Cancelar</button>
      </div>
        
       
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
<!-- /Modal -->
@endsection
