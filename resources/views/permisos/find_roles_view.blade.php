@extends('layouts/layoutMaster')

@section('title', 'Roles')

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

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/roles.js'])
@endsection

@section('content')


    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Roles</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Rol</th>
                        <th>Fecha de creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom bg-primary">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title text-white">Registrar</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form class="add-new-user pt-0" id="addNewRol">
                    <input type="hidden" name="rol_id" id="rol_id">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="name" placeholder="Inspector" name="name"
                            aria-label="Inspector" />
                        <label for="add-user-fullname">Nombre del rol</label>
                    </div>

                    <div class="form-group">
                      <label for="permisos" class="form-label">Seleccionar Permisos</label>
                      <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="checkAllPermisos">
                        <label class="form-check-label" for="checkAllPermisos">
                          Seleccionar todos
                        </label>
                      </div>
                      
                      <div style="max-height: 800px; overflow-y: auto;">
                          @foreach($permisos as $permiso)
                              <div class="form-check form-check-sm">
                                  <input class="form-check-input" type="checkbox" value="{{ $permiso->name }}" id="permiso{{ $permiso->id }}" name="permisos[]">
                                  <label class="form-check-label" for="permiso{{ $permiso->id }}">
                                      {{ $permiso->name }}
                                  </label>
                              </div>
                          @endforeach
                      </div>
                  </div>
                  



                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" id="registrar-editar" class="btn btn-primary me-sm-3 me-1 data-submit"><i
                                class="ri-add-line"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="offcanvas"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection