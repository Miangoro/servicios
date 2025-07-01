'use strict';

$(function () {

  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#addGuias');

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
        url: baseUrl + 'guias-list'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id_guia' },
        {
          data: null,
          searchable: true,
          orderable: false,
          render: function (data, type, row) {
            var id_empresa = '';
            var razon_social = '';

            if (row.id_empresa != 'N/A') {
              id_empresa =
                '<br><span class="fw-bold text-dark small">Número del cliente:</span><span class="small"> ' +
                row.id_empresa +
                '</span>';
            }
            if (row.razon_social != 'N/A') {
              razon_social =
                '<br><span class="fw-bold text-dark small">Nombre del cliente:</span><span class="small"> ' +
                row.razon_social +
                '</span>';
            }

            return (
              '<span class="fw-bold text-dark small">Número del cliente:</span> <span class="small"> ' +
              row.id_empresa +
              '</span><br><span class="fw-bold text-dark small">Nombre del cliente:</span><span class="small"> ' +
              row.razon_social
            );
          }
        },
        { data: 'folio' },
        { data: 'run_folio' },
        { data: 'id_predio' },
        { data: 'numero_guias' },
        { data: 'numero_plantas' },
        { data: 'num_anterior' },
        { data: 'num_comercializadas' },
        { data: 'mermas_plantas' },
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
              `<a data-id="${full['run_folio']}" data-bs-toggle="modal" data-bs-target="#verGuiasRegistardas" href="javascript:;" class="dropdown-item ver-registros"><i class="ri-id-card-line ri-20px text-primary"></i> Ver/Llenar guías de traslado</a>` +
              `<a data-id="${full['id_guia']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar guía de traslado</a>` +
              /*               `<button class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_guia']}" data-bs-toggle="modal" data-bs-target="#editGuias"><i class="ri-edit-box-line ri-20px text-info"></i></button>` +
                            `<button class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-id="${full['id_guia']}"><i class="ri-delete-bin-7-line ri-20px text-danger"></i></button>` + */
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
        },
        {
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Solicitud de Guía de Traslado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addGuias'
          }
        }
      ],
      // For responsive popup
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

  //Inicializar DatePicker
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

    //Obtener nombre predio
    function obtenerNombrePredio() {
      var empresa = $("#id_empresa").val();
      $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function (response) {
          console.log(response);
          var contenido = "";
          for (let index = 0; index < response.predios.length; index++) {
            contenido = '<option value="' + response.predios[index].id_predio + '">' + response
              .predios[index].nombre_predio + '</option>' + contenido;
          }
          if (response.predios.length == 0) {
            contenido = '<option value="">Sin predios registradas</option>';
          }
          $('#nombre_predio').html(contenido);
          formValidator.revalidateField('predios');
        },
        error: function () {
        }
      });
    }

    //Obtener plantacion
    function obtenerPlantacionPredio() {
      var empresa = $("#id_empresa").val();
      $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function (response) {
          console.log(response);
          var contenido = "";
          for (let index = 0; index < response.predio_plantacion.length; index++) {
            contenido = '<option value="' + response.predio_plantacion[index].id_plantacion +
              '" " data-num-plantas="' + response.predio_plantacion[index].num_plantas + '">Número de plantas: ' + response
                .predio_plantacion[index].num_plantas + ' | Tipo de agave: ' + response
                  .predio_plantacion[index].nombre + ' ' + response
                    .predio_plantacion[index].cientifico + ' | Año de platanción: ' + response
                      .predio_plantacion[index].anio_plantacion + '</option>' + contenido;
          }
          if (response.predio_plantacion.length == 0) {
            contenido = '<option value="">Sin predios registradas</option>';
          }
          $('#id_plantacion').html(contenido);
          $('#id_plantacion').on('change', function () {
            var selectedOption = $(this).find('option:selected');
            var numPlantas = selectedOption.data('num-plantas');
            $('#num_anterior').val(numPlantas);
          });
          $('#id_plantacion').trigger('change');
          formValidator.revalidateField('plantacion');
        },
        error: function () {
        }
      });
    }

    $('#id_empresa').on('change', function () {
      obtenerNombrePredio();  // Cargar las marcas
      obtenerPlantacionPredio();  // Cargar las direcciones
      formValidator.revalidateField('empresa');  // Revalidar el campo de empresa
    });
    // Agregar nuevo registro y validacion
    const addGuiaForm = document.getElementById('addGuiaForm');
    const formValidator = FormValidation.formValidation(addGuiaForm, {
      fields: {
        empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente'
            }
          }
        },
        numero_guias: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca un número de guías a solicitar'
            },
            between: {
              min: 1,
              max: 100,
              message: 'El número de guías debe estar entre 1 y 100'
            },
            regexp: {
              regexp: /^(?!0)\d+$/,
              message: 'El número no debe comenzar con 0'
            }
          }
        },
        predios: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un predio de la lista'
            }
          }
        },
        plantacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa para continuar'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: function (field, ele) {
            return '.mb-5, .mb-6';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function (e) {
      var formData = new FormData(addGuiaForm);

      $.ajax({
        url: '/guias/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {

          $('#addGuias').modal('hide');
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
            text: 'Error al registrar la guía de traslado',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  // Limpiar campos al cerrar el modal
  $('#addGuias').on('hidden.bs.modal', function () {
    // Restablecer select de empresa
    $('#id_empresa').val('');
    $('#nombre_predio').html('');
    $('#id_plantacion').html('');
    $('#numero_guias').val('');
    $('#num_comercializadas').val('');
    $('#mermas_plantas').val('');
    $('#numero_plantas').val('');

    // Restablecer la validación del formulario
    formValidator.resetForm(true);
  });

  initializeSelect2(select2Elements);

  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var user_id = $(this).data('id'),
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
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}guias-list/${user_id}`,
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
          text: '¡La guia ha sido eliminada correctamente!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La guia no ha sido eliminada',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // Reciben los datos del pdf
  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var pdfUrl = '../guia_de_translado/' + id; // Ruta del PDF

    var iframe = $('#pdfViewerGuias');
    $('#loading-spinner-chelo').show(); //se el agrega esto
    iframe.hide(); //se el agrega esto
    iframe.attr('src', '../guia_de_translado/' + id);

    $('#titulo_modal_GUIAS').text('Guía de traslado');
    $('#subtitulo_modal_GUIAS').text(registro);
    $('#mostrarPdfGUias').modal('show');
    var descargarBtn = $('#descargarPdfBtn');
    // Actualizar el enlace de descarga
    descargarBtn.off('click').on('click', function (e) {
      e.preventDefault();
      downloadPdfAsZip(pdfUrl, 'Guia_de_traslado_' + registro + '.pdf');
    });
  });
  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewerGuias').on('load', function () {
    $('#loading-spinner-chelo').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });


  //Editar guias
  $(document).on('click', '.edit-record', function () {
    var id_guia = $(this).data('id');

    $.get('/edit/' + id_guia, function (data) {
      // Rellenar el formulario con los datos obtenidos
      $('#editt_id_guia').val(data.id_guia);
      $('#edit_id_empresa').val(data.id_empresa).trigger('change');
      $('#edit_numero_guias').val(data.numero_guias);
      $('#edit_nombre_predio').val(data.id_predio).trigger('change'); // Cambiado a 'id_predio'
      $('#edit_id_plantacion').val(data.id_plantacion).trigger('change');
      $('#edit_num_anterior').val(data.num_anterior);
      $('#edit_num_comercializadas').val(data.num_comercializadas);
      $('#edit_mermas_plantas').val(data.mermas_plantas);
      $('#edit_numero_plantas').val(data.numero_plantas);
      $('#edit_edad').val(data.edad);
      $('#edit_id_art').val(data.art);
      $('#edit_kg_magey').val(data.kg_maguey);
      $('#edit_no_lote_pedido').val(data.no_lote_pedido);
      $('#edit_fecha_corte').val(data.fecha_corte);
      $('#edit_id_observaciones').val(data.observaciones);
      $('#edit_nombre_cliente').val(data.nombre_cliente);
      $('#edit_no_cliente').val(data.no_cliente);
      $('#edit_fecha_ingreso').val(data.fecha_ingreso);
      $('#edit_domicilio').val(data.domicilio);
      // Mostrar el modal de edición
      $('#editGuias').modal('show');
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Error al obtener los datos de la guía de traslado',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    });
  });

// Ver guías y descargar
$(document).on('click', '.ver-registros', function () {
  var run_folio = $(this).data('id');

  $.get('/editGuias/' + run_folio, function (data) {
      $('#tablita').empty();

      // Array para almacenar URLs y nombres de los PDFs
      var pdfFiles = [];

      data.forEach(function (item) {
          var razon_social = item.empresa ? item.empresa.razon_social : 'Indefinido';
          var pdfUrl = '../guia_de_translado/' + item.id_guia;
          var filename = 'Guia_de_traslado_' + item.folio + '.pdf';

          pdfFiles.push({ url: pdfUrl, filename: filename });

          var fila = `
              <tr>
                  <td>${item.folio}</td>
                  <td>
                      <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" 
                          data-bs-target="#mostrarPdfGUias" 
                          data-bs-toggle="modal" 
                          data-bs-dismiss="modal" 
                          data-id="${item.id_guia}" 
                          data-registro="${razon_social}">
                      </i>
                  </td>
                  <td>
                      <a href="${pdfUrl}" target="_blank" class="open-pdf" rel="noopener noreferrer">
                          <i class="ri-file-pdf-2-line text-danger ri-40px cursor-pointer"></i>
                      </a>
                  </td>
                  <td>
                      <button type="button" class="btn btn-info">
                          <a href="javascript:;" class="edit-record" style="color:#FFF" 
                              data-id="${item.id_guia}" 
                              data-bs-toggle="modal" 
                              data-bs-target="#editGuias">
                              <i class="ri-book-marked-line"></i> Llenar guia
                          </a>
                      </button>
                  </td>
              </tr>
          `;
          $('#tablita').append(fila);
      });

      $('#verGuiasRegistardas').modal('show');

      // Descargar todos los PDFs en un archivo ZIP
      $('#descargarPdfBtn')
          .off('click')
          .on('click', function (e) {
              e.preventDefault();
              downloadPdfsAsZip(pdfFiles, `Guias_de_traslado_${run_folio}.zip`);
          });
  }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus + ' - ' + errorThrown);
      Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al obtener los datos de la guía de traslado',
          customClass: {
              confirmButton: 'btn btn-danger'
          }
      });
  });
});

  // Función para descargar múltiples PDFs en un archivo ZIP
  function downloadPdfsAsZip(pdfFiles, zipFileName) {
    Swal.fire({
      title: '🔄 Procesando...',
      text: 'Por favor espera mientras se comprimen los archivos.',
      allowOutsideClick: false,
      customClass: {},
      didOpen: () => {
        Swal.showLoading();
      }
    });
    var zip = new JSZip();
    // Crear una lista de promesas para descargar cada PDF
    var pdfPromises = pdfFiles.map(file =>
      fetch(file.url)
        .then(response => response.blob())
        .then(blob => {
          zip.file(file.filename, blob); // Añadir el archivo al ZIP
        })
        .catch(error => console.error('Error al descargar el PDF:', error))
    );

    // Esperar a que todas las descargas terminen y crear el ZIP
    Promise.all(pdfPromises).then(() => {
      zip
        .generateAsync({ type: 'blob' })
        .then(function (zipBlob) {
          // Descargar el archivo ZIP
          saveAs(zipBlob, zipFileName);
          // Cerrar la alerta de "Procesando..." después de que el ZIP esté listo
          Swal.close();
        })
        .catch(error => {
          console.error('Error al generar el archivo ZIP:', error);
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Hubo un problema al generar el archivo ZIP.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        });
    });
  }

  //Editar Guias y validacion
  const editGuiaForm = document.getElementById('editGuiaForm');
  const fv2 = FormValidation.formValidation(editGuiaForm, {
    fields: {
      id_empresa: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un cliente'
          }
        }
      },
      numero_guias: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese el número de guías solicitadas'
          }
        }
      },
      predios: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione un predio'
          }
        }
      },
      plantacion: {
        validators: {
          notEmpty: {
            message: 'Por favor seleccione una plantación'
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
    var formData = new FormData(editGuiaForm);
    $.ajax({
      url: '/update/', // Actualiza con la URL correcta
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#editGuias').modal('hide');
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
          text: 'Error al registrar la guía de traslado',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });
});
