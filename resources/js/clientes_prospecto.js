/**
 * Lista de clientes prospecto
 */

'use strict';

// Datatable (jquery)
$(function () {

  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),

    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#offcanvasValidarSolicitud');

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
        url: baseUrl + 'empresas-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'razon_social' },
        { data: 'domicilio_fiscal' },
        { data: 'regimen' },
        { data: 'regimen' },
        { data: 'id_empresa' },
        { data: '' },
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
          // Es la razón social
          targets: 2,
          render: function (data, type, full, meta) {
            var $name = full['razon_social'];

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
          targets: 3,
          render: function (data, type, full, meta) {
            var $email = full['domicilio_fiscal'];
            return '<span class="user-email">' + $email + '</span>';
          }
        },


        {
          // email verify
          targets: 4,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $verified = full['regimen'];
            if ($verified == 'Persona física') {
              var $colorRegimen = 'info';
            } else {
              var $colorRegimen = 'warning';
            }
            return `${$verified
              ? '<span class="badge rounded-pill  bg-label-' + $colorRegimen + '">' + $verified + '</span>'
              : '<span class="badge rounded-pill  bg-label-' + $colorRegimen + '">' + $verified + '</span>'
              }`;
          }
        },
        {
          targets: 5,  // Aquí es donde se mostrará la información de las normas
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var normas = full['normas'] || []; // Accedemos al array de normas

            // Verificar si no hay normas
            if (normas.length === 0) {
              return '<span class="no-normas">N/A</span>'; // Si no hay normas, mostrar N/A o un icono
            }

            // Si hay normas, crear una cadena con las normas asociadas (sin el ID)
            var normasHtml = normas.map(function (norma) {
              return '<div>' + norma.norma + '</div>'; // Solo mostrar el nombre de la norma
            }).join('');

            return normasHtml; // Devolvemos las normas para mostrarlas en la tabla
          }
        },
        {
          targets: 6,
          className: 'text-center',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
              var idEmpresa = full['id_empresa'];
              var normas = full['normas'] || []; // Accediendo al array de normas
              if (normas.length === 0) {
                  return '<i class="ri-file-damage-fill ri-40px icon-no-pdf"></i>';
              }
              var tieneNorma4 = normas.some(norma => norma.id_norma == 4);
              if (tieneNorma4) {
                  return `<i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer" data-bs-target="#mostrarPdfDictamen" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${idEmpresa}" data-registro="${full['razon_social']}"></i>`;
              } else {
                  return `<i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdfDictamen" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${idEmpresa}" data-registro="${full['razon_social']}"></i>`;
              }
          }
      },
        {
          // Actions
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-50">' +

              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +

              `<a data-id="${full['id_empresa']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasValidarSolicitud" href="javascript:;" class="dropdown-item validar-solicitud"><i class="text-info ri-search-eye-line"></i> Validar solicitud</a>` +
              `<a data-id="${full['id_empresa']}"  data-bs-toggle="modal" data-bs-dismiss="modal" onclick="abrirModal(${full['id_empresa']})" href="javascript:;" class="cursor-pointer dropdown-item validar-solicitud2"><i class="text-success ri-checkbox-circle-fill"></i> Aceptar cliente</a>` +
              `<a data-id="${full['id_empresa']}" data-bs-toggle="modal" data-bs-target="#editCLientesProspectos" class="dropdown-item edit-record waves-effect text-warning"><i class="text-warning ri-edit-fill"></i> Editar</a>` +
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
                columns: [1, 2, 3, 4, 5],
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
                columns: [1, 2, 3, 4, 5],
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
                columns: [1, 2, 3, 4, 5],
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
                columns: [1, 2, 3, 4, 5],
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
                columns: [1, 2, 3, 4, 5],
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
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['razon_social'];
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
    var user_id = $(this).data('empresa_id'),
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
          url: `${baseUrl}empresas-list/${id_empresa}`,
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



  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewerDictamen');
    // Mostrar el spinner y ocultar el iframe
    $('#loading-spinner').show();
    iframe.hide();

    iframe.attr('src', '../solicitudinfo_cliente/' + id);


    $("#titulo_modal_Dictamen").text("Solicitud de información del cliente");
    $("#subtitulo_modal_Dictamen").text(registro);
    $('#mostrarPdfDictamen').modal('show');
  });

  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewerDictamen').on('load', function () {
    $('#loading-spinner').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });



  $(document).on('click', '.pdf2', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewerDictamen');
    // Mostrar el spinner y ocultar el iframe
    $('#loading-spinner').show();
    iframe.hide();

    iframe.attr('src', '../solicitudInfoClienteNOM-199/' + id);

    $("#titulo_modal_Dictamen").text("Solicitud de información del cliente");
    $("#subtitulo_modal_Dictamen").text(registro);
    $('#mostrarPdfDictamen').modal('show');
  });

  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewerDictamen').on('load', function () {
    $('#loading-spinner').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });




  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición de cliente
    const form = document.getElementById('editClienteForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        'nombre_cliente': {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el nombre del cliente.'
            }
          }
        },
        'regimen': {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el régimen del cliente.'
            }
          }
        },
        'domicilio_fiscal': {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el domicilio fiscal.'
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
      // Validar y enviar el formulario cuando pase la validación
      var formData = new FormData(form);
      var clienteid = $('#edit_id_cliente').val();

      $.ajax({
        url: '/clientes/' + clienteid + '/update',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          // Recargar la tabla de clientes
          dt_user.ajax.reload();
          // Cerrar el modal
          $('#editClientesProspectos').modal('hide');
          // Mostrar mensaje de éxito
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
              text: 'Ha ocurrido un error al actualizar el cliente.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        }
      });
    });


    $(document).on('click', '.edit-record', function () {
      var id = $(this).data('id');
      $("#edit_id_cliente").val(id);
      $.ajax({
        url: '/clientes-list/' + id + '/edit',
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
          $('#edit_nombre_cliente').val(data.razon_social);
          $('#edit_regimen').val(data.regimen).trigger('change');
          $('#edit_domicilio_fiscal').val(data.domicilio_fiscal);
          $('#editClientesProspectos').modal('show');
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos del cliente.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });


  });








  // Validar solicitud
  $(document).on('click', '.validar-solicitud', function () {
    var id_empresa = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // changing the title of offcanvas
    //  $('#offcanvasAddUserLabel').html('Edit User');

    $('#empresa_id').val(id_empresa);
  });

  // aceptar cliente
  $(document).on('click', '.validar-solicitud2', function () {
    var id_empresa = $(this).data('id');


    $('#empresaID').val(id_empresa);
  });

  // changing the title
  $('.add-new').on('click', function () {
    $('#user_id').val(''); //reseting input field
    $('#offcanvasAddUserLabel').html('Add User');
  });

  // validating form and updating user's data
  const addNewUserForm = document.getElementById('addNewUserForm');

  // Validación del formulario de Validación de solicitud
  const fv = FormValidation.formValidation(addNewUserForm, {
    fields: {
      medios: {
        validators: {
          notEmpty: {
            message: 'Por favor selecciona una opción.'
          }
        }
      }, competencia: {
        validators: {
          notEmpty: {
            message: 'Por favor selecciona una opción.'
          }
        }
      }, capacidad: {
        validators: {
          notEmpty: {
            message: 'Por favor selecciona una opción.'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.mb-5';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // adding or updating user when form successfully validate
    $.ajax({
      data: $('#addNewUserForm').serialize(),
      url: `${baseUrl}empresas-list`,
      type: 'POST',
      success: function (status) {
        dt_user.draw();
        offCanvasForm.offcanvas('hide');

        // sweetalert
        Swal.fire({
          icon: 'success',
          title: `${status} Exitosamente`,
          text: `Solicitud ${status} Exitosamente.`,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (err) {

        offCanvasForm.offcanvas('hide');
        Swal.fire({
          title: 'Duplicate Entry!',
          text: 'Your email should be unique.',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });



  // validating form and updating user's data
  const addNewCliente = document.getElementById('addNewCliente');

  // Validación del formulario de aceptar cliente
  const fv2 = FormValidation.formValidation(addNewCliente, {
    fields: {
      'numero_cliente[]': {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca el número de cliente.'
          }
        }
      }, fecha_cedula: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca la fecha de cédula de identificación fiscal.'
          }
        }
      }, idcif: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca el idCIF del Servicio deAdministración Tributaria.'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.col-sm-12';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // adding or updating user when form successfully validate
    $.ajax({
      data: $('#addNewCliente').serialize(),
      url: `${baseUrl}aceptar-cliente`,
      type: 'POST',
      success: function (status) {
        dt_user.draw();
        offCanvasForm.offcanvas('hide');

        // sweetalert
        Swal.fire({
          icon: 'success',
          title: `${status} Exitosamente`,
          text: `Solicitud ${status} Exitosamente.`,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (err) {

        offCanvasForm.offcanvas('hide');
        Swal.fire({
          title: 'Duplicate Entry!',
          text: 'Your email should be unique.',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // clearing form data when offcanvas hidden
  offCanvasForm.on('hidden.bs.offcanvas', function () {
    fv2.resetForm(true);
  });

  const phoneMaskList = document.querySelectorAll('.phone-mask');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true,
        phoneRegionCode: 'US'
      });
    });
  }

  

});
