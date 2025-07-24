// resources/js/historial_clientes.js

$(function() {
    // Verifica que la variable dataTableAjaxUrl esté definida (viene de la vista Blade)
    if (typeof dataTableAjaxUrl === 'undefined') {
        console.error("Error: 'dataTableAjaxUrl' no está definida. Asegúrate de definirla en tu vista Blade.");
        return; // Detener la ejecución si la URL no está disponible
    }

    // Inicializa DataTables usando el ID de la tabla
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
                // Puedes añadir parámetros adicionales a la solicitud AJAX aquí si es necesario
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

    // Inicializar la instancia de la modal de edición
    const editHistorialModal = new bootstrap.Modal(document.getElementById('editHistorialModal'));
    const modalContentContainer = document.getElementById('editHistorialModalContent'); // Contenedor para el contenido dinámico

    // Inicializar la instancia de la modal de agregar
    const agregarEmpresaModal = new bootstrap.Modal(document.getElementById('agregarEmpresa'));
    const formAgregarContacto = document.getElementById('formAgregarContacto'); // Formulario de agregar

    // --- Funciones para manejar campos de contacto dinámicos ---
    let contactIndex = 0; // Para asignar índices únicos a los campos de contacto

    /**
     * Añade una nueva fila de campos de contacto al contenedor especificado.
     * @param {string} containerId - El ID del tbody donde se añadirán las filas (ej. 'contact-rows-container-agregar').
     * @param {object} [data={}] - Objeto con datos para pre-llenar la fila (nombre_contacto, telefono_contacto, correo_contacto, status, observaciones).
     */
    function addContactRow(containerId, data = {}) {
        const template = document.getElementById('contact-row-template');
        const clone = template.content.cloneNode(true);
        const newRow = clone.querySelector('.contact-row');

        // Reemplazar INDEX con el índice actual
        newRow.innerHTML = newRow.innerHTML.replace(/INDEX/g, contactIndex);

        // Pre-llenar los campos si se proporcionan datos
        if (data.contacto) {
            newRow.querySelector('[name$="[contacto]"]').value = data.contacto;
        }
        if (data.celular) {
            newRow.querySelector('[name$="[celular]"]').value = data.celular;
        }
        if (data.correo) {
            newRow.querySelector('[name$="[correo]"]').value = data.correo;
        }
        // NUEVOS CAMPOS: status y observaciones
        const statusField = newRow.querySelector('[name$="[status]"]');
        if (statusField) {
            statusField.value = data.status !== undefined ? data.status.toString() : '0';
        }
        const observacionesField = newRow.querySelector('[name$="[observaciones]"]');
        if (observacionesField) {
            observacionesField.value = data.observaciones || '';
        }


        // Adjuntar listener para el botón de eliminar
        newRow.querySelector('.remove-contact-row').addEventListener('click', function() {
            this.closest('.contact-row').remove();
        });

        document.getElementById(containerId).appendChild(newRow);
        contactIndex++; // Incrementar el índice para la próxima fila
    }

    // --- Manejo de la modal de AGREGAR ---
    $('#agregarEmpresa').on('shown.bs.modal', function () {
        console.log('Modal Agregar mostrada. Inicializando Select2 y Contactos.');
        $('#agregarEmpresa .select2').select2({
            dropdownParent: $('#agregarEmpresa')
        });
        // Reiniciar el índice de contactos y añadir una fila vacía al abrir la modal de agregar
        contactIndex = 0;
        $('#contact-rows-container-agregar').empty(); // Limpiar filas anteriores
        addContactRow('contact-rows-container-agregar'); // Añadir la primera fila vacía
    });

    $('#agregarEmpresa').on('hidden.bs.modal', function () {
        console.log('Modal Agregar oculta. Limpiando formulario y errores.');
        if (formAgregarContacto) {
            clearValidationErrors(formAgregarContacto);
            formAgregarContacto.reset(); // También resetea el formulario al cerrar
        }
    });

    // Listener para el botón "Añadir contacto" en la modal de agregar
    document.getElementById('add-contact-row-agregar').addEventListener('click', function() {
        addContactRow('contact-rows-container-agregar');
    });

    // --- Manejo de la modal de EDITAR ---
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

                // Reiniciar el índice de contactos
                contactIndex = $('#contact-rows-container-editar').children().length; // Establecer el índice basado en las filas existentes cargadas por Blade

                // Si no hay contactos existentes, añadir una fila vacía
                if (contactIndex === 0) {
                    addContactRow('contact-rows-container-editar');
                }

                // Asegurar que el Select2 se inicialice correctamente para los selects principales
                $('#editarhistorial .select2').select2({
                    dropdownParent: $('#editHistorialModal')
                });
                // Y para los selects de estatus en las filas de contacto, si existen
                $('#contact-rows-container-editar select[name$="[status]"]').each(function() {
                    $(this).select2({
                        minimumResultsForSearch: Infinity, // Oculta la barra de búsqueda para selects pequeños
                        dropdownParent: $(this).closest('td') // Asegura que el dropdown se muestre correctamente
                    });
                });


                $('#editHistorialModal').on('shown.bs.modal', function () {
                    console.log('Modal Editar mostrada. Inicializando Select2.');
                    $('#editarhistorial .select2').select2({
                        dropdownParent: $('#editHistorialModal')
                    });
                     $('#contact-rows-container-editar select[name$="[status]"]').each(function() {
                        $(this).select2({
                            minimumResultsForSearch: Infinity,
                            dropdownParent: $(this).closest('td')
                        });
                    });
                });
                if (editHistorialModal._isShown) {
                    console.log('Modal Editar ya estaba visible. Inicializando Select2 directamente.');
                    $('#editarhistorial .select2').select2({
                        dropdownParent: $('#editHistorialModal')
                    });
                     $('#contact-rows-container-editar select[name$="[status]"]').each(function() {
                        $(this).select2({
                            minimumResultsForSearch: Infinity,
                            dropdownParent: $(this).closest('td')
                        });
                    });
                }

                $('#editHistorialModal').on('hidden.bs.modal', function () {
                    const form = document.getElementById('editarhistorial');
                    if (form) {
                        console.log('Modal Editar oculta. Limpiando errores.');
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
                    }
                });

                // Listener para el botón "Añadir contacto" en la modal de editar
                document.getElementById('add-contact-row-editar').addEventListener('click', function() {
                    addContactRow('contact-rows-container-editar');
                    // Re-inicializar Select2 para el nuevo select de estatus
                    const newSelect = $('#contact-rows-container-editar .contact-row:last-child').find('select[name$="[status]"]');
                    if (newSelect.length) {
                        newSelect.select2({
                            minimumResultsForSearch: Infinity,
                            dropdownParent: newSelect.closest('td')
                        });
                    }
                });

                const form = document.getElementById('editarhistorial');
                if (form) {
                    console.log('Formulario de edición encontrado. Adjuntando listener.');
                    form.addEventListener('submit', function(event) {
                        console.log('Evento submit del formulario de edición disparado.');
                        event.preventDefault();
                        clearValidationErrors(this);

                        const formData = new FormData(this);

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
                                'X-Requested-With': 'XMLHttpRequest'
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
                modalContentContainer.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar el formulario: ${error.message}</div></div>`;
            }
        });
    };

    /**
     * Muestra los errores de validación en el formulario.
     * @param {object} errors - Objeto de errores de Laravel (ej. {campo: ['mensaje1', 'mensaje2']})
     * @param {HTMLElement} formElement - El elemento del formulario donde se mostrarán los errores.
     */
    function displayValidationErrors(errors, formElement) {
        clearValidationErrors(formElement); // Limpiar errores previos
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

                    // Para Select2, el error se muestra en el contenedor de Select2
                    if ($(inputElement).hasClass('select2')) {
                        $(inputElement).next('.select2-container').find('.select2-selection--single').addClass('is-invalid');
                    }

                    // Intenta encontrar el elemento de feedback directamente después del input
                    let feedbackElement = inputElement.nextElementSibling;
                    if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                        feedbackElement.innerHTML = errors[fieldName].join('<br>');
                    } else {
                        // Si no está directamente, busca en el padre más cercano con form-floating-outline
                        const parentDiv = inputElement.closest('.form-floating-outline');
                        if (parentDiv) {
                            feedbackElement = parentDiv.nextElementSibling;
                            if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                                feedbackElement.innerHTML = errors[fieldName].join('<br>');
                            }
                        } else {
                            // Para elementos dentro de tablas (como los contactos)
                            const tdElement = inputElement.closest('td');
                            if (tdElement) {
                                // Busca el invalid-feedback dentro de la misma celda
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

    /**
     * Limpia los errores de validación de un formulario.
     * @param {HTMLElement} formElement - El elemento del formulario a limpiar.
     */
    function clearValidationErrors(formElement) {
        console.log('Limpiando errores de validación del formulario.');
        formElement.querySelectorAll('.is-invalid').forEach(input => {
            input.classList.remove('is-invalid');
        });

        $(formElement).find('.select2-container').find('.select2-selection--single').removeClass('is-invalid');

        formElement.querySelectorAll('.invalid-feedback').forEach(feedback => {
            feedback.innerHTML = '';
        });
    }

    // --- Manejador de envío del formulario de AGREGAR (se mantiene igual) ---
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

    // --- Función para eliminar (se mantiene igual) ---
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
                            console.error('Error de respuesta (JSON) para eliminar:', errorData);
                            throw { status: response.status, data: errorData };
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Éxito al eliminar empresa:', data);
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
});
