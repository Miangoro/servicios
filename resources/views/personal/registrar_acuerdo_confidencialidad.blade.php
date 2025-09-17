@extends('layouts/layoutMaster')

@section('title', 'Registrar acuerdo de confidencialidad')

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
        'resources/js/registrarConfidencialidad.js',
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
                            <span class="iconify text-normal" data-icon="fa7-solid:file-signature" data-inline="false" style="font-size: 30px;"></span>
                            <div class="mx-2">
                                <h3 class="mb-0"><b>Acuerdo de imparcialidad, confidencialidad y ética.</b></h3>
                            </div>
                        </div>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div>
                        <form id="form-agregar-conflicto-interes">
                            @csrf

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
                                
                                <div class="card shadow-none  border border-secondary">
                                    <div class="text-center bg-secondary-subtle card-header">
                                        <h3 class="card-title">Acuerdo de imparcialidad, confidencialidad y ética</h3>
                                    </div>
                                    <div class="card-body p-6">
                                        
                                        <p class="card-text">Se celebra y entra en vigencia en la fecha de su firma</p>

                                        <div class="form-floating form-floating-outline col-md-4 my-6">
                                            <input type="text" class="form-control" id="puestoInput" name="puesto" placeholder="Puesto" aria-describedby="floatingInputHelp" />
                                            <label for="versionInput">Escribe aquí tu puesto:</label>
                                        </div>

                                        <p class="card-text">Entre: El <strong>Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.</strong>
                                        en lo sucesivo “EL CIDAM, A.C.”, constituido en y que opera de acuerdo con las leyes de los Estados Unidos Mexicanos,
                                        cuya dirección es Kilometro 8 antigua carretera a Pátzcuaro, S/N Col. Otra no Especificada en el Catálogo C.P. 58341, Morelia Michoacán. <br>
                                        <br>
                                        Y: La/El C. <strong class="text-danger">{{$empleado->nombre}}</strong> en lo sucesivo “EL COLABORADOR”, persona física con dirección principal en <strong>Morelia, Michoacán.</strong> <br>
                                        <br>
                                        A fin de reafirmar mi compromiso con el Centro de Innovación y Desarrollo Agroalimentario de Michoacán, CIDAM, sus clientes y personas ajenas que prestan servicios, me comprometo a seguir lo que a continuación se menciona:</p>
                                        
                                        <h4>IMPARCIALIDAD</h4>
                                        <p class="card-text">
                                            1. No laborar, durante mi estancia en el CIDAM, en alguno de los Organismos Evaluadores de la Conformidad (OEC) que conforman al Centro, en otras organizaciones de competencia comercial, que generen una repercusión negativa en éste o un conflicto de interés.
                                            <br>2. Respetar las restricciones especificadas en los procedimientos técnicos y administrativos, referente a la información que se genera en el área y/o en cualquier OEC en el que me encuentro desarrollando actividades laborales.
                                            <br>3. No aceptar regalos o bonificaciones de ninguna especie por parte de los clientes o proveedores del CIDAM., ni permitir recibir presiones comerciales o financieras.
                                            <br>4. La dirección y todo el personal del CIDAM deben de estar comprometidos con la imparcialidad y la independencia.
                                            <br>5. Mantener imparcialidad en el trato y atención de los clientes, en cada uno de los servicios ofrecidos, sin distinción alguna. Si existiese alguna causa que pudiera generar parcialidad en un servicio, me comprometo a notificar al Director Ejecutivo y/o Responsable de Laboratorio, área, Unidad u Organismo de Certificación de manera inmediata.
                                            <br>6. Identificar los riesgos derivados de las actividades desarrolladas en el área de trabajo y especificarlos en el formato R-UGII-082 evaluación y control de riesgos.
                                            <br>7. Atender a los clientes y a todo visitante del CIDAM de manera amable, respetuosa e igualitaria a fin de evitar un trato preferencial y caer en un acto de parcialidad.
                                            <br>8. No participar directa o indirectamente como proveedor de bienes o servicios requeridos por el CIDAM o el Laboratorio u Organismo de Certificación o las Unidades.
                                            <br>9. Participar en entrevistas, comunicando cualquier hecho que pudiera poner en riesgo la confianza del CIDAM y del Laboratorio u Organismo de Certificación y las Unidades.
                                            <br>10. Los OEC de CIDAM, deben ser independientes en la medida en que lo requieran las condiciones bajo las cuales presta sus servicios.
                                        </p>

                                        <h4>CONFIDENCIALIDAD</h4>
                                        <p class="card-text">
                                            Administrar la información confidencial y derechos de propiedad de los clientes, conforme lo establecido en el procedimiento PR-UGII-001
                                            Procedimiento para asegurar la protección de la información confidencial de los clientes, así como la información confidencial que se genera en CIDAM. <br>
                                            <br>
                                            Se notificará al Ingeniero de Calidad cuando el OEC de CIDAM, sea requerido por ley o autorizado por las disposiciones contractuales,
                                            para revelar información confidencial de los resultados de los servicios ofertados o de los análisis. <br>
                                            <br>
                                            La información acerca del cliente, obtenida de fuentes diferentes del cliente (por ejemplo, una persona que presenta una queja, los organismos reglamentarios) debe ser confidencial entre el cliente y el OEC de CIDAM.
                                        </p>

                                         <h4>ÉTICA</h4>
                                        <p class="card-text">
                                           1. Actuar conforme a las normas y principios que de mis actividades profesionales deban respetarse. <br>
                                           2. Brindar un trato amable, respetuoso e igualitario a todo el personal que integra CIDAM. <br>
                                           3. No utilizar las instalaciones del CIDAM y del Laboratorio u Organismo de Certificación o las Unidades,
                                           para realizar actividades extra-laborables sin autorización de la Dirección Ejecutiva. <br>
                                           4. No realizar actividades extra-laborables dentro del horario de trabajo. <br>
                                           5. No extraer de las instalaciones ningún documento, equipo ni otros materiales sin el permiso por escrito del Director Ejecutivo de El CIDAM, A.C. <br>
                                           6. El COLABORADOR no fotografiará ni de ninguna otra forma reproducirá ninguna información a la que haya tenido acceso durante su estancia en El CIDAM, A.C. <br>
                                           7. Conservar en la medida de lo posible la integridad de los recursos y materiales que me proporciona el CIDAM para la realización de mis actividades. <br>
                                        </p>

                                        <h4>SANCIONES DE NO CUMPLIMIENTO DE ESTE DOCUMENTO</h4>
                                        <p>
                                            En caso de detectar actividades dudosas en cualquier nivel de la organización, que pudieran poner en riesgo la integridad del CIDAM,
                                            utilizaré los conductos disponibles (e-mail, teléfono, mensaje, etc.) para denunciar estos hechos a Dirección Ejecutiva, Calidad,
                                            Responsable de Administración, Coordinadores o Responsables de áreas y/o Laboratorios, Gerentes del Organismo Certificador o de las Unidades. <br>
                                            <br>
                                            Dependiendo el impacto de la actividad dudosa se somete una sanción, la cual es designada por la Alta Dirección. <br>
                                            <br>
                                            Hasta cuestiones legales, mismas que se valorará con la alta dirección y socios propietarios del CIDAM.
                                        </p>

                                        <h4>ACUERDO VINCULANTE</h4>
                                        <p>
                                            El presente constituye EL ACUERDO completo entre EL CIDAM, A.C. y El COLABORADOR con respecto al contenido del mismo. EL ACUERDO presente reemplaza toda declaración y entendimiento previo, ya sea escrito u oral.
                                        </p>

                                        <p class="text-center">
                                            <strong>En FÉ de lo cual, EL CIDAM, A.C. y EL COLABORADOR celebran el presente en la ciudad de Morelia, Michoacán a 03 de Enero del 2025</strong>
                                        </p>

                                        <div class="form-floating form-floating-outline">
                                            <select id="selectpickerBasic" class="selectpicker" data-style="btn-default" name="firma">
                                                <option value="Si">No acepto</option>
                                                <option value="No">Acepto</option>
                                            </select>
                                            <label for="selectpickerBasic">Firmar <strong class="text-danger">*</strong></label>
                                        </div>

                                    </div>
                                </div>

                            </div>


                            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                                <button id="AddConfidencialidadBtn" type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
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