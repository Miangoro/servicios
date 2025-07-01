'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    select2Elements = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#addlostesEnvasado');

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'lotes-list'
      },
      columns: [
        { data: '' },
        { data: 'id_lote_envasado' },
        {
          data: null,
          searchable: true,
          orderable: false,
          render: function (data, type, row) {
            var id_empresa = '';
            var razon_social = '';

            if (row.id_empresa != 'N/A') {
              id_empresa =
                '<br><span class="fw-bold text-dark small">' + row.id_empresa + '</span>';
            }
            if (row.razon_social != 'N/A') {
              razon_social =
                '<br><span class="small">' +
                row.razon_social +
                '</span><span class="small"> </span>';
            }

            return (
              '<span class="fw-bold text-dark">' +
              row.id_empresa +
              '</span> <br><span class="small">' + row.razon_social + '</span>'

            );
          }
        },
        {
          data: null,
          searchable: true,
          orderable: false,
          render: function (data, type, row) {
            var id_lote_granel = '';
            var nombre = '';

            if (row.id_lote_granel != 'N/A') {
              id_lote_granel =
                '<br><span class="fw-bold text-dark small">Agranel:</span><span class="small"> ' +
                row.id_lote_granel +
                '</span>';
            }
            if (row.nombre != 'N/A') {
              nombre =
                '<br><span class="fw-bold text-dark small">Envasado:</span><span class="small"> ' +
                row.nombre +
                '</span>';
            }

            return (
              '<span class="fw-bold text-dark small">Agranel:</span> <span class="small"> ' +
              row.id_lote_granel +
              '</span><br><span class="fw-bold text-dark small">Envasado:</span><span class="small"> ' +
              row.nombre
            );
          }
        },
        { data: 'id_marca' },

        {
          data: null,
          searchable: true,
          orderable: false,
          render: function (data, type, row) {
            var cant_botellas = '';
            var cantt_botellas = '';

            if (row.cant_botellas != 'N/A') {
              cant_botellas =
                '<br><span class="fw-bold text-dark small">Cantidad de botellas:</span><span class="small"> ' +
                row.cant_botellas +
                '</span>';
            }
            if (row.cantt_botellas != 'N/A') {
              cantt_botellas =
                '<br><span class="fw-bold text-dark small">Cantidad de botellas restantes:</span><span class="small"> ' +
                row.cantt_botellas +
                '</span>';
            }

            return (
              '<span class="fw-bold text-dark small">Inicial:</span> <span class="small"> ' +
              row.cant_botellas +
              '</span><br><span class="fw-bold text-dark small">Restantes:</span><span class="small"> ' +
              row.cantt_botellas
            );
          }
        },

        {
          data: function (row, type, set) {
            return row.presentacion + ' ' + row.unidad;
          }
        },

        {
          data: null,
          searchable: true,
          orderable: false,
          render: function (data, type, row) {
            var volumen_total = '';
            var volumen_total = '';

            if (row.volumen_total != 'N/A') {
              volumen_total =
                '<br><span class="fw-bold text-dark small">Volumen inicial:</span><span class="small"> ' +
                row.volumen_total +
                ' </span>';
            }
            if (row.volumen_total != 'N/A') {
              volumen_total =
                '<br><span class="fw-bold text-dark small">Volumen restante:</span><span class="small"> ' +
                row.volumen_total +
                ' </span>';
            }

            return (
              '<span class="fw-bold text-dark small">Inicial:</span> <span class="small"> ' +
              row.volumen_total +
              ' Litros' +
              '</span><br><span class="fw-bold text-dark small">Restante:</span><span class="small"> ' +
              row.volumen_total +
              ' Litros'
            );
          }
        },
        {
          data: 'destino_lote',
          className: 'text-center',
          render: function (data, type, full, meta) {
            var destinoText = '';
            var colorClass = '';

            switch (data) {
              case 1:
                destinoText = 'Nacional';
                colorClass = 'info'; // Azul
                break;
              case 2:
                destinoText = 'Exportación';
                colorClass = 'success'; // Verde
                break;
              case 3:
                destinoText = 'Stock';
                colorClass = 'warning'; // Amarillo
                break;
              default:
                destinoText = 'Desconocido';
                colorClass = 'secondary'; // Gris
            }
            return `
              <span class="badge rounded-pill bg-label-${colorClass}">
                ${destinoText}
              </span>
            `;
          }
        }
        ,
        { data: 'lugar_envasado' },
        {
          data: null,
          searchable: true,
          orderable: false,
          render: function (data, type, row) {
            var inicial = '';
            var nuevo = '';

            if (row.inicial && row.inicial !== 'N/A') {
              inicial =
                '<br><span class="fw-bold text-dark small">SKU inicial:</span><span class="small"> ' +
                row.inicial +
                '</span>';
            }
            if (row.nuevo && row.nuevo !== 'N/A') {
              nuevo =
                '<br><span class="fw-bold text-dark small">SKU nuevo:</span><span class="small"> ' +
                row.nuevo +
                '</span>';
            }
            return inicial + nuevo;
          }
        },
        { data: 'estatus' }, //status
        { data: 'action' }
      ],
      columnDefs: [
        {
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
          //Tabla 1
          searchable: false,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
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
              `<a data-id="${full['id_lote_envasado']}" data-bs-toggle="modal" data-bs-target="#editLoteEnvasado" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i>Editar lotes envasado</a>` +
              `<a data-id="${full['id_lote_envasado']}" data-bs-toggle="modal" data-bs-target="#reclasificacion" href="javascript:;" class="dropdown-item edit-reclasificacion"><i class="ri-id-card-fill ri-20px text-success"></i> Reclasificación SKU</a>` +
              `<a data-id="${full['']}" data-bs-toggle="modal" data-bs-target="#" href="javascript:;" class="dropdown-item "><i class="ri-git-repository-line ri-20px text-warning"></i> Trazabilidad</a>` +
              `<a data-id="${full['id_lote_envasado']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar lotes envasados</a>` +
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
      // Opciones Exportar Documentos
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
                columns: [1, 2, 3],
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
                columns: [1, 2, 3],
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
                columns: [1, 2, 3],
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
                columns: [1, 2, 3],
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
              title: 'Categorías de Agave',
              text: '<i class="ri-file-copy-line me-1"></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3],
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
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Lote Envasado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#addlostesEnvasado'
          }
        }
      ],

      ///PAGINA RESPONSIVA
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



  // Registrar Lotes y validar
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    //Obtener graneles
    function obtenerGraneles() {
      var empresa = $("#id_empresa").val();
      if (!empresa) {
        return; // No hace la petición
      }
      $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function (response) {

          var contenido = "";
          for (let index = 0; index < response.lotes_granel.length; index++) {
            contenido = '<option value="' + response.lotes_granel[index].id_lote_granel + '">' +
              response.lotes_granel[index].nombre_lote + '</option>' + contenido;
          }
          if (response.lotes_granel.length == 0) {
            contenido = '<option value="">Sin lotes a granel registrados</option>';
          }
          $('.id_lote_granel').html(contenido);
          //fv.revalidateField('id_lote_granel');
          /* contenido marcas */
          var Macontenido = "";
          for (let index = 0; index < response.marcas.length; index++) {
            Macontenido = '<option value="' + response.marcas[index].id_marca + '">' + response
              .marcas[index].marca + '</option>' + Macontenido;
          }
          if (response.marcas.length == 0) {
            Macontenido = '<option value="">Sin marcas registradas</option>';
          }
          $('#id_marca').html(Macontenido);
          //fv.revalidateField('id_marca');
          /* contenido direcciones */
          var Direcontenido = "";
          for (let index = 0; index < response.instalaciones.length; index++) {
            // Verifica si la palabra 'Envasadora' está en la cadena
            if (response.instalaciones[index].tipo.includes('Envasadora')) {
              Direcontenido += '<option value="' + response.instalaciones[index].id_instalacion + '">' +
                response.instalaciones[index].direccion_completa + '</option>';
            }
          }
          if (Direcontenido === "") {
            Direcontenido = '<option value="">Sin instalaciones de envasado registrados</option>';
          }
          $('.id_instalacion').html(Direcontenido);
          //fv.revalidateField('lugar_envasado');


        },
        error: function () { }
      });
    }

    //Obtener marcas
    /*     function obtenerMarcas() {
          var empresa = $("#id_empresa").val();
          $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function (response) {





            },
            error: function () { }
          });
        }

        //Obtener direcciones
        function obtenerDirecciones() {
          var empresa = $("#id_empresa").val();
          $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function (response) {



            },
            error: function () { }
          });
        }
    */

    function cargarMarcas() {
      var id_empresa = $('#id_empresa').val();

      if (id_empresa) {
        $.ajax({
          url: '/marcas/' + id_empresa,
          method: 'GET',
          success: function (marcas) {
            var tbody = '';

            marcas.forEach(function (marca) {
              // Verifica que 'etiquetado' sea un objeto válido
              if (marca.etiquetado && typeof marca.etiquetado === 'object') {
                for (var i = 0; i < marca.etiquetado.sku.length; i++) {
                  tbody += '<tr>';
                  tbody += `<td>${(marca.direccion_nombre && marca.direccion_nombre[i]) || 'N/A'}</td>`;
                  tbody += `<td>${marca.etiquetado.sku[i] || 'N/A'}</td>`;
                  tbody += `<td>${marca.tipo_nombre[i] || 'N/A'}</td>`;
                  tbody += `<td>${marca.etiquetado.presentacion[i] || 'N/A'}</td>`;
                  tbody += `<td>${marca.clase_nombre[i] || 'N/A'}</td>`;
                  tbody += `<td>${marca.categoria_nombre[i] || 'N/A'}</td>`;
                  /*                          tbody += '<td>' + (marca.etiquetado.etiqueta || 'N/A') + '</td>';
                                              tbody += '<td>' + (marca.etiquetado.corrugado || 'N/A') + '</td>'; */

                  // Agregar documento de etiquetas si existe
                  var documentoEtiquetas = marca.documentos.find(function (doc) {
                    return doc.nombre_documento === "Etiquetas";
                  });

                  if (documentoEtiquetas) {
                    var rutaArchivo = '/files/' + marca.numero_cliente + '/' + documentoEtiquetas.url;
                    tbody += `<td><a href="${rutaArchivo}" target="_blank" class="btn btn-sm btn-primary"><i class="ri-file-pdf-2-fill"></i> Visualizar</a></td>`;
                  } else {
                    tbody += '<td>No disponible</td>';
                  }

                  tbody += '</tr>';
                }
              } else {
                tbody += '<tr><td colspan="9" class="text-center">Datos de etiquetado no disponibles.</td></tr>';
              }
            });

            // Si no hay filas, mostrar mensaje
            if (!tbody) {
              tbody = '<tr><td colspan="9" class="text-center">No hay datos disponibles.</td></tr>';
            }

            // Agregar las filas a la tabla
            $('#tabla_marcas tbody').html(tbody);
          },
          error: function (xhr) {
            console.error('Error al obtener marcas:', xhr);
            $('#tabla_marcas tbody').html('<tr><td colspan="9">Error al cargar los datos</td></tr>');
          }
        });
      } else {
        $('#tabla_marcas tbody').html('<tr><td colspan="9">Seleccione una empresa para ver los datos</td></tr>');
      }
    }


    $('#id_empresa').on('change', function () {
      obtenerGraneles();  // Cargar las marcas
      /*  obtenerMarcas();  */ // Cargar las direcciones
      cargarMarcas();  // Cargar las direcciones
      /* obtenerDirecciones();  */ // Cargar las direcciones
      //fv.revalidateField('id_empresa');  // Revalidar el campo de empresa
    });



  });




  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    const addNewLoteForm = document.getElementById('addNewLoteForm');
    const fv = FormValidation.formValidation(addNewLoteForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente'
            }
          }
        },
        nombre: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca el nombre del lote'
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
        /*   'volumen_parcial[]': {
             validators: {
               notEmpty: {
                 message: 'Por favor introduzca el volumen del lote'
               }
             }
           },*/
        /*         presentacion: {
                  validators: {
                    notEmpty: {
                      message: 'Por favor introduzca una cantidad'
                    },
                    between: {
                      min: 1,
                      max: Infinity,
                      message: 'El número debe ser superior a 0 y sin negativos'
                    },
                    regexp: {
                      // Expresión regular que asegura que el número no comience con 0 a menos que sea exactamente 0
                      regexp: /^(?!0)\d+$/,
                      message: 'El número no debe comenzar con 0'
                    }
                  }
                }, */
        destino_lote: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese un destino de lote'
            }
          }
        },
        /*         cant_botellas: {
                  validators: {
                    notEmpty: {
                      message: 'Por favor introduzca una cantidad'
                    },
                    between: {
                      min: 1,
                      max: Infinity,
                      message: 'El número debe ser superior a 0 y sin negativos'
                    },
                    regexp: {
                      // Expresión regular que asegura que el número no comience con 0 a menos que sea exactamente 0
                      regexp: /^(?!0)\d+$/,
                      message: 'El número no debe comenzar con 0'
                    }
                  }
                }, */

        lugar_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lugar de envasado'
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
      $('#bntAddEnvasado').addClass('d-none');
      $('#btnSpinner').removeClass('d-none');
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
          $('#btnSpinner').addClass('d-none');
          $('#bntAddEnvasado').removeClass('d-none');
          // Mostrar alerta de éxito
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
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: xhr.responseJSON.message,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#btnSpinner').addClass('d-none');
          $('#bntAddEnvasado').removeClass('d-none');
        }
      });
    });

    // Limpiar campos al cerrar el modal
    $('#addlostesEnvasado').on('hidden.bs.modal', function () {
      // Restablecer select de empresa
      $('.id_lote_granel').html('');
      $('#id_marca').html('');
      $('.id_instalacion').html('');
      $('#nombre').val('');
      $('#destino_lote').val('');
      $('#id_empresa').val('').trigger('change');
      $('#lugar_envasado').val('').trigger('change');
      $('#cant_botellas').val('');
      $('#presentacion').val('');
      $('#sku').val('');
      $('#cantidad_botellas').val('');
      $('#volumen_total').val('');
      $('#volumen_parcial').val('');

      // Restablecer la validación del formulario
      fv.resetForm(true);
    });


  });


  initializeSelect2(select2Elements);

  //Eliminar registro
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
        Swal.fire({
          icon: 'success',
          title: '¡Eliminado!',
          text: '¡El lote envasado ha sido eliminada correctamente!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'El lote envasado no ha sido eliminada',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  // Método para mostrar el modal de edición con los datos del lote envasado
  $(document).on('click', '.edit-record', function () {
    var id_lote_envasado = $(this).data('id');

    // Realizar la solicitud AJAX para obtener los datos del lote envasado
    $.get('/lotes-envasado/edit/' + id_lote_envasado, function (data) {
      // Rellenar el formulario con los datos obtenidos
      $('#edit_id_lote_envasado').val(data.id_lote_envasado);
      $('#edit_cliente').val(data.id_empresa).trigger('change');
      $('#edit_lote_granel').val(data.id_lote_granel).trigger('change');
      $('#edit_nombre').val(data.nombre);
      $('#edit_sku').val(data.inicial);
      $('#edit_destino_lote').val(data.destino_lote);
      $('#edit_cant_botellas').val(data.cant_botellas);
      $('#edit_presentacion').val(data.presentacion);
      $('#edit_unidad').val(data.unidad);
      $('#edit_volumen_total').val(data.volumen_total);
      $('#edit_Instalaciones').data('selected', data.lugar_envasado).trigger('change');
      $('#edit_marca').data('selected', data.id_marca).trigger('change');

      // Limpiar contenido previo de lotes de envasado de granel
      $('#edit_contenidoGraneles').empty();

      // Agregar las opciones y rellenar cada fila del lote
      data.lotes_envasado_granel.forEach(function (lote, index) {
        var newRow = `
        <tr>
          <th>
            <button type="button" class="btn btn-danger remove-row">
              <i class="ri-delete-bin-5-fill"></i>
            </button>
          </th>
          <td>
            <select class="form-control select2 edit_lote_granel" name="id_lote_granel[]" id="id_lote_granel${index}">
              <option value="${lote.id_lote_granel}" selected>${lote.nombre_lote}</option>
            </select>
          </td>
          <td>
            <input type="text" class="form-control form-control-sm" name="volumen_parcial[]" value="${lote.volumen_parcial}" />
          </td>
        </tr>
      `;
        $('#edit_contenidoGraneles').append(newRow);

        // Inicializar select2 para el select en la fila recién añadida
        $('#id_lote_granel' + index).select2({
          dropdownParent: $('#editLoteEnvasado')
        });
      });

      // Mostrar el modal de edición
      $('#editLoteEnvasado').modal('show');
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

  // Agregar nueva fila en la tabla de edición
  $(document).on('click', '.add-row-edit', function () {
    var newRow = `
    <tr>
      <th>
        <button type="button" class="btn btn-danger btn-sm remove-row">
          <i class="ri-delete-bin-5-fill"></i>
        </button>
      </th>
      <td>
        <select class="form-control select2 select2-edit edit_lote_granel" name="id_lote_granel[]">
          <!-- Opciones se copiarán del primer select existente -->
        </select>
      </td>
      <td>
        <input type="text" class="form-control form-control-sm" name="volumen_parcial[]" />
      </td>
    </tr>
  `;

    // Agregar la nueva fila al contenedor de filas
    $('#edit_contenidoGraneles').append(newRow);

    // Inicializar select2 para el nuevo select
    $('#edit_contenidoGraneles').find('.select2-edit').last().select2({
      dropdownParent: $('#editLoteEnvasado'),
      width: '100%',
    });

    // Copiar las opciones del primer select al nuevo select
    var options = $('#edit_contenidoGraneles tr:first-child .edit_lote_granel').html();
    $('#edit_contenidoGraneles tr:last-child .edit_lote_granel').html(options);
  });

  // Eliminar fila de la tabla
  $(document).on('click', '.remove-row', function () {
    $(this).closest('tr').remove();
  });

  //Añadir row
  $(document).ready(function () {
    $('.add-row').click(function () {
      // Verificar si se ha seleccionado un cliente
      if ($('#id_empresa').val() === '') {
        // Mostrar la alerta de SweetAlert2
        Swal.fire({
          icon: 'warning',
          title: 'Espere!',
          text: 'Por favor, selecciona un cliente primero.',
          customClass: {
            confirmButton: 'btn btn-danger'
          },
          buttonsStyling: false // Asegura que los estilos personalizados se apliquen
        });
        return;
      }

      // Obtener el valor de volumen_parcial calculado
      var volumenParcial = document.getElementById('volumen_parcial').value;

      // Si el valor de volumen_parcial no está vacío, añade una nueva fila
      var newRow = `
        <tr>
            <th>
                <button type="button" class="btn btn-danger btn-sm remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
            </th>
            <td>
                <select class="id_lote_granel form-control select2-nuevo id_lote_granel" name="id_lote_granel[]">
                </select>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm " name="volumen_parcial[]" value="${volumenParcial}">
            </td>
        </tr>`;
      $('#contenidoGraneles').append(newRow);

      // Re-inicializar select2 en la nueva fila
      $('#contenidoGraneles')
        .find('.select2-nuevo')
        .select2({
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



  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
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

        edit_lote_granel: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese un numero de pedido/SKU'
            }
          }
        },
        edit_nombre: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca el nombre del lote'
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
        /*       edit_cant_botellas: {
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
              }, */

        edit_unidad: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese una cantidad'
            }
          }
        },

        /*       edit_volumen_total: {
                validators: {
                  notEmpty: {
                    message: 'Por favor llene los campos de detino lote y cantidad de botellas'
                  }
                }
              } */
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
      $('#btnEditEnvasado').addClass('d-none');
      $('#btnSpinnerEdit').removeClass('d-none');
      var formData = new FormData(editLoteEnvasadoForm);
      $.ajax({
        url: '/lotes-envasado/update', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Agregar token CSRF
        },
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editLoteEnvasado').modal('hide');
          $('.datatables-users').DataTable().ajax.reload();
          $('#btnSpinnerEdit').addClass('d-none');
          $('#btnEditEnvasado').removeClass('d-none');
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
          $('#btnSpinnerEdit').addClass('d-none');
          $('#btnEditEnvasado').removeClass('d-none');
        }
      });
    });
  });


  $(document).on('click', '.edit-reclasificacion', function () {
    var id_lote_envasado = $(this).data('id');
    $('#reclasificacion').modal('show');
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
        text: 'Error al obtener los datos de la reclasificacion SKU',
        customClass: {
          confirmButton: 'btn btn-danger'
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
    // Validación del formulario reclasificacion
    const reclasificacionForm = document.getElementById('reclasificacionForm');
    const fv3 = FormValidation.formValidation(reclasificacionForm, {
      fields: {
        nuevo: {
          validators: {
            notEmpty: {
              message: 'Por ingrese un nuevo SKU'
            }
          }
        },
        cantt_botellas: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca una cantidad'
            },
            between: {
              min: 1,
              max: Infinity,
              message: 'El número debe ser superior a 0 y sin negativos'
            },
            regexp: {
              // Expresión regular que asegura que el número no comience con 0 a menos que sea exactamente 0
              regexp: /^(?!0)\d+$/,
              message: 'El número no debe comenzar con 0'
            }
          }
        },
        observaciones: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese observaciones'
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
            text: 'Error al registrar la reclasificacion SKU',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });


  $(document).on('shown.bs.modal', '#addlostesEnvasado', function () {
    $('#cantidad_botellas, #presentacion, #unidad').on('input change', function () {
      var cantidadBotellas = parseFloat($('#cantidad_botellas').val()) || 0;
      var presentacion = parseFloat($('#presentacion').val()) || 0;
      var unidad = $('#unidad').val();
      var volumenTotal;

      if (unidad === "L") {
        volumenTotal = cantidadBotellas * presentacion;
      } else if (unidad === "mL") {
        volumenTotal = (cantidadBotellas * presentacion) / 1000;
      } else if (unidad === "cL") {
        volumenTotal = (cantidadBotellas * presentacion) / 100;
      } else {
        volumenTotal = '';
      }

      $('#volumen_total').val(volumenTotal ? volumenTotal.toFixed(2) : '');
      $('input[name="volumen_parcial[]"]').val(volumenTotal ? volumenTotal.toFixed(2) : '');
    });
  });




});
