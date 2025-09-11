@extends('layouts/layoutMaster')

@section('title', 'Agregar conflicto de interés')

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
    </script>

    <div class="container-fluid mt--7">

        <div class="row">
            <div class="col">
                <div class="card shadow p-6">
                    <div class="card-header border-0 pb-1">
                        <div class="d-flex flex-row">
                            <span class="iconify text-normal" data-icon="fluent:document-search-20-filled" data-inline="false" style="font-size: 30px;"></span>
                            <div class="mx-2">
                                <h3 class="mb-0"><b>Registrar conflicto de interés</b></h3>
                            </div>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div>
                        <form id="form-agregar-nombramiento">
                            @csrf

                            <input type="hidden" name="empleado_id" value="{{ $empleado->id_empleado }}">

                            <div class="row col-md-12 my-6">
                                
                                <div class="col-md-4 form-floating form-floating-outline">
                                    <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date" name="fecha" />
                                    <label for="flatpickr-date">Morelia, Michoacán a</label>
                                </div>

                                <div class="form-floating form-floating-outline col-md-4">
                                    <input type="text" class="form-control" id="versionInput" name="version" aria-describedby="floatingInputHelp" />
                                    <label for="versionInput">Versión</label>
                                </div>

                            </div>

                            <div class="col-md-12 my-6">
                                
                                <p>
                                <strong>Los conflictos de interés son aquellas situaciones en las que personal de CIDAM A.C. pudiera ser influido para tomar acciones indebidas, específicamente por motivos relacionados con sus propios intereses económicos o por el puesto del trabajo en el que se está desempeñando.</strong> <br>
                                    <br>
                                    Los empleados y directivos de CIDAM A.C. estarán impedidos para conocer de las solicitudes de Evaluación de la Conformidad promovidas por personas con las cuales tengan nexos familiares por afinidad o consanguinidad hasta el cuarto grado en línea recta o colateral, intereses económicos o conflictos de interés de otra índole.
                                    Es responsabilidad de todo el personal de CIDAM A.C. revelar cualquier vínculo personal que pudiera estar relacionado con la prestación de sus servicios y de este modo, gestionar apropiadamente esos conflictos existentes o potenciales. <br>
                                    <br>
                                    <strong>Le recordamos que la información que proporcione a continuación se mantendrá de manera confidencial, entre el personal de la Unidad de Apoyo Administrativo y usted.</strong>
                                </p>

                                <p>
                                    Yo, <strong>{{ $empleado->nombre }}</strong>
                                </p>

                                <div class="form-floating form-floating-outline col-md-4">
                                    <input type="text" class="form-control" id="areaInput" name="area" aria-describedby="floatingInputHelp" value="{{ $area->area }}" />
                                </div>

                                <p>
                                    (laboratorio/área, OEC) del CIDAM A.C. Declaro que la información proporcionada en el presente documento es legítima y me hago responsable de su validez durante el tiempo en que la empresa considere pertinente validar la misma.
                                </p>
                                
                                <div class="my-4">
                                    <h4>Negocios</h4>
                                    <p>1. ¿Tiene algún tipo de negocios vinculado con el giro de negocio de CIDAM?</p>
                                    <div class="form-floating form-floating-outline">
                                        <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                            <option>Sí</option>
                                            <option>No</option>
                                        </select>
                                    </div>

                                    <p>2. ¿Tiene algún tipo de negocio en conjunto, con alguno de los clientes de CIDAM?</p>
                                    <div class="form-floating form-floating-outline">
                                        <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                            <option>Sí</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="my-4">
                                    <h4>Personal</h4>
                                    <p>3. ¿Mantiene usted alguna relación sentimental con, algún miembro del CIDAM?</p>
                                    <div class="form-floating form-floating-outline">
                                        <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                            <option>Sí</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="my-4">
                                    <h4>Familiar</h4>
                                    <p>4.¿Algún familiar suyo (por afinidad o consanguinidad hasta el cuarto grado en línea recta o colateral) mantiene algún tipo de negocios vinculados con el giro de negocio de CIDAM?</p>
                                    <div class="form-floating form-floating-outline">
                                        <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                            <option>Sí</option>
                                            <option>No</option>
                                        </select>
                                    </div>

                                    <p>5. ¿Algún familiar suyo (por afinidad o consanguinidad hasta el cuarto grado en línea recta o colateral) mantiene alguna actividad económica en conjunto, con alguno de los clientes de CIDAM?</p>
                                    <div class="form-floating form-floating-outline">
                                        <select id="selectpickerBasic" class="selectpicker w-100" data-style="btn-default">
                                            <option>Sí</option>
                                            <option>No</option>
                                        </select>
                                    </div>
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