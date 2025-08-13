document.addEventListener('DOMContentLoaded', function () {
    // Definición de elementos y variables principales
    const formAgregarEmpresa = document.getElementById('formAgregarContacto');
    const agregarEmpresaModalElement = document.getElementById('agregarEmpresa');
    const editHistorialModalElement = document.getElementById('editHistorialModal');
    const viewHistorialModalElement = document.getElementById('viewHistorialModal');
    const exportModalElement = document.getElementById('modal-add-export_clientes_empresas');
    const viewPdfModalElement = document.getElementById('viewPdfModal');
    const editHistorialModalContent = document.getElementById('editHistorialModalContent');
    const viewHistorialModalContent = document.getElementById('viewHistorialModalContent');

    const agregarEmpresaModal = agregarEmpresaModalElement ? new bootstrap.Modal(agregarEmpresaModalElement) : null;
    const editHistorialModal = editHistorialModalElement ? new bootstrap.Modal(editHistorialModalElement) : null;
    const viewHistorialModal = viewHistorialModalElement ? new bootstrap.Modal(viewHistorialModalElement) : null;
    const exportModal = exportModalElement ? new bootstrap.Modal(exportModalElement) : null;
    const viewPdfModal = viewPdfModalElement ? new bootstrap.Modal(viewPdfModalElement) : null;

    let contactIndex = 0;
    let dataTable;

    // --- Funciones Auxiliares Centralizadas ---

    /**
     * Limpia los mensajes de error y las clases 'is-invalid' de un formulario.
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function clearValidationErrors(formElement) {
        formElement.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        $(formElement).find('.select2-container .select2-selection--single').removeClass('is-invalid');
        formElement.querySelectorAll('.invalid-feedback').forEach(el => el.innerHTML = '');
    }

    /**
     * Muestra los errores de validación en el formulario.
     * @param {object} errors - Objeto con los errores de validación (campo: [mensajes]).
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function displayValidationErrors(errors, formElement) {
        clearValidationErrors(formElement);
        for (const [fieldName, messages] of Object.entries(errors)) {
            const htmlFieldName = fieldName.includes('contactos.') ?
                fieldName.replace(/contactos\.(\d+)\.(.*)/, 'contactos[$1][$2]') :
                fieldName;

            const inputElement = formElement.querySelector(`[name="${htmlFieldName}"]`);
            if (inputElement) {
                inputElement.classList.add('is-invalid');
                if ($(inputElement).hasClass('select2') || $(inputElement).is('select')) {
                    $(inputElement).next('.select2-container').find('.select2-selection--single').addClass('is-invalid');
                }
                const feedbackElement = inputElement.nextElementSibling;
                if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                    feedbackElement.innerHTML = messages.join('<br>');
                }
            } else {
                console.warn(`Elemento HTML con name="${htmlFieldName}" no encontrado.`);
            }
        }
    }

    /**
     * Muestra un SweetAlert para errores.
     * @param {string} title - El título del error.
     * @param {string} message - El mensaje de error.
     */
    function showSweetAlertError(title, message) {
        Swal.fire({
            icon: 'error',
            title: title,
            html: message,
            customClass: { confirmButton: 'btn btn-danger' }
        });
    }

    /**
     * Actualiza el contador de clientes y recarga la tabla.
     * Esta función centraliza toda la lógica de actualización de la UI.
     */
    function updateUI() {
        if (dataTable) {
            dataTable.ajax.reload(null, false);
        }
        updateClientStats();
    }

    /**
     * Envía una petición de formulario mediante AJAX.
     * @param {HTMLFormElement} form - El formulario a enviar.
     * @param {string} url - La URL del endpoint.
     * @param {object} [options={}] - Opciones adicionales para la petición.
     */
    async function submitForm(form, url, options = {}) {
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonHtml = submitButton.innerHTML;
        const loadingHtml = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

        submitButton.innerHTML = loadingHtml;
        submitButton.disabled = true;
        clearValidationErrors(form);

        try {
            const formData = new FormData(form);
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    ...options.headers
                }
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    displayValidationErrors(data.errors, form);
                } else {
                    throw new Error(data.message || 'Error inesperado.');
                }
            } else {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    customClass: { confirmButton: 'btn btn-success' }
                });
                return true;
            }
        } catch (error) {
            console.error('Error en la petición:', error);
            showSweetAlertError('¡Error!', `Hubo un problema al guardar los datos: ${error.message}`);
        } finally {
            submitButton.innerHTML = originalButtonHtml;
            submitButton.disabled = false;
        }
        return false;
    }

    /**
     * Añade una nueva fila de contacto a un contenedor.
     * @param {string} containerId - El ID del contenedor.
     * @param {object} [data={}] - Datos predefinidos para la fila.
     * @param {boolean} [isViewMode=false] - Si la fila es de solo lectura.
     */
    function addContactRow(containerId, data = {}, isViewMode = false) {
        const container = document.getElementById(containerId);
        if (!container) {
            console.error(`Contenedor con ID "${containerId}" no encontrado.`);
            return;
        }

        const template = document.getElementById('contact-row-template');
        const clone = template.content.cloneNode(true);
        const newRow = clone.querySelector('.contact-row');

        const prefix = `contactos[${contactIndex}]`;
        $(newRow).find('[name^="contactos[INDEX]"]').each(function() {
            $(this).attr('name', $(this).attr('name').replace('INDEX', contactIndex));
        });

        if (data.contacto) newRow.querySelector('[name$="[contacto]"]').value = data.contacto;
        if (data.celular) newRow.querySelector('[name$="[celular]"]').value = data.celular;
        if (data.correo) newRow.querySelector('[name$="[correo]"]').value = data.correo;
        const statusField = newRow.querySelector('[name$="[status]"]');
        if (statusField) statusField.value = data.status !== undefined ? data.status.toString() : '0';
        if (data.observaciones) newRow.querySelector('[name$="[observaciones]"]').value = data.observaciones;

        if (isViewMode) {
            $(newRow).find('input, select, textarea').prop('disabled', true);
            $(newRow).find('.remove-contact-row').remove();
        } else {
            newRow.querySelector('.remove-contact-row').addEventListener('click', () => newRow.remove());
        }

        container.appendChild(newRow);
        const selectElement = $(newRow).find('select');
        selectElement.select2({
            minimumResultsForSearch: Infinity,
            dropdownParent: selectElement.closest('td')
        });
        contactIndex++;
    }

    /**
     * Actualiza el contador de clientes en los cuadros de estadísticas.
     */
    async function updateClientStats() {
        if (typeof estadisticasClientesUrl === 'undefined') {
            console.warn("'estadisticasClientesUrl' no está definida. No se pueden actualizar las estadísticas.");
            return;
        }
        try {
            const response = await fetch(estadisticasClientesUrl);
            if (!response.ok) throw new Error('Error al obtener las estadísticas.');
            const data = await response.json();
            if (data) {
                // Actualizar los contadores en las tarjetas
                animateCounter('#clientesActivosCount', data.clientesActivos);
                animateCounter('#personasFisicasCount', data.personasFisicas);
                animateCounter('#otrosRegimenesCount', data.otrosRegimenes);
                animateCounter('#clientesInactivosCount', data.clientesInactivos);
                $('#totalEmpresasCount').text(data.total);
            }
        } catch (error) {
            console.error('Error al actualizar las estadísticas:', error);
        }
    }

    // Función para animar el conteo de números (ya la tenías)
    function animateCounter(selector, targetValue) {
        const element = $(selector);
        const startValue = 0;
        const duration = 1000;
        const increment = targetValue / (duration / 16);
        let currentValue = startValue;

        const timer = setInterval(function() {
            currentValue += increment;
            if (currentValue >= targetValue) {
                currentValue = targetValue;
                clearInterval(timer);
            }
            element.text(Math.floor(currentValue));
        }, 16);
    }

    /**
     * Muestra el modal con el formulario de edición cargado vía AJAX.
     * @param {number} id - El ID del cliente a editar.
     */
    async function showEditModal(id) {
        editHistorialModalContent.innerHTML = `<div class="modal-body text-center py-5">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>
            <p class="mt-2">Cargando formulario de edición...</p>
        </div>`;
        editHistorialModal.show();

        try {
            const response = await fetch(`/empresas/${id}/edit-modal`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } });
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText || `Error ${response.status}: ${response.statusText}`);
            }

            editHistorialModalContent.innerHTML = await response.text();
            const form = document.getElementById('editarhistorial');
            contactIndex = form.querySelectorAll('.contact-row').length;

            form.querySelectorAll('.remove-contact-row').forEach(btn => btn.addEventListener('click', () => btn.closest('.contact-row').remove()));
            $('#editarhistorial .select2').select2({ dropdownParent: editHistorialModalElement });
            form.querySelectorAll('.contact-row select').forEach(select => $(select).select2({ minimumResultsForSearch: Infinity, dropdownParent: $(select).closest('td') }));
            document.getElementById('add-contact-row-editar').addEventListener('click', () => addContactRow('contact-rows-container-editar'));

            // Listener para el submit del formulario de edición.
            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                // Realiza la petición AJAX para editar
                const success = await submitForm(this, `/empresas/${id}`, {
                    successButtonText: '<i class="ri-add-line"></i> Actualizar Empresa'
                });
                if (success) {
                    editHistorialModal.hide();

                    updateUI();
                }
            });
        } catch (error) {
            console.error('Error al cargar el formulario de edición:', error);
            editHistorialModalContent.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar: ${error.message}</div></div>`;
        }
    }

    /**
     * Muestra el modal con la información de visualización cargada vía AJAX.
     * @param {number} id - El ID del cliente a visualizar.
     */
    async function showViewModal(id) {
        viewHistorialModalContent.innerHTML = `<div class="modal-body text-center py-5">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>
            <p class="mt-2">Cargando información de la empresa...</p>
        </div>`;
        viewHistorialModal.show();

        try {
            const response = await fetch(`/empresas/${id}/view-modal`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } });
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText || response.statusText);
            }

            viewHistorialModalContent.innerHTML = await response.text();
            const contactRows = document.getElementById('contact-rows-container-view');
            if (contactRows) {
                $(contactRows).find('select').each(function() {
                    $(this).select2({ minimumResultsForSearch: Infinity, dropdownParent: $(this).closest('td') });
                });
            }
        } catch (error) {
            console.error('Error al cargar la vista del historial:', error);
            viewHistorialModalContent.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar los detalles: ${error.message || 'Error desconocido'}</div></div>`;
        }
    }

    /**
     * Muestra el modal del visor de PDF.
     * @param {string} pdfUrl - La URL del PDF a mostrar.
     */
    function showPdfViewer(pdfUrl) {
        const pdfViewerFrame = document.getElementById('pdfViewerFrame');
        const openPdfInNewTabBtn = document.getElementById('openPdfInNewTabBtn');
        const pdfLoadingMessage = document.getElementById('pdfLoadingMessage');

        pdfLoadingMessage.innerText = 'Cargando contenido... Si no se muestra, usa "Abrir en otra pestaña".';
        pdfLoadingMessage.style.display = 'block';
        pdfViewerFrame.style.display = 'none';
        pdfViewerFrame.src = pdfUrl;
        openPdfInNewTabBtn.href = pdfUrl;

        pdfViewerFrame.onload = () => {
            pdfLoadingMessage.style.display = 'none';
            pdfViewerFrame.style.display = 'block';
        };
        pdfViewerFrame.onerror = () => {
            pdfLoadingMessage.innerText = 'Error al cargar el contenido. Por favor, haz clic en "Abrir en otra pestaña".';
            pdfLoadingMessage.style.display = 'block';
            pdfViewerFrame.style.display = 'none';
        };

        viewPdfModal.show();
    }

    /**
     * Realiza una petición AJAX para cambiar el estado de un cliente (alta/baja).
     * @param {number} id - El ID del cliente.
     * @param {string} endpoint - El endpoint de la API ('baja' o 'alta').
     * @param {string} title - El título de la confirmación.
     * @param {string} text - El texto de la confirmación.
     * @param {string} confirmText - El texto del botón de confirmación.
     * @param {string} successTitle - El título del mensaje de éxito.
     * @param {string} successIcon - El icono del mensaje de éxito.
     */
    async function toggleClientStatus(id, endpoint, title, text, confirmText, successTitle, successIcon) {
        Swal.fire({
            title: title,
            text: text,
            icon: successIcon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmText,
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/empresas/${id}/${endpoint}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || `Error al realizar la operación de ${endpoint}.`);
                    }

                    Swal.fire({
                        icon: 'success',
                        title: successTitle,
                        text: data.message,
                        customClass: { confirmButton: 'btn btn-success' }
                    });

                    // Recarga la UI después de cambiar el estado.
                    updateUI();

                } catch (error) {
                    console.error(`Error en la petición de ${endpoint}:`, error);
                    showSweetAlertError('¡Error!', `Hubo un problema: ${error.message}`);
                }
            }
        });
    }

    // --- Lógica del CRUD y Event Listeners ---

    // Inicializar DataTables
    dataTable = $('#tablaHistorial').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            lengthMenu: '_MENU_',
        },
        processing: true,
        serverSide: true,
        responsive: false,
        ajax: { url: dataTableAjaxUrl, type: "GET" },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '25px', className: 'text-center' },
            {
                data: 'nombre',
                name: 'nombre',
                width: '100px',
                className: 'text-wrap',
                render: (data, type, row) => {
                    const iconHtml = row.estado_cliente === 0 ? `<i class="ri-user-forbid-line text-danger me-2"></i>` : '';
                    return `${iconHtml}${data}`;
                }
            },
            { data: 'rfc', name: 'rfc', width: '80px', className: 'text-center' },
            { data: 'calle', name: 'calle', width: '100px', className: 'text-wrap' },
            { data: 'colonia', name: 'colonia', width: '80px', className: 'text-wrap' },
            { data: 'localidad', name: 'localidad', width: '70px', className: 'text-wrap' },
            { data: 'municipio', name: 'municipio', width: '70px', className: 'text-wrap' },
            {
                data: 'constancia',
                name: 'constancia',
                width: '120px',
                className: 'text-wrap text-center',
                render: (data) => {
                    const imageUrl = data ? '/assets/img/icons/misc/pdf.png' : '/img_pdf/FaltaPDF.png';
                    const buttonClass = data ? '' : 'btn-no-border';
                    return `<button type="button" class="btn btn-icon waves-effect waves-light view-pdf-btn ${buttonClass}" data-pdf-url="${data || '/img_pdf/FaltaPDF.png'}">
                                <img src="${imageUrl}" alt="Ver PDF" style="width: 40px; height: auto;">
                            </button>`;
                }
            },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                width: '140px',
                className: 'text-center',
                render: (data) => {
                    const actionButton = data.estado_cliente === 0
                        ? `<li><a href="javascript:void(0)" class="dropdown-item text-success btn-dar-de-alta" data-id="${data.id}"><i class="ri-check-line me-1"></i> Dar de Alta</a></li>`
                        : `<li><a href="javascript:void(0)" class="dropdown-item text-danger btn-dar-de-baja" data-id="${data.id}"><i class="ri-delete-bin-line me-1"></i> Dar de Baja</a></li>`;

                    return `<div class="dropdown">
                                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end p-0">
                                    <li><a href="javascript:void(0)" class="dropdown-item py-2 btn-view-unidad" data-id="${data.id}"><i class="ri-search-line me-1 text-muted"></i> Visualizar</a></li>
                                    <li><a href="javascript:void(0)" class="dropdown-item py-2 btn-edit-unidad" data-id="${data.id}"><i class="ri-edit-box-line me-1 text-info"></i> Editar</a></li>
                                    ${actionButton}
                                </ul>
                            </div>`;
                }
            }
        ],
        rowCallback: (row, data) => {
            $(row).toggleClass('table-danger', data.estado_cliente === 0);
        },
        dom: '<"row"<"col-sm-12 col-md-6 d-flex justify-content-start"f><"col-sm-12 col-md-6 d-flex justify-content-end"l>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
    });

    // Carga inicial de estadísticas
    updateClientStats();

    // Evento para el formulario de agregar empresa
    if (formAgregarEmpresa) {
        formAgregarEmpresa.addEventListener('submit', async function(event) {
            event.preventDefault();
            const success = await submitForm(this, this.action, {
                successButtonText: '<i class="ri-add-line"></i> Agregar Contacto'
            });
            if (success) {
                agregarEmpresaModal.hide();
                // Se llama a la función centralizada de actualización de la UI
                updateUI();
            }
        });
    }

    // Eventos de modales
    if (agregarEmpresaModalElement) {
        agregarEmpresaModalElement.addEventListener('shown.bs.modal', () => {
            $('#agregarEmpresa .select2').select2({ dropdownParent: $('#agregarEmpresa') });
            contactIndex = 0;
            $('#contact-rows-container-agregar').empty();
            addContactRow('contact-rows-container-agregar');
        });
        agregarEmpresaModalElement.addEventListener('hidden.bs.modal', () => {
            clearValidationErrors(formAgregarEmpresa);
            formAgregarEmpresa.reset();
            $('#agregarEmpresa .select2').select2('destroy');
        });
        document.getElementById('add-contact-row-agregar').addEventListener('click', () => addContactRow('contact-rows-container-agregar'));
    }

    // Evento para el modal de exportación
    async function loadClientesForExportModal() {
        if (!clientesAjaxUrl) {
            console.warn("'clientesAjaxUrl' no está definida.");
            return;
        }
        const selectElement = document.getElementById('filtroCliente');
        if (!selectElement) {
            console.error("No se encontró el elemento 'filtroCliente'.");
            return;
        }
        $(selectElement).find('option:not(:first)').remove();
        try {
            const response = await fetch(clientesAjaxUrl);
            if (!response.ok) throw new Error('Error al obtener la lista de clientes.');
            const data = await response.json();
            data.forEach(cliente => {
                const option = document.createElement('option');
                option.value = cliente.id;
                option.textContent = cliente.nombre;
                selectElement.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar clientes:', error);
            const option = document.createElement('option');
            option.textContent = 'Error al cargar clientes';
            selectElement.appendChild(option);
        }
    }
    if (exportModalElement) {
        exportModalElement.addEventListener('shown.bs.modal', loadClientesForExportModal);
    }

    // --- Listeners para botones generados dinámicamente (usando delegación de eventos) ---
    $(document).on('click', '.view-pdf-btn', function(event) {
        event.preventDefault();
        const pdfUrl = $(this).data('pdf-url');
        if (pdfUrl) {
            showPdfViewer(pdfUrl);
        } else {
            console.warn('No se encontró la URL del contenido para este elemento.');
        }
    });

    $(document).on('click', '.btn-dar-de-baja', function() {
        const id = $(this).data('id');
        toggleClientStatus(id, 'baja', '¿Estás seguro?', '¡El cliente será dado de baja!', 'Sí, ¡dar de baja!', '¡Cliente dado de baja!', 'warning');
    });

    $(document).on('click', '.btn-dar-de-alta', function() {
        const id = $(this).data('id');
        toggleClientStatus(id, 'alta', '¿Estás seguro?', '¡El cliente será dado de alta de nuevo!', 'Sí, ¡dar de alta!', '¡Cliente dado de alta!', 'question');
    });

    $(document).on('click', '.btn-edit-unidad', function() {
        const id = $(this).data('id');
        showEditModal(id);
    });

    $(document).on('click', '.btn-view-unidad', function() {
        const id = $(this).data('id');
        showViewModal(id);
    });

    // Eventos para limpiar modales al ocultarse
    if (viewPdfModalElement) {
        viewPdfModalElement.addEventListener('hidden.bs.modal', function() {
            document.getElementById('pdfViewerFrame').src = '';
            document.getElementById('pdfLoadingMessage').style.display = 'none';
        });
    }

    if (editHistorialModalElement) {
        $('#editHistorialModal').on('hidden.bs.modal', function() {
            const form = document.getElementById('editarhistorial');
            if (form) {
                clearValidationErrors(form);
                const motivoEdicionField = form.querySelector('#motivoEdicion');
                if (motivoEdicionField) {
                    motivoEdicionField.value = '';
                }
                $(form).find('.select2, select').select2('destroy');
            }
        });
    }

    if (viewHistorialModalElement) {
        $('#viewHistorialModal').on('hidden.bs.modal', function() {
            const form = document.getElementById('visualizarhistorialForm');
            if (form) {
                $(form).find('.select2, select').select2('destroy');
            }
        });
    }

    // Evento para habilitar/deshabilitar el filtro de empresa
    document.getElementById('habilitar_filtro_empresa').addEventListener('change', function() {
        document.getElementById('empresa_id').disabled = !this.checked;
    });

    // MODIFICACIÓN ACTUALIZADA: Mover los botones junto al control de "Mostrar X registros"
    $('#tablaHistorial').on('init.dt', function () {
        // Obtener referencias a los elementos necesarios
        const dataTablesLength = $('.dataTables_length');
        const dataTablesFilter = $('.dataTables_filter');
        
        // Crear contenedor principal con flexbox
        const mainContainer = $('<div>').addClass('d-flex justify-content-between align-items-center w-100 mb-3');
        
        // Contenedor izquierdo para botones y selector de registros
        const leftContainer = $('<div>').addClass('d-flex align-items-center gap-2');
        
        // Clonar y preparar los botones (eliminando los originales para evitar duplicados)
        const botonAgregar = $('#agregarClienteBtn').length ? $('#agregarClienteBtn').clone() : null;
        const botonExportar = $('#btn-export-clientes').length ? $('#btn-export-clientes').clone() : null;
        
        // Eliminar botones originales si existen
        $('#agregarClienteBtn').remove();
        $('#btn-export-clientes').remove();
        
        // Agregar botones al contenedor izquierdo
        if (botonAgregar) {
            leftContainer.append(botonAgregar);
        }
        if (botonExportar) {
            leftContainer.append(botonExportar);
        }
        
        // Agregar el selector de "Mostrar X registros" al contenedor izquierdo
        leftContainer.append(dataTablesLength);
        
        // Agregar contenedores al contenedor principal
        mainContainer.append(leftContainer);
        mainContainer.append(dataTablesFilter);
        
        // Insertar el contenedor principal antes de la tabla
        $('#tablaHistorial').before(mainContainer);
        
        // Limpiar el div wrapper original de DataTables que puede estar vacío
        $('.dataTables_wrapper .row').first().hide();
    });
});