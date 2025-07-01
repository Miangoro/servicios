$(function () {
  // Definir la URL base
  var baseUrl = window.location.origin + '/';

  // Inicializar DataTable
  var dt_instalaciones_table = $('.datatables-users').DataTable({

    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'inspecciones-list',
      type: 'GET',
      dataSrc: function (json) {
        console.log(json); // Ver los datos en la consola
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

      { data: '' },
      { data: 'folio' },
      {
        data: 'num_servicio',
        render: function (data, type, row) {
          if (!data || data.toLowerCase().includes('sin asignar')) {
            // No hay número, o es "sin asignar", entonces mostrar badge
            return `<p class="badge bg-danger">Sin asignar</p>`;
          } else {
            // Hay número de servicio, solo texto plano, sin etiquetas extra
            // Si viene con HTML, limpiarlo
            return $('<div>').html(data).text();
          }
        }
      },
      {
        render: function (data, type, full, meta) {
          var $numero_cliente = full['numero_cliente'];
          var $razon_social = full['razon_social'];
          return `
            <div>
              <span class="fw-bold">${$numero_cliente}</span><br>
              <small style="font-size:12px;" class="user-email">${$razon_social}</small>
            </div>
          `;
        }
      },
      //{ data: 'fecha_solicitud' },
      {
        data: function (row) {
          return row.tipo;
        }
      },
      { data: 'direccion_completa' },
      { data: 'fecha_visita' },
      {
        render: function (data, type, full, meta) {
          var $name = full['inspector'];
          var foto_inspector = full['foto_inspector'];

          // For Avatar badge

          var $output;
          if (foto_inspector != '') {
            $output =
              '<div class="avatar-wrapper"><div class="avatar avatar-sm me-3"> <div class="avatar "><img src="storage/' +
              foto_inspector +
              '" alt class="rounded-circle"></div></div></div>';
          } else {
            $output = '';
          }

          // Creates full output for row
          var $row_output =
            '<div class="d-flex justify-content-start align-items-center user-name">' +
            $output +
            '<div class="d-flex flex-column">' +
            '<a href="#" class="text-truncate text-heading"><span class="fw-medium">' +
            $name +
            '</span></a>' +
            '</div>' +
            '</div>';
          return $row_output;
        }
      },
      { data: 'fecha_servicio' },
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
      /*   {
         searchable: false,
         orderable: true,
         targets: 1,
         render: function (data, type, full, meta) {
           return `<span>${full.fake_id}</span>`;
         }
       },
            {

         targets: 11,
         className: 'text-center',
         render: function (data, type, full, meta) {

           if (full['id_inspeccion'] && full['razon_social'].trim() !== '') {
             return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="${full['id_inspeccion']}" data-registro="${full['razon_social']}"></i>`;
         } else {
             return '---';
         }
         }
       },*/

      {
        targets: 9,
        className: 'text-center',
        render: function (data, type, full, meta) {
          const acta = full['url_acta'];
          const dictamen = full['url_dictamen'];
          const razon = full['razon_social'];
          const cliente = full['numero_cliente'];

          let html = '';

          // ACTA
          if (acta && acta !== 'Sin subir') {
            html += `<i class="ri-file-pdf-2-fill text-danger ri-30px me-2 pdf cursor-pointer"
                        title="Ver Acta"
                        data-bs-target="#mostrarPdf"
                        data-bs-toggle="modal"
                        data-bs-dismiss="modal"
                        data-id="/files/${cliente}/actas/${acta}"
                        data-registro="${razon}">
                     </i>`;
          } else {
            html += '<span class="badge bg-danger me-1">Sin acta</span>';
          }

          // DICTAMEN
          if (dictamen && dictamen !== 'Sin subir') {
            html += `<i class="ri-file-pdf-2-fill text-primary ri-30px pdf cursor-pointer"
                        title="Ver Dictamen"
                        data-bs-target="#mostrarPdf"
                        data-bs-toggle="modal"
                        data-bs-dismiss="modal"
                        data-id="../${dictamen}"
                        data-registro="${razon}">
                     </i>`;
          } else {
            html += '<span class="badge bg-warning">Sin dictamen</span>';
          }

          return html;
        }
      },


      {
        // Acciones
        targets: -1,
        title: 'Acciones',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {


          return (
            '<div class="d-flex align-items-center gap-50">' +

            '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>' +
            '<div class="dropdown-menu dropdown-menu-end m-0">' +

            `<a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModalTrazabilidad(${full['id_solicitud']},'${full['tipo']}','${full['razon_social']}')" href="javascript:;" class="cursor-pointer dropdown-item validar-solicitud2"><i class="text-warning ri-user-search-fill"></i>Trazabilidad</a>` +
            // Botón de Validar Solicitud
            `<a
              data-id="${full['id']}"
              data-id-solicitud="${full['id_solicitud']}"
              data-tipo="${full['tipo']}"
              data-razon-social="${full['razon_social']}"
              data-bs-toggle="modal"
              data-bs-target="#addSolicitudValidar"
              class="dropdown-item text-dark waves-effect validar-solicitudes">
                <i class="text-success ri-search-eye-line"></i> Validar solicitud
            </a>` +

            `<a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModalAsignarInspector(${full['id_solicitud']},'${full['tipo']}','${full['razon_social']}')" href="javascript:;" class="cursor-pointer dropdown-item validar-solicitud2"><i class="text-warning ri-user-search-fill"></i>Asignar inspector</a>` +
            `<a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModalSubirResultados(${full['id_solicitud']},'${full['razon_social']}', '${full['folio_info']}','${full['inspectorName']}','${escapeHtml(full['num_servicio'])}')" href="javascript:;" class="dropdown-item"><i class="text-success ri-search-eye-line"></i>Resultados de inspección</a>` +
            `<a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModal(${full['id_solicitud']},'${full['id_inspeccion']}', '${full['tipo']}', '${full['razon_social']}', '${full['id_tipo']}','${full['folio_info']}', '${full['num_servicio_info']}','${full['inspectorName']}')" href="javascript:;" class="dropdown-item"><i class="text-info ri-folder-3-fill"></i>Expediente del servicio</a>` +

            //  `<a data-id="${full['id_inspeccion']}" data-bs-toggle="modal" onclick="abrirModalActaProduccion('${full['id_inspeccion']}','${full['tipo']}','${full['razon_social']}','${full['id_empresa']}','${full['direccion_completa']}','${full['tipo_instalacion']}')"href="javascript:;" class="dropdown-item "><i class="ri-file-pdf-2-fill ri-20px text-info"></i>Crear Acta</a>` +
            //  `<a data-id="${full['id_inspeccion']}" data-bs-toggle="modal" onclick="editModalActaProduccion('${full['id_acta']}')" href="javascript:;" class="dropdown-item "><i class="ri-file-pdf-2-fill ri-20px textStatus"></i>Editar Acta</a>` +


            '</div>' +
            '</div>'
          );
        }
      }
    ],
    order: [[2, 'desc']],
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
            title: 'Instalaciones',
            text: '<i class="ri-printer-line me-1"></i>Print',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, coldex, rowdex) {
                  if (inner.length <= 0) return inner;
                  var el = $.parseHTML(inner);
                  var result = '';
                  $.each(el, function (index, item) {
                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                      result += item.lastChild.firstChild.textContent;
                    } else if (item.innerText === undefined) {
                      result += item.textContent;
                    } else {
                      result += item.innerText;
                    }
                  });
                  return result;
                }
              }
            },
            customize: function (win) {
              // Customize print view for dark
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
            title: 'Instalaciones',
            text: '<i class="ri-file-text-line me-1"></i>CSV',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) { // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'excel',
            title: 'Instalaciones',
            text: '<i class="ri-file-excel-line me-1"></i>Excel',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) { // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'pdf',
            title: 'Instalaciones',
            text: '<i class="ri-file-pdf-line me-1"></i>PDF',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 1) { // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'copy',
            title: 'Instalaciones',
            text: '<i class="ri-file-copy-line me-1"></i>Copy',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) { // Asegúrate de que el índice de columna es el correcto para el ID
                    return inner.replace(/<[^>]*>/g, ''); // Elimina cualquier HTML del valor
                  }
                  return inner;
                }
              }
            }
          }
        ]
      },
      {
        text: '<i class="ri-file-excel-2-fill ri-16px me-0 me-md-2 align-baseline"></i><span class="d-none d-sm-inline-block">Exportar Excel</span>',
        className: 'btn btn-info waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4  mt-md-0',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#exportarExcel'
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

  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Eliminar registro
  $(document).on('click', '.delete-record', function () {
    var id_instalacion = $(this).data('id');

    // Confirmación con SweetAlert
    Swal.fire({
      title: '¿Está seguro?',
      text: "No podrá revertir este evento",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // Solicitud de eliminación
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}instalaciones/${id_instalacion}`, // Ajusta la URL aquí
          success: function () {
            dt_instalaciones_table.ajax.reload(null, false);

            // Mostrar mensaje de éxito
            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: '¡La solicitud ha sido eliminada correctamente!',
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
          text: 'La solicitud no ha sido eliminada',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  $(document).ready(function () {
    $('#reporteForm').on('submit', function (e) {
      e.preventDefault(); // Prevenir el envío tradicional del formulario
      const exportUrl = $(this).attr('action'); // Obtener la URL del formulario
      // Obtener los datos del formulario (filtros)
      const formData = $(this).serialize(); // serializa los datos del formulario en una cadena de consulta
      // Mostrar el SweetAlert de "Generando Reporte"
      Swal.fire({
        title: 'Generando Reporte...',
        text: 'Por favor espera mientras se genera el reporte.',
        icon: 'info',
        didOpen: () => {
          Swal.showLoading(); // Muestra el icono de carga
        },
        customClass: {
          confirmButton: false
        }
      });
      // Realizar la solicitud GET para descargar el archivo
      $.ajax({
        url: exportUrl,
        type: 'GET',
        data: formData,
        xhrFields: {
          responseType: 'blob' // Necesario para manejar la descarga de archivos
        },
        success: function (response) {
          // Crear un enlace para descargar el archivo
          const link = document.createElement('a');
          const url = window.URL.createObjectURL(response);
          link.href = url;
          link.download = 'reporte_solicitudes.xlsx';
          link.click();
          window.URL.revokeObjectURL(url);
          $('#exportarExcel').modal('hide');
          Swal.fire({
            title: '¡Éxito!',
            text: 'El reporte se generó exitosamente.',
            icon: 'success',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr, status, error) {
          console.error('Error al generar el reporte:', error);
          $('#exportarExcel').modal('hide');
          Swal.fire({
            title: '¡Error!',
            text: 'Ocurrió un error al generar el reporte.',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //funcion para exportar en excel
  $(document).ready(function () {
    $('#restablecerFiltros').on('click', function () {
      $('#reporteForm')[0].reset();
      $('.select2').val('').trigger('change');
      console.log('Filtros restablecidos.');
    });
  });

  $(document).ready(function () {
    $('#id_soli').on('change', function () {
      var selectedValues = $(this).val(); // Obtener los valores seleccionados

      if (selectedValues && selectedValues.includes('')) {
        // Si "Todas" es seleccionado
        $('#id_soli option').each(function () {
          if ($(this).val() !== '') {
            $(this).prop('selected', false); // Deseleccionar otras opciones
            $(this).prop('disabled', true); // Deshabilitar otras opciones
          }
        });
      } else {
        // Si seleccionas cualquier otra opción
        if (selectedValues && selectedValues.length > 0) {
          $('#id_soli option[value=""]').prop('disabled', true); // Deshabilitar "Todas"
        } else {
          // Si no hay opciones seleccionadas, habilitar todas
          $('#id_soli option').each(function () {
            $(this).prop('disabled', false); // Habilitar todas las opciones
          });
        }
      }
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
    const form = document.getElementById('addAsignarInspector');
    const fv = FormValidation.formValidation(form, {
      fields: {
        'num_servicio': {
          validators: {
            notEmpty: {
              message: 'Introduce el número de servicio.'
            }
          }
        },
        'fecha_servicio': {
          validators: {
            notEmpty: {
              message: 'Introduce la fecha del servicio.'
            }
          }
        },
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
      // Validar el formulario
      $('#btnAsignarInspec').addClass('d-none');
      $('#btnSpinnerAsigInspec').removeClass('d-none');
      var formData = new FormData(form);
      $.ajax({
        url: '/asignar-inspector',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#btnSpinnerAsigInspec').addClass('d-none');
          $('#btnAsignarInspec').removeClass('d-none');
          $('#asignarInspector').modal('hide');
          $('#addAsignarInspector')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-users').DataTable().ajax.reload(null, false);
          console.log(response);

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
          let mensaje = 'Ocurrió un error inesperado.';
          // Si Laravel devuelve errores de validación
          if (xhr.responseJSON?.errors) {
            const errores = xhr.responseJSON.errors;
            mensaje = Object.values(errores).flat().join('\n');
          }
          // Si es un mensaje directo desde el catch
          else if (xhr.responseJSON?.message) {
            mensaje = xhr.responseJSON.message;
          }

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: mensaje,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#btnSpinnerAsigInspec').addClass('d-none');
          $('#btnAsignarInspec').removeClass('d-none');
        }
      });
    });

    //Subir resultados de inspección

    $(function () {
      // Configuración CSRF para Laravel
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Inicializar FormValidation
      const form = document.getElementById('addResultadosInspeccion');
      const fv = FormValidation.formValidation(form, {
        fields: {
          'num_servicio': {
            validators: {
              notEmpty: {
                message: 'Introduce el número de servicio.'
              }
            }
          },
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
        $('#btnSubirInsp').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Subiendo...');
        // Validar el formulario
        var formData = new FormData(form);

        $.ajax({
          url: '/agregar-resultados',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            $('#resultadosInspeccion').modal('hide');
            $('#addResultadosInspeccion')[0].reset();
            $('.datatables-users').DataTable().ajax.reload(null, false);
            console.log(response);

            Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: response.message,
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
            $('#btnSubirInsp').prop('disabled', false).html('<i class="ri-upload-2-fill"></i> Subir');
          },
          error: function (xhr) {
            console.log('Error:', xhr.responseText);

            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al registrar los resultados de la inspección',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
            $('#btnSubirInsp').prop('disabled', false).html('<i class="ri-upload-2-fill"></i> Subir');
          }
        });
      });

    });

    // Mostrar u ocultar campos adicionales según el tipo de certificación
    $('#certificacion').on('change', function () {
      if ($(this).val() === 'otro_organismo') {
        $('#certificado-otros').removeClass('d-none');

        // Agregar la validación a los campos adicionales
        fv.addField('url[]', {
          validators: {
            notEmpty: {
              message: 'Debes subir un archivo de certificado.'
            },
            file: {
              extension: 'pdf,jpg,jpeg,png',
              type: 'application/pdf,image/jpeg,image/png',
              maxSize: 2097152, // 2 MB en bytes
              message: 'El archivo debe ser un PDF o una imagen (jpg, png) y no debe superar los 2 MB.'
            }
          }
        });

        fv.addField('folio', {
          validators: {
            notEmpty: {
              message: 'El folio o número del certificado es obligatorio.'
            }
          }
        });

        fv.addField('id_organismo', {
          validators: {
            notEmpty: {
              message: 'Selecciona un organismo de certificación.'
            }
          }
        });

        fv.addField('fecha_emision', {
          validators: {
            notEmpty: {
              message: 'La fecha de emisión es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha de emisión no es válida.'
            }
          }
        });

        fv.addField('fecha_vigencia', {
          validators: {
            notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha de vigencia no es válida.'
            }
          }
        });

      } else {
        $('#certificado-otros').addClass('d-none');

        // Quitar la validación de los campos adicionales
        fv.removeField('url[]');
        fv.removeField('folio');
        fv.removeField('id_organismo');
        fv.removeField('fecha_emision');
        fv.removeField('fecha_vigencia');
      }
    });
  });

  //new new
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('editInstalacionForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        'id_empresa': {
          validators: {
            notEmpty: {
              message: 'Selecciona una empresa.'
            }
          }
        },
        'tipo': {
          validators: {
            notEmpty: {
              message: 'Selecciona un tipo de instalación.'
            }
          }
        },
        'estado': {
          validators: {
            notEmpty: {
              message: 'Selecciona un estado.'
            }
          }
        },
        'direccion_completa': {
          validators: {
            notEmpty: {
              message: 'Ingrese la dirección completa.'
            }
          }
        },
        'certificacion': {
          validators: {
            notEmpty: {
              message: 'Selecciona el tipo de certificación.'
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
      // Validar el formulario
      var formData = new FormData(form);

      $.ajax({
        url: baseUrl + 'instalaciones/' + $('#editInstalacionForm').data('id'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-HTTP-Method-Override', 'PUT');
        },
        success: function (response) {
          dt_instalaciones_table.ajax.reload(null, false);
          $('#modalEditInstalacion').modal('hide');
          $('#editInstalacionForm')[0].reset();
          $('.select2').val(null).trigger('change');

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
          console.log('Error:', xhr.responseText);

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al actualizar la instalación',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Mostrar u ocultar campos adicionales según el tipo de certificación
    $('#edit_certificacion').on('change', function () {
      if ($(this).val() === 'otro_organismo') {
        $('#edit_certificado_otros').removeClass('d-none');

        // Agregar la validación a los campos adicionales
        fv.addField('url[]', {
          validators: {
            notEmpty: {
              message: 'Debes subir un archivo de certificado.'
            },
            file: {
              extension: 'pdf,jpg,jpeg,png',
              type: 'application/pdf,image/jpeg,image/png',
              maxSize: 2097152, // 2 MB en bytes
              message: 'El archivo debe ser un PDF o una imagen (jpg, png) y no debe superar los 2 MB.'
            }
          }
        });

        fv.addField('folio', {
          validators: {
            notEmpty: {
              message: 'El folio o número del certificado es obligatorio.'
            }
          }
        });

        fv.addField('id_organismo', {
          validators: {
            notEmpty: {
              message: 'Selecciona un organismo de certificación.'
            }
          }
        });

        fv.addField('fecha_emision', {
          validators: {
            notEmpty: {
              message: 'La fecha de emisión es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha de emisión no es válida.'
            }
          }
        });

        fv.addField('fecha_vigencia', {
          validators: {
            notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'La fecha de vigencia no es válida.'
            }
          }
        });

      } else {
        $('#edit_certificado_otros').addClass('d-none');

        // Quitar la validación de los campos adicionales
        fv.removeField('url[]');
        fv.removeField('folio');
        fv.removeField('id_organismo');
        fv.removeField('fecha_emision');
        fv.removeField('fecha_vigencia');
      }
    });
  });

  //new
  $(document).on('click', '.edit-record', function () {
    var id_instalacion = $(this).data('id');
    var url = baseUrl + 'domicilios/edit/' + id_instalacion;

    // Solicitud para obtener los datos de la instalación
    $.get(url, function (data) {
      if (data.success) {
        var instalacion = data.instalacion;

        // Asignar valores a los campos
        $('#edit_id_empresa').val(instalacion.id_empresa).trigger('change');
        $('#edit_tipo').val(instalacion.tipo).trigger('change');
        $('#edit_estado').val(instalacion.estado).trigger('change');
        $('#edit_direccion').val(instalacion.direccion_completa);

        // Verificar si hay valores en los campos adicionales
        var tieneCertificadoOtroOrganismo = instalacion.folio || instalacion.id_organismo ||
          (instalacion.fecha_emision && instalacion.fecha_emision !== 'N/A') ||
          (instalacion.fecha_vigencia && instalacion.fecha_vigencia !== 'N/A') ||
          data.archivo_url;

        if (tieneCertificadoOtroOrganismo) {
          $('#edit_certificacion').val('otro_organismo').trigger('change');
          $('#edit_certificado_otros').removeClass('d-none');

          $('#edit_folio').val(instalacion.folio || '');
          $('#edit_id_organismo').val(instalacion.id_organismo || '').trigger('change');
          $('#edit_fecha_emision').val(instalacion.fecha_emision !== 'N/A' ? instalacion.fecha_emision : '');
          $('#edit_fecha_vigencia').val(instalacion.fecha_vigencia !== 'N/A' ? instalacion.fecha_vigencia : '');

          // Mostrar URL del archivo debajo del campo de archivo
          var archivoUrl = data.archivo_url || '';
          var numCliente = data.numeroCliente;
          if (archivoUrl) {
            try {
              $('#archivo_url_display').html(`
                              <p>Archivo existente:</span> <a href="../files/${numCliente}/${archivoUrl}" target="_blank">${archivoUrl}</a></p>`);
            } catch (e) {
              $('#archivo_url_display').html('URL del archivo no válida.');
            }
          } else {
            $('#archivo_url_display').html('No hay archivo disponible.');
          }
        } else {
          $('#edit_certificacion').val('oc_cidam').trigger('change');
          $('#edit_certificado_otros').addClass('d-none');
          $('#archivo_url_display').html('No hay archivo disponible.');
        }

        // Mostrar el modal
        $('#modalEditInstalacion').modal('show');
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'No se pudo cargar los datos de la instalación',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    }).fail(function (jqXHR, textStatus, errorThrown) {
      console.error('Error en la solicitud:', textStatus, errorThrown);

      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error en la solicitud. Inténtalo de nuevo.',
        customClass: {
          confirmButton: 'btn btn-primary'
        }
      });
    });
  });

  // Limpiar los campos del formulario cuando el modal se oculta
  $('#modalEditInstalacion').on('hidden.bs.modal', function () {
    $('#edit_certificado_otros').addClass('d-none');
    $('#archivo_url_display').html('No hay archivo disponible.');

    // Limpiar campos individuales
    $('#edit_id_empresa').val('').trigger('change');
    $('#edit_tipo').val('').trigger('change');
    $('#edit_estado').val('').trigger('change');
    $('#edit_direccion').val('');
    $('#edit_certificacion').val('oc_cidam').trigger('change');
    $('#edit_folio').val('');
    $('#edit_id_organismo').val('').trigger('change');
    $('#edit_fecha_emision').val('');
    $('#edit_fecha_vigencia').val('');
  });


  // Manejar el cambio en el tipo de instalación
  $(document).on('change', '#edit_tipo', function () {
    var tipo = $(this).val();
    var hiddenIdDocumento = $('#edit_certificado_otros').find('input[name="id_documento[]"]');
    var hiddenNombreDocumento = $('#edit_certificado_otros').find('input[name="nombre_documento[]"]');
    var fileCertificado = $('#edit_certificado_otros').find('input[type="file"]');

    switch (tipo) {
      case 'productora':
        hiddenIdDocumento.val('127');
        hiddenNombreDocumento.val('Certificado de instalaciones');
        fileCertificado.attr('id', 'file-127');
        break;
      case 'envasadora':
        hiddenIdDocumento.val('128');
        hiddenNombreDocumento.val('Certificado de envasadora');
        fileCertificado.attr('id', 'file-128');
        break;
      case 'comercializadora':
        hiddenIdDocumento.val('129');
        hiddenNombreDocumento.val('Certificado de comercializadora');
        fileCertificado.attr('id', 'file-129');
        break;
      default:
        hiddenIdDocumento.val('');
        hiddenNombreDocumento.val('');
        fileCertificado.removeAttr('id');
        break;
    }
  });

  $(document).ready(function () {
    $('#modalEditInstalacion').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id_instalacion = button.data('id');
      var modal = $(this);

      modal.find('#editInstalacionForm').data('id', id_instalacion);
    });

    $('#editInstalacionForm').submit(function (e) {
      e.preventDefault();

      var id_instalacion = $(this).data('id');
      var form = $(this)[0];
      var formData = new FormData(form);

      $.ajax({
        url: baseUrl + 'instalaciones/' + id_instalacion,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
          xhr.setRequestHeader('X-HTTP-Method-Override', 'PUT');
        },
        success: function (response) {
          dt_instalaciones_table.ajax.reload(null, false);
          $('#modalEditInstalacion').modal('hide');

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
          console.error('Error en la solicitud AJAX:', xhr.responseJSON);

          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al actualizar los datos.',
            footer: `<pre>${JSON.stringify(xhr.responseJSON, null, 2)}</pre>`,
          });
        }
      });
    });
  });


  /*   $(document).on('click', '.pdf', function () {
      var url = $(this).data('url');
      var registro = $(this).data('registro');
          var iframe = $('#pdfViewer');
          iframe.attr('src', '../files/'+url);

          $("#titulo_modal").text("Certificado de instalaciones");
          $("#subtitulo_modal").text(registro);
    }); */
  $(document).on('click', '.pdf', function () {
    var id_inspeccion = $(this).data('id');
    var registro = $(this).data('registro');



    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', id_inspeccion);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', id_inspeccion).show();

    $("#titulo_modal").text("Acta de inspección");
    $("#subtitulo_modal").text(registro);

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });
  //Añadir row

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
              <button type="button" class="btn btn-danger remove-row"> <i
               class="ri-delete-bin-5-fill"></i> </button>
              </th>
              <td>
                  <input class="form-control form-control-sm" type="text" name="nombre_documento[]">
              </td>
              <td>
                  <input class="form-control form-control-sm" type="file" id="file69" data-id="70" name="url[]">
                  <input value="70" class="form-control" type="hidden" name="id_documento[]">
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

  function escapeHtml(html) {
    return html
      .replace(/&/g, '&amp;')  // Escapa el símbolo &
      .replace(/</g, '&lt;')   // Escapa el símbolo <
      .replace(/>/g, '&gt;')   // Escapa el símbolo >
      .replace(/"/g, '&quot;') // Escapa las comillas dobles
      .replace(/'/g, '&#039;'); // Escapa las comillas simples
  }




  //Agregar o eliminar tablas +
  $(document).ready(function () {
    // Cuando se haga clic en el botón .add-row
    $('.add-row').click(function () {
      var targetTable = $(this).data('target'); // Obtener la tabla objetivo

      // Verificar si es la tabla de "testigos" o "unidadProduccion"
      if (targetTable === '#testigoss') {
        var namePrefix = $(this).data('name-prefix'); // Obtener el nombre para rango_inicial
        var nameSuffix = $(this).data('name-suffix'); // Obtener el nombre para rango_final

        // Crear una nueva fila para la tabla "testigos"
        var newRow = `
              <tr>
                  <th>
                      <button type="button" class="btn btn-danger remove-row">
                          <i class="ri-delete-bin-5-fill"></i>
                      </button>
                  </th>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${namePrefix}" />
                  </td>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${nameSuffix}" />
                  </td>
              </tr>`;

        $(targetTable).append(newRow);
      } /* else if (targetTable === '#unidadProduccion') {
          // Obtener nombres para los diferentes campos de la tabla "unidadProduccion"
          var namePredio = $(this).data('name-prefix');
          var nameEspacio = $(this).data('name-espacio');
          var nameSuperficie = $(this).data('name-superficie');
          var nameMadurez = $(this).data('name-madurez');
          var namePlagas = $(this).data('name-plagas');
          var namePlantas = $(this).data('name-plantas');
          var nameCoordenadas = $(this).data('name-coordenadas');

          // Crear una nueva fila para la tabla "unidadProduccion"
          var newRow = `
              <tr>
                  <th>
                      <button type="button" class="btn btn-danger remove-row">
                          <i class="ri-delete-bin-5-fill"></i>
                      </button>
                  </th>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${namePredio}" />
                  </td>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${nameEspacio}" />
                  </td>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${nameSuperficie}" />
                  </td>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${nameMadurez}" />
                  </td>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${namePlagas}" />
                  </td>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${namePlantas}" />
                  </td>
                  <td>
                      <input type="text" class="form-control form-control-sm" name="${nameCoordenadas}" />
                  </td>
              </tr>`;

          $(targetTable).append(newRow);
      } */
    });

    // Función para eliminar una fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
    });
  });


  $(document).ready(function () {
    // Añadir fila a la tabla con id "unidadProduccion"
    $('.add-row-produccion').click(function () {
      // Seleccionamos el tbody de la tabla específica (en este caso, "unidadProduccion")
      var targetTable = $('#unidadProduccion');

      // Crear una nueva fila con el formato que necesitas
      var newRow = `
          <tr>
              <th>
                  <button type="button" class="btn btn-danger remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
              </th>
              <td>
                  <select class="form-control select2-nuevo plantacion" name="id_empresa[]">
                      <!-- Opciones -->
                  </select>
              </td>
              <td>
                  <input type="text" class="form-control form-control-sm" name="plagas[]">
              </td>
          </tr>`;

      // Agregar la nueva fila al tbody de la tabla objetivo
      $(targetTable).append(newRow);

      // Re-inicializar select2 en el nuevo select
      $(targetTable).find('.select2-nuevo').select2({
        dropdownParent: $('#ActaUnidades'), // Asegúrate de que este es el id correcto de tu modal
        width: '100%',
        dropdownCssClass: 'select2-dropdown'
      });

      // Asegurar que el z-index esté configurado correctamente para el dropdown de select2
      $('.select2-dropdown').css('z-index', 9999);

      // Copiar las opciones del primer select al nuevo select
      var options = $(targetTable).find('tr:first-child .plantacion').html();
      $(targetTable).find('tr:last-child .plantacion').html(options);

      var select2Elements = $('.select2-nuevo');
      initializeSelect2(select2Elements);
    });

    // Función para eliminar una fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
    });
  });





  /* PRODUCCION DE MEZCAL */

  $(document).ready(function () {
    var rowCount = $('#unidadMezcal tr').length; // Inicializar el contador de filas

    // Añadir fila a la tabla
    $('.add-rowMezcal').click(function () {
      var newRow = `
      <tr>
          <th>
              <button type="button" class="btn btn-danger remove-row">
                  <i class="ri-delete-bin-5-fill"></i>
              </button>
          </th>
          <td><select class="form-control select" name="respuesta[` + rowCount + `][0]">
<option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select" name="respuesta[` + rowCount + `][1]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select" name="respuesta[` + rowCount + `][2]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select" name="respuesta[` + rowCount + `][3]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select" name="respuesta[` + rowCount + `][4]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select" name="respuesta[` + rowCount + `][5]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select" name="respuesta[` + rowCount + `][6]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select" name="respuesta[` + rowCount + `][7]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
      </tr>`;

      $('#unidadMezcal').append(newRow);
      rowCount++; // Incrementa el contador de filas

      // Re-inicializar select2 en los nuevos selects
      $('#unidadMezcal').find('.select').select({
        dropdownParent: $('#ActaUnidades'),
        width: '100%',
        dropdownCssClass: 'select-dropdown'
      });

      var selectElements = $('.select');
      initializeSelect(selectElements);

    });

    // Eliminar fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
      rowCount--; // Disminuir el contador de filas
    });
  });






  $(document).ready(function () {
    // Añadir fila a la tabla con id "equipoMezcal"
    $('.add-row-equipoMezcal').click(function () {
      // Seleccionamos el tbody de la tabla específica (en este caso, "equipoMezcal")
      var targetTable = $('#equipoMezcal');

      // Crear una nueva fila con el formato que necesitas
      var newRow = `
          <tr>
              <th>
                  <button type="button" class="btn btn-danger remove-row">
                      <i class="ri-delete-bin-5-fill"></i>
                  </button>
              </th>
              <td>
                  <select class="form-control select2-nuevo2 equipo" name="equipo[]">
                  </select>
              </td>
              <td>
                  <input type="number" class="form-control form-control-sm" name="cantidad[]" />
              </td>
              <td>
                  <input type="text" class="form-control form-control-sm" name="capacidad[]" />
              </td>
              <td>
                  <input type="text" class="form-control form-control-sm" name="tipo_material[]" />
              </td>
          </tr>`;

      // Agregar la nueva fila al tbody de la tabla objetivo
      $(targetTable).append(newRow);

      // Re-inicializar select2 en el nuevo select
      $(targetTable).find('.select2-nuevo2').select2({
        dropdownParent: $('#ActaUnidades'), // Asegúrate de que este es el id correcto de tu modal
        width: '100%',
        dropdownCssClass: 'select2-dropdown'
      });

      // Asegurar que el z-index esté configurado correctamente para el dropdown de select2
      $('.select2-dropdown').css('z-index', 9999);

      // Copiar las opciones del primer select al nuevo select
      var options = $(targetTable).find('tr:first-child .equipo').html();
      $(targetTable).find('tr:last-child .equipo').html(options);

      var select2Elements = $('.select2-nuevo2');
      initializeSelect2(select2Elements);
    });


    // Función para eliminar una fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
    });
  });







  /* PRODUCCION ENVASADO */

  $(document).ready(function () {
    var rowCount = $('#unidadEnvasado tr').length; // Inicializar el contador de filas

    // Añadir fila a la tabla
    $('.add-rowEnvasado').click(function () {
      var newRow = `
      <tr>
          <th>
              <button type="button" class="btn btn-danger remove-row">
                  <i class="ri-delete-bin-5-fill"></i>
              </button>
          </th>
          <td><select class="form-control select-unidad" name="respuestas[` + rowCount + `][0]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-unidad" name="respuestas[` + rowCount + `][1]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-unidad" name="respuestas[` + rowCount + `][2]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-unidad" name="respuestas[` + rowCount + `][3]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-unidad" name="respuestas[` + rowCount + `][4]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-unidad" name="respuestas[` + rowCount + `][5]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-unidad" name="respuestas[` + rowCount + `][6]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
      </tr>`;

      $('#unidadEnvasado').append(newRow);
      rowCount++; // Incrementa el contador de filas

      // Re-inicializar select2 en los nuevos selects
      $('#unidadEnvasado').find('.select-unidad').select({
        dropdownParent: $('#ActaUnidades'),
        width: '100%',
        dropdownCssClass: 'select-dropdown'
      });

      var selectElements = $('.select-unidad');
      initializeSelect(selectElements);

    });

    // Eliminar fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
      rowCount--; // Disminuir el contador de filas
    });
  });



  /* EQUIPO ENVASADO */

  $(document).ready(function () {
    // Añadir fila a la tabla con id "equipoMezcal"
    $('.add-row-equipoEnvasado').click(function () {
      // Seleccionamos el tbody de la tabla específica (en este caso, "equipoMezcal")
      var targetTable = $('#equipoEnvasado');

      // Crear una nueva fila con el formato que necesitas
      var newRow = `
          <tr>
              <th>
                  <button type="button" class="btn btn-danger remove-row">
                      <i class="ri-delete-bin-5-fill"></i>
                  </button>
              </th>
              <td>
                  <select class="form-control select2-nuevo3 equipo2" name="equipo_envasado[]">
                  </select>
              </td>
              <td>
                  <input type="number" class="form-control form-control-sm" name="cantidad_envasado[]" />
              </td>
              <td>
                  <input type="text" class="form-control form-control-sm" name="capacidad_envasado[]" />
              </td>
              <td>
                  <input type="text" class="form-control form-control-sm" name="tipo_material_envasado[]" />
              </td>
          </tr>`;

      // Agregar la nueva fila al tbody de la tabla objetivo
      $(targetTable).append(newRow);

      // Re-inicializar select2 en el nuevo select
      $(targetTable).find('.select2-nuevo3').select2({
        dropdownParent: $('#ActaUnidades'), // Asegúrate de que este es el id correcto de tu modal
        width: '100%',
        dropdownCssClass: 'select2-dropdown'
      });

      // Asegurar que el z-index esté configurado correctamente para el dropdown de select2
      $('.select2-dropdown').css('z-index', 9999);

      // Copiar las opciones del primer select al nuevo select
      var options = $(targetTable).find('tr:first-child .equipo2').html();
      $(targetTable).find('tr:last-child .equipo2').html(options);

      var select2Elements = $('.select2-nuevo3');
      initializeSelect2(select2Elements);
    });


    // Función para eliminar una fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
    });
  });


  /* COMERCIALIZACION */
  $(document).ready(function () {
    var rowCount = $('#unidadComercializadora tr').length; // Inicializar el contador de filas

    // Añadir fila a la tabla
    $('.add-rowComercializadora').click(function () {
      var newRow = `
      <tr>
          <th>
              <button type="button" class="btn btn-danger remove-row">
                  <i class="ri-delete-bin-5-fill"></i>
              </button>
          </th>
          <td><select class="form-control select-comercio" name="respuestas_comercio[` + rowCount + `][0]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-comercio" name="respuestas_comercio[` + rowCount + `][1]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-comercio" name="respuestas_comercio[` + rowCount + `][2]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-comercio" name="respuestas_comercio[` + rowCount + `][3]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>
          <td><select class="form-control select-comercio" name="respuestas_comercio[` + rowCount + `][4]">
              <option value="" selected>Selecciona</option>
              <option value="C">C</option>
              <option value="NC">NC</option>
              <option value="NA">NA</option>
          </select></td>

      </tr>`;

      $('#unidadComercializadora').append(newRow);
      rowCount++; // Incrementa el contador de filas

      // Re-inicializar select2 en los nuevos selects
      $('#unidadComercializadora').find('.select-comercio').select({
        dropdownParent: $('#ActaUnidades'),
        width: '100%',
        dropdownCssClass: 'select-dropdown'
      });

      var selectElements = $('.select-comercio');
      initializeSelect(selectElements);

    });

    // Eliminar fila
    $(document).on('click', '.remove-row', function () {
      $(this).closest('tr').remove();
      rowCount--; // Disminuir el contador de filas
    });
  });



  /* // Añadir método para agregar acta
  $('#ActaUnidadesForm').on('submit', function (e) {
    e.preventDefault();

    var formData = $(this).serialize(); // Serializar los datos del formulario

    $.ajax({
      url: '/acta-unidades', // Asegúrate que esta URL sea la correcta en tus rutas
      type: 'POST',
      data: formData,
      success: function (response) {
        $('#ActaUnidades').modal('hide'); // Cerrar modal
        $('#ActaUnidadesForm')[0].reset(); // Limpiar formulario
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
      console.log('Error:', xhr.responseText);
        // Mostrar alerta de error
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al agregar la clase',
            customClass: {
                confirmButton: 'btn btn-danger'
            }
        });
    }
    });
  }); */



  // Añadir método para agregar acta con validación
  const actaUnidadesForm = document.getElementById('ActaUnidadesForm');

  // Validación del formulario
  const fv = FormValidation.formValidation(actaUnidadesForm, {
    fields: {
      // Asegúrate de ajustar los nombres de los campos según tu formulario
      num_acta: {
        validators: {
          notEmpty: {
            message: 'Por favor introduzca un número de actas'
          }
        }
      },
      categoria_acta: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese una marca'
          }
        }
      },
      testigos: {
        validators: {
          notEmpty: {
            message: 'Introduzca el nombre del testigo'
          }
        }
      },
      encargado: {
        validators: {
          notEmpty: {
            message: 'Por favor, ingrese el número de hologramas solicitado'
          }
        }
      },
      num_credencial_encargado: {
        validators: {
          notEmpty: {
            message: 'Por favor, ingrese la credencial vigente'
          }
        }
      },
      fecha_inicio: {
        validators: {
          notEmpty: {
            message: 'Elija una fecha de inicio'
          }
        }
      },
      fecha_fin: {
        validators: {
          notEmpty: {
            message: 'Elija una fecha de finalización'
          }
        }
      },
      no_conf_infraestructura: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese no conformidades identificadas en la inspección'
          }
        }
      },
      no_conf_equipo: {
        validators: {
          notEmpty: {
            message: 'Por favor ingrese no conformidades identificadas en la inspección'
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
  }).on('core.form.valid', function () {
    var formData = $(actaUnidadesForm).serialize(); // Serializar los datos del formulario

    $.ajax({
      url: '/acta-unidades', // Asegúrate de que esta URL sea correcta en tus rutas
      type: 'POST',
      data: formData,
      success: function (response) {
        $('#ActaUnidades').modal('hide'); // Cerrar modal
        $('#ActaUnidadesForm')[0].reset(); // Limpiar formulario

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
        console.log('Error:', xhr.responseText);

        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al agregar la acta',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Manejar el clic en los enlaces con clase "validar-solicitudes"
  $(document).on('click', '.validar-solicitudes', function () {
    // Leer los datos desde los atributos data-*
    var idTipo = $(this).data('id');
    var id_solicitud = $(this).data('id-solicitud');
    var tipoName = $(this).data('tipo');
    var razon_social = $(this).data('razon-social');
    $('#tipoSolicitud').text(tipoName);

    // Manejar la visibilidad de divs si aplica
    manejarVisibilidadDivs(idTipo);


    $.ajax({
      url: `/getDatosSolicitud/${id_solicitud}`,
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          $('#solicitud_id').val(id_solicitud);
          $('.domicilioFiscal').text(response.data.empresa.domicilio_fiscal);
          // Validar si `direccion_completa` no está vacío
          if (response.data.instalacion) {
            $('.domicilioInstalacion').html(response.data.instalacion.direccion_completa + " <b>Vigencia: </b>" + response.data.instalacion.fecha_vigencia);
          } else {
            // Si está vacío, usar `ubicacion_predio`
            $('.domicilioInstalacion').text(response.data?.predios?.ubicacion_predio);
            $('.nombrePredio').text(response.data?.predios?.nombre_predio);
            $('.preregistro').html(
              "<a target='_Blank' href='/pre-registro_predios/" +
              response.data?.predios?.id_predio +
              "'><i class='ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer'></i></a>"
            );
          }



          $('.razonSocial').text(response?.data?.empresa?.razon_social || 'No disponible');
          $('.fechaHora').text(response?.fecha_visita_formateada || 'No disponible');

          $('.nombreLote').text(response?.data?.lote_granel?.nombre_lote || 'No disponible');


          $('.guiasTraslado').text(response?.data?.caracteristicas?.guias || 'No disponible');

          // Validar categoría
          $('.categoria').text(
            response?.data?.lote_granel?.categoria?.categoria ||
            response?.data?.lote_envasado?.lotes_envasado_granel?.[0]?.lotes_granel?.[0]?.categoria?.categoria ||
            'No disponible'
          );

          // Validar clase
          $('.clase').text(
            response?.data?.lote_granel?.clase?.clase ||
            response?.data?.lote_envasado?.lotes_envasado_granel?.[0]?.lotes_granel?.[0]?.clase?.clase ||
            'No disponible'
          );

          $('.cont_alc').text(response?.data?.lote_granel?.cont_alc || 'No disponible');
          $('.fq').text(response?.data?.lote_granel?.folio_fq || 'No disponible');
          $('.certificadoGranel').text(response?.data?.lote_granel?.certificado_granel?.num_certificado ||
            response?.data?.lote_envasado?.lotes_envasado_granel?.[0]?.lotes_granel?.[0]?.certificado_granel?.num_certificado ||
            'No disponible');



          $('.tipos').text(response?.tipos_agave || 'No disponible');


          // Validar nombre del lote envasado
          $('.nombreLoteEnvasado').text(response?.data?.lote_envasado?.nombre || 'Nombre no disponible');

          var caracteristicas = JSON.parse(response.data?.caracteristicas);
          var tipos = {
            1: 'Análisis completo',
            2: 'Ajuste de grado alcohólico'
          };

          var texto = tipos[caracteristicas?.tipo_analisis] || 'No disponible';

          $('.tipoAnalisis').text(texto);
          $('.materialRecipiente').text(caracteristicas.material);
          $('.capacidadRecipiente').text(caracteristicas.capacidad);
          $('.numeroRecipiente').text(caracteristicas.num_recipientes);
          $('.tiempoMaduracion').text(caracteristicas.tiempo_dura);
          $('.tipoIngreso').text(caracteristicas.tipoIngreso);
          $('.volumenLiberado').text(caracteristicas.volumen_liberacion);
          $('.tipoLiberacion').text(caracteristicas.tipoLiberacion);
          $('.volumenActual').text(caracteristicas.id_vol_actual);
          $('.volumenTrasladado').text(caracteristicas.id_vol_traslado);
          $('.volumenSobrante').text(caracteristicas.id_vol_res);
          $('.volumenIngresado').text(caracteristicas.volumen_ingresado);
          $('.etiqueta').html('<a href="files/' + response.data.empresa.empresa_num_clientes[0].numero_cliente + '/' + response?.url_etiqueta + '" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>');
          $('.dictamenEnvasado').html('<a href="/dictamen_envasado/' + response?.data?.lote_envasado?.dictamen_envasado?.id_dictamen_envasado + '" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>');

          // Verificar si 'detalles' existe y es un arreglo
          if (caracteristicas.detalles && Array.isArray(caracteristicas.detalles)) {
            // Recorrer cada elemento de 'detalles'
            $('.cajasBotellas').text('');
            caracteristicas.detalles.forEach(function (detalle) {
              // Asumiendo que '.cajasBotellas' es un contenedor de varias cajas, agregamos el texto en cada una
              $('.cajasBotellas').append(
                detalle.cantidad_cajas + ' Cajas y ' + detalle.cantidad_botellas + ' Botellas<br>'
              );
            });
          } else {
            // Si 'detalles' no existe o no es un arreglo
            $('.cajasBotellas').text('No hay detalles disponibles.');
          }

          // Estructura de configuración para los documentos
          const documentConfig = [
            {
              ids: [45, 66, 113],
              targetClass: '.comprobantePosesion',
              noDocMessage: 'No hay comprobante de posesión',
              condition: (documento, response) => documento.id_relacion == response.data.id_instalacion
            },
            {
              ids: [34],
              targetClass: '.comprobantePosesion',
              noDocMessage: 'No hay contrato de arrendamiento',
              condition: (documento, response) => documento.id_relacion == response.data.id_predio
            },
            {
              ids: [43, 106, 112],
              targetClass: '.planoDistribucion',
              noDocMessage: 'No hay plan de distribución',
              condition: (documento, response) => documento.id_relacion == response.data.id_instalacion
            },
            {
              ids: [76],
              targetClass: '.csf',
              noDocMessage: 'No hay CSF',
              condition: (documento, response) => documento.id_empresa == response.data.id_empresa
            },
            {
              ids: [1],
              targetClass: '.actaConstitutiva',
              noDocMessage: 'No hay acta constitutiva',
              condition: (documento, response) => documento.id_empresa == response.data.id_empresa
            },
            {
              ids: [55],
              targetClass: '.proforma',
              noDocMessage: 'No hay factura proforma',
              condition: (documento, response) => documento.id_empresa == response.data.id_empresa
            },
            /*/  {
                ids: [128],
                targetClass: '.domicilioInstalacion',
                noDocMessage: 'No hay dictamen de instalaciones',
                condition: (documento, response) => documento.id_relacion == response.data.id_instalacion
              }*/
          ];

          // Variable para seguimiento de documentos encontrados
          const documentsFound = {};

          // Inicializamos cada grupo como no encontrado
          documentConfig.forEach(config => {
            documentsFound[config.targetClass] = false;
          });

          // Iterar sobre los documentos
          $.each(response.documentos, function (index, documento) {
            documentConfig.forEach(config => {
              if (
                config.ids.includes(documento.id_documento) &&
                config.condition(documento, response) // Usar la condición dinámica
              ) {
                const link = $('<a>', {
                  href: 'files/' + response.data.empresa.empresa_num_clientes[0].numero_cliente + '/' + documento.url,
                  target: '_blank'
                });

                link.html('<i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i>');
                if (documento.id_documento === 128) {
                  $(config.targetClass).append(link);
                } else {
                  $(config.targetClass).empty().append(link);
                }
                documentsFound[config.targetClass] = true;
              }
            });
          });

          // Mostrar mensajes para documentos no encontrados
          documentConfig.forEach(config => {
            if (!documentsFound[config.targetClass]) {
              $(config.targetClass).text(config.noDocMessage);
            }
          });
        } else {
          console.warn('No se encontró información para la solicitud.');
        }
      },
      error: function (xhr, status, error) {
        console.error('Error al obtener los datos:', error);
      }
    });


  });
  //end
});


