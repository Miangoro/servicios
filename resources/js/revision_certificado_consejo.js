'use strict';

$(function () {

  var dt_user_table = $('.datatables-users')

  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '/revision-consejo-list',
      },
      columns: [
        { data: '#' },                //0
        { data: 'fake_id' },          //1
        { data: '' },    //2
        { data: 'num_certificado' },  //3
        { data: 'id_revisor' },       //4
        { data: 'created_at' },       //5
        { data: 'updated_at' },       //6
        { data: 'PDF' },              //7
        { data: 'decision' },         //8
        { data: 'actions' }           //9
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
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          targets: 2,
          render: function (data, type, row) {
            var tipoRevision = row['tipo_revision'];
            var icono = '';

            if (tipoRevision === 'Instalaciones de productor' || tipoRevision === 'Instalaciones de envasador' || tipoRevision === 'Instalaciones de comercializador' || tipoRevision === 'Instalaciones de almacén o bodega' || tipoRevision === 'Instalaciones de área de maduración') {
              icono = `<span class="fw-bold mt-1 badge bg-secondary">${tipoRevision}</span>`;
            }
            if (tipoRevision === 'Granel') {
              icono = `<span class="fw-bold mt-1 badge bg-dark">${tipoRevision}</span>`;
            }
            if (tipoRevision === 'Exportación') {
              icono = `<span class="fw-bold mt-1 badge bg-primary">${tipoRevision}</span>`;
            }
            return icono;
          }
        },
        {
          targets: 3,
          render: function (data, type, full, meta) {
            var $num_certificado = full['num_certificado'];


            return `
              <div style="display: flex; flex-direction: column; align-items: start; gap: 4px;">
                <span class="fw-bold">
                  ${$num_certificado}
                </span>
              </div>
              `;
          }

        },
        {
          targets: 4,
          render: function (data, type, full, meta) {
            var $id_revisor = full['id_revisor'];
            return '<span class="user-email">' + $id_revisor + '</span>';
          }
        },

        {
          targets: 5,
          render: function (data, type, full, meta) {
            var $created_at = full['created_at'];
            return '<span class="user-email">' + $created_at + '</span>';
          }
        },
        {
          targets: 6,
          render: function (data, type, full, meta) {
            var $updated_at = full['updated_at'];
            return '<span class="user-email">' + $updated_at + '</span>';
          }
        },
        {
          targets: 7,
          className: 'text-center',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            if (full['decision'] != 'Pendiente') {
              // Si existe la decisión, el ícono es funcional (activo)
              return `
                      <i class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer"
                         data-bs-target="#mostrarPdf"
                         data-bs-toggle="modal"
                         data-bs-dismiss="modal"
                         data-num-certificado="${full['num_certificado']}"
                         data-tipo="${full['tipo_dictamen']}"
                         data-id="${full['id_revision']}"
                         data-tipo_revision="${full['tipo_revision']}">
                      </i>`;
            } else {
              // Si la decisión no existe, el ícono se ve como deshabilitado con un color más claro
              return `
                      <i class="ri-file-pdf-2-fill ri-40px cursor-not-allowed" style="color: lightgray;"></i>`;
            }
          }
        },
        {
          targets: 8,
          orderable: 0,
          render: function (data, type, full, meta) {
            let $decision = full['decision'];
            let $colorDesicion;
            let $nombreDesicion;
            let num_revision = '';


            if (full['num_revision'] == 1) {
              num_revision = 'Primera';
            } else {
              num_revision = 'Segunda';
            }

            switch ($decision) {
              case "positiva":
                $nombreDesicion = num_revision + ' Revisión positiva';
                $colorDesicion = 'primary';
                break;

              case "negativa":
                $nombreDesicion = num_revision + ' Revisión negativa';
                $colorDesicion = 'danger';
                break;
              default:
                $nombreDesicion = num_revision + ' Revisión pendiente';
                $colorDesicion = 'warning';
            }

            return `<span class="badge rounded-pill bg-${$colorDesicion}">${$nombreDesicion}</span>`;
          }
        },
        {
          // Actions
          targets: 9,
          title: 'Acciones',
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-50">' +
              // Botón de Opciones
              '<button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
              '<i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>' +
              '</button>' +
              // Menú desplegable
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              // Botón para revisar
              `<a class="dropdown-item waves-effect text-info cuest" ` +
              `href="/add_revision_consejo/${full['id_revision']}" ` +
              `data-id="${full['id_revision']}" ` +
              `data-revisor-id="${full['id_revisor']}" ` +
              `data-dictamen-id="${full['id_certificado']}" ` +
              `data-num-certificado="${full['num_certificado']}" ` +
              `data-num-dictamen="${full['num_dictamen']}" ` +
              `data-tipo-dictamen="${full['tipo_dictamen']}" ` +
              `data-fecha-vigencia="${full['fecha_vigencia']}" ` +
              `data-fecha-vencimiento="${full['fecha_vigencia']}" ` +
              `data-tipo="${full['tipo_dictamen']}" ` +
              `data-tipo_revision="${full['tipo_revision']}" ` +

              `data-bs-target="#fullscreenModal">` +
              '<i class="ri-eye-fill ri-20px text-info"></i> Revisar' +
              '</a>' +
              // Botón para editar revisión
              `<a class="dropdown-item waves-effect text-primary editar-revision" ` +
              `href="/edit_revision_consejo/${full['id_revision']}" ` +
              `data-id="${full['id_revision']}" ` +
              `data-tipo="${full['tipo_dictamen']}" ` +
              `data-tipo_revision="${full['tipo_revision']}" ` +
              `data-accion="editar" ` +  // Identificador

              `>` +
              '<i class="ri-pencil-fill ri-20px text-primary"></i> Editar Revisión' +
              '</a>' +

              // Botón para Historial
              `<a data-id='${full['id_revision']}' class="dropdown-item waves-effect text-warning abrir-historial" ` +
              `data-bs-toggle="modal" data-bs-target="#historialModal">` +
              '<i class="ri-history-line text-warning"></i> Historial' +
              '</a>' +
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'desc']],
      dom:
        '<"card-header d-flex rounded-0 flex-wrap pb-md-0 pt-0"' +
        '<"me-5 ms-n2"f>' +
        '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center gap-4"l>>' +
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

      // Opciones Exportar Documentos

      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Detalles de Certificado: ' + data['num_certificado'];
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
  }

  // FUNCIONES DEL FUNCIONAMIENTO DEL CRUD

  dt_user.on('draw', function () {
    // Inicializa todos los tooltips después de cada redibujado
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
  // Inicializacion Elementos
  function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
      });
    });
  }

  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
  });

  // Registrar Respuesta y mostrar PDF correspondiente
  let id_revision;
  $(document).on('click', '.cuest', function () {
    id_revision = $(this).data('id');
    let tipo = $(this).data('tipo');
    console.log('ID de Revisión:', id_revision);
    console.log('Tipo:', tipo);
    $('#modal-loading-spinner').show();
    $('#pdfViewerFrame').hide();

    $('#Registrar').show();
    $('#Editar').hide();

    // Genera un parámetro único para evitar el caché
    let timestamp = new Date().getTime();
    let tipoRevision = $(this).data('tipo_revision');
    let url;

    // Decide la URL del PDF según el tipo de revisión
    if (tipoRevision === 'RevisorGranel') {
      url = `/Pre-certificado/${id_revision}?t=${timestamp}`;
    } else {
      url = `/get-certificado-url/${id_revision}/${tipo}?t=${timestamp}`;
    }

    $.ajax({
      url: url,
      type: 'GET',
      success: function (response) {
        if (tipoRevision === 'RevisorGranel') {
          $('#pdfViewerFrame').attr('src', url + '#zoom=80');
          console.log('PDF cargado (Granel): ' + url);
        } else if (response.certificado_url) {
          let uniqueUrl = response.certificado_url + '?t=' + timestamp;
          $('#pdfViewerFrame').attr('src', uniqueUrl + '#zoom=80');
          console.log('PDF cargado: ' + uniqueUrl);
        } else {
          console.log('No se encontró el certificado para la revisión ' + id_revision);
        }
      },
      error: function (xhr) {
        console.error('Error al obtener la URL del certificado: ', xhr.responseText);
      },
      complete: function () {
        $('#pdfViewerFrame').on('load', function () {
          $('#modal-loading-spinner').hide();
          $(this).show();
        });
      }
    });

    // Ajuste de títulos y visibilidad según el tipo de revisión
    if (tipoRevision === 'Revisor') {
      $('#modalFullTitle').text('REVISIÓN POR PARTE DEL PERSONAL DEL OC PARA LA DECISIÓN DE LA CERTIFICACIÓN (INSTALACIONES)');
      $('tbody#revisor').show();
      $('tbody#revisorGranel').hide();
      cargarRespuestas(id_revision);
    } else if (tipoRevision === 'RevisorGranel') {
      $('#modalFullTitle').text('REVISIÓN POR PARTE DEL PERSONAL DEL OC PARA LA DECISIÓN DE LA CERTIFICACIÓN (GRANEL)');
      $('tbody#revisorGranel').show();
      $('tbody#revisor').hide();
    }
  });

  $(document).on('click', '#registrarRevisionConsejo', function () {
    if (typeof id_revision === 'undefined') {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'El ID de revisión no está definido.',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
      return;
    }

    const respuestas = {};
    const observaciones = {};
    const rows = $('#fullscreenModal .table-container table tbody tr');
    let todasLasRespuestasSonC = true;
    let valid = true;

    rows.each(function (index) {
      // Verificar si la fila está visible antes de realizar la validación
      if ($(this).is(':visible')) {
        let respuesta = $(this).find('select').val();
        const observacion = $(this).find('textarea').val();

        if (!respuesta) {
          $(this).find('select').addClass('is-invalid');
          valid = false;
        } else {
          $(this).find('select').removeClass('is-invalid');
        }

        if (respuesta === '1') {
          respuesta = 'C';
        } else if (respuesta === '2') {
          respuesta = 'NC';
          todasLasRespuestasSonC = false;
        } else if (respuesta === '3') {
          respuesta = 'NA';
          todasLasRespuestasSonC = false;
        } else {
          respuesta = null;
          todasLasRespuestasSonC = false;
        }

        respuestas[`pregunta${index + 1}`] = respuesta;
        observaciones[`pregunta${index + 1}`] = observacion || null;
      }
    });

    if (!valid) {
      Swal.fire({
        icon: 'error',
        title: '¡Error!',
        text: 'Por favor, completa todos los campos requeridos.',
        customClass: {
          confirmButton: 'btn btn-danger'
        }
      });
      return;
    }

    const decision = todasLasRespuestasSonC ? 'positiva' : 'negativa';

    console.log({
      id_revision: id_revision,
      respuestas: respuestas,
      observaciones: observaciones,
      decision: decision
    });

    $.ajax({
      url: '/revisor/registrar-respuestas-consejo',
      type: 'POST',
      contentType: 'application/json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: JSON.stringify({
        id_revision: id_revision,
        respuestas: respuestas,
        observaciones: observaciones,
        decision: decision
      }),
      success: function (response) {
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: response.message,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });

        $('#fullscreenModal').modal('hide');
        $('.datatables-users').DataTable().ajax.reload();
      },
      error: function (xhr) {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: 'Error al registrar las respuestas: ' + xhr.responseJSON.message,
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
      }
    });
  });

  // Quitar Validacion al llenar Select
  $(document).on('change', 'select[name^="respuesta"], textarea[name^="observaciones"], select[name^="tipo"]', function () {
    $(this).removeClass('is-invalid');
  });

  // Limpiar Validacion al cerrar Modal
  $(document).on('hidden.bs.modal', '#fullscreenModal', function () {
    const respuestas = document.querySelectorAll('select[name^="respuesta"]');
    respuestas.forEach((respuesta) => {
      respuesta.classList.remove('is-invalid');
      respuesta.value = '';
    });
  });

  function cargarRespuestas(id_revision) {
    $.ajax({
      url: `/revisor/obtener-respuestas-consejo/${id_revision}`,
      type: 'GET',
      success: function (response) {
        const respuestasGuardadas = response.respuestas || {};
        const rows = $('#fullscreenModal .table-container table tbody tr');

        // Recorre cada fila de la tabla
        rows.each(function (index) {
          const respuestaKey = `pregunta${index + 1}`;
          const respuestaGuardada = respuestasGuardadas[respuestaKey]?.respuesta || '';
          const observacionGuardada = respuestasGuardadas[respuestaKey]?.observacion || '';

          // Establece la respuesta en el select
          let respuestaSelect = '';
          if (respuestaGuardada === 'C') {
            respuestaSelect = '1';
          } else if (respuestaGuardada === 'NC') {
            respuestaSelect = '2';
          } else if (respuestaGuardada === 'NA') {
            respuestaSelect = '3';
          }

          $(this).find('select').val(respuestaSelect || ''); // Asigna la respuesta
          $(this).find('textarea').val(observacionGuardada); // Asigna la observación
        });

        // Establecer la decisión si está disponible
        const decision = response.decision || null;
        $('#floatingSelect').val(decision);
      },
      error: function (xhr) {
        console.error('Sin Respuestas');
      }
    });
  }

  //Abrir PDF Bitacora
  $(document).on('click', '.pdf', function () {
    var id_revisor = $(this).data('id');
    var tipoRevision = $(this).data('tipo_revision'); // Nuevo: tipo de revisión
    var num_certificado = $(this).data('num-certificado');

    console.log('ID del Revisor:', id_revisor);
    console.log('Tipo de Revisión:', tipoRevision);
    console.log('Número de Certificado:', num_certificado);

    // Definir URL según el tipo de revisión
    if (tipoRevision === 'Instalaciones de productor' || tipoRevision === 'Instalaciones de envasador' || tipoRevision === 'Instalaciones de comercializador' || tipoRevision === 'Instalaciones de almacén o bodega' || tipoRevision === 'Instalaciones de área de maduración') {
      var url_pdf = '../pdf_bitacora_revision_certificado_instalaciones/' + id_revisor;
    }

    if (tipoRevision === 'Granel') {
      var url_pdf = '../pdf_bitacora_revision_certificado_granel/' + id_revisor;
    }
    if (tipoRevision === 'Exportación') {
      var url_pdf = '../pdf_bitacora_revision_certificado_exportacion/' + id_revisor;
    }


    console.log('URL del PDF:', url_pdf);

    // Configurar encabezados del modal
    $('#titulo_modal_Dictamen').text("Bitácora de revisión documental");
    $('#subtitulo_modal_Dictamen').text(num_certificado);

    // Configurar botón para abrir PDF
    var openPdfBtn = $('#NewPestana');
    openPdfBtn.attr('href', url_pdf);
    openPdfBtn.show();

    // Mostrar modal de PDF
    $('#mostrarPdf').modal('show');
    $('#cargando').show();
    $('#pdfViewer').hide();

    // Cargar PDF en iframe

    $('#pdfViewer').attr('src', url_pdf);
  });

  // Ocultar spinner y mostrar PDF cuando el iframe se haya cargado
  $('#pdfViewer').on('load', function () {
    $('#cargando').hide();
    $('#pdfViewer').show();
  });

  // Abrir modal Aprobacion
  $(document).on('click', '.Aprobacion-record', function () {
    const idRevision = $(this).data('id');
    const certificado = $(this).data('num-certificado');
    const select2Elements = $('#id_firmante');
    initializeSelect2(select2Elements);

    $('#modalAprobacionConsejo').modal('show');
    $('#numero-certificado').text(certificado);
    $('#btnRegistrar').data('id-revisor', idRevision);

    // Cargar los datos de aprobación
    $.ajax({
      url: `/aprobacion-consejo/${idRevision}`,
      method: 'GET',
      success: function (data) {
        $('#id_firmante').val(data.revisor.id_aprobador || '').trigger('change');
        $('#respuesta-aprobacion').val(data.revisor.aprobacion || '').prop('selected', true);
        if (data.revisor.fecha_aprobacion && data.revisor.fecha_aprobacion !== '0000-00-00') {
          $('#fecha-aprobacion').val(data.revisor.fecha_aprobacion);
        } else {
          $('#fecha-aprobacion').val('');
        }
      },
      error: function (xhr) {
        console.error(xhr.responseJSON.message);
        alert('Error al cargar los datos de la aprobación.');
      }
    });
  });

  // Registrar Aprobacion
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation
    const form = document.getElementById('formAprobacionConsejo');
    const fv = FormValidation.formValidation(form, {
      fields: {
        'respuesta-aprobacion': {
          validators: {
            notEmpty: {
              message: 'Selecciona una respuesta de aprobación.'
            }
          }
        },
        'fecha-aprobacion': {
          validators: {
            notEmpty: {
              message: 'Por favor, ingresa una fecha de aprobación.'
            },
            date: {
              format: 'YYYY-MM-DD',
              message: 'Por favor, ingresa una fecha válida en formato AAAA-MM-DD.'
            }
          }
        },
        'id_firmante': {
          validators: {
            notEmpty: {
              message: 'Por favor, selecciona la persona que aprueba.'
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
    }).on('core.form.valid', function () {
      const idRevisor = $('#btnRegistrar').data('id-revisor');
      const aprobacion = $('#respuesta-aprobacion').val();
      const fechaAprobacion = $('#fecha-aprobacion').val();
      const idAprobador = $('#id_firmante').val();

      $.ajax({
        url: '/registrar-aprobacion-consejo',
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          id_revisor: idRevisor,
          aprobacion: aprobacion,
          fecha_aprobacion: fechaAprobacion,
          id_aprobador: idAprobador
        },
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Aprobación registrada exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
          $('#modalAprobacionConsejo').modal('hide');
          form.reset();
          $('.select2').val(null).trigger('change');
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: xhr.responseJSON.message,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
        }
      });
    });

    // Revalidaciones
    $('#id_firmante').on('change', function () {
      if ($(this).val()) {
        fv.revalidateField($(this).attr('name'));
      }
    });

    $('#respuesta-aprobacion').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });

    $('#fecha-aprobacion').on('change', function () {
      fv.revalidateField($(this).attr('name'));
    });
  });

  // Limpiar campos al cerrar el modal
  $('#modalAprobacionConsejo').on('hidden.bs.modal', function () {
    $('#id_firmante, #respuesta-aprobacion, #fecha-aprobacion').val('');
    $('#respuesta-aprobacion').prop('selected', true);
  });


  // Historial
  $(document).on('click', '.abrir-historial', function () {
    const id_revision = $(this).data('id');
    console.log('ID de revisión clicado:', id_revision);
    $('#historialModalCosnejo').modal('show');
  });

  function cargarHistorial(id_revision) {
    console.log('Cargando historial para ID de revisión:', id_revision);
    $('#historialRespuestasContainer').html('<p>Cargando historial...</p>');
    $('#respuestasContainer').html('');

    $.ajax({
      url: `/obtener/historial-consejo/${id_revision}`,
      method: 'GET',
      success: function (data) {
        console.log('Datos recibidos:', data);
        if (!data.respuestas || data.respuestas.length === 0) {
          $('#historialRespuestasContainer').html('<p>No hay historial disponible.</p>');
          return;
        }

        let botonesHTML = '';
        if (!data.respuestas[0].respuestas || Object.keys(data.respuestas[0].respuestas).length === 0) {
          $('#historialRespuestasContainer').html('<p>No hay historial disponible para esta revisión.</p>');
          return;
        }

        data.respuestas[0].respuestas.forEach(function (revisionItem) {
          botonesHTML += `
                <button class="btn btn-primary btn-lg mb-2"
                        data-revision="${revisionItem.nombre_revision}"
                        data-respuestas='${JSON.stringify(revisionItem.respuestas)}'>
                    <i class="fas fa-history"></i> ${revisionItem.nombre_revision}
                </button>
            `;
        });


        $('#historialRespuestasContainer').html(botonesHTML);
        $('.btn-primary').on('click', function () {
          const respuestas = $(this).data('respuestas');
          mostrarRespuestas(respuestas);
        });
      },
      error: function (xhr) {
        $('#historialRespuestasContainer').html('<p>Error al cargar el historial.</p>');
        $('#respuestasContainer').html('');
        console.error('Error al cargar el historial:', xhr);
      }
    });
  }

  function mostrarRespuestas(respuestas) {
    if (typeof respuestas === 'string') {
      respuestas = JSON.parse(respuestas);
    }

    let respuestasHTML = `
          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead class="table-light">
                      <tr>
                          <th class="text-start">#</th>
                          <th class="text-start">Pregunta</th>
                          <th class="text-center">C</th>
                          <th class="text-center">NC</th>
                          <th class="text-center">NA</th>
                          <th class="text-start">Observaciones</th>
                      </tr>
                  </thead>
                  <tbody>
      `;

    respuestas.forEach((item, index) => {
      const respuesta = item.respuesta;
      const observacion = item.observacion ? item.observacion : '---';

      respuestasHTML += `
                <tr>
                    <td class="text-start">${index + 1}</td>
                    <td>${item.pregunta}</td>
                    <td class="text-center">${respuesta === 'C' ? 'C' : '---'}</td>
                    <td class="text-center ${respuesta === 'NC' ? 'text-danger' : ''}">${respuesta === 'NC' ? 'NC' : '---'}</td>
                    <td class="text-center">${respuesta === 'NA' ? 'NA' : '---'}</td>
                    <td class="text-start">${observacion}</td>
                </tr>
            `;
    });

    respuestasHTML += `
                    </tbody>
                </table>
            </div>
        `;

    document.getElementById('respuestasContainer').innerHTML = respuestasHTML;
  }


  // Editar Respuestas
  let id_revision_edit;
  $(document).on('click', '.abrir-historial', function () {
    id_revision_edit = $(this).data('id');
    console.log('ID de revisión clicado:', id_revision_edit);
    cargarHistorial(id_revision_edit);
    $('#historialModalConsejo').modal('show');
  });




  // Quitar Validación al llenar Select
  $(document).on('change', 'select[name^="respuesta"], textarea[name^="observaciones"], select[name^="tipo"]', function () {
    $(this).removeClass('is-invalid');
  });

  /*   // Limpiar Validación al cerrar Modal
    $(document).on('hidden.bs.modal', '#fullscreenModal', function () {
      const respuestas = document.querySelectorAll('select[name^="respuesta"]');
      respuestas.forEach((respuesta) => {
        respuesta.classList.remove('is-invalid');
        respuesta.value = '';
      });
    }); */


  /* $(function () {
    // Configuración de AJAX para enviar el token CSRF
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Inicializar FormValidation en el formulario
    const form = document.getElementById('formularioConsejo');
    const fv = FormValidation.formValidation(form, {
      fields: {
        'respuesta[]': {
          validators: {
            notEmpty: {
              message: 'Selecciona una respuesta.'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.resp'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      $('#btnAddRevConse').addClass('d-none');
      $('#btnSpinnerRevConse').removeClass('d-none');
      // Crear un objeto FormData con todos los datos del formulario
      const formData = new FormData(form);

      // Enviar la solicitud AJAX con todos los datos del formulario
      $.ajax({
        url: '/registrar_revision_consejo',
        type: 'POST',
        data: formData,
        contentType: false,  // Importante para enviar los datos correctamente
        processData: false,  // Importante para evitar la transformación de los datos en cadena de consulta
        success: function (response) {
          $('#btnSpinnerRevConse').addClass('d-none');
          $('#btnAddRevConse').removeClass('d-none');
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Revisión registrada exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          }).then(() => {
            // Redirigir a la ruta después de mostrar el mensaje de éxito
            window.location.href = '/revision/consejo';
          });
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: xhr.responseJSON.message,
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#btnSpinnerRevConse').addClass('d-none');
          $('#btnAddRevConse').removeClass('d-none');
        }
      });

    });



  }); */


  //end
});

'use strict';

$(function () {
  // Configuración de AJAX para enviar el token CSRF
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Inicializar FormValidation en el formulario
  const form = document.getElementById('formularioConsejo');
  const fv = FormValidation.formValidation(form, {
    fields: {
      'respuesta[]': {
        validators: {
          notEmpty: {
            message: 'Selecciona una respuesta.'
          }
        }
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        eleInvalidClass: 'is-invalid',
        rowSelector: '.resp'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // Este evento se dispara cuando el formulario es válido
    $('#btnAddRevConse').addClass('d-none');
    $('#btnSpinnerRevConse').removeClass('d-none');
    // Crear un objeto FormData con todos los datos del formulario
    const formData = new FormData(form);

    // Enviar la solicitud AJAX con todos los datos del formulario
    $.ajax({
      url: '/registrar_revision_consejo',
      type: 'POST',
      data: formData,
      contentType: false,  // Importante para enviar los datos correctamente
      processData: false,  // Importante para evitar la transformación de los datos en cadena de consulta
      success: function (response) {
        $('#btnSpinnerRevConse').addClass('d-none');
        $('#btnAddRevConse').removeClass('d-none');
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Revisión registrada exitosamente.',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        }).then(() => {
          // Redirigir a la ruta después de mostrar el mensaje de éxito
          window.location.href = '/revision/consejo';
        });
      },
      error: function (xhr) {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: xhr.responseJSON.message,
          customClass: {
            confirmButton: 'btn btn-danger'
          }
        });
        $('#btnSpinnerRevConse').addClass('d-none');
        $('#btnAddRevConse').removeClass('d-none');
      }
    });

  });



});



'use strict';

$(function () {
  // Configuración de AJAX para enviar el token CSRF
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Inicializar FormValidation en el formulario de edición
  const formEditar = document.getElementById('formularioEditarConsejo');
  if (formEditar) {
    const fvEditar = FormValidation.formValidation(formEditar, {
      fields: {
        'respuesta[]': {
          validators: {
            notEmpty: {
              message: 'Selecciona una respuesta.'
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          eleInvalidClass: 'is-invalid',
          rowSelector: '.resp'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      }
    }).on('core.form.valid', function () {
      // Este evento se dispara cuando el formulario es válido
      $('#btnEditRevConse').addClass('d-none');
      $('#btnSpinnerRevConseEdit').removeClass('d-none');
      // Crear un objeto FormData con todos los datos del formulario
      const formData = new FormData(formEditar);

      // Enviar la solicitud AJAX con todos los datos del formulario
      $.ajax({
        url: '/editar_revision_consejo',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Revisión editada exitosamente.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          }).then(() => {
            // Redirigir a la ruta después de mostrar el mensaje de éxito
            window.location.href = '/revision/consejo';
          });
          $('#btnSpinnerRevConseEdit').addClass('d-none');
          $('#btnEditRevConse').removeClass('d-none');
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: xhr.responseJSON?.message || 'Ocurrió un error al editar la revisión.',
            customClass: {
              confirmButton: 'btn btn-danger'
            }
          });
          $('#btnSpinnerRevConseEdit').addClass('d-none');
          $('#btnEditRevConse').removeClass('d-none');
        }
      });

    });
  }
});


