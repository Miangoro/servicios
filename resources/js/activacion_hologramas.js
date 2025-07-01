'use strict';

$(function () {
  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#addHologramas');

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
        url: baseUrl + 'find_hologramas_activar-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: '' },
        { data: 'folio_activacion' },
        { data: 'folio_solicitud' },
        { data: 'num_servicio' },
        { data: 'marca' },
        { data: 'lote_granel' },
        { data: 'lote_envasado' },
        { 
          data: 'folios', 
          render: function (data, type, row) {
            return '<span style="font-size:12px">' + data + '</span>';
          }
        },
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
            
              `<a data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#edit_activarHologramas" href="javascript:;" class="dropdown-item edit-activos "><i class="ri-edit-box-line ri-20px text-info"></i> Editar activación</a>` +
              `<a data-id="${full['id']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar activación</a>` +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              '<a href="' +
              userView +
              '" class="dropdown-item">View</a>' +
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
              title: 'Categorías de Agave',
              text: '<i class="ri-printer-line me-1" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
              title: 'Categorías de Agave',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
              title: 'Categorías de Agave',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
              title: 'Categorías de Agave',
              text: '<i class="ri-file-copy-line me-1"></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9],
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Activar hologramas</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#activarHologramas' 
          }
        }
      ],
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['folio'];
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

  // Inicializacion Elementos
  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Selecciona una opcion',
        dropdownParent: $this.parent()
      });
    });
  }

  // Inicializacion DatePicker
  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es' // Configura el idioma a español
    });
  });

  // Agregar nuevo registro y validacion
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  
    // Función que obtiene las marcas de la empresa seleccionada
    function obtenerMarcas() {
      var empresa = $("#id_empresa").val();
      // Hacer una petición AJAX para obtener los detalles de la empresa
      $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function(response) {
          // Cargar los detalles de las marcas en el select
          var contenido = "";
          for (let index = 0; index < response.marcas.length; index++) {
            contenido = '<option value="' + response.marcas[index].id_marca + '">' + response.marcas[index].marca + '</option>' + contenido;
          }
  
          if (response.marcas.length == 0) {
            contenido = '<option value="">Sin marcas registradas</option>';
          }
          $('#id_marca').html(contenido);
  
          // Revalidar el campo 'id_marca' para verificar la selección
          formValidator.revalidateField('id_marca');
        },
        error: function() {
          //alert('Error al cargar las marcas.');
        }
      });
    }
  
    // Función que obtiene las direcciones de la empresa seleccionada
    function obtenerDirecciones() {
      var empresa = $("#id_empresa").val();
      // Hacer una petición AJAX para obtener los detalles de la empresa
      $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function(response) {
          // Filtrar las direcciones para que solo se incluyan las que tienen tipo_direccion igual a 3
          var direccionesFiltradas = response.direcciones.filter(function(direccion) {
            return direccion.tipo_direccion == 3;
          });
  
          // Cargar los detalles de las direcciones en el select
          var contenido = "";
          for (let index = 0; index < direccionesFiltradas.length; index++) {
            contenido += '<option value="' + direccionesFiltradas[index].id_direccion + '">' +
              'Nombre de destinatario: ' + direccionesFiltradas[index].nombre_recibe +
              ' - Dirección: ' + direccionesFiltradas[index].direccion +
              ' - Correo: ' + direccionesFiltradas[index].correo_recibe +
              ' - Celular: ' + direccionesFiltradas[index].celular_recibe +
              '</option>';
          }
  
          if (direccionesFiltradas.length == 0) {
            contenido = '<option value="">Sin direcciones registradas</option>';
          }
  
          $('.id_direccion').html(contenido);
  
          // Revalidar el campo 'id_direccion' para verificar la selección
          formValidator.revalidateField('id_direccion');
        },
        error: function() {
          //alert('Error al cargar las direcciones.');
        }
      });
    }
  
    // Event listener para cuando cambie la selección de empresa
    $('#id_empresa').on('change', function () {
      obtenerMarcas();  // Cargar las marcas
      obtenerDirecciones();  // Cargar las direcciones
      formValidator.revalidateField('id_empresa');  // Revalidar el campo de empresa
    });
  
    // Validación del formulario
    const addHologramasForm = document.getElementById('addHologramasForm');
    const formValidator = FormValidation.formValidation(addHologramasForm, {
      fields: {
        folio: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca un folio'
            }
          }
        },
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente'
            }
          }
        },
        id_marca: {
          validators: {
            callback: {
              message: 'Por favor seleccione al menos una marca',
              callback: function (input) {
                return $('#id_marca').val() && $('#id_marca').val().length > 0;
              }
            }
          }
        },
        id_solicitante: {
          validators: {
            notEmpty: {
              message: 'Falta el ID del usuario'
            }
          }
        },
        cantidad_hologramas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de hologramas solicitados'
            },
            between: {
              min: 1,
              max: Infinity,
              message: 'El número debe ser superior a 0 y sin negativos'
            },
            regexp: {
              regexp: /^(?!0)\d+$/,
              message: 'El número no debe comenzar con 0'
            }
          }
        },
        id_direccion: {
          validators: {
            callback: {
              message: 'Por favor seleccione al menos una dirección',
              callback: function (input) {
                return $('#id_direccion').val() && $('#id_direccion').val().length > 0;
              }
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: function (field, ele) {
            return '.mb-4, .mb-5, .mb-6';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function (e) {
      var formData = new FormData(addHologramasForm);
  
      $.ajax({
        url: '/hologramas/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addHologramas').modal('hide');
          $('.datatables-users').DataTable().ajax.reload();
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
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar los hologramas',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

// Limpiar campos al cerrar el modal
$('#addHologramas').on('hidden.bs.modal', function () {
  // Restablecer select de empresa
  $('#id_empresa').val('');
  $('#id_marca').html('');
  $('.id_direccion').html('');
  $('#folio').val('');
  $('#comentarios').val(''); 
  $('#id_solicitante').val('');
  $('#cantidad_hologramas').val('');
  
  // Restablecer la validación del formulario
  formValidator.resetForm(true);
});


  initializeSelect2(select2Elements);

  // Eliminar Registro
  $(document).on('click', '.delete-record', function () {
    var id_solicitud = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }
    Swal.fire({
      title: '¿Está seguro?',
      text: 'No podrá revertir este evento',
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
          url: `${baseUrl}find_hologramas_activar-list/${id_solicitud}`,
          success: function () {
            dt_user.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });
        Swal.fire({
          icon: 'success',
          title: '¡Eliminado!',
          text: '¡Los hologramas han sido eliminados correctamente!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'Los hologramas no han sido eliminados',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // Registrar Respuesta y mostrar PDF correspondiente
  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewerDictamen');
    $('#loading-spinner').show(); //se el agrega esto
    iframe.hide(); //se el agrega esto
    iframe.attr('src', '../solicitud_de_holograma/' + id);
    $('#titulo_modal_Dictamen').text('Solicitud de entrega de hologramas');
    $('#subtitulo_modal_Dictamen').text(registro);
    $('#mostrarPdfDictamen').modal('show');
  });
  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewerDictamen').on('load', function () {
    $('#loading-spinner').hide();
    $(this).show();
  });

  // Editar Registro
  $(document).on('click', '.edit-record', function () {
    var id_solicitud = $(this).data('id');
    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {
      $('#editt_id_solicitud').val(data.id_solicitud);
      $('#edit_folio').val(data.folio);
      $('#edit_id_empresa').val(data.id_empresa).trigger('change');
      $('#edit_id_marca').val(data.id_marca).trigger('change');
      $('#edit_id_solicitante').val(data.id_solicitante);
      $('#edit_cantidad_hologramas').val(data.cantidad_hologramas);
      $('#edit_id_direccion').val(data.id_direccion).trigger('change');
      $('#edit_comentarios').val(data.comentarios);
      $('#editHologramas').modal('show');
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

  // Editar registro y validacion
  const editHologramasForm = document.getElementById('editHologramasForm');
  const fv = FormValidation.formValidation(editHologramasForm, {
    fields: {
      edit_folio: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca un folio'
          }
        }
      },
      edit_id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un cliente'
          }
        }
      },
      edit_id_marca: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese una marca'
          }
        }
      },
      edit_cantidad_hologramas: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de hologramas solicitados'
          }
        }
      },
      edit_id_direccion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una dirección'
          }
        }
      }
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
  }).on('core.form.valid', function () {
    var formData = new FormData(editHologramasForm);
    $.ajax({
      url: '/solicitud_holograma/update/', // URL de la ruta de actualización
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Solicitud actualizada correctamente',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(function () {
          $('#editHologramas').modal('hide'); // Cierra el modal de edición
          $('.datatables-users').DataTable().ajax.reload(); // Recarga la tabla de datos
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error: ' + textStatus + ' - ' + errorThrown);
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al actualizar la solicitud de hologramas',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Agregar nuevo registro Pago y validacion
  const addPagoForm = document.getElementById('addPagoForm');
  const fv2 = FormValidation.formValidation(addPagoForm, {
    fields: {
      tipo_pago: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un tipo de pago'
          }
        }
      },
      'url[]': {
        validators: {
          notEmpty: {
            message: 'Por favor adjunte un comprobante de pago'
          },
          file: {
            extension: 'pdf,doc,docx,jpg,jpeg,png',
            type: 'application/pdf,application/msword,image/jpeg,image/png',
            maxSize: 5242880, // 5 MB
            message: 'El archivo adjunto debe ser un documento válido (PDF, DOC, JPG, PNG) y no mayor de 5MB'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: function (field, ele) {
          return '.mb-4, .mb-5'; // Ajusta según las clases de tus elementos
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // Se ejecuta cuando el formulario es válido
    var formData = new FormData(addPagoForm);

    $.ajax({
      url: '/solicitud_holograma/update2',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#addPago').modal('hide');
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
          text: 'Ocurrió un error al actualizar el pago.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Editar registro Pago
  $(document).on('click', '.edit-pay', function () {
    var id_solicitud = $(this).data('id');

    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {
      // Rellenar el formulario con los datos obtenidos
      $('#pago_id_solicitud').val(data.id_solicitud);

      $('#tipo_pago').val(data.tipo_pago);
      $('#empresa').val(data.id_empresa);
      // Mostrar el modal de edición
      $('#addPago').modal('show');
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

  // Registrar Envio y validar campos
  const addEnvioForm = document.getElementById('addEnvioForm');
  const fv3 = FormValidation.formValidation(addEnvioForm, {
    fields: {
      fecha_envio: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca la fecha de envío'
          }
        }
      },
      costo_envio: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca el costo de envío'
          },
          numeric: {
            message: 'El costo de envío debe ser un número válido'
          }
        }
      },
      no_guia: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de guía'
          }
        }
      },
      'url[]': {
        validators: {
          notEmpty: {
            message: 'Por favor adjunte el comprobante de pago'
          },
          file: {
            extension: 'pdf,doc,docx,jpg,jpeg,png',
            type: 'application/pdf,application/msword,image/jpeg,image/png',
            maxSize: 5242880, // 5 MB
            message: 'El archivo adjunto debe ser un documento válido (PDF, DOC, JPG, PNG) y no mayor de 5MB'
          }
        }
      }
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
    // Prevenir el comportamiento predeterminado

    var formData = new FormData(addEnvioForm);

    $.ajax({
      url: '/solicitud_holograma/update3', // URL de la acción de actualización
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar el modal al éxito
        $('#addEnvio').modal('hide');
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
          text: 'Ocurrió un error al actualizar la guía.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  //Metodo para editar Envio
  $(document).on('click', '.edit-envio', function () {
    var id_solicitud = $(this).data('id');
    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {
      $('#edit_id_solicitud2').val(data.id_solicitud);
      $('#fecha_envio').val(data.fecha_envio);
      $('#costo_envio').val(data.costo_envio);
      $('#no_guia').val(data.no_guia);
      $('#empresa2').val(data.id_empresa);
      // Mostrar el modal de edición
      $('#addEnvio').modal('show');
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

  //Registrar Asignar hologramas
  $(document).on('click', '.edit-signar', function () {
    var id_solicitud = $(this).data('id');
    $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {
      $('#id_solicitudAsignar').val(data.id_solicitud);
      $('#asig_folio_inicial').val(data.folio_inicial);
      $('#asig_folio_final').val(data.folio_final);
      $('#empresaAsignar').val(data.id_empresa);
      // Mostrar el modal de edición
      $('#asignarHolograma').modal('show');
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

  //Actualizar Asignar hologramas
  $('#asignarHologramaForm').submit(function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    console.log();

    $.ajax({
      url: '/solicitud_holograma/updateAsignar',
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
        $('#asignarHolograma').modal('hide');
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
  });

  //Funcion Validacion de folios
  $(document).ready(function () {
    // Delegación de eventos para escuchar el cambio en los inputs de cada fila
    $(document).on('input', '.folio_inicial, .folio_final', function () {
        var row = $(this).closest('.folio-row'); // Encuentra la fila más cercana
        var folioInicial = row.find('.folio_inicial').val();
        var folioFinal = row.find('.folio_final').val();
        var id_solicitud = $('#id_solicitudActivacion').val();
        var subtotal = folioFinal - folioInicial;
        
        
        // Actualizar el subtotal en la fila correspondiente
        row.find(".subtotal").text(subtotal+1); 
        
        // Verificar si ambos campos tienen valores
        if (folioInicial && folioFinal) {
            $.ajax({
                url: '/verificar-folios',
                type: 'POST',
                data: {
                    folio_inicial: folioInicial,
                    folio_final: folioFinal,
                    id_solicitud: id_solicitud
                },
                success: function (response) {
                    var mensajeDiv = row.find('.mensaje'); // Obtener el mensaje en la fila actual
                    mensajeDiv.html(response.success || 'Rango de folios disponible.')
                              .removeClass('alert-danger alert-warning')
                              .addClass('alert alert-success')
                              .show();
                              $("#btnRegistrar").prop("disabled", false);
                  
                },
                error: function (xhr) {
                    var mensajeDiv = row.find('.mensaje'); // Obtener el mensaje en la fila actual
                    mensajeDiv.html(xhr.responseJSON.error || 'Ocurrió un error.')
                              .removeClass('alert-success alert-warning')
                              .addClass('alert alert-danger')
                              .show();
                              $("#btnRegistrar").prop("disabled", true);

                }
            });
        }
    });
});




  //Activar hologramas
  $(document).on('click', '.activar_holograma', function () {
    var id_solicitud = $(this).data('id');

    $('#id_solicitudActivacion').val(id_solicitud);

    // Mostrar el modal de edición
    $('#activarHologramas').modal('show');
  });

  // Agregar nuevo registro Activar y validacion
  const activarHologramasForm = document.getElementById('activarHologramasForm');
  const fv5 = FormValidation.formValidation(activarHologramasForm, {
    fields: {
      id_solicitudActivacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una solicitud de entrega'
          }
        }
      },
      folio_activacion: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca el folio'
          }
        }
      },
      id_inspeccion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una opción'
          }
        }
      },
      no_lote_agranel: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el nombre del lote'
          }
        }
      },
      certificado_granel: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de certificado granel'
          }
        }
      },
      categoria: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una categoría'
          }
        }
      },
      no_analisis: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de análisis del laboratorio'
          }
        }
      },
      cont_neto: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione el contenido'
          }
        }
      },

      unidad: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione la unidad'
          }
        }
      },
      clase: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione la clase'
          }
        }
      },
      contenido: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el contenido'
          }
        }
      },
      no_lote_envasado: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de lote envasado'
          }
        }
      },
      id_tipo: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione el tipo'
          }
        }
      },
      lugar_produccion: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el lugar de producción'
          }
        }
      },
      lugar_envasado: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el lugar de envasado'
          }
        }
      }
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
    var formData = new FormData(activarHologramasForm);

    $.ajax({
      url: '/solicitud_holograma/storeActivar', // Actualiza con la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#activarHologramas').modal('hide');
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
          text: 'Error al activar los hologramas',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Editar Registro Activos y validacion
  const edit_activarHologramasForm = document.getElementById('edit_activarHologramasForm');
  const fv4 = FormValidation.formValidation(edit_activarHologramasForm, {
    fields: {
      edit_id_inspeccion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una opción'
          }
        }
      },
      edit_no_lote_agranel: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el nombre del lote'
          }
        }
      },
      edit_categoria: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una categoría'
          }
        }
      },
      edit_no_analisis: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de análisis del laboratorio'
          }
        }
      },
      edit_cont_neto: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione el contenido'
          }
        }
      },
      edit_unidad: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione la unidad'
          }
        }
      },
      edit_clase: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione la clase'
          }
        }
      },
      edit_contenido: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el contenido'
          }
        }
      },
      edit_no_lote_envasado: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de lote envasado'
          }
        }
      },
      edit_id_tipo: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione el tipo'
          }
        }
      },
      edit_lugar_produccion: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el lugar de producción'
          }
        }
      },
      edit_lugar_envasado: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el lugar de envasado'
          }
        }
      }
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
    // Prevenir el comportamiento predeterminado

    var formData = new FormData(edit_activarHologramasForm);

    $.ajax({
      url: '/solicitud_holograma/update/updateActivados', // URL de la acción de actualización
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Ocultar el modal al éxito
        $('#edit_activarHologramas').modal('hide');
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
          text: 'Ocurrió un error al actualizar los hologramas activados.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  //Ver Activos en la tabla
  $(document).on('click', '.activos_hologramas', function () {
    var id = $(this).data('id');
    $.get('/solicitud_holograma/editActivos/' + id, function (data) {
      $('#tablita').empty();

      // Rellenar el formulario con los datos obtenidos
      data.forEach(function (item) {
        let folio_inicial = String(item.folio_inicial)
          .split(',')
          .map(folio => {
            return `<a href="http://localhost:8000/pages/hologramas-validacion/${folio}" target="_blank">${folio}</a>`;
          })
          .join('<br>');
        let folio_final = String(item.folio_final).replace(/,/g, '<br>');
        let mermas = String(item.mermas).replace(/,/g, '<br>');

        // Crear una nueva fila con los datos
        var fila = `
            <tr>
                <td>${item.id}</td>
                <td>${item.no_lote_agranel}</td>
                <td>${item.categoria}</td>
                <td>${item.no_analisis}</td>
                <td>${item.cont_neto} ${item.unidad}</td>
                <td>${item.clase}</td>
                <td>${item.contenido}</td>
                <td>${item.no_lote_envasado}</td>
              <td>${item.num_servicio}</td>
                <td>${item.lugar_produccion}</td>
                <td>${item.lugar_envasado}</td>
                <td>
                ${folio_inicial}
                </td>
                  <td>
                    <a href="http://localhost:8000/pages/hologramas-validacion" target="_blank">
                      ${folio_final}
                    </a>
                  </td> 
                     <td>
                      ${mermas}
                     </td>
            
                  <td>
                <button type="button" class="btn btn-info">
                  <a href="javascript:;" class="edit-activos" style="color:#FFF" 
                    data-id="${item.id}" 
                    data-bs-toggle="modal" 
                    data-bs-target="#edit_activarHologramas">
                    <i class="ri-edit-fill"></i> Editar
                  </a>
                </button>

            </td>
            </tr>
        `;
        $('#tablita').append(fila);
      });
      $('#activosHologramas').modal('show');
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

  // Editar Registro Activados y validacion
  $(document).on('click', '.edit-activos', function () {
    var id = $(this).data('id');
    $.get('/activacion_holograma/edit/' + id, function (data) {
      console.log(data);
      $('#edit_id').val(data.id);
      $('#edit_folio_activacion').val(data.folio_activacion);
      $('#edit_id_solicitudActivacion').val(data.id_solicitud).trigger('change');
      $('#edit_id_inspeccion').val(data.id_inspeccion).trigger('change');
      $('#edit_no_lote_agranel').val(data.no_lote_agranel);
      $('#edit_categoria').val(data.categoria).trigger('change');
      $('#edit_no_analisis').val(data.no_analisis);
      $('#edit_cont_neto').val(data.cont_neto);
      $('#edit_unidad').val(data.unidad);
      $('#edit_clase').val(data.clase);
      $('#edit_contenido').val(data.contenido);
      $('#edit_no_lote_envasado').val(data.no_lote_envasado);
      $('#edit_id_tipo').val(data.id_tipo).trigger('change');
      $('#edit_lugar_produccion').val(data.lugar_produccion);
      $('#edit_lugar_envasado').val(data.lugar_envasado);
      $('#edit_certificado_granel').val(data.certificado_granel);
      $('#edit_edad').val(data.edad);
      $('#edit_contenidoRango').empty();
      data.folio_inicial.forEach(function (folioInicial, index) {
        var folioFinal = data.folio_final[index];
        var newRow = `
         <tr class="folio-row">
              <th>
                  <button type="button" class="btn btn-danger remove-row">
                      <i class="ri-delete-bin-5-fill"></i>
                  </button>
              </th>
              <td><input type="number" class="form-control form-control-sm" name="edit_rango_inicial[]"  min="0" value="${folioInicial}"></td>
              <td><input type="number" class="form-control form-control-sm" name="edit_rango_final[]"  min="0"  value="${folioFinal}"></td>
              <td class="subtotal"></td>
                                <td>
                                    <div class="mensaje alert" style="display:none;"></div>
                                </td>

          </tr>`;
        $('#edit_contenidoRango').append(newRow);
      });

 
    

      $('#edit_contenidoMermas').empty();
      /*data.mermas.forEach(function (mermasHolo) {
        var newRow = `
          <tr>
              <th>
                  <button type="button" class="btn btn-danger remove-row">
                      <i class="ri-delete-bin-5-fill"></i>
                  </button>
              </th>
              <td><input type="number" class="form-control form-control-sm" name="edit_mermas[]"  min="0" value="${mermasHolo}"></td>

          </tr>`;
        $('#edit_contenidoMermas').append(newRow);
      });*/
      $('#edit_activarHologramas').modal('show');
      $('.folio_inicial, .folio_final').each(function () {
        $(this).trigger('input'); // Dispara manualmente el evento para ejecutar la validación
       
    });
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de los hologramas activados',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });

  // Agregar FILA A EDIT ACTIVADOS
  $(document).on('click', '.add-row-edit', function () {
    var newRow = `
      <tr>
          <th>
              <button type="button" class="btn btn-danger remove-row">
                  <i class="ri-delete-bin-5-fill"></i>
              </button>
          </th>
          <td>
              <input type="number" class="form-control form-control-sm" name="edit_rango_inicial[]" min="0"  placeholder="Rango inicial">
          </td>
          <td>
              <input type="number" class="form-control form-control-sm" name="edit_rango_final[]" min="0"  placeholder="Rango final">
</td>
      </tr>`;

    $('#edit_contenidoRango').append(newRow);
  });

  // Eliminar fila de la tabla
  $(document).on('click', '.remove-row', function () {
    $(this).closest('tr').remove();
  });

  // Agregar FILA A EDIT ACTIVADOS mermas
  $(document).on('click', '.add-row-editMermas', function () {
    var newRow = `
        <tr>
            <th>
                <button type="button" class="btn btn-danger remove-row">
                    <i class="ri-delete-bin-5-fill"></i>
                </button>
            </th>
            <td>
                <input type="number" class="form-control form-control-sm" name="edit_mermas[]" min="0"  placeholder="Mermas">
            </td>

        </tr>`;

    $('#edit_contenidoMermas').append(newRow);
  });
  // Eliminar fila de la tabla
  $(document).on('click', '.remove-row', function () {
    $(this).closest('tr').remove();
  });

  //Agregar o eliminar tablas en add activos
  $(document).ready(function () {
    $('.add-row-add').click(function () {
      // Añade una nueva fila
      var newRow = `
          <tr class="folio-row"> 
              <th>
                  <button type="button" class="btn btn-danger remove-row" disabled>
                      <i class="ri-delete-bin-5-fill"></i>
                  </button>
              </th>
              <td>
                  <input type="number" class="form-control form-control-sm folio_inicial" name="rango_inicial[]" min="0" placeholder="Rango inicial">
              </td>
              <td>
                  <input type="number" class="form-control form-control-sm folio_final" name="rango_final[]" min="0" placeholder="Rango final">
              </td>
              <th class="subtotal"></th>
              <td>
                  <div class="mensaje alert" style="display:none;"></div> <!-- Se movió dentro de la fila -->
              </td>
          </tr>`;
      $('#contenidoRango').append(newRow);
    });

    // Función para eliminar una fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
    });
  });
  //mermas

  $(document).ready(function () {
    $('.add-row-addmermas').click(function () {
      // Añade una nueva fila
      var newRow = `
          <tr>
              <th>
                  <button type="button" class="btn btn-danger remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
              </th>
              <td>
                  <input type="number" class="form-control form-control-sm " min="0" name="mermas[]"  placeholder="Mermas" />
              </td>
          </tr>`;
      $('#contenidoMermas').append(newRow);
    });
    // Función para eliminar una fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
    });
  });

  //METODO QUE TAL VEZ NO SE USE
  //recepcion hologramas
  /*   $(document).on('click', '.edit-recepcion', function () {
      var id_solicitud = $(this).data('id');
  
      $.get('/solicitud_holograma/edit/' + id_solicitud, function (data) {
  
  
        // Rellenar el formulario con los datos obtenidos
        $('#recepcion_id_solicitud').val(data.id_solicitud);
  
        $('#recepcion_empresa').val(data.id_empresa);
        // Mostrar el modal de edición
        $('#addRecepcion').modal('show');
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
    }); */

  //METODO QUE TAL VEZ NO SE USE
  /*   const addRecepcionForm = document.getElementById('addRecepcionForm');
    FormValidation.formValidation(addRecepcionForm, {
      fields: {
        'url[]': {
          validators: {
            notEmpty: {
              message: 'Por favor adjunte el comprobante de pago'
            },
            file: {
              extension: 'pdf,doc,docx,jpg,jpeg,png',
              type: 'application/pdf,application/msword,image/jpeg,image/png',
              maxSize: 5242880, // 5 MB
              message: 'El archivo adjunto debe ser un documento válido (PDF, DOC, JPG, PNG) y no mayor de 5MB'
            }
          }
        }
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
      // Prevenir el comportamiento predeterminado
  
      var formData = new FormData(addRecepcionForm);
  
      $.ajax({
        url: '/solicitud_holograma/updateRecepcion',
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
          $('#addRecepcion').modal('hide');
          $('.datatables-users').DataTable().ajax.reload();
        },
        error: function (response) {
          Swal.fire({
            title: 'Error',
            text: 'Ocurrió un error al actualizar los holograms.',
            icon: 'error',
            buttonsStyling: false,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    }); */

   /* $(document).ready(function () {
      $('#id_inspeccion').change(function () { 
          var id_inspeccion = $(this).val(); // Obtener el valor seleccionado
         
  
          if (id_inspeccion) {
              $.ajax({
                  url: '/getDatosSolicitud/' + id_inspeccion, // URL del backend
                  type: 'GET',
                  dataType: 'json',
                  success: function (response) {
                      if (response.success) {
                          // Llenar los inputs con los datos recibidos
                          $('#no_lote_agranel').val(response.data.lote_granel.nombre_lote || '');
                          $('#categoria').val(response.data.lote_granel.id_categoria).trigger('change');
                          $('#clase').val(response.data.lote_granel.id_clase).trigger('change');
                          $('#id_tipo').val(response.data.lote_granel.tipo_lote).trigger('change');
                          $('#cont_neto').val(response.data.lote_envasado.presentacion);
                          $('#unidad').val(response.data.lote_envasado.unidad);
                          $('#no_analisis').val(response.data.lote_granel.folio_fq);
                          $('#contenido').val(response.data.lote_granel.cont_alc);
                          $('#no_lote_envasado').val(response.data.lote_envasado.nombre);
                          $('#lugar_envasado').val(response.data.instalacion.direccion_completa);

                          
                          
                          
                        
                      } else {
                          Swal.fire('Error', 'No se encontraron datos', 'error');
                      }
                  },
                  error: function () {
                      Swal.fire('Error', 'Ocurrió un problema con la consulta', 'error');
                  }
              });
          }
      });
  });*/


});
