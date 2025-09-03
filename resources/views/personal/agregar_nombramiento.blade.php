@extends('layouts/layoutMaster')

@section('title', 'Expediente personal')

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
    @vite([
        'resources/js/agregarExpediente.js',
        'resources/assets/js/forms-pickers.js',
    ])

@endsection

@section('content')

    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script>
        var empleado = @json($empleado);
    </script>

    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card shadow p-6">
                    <div class="card-header border-0 pb-1">
                        <div class="d-flex flex-row">
                            <span class="iconify text-primary" data-icon="streamline-ultimate:job-responsibility-bag-hand-bold" data-inline="false" style="font-size: 24px;"></span>
                            <div class="">
                                <h3 class="mb-0"><b>Registrar Nombramiento</b></h3>
                            </div>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div>
                        <form id="form-agregar-expediente">
                            @csrf

                            <div class="d-flex flex-row align-items-center mt-6">
                                <span class="iconify" data-icon="fluent:info-24-filled" data-inline="false"
                                    style="font-size: 24px;"></span>
                                <span>Información del nombramiento</span>
                            </div>

                            <div>
                                <select id="a_Evaluar" name="aEvaluar" required class="select2 form-select form-select-lg">
                                <option value="">Seleccione</option>
                                @foreach($puestos as $puesto)
                                    <option value="{{ $puesto->puesto }}">
                                        {{ $puesto->puesto }}
                                    </option>
                                @endforeach
                            </select>
                            </div>

                            <div class="form-floating form-floating-outline col-md-4">
                                <input type="text" class="form-control" id="folioEmpleadoInput" name="folioEmpleado" placeholder="Asigne el área" aria-describedby="floatingInputHelp" />
                                <label for="folioEmpleadoInput">Área</label>
                            </div>

                            <div class="col-md-6 form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" name="fechaIngreso" />
                                <label for="flatpickr-date">Fecha de nombramiento</label>
                            </div>

                            <div class="col-md-6 form-floating form-floating-outline">
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" name="fechaIngreso" />
                                <label for="flatpickr-date">Fecha efectivo</label>
                            </div>

                            <div>
                                <select id="a_Evaluar" name="aEvaluar" required class="select2 form-select form-select-lg">
                                <option value="">Responsable</option>
                                @foreach($puestos as $puesto)
                                    <option value="{{ $puesto->puesto }}">
                                        {{ $puesto->puesto }}
                                    </option>
                                @endforeach
                            </select>
                            </div>

                            <div class="form-floating form-floating-outline col-md-4">
                                <input type="text" class="form-control" id="folioEmpleadoInput" name="folioEmpleado" placeholder="Cree un folio para este empleado" aria-describedby="floatingInputHelp" />
                                <label for="folioEmpleadoInput">Suplente</label>
                            </div>

                            <div>
                                <select id="a_Evaluar" name="aEvaluar" required class="select2 form-select form-select-lg">
                                <option value="">Persona que supervisa</option>
                                @foreach($puestos as $puesto)
                                    <option value="{{ $puesto->puesto }}">
                                        {{ $puesto->puesto }}
                                    </option>
                                @endforeach
                            </select>
                            </div>

                            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                                <button id="AddExpedienteBtn" type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
                                    <i class="ri-add-line"></i> Guardar
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