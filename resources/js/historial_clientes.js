// resources/js/historial_clientes.js

// Mueve la función viewPdf al ámbito global explícitamente
window.viewPdf = function(pdfUrl) {
    const pdfViewerFrame = document.getElementById('pdfViewerFrame');
    const openPdfInNewTabBtn = document.getElementById('openPdfInNewTabBtn');
    const pdfLoadingMessage = document.getElementById('pdfLoadingMessage');
    const viewPdfModalElement = document.getElementById('viewPdfModal');

    // Registra la URL del PDF para depuración
    console.log('Intentando cargar contenido desde URL:', pdfUrl);

    // Mostrar mensaje de carga y ocultar iframe mientras se carga
    pdfLoadingMessage.innerText = 'Cargando contenido... Si no se muestra aquí, por favor, usa el botón "Abrir en otra pestaña".';
    pdfLoadingMessage.style.display = 'block';
    pdfViewerFrame.style.display = 'none';
    pdfViewerFrame.src = ''; // Limpiar src anterior

    // Asignar la URL del PDF/imagen al iframe.
    // Aunque sea una imagen, la modal se usa para "visualizar" contenido.
    // El navegador mostrará la imagen directamente si la URL apunta a una imagen.
    pdfViewerFrame.src = pdfUrl;

    // Actualizar el enlace del botón "Abrir en otra pestaña"
    openPdfInNewTabBtn.href = pdfUrl;

    // Manejar la carga del iframe
    pdfViewerFrame.onload = function() {
        pdfLoadingMessage.style.display = 'none'; // Ocultar mensaje de carga
        pdfViewerFrame.style.display = 'block'; // Mostrar iframe
        console.log('Contenido cargado exitosamente en el iframe (o el navegador lo maneja).');
    };

    pdfViewerFrame.onerror = function() {
        pdfLoadingMessage.innerText = 'Error al cargar el contenido en la ventana. Esto puede deberse a restricciones de seguridad del navegador o un formato no compatible. Por favor, haz clic en "Abrir en otra pestaña".';
        pdfLoadingMessage.style.display = 'block';
        pdfViewerFrame.style.display = 'none';
        console.error('Error al cargar el contenido en el iframe. URL:', pdfUrl);
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
    // Comprobar si dataTableAjaxUrl está definida
    if (typeof dataTableAjaxUrl === 'undefined') {
        console.error("Error: 'dataTableAjaxUrl' no está definida. Asegúrate de definirla en tu vista Blade.");
        return;
    }

    // Inicialización de la tabla de datos de historial de clientes
    var table = $('#tablaHistorial').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json', // Idioma español
        },
        processing: true, // Mostrar indicador de procesamiento
        serverSide: true, // Procesamiento en el lado del servidor
        responsive: false, // Desactivar responsividad por defecto (ajuste manual si es necesario)
        ajax: {
            url: dataTableAjaxUrl, // URL para obtener los datos de la tabla
            type: "GET",
            data: function(d) {
                // Parámetros adicionales para la solicitud AJAX si son necesarios
            }
        },
        columns: [
            // Definición de columnas para DataTables
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '25px', className: 'text-center' },
            { data: 'nombre', name: 'nombre', width: '100px', className: 'text-wrap' },
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
                    // Ruta de la imagen para el icono de PDF subido
                    const pdfIconUrl = '/assets/img/icons/misc/pdf.png';
                    // Ruta de la imagen para cuando no hay PDF
                    const missingPdfImageUrl = '/img_pdf/FaltaPDF.png';

                    // Si 'data' tiene un valor (se asume que es la URL del PDF real)
                    if (data) {
                        // Usar la imagen pdf.png para los PDFs subidos
                        // Se quita 'btn-outline-secondary' y se añade 'btn-no-border' (se requiere CSS adicional)
                        return `<button type="button" class="btn btn-icon waves-effect waves-light view-pdf-btn btn-no-border" data-pdf-url="${data}">
                                    <img src="${pdfIconUrl}" alt="Ver PDF" style="width: 40px; height: auto;">
                                </button>`;
                    } else {
                        // Si 'data' es null (no hay PDF), muestra la imagen de "FaltaPDF.png"
                        // Se quita 'btn-outline-secondary' y se añade 'btn-no-border' (se requiere CSS adicional)
                        return `<button type="button" class="btn btn-icon waves-effect waves-light view-pdf-btn btn-no-border" data-pdf-url="${missingPdfImageUrl}">
                                    <img src="${missingPdfImageUrl}" alt="PDF no disponible" style="width: 40px; height: auto;">
                                </button>`;
                    }
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false, width: '80px', className: 'text-center' }
        ],
        autoWidth: false, // Desactivar ajuste automático del ancho de columna
    });

    // Modales de Bootstrap
    const editHistorialModal = new bootstrap.Modal(document.getElementById('editHistorialModal'));
    const modalContentContainer = document.getElementById('editHistorialModalContent');

    const viewHistorialModalElement = document.getElementById('viewHistorialModal');
    const viewHistorialModal = new bootstrap.Modal(viewHistorialModalElement);
    const viewModalContentContainer = document.getElementById('viewHistorialModalContent');

    const agregarEmpresaModal = new bootstrap.Modal(document.getElementById('agregarEmpresa'));
    const formAgregarContacto = document.getElementById('formAgregarContacto');

    let contactIndex = 0; // Índice para los campos de contacto dinámicos

    /**
     * Añade una nueva fila de contacto al formulario.
     * @param {string} containerId - El ID del contenedor donde se añadirá la fila.
     * @param {object} data - Objeto con datos predefinidos para la fila (contacto, celular, correo, status, observaciones).
     * @param {boolean} isViewMode - Si la fila es para modo de visualización (deshabilita campos y elimina botón de remover).
     */
    function addContactRow(containerId, data = {}, isViewMode = false) {
        const template = document.getElementById('contact-row-template');
        const clone = template.content.cloneNode(true);
        const newRow = clone.querySelector('.contact-row');

        // Renombrar atributos 'name' para que sean únicos y compatibles con arrays PHP (contactos[INDEX][campo])
        $(newRow).find('[name^="contactos[INDEX]"]').each(function() {
            $(this).attr('name', $(this).attr('name').replace('INDEX', contactIndex));
        });

        // Rellenar campos con datos si se proporcionan
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

        // Configurar modo de visualización o edición
        if (isViewMode) {
            $(newRow).find('input, select, textarea').prop('disabled', true); // Deshabilitar todos los campos
            $(newRow).find('.remove-contact-row').closest('td').remove(); // Remover el botón de eliminar
        } else {
            // Añadir listener para remover fila en modo edición/creación
            newRow.querySelector('.remove-contact-row').addEventListener('click', function() {
                this.closest('.contact-row').remove();
            });
        }

        document.getElementById(containerId).appendChild(newRow); // Añadir la nueva fila al DOM

        // Inicializar Select2 para el campo de estado si existe
        const newSelect = $(newRow).find('select[name$="[status]"]');
        if (newSelect.length) {
            newSelect.select2({
                minimumResultsForSearch: Infinity, // No mostrar campo de búsqueda
                dropdownParent: newSelect.closest('td') // Asegurar que el dropdown se muestre correctamente
            });
        }

        contactIndex++; // Incrementar el índice para la próxima fila
    }

    // Eventos para la modal de "Agregar Empresa"
    $('#agregarEmpresa').on('shown.bs.modal', function () {
        console.log('Modal Agregar mostrada. Inicializando Select2 y Contactos.');
        // Inicializar Select2 para todos los selects dentro de la modal
        $('#agregarEmpresa .select2').select2({
            dropdownParent: $('#agregarEmpresa') // Asegurar que el dropdown se muestre correctamente
        });
        contactIndex = 0; // Reiniciar índice de contacto
        $('#contact-rows-container-agregar').empty(); // Limpiar contactos anteriores
        addContactRow('contact-rows-container-agregar'); // Añadir una fila de contacto inicial
    });

    $('#agregarEmpresa').on('hidden.bs.modal', function () {
        console.log('Modal Agregar oculta. Limpiando formulario y errores.');
        if (formAgregarContacto) {
            clearValidationErrors(formAgregarContacto); // Limpiar errores de validación
            formAgregarContacto.reset(); // Resetear el formulario
            $('#agregarEmpresa .select2').select2('destroy'); // Destruir instancias de Select2
        }
    });

    // Listener para el botón "Agregar Contacto" en la modal de agregar
    document.getElementById('add-contact-row-agregar').addEventListener('click', function() {
        addContactRow('contact-rows-container-agregar');
    });

    /**
     * Función global para editar una unidad (empresa).
     * @param {number} id - El ID de la empresa a editar.
     */
    window.editUnidad = function(id) {
        console.log('Función editar llamada para ID:', id);

        // Mostrar un spinner de carga mientras se carga el formulario
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
        editHistorialModal.show(); // Mostrar la modal

        // Realizar una solicitud AJAX para obtener el formulario de edición
        fetch(`/empresas/${id}/edit-modal`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Indica que es una solicitud AJAX
                'Accept': 'text/html' // Espera HTML como respuesta
            }
        })
        .then(response => {
            console.log('Respuesta de carga de modal de edición (raw):', response);
            if (!response.ok) {
                // Si la respuesta no es OK, intenta leer el error
                return response.text().then(text => { throw new Error(text || response.statusText); });
            }
            return response.text(); // Devuelve el HTML del formulario
        })
        .then(html => {
            if (modalContentContainer) {
                modalContentContainer.innerHTML = html; // Cargar el HTML en el contenedor de la modal
                console.log('Contenido de modal de edición cargado. Adjuntando listeners.');

                // Establecer el contactIndex basado en las filas ya existentes
                contactIndex = $('#contact-rows-container-editar').children().length;

                // Si no hay contactos preexistentes, añadir uno vacío
                if (contactIndex === 0) {
                    addContactRow('contact-rows-container-editar');
                } else {
                    // Si ya hay contactos, adjuntar listeners de eliminación a los existentes
                    $('#contact-rows-container-editar .remove-contact-row').each(function() {
                        this.addEventListener('click', function() {
                            this.closest('.contact-row').remove();
                        });
                    });
                }

                // Inicializar Select2 para campos dentro del formulario de edición
                $('#editarhistorial .select2').select2({
                    dropdownParent: $('#editHistorialModal')
                });

                // Inicializar Select2 específicamente para los selectores de status de contacto
                $('#contact-rows-container-editar select[name$="[status]"]').each(function() {
                    $(this).select2({
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $(this).closest('td')
                    });
                });

                // Listener para el botón "Agregar Contacto" en la modal de edición
                document.getElementById('add-contact-row-editar').addEventListener('click', function() {
                    addContactRow('contact-rows-container-editar');
                });

                // Manejar el envío del formulario de edición
                const form = document.getElementById('editarhistorial');
                if (form) {
                    console.log('Formulario de edición encontrado. Adjuntando listener.');
                    form.addEventListener('submit', function(event) {
                        console.log('Evento submit del formulario de edición disparado.');
                        event.preventDefault(); // Prevenir el envío tradicional del formulario
                        clearValidationErrors(this); // Limpiar errores de validación anteriores

                        const formData = new FormData(this); // Crear FormData del formulario
                        formData.append('_method', 'PUT'); // Simular el método PUT para Laravel

                        const empresaId = document.getElementById('idHistorial').value;
                        const updateUrl = `/empresas/${empresaId}`;

                        console.log('URL de actualización (updateUrl):', updateUrl);
                        // Loguear los datos del FormData para depuración
                        for (let [key, value] of formData.entries()) {
                            console.log(`${key}: ${value}`);
                        }

                        // Deshabilitar el botón de envío y mostrar spinner
                        const submitButton = form.querySelector('button[type="submit"]');
                        if (submitButton) {
                            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
                            submitButton.disabled = true;
                        }

                        // Enviar datos del formulario a través de AJAX
                        fetch(updateUrl, {
                            method: 'POST', // Usar POST con _method PUT
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Token CSRF para seguridad
                            }
                        })
                        .then(response => {
                            console.log('Respuesta de la API (raw):', response);
                            if (!response.ok) {
                                // Si hay errores, parsear el JSON de errores
                                return response.json().then(errorData => {
                                    console.error('Error de respuesta (JSON):', errorData);
                                    throw { status: response.status, data: errorData };
                                });
                            }
                            return response.json(); // Si es exitoso, parsear el JSON de respuesta
                        })
                        .then(data => {
                            console.log('Éxito al actualizar empresa:', data);
                            // Mostrar mensaje de éxito con SweetAlert2
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: data.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            });
                            editHistorialModal.hide(); // Ocultar la modal de edición
                            table.ajax.reload(null, false); // Recargar la tabla de datos
                        })
                        .catch(error => {
                            console.error('Error en la solicitud AJAX (catch):', error);
                            let errorMessage = 'Hubo un error inesperado al actualizar la empresa.';

                            // Manejar errores de validación de Laravel (estado 422)
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
                            // Revertir estado del botón de envío
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

        // Mostrar un spinner de carga mientras se carga la información
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
        viewHistorialModal.show(); // Mostrar la modal de visualización

        // Realizar una solicitud AJAX para obtener el contenido de visualización
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
                viewModalContentContainer.innerHTML = html; // Cargar el HTML en el contenedor
                console.log('Contenido de modal de visualización cargado.');

                // Inicializar Select2 para los selects en la modal de visualización
                // Aunque estén deshabilitados, Select2 puede mejorar la apariencia si ya se usa en la aplicación
                $('#visualizarhistorialForm .select2').select2({ // ID actualizado para el formulario de visualización
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

    // Evento cuando la modal de edición se oculta
    $('#editHistorialModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('editarhistorial');
        if (form) {
            console.log('Modal Editar oculta. Limpiando errores y destruyendo Select2.');
            clearValidationErrors(form); // Limpiar errores de validación
            const motivoEdicionField = form.querySelector('#motivoEdicion'); // Campo específico para motivo de edición
            if (motivoEdicionField) {
                motivoEdicionField.value = '';
                motivoEdicionField.classList.remove('is-invalid');
                const feedback = motivoEdicionField.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.innerHTML = '';
                }
            }
            $(form).find('.select2').select2('destroy'); // Destruir instancias de Select2 generales
            $(form).find('select[name$="[status]"]').select2('destroy'); // Destruir instancias de Select2 para estados
        }
    });

    // Evento cuando la modal de visualización se oculta
    $('#viewHistorialModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('visualizarhistorialForm'); // ID actualizado
        if (form) {
            console.log('Modal Visualizar oculta. Destruyendo Select2.');
            $(form).find('.select2').select2('destroy'); // Destruir instancias de Select2 generales
            $(form).find('select').select2('destroy'); // Destruir todas las instancias de Select2 restantes
        }
    });

    /**
     * Muestra los errores de validación en el formulario.
     * @param {object} errors - Objeto con los errores de validación (campo: [mensajes]).
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function displayValidationErrors(errors, formElement) {
        clearValidationErrors(formElement); // Limpiar errores anteriores
        console.log('Mostrando errores de validación:', errors);

        for (const fieldName in errors) {
            if (errors.hasOwnProperty(fieldName)) {
                let htmlFieldName = fieldName;
                // Mapear nombres de campo de la validación a los nombres HTML si son diferentes
                if (fieldName === 'noext') {
                    htmlFieldName = 'no_exterior';
                } else if (fieldName === 'regimen') {
                    htmlFieldName = 'regimen'; // Confirmar si 'regimen' se mapea a sí mismo o a otro
                } else if (fieldName === 'municipio') {
                    htmlFieldName = 'municipio'; // Confirmar si 'municipio' se mapea a sí mismo o a otro
                } else if (fieldName.startsWith('contactos.')) {
                    // Manejar errores para campos de arrays dinámicos (contactos)
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
                    inputElement.classList.add('is-invalid'); // Añadir clase de Bootstrap para invalidación

                    // Si es un Select2, añadir la clase 'is-invalid' al contenedor de Select2
                    if ($(inputElement).hasClass('select2') || $(inputElement).is('select[name$="[status]"]')) {
                        $(inputElement).next('.select2-container').find('.select2-selection--single').addClass('is-invalid');
                    }

                    // Encontrar y mostrar el mensaje de feedback
                    let feedbackElement = inputElement.nextElementSibling;
                    if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                        feedbackElement.innerHTML = errors[fieldName].join('<br>');
                    } else {
                        // Buscar el feedback si está en un contenedor diferente (ej. form-floating-outline)
                        const parentDiv = inputElement.closest('.form-floating-outline');
                        if (parentDiv) {
                            feedbackElement = parentDiv.nextElementSibling;
                            if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                                feedbackElement.innerHTML = errors[fieldName].join('<br>');
                            }
                        } else {
                            // Buscar el feedback si está dentro de un <td> (para filas de contacto)
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

    /**
     * Limpia todos los errores de validación de un formulario.
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function clearValidationErrors(formElement) {
        console.log('Limpiando errores de validación del formulario.');
        // Remover clase 'is-invalid' de todos los inputs
        formElement.querySelectorAll('.is-invalid').forEach(input => {
            input.classList.remove('is-invalid');
        });

        // Remover clase 'is-invalid' de los contenedores de Select2
        $(formElement).find('.select2-container').find('.select2-selection--single').removeClass('is-invalid');
        $(formElement).find('select[name$="[status]"]').each(function() {
            $(this).next('.select2-container').find('.select2-selection--single').removeClass('is-invalid');
        });

        // Limpiar el contenido de los mensajes de feedback
        formElement.querySelectorAll('.invalid-feedback').forEach(feedback => {
            feedback.innerHTML = '';
        });
    }

    // Manejar el envío del formulario de agregar contacto/empresa
    if (formAgregarContacto) {
        formAgregarContacto.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir el envío tradicional
            clearValidationErrors(this); // Limpiar errores anteriores

            const formData = new FormData(this);
            const storeUrl = this.action; // Obtener la URL de la acción del formulario

            // Deshabilitar botón de envío y mostrar spinner
            const submitButton = document.getElementById('agregar-empresa-btn');
            if (submitButton) {
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
                submitButton.disabled = true;
            }

            // Enviar datos vía AJAX
            fetch(storeUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Token CSRF
                    'X-Requested-With': 'XMLHttpRequest' // Indica solicitud AJAX
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
                // Mostrar éxito y recargar tabla
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                });
                agregarEmpresaModal.hide(); // Ocultar modal
                table.ajax.reload(null, false); // Recargar DataTables
            })
            .catch(error => {
                let errorMessage = 'Hubo un error inesperado al agregar la empresa.';

                // Manejar errores de validación y otros errores
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
                // Revertir estado del botón de envío
                if (submitButton) {
                    submitButton.innerHTML = '<i class="ri-add-line"></i> Agregar Contacto';
                    submitButton.disabled = false;
                }
            });
        });
    }

    /**
     * Función global para eliminar una unidad (empresa).
     * @param {number} id - El ID de la empresa a eliminar.
     */
    window.deleteUnidad = function(id) {
        console.log('Función eliminar llamada para ID:', id);
        // Mostrar confirmación con SweetAlert2
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
            buttonsStyling: false // Deshabilitar estilos por defecto de SweetAlert2 para usar customClass
        }).then(function (result) {
            if (result.value) { // Si el usuario confirma
                console.log('Confirmado eliminar unidad con ID:', id);
                fetch(`/empresas/${id}`, {
                    method: 'DELETE', // Método DELETE
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Token CSRF
                        'X-Requested-With': 'XMLHttpRequest' // Indica solicitud AJAX
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
                    // Mostrar éxito y recargar tabla
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: data.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                    table.ajax.reload(null, false); // Recargar DataTables
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

    // Listener para el clic en los botones de "Ver PDF" (y ahora también las imágenes "FaltaPDF")
    $(document).on('click', '.view-pdf-btn', function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del enlace
        const pdfUrl = $(this).data('pdf-url'); // Obtener la URL del PDF/imagen del atributo data-pdf-url
        if (pdfUrl) {
            window.viewPdf(pdfUrl); // Llamar a la función global para ver el contenido
        } else {
            console.warn('No se encontró la URL del contenido para este elemento.');
        }
    });
});