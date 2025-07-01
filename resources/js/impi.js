/* Page User List */
'use strict';

 $(document).ready(function () {
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    language: 'es' // Configura el idioma a español
  });
});

 // Datatable (jquery)
 $(function () {
 
   // Variable declaration for table
   var dt_user_table = $('.datatables-users'),
     select2 = $('.select2'),
     userView = baseUrl + 'app/user/view/account',
     offCanvasForm = $('#offcanvasAddUser');
 

var select2Elements = $('.select2');
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


// ajax setup
  $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
  });
 
 
   //FUNCIONALIDAD DE LA VISTA datatable
   if (dt_user_table.length) {
     var dt_user = dt_user_table.DataTable({
       processing: true,
       serverSide: true,
       ajax: {
         url: baseUrl + 'tramite-list'
       },
       columns: [
         // columns according to JSON
         { data: '' },
         { data: 'folio' },
         { data: 'fecha_solicitud' },
         { data: 'razon_social' },
         { data: 'tramite' },
         { data: 'contrasena' },
         { data: 'pago' },
         { data: 'contacto' },
         { data: 'observaciones' },
         { data: 'estatus' },
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
          // Tabla 3 (empresa y folio)
          targets: 3,
          responsivePriority: 1,
          render: function (data, type, full, meta) {
            var $razon_social = full['razon_social'] ?? 'N/A';
            return '<span class="user-email">' + $razon_social + '</span>';
          }
        },
        {
          // Tabla 4 (tramite)
          targets: 4,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
           var $tramite = full['tramite'];

           if ($tramite == 1){
             return '<span style="color:red;">Registro de marca</span>';
           }
           else if($tramite == 2){ 
                 return '<span style="color:red;">Trámite USO DE LA DOM</span>';
           }
           else if($tramite == 3){ 
             return '<span style="color:red;">Inscripción de convenio de correponsabilidad</span>';
           }
           else if($tramite == 4){ 
             return '<span style="color:red;">Licenciamiento de la marca</span>';
           }
           else if($tramite == 5){ 
            return '<span style="color:red;">Cesión de derechos de marca</span>';
          }
          else if($tramite == 6){ 
            return '<span style="color:red;">Declaración de uso de marca</span>';
          }
          }
        },
         {
           // Tabla 9 (estatus)
           targets: 9,
           responsivePriority: 4,
           render: function (data, type, full, meta) {
            var $name = full['estatus'];

            if ($name == 1){
              return '<span class="badge rounded-pill bg-dark">Pendiente</span>';
            }
            else if($name == 2){ 
                  return '<span class="badge rounded-pill bg-warning">Tramite</span>';
            }
            else if($name == 3){ 
              return '<span class="badge rounded-pill bg-primary">Tramite favorable</span>';
            }
            else if($name == 4){ 
              return '<span class="badge rounded-pill bg-danger">Tramite no favorable</span>';
            }
           }
         },
          {
           // Tabla 7 telefono y correo
           targets: 7,
           render: function (data, type, full, meta) {
             var $contacto = full['contacto'];
             /*return '<span class="fw-bold">Telefono:</span> <br>'+
              '<span class="fw-bold">Correo:</span>';*/
              return '<span class="user-email">' + $contacto + '</span>';
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

                   `<a data-id="${full['id_impi']}" data-bs-toggle="modal" data-bs-target="#editDictamen" href="javascript:;" class="dropdown-item edit-record"><i class="ri-edit-box-line ri-20px text-info"></i> Editar </a>` +
                   `<a data-id="${full['id_impi']}" data-bs-toggle="modal" data-bs-target="#addEvento" href="javascript:;" class="dropdown-item add-event"><i class="ri-add-box-line  ri-25px"></i> Agregar evento </a> ` +
                   `<a data-id="${full['id_impi']}" class="dropdown-item delete-record  waves-effect text-danger"><i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar </a>` +
                  
                 '<div class="dropdown-menu dropdown-menu-end m-0">' +
                 '<a href="' + userView + '" class="dropdown-item">View</a>' +
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
                 "sFirst":    "Primero",
                 "sLast":     "Último",
                 "sNext":     "Siguiente",
                 "sPrevious": "Anterior"
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
           text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Trámite</span>',
           className: 'add-new btn btn-primary waves-effect waves-light',
           attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#addDictamen'
           }
         }
       ],
 
 ///PAGINA RESPONSIVA
       responsive: {
         details: {
           display: $.fn.dataTable.Responsive.display.modal({
             header: function (row) {
               var data = row.data();
               return 'Detalles de ' + data['id_impi'];
               //return 'Detalles del ' + 'Dictamen';
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
 
 
const fv = FormValidation.formValidation(NuevoDictamen, {
    fields: {
//valida por name
      fecha_solicitud: {
            validators: {
                notEmpty: {
                    message: 'Seleccione una fecha'
                }
            }
        },
        tramite: {
          validators: {
              notEmpty: {
                  message: 'Seleccione el trámite'
              }
          }
      },
      id_empresa: {
            validators: {
                notEmpty: {
                    message: 'Seleccione el cliente'
                }
            }
        },
        contrasena: {
            validators: {
                notEmpty: {
                    message: 'Introduzca una contraseña'
                }
            }
        },
        pago: {
            validators: {
                notEmpty: {
                    message: 'Introduzca el pago'
                }
            }
        },
        estatus: {
          validators: {
              notEmpty: {
                  message: 'Seleccione un estatus'
              }
          }
        },
        /*'categorias[]': {
            validators: {
                notEmpty: {
                    message: 'Seleccione una categoría de agave'
                }
            }
        },*/
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

  var formData = new FormData(NuevoDictamen);
    $.ajax({
        url: 'registrar',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log('Funcionando', response);
            $('#addDictamen').modal('hide');//div que encierra al formulario #addDictamen
            $('#NuevoDictamen')[0].reset();
  
            dt_user.ajax.reload();
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
          console.log('Error por error:', xhr);
            // Mostrar alerta de error
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '¡Error al subir!',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }
    });
  });



///ELIMINAR REGISTRO
  $(document).on('click', '.delete-record', function () {
    var id_dictamen = $(this).data('id'); // Obtener el ID del registro
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
                url: `${baseUrl}eliminar/${id_dictamen}`,
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
                        text: '¡El registro ha sido eliminado correctamente!',
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
                        title: '¡Error!',
                        text: 'No se pudo eliminar el registro. Inténtelo más tarde.',
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
                text: 'La eliminación ha sido cancelada',
                icon: 'info',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        }
    });
});



// FUNCION PARA EDITAR un registro
$(document).ready(function() {
  // Abrir el modal y cargar datos para editar
  $('.datatables-users').on('click', '.edit-record', function() {
      var id_dictamen = $(this).data('id');

      // Realizar la solicitud AJAX para obtener los datos de la clase
      $.get('/insta2/' + id_dictamen + '/edit', function(data) {
        
          // Rellenar el formulario con los datos obtenidos
          $('#edit_id_impi').val(data.id_impi);
          $('#edit_tramite').val(data.tramite).prop('selected', true).change();
          $('#edit_fecha_solicitud').val(data.fecha_solicitud);
          $('#edit_cliente').val(data.id_empresa).prop('selected', true).change();
          $('#edit_contrasena').val(data.contrasena);
          $('#edit_pago').val(data.pago);
          $('#edit_estatus').val(data.estatus).prop('selected', true).change();
          $('#edit_observaciones').val(data.observaciones);
          //$('#edit_categorias').val(data.categorias).trigger('change');
          

          // Mostrar el modal de edición
          $('#editDictamen').modal('show');
      }).fail(function() {
          Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al obtener los datos',
              customClass: {
                  confirmButton: 'btn btn-danger'
              }
          });
      });
  });

  // Manejar el envío del formulario de edición
  $('#EditarDictamen').on('submit', function(e) {
      e.preventDefault();

      var formData = $(this).serialize();
      var id_dictamen = $('#edit_id_impi').val(); // Obtener el ID de la clase desde el campo oculto

      $.ajax({
          url: '/insta2/' + id_dictamen,
          type: 'PUT',
          data: formData,
          success: function(response) {
              $('#editDictamen').modal('hide'); // Ocultar el modal de edición "DIV"
              $('#EditarDictamen')[0].reset(); // Limpiar el formulario "FORM"
              // Mostrar alerta de éxito
              Swal.fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: response.success,
                  customClass: {
                      confirmButton: 'btn btn-success'
                  }
              });
              // Recargar los datos en la tabla sin reinicializar DataTables
              $('.datatables-users').DataTable().ajax.reload();
          },
          error: function(xhr) {
            console.log('Error:', xhr.responseText);
              // Mostrar alerta de error
              Swal.fire({
                  icon: 'error',
                  title: '¡Error!',
                  text: 'Error al actualizar',
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
          }
      });
  });
});




///REGISTRAR EVENTO
const fv2 = FormValidation.formValidation(NuevoEvento, { //FORMULARIO ID
  fields: {
//valida por name
/*    fecha_solicitud: {
          validators: {
              notEmpty: {
                  message: 'Seleccione una fecha'
              }
          }
      },
      tramite: {
        validators: {
            notEmpty: {
                message: 'Seleccione el trámite'
            }
        }
    },
    id_empresa: {
          validators: {
              notEmpty: {
                  message: 'Seleccione el cliente'
              }
          }
      },
      contrasena: {
          validators: {
              notEmpty: {
                  message: 'Introduzca una contraseña'
              }
          }
      },
      pago: {
          validators: {
              notEmpty: {
                  message: 'Introduzca el pago'
              }
          }
      },
      estatus: {
        validators: {
            notEmpty: {
                message: 'Seleccione un estatus'
            }
        }
      },*/
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

var formData = new FormData(NuevoEvento);
  $.ajax({
      url: 'crearEvento',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log('Funcionando2 :D', response);
          $('#addEvento').modal('hide');//modal que encierra al formulario #addEvento
          $('#NuevoEvento')[0].reset();

          dt_user.ajax.reload();
          // Mostrar alerta de éxito
          Swal.fire({
              icon: 'success',
              title: '¡Éxito22!',
              text: response.success,
              customClass: {
                  confirmButton: 'btn btn-success'
              }
          });
      },
      error: function (xhr) {
        console.log('Error por error:', xhr.responseText);
          // Mostrar alerta de error
          Swal.fire({
              icon: 'error',
              title: '¡Error22!',
              text: '¡Error al subir22!',
              customClass: {
                  confirmButton: 'btn btn-danger'
              }
          });
      }
  });
});






});//fin dataquery