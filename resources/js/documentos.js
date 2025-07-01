$(function () {
    var baseUrl = window.location.origin + '/';

    // Inicializar DataTable
    var dt_instalaciones_table = $('.datatables-users').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl + 'documentos-list',
            type: 'GET',
            dataSrc: function (json) {
                return json.data;
            },
            error: function (xhr, error, thrown) {
                console.error('Error en la solicitud Ajax:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al cargar los datos.',
                });
            }
        },
        columns: [
            { data: null, defaultContent: '' },
            { data: 'id_documento' },
            { data: 'nombre' },
            { data: 'tipo' },
            { data: null, defaultContent: '' }
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
                targets: -1,
                title: 'Acciones',
                searchable: false,
                orderable: false,
                render: function (data, type, full) {
                    return (
                        `<div class="d-flex align-items-center gap-50">
                        <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                        <div class="dropdown-menu dropdown-menu-end m-0">
                            <a data-id="${full['id_documento']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditInstalacion" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar documento</a>
                            <a data-id="${full['id_documento']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar documento</a>
                        </div>`
                    );
                }
            }
        ],
        order: [[1, 'desc']],
        dom: '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
            '<"me-5 ms-n2"f>' +
            '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-4"lB>>' +
            '>t' +
            '<"row mx-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        lengthMenu: [10, 20, 50, 70, 100],
        language: {
            sLengthMenu: '_MENU_',
            search: '',
            searchPlaceholder: 'Buscar',
            info: 'Mostrar _START_ a _END_ de _TOTAL_ registros',
            paginate: {
                sFirst: 'Primero',
                sLast: 'Último',
                sNext: 'Siguiente',
                sPrevious: 'Anterior'
            }
        },
        buttons: [
            {
                extend: 'collection',
                className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
                text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
                buttons: [
                    {
                        extend: 'print',
                        title: 'Documentación',
                        text: '<i class="ri-printer-line me-1"></i>Print',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                body: function (inner, rowIndex, columnIndex) {
                                    if (columnIndex === 1) {
                                        return inner.replace(/<[^>]*>/g, '');
                                    }
                                    return inner;
                                }
                            }
                        },
                        customize: function (win) {
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
                        title: 'Documentación',
                        text: '<i class="ri-file-text-line me-1"></i>CSV',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                body: function (inner, rowIndex, columnIndex) {
                                    if (columnIndex === 1) {
                                        return inner.replace(/<[^>]*>/g, '');
                                    }
                                    if (columnIndex === 4) {
                                        return 'ViewSuspend';
                                    }
                                    return inner;
                                }
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Documentación',
                        text: '<i class="ri-file-excel-line me-1"></i>Excel',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                body: function (inner, rowIndex, columnIndex) {
                                    if (columnIndex === 1) {
                                        return inner.replace(/<[^>]*>/g, '');
                                    }
                                    if (columnIndex === 4) {
                                        return 'ViewSuspend';
                                    }
                                    return inner;
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Documentación',
                        text: '<i class="ri-file-pdf-line me-1"></i>PDF',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                body: function (inner, rowIndex, columnIndex) {
                                    if (columnIndex === 1) {
                                        return inner.replace(/<[^>]*>/g, '');
                                    }
                                    if (columnIndex === 4) {
                                        return 'ViewSuspend';
                                    }
                                    return inner;
                                }
                            }
                        }
                    },
                    {
                        extend: 'copy',
                        title: 'Documentación',
                        text: '<i class="ri-file-copy-line me-1"></i>Copy',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                body: function (inner, rowIndex, columnIndex) {
                                    if (columnIndex === 1) {
                                        return inner.replace(/<[^>]*>/g, '');
                                    }
                                    if (columnIndex === 4) {
                                        return 'ViewSuspend';
                                    }
                                    return inner;
                                }
                            }
                        }
                    }
                ]
            },
            {
                text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Documentación</span>',
                className: 'add-new btn btn-primary waves-effect waves-light',
                attr: {
                    'data-bs-toggle': 'offcanvas',
                    'data-bs-target': '#offcanvasAddInstalacion'
                }
            }
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return 'Detalles de ' + data['nombre'];
                    }
                }),
                type: 'column',
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col) {
                        return col.title !== ''
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

    function initializeSelect2($elements) {
        $elements.each(function () {
            var $this = $(this);
            $this.wrap('<div class="position-relative"></div>').select2({
                placeholder: 'Selecciona un tipo',
                dropdownParent: $this.parent()
            });
        });
    }
    initializeSelect2($('.select2'));

    $('.datatables-users').on('click', '.delete-record', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: '¿Está seguro?',
            text: "No podrá revertir este evento",
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
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: baseUrl + 'documentos/' + id,
                    success: function () {
                        dt_instalaciones_table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminado!',
                            text: '¡El registro ha sido eliminado correctamente!',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        console.error('Error al eliminar:', textStatus, errorThrown);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al eliminar el registro.',
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelado',
                    text: 'La eliminación del registro ha sido cancelada.',
                    icon: 'info',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
            }
        });
    });


    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        const formAdd = document.getElementById('formAddDocumentacion');
        FormValidation.formValidation(formAdd, {
            fields: {
                'nombre': {
                    validators: {
                        notEmpty: {
                            message: 'El nombre es obligatorio.'
                        }
                    }
                },
                'tipo': {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona un tipo.'
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
        }).on('core.form.valid', function (e) {
            var formData = $(formAdd).serialize();
    
            $.ajax({
                url: '/documentos',
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#offcanvasAddInstalacion').offcanvas('hide');
                    $('#formAddDocumentacion')[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Documento agregado exitosamente.',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                    $('.datatables-users').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    console.log('Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Error al agregar la documentación',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        });
    });
    

    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.datatables-users').on('click', '.edit-record', function () {
            var id_documento = $(this).data('id');

            $.get('/documentos/' + id_documento + '/edit', function (data) {
                console.log('Datos recibidos:', data);
                if (data && data.id_documento) {
                    $('#documentoId').val(data.id_documento);
                    $('#nombreEdit').val(data.nombre);

                    var tipoSelect = $('#tipoEdit');
                    var tipoOptions = tipoSelect.find('option').map(function () {
                        return $(this).val();
                    }).get();

                    if (tipoOptions.includes(data.tipo)) {
                        tipoSelect.val(data.tipo);
                    } else {
                        tipoSelect.append(new Option(data.tipo, data.tipo, true, true));
                        tipoSelect.val(data.tipo);
                    }

                    tipoSelect.trigger('change');

                    $('#offcanvasEditInstalacion').offcanvas('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'No se encontraron datos',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            }).fail(function (xhr) {
                console.error('Error en la solicitud:', xhr);
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Error al obtener los datos del documento',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            });
        });

        const editForm = document.getElementById('formEditDocumentacion');
        const fvEdit = FormValidation.formValidation(editForm, {
            fields: {
                'nombre': {
                    validators: {
                        notEmpty: {
                            message: 'Ingrese el nombre del documento.'
                        }
                    }
                },
                'tipo': {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona un tipo de documento.'
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
        }).on('core.form.valid', function (e) {
            var formData = $(editForm).serialize();
            var id_documento = $('#documentoId').val();

            $.ajax({
                url: '/documentos/' + id_documento,
                type: 'PUT',
                data: formData,
                success: function (response) {
                    $('#offcanvasEditInstalacion').offcanvas('hide');
                    $('#formEditDocumentacion')[0].reset();

                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.success,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });

                    $('.datatables-users').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Error al actualizar el documento',
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            });
        });
    });


    //end
});
