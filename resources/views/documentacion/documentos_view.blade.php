@extends('layouts.layoutMaster')

@section('title', 'Catálogo Instalaciones')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
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
])
@endsection

@section('page-script')
@vite(['resources/js/documentos.js'])
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Documentación</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddInstalacion" aria-labelledby="offcanvasAddInstalacionLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddInstalacionLabel">Agregar Documentación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formAddDocumentacion">
            <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" aria-label="Nombre" required>
                <label for="nombre">Nombre</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
                <select class="form-select" id="tipo" name="tipo" aria-label="Tipo" required>
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="Todas">Todas</option>
                    <option value="Generales Productor">Generales Productor</option>
                    <option value="Generales Productor Mezcal">Generales Productor Mezcal</option>
                    <option value="Generales Envasador">Generales Envasador</option> 
                    <option value="Generales Comercializador">Generales Comercializador</option>
                </select>
                <label for="tipo">Tipo</label>
            </div>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<!-- /Offcanvas -->
<!-- Offcanvas para editar documentación -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditInstalacion" aria-labelledby="offcanvasEditInstalacionLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasEditInstalacionLabel">Editar Documentación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="formEditDocumentacion">
            <input type="hidden" id="documentoId" name="id">
            <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="nombreEdit" name="nombre" placeholder="Nombre" aria-label="Nombre" required>
                <label for="nombreEdit">Nombre</label>
            </div>
            <div class="form-floating form-floating-outline mb-5">
                <select class="form-select" id="tipoEdit" name="tipo" aria-label="Tipo" required>
                    <option value="" disabled>Selecciona un tipo</option>
                    <option value="Todas">Todas</option>
                    <option value="Generales Productor">Generales Productor</option>
                    <option value="Generales Productor Mezcal">Generales Productor Mezcal</option>
                    <option value="Generales Envasador">Generales Envasador</option> 
                    <option value="Generales Comercializador">Generales Comercializador</option>
                    <option value="Marcas">Marcas</option>
                </select>
                <label for="tipoEdit">Tipo</label>
            </div>
            <div class="d-flex justify-content-start">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Actualizar</button>
                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </div>
        </form>
    </div>
</div>






@endsection
