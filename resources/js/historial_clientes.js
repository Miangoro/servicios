/**
 * Script para la gestión de empresas (CRUD) mediante AJAX.
 *
 * MODIFICACIÓN CLAVE:
 * - Cuando una empresa está "dada de baja" (en localStorage), un ícono de "prohibido" se muestra junto a su nombre.
 * - La fila completa de la empresa se torna de color rojo.
 * - Las funciones de alta y baja manipulan el localStorage y recargan la tabla.
 */
document.addEventListener('DOMContentLoaded', function () {

    // Comprobaciones iniciales para evitar errores
    if (typeof dataTableAjaxUrl === 'undefined') {
        console.error("Error: 'dataTableAjaxUrl' no está definida. Asegúrate de definirla en tu vista Blade.");
        return;
    }

    if (typeof totalEmpresasUrl === 'undefined') {
        console.error("Error: 'totalEmpresasUrl' no está definida. Necesaria para actualizar el contador de empresas.");
    }

    // Definición de elementos y variables principales
    const formAgregarContacto = document.getElementById('formAgregarContacto');
    const agregarEmpresaModalElement = document.getElementById('agregarEmpresa');
    const agregarEmpresaModal = new bootstrap.Modal(agregarEmpresaModalElement);
    const modalContentContainer = document.getElementById('editHistorialModalContent');
    const viewModalContentContainer = document.getElementById('viewHistorialModalContent');
    const editHistorialModal = new bootstrap.Modal(document.getElementById('editHistorialModal'));
    const viewHistorialModal = new bootstrap.Modal(document.getElementById('viewHistorialModal'));

    let contactIndex = 0;
    let table = null;

    // --- Funciones Auxiliares ---

    /**
     * Limpia los mensajes de error de validación y las clases 'is-invalid' de un formulario.
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function clearValidationErrors(formElement) {
        formElement.querySelectorAll('.is-invalid').forEach(input => {
            input.classList.remove('is-invalid');
        });
        $(formElement).find('.select2-container').find('.select2-selection--single').removeClass('is-invalid');
        $(formElement).find('select').each(function() {
            $(this).next('.select2-container').find('.select2-selection--single').removeClass('is-invalid');
        });
        formElement.querySelectorAll('.invalid-feedback').forEach(feedback => {
            feedback.innerHTML = '';
        });
    }

    /**
     * Muestra los errores de validación en el formulario.
     * @param {object} errors - Objeto con los errores de validación (campo: [mensajes]).
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function displayValidationErrors(errors, formElement) {
        clearValidationErrors(formElement);
        console.log('Mostrando errores de validación:', errors);

        for (const fieldName in errors) {
            if (errors.hasOwnProperty(fieldName)) {
                let htmlFieldName = fieldName;
                if (fieldName === 'noext') {
                    htmlFieldName = 'no_exterior';
                } else if (fieldName.startsWith('contactos.')) {
                    const parts = fieldName.split('.');
                    if (parts.length === 3) {
                        const index = parts[1];
                        const field = parts[2];
                        htmlFieldName = `contactos[${index}][${field}]`;
                    }
                }
                const inputElement = formElement.querySelector(`[name="${htmlFieldName}"]`);

                if (inputElement) {
                    inputElement.classList.add('is-invalid');
                    if ($(inputElement).hasClass('select2') || $(inputElement).is('select')) {
                        $(inputElement).next('.select2-container').find('.select2-selection--single').addClass('is-invalid');
                    }
                    let feedbackElement = inputElement.nextElementSibling;
                    if (!feedbackElement || !feedbackElement.classList.contains('invalid-feedback')) {
                        feedbackElement = document.createElement('div');
                        feedbackElement.classList.add('invalid-feedback');
                        inputElement.parentNode.insertBefore(feedbackElement, inputElement.nextElementSibling);
                    }
                    feedbackElement.innerHTML = errors[fieldName].join('<br>');
                } else {
                    console.warn(`Elemento HTML con name="${htmlFieldName}" no encontrado para el error de campo: ${fieldName}`);
                }
            }
        }
    }

    /**
     * Añade una nueva fila de contacto al formulario.
     * @param {string} containerId - El ID del contenedor donde se añadirá la fila.
     * @param {object} data - Objeto con datos predefinidos para la fila.
     * @param {boolean} isViewMode - Si la fila es para modo de visualización.
     */
    function addContactRow(containerId, data = {}, isViewMode = false) {
        const template = document.getElementById('contact-row-template');
        const clone = template.content.cloneNode(true);
        const newRow = clone.querySelector('.contact-row');

        $(newRow).find('[name^="contactos[INDEX]"]').each(function() {
            $(this).attr('name', $(this).attr('name').replace('INDEX', contactIndex));
        });

        if (data.contacto) newRow.querySelector('[name$="[contacto]"]').value = data.contacto;
        if (data.celular) newRow.querySelector('[name$="[celular]"]').value = data.celular;
        if (data.correo) newRow.querySelector('[name$="[correo]"]').value = data.correo;
        const statusField = newRow.querySelector('[name$="[status]"]');
        if (statusField) statusField.value = data.status !== undefined ? data.status.toString() : '0';
        const observacionesField = newRow.querySelector('[name$="[observaciones]"]');
        if (observacionesField) observacionesField.value = data.observaciones || '';

        if (isViewMode) {
            $(newRow).find('input, select, textarea').prop('disabled', true);
            $(newRow).find('.remove-contact-row').closest('td').remove();
        } else {
            newRow.querySelector('.remove-contact-row').addEventListener('click', function() {
                this.closest('.contact-row').remove();
            });
        }

        document.getElementById(containerId).appendChild(newRow);

        const newSelect = $(newRow).find('select');
        if (newSelect.length) {
            newSelect.select2({
                minimumResultsForSearch: Infinity,
                dropdownParent: newSelect.closest('td')
            });
        }
        contactIndex++;
    }

    /**
     * Función para actualizar el contador de empresas.
     */
    function updateCompanyCount() {
        if (typeof totalEmpresasUrl === 'undefined') {
            console.warn("totalEmpresasUrl no está definida. No se puede actualizar el contador de empresas.");
            return;
        }

        fetch(totalEmpresasUrl)
            .then(response => {
                if (!response.ok) throw new Error('Error al obtener el conteo de empresas.');
                return response.json();
            })
            .then(data => {
                const companyCountElement = document.getElementById('totalEmpresasCount');
                if (companyCountElement) {
                    const inactiveClients = JSON.parse(localStorage.getItem('inactive_clients')) || [];
                    const totalActivos = data.total - inactiveClients.length;

                    companyCountElement.innerText = totalActivos;
                    console.log('Contador de empresas actualizado a:', totalActivos);
                } else {
                    console.warn("Elemento con ID 'totalEmpresasCount' no encontrado.");
                }
            })
            .catch(error => {
                console.error('Error al actualizar el contador de empresas:', error);
            });
    }

    /**
     * Muestra un PDF en un modal.
     * @param {string} pdfUrl - La URL del archivo PDF a mostrar.
     */
    window.viewPdf = function(pdfUrl) {
        const pdfViewerFrame = document.getElementById('pdfViewerFrame');
        const openPdfInNewTabBtn = document.getElementById('openPdfInNewTabBtn');
        const pdfLoadingMessage = document.getElementById('pdfLoadingMessage');
        const viewPdfModalElement = document.getElementById('viewPdfModal');

        console.log('Intentando cargar contenido desde URL:', pdfUrl);

        pdfLoadingMessage.innerText = 'Cargando contenido... Si no se muestra aquí, por favor, usa el botón "Abrir en otra pestaña".';
        pdfLoadingMessage.style.display = 'block';
        pdfViewerFrame.style.display = 'none';
        pdfViewerFrame.src = '';
        pdfViewerFrame.src = pdfUrl;
        openPdfInNewTabBtn.href = pdfUrl;

        pdfViewerFrame.onload = function() {
            pdfLoadingMessage.style.display = 'none';
            pdfViewerFrame.style.display = 'block';
            console.log('Contenido cargado exitosamente en el iframe.');
        };

        pdfViewerFrame.onerror = function() {
            pdfLoadingMessage.innerText = 'Error al cargar el contenido en la ventana. Por favor, haz clic en "Abrir en otra pestaña".';
            pdfLoadingMessage.style.display = 'block';
            pdfViewerFrame.style.display = 'none';
            console.error('Error al cargar el contenido en el iframe. URL:', pdfUrl);
        };

        const viewPdfModal = new bootstrap.Modal(viewPdfModalElement);
        viewPdfModal.show();
    };

    /**
     * Aplica la clase 'table-danger' a la fila si el ID está en la lista de clientes inactivos.
     * @param {HTMLTableRowElement} row - La fila de la tabla.
     * @param {object} data - Los datos de la fila.
     */
    function applyInactiveClass(row, data) {
        const inactiveClients = JSON.parse(localStorage.getItem('inactive_clients')) || [];
        if (inactiveClients.includes(data.id)) {
            $(row).addClass('table-danger');
        } else {
            $(row).removeClass('table-danger');
        }
    }

    // --- Lógica del CRUD y Event Listeners ---

    // Inicializar DataTables
    table = $('#tablaHistorial').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' },
        processing: true,
        serverSide: true,
        responsive: false,
        ajax: {
            url: dataTableAjaxUrl,
            type: "GET",
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '25px', className: 'text-center' },
            {
                data: 'nombre',
                name: 'nombre',
                width: '100px',
                className: 'text-wrap',
                render: function(data, type, row) {
                    const inactiveClients = JSON.parse(localStorage.getItem('inactive_clients')) || [];
                    const isInactive = inactiveClients.includes(row.id);
                    let iconHtml = '';
                    if (isInactive) {
                        iconHtml = `<i class="ri-user-forbid-line text-danger me-2"></i>`;
                    }
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
                render: function(data, type, row) {
                    const pdfIconUrl = '/assets/img/icons/misc/pdf.png';
                    const missingPdfImageUrl = '/img_pdf/FaltaPDF.png';
                    const imageUrl = data ? data : missingPdfImageUrl;
                    return `<button type="button" class="btn btn-icon waves-effect waves-light view-pdf-btn btn-no-border" data-pdf-url="${imageUrl}">
                                <img src="${imageUrl === missingPdfImageUrl ? missingPdfImageUrl : pdfIconUrl}" alt="Ver PDF" style="width: 40px; height: auto;">
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
                render: function(data, type, row) {
                    const inactiveClients = JSON.parse(localStorage.getItem('inactive_clients')) || [];
                    const isInactive = inactiveClients.includes(row.id);

                    let statusItemHtml = '';
                    if (isInactive) {
                        statusItemHtml = `<li><a href="javascript:void(0)" class="dropdown-item text-success" onclick="darDeAltaUnidad(${row.id})"><i class="ri-check-line me-1"></i>Dar de alta</a></li>`;
                    } else {
                        statusItemHtml = `<li><a href="javascript:void(0)" class="dropdown-item text-danger" onclick="darDeBajaUnidad(${row.id})"><i class="ri-user-forbid-line me-1"></i>Dar de baja</a></li>`;
                    }

                    return `<div class="dropdown">
                                <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="javascript:void(0)" class="dropdown-item" onclick="viewUnidad(${row.id})"><i class="ri-search-line me-1 text-muted"></i> Visualizar</a></li>
                                    <li><a href="javascript:void(0)" class="dropdown-item" onclick="editUnidad(${row.id})"><i class="ri-edit-box-line me-1 text-info"></i> Editar</a></li>
                                    <li class="dropdown-divider"></li>
                                    ${statusItemHtml}
                                </ul>
                            </div>`;
                }
            }
        ],
        autoWidth: false,
        rowCallback: function(row, data) {
            applyInactiveClass(row, data);
        }
    });

    // Inicializar el contador de empresas al cargar la página
    updateCompanyCount();

    // Eventos para la modal de "Agregar Empresa"
    if (agregarEmpresaModalElement) {
        agregarEmpresaModalElement.addEventListener('shown.bs.modal', function () {
            console.log('Modal Agregar mostrada. Inicializando Select2 y Contactos.');
            $('#agregarEmpresa .select2').select2({ dropdownParent: $('#agregarEmpresa') });
            contactIndex = 0;
            $('#contact-rows-container-agregar').empty();
            addContactRow('contact-rows-container-agregar');
        });

        agregarEmpresaModalElement.addEventListener('hidden.bs.modal', function () {
            console.log('Modal Agregar oculta. Limpiando formulario y errores.');
            if (formAgregarContacto) {
                clearValidationErrors(formAgregarContacto);
                formAgregarContacto.reset();
                $('#agregarEmpresa .select2').select2('destroy');
            }
        });
    }

    // Listener para el botón "Agregar Contacto" en la modal de agregar
    if (document.getElementById('add-contact-row-agregar')) {
        document.getElementById('add-contact-row-agregar').addEventListener('click', function() {
            addContactRow('contact-rows-container-agregar');
        });
    }

    // Manejar el envío del formulario de agregar contacto/empresa
    if (formAgregarContacto) {
        formAgregarContacto.addEventListener('submit', function(event) {
            event.preventDefault();
            clearValidationErrors(this);

            const formData = new FormData(this);
            const storeUrl = this.action;
            const submitButton = document.getElementById('agregar-empresa-btn');

            if (submitButton) {
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
                submitButton.disabled = true;
            }

            fetch(storeUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw { status: response.status, data: errorData };
                    });
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    customClass: { confirmButton: 'btn btn-success' }
                });
                agregarEmpresaModal.hide();
                table.ajax.reload(null, false);
                updateCompanyCount();
            })
            .catch(error => {
                let errorMessage = 'Hubo un error inesperado al agregar la empresa.';
                if (error.status === 422 && error.data && error.data.errors) {
                    displayValidationErrors(error.data.errors, formAgregarContacto);
                } else if (error.data && error.data.message) {
                    errorMessage = error.data.message;
                } else if (error.message) {
                    errorMessage = error.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    html: `${errorMessage}`,
                    customClass: { confirmButton: 'btn btn-danger' }
                });
            })
            .finally(() => {
                if (submitButton) {
                    submitButton.innerHTML = '<i class="ri-add-line"></i> Agregar Contacto';
                    submitButton.disabled = false;
                }
            });
        });
    }

    // Función para "dar de baja" (ahora 100% en el frontend con cambio de color)
    window.darDeBajaUnidad = function(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se marcará visualmente esta empresa como inactiva (la fila se tornará roja y aparecerá un ícono).",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, dar de baja',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-warning me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                const inactiveClients = JSON.parse(localStorage.getItem('inactive_clients')) || [];
                if (!inactiveClients.includes(id)) {
                    inactiveClients.push(id);
                    localStorage.setItem('inactive_clients', JSON.stringify(inactiveClients));
                    Swal.fire({
                        icon: 'success',
                        title: '¡Dado de baja!',
                        text: 'El cliente se ha marcado como inactivo.',
                        customClass: { confirmButton: 'btn btn-success' }
                    });
                    table.ajax.reload(null, false); // Recargar la tabla para aplicar los cambios visuales
                    updateCompanyCount();
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Ya está inactivo',
                        text: 'El cliente ya está marcado como inactivo.',
                        customClass: { confirmButton: 'btn btn-info' }
                    });
                }
            }
        });
    };

    // Función para "dar de alta" (100% en el frontend con eliminación del color rojo)
    window.darDeAltaUnidad = function(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se quitará la marca visual de inactividad.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Sí, dar de alta',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-success me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                let inactiveClients = JSON.parse(localStorage.getItem('inactive_clients')) || [];
                const index = inactiveClients.indexOf(id);
                if (index > -1) {
                    inactiveClients.splice(index, 1);
                    localStorage.setItem('inactive_clients', JSON.stringify(inactiveClients));
                    Swal.fire({
                        icon: 'success',
                        title: '¡Dado de alta!',
                        text: 'Se ha quitado la marca de inactividad del cliente.',
                        customClass: { confirmButton: 'btn btn-success' }
                    });
                    table.ajax.reload(null, false); // Recargar la tabla para quitar los cambios visuales
                    updateCompanyCount();
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Ya está activo',
                        text: 'El cliente ya está en su estado activo.',
                        customClass: { confirmButton: 'btn btn-info' }
                    });
                }
            }
        });
    };

    /**
     * Función global para editar una unidad (empresa).
     * @param {number} id - El ID de la empresa a editar.
     */
    window.editUnidad = function(id) {
        console.log('Función editar llamada para ID:', id);
        if (modalContentContainer) {
            modalContentContainer.innerHTML = `<div class="modal-body text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <p class="mt-2">Cargando formulario de edición...</p>
                            </div>`;
        }
        editHistorialModal.show();
        fetch(`/empresas/${id}/edit-modal`, { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
        .then(response => {
            if (!response.ok) return response.text().then(text => { throw new Error(text || response.statusText); });
            return response.text();
        })
        .then(html => {
            if (modalContentContainer) {
                modalContentContainer.innerHTML = html;
                contactIndex = $('#contact-rows-container-editar').children().length;
                if (contactIndex === 0) { addContactRow('contact-rows-container-editar'); }
                $('#contact-rows-container-editar .remove-contact-row').each(function() {
                    this.addEventListener('click', function() { this.closest('.contact-row').remove(); });
                });
                $('#editarhistorial .select2').select2({ dropdownParent: $('#editHistorialModal') });
                $('#contact-rows-container-editar select').each(function() {
                    $(this).select2({ minimumResultsForSearch: Infinity, dropdownParent: $(this).closest('td') });
                });
                document.getElementById('add-contact-row-editar').addEventListener('click', function() {
                    addContactRow('contact-rows-container-editar');
                });
                const form = document.getElementById('editarhistorial');
                if (form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        clearValidationErrors(this);
                        const formData = new FormData(this);
                        formData.append('_method', 'PUT');
                        const empresaId = document.getElementById('idHistorial').value;
                        const updateUrl = `/empresas/${empresaId}`;
                        const submitButton = form.querySelector('button[type="submit"]');
                        if (submitButton) {
                            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
                            submitButton.disabled = true;
                        }
                        fetch(updateUrl, {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                        })
                        .then(response => {
                            if (!response.ok) return response.json().then(errorData => { throw { status: response.status, data: errorData }; });
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({ icon: 'success', title: '¡Éxito!', text: data.message, customClass: { confirmButton: 'btn btn-success' } });
                            editHistorialModal.hide();
                            table.ajax.reload(null, false);
                            updateCompanyCount();
                        })
                        .catch(error => {
                            let errorMessage = 'Hubo un error inesperado al actualizar la empresa.';
                            if (error.status === 422 && error.data && error.data.errors) {
                                displayValidationErrors(error.data.errors, form);
                            } else if (error.data && error.data.message) {
                                errorMessage = error.data.message;
                            } else if (error.message) {
                                errorMessage = error.message;
                            }
                            Swal.fire({ icon: 'error', title: '¡Error!', html: `${errorMessage}`, customClass: { confirmButton: 'btn btn-danger' } });
                        })
                        .finally(() => {
                            if (submitButton) {
                                submitButton.innerHTML = '<i class="ri-add-line"></i> Actualizar Empresa';
                                submitButton.disabled = false;
                            }
                        });
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar el formulario de edición:', error);
            if (modalContentContainer) {
                modalContentContainer.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar el formulario: ${error.message || 'Error desconocido'}</div></div>`;
            }
        });
    };

    /**
     * Función global para visualizar los detalles de una unidad (empresa).
     * @param {number} id - El ID de la empresa a visualizar.
     */
    window.viewUnidad = function(id) {
        console.log('Función visualizar llamada para ID:', id);
        if (viewModalContentContainer) {
            viewModalContentContainer.innerHTML = `<div class="modal-body text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <p class="mt-2">Cargando información de la empresa para visualización...</p>
                            </div>`;
        }
        viewHistorialModal.show();
        fetch(`/empresas/${id}/view-modal`, { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
        .then(response => {
            if (!response.ok) return response.text().then(text => { throw new Error(text || response.statusText); });
            return response.text();
        })
        .then(html => {
            if (viewModalContentContainer) {
                viewModalContentContainer.innerHTML = html;
                const contactRows = document.getElementById('contact-rows-container-view');
                if (contactRows) {
                    $(contactRows).find('select').each(function() {
                        $(this).select2({ minimumResultsForSearch: Infinity, dropdownParent: $(this).closest('td') });
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error al cargar la vista del historial:', error);
            if (viewModalContentContainer) {
                viewModalContentContainer.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar los detalles: ${error.message || 'Error desconocido'}</div></div>`;
            }
        });
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
            console.log('Modal Editar oculta. Limpiando errores y destruyendo Select2.');
            clearValidationErrors(form);
            const motivoEdicionField = form.querySelector('#motivoEdicion');
            if (motivoEdicionField) {
                motivoEdicionField.value = '';
                motivoEdicionField.classList.remove('is-invalid');
                const feedback = motivoEdicionField.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.innerHTML = '';
                }
            }
            $(form).find('.select2').select2('destroy');
            $(form).find('select').each(function() {
                $(this).select2('destroy');
            });
        }
    });

    // Evento cuando la modal de visualización se oculta
    $('#viewHistorialModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('visualizarhistorialForm');
        if (form) {
            console.log('Modal Visualizar oculta. Destruyendo Select2.');
            $(form).find('.select2').select2('destroy');
            $(form).find('select').each(function() {
                $(this).select2('destroy');
            });
        }
    });

});