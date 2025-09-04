@extends('layouts/layoutMaster')

@section('title', 'Personal regular')

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
        'resources/assets/vendor/libs/tagify/tagify.scss',
        'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
        'resources/assets/vendor/libs/typeahead-js/typeahead.scss',
        'resources/assets/vendor/libs/dropzone/dropzone.scss',
        'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
        'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
        'resources/assets/vendor/libs/spinkit/spinkit.scss',
        'resources/assets/vendor/libs/quill/typography.scss',
        'resources/assets/vendor/libs/quill/katex.scss',
        'resources/assets/vendor/libs/quill/editor.scss'
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/tagify/tagify.js',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
    'resources/assets/vendor/libs/typeahead-js/typeahead.js',
    'resources/assets/vendor/libs/bloodhound/bloodhound.js',
    'resources/assets/vendor/libs/dropzone/dropzone.js',
    'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
    'resources/assets/vendor/libs/flatpickr/flatpickr.js',
    'resources/assets/vendor/libs/quill/katex.js',
  'resources/assets/vendor/libs/quill/quill.js'
    ])
@endsection

@section('page-script')
@vite(['resources/js/agregarPersonalRegular.js',
  'resources/assets/js/forms-pickers.js',
])

@endsection

@section('content')

<script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
<script>
  var usuarios = @json($usuarios); 
</script>


<style>
#dropzone-basic {
  position: relative;
  min-height: 250px;
  max-height: 400px;
  border: 2px dashed #ccc;
  border-radius: 12px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

#dropzone-basic .dz-message {
  text-align: center;
  color: #888;
  font-size: 1rem;
  z-index: 10;
}

#dropzone-basic.dz-started .dz-message {
  display: none;
}

#dropzone-basic .dz-preview {
  margin: 0 !important;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

#dropzone-basic .dz-preview .dz-image,
#dropzone-basic .dz-preview .dz-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  pointer-events: none;
}

</style>

<div class="container-fluid mt--7">

    <div class="row">
        <div class="col">
            <div class="card shadow p-6">
                <div class="card-header border-0 pb-1">
                    <div class="d-flex flex-row">
                        <span class="iconify" data-icon="mdi:user-badge" data-inline="false" style="font-size: 48px;"></span>
                        <div class="">
                            <h3 class="mb-0"><b>Agregar empleado</b></h3>
                        </div>
                    </div>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div>
                    <form id="form-agregar-empleado">
                        @csrf
                        <div class="col-md-12 d-flex flex-column align-items-center justify-content-center">
                            <h4>Foto</h4>
                            <div class="dropzone needsclick col-md-4" id="dropzone-basic">
                                <div class="dz-message needsclick">
                                    <div class="d-flex justify-content-center">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded-3 bg-label-secondary">
                                                <i class="ri-upload-2-line ri-24px"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="h4 needsclick my-2">Arrastra y suelta tu imagen aquí</p>
                                    <small class="note text-muted d-block fs-6 my-2">o</small>
                                    <span class="needsclick btn btn-sm btn-outline-primary" id="btnBrowse">Buscar imagen</span>
                                </div>
                                <div class="fallback">
                                    <input name="fotoEmpleado" type="file" id="fotoEmpleadoInput" />
                                </div>
                            </div>
                        </div>

                        <input hidden value="" name="idUsuario" id="id_usuario_input">

                        <div class="d-flex flex-row align-items-center">
                               <span class="iconify" data-icon="fluent:info-24-filled" data-inline="false" style="font-size: 24px;"></span>
                                <span>Información principal</span> 
                        </div>

                        <div class="row col-md-12 my-4">
                            <div class="col-md-8">
                                <input id="nombreEmpleadoInput" name="nombreEmpleado" class="form-control typeahead" type="text" autocomplete="off" placeholder="Escriba el nombre completo del empleado o selecciónelo" />
                            </div>
                            <div class="form-floating form-floating-outline col-md-4">
                                <input type="text" class="form-control" id="folioEmpleadoInput" name="folioEmpleado" placeholder="Cree un folio para este empleado" aria-describedby="floatingInputHelp" />
                                <label for="folioEmpleadoInput">Folio</label>
                            </div>
                        </div>

                        <div class="row col-md-12 my-4">
                            <div class="form-floating form-floating-outline col-md-6">
                                <input type="text" class="form-control" id="correoEmpleadoInput" name="correoEmpleado" placeholder="Correo electrónico del empleado" aria-describedby="floatingInputHelp" />
                                <label for="correoEmpleadoInput">Correo</label>
                            </div>
                            <div class="col-md-6 form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" name="fechaIngreso" />
                                <label for="flatpickr-date">Fecha de ingreso</label>
                            </div>
                        </div>

                        <div class="col-12">
                        <span>Descripción</span>
                        <input type="hidden" name="descripcionEmpleado" id="descripcionEmp">
                        <div id="snow-toolbar">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                            </span>
                        </div>
                        <div id="snow-editor"></div>
                    </div>

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button id="AddEmpleadoBtn" type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
                            <i class="ri-add-line"></i> Agregar
                        </button>
                        <a href="{{ route('personalRegular.index') }}" class="btn btn-danger">
                            <i class="ri-close-line"></i> Cancelar
                        </a>
                    </div>
                        
                    </form>
                </div>

                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="..."></nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection