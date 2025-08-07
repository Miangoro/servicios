/**
 * Script para la gestión de empresas (CRUD) mediante AJAX.
 *
 * Mejoras implementadas:
 * - Uso de async/await para peticiones más limpias.
 * - Funciones auxiliares centralizadas para manejo de modales, errores y peticiones.
 * - La lógica de "dar de baja" y "dar de alta" ahora se comunica con el servidor
 * a través de peticiones AJAX para una gestión de estado persistente.
 * - Las tablas y los contadores se actualizan en tiempo real sin recargar la página.
 */
document.addEventListener('DOMContentLoaded', function () {
    // Definición de elementos y variables principales
    const formAgregarEmpresa = document.getElementById('formAgregarContacto');
    const agregarEmpresaModalElement = document.getElementById('agregarEmpresa');
    const editHistorialModalElement = document.getElementById('editHistorialModal');
    const viewHistorialModalElement = document.getElementById('viewHistorialModal');
    const exportModalElement = document.getElementById('modal-add-export_clientes_empresas');

    const agregarEmpresaModal = agregarEmpresaModalElement ? new bootstrap.Modal(agregarEmpresaModalElement) : null;
    const editHistorialModal = editHistorialModalElement ? new bootstrap.Modal(editHistorialModalElement) : null;
    const viewHistorialModal = viewHistorialModalElement ? new bootstrap.Modal(viewHistorialModalElement) : null;
    const exportModal = exportModalElement ? new bootstrap.Modal(exportModalElement) : null;

    let contactIndex = 0;
    let dataTable;

    // --- Funciones Auxiliares ---

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
     * Envía una petición de formulario mediante AJAX.
     * @param {HTMLFormElement} form - El formulario a enviar.
     * @param {string} url - La URL del endpoint.
     * @param {object} [options={}] - Opciones adicionales para la petición.
     */
    async function submitForm(form, url, options = {}) {
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
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
                if (response.status === 422) {
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
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                html: `${error.message}`,
                customClass: { confirmButton: 'btn btn-danger' }
            });
        } finally {
            submitButton.innerHTML = options.successButtonText || '<i class="ri-add-line"></i> Guardar';
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

        document.getElementById(containerId).appendChild(newRow);
        $(newRow).find('select').select2({
            minimumResultsForSearch: Infinity,
            dropdownParent: $(newRow).find('select').closest('td')
        });
        contactIndex++;
    }

    /**
     * Actualiza el contador de clientes en los cuadros de estadísticas.
     */
    async function updateClientStats() {
        if (typeof estadisticasUrl === 'undefined') {
            console.warn("'estadisticasUrl' no está definida. No se pueden actualizar las estadísticas.");
            return;
        }
        try {
            const response = await fetch(estadisticasUrl);
            if (!response.ok) throw new Error('Error al obtener las estadísticas.');
            const data = await response.json();
            if (data) {
                document.getElementById('clientesActivosCard').innerText = data.clientesActivos;
                document.getElementById('clientesInactivosCard').innerText = data.clientesInactivos;
                document.getElementById('totalClientesCard').innerText = data.total;
            }
        } catch (error) {
            console.error('Error al actualizar las estadísticas:', error);
        }
    }
    
    // Función para dar de baja/alta con petición al servidor
    async function changeClientStatus(id, newStatus, message) {
        const actionUrl = newStatus === 0 ? `/dar-de-baja/${id}` : `/dar-de-alta/${id}`;
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        const result = await Swal.fire({
            title: '¿Estás seguro?',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, continuar',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error al cambiar el estado.');
                }
                
                const data = await response.json();
                Swal.fire('¡Éxito!', data.message, 'success');
                dataTable.ajax.reload(null, false);
                updateClientStats();
            } catch (error) {
                console.error('Error al actualizar el estado del cliente:', error);
                Swal.fire('Error', error.message, 'error');
            }
        }
    }

    window.darDeBajaUnidad = (id) => changeClientStatus(id, 0, "¡El cliente será dado de baja!");
    window.darDeAltaUnidad = (id) => changeClientStatus(id, null, "¡El cliente será dado de alta!");

    // --- Lógica del CRUD y Event Listeners ---

    // Inicializar DataTables
    dataTable = $('#tablaHistorial').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
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
                    const pdfIconUrl = '/assets/img/icons/misc/pdf.png';
                    const missingPdfImageUrl = '/img_pdf/FaltaPDF.png';
                    const imageUrl = data ? pdfIconUrl : missingPdfImageUrl;
                    return `<button type="button" class="btn btn-icon waves-effect waves-light view-pdf-btn btn-no-border" data-pdf-url="${data || missingPdfImageUrl}">
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
                    const isInactive = data.estado_cliente === 0;
                    const statusItemHtml = isInactive
                        ? `<li><a href="javascript:void(0)" class="dropdown-item text-success" onclick="darDeAltaUnidad(${data.id})"><i class="ri-check-line me-1"></i>Dar de alta</a></li>`
                        : `<li><a href="javascript:void(0)" class="dropdown-item text-danger" onclick="darDeBajaUnidad(${data.id})"><i class="ri-user-forbid-line me-1"></i>Dar de baja</a></li>`;

                    return `<div class="dropdown">
                                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="javascript:void(0)" class="dropdown-item" onclick="viewUnidad(${data.id})"><i class="ri-search-line me-1 text-muted"></i> Visualizar</a></li>
                                    <li><a href="javascript:void(0)" class="dropdown-item" onclick="editUnidad(${data.id})"><i class="ri-edit-box-line me-1 text-info"></i> Editar</a></li>
                                    <li class="dropdown-divider"></li>
                                    ${statusItemHtml}
                                </ul>
                            </div>`;
                }
            }
        ],
        rowCallback: (row, data) => {
            $(row).toggleClass('table-danger', data.estado_cliente === 0);
        }
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
                dataTable.ajax.reload(null, false);
                updateClientStats();
            }
        });
    }

    // Funciones de modales y botones
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

    // PDF Viewer global
    window.viewPdf = function(pdfUrl) {
        const viewPdfModalElement = document.getElementById('viewPdfModal');
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

        (new bootstrap.Modal(viewPdfModalElement)).show();
    };

    // Nueva función para cargar clientes en el modal de exportación
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

    // Funciones globales para edición y visualización
    window.editUnidad = async function(id) {
        const url = `/empresas/${id}/edit-modal`;
        const modalContentContainer = document.getElementById('editHistorialModalContent');
        
        modalContentContainer.innerHTML = `<div class="modal-body text-center py-5">
                                             <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>
                                             <p class="mt-2">Cargando formulario de edición...</p>
                                          </div>`;
        editHistorialModal.show();
        
        try {
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } });
            if (!response.ok) throw new Error(`Error ${response.status}: ${await response.text()}`);
            
            modalContentContainer.innerHTML = await response.text();
            
            const form = document.getElementById('editarhistorial');
            contactIndex = form.querySelectorAll('.contact-row').length;
            
            form.querySelectorAll('.remove-contact-row').forEach(btn => btn.addEventListener('click', () => btn.closest('.contact-row').remove()));
            
            $('#editarhistorial .select2').select2({ dropdownParent: editHistorialModalElement });
            form.querySelectorAll('.contact-row select').forEach(select => $(select).select2({ minimumResultsForSearch: Infinity, dropdownParent: $(select).closest('td') }));
            
            document.getElementById('add-contact-row-editar').addEventListener('click', () => addContactRow('contact-rows-container-editar'));
            
            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                const success = await submitForm(this, `/empresas/${id}`, {
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    successButtonText: '<i class="ri-add-line"></i> Actualizar Empresa'
                });
                if (success) {
                    editHistorialModal.hide();
                    dataTable.ajax.reload(null, false);
                    updateClientStats();
                }
            });
        } catch (error) {
            console.error('Error al cargar el formulario de edición:', error);
            modalContentContainer.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar: ${error.message}</div></div>`;
        }
    };
    
    window.viewUnidad = async function(id) {
        console.log('Función visualizar llamada para ID:', id);
        const viewModalContentContainer = document.getElementById('viewHistorialModalContent');
        const viewHistorialModal = new bootstrap.Modal(document.getElementById('viewHistorialModal'));
        const url = `/empresas/${id}/view-modal`;

        viewModalContentContainer.innerHTML = `<div class="modal-body text-center py-5">
                                                 <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>
                                                 <p class="mt-2">Cargando información de la empresa para visualización...</p>
                                              </div>`;
        viewHistorialModal.show();

        try {
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } });
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText || response.statusText);
            }

            viewModalContentContainer.innerHTML = await response.text();
            const contactRows = document.getElementById('contact-rows-container-view');
            if (contactRows) {
                $(contactRows).find('select').each(function() {
                    $(this).select2({ minimumResultsForSearch: Infinity, dropdownParent: $(this).closest('td') });
                });
            }
        } catch (error) {
            console.error('Error al cargar la vista del historial:', error);
            viewModalContentContainer.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar los detalles: ${error.message || 'Error desconocido'}</div></div>`;
        }
    };

    // Listener para el clic en los botones de "Ver PDF"
    $(document).on('click', '.view-pdf-btn', function(event) {
        event.preventDefault();
        const pdfUrl = $(this).data('pdf-url');
        if (pdfUrl) {
            window.viewPdf(pdfUrl);
        } else {
            console.warn('No se encontró la URL del contenido para este elemento.');
        }
    });

    // Evento para limpiar el iframe cuando la modal de PDF se oculta
    document.getElementById('viewPdfModal').addEventListener('hidden.bs.modal', function () {
        document.getElementById('pdfViewerFrame').src = '';
        document.getElementById('pdfLoadingMessage').style.display = 'none';
    });

    // Evento cuando la modal de edición se oculta
    $('#editHistorialModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('editarhistorial');
        if (form) {
            console.log('Modal Editar oculta. Limpiando y destruyendo Select2.');
            clearValidationErrors(form);
            const motivoEdicionField = form.querySelector('#motivoEdicion');
            if (motivoEdicionField) {
                motivoEdicionField.value = '';
            }
            $(form).find('.select2, select').select2('destroy');
        }
    });

    // Evento para habilitar/deshabilitar el filtro de empresa
    document.getElementById('habilitar_filtro_empresa').addEventListener('change', function() {
        document.getElementById('empresa_id').disabled = !this.checked;
    });

    // Evento cuando la modal de visualización se oculta
    $('#viewHistorialModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('visualizarhistorialForm');
        if (form) {
            console.log('Modal Visualizar oculta. Destruyendo Select2.');
            $(form).find('.select2, select').select2('destroy');
        }
    });
});