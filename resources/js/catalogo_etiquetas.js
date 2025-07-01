'use strict';
$(function () {

  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#addMarca');

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
        url: baseUrl + 'etiquetas-list'
      },
      columns: [
        { data: '' },
        { data: '' },//PAra cliente
        { data: 'sku' },
        { data: 'marca' },
        { data: '' },
        { data: 'alc_vol' },
        { data: 'categoria' },
        { data: 'clase' },
        { data: 'tipo' },
        { data: 'destinos' },
        { data: '' },
        { data: '' }
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
        {
          searchable: false,
          orderable: false,
          targets: 4,
          render: function (data, type, full, meta) {
            return `${full.presentacion} ${full.unidad}`;
          }
        },
        {
          // pdf
          targets: 10,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $id = full['id_empresa'];
            return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-url="${full['numero_cliente']}/${full['url_etiqueta']}" data-registro="${full['name']} "></i>`;
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
              `<a data-id="${full['id_etiqueta']}" data-bs-toggle="modal" data-bs-target="#etiquetas" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar etiqueta</a>` +
              `<a data-id="${full['id_etiqueta']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar etiqueta</a>` +
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
      lengthMenu: [10, 20, 50, 70, 100],
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
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-outline-secondary dropdown-toggle me-4 waves-effect waves-light',
          text: '<i class="ri-upload-2-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Exportar </span>',
          buttons: [
            {
              extend: 'print',
              title: 'Etiquetas',
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
              title: 'Etiquetas',
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
              title: 'Etiquetas',
              text: '<i class="ri-file-excel-line me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
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
              title: 'Etiquetas',
              text: '<i class="ri-file-pdf-line me-1"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar nueva etiqueta</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#etiquetas'
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
        dropdownParent: $this.parent()
      });
    });
  }



  $(function () {


    const addNewEtiqueta = document.getElementById('etiquetasForm');
    let fv = null; // Inicializamos la variable del validador afuera para reutilizar

    // Función para inicializar el validador

    fv = FormValidation.formValidation(addNewEtiqueta, {
      fields: {
        'id_destino[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un destino'
            }
          }
        },
        id_marca: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la marca'
            }
          }
        },
        presentacion: {
          validators: {
            notEmpty: {
              message: 'Por introduzca el cont. neto'
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
        alc_vol: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca el %Alc. Vol.'
            }
          }
        },
        id_categoria: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la categoría'
            }
          }
        },
        id_clase: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la clase'
            }
          }
        },
        'id_tipo[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de agave'
            }
          }
        },
        botellas_caja: {
          validators: {
            digits: {
              message: 'Solo se permiten números enteros'
            },
          },
        },
      },

      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: function (field, ele) {
            return '.mb-5';
          }
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus(),

      }
    }).on('core.form.valid', function (e) {
      var formData = new FormData(addNewEtiqueta);
      $.ajax({
        url: '/registrar-etiqueta',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#etiquetas').modal('hide');
          addNewEtiqueta.reset();
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
            text: 'Error al agregar la etiqueta',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });




  });


  initializeSelect2(select2Elements);

  // Eliminar Registro Marca
  $(document).on('click', '.delete-record', function () {
    var id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }
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
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}etiquetas-list/${id}`,
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
          text: '¡La etiqueta ha sido eliminada correctamente!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La marca no ha sido eliminada',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  //Editar etiquetas - Obtener datos para el modal de editar etiquetas
  $(document).ready(function () {
    function limpiarFormulario() {
      $('#etiquetasForm')[0].reset(); // Reinicia los inputs
      $('#etiquetasForm').find('select').val(null).trigger('change');
      $('#id_tipo').val(null).trigger('change');
      $('#doc_etiqueta').html('');
      $('#doc_corrugado').html('');
      $('#id_etiqueta').val('');
      $('#titleSubirEtiquetas').text('Subir etiquetas');
      $('#subirBtnEtiqueta').html('<i class="ri-add-line me-1"></i> Registrar');
      $('#id_marca').html('<option value="" disabled selected>Selecciona una marca</option>').val(null).trigger('change');
      $('#id_destino').html('').val(null).trigger('change');
    }

    $('#etiquetas').on('hidden.bs.modal', function () {
      limpiarFormulario();
    });
    $(document).on('click', '.edit-record', function () {
      $('#subirBtnEtiqueta').html('<i class="ri-pencil-fill me-1"></i> Editar');
      $('#titleSubirEtiquetas').text('Editar Etiqueta');
      var id_etiqueta = $(this).data('id');
      $("#modo_formulario").val("editar");
      $.get('/edit-etiqueta/' + id_etiqueta, function (data) {

        var datos = data.etiqueta;
        var documentacion_urls = data.documentacion_urls;
        var documentacion_urls_corrugado = data.documentacion_urls_corrugado;
        var numCliente = data.numeroCliente;
        var tipos = JSON.parse(data.etiqueta.id_tipo);
        let valores = datos.destinos.map(d => d.id_direccion);
        // Rellenar el formulario con los datos obtenidos
        $('#id_empresa').val(datos.id_empresa).trigger('change');
        obtenerdestinos(datos.id_empresa, valores, datos.id_marca);

        $('#id_etiqueta').val(datos.id_etiqueta);



        /* $('#id_destino').val(valores).trigger('change'); */

        $('#sku').val(datos.sku);
        $('#presentacion').val(datos.presentacion);
        $('#alc_vol').val(datos.alc_vol);
        $('#unidad').val(datos.unidad).trigger('change');

        /* $('#id_marca').val(datos.id_marca).trigger('change'); */
        $('#id_categoria').val(datos.id_categoria).trigger('change');
        $('#id_clase').val(datos.id_clase).trigger('change');
        //$('#id_tipo').val(datos.etiqueta.id_tipo).trigger('change');
        $('#id_tipo').val(tipos).trigger('change');
        $('#botellas_caja').val(datos.botellas_caja);

        $('#doc_etiqueta').html(`<div style="display: flex; align-items: center; gap: 8px;">
        <a href="/files/${numCliente}/${documentacion_urls[0].url}" target="_blank">
            <i class="ri-file-pdf-2-line ri-20px" aria-hidden="true"></i>
         </a>
        </div>`
        );
        if (documentacion_urls_corrugado.length > 0 && documentacion_urls_corrugado[0].url) {
          $('#doc_corrugado').html(`
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <a href="/files/${numCliente}/${documentacion_urls_corrugado[0].url}" target="_blank">
                            <i class="ri-file-pdf-2-line ri-20px" aria-hidden="true"></i>
                        </a>
                    </div>
                `);
        }
      });
    });
  });




});



/*
$('#id_empresa').on('change', function () {
  const empresaId = $(this).val();
  if (empresaId) {
    cargarDestinosPorEmpresa(empresaId);
  }
});
 */

$(document).on('click', '.pdf', function () {


  // Verificar si el tipo es igual a 3

  var url = $(this).data("url");  // URL de la ruta

  $('#NewPestana').attr('href', "/files/" + url);

  var iframe = $('#pdfViewer');
  var spinner = $('#cargando');  // Spinner
  spinner.show();
  iframe.hide();

  // Asegurarse de que la URL esté bien formada
  iframe.attr('src', "/files/" + url);    // Concatenar la URL con el ID de la solicitud

  // Configurar el botón para abrir el PDF en una nueva pestaña
  $('#pdfViewer')
    .attr('href', "/files/" + url)
    .show();

  // Mostrar el modal
  $('#mostrarPdf').modal('show');

  // Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
  iframe.on('load', function () {
    console.log('PDF cargado en el iframe.');
    spinner.hide();
    iframe.show();
  });

});
