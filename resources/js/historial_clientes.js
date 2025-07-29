// resources/js/historial_clientes.js

// Mueve la función viewPdf al ámbito global explícitamente
window.viewPdf = function(pdfUrl) {
    const pdfViewerFrame = document.getElementById('pdfViewerFrame');
    const openPdfInNewTabBtn = document.getElementById('openPdfInNewTabBtn');
    const pdfLoadingMessage = document.getElementById('pdfLoadingMessage');
    const viewPdfModalElement = document.getElementById('viewPdfModal');

    // Loguea la URL del PDF para depuración
    console.log('Intentando cargar PDF desde URL:', pdfUrl);

    // Mostrar mensaje de carga y ocultar iframe mientras se carga
    pdfLoadingMessage.innerText = 'Cargando PDF... Si no se muestra aquí, por favor, usa el botón "Abrir en otra pestaña".';
    pdfLoadingMessage.style.display = 'block';
    pdfViewerFrame.style.display = 'none';
    pdfViewerFrame.src = ''; // Limpiar src anterior

    // Asignar la URL del PDF al iframe
    pdfViewerFrame.src = pdfUrl;
    
    // Actualizar el enlace del botón "Abrir en otra pestaña"
    openPdfInNewTabBtn.href = pdfUrl;

    // Manejar la carga del iframe
    pdfViewerFrame.onload = function() {
        pdfLoadingMessage.style.display = 'none'; // Ocultar mensaje de carga
        pdfViewerFrame.style.display = 'block'; // Mostrar iframe
        console.log('PDF cargado exitosamente en el iframe (o el navegador lo maneja).');
    };

    pdfViewerFrame.onerror = function() {
        pdfLoadingMessage.innerText = 'Error al cargar el PDF en la ventana. Esto puede deberse a restricciones de seguridad del navegador. Por favor, haz clic en "Abrir en otra pestaña".';
        pdfLoadingMessage.style.display = 'block';
        pdfViewerFrame.style.display = 'none';
        console.error('Error al cargar el PDF en el iframe. Esto podría ser por seguridad del navegador. URL:', pdfUrl);
    };

    // Mostrar la modal
    const viewPdfModal = new bootstrap.Modal(viewPdfModalElement);
    viewPdfModal.show();
};

// Limpiar el iframe cuando la modal se cierra para liberar recursos
document.getElementById('viewPdfModal').addEventListener('hidden.bs.modal', function (event) {
    document.getElementById('pdfViewerFrame').src = ''; // Limpiar el src del iframe
    document.getElementById('pdfLoadingMessage').style.display = 'none'; // Asegurarse de ocultar el mensaje
});


$(function() {
    if (typeof dataTableAjaxUrl === 'undefined') {
        console.error("Error: 'dataTableAjaxUrl' no está definida. Asegúrate de definirla en tu vista Blade.");
        return;
    }

    var table = $('#tablaHistorial').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        },
        processing: true,
        serverSide: true,
        responsive: false,
        ajax: {
            url: dataTableAjaxUrl,
            type: "GET",
            data: function(d) {
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '25px', className: 'text-center' },
            { data: 'nombre', name: 'nombre', width: '100px', className: 'text-wrap' },
            { data: 'rfc', name: 'rfc', width: '80px', className: 'text-center' },
            { data: 'calle', name: 'calle', width: '100px', className: 'text-wrap' },
            { data: 'colonia', name: 'colonia', width: '80px', className: 'text-wrap' },
            { data: 'localidad', name: 'localidad', width: '70px', className: 'text-wrap' },
            { data: 'municipio', name: 'municipio', width: '70px', className: 'text-wrap' },
            { data: 'constancia', name: 'constancia', width: '120px', className: 'text-wrap text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, width: '80px', className: 'text-center' }
        ],
        autoWidth: false,
    });

    const editHistorialModal = new bootstrap.Modal(document.getElementById('editHistorialModal'));
    const modalContentContainer = document.getElementById('editHistorialModalContent');

    const viewHistorialModalElement = document.getElementById('viewHistorialModal'); 
    const viewHistorialModal = new bootstrap.Modal(viewHistorialModalElement);
    const viewModalContentContainer = document.getElementById('viewHistorialModalContent');


    const agregarEmpresaModal = new bootstrap.Modal(document.getElementById('agregarEmpresa'));
    const formAgregarContacto = document.getElementById('formAgregarContacto');

    let contactIndex = 0;

    function addContactRow(containerId, data = {}, isViewMode = false) {
        const template = document.getElementById('contact-row-template');
        const clone = template.content.cloneNode(true);
        const newRow = clone.querySelector('.contact-row');

        $(newRow).find('[name^="contactos[INDEX]"]').each(function() {
            $(this).attr('name', $(this).attr('name').replace('INDEX', contactIndex));
        });

        if (data.contacto) {
            newRow.querySelector('[name$="[contacto]"]').value = data.contacto;
        }
        if (data.celular) {
            newRow.querySelector('[name$="[celular]"]').value = data.celular;
        }
        if (data.correo) {
            newRow.querySelector('[name$="[correo]"]').value = data.correo;
        }
        const statusField = newRow.querySelector('[name$="[status]"]');
        if (statusField) {
            statusField.value = data.status !== undefined ? data.status.toString() : '0';
        }
        const observacionesField = newRow.querySelector('[name$="[observaciones]"]');
        if (observacionesField) {
            observacionesField.value = data.observaciones || '';
        }

        if (isViewMode) {
            $(newRow).find('input, select, textarea').prop('disabled', true);
            $(newRow).find('.remove-contact-row').closest('td').remove();
        } else {
            newRow.querySelector('.remove-contact-row').addEventListener('click', function() {
                this.closest('.contact-row').remove();
            });
        }

        document.getElementById(containerId).appendChild(newRow);

        const newSelect = $(newRow).find('select[name$="[status]"]');
        if (newSelect.length) {
            newSelect.select2({
                minimumResultsForSearch: Infinity,
                dropdownParent: newSelect.closest('td')
            });
        }

        contactIndex++;
    }

    $('#agregarEmpresa').on('shown.bs.modal', function () {
        console.log('Modal Agregar mostrada. Inicializando Select2 y Contactos.');
        $('#agregarEmpresa .select2').select2({
            dropdownParent: $('#agregarEmpresa')
        });
        contactIndex = 0;
        $('#contact-rows-container-agregar').empty();
        addContactRow('contact-rows-container-agregar');
    });

    $('#agregarEmpresa').on('hidden.bs.modal', function () {
        console.log('Modal Agregar oculta. Limpiando formulario y errores.');
        if (formAgregarContacto) {
            clearValidationErrors(formAgregarContacto);
            formAgregarContacto.reset();
            $('#agregarEmpresa .select2').select2('destroy');
        }
    });

    document.getElementById('add-contact-row-agregar').addEventListener('click', function() {
        addContactRow('contact-rows-container-agregar');
    });

    window.editUnidad = function(id) {
        console.log('Función editar llamada para ID:', id);

        if (modalContentContainer) {
            modalContentContainer.innerHTML = `
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando formulario de edición...</p>
                </div>
            `;
        }
        editHistorialModal.show();

        fetch(`/empresas/${id}/edit-modal`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            console.log('Respuesta de carga de modal de edición (raw):', response);
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text || response.statusText); });
            }
            return response.text();
        })
        .then(html => {
            if (modalContentContainer) {
                modalContentContainer.innerHTML = html;
                console.log('Contenido de modal de edición cargado. Adjuntando listeners.');

                contactIndex = $('#contact-rows-container-editar').children().length;

                if (contactIndex === 0) {
                    addContactRow('contact-rows-container-editar');
                } else {
                    $('#contact-rows-container-editar .remove-contact-row').each(function() {
                        this.addEventListener('click', function() {
                            this.closest('.contact-row').remove();
                        });
                    });
                }

                $('#editarhistorial .select2').select2({
                    dropdownParent: $('#editHistorialModal')
                });

                $('#contact-rows-container-editar select[name$="[status]"]').each(function() {
                    $(this).select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $(this).closest('td')
                    });
                });

                document.getElementById('add-contact-row-editar').addEventListener('click', function() {
                    addContactRow('contact-rows-container-editar');
                });

                const form = document.getElementById('editarhistorial');
                if (form) {
                    console.log('Formulario de edición encontrado. Adjuntando listener.');
                    form.addEventListener('submit', function(event) {
                        console.log('Evento submit del formulario de edición disparado.');
                        event.preventDefault();
                        clearValidationErrors(this);

                        const formData = new FormData(this);
                        formData.append('_method', 'PUT');

                        const empresaId = document.getElementById('idHistorial').value;
                        const updateUrl = `/empresas/${empresaId}`;

                        console.log('URL de actualización (updateUrl):', updateUrl);
                        for (let [key, value] of formData.entries()) {
                            console.log(`${key}: ${value}`);
                        }

                        const submitButton = form.querySelector('button[type="submit"]');
                        if (submitButton) {
                            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
                            submitButton.disabled = true;
                        }

                        fetch(updateUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }
                        })
                        .then(response => {
                            console.log('Respuesta de la API (raw):', response);
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    console.error('Error de respuesta (JSON):', errorData);
                                    throw { status: response.status, data: errorData };
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Éxito al actualizar empresa:', data);
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: data.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            editHistorialModal.hide();
                            table.ajax.reload(null, false);
                        })
                        .catch(error => {
                            console.error('Error en la solicitud AJAX (catch):', error);
                            let errorMessage = 'Hubo un error inesperado al actualizar la empresa.';

                            if (error.status === 422 && error.data && error.data.errors) {
                                displayValidationErrors(error.data.errors, form);
                            } else if (error.data && error.data.message) {
                                errorMessage = error.data.message;
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡Error!',
                                    html: `${errorMessage}`,
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            } else if (error.message) {
                                errorMessage = error.message;
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡Error!',
                                    html: `${errorMessage}`,
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: '¡Error!',
                                    html: `${errorMessage}`,
                                    customClass: {
                                        confirmButton: 'btn btn-danger'
                                    }
                                });
                            }
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

    window.viewUnidad = function(id) {
        console.log('Función visualizar llamada para ID:', id);

        if (viewModalContentContainer) {
            viewModalContentContainer.innerHTML = `
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando información de la empresa para visualización...</p>
                </div>
            `;
        }
        viewHistorialModal.show();

        fetch(`/empresas/${id}/view-modal`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            console.log('Respuesta de carga de modal de visualización (raw):', response);
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text || response.statusText); });
            }
            return response.text();
        })
        .then(html => {
            if (viewModalContentContainer) {
                viewModalContentContainer.innerHTML = html;
                console.log('Contenido de modal de visualización cargado.');

                // Inicializar Select2 para los selects en la modal de visualización
                // Aunque estén deshabilitados, Select2 puede mejorar la apariencia si ya se usa en la aplicación
                $('#visualizarhistorialForm .select2').select2({ // ID actualizado
                    dropdownParent: $('#viewHistorialModal')
                });
                $('#contact-rows-container-view select').each(function() {
                    $(this).select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $(this).closest('td')
                    });
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar el formulario de visualización:', error);
            if (viewModalContentContainer) {
                viewModalContentContainer.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar la información: ${error.message || 'Error desconocido'}</div></div>`;
            }
        });
    };

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
            $(form).find('select[name$="[status]"]').select2('destroy');
        }
    });

    $('#viewHistorialModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('visualizarhistorialForm'); // ID actualizado
        if (form) {
            console.log('Modal Visualizar oculta. Destruyendo Select2.');
            $(form).find('.select2').select2('destroy');
            $(form).find('select').select2('destroy');
        }
    });


    function displayValidationErrors(errors, formElement) {
        clearValidationErrors(formElement);
        console.log('Mostrando errores de validación:', errors);

        for (const fieldName in errors) {
            if (errors.hasOwnProperty(fieldName)) {
                let htmlFieldName = fieldName;
                if (fieldName === 'noext') {
                    htmlFieldName = 'no_exterior';
                } else if (fieldName === 'regimen') {
                    htmlFieldName = 'regimen';
                } else if (fieldName === 'municipio') {
                    htmlFieldName = 'municipio';
                } else if (fieldName.startsWith('contactos.')) {
                    const parts = fieldName.split('.');
                    if (parts.length === 3) {
                        const index = parts[1];
                        const field = parts[2];
                        htmlFieldName = `contactos[${index}][${field}]`;
                    }
                } else if (fieldName === 'motivo_edicion') {
                    htmlFieldName = 'motivo_edicion';
                }

                const inputElement = formElement.querySelector(`[name="${htmlFieldName}"]`);
                if (inputElement) {
                    inputElement.classList.add('is-invalid');

                    if ($(inputElement).hasClass('select2') || $(inputElement).is('select[name$="[status]"]')) {
                        $(inputElement).next('.select2-container').find('.select2-selection--single').addClass('is-invalid');
                    }

                    let feedbackElement = inputElement.nextElementSibling;
                    if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                        feedbackElement.innerHTML = errors[fieldName].join('<br>');
                    } else {
                        const parentDiv = inputElement.closest('.form-floating-outline');
                        if (parentDiv) {
                            feedbackElement = parentDiv.nextElementSibling;
                            if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                                feedbackElement.innerHTML = errors[fieldName].join('<br>');
                            }
                        } else {
                            const tdElement = inputElement.closest('td');
                            if (tdElement) {
                                feedbackElement = tdElement.querySelector('.invalid-feedback');
                                if (feedbackElement) {
                                    feedbackElement.innerHTML = errors[fieldName].join('<br>');
                                }
                            }
                        }
                    }
                } else {
                    console.warn(`Elemento HTML con name="${htmlFieldName}" no encontrado para el error de campo: ${fieldName}`);
                }
            }
        }
    }

    function clearValidationErrors(formElement) {
        console.log('Limpiando errores de validación del formulario.');
        formElement.querySelectorAll('.is-invalid').forEach(input => {
            input.classList.remove('is-invalid');
        });

        $(formElement).find('.select2-container').find('.select2-selection--single').removeClass('is-invalid');
        $(formElement).find('select[name$="[status]"]').each(function() {
            $(this).next('.select2-container').find('.select2-selection--single').removeClass('is-invalid');
        });

        formElement.querySelectorAll('.invalid-feedback').forEach(feedback => {
            feedback.innerHTML = '';
        });
    }

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
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
                agregarEmpresaModal.hide();
                table.ajax.reload(null, false);
            })
            .catch(error => {
                let errorMessage = 'Hubo un error inesperado al agregar la empresa.';

                if (error.status === 422 && error.data && error.data.errors) {
                    displayValidationErrors(error.data.errors, formAgregarContacto);
                } else if (error.data && error.data.message) {
                    errorMessage = error.data.message;
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        html: `${errorMessage}`,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                } else if (error.message) {
                    errorMessage = error.message;
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        html: `${errorMessage}`,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        html: `${errorMessage}`,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                }
            })
            .finally(() => {
                if (submitButton) {
                    submitButton.innerHTML = '<i class="ri-add-line"></i> Agregar Contacto';
                    submitButton.disabled = false;
                }
            });
        });
    }

    window.deleteUnidad = function(id) {
        console.log('Función eliminar llamada para ID:', id);
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-danger me-3',
                cancelButton: 'btn btn-label-secondary'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                console.log('Confirmado eliminar unidad con ID:', id);
                fetch(`/empresas/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    console.log('Respuesta de la API (raw) para eliminar:', response);
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            console.error('Error de respuesta (JSON):', errorData);
                            throw { status: response.status, data: errorData };
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: data.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                    table.ajax.reload(null, false);
                })
                .catch(error => {
                    console.error('Error en la solicitud AJAX (catch) para eliminar:', error);
                    let errorMessage = 'Hubo un error al eliminar la empresa.';
                    if (error.data && error.data.message) {
                        errorMessage = error.data.message;
                    } else if (error.message) {
                        errorMessage = error.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        html: `${errorMessage}`,
                        customClass: {
                            confirmButton: 'btn btn-danger'
                        }
                    });
                });
            }
        });
    };

    $(document).on('click', '.view-pdf-btn', function(event) {
        event.preventDefault();
        const pdfUrl = $(this).data('pdf-url');
        if (pdfUrl) {
            window.viewPdf(pdfUrl);
        } else {
            console.warn('No se encontró la URL del PDF para este elemento.');
        }
    });
});
