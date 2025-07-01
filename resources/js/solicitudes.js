$(function () {
  // Definir la URL base
  var baseUrl = window.location.origin + '/';

  // 1. Declarar primero los filtros
  const filtros = [
    'Muestreo de agave (ART)',
    'Dictaminación de instalaciones',
    'Vigilancia en producción de lote',
    'Muestreo de lote a granel',
    'Vigilancia en el traslado del lote',
    'Emisión de certificado NOM a granel',
    'Inspección ingreso a barrica/ contenedor de vidrio',
    'Inspección de liberación a barrica/contenedor de vidrio',
    'Georreferenciación',
    'Inspección de envasado',
    'Muestreo de lote envasado',
    'Liberación de producto terminado nacional',
    'Pedidos para exportación',
    'Emisión de certificado venta nacional',
    'Revisión de etiquetas'
  ];



  // 2. Generar los botones dinámicamente
  const filtroButtons = filtros.map(filtro => ({
    text: filtro,
    className: 'dropdown-item',
    action: function (e, dt, node, config) {
      dt_instalaciones_table.search(filtro).draw();
      $('.dt-button-collection').hide(); // Ocultar el dropdown al seleccionar
    }
  }));
  filtroButtons.unshift({
    text: '<i class="ri-close-line text-danger me-2"></i>Quitar filtro',
    className: 'dropdown-item text-danger fw-semibold border',
    action: function (e, dt, node, config) {
      dt_instalaciones_table.search('').draw();
      $('.dt-button-collection').hide(); // Ocultar dropdown también
    }
  });


  // Inicializar DataTable
  var dt_instalaciones_table = $('.datatables-solicitudes').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + 'solicitudes-list',
      type: 'GET',
      dataSrc: function (json) {
        /*  console.log(json); */ // Ver los datos en la consola
        return json.data;
      },
      error: function (xhr, error, thrown) {
        console.error('Error en la solicitud Ajax:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un problema al cargar los datos.',
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    },

    columns: [

      { data: '' },
      {
        data: 'folio',
        render: function (data, type, row) {
          return `<span style="font-weight: bold; font-size: 1.1em;">${data}</span>`;
        }
      },
      { data: 'num_servicio' },
      {
        render: function (data, type, full, meta) {
          var $numero_cliente = full['numero_cliente'];
          var $razon_social = full['razon_social'];
          return `
            <div>
              <span  style="font-size:12px;" class="fw-bold">${$numero_cliente}</span><br>
              <small style="font-size:11px;" class="user-email">${$razon_social}</small>
            </div>
          `;
        }
      },
      { data: 'fecha_solicitud' },
      {
        data: 'tipo',
        render: function (data) {
          return `<span class="fw-bold">${data}</span>`;
        }
      },
      {
        data: 'direccion_completa',
        render: function (data, type, row) {
          return `<span style="font-size: 12px;">${data}</span>`; // Tamaño en línea
        }
      },
      { data: 'fecha_visita' },
      { data: 'inspector' },
      {
        data: null,
        render: function (data) {
          switch (data.id_tipo) {
            case 1: //Muestreo de agave
              return `
            <br>
            <span class="fw-bold small">Guías de agave:</span>
            <span class="small"> ${data.guias || 'N/A'}</span>
          `;

            case 2: //Vigilancia en producción de lote
              return `<br><span class="fw-bold small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Nombre del predio:</span><span class="small"> ${data.nombre_predio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Art:</span><span class="small"> ${data.art || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Etapa:</span><span class="small"> ${data.etapa || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha de Corte:</span>
                      <span class="small">${data.fecha_corte || 'N/A'}</span>
                      `;
            case 3:
              return `<br><span class="fw-bold  small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small">${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Certificado de lote:</span><span class="small"> ${data.id_certificado_muestreo || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">%Alc. Vol:</span><span class="small"> ${data.cont_alc || 'N/A'}</span>
                      `;
            case 4:
              return `<br><span class="fw-bold  small">Lote agranel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey_traslado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Volumen actual:</span><span class="small"> ${data.id_vol_actual || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Volumen restante:</span><span class="small"> ${data.id_vol_res || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis_traslado || 'N/A'}</span>
                      `;
            case 5:
              return `<br><span class="fw-bold  small">Envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br><span class="fw-bold  small">Información adicional:</span><span class="small"> ${data.info_adicional || 'N/A'}</span>`;
            case 7:
              return `<br><span class="fw-bold  small">Granel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis_barricada || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.tipo_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha inicio:</span><span class="small"> ${data.fecha_inicio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha término:</span><span class="small"> ${data.fecha_termino || 'N/A'}</span>
                       <br>
                      <span class="fw-bold  small">Volumen ingresado:</span><span class="small"> ${data.volumen_ingresado || 'N/A'}</span>
                      `;
            case 8:
              return `<br><span class="fw-bold  small">Envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">%Alc. Vol:</span><span class="small"> ${data.cont_alc || 'N/A'}</span>
                      `;
            case 9:
              return `<br><span class="fw-bold  small">Granel:</span><span class="small"> ${data.nombre_lote || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Categoría:</span><span class="small"> ${data.id_categoria || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Clase:</span><span class="small"> ${data.id_clase || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.id_tipo_maguey || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Análisis:</span><span class="small"> ${data.analisis || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Tipo:</span><span class="small"> ${data.tipo_lote_lib || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha inicio:</span><span class="small"> ${data.fecha_inicio || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Fecha término:</span><span class="small"> ${data.fecha_termino || 'N/A'}</span>
                      `;
            case 10:
              return `<br><span class="fw-bold small">Punto de reunión:</span><span class="small"> ${data.punto_reunion || 'N/A'}</span>
                      <br>
                      <span class="fw-bold small">Información adicional:</span><span class="small"> ${data.info_adicional || 'N/A'}</span>`;
            case 11:
              return `<br><span class="fw-bold  small">Envasado:</span><span class="small"> ${data.id_lote_envasado || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Granel:</span><span class="small"> ${data.lote_granel || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Marca:</span><span class="small"> ${data.marca || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Cont. Neto.:</span><span class="small"> ${data.presentacion || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Cajas:</span><span class="small"> ${data.cajas || 'N/A'}</span>
                      <br>
                      <span class="fw-bold  small">Botellas:</span><span class="small"> ${data.botellas || 'N/A'}</span>
                       <br>
                       <span class="fw-bold  small">Proforma:</span><span class="small"> ${data.no_pedido || 'N/A'}</span>
                       <br>
                      <span class="fw-bold  small">Certificado:</span><span class="small"> ${data.certificado_exportacion || 'N/A'}</span>
                       ${data.combinado}`;
            case 14:
              return `<span class="fw-bold  small">
                  ${data.renovacion === 'si' ? 'Es renovación' : 'No es renovación'}
              </span>`;

            default:
              return `<br><span class="fw-bold text-dark small">Información no disponible</span>`;
          }
        }
      },
      { data: 'fecha_servicio' },
      { data: '' },
      {
        data: 'estatus',
        render: function (data, type, row) {
          // Define las etiquetas para cada estado
          let estatus_validado_oc = 'bg-warning';
          let estatus_validado_ui = 'bg-warning';
          if (row.estatus_validado_oc == 'Validada') {
            estatus_validado_oc = 'bg-success';
          }
          if (row.estatus_validado_oc == 'Rechazada') {
            estatus_validado_oc = 'bg-danger';
          }

          if (row.estatus_validado_ui == 'Validada') {
            estatus_validado_ui = 'bg-success';
          }
          if (row.estatus_validado_ui == 'Rechazada') {
            estatus_validado_ui = 'bg-danger';
          }
          return `<span class="badge bg-warning mb-1">${data}</span><br>
            <span class="badge ${estatus_validado_oc} mb-1">${row.estatus_validado_oc} por oc</span><br>
            <span class="badge ${estatus_validado_ui}">${row.estatus_validado_ui} por ui</span>`;


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
        targets: 1,
        searchable: false,
        orderable: false,
      },
      {
        targets: 2,
        searchable: false,
        orderable: false,
      },
      {
        targets: 3,
        responsivePriority: 4,
        orderable: false,
      },
      {
        targets: 4,
        searchable: false,
        orderable: false,
      },
      {
        targets: 5,
        searchable: false,
        orderable: false,
      },
      {
        // User full name
        targets: 8,
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
            '<a href="#" class="text-truncate text-heading"><span style="font-size: 12px;" class="fw-medium">' +
            $name +
            '</span></a>' +
            '</div>' +
            '</div>';
          return $row_output;
        }
      },
      {
        targets: 9,
        searchable: false,
        orderable: false,
      },
      {
        targets: 11,
        className: 'text-center',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          return `<i style class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-id="${full['id_solicitud']}" data-registro="${full['folio']}"></i>`;
        }
      },
      {
        targets: 12, // o el índice correcto de la columna 'estatus'
        orderable: false,
        searchable: false
      },
      {
        // Acciones
        targets: -1,
        title: 'Acciones',
        searchable: false,
        orderable: false,
        render: function (data, type, full, meta) {
          let dropdown = `
                <div class="d-flex align-items-center gap-50">
                  <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end m-0">
                    <a data-id="${full['id']}" data-bs-toggle="modal" onclick="abrirModalTrazabilidad(${full['id_solicitud']}, '${full['tipo']}', '${full['razon_social']}')" href="javascript:;" class="cursor-pointer dropdown-item validar-solicitud2">
                      <i class="text-warning ri-user-search-fill"></i> Trazabilidad
                    </a>`;

          // Si puede agregar usuario, incluir opción adicional
          if (puedeValidarSolicitud) {
            dropdown += `
                  <a
                    data-id="${full['id_tipo']}"
                    data-id-solicitud="${full['id_solicitud']}"
                    data-tipo="${full['tipo']}"
                    data-razon-social="${full['razon_social']}"
                    data-bs-toggle="modal"
                    data-bs-target="#addSolicitudValidar"
                    class="dropdown-item text-dark waves-effect validar-solicitudes">
                    <i class="text-success ri-search-eye-line"></i> Validar solicitud
                  </a>`;
          }

          if (puedeEditarSolicitud) {
            dropdown += `
                  <a
                    data-id="${full['id']}"
                    data-id-solicitud="${full['id_solicitud']}"
                    data-tipo="${full['tipo']}"
                    data-id-tipo="${full['id_tipo']}"
                    data-razon-social="${full['razon_social']}"
                    class="cursor-pointer dropdown-item text-dark edit-record-tipo">
                    <i class="text-warning ri-edit-fill"></i> Editar
                  </a>`;
          }
          if (puedeEliminarSolicitud) {
            dropdown += `
                    <a data-id="${full['id']}" data-id-solicitud="${full['id_solicitud']}" class="dropdown-item text-danger delete-recordes cursor-pointer">
                      <i class="ri-delete-bin-7-line ri-20px text-danger"></i> Eliminar
                    </a>`;
          }

          dropdown += `
                  </div>
                </div>`;

          return dropdown;
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
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior'
      }
    },
    buttons: [
      {
        extend: 'collection',
        className: 'btn btn-outline-primary dropdown-toggle me-4 waves-effect waves-light',
        text: '<i class="ri-filter-line ri-16px me-2"></i><span class="d-none d-sm-inline-block">Filtrar</span>',
        buttons: filtroButtons
      },
      {
        text: '<i class="ri-file-excel-2-fill ri-16px me-0 me-md-2 align-baseline"></i><span class="d-none d-sm-inline-block">Exportar Excel</span>',
        className: 'btn btn-info waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4  mt-md-0',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#exportarExcel'
        }
      },
      {
        text: '<i class="ri-add-line ri-16px me-0 me-md-2 align-baseline"></i><span class="d-none d-sm-inline-block">Nueva solicitud</span>',
        className: 'add-new btn btn-primary waves-effect waves-light me-2 mb-2 mb-sm-2 mt-4  mt-md-0',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-dismiss': 'modal',
          'data-bs-target': '#verSolicitudes'
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


  var dt_user_table = $('.datatables-solicitudes'),
    select2Elements = $('.select2');

  // Función para inicializar Select2 en elementos específicos
  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      select2Focus($this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        language: 'es',
      });
    });
  }

  initializeSelect2(select2Elements);
  //funcion para los datepickers formato año/mes/dia
  $(document).ready(function () {
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es'
    });
  });


  // Configuración CSRF para Laravel
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Eliminar registro
  $(document).on('click', '.delete-recordes', function () {
    var id_solicitudes = $(this).data('id-solicitud');
    console.log(id_solicitudes);
    $('.modal').modal('hide');

    // Confirmación con SweetAlert
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
      html: `
        <label for="delete-reason" style="margin-bottom: 5px;">Escriba el motivo de la eliminación:</label>
        <input id="delete-reason" class="swal2-input" placeholder="Escriba el motivo de la eliminación" required>
      `,
      preConfirm: () => {
        const reason = Swal.getPopup().querySelector('#delete-reason').value;
        if (!reason) {
          Swal.showValidationMessage('Debe proporcionar un motivo para eliminar');
          return false;
        }
        return reason; // Devuelve el motivo si es válido
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        const reason = result.value; // El motivo ingresado por el usuario
        // Solicitud de eliminación
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}solicitudes-lista/${id_solicitudes}`, // Ajusta la URL aquí
          data: { reason: reason }, // Envía el motivo al servidor si es necesario
          success: function () {
            dt_instalaciones_table.ajax.reload();
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
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'La solicitud no ha sido eliminada',
          icon: 'info',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  $(document).on('click', '.open-modal', function () {
    // Ocultar el modal antes de abrir
    $('.modal').modal('hide');

    var id_solicitud = $('.id_solicitud').text(); // Extrae el texto de ID Solicitud
    var tipo = $('.tiposs').text(); // Extrae el texto del Tipo
    console.log(id_solicitud);
    console.log(tipo);

    // Verificar si el tipo es igual a 3
    if (tipo === "3") {
      var url = 'Etiqueta-2401ESPTOB';  // URL de la ruta

      var iframe = $('#pdfViewerDictamen1');
      var spinner = $('#loading-spinner1');  // Spinner
      spinner.show();
      iframe.hide();

      // Asegurarse de que la URL esté bien formada
      iframe.attr('src', url + '/' + id_solicitud);    // Concatenar la URL con el ID de la solicitud

      // Configurar el botón para abrir el PDF en una nueva pestaña
      $('#openPdfBtnDictamen1')
        .attr('href', url + '/' + id_solicitud)
        .show();

      // Configuración del título y subtítulo del modal
      $('#titulo_modal_Dictamen1').text('Etiquetas');

      // Obtener el texto del título de la solicitud
      var solicitudTitleText = $('#solicitud_title').text().trim();
      $('#subtitulo_modal_Dictamen1').html('<p class="solicitud badge bg-primary"> ' + solicitudTitleText + '</p>');

      // Mostrar el modal
      $('#modalDictamen').modal('show');

      // Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
      iframe.on('load', function () {
        console.log('PDF cargado en el iframe.');
        spinner.hide();
        iframe.show();
      });
    } else {
      console.log("El tipo no es 3. No se cargará el PDF.");
    }
  });



  $(document).on('click', '.expediente-record', function () {
    // Accediendo a los valores de los atributos data-
    var id = $(this).data('id');
    var id_solicitud = $(this).data('id-solicitud');
    var tipo = $(this).data('tipo');
    var id_tipo = $(this).data('id-tipo');
    var razon_social = $(this).data('razon-social');

    // Ahora puedes hacer lo que necesites con estos valores
    /*   console.log("ID:", id);
      console.log("ID Solicitud:", id_solicitud);
      console.log("Tipo:", tipo);
      console.log("ID Tipo:", id_tipo);
      console.log("Razón Social:", razon_social); */

    $('#expedienteServicio .id_solicitud').text(id_solicitud);
    $('#expedienteServicio .tiposs').text(id_tipo);
    // Aquí puedes utilizar estos datos para abrir un modal, hacer una solicitud AJAX, etc.
    abrirModal(id_solicitud, tipo, razon_social);
  });





  $(document).ready(function () {
    $(document).on('click', '.edit-record-tipo', function () {
      // Obtenemos los datos del botón
      const id_solicitud = $(this).data('id-solicitud');
      const id_tipo = parseInt($(this).data('id-tipo')); // Convertir a número

      // Cierra cualquier modal u offcanvas visible
      $('.modal').modal('hide');

      // Variables para el modal
      let modal = null;

      // Validamos el tipo y configuramos el modal correspondiente
      if (id_tipo === 1) {
        modal = $('#editSolicitudMuestreoAgave');
      } else if (id_tipo === 2) {
        modal = $('#editVigilanciaProduccion');
      } else if (id_tipo === 3) {
        modal = $('#editMuestreoLoteAgranel');
      } else if (id_tipo === 4) {
        modal = $('#editVigilanciaTraslado');
      } else if (id_tipo === 5) {
        modal = $('#editInspeccionEnvasado');
      } else if (id_tipo === 7) {
        modal = $('#editInspeccionIngresoBarricada');
      } else if (id_tipo === 8) {
        modal = $('#editLiberacionProducto');
      } else if (id_tipo === 9) {
        modal = $('#editInspeccionLiberacion');
      } else if (id_tipo === 10) {
        modal = $('#editClienteModalTipo10');
      } else if (id_tipo === 11) {
        modal = $('#editPedidoExportacion');
      } else if (id_tipo === 13) {
        modal = $('#editSolicitudEmisionCertificado');
      } else if (id_tipo === 14) {
        modal = $('#editSolicitudDictamen');
      } else {
        console.error('Tipo no válido:', id_tipo);
        return; // Salimos si el tipo no es válido
      }

      // Hacemos la solicitud para obtener los datos
      $.ajax({
        url: `/datos-solicitud/${id_solicitud}`, // Ruta única
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          if (response.success) {
            // Rellenar campos según el tipo de modal
            const datos = response.data;

            $('.solicitud').text(datos.folio);
            if (id_tipo === 1) {
              modal.find('#edit_id_solicitud_muestr').val(id_solicitud);
              modal.find('#id_empresa_muestr').val(response.data.id_empresa).trigger('change');
              modal.find('#fecha_visita_muestr').val(response.data.fecha_visita);
              modal.find('#id_instalacion_dic23').data('selected', response.data.id_instalacion);

              if (response.caracteristicas && response.caracteristicas.id_guia) {
                modal.find('#edit_id_guiass').data('selected', response.caracteristicas.id_guia);
              } else {
                modal.find('#edit_id_guiass').val('');
              }
              modal.find('#edit_info_adicional_muestr').val(response.data.info_adicional);
            }

            if (id_tipo === 2) {
              modal.find('#edit_id_solicitud_vig').val(id_solicitud);
              modal.find('#edit_id_empresa_vig').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita_vig').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_vig').data('selected', response.data.id_instalacion);
              modal.find('.linksGuias').html('');
              if (response.documentos && Array.isArray(response.documentos)) {
                const numeroCliente = response.numero_cliente;

                const guias = response.documentos.filter(doc => doc.id_documento === 71);

                if (guias.length > 0) {
                  guias.forEach(doc => {
                    const url = `/storage/uploads/${numeroCliente}/${doc.url}`;
                    const linkHtml = `<a href="${url}" target="_blank" class="d-block text-end mb-1">
                      <i class="ri-file-check-fill me-1"></i> ${doc.url}
                    </a>`;
                    modal.find('.linksGuias').append(linkHtml);
                  });
                } else {
                  modal.find('.linksGuias').html('<div class="text-muted text-end me-6">Sin guías de traslado</div>');
                }
              } else {
                modal.find('.linksGuias').html('<div class="text-muted text-end me-6">Sin guías de traslado</div>');
              }
              if (response.caracteristicas && response.caracteristicas.nombre_produccion) {
                modal.find('#edit_nombre_produccion').val(response.caracteristicas.nombre_produccion);
              } else {
                modal.find('#edit_nombre_produccion').val('');
              }
              if (response.caracteristicas && response.caracteristicas.etapa_proceso) {
                modal.find('#edit_etapa_proceso').val(response.caracteristicas.etapa_proceso);
              } else {
                modal.find('#edit_etapa_proceso').val('');
              }
              if (response.caracteristicas && response.caracteristicas.cantidad_pinas) {
                modal.find('#edit_cantidad_pinas').val(response.caracteristicas.cantidad_pinas);
              } else {
                modal.find('#edit_cantidad_pinas').val('');
              }
              modal.find('#edit_info_adicional_vig').val(response.data.info_adicional);
              //Muestreo lote a granel
            } else if (id_tipo === 3) {
              modal.find('#edit_id_solicitud_muestreo').val(id_solicitud);
              modal.find('#edit_id_empresa_muestreo').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_muestreo').data('selected', response.data.id_instalacion);

              if (response.caracteristicas && response.caracteristicas.id_lote_granel) {
                modal.find('#edit_id_lote_granel_muestreo').data('selected', response.caracteristicas.id_lote_granel).trigger('change');
              } else {
                modal.find('#edit_id_lote_granel_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.tipo_analisis) {
                modal.find('#edit_destino_lote').val(response.caracteristicas.tipo_analisis).trigger('change');
              } else {
                modal.find('#edit_destino_lote').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_categoria_muestreo) {
                modal.find('#edit_id_categoria_muestreo_id').val(response.caracteristicas.id_categoria_muestreo);
              } else {
                modal.find('#edit_id_categoria_muestreo_id').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_clase_muestreo) {
                modal.find('#edit_id_clase_muestreo_id').val(response.caracteristicas.id_clase_muestreo);
              } else {
                modal.find('#edit_id_clase_muestreo_id').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_tipo_maguey_muestreo) {
                modal.find('#edit_id_tipo_maguey_muestreo_ids').val(response.caracteristicas.id_tipo_maguey_muestreo);
              } else {
                modal.find('#edit_id_tipo_maguey_muestreo_ids').val('');
              }
              if (response.caracteristicas) {
                // Categoría
                modal.find('#edit_id_categoria_muestreo').val(response.caracteristicas.categoria || 'N/A');

                // Clase
                modal.find('#edit_id_clase_muestreo').val(response.caracteristicas.clase || 'N/A');
                // Tipos de Maguey
                modal.find('#edit_id_tipo_maguey_muestreo').val(
                  response.caracteristicas.nombre.join(', ') || 'N/A'
                );
              }
              if (response.caracteristicas && response.caracteristicas.analisis_muestreo) {
                modal.find('#edit_analisis_muestreo').val(response.caracteristicas.analisis_muestreo);
              } else {
                modal.find('#edit_analisis_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.volumen_muestreo) {
                modal.find('#edit_volumen_muestreo').val(response.caracteristicas.volumen_muestreo);
              } else {
                modal.find('#edit_volumen_muestreo').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_certificado_muestreo) {
                modal.find('#edit_id_certificado_muestreo').val(response.caracteristicas.id_certificado_muestreo);
              } else {
                modal.find('#edit_id_certificado_muestreo').val('');
              }
              modal.find('#edit_info_adicional').val(response.data.info_adicional);
              //Vigilancia solicitud de vigilancia traslado lotes
            } else if (id_tipo === 4) {
              modal.find('#edit_id_solicitud_traslado').val(id_solicitud);
              modal.find('#edit_id_empresa_traslado').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_traslado').data('selected', response.data.id_instalacion);
              modal.find('#instalacion_id_traslado').val(response.data.id_instalacion);


              if (response.caracteristicas) {
                modal.find('#lote_id_traslado').val(response.caracteristicas.id_lote_granel || '');
                modal.find('#edit_id_lote_granel_traslado').val(response.caracteristicas.id_lote_granel || '');
                modal.find('#edit_id_categoria_traslado').val(response.caracteristicas.id_categoria_traslado || '');
                modal.find('#edit_id_clase_traslado').val(response.caracteristicas.id_clase_traslado || '');
                modal.find('#edit_id_tipo_maguey_traslado').val(response.caracteristicas.id_tipo_maguey_traslado || '');
                modal.find('#edit_id_salida').val(response.caracteristicas.id_salida || '');
                modal.find('#edit_id_contenedor').val(response.caracteristicas.id_contenedor || '');
                modal.find('#edit_id_sobrante').val(response.caracteristicas.id_sobrante || '');
                modal.find('#edit_id_vol_actual').val(response.caracteristicas.id_vol_actual || '');
                modal.find('#edit_id_vol_traslado').val(response.caracteristicas.id_vol_traslado || '');
                modal.find('#edit_id_vol_res').val(response.caracteristicas.id_vol_res || '');
                modal.find('#edit_analisis_traslado').val(response.caracteristicas.analisis_traslado || '');
                modal.find('#edit_volumen_traslado').val(response.caracteristicas.volumen_traslado || '');
                modal.find('#edit_id_certificado_traslado').val(response.caracteristicas.id_certificado_traslado || '');
              }

              if (response.caracteristicas && response.caracteristicas.instalacion_vigilancia) {
                modal
                  .find('#edit_instalacion_vigilancia')
                  .val(response.caracteristicas.instalacion_vigilancia) // Establece el valor
                  .trigger('change'); // Asegúrate de que select2 lo actualice visualmente
              } else {
                modal.find('#edit_instalacion_vigilancia').val('').trigger('change');
              }

              modal.find('#edit_info_adicional').val(response.data.info_adicional);
            } else if (id_tipo === 5) {
              modal.find('#edit_id_solicitud_inspeccion').val(id_solicitud);
              modal.find('#edit_id_empresa_inspeccion').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_inspeccion').data('selected', response.data.id_instalacion);

              if (response.caracteristicas && response.caracteristicas.id_lote_envasado) {
                modal.find('#edit_id_lote_envasado_inspeccion').data('selected', response.caracteristicas.id_lote_envasado);
              } else {
                modal.find('#edit_id_lote_envasado_inspeccion').val('');
              }
              /*               if (response.caracteristicas && response.caracteristicas.id_categoria_inspeccion) {
                              modal.find('#edit_id_categoria_inspeccion').val(response.caracteristicas.id_categoria_inspeccion);
                            } else {
                              modal.find('#edit_id_categoria_inspeccion').val('');
                            }
                            if (response.caracteristicas && response.caracteristicas.id_clase_inspeccion) {
                              modal.find('#edit_id_clase_inspeccion').val(response.caracteristicas.id_clase_inspeccion);
                            } else {
                              modal.find('#edit_id_clase_inspeccion').val('');
                            }
                            if (response.caracteristicas && response.caracteristicas.id_tipo_maguey_inspeccion) {
                              modal.find('#edit_id_tipo_maguey_inspeccion').val(response.caracteristicas.id_tipo_maguey_inspeccion);
                            } else {
                              modal.find('#edit_id_tipo_maguey_inspeccion').val('');
                            }
                            if (response.caracteristicas && response.caracteristicas.id_marca) {
                              modal.find('#edit_id_marca').val(response.caracteristicas.id_marca);
                            } else {
                              modal.find('#edit_id_marca').val('');
                            }
                            if (response.caracteristicas && response.caracteristicas.volumen_inspeccion) {
                              modal.find('#edit_volumen_inspeccion').val(response.caracteristicas.volumen_inspeccion);
                            } else {
                              modal.find('#edit_volumen_inspeccion').val('');
                            }
                            if (response.caracteristicas && response.caracteristicas.analisis_inspeccion) {
                              modal.find('#edit_analisis_inspeccion').val(response.caracteristicas.analisis_inspeccion);
                            } else {
                              modal.find('#edit_analisis_inspeccion').val('');
                            }
                            if (response.caracteristicas && response.caracteristicas.id_tipo_inspeccion) {
                              modal.find('#edit_id_tipo_inspeccion').val(response.caracteristicas.id_tipo_inspeccion);
                            } else {
                              modal.find('#edit_id_tipo_inspeccion').val('');
                            }
                            if (response.caracteristicas && response.caracteristicas.id_cantidad_bote) {
                              modal.find('#edit_id_cantidad_bote').val(response.caracteristicas.id_cantidad_bote);
                            } else {
                              modal.find('#edit_id_cantidad_bote').val('');
                            } */
              if (response.caracteristicas && response.caracteristicas.cantidad_caja) {
                modal.find('#edit_id_cantidad_caja').val(response.caracteristicas.cantidad_caja);
              } else {
                modal.find('#edit_id_cantidad_caja').val('');
              }
              if (response.caracteristicas && response.caracteristicas.fecha_inicio) {
                modal.find('#edit_id_inicio_envasado').val(response.caracteristicas.fecha_inicio);
              } else {
                modal.find('#edit_id_inicio_envasado').val('');
              }
              if (response.caracteristicas && response.caracteristicas.fecha_fin) {
                modal.find('#edit_id_previsto').val(response.caracteristicas.fecha_fin);
              } else {
                modal.find('#edit_id_previsto').val('');
              }
              if (response.caracteristicas && response.caracteristicas.id_certificado_inspeccion) {
                modal.find('#edit_id_certificado_inspeccion').val(response.caracteristicas.id_certificado_inspeccion);
              } else {
                modal.find('#edit_id_certificado_inspeccion').val('');
              }
              modal.find('#edit_info_adicional').val(response.data.info_adicional);
              //Inspeccion ingreso barricada
            } else if (id_tipo === 7) {
              modal.find('#edit_id_solicitud_barricada').val(id_solicitud);
              modal.find('#edit_id_empresa_barricada').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_barricada').data('selected', response.data.id_instalacion);
              modal.find('#instalacion_ingreso').val(response.data.id_instalacion);
              modal.find('#lote_ingreso').val(response.caracteristicas?.id_lote_granel || '');

              if (response.caracteristicas) {
                modal.find('#edit_id_lote_granel_barricada').val(response.caracteristicas.id_lote_granel || '');
                modal.find('#edit_id_categoria_barricada_id').val(response.caracteristicas.id_categoria || '');
                modal.find('#edit_id_categoria_barricada').val(response.caracteristicas.categoria || '');
                modal.find('#edit_id_clase_barricada_id').val(response.caracteristicas.id_clase || '');
                modal.find('#edit_id_clase_barricada').val(response.caracteristicas.clase || '');
                modal.find('#edit_id_tipo_maguey_barricada_ids').val(response.caracteristicas.id_tipo_maguey || '');
                modal.find('#edit_id_tipo_maguey_barricada').val(
                  response.caracteristicas.nombre.join(', ') || 'N/A'
                );
                modal.find('#edit_volumen_ingresado').val(response.caracteristicas.volumen_ingresado || '');
                modal.find('#edit_analisis_barricada').val(response.caracteristicas.analisis || '');
                modal.find('#edit_alc_vol_barrica').val(response.caracteristicas.cont_alc || '');
                modal.find('#edit_tipo_lote').val(response.caracteristicas.tipoIngreso || '');
                modal.find('#edit_fecha_inicio').val(response.caracteristicas.fecha_inicio || '');
                modal.find('#edit_fecha_termino').val(response.caracteristicas.fecha_termino || '');
                modal.find('#edit_material').val(response.caracteristicas.material || '');
                modal.find('#edit_capacidad').val(response.caracteristicas.capacidad || '');
                modal.find('#edit_num_recipientes').val(response.caracteristicas.num_recipientes || '');
                modal.find('#edit_tiempo_maduracion').val(response.caracteristicas.tiempo_maduracion || '');
                modal.find('#edit_id_certificado_barricada').val(response.caracteristicas.id_certificado || '');
              }

              modal.find('#edit_info_adicional').val(response.data.info_adicional);

              //liberacion inspeccion
            }
            else if (id_tipo === 8) {
              modal.find('#edit_id_solicitud_liberacion_terminado').val(id_solicitud);
              modal.find('#edit_id_empresa_solicitud_lib_ter').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_liberacion_terminado').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_lib_ter').data('selected', response.data.id_instalacion).trigger('change');

              if (response.caracteristicas) {
                modal.find('#edit_id_lote_envasado_lib_ter').data('selected', response.caracteristicas.id_lote_envasado || '');
                modal.find('#edit_id_categoria_lib_ter').val(response.caracteristicas.categoria || '');
                modal.find('#edit_id_clase_lib_ter').val(response.caracteristicas.clase || '');
                modal.find('#edit_id_tipo_maguey_lib_ter').val(response.caracteristicas.nombre || '');
                modal.find('#edit_marca_lib_ter').val(response.caracteristicas.marca || '');
                modal.find('#edit_porcentaje_alcohol_lib_ter').val(response.caracteristicas.cont_alc || '');
                modal.find('#edit_analisis_fisiq_lib_ter').val(response.caracteristicas.analisis || '');
                modal.find('#edit_can_botellas_lib_ter').val(response.caracteristicas.cantidad_botellas || '');
                modal.find('#edit_presentacion_lib_ter').val(response.caracteristicas.presentacion || '');
                modal.find('#edit_can_pallets_lib_ter').val(response.caracteristicas.cantidad_pallets || '');
                modal.find('#edit_cajas_por_pallet_lib_ter').val(response.caracteristicas.cajas_por_pallet || '');
                modal.find('#edit_botellas_por_caja_lib_ter').val(response.caracteristicas.botellas_por_caja || '');
                modal.find('#edit_hologramas_utilizados_lib_ter').val(response.caracteristicas.hologramas_utilizados || '');
                modal.find('#edit_hologramas_mermas_lib_ter').val(response.caracteristicas.hologramas_mermas || '');
                modal.find('#edit_certificado_nom_granel_lib_ter').val(response.caracteristicas.certificado_nom_granel || '');
              }

              modal.find('#edit_comentarios_lib_ter').val(response.data.info_adicional);
            }
            else if (id_tipo === 9) {
              modal.find('#edit_id_solicitud_liberacion').val(id_solicitud);
              modal.find('#edit_id_empresa_liberacion').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_liberacion').data('selected', response.data.id_instalacion);

              // Mapeo de campos de `caracteristicas` a los inputs correspondientes
              const fields = {
                id_lote_granel: '#edit_id_lote_granel_liberacion',
                id_categoria: '#edit_id_categoria_liberacion_id',
                categoria: '#edit_id_categoria_liberacion',
                id_clase: '#edit_id_clase_liberacion_id',
                clase: '#edit_id_clase_liberacion',
                id_tipo_maguey: '#edit_id_tipo_maguey_liberacion_ids',
                nombre: '#edit_id_tipo_maguey_liberacion',
                edad: '#edit_id_edad_liberacion',
                analisis: '#edit_analisis_liberacion',
                cont_alc: '#edit_volumen_liberacion',
                tipoLiberacion: '#edit_tipo_lote_lib',
                fecha_inicio: '#edit_fecha_inicio_lib',
                fecha_termino: '#edit_fecha_termino_lib',
                material: '#edit_material_liberacion',
                capacidad: '#edit_capacidad_liberacion',
                num_recipientes: '#edit_num_recipientes_lib',
                tiempo_dura: '#edit_tiempo_dura_lib',
                id_certificado: '#edit_id_certificado_liberacion'
              };

              // Iterar sobre el mapeo y asignar valores
              Object.entries(fields).forEach(([key, selector]) => {
                const value = response.caracteristicas?.[key] || ''; // Asignar '' si no existe
                modal.find(selector).val(value);
              });

              modal.find('#edit_info_adicional').val(response.data.info_adicional || '');
            }
            else if (id_tipo === 10) {
              modal.find('#id_solicitud_geo').val(id_solicitud);
              modal.find('#edit_id_empresa_geo').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita_geo').val(response.data.fecha_visita);
              modal.find('#edit_id_predio_geo').data('selected', response.data.id_predio);
              // Acceder al campo `punto_reunion` desde `caracteristicas`
              if (response.caracteristicas && response.caracteristicas.punto_reunion) {
                modal.find('#edit_punto_reunion_geo').val(response.caracteristicas.punto_reunion);
              } else {
                modal.find('#edit_punto_reunion_geo').val(''); // Si no existe, deja vacío
              }
              modal.find('#edit_info_adicional_geo').val(response.data.info_adicional);
              // Otros campos específicos para tipo 10
            }
            else if (id_tipo === 11) {
              modal.find('#id_empresa_solicitud_exportacion_edit').val(response.data.id_empresa).trigger('change');
              modal.find('.id_solicitud').val(id_solicitud);
              modal.find('#fecha_visita_edit_exportacion').val(response.data.fecha_visita);
              modal.find('.instalacion_id').val(response.data.id_instalacion);

              if (response.caracteristicas) {
                modal.find('#tipo_solicitud_edit').val(response.caracteristicas.tipo_solicitud).trigger('change');
                modal.find('.direccion_id').val(response.caracteristicas.direccion_destinatario);
                modal.find('.aduana_salida').val(response.caracteristicas.aduana_salida).trigger('change');
                modal.find('.no_pedido').val(response.caracteristicas.no_pedido);
                modal.find('.instalacion_envasado_id').val(response.caracteristicas.id_instalacion_envasado);
                modal.find('#direccion_destinatario_ex_edit').val(response.caracteristicas.id_instalacion_envasado).trigger('change');

                modal.find('.etiqueta_id').val(response.caracteristicas.id_etiqueta);

                var lotesEnvasado = response.caracteristicas.detalles.map(function (detalle) {
                  return detalle.id_lote_envasado;
                });
                // Mostrar Factura Proforma
                let facturaProforma = null;
                let facturaProformaCont = null;
                var numeroCliente = response.numero_cliente;

                if (response.documentos && Array.isArray(response.documentos)) {
                  facturaProforma = response.documentos.find(
                    doc => doc.nombre_documento && doc.nombre_documento.toLowerCase().includes('proforma') && !doc.nombre_documento.toLowerCase().includes('continuación')
                  );
                  facturaProformaCont = response.documentos.find(
                    doc => doc.nombre_documento && doc.nombre_documento.toLowerCase().includes('continuación')
                  );
                }

                if (facturaProforma && facturaProforma.url) {
                  $('#factura_proforma_display').html(
                    'Factura actual: <a href="/storage/uploads/' + numeroCliente + '/' + facturaProforma.url + '" target="_blank">' + facturaProforma.url + '</a>'
                  );
                } else {
                  $('#factura_proforma_display').html('<span class="text-danger">No hay factura proforma.</span>');
                }

                if (facturaProformaCont && facturaProformaCont.url) {
                  $('#factura_proforma_cont_display').html(
                    'Factura (Continuación) actual: <a href="/storage/uploads/' + numeroCliente + '/' + facturaProformaCont.url + '" target="_blank">' + facturaProformaCont.url + '</a>'
                  );
                } else {
                  $('#factura_proforma_cont_display').html('<span class="text-danger">No hay factura proforma (continuación).</span>');
                }

                modal.find('.lote_envasado_id').val(lotesEnvasado.join(','));

                var cantidadDeLotes = response.caracteristicas.detalles.length;

                if (cantidadDeLotes === 1) {
                  $('#sections-container2').not(':first').remove();
                  modal.find('#cantidad_cajas_edit0').val(response.caracteristicas.detalles[0].cantidad_cajas);
                  modal.find('#cantidad_botellas_edit0').val(response.caracteristicas.detalles[0].cantidad_botellas);
                  modal.find('#presentacion_edit0').val(response.caracteristicas.detalles[0].presentacion || '');
                  modal.find('#lote_granel_edit_0').val(response.caracteristicas.detalles[0].lote_granel || '');
                  modal.find('#lote_envasado_edit_0').data('selected', response.caracteristicas.detalles[0].id_lote_envasado).trigger('change');
                  let idLoteEnvasado = response.caracteristicas.detalles[0].id_lote_envasado;
                  cargarDetallesLoteEnvasadoEdit(idLoteEnvasado);
                } else {
                  for (var i = 1; i < cantidadDeLotes; i++) {
                    $('#add-characteristics_edit').click();
                    // Primero actualiza el índice 0 (parece error: debería ser i)
                    modal.find(`#2cantidad_cajas_edit0`).val(response.caracteristicas.detalles[0].cantidad_cajas);
                    modal.find(`#2cantidad_botellas_edit0`).val(response.caracteristicas.detalles[0].cantidad_botellas);
                    modal.find(`#2presentacion_edit0`).val(response.caracteristicas.detalles[0].presentacion || '');
                    modal.find(`#lote_granel_edit_0`).val(response.caracteristicas.detalles[0].lote_granel || '');
                    modal.find('#lote_envasado_edit_0').data('selected', response.caracteristicas.detalles[0].id_lote_envasado).trigger('change');
                    let idLoteEnvasado = response.caracteristicas.detalles[0].id_lote_envasado;
                    cargarDetallesLoteEnvasadoEdit(idLoteEnvasado);
                    $(`#caracteristicas_Ex_edit_${i} .evasado_export_edit`).data('selected', response.caracteristicas.detalles[i].id_lote_envasado);
                    cargarLotesEdit($('#id_empresa_solicitud_exportacion_edit').val(), i);
                  }
                }
              }

              modal.find('#comentarios_edit').val(response.data.info_adicional);
            }
            else if (id_tipo === 13) {
              modal.find('#id_solicitud_emision_v').val(id_solicitud);
              modal.find('#edit_id_empresa_solicitud_emision_venta').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita_emision_v').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion_emision_v').val(response.data.id_instalacion);

              let caracteristicas = {};
              if (typeof response.data.caracteristicas === 'string') {
                try {
                  caracteristicas = JSON.parse(response.data.caracteristicas);
                } catch (e) {
                  console.error("Error al parsear caracteristicas:", e);
                }
              }
              if (caracteristicas.id_dictamen_envasado) {
                modal.find('#edit_id_dictamen_envasado').data('selected', caracteristicas.id_dictamen_envasado || '');
              }
              if (caracteristicas.id_lote_envasado) {
                modal.find('#edit_id_lote_envasado_emision_v').val(caracteristicas.id_lote_envasado || '');
              }
              if (caracteristicas.cantidad_cajas) {
                modal.find('#edit_num_cajas').val(caracteristicas.cantidad_cajas);
              }
              if (caracteristicas.cantidad_botellas) {
                modal.find('#edit_num_botellas').val(caracteristicas.cantidad_botellas);
              }

              modal.find('#edit_comentarios_e_venta_n').val(response.data.info_adicional);
            }
            else if (id_tipo === 14) {
              // Aquí va el tipo correspondiente para tu caso
              // Llenar los campos del modal con los datos de la solicitud
              modal.find('#edit_id_solicitud').val(id_solicitud);
              modal.find('#edit_id_empresa').val(response.data.id_empresa).trigger('change');
              modal.find('#edit_fecha_visita').val(response.data.fecha_visita);
              modal.find('#edit_id_instalacion').val(response.data.id_instalacion).trigger('change');
              modal.find('#edit_info_adicional').val(response.data.info_adicional);
              modal.find('#instalacion_id').val(response.data.id_instalacion);
              modal.find('#instalacion_id').val(response.data.id_instalacion);

              // Aquí vamos a manejar las características (clases, categorías, renovacion)
              if (response.caracteristicas) {
                // Llenar las categorías si están presentes
                if (response.caracteristicas.categorias) {
                  modal.find('#edit_categoria_in').val(response.caracteristicas.categorias).trigger('change');
                }
                // Llenar las clases si están presentes
                if (response.caracteristicas.clases) {
                  modal.find('#edit_clases_in').val(response.caracteristicas.clases).trigger('change');
                }
                // Llenar la renovación si está presente
                if (response.caracteristicas.renovacion) {
                  modal.find('#edit_renovacion_in').val(response.caracteristicas.renovacion).trigger('change');
                }
              } else {
                // Si no hay características, vaciar los campos correspondientes
                modal.find('#edit_categoria_in').val([]).trigger('change');
                modal.find('#edit_clases_in').val([]).trigger('change');
                modal.find('#edit_renovacion_in').val('').trigger('change');
              }
            }
            // Muestra el modal después de rellenar los datos
            modal.modal('show');
          } else {
            console.error('Error al cargar los datos:', response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error('Error en la solicitud:', error);
        }
      });
    });
  });


  /* formulario para enviar los datos y actualizar */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de actualización
    const formUpdate = document.getElementById('editFormTipo10');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha y hora para la inspección.'
            }
          }
        },
        id_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un predio para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca la dirección para el punto de reunión.'
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
      var formData = new FormData(formUpdate);
      $('#btnEditGeo').prop('disabled', true);

      $('#btnEditGeo').html('<span class="spinner-border spinner-border-sm me-2"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditGeo').prop('disabled', false);
        $('#btnEditGeo').html('<i class="ri-add-line"></i> Editar');
      }, 3000);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#id_solicitud_geo').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editClienteModalTipo10').modal('hide'); // Oculta el modal
          $('#editFormTipo10')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);


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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  /*funcion para solicitud de dictaminacion  */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de dictaminación
    const formDictaminacion = document.getElementById('addEditSolicitud');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        'clases[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione al menos una clase.'
            }
          }
        },
        'categorias[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione al menos una categoria.'
            }
          }
        },
        renovacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione si es renovación o no.'
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
      var formData = new FormData(formDictaminacion);
      $('#btnEditDicIns').prop('disabled', true);

      $('#btnEditDicIns').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditDicIns').prop('disabled', false);
        $('#btnEditDicIns').html('<i class="ri-add-line"></i> Editar');
      }, 3000);
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editSolicitudDictamen').modal('hide');
          $('#addEditSolicitud')[0].reset();
          $('.select2').val(null).trigger('change');

          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);


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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  /*  */
  /* formulario para enviar los datos y actualizar */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de actualización
    const formUpdate = document.getElementById('editVigilanciaProduccionForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha y hora para la inspección.'
            }
          }
        },
        id_lote_granel: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un predio para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca la dirección para el punto de reunión.'
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
      var formData = new FormData(formUpdate);
      $('#btnEditVigiProd').addClass('d-none');
      $('#btnSpinnerEditVigilanciaProduccion').removeClass('d-none');
      // Agregar los valores seleccionados del select múltiple al FormData
      $('#edit_id_tipo_vig')
        .find('option:selected')
        .each(function () {
          formData.append('edit_id_tipo_vig[]', $(this).val());
        });

      $('#edit_edit_id_guias_vigiP')
        .find('option:selected')
        .each(function () {
          formData.append('id_guias[]', $(this).val());
        });

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_vig').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#btnSpinnerEditVigilanciaProduccion').addClass('d-none');
          $('#btnEditVigiProd').removeClass('d-none');
          $('#editVigilanciaProduccion').modal('hide'); // Oculta el modal
          $('#editVigilanciaProduccionForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          // Recarga la tabla manteniendo la página actual
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);

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
          if (xhr.status === 422) {
            let errores = xhr.responseJSON.errors;
            let mensaje = '';

            // Armar el listado de errores
            for (let campo in errores) {
              if (errores.hasOwnProperty(campo)) {
                mensaje += `<div>• ${errores[campo][0]}</div>`;
              }
            }

            Swal.fire({
              icon: 'error',
              title: 'Errores de validación',
              html: mensaje,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });

          } else if (xhr.status === 404) {
            Swal.fire({
              icon: 'warning',
              title: 'No encontrado',
              text: 'Solicitud no encontrada',
              customClass: {
                confirmButton: 'btn btn-warning'
              }
            });

          } else {
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error inesperado al actualizar la solicitud',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
            console.error("Error inesperado:", xhr.responseText);
          }

          $('#btnSpinnerEditVigilanciaProduccion').addClass('d-none');
          $('#btnEditVigiProd').removeClass('d-none');
        }
      });
    });


  });
  //metodo update para muestrteo de lote agranel
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editMuestreoLoteAgranelForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_granel_muestreo: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        destino_lote: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo.'
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
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
      $('#btnEditMLote').prop('disabled', true);
      $('#btnEditMLote').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditMLote').prop('disabled', false);
        $('#btnEditMLote').html('<i class="ri-add-line"></i> Editar');
      }, 3000);
      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_muestreo').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editMuestreoLoteAgranel').modal('hide'); // Oculta el modal
          $('#editMuestreoLoteAgranelForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);

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
            text: 'Error al actualizar la solicitud de muestreo',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //medoto update para viligancia tarslado
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editVigilanciaTrasladoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_granel_traslado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        id_vol_traslado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
      $('#btnEditVigiLote').prop('disabled', true);
      $('#btnEditVigiLote').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditVigiLote').prop('disabled', false);
        $('#btnEditVigiLote').html('<i class="ri-add-line"></i> Editar');
      }, 2000);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_traslado').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editVigilanciaTraslado').modal('hide'); // Oculta el modal
          $('#editVigilanciaTrasladoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla

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
            text: 'Error al actualizar la vigilancia en el traslado del lote',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //metodo para actualizar inspeccion barricada
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionIngresoBarricadaForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_granel_barricada: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        volumen_barricada: {
          validators: {
            notEmpty: {
              message: 'por favor ingrese el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
      $('#btnEditIngresoBarrica').prop('disabled', true);
      $('#btnEditIngresoBarrica').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditIngresoBarrica').prop('disabled', false);
        $('#btnEditIngresoBarrica').html('<i class="ri-add-line"></i> Editar');
      }, 2000);
      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_barricada').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionIngresoBarricada').modal('hide'); // Oculta el modal
          $('#editInspeccionIngresoBarricadaForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);// Recarga la tabla

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
            text: 'Error al actualizar la inspección ingreso a la barrica/contenedor de vidrio',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //edit inspeccion de envasado
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionEnvasadoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        edit_id_lote_envasado_inspeccion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote envasado.'
            }
          }
        },
        id_cantidad_caja: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la cantidad de cajas.'
            }
          }
        },
        id_inicio_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese inicio de envasado.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato de la fecha debe ser AAAA-MM-DD (ej. 2025-05-30).'
            }
          }
        },
        id_previsto: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el término previsto del envasado.'
            }, date: {
              format: 'YYYY-MM-DD',
              message: 'El formato de la fecha debe ser AAAA-MM-DD (ej. 2025-05-30).'
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
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
      $('#enviarInspec').prop('disabled', true);

      $('#enviarInspec').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#enviarInspec').prop('disabled', false);
        $('#enviarInspec').html('<i class="ri-add-line"></i> Editar');
      }, 2500);
      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_inspeccion').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionEnvasado').modal('hide'); // Oculta el modal
          $('#editInspeccionEnvasadoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);// Recarga la tabla

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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    // Inicializar select2 y revalidar el campo cuando cambie
    $('#edit_id_lote_envasado_inspeccion, #edit_id_inicio_envasado, #edit_id_previsto').on('change', function () {
      fvUpdate.revalidateField($(this).attr('name'));
    });
  });

  //add inspeccion de envsasado
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario inpeccion de envasado
    const addInspeccionEnvasadoForm = document.getElementById('addInspeccionEnvasadoForm');
    const fvEnvasado = FormValidation.formValidation(addInspeccionEnvasadoForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_envasado_inspeccion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote envasado.'
            }
          }
        },
        id_cantidad_caja: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la cantidad de cajas.'
            }
          }
        },
        id_inicio_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese inicio de envasado.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato de la fecha debe ser AAAA-MM-DD (ej. 2025-05-30).'
            }
          }
        },
        id_previsto: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el término previsto del envasado.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'El formato de la fecha debe ser AAAA-MM-DD (ej. 2025-05-30).'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.mb-4, .mb-5, .mb-6'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }

    }).on('core.form.valid', function () {
      const formData = new FormData(addInspeccionEnvasadoForm);
      $('#btnAddInspEnv').prop('disabled', true);

      $('#btnAddInspEnv').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnAddInspEnv').prop('disabled', false);
        $('#btnAddInspEnv').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);

      $.ajax({
        url: '/hologramas/storeInspeccionEnvasado', // Cambiar a la ruta correspondiente
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addInspeccionEnvasado').modal('hide');
          $('#addInspeccionEnvasadoForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Inspección de envasado registrada exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function () {
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar la inspección.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }

      });
    });
    // Inicializar select2 y revalidar el campo cuando cambie
    $('#id_empresa_inspeccion, #fecha_visita_inspeccion_envasado, #id_lote_envasado_inspeccion, #id_inicio_envasado, #id_previsto, #id_instalacion_inspeccion').on('change', function () {
      fvEnvasado.revalidateField($(this).attr('name'));
    });
  });

  //metodo para liberacion
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editInspeccionLiberacionForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_granel_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        volumen_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen debe ser un número válido.'
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
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
      $('#btnEditLiberacion').prop('disabled', true);
      $('#btnEditLiberacion').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditLiberacion').prop('disabled', false);
        $('#btnEditLiberacion').html('<i class="ri-add-line"></i> Editar');
      }, 3000);

      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_liberacion').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editInspeccionLiberacion').modal('hide'); // Oculta el modal
          $('#editInspeccionLiberacionForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla

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
            text: 'Error al actualizar la inspección de liberación.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });
  //edit liberacion
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de edición
    const formUpdate = document.getElementById('editLiberacionProductoForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha y hora para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote envasado.'
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
      // Obtener los datos del formulario
      var formData = new FormData(formUpdate);
      $('#btneditlib').prop('disabled', true);

      $('#btneditlib').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_liberacion_terminado').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editLiberacionProducto').modal('hide'); // Oculta el modal
          $('#btneditlib').prop('disabled', false);
          $('#btneditlib').html('<i class="ri-add-line"></i> Editar');
          $('#editLiberacionProductoForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false); // Recarga la tabla
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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  //actualizar muestreo lote
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo
    const formDictaminacion = document.getElementById('editRegistrarSolicitudMuestreoAgave');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
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
      var formData = new FormData(formDictaminacion);
      $('#btnEditMA').prop('disabled', true);

      $('#btnEditMA').html('<span class="spinner-border spinner-border-sm"></span> Actualizando...');
      setTimeout(function () {
        $('#btnEditMA').prop('disabled', false);
        $('#btnEditMA').html('<i class="ri-add-line"></i> Editar');
      }, 3000);

      $.ajax({
        url: '/actualizar-solicitudes/' + $('#edit_id_solicitud_muestr').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editSolicitudMuestreoAgave').modal('hide');
          $('#editRegistrarSolicitudMuestreoAgave')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);
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
          console.log('Error:', xhr.responseText);

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  //Editar pedidos para exportación
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo
    const formDictaminacion = document.getElementById('editPedidoExportacionForm');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de la visita.'
            }
          }
        },

        id_etiqueta: {
          selector: "input[name='id_etiqueta']",
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una etiqueta.'
            }
          }
        },

        direccion_destinatario: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una dirección del destinatario.'
            }
          }
        },
        aduana_salida: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la aduana de salida.'
            }
          }
        },
        no_pedido: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de pedido.'
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
      $('#btnEditExport').addClass('d-none');
      $('#btnSpinnerPedidosExportacionEdit').removeClass('d-none');
      var formData = new FormData(formDictaminacion);

      // Construir las características como un JSON completo
      const caracteristicas = {
        tipo_solicitud: $('#tipo_solicitud_edit').val(),
        direccion_destinatario: $('#direccion_destinatario_ex_edit').val(),
        aduana_salida: $('[name="aduana_salida"]').val(),
        no_pedido: $('[name="no_pedido"]').val(),
        factura_proforma: $('[name="factura_proforma"]')[0].files[0], // Archivo
        factura_proforma_cont: $('[name="factura_proforma_cont"]')[0].files[0], // Archivo
        detalles: [] // Aquí van las filas de la tabla de características
      };

      // Agregar cada fila de la tabla dinámica al JSON
      $('#tabla-marcas tbody tr').each(function () {
        const row = $(this);
        caracteristicas.detalles.push({
          lote_envasado: row.find('.evasado_export').val(),
          cantidad_botellas: row.find('.cantidad-botellas').val(),
          cantidad_cajas: row.find('.cantidad-cajas').val(),
          presentacion: row.find('.presentacion').val()
        });
      });

      // Añadir el JSON al FormData como string
      formData.append('caracteristicas', JSON.stringify(caracteristicas));

      $.ajax({
        url: '/actualizar-solicitudes/' + $('#solicitud_id_pedidos').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#btnSpinnerPedidosExportacionEdit').addClass('d-none');
          $('#btnEditExport').removeClass('d-none');
          $('#editPedidoExportacion').modal('hide');
          $('#editPedidoExportacionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);


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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#btnSpinnerPedidosExportacionEdit').addClass('d-none');
          $('#btnEditExport').removeClass('d-none');
        }
      });
    });
  });
  /* editar emision certificado venta nacional */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para el formulario de actualización
    const formUpdate = document.getElementById('editEmisionCetificadoVentaNacionalForm');
    const fvUpdate = FormValidation.formValidation(formUpdate, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        id_dictamen_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un dictamen de envasado.'
            }
          }
        },
        cantidad_botellas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de botellas.'
            }
          }
        },
        cantidad_cajas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de cajas.'
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
      var formData = new FormData(formUpdate);
      $('#btnEditremi').prop('disabled', true);
      $('#btnEditremi').html('<span class="spinner-border spinner-border-sm me-2"></span> Actualizando...');
      // Hacer la solicitud AJAX
      $.ajax({
        url: '/actualizar-solicitudes/' + $('#id_solicitud_emision_v').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#editSolicitudEmisionCertificado').modal('hide'); // Oculta el modal
          $('#btnEditremi').prop('disabled', false);
          $('#btnEditremi').html('<i class="ri-add-line"></i> Editar');
          $('#editEmisionCetificadoVentaNacionalForm')[0].reset(); // Resetea el formulario
          $('.select2').val(null).trigger('change'); // Resetea los select2
          $('.datatables-solicitudes').DataTable().ajax.reload(null, false);
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
            text: 'Error al actualizar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
  });

  ///
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Inicializar FormValidation para la solicitud de dictaminación de instalaciones
    const form = document.getElementById('addRegistrarSolicitud');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la instalación.'
            }
          }
        },
        renovacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una opción.'
            }
          }
        },
        'clases[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una clase'
            }
          }
        },
        'categorias[]': {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una categoria'
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
      var formData = new FormData(form);
      $('#btnRegistrarDicIns').prop('disabled', true);

      $('#btnRegistrarDicIns').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnRegistrarDicIns').prop('disabled', false);
        $('#btnRegistrarDicIns').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);

      $.ajax({
        url: '/solicitudes-list',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudDictamen').modal('hide');
          $('#addRegistrarSolicitud')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud registrada correctamente',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    // Inicializar select2 y manejar eventos de cambio por "name"
    $('#id_empresa_solicitudes, #fechaSoliInstalacion, #id_instalacion_dic, #categoriaDictamenIns, #clasesDicIns, #renovacion').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });

  });

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Inicializar FormValidation para la solicitud de georeferenciacion
    const form2 = document.getElementById('addRegistrarSolicitudGeoreferenciacion');
    const fv2 = FormValidation.formValidation(form2, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Por favor introduzca la dirección para el punto de reunión.'
            }
          }
        },
        id_predio: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione el predio.'
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
      var formData = new FormData(form2);
      $('#btnRegistrarGeo').addClass('d-none');
      $('#btnSpinnerGeoreferenciacion').removeClass('d-none');
      $.ajax({
        url: '/registrar-solicitud-georeferenciacion',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#btnRegistrarGeo').removeClass('d-none');
          $('#btnSpinnerGeoreferenciacion').addClass('d-none');
          $('#addSolicitudGeoreferenciacion').modal('hide');
          $('#addRegistrarSolicitudGeoreferenciacion')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud registrada correctamente',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#btnRegistrarGeo').removeClass('d-none');
          $('#btnSpinnerGeoreferenciacion').addClass('d-none');
        }
      });
    });

    $('#id_empresa_georefere, #fecha_visita_geo, #id_predio_georefe, #punto_reunion_georefere').on('change', function () {
      fv2.revalidateField($(this).attr('name'));
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
        var tieneCertificadoOtroOrganismo =
          instalacion.folio ||
          instalacion.id_organismo ||
          (instalacion.fecha_emision && instalacion.fecha_emision !== 'N/A') ||
          (instalacion.fecha_vigencia && instalacion.fecha_vigencia !== 'N/A') ||
          data.archivo_url;

        if (tieneCertificadoOtroOrganismo) {
          $('#edit_certificacion').val('otro_organismo').trigger('change');
          $('#edit_certificado_otros').removeClass('d-none');

          $('#edit_folio').val(instalacion.folio || '');
          $('#edit_id_organismo')
            .val(instalacion.id_organismo || '')
            .trigger('change');
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

  //vigilancia en produccion
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario Vigilancia en produccion
    const addVigilanciaProduccionForm = document.getElementById('addVigilanciaProduccionForm');
    const fv5 = FormValidation.formValidation(addVigilanciaProduccionForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de visita.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
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
    }).on('core.form.valid', function () {
      var formData = new FormData(addVigilanciaProduccionForm);
      $('#btnRegisVigiPro').addClass('d-none');
      $('#btnSpinnerVigilanciaProduccion').removeClass('d-none');
      $('#id_tipo_maguey')
        .find('option:selected')
        .each(function () {
          formData.append('id_tipo_maguey[]', $(this).val());
        });

      $('#edit_id_guias_vigiP')
        .find('option:selected')
        .each(function () {
          formData.append('id_guias[]', $(this).val());
        });

      $.ajax({
        url: '/hologramas/storeVigilanciaProduccion', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#btnRegisVigiPro').removeClass('d-none');
          $('#btnSpinnerVigilanciaProduccion').addClass('d-none');
          $('#addVigilanciaProduccion').modal('hide');
          $('#addVigilanciaProduccionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud vigilancia registrado exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr) {
          if (xhr.status === 422) {
            let errores = xhr.responseJSON.errors;
            let mensaje = '';

            // Recorremos y formateamos los errores
            for (let campo in errores) {
              if (errores.hasOwnProperty(campo)) {
                mensaje += `<div>• ${errores[campo][0]}</div>`;
              }
            }

            Swal.fire({
              icon: 'error',
              title: 'Errores de validación',
              html: mensaje,
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });

          } else if (xhr.status === 404) {
            Swal.fire({
              icon: 'warning',
              title: 'No encontrado',
              text: 'Solicitud no encontrada',
              customClass: {
                confirmButton: 'btn btn-warning'
              }
            });

          } else {
            Swal.fire({
              icon: 'error',
              title: '¡Error!',
              text: 'Error inesperado al registrar la vigilancia en producción.',
              customClass: {
                confirmButton: 'btn btn-danger'
              }
            });
            console.error("Error inesperado:", xhr.responseText);
          }

          $('#btnRegisVigiPro').removeClass('d-none');
          $('#btnSpinnerVigilanciaProduccion').addClass('d-none');
        }

      });
    });
    $('#id_empresa_vigilancia, #fecha_visita_vigi, #id_instalacion_vigi').on('change', function () {
      fv5.revalidateField($(this).attr('name'));
    });
  });

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario Muestreo Lote Agranel
    const addMuestreoLoteAgranelForm = document.getElementById('addMuestreoLoteAgranelForm');
    const fvMuestreo = FormValidation.formValidation(addMuestreoLoteAgranelForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de la visita.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_granel: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
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
    }).on('core.form.valid', function () {
      const formData = new FormData(addMuestreoLoteAgranelForm);
      $('#btnRegistrMLote').prop('disabled', true);
      $('#btnRegistrMLote').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnRegistrMLote').prop('disabled', false);
        $('#btnRegistrMLote').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);

      $.ajax({
        url: '/hologramas/storeMuestreoLote', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addMuestreoLoteAgranel').modal('hide');
          $('#addMuestreoLoteAgranelForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud de Muestreo registrado exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function () {
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar el muestreo.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });

    });
    $('#id_empresa_muestreo, #fecha_visita_muestreoLo, #id_instalacion_muestreoLo, #id_lote_granel_muestreo').on('change', function () {
      fvMuestreo.revalidateField($(this).attr('name'));
    });

  });

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Validación del formulario Inspección Ingreso Barricada
    const addInspeccionIngresoBarricadaForm = document.getElementById('addInspeccionIngresoBarricadaForm');
    const fvBarricada = FormValidation.formValidation(addInspeccionIngresoBarricadaForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_granel_barricada: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        tipo_lote: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo.'
            }
          }
        },
        analisis_barricada: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el análisis fisicoquímico.'
            }
          }
        },
        volumen_barricada: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el porcentaje de alcohol.'
            },
            numeric: {
              message: 'Por favor ingrese un valor numérico válido.'
            }
          }
        },
        fecha_inicio: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de inicio.'
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
    }).on('core.form.valid', function () {
      const formData = new FormData(addInspeccionIngresoBarricadaForm);
      $('#btnReIngresoBarrica').prop('disabled', true);
      $('#btnReIngresoBarrica').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnReIngresoBarrica').prop('disabled', false);
        $('#btnReIngresoBarrica').html('<i class="ri-add-line"></i> Registrar');
      }, 2000);
      $.ajax({
        url: '/hologramas/storeInspeccionBarricada', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addInspeccionIngresoBarricada').modal('hide');
          $('#addInspeccionIngresoBarricadaForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Inspección barricada registrada exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function () {
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar la inspección.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $('#id_empresa_barricada, #fecha_visita_ingreso_barrica, #id_instalacion_barricada, #id_lote_granel_barricada, #fecha_inicio_ingreso_barrica').on('change', function () {
      fvBarricada.revalidateField($(this).attr('name'));
    });
  });

  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Validación del formulario Inspección Liberación Barrica/Contenedor de Vidrio
    const addInspeccionLiberacionForm = document.getElementById('addInspeccionLiberacionForm');
    const fvLiberacion = FormValidation.formValidation(addInspeccionLiberacionForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_granel_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        tipo_lote_lib: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo.'
            }
          }
        },
        analisis_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el análisis fisicoquímico.'
            }
          }
        },
        volumen_liberacion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen.'
            },
            numeric: {
              message: 'Por favor ingrese un valor numérico válido.'
            }
          }
        },
        fecha_inicio_lib: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de inicio.'
            }
          }
        },
        fecha_termino_lib: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha de término.'
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
    }).on('core.form.valid', function () {
      const formData = new FormData(addInspeccionLiberacionForm);
      $('#btnAddLiberacion').prop('disabled', true);
      $('#btnAddLiberacion').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnAddLiberacion').prop('disabled', false);
        $('#btnAddLiberacion').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);

      $.ajax({
        url: '/hologramas/storeInspeccionBarricadaLiberacion', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addInspeccionLiberacion').modal('hide');
          $('#addInspeccionLiberacionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Inspección de liberacion barricada registrada exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function () {
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar la inspección.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $('#id_empresa_liberacion, #fecha_visita_liberacion, #id_instalacion_liberacion, #id_lote_granel_liberacion, #fecha_inicio_libe_inspe, #fecha_termino_libe_inspe').on('change', function () {
      fvLiberacion.revalidateField($(this).attr('name'));
    });
  });


  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    //Validar vigilancia en traslado
    const addVigilanciaTrasladoForm = document.getElementById('addVigilanciaTrasladoForm');
    const fvVigilancia = FormValidation.formValidation(addVigilanciaTrasladoForm, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        instalacion_vigilancia: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una dirección de destino.'
            }
          }
        },
        id_lote_granel_traslado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un lote a granel.'
            }
          }
        },
        id_vol_traslado: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el volumen trasladado.'
            },
            numeric: {
              message: 'El volumen trasladado debe ser un número válido.',
              thousandsSeparator: '',
              decimalSeparator: '.'
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
    }).on('core.form.valid', function () {
      const formData = new FormData(addVigilanciaTrasladoForm);
      $('#btnReVigiLote').prop('disabled', true);
      $('#btnReVigiLote').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnReVigiLote').prop('disabled', false);
        $('#btnReVigiLote').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);
      $.ajax({
        url: '/hologramas/storeVigilanciaTraslado', // Cambia a la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Cerrar modal y reiniciar formulario
          $('#addVigilanciaTraslado').modal('hide');
          $('#addVigilanciaTrasladoForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();

          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Vigilancia traslado registrada exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function () {
          // Mostrar alerta de error
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Error al registrar la vigilancia.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $('#id_empresa_traslado, #fecha_visita_traslado, #id_instalacion_traslado, #instalacion_vigilancia, #id_lote_granel_traslado').on('change', function () {
      fvVigilancia.revalidateField($(this).attr('name'));
    });
  });

  /* envio de emision de certificado de venta nacional */
  ///
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Inicializar FormValidation para la solicitud de dictaminación de instalaciones
    const form = document.getElementById('addEmisionCetificadoVentaNacionalForm');
    const fv = FormValidation.formValidation(form, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        id_dictamen_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un dictamen de envasado.'
            }
          }
        },
        cantidad_botellas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de botellas.'
            }
          }
        },
        cantidad_cajas: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la cantidad de cajas.'
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
      var formData = new FormData(form);
      $('#btnRegistraremi').prop('disabled', true);

      $('#btnRegistraremi').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      $.ajax({
        url: '/storeEmisionCertificadoVentaNacional', // Cambia a la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addEmisionCetificadoVentaNacional').modal('hide');
          $('#btnRegistraremi').prop('disabled', false);
          $('#btnRegistraremi').html('<i class="ri-add-line"></i> Registrar');
          $('#addEmisionCetificadoVentaNacionalForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud registrada correctamente',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    // Inicializar select2 y manejar eventos de cambio por "name"
    $('#id_empresa_solicitudes, #fechaSoliInstalacion, #id_instalacion_dic, #categoriaDictamenIns, #clasesDicIns, #renovacion').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });

  });

  /*funcion para solicitud de liberacion producto termiando  */
  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de dictaminación
    const formDictaminacion = document.getElementById('addLiberacionProductoForm');
    const fvDictaminacion = FormValidation.formValidation(formDictaminacion, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una empresa.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una instalación.'
            }
          }
        },
        id_lote_envasado: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione al menos un lote envasado.'
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
      var formData = new FormData(formDictaminacion);
      $('#btnRegistrarlib').prop('disabled', true);
      $('#btnRegistrarlib').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      $.ajax({
        url: '/registrar-solicitud-lib-prod-term',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addLiberacionProducto').modal('hide');
          $('#btnRegistrarlib').prop('disabled', false);
          $('#btnRegistrarlib').html('<i class="ri-add-line"></i> Registrar');
          $('#addLiberacionProductoForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'La liberación del producto se registró exitosamente.',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $('#id_empresa_solicitud_lib_ter, #fecha_visita_liberacion_produto, #id_instalacion_lib_ter, #id_lote_envasado_lib_ter').on('change', function () {
      fvDictaminacion.revalidateField($(this).attr('name'));
    });
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


  $(document).on('click', '.pdf2', function () {
    var url = $(this).data('url');
    var registro = $(this).data('registro');
    var id_solicitud = $(this).data('id');
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');

    //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
    spinner.show();
    iframe.hide();
    //Cargar el PDF con el ID
    iframe.attr('src', 'solicitud_de_servicio/' + id_solicitud);
    //Configurar el botón para abrir el PDF en una nueva pestaña
    $('#NewPestana')
      .attr('href', 'solicitud_de_servicio/' + id_solicitud)
      .show();

    $('#titulo_modal').text('Solicitud de servicios NOM-070-SCFI-2016');
    $('#subtitulo_modal').html('<p class="solicitud badge bg-primary">' + registro + '</p>');
    //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
      spinner.hide();
      iframe.show();
    });
  });

  /* seccion para exportacion */
  $(document).ready(function () {
    const $tipoSolicitud = $('#tipo_solicitud');
    const $seccionCombinado = $('#seccionCajasBotellasCombinado');
    const $seccionExportacion = $('#seccionCajasBotellas');
    const $botonesCharacteristics = $('#botones_characteristics');

    $tipoSolicitud.on('change', function () {
      const tipo = $(this).val();

      if (tipo === '2') {
        // Combinado: ocultar inputs originales y activar sección nueva
        $('#cant_botellas_exportac').removeAttr('name');
        $('#cant_cajas_exportac').removeAttr('name');
        $('#presentacion_exportac').removeAttr('name');

        $('#cant_botellas_exportac2').attr('name', 'cantidad_botellas[0]');
        $('#cant_cajas_exportac2').attr('name', 'cantidad_cajas[0]');
        $('#presentacion_exportac2').attr('name', 'presentacion[0]');

        $seccionExportacion.removeClass('d-none');
        $seccionCombinado.addClass('d-none');

        // Mostrar botones para tablas adicionales
        $botonesCharacteristics.removeClass('d-none');
      } else {
        // Otro tipo: regresar a inputs originales
        $('#cant_botellas_exportac2').removeAttr('name');
        $('#cant_cajas_exportac2').removeAttr('name');
        $('#presentacion_exportac2').removeAttr('name');

        $('#cant_botellas_exportac').attr('name', 'cantidad_botellas[0]');
        $('#cant_cajas_exportac').attr('name', 'cantidad_cajas[0]');
        $('#presentacion_exportac').attr('name', 'presentacion[0]');

        $seccionCombinado.removeClass('d-none');
        $seccionExportacion.addClass('d-none');

        // Ocultar botones
        $botonesCharacteristics.addClass('d-none');
      }
    });

    // Ejecutar una vez al cargar (por si ya tiene valor)
    if ($tipoSolicitud.val() === '2') {
      $tipoSolicitud.trigger('change');
    }
  });




  $(document).ready(function () {
    $('#editPedidoExportacion').on('hidden.bs.modal', function () {
      // Elimina todas las tarjetas menos la primera dentro de sections-container2
      $('#sections-container2 .card').not(':first').remove();
      sectionCountEdit = 1;
    });
  });

  $(document).ready(function () {
    var $tipoSolicitudEdit = $('#tipo_solicitud_edit');
    var $botonesCharacteristicsEdit = $('#botones_characteristics_edit');
    var $seccionCombinadoEdit = $('#seccionCajasBotellasCombinadoEdit');
    var $seccionExportacionEdit = $('#seccionCajasBotellasEdit');

    function actualizarSeccionesEdit() {
      if ($tipoSolicitudEdit.val() === '2') {
        // COMBINADO (tipo 2) => mostrar card, ocultar combinado
        $botonesCharacteristicsEdit.removeClass('d-none');
        $seccionExportacionEdit.removeClass('d-none');
        $seccionCombinadoEdit.addClass('d-none');

        // Remover name del combinado
        $('#cantidad_botellas_edit0').removeAttr('name');
        $('#cantidad_cajas_edit0').removeAttr('name');
        $('#presentacion_edit0').removeAttr('name');

        // Agregar name a la sección "card"
        $('#2cantidad_botellas_edit0').attr('name', 'cantidad_botellas[0]');
        $('#2cantidad_cajas_edit0').attr('name', 'cantidad_cajas[0]');
        $('#2presentacion_edit0').attr('name', 'presentacion[0]');
      } else {
        // Otro tipo => mostrar combinado, ocultar card
        $botonesCharacteristicsEdit.addClass('d-none');
        $seccionExportacionEdit.addClass('d-none');
        $seccionCombinadoEdit.removeClass('d-none');

        // Remover name del card
        $('#2cantidad_botellas_edit0').removeAttr('name');
        $('#2cantidad_cajas_edit0').removeAttr('name');
        $('#2presentacion_edit0').removeAttr('name');

        // Agregar name a la sección original
        $('#cantidad_botellas_edit0').attr('name', 'cantidad_botellas[0]');
        $('#cantidad_cajas_edit0').attr('name', 'cantidad_cajas[0]');
        $('#presentacion_edit0').attr('name', 'presentacion[0]');
      }
    }

    // Evento change
    $tipoSolicitudEdit.on('change', actualizarSeccionesEdit);

    // Llamar una vez al cargar por si ya tiene valor
    actualizarSeccionesEdit();
  });


  $(document).ready(function () {
    let sectionCount = 1;

    $('#add-characteristics').click(function () {
      let empresaSeleccionada = $('#id_empresa_solicitud_exportacion').val();
      if (!empresaSeleccionada) {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'Debe seleccionar un cliente antes de agregar una nueva sección.',
          customClass: { confirmButton: 'btn btn-warning' }
        });
        return;
      }

      var newSection = `
      <div class="card mt-4" id="caracteristicas_Ex${sectionCount}">
                              <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                Características del Producto
                            </div>
        <div class="card-body">
          <div class="row caracteristicas-row">
            <div class="col-md-8">
              <div class="form-floating form-floating-outline mb-4">
                <select name="lote_envasado[${sectionCount}]" class="select2 form-select evasado_export" onchange="cargarDetallesLoteEnvasadoDinamico(this, ${sectionCount})">
                  <option value="" disabled selected>Selecciona un lote envasado</option>
                </select>
                <label for="lote_envasado">Selecciona el lote envasado</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-4">
                <input type="text" disabled class="form-control" name="lote_granel[${sectionCount}]" id="lote_granel_${sectionCount}" placeholder="Lote a granel">
                <label for="lote_granel">Lote a granel</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
      $('#sections-container').append(newSection);
      cargarLotes(empresaSeleccionada, sectionCount);
      initializeSelect2($('.select2'));
      sectionCount++;
    });

    function cargarLotes(empresaSeleccionada, sectionCount) {
      $.ajax({
        url: '/getDatos/' + empresaSeleccionada,
        method: 'GET',
        success: function (response) {
          var contenidoLotesEnvasado = '<option value="" disabled selected>Selecciona un lote envasado</option>';
          var marcas = response.marcas;
          for (let index = 0; index < response.lotes_envasado.length; index++) {
            var lote = response.lotes_envasado[index];
            var skuLimpio = limpiarSku(lote.sku);
            var marcaEncontrada = marcas.find(marca => marca.id_marca === lote.id_marca);
            var nombreMarca = marcaEncontrada ? marcaEncontrada.marca : 'Sin marca';
            var num_dictamen = lote.dictamen_envasado ? lote.dictamen_envasado.num_dictamen : 'Sin dictamen de envasado';
            contenidoLotesEnvasado += `<option value="${lote.id_lote_envasado}">${skuLimpio} ${lote.nombre} ${nombreMarca} ${num_dictamen}</option>`;
          }
          if (response.lotes_envasado.length == 0) {
            contenidoLotesEnvasado = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
          }
          $(`#caracteristicas_Ex${sectionCount} .evasado_export`).html(contenidoLotesEnvasado);
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error al cargar los datos',
            text: 'Hubo un problema al intentar cargar los lotes.',
            customClass: { confirmButton: 'btn btn-danger' }
          });
        }
      });
    }

    $('#delete-characteristics').click(function () {
      var totalSections = $('#sections-container .card').length;
      var lastSection = $('#sections-container .card').last();
      if (totalSections > 1) {
        lastSection.remove();
        sectionCount--;
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'No se puede eliminar la sección original.',
          customClass: { confirmButton: 'btn btn-warning' }
        });
      }
    });

    $('#id_empresa_solicitud_exportacion').on('change', function () {
      cargarDatosCliente();

      // Obtener el nuevo valor de empresa
      let empresaSeleccionada = $(this).val();

      // Si no hay valor, no hacer nada
      if (!empresaSeleccionada) return;

      // Recorrer todas las secciones generadas y recargar sus selects
      $('#sections-container .card').each(function (i, card) {
        let sectionIndex = $(card).attr('id').replace('caracteristicas_Ex', '');
        cargarLotes(empresaSeleccionada, sectionIndex);
      });
    });

  });
  /* seccion de editar solicitudes exportacion */
  // ==================== EDITAR ====================
  let sectionCountEdit = 1;
  /*   $(document).ready(function () { */

  /*     $('#add-characteristics_edit_1').click(function () {
        let empresaSeleccionada = $('#id_empresa_solicitud_exportacion_edit').val();
        if (!empresaSeleccionada) {
          Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Debe seleccionar un cliente antes de agregar una nueva sección.',
            customClass: { confirmButton: 'btn btn-warning' }
          });
          return;
        }

        var newSection = `
        <div class="card mt-4" id="caracteristicas_Ex_edit_${sectionCountEdit}">
                                <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
                                  Características del Producto
                              </div>
          <div class="card-body">
            <div class="row caracteristicas-row">
              <div class="col-md-8">
                <div class="form-floating form-floating-outline mb-4">
                  <select name="lote_envasado_edit[${sectionCountEdit}]" class="select2 form-select evasado_export_edit" onchange="cargarDetallesLoteEnvasadoDinamicoEdit2(this, ${sectionCountEdit})">
                    <option value="" disabled selected>Selecciona un lote envasado</option>
                  </select>
                  <label for="lote_envasado">Selecciona el lote envasado</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating form-floating-outline mb-4">
                  <input type="text" disabled class="form-control" name="lote_granel_edit[${sectionCountEdit}]" id="lote_granel_edit_${sectionCountEdit}" placeholder="Lote a granel">
                  <label for="lote_granel">Lote a granel</label>
                </div>
              </div>



            </div>
          </div>
        </div>
      `;
        $('#sections-container2').append(newSection);
        cargarLotesEdit2(empresaSeleccionada, sectionCountEdit);
        initializeSelect2($('.select2'));
        sectionCountEdit++;
      }); */

  /*   }); */

  $(document).ready(function () {
    $('#add-characteristics_edit').click(function () {
      let empresaSeleccionada = $('#id_empresa_solicitud_exportacion_edit').val();
      if (!empresaSeleccionada) {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'Debe seleccionar un cliente antes de agregar una nueva sección.',
          customClass: { confirmButton: 'btn btn-warning' }
        });
        return;
      }

      var newSection = `
      <div class="card mt-4" id="caracteristicas_Ex_edit_${sectionCountEdit}">
                                 <div class="badge rounded-2 bg-label-primary  fw-bold fs-6 px-4 py-4 mb-5">
                                Características del Producto
                            </div>
        <div class="card-body">
          <div class="row caracteristicas-row">
            <div class="col-md-8">
              <div class="form-floating form-floating-outline mb-4">
                <select name="lote_envasado[${sectionCountEdit}]" class="select2 form-select evasado_export_edit" onchange="cargarDetallesLoteEnvasadoDinamicoEdit(this, ${sectionCountEdit})">
                  <option value="" disabled selected>Selecciona un lote envasado</option>
                </select>
                <label for="lote_envasado">Selecciona el lote envasado</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline mb-4">
                <input type="text" disabled class="form-control" name="lote_granel_edit[${sectionCountEdit}]" id="lote_granel_edit_${sectionCountEdit}" placeholder="Lote a granel">
                <label for="lote_granel">Lote a granel</label>
              </div>
            </div>



          </div>
        </div>
      </div>
    `;
      $('#sections-container2').append(newSection);
      cargarLotesEdit(empresaSeleccionada, sectionCountEdit);
      initializeSelect2($('.select2'));
      sectionCountEdit++;
    });



    // Eliminar la última sección (editar)
    $('#delete-characteristics_edit').click(function () {
      var totalSections = $('#sections-container2 .card').length;
      var lastSection = $('#sections-container2 .card').last();
      if (totalSections > 1) {
        lastSection.remove();
        sectionCountEdit--;
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'No se puede eliminar la sección original.',
          customClass: { confirmButton: 'btn btn-warning' }
        });
      }
    });
  });

  function cargarLotesEdit(empresaSeleccionada, sectionCountEdit) {
    $.ajax({
      url: '/getDatos/' + empresaSeleccionada,
      method: 'GET',
      success: function (response) {
        var contenidoLotesEnvasado = '<option value="" disabled selected>Selecciona un lote envasado</option>';
        var marcas = response.marcas;
        for (let index = 0; index < response.lotes_envasado.length; index++) {
          var lote = response.lotes_envasado[index];
          var skuLimpio = limpiarSku(lote.sku);
          var marcaEncontrada = marcas.find(marca => marca.id_marca === lote.id_marca);
          var nombreMarca = marcaEncontrada ? marcaEncontrada.marca : 'Sin marca';
          var num_dictamen = lote.dictamen_envasado ? lote.dictamen_envasado.num_dictamen : 'Sin dictamen de envasado';
          contenidoLotesEnvasado += `<option value="${lote.id_lote_envasado}">${skuLimpio} ${lote.nombre} ${nombreMarca} ${num_dictamen}</option>`;
        }
        if (response.lotes_envasado.length == 0) {
          contenidoLotesEnvasado = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
        }
        const select = $(`#caracteristicas_Ex_edit_${sectionCountEdit} .evasado_export_edit`);
        select.html(contenidoLotesEnvasado);

        // ✅ Verificar si hay un valor seleccionado previamente
        const selectedPrevio = select.data('selected');
        if (selectedPrevio) {
          select.val(selectedPrevio).trigger('change');
        }
      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: 'Error al cargar los datos',
          text: 'Hubo un problema al intentar cargar los lotes.',
          customClass: { confirmButton: 'btn btn-danger' }
        });
      }
    });
  }

  function cargarDetallesLoteEnvasadoEdit(idLoteEnvasado) {
    if (idLoteEnvasado) {
      $.ajax({
        url: '/getDetalleLoteEnvasado/' + idLoteEnvasado,
        method: 'GET',
        success: function (response) {
          console.log(response); // Verifica la respuesta en la consola
          console.log("Entro en el de modal edit");

          let tbody = $('#tablaLotes tbody');
          tbody.empty(); // Limpia los datos anteriores
          if (response.lote_envasado) {
            let filaEnvasado = `
                        <tr>
                            <td>1</td>
                            <td>${response.lote_envasado.nombre}</td>
                            <td>${limpiarSku(response.lote_envasado.sku) == '{"inicial":""}' ? "SKU no definido" : limpiarSku(response.lote_envasado.sku)}</td>
                            <td>${response.lote_envasado.presentacion || 'N/A'} ${response.lote_envasado.unidad || ''}</td>

                            <td>Botellas: ${response.lote_envasado.cant_botellas}
                        </tr>`;
            tbody.append(filaEnvasado);
          }

          // Verifica si hay lotes a granel asociados y los muestra
          if (response.detalle && response.detalle.length > 0) {
            tbody.append(`
            <tr style="background-color: #f5f5f7;">
                <th>#</th>
                <th>Nombre de lote a granel</th>
                <th>Folio FQ</th>
                <th>Cont. Alc.</th>
                <th>Categoría / Clase / Tipos de Maguey</th>
            </tr>`);
            let nombre_lote_granel = "";
            response.detalle.forEach((lote, index) => {
              let filaGranel = `
                            <tr>
                                <td>${index + 2}</td>
                                <td>
                                ${lote.nombre_lote}<br>
                                <b>Certificado: </b>
                                ${lote.certificado_granel ? lote.certificado_granel.num_certificado : 'Sin definir'}
                                </td>
                                  <td>
                                    <input type="text" class="form-control form-control-sm" name="folio_fq[]" value="${lote.folio_fq || ''}" />
                                  </td>

                                  <td>
                                    <input type="text" class="form-control form-control-sm" name="cont_alc[]" value="${lote.cont_alc || ''}" />
                                  </td>
                               <td>
                                ${lote.categoria.categoria || 'N/A'}<br>
                                ${lote.clase.clase || 'N/A'}<br>
                                ${lote.tiposMaguey.length ? lote.tiposMaguey.map(tipo => tipo.nombre + ' (<i>' + tipo.cientifico + '</i>)').join('<br>') : 'N/A'}
                            </td>

                            </tr>`;
              tbody.append(filaGranel);
              nombre_lote_granel += lote.nombre_lote;
            });

            $('.lotes_granel_export_edit').val(nombre_lote_granel);


          } else {
            tbody.append(
              `<tr><td colspan="4" class="text-center">No hay lotes a granel asociados</td></tr>`
            );
          }
        },
        error: function () {
          console.error('Error al cargar el detalle del lote envasado.');
        }
      });
    }
  }


  /* fin de la seccion de editar solicitudes exportacion */
  /* Enviar formulario store add exportacion */

  $(function () {
    // Configuración de CSRF para las solicitudes AJAX
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Validación del formulario Pedido de Exportación
    const addPedidoExportacionForm = document.getElementById('addPedidoExportacionForm');
    const fv = FormValidation.formValidation(addPedidoExportacionForm, {
      fields: {
        tipo_solicitud: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un tipo de solicitud.'
            }
          }
        },
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        id_instalacion_envasado_2: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un domicilio de envasado.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un domicilio para la inspección.'
            }
          }
        },
        /*

                'cantidad_botellas[0]': {
                  validators: {
                    notEmpty: {
                      message: 'Por favor introduzca el número de botellas'
                    }
                  }
                },
                'cantidad_cajas[0]': {
                  validators: {
                    notEmpty: {
                      message: 'Por favor introduzca el número de cajas'
                    }
                  }
                }, */
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la fecha y hora de la visita.'
            }
          }
        },

        id_etiqueta: {
          selector: "input[name='id_etiqueta']",
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una etiqueta.'
            }
          }
        },
        factura_proforma: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la factura'
            }
          }
        },
        direccion_destinatario: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione una dirección del destinatario.'
            }
          }
        },
        aduana_salida: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la aduana de salida.'
            }
          }
        },
        no_pedido: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese el número de pedido.'
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
    }).on('core.form.valid', function () {

      // Recolectar el resto de los datos del formulario
      const formData = new FormData(addPedidoExportacionForm);
      $('#btnAddExport').addClass('d-none');
      $('#btnSpinnerPedidosExportacion').removeClass('d-none');
      const caracteristicas = {
        tipo_solicitud: $('#tipo_solicitud').val(),
        direccion_destinatario: $('#direccion_destinatario_ex').val(),
        aduana_salida: $('[name="aduana_salida"]').val(),
        cont_alc: $('[name="cont_alc"]').val(),
        no_pedido: $('[name="no_pedido"]').val(),
        factura_proforma: $('[name="factura_proforma"]')[0].files[0], // Archivo
        factura_proforma_cont: $('[name="factura_proforma_cont"]')[0].files[0], // Archivo
        detalles: [] // Aquí van las filas de la tabla de características
      };

      // Agregar cada fila de la tabla dinámica al JSON
      $('#tabla-marcas tbody tr').each(function () {
        const row = $(this);
        caracteristicas.detalles.push({
          lote_envasado: row.find('.lote-envasado').val(),
          cantidad_botellas: row.find('.cantidad-botellas').val(),
          cantidad_cajas: row.find('.cantidad-cajas').val(),
          presentacion: row.find('.presentacion').val()
        });
      });

      // Añadir el JSON al FormData como string
      formData.append('caracteristicas', JSON.stringify(caracteristicas));

      $.ajax({
        url: '/exportaciones/storePedidoExportacion', // Actualiza con la URL correcta
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          // Reiniciar el formulario
          $('#btnSpinnerPedidosExportacion').addClass('d-none');
          $('#btnAddExport').removeClass('d-none');
          $('#addPedidoExportacionForm')[0].reset();
          $('.select2').val(null).trigger('change');
          $('#sections-container .card').not(':first').remove();
          $('#encabezado_etiquetas').html('Elegir Etiquetas y Corrugados');
          $('#tablaLotes tbody').empty();
          $('.datatables-solicitudes').DataTable().ajax.reload();
          $('#addPedidoExportacion').modal('hide');
          // Mostrar alerta de éxito
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'El pedido de exportación se registró exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        },
        error: function (xhr, status, error) {
          let mensaje = 'Hubo un error al registrar el pedido de exportación.';

          if (xhr.responseJSON) {
            // Si hay errores de validación
            if (xhr.responseJSON.errors) {
              // Construir mensaje concatenando todos los errores
              const errores = xhr.responseJSON.errors;
              mensaje = Object.values(errores)
                .flat() // en caso que haya arrays de mensajes
                .join('\n'); // separa por salto de línea
            } else if (xhr.responseJSON.message) {
              mensaje = xhr.responseJSON.message;
            }
          } else if (xhr.responseText) {
            try {
              const json = JSON.parse(xhr.responseText);
              if (json.message) mensaje = json.message;
            } catch (e) {
              mensaje = xhr.responseText;
            }
          }

          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            html: mensaje.replace(/\n/g, '<br>'), // reemplaza saltos de línea por <br>
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });

          $('#btnSpinnerPedidosExportacion').addClass('d-none');
          $('#btnAddExport').removeClass('d-none');
        }
      });
    });
    $('#id_empresa_solicitud_exportacion, #fecha_visita_exportacion, #id_instalacion_exportacion, #direccion_destinatario_ex, #id_instalacion_envasado_2').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });

  // Mapeo entre IDs de tipo de solicitud y IDs de divs
  const divsPorSolicitud = {
    1: ['muestreoAgave'],
    2: ['vigilanciaProduccion'],
    4: ['vigilanciaTraslado'],
    14: ['dictamenInstalaciones'],
    10: ['georreferencia'],
    11: ['liberacionPTExportacion'],
    3: ['muestreoLoteAjustes', 'guiastraslado'],
    5: ['inspeccionEnvasado'],
    7: ['inspeccionIngresoBarrica'],
    8: ['liberacionPTNacional'],
    9: ['liberacionBarricaVidrio']
  };

  // Función para manejar la visibilidad de divs según el tipo de solicitud
  function manejarVisibilidadDivs(idTipo) {
    // Ocultamos todos los divs
    Object.values(divsPorSolicitud)
      .flat()
      .forEach(divId => {
        $(`#${divId}`).addClass('d-none');
      });
    const divsMostrar = divsPorSolicitud[idTipo];
    if (divsMostrar) {
      divsMostrar.forEach(divId => {
        $(`#${divId}`).removeClass('d-none');

        document.querySelectorAll('.d-none select').forEach(el => {
          // el.disabled = true;

        });

      });
    }

  }

  function limpiarCamposDictamen() {
    $('.cajasBotellas, .guiasTraslado, .cajasBotellasTN, .solicitudPdf, .proforma, .csf, .razonSocial, .domicilioFiscal, .domicilioInstalacion, .nombrePredio, .preregistro, .fechaHora, .nombreLote, .guiasTraslado, .categoria, .clase, .cont_alc, .fq, .certificadoGranel, .tipos, .nombreLoteEnvasado, .tipoAnalisis, .materialRecipiente, .capacidadRecipiente, .numeroRecipiente, .tiempoMaduracion, .tipoIngreso, .volumenLiberado, .tipoLiberacion, .volumenActual, .volumenTrasladado, .volumenSobrante, .volumenIngresado, .inicioTerminoEnvasado, .destinoEnvasado, .etiqueta, .acta').html('');
  }

  // Manejar el clic en los enlaces con clase "validar-solicitudes"
  $(document).on('click', '.validar-solicitudes', function () {
    limpiarCamposDictamen();
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
          $('.razonSocial').html(response?.data?.empresa?.razon_social || 'No disponible');
          $('.id_empresa').html(response?.data?.empresa?.id_empresa || 'No disponible');
          $('.domicilioFiscal').html(response.data.empresa.domicilio_fiscal);
          // Validar si `direccion_completa` no está vacío
          if (response.data.instalacion) {
            $('.domicilioInstalacion').append(response.data.instalacion.direccion_completa + " <b>Vigencia: </b>" + response.data.instalacion.fecha_vigencia);
          } else {
            // Si está vacío, usar `ubicacion_predio`
            $('.domicilioInstalacion').append(response.data?.predios?.ubicacion_predio);
            $('.nombrePredio').text(response.data?.predios?.nombre_predio);
            $('.preregistro').html(
              "<a target='_Blank' href='/pre-registro_predios/" +
              response.data?.predios?.id_predio +
              "'><i class='ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer'></i></a>"
            );
          }




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
            /*/ {
               ids: [55],
               targetClass: '.proforma',
               noDocMessage: 'No hay factura proforma',
               condition: (documento, response) => documento.id_empresa == response.data.id_empresa
             },
               {
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


          // Obtener el primer cliente válido
          const clientes = response.data.empresa.empresa_num_clientes || [];
          const clienteValido = clientes.find(c => c && c.numero_cliente);
          const numeroCliente = clienteValido ? clienteValido.numero_cliente : null;

          // Iterar sobre los documentos
          if (numeroCliente) {
            $.each(response.documentos, function (index, documento) {
              documentConfig.forEach(config => {
                if (
                  config.ids.includes(documento.id_documento) &&
                  config.condition(documento, response) // Usar la condición dinámica
                ) {
                  const link = $('<a>', {
                    href: 'files/' + numeroCliente + '/' + documento.url,
                    target: '_blank'
                  });

                  link.html('<i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i>');
                  if (documento.id_documento === 128 || documento.id_documento === 76) {
                    $(config.targetClass).html(link);
                  } else {
                    $(config.targetClass).empty().html(link);
                  }
                  documentsFound[config.targetClass] = true;
                }
              });
            });
          } else {
            console.warn('No se encontró un número de cliente válido.');
          }


          $('.cont_alc').text(response?.data?.lote_granel?.cont_alc || 'No disponible');
          $('.fq').text(response?.data?.lote_granel?.folio_fq || 'No disponible');
          $('.certificadoGranel').text(response?.data?.lote_granel?.certificado_granel?.num_certificado ||
            response?.data?.lote_envasado?.lotes_envasado_granel?.[0]?.lotes_granel?.[0]?.certificado_granel?.num_certificado ||
            'No disponible');
          /* $('.certificadoGranel').html('<a href="/files/' + response?.data?.lote_granel.empresa?.empresa_num_clientes[0]?.numero_cliente + '/certificados_granel/' + response?.url_certificado_granel + '" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>'); */
          if (response?.data?.lote_granel?.empresa?.empresa_num_clientes?.[0] && response?.url_certificado_granel) {
            const cliente = response.data.lote_granel.empresa.empresa_num_clientes[0].numero_cliente;
            const url = '/files/' + cliente + '/certificados_granel/' + response.url_certificado_granel;

            $('.certificadoGranel').html(
              `<a href="${url}" target="_blank">
                <i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i>
            </a>`
            );
          }

          /* $('.fq').html('<a href="/files/' + response?.data?.lote_granel.empresa?.empresa_num_clientes[0]?.numero_cliente + '/fqs/' + response?.url_fqs + '" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>'); */
          if (
            response?.data?.lote_granel?.empresa?.empresa_num_clientes?.[0] &&
            response?.url_fqs
          ) {
            const cliente = response.data.lote_granel.empresa.empresa_num_clientes[0].numero_cliente;
            const url = '/files/' + cliente + '/fqs/' + response.url_fqs;

            $('.fq').html(
              `<a href="${url}" target="_blank">
                 <i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i>
               </a>`
            );
          }


          if (response.guias && Array.isArray(response.guias) && response.guias.length > 0) {
            const folios = response.guias.map(g => g.folio || 'Sin folio').join(', ');
            $('.guiasTraslado').text(folios);
          } else {
            $('.guiasTraslado').text('No disponibles');
          }


          $('.tipos').text(response?.tipos_agave || 'No disponible');


          // Validar nombre del lote envasado


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
          // $('.tipoEtiquetaEnvasado').text(response?.data?.lotes_envasado.tipo);
          $('.inicioTerminoEnvasado').text(caracteristicas.fecha_inicio + ' a ' + caracteristicas.fecha_fin);
          let destino;
          /* if (response?.data?.lote_envasado.destino_lote == 1) {
             destino = 'Nacional';
           }
           if (response?.data?.lote_envasado.destino_lote == 2) {
             destino = 'Exportación';
           }
           if (response?.data?.lote_envasado.destino_lote == 3) {
             destino = 'stock';
           }

           $('.destinoEnvasado').text(destino);*/
          $('.etiqueta').html('<a href="files/' + response.data.empresa.empresa_num_clientes[0].numero_cliente + '/' + response?.url_etiqueta + '" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>');
          if (Array.isArray(response.lotesEnvasado) && response.lotesEnvasado.length > 0) {
            $('.nombreLoteEnvasado').text(response.lotesEnvasado[0].nombre || 'Nombre no disponible');

            response.lotesEnvasado.forEach((lote, index) => {
              let html = 'N/A';

              if (lote.dictamen_envasado) {
                const idDictamen = lote.dictamen_envasado.id_dictamen_envasado;
                const numDictamen = lote.dictamen_envasado.num_dictamen;
                const url = `/dictamen_envasado/${idDictamen}`;

                html = `${numDictamen}
                  <a href="${url}" target="_blank">
                    <i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i>
                  </a>`;
              }

              // Aplicar por índice si hay varios
              $(`.dictamenEnvasado[data-index="${index}"]`).html(html);
            });
          } else {
            // Si no hay lotes, dejar los campos limpios o con texto por defecto
            $('.nombreLoteEnvasado').text('Nombre no disponible');
            $('.dictamenEnvasado').html('Dictamen no disponible');
          }


          $('.acta').html('<a href="/files/' + response?.data?.empresa?.empresa_num_clientes[0]?.numero_cliente + '/actas/' + response?.url_acta + '" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>');
          $('.solicitudPdf').html('<a href="/solicitud_de_servicio/' + response?.data?.id_solicitud + '" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>');
          $('.proforma').html('<a href="/files/' + response?.data?.empresa?.empresa_num_clientes[0]?.numero_cliente + '/' + response?.url_proforma + '" target="_blank"><i class="ri-file-pdf-2-fill text-danger ri-40px pdf2 cursor-pointer"></i></a>');
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
            $('.cajasBotellas').text(
              caracteristicas.cantidad_caja + ' Cajas y ' + (response?.lotesEnvasado?.[0]?.cant_botellas ?? '0') + ' Botellas'
            );
          }
          const cajas = caracteristicas.cajas_por_pallet || '0';
          const botellas = caracteristicas.botellas_por_caja || '0';

          $('.cajasBotellasTN').text(`Cajas por pallet: ${cajas} Botellas por caja: ${botellas}`);

          let destinoTexto = 'No disponible';

          switch (response?.lotesEnvasado?.[0]?.destino_lote) {
            case 1:
              destinoTexto = 'Nacional';
              break;
            case 2:
              destinoTexto = 'Exportación';
              break;
            case 3:
              destinoTexto = 'Stock';
              break;
          }

          $('.destinoEnvasado').text(destinoTexto);

          // Estructura de configuración para los documentos


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


  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation para la solicitud de muestreo de agave
    const form3 = document.getElementById('addRegistrarSolicitudMuestreoAgave');
    const fv3 = FormValidation.formValidation(form3, {
      fields: {
        id_empresa: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un cliente.'
            }
          }
        },
        fecha_visita: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione la fecha sugerida para la inspección.'
            }
          }
        },
        punto_reunion: {
          validators: {
            notEmpty: {
              message: 'Por favor ingrese la dirección para el punto de reunión.'
            }
          }
        },
        id_instalacion: {
          validators: {
            notEmpty: {
              message: 'Por favor seleccione un domicilio para la inspección.'
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
      var formData = new FormData(form3);
      $('#btnRegistrarMA').prop('disabled', true);

      $('#btnRegistrarMA').html('<span class="spinner-border spinner-border-sm"></span> Registrando...');
      setTimeout(function () {
        $('#btnRegistrarMA').prop('disabled', false);
        $('#btnRegistrarMA').html('<i class="ri-add-line"></i> Registrar');
      }, 3000);
      $.ajax({
        url: '/registrar-solicitud-muestreo-agave',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudMuestreoAgave').modal('hide');
          $('#addRegistrarSolicitudMuestreoAgave')[0].reset();
          $('.select2').val(null).trigger('change');
          $('.datatables-solicitudes').DataTable().ajax.reload();
          console.log(response);

          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud de muestreo registrado exitosamente.',
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
            text: 'Error al registrar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });
    $('#id_empresa_dic2mues, #fecha_visita_dic2, #id_instalacion_dic2').on('change', function () {
      fv3.revalidateField($(this).attr('name'));
    });
  });


  $(function () {
    // Configuración CSRF para Laravel
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    // Inicializar FormValidation para las validaciones por parte del personal oc
    const form = document.getElementById('addValidarSolicitud');

    const fv = FormValidation.formValidation(form, {
      excluded: ':disabled',
      fields: {
        /* razonSocial: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         },
         razonSocial1: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         },
         domicilioFiscal: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         },
         domicilioInstalacion: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         },
         fechaHora: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         },
         actaConstitutiva: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         },
         csf: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         },
         comprobantePosesion: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         },
         planoDistribucion: {
           validators: {
             notEmpty: {
               message: 'Selecciona la respuesta'
             }
           }
         }, */
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.marcar'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }


    }).on('core.form.valid', function (e) {
      // Validar el formulario
      var formData = new FormData(form);

      $.ajax({
        url: '/registrarValidarSolicitud',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          $('#addSolicitudValidar').modal('hide');
          $('#addValidarSolicitud')[0].reset();
          $('.datatables-solicitudes').DataTable().ajax.reload();


          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Solicitud validada correctamente',
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
            text: 'Error al validar la solicitud',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

  });


  $(function () {
    if ($('#dropzone-multi').length) {
      new Dropzone('#dropzone-multi', {
        url: '/upload',
        acceptedFiles: 'application/pdf',
        maxFilesize: 5,
        addRemoveLinks: true,
        dictDefaultMessage: 'Arrastra aquí los archivos o haz clic para seleccionar',
        dictRemoveFile: 'Eliminar',
        previewTemplate: document.querySelector('#tpl-preview').innerHTML,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function () {
          this.on('success', function (file, response) {
            console.log('Subido:', response);
          });
          this.on('removedfile', function (file) {
            console.log('Archivo eliminado:', file);
          });
        }
      });
    }
  });



});


document.getElementById('addPedidoExportacion').addEventListener('shown.bs.modal', function () {
  cargarDatosCliente();
});




