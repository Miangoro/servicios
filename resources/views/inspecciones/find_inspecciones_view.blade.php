@extends('layouts.layoutMaster')

@section('title', 'Inspecciones')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
    @vite(['resources/js/inspecciones.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const certificacionSelectAdd = document.getElementById('certificacion');
            const certificadoOtrosDivAdd = document.getElementById('certificado-otros');
            const tipoSelectAdd = document.getElementById('tipo');
            const modalAddInstalacion = document.getElementById('modalAddInstalacion');

            const certificacionSelectEdit = document.getElementById('edit_certificacion');
            const certificadoOtrosDivEdit = document.getElementById('edit_certificado_otros');
            const tipoSelectEdit = document.getElementById('edit_tipo');
            const modalEditInstalacion = document.getElementById('modalEditInstalacion');

            function toggleCertificadoOtros(selectElement, divElement) {
                if (selectElement.value === 'otro_organismo') {
                    divElement.classList.remove('d-none');
                } else {
                    divElement.classList.add('d-none');
                }
            }

            function updateDocumentFields(tipoSelect, divElement) {
                const hiddenIdDocumento = divElement.querySelector('input[name="id_documento[]"]');
                const hiddenNombreDocumento = divElement.querySelector('input[name="nombre_documento[]"]');
                const fileCertificado = divElement.querySelector('input[type="file"]');

                switch (tipoSelect.value) {
                    case 'productora':
                        hiddenIdDocumento.value = '127';
                        hiddenNombreDocumento.value = 'Certificado de instalaciones';
                        fileCertificado.setAttribute('id', 'file-127');
                        break;
                    case 'envasadora':
                        hiddenIdDocumento.value = '128';
                        hiddenNombreDocumento.value = 'Certificado de envasadora';
                        fileCertificado.setAttribute('id', 'file-128');
                        break;
                    case 'comercializadora':
                        hiddenIdDocumento.value = '129';
                        hiddenNombreDocumento.value = 'Certificado de comercializadora';
                        fileCertificado.setAttribute('id', 'file-129');
                        break;
                    default:
                        hiddenIdDocumento.value = '';
                        hiddenNombreDocumento.value = '';
                        fileCertificado.removeAttribute('id');
                        break;
                }
            }

            function setupEventListeners() {
                // Add modal event listeners
                certificacionSelectAdd.addEventListener('change', function() {
                    toggleCertificadoOtros(certificacionSelectAdd, certificadoOtrosDivAdd);
                });

                tipoSelectAdd.addEventListener('change', function() {
                    updateDocumentFields(tipoSelectAdd, certificadoOtrosDivAdd);
                });

                modalAddInstalacion.addEventListener('shown.bs.modal', function() {
                    certificacionSelectAdd.value = '';
                    $(certificacionSelectAdd).trigger('change');
                    tipoSelectAdd.value = '';
                    $(tipoSelectAdd).trigger('change');
                    certificadoOtrosDivAdd.classList.add('d-none');
                });

                modalAddInstalacion.addEventListener('hidden.bs.modal', function() {
                    certificacionSelectAdd.value = '';
                    $(certificacionSelectAdd).trigger('change');
                    tipoSelectAdd.value = '';
                    $(tipoSelectAdd).trigger('change');
                    certificadoOtrosDivAdd.classList.add('d-none');
                });

                // Edit modal event listeners
                certificacionSelectEdit.addEventListener('change', function() {
                    toggleCertificadoOtros(certificacionSelectEdit, certificadoOtrosDivEdit);
                });

                tipoSelectEdit.addEventListener('change', function() {
                    updateDocumentFields(tipoSelectEdit, certificadoOtrosDivEdit);
                });

                modalEditInstalacion.addEventListener('shown.bs.modal', function() {
                    certificacionSelectEdit.value = '';
                    $(certificacionSelectEdit).trigger('change');
                    tipoSelectEdit.value = '';
                    $(tipoSelectEdit).trigger('change');
                    certificadoOtrosDivEdit.classList.add('d-none');
                });

                modalEditInstalacion.addEventListener('hidden.bs.modal', function() {
                    certificacionSelectEdit.value = '';
                    $(certificacionSelectEdit).trigger('change');
                    tipoSelectEdit.value = '';
                    $(tipoSelectEdit).trigger('change');
                    certificadoOtrosDivEdit.classList.add('d-none');
                });
            }

            setupEventListeners();
        });
    </script>

    <style>
        .text-primary {
            color: #262b43 !important;
        }
    </style>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0 fw-bold">Inspecciones de la Unidad de Inspección</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table style="font-size: 14px" class="datatables-users table table-bordered  table-hover">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>Folio</th>
                        <th>No. de servicio</th>
                        <th>Cliente</th>
                        {{-- <th>Fecha de solicitud</th> --}}
                        <th>Solicitud</th>
                        <th>Domicilio de inspección</th>
                        <th>Fecha y hora de visita estimada</th>
                        <th>Inspector asignado</th>
                        <th>Fecha y hora de inspección</th>
                        <th>Acta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>





        <!-- Modal -->
        @include('_partials._modals.modal-pdfs-frames')
        @include('_partials._modals.modal-expediente-servicio')
        @include('_partials._modals.modal-validad-solicitud')
        @include('_partials._modals.modal-add-asignar-inspector')
        @include('_partials._modals.modal-trazabilidad')
        @include('_partials._modals.modal-add-resultados-inspeccion')
        @include('_partials._modals.modal-export-excel-inspecciones')



        <!-- Modal -->

    </div>
@endsection

<script>
    function abrirModal(id_solicitud, id_inspeccion, tipo, nombre_empresa, id_tipo, folio, noservicio, inspectorName) {

        $('.id_soli').text(id_solicitud);
        $('.id_deinspeccion').text(id_inspeccion);
        $('.solicitud').text(tipo);
        $('.nombre_empresa').text(nombre_empresa);
        $('.numero_tipo').text(id_tipo);
        $('.folio_solicitud').html('<b class="text-primary">' + (folio) + '</b>');
        $('.numero_servicio').html('<b class="text-primary">' + noservicio + '</b>');
        $('.inspectorName').html(inspectorName);


        const links = [{
                id: '#link_solicitud_servicio',
                href: '{{ url('solicitud_de_servicio') }}/' + id_solicitud
            },
            {
                id: '#link_oficio_comision',
                href: '{{ url('oficio_de_comision') }}/' + id_inspeccion
            },
            {
                id: '#link_orden_servicio',
                href: '{{ url('orden_de_servicio') }}/' + id_inspeccion
            },
            {
                id: '#links_etiquetas',
                href: ''
            }
        ];

        // Restaurar enlaces e íconos
        links.forEach(link => {
            if (link.id !== '#links_etiquetas') { // se maneja aparte por id_tipo
                $(link.id)
                    .attr('href', link.href)
                    .removeClass('text-secondary opacity-50')
                    .find('i')
                    .removeClass('text-secondary opacity-50')
                    .addClass('text-danger');
            } else {
                $(link.id)
                    .removeClass('text-secondary opacity-50')
                    .find('i')
                    .removeClass('text-secondary opacity-50')
                    .addClass('text-danger');
            }
        });

        // Etiquetas específicas según tipo
        let etiquetaHref = '';
        let etiquetaTexto = 'Etiquetas';

        switch (parseInt(id_tipo)) {
            case 1:
                etiquetaHref = '{{ url('etiqueta_agave_art') }}/' + id_solicitud;
                etiquetaTexto = 'Etiqueta para agave (%ART)';
                break;
            case 3:
                etiquetaHref = '{{ url('etiquetas_tapas_sellado') }}/' + id_solicitud;
                etiquetaTexto = 'Etiqueta para tapa de la muestra';
                break;
            case 4:
            case 5:
                etiquetaHref = '{{ url('etiqueta_lotes_mezcal_granel') }}/' + id_solicitud;
                etiquetaTexto = 'Etiqueta para lotes de mezcal a granel';
                break;
            case 7:
                etiquetaHref = '{{ url('etiqueta-barrica') }}/' + id_solicitud;
                etiquetaTexto = 'Etiqueta de ingreso a barricas';
                break;
        }

        if (etiquetaHref !== '') {
            $('#links_etiquetas').attr('href', etiquetaHref);
            $('.etiqueta_name').text(etiquetaTexto);
            $('.etiquetasNA').show(); // mostrar el tr
        } else {
            $('.etiquetasNA').hide(); // ocultar el tr
        }

        $.ajax({
            url: '/getDocumentosSolicitud/' +
            id_solicitud, // URL del servidor (puede ser .php, .json, .html, etc.)
            type: 'GET', // O puede ser 'GET'
            dataType: 'json', // Puede ser 'html', 'text', 'json', etc.
            success: function(response) {
                if (response.success) {

                    const documentos = response.data;
                    const fqs = response.fqs;
                    const url_etiqueta = response.url_etiqueta;
                    const urls_certificados = response.url_certificado;
                    const url_corrugado = response.url_corrugado;
                    const url_evidencias = response.url_evidencias;
                    let html = `
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" colspan="2">Documentación de la solicitud</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    if (documentos.length > 0) {
                        documentos.forEach(function(doc) {
                            let carpeta = '';
                            if (doc.id_documento == 69 || doc.id_documento == 70) {
                                carpeta = 'actas/';
                            }
                            html += `
                            <tr>
                                <td>${doc.nombre}</td>
                                <td>
                                    <a href="/files/${response.numero_cliente}/${carpeta}${doc.url}" target="_blank">
                                        <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                    </a>
                                </td>
                            </tr>`;
                        });
                    } else {
                        html += `<tr><td colspan="2">No se encontraron documentos.</td></tr>`;
                    }

                    if (urls_certificados && urls_certificados.length > 0) {
                        urls_certificados.forEach(function(url) {
                            html += `
                                    <tr>
                                        <td>Certificado de granel</td>
                                        <td>
                                            <a href="/files/${response.numero_cliente}/certificados_granel/${url}" target="_blank">
                                                <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                            </a>
                                        </td>
                                    </tr>`;
                        });
                    }


                    if (fqs) {
                        fqs.forEach(function(fq) {
                            html += `
                            <tr>
                                <td>${fq.nombre_documento}</td>
                                <td>
                                    <a href="/files/${response.numero_cliente_lote}/fqs/${fq.url}" target="_blank">
                                        <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                    </a>
                                </td>
                            </tr>`;
                        });
                    }

                    if (url_etiqueta) {

                        html += `
                            <tr>
                                <td>Etiqueta</td>
                                <td>
                                    <a href="/files/${response.numero_cliente}/${url_etiqueta}" target="_blank">
                                        <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                    </a>
                                </td>
                            </tr>`;

                    }

                    if (url_corrugado) {

                        html += `
                            <tr>
                                <td>Corrugado</td>
                                <td>
                                    <a href="/files/${response.numero_cliente}/${url_corrugado}" target="_blank">
                                        <i class="ri-file-pdf-2-fill ri-40px text-danger"></i>
                                    </a>
                                </td>
                            </tr>`;

                    }


                    html += `</tbody></table>`;
                    $('#contenedor-documentos').html(html);
                }
            },


            error: function(xhr, status, error) {
                // Aquí si algo salió mal
                console.error('Error AJAX:', error);
                $('#contenedor-documentos').html('');
            }
        });

        $('#expedienteServicio').modal('show');


    }

    function abrirModalAsignarInspector(id_solicitud, tipo, nombre_empresa) {
        // Asignar valores iniciales
        $("#id_solicitud").val(id_solicitud);
        $('.solicitud').text(tipo);
        $('#nombre_empresa').text(nombre_empresa); // Mostrar nombre de la empresa en el modal
        $('#solInspecciones').val(null).trigger('change');

        $('#asignarInspector').modal('show');

        $.ajax({
            url: '/getInspeccion/' + id_solicitud,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    console.log(data);

                    if (data) {
                        const solicitud = data;

                        const tabla = `
                        <div class="table-responsive">
                            <table class="table small table-hover table-bordered table-sm">

                                <tbody>
                                    <tr>
                                        <td><b>Folio</b></td>
                                        <td>${solicitud.folio}</td>
                                    </tr>
                                     <tr>
                                        <td><b>Cliente</b></td>
                                        <td>${solicitud.empresa.razon_social}</td>
                                    </tr>
                                </tbody>
                                    <tr>
                                        <td><b>Fecha</b></td>
                                        <td>${solicitud.fecha_solicitud}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Fecha sugerida</b></td>
                                        <td>${solicitud.fecha_visita}</td>
                                    </tr>
                            </table>
                        </div>`;

                        $("#datosSolicitud").html(tabla);
                    } else {
                        $("#datosSolicitud").html(
                            '<div class="alert alert-warning">No hay datos de la solicitud.</div>');
                    }
                    if (data.inspeccion) {
                        $("#id_inspector").val(data.inspeccion.id_inspector).change();
                        $("#num_servicio").val(data.inspeccion.num_servicio || '');
                        $("#fecha_servicio").val(data.inspeccion.fecha_servicio || '');
                        $("#observaciones").text(data.inspeccion.observaciones || '');
                    } else {

                        $("#num_servicio").val('');
                        $("#fecha_servicio").val('');
                        $("#observaciones").text('');
                    }


                } else {
                    alert('No se pudieron obtener los datos de la solicitud.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', error);
                alert('Hubo un error al obtener los datos.');
            }
        });
    }


    function abrirModalActaProduccion(id_inspeccion, tipo, nombre_empresa, id_empresa, direccion_completa,
        tipo_instalacion) {

        $(".id_inspeccion").val(id_inspeccion);
        $(".direccion_completa").val(direccion_completa);
        $(".tipo_instalacion").val(tipo_instalacion);
        $(".id_empresa").val(id_empresa);
        $('.solicitud').text(tipo);
        obtenerNombrePredio();
        $('#ActaUnidades').modal('show');
        initializeModalFunctionality();
        Testigos();
    }



    function editModalActaProduccion(id_acta) {
        $.get('/acta-solicitud/edit/' + id_acta, function(data) {
            // Rellenar el formulario con los datos obtenidos
            $('.edit_id_acta').val(data.id_acta);
            $('#edit_num_acta').val(data.num_acta);
            $('#edit_categoria_acta').val(data.categoria_acta);
            $('#edit_encargado').val(data.encargado);
            $('#edit_num_credencial_encargado').val(data.num_credencial_encargado);
            $('#edit_lugar_inspeccion').val(data.lugar_inspeccion);
            $('#edit_fecha_inicio').val(data.fecha_inicio);
            $('#edit_fecha_fin').val(data.fecha_fin);
            $('#edit_no_conf_infraestructura').val(data.no_conf_infraestructura);
            $('#edit_no_conf_equipo').val(data.no_conf_equipo);

            // EDIT TESTIGOS
            $('#edit_testigoss').empty();

            // Iterar sobre los testigos y agregar filas a la tabla
            data.actas_testigo.forEach(function(testigo, index) {
                var newRow = `
                <tr>
                    <th>
                        <button type="button" class="btn btn-danger remove-row" ${index === 0 ? 'disabled' : ''}>
                            <i class="ri-delete-bin-5-fill"></i>
                        </button>
                    </th>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="edit_nombre_testigo[]" value="${testigo.nombre_testigo}" />
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="edit_domicilio[]" value="${testigo.domicilio}" />
                    </td>
                </tr>
            `;
                $('#edit_testigoss').append(newRow);
            });

            // EDIT PRODUCCION AGAVE
            $('#edit_unidadProduccion').empty();

            // Iterar sobre los testigos y agregar filas a la tabla
            data.actas_produccion.forEach(function(plantacion, index) {
                var newRow = `
        <tr>
            <th>
                <button type="button" class="btn btn-danger remove-row" ${index === 0 ? 'disabled' : ''}>
                    <i class="ri-delete-bin-5-fill"></i>
                </button>
            </th>
            <td>
                <input type="text" class="form-control form-control-sm" name="edit_id_empresa[]" value="${plantacion.id_plantacion}" />
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" name="edit_plagas[]" value="${plantacion.plagas}" />
            </td>
        </tr>
    `;
                $('#edit_unidadProduccion').append(newRow);
            });

            //EQUIPO MEZCAL
            //EQUIPO MEZCAL
            $('#edit_equipoMezcal').empty();

            // Iterar sobre los testigos y agregar filas a la tabla
            data.actas_equipo_mezcal.forEach(function(equipoMezcal, index) {
                var newRow = `
        <tr>
            <th>
                <button type="button" class="btn btn-danger remove-row" ${index === 0 ? 'disabled' : ''}>
                    <i class="ri-delete-bin-5-fill"></i>
                </button>
            </th>
            <td>
                <select class="form-control select2" name="edit_equipo[]">
                    <option value="" selected>Selecciona equipo</option>
                    <option value="${equipoMezcal.equipo}" selected>${equipoMezcal.equipo}</option>
                    @foreach ($equipos as $equipo)
                        @if ('${equipoMezcal.equipo}' != $equipo->edit_equipo)
                            <option value="{{ $equipo->edit_equipo }}">{{ $equipo->equipo }}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" name="edit_cantidad[]" value="${equipoMezcal.cantidad}" />
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" name="edit_capacidad[]" value="${equipoMezcal.capacidad}" />
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" name="edit_tipo_material[]" value="${equipoMezcal.tipo_material}" />
            </td>
        </tr>
    `;
                $('#edit_equipoMezcal').append(newRow);
            });

            //EQUIPO ENVASADO
            $('#edit_equipoEnvasado').empty();

            // Iterar sobre los testigos y agregar filas a la tabla
            data.actas_equipo_envasado.forEach(function(equipoEnvasado, index) {
                var newRow = `
        <tr>
            <th>
                <button type="button" class="btn btn-danger remove-row" ${index === 0 ? 'disabled' : ''}>
                    <i class="ri-delete-bin-5-fill"></i>
                </button>
            </th>
            <td>
            <select class="form-control select2" name="edit_equipo_envasado[]">
                <option value="" selected>Selecciona equipo</option>
                <option value="${equipoEnvasado.equipo_envasado}" selected>${equipoEnvasado.equipo_envasado}</option>
                @foreach ($equipos as $equipo)
                    @if ('${equipoEnvasado.equipo_envasado}' != $equipo->edit_equipo_envasado)
                        <option value="{{ $equipo->edit_equipo_envasado }}">{{ $equipo->equipo }}</option>
                    @endif
                @endforeach
            </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" name="edit_cantidad_envasado[]" value="${equipoEnvasado.cantidad_envasado}" />
            </td>
                        <td>
                <input type="text" class="form-control form-control-sm" name="edit_capacidad_envasado[]" value="${equipoEnvasado.capacidad_envasado}" />
            </td>
                        <td>
                <input type="text" class="form-control form-control-sm" name="edit_tipo_material_envasado[]" value="${equipoEnvasado.tipo_material_envasado}" />
            </td>
        </tr>
    `;
                $('#edit_equipoEnvasado').append(newRow);
            });

            //UNIDAD MEZCAL
            $('#edit_unidadMezcal').empty();
            var newRow = `<tr>
                            `;
            // Iterar sobre los testigos y agregar filas a la tabla
            var c = "";
            var nc = "";
            var na = "";
            data.acta_produccion_mezcal.forEach(function(mezcal, index) {
                if (mezcal.respuesta == 'C') {
                    c = "selected";
                    nc = "";
                    na = "";
                }
                if (mezcal.respuesta == 'NC') {
                    nc = "selected";
                    na = "";
                    c = "";
                }
                if (mezcal.respuesta == 'NA') {
                    na = "selected";
                    nc = "";
                    c = "";
                }

                newRow += `
                            <td>
                                <select class="form-control" name="edit_respuesta[]">
                                    <option value="" selected>Selecciona</option>
                                    <option ` + c + ` value="C">C</option>
                                    <option ` + nc + ` value="NC">NC</option>
                                    <option ` + na + ` value="NA">NA</option>
                                </select>
                            </td>
                    `;
            });

            //UNIDAD ENVASADO
            $('#edit_unidadMezcal').append(newRow);
            newRow += `</tr>`;
            $('#edit_unidadEnvasado').empty();
            var newRow = `<tr>
                            `;
            // Iterar sobre los testigos y agregar filas a la tabla
            var c = "";
            var nc = "";
            var na = "";
            data.actas_unidad_envasado.forEach(function(enva, index) {
                if (enva.respuestas == 'C') {
                    c = "selected";
                    nc = "";
                    na = "";
                }
                if (enva.respuestas == 'NC') {
                    nc = "selected";
                    na = "";
                    c = "";
                }
                if (enva.respuestas == 'NA') {
                    na = "selected";
                    nc = "";
                    c = "";
                }

                newRow += `
                            <td>
                                <select class="form-control" name="edit_respuestas[]">
                                    <option value="" selected>Selecciona</option>
                                    <option ` + c + ` value="C">C</option>
                                    <option ` + nc + ` value="NC">NC</option>
                                    <option ` + na + ` value="NA">NA</option>
                                </select>
                            </td>
                    `;
            });

            $('#edit_unidadEnvasado').append(newRow);

            newRow += `</tr>`;

            //UNIDAD COMERCIALIZAION
            $('#edit_unidadComercializadora').empty();

            var newRow = `<tr>
                    `;

            // Iterar sobre los testigos y agregar filas a la tabla
            var c = "";
            var nc = "";
            var na = "";
            data.actas_unidad_comercializacion.forEach(function(comer, index) {
                if (comer.respuestas_comercio == 'C') {
                    c = "selected";
                    nc = "";
                    na = "";
                }
                if (comer.respuestas_comercio == 'NC') {
                    nc = "selected";
                    na = "";
                    c = "";
                }
                if (comer.respuestas_comercio == 'NA') {
                    na = "selected";
                    nc = "";
                    c = "";
                }

                newRow += `
                    <td>
                        <select class="form-control" name="edit_respuestas_comercio[]">
                            <option value="" selected>Selecciona</option>
                            <option ` + c + ` value="C">C</option>
                            <option ` + nc + ` value="NC">NC</option>
                            <option ` + na + ` value="NA">NA</option>
                        </select>
                    </td>
            `;
            });

            $('#edit_unidadComercializadora').append(newRow);
            newRow += `</tr>`;
            // Mostrar el modal de edición
            $('#editActaUnidades').modal('show');
        });
        // Cualquier otra lógica adicional
        /*         edit_obtenerNombrePredio();
         */
        edit_Testigos();
        iniciarCategorias();
    }







    //modal resulatdos
    function abrirModalSubirResultados(id_solicitud, nombre_empresa, folio, inspectorName, num_servicio) {

        $(".id_solicitud").val(id_solicitud);
        $("#nombre_documento").val('Acta de inspección ' + num_servicio);
        $(".num_servicio").text(num_servicio);

        $('.nombre_empresa').text(nombre_empresa);
        $('.folio_solicitud').html('<b class="text-primary">' + (folio) + '</b>');
        $('.inspectorName').html(inspectorName);

        $('#resultadosInspeccion').modal('show');
    }


    function abrirModalTrazabilidad(id_solicitud, tipo, nombre_empresa) {
        // Asignar valores en el modal
        $("#id_solicitud").val(id_solicitud);
        $('.solicitud').text(tipo);

        // Construir la URL para la solicitud AJAX
        var url = baseUrl + 'trazabilidad/' + id_solicitud;

        // Hacer la solicitud AJAX para obtener los logs
        $.get(url, function(data) {
            if (data.success) {
                // Recibir los logs y mostrarlos en el modal
                var logs = data.logs;
                var logsContainer = $('#logsContainer');
                logsContainer.empty(); // Limpiar el contenedor de logs

                // Iterar sobre los logs y agregarlos al contenedor
                logs.forEach(function(log) {
                    logsContainer.append(`

                <li class="timeline-item timeline-item-transparent">
                    <span class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                        <div class="timeline-header mb-3">
                        <h6 class="mb-0">${log.description}</h6>
                        <small class="text-muted">${log.created_at}</small>
                        </div>
                        <p class="mb-2">  ${log.contenido}</p>
                        <div class="d-flex align-items-center mb-1">

                        </div>
                    </div>
                    </li><hr>
                `);
                });

                // Mostrar el modal
                $('#trazabilidad').modal('show');
            }
        }).fail(function(xhr) {
            console.error(xhr.responseText);
        });
    }
</script>
