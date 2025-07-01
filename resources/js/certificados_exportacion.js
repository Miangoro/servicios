/*
 Page User List
 */
'use strict';

$(document).ready(function () {///flatpickr
  flatpickr(".flatpickr-datetime", {
    dateFormat: "Y-m-d", // Formato de la fecha: Año-Mes-Día (YYYY-MM-DD)
    enableTime: false,   // Desactiva la  hora
    allowInput: true,    // Permite al usuario escribir la fecha manualmente
    locale: "es",        // idioma a español
  });
});
//FUNCION FECHAS
$('#fecha_emision').on('change', function () {
  var valor = $(this).val();
  if (!valor) {// Si está vacío, también limpiar fecha_vigencia
    $('#fecha_vigencia').val('');
    return; // No seguir ejecutando
  }
  var fechaInicial = new Date(valor);
  fechaInicial.setDate(fechaInicial.getDate() + 90); // +90 días
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
// FUNCION FECHAS EDIT
$('#edit_fecha_emision').on('change', function () {
  var valor = $(this).val();
  if (!valor) {// Si está vacía, limpiar también la fecha de vigencia
    $('#edit_fecha_vigencia').val('');
    return;
  }
  var fechaInicial = new Date(valor);
  fechaInicial.setDate(fechaInicial.getDate() + 90); // +90 días
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




///Datatable (jquery)
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



///FUNCIONALIDAD DE LA VISTA datatable
if (dt_user_table.length) {
    var dataTable = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'CerExpo-list'
      },
      columns: [
        { data: '' }, // (0)
        { data: 'num_certificado' },//(1)
        {
          data: '',/*null, //soli y serv.
            render: function(data, type, row) {
            return `<span style="font-size:14px"> <strong>${data.folio}</strong><br>
                ${data.n_servicio}<span>`;
            }*/
        },
        {
          data: null, // Se usará null porque combinaremos varios valores
          render: function (data, type, row) {
            return `
              <strong>${data.numero_cliente}</strong><br>
                  <span style="font-size:12px">${data.razon_social}<span>
              `;
          }
        },
        { data: '' },
        { data: 'fechas' },
        { data: '' },//Revisores
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
          targets: 1,
          orderable: true,
          searchable: true,
          render: function (data, type, full, meta) {
            var $num_certificado = full['num_certificado'];
            var $id = full['id_certificado'];
            //var $folio_solicitud = full['folio_solicitud'];
            var $folio_solicitud = full['folio_solicitud']?.match(/^([A-Z\-]+\d+)$/)?.[1] + '-E' ?? 'No encontrado';
            
            var $pdf_firmado  = full['pdf_firmado'];
            if ($pdf_firmado) {
              var icono = `<a href="${$pdf_firmado}" target="_blank" title="Ver PDF firmado">
                <i class="ri-file-pdf-2-fill text-success ri-28px cursor-pointer"></i> </a>`;
            } else {
              var icono = '<i data-id="' + $id + '" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>';
            }

            return '<small class="fw-bold">' + $num_certificado + '</small>' +
              `${icono}` +

              `<br><span class="fw-bold">Solicitud:</span> ${$folio_solicitud} <i data-id="${full['id_certificado']}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfSolicitudCertificado" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"></i>
              
              <br><span class="fw-bold">Pedido:</span> ${full['folio_solicitud']}
              <i data-id="${full['id_solicitud']}" data-folio="${full['folio_solicitud']}"
                class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfSolicitud"
                data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
              </i>
              `;
          }
        },
        {
          //Tabla 2
          targets: 2,
          searchable: true,
          orderable: false,
          render: function (data, type, full, meta) {
            var $num_servicio = full['num_servicio'];

            if (full['url_acta'] == 'Sin subir') {
              var $acta = '<a href="/img_pdf/FaltaPDF.png" target="_blank"> <img src="/img_pdf/FaltaPDF.png" height="25" width="25" title="Ver documento" alt="FaltaPDF"> </a>'
            } else {
              var $acta = full['url_acta'].map(url => `
                <i data-id="${full['numero_cliente']}/actas/${url}" data-empresa="${full['razon_social']}"
                   class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfActa"
                   data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
                </i>
              `).join('');//concatena en un string.
            }

            return `
            <span class="fw-bold">Dictamen:</span> ${full['num_dictamen']}
              <i data-id="${full['id_dictamen']}" class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen" 
                data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
              </i>
            <br><span class="fw-bold">Servicio:</span> ${$num_servicio}
              <span>${$acta}</span>
            `;
          }
        },
        {
          //caracteristicas
          targets: 4,
          searchable: true,
          orderable: false,
          responsivePriority: 4,
          render: function (data, type, full, meta) {

            return `<div class="small">
            ${full['combinado'] ? '<span class="badge rounded-pill bg-info"><b>Combinado</b></span> <br>' : ''}
                <b>Lote envasado:</b> ${full['nombre_lote_envasado']} <br>
                <b>Lote granel:</b> ${full['nombre_lote_granel']} <br>
                <b>Marca:</b> ${full['marca']} <br>
                <b>Cajas:</b> ${full['cajas']} <br>
                <b>Botellas:</b> ${full['botellas']} <br>
                <b>Pedido:</b> ${full['n_pedido']}
                
                ${full['sustituye'] ? `<br><b>Sustituye:</b> ${full['sustituye']}` : ''}
              </div>`;
          }
        },
        {//fechas
          targets: 5,
          searchable: true,
          orderable: true,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $fecha_emision = full['fecha_emision'] ?? 'No encontrado';
            var $fecha_vigencia = full['fecha_vigencia'] ?? 'No encontrado';
            return `
                <div>
                    <div><span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Emisión:<br></strong> ${$fecha_emision}</span></div>
                    <div><span class="badge" style="background-color: transparent; color: #676B7B;"><strong>Vigencia:<br></strong> ${$fecha_vigencia}</span></div>
                    <div class="small">${full['diasRestantes']}</div>
                </div> `;
          }
        },
        {//estatus
          targets: 6,
          searchable: false,
          orderable: true,
          className: 'text-center',
          render: function (data, type, full, meta) {
            //estatus
            var $estatus = full['estatus'];
            var $fecha_actual = full['fecha_actual'];
            var $vigencia = full['vigencia'];
            var $pdf_firmado  = full['pdf_firmado'];//si hay archivo subido
            let estatus;
            
            
            if ($fecha_actual > $vigencia) {
              estatus = '<span class="badge rounded-pill bg-danger">Vencido</span>';
            } else if ($pdf_firmado) {
              estatus = '<span class="badge rounded-pill bg-success">Emitido</span>';
            } else if ($estatus == 1) {
              estatus = '<span class="badge rounded-pill bg-danger">Cancelado</span>';
            } else if ($estatus == 2) {
              estatus = '<span class="badge rounded-pill bg-warning">Reexpedido</span>';
            } else if ($estatus == 3) {
              estatus = '<span class="badge rounded-pill bg-success">Emitido</span>';
            } else {
              estatus = '<span class="badge rounded-pill bg-secondary">Pre-certificado</span>';
            }

            ///revisores PERSONAL
            var $revisor_personal = full['revisor_personal'];
            var $numero_revision_personal = full['numero_revision_personal'];
            const decision_personal = full['decision_personal'];
            const respuestas_personal = full['respuestas_personal'] ? JSON.parse(full['respuestas_personal']) : {};

            const observaciones_personal = Object.values(respuestas_personal).some(r =>
              r.some(({ observacion }) => observacion?.toString().trim()));

            const icono_oc = observaciones_personal
              ? `<i class="ri-alert-fill text-warning"></i>`
              : '';

            let revisor_oc = $revisor_personal !== null ? $revisor_personal : `<b style="color: red;">Sin asignar</b>`;

            let revision_oc = $numero_revision_personal === 1 ? 'Primera revisión - '
              : $numero_revision_personal === 2 ? 'Segunda revisión - '
                : '';

            let colorClass = '';
            if (decision_personal === 'positiva') {
              colorClass = 'badge rounded-pill bg-primary';
            } else if (decision_personal === 'negativa') {
              colorClass = 'badge rounded-pill bg-danger';
            } else if (decision_personal === 'Pendiente') {
              colorClass = 'badge rounded-pill bg-warning text-dark';
            }

            ///revisores CONSEJO
            var $revisor_consejo = full['revisor_consejo'];
            var $numero_revision_consejo = full['numero_revision_consejo'];
            const decision_consejo = full['decision_consejo'];
            const respuestas_consejo = full['respuestas_consejo'] ? JSON.parse(full['respuestas_consejo']) : {};

            const observaciones2 = Object.values(respuestas_consejo).some(r =>
              r.some(({ observacion }) => observacion?.toString().trim()));

            const icono2 = observaciones2
              ? `<i class="ri-alert-fill text-warning"></i>`
              : '';

            let revisor2 = $revisor_consejo !== null ? $revisor_consejo : `<b style="color: red;">Sin asignar</b>`;

            let revision2 = $numero_revision_consejo === 1 ? 'Primera revisión - '
              : $numero_revision_consejo === 2 ? 'Segunda revisión - '
                : '';

            let colorClass2 = '';
            if (decision_consejo === 'positiva') {
              colorClass2 = 'badge rounded-pill bg-primary';
            } else if (decision_consejo === 'negativa') {
              colorClass2 = 'badge rounded-pill bg-danger';
            } else if (decision_consejo === 'Pendiente') {
              colorClass2 = 'badge rounded-pill bg-warning text-dark';
            }

            //visto bueno
            const voboData = full['vobo'];
            let vobo = ''; // Declaración fuera del bloque

            if (!voboData) {
              vobo = '';// No mostrar nada si está vacío
            }else {
                const hayCliente = voboData.find(v => v.id_cliente);
                const respuesta = hayCliente ? hayCliente.respuesta : null;
                if (!hayCliente) {//Sin respuesta del cliente
                    vobo = `<span class="badge rounded-pill bg-dark">Vo.Bo. pendiente</span>`;
                }
                if (respuesta == "1") {
                    vobo = `<span class="badge rounded-pill bg-info">Vo.Bo. cliente</span>`;
                }
                if (respuesta == "2") {
                    vobo = `<span class="badge rounded-pill bg-danger">Vo.Bo. cliente</span>`;
                }
            }
            

            return estatus +
              `<div style="flex-direction: column; margin-top: 2px;">
                <div class="small"> <b>Personal:</b> 
                  <span class="${colorClass}">${revision_oc} ${revisor_oc}</span>${icono_oc}
                </div>
                <div style="display: inline;" class="small"> <b>Consejo:</b> 
                  <span class="${colorClass2}">${revision2} ${revisor2}</span>${icono2}
                </div>
              </div> `+
              `<div class="small" style="margin-top: 4px;"> ${vobo} </div>`;
            //<div style="display: flex; flex-direction: column; align-items: flex-start;"></div>;
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
              `<button class="btn btn-sm dropdown-toggle hide-arrow ` + (full['estatus'] == 1 ? 'btn-danger' : 'btn-info') + `" data-bs-toggle="dropdown">` +
              (full['estatus'] == 1 ? 'Cancelado' : '<i class="ri-settings-5-fill"></i>&nbsp;Opciones<i class="ri-arrow-down-s-fill ri-20px"></i>') +
              '</button>' +

              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              ( full['estatus'] == 1 ?  //Mostrar solo trazabilidad si está cancelado
                `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" data-bs-toggle="modal" data-bs-target="#ModalTracking"  class="dropdown-item waves-effect text-black trazabilidad"> <i class="ri-history-line text-secondary"></i> Trazabilidad</a>`
              :// Mostrar todas las opciones
                `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" data-bs-toggle="modal" data-bs-target="#ModalEditar" href="javascript:;" class="dropdown-item text-dark editar"> <i class="ri-edit-box-line ri-20px text-info"></i> Editar</a>` +
                `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" class="dropdown-item waves-effect text-dark subirPDF" data-bs-toggle="modal" data-bs-target="#ModalCertificadoFirmado">` + '<i class="ri-upload-2-line ri-20px text-secondary"></i> Adjuntar PDF</a>' +
                `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" data-bs-toggle="modal" data-bs-target="#ModalDocumentos" href="javascript:;" class="dropdown-item text-dark documentos"> <i class="ri-folder-line ri-20px text-secondary"></i> Ver documentación</a>` +
                `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" data-bs-toggle="modal" data-bs-target="#asignarRevisorModal" class="dropdown-item waves-effect text-dark"> <i class="text-warning ri-user-search-fill"></i> Asignar revisor </a>` +
                `<a data-id="${full['id_certificado']}" data-bs-toggle="modal" data-bs-target="#ModalVoBo" href="javascript:;" class="dropdown-item text-dark VoBo"> <i class="ri-edit-box-line ri-20px text-light"></i> Vo. Bo.</a>` +
                `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" data-bs-toggle="modal" data-bs-target="#ModalTracking"  class="dropdown-item waves-effect text-black trazabilidad"> <i class="ri-history-line text-secondary"></i> Trazabilidad</a>` +
                `<a data-id="${full['id_certificado']}" data-folio="${full['num_certificado']}" data-bs-toggle="modal" data-bs-target="#modalAddReexCerExpor" class="dropdown-item waves-effect text-black reexpedir"> <i class="ri-file-edit-fill text-success"></i> Reexpedir/Cancelar</a>` +
                `<a data-id="${full['id_certificado']}" class="dropdown-item waves-effect text-black eliminar"> <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar</a>`
              ) +
              '</div>' +
              '</div>'
            );
          }
        }
      ],

      order: [[1, 'desc']],//por defecto ordene por num_certificado (index 1)
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

      // Opciones NUEVO/FIRMAR/EXPORTAR/exportar default
      buttons: [
        /*{
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
        },*///BOTONES EXPORTAR

        {//EXPORTAR EXCEL
          text: '<i class="ri-file-excel-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Exportar Excel</span>',
          className: 'btn btn-primary waves-effect waves-light me-2',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#exportarExcelCertificados'
          }
        },
        {//FIRMAR DOCUSIGN
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Firmar Docusign</span>',
          className: 'btn btn-info waves-effect waves-light me-2',
          action: function (e, dt, node, config) {
            window.location.href = '/add_firmar_docusign';
          }
        },
        {//BOTON AGREGAR
          text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nuevo Certificado</span>',
          className: 'add-new btn btn-primary waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-dismiss': 'modal',
            'data-bs-target': '#ModalAgregar'
          }
        }
      ],

      ///PAGINA RESPONSIVA
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de ' + data['num_certificado'];
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

  });//var DataTable
}// end-datatable



///EXPORTAR EXCEL
$(document).ready(function () {
    $('#reporteForm').on('submit', function (e) {
      e.preventDefault(); // Prevenir el envío tradicional del formulario
      const exportUrl = $(this).attr('action'); // Obtener la URL del formulario
      const formData = $(this).serialize(); // Serializa los datos del formulario

      // Mostrar el SweetAlert de "Generando Reporte"
      Swal.fire({
        title: 'Generando Reporte...',
        text: 'Por favor espera mientras se genera el reporte.',
        icon: 'info',
        didOpen: () => {
          Swal.showLoading(); // Muestra el ícono de carga
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
          const link = document.createElement('a');
          const url = window.URL.createObjectURL(response);
          link.href = url;
          link.download = 'reporte_certificados_exportacion.xlsx';
          link.click();
          window.URL.revokeObjectURL(url);

          $('#exportarExcelCertificados').modal('hide');
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
          $('#exportarExcelCertificados').modal('hide');
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

$(document).ready(function () {
  $('#restablecerFiltros').on('click', function () {
    $('#reporteForm')[0].reset();
    $('.select2').val('').trigger('change');
    console.log('Filtros restablecidos.');
  });
});



///AGREGAR NUEVO REGISTRO
//const form = document.getElementById('FormAgregar');
//Validación del formulario por "name"
const fv = FormValidation.formValidation(FormAgregar, {
    fields: {
      id_dictamen: {
        validators: {
          notEmpty: {
            message: 'El número de dictamen es obligatorio.'
          }
        }
      },
      num_certificado: {
        validators: {
          notEmpty: {
            message: 'El número de certificado es obligatorio.'
          }
        }
      },
      id_firmante: {
        validators: {
          notEmpty: {
            message: 'Seleccione una opcion'
          }
        }
      },
      fecha_emision: {
        validators: {
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
          }
        }
      },
      fecha_vigencia: {
        validators: {
          date: {
            format: 'YYYY-MM-DD',
            message: 'Ingresa una fecha válida (yyyy-mm-dd).',
          }
        }
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        eleInvalidClass: 'is-invalid',
        rowSelector: '.form-floating'//clases del formulario
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
}).on('core.form.valid', function (e) {

    var formData = new FormData(FormAgregar);
    $.ajax({
      url: '/creaCerExp',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        console.log('Error222:', response);
        $('#ModalAgregar').modal('hide');//modal
        $('#FormAgregar')[0].reset();//formulario
        $('.select2').val(null).trigger('change'); //Reset del select2

        // Actualizar la tabla sin reinicializar DataTables
        dataTable.ajax.reload();
        // Mostrar alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.message,
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      },
      error: function (xhr) {
        console.log('Error:', xhr);
        console.log('Error2:', xhr.responseText);
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
});



///ELIMINAR REGISTRO
$(document).on('click', '.eliminar', function () {//clase del boton "eliminar"
    var id_certificado = $(this).data('id'); //ID de la clase
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
      confirmButtonText: '<i class="ri-check-line"></i> Sí, eliminar',
      cancelButtonText: '<i class="ri-close-line"></i> Cancelar',
      customClass: {
        confirmButton: 'btn btn-primary me-2',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        // Enviar solicitud DELETE al servidor
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}deletCerExp/${id_certificado}`,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            dataTable.draw(false);//Actualizar la tabla, "null,false" evita que vuelva al inicio
            // Mostrar SweetAlert de éxito
            Swal.fire({
              icon: 'success',
              title: '¡Exito!',
              text: response.message,
              customClass: {
                confirmButton: 'btn btn-primary'
              }
            });
          },
          error: function (error) {
            console.log('Error:', error);
            // Mostrar SweetAlert de error
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al eliminar.',
              //footer: `<pre>${error.responseText}</pre>`,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });

      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // Acción cancelada, mostrar mensaje informativo
        Swal.fire({
          title: '¡Cancelado!',
          text: 'La eliminación ha sido cancelada.',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      }
    });
});



///EDITAR
$(document).ready(function () {
    // Función para cargar los datos
    $(document).on('click', '.editar', function () {//clase del boton "editar"
      var id_certificado = $(this).data('id');
      var num_certificado = $(this).data('folio');
      $('#badge-certificado').text(num_certificado);


      $('#edit_id_certificado').val(id_certificado);
      
      $.ajax({
        url: '/editCerExp/' + id_certificado + '/edit',
        method: 'GET',
        success: function (datos) {


          
const $select = $('#edit_id_dictamen');
// Eliminar opciones anteriores agregadas dinámicamente, pero dejar los disponibles
$select.find('option[data-dinamico="true"]').remove();

// Si el dictamen guardado no está en los disponibles, agregarlo temporalmente
if (!$select.find(`option[value="${datos.id_dictamen}"]`).length) {
    const texto = `${datos.num_dictamen} | ${datos.folio ?? 'Sin folio'}`;
    $select.append(`<option value="${datos.id_dictamen}" selected data-dinamico="true">${texto}</option>`);
} else {
    $select.val(datos.id_dictamen).trigger('change');
}


          // Asignar valores a los campos del formulario
          window.esEdicion = true;// Activar bandera de edición antes de cambiar el dictamen
          $('#edit_id_dictamen').val(datos.id_dictamen).trigger('change');
          $('#edit_num_certificado').val(datos.num_certificado);
          $('#edit_fecha_emision').val(datos.fecha_emision);
          $('#edit_fecha_vigencia').val(datos.fecha_vigencia);
          $('#edit_id_firmante').val(datos.id_firmante).prop('selected', true).change();

//HOLOGRAMAS DINAMICOS (sólo si hay datos)
  const idHologramas = JSON.parse(datos.id_hologramas || '{}');
  const oldHologramas = JSON.parse(datos.old_hologramas || '{}');
  const claves = Object.keys(idHologramas).length > 0 ? Object.keys(idHologramas) : Object.keys(oldHologramas);

  const contenedor = $('#contenedor-lotes-dinamicos-editar');
  contenedor.empty();

  if (claves.length > 0) {
    claves.forEach((clave, i) => {
      let opciones = '';
      opcionesHologramas.forEach(op => {
        opciones += `<option value="${op.valor}">${op.texto}</option>`;
      });

      contenedor.append(`
        <div class="col-md-12">
            <div class="form-floating form-floating-outline mb-6 select2-primary">
                <select class="form-select select2" name="hologramas[${i}][tipo][]" multiple id="edit_holograma_tipo_${i}">
                    ${opciones}
                </select>
                <label for="">Holograma ${i + 1} - tipo</label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-floating form-floating-outline mb-6">
                <input type="text" class="form-control" name="hologramas[${i}][descripcion]" value="${oldHologramas[clave] || ''}" placeholder="Descripción del holograma ${i + 1}">
                <label for="">Holograma ${i + 1} - descripción</label>
            </div>
        </div>
      `);

      const select = $(`#edit_holograma_tipo_${i}`);
      select.select2({
        dropdownParent: $('#ModalEditar')
      });

      if (idHologramas[clave]?.rangos) {
        const valores = idHologramas[clave].rangos.map(r => `${idHologramas[clave].id}|${r.inicial}|${r.final}`);
        setTimeout(() => {
          select.val(valores).trigger('change');
        }, 100);
      }
    });
  } else {
    // Si no hay datos almacenados, forzamos manualmente la generación de campos
    setTimeout(() => {
      $('#edit_id_dictamen').trigger('change');
    }, 300); // da un pequeño tiempo para que el select2 se estabilice
  }
//FIN HOLOGRAMAS DINAMICOS


          flatpickr("#edit_fecha_emision", {//Actualiza flatpickr para mostrar la fecha correcta
            dateFormat: "Y-m-d",
            enableTime: false,
            allowInput: true,
            locale: "es"
          });

          // Mostrar el modal
          $('#ModalEditar').modal('show');
        },
        error: function (error) {
          console.error('Error al cargar los datos:', error);
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al cargar los datos.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Manejar el envío del formulario de edición
    $('#FormEditar').on('submit', function (e) {
      e.preventDefault();
      var formData = $(this).serialize();
      var id_certificado = $('#edit_id_certificado').val();//Obtener el ID del registro desde el campo oculto

      $.ajax({
        url: '/editCerExp/' + id_certificado,
        type: 'PUT',
        data: formData,
        success: function (response) {
          $('#ModalEditar').modal('hide'); // Ocultar el modal de edición
          $('#FormEditar')[0].reset(); // Limpiar el formulario
          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });

          dataTable.ajax.reload(null, false);//Recarga los datos del datatable, "null,false" evita que vuelva al inicio
        },
        error: function (xhr) {
          //error de validación del lado del servidor
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            var errorMessages = Object.keys(errors).map(function (key) {
              return errors[key].join('<br>');
            }).join('<br>');
            /*var errorMessages = Object.values(errors).map(msgArray => 
              msgArray.join('<br>')).join('<br><hr>');*/

            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              html: errorMessages,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          } else {//otro tipo de error
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error al actualizar.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        }
      });
    });

});



  ///REEXPEDIR
  let isLoadingData = false;
  let fieldsValidated = [];
  $(document).ready(function () {

    $(document).on('click', '.reexpedir', function () {
      var id_certificado = $(this).data('id');
      var num_certificado = $(this).data('folio');

      console.log('ID para reexpedir:', id_certificado);
      $('#rex_id_certificado').val(id_certificado);
      $('#tituloreexpedido').html('Reexpedir/Cancelar certificado <span class="badge bg-info">'+num_certificado+'</span>');
      $('#ModalReexpedir').modal('show');
    });

    //funcion fechas
  $('#rex_fecha_emision').on('change', function () {
    var valor = $(this).val();
    if (!valor) {// Si está vacío, también limpiar fecha_vigencia
      $('#rex_fecha_vigencia').val('');
      return; // No seguir ejecutando
    }
    var fechaInicial = new Date(valor);
    fechaInicial.setDate(fechaInicial.getDate() + 90); // +90 días
    var fechaVigencia = fechaInicial.toISOString().split('T')[0];
    $('#rex_fecha_vigencia').val(fechaVigencia);
    flatpickr("#rex_fecha_vigencia", {
      dateFormat: "Y-m-d",
      enableTime: false,
      allowInput: true,
      locale: "es",
      static: true,
      disable: true
    });
  });

    $(document).on('change', '#accion_reexpedir', function () {
      var accionSeleccionada = $(this).val();
      console.log('Acción seleccionada:', accionSeleccionada);
      var id_certificado = $('#rex_id_certificado').val();

      if (accionSeleccionada && !isLoadingData) {
        isLoadingData = true;
        cargarDatosReexpedicion(id_certificado);
      }

      if (accionSeleccionada === '2') {
        $('#campos_condicionales').slideDown();
      } else {
        $('#campos_condicionales').slideUp();
      }
    });

    function cargarDatosReexpedicion(id_certificado) {
      console.log('Cargando datos para la reexpedición con ID:', id_certificado);
      clearFields();

      //cargar los datos
      $.get(`/editCerExp/${id_certificado}/edit`).done(function (datos) {
        console.log('Respuesta completa:', datos);

        if (datos.error) {
          showError(datos.error);
          return;
        }

        $('#rex_id_dictamen').val(datos.id_dictamen).trigger('change');
        $('#rex_numero_certificado').val(datos.num_certificado);
        $('#rex_id_firmante').val(datos.id_firmante).trigger('change');
        $('#rex_fecha_emision').val(datos.fecha_emision);
        $('#rex_fecha_vigencia').val(datos.fecha_vigencia);

        $('#accion_reexpedir').trigger('change');
        isLoadingData = false;

        flatpickr("#rex_fecha_emision", {//Actualiza flatpickr para mostrar la fecha correcta
          dateFormat: "Y-m-d",
          enableTime: false,
          allowInput: true,
          locale: "es"
        });

      }).fail(function () {
        showError('Error al cargar los datos.');
        isLoadingData = false;
      });
    }

    function clearFields() {
      $('#rex_id_dictamen').val('');
      $('#rex_numero_certificado').val('');
      $('#rex_id_firmante').val('');
      $('#rex_fecha_emision').val('');
      $('#rex_fecha_vigencia').val('');
      $('#rex_observaciones').val('');
    }

    function showError(message) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: message,
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
    }

    $('#ModalReexpedir').on('hidden.bs.modal', function () {
      $('#FormReexpedir')[0].reset();
      clearFields();
      $('#campos_condicionales').hide();
      fieldsValidated = [];
    });

    //validar formulario
    const formReexpedir = document.getElementById('FormReexpedir');
    const validatorReexpedir = FormValidation.formValidation(formReexpedir, {
      fields: {
        'accion_reexpedir': {
          validators: {
            notEmpty: {
              message: 'Debes seleccionar una acción.'
            }
          }
        },
        'observaciones': {
          validators: {
            notEmpty: {
              message: 'El motivo de cancelación es obligatorio.'
            }
          }
        },
        'id_dictamen': {
          validators: {
            notEmpty: {
              message: 'El número de dictamen es obligatorio.'
            }
          }
        },
        'num_certificado': {
          validators: {
            notEmpty: {
              message: 'El número de certificado es obligatorio.'
            },
            stringLength: {
              min: 8,
              message: 'Debe tener al menos 8 caracteres.'
            }
          }
        },
        'id_firmante': {
          validators: {
            notEmpty: {
              message: 'El nombre del firmante es obligatorio.'
            }
          }
        },
        'fecha_emision': {
          validators: {
            /*notEmpty: {
              message: 'La fecha de emisión es obligatoria.'
            },*/
            date: {
              format: 'YYYY-MM-DD',
              message: 'Ingresa una fecha válida (yyyy-mm-dd).'
            }
          }
        },
        'fecha_vigencia': {
          validators: {
            /*notEmpty: {
              message: 'La fecha de vigencia es obligatoria.'
            },*/
            date: {
              format: 'YYYY-MM-DD',
              message: 'Ingresa una fecha válida (yyyy-mm-dd).'
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
    }).on('core.form.valid', function () {
      const formData = $(formReexpedir).serialize();

      $.ajax({
        url: $(formReexpedir).attr('action'),
        method: 'POST',
        data: formData,
        success: function (response) {
          $('#ModalReexpedir').modal('hide');
          formReexpedir.reset();

          dt_user_table.DataTable().ajax.reload();
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: response.message,
            customClass: {
              confirmButton: 'btn btn-primary'
            }
          });
        },
        error: function (jqXHR) {
          console.log('Error en la solicitud:', jqXHR);
          let errorMessage = 'No se pudo registrar. Por favor, verifica los datos.';
          try {
            let response = JSON.parse(jqXHR.responseText);
            errorMessage = response.message || errorMessage;
          } catch (e) {
            console.error('Error al parsear la respuesta del servidor:', e);
          }
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: errorMessage,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

  });



  ///FORMATO PDF CERTIFICADO
  $(document).on('click', '.pdfCertificado', function () {
    var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
    var pdfUrl = '/certificado_exportacion/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Certificado de Exportación");
    $("#subtitulo_modal").text("PDF del Certificado");
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  ///FORMATO PDF SOLICITUD CERTIFICADO
  $(document).on('click', '.pdfSolicitudCertificado', function () {
    var id = $(this).data('id');//Obtén el ID desde el atributo "data-id" en PDF
    var pdfUrl = '/solicitud_certificado_exportacion/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Solicitud de emisión de Certificado para Exportación");
    $("#subtitulo_modal").text("PDF de la solicitud");
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  ///FORMATO PDF DICTAMEN
  $(document).on('click', '.pdfDictamen', function () {
    var id = $(this).data('id');
    var pdfUrl = '/dictamen_exportacion/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();
    $("#titulo_modal").text("Dictamen de Cumplimiento para Producto de Exportación");
    $("#subtitulo_modal").text("PDF del Dictamen");
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  ///FORMATO PDF SOLICITUD SERVICIOS
  $(document).on('click', '.pdfSolicitud', function () {
    var id = $(this).data('id');
    var folio = $(this).data('folio');
    var pdfUrl = '/solicitud_de_servicio/' + id; //Ruta del PDF
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', pdfUrl);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', pdfUrl).show();

    $("#titulo_modal").text("Solicitud de servicios");
    $("#subtitulo_modal").html('<p class="solicitud badge bg-primary">' + folio + '</p>');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  ///FORMATO PDF ACTA
  $(document).on('click', '.pdfActa', function () {
    var id_acta = $(this).data('id');
    var empresa = $(this).data('empresa');
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();

    //Cargar el PDF con el ID
    iframe.attr('src', '/files/' + id_acta);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', '/files/' + id_acta).show();

    $("#titulo_modal").text("Acta de inspección");
    $("#subtitulo_modal").text(empresa);

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });



  ///OBTENER REVISORES
  $(document).ready(function () {
    $('#tipoRevisor').on('change', function () {
      var tipoRevisor = $(this).val();
      
      $('#nombreRevisor').empty().append('<option value="">Seleccione un revisor</option>');

      if (tipoRevisor) {
        var tipo = (tipoRevisor === '1') ? 1 : 4;

        $.ajax({
          url: '/ruta-para-obtener-revisores',
          type: 'GET',
          data: { tipo: tipo },
          success: function (response) {

            if (Array.isArray(response) && response.length > 0) {
              response.forEach(function (revisor) {
                $('#nombreRevisor').append('<option value="' + revisor.id + '">' + revisor.name + '</option>');
              });
            } else {
              $('#nombreRevisor').append('<option value="">No hay revisores disponibles</option>');
            }
          },
          error: function (xhr) {
            console.log('Error:', xhr.responseText);
            alert('Error al cargar los revisores. Inténtelo de nuevo.');
          }
        });
      }
    });
  });

  ///ASIGNAR REVISOR
  $('#asignarRevisorForm').hide();

  const form = document.getElementById('asignarRevisorForm');
  const fv2 = FormValidation.formValidation(form, {
    fields: {
      'tipoRevisor': {
        validators: {
          notEmpty: {
            message: 'Debe seleccionar una opción para la revisión.'
          }
        }
      },
      'nombreRevisor': {
        validators: {
          notEmpty: {
            message: 'Debe seleccionar un nombre para el revisor.'
          }
        }
      },
      'numeroRevision': {
        validators: {
          notEmpty: {
            message: 'Debe seleccionar un número de revisión.'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        eleInvalidClass: 'is-invalid',
        rowSelector: '.mb-3'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function (e) {
    var formData = new FormData(form);
    var id_certificado = $('#id_certificado').val();
    var tipoRevisor = $('#tipoRevisor').val();
    var revisorValue = $('#nombreRevisor').val();

    console.log('ID Certificado:', id_certificado);
    console.log('Tipo de Revisor:', tipoRevisor);
    console.log('Valor del Revisor:', revisorValue);

    if (tipoRevisor == '1') {
      formData.append('id_revisor', revisorValue);
      formData.append('id_revisor2', null);
    } else if (tipoRevisor == '2') {
      formData.append('id_revisor2', revisorValue);
      formData.append('id_revisor', null);
    }

    // Añadir otros datos
    formData.append('id_certificado', id_certificado);
    var esCorreccion = $('#esCorreccion').is(':checked') ? 'si' : 'no';
    formData.append('esCorreccion', esCorreccion);

    console.log('FormData:', Array.from(formData.entries()));

    $.ajax({
      url: '/asignar_revisor_exportacion',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $('#asignarRevisorModal').modal('hide');
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.message,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(function () {
          form.reset();
          $('#nombreRevisor').val(null).trigger('change');
          $('#esCorreccion').prop('checked', false);
          fv.resetForm();
          $('.datatables-users').DataTable().ajax.reload();
        });
      },
      error: function (xhr) {
        $('#asignarRevisorModal').modal('hide');
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Revisor asignado exitosamente',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(function () {
          form.reset();
          $('#nombreRevisor').val(null).trigger('change');
          $('#esCorreccion').prop('checked', false);
          fv.resetForm();
          $('.datatables-users').DataTable().ajax.reload();
        });
      }
    });
  });

  $('#nombreRevisor').on('change', function () {
    fv.revalidateField($(this).attr('name'));
  });

  $('#asignarRevisorModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id_certificado = button.data('id');
    var num_certificado = button.data('folio');
    $('#id_certificado').val(id_certificado);
    $('#folio_certificado').html('<span class="badge bg-info">'+num_certificado+'</span>');
    $('#asignarRevisorModalLabel').html('Asignar revisor <span class="badge bg-info">' + num_certificado + '</span>');

    fv.resetForm();
    form.reset();

    $('#asignarRevisorForm').show();
  });






//Abrir PDF Bitacora
$(document).on('click', '.pdf', function () {
  var id_revisor = $(this).data('id');
  var num_certificado = $(this).data('num-certificado');
  var tipoRevision = $(this).data('tipo_revision');
    console.log('ID de la revision:', id_revisor);
    console.log('Tipo revisor OC/consejo:', tipoRevision);//1=OC, 2=Consejo
    console.log('Número Certificado:', num_certificado);
    
    // Definir URL según el tipo de revisión
    if (tipoRevision === 1) {  
      var url_pdf = '../pdf_bitacora_revision_personal/' + id_revisor;
    }else{
      var url_pdf = '../pdf_bitacora_revision_certificado_exportacion/' + id_revisor;
    }

    
    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    $('#cargando').show();
    $('#pdfViewer').hide();

    //Cargar el PDF con el ID
    $('#pdfViewer').attr('src', url_pdf);
    //Abrir PDF en nueva pestaña
    $("#NewPestana").attr('href', url_pdf).show();

    $("#titulo_modal").text("Bitácora de revisión documental");
    $("#subtitulo_modal").html('<span class="badge bg-info">'+num_certificado+'</span>');

    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    $('#pdfViewer').on('load', function () {
      $('#cargando').hide();
      $('#pdfViewer').show();
    });
});
  
///VER TRAZABILIDAD
$(document).on('click', '.trazabilidad', function () {
  var id_certificado = $(this).data('id');
  $('.num_certificado').text($(this).data('folio'));
  var url = '/trazabilidad-certificados/' + id_certificado;

  $.get(url, function (data) {
    if (data.success) {
      var logs = data.logs;
      var contenedor = $('#ListTracking');
      contenedor.empty();

      let voboPersonalHtml = '';
      let voboClienteHtml = '';
      $('<style>')
      .prop('type', 'text/css')
      .html(`
        .border-blue { border: 2px solid #007bff !important; }
        .border-purple { border: 2px solid #6f42c1 !important; }
        .border-danger { border: 2px solid #ff0000 !important; }
      `)
      .appendTo('head');
      

      // Extraemos y guardamos los Vo.Bo. (solo uno de cada)
      logs.forEach(function (log) {
        if (!voboPersonalHtml && log.vobo_personal) {
          voboPersonalHtml = `
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="mt-2 pb-3 border border-blue p-3 rounded">
                <h6 class="text-primary"><i class="ri-user-line me-1"></i> Vo.Bo. del Personal</h6>
                ${log.vobo_personal}
              </div>
            </li><hr>`;
        }
        if (!voboClienteHtml && log.vobo_cliente) {
          voboClienteHtml = `
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-primary"></span>
              <div class="mt-2 pb-3 border border-blue p-3 rounded">
                <h6 class="text-success"><i class="ri-user-line me-1"></i> Revisión del cliente</h6>
                ${log.vobo_cliente}
              </div>
            </li><hr>`;
        }
      });

      // Calculamos el máximo orden_personalizado (aseguramos cubrir hasta 7)
      const maxOrdenLogs = logs.length > 0 ? Math.max(...logs.map(l => l.orden_personalizado)) : 0;
      const maxOrden = Math.max(maxOrdenLogs, 7);

      // Insertar logs en orden y colocar Vo.Bo. en posiciones 4 y 7
      for (let i = 1; i <= maxOrden; i++) {
        logs.forEach(log => {
          if (log.orden_personalizado === i) {
            // Mapeamos el tipo a una clase de color
            let borderClase = '';
            switch (log.tipo_bloque) {
              case 'registro':
                borderClase = 'border-blue';
                break;
              case 'asignacion':
                borderClase = 'border-purple';
                break;
              case 'resultado_positivo':
                borderClase = 'border-primary';
                break;
              case 'resultado_negativo':
                borderClase = 'border-danger';
                break;
              case 'cancelado':
                borderClase = 'border-danger';
                break;
              default:
                borderClase = 'border-secondary';
            }

            contenedor.append(`
              <li class="timeline-item timeline-item-transparent">
                <span class="timeline-point timeline-point-primary"></span>
                <div class="timeline-event border ${borderClase} p-3 rounded">
                  <div class="timeline-header mb-3">
                    <h6 class="mb-0">${log.description}</h6>
                    <small class="text-muted">${log.created_at}</small>
                  </div>
                  <p class="mb-2">${log.contenido}</p>
                  <div class="d-flex align-items-center mb-1">
                    ${log.bitacora} ${log.bitacora2}
                  </div>
                </div>
              </li><hr>
            `);
          }
        });

        // Insertar Vo.Bo. en orden 12 y 23
        if (i === 12 && voboPersonalHtml) {
          contenedor.append(voboPersonalHtml);
        }
        if (i === 23 && voboClienteHtml) {
          contenedor.append(voboClienteHtml);
        }
      }

      $('#ModalTracking').modal('show');
    }
  }).fail(function (xhr) {
    console.error(xhr.responseText);
  });
});






///SUBIR CERTIFICADO FIRMADO
$('#FormCertificadoFirmado').on('submit', function (e) {
  e.preventDefault();
  var formData = new FormData(this);

  $.ajax({
    url: '/certificados/exportacion/documento',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: response.message,
        customClass: {
            confirmButton: 'btn btn-primary'
        }
      });
      $('#ModalCertificadoFirmado').modal('hide');
      $('#FormCertificadoFirmado')[0].reset();
      $('#documentoActual').empty();
      dataTable.ajax.reload(null, false); // Si usas datatables
    },
    error: function (xhr) {

      console.log(xhr.responseText);
      if (xhr.status === 422) {
        // Error de validación
        Swal.fire({
          icon: 'warning',
          title: 'Error al subir',
          text: 'El documento no debe ser mayor a 3MB',
          //footer: `<pre>${xhr.responseText}</pre>`,
          customClass: {
            confirmButton: 'btn btn-warning'
          }
        });
      } else {
        // Otro tipo de error (500, 404, etc.)
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al subir el documento.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
      
    }
  });
      
});
///OBTENER CERTIFICADO FIRMADO
$(document).on('click', '.subirPDF', function () {
  var id = $(this).data('id');
  var num_certificado = $(this).data('folio');
  $('#doc_id_certificado').val(id);
  $('#documentoActual').html('Cargando documento...');
  $('#modalTitulo').html('Certificado exportación firmado <span class="badge bg-info">' +num_certificado+ '</span>');

  $.ajax({
    url: `/certificados/exportacion/documento/${id}`,
    type: 'GET',
    success: function (response) {
      if (response.documento_url && response.nombre_archivo) {
        $('#documentoActual').html(
          `<p>Documento actual: 
            <a href="${response.documento_url}" target="_blank">${response.nombre_archivo}</a>
          </p>`);
      } else {
        $('#documentoActual').html('<p>No hay documento cargado.</p>');
      }
    },
    error: function () {
      $('#documentoActual').html('<p class="text-danger">Error al cargar el documento.</p>');
    }
  });

});



///VER DOCUMENTOS RELACIONADOS
$(document).on('click', '.documentos', function () {
    var id_certificado = $(this).data('id');
    $(".titulo").html('Documentación relacionada al certificado <span class="badge bg-info">' +$(this).data('folio')+ '</span>');
    var url = '/documentos/' + id_certificado;
    const noDisponibleImg = `<a href="/img_pdf/FaltaPDF.png" target="_blank"> 
          <img src="/img_pdf/FaltaPDF.png" height="40" width="40" alt="FaltaPDF"> </a>`;

    $.get(url, function (data) {
        if (data.success) {
            // Concatenar dictamenes (puede haber uno por lote) separados por coma
            let dictamenLinks = data.documentos
                .map(d => d.dictamen)
                .filter(Boolean)
                .map(id => `<a href="/dictamen_envasado/${id}" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>`)
                .join(', ') || noDisponibleImg;

            // Concatenar certificados granel separados por coma
            let certificadoLinks = data.documentos
                .filter(d => d.certificadoGranel && d.clienteOrigen)
                .map(d => `<a href="/files/${d.clienteOrigen}/certificados_granel/${d.certificadoGranel}" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>`)
                .join(', ') || noDisponibleImg;

            // Concatenar FQs separados por coma
            let fqsLinks = data.documentos
                .flatMap(d => (d.fqs || []).map(fq => ({
                    url: fq,
                    clienteOrigen: d.clienteOrigen
                })))
                .filter(d => d.url && d.clienteOrigen)
                .map(d => `<a href="/files/${d.clienteOrigen}/fqs/${d.url}" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>`)
                .join(', ') || noDisponibleImg;

            // Concatenar FQ Ajustes separados por coma
            let fqAjusteLinks = data.documentos
                .flatMap(d => (d.fqs_ajuste || []).map(fq => ({
                    url: fq,
                    clienteOrigen: d.clienteOrigen
                })))
                .filter(d => d.url && d.clienteOrigen)
                .map(d => `<a href="/files/${d.clienteOrigen}/fqs/${d.url}" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>`)
                .join(', ') || noDisponibleImg;

            // Etiqueta, Corrugado y Proforma únicos
            let etiquetasLink = data.etiquetas
                ? `<a href="/files/${data.numeroCliente}/${data.etiquetas}" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>`
                : noDisponibleImg;

            let corrugadoLink = data.corrugado
                ? `<a href="/files/${data.numeroCliente}/${data.corrugado}" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>`
                : noDisponibleImg;

            let proformaLink = data.proforma
                ? `<a href="/storage/uploads/${data.numeroCliente}/${data.proforma}" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>`
                : noDisponibleImg;

            $('#dictamen').html(dictamenLinks);
            $('#certificado').html(certificadoLinks);
            $('#fq').html(fqsLinks);
            $('#fq_ajuste').html(fqAjusteLinks);
            $('#etiquetas').html(etiquetasLink);
            $('#corrugado').html(corrugadoLink);
            $('#proforma').html(proformaLink);

            $('#ModalDocumentos').modal('show');
        }
    }).fail(function (xhr) {
        console.error(xhr.responseText);
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al obtener los documentos.',
            customClass: { confirmButton: 'btn btn-danger' }
        });
    });
});



//OBTENER VISTO BUENO
$(document).on('click', '.VoBo', function () {
    const id_certificado = $(this).data('id');

    $.get(`/certificados/${id_certificado}/vobo`, function (data) {
        const vobo = data.vobo;
        const num_certificado = data.num_certificado;
        const clientes = data.clientes;
        let html = '';

        if (!vobo) {

          let opciones = '';
          clientes.forEach(cliente => {
              opciones += `<option value="${cliente.id}">${cliente.name}</option>`;
          });
          
            html = `
              <div class="col-md-12">
                <div class="form-floating form-floating-outline mb-6">
                  <textarea style="height: 100px;" name="descripcion" class="form-control" required>
Estimado cliente, envío a usted el siguiente pre certificado con codificación ${num_certificado} para su Vo.Bo.</textarea>
                  <label>Descripción:</label>
                </div>
              </div>

              <div class="col-md-12">
              <div class="form-floating form-floating-outline mb-6 select2-primary">
                <select name="notificados[]" class="select2 form-select" multiple required data-placeholder="Selecciona un cliente">
                  ${opciones}
                </select>
                <label>Participantes:</label>
              </div>
            </div>
          `;
        } else {
            const yaExiste = vobo.find(v => v.id_personal);
            if (yaExiste) {
                // Cliente: muestra select de respuesta
                html += `
                  <div class="col-md-12">
                    <div class="form-floating form-floating-outline mb-6">
                      <textarea style="height: 100px;" name="descripcion" class="form-control" required> </textarea>
                      <label>Descripción:</label>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-floating form-floating-outline mb-6">
                      <select name="respuesta" class="form-select" required>
                          <option value=""  selected disabled >Selecciona una opcion</option>
                          <option value="1">Aprobado</option>
                          <option value="2">No aprobado</option>
                      </select>
                      <label>Respuesta:</label>
                    </div>
                  </div>
                `;
            }
        }

        $('#folio_certificado').html('<span class="badge bg-info">'+num_certificado+'</span>');
        $('#contenidoVobo').html(html);
        initializeSelect2($('#contenidoVobo .select2'));
        $('#formVobo input[name="id_certificado"]').val(id_certificado);
        
    });
});
//REGISTRAR VISTO BUENO
$(document).on('submit', '#formVobo', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/certificados/guardar-vobo',
        method: 'POST',
        data: $(this).serialize(),
        
       success: function (response) {
        console.log('Ok.:', response);
        $('#ModalVoBo').modal('hide');

        // Actualizar la tabla sin reinicializar DataTables
        dataTable.ajax.reload();
        // Mostrar alerta de éxito
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.message,
          customClass: {
            confirmButton: 'btn btn-primary'
          }
        });
      },
      error: function (xhr) {
        console.log('Error:', xhr);
        console.log('Error2:', xhr.responseText);
        // Mostrar alerta de error
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
});








});//end-function(jquery)
