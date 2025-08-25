document.addEventListener('DOMContentLoaded', function () {
    // Definición de elementos y variables principales
    const formAgregarEmpresa = document.getElementById('formAgregarContacto');
    const agregarEmpresaModalElement = document.getElementById('agregarEmpresa');
    const editHistorialModalElement = document.getElementById('editHistorialModal');
    const viewHistorialModalElement = document.getElementById('viewHistorialModal');
    const viewPdfModalElement = document.getElementById('viewPdfModal');
    const exportModalElement = document.getElementById('exportarVentasModal');

    // Inicialización de modales
    const agregarEmpresaModal = agregarEmpresaModalElement ? new bootstrap.Modal(agregarEmpresaModalElement) : null;
    const editHistorialModal = editHistorialModalElement ? new bootstrap.Modal(editHistorialModalElement) : null;
    const viewHistorialModal = viewHistorialModalElement ? new bootstrap.Modal(viewHistorialModalElement) : null;
    const viewPdfModal = viewPdfModalElement ? new bootstrap.Modal(viewPdfModalElement) : null;
    const exportModal = exportModalElement ? new bootstrap.Modal(exportModalElement) : null;

    let contactIndex = 0;
    let dataTable;

    // --- Funciones Auxiliares Centralizadas ---

    /**
     * Limpia los mensajes de error y las clases 'is-invalid' de un formulario.
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function clearValidationErrors(formElement) {
        if (!formElement) return;
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
     */
    async function submitForm(form, url) {
        const submitButton = form.querySelector('button[type="submit"]');
        if (!submitButton) return false;

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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json' // Aseguramos que la respuesta sea JSON
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

        // Poblar datos si se proporcionan
        if (data.id) {
            const hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.name = `${prefix}[id]`;
            hiddenId.value = data.id;
            newRow.appendChild(hiddenId);
        }
        $(newRow).find('[name$="[contacto]"]').val(data.nombre_contacto || '');
        $(newRow).find('[name$="[celular]"]').val(data.telefono_contacto || '');
        $(newRow).find('[name$="[correo]"]').val(data.correo_contacto || '');
        $(newRow).find('[name$="[status]"]').val(data.status !== undefined ? data.status.toString() : '1');
        $(newRow).find('[name$="[observaciones]"]').val(data.observaciones || '');

        if (isViewMode) {
            $(newRow).find('input, select, textarea').prop('disabled', true);
            $(newRow).find('.remove-contact-row').remove();
        } else {
            newRow.querySelector('.remove-contact-row').addEventListener('click', () => newRow.remove());
        }

        container.appendChild(newRow);
        $(newRow).find('select').select2({
            minimumResultsForSearch: Infinity,
            dropdownParent: $(newRow).closest('.modal-content')
        });
        contactIndex++;
    }

    /**
     * Actualiza el contador de clientes en los cuadros de estadísticas.
     */
    async function updateClientStats() {
        if (typeof estadisticasClientesUrl === 'undefined') {
            return;
        }
        try {
            const response = await fetch(estadisticasClientesUrl);
            if (!response.ok) throw new Error('Error al obtener las estadísticas.');
            const data = await response.json();
            if (data) {
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

    /**
     * Función para animar el conteo de números.
     */
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
        const editHistorialModalContent = document.getElementById('editHistorialModalContent');
        if (!editHistorialModalContent) return;

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
            if (!form) return;

            contactIndex = 0;
            // Re-indexar los contactos existentes
            form.querySelectorAll('.contact-row').forEach(row => {
                const inputs = $(row).find('input, select, textarea');
                inputs.each(function() {
                    const originalName = $(this).attr('name');
                    const newName = originalName.replace(/contactos\[\d+\]/, `contactos[${contactIndex}]`);
                    $(this).attr('name', newName);
                });
                contactIndex++;
            });

            form.querySelectorAll('.remove-contact-row').forEach(btn => btn.addEventListener('click', () => btn.closest('.contact-row').remove()));
            $('#editarhistorial .select2').select2({ dropdownParent: editHistorialModalElement });
            form.querySelectorAll('.contact-row select').forEach(select => $(select).select2({ minimumResultsForSearch: Infinity, dropdownParent: $(select).closest('td') }));

            // Agregar un solo listener para el botón de añadir contacto en edición
            const addContactBtn = document.getElementById('add-contact-row-editar');
            if (addContactBtn) {
                addContactBtn.addEventListener('click', () => addContactRow('contact-rows-container-editar'));
            }

            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                const success = await submitForm(this, `/empresas/${id}`);
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
        const viewHistorialModalContent = document.getElementById('viewHistorialModalContent');
        if (!viewHistorialModalContent) return;

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
            $(viewHistorialModalContent).find('select').each(function() {
                $(this).select2({ minimumResultsForSearch: Infinity, dropdownParent: viewHistorialModalElement });
            });
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

        if (!pdfViewerFrame || !openPdfInNewTabBtn || !pdfLoadingMessage) {
            console.error('Elementos del modal de PDF no encontrados.');
            return;
        }

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
        const result = await Swal.fire({
            title: title,
            text: text,
            icon: successIcon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmText,
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`/empresas/${id}/${endpoint}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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

                updateUI();
            } catch (error) {
                console.error(`Error en la petición de ${endpoint}:`, error);
                showSweetAlertError('¡Error!', `Hubo un problema: ${error.message}`);
            }
        }
    }

    // --- Lógica del CRUD y Event Listeners ---
    function initializeDataTable() {
        if (!$.fn.DataTable) return;

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
                { data: 'estado', name: 'estado', width: '70px', className: 'text-wrap' },
                { data: 'regimen_fiscal_nombre', name: 'catalogoRegimen.regimen', width: '80px', className: 'text-wrap' },
                { data: 'credito', name: 'credito', width: '80px', className: 'text-wrap' },
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
                    width: '1%',
                    className: 'text-center acciones-col',
                    render: (data) => {
                        const actionButton = data.estado_cliente === 0
                            ? `<li><a href="javascript:void(0)" class="dropdown-item text-success btn-dar-de-alta" data-id="${data.id}"><i class="ri-check-line me-1"></i> Dar de Alta</a></li>`
                            : `<li><a href="javascript:void(0)" class="dropdown-item text-danger btn-dar-de-baja" data-id="${data.id}"><i class="ri-delete-bin-line me-1"></i> Dar de Baja</a></li>`;

                        return `<div class="dropdown">
                            <button class="btn btn-sm btn-info dropdown-toggle hide-arrow btn-acciones" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;<span class="d-none d-lg-inline-block">Opciones</span> <i class="ri-arrow-down-s-fill ri-16px"></i></button>
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
            dom: '<"top-row d-flex flex-wrap justify-content-between align-items-center"f<"d-flex gap-2 align-items-center"lB>>rtip',
            buttons: [
                {
                    text: '<i class="ri-add-line"></i> Agregar Cliente',
                    className: 'btn btn-primary waves-effect waves-light m-1',
                    action: () => agregarEmpresaModal?.show()
                },
                {
                    text: '<i class="ri-file-text-line"></i> Exportar',
                    className: 'btn btn-info waves-effect waves-light m-1',
                    action: () => exportModal?.show()
                }
            ]
        });
    }

    function setupEventListeners() {
        // Formulario de agregar empresa
        if (formAgregarEmpresa) {
            formAgregarEmpresa.addEventListener('submit', async function(event) {
                event.preventDefault();
                const success = await submitForm(this, this.action);
                if (success) {
                    agregarEmpresaModal.hide();
                    updateUI();
                }
            });
        }

        // Listeners para los modales
        if (agregarEmpresaModalElement) {
            agregarEmpresaModalElement.addEventListener('shown.bs.modal', () => {
                $('#agregarEmpresa .select2').select2({ dropdownParent: agregarEmpresaModalElement });
                contactIndex = 0;
                $('#contact-rows-container-agregar').empty();
                addContactRow('contact-rows-container-agregar');
            });
            agregarEmpresaModalElement.addEventListener('hidden.bs.modal', () => {
                clearValidationErrors(formAgregarEmpresa);
                formAgregarEmpresa?.reset();
                $('#agregarEmpresa .select2').select2('destroy');
            });
            const addContactBtnAgregar = document.getElementById('add-contact-row-agregar');
            if (addContactBtnAgregar) {
                addContactBtnAgregar.addEventListener('click', () => addContactRow('contact-rows-container-agregar'));
            }
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
        
        if (viewPdfModalElement) {
            viewPdfModalElement.addEventListener('hidden.bs.modal', function() {
                const pdfViewerFrame = document.getElementById('pdfViewerFrame');
                const pdfLoadingMessage = document.getElementById('pdfLoadingMessage');
                if (pdfViewerFrame) pdfViewerFrame.src = '';
                if (pdfLoadingMessage) pdfLoadingMessage.style.display = 'none';
            });
        }

        // Modal de exportación
        if (exportModalElement) {
            exportModalElement.addEventListener('shown.bs.modal', loadClientesForExportModal);
        }

        // Habilitar/deshabilitar el filtro de empresa
        const habilitarFiltro = document.getElementById('habilitar_filtro_empresa');
        const empresaIdInput = document.getElementById('empresa_id');
        if (habilitarFiltro && empresaIdInput) {
            habilitarFiltro.addEventListener('change', () => {
                empresaIdInput.disabled = !habilitarFiltro.checked;
            });
        }
        
        // Delegación de eventos para la tabla
        $(document).on('click', '.view-pdf-btn', function(event) {
            event.preventDefault();
            const pdfUrl = $(this).data('pdf-url');
            if (pdfUrl) {
                showPdfViewer(pdfUrl);
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
    }

    /**
     * Carga dinámicamente la lista de clientes para el modal de exportación.
     */
    async function loadClientesForExportModal() {
        const selectElement = document.getElementById('filtroCliente');
        if (!selectElement || typeof clientesAjaxUrl === 'undefined' || !clientesAjaxUrl) {
            console.error('Elementos o URL de clientes para exportación no encontrados.');
            return;
        }

        // Limpiar opciones previas
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
    
    // --- Inicialización de la aplicación ---
    initializeDataTable();
    updateClientStats();
    setupEventListeners();
});