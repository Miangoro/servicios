/**
 * Page User List
 */

'use strict';


$(function () {



    // Variable declaration for table
    var dt_user_table = $('.datatables-users'),

        select2 = $('.select2'),

        offCanvasForm = $('#modalAddDestino');

    if (select2.length) {
        var $this = select2;
        select2Focus($this);
        $this.wrap('<div class="position-relative"></div>').select2({
            placeholder: 'Select Country',
            dropdownParent: $this.parent()
        });
    }
    /* lo del select de arriba lo puedo quitar "creo" */
    // ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Users datatable
    if (dt_user_table.length) {
        var dt_user = dt_user_table.DataTable({

            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl + 'destinos-list', // Asegúrate de que esta URL coincida con la ruta en tu archivo de rutas
                type: 'GET'
            },
            columns: [
                // columns according to JSON
                { data: '' },
                { data: 'id_direccion' },
                { data: 'tipo_direccion' },
                { data: 'id_empresa' },
                { data: 'direccion' },
                { data: 'destinatario' },
                //{ data: 'aduana' },
                { data: 'pais_destino' },
                { data: 'nombre_recibe' },
                { data: 'correo_recibe' },
                { data: 'celular_recibe' },
                { data: 'action' },
            ],

            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    searchable: false,
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    searchable: false,
                    orderable: true,
                    targets: 1,
                    render: function (data, type, full, meta) {
                        return `<span>${full.fake_id}</span>`;
                    }
                },

                {
                    // User full name
                    targets: 2,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $name = full['tipo_direccion'];
                        if ($name == 'Exportación'){
                            return '<span class="badge rounded-pill bg-info">Exportación</span>';
                         }
                         else if($name == 'Nacional'){ 
                                return '<span class="badge rounded-pill bg-primary">Nacional</span>';
                         }
                         else if($name == 'Hologramas'){ 
                            return '<span class="badge rounded-pill bg-danger">Hologramas</span>';
                        }

                        // For Avatar badge
                        var stateNum = Math.floor(Math.random() * 6);
                        var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                        var $state = states[stateNum];

                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-start align-items-center user-name">' +
                            '<div class="avatar-wrapper">' +
                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<span class="fw-medium">' +
                            $name +
                            '</span>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },

                {
                    // Actions botones de eliminar y actualizar(editar)
                    targets: -1,
                    title: 'Acciones',
                    searchable: false,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="d-flex align-items-center gap-50">' +
                            '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
                            '<div class="dropdown-menu dropdown-menu-end m-0">' +
                            `<a data-id="${full['id_direccion']}" data-bs-toggle="modal" data-bs-target="#modalEditDestino" href="javascrip:;" class="dropdown-item edit-record text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
                            `<a data-id="${full['id_direccion']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>` +
                            '<div class="dropdown-menu dropdown-menu-end m-0">' +
                            '<a href="javascript:;" class="dropdown-item">Suspend</a>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                }
            ],

            order: [[2, 'desc']],
            dom:
                '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
                '<"me-5 ms-n2"f>' +
                '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-4"lB>>' +
                '>t' +
                '<"row mx-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            lengthMenu: [10, 20, 50, 70, 100], //for length of menu
            language: {
                sLengthMenu: '_MENU_',
                search: '',
                searchPlaceholder: 'Buscar',
                info: 'Mostrar _START_ a _END_ de _TOTAL_ registros',
                paginate: {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                }
            },

            // Buttons with Dropdown
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
                    text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
                    buttons: [
                        {
                            extend: 'print',
                            title: 'Direcciones de destinos',
                            text: '<i class="ri-printer-line me-1" ></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be print
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {

                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }
                                        });

                                        return result;
                                    }
                                }
                            },
                            customize: function (win) {
                                //customize print view for dark
                                $(win.document.body)
                                    .css('color', config.colors.headingColor)
                                    .css('border-color', config.colors.borderColor)
                                    .css('background-color', config.colors.body);
                                $(win.document.body)
                                    .find('table')
                                    .addClass('compact')
                                    .css('color', 'inherit')
                                    .css('border-color', 'inherit')
                                    .css('background-color', 'inherit');
                            }
                        },
                        {
                            extend: 'csv',
                            title: 'Direcciones de destinos',
                            text: '<i class="ri-file-text-line me-1" ></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be print
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {

                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }

                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            title: 'Direcciones de destinos',
                            text: '<i class="ri-file-excel-line me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Direcciones de destinos',
                            text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            title: 'Direcciones de destinos',
                            text: '<i class="ri-file-copy-line me-1"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                                // prevent avatar to be copy
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                if (item.lastChild && item.lastChild.firstChild) {
                                                    result = result + item.lastChild.firstChild.textContent;
                                                }
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else {
                                                result = result + item.innerText;
                                            }
                                        });
                                        return result;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar Destino</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#modalAddDestino'
                    }
                }
            ],


            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Detalles del destino ';
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');

                        return data ? $('<table class="table"/><tbody />').append(data) : false;
                    }
                }
            }

        });
    }

    var dt_user_table = $('.datatables-users'),
        select2Elements = $('.select2'),
        userView = baseUrl + 'app/user/view/account'
    // Función para inicializar Select2 en elementos específicos
    function initializeSelect2($elements) {
        $elements.each(function () {
            var $this = $(this);
            select2Focus($this);
            $this.wrap('<div class="position-relative"></div>').select2({
                dropdownParent: $this.parent()
            });
        });
    }

    initializeSelect2(select2Elements);


    // Delete Record
    $(document).on('click', '.delete-record', function () {
        var id_destino = $(this).data('id'); // Obtener el ID de la clase
        var dtrModal = $('.dtr-bs-modal.show');

        // Ocultar modal responsivo en pantalla pequeña si está abierto
        if (dtrModal.length) {
            dtrModal.modal('hide');
        }

        // SweetAlert para confirmar la eliminación
        Swal.fire({
            title: '¿Está seguro?',
            text: 'No podrá revertir este evento',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.isConfirmed) {
                // Enviar solicitud DELETE al servidor
                $.ajax({
                    type: 'DELETE',
                    url: `${baseUrl}destinos-list/${id_destino}`,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        // Actualizar la tabla después de eliminar el registro
                        dt_user.draw();

                        // Mostrar SweetAlert de éxito
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminado!',
                            text: '¡La direccion ha sido eliminada correctamente!',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    },
                    error: function (error) {
                        // Mostrar SweetAlert de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo eliminar la direccion. Inténtalo de nuevo más tarde.',
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }

                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Acción cancelada, mostrar mensaje informativo
                Swal.fire({
                    title: 'Cancelado',
                    text: 'La eliminación de la direccion ha sido cancelada',
                    icon: 'info',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    }
                });
            }
        });
    });



    /* agregar nuevo direccion de destino */
    $(document).ready(function () {
        // Configuración CSRF para Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inicializar FormValidation
        const addNewDestino = document.getElementById('addNewDestinoForm');
        const fv = FormValidation.formValidation(addNewDestino, {
            fields: {
                id_empresa: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor selecciona la empresa cliente'
                        }
                    }
                },
                tipo_direccion: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor selecciona el tipo de dirección'
                        }
                    }
                },
                direccion: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor selecciona una dirección'
                        }
                    }
                },
                // Campos de Exportación
                destinatario: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor ingresa el destinatario'
                        }
                    }
                },
                /*aduana: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor ingresa la aduana'
                        }
                    }
                },*/
                pais_destino: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor ingresa el país de destino'
                        }
                    }
                },
                // Campos de Envío de Hologramas
                correo_recibe: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor ingresa el correo de quien recibe'
                        },
                        emailAddress: {
                            message: 'Por favor ingresa un correo válido'
                        }
                    }
                },
                nombre_recibe: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor ingresa el nombre de quien recibe'
                        }
                    }
                },
                celular_recibe: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor ingresa el celular de quien recibe'
                        },
                        regexp: {
                            regexp: /^(\+52)?\s?\d{2}\s?\d{4}\s?\d{4}$/,
                            message: 'El número de teléfono debe ser válido (ejemplo: +52 55 1234 5678 o 55 1234 5678)'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    eleInvalidClass: 'is-invalid',
                    rowSelector: function (field, ele) {
                        return '.form-floating';
                    }
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            }
        });

        // Manejar el cambio del tipo de dirección
        function handleDireccionChange() {
            var tipoDireccion = $('#tipo_direccion').val();

            // Ocultar todos los campos primero
            $('#exportacionFields, #hologramasFields').hide();

            // Mostrar los campos correspondientes y habilitar/deshabilitar validaciones
            if (tipoDireccion === '1') { // Exportación
                $('#exportacionFields').show();
                // Habilitar validaciones para Exportación
                fv.enableValidator('destinatario');
                //fv.enableValidator('aduana');
                fv.enableValidator('pais_destino');
                // Deshabilitar validaciones de Envío de Hologramas
                fv.disableValidator('correo_recibe');
                fv.disableValidator('nombre_recibe');
                fv.disableValidator('celular_recibe');
            } else if (tipoDireccion === '3') { // Envío de Hologramas
                $('#hologramasFields').show();
                // Habilitar validaciones para Envío de Hologramas
                fv.enableValidator('correo_recibe');
                fv.enableValidator('nombre_recibe');
                fv.enableValidator('celular_recibe');
                // Deshabilitar validaciones de Exportación
                fv.disableValidator('destinatario');
                //fv.disableValidator('aduana');
                fv.disableValidator('pais_destino');
            } else {
                // Deshabilitar todas las validaciones específicas
                fv.disableValidator('destinatario');
                //fv.disableValidator('aduana');
                fv.disableValidator('pais_destino');
                fv.disableValidator('correo_recibe');
                fv.disableValidator('nombre_recibe');
                fv.disableValidator('celular_recibe');
            }
        }

        // Ejecutar la función al cambiar el valor y al cargar la página
        $('#tipo_direccion').change(handleDireccionChange);
        handleDireccionChange();

        // Escuchar el evento de formulario válido
        fv.on('core.form.valid', function () {
            // Solo enviar el formulario si es válido
            var formData = new FormData(addNewDestino);

            $.ajax({
                url: '/destinos-list',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    addNewDestino.reset();
                    $('#id_empresa').val('').trigger('change');
                    $('#modalAddDestino').modal('hide');
                    $('.datatables-users').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Error al agregar el predio',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        });

        // Bloquear el envío normal del formulario
        $('#addNewDestinoForm').on('submit', function (e) {
            e.preventDefault();
            // Inicia el proceso de validación
            fv.validate();
        });

    });










    $(document).on('click', '.edit-record', function () {
        var idDireccion = $(this).data('id');

        $.ajax({
            url: '/destinos-list/' + idDireccion + '/edit',
            method: 'GET',
            success: function (data) {
                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                    return;
                }

                $('#edit_tipo_direccion').val(data.tipo_direccion).trigger('change');
                $('#edit_id_empresa').val(data.id_empresa).trigger('change');
                $('#edit_direccion').val(data.direccion);

                if (data.tipo_direccion == '1') { // Exportación
                    $('#exportacionFieldsEdit').show();
                    $('#hologramasFieldsEdit').hide();
                    $('#edit_destinatario').val(data.destinatario);
                    //$('#edit_aduana').val(data.aduana);
                    $('#edit_pais_destino').val(data.pais_destino);
                } else if (data.tipo_direccion == '3') { // Envío de Hologramas
                    $('#hologramasFieldsEdit').show();
                    $('#exportacionFieldsEdit').hide();
                    $('#edit_correo_recibe').val(data.correo_recibe);
                    $('#edit_nombre_recibe').val(data.nombre_recibe);
                    $('#edit_celular_recibe').val(data.celular_recibe);
                } else {
                    $('#exportacionFieldsEdit').hide();
                    $('#hologramasFieldsEdit').hide();
                }

                $('#modalEditDestino').modal('show');
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar los datos del destino.',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            }
        });
    });

    $('#modalEditDestino').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        var modal = $(this);
        modal.find('#edit_destinos_id').val(id);
    });

    $(document).ready(function () {
        const editDestinoForm = document.getElementById('EditDestinoForm');

        if (editDestinoForm) {
            const formValidationInstance = FormValidation.formValidation(editDestinoForm, {
                fields: {
                    'tipo_direccion': {
                        validators: {
                            notEmpty: {
                                message: 'Selecciona el tipo de dirección.'
                            }
                        }
                    },
                    'id_empresa': {
                        validators: {
                            notEmpty: {
                                message: 'Selecciona una empresa cliente.'
                            }
                        }
                    },
                    'direccion': {
                        validators: {
                            notEmpty: {
                                message: 'Ingresa la dirección.'
                            }
                        }
                    },
                    'destinatario': {
                        validators: {
                            notEmpty: {
                                message: 'El destinatario es obligatorio.',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '1'; // Exportación
                                }
                            }
                        }
                    },
                    /*'aduana': {
                        validators: {
                            notEmpty: {
                                message: 'La aduana es obligatoria.',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '1'; // Exportación
                                }
                            }
                        }
                    },*/
                    'pais_destino': {
                        validators: {
                            notEmpty: {
                                message: 'El país de destino es obligatorio.',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '1'; // Exportación
                                }
                            }
                        }
                    },
                    'correo_recibe': {
                        validators: {
                            notEmpty: {
                                message: 'El correo del receptor es obligatorio.',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '3'; // Hologramas
                                }
                            },
                            emailAddress: {
                                message: 'Ingrese una dirección de correo electrónico válida.',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '3'; // Hologramas
                                }
                            }
                        }
                    },
                    'nombre_recibe': {
                        validators: {
                            notEmpty: {
                                message: 'El nombre del receptor es obligatorio.',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '3'; // Hologramas
                                }
                            }
                        }
                    },
                    'celular_recibe': {
                        validators: {
                            notEmpty: {
                                message: 'El número de celular es obligatorio.',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '3'; // Hologramas
                                }
                            },
                            regexp: {
                                regexp: /^(\+52)?\s?\d{2}\s?\d{4}\s?\d{4}$/,
                                message: 'El número de teléfono debe ser válido (ejemplo: +52 55 1234 5678 o 55 1234 5678)',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '3'; // Hologramas
                                }
                            },
                            phone: {
                                country: 'US',
                                message: 'Ingrese un número de teléfono válido.',
                                enabled: function () {
                                    return $('#edit_tipo_direccion').val() == '3'; // Hologramas
                                }
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        eleInvalidClass: 'is-invalid',
                        rowSelector: '.form-floating'
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                }
            }).on('core.form.valid', function () {
                var formData = new FormData(editDestinoForm);
                var idDestino = $('#edit_destinos_id').val();

                $.ajax({
                    url: '/destinos-update/' + idDestino,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('.datatables-users').DataTable().ajax.reload();
                        $('#modalEditDestino').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: response.message,
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = Object.keys(errors).map(function (key) {
                                return errors[key].join('<br>');
                            }).join('<br>');

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: errorMessages,
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ha ocurrido un error al actualizar la dirección.',
                                customClass: {
                                    confirmButton: 'btn btn-danger'
                                }
                            });
                        }
                    }
                });
            });

            // Manejo de cambio en el tipo de dirección
            $('#edit_tipo_direccion').change(function () {
                var tipoDireccion = $(this).val();
                formValidationInstance.disableValidator('destinatario');
                //formValidationInstance.disableValidator('aduana');
                formValidationInstance.disableValidator('pais_destino');
                formValidationInstance.disableValidator('correo_recibe');
                formValidationInstance.disableValidator('nombre_recibe');
                formValidationInstance.disableValidator('celular_recibe');

                hideAndClearFields('#exportacionFieldsEdit');
                hideAndClearFields('#hologramasFieldsEdit');

                if (tipoDireccion == '1') { // Exportación
                    $('#exportacionFieldsEdit').show();
                    formValidationInstance.enableValidator('destinatario');
                    //formValidationInstance.enableValidator('aduana');
                    formValidationInstance.enableValidator('pais_destino');
                } else if (tipoDireccion == '3') { // Envío de Hologramas
                    $('#hologramasFieldsEdit').show();
                    formValidationInstance.enableValidator('correo_recibe');
                    formValidationInstance.enableValidator('nombre_recibe');
                    formValidationInstance.enableValidator('celular_recibe');
                } else { // Nacional u otro
                    $('#exportacionFieldsEdit').hide();
                    $('#hologramasFieldsEdit').hide();
                }
            });
        }

        function hideAndClearFields(selector) {
            $(selector).hide().find('input, textarea').val('');
        }
    });






});
