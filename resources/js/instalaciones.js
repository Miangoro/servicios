
///flatpickr
$(document).ready(function () {
  flatpickr(".flatpickr-datetime", {
      dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
      enableTime: false,   // Desactiva la  hora
      allowInput: true,    // Permite al usuario escribir la fecha manualmente
      locale: "es",        // idioma a español
  });
});

//FUNCION FECHAS
$('#fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  var fechaVigencia = fechaInicial.toISOString().split('T')[0]; 
  $('#fecha_vigencia').val(fechaVigencia);
  flatpickr("#fecha_vigencia", {
      dateFormat: "Y-m-d",
      enableTime: false,  
      allowInput: true,  
      locale: "es",     
      static: true,      
      disable: true          
  });
});
//FUNCION FECHAS EDIT
$('#edit_fecha_emision').on('change', function() {
  var fechaInicial = new Date($(this).val());
  fechaInicial.setFullYear(fechaInicial.getFullYear() + 1);
  var fechaVigencia = fechaInicial.toISOString().split('T')[0]; 
  $('#edit_fecha_vigencia').val(fechaVigencia);
  flatpickr("#edit_fecha_vigencia", {
      dateFormat: "Y-m-d",  
      enableTime: false,   
      allowInput: true,  
      locale: "es",  
      static: true,   
      disable: true  
  });
});



$(function () {
  var dt_user_table = $('.datatables-users'),
  select2Elements = $('.select2'),
  userView = baseUrl + 'app/user/view/account'

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



  var baseUrl = window.location.origin + '/';
  var dt_instalaciones_table = $('.datatables-users').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'instalaciones-list',
      type: 'GET',
      dataSrc: function (json) {
        console.log(json); 
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
      { data: '#' },                 //0
      { data: 'id_instalacion' },    //1
      { data: 'razon_social' },      //2
      { data: 'tipo' },              //3
      { data: 'responsable' },       //4
      { data: 'estado' },            //5
      { data: 'direccion_completa' },//6
      { data: 'folio' },             //7
     // { data: 'organismo' },         //8
      { data: 'PDF' },               //9
     // { data: 'fechas' },            //10
      { data: 'actions' }            //12
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
        searchable: false,
        orderable: true,
        targets: 1,
        render: function (data, type, full, meta) {
          return `<span>${full.fake_id}</span>`;
        }
      },
      {
        targets: 2,
        responsivePriority: 1,
        render: function (data, type, full, meta) {
          var $razon_social = full['razon_social'] ?? 'N/A';
          return '<span class="user-email">' + $razon_social + '</span>';
        }
      },
      {
        targets: 3,
        responsivePriority: 3,
        render: function (data, type, full, meta) {
            var tipos = []; 
            try {
                if (full['tipo']) {
                    tipos = JSON.parse(full['tipo']); 
                }
            } catch (e) {
                tipos = full['tipo'] ? full['tipo'].split(',') : [];
            }
    
            const tipoConfig = {
                'Productora': { color: 'primary', nombre: 'Productora' },                // Azul
                'Envasadora': { color: 'dark', nombre: 'Envasadora' },                // Verde
                'Comercializadora': { color: 'info', nombre: 'Comercializadora' },       // Celeste
                'Almacen y bodega': { color: 'danger', nombre: 'Almacén y bodega' },     // Rojo
                'Area de maduracion': { color: 'warning', nombre: 'Área de maduración' } // Amarillo
            };
    
            var badges = ''; 
            tipos.forEach(function(tipo) {
                tipo = tipo.trim();
                const config = tipoConfig[tipo] || { color: 'secondary', nombre: 'Desconocido' }; 
                badges += `<span  style="font-size:11px" class="small badge bg-${config.color}">${config.nombre}</span><br>`;
            });
    
            return badges || '<span class="badge  bg-secondary">N/A</span>';
        }
    },        
      {
        targets: 4,
        render: function (data, type, full, meta) {
          var $responsable = full['responsable'] ?? 'N/A';
          return '<span class="user-email">' + $responsable + '</span>';
        }
      },
      {
        targets: 5,
        render: function (data, type, full, meta) {
          var $estado = full['estado'] ?? 'N/A';
          return '<span class="user-email">' + $estado + '</span>';
        }
      },
      {
        targets: 6,
        render: function (data, type, full, meta) {
          var $direccion_completa = full['direccion_completa'] ?? 'N/A';
          return '<span class="user-email">' + $direccion_completa + '</span>';
        }
      },
      {
        targets: 7,
        render: function (data, type, full, meta) {
          //var $folio = full['folio'] ?? 'N/A';
          //return '<span class="user-email">' + $folio + '</span>';
          
/* if (folio !== 'N/A') {//si hay folio
    certificado=   `<u><a href="${$numeroCliente}/certificados_instalaciones/${url}" target="_blank"> </a></u>` ;
  (relacionCertificado ?//si hay folio del certificado subido
        certificado= `<u><a href="${$numeroCliente}/certificados_instalaciones/${url}" target="_blank" class="text-decoration-underline waves-effect text-primary"> </a></u>`
      :  certificado= folio) +//solo folio
} else {
  certificado=  `<span class="badge rounded-pill bg-danger">Sin certificado</span>`;

}

return `<span><b>Certificadora: </b>${full['certificadora']} <br>
        <b>Número de certificado: </b>${certificado} <br>
          <b>Fecha de emisión: </b>${full['fecha_emision']} <br>
          <b>Fecha de vigencia: </b>${full['fecha_vigencia']} <br>
  </span>`; */
const folio = full['folio'];
const documentos = Array.isArray(full['documentos']) ? full['documentos'] : [];

let certificado = '';

if (!folio) {
    certificado = `<span class="badge rounded-pill bg-danger">Sin certificado</span>`;
} else if (documentos.length > 0) {
    certificado = documentos
        .filter(doc => doc.url && doc.nombre)
        .map(doc => `<a href="${doc.url}" target="_blank" class="text-primary text-decoration-underline fw-bold">${doc.nombre}</a>`)
        .join(', ');
} else {
    certificado = `${folio}`;
}

return `<span class="small">
    <b>Certificadora: </b>${full['certificadora']} <br>
    <b>Certificado: </b>${certificado} <br>
    <b>Fecha de emisión: </b>${full['fecha_emision'] ?? 'N/A'} <br>
    <b>Fecha de vigencia: </b>${full['fecha_vigencia'] ?? 'N/A'} <br>
</span>`;


        }
      },
    /*  {
        targets: 8,
        render: function (data, type, full, meta) {
          var $organismo = full['organismo'] ?? 'N/A';
          return '<span class="user-email">' + $organismo + '</span>';
        }
      },*/
      {
        targets: 8,
        className: 'text-center',
        render: function (data, type, full, meta) {
            if (full['url'] && full['url'].trim() !== '') {
                return `<button class="verDocumentosBtn" data-urls="${full['url']}" data-nombres="${full['nombre_documento']}" data-id="${full['id_instalacion']}" data-bs-toggle="modal" data-bs-target="#modalVerDocumento" data-bs-dismiss="modal" style="border: none; background: transparent;">
                            <i class="ri-folder-6-fill" style="color: #F9BB36; font-size: 2.5rem;"></i>
                        </button>`;
            } else {
                return '---';
            }
        }
      },     
   /*   {
        targets: 10, // Suponiendo que este es el índice de la columna que quieres actualizar
        render: function (data, type, full, meta) {
            var $fecha_emision = full['fecha_emision'] ?? 'N/A'; // Obtener la fecha de emisión
            var $fecha_vigencia = full['fecha_vigencia'] ?? 'N/A'; // Obtener la fecha de vigencia
    
            // Definir los mensajes de fecha con formato
            var fechaEmisionMessage = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Emisión:</strong> ${$fecha_emision}</span>`;
            var fechaVigenciaMessage = `<span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Vigencia:</strong> ${$fecha_vigencia}</span>`;
    
            // Retorna las fechas en formato de columnas
            return `
                <div style="display: flex; flex-direction: column;">
                    <div style="display: inline;">${fechaEmisionMessage}</div>
                    <div style="display: inline;">${fechaVigenciaMessage}</div>
                </div>
            `;
        }
      },   */ 
      {
        // Actions
        targets: 9,
        title: 'Acciones',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          return (
            '<div class="d-flex align-items-center gap-50">' +
            // Botón de Opciones
            '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
            '<i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>' +
            '</button>' +
            // Menú desplegable
            '<div class="dropdown-menu dropdown-menu-end m-0">' +
            // Botón para Modificar
            `<a class="dropdown-item waves-effect text-info edit-record" ` +
            `data-id="${full['id_instalacion']}" ` +
            `data-bs-toggle="modal" ` +
            `data-bs-target="#modalEditInstalacion">` +
            '<i class="ri-edit-box-line ri-20px text-info"></i> Modificar' +
            '</a>' +
            // Botón para Eliminar
            `<a class="dropdown-item waves-effect text-danger delete-record" ` +
            `data-id="${full['id_instalacion']}">` +
            '<i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar' +
            '</a>' +
            '</div>' + // Cierre del menú desplegable
            '</div>'
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
            title: 'Instalaciones',
            text: '<i class="ri-printer-line me-1"></i>Imprimir',
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
                  if (columnIndex === 1) { 
                    return inner.replace(/<[^>]*>/g, ''); 
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
                  if (columnIndex === 1) {
                    return inner.replace(/<[^>]*>/g, ''); 
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
                  if (columnIndex === 1) { 
                    return inner.replace(/<[^>]*>/g, '');
                  }
                  return inner;
                }
              }
            }
          },
          {
            extend: 'copy',
            title: 'Instalaciones',
            text: '<i class="ri-file-copy-line me-1"></i>Copiar',
            className: 'dropdown-item',
            exportOptions: {
              columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
              format: {
                body: function (inner, rowIndex, columnIndex) {
                  if (columnIndex === 8 || columnIndex === 11) {
                    return 'ViewSuspend';
                  }
                  if (columnIndex === 1) { 
                    return inner.replace(/<[^>]*>/g, '');
                  }
                  return inner;
                }
              }
            }
          }
        ]
      },
      {
        text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Agregar Instalación</span>',
        className: 'add-new btn btn-primary waves-effect waves-light',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#modalAddInstalacion'
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


  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  //ELIMINAR
  $(document).on('click', '.delete-record', function () {
    var id_instalacion = $(this).data('id'),
        dtrModal = $('.dtr-bs-modal.show');

    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

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
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}instalaciones/${id_instalacion}`, 
          success: function () {
            dt_instalaciones_table.ajax.reload();

            Swal.fire({
              icon: 'success',
              title: '¡Eliminado!',
              text: '¡La Instalacion ha sido eliminada correctamente!',
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
              text: 'Hubo un problema al eliminar la Istalacion.',
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La Instalacion no ha sido eliminada',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });






  //AGREGAR
  $(document).ready(function () {
    const formAdd = document.getElementById('addNewInstalacionForm');
    const certificadoContainer = $('#certificado-otros');
    const fieldsAdded = new Set();

    const fv = FormValidation.formValidation(formAdd, {
        fields: {
            'id_empresa': {
                validators: {
                    notEmpty: {
                        message: 'El ID de la empresa es obligatorio.'
                    }
                }
            },
            'tipo[]': {
                validators: {
                    notEmpty: {
                        message: 'Selecciona un tipo de instalación.'
                    }
                }
            },
            'estado': {
                validators: {
                    notEmpty: {
                        message: 'Selecciona el estado.'
                    }
                }
            },
            'direccion_completa': {
                validators: {
                    notEmpty: {
                        message: 'La dirección es obligatoria.'
                    }
                }
            },
            'certificacion': {
              validators: {
                  notEmpty: {
                      message: 'Selecciona una opcion.'
                  }
              }
          },
          'responsable': { 
            validators: {
                notEmpty: {
                    message: 'El nombre del responsable de la instalación es obligatorio.'
                }
            }
        },
        'eslabon': { 
          validators: {
              notEmpty: {
                  message: 'Es obligatorio seleccionar un eslabón al que pertenece.'
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
    });

    function updateCertificadoValidation() {
        const tipo = $('#certificacion').val();

        if (tipo === 'otro_organismo') {
            certificadoContainer.removeClass('d-none');

            if (!fieldsAdded.has('url[]')) {
                fv.addField('url[]', {
                    validators: {
                        notEmpty: {
                            message: 'Debes subir un archivo de certificado.'
                        },
                        file: {
                            extension: 'pdf,jpg,jpeg,png',
                            type: 'application/pdf,image/jpeg,image/png',
                            maxSize: 2097152, 
                            message: 'El archivo debe ser un PDF o una imagen (jpg, png) y no debe superar los 2 MB.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('url[]');
            }

            if (!fieldsAdded.has('folio')) {
                fv.addField('folio', {
                    validators: {
                        notEmpty: {
                            message: 'El folio o número del certificado es obligatorio.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('folio');
            }

            if (!fieldsAdded.has('id_organismo')) {
                fv.addField('id_organismo', {
                    validators: {
                        notEmpty: {
                            message: 'Selecciona un organismo de certificación.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('id_organismo');
            }

            if (!fieldsAdded.has('fecha_emision')) {
                fv.addField('fecha_emision', {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de emisión es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha de emisión no es válida.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('fecha_emision');
            }

            if (!fieldsAdded.has('fecha_vigencia')) {
                fv.addField('fecha_vigencia', {
                    validators: {
                        notEmpty: {
                            message: 'La fecha de vigencia es obligatoria.'
                        },
                        date: {
                            format: 'YYYY-MM-DD',
                            message: 'La fecha de vigencia no es válida.'
                        },
                        enabled: function (field) {
                            return $(field).closest('.form-group').css('display') !== 'none';
                        }
                    }
                });
                fieldsAdded.add('fecha_vigencia');
            }
        } else {
            certificadoContainer.addClass('d-none'); 

            if (fieldsAdded.has('url[]')) {
                fv.removeField('url[]');
                fieldsAdded.delete('url[]');
                $('input[name="url[]"]').removeClass('is-invalid');
            }
            if (fieldsAdded.has('folio')) {
                fv.removeField('folio');
                fieldsAdded.delete('folio');
                $('input[name="folio"]').removeClass('is-invalid');
            }
            if (fieldsAdded.has('id_organismo')) {
                fv.removeField('id_organismo');
                fieldsAdded.delete('id_organismo');
                $('select[name="id_organismo"]').removeClass('is-invalid');
            }
            if (fieldsAdded.has('fecha_emision')) {
                fv.removeField('fecha_emision');
                fieldsAdded.delete('fecha_emision');
                $('input[name="fecha_emision"]').removeClass('is-invalid');
            }
            if (fieldsAdded.has('fecha_vigencia')) {
                fv.removeField('fecha_vigencia');
                fieldsAdded.delete('fecha_vigencia');
                $('input[name="fecha_vigencia"]').removeClass('is-invalid');
            }
        }
    }

    // Revalidar los select2 cuando cambian
    $('#id_empresa, #estado, #fecha_emision').on('change', function () {
        fv.revalidateField($(this).attr('name'));
        if ($(this).val() === '') {
            $(this).removeClass('is-invalid'); 
        }
    });

    $('#tipo').on('change', function () {
      fv.revalidateField('tipo[]');
    });

    $('#certificacion').on('change', function () {
        updateCertificadoValidation();
    });

    function updateDatepickerValidation() {
        $('#fecha_vigencia').on('change', function () {
            const fechaVigencia = $(this).val();
            if (fechaVigencia) {
                const fecha = moment(fechaVigencia, 'YYYY-MM-DD');
                const fechaVencimiento = fecha.add(1, 'years').format('YYYY-MM-DD');
                $('#fecha_vencimiento').val(fechaVencimiento);

                fv.revalidateField('fecha_vigencia');
                fv.revalidateField('fecha_vencimiento');
            }
        });

        $('#fecha_vencimiento').on('change', function () {
            fv.revalidateField('fecha_vencimiento');
        });
    }

    updateCertificadoValidation();
    updateDatepickerValidation();

    // Enviar el formulario si es válido
    fv.on('core.form.valid', function () {
        var formData = new FormData(formAdd); 
        $.ajax({
            url: '/instalaciones',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#btnRegistrarInstalacion').prop('disabled', true).text('Registrando...');
            },
            success: function (response) {
              dt_user_table.DataTable().ajax.reload();
          
              $('#btnRegistrarInstalacion').prop('disabled', false).text('Registrar');
              $('#modalAddInstalacion').modal('hide');
          
              // Desactivar validaciones temporalmente
              fv.disableValidator('id_empresa');
              fv.disableValidator('estado');
              fv.disableValidator('tipo[]');
              $('#addNewInstalacionForm')[0].reset();
          
              // Limpiar selects y quitar clases de error
              $('#id_empresa').val('').trigger('change').removeClass('is-invalid');
              $('#estado').val('').trigger('change').removeClass('is-invalid');
              $('#tipo').val([]).trigger('change').removeClass('is-invalid'); 
              certificadoContainer.addClass('d-none');
          
              // Reactivar validaciones después de reiniciar
              setTimeout(() => {
                  fv.enableValidator('id_empresa');
                  fv.enableValidator('estado');
                  fv.enableValidator('tipo[]');
              }, 0);
          
              // Mostrar mensaje de éxito
              Swal.fire({
                  icon: 'success',
                  title: '¡Éxito!',
                  text: 'Registrado correctamente.',
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
                  text: 'Error al registrar la Instalacion',
                  customClass: {
                      confirmButton: 'btn btn-danger'
                  }
              });
          }
        });
    });

  // Manejo de los tipos seleccionados
  $(document).on('change', '#tipo', function () {
    var tiposSeleccionados = $(this).val();
    var certificadoContainer = $('#certificado-otros');
    certificadoContainer.find('.file-input').remove();
    var archivosCreados = new Set();
    var primerCampoInsertado = false;

    tiposSeleccionados.forEach(function(tipo) {
        var archivoId = '';
        var archivoNombre = '';

        if (tipo === "Productora") {
            archivoId = '127';
            archivoNombre = 'Certificado como productor';
        } else if (tipo === "Envasadora") {
            archivoId = '128';
            archivoNombre = 'Certificado como envasador';
        } else if (tipo === "Comercializadora") {
            archivoId = '129';
            archivoNombre = 'Certificado como comercializador';
        } else if (tipo === "Almacen y bodega") {
            archivoId = '130'; 
            archivoNombre = 'Certificado como almacén y bodega';
        } else if (tipo === "Area de maduracion") {
            archivoId = '131'; 
            archivoNombre = 'Certificado como área de maduración';
        }

       // Mostrar u ocultar el select según las opciones seleccionadas
          if (tiposSeleccionados.includes('Almacen y bodega') || tiposSeleccionados.includes('Area de maduracion')) {
            $('#eslabon-select').removeClass('d-none'); 
            fv.enableValidator('eslabon');
        } else {
            $('#eslabon-select').addClass('d-none');
            $('#eslabon').val(''); 
            fv.disableValidator('eslabon');
        }

        // Asegurarse de que solo se agregue una vez cada archivo
        if (!archivosCreados.has(archivoId)) {
            if (!primerCampoInsertado) {
                certificadoContainer.prepend(`
                    <div class="col-md-12 mb-3 file-input" id="file-input-${archivoId}">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control form-control-sm" type="file" id="file-${archivoId}" name="url[]" required>
                            <input value="${archivoId}" class="form-control" type="hidden" name="id_documento[]">
                            <input value="${archivoNombre}" class="form-control" type="hidden" name="nombre_documento[]">
                            <label for="file-${archivoId}">${archivoNombre}</label>
                        </div>
                    </div>
                `);
                primerCampoInsertado = true; 
            } else {
                certificadoContainer.find('.file-input').last().after(`
                    <div class="col-md-12 mb-3 file-input" id="file-input-${archivoId}">
                        <div class="form-floating form-floating-outline">
                            <input class="form-control form-control-sm" type="file" id="file-${archivoId}" name="url[]" required>
                            <input value="${archivoId}" class="form-control" type="hidden" name="id_documento[]">
                            <input value="${archivoNombre}" class="form-control" type="hidden" name="nombre_documento[]">
                            <label for="file-${archivoId}">${archivoNombre}</label>
                        </div>
                    </div>
                `);
            }
            archivosCreados.add(archivoId);
        }
    });
  });

});









//EDITAR
$(document).ready(function () {
  let instalacionData = {};
  let archivo = false; // Variable para manejar la existencia del archivo

  // Función para mostrar u ocultar campos según el valor de certificación
  function toggleCamposCertificacion(certificacion) {
      if (certificacion === 'otro_organismo') {
          $('#edit_certificado_otros').removeClass('d-none');
          
          // Rellenar los campos adicionales con los datos obtenidos
          $('#edit_folio').val(instalacionData.folio || '');
          $('#edit_id_organismo').val(instalacionData.id_organismo || '').trigger('change');
          $('#edit_fecha_emision').val(instalacionData.fecha_emision || '');
          $('#edit_fecha_vigencia').val(instalacionData.fecha_vigencia || '');
        
          /*if (instalacionData.archivoUrl) {
              $('#archivo_url_display').html(`
                  <p>Archivo existente: <a href="../files/${instalacionData.numeroCliente}/${instalacionData.archivoUrl}" target="_blank">${instalacionData.archivoUrl}</a></p>`);
              archivo = true; // Si existe un archivo, asignamos true
          } else {
              $('#archivo_url_display').html('No hay archivo disponible.');
              archivo = false; // Si no existe archivo, asignamos false
          }*/

if (instalacionData.archivoUrl && Array.isArray(instalacionData.archivoUrl)) {
    const enlaces = instalacionData.archivoUrl.map(function (url) {
        return `<a href="../files/${instalacionData.numeroCliente}/${url}" target="_blank">${url}</a>`;
    });
    $('#archivo_url_display').html(`Archivo existente: ${enlaces.join(', ')}`);
    archivo = true;
} else if (instalacionData.archivoUrl) {
    // Caso en que sea solo un string
    $('#archivo_url_display').html(`
        Archivo existente: <a href="../files/${instalacionData.numeroCliente}/${instalacionData.archivoUrl}" target="_blank">${instalacionData.archivoUrl}</a>`);
    archivo = true;
} else {
    $('#archivo_url_display').html('No hay archivo disponible.');
    archivo = false;
}

          // Deshabilitar o habilitar la validación del archivo según la existencia del archivo
          if (archivo) {
            fvEdit.disableValidator('edit_url[]'); // Deshabilitamos la validación si ya existe un archivo
          } else {
            fvEdit.enableValidator('edit_url[]'); // Habilitamos la validación si no existe un archivo
          }

          // Habilitar la validación de los otros campos
          fvEdit.enableValidator('edit_folio');
          fvEdit.enableValidator('edit_id_organismo');
          fvEdit.enableValidator('edit_fecha_emision');
          fvEdit.enableValidator('edit_fecha_vigencia');
      } else {
          $('#edit_certificado_otros').addClass('d-none');
          $('#edit_folio').val(null);
          $('#edit_id_organismo').val(null).trigger('change');
          $('#edit_fecha_emision').val(null);
          $('#edit_fecha_vigencia').val(null);
          $('#archivo_url_display').html('No hay archivo disponible.');

          // Si no es 'otro_organismo', deshabilitar la validación del archivo y otros campos
          fvEdit.disableValidator('edit_folio');
          fvEdit.disableValidator('edit_id_organismo');
          fvEdit.disableValidator('edit_fecha_emision');
          fvEdit.disableValidator('edit_fecha_vigencia');
          fvEdit.disableValidator('edit_url[]');
      }
  }

  // Manejar el cambio en el select de certificación
  $('#edit_certificacion').on('change', function () {
      toggleCamposCertificacion($(this).val());
  });

  // Iniciar FormValidation
  const editForm = document.getElementById('editInstalacionForm');
  const fvEdit = FormValidation.formValidation(editForm, {
      fields: {
        'edit_tipo[]': {
            validators: {
                notEmpty: {
                    message: 'Selecciona al menos un tipo de instalación.'
                }
            }
        },
        'edit_direccion': {
            validators: {
                notEmpty: {
                    message: 'La dirección completa es obligatoria.'
                }
            }
        },
        'edit_responsable': {
            validators: {
                notEmpty: {
                    message: 'El nombre del responsable es obligatorio.'
                }
            }
        },
        'edit_folio': {
            validators: {
                notEmpty: {
                    message: 'El folio es obligatorio.'
                }
            }
        },
        'edit_id_organismo': {
            validators: {
                notEmpty: {
                    message: 'Selecciona un organismo de certificación.'
                }
            }
        },
        'edit_fecha_emision': {
            validators: {
                notEmpty: {
                    message: 'La fecha de emisión es obligatoria.'
                },
                date: {
                  format: 'YYYY-MM-DD',
                  message: 'Ingresa una fecha válida (yyyy-mm-dd).'
                }
            }
        },
        'edit_fecha_vigencia': {
            validators: {
                notEmpty: {
                    message: 'La fecha de vigencia es obligatoria.'
                },
                date: {
                  format: 'YYYY-MM-DD',
                  message: 'Ingresa una fecha válida (yyyy-mm-dd).'
                }
            }
        },
        'edit_eslabon': {
          validators: {
              notEmpty: {
                  message: 'La fecha de vigencia es obligatoria.'
              }
          }
      },
        'edit_url[]': {
            validators: {
                file: {
                    extension: 'pdf,jpg,jpeg,png',
                    type: 'application/pdf,image/jpeg,image/png',
                    maxSize: 2097152, // 2MB en bytes
                    message: 'El archivo debe ser en formato PDF, JPG, JPEG o PNG y no debe superar los 2MB.'
                },
                notEmpty: {
                    message: 'El archivo es obligatorio cuando se selecciona "Otro organismo".'
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
      // Si la validación es exitosa, enviar el formulario
      var id_instalacion = $(editForm).data('id');
      var formData = new FormData(editForm);

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
              dt_instalaciones_table.ajax.reload();
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
                  footer: `<pre>${JSON.stringify(xhr.responseJSON, null, 2)}</pre>`
              });
          }
      });
  });

  $('#edit_tipo').on('change', function () {
    fvEdit.revalidateField('edit_tipo[]');
  });

  var id_instalacion = null; // Variable global para almacenar el ID de instalación

  // Evento `click` para inicializar el ID de instalación
  $(document).on('click', '.edit-record', function () {
      id_instalacion = $(this).data('id'); // Asignar el ID al hacer clic
      console.log('ID de instalación inicializado:', id_instalacion);
  });
  
  // Evento `change` para manejar el tipo seleccionado
  $(document).on('change', '#edit_tipo', function () {
      var tipo = $(this).val();
  
      // Referencias a los campos relacionados con documentos
      var hiddenIdDocumento = $('#edit_certificado_otros').find('input[name="edit_id_documento[]"]');
      var hiddenNombreDocumento = $('#edit_certificado_otros').find('input[name="edit_nombre_documento[]"]');
      var fileCertificado = $('#edit_certificado_otros').find('input[type="file"]');
  
      // Manejo de documentos basado en el tipo seleccionado
      if (tipo.includes("Productora")) {
        hiddenIdDocumento.val('127');
        hiddenNombreDocumento.val('Certificado como productor');
        fileCertificado.attr('id', 'file-127');
      } else if (tipo.includes("Envasadora")) {
        hiddenIdDocumento.val('128');
        hiddenNombreDocumento.val('Certificado como envasador');
        fileCertificado.attr('id', 'file-128');
      } else if (tipo.includes("Comercializadora")) {
        hiddenIdDocumento.val('129');
        hiddenNombreDocumento.val('Certificado como comercializador');
        fileCertificado.attr('id', 'file-129');
      } else if (tipo.includes("Almacen y bodega")) {
        hiddenIdDocumento.val('130');
        hiddenNombreDocumento.val('Certificado como almacén y bodega');
        fileCertificado.attr('id', 'file-130');
      } else if (tipo.includes("Area de maduracion")) {
        hiddenIdDocumento.val('131');
        hiddenNombreDocumento.val('Certificado como área de maduración');
        fileCertificado.attr('id', 'file-131');
      } else {
        hiddenIdDocumento.val('');
        hiddenNombreDocumento.val('');
        fileCertificado.removeAttr('id');
      }
  
      // Mostrar u ocultar el campo `#edit_eslabon` dependiendo del tipo seleccionado
      if (tipo.includes('Almacen y bodega') || tipo.includes('Area de maduracion')) {
          $('#edit_eslabon-select').removeClass('d-none');
          fvEdit.enableValidator('edit_eslabon');
  
          // Verifica si `id_instalacion` ya fue inicializado
          if (id_instalacion) {
              cargarDatos(id_instalacion); // Llama a cargarDatos con el ID almacenado
          } else {
              console.warn("No se encontró un ID de instalación válido.");
          }
      } else {
          $('#edit_eslabon-select').addClass('d-none');
          $('#edit_eslabon').val('');
          fvEdit.disableValidator('edit_eslabon');
          console.log('Validación desactivada para #edit_eslabon');
      }
  });
  
  function cargarDatos(id_instalacion) {
      if (!id_instalacion) {
          console.warn("No se proporcionó un ID de instalación válido.");
          return;
      }
  
      console.log('Se obtuvo: ' + id_instalacion);
  
      $.ajax({
          url: '/domicilios/edit/' + id_instalacion,
          type: 'GET',
          success: function (response) {
              console.log('Datos recibidos del servidor:', response);
              $('#edit_eslabon').val(response.instalacion.eslabon).trigger('change');
          },
          error: function (error) {
              console.log(error);
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Hubo un problema al cargar los datos del domicilio.'
              });
          }
      });
  }
  
  // Deshabilitar validación inicial
  fvEdit.disableValidator('edit_folio');
  fvEdit.disableValidator('edit_id_organismo');
  fvEdit.disableValidator('edit_fecha_emision');
  fvEdit.disableValidator('edit_fecha_vigencia');
  fvEdit.disableValidator('edit_url[]');
  
  $(document).on('click', '.edit-record', function () {
    var id_instalacion = $(this).data('id');
    var url = baseUrl + 'domicilios/edit/' + id_instalacion;
    console.log('el ide es:' + id_instalacion);

    $.get(url, function (data) {
        if (data.success) {
            var instalacion = data.instalacion;
            var tipoParsed = JSON.parse(instalacion.tipo); 

            instalacionData = {
                folio: instalacion.folio || '',
                eslabon: instalacion.eslabon || '',
                id_organismo: instalacion.id_organismo || '',
                fecha_emision: instalacion.fecha_emision !== 'N/A' ? instalacion.fecha_emision : '',
                fecha_vigencia: instalacion.fecha_vigencia !== 'N/A' ? instalacion.fecha_vigencia : '',
                archivoUrl: data.archivo_urls || '',
                numeroCliente: data.numeroCliente || ''
            };

            $('#edit_id_empresa').val(instalacion.id_empresa).trigger('change');
            $('#edit_tipo').val(tipoParsed).trigger('change');
            $('#edit_eslabon').val(instalacion.eslabon).trigger('change');
            $('#edit_estado').val(instalacion.estado).trigger('change');
            $('#edit_direccion').val(instalacion.direccion_completa);
            $('#edit_responsable').val(instalacion.responsable || '').trigger('change');

            // Establecer el valor del select y mostrar los campos adicionales si corresponde
            $('#edit_certificacion').val(instalacion.certificacion).trigger('change');
            toggleCamposCertificacion(instalacion.certificacion);

            // Asignar el id_instalacion al atributo data-id del formulario
            $('#editInstalacionForm').data('id', id_instalacion);
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
});







$(document).on('click', '.verDocumentosBtn', function () {
  var idInstalacion = $(this).data('id');
  console.log('ID de Instalación:', idInstalacion);

  $('#modalEditInstalacion').modal('hide');
  $('#modalVerDocumento').modal('hide');
  $('#documentosTableBody').html('<tr><td colspan="2" class="text-center">Cargando documentos...</td></tr>');
  $('#modalVerDocumento').modal('show');

  $.ajax({
      url: '/getDocumentosPorInstalacion', 
      method: 'GET',
      data: { id_instalacion: idInstalacion },
      success: function (response) {
          if (response.success) {
              var documentos = response.documentos; 
              var numeroCliente = response.numero_cliente;
              var tablaContenido = '';

              documentos.forEach(function (doc, index) {
                  var fullUrl = `../files/${numeroCliente}/${doc.url}`;
                  var nombreDocumento = doc.nombre_documento || 'Documento sin nombre';

                  tablaContenido += `
                  <tr>
                      <td style="text-align:left;">${nombreDocumento}</td>
                      <td>
                          <button 
                              class="verDocumentoBtn" 
                              data-url="${fullUrl}" 
                              data-nombre="${nombreDocumento}" 
                              data-registro="Registro ${index + 1}" 
                              style="border: none; background: transparent;">
                              <i class="ri-file-pdf-2-fill text-danger fs-1 cursor-pointer"></i>
                          </button>
                      </td>
                  </tr>`;
              });

              $('#documentosTableBody').html(tablaContenido);
          } else {
              $('#documentosTableBody').html('<tr><td colspan="2" class="text-center">No se encontraron documentos.</td></tr>');
          }
      },
      error: function () {
          $('#documentosTableBody').html('<tr><td colspan="2" class="text-center">Error al cargar los documentos.</td></tr>');
      }
  });
});

// Al hacer clic en el botón "Ver Documento"
$(document).on('click', '.verDocumentoBtn', function () {
  var nombreDocumento = $(this).data('nombre'); 
  var url = $(this).data('url'); 

  $('#loading-spinner').show();
  $('#modalVerDocumento').modal('hide');
  $('#PdfDictamenIntalaciones').modal('show'); 

  $('#pdfViewerDictamen').attr('src', url);
  $('#titulo_modal_Dictamen').text('Certificado Instalaciones');
  $('#subtitulo_modal_Dictamen').text(nombreDocumento); 

  var openPdfBtn = $('#openPdfBtnDictamen');
  openPdfBtn.attr('href', url);
  openPdfBtn.show();
});

// Evento para ocultar el spinner y mostrar el iframe cuando el PDF haya cargado
$('#pdfViewerDictamen').on('load', function () {
  $('#loading-spinner').hide();
  $('#pdfViewerDictamen').show();
});

$('#PdfDictamenIntalaciones').on('hidden.bs.modal', function () {
$('#pdfViewerDictamen').attr('src', '');
console.log("Modal de PDF cerrado y iframe limpiado");
$('#modalVerDocumento').modal('show');
});






});///end function
