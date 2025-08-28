/**
 * Este script maneja la lógica para dos partes de la aplicación:
 * 1. La inicialización y el comportamiento de la tabla de servicios DataTables.
 * 2. La validación y el envío del formulario para agregar un nuevo servicio.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Definición de elementos principales del formulario de agregar servicio
    const formAgregarServicio = document.getElementById('formAgregarServicio');
    const formEditServicio = document.getElementById('editServicioForm');
    const selectClave = document.getElementById('clave');
    const precioInput = document.getElementById('precio');
    const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');
    const agregarRequisitoBtn = document.getElementById('agregar-requisito-btn');
    const requisitosContenedor = document.getElementById('requisitos-contenedor');
    const agregarLaboratorioBtn = document.getElementById('agregar-laboratorio-btn');
    const requiereMuestraSelect = document.getElementById('requiereMuestra');
    const metodoField = document.getElementById('metodoField');
    const tipoMuestraField = document.getElementById('tipoMuestraField');
    const tipoMuestraInput = document.getElementById('tipoMuestra');
    const acreditacionSelect = document.getElementById('acreditacion');

    // Variable para la instancia de DataTables, se inicializará más tarde
    let dt_servicios = null;

    // Cargar los datos de laboratorios desde el atributo data del formulario
    let laboratoriosData = [];
    if (formAgregarServicio) {
        try {
            const dataString = formAgregarServicio.getAttribute('data-laboratorios');
            if (dataString) {
                laboratoriosData = JSON.parse(dataString);
            }
        } catch (error) {
            console.error('Error al parsear los datos de laboratorios del formulario:', error);
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
     * Limpia los mensajes de error y las clases 'is-invalid' de un formulario.
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function clearValidationErrors(formElement) {
        if (!formElement) return;
        formElement.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        $(formElement).find('.select2-container .select2-selection--single').removeClass('is-invalid');
        formElement.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }

    /**
     * Muestra los errores de validación en el formulario.
     * @param {object} errors - Objeto con los errores de validación (campo: [mensajes]).
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    function displayValidationErrors(errors, formElement) {
        clearValidationErrors(formElement);
        let firstInvalidField = null;

        for (const [fieldName, messages] of Object.entries(errors)) {
            let inputElement = null;

            if (fieldName.includes('.')) {
                // Manejar campos dinámicos (e.g., precios_laboratorio.0)
                const parts = fieldName.split('.');
                const baseName = parts[0];
                const index = parts[1];

                if (baseName === 'precios_laboratorio') {
                    const precioItems = formElement.querySelectorAll('.precio-lab');
                    if (precioItems[index]) {
                        inputElement = precioItems[index];
                    }
                } else if (baseName === 'laboratorios_responsables') {
                    const labSelects = formElement.querySelectorAll('.laboratorio-item select');
                    if (labSelects[index]) {
                        inputElement = labSelects[index];
                    }
                } else if (baseName === 'requisitos') {
                    const requisitoInputs = formElement.querySelectorAll('input[name="requisitos[]"]');
                    if (requisitoInputs[index]) {
                        inputElement = requisitoInputs[index];
                    }
                }
            } else {
                // Manejar campos estándar
                inputElement = formElement.querySelector(`[name="${fieldName}"]`);
            }

            if (inputElement) {
                // Marcar el campo como inválido
                inputElement.classList.add('is-invalid');

                // Si es un select2, también marcar el contenedor del select2
                if ($(inputElement).hasClass('select2') || $(inputElement).is('select')) {
                    const select2Container = $(inputElement).next('.select2-container');
                    if (select2Container.length) {
                        select2Container.find('.select2-selection--single').addClass('is-invalid');
                    }
                }

                // Buscar o crear el elemento para el mensaje de error
                let feedbackElement = inputElement.nextElementSibling;
                if (!feedbackElement || !feedbackElement.classList.contains('invalid-feedback')) {
                    const newFeedback = document.createElement('div');
                    newFeedback.classList.add('invalid-feedback');
                    inputElement.parentNode.insertBefore(newFeedback, inputElement.nextSibling);
                    feedbackElement = newFeedback;
                }
                feedbackElement.innerHTML = messages.join('<br>');

                if (!firstInvalidField) {
                    firstInvalidField = inputElement;
                }
            } else {
                console.warn(`Elemento HTML no encontrado para el campo: ${fieldName}`);
            }
        }

        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            if (firstInvalidField.tagName.toLowerCase() === 'select') {
                $(firstInvalidField).next('.select2-container').find('.select2-selection--single').focus();
            } else {
                firstInvalidField.focus();
            }
        }
    }

    /**
     * Envía una petición de formulario mediante AJAX.
     * @param {HTMLFormElement} form - El formulario a enviar.
     * @param {string} url - La URL del endpoint.
     * @param {string} method - El método HTTP ('POST' o 'PUT').
     */
    async function submitForm(form, url, method = 'POST') {
        const submitButton = form.querySelector('button[type="submit"]');
        if (!submitButton) return false;

        const originalButtonHtml = submitButton.innerHTML;
        const loadingHtml = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

        submitButton.innerHTML = loadingHtml;
        submitButton.disabled = true;
        clearValidationErrors(form);

        try {
            const finalFormData = new FormData(form);
            
            // Añadir el método de sobreescritura para PUT
            if (method === 'PUT') {
                finalFormData.append('_method', 'PUT');
            }

            const response = await fetch(url, {
                method: 'POST', // Siempre usamos POST para enviar el FormData
                body: finalFormData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            const responseData = await response.json();

            if (!response.ok) {
                if (response.status === 422 && responseData.errors) {
                    displayValidationErrors(responseData.errors, form);
                    showSweetAlertError('Faltan campos', 'Por favor, completa los campos obligatorios. Los campos con errores han sido marcados en rojo. 🚨');
                } else {
                    throw new Error(responseData.message || 'Error inesperado.');
                }
            } else {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: responseData.message,
                    customClass: { confirmButton: 'btn btn-success' }
                }).then(() => {
                    // Redirigir solo si la acción fue exitosa y estamos en la vista de edición
                    if (method === 'PUT') {
                        window.location.href = "{{ route('servicios.index') }}";
                    } else if (dt_servicios) {
                        // Recargar la tabla si estamos en la vista de agregar servicio
                        dt_servicios.ajax.reload();
                    }
                    // Limpiar el formulario para permitir un nuevo registro
                    if (form.id === 'formAgregarServicio') {
                        form.reset();
                        clearValidationErrors(form);
                        // Restablecer Select2 si es necesario
                        $('.select2').val(null).trigger('change');
                        // Restablecer campos dinámicos a su estado inicial
                        laboratoriosContenedor.innerHTML = '';
                        requisitosContenedor.innerHTML = '';
                        // Se puede agregar un laboratorio por defecto si es necesario
                        agregarLaboratorioBtn.click();
                        // Actualizar el precio total
                        updatePrecioTotal();
                    }
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

    // Asocia los eventos al formulario de Agregar
    if (formAgregarServicio) {
        formAgregarServicio.addEventListener('submit', async function(event) {
            event.preventDefault();
            await submitForm(this, this.action, 'POST');
        });
    }

    // Asocia los eventos al formulario de Editar
    if (formEditServicio) {
        formEditServicio.addEventListener('submit', async function(event) {
            event.preventDefault();
            const servicioId = this.querySelector('input[name="id_servicio"]').value;
            // Asegúrate de que la URL de edición esté correctamente definida en tu HTML/Blade
            const editUrl = this.action || `/servicios/${servicioId}`;
            await submitForm(this, editUrl, 'PUT');
        });
    }

    // --- Lógica de campos dinámicos: Requisitos y Laboratorios ---
    if (agregarRequisitoBtn && requisitosContenedor) {
        agregarRequisitoBtn.addEventListener('click', function() {
            const nuevoRequisito = document.createElement('div');
            nuevoRequisito.classList.add('input-group', 'mb-3', 'requisito-item');
            nuevoRequisito.innerHTML = `
                <div class="form-floating form-floating-outline flex-grow-1">
                    <input type="text" class="form-control" name="requisitos[]" placeholder="Requisitos" />
                    <label>Requisitos</label>
                </div>
                <button type="button" class="btn btn-danger eliminar-requisito-btn ms-2">
                    <i class="ri-subtract-line"></i>
                </button>
            `;
            requisitosContenedor.appendChild(nuevoRequisito);
        });

        requisitosContenedor.addEventListener('click', function(e) {
            if (e.target.closest('.eliminar-requisito-btn')) {
                const btn = e.target.closest('.eliminar-requisito-btn');
                const item = btn.closest('.requisito-item');
                item.remove();
            }
        });
    }

    function updatePrecioTotal() {
        let total = 0;
        laboratoriosContenedor.querySelectorAll('.precio-lab').forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        if (precioInput) {
            precioInput.value = total.toFixed(2);
        }
    }

    if (precioInput) {
        precioInput.disabled = true;
        precioInput.readOnly = true;
    }

    if (agregarLaboratorioBtn && laboratoriosContenedor) {
        agregarLaboratorioBtn.addEventListener('click', function() {
            const nuevoLaboratorio = document.createElement('div');
            nuevoLaboratorio.classList.add('input-group', 'mb-3', 'laboratorio-item');

            let optionsHtml = '<option value="">Seleccione un laboratorio</option>';
            if (Array.isArray(laboratoriosData) && laboratoriosData.length > 0) {
                laboratoriosData.forEach(lab => {
                    optionsHtml += `<option value="${lab.id_laboratorio}">${lab.laboratorio}</option>`;
                });
            } else {
                console.warn('No se encontraron datos de laboratorios para generar el select.');
            }

            const clonedItem = document.createElement('div');
            clonedItem.classList.add('input-group', 'mb-3', 'laboratorio-item');
            clonedItem.innerHTML = `
                <div class="form-floating form-floating-outline flex-grow-1">
                    <input type="number" step="0.01" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" />
                    <label>Precio *</label>
                </div>
                <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                    <select class="form-select select2-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true">
                        ${optionsHtml}
                    </select>
                    <label for="select2-laboratorio">Laboratorio responsable *</label>
                </div>
                <button type="button" class="btn btn-danger eliminar-laboratorio-btn ms-2">
                    <i class="ri-subtract-line"></i>
                </button>
            `;

            laboratoriosContenedor.appendChild(clonedItem);

            const newSelect = clonedItem.querySelector('.select2-laboratorio');
            $(newSelect).select2({
                placeholder: 'Seleccione un laboratorio',
                allowClear: true
            });

            const newPrecioInput = clonedItem.querySelector('.precio-lab');
            if (newPrecioInput) {
                newPrecioInput.addEventListener('input', updatePrecioTotal);
            }
            updatePrecioTotal();
        });

        laboratoriosContenedor.addEventListener('click', function(e) {
            if (e.target.closest('.eliminar-laboratorio-btn')) {
                const btn = e.target.closest('.eliminar-laboratorio-btn');
                const item = btn.closest('.laboratorio-item');
                if (laboratoriosContenedor.children.length > 1) {
                    item.remove();
                    updatePrecioTotal();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No se puede eliminar',
                        text: 'Debe haber al menos un laboratorio responsable.',
                        customClass: { confirmButton: 'btn btn-warning' }
                    });
                }
            }
        });

        laboratoriosContenedor.addEventListener('input', function(e) {
            if (e.target.classList.contains('precio-lab')) {
                updatePrecioTotal();
            }
        });

        updatePrecioTotal();
    }

    // Lógica para la selección de clave y autocompletado del laboratorio responsable
    if (selectClave) {
        $(selectClave).on('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value !== "") {
                const idLaboratorio = selectedOption.getAttribute('data-id-lab');
                const laboratorioResponsableInput = document.getElementById('laboratorioResponsableInput');
                const laboratorioResponsableId = document.getElementById('laboratorioResponsableId');

                if (laboratorioResponsableInput && laboratorioResponsableId) {
                    laboratorioResponsableInput.value = selectedOption.getAttribute('data-nombre-lab');
                    laboratorioResponsableId.value = idLaboratorio;
                }

                const firstLabSelect = document.querySelector('#laboratorios-contenedor select[name="laboratorios_responsables[]"]');
                if (firstLabSelect) {
                    $(firstLabSelect).val(idLaboratorio).trigger('change');
                }
            } else {
                const laboratorioResponsableInput = document.getElementById('laboratorioResponsableInput');
                const laboratorioResponsableId = document.getElementById('laboratorioResponsableId');
                if (laboratorioResponsableInput && laboratorioResponsableId) {
                    laboratorioResponsableInput.value = '';
                    laboratorioResponsableId.value = '';
                }

                const firstLabSelect = document.querySelector('#laboratorios-contenedor select[name="laboratorios_responsables[]"]');
                if (firstLabSelect) {
                    $(firstLabSelect).val('').trigger('change');
                }
            }
        });
    }

    // Lógica para mostrar/ocultar campos de muestra y método
    function handleMuestraSelection() {
        if (!requiereMuestraSelect || !tipoMuestraField || !tipoMuestraInput || !acreditacionSelect) return;

        const isSiSelected = requiereMuestraSelect.value === 'si';
        const isAcreditadoSelected = acreditacionSelect.value.includes('Acreditado');

        if (isSiSelected) {
            tipoMuestraField.style.display = 'block';
            tipoMuestraInput.disabled = false;
        } else {
            tipoMuestraField.style.display = 'none';
            tipoMuestraInput.disabled = true;
            tipoMuestraInput.value = '';
        }

        if (isAcreditadoSelected) {
            metodoField.style.display = 'block';
        } else {
            metodoField.style.display = 'none';
        }
    }

    if (requiereMuestraSelect) {
        $(requiereMuestraSelect).on('change', handleMuestraSelection);
        handleMuestraSelection();
    }
    if (acreditacionSelect) {
        $(acreditacionSelect).on('change', handleMuestraSelection);
        handleMuestraSelection();
    }

    // Inicializa todos los selects con select2
    $('.select2').select2();

    // --- CÓDIGO DE DATATABLES ---
    const dt_servicios_table = $('#tablaServicios');

    if (dt_servicios_table.length) {
        try {
            // Verifica si 'dataTableAjaxUrl' está definido antes de usarlo
            if (typeof dataTableAjaxUrl === 'undefined') {
                console.error("La variable 'dataTableAjaxUrl' no está definida. Asegúrate de que se pase desde tu plantilla Blade.");
                showSweetAlertError('Error de Configuración', `La URL para cargar la tabla de servicios no está definida.`);
                return;
            }

            dt_servicios = dt_servicios_table.DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: dataTableAjaxUrl,
                    type: 'GET',
                    // Manejo de errores en la petición AJAX
                    error: function(xhr, error, thrown) {
                        console.error("Error al cargar datos con DataTables:", thrown);
                        console.log("Respuesta del servidor:", xhr.responseText);
                        showSweetAlertError('Error de Carga', `Hubo un problema al cargar los datos de la tabla. Revisa la consola para más detalles. Error: ${thrown}`);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'clave',
                        name: 'clave'
                    },
                    {
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'precio',
                        name: 'precio'
                    },
                    {
                        data: 'laboratorio',
                        name: 'laboratorio',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'duracion',
                        name: 'duracion'
                    },
                    {
                        data: 'id_habilitado',
                        name: 'id_habilitado'
                    },
                    {
                        // Modificación para el nuevo botón de acciones
                        data: 'acciones',
                        name: 'acciones',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <div class="d-flex justify-content-center">
                                <div class="dropdown">
                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuActions_${row.id_servicio}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuActions_${row.id_servicio}">
                                        <li>
                                            <a href="{{ url('servicios') }}/${row.id_servicio}" class="dropdown-item btn-view-servicio">
                                                <i class="ri-eye-line me-1"></i> Visualizar
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ url('servicios') }}/${row.id_servicio}/edit" class="dropdown-item btn-edit-servicio">
                                                <i class="ri-pencil-line me-1"></i> Editar
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item btn-disable-servicio" data-id="${row.id_servicio}">
                                                <i class="ri-delete-bin-line me-1"></i> Deshabilitar
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                // Configuración del DOM para la tabla
                // 't': Tabla, 'i': Información, 'p': Paginación.
                // Eliminamos 'l' (length) y 'f' (filter) para usar los controles manuales en el HTML
                dom: 't<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                responsive: true
            });

            // Event listener para el campo de búsqueda manual
            const searchInput = document.getElementById('buscar');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    dt_servicios.search(this.value).draw();
                });
            }

            // Event listener para el select de "Mostrar x registros"
            const lengthSelect = document.querySelector('select[name="tablaServicios_length"]');
            if (lengthSelect) {
                $(lengthSelect).on('change', function() {
                    dt_servicios.page.len(this.value).draw();
                });
            }

            // --- LÓGICA AGREGADA: MANEJO DEL BOTÓN DE DESHABILITAR ---
            dt_servicios_table.on('click', '.btn-disable-servicio', function() {
                const servicioId = $(this).data('id');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ¡deshabilitar!',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        confirmButton: 'btn btn-danger me-3',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviamos la petición AJAX para deshabilitar el servicio
                        const url = `/servicios/${servicioId}`; // Asegúrate de que esta URL exista
                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw new Error(errorData.message || 'Error al deshabilitar el servicio.');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Deshabilitado!',
                                text: data.message,
                                customClass: { confirmButton: 'btn btn-success' }
                            });
                            // Recargar la tabla para reflejar el cambio
                            dt_servicios.ajax.reload();
                        })
                        .catch(error => {
                            showSweetAlertError('Error de Deshabilitación', `Hubo un problema: ${error.message}`);
                        });
                    }
                });
            });

            // Manejo de clic para el botón de editar
            dt_servicios_table.on('click', '.btn-edit-servicio', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                window.location.href = url;
            });

        } catch (error) {
            console.error('Error al inicializar la tabla de DataTables:', error);
            showSweetAlertError('Error de Inicialización', `Hubo un problema al inicializar la tabla de servicios. Revisa la consola para más detalles.`);
        }
    }
});
