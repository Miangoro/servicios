@extends('layouts/layoutMaster')

@section('title', 'Permisos')

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
    @vite(['resources/js/permisos.js'])
@endsection

@section('content')


    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Permisos</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Permiso</th>
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
                    <input type="hidden" name="permiso_id" id="permiso_id">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="name" placeholder="Visualizar documentación" name="name"
                            aria-label="Inspector" />
                        <label for="add-user-fullname">Nombre del permiso</label>
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
