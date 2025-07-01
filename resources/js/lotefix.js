/**
 * Page User List
 */
'use strict';



// Agregar nuevo registro
// validating form and updating user's data
const addNewLoteForm = document.getElementById('addNewLoteForm');

// Validación del formulario
const fv = FormValidation.formValidation(addNewLoteForm, {
    fields: {
        id_empresa: {
            validators: {
                notEmpty: {
                    message: 'Por favor seleccione un cliente'
                }
            }
        },
        nombre_lote: {
            validators: {
                notEmpty: {
                    message: 'Por favor introduzca el nombre del lote'
                }
            }
        },
        sku: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un numero de pedido/SKU'
                }
            }
        },
        id_marca: {
            validators: {
                notEmpty: {
                    message: 'Por favor seleccione una marca'
                }
            }
        },
        presentacion: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese una cantidad'
                }
            }
        },
        destino_lote: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un destino de lote'
                }
            }
        },
        cant_botellas: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese una cantidad'
                }
            }
        },
        volumen_total: {
            validators: {
                notEmpty: {
                    message: 'Por favor llene los campos de detino lote y cantidad de botellas'
                }
            }
        },
        lugar_envasado: {
            validators: {
                notEmpty: {
                    message: 'Por favor seleccione un lugar de envasado'
                }
            }
        },


    },
    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: function (field, ele) {
                return '.mb-4, .mb-5, .mb-6'; // Ajusta según las clases de tus elementos
            }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
    }
}).on('core.form.valid', function (e) {
    //e.preventDefault();
    var formData = new FormData(addNewLoteForm);

    $.ajax({
        url: '/lotes-envasado', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#addlostesEnvasado').modal('hide');
            $('.datatables-users').DataTable().ajax.reload();

            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.success,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        },
        error: function (xhr) {
            // Mostrar alerta de error
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al registrar el lote envasado',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
});







$(function () {
    // Datatable (jquery)
    // Variable declaration for table
    var dt_user_table = $('.datatables-users'),
        select2Elements = $('.select2'),
        userView = baseUrl + 'app/user/view/account',
        offCanvasForm = $('#addlostesEnvasado');






    // Función para inicializar Select2 en elementos específicos
    function initializeSelect2($elements) {
        $elements.each(function () {
            var $this = $(this);
            select2Focus($this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'Selecciona cliente',
                dropdownParent: $this.parent()
            });
        });
    }

    // Inicialización de Select2 para elementos con clase .select2
    initializeSelect2(select2Elements);


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
                url: baseUrl + 'lotes-list'
            },
            scrollX: true, // Scroll horizontal
            columns: [
                { data: '' },
                { data: 'id_lote_envasado' },
                {
                    data: null,
                    searchable: true, orderable: false,
                    render: function (data, type, row) {
                        var id_empresa = '';
                        var razon_social = '';

                        if (row.id_empresa != 'N/A') {
                            id_empresa = '<br><span class="fw-bold text-dark small">Número del cliente:</span><span class="small"> ' + row.id_empresa + '</span>';
                        }
                        if (row.razon_social != 'N/A') {
                            razon_social = '<br><span class="fw-bold text-dark small">Nombre del cliente:</span><span class="small"> ' + row.razon_social + '</span>';
                        }

                        return '<span class="fw-bold text-dark small">Número del cliente:</span> <span class="small"> ' + row.id_empresa +
                            '</span><br><span class="fw-bold text-dark small">Nombre del cliente:</span><span class="small"> ' + row.razon_social
                            ;
                    }
                },
                {
                    data: null,
                    searchable: true, orderable: false,
                    render: function (data, type, row) {
                        var id_lote_granel = '';
                        var nombre_lote = '';

                        if (row.id_lote_granel != 'N/A') {
                            id_lote_granel = '<br><span class="fw-bold text-dark small">Lote agranel:</span><span class="small"> ' + row.id_lote_granel + '</span>';
                        }
                        if (row.nombre_lote != 'N/A') {
                            nombre_lote = '<br><span class="fw-bold text-dark small">Lote envasado:</span><span class="small"> ' + row.nombre_lote + '</span>';
                        }

                        return '<span class="fw-bold text-dark small">Agranel:</span> <span class="small"> ' + row.id_lote_granel +
                            '</span><br><span class="fw-bold text-dark small">Envasado:</span><span class="small"> ' + row.nombre_lote
                            ;
                    }
                },
                { data: 'id_marca' },

                                {
                    data: null,
                    searchable: true, orderable: false,
                    render: function (data, type, row) {
                        var cant_botellas = '';
                        var cantt_botellas = '';

                        if (row.cant_botellas != 'N/A') {
                            cant_botellas = '<br><span class="fw-bold text-dark small">Cantidad de botellas:</span><span class="small"> ' + row.cant_botellas + '</span>';
                        }
                        if (row.cantt_botellas != 'N/A') {
                            cantt_botellas = '<br><span class="fw-bold text-dark small">Cantidad de botellas restantes:</span><span class="small"> ' + row.cantt_botellas + '</span>';
                        }

                        return '<span class="fw-bold text-dark small">Inicial:</span> <span class="small"> ' + row.cant_botellas +
                            '</span><br><span class="fw-bold text-dark small">Restantes:</span><span class="small"> ' + row.cantt_botellas
                            ;
                    }
                },

                {
                    data: function (row, type, set) {
                        return row.presentacion + ' ' + row.unidad;
                    }
                },


                {
                    data: null,
                    searchable: true, orderable: false,
                    render: function (data, type, row) {
                        var volumen_total = '';
                        var volumen_total = '';

                        if (row.volumen_total != 'N/A') {
                            volumen_total = '<br><span class="fw-bold text-dark small">Volumen inicial:</span><span class="small"> ' + row.volumen_total + ' </span>';
                        }
                        if (row.volumen_total != 'N/A') {
                            volumen_total = '<br><span class="fw-bold text-dark small">Volumen restante:</span><span class="small"> ' + row.volumen_total + ' </span>';
                        }

                        return '<span class="fw-bold text-dark small">Inicial:</span> <span class="small"> ' + row.volumen_total + ' Litros' +
                            '</span><br><span class="fw-bold text-dark small">Restante:</span><span class="small"> ' + row.volumen_total + ' Litros'
                            ;
                    }
                },

                { data: 'destino_lote' },
                { data: 'lugar_envasado' },
                {
                    data: null,
                    searchable: true, orderable: false,
                    render: function (data, type, row) {
                        var inicial = '';
                        var nuevo = '';

                        if (row.inicial != 'N/A') {
                            inicial = '<br><span class="fw-bold text-dark small">SKU inicial:</span><span class="small"> ' + row.inicial + '</span>';
                        }
                        if (row.nuevo != 'N/A') {
                            nuevo = '<br><span class="fw-bold text-dark small">SKU nuevo:</span><span class="small"> ' + row.nuevo + '</span>';
                        }

                        return '<span class="fw-bold text-dark small">Inicial:</span> <span class="small"> ' + row.inicial +
                            '</span><br><span class="fw-bold text-dark small">Nuevo:</span><span class="small"> ' + row.nuevo
                            ;
                    }
                },
                { data: 'estatus' },//status
                { data: 'action' }
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
                    orderable: false,
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
                        var $name = full['id_empresa'];

                        // For Avatar badge
                        var stateNum = Math.floor(Math.random() * 6);
                        var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
                        var $state = states[stateNum];



                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-start align-items-center user-name">' +
                            '<div class="avatar-wrapper">' +
                            '<div class="avatar avatar-sm me-3">' +

                            '</div>' +
                            '</div>' +
                            '<div class="d-flex flex-column">' +
                            '<a href="' +
                            userView +
                            '" class="text-truncate text-heading"><span class="fw-medium">' +
                            $name +
                            '</span></a>' +
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    // User email
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var $email = full['razon_social'];
                        return '<span class="user-email">' + $email + '</span>';
                    }
                },

                {
                    // email verify
                    targets: 11,
                    className: 'text-center',
                    render: function (data, type, full, meta) {
                        var $verified = full['estatus'];
                        var $colorRegimen;

                        if ($verified == 'Pendiente') {
                            $colorRegimen = 'danger'; // Azulnja
                            /*                       } else if ($verified == 'Pendiente') {
                                                    $colorRegimen = 'danger';  */
                        } else {
                            $colorRegimen = 'secondary'; // Color por defecto si no coincide con ninguno
                        }

                        return `${$verified
                            ? '<span class="badge rounded-pill bg-label-' + $colorRegimen + '">' + $verified + '</span>'
                            : '<span class="badge rounded-pill bg-label-' + $colorRegimen + '">' + $verified + '</span>'
                            }`;
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
                        `<a data-id="${full['id_lote_envasado']}" data-bs-toggle="modal" data-bs-target="#editLoteEnvasado" class="dropdown-item edit-record waves-effect"><i class="ri-edit-box-line ri-20px text-info"></i> Editar lotes envasado</a>` +
                        `<a data-id="${full['id_lote_envasado']}" data-bs-toggle="modal" data-bs-target="#reclasificacion" class="dropdown-item edit-reclasificacion waves-effect "><i class="ri-file-settings-line ri-20px text-success"></i> Reclasificación SKU</a>` +
                        `<a data-id="${full['id_lote_envasado']}" data-bs-toggle="modal" data-bs-target="#" class="dropdown-item edit waves-effect "><i class="ri-file-settings-line ri-20px text-warning"></i> Trazabilidad</a>` +
                        `<a data-id="${full['id_lote_envasado']}" class="dropdown-item delete-record waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar lotes envasados</a>` +
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
                            title: 'Users',
                            text: '<i class="ri-printer-line me-1" ></i>Print',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 7, 8, 9, 10, 11],
                                // prevent avatar to be print
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
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
                            title: 'Users',
                            text: '<i class="ri-file-text-line me-1" ></i>Csv',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 7, 8, 9, 10, 11],
                                // prevent avatar to be print
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'excel',
                            title: 'Users',
                            text: '<i class="ri-file-excel-line me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 7, 8, 9, 10, 11],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Users',
                            text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 7, 8, 9, 10, 11],
                                // prevent avatar to be display
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        },
                        {
                            extend: 'copy',
                            title: 'Users',
                            text: '<i class="ri-file-copy-line me-1"></i>Copy',
                            className: 'dropdown-item',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 7, 8, 9, 10, 11],
                                // prevent avatar to be copy
                                format: {
                                    body: function (inner, coldex, rowdex) {
                                        if (inner.length <= 0) return inner;
                                        var el = $.parseHTML(inner);
                                        var result = '';
                                        $.each(el, function (index, item) {
                                            if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                result = result + item.lastChild.firstChild.textContent;
                                            } else if (item.innerText === undefined) {
                                                result = result + item.textContent;
                                            } else result = result + item.innerText;
                                        });
                                        return result;
                                    }
                                }
                            }
                        }
                    ]
                },
                {
                    text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar nuevo lote de envasado</span>',
                    className: 'add-new btn btn-primary waves-effect waves-light',
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-dismiss': 'modal',
                        'data-bs-target': '#addlostesEnvasado'
                    }
                }
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Detalles de ' + data['id_empresa'];
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
    // Delete Record
    $(document).on('click', '.delete-record', function () {
        var user_id = $(this).data('id'),
            dtrModal = $('.dtr-bs-modal.show');

        // hide responsive modal in small screen
        if (dtrModal.length) {
            dtrModal.modal('hide');
        }

        // sweetalert for confirmation of delete
        Swal.fire({
            title: '¿Está seguro?',
            text: "No podrá revertir este evento",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, eliminar',
            customClass: {
                confirmButton: 'btn btn-primary me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                // delete the data
                $.ajax({
                    type: 'DELETE',
                    url: `${baseUrl}lotes-list/${user_id}`,
                    success: function () {
                        dt_user.draw();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

                // success sweetalert
                Swal.fire({
                    icon: 'success',
                    title: '¡Eliminado!',
                    text: '¡La solicitud ha sido eliminada correctamente!',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelado',
                    text: 'La solicitud no ha sido eliminada',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    });


    $(document).on('click', '.edit-record', function () {

        var id_lote_envasado = $(this).data('id');
        // Realizar la solicitud AJAX para obtener los datos del lote envasado
        $.get('/lotes-envasado/edit/' + id_lote_envasado, function (data) {
            // Rellenar el formulario con los datos obtenidos
            $('#edit_id_lote_envasado').val(data.id_lote_envasado);
            $('#edit_cliente').val(data.id_empresa).trigger('change');
            $('#edit_lote_granel').val(data.id_empresa).trigger('change');
            $('#edit_nombre_lote').val(data.nombre_lote);
            $('#edit_tipo_lote').val(data.tipo_lote);
            $('#edit_sku').val(data.inicial);
            $('#edit_destino_lote').val(data.destino_lote);
            $('#edit_cant_botellas').val(data.cant_botellas);
            $('#edit_presentacion').val(data.presentacion);
            $('#edit_unidad').val(data.unidad);
            $('#edit_volumen_total').val(data.volumen_total);
            $('#edit_Instalaciones').val(data.lugar_envasado).trigger('change');

            // EDIT TESTIGOS
            $('#edit_contenidoGraneles').empty();

            // Iterar sobre los testigos y agregar filas a la tabla
            data.lotes_envasado_granel.forEach(function (lote, index) {
                var newRow = `
                <tr>
                    <th>
                        <button type="button" class="btn btn-danger remove-row" ${index === 0 ? '' : ''}>
                            <i class="ri-delete-bin-5-fill"></i>
                        </button>
                    </th>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="id_lote_granel[]" value="${lote.id_lote_granel}" />
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="volumen_parcial[]" value="${lote.volumen_parcial}" />
                    </td>
                    
                </tr>
            `;
                $('#edit_contenidoGraneles').append(newRow);
            });
            // Mostrar el modal de edición
            $('#editLoteEnvasado').modal('show');
            $('#edit_marca option[value="' + data.id_marca + '').attr('selected', 'selected');

        }).fail(function () {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al obtener los datos del lote envasado',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        });

    });
    /*$(document).on('click', '.pdf', function () {
          var id = $(this).data('id');
          var registro = $(this).data('registro');
              var iframe = $('#pdfViewer');
              iframe.attr('src', '../solicitudinfo_cliente/'+id);
    
              $("#titulo_modal").text("Solicitud de información del cliente");
              $("#subtitulo_modal").text(registro);
              
            
    });*/


});

//update valiacion: en editar
const editLoteEnvasadoForm = document.getElementById('editLoteEnvasadoForm');

// Validación del formulario
const fv2 = FormValidation.formValidation(editLoteEnvasadoForm, {
    fields: {
        edit_cliente: {
            validators: {
                notEmpty: {
                    message: 'Por favor seleccione un cliente'
                }
            }
        },
        edit_tipo_lote: {
            validators: {
                notEmpty: {
                    message: 'Por favor introduzca el nombre del lote'
                }
            }
        },
        edit_lote_granel: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un numero de pedido/SKU'
                }
            }
        },
        edit_nombre_lote: {
            validators: {
                notEmpty: {
                    message: 'Por favor introduzca el nombre del lote'
                }
            }
        },
        edit_sku: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un numero de pedido/SKU'
                }
            }
        },
        edit_marca: {
            validators: {
                notEmpty: {
                    message: 'Por favor seleccione una marca'
                }
            }
        },
        edit_destino_lote: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese un destino de lote'
                }
            }
        },
        edit_cant_botellas: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese una cantidad'
                }
            }
        },
        edit_presentacion: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese una cantidad'
                }
            }
        },

        edit_unidad: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese una cantidad'
                }
            }
        },

        edit_volumen_total: {
            validators: {
                notEmpty: {
                    message: 'Por favor llene los campos de detino lote y cantidad de botellas'
                }
            }
        },

    },
    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: function (field, ele) {
                return '.mb-4, .mb-5, .mb-6'; // Ajusta según las clases de tus elementos
            }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
    }
}).on('core.form.valid', function (e) {
    //e.preventDefault();
    var formData = new FormData(editLoteEnvasadoForm);

    $.ajax({
        url: '/lotes-envasado/update/', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#editLoteEnvasado').modal('hide');
            $('.datatables-users').DataTable().ajax.reload();

            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.success,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        },
        error: function (xhr) {
            // Mostrar alerta de error
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al registrar el lote envasado',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
});


$(document).on('click', '.edit-reclasificacion', function () {
    var id_lote_envasado = $(this).data('id');

    $.get('/lotes-envasado/editSKU/' + id_lote_envasado, function (data) {
        // Rellenar el formulario con los datos obtenidos
        $('#id_lote_envasado').val(data.id_lote_envasado);
        $('#edictt_sku').val(data.inicial);
        $('#observaciones').val(data.observaciones);
        $('#nuevo').val(data.nuevo);
        $('#cantt_botellas').val(data.cantt_botellas);


        // Mostrar el modal de edición
        $('#reclasificacion').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.error('Error: ' + textStatus + ' - ' + errorThrown);
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al obtener los datos de la solicitud de holograma',
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
    });
});

/* $('#reclasificacionForm').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    console.log()

    $.ajax({
      url: '/lotes-envasado/updateSKU/',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          title: 'Éxito',
          text: response.success,
          icon: 'success',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
        $('#reclasificacion').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
      },
      error: function (response) {
        console.log(response);

        Swal.fire({
          title: 'Error',
          text: 'Ocurrió un error al actualizar la guía.',
          icon: 'error',
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  }); */


//FUNCION MOSTRAR Y OCULTAR EN EDIT
document.addEventListener('DOMContentLoaded', function () {
    // Evento para el cambio en el select de tipo de lote
    document.getElementById('edit_tipo_lote').addEventListener('change', function () {
        mostrarLotes();
    });
    function mostrarLotes() {

        var tipoLote = document.getElementById('edit_tipo_lote').value;

        if (tipoLote == 'Por un solo lote a granel') {
            document.getElementById('edit_datosOpcion1').style.display = 'block';
            document.getElementById('edit_datosOpcion2').style.display = 'none';
        } else if (tipoLote == 'Por más de un lote a granel') {
            document.getElementById('edit_datosOpcion1').style.display = 'none';
            document.getElementById('edit_datosOpcion2').style.display = 'block';
        } else {
            document.getElementById('edit_datosOpcion1').style.display = 'none';
            document.getElementById('edit_datosOpcion2').style.display = 'none';
        }

    };

    //Ocultar select
    document.addEventListener('DOMContentLoaded', function () {
        const edittipoLoteSelect = document.getElementById('edit_tipo_lote');
        const edit_datosOpcion1 = document.getElementById('edit_datosOpcion1');
        const edit_datosOpcion2 = document.getElementById('edit_datosOpcion2');

        function toggleFields() {
            if (edittipoLoteSelect.value === 'Por un solo lote a granel') {
                edit_datosOpcion1.style.display = 'block'; // Muestra el campo
                edit_datosOpcion2.style.display = 'none';  // Oculta la opción 2
            } else if (edittipoLoteSelect.value === 'Por más de un lote a granel') {
                edit_datosOpcion1.style.display = 'none';  // Oculta el campo
                edit_datosOpcion2.style.display = 'block'; // Muestra la opción 2
            } else {
                edit_datosOpcion1.style.display = 'none';  // Oculta el campo
                edit_datosOpcion2.style.display = 'none';  // Oculta la opción 2
            }
        }

        // Llama a toggleFields cuando se carga la página
        toggleFields();

        // Llama a toggleFields cada vez que cambia el valor del select
        edittipoLoteSelect.addEventListener('change', toggleFields);

        
    });

});



//Añadir row
$(document).ready(function () {
    $('.add-row').click(function () {
        // Verificar si se ha seleccionado un cliente
        if ($("#id_empresa").val() === "") {
            // Mostrar la alerta de SweetAlert2
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Por favor, selecciona un cliente primero.',
                customClass: {
                    confirmButton: 'btn btn-danger'
                },
                buttonsStyling: false // Asegura que los estilos personalizados se apliquen
            });
            return;
        }

        // Si el cliente está seleccionado, añade una nueva fila
        var newRow = `
            <tr>
                <th>
                    <button type="button" class="btn btn-danger remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
                </th>
                <td>
                    <select class="id_lote_granel form-control select2-nuevo id_lote_granel" name="id_lote_granel[]">
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="volumen_parcial[]">
                </td>
            </tr>`;
        $('#contenidoGraneles').append(newRow);

        // Re-inicializar select2 en la nueva fila
        $('#contenidoGraneles').find('.select2-nuevo').select2({
            dropdownParent: $('#addlostesEnvasado'), // Asegúrate de que #myModal sea el id de tu modal
            width: '100%',
            dropdownCssClass: 'select2-dropdown'
        });

        $('.select2-dropdown').css('z-index', 9999);

        // Copiar opciones del primer select al nuevo select
        var options = $('#contenidoGraneles tr:first-child .id_lote_granel').html();
        $('#contenidoGraneles tr:last-child .id_lote_granel').html(options);
    });

    // Función para eliminar una fila
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
    });
});


//agregar tabal a editar:
$(document).on('click', '.add-row-edit', function () {
    var newRow = `
      <tr>
          <th>
              <button type="button" class="btn btn-danger remove-row">
                  <i class="ri-delete-bin-5-fill"></i>
              </button>
          </th>
                <td>
                    <select class="id_lote_granel form-control select2-edit edit_lote_granel" name="id_lote_granel[]">
                    </select>
                    
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="volumen_parcial[]">
                </td>
      </tr>`;

    $('#edit_contenidoGraneles').append(newRow);
    $('#edit_contenidoGraneles').find('.select2-edit').select2({
        dropdownParent: $('#editLoteEnvasado'), // Asegúrate de que #myModal sea el id de tu modal
        width: '100%',
        dropdownCssClass: 'select2-dropdown'
    });
    $('.select2-dropdown').css('z-index', 9999);

    // Copiar opciones del primer select al nuevo select
    var options = $('#edit_contenidoGraneles tr:first-child .edit_lote_granel').html();
    $('#edit_contenidoGraneles tr:last-child .edit_lote_granel').html(options);
});

// Eliminar fila de la tabla
$(document).on('click', '.remove-row', function () {
    $(this).closest('tr').remove();

});



//MODAL para ocultar y mostara
document.addEventListener('DOMContentLoaded', function () {
    // Evento para el cambio en el select de tipo de lote
    document.getElementById('tipo_lote').addEventListener('change', function () {
        toggleFields();
    });

    // Función para mostrar u ocultar campos dependiendo de la opción seleccionada
    function toggleFields() {

        var tipoLote = document.getElementById('tipo_lote').value;
        if (tipoLote == 'Por un solo lote a granel') {
            document.getElementById('datosOpcion1').style.display = 'block';
            document.getElementById('datosOpcion2').style.display = 'none';
        } else if (tipoLote == 'Por más de un lote a granel') {
            document.getElementById('datosOpcion1').style.display = 'none';
            document.getElementById('datosOpcion2').style.display = 'block';
        } else {
            document.getElementById('datosOpcion1').style.display = 'none';
            document.getElementById('datosOpcion2').style.display = 'none';
        }
    }

    //Ocultar select
    document.addEventListener('DOMContentLoaded', function () {
        const tipoLoteSelect = document.getElementById('tipo_lote');
        const datosOpcion1 = document.getElementById('datosOpcion1');
        const datosOpcion2 = document.getElementById('datosOpcion2');

        function toggleFields() {
            if (tipoLoteSelect.value === 'Por un solo lote a granel') {
                datosOpcion1.style.display = 'block'; // Muestra el campo
                datosOpcion2.style.display = 'none';  // Oculta la opción 2
            } else if (tipoLoteSelect.value === 'Por más de un lote a granel') {
                datosOpcion1.style.display = 'none';  // Oculta el campo
                datosOpcion2.style.display = 'block'; // Muestra la opción 2
            } else {
                datosOpcion1.style.display = 'none';  // Oculta el campo
                datosOpcion2.style.display = 'none';  // Oculta la opción 2
            }
        }

        // Llama a toggleFields cuando se carga la página
        toggleFields();

        // Llama a toggleFields cada vez que cambia el valor del select
        tipoLoteSelect.addEventListener('change', toggleFields);
    });


    // Función para inicializar select2 en los select
    function initializeSelect2() {
        $('.select2').select2();
    }

    // Inicializar select2
    initializeSelect2();

    // Inicializar campos por defecto
    toggleFields();
});






//validaicon undate sku







//update valiacion: en editar
const reclasificacionForm = document.getElementById('reclasificacionForm');

// Validación del formulario
const fv3 = FormValidation.formValidation(reclasificacionForm, {
    fields: {
        nuevo: {
            validators: {
                notEmpty: {
                    message: 'Por favor seleccione SKU'
                }
            }
        },
        cantt_botellas: {
            validators: {
                notEmpty: {
                    message: 'Por favor introduzca una cantidad'
                }
            }
        },
        observaciones: {
            validators: {
                notEmpty: {
                    message: 'Por favor ingrese observaciones'
                }
            }
        },

    },
    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: function (field, ele) {
                return '.mb-4, .mb-5, .mb-6'; // Ajusta según las clases de tus elementos
            }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
    }
}).on('core.form.valid', function (e) {
    //e.preventDefault();
    var formData = new FormData(reclasificacionForm);

    $.ajax({
        url: '/lotes-envasado/updateSKU/', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#reclasificacion').modal('hide');
            $('.datatables-users').DataTable().ajax.reload();

            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.success,
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            });
        },
        error: function (xhr) {
            // Mostrar alerta de error
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Error al registrar el lote envasado',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
});