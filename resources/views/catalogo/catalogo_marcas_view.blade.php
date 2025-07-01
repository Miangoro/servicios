extends('layouts/layoutMaster')

@section('title', 'Catalogo Marcas')

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
@vite(['resources/js/clientes_prospecto.js'])
@endsection

@section('content')
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Control de Marcas</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Cliente</th>
                        <th>Marca</th>
                        <th>Folio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($opciones as $opcion)
                        <tr>
                            <td>{{ $opcion->id_marca }}</td>
                            <td>{{ $opcion->cliente->razon_social ?? 'N/A' }}</td>
                            <td>{{ $opcion->marca }}</td>
                            <td>{{ $opcion->folio }}</td>
                            <td>
                                <center>
                                    <form action="{{ route('catalogoMarcas.destroy', $opcion->id_marca) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect">
                                            <i class="ri-delete-bin-7-line ri-20px text-danger"></i>
                                        </button>
                                    </form>
                                    <!-- Botón de modificar -->
                                    <button
                                        class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect"
                                        data-id="{{ $opcion->id_marca }}" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasAddUser">
                                        <i class="ri-edit-box-line ri-20px text-info"></i>
                                    </button>
                                    <!-- Botón de agregarpdfs -->
                                    <button
                                        class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect dropdown-toggle hide-arrow"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-2-line ri-20px"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="dropdown-item" id="openUploadModal">Subir archivos</a>
                                        </li>
                                    </ul>
                                </center>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Offcanvas to add new user -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Añadir registro</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body mx-0 flex-grow-0 h-100">
            <form class="add-new-user pt-0" id="addNewUserForm" method="POST" action="{{ route('catalogoMarcas.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="user_id">
                <!-- muestra clientes tipo2 -->
                <div class="form-floating form-floating-outline mb-5">
                    <select id="cliente" name="cliente" class="select2 form-select" required>
                        <option value="">Selecciona cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                        @endforeach
                    </select>
                    <label for="cliente">Cliente</label>
                </div>
            
                <!-- nombre marcas -->
                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" id="add-user-company" name="company" class="form-control"
                        placeholder="Nombre de la marca" required />
                    <label for="add-user-company">Nombre de la marca</label>
                </div>
            
                <!-- folio -->
                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" id="add-user-folio" name="folio" class="form-control" placeholder="Folio"
                        required />
                    <label for="add-user-folio">Folio</label>
                </div>
            
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </form>
            
            
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Subir Archivos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadFilesForm">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="file{{ $i }}" class="form-label">Subir archivo</label>
                                    <input type="file" class="form-control" id="file{{ $i }}" name="files[]">
                                </div>
                                <div class="col-md-6">
                                    <label for="vigencia{{ $i }}" class="form-label">Fecha de vigencia</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker"
                                            id="vigencia{{ $i }}" name="vigencia[]">
                                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endfor

                        <button type="submit" class="btn btn-primary">Subir</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    <!-- /Modal -->
@endsection
