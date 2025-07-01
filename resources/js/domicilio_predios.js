/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Selecciona los elementos para el formulario de edición


  $(document).on('change', '#edit_tiene_coordenadas', function () {
    var tieneCoordenadasSelectEdit = $(this);
    var coordenadasDivEdit = $('#edit_coordenadas');

    if (tieneCoordenadasSelectEdit.val() === 'Si') {
      coordenadasDivEdit.removeClass('d-none');
    } else {
      coordenadasDivEdit.addClass('d-none');
    }
  });

  // Variable declaration for table
  var dt_user_table = $('.datatables-users');
  //DATE PICKER
  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true
    });

  });

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
        url: baseUrl + 'predios-list', // Asegúrate de que esta URL coincida con la ruta en tu archivo de rutas
        type: 'GET'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id_predio' },
        { data: 'id_empresa', className: 'col-id-empresa' },
        {
          data: 'num_predio',
          className: 'col-id-empresa text-center',
          render: function (data, type, full, meta) {
            if (data === 'Sin asignar') {
              return '<span class="badge bg-danger rounded-pill">Sin asignar</span>';
            }
            return data ?? '';
          }
        },
        { data: 'nombre_predio' , className: 'col-id-empresa'},
        { data: 'ubicacion_predio', className: 'col-id-empresa' },
        { data: 'tipo_predio', className: 'col-id-empresa' },
        //{ data: 'puntos_referencia' },
        // { data: 'cuenta_con_coordenadas' },
        { data: 'superficie', className: 'col-id-empresa' },
        {
          data: 'estatus', className: 'col-id-empresa',
          searchable: true, orderable: true,
          render: function (data, type, row) {
            var estatusClass = '';
            // Asignar clases según el estatus
            if (data === 'Vigente') {
              estatusClass = 'badge rounded-pill bg-success'; // Verde para 'Vigente'
            } else if (data === 'Pendiente') {
              estatusClass = 'badge rounded-pill bg-danger'; // Rojo para 'Pendiente'
            } else if (data === 'Inspeccionado') {
              estatusClass = 'badge rounded-pill bg-warning'; // Amarillo para 'Inspeccionado'
            }
            return '<span class="' + estatusClass + '">' + data + '</span>';
          }
        },
        { data: '' },
        { data: '' },
        { data: '' },
        { data: '' },
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
        // Pdf de solicitud
        // Pdf de solicitud
        {
          targets: 9,
          className: 'text-center',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            if (full['hasSolicitud']) {
              return `<a href="#" class="text-primary pdfSolicitud col-id-empresa"
                        data-bs-toggle="modal"
                        data-bs-target="#mostrarPdfDictamen1"
                        data-id="${full['id_solicitud']}"
                        data-registro="${full['id_empresa']}">
                        ${full['folio_solicitud']}
                      </a>`;
            } else {
              return `<span class="text-muted col-id-empresa"
                        data-bs-placement="right" title="Necesita hacer la solicitud">Sin asignar</span>`;
            }
          }
        },

        // Pdf de pre-registro
        {
          targets: 10,
          className: 'text-center',
          searchable: false, orderable: false,
          render: function (data, type, full, meta) {
            var $id = full['id_guia'];
            if (full['estatus'] === 'Pendiente' || full['estatus'] === 'Inspeccionado' || full['estatus'] === 'Vigente') {
              return `<i class="ri-file-pdf-2-fill text-danger ri-32px pdf cursor-pointer"
                      data-bs-target="#mostrarPdfDcitamen1" data-bs-toggle="modal"
                      data-bs-dismiss="modal" data-id="${full['id_predio']}"
                      data-registro="${full['id_empresa']}"></i>`;
            } else {
              return '<i class="ri-file-pdf-2-fill ri-32px icon-no-pdf"></i>'; // Mostrar ícono si no cumple las condiciones
            }
          }
        },
        //inspeccion y acta
        {
          targets: 11, // o el índice que te corresponda
          className: 'text-center',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
          const tieneGeo = full['url_documento_geo'];
          const tieneActa = full['url_acta_inspeccion'];
          const numServicio = full['num_servicio'] || 'Sin asignar';
          const escapeHtml = (text) => $('<div>').text(text).html();

          let actaIcon = '';
          if (tieneActa) {
            actaIcon = `
              <a class="text-danger pdf2 cursor-pointer"
                data-id="${full['id_predio']}"
                data-registro="${full['id_empresa']}"
                data-url="${tieneActa}"
                data-tipo="acta"
                title="Acta de inspección">
                <i class="ri-file-pdf-2-fill ri-32px"></i>
              </a>`;
          } else {
            actaIcon = `<i class="ri-file-pdf-2-fill ri-32px text-muted" title="Sin acta"></i>`;
          }
        if (tieneGeo) {
          return `
            <a class="text-primary text-danger col-id-empresa pdf2 cursor-pointer me-2"
              data-id="${full['id_predio']}"
              data-registro="${full['id_empresa']}"
              data-url="${tieneGeo}"
              data-tipo="geo">
              ${escapeHtml(numServicio)}
            </a>${actaIcon}`;
        } else {
          const clase = numServicio === 'Sin asignar' ? 'text-muted' : '';
          return `<span class="${clase} col-id-empresa me-2">${escapeHtml(numServicio)}</span>`;
        }
        }

        },

        // Pdf de registro (Dictamen final)
        {
          targets: 12,
          className: 'text-center',
          searchable: false, orderable: false,
            render: function (data, type, full, meta) {
              if (full['estatus'] === 'Vigente' && full['url_documento_registro_predio']) {
                return `<i class="ri-file-pdf-2-fill text-danger ri-32px pdf3 cursor-pointer"
                            data-bs-target="#mostrarPdfDictamen1" data-bs-toggle="modal"
                            data-bs-dismiss="modal" data-id="${full['id_predio']}"
                            data-registro="${full['id_empresa']}"
                            data-url="${full['url_documento_registro_predio']}"></i>`;
              } else {
                return '<i class="ri-file-pdf-2-fill ri-32px icon-no-pdf"></i>';
              }
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
          targets: -1,
          title: 'Acciones',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            const estatus = full['estatus']; // "Pendiente", "Inspeccionado", "Vigente"

            let opciones = `
              <div class="d-flex align-items-center gap-50">
                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end m-0">
            `;

            // Pendiente → solo registrar inspección
            if (estatus === 'Pendiente') {
              opciones += `<a data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalAddPredioInspeccion" class="dropdown-item inspeccion-record waves-effect text-primary"><i class="ri-add-circle-line ri-20px text-primary"></i> Registrar inspección</a>`;
            }

            // Inspeccionado → editar inspección y registrar predio
            if (estatus === 'Inspeccionado') {
              opciones += `<a data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalEditPredioInspeccion" class="dropdown-item edit-inspeccion-record waves-effect text-warning"><i class="ri-edit-2-line ri-20px text-warning"></i> Editar inspección</a>`;
              opciones += `<a data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalAddRegistroPredio" class="dropdown-item registro-record waves-effect text-primary"><i class="ri-add-circle-line ri-20px text-primary"></i> Registrar predio</a>`;
            }

            // Vigente → editar inspección y editar registro
            if (estatus === 'Vigente') {
              opciones += `<a data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalEditPredioInspeccion" class="dropdown-item edit-inspeccion-record waves-effect text-warning"><i class="ri-edit-2-line ri-20px text-warning"></i> Editar inspección</a>`;
              opciones += `<a data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalEditRegistroPredio" class="dropdown-item waves-effect edit_registro-record text-warning"><i class="ri-edit-2-line ri-20px text-warning"></i> Editar registro</a>`;
            }

            // Todos pueden editar el pre-registro
            opciones += `<a data-id="${full['id_predio']}" data-bs-toggle="modal" data-bs-target="#modalEditPredio" class="dropdown-item edit-record waves-effect text-info"><i class="ri-edit-box-line ri-20px text-info"></i> Editar pre-registro</a>`;

            // Todos pueden eliminar
            opciones += `<a data-id="${full['id_predio']}" class="dropdown-item delete-record waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>`;

            opciones += '</div></div>';
            return opciones;
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
              title: 'Predios',
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
              title: 'Users',
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
              title: 'Predios',
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
              title: 'Predios',
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
              title: 'Predios',
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline shadow"></i><span class="d-none d-sm-inline-block">Agregar pre-registro de predios</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#modalAddPredio'
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['nombre_predio'];
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
    var id_predio = $(this).data('id'); // Obtener el ID de la clase
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
          url: `${baseUrl}predios-list/${id_predio}`,
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
              text: '¡El predio ha sido eliminado correctamente!',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          },
          error: function (error) {
            console.log(error);

            // Mostrar SweetAlert de error
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo eliminar el predio. Inténtalo de nuevo más tarde.',
              footer: `<pre>${error.responseText}</pre>`,
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
          text: 'La eliminación del predio ha sido cancelada',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
  });

  /* creacion seccion de plantacion */
  $(document).ready(function () {
    // Definir los contenedores
    const containerAdd = '.contenidoPlantacion';           // Contenedor para agregar plantaciones
    const containerEdit = '.edit_ContenidoPlantacion';      // Contenedor para editar plantaciones
    const containerInspeccion = '.inspeccion_ContenidoPlantacion'; // Contenedor para inspección

    // Función para generar las opciones de tipos de agave
    function generateOptions(tipos) {
      return tipos.map(tipo => `<option value="${tipo.id_tipo}">${tipo.nombre} (${tipo.cientifico})</option>`).join('');
    }

    // Función para agregar una nueva sección de plantación
    function addRow(container) {
      var options = generateOptions(tiposAgave); // Asumiendo que `tiposAgave` es un array con los tipos de agave
      var newSection = `
          <tr class="plantacion-row">
              <td rowspan="4">
                  <button type="button" class="btn btn-danger remove-row-plantacion btn-sm"><i class="ri-delete-bin-5-fill"></i></button>
              </td>
              <td><b>Nombre y Especie de Agave/Maguey</b></td>
              <td>
                  <div class="form-floating form-floating-outline mb-3">
                      <select name="id_tipo[]" class="select2 form-select tipo_agave" required>
                          <option value="" disabled selected>Tipo de agave</option>
                          ${options}
                      </select>
                      <label for="especie_agave"></label>
                  </div>
              </td>
          </tr>
          <tr class="plantacion-row">
              <td><b>Número de Plantas</b></td>
              <td>
                  <div class="form-floating form-floating-outline">
                      <input type="number" class="form-control" name="numero_plantas[]" placeholder="Número de plantas" step="1" autocomplete="off" required>
                      <label for="numero_plantas">Número de Plantas</label>
                  </div>
              </td>
          </tr>
          <tr class="plantacion-row">
              <td><b>Año de plantación</b></td>
              <td>
                  <div class="form-floating form-floating-outline">
                      <input type="number" class="form-control" name="edad_plantacion[]" placeholder="Año de plantación" step="1" autocomplete="off" required>
                      <label for="edad_plantacion">Año de plantación</label>
                  </div>
              </td>
          </tr>
          <tr class="plantacion-row">
              <td><b>Tipo de Plantación</b></td>
              <td>
                  <div class="form-floating form-floating-outline">
                      <select class="form-control" name="tipo_plantacion[]" >
                                                            <option value="Cultivado">Cultivado</option>
                                                            <option value="Silvestre">Silvestre</option>
                                                        </select>
                      <label for="tipo_plantacion">Tipo de Plantación</label>
                  </div>
              </td>
          </tr>`;
      // Agregar la nueva sección al contenedor correspondiente (al final)
      $(container).append(newSection);
      // Inicializar Select2 en los nuevos campos
      $(container).find('.select2').select2();
      // Inicializar los elementos select2
      var select2Elements = $('.select2');
      initializeSelect2(select2Elements);

      // Habilitar el botón de eliminación para las nuevas filas
      if ($(container).find('.plantacion-row').length > 1) {
        $(container).find('.remove-row-plantacion').not(':first').prop('disabled', false);
      }
    }

    // Evento para agregar filas de plantación (para agregar, editar e inspección)
    $('.add-row-plantacion').on('click', function () {
      // Determinar en qué sección estamos
      const isEdit = $(this).closest('.edit_InformacionAgave').length > 0;
      const isInspeccion = $(this).closest('.inspeccion_InformacionAgave').length > 0;

      let container = containerAdd; // Por defecto, usar contenedor de agregar
      if (isEdit) {
        container = containerEdit;
      } else if (isInspeccion) {
        container = containerInspeccion;
      }
      addRow(container);
    });

    // Evento para eliminar filas de plantación
    $(document).on('click', '.remove-row-plantacion', function () {
      var $currentRow = $(this).closest('tr');
      var container = $currentRow.closest('tbody');

      if ($currentRow.index() === 0) return; // No permitir eliminar la primera fila

      $currentRow.nextUntil('tr:not(.plantacion-row)').addBack().remove();

      // Deshabilitar el botón de eliminación si queda solo una fila
      if (container.find('.plantacion-row').length <= 1) {
        container.find('.remove-row-plantacion').prop('disabled', true);
      }
    });

    // Deshabilitar el botón de eliminación en la primera fila de cada contenedor
    $(containerAdd).find('.remove-row-plantacion').first().prop('disabled', true);
    $(containerEdit).find('.remove-row-plantacion').first().prop('disabled', true);
    $(containerInspeccion).find('.remove-row-plantacion').first().prop('disabled', true);
  });


  // Definir fv en un alcance global
  let fv;

  $(document).ready(function () {
    const tieneCoordenadasSelect = document.getElementById('tiene_coordenadas');
    const coordenadasDiv = document.getElementById('coordenadas');
    const coordenadasBody = document.getElementById('coordenadas-body');
    const editCoordenadasBody = document.getElementById('coordenadas-body-edit');
    const inspeccionCoordenadasBody = document.getElementById('coordenadas-body-inspeccion');

    // Función para agregar una nueva fila de coordenadas
    function addCoordinateRow(body) {
      const newRow = `
            <tr>
                <td>
                    <button type="button" class="btn btn-danger remove-row-cordenadas btn-sm"><i class="ri-delete-bin-5-fill"></i></button>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="latitud[]" placeholder="Latitud" autocomplete="off" required>
                        <label>Latitud</label>
                    </div>
                </td>
                <td>
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control" name="longitud[]" placeholder="Longitud" autocomplete="off" required>
                        <label>Longitud</label>
                    </div>
                </td>
            </tr>`;
      body.insertAdjacentHTML('beforeend', newRow);
      updateRemoveButtonState(body);
    }

    // Función para eliminar una fila de coordenadas
    function removeCoordinateRow(button, body) {
      const $tableBody = $(button).closest('tbody');
      if ($tableBody.children('tr').length > 1) {
        $(button).closest('tr').remove();
      }
      updateRemoveButtonState(body);
    }

    // Función para actualizar el estado del botón de eliminar
    function updateRemoveButtonState(body) {
      $(body).find('tbody tr').each(function () {
        $(this).find('.remove-row-cordenadas').prop('disabled', $(this).siblings('tr').length === 0);
      });
    }

    // Inicializar el estado del botón de eliminar en todas las tablas al cargar la página
    updateRemoveButtonState(coordenadasBody);
    updateRemoveButtonState(editCoordenadasBody);
    updateRemoveButtonState(inspeccionCoordenadasBody);

    // Evento para cambiar la visibilidad de las coordenadas basado en la selección
    if (tieneCoordenadasSelect && coordenadasDiv) {
      tieneCoordenadasSelect.addEventListener('change', function () {
        if (tieneCoordenadasSelect.value === 'Si') {
          coordenadasDiv.classList.remove('d-none');
          if (coordenadasBody.children.length === 0) {
            addCoordinateRow(coordenadasBody);
          }
        } else {
          coordenadasDiv.classList.add('d-none');
          coordenadasBody.innerHTML = ''; // Limpiar todos los campos
        }
      });
    }
    else {
      // Quitar validaciones antes de limpiar los campos
      $(coordenadasBody).find('input[name="latitud[]"]').each(function () {
      });
      $(coordenadasBody).find('input[name="longitud[]"]').each(function () {
      });

      coordenadasDiv.classList.add('d-none');
      coordenadasBody.innerHTML = ''; // Limpiar todos los campos
    }


    // Manejo de eventos para añadir y eliminar filas de coordenadas en la vista principal
    $(document).on('click', '.add-row-cordenadas', function () {
      addCoordinateRow(coordenadasBody);
    });

    $(document).on('click', '.remove-row-cordenadas', function () {
      removeCoordinateRow(this, coordenadasBody);
    });

    // Manejo de eventos para añadir y eliminar filas de coordenadas en el modal de edición
    $(document).on('click', '.add-row-cordenadas-edit', function () {
      addCoordinateRow(editCoordenadasBody);
    });

    $(document).on('click', '.remove-row-cordenadas', function () {
      removeCoordinateRow(this, editCoordenadasBody);
    });

    // Manejo de eventos para añadir y eliminar filas de coordenadas en la sección de inspección
    $(document).on('click', '.add-row-cordenadas-inspeccion', function () {
      addCoordinateRow(inspeccionCoordenadasBody);
    });

    $(document).on('click', '.remove-row-cordenadas', function () {
      removeCoordinateRow(this, inspeccionCoordenadasBody);
    });
  });



  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const addNewPredio = document.getElementById('addNewPredioForm');
    fv = FormValidation.formValidation(addNewPredio, { // Usa la variable fv global
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona la empresa cliente'
            }
          }
        },
        nombre_productor: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el nombre del productor'
            }
          }
        },
        nombre_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el nombre del predio'
            }
          }
        },
        tipo_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el tipo de predio'
            }
          }
        },
        puntos_referencia: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa los puntos de referencia'
            }
          }
        },
        ubicacion_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la ubicación del predio'
            }
          }
        },
        superficie: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la superficie del predio'
            },
            numeric: {
              message: 'Por favor ingresa un valor numérico válido'
            }
          }
        },
        tiene_coordenadas: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona si el predio cuenta con coordenadas'
            }
          }
        },
        /* url: {
           validators: {
             notEmpty: {
               message: 'Por favor adjunta el documento requerido'
             }
           }
         },*/
        'id_tipo[]': {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el tipo de agave/maguey'
            }
          }
        },
        'numero_plantas[]': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el número de plantas'
            },
            numeric: {
              message: 'Por favor ingresa un valor numérico válido'
            }
          }
        },
        'edad_plantacion[]': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la edad de la plantación'
            },
            numeric: {
              message: 'Por favor ingresa un valor numérico válido'
            }
          }
        },
        'tipo_plantacion[]': {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el tipo de plantación'
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
    // Manejo del envío del formulario
    fv.on('core.form.valid', function (e) {
      $('#btnAddNewPredio').addClass('d-none');
      $('#btnSpinnerPredio').removeClass('d-none');
      var formData = new FormData(addNewPredio);
      $.ajax({
        url: '/predios-list',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          addNewPredio.reset();
          $('#id_empresa').val('').trigger('change');
          $('#btnSpinnerPredio').addClass('d-none');
          $('#btnAddNewPredio').removeClass('d-none');
          $('#modalAddPredio').modal('hide');
          $('.datatables-users').DataTable().ajax.reload();
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-success'
            }
          }).then(function () {
            limpiarModal();
            // Abre el modal de georreferenciación
            $('#addSolicitudGeoreferenciacion').modal('show');
            // Inicializa el modal de georreferenciación
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
          $('#btnSpinnerPredio').addClass('d-none');
          $('#btnAddNewPredio').removeClass('d-none');
        }
      });
    });

    // Inicializar select2 y revalidar el campo cuando cambie
    $('#id_empresa, .tipo_agave').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });

  /* traje la funcion de agregar solicitud de georeferenciacion en predios */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Inicializar FormValidation para la solicitud de georreferenciación
    const addRegistrarSolicitudGeoreferenciacion = document.getElementById('addRegistrarSolicitudGeoreferenciacion');
    const fvGeoreferenciacion = FormValidation.formValidation(addRegistrarSolicitudGeoreferenciacion, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona el cliente.'
            }
          }
        },
        'fecha_visita': {
          validators: {
            notEmpty: {
              message: 'Selecciona la fecha sugerida para la inspección.'
            }
          }
        },
        'punto_reunion': {
          validators: {
            notEmpty: {
              message: 'Introduce la dirección para el punto de reunión.'
            }
          }
        },
        // Agrega otros campos necesarios para la validación aquí
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
      $('#btnRegistrarGeo').addClass('d-none');
      $('#btnSpinnerGeoreferenciacion').removeClass('d-none');
      // Validar el formulario
      var formData = new FormData(addRegistrarSolicitudGeoreferenciacion);
      $.ajax({
        url: '/registrar-solicitud-georeferenciacion', // Cambia esta URL según tu endpoint
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#btnSpinnerGeoreferenciacion').addClass('d-none');
          $('#btnRegistrarGeo').removeClass('d-none');
          $('#addSolicitudGeoreferenciacion').modal('hide');
          addRegistrarSolicitudGeoreferenciacion.reset(); // Resetea el formulario
          $('.datatables-users').DataTable().ajax.reload();
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud registrada correctamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr) {
          console.log('Error:', xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar la solicitud de georreferenciación',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#btnSpinnerGeoreferenciacion').addClass('d-none');
          $('#btnRegistrarGeo').removeClass('d-none');
        }
      });
    });
  });

  // Llama a la función al abrir el modal de georreferenciación
  /*   $('#addSolicitudGeoreferenciacion').on('show.bs.modal', function () {
      if (typeof inicializarGeoreferenciacion === 'function') {
        inicializarGeoreferenciacion(); // Llama a la función de solicitudes.js
      }
    });
   */





  function limpiarModal() {
    // Aquí puedes añadir cualquier lógica necesaria para resetear el contenido del modal
    $('#modalAddPredio .plantacion-row').remove();
    $('#modalAddPredio #coordenadas tbody tr').remove();
    // Reiniciar select2 si es necesario
    $('.select2').val('').trigger('change');
    // Reiniciar otros elementos o plugins que uses dentro del modal
  }


  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const addEditPredioForm = document.getElementById('addEditPredioForm');
    const fv = FormValidation.formValidation(addEditPredioForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona la empresa cliente'
            }
          }
        },
        nombre_productor: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el nombre del productor'
            }
          }
        },
        nombre_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa el nombre del predio'
            }
          }
        },
        tipo_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona el tipo de predio'
            }
          }
        },
        puntos_referencia: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa los puntos de referencia'
            }
          }
        },
        ubicacion_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la ubicación del predio'
            }
          }
        },
        superficie: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la superficie del predio'
            },
            numeric: {
              message: 'Por favor ingresa un valor numérico válido'
            }
          }
        },
        tiene_coordenadas: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona si el predio cuenta con coordenadas'
            }
          }
        },
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
    }).on('core.form.valid', function (e) {
      $('#btnEditPredioPre').addClass('d-none');
      $('#btnSpinnerEditPredio').removeClass('d-none');
      var formData = new FormData(addEditPredioForm);
      var predioId = $('#edit_id_predio').val(); // Asegúrate de que este ID esté correctamente asignado

      $.ajax({
        url: '/domicilios-predios/' + predioId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          addEditPredioForm.reset();
          $('#btnEditPredioPre').removeClass('d-none');
          $('#btnSpinnerEditPredio').addClass('d-none');
          $('#modalEditPredio').modal('hide');
          $('.datatables-users').DataTable().ajax.reload(null, false);
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
              text: 'Ha ocurrido un error al actualizar el predio.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
          $('#btnEditPredioPre').removeClass('d-none');
          $('#btnSpinnerEditPredio').addClass('d-none');
        }
      });
    });

    // Manejar el clic en el botón de editar
    $(document).on('click', '.edit-record', function () {
      var predioId = $(this).data('id'); // Obtener el ID del predio a editar
      $('#edit_id_predio').val(predioId);

      // Solicitar los datos del predio desde el servidor
      $.ajax({
        url: '/domicilios-predios/' + predioId + '/edit',
        method: 'GET',
        success: function (data) {
          if (data.success) {
            var predio = data.predio;

            // Rellenar el formulario con los datos del predio
            $('#edit_id_empresa').val(predio.id_empresa).trigger('change');
            $('#edit_nombre_productor').val(predio.nombre_productor);
            $('#edit_nombre_predio').val(predio.nombre_predio);
            $('#edit_ubicacion_predio').val(predio.ubicacion_predio);
            $('#edit_tipo_predio').val(predio.tipo_predio);
            $('#edit_puntos_referencia').val(predio.puntos_referencia);
            $('#edit_tiene_coordenadas').val(predio.cuenta_con_coordenadas).trigger('change');
            $('#edit_superficie').val(predio.superficie);

            /* console.log(data.documentos); // Verifica el contenido */

            if (Array.isArray(data.documentos)) {
              $('#archivo_url_contrato').empty(); // Limpia el contenido existente

              data.documentos.forEach(function (documento) {
                var nombre = documento.nombre; // Nombre del documento
                var url = documento.url; // URL del documento

                // Codificar la URL del archivo
                var urlCodificada = encodeURIComponent(url);

                // Construir la URL completa utilizando el numeroCliente
                var urlCompleta = '../files/' + data.numeroCliente + '/' + urlCodificada;

                // Agregar el enlace al documento en el div
                $('#archivo_url_contrato').append(`
                                    <a href="${urlCompleta}" target="_blank">${nombre}</a>
                                    <br>
                                `);
              });
            } else {
              console.error('data.documentos no es un array:', data.documentos);
            }

            // Limpiar las filas de coordenadas anteriores
            $('#edit_coordenadas tbody').empty();

            // Rellenar coordenadas o añadir una fila vacía si no hay coordenadas
            if (predio.cuenta_con_coordenadas === 'Si' && data.coordenadas.length > 0) {
              data.coordenadas.forEach(function (coordenada) {
                var newRow = `
                        <tr>
                            <td>
                                <button type="button" class="btn btn-danger remove-row-cordenadas btn-sm"><i class="ri-delete-bin-5-fill"></i></button>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="latitud[]" value="${coordenada.latitud}" placeholder="Latitud" autocomplete="off">
                                    <label for="latitud">Latitud</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" name="longitud[]" value="${coordenada.longitud}" placeholder="Longitud" autocomplete="off">
                                    <label for="longitud">Longitud</label>
                                </div>
                            </td>
                        </tr>`;
                $('#edit_coordenadas tbody').append(newRow);
              });
            } else {
              var emptyRow = `
                    <tr>
                        <td>
                            <button type="button" class="btn btn-danger remove-row-cordenadas btn-sm"><i class="ri-delete-bin-5-fill"></i></button>
                        </td>
                        <td>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="latitud[]" placeholder="Latitud">
                                <label for="latitud">Latitud</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" name="longitud[]" placeholder="Longitud">
                                <label for="longitud">Longitud</label>
                            </div>
                        </td>
                    </tr>`;
              $('#edit_coordenadas tbody').append(emptyRow);
            }

            // Mostrar u ocultar la sección de coordenadas basado en la presencia de coordenadas
            if (predio.cuenta_con_coordenadas === 'Si' && data.coordenadas.length > 0) {
              $('#edit_coordenadas').removeClass('d-none');
            } else {
              $('#edit_coordenadas').addClass('d-none');
            }

            // Limpiar las filas de plantaciones anteriores
            $('.edit_ContenidoPlantacion').empty();

            // Cargar tipos de agave en el select
            var tipoOptions = data.tipos.map(function (tipo) {
              return `<option value="${tipo.id_tipo}">${tipo.nombre}  (${tipo.cientifico})</option>`;
            }).join('');

            // Rellenar plantaciones o añadir una fila vacía si no hay plantaciones
            if (data.plantaciones.length > 0) {
              data.plantaciones.forEach(function (plantacion) {

                $('#edit_superficie').val(predio.superficie);
                var newRow = `
                                <tr class="plantacion-row">
                                    <td rowspan="4">
                                        <button type="button" class="btn btn-danger remove-row-plantacion btn-sm"><i class="ri-delete-bin-5-fill"></i></button>
                                    </td>
                                    <td><b>Nombre y Especie de Agave/Maguey</b></td>
                                    <td>
                                        <div class="form-floating form-floating-outline mb-3">
                                            <select name="id_tipo[]" class="select2 form-select tipo_agave">
                                                <option disabled>Tipo de agave</option>
                                                ${tipoOptions}
                                            </select>
                                            <label for="especie_agave"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="plantacion-row">
                                    <td><b>Número de Plantas</b></td>
                                    <td>
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" name="numero_plantas[]" value="${plantacion.num_plantas}" placeholder="Número de plantas" step="1" autocomplete="off">
                                            <label for="numero_plantas">Número de Plantas</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="plantacion-row">
                                    <td><b>Año de la plantación</b></td>
                                    <td>
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" name="edad_plantacion[]" value="${plantacion.anio_plantacion}" placeholder="Año de la plantación" step="1" autocomplete="off">
                                            <label for="edad_plantacion">Año de la plantación</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="plantacion-row">
                                    <td><b>Tipo de Plantación</b></td>
                                    <td>
                                        <div class="form-floating form-floating-outline">
                                             <select class="form-control" name="tipo_plantacion[]" >
                                                  <option value="Cultivado" ${plantacion.tipo_plantacion === 'Cultivado' ? 'selected' : ''}>Cultivado</option>
                                                  <option value="Silvestre" ${plantacion.tipo_plantacion === 'Silvestre' ? 'selected' : ''}>Silvestre</option>
                                              </select>
                                            <label for="tipo_plantacion">Tipo de Plantación</label>
                                        </div>
                                    </td>
                                </tr>`;
                $('.edit_ContenidoPlantacion').append(newRow);
                // Seleccionar el tipo de agave actual
                $('.edit_ContenidoPlantacion').find('select[name="id_tipo[]"]').last().val(plantacion.id_tipo);
              });
              // Inicializar los elementos select2
              var select2Elements = $('.select2');
              initializeSelect2(select2Elements);
            } else {
              var emptyRow = `
                            <tr>
                                <td rowspan="4">
                                    <button type="button" class="btn btn-danger remove-row-plantacion btn-sm"><i class="ri-delete-bin-5-fill"></i></button>
                                </td>
                                <td><b>Nombre y Especie de Agave/Maguey</b></td>
                                <td>
                                    <div class="form-floating form-floating-outline mb-3">
                                        <select name="id_tipo[]" class="select2 form-select tipo_agave">
                                            <option value="" disabled>Tipo de agave</option>
                                            ${tipoOptions}
                                        </select>
                                        <label for="especie_agave"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Número de Plantas</b></td>
                                <td>
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control" name="numero_plantas[]" placeholder="Número de plantas" step="1">
                                        <label for="numero_plantas">Número de Plantas</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Año de plantación</b></td>
                                <td>
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control" name="edad_plantacion[]" placeholder="Año de plantación" step="1">
                                        <label for="edad_plantacion">Año de plantación</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Tipo de Plantación</b></td>
                                <td>
                                    <div class="form-floating form-floating-outline">
                                       <select class="form-control" name="tipo_plantacion[]" >
                                                  <option value="Cultivado">Cultivado</option>
                                                  <option value="Silvestre">Silvestre</option>
                                              </select>
                                        <label for="tipo_plantacion">Tipo de Plantación</label>
                                    </div>
                                </td>
                            </tr>`;
              $('.edit_ContenidoPlantacion').append(emptyRow);
            }

            // Mostrar el modal
            $('#modalEditPredio').modal('show');

            // Aplicar validaciones a las plantaciones dinámicas
            $('.edit_ContenidoPlantacion input').each(function () {
              fv.addField($(this).attr('name'), {
                validators: {
                  notEmpty: {
                    message: 'Este campo es requerido'
                  },

                }
              });
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo cargar los datos del predio.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (error) {
          console.error('Error al cargar los datos del predio:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos del predio.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });


  // Reciben los datos del PDF
  $(document).on('click', '.pdf', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewerDictamen1');
    var openPdfBtn = $('#openPdfBtnDictamen1'); // Botón para abrir en nueva pestaña

    // Mostrar el spinner y ocultar el iframe
    $('#loading-spinner1').show();
    iframe.hide();

    // Generar la URL del PDF
    var pdfUrl = '../pre-registro_predios/' + id;

    // Cargar el PDF en el iframe
    iframe.attr('src', pdfUrl);

    // Actualizar el texto y subtítulo del modal
    $("#titulo_modal_Dictamen1").text("Pre-registro de predios de maguey o agave");
    $("#subtitulo_modal_Dictamen1").html(registro);

    // Actualizar el botón para abrir en nueva pestaña
    openPdfBtn.attr('href', pdfUrl);
    openPdfBtn.show(); // Mostrar el botón

    // Abrir el modal
    $('#mostrarPdfDictamen1').modal('show');
  });

  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewerDictamen1').on('load', function () {
    $('#loading-spinner1').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });


    $(document).on('click', '.pdf2', function () {
      const pdfUrl = $(this).data('url');
      const tipo = $(this).data('tipo');
      const registro = $(this).data('registro');

      if (!pdfUrl) {
        alert('No hay documento para mostrar');
        return;
      }

      $('#loading-spinner1').show();
      $('#pdfViewerDictamen1').hide().attr('src', pdfUrl);

      let titulo = '';
      if (tipo === 'geo') {
        titulo = 'Inspección para la geo-referenciación de los predios de maguey o agave';
      } else if (tipo === 'acta') {
        titulo = 'Acta de inspección';
      }

      $('#titulo_modal_Dictamen1').text(titulo);
      $('#subtitulo_modal_Dictamen1').html(registro);
      $('#openPdfBtnDictamen1').attr('href', pdfUrl).show();

      $('#mostrarPdfDictamen1').modal('show');
    });


  $('#pdfViewerDictamen1').on('load', function () {
    $('#loading-spinner1').hide();
    $(this).show();
  });



  // Reciben los datos del PDF
      $(document).on('click', '.pdf3', function () {
        var id = $(this).data('id');
        var registro = $(this).data('registro');
        var pdfUrl = $(this).data('url'); // <- Aquí tomas la URL directamente
        var iframe = $('#pdfViewerDictamen1');
        var openPdfBtn = $('#openPdfBtnDictamen1');

        // Mostrar el spinner y ocultar el iframe
        $('#loading-spinner1').show();
        iframe.hide();

        // Cargar el PDF
        iframe.attr('src', pdfUrl);
        $("#titulo_modal_Dictamen1").text("F-UV-21-03 Registro de predios de maguey o agave Ed. 4 Vigente.");
        $("#subtitulo_modal_Dictamen1").html(registro);

        // Botón para abrir en nueva pestaña
        openPdfBtn.attr('href', pdfUrl);
        openPdfBtn.show();

        // Abrir el modal
        $('#mostrarPdfDictamen1').modal('show');
      });


  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewerDictamen1').on('load', function () {
    $('#loading-spinner1').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });


  // Reciben los datos del PDF
  $(document).on('click', '.pdfSolicitud', function () {
    var id = $(this).data('id');
    var registro = $(this).data('registro');
    var iframe = $('#pdfViewerDictamen1'); // Cambiado a pdfViewerDictamen1
    var openPdfBtn = $('#openPdfBtnDictamen1'); // Botón para abrir en nueva pestaña

    // Mostrar el spinner y ocultar el iframe
    $('#loading-spinner1').show();
    iframe.hide();

    // Generar la URL del PDF
    var pdfUrl = '../solicitud_de_servicio/' + id;

    // Cargar el PDF en el iframe
    iframe.attr('src', pdfUrl);

    // Actualizar el texto y subtítulo del modal
    $("#titulo_modal_Dictamen1").text("Inspección para la geo-referenciación de los predios de maguey o agave");
    $("#subtitulo_modal_Dictamen1").html(registro);

    // Actualizar el botón para abrir en nueva pestaña
    openPdfBtn.attr('href', pdfUrl);
    openPdfBtn.show(); // Mostrar el botón

    // Abrir el modal
    $('#mostrarPdfDictamen1').modal('show'); // Cambiado a mostrarPdfDictamen1
  });

  // Ocultar el spinner cuando el PDF esté completamente cargado
  $('#pdfViewerDictamen1').on('load', function () {
    $('#loading-spinner1').hide(); // Ocultar el spinner
    $(this).show(); // Mostrar el iframe con el PDF
  });




  /* seccion para la inserccion de los datos de los predios inspecciones */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const addAddPredioInspeccionForm = document.getElementById('addAddPredioInspeccionForm');
    const fv = FormValidation.formValidation(addAddPredioInspeccionForm, {
      fields: {
        ubicacion_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la ubicación del predio'
            }
          }
        },
        localidad: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la localidad'
            }
          }
        },
        distrito: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el distrito'
            }
          }
        },
        municipio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el municipio'
            }
          }
        },
        estado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el estado'
            }
          }
        },
        nombre_paraje: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el nombre del paraje'
            }
          }
        },
        zona_dom: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona la opción'
            }
          }
        },
        inspeccion_geo_Doc: {
          validators: {
            notEmpty: {
              message: 'Por favor adjunta el documento requerido'
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
    }).on('core.form.valid', function (e) {
      $('#btnAddPredioInspeccion').addClass('d-none');
      $('#btnSpinnerPredioInspeccion').removeClass('d-none');
      var formData = new FormData(addAddPredioInspeccionForm);
      var predioId = $('#inspeccion_id_predio').val(); // Asegúrate de que este ID esté correctamente asignado

      $.ajax({
        url: '/domicilios-predios/' + predioId + '/inspeccion',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          addAddPredioInspeccionForm.reset();
          $('#btnAddPredioInspeccion').removeClass('d-none');
          $('#btnSpinnerPredioInspeccion').addClass('d-none');
          $('#modalAddPredioInspeccion').modal('hide');
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
          $('#btnAddPredioInspeccion').removeClass('d-none');
          $('#btnSpinnerPredioInspeccion').addClass('d-none');
        }
      });

    });

    // Manejar el clic en el botón de editar
    $(document).on('click', '.inspeccion-record', function () {
      var predioId = $(this).data('id'); // Obtener el ID del predio a editar
      $('#inspeccion_id_predio').val(predioId);

      // Solicitar los datos del predio desde el servidor
      $.ajax({
        url: '/domicilios-predios/' + predioId + '/edit',
        method: 'GET',
        success: function (data) {
          if (data.success) {
            var predio = data.predio;
            /* console.log(data) */
            // Rellenar el formulario con los datos del predio
            $('#inspeccion_id_empresa').val(predio.id_empresa);
            $('#inspeccion_ubicacion_predio').val(predio.ubicacion_predio);

            $('#inspeccion_superficie').val(predio.superficie);
            // Limpiar las filas de coordenadas anteriores
            $('#coordenadas-body-inspeccion').empty();
            // Rellenar coordenadas o añadir una fila vacía si no hay coordenadas

            // Mostrar el modal
            $('#modalAddPredioInspeccion').modal('show');

          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo cargar los datos del predio.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        },
        error: function (error) {
          console.error('Error al cargar los datos del predio:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos del predio.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });

    });
    // Inicializar select2 y revalidar el campo cuando cambie
    $('#fecha_inspeccion, #tipoMaguey, #inspeccion_id_empresa, #tipoAgave, #estado').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });








  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de agregar predio
    const modalAddRegistroPredioForm = document.getElementById('modalAddRegistroPredioForm');
    const fv = FormValidation.formValidation(modalAddRegistroPredioForm, {
      fields: {
        num_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de predio'
            }
          }
        },
        fecha_emision: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de emisión'
            }
          }
        },
        fecha_vigencia: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de vigencia'
            }
          }
        },
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
    }).on('core.form.valid', function (e) {
      var formData = new FormData(modalAddRegistroPredioForm);
      var predioId = $('#id_predio_registro').val(); // ID del predio
      $('#btnRegistroPredio').addClass('d-none');
      $('#btnSpinnerRegistroPredio').removeClass('d-none');
      $.ajax({
        url: '/registro-Predio/' + predioId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          modalAddRegistroPredioForm.reset();
          $('#btnRegistroPredio').removeClass('d-none');
          $('#btnSpinnerRegistroPredio').addClass('d-none');
          $('#modalAddRegistroPredio').modal('hide');
          $('.datatables-users').DataTable().ajax.reload(); // Recargar la tabla de usuarios
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
          $('#btnRegistroPredio').removeClass('d-none');
          $('#btnSpinnerRegistroPredio').addClass('d-none');

          // Errores de validación (Laravel 422)
          if (xhr.status === 422) {
            let errores = xhr.responseJSON.errors;
            let mensajes = Object.values(errores).flat().join('\n');

            Swal.fire({
              icon: 'error',
              title: 'Errores de validación',
              text: mensajes,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });

            // Errores del catch (500 u otros)
          } else {
            const mensaje = xhr.responseJSON?.message || 'Ocurrió un error inesperado.';

            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: mensaje,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        }
      });
    });

    // Manejar el clic en el botón de editar
    $(document).on('click', '.registro-record', function () {
      var predioId = $(this).data('id'); // Obtener el ID del predio a editar
      $('#id_predio_registro').val(predioId); // Establecer el ID en el input correspondiente

    $.ajax({
      url: '/domicilios-predios/' + predioId + '/edit',
      method: 'GET',
      success: function (data) {
        if (data.success) {
          $('#PrdocumentoPreview').html(''); // Limpiar el contenido previo del documento
          var predio = data.predio;
          var url = data.url_documento;
          var documento = data.documento;
          // Rellenar el formulario con los datos del predio
          /*             $('#edit_id_predio_registro').val(predio.id_empresa).trigger('change'); */
          $('#num_predio').val(predio.num_predio);
          $('#fecha_emision').val(predio.fecha_emision);
          $('#fecha_vigencia').val(predio.fecha_vigencia);
            if (url && documento) {
              $('#documentoPreview').html(`
                <a href="${url}" target="_blank" class="text-primary">
                  ${documento.url}
                </a>
              `);
            } else {
              $('#PrdocumentoPreview').html(`<span class="text-muted">No hay documento cargado</span>`);
            }

          // Mostrar el modal
          $('#modalAddRegistroPredio').modal('show');

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos del predio.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      },
      error: function (error) {
        console.error('Error al cargar los datos del predio:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo cargar los datos del predio.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });


    });

    updateDatepickerValidation(fv);

  });

  // Función para agregar 5 años a la fecha de emisión y actualizar la fecha de vigencia
  function updateDatepickerValidation(fv) {
    $('#fecha_emision').on('change', function () {
      var fechaEmision = $(this).val();
      if (fechaEmision) {
        var fecha = moment(fechaEmision, 'YYYY-MM-DD'); // Asegurarse del formato
        var fechaVencimiento = fecha.add(5, 'years').format('YYYY-MM-DD'); // Agregar 5 años
        $('#fecha_vigencia').val(fechaVencimiento); // Actualizar el campo de vigencia

        // Revalidar ambos campos de fechas
        fv.revalidateField('fecha_emision');
        fv.revalidateField('fecha_vigencia');
      }
    });
  }


  //Date picker
  $(document).ready(function () {
    const flatpickrDateTime = document.querySelectorAll('.flatpickr-datetime');

    if (flatpickrDateTime.length) {
      flatpickrDateTime.forEach((element) => {
        // Inicializar flatpickr para cada input
        flatpickr(element, {
          enableTime: true, // Habilitar selección de tiempo
          time_24hr: true, // Mostrar tiempo en formato 24 horas
          dateFormat: 'Y-m-d H:i',
          locale: 'es',
          allowInput: true,
        });
      });
    }
  });



  $(document).on('click', '.edit-inspeccion-record', function () {
    var predioId = $(this).data('id'); // Obtener el ID del predio a editar
    $('#edit_inspeccion_id_predio').val(predioId);

    // Solicitar los datos del predio desde el servidor
    $.ajax({
      url: '/domicilios-predios/' + predioId + '/edit-inspeccion',
      method: 'GET',
      success: function (data) {
        if (data.success) {
          var inspeccion = data.data; // inspección con todos los campos directos
          var url = data.document_url;  // Aquí está la URL correcta
          console.log('url:', url);
          $('#edit_inspeccion_id_empresa').val(inspeccion.predio.id_empresa);
          $('#edit_inspeccion_ubicacion_predio').val(inspeccion.ubicacion_predio);
          $('#edit_inspeccion_superficie').val(inspeccion.superficie);
          $('#edit_localidad').val(inspeccion.localidad);
          $('#edit_municipio').val(inspeccion.municipio);
          $('#edit_estado').val(inspeccion.id_estado).trigger('change');
          $('#edit_distrito').val(inspeccion.distrito);
          $('#edit_nombreParaje').val(inspeccion.nombre_paraje);
          $('#edit_zonaDom').val(inspeccion.zona_dom).trigger('change');
          $('#url_documento_geo_edit').html(`<span class="text-muted">No hay documento cargado</span>`);
          /*           $('#edit_inspeccion_geo_Doc').val(predio.inspeccion_geo_Doc); */
          if (url) {
            $('#url_documento_geo_edit').html(`
                <a href="${url}" target="_blank" class="">
                  Inspección para la geo-referenciación de los predios de maguey o agave
                </a>
              `);
          } else {
            $('#url_documento_geo_edit').html(`<span class="text-muted">No hay documento cargado</span>`);
          }



          // Mostrar el modal
          $('#modalEditPredioInspeccion').modal('show');

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos del predio.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      },
      error: function (error) {
        console.error('Error al cargar los datos del predio:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo cargar los datos del predio.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });

  });




  /* seccion para la inserccion de los datos de los predios inspecciones */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const addAddPredioInspeccionForm = document.getElementById('EditPredioInspeccionForm');
    const fv = FormValidation.formValidation(addAddPredioInspeccionForm, {
      fields: {
        ubicacion_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingresa la ubicación del predio'
            }
          }
        },
        localidad: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la localidad'
            }
          }
        },
        distrito: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el distrito'
            }
          }
        },
        municipio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el municipio'
            }
          }
        },
        estado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el estado'
            }
          }
        },
        nombre_paraje: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el nombre del paraje'
            }
          }
        },
        zona_dom: {
          validators: {
            notEmpty: {
              message: 'Por favor selecciona la opción'
            }
          }
        },
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
    }).on('core.form.valid', function (e) {
      $('#btnEditInspeccionPredio').addClass('d-none');
      $('#btnSpinnerEditPredioInspeccion').removeClass('d-none');
      var formData = new FormData(addAddPredioInspeccionForm);
      var predioId = $('#edit_inspeccion_id_predio').val(); // Asegúrate de que este ID esté correctamente asignado

      $.ajax({
        url: '/domicilios-predios/' + predioId + '/inspeccion-update',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          addAddPredioInspeccionForm.reset();
          $('#btnEditInspeccionPredio').removeClass('d-none');
          $('#btnSpinnerEditPredioInspeccion').addClass('d-none');
          $('#modalEditPredioInspeccion').modal('hide');
          $('.datatables-users').DataTable().ajax.reload(null, false);
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
          $('#btnEditInspeccionPredio').removeClass('d-none');
          $('#btnSpinnerEditPredioInspeccion').addClass('d-none');
        }
      });

    });

    // Inicializar select2 y revalidar el campo cuando cambie
    $('#edit_fecha_inspeccion, #edit_estado').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });




  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de agregar predio
    const modalAddRegistroPredioForm = document.getElementById('modalEditRegistroPredioForm');
    const fv = FormValidation.formValidation(modalAddRegistroPredioForm, {
      fields: {
        num_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de predio'
            }
          }
        },
        fecha_emision: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de emisión'
            }
          }
        },
        fecha_vigencia: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de vigencia'
            }
          }
        },
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
    }).on('core.form.valid', function (e) {
      $('#btnEditRegistroPredio').addClass('d-none');
      $('#btnSpinnerEditRegistroPredio').removeClass('d-none');
      var formData = new FormData(modalAddRegistroPredioForm);
      var predioId = $('#edit_id_predio_registro').val(); // ID del predio
      $.ajax({
        url: '/edit-registro-Predio/' + predioId,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          modalAddRegistroPredioForm.reset();
          $('#btnEditRegistroPredio').removeClass('d-none');
          $('#btnSpinnerEditRegistroPredio').addClass('d-none');
          $('#modalEditRegistroPredio').modal('hide');
          $('.datatables-users').DataTable().ajax.reload(null, false); // Recargar la tabla de usuarios
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
          let mensajeError = 'Error desconocido';
          if (xhr.status === 422 && xhr.responseJSON) {
            const errores = xhr.responseJSON.errors;
            if (errores) {
              const primerCampo = Object.keys(errores)[0];
              mensajeError = errores[primerCampo][0];
            } else if (xhr.responseJSON.message) {
              mensajeError = xhr.responseJSON.message;
            }
          } else if (xhr.responseJSON && xhr.responseJSON.message) {
            mensajeError = xhr.responseJSON.message;
          }
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: mensajeError,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });

          $('#btnEditRegistroPredio').removeClass('d-none');
          $('#btnSpinnerEditRegistroPredio').addClass('d-none');
        }

      });
    });

    updateDatepickerValidationEdit(fv);

  });

  // Manejar el clic en el botón de editar
  $(document).on('click', '.edit_registro-record', function () {
    var predioId = $(this).data('id'); // Obtener el ID del predio a editar
    $('#edit_id_predio_registro').val(predioId); // Establecer el ID en el input correspondiente
    $.ajax({
      url: '/domicilios-predios/' + predioId + '/edit',
      method: 'GET',
      success: function (data) {
        if (data.success) {
          $('#documentoPreview').html(''); // Limpiar el contenido previo del documento
          var predio = data.predio;
          var url = data.url_documento;
          var documento = data.documento;
          // Rellenar el formulario con los datos del predio
          /*             $('#edit_id_predio_registro').val(predio.id_empresa).trigger('change'); */
          $('#edit_num_predio').val(predio.num_predio);
          $('#edit_fecha_emision').val(predio.fecha_emision);
          $('#edit_fecha_vigencia').val(predio.fecha_vigencia);
            if (url && documento) {
              $('#documentoPreview').html(`
                <a href="${url}" target="_blank" class="text-primary">
                  ${documento.url}
                </a>
              `);
            } else {
              $('#documentoPreview').html(`<span class="text-muted">No hay documento cargado</span>`);
            }

          // Mostrar el modal
          $('#modalEditRegistroPredio').modal('show');

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cargar los datos del predio.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      },
      error: function (error) {
        console.error('Error al cargar los datos del predio:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo cargar los datos del predio.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });

  });

  // Función para agregar 5 años a la fecha de emisión y actualizar la fecha de vigencia
  function updateDatepickerValidationEdit(fv) {
    $('#edit_fecha_emision').on('change', function () {
      var fechaEmision = $(this).val();
      if (fechaEmision) {
        var fecha = moment(fechaEmision, 'YYYY-MM-DD'); // Asegurarse del formato
        var fechaVencimiento = fecha.add(5, 'years').format('YYYY-MM-DD'); // Agregar 5 años
        $('#edit_fecha_vigencia').val(fechaVencimiento); // Actualizar el campo de vigencia
        // Revalidar ambos campos de fechas
        fv.revalidateField('fecha_emision');
        fv.revalidateField('fecha_vigencia');
      }
    });
  }



});
