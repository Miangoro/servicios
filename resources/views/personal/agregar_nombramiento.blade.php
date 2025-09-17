@extends('layouts/layoutMaster')

@section('title', 'Agregar nombramiento')

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
        'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js',
        'resources/assets/vendor/libs/flatpickr/flatpickr.js',
        'resources/assets/vendor/libs/quill/katex.js',
        'resources/assets/vendor/libs/quill/quill.js',
    ])
@endsection

@section('page-script')
    @vite([
        'resources/js/agregarNombramiento.js',
        'resources/assets/js/forms-pickers.js',
        'resources/assets/js/forms-selects.js',
        'resources/assets/js/forms-tagify.js',
        'resources/assets/js/forms-typeahead.js'
    ])

@endsection

@section('content')

    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script>
        var empleado = @json($empleado);
        var puestos = @json($puestos);
        var responsable = @json($responsable);
    </script>

    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card shadow p-6">
                    <div class="card-header border-0 pb-1">
                        <div class="d-flex flex-row">
                            <span class="iconify text-normal" data-icon="streamline-ultimate:job-responsibility-bag-hand-bold" data-inline="false" style="font-size: 30px;"></span>
                            <div class="mx-2">
                                <h3 class="mb-0"><b>Registrar Nombramiento</b></h3>
                            </div>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div>
                        <form id="form-agregar-nombramiento">
                            @csrf

                            <div class="d-flex flex-row align-items-center mt-6">
                                <span class="iconify" data-icon="fluent:info-24-filled" data-inline="false"
                                    style="font-size: 24px;"></span>
                                <span>Información del nombramiento</span>
                            </div>

                            <input type="hidden" name="empleado_id" value="{{ $empleado->id_empleado }}">

                            <div class="row col-md-12 my-6">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="select2Basic" name="puesto" required class="select2 form-select form-select-lg" data-allow-clear="true">
                                            @foreach($puestos as $puesto)
                                                <option value="{{ $puesto->nombre }}">
                                                    {{ $puesto->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="select2Basic">Puesto</label>
                                    </div>
                                </div>
                            
                                 <div class="form-floating form-floating-outline col-md-6">
                                    <input type="text" class="form-control" id="areaInput" name="area" placeholder="Asigne el área" aria-describedby="floatingInputHelp" />
                                    <label for="areaInput">Área</label>
                                </div>
                            </div>

                           <div class="row col-md-12 my-6">
                                <div class="col-md-4 form-floating form-floating-outline">
                                    <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" name="fechaNombramiento" />
                                    <label for="flatpickr-date">Fecha de nombramiento</label>
                                </div>

                                <div class="col-md-4 form-floating form-floating-outline">
                                    <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date2" name="fechaEfectivo" />
                                    <label for="flatpickr-date2">Fecha efectivo</label>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline">
                                    <select id="select2BasicResponsable" name="responsable" required class="select2 form-select form-select-lg" data-allow-clear="true">
                                        @foreach($responsable as $resp)
                                            <option value="{{ $resp->id }}">
                                                {{ $resp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="select2BasicResponsable">Responsable</label>
                                    </div>
                                </div>

                           </div>

                           <div class="row col-md-12 my-6">

                                <div class="form-floating form-floating-outline col-md-6">
                                    <input type="text" class="form-control" id="sup" name="suplente" placeholder="Asignar suplente" aria-describedby="floatingInputHelp" />
                                    <label for="sup">Suplente</label>
                                </div>

                                <div class="form-floating form-floating-outline col-md-6">
                                    <select id="select2BasicSupervisa" name="supervisor" required class="select2 form-select form-select-lg" data-allow-clear="true">
                                        @foreach($responsable as $resp)
                                            <option value="{{ $resp->id }}">
                                                {{ $resp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="select2BasicSupervisa">Supervisor</label>
                                </div>

                           </div>

                            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                                <button id="AddNombramientoBtn" type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
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