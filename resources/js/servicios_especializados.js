document.addEventListener('DOMContentLoaded', function () {
    // Definición de elementos y variables principales
    const formAgregarServicio = document.getElementById('formAgregarServicio');
    const agregarServicioModalElement = document.getElementById('agregarServicioModal');
    const editServicioModalElement = document.getElementById('editServicioModal');
    const viewServicioModalElement = document.getElementById('viewServicioModal');
    const viewPdfModalElement = document.getElementById('viewPdfModal');
    const exportModalElement = document.getElementById('exportarServiciosModal');

    // Inicialización de modales
    const agregarServicioModal = agregarServicioModalElement ? new bootstrap.Modal(agregarServicioModalElement) : null;
    const editServicioModal = editServicioModalElement ? new bootstrap.Modal(editServicioModalElement) : null;
    const viewServicioModal = viewServicioModalElement ? new bootstrap.Modal(viewServicioModalElement) : null;
    const viewPdfModal = viewPdfModalElement ? new bootstrap.Modal(viewPdfModalElement) : null;
    const exportModal = exportModalElement ? new bootstrap.Modal(exportarServiciosModal) : null;

    let dataTable;
    let laboratoriosData = [];

    // Cargar los datos de laboratorios desde el atributo data del formulario
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
            // Manejar errores para campos de array como 'precios_laboratorio.0'
            const fieldParts = fieldName.split('.');
            let inputElement;

            if (fieldParts.length > 1) {
                const baseName = fieldParts[0];
                const index = fieldParts[1];
                const isPriceField = baseName === 'precios_laboratorio';
                const isLabField = baseName === 'laboratorios_responsables';

                if (isPriceField) {
                    inputElement = formElement.querySelectorAll(`.laboratorio-item .precio-lab`)[index];
                } else if (isLabField) {
                    inputElement = formElement.querySelectorAll(`.laboratorio-item select`)[index];
                }
            } else {
                inputElement = formElement.querySelector(`[name="${fieldName}"]`);
            }

            if (inputElement) {
                inputElement.classList.add('is-invalid');

                if ($(inputElement).hasClass('select2') || $(inputElement).is('select')) {
                    $(inputElement).next('.select2-container').find('.select2-selection--single').addClass('is-invalid');
                }
                const feedbackElement = inputElement.nextElementSibling;
                if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                    feedbackElement.innerHTML = messages.join('<br>');
                } else {
                    console.warn(`No se encontró un elemento invalid-feedback para el campo ${fieldName}.`);
                }
            } else {
                console.warn(`Elemento HTML con name="${fieldName}" no encontrado.`);
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
     * Actualiza la tabla.
     */
    function updateUI() {
        if (dataTable) {
            dataTable.ajax.reload(null, false);
        }
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
            // Recopilar manualmente todos los datos del formulario, incluyendo arrays
            const formData = new FormData(form);
            const data = {};
            for (let [key, value] of formData.entries()) {
                // Manejar campos de arrays
                if (key.endsWith('[]')) {
                    key = key.slice(0, -2);
                    if (!data[key]) {
                        data[key] = [];
                    }
                    data[key].push(value);
                } else {
                    data[key] = value;
                }
            }

            // Recopilar los datos de laboratorios y precios manualmente
            data.laboratorios_responsables = Array.from(form.querySelectorAll('.laboratorio-item select')).map(select => select.value);
            data.precios_laboratorio = Array.from(form.querySelectorAll('.laboratorio-item .precio-lab')).map(input => input.value);
            
            // Construir el FormData final para el envío
            const finalFormData = new FormData();
            for (const key in data) {
                if (Array.isArray(data[key])) {
                    data[key].forEach(value => finalFormData.append(`${key}[]`, value));
                } else {
                    finalFormData.append(key, data[key]);
                }
            }

            // Agregar el archivo si existe
            if (form.querySelector('input[name="file_requisitos"]').files.length > 0) {
                finalFormData.append('file_requisitos', form.querySelector('input[name="file_requisitos"]').files[0]);
            }
            
            const response = await fetch(url, {
                method: 'POST',
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
                } else {
                    throw new Error(responseData.message || 'Error inesperado.');
                }
            } else {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: responseData.message,
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
     * Muestra el modal con el formulario de edición cargado vía AJAX.
     * @param {number} id - El ID del servicio a editar.
     */
    async function showEditModal(id) {
        const editServicioModalContent = document.getElementById('editServicioModalContent');
        if (!editServicioModalContent) return;

        editServicioModalContent.innerHTML = `<div class="modal-body text-center py-5">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>
            <p class="mt-2">Cargando formulario de edición...</p>
        </div>`;
        editServicioModal.show();

        try {
            const response = await fetch(`/servicios/${id}/edit-modal`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } });
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText || `Error ${response.status}: ${response.statusText}`);
            }

            editServicioModalContent.innerHTML = await response.text();
            const form = document.getElementById('editarservicio');
            if (!form) return;

            $('#editarservicio .select2').select2({ dropdownParent: editServicioModalElement });

            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                const success = await submitForm(this, `/servicios/${id}`);
                if (success) {
                    editServicioModal.hide();
                    updateUI();
                }
            });
        } catch (error) {
            console.error('Error al cargar el formulario de edición:', error);
            editServicioModalContent.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar: ${error.message}</div></div>`;
        }
    }

    /**
     * Muestra el modal con la información de visualización cargada vía AJAX.
     * @param {number} id - El ID del servicio a visualizar.
     */
    async function showViewModal(id) {
        const viewServicioModalContent = document.getElementById('viewServicioModalContent');
        if (!viewServicioModalContent) return;

        viewServicioModalContent.innerHTML = `<div class="modal-body text-center py-5">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>
            <p class="mt-2">Cargando información del servicio...</p>
        </div>`;
        viewServicioModal.show();

        try {
            const response = await fetch(`/servicios/${id}/view-modal`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } });
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(errorText || response.statusText);
            }

            viewServicioModalContent.innerHTML = await response.text();
            $(viewServicioModalContent).find('select').each(function() {
                $(this).select2({ minimumResultsForSearch: Infinity, dropdownParent: viewServicioModalElement });
            });
        } catch (error) {
            console.error('Error al cargar la vista del servicio:', error);
            viewServicioModalContent.innerHTML = `<div class="modal-body"><div class="alert alert-danger p-4">Error al cargar los detalles: ${error.message || 'Error desconocido'}</div></div>`;
        }
    }

    /**
     * Realiza una petición AJAX para cambiar el estado de un servicio (alta/baja).
     * @param {number} id - El ID del servicio.
     * @param {string} endpoint - El endpoint de la API ('baja' o 'alta').
     * @param {string} title - El título de la confirmación.
     * @param {string} text - El texto de la confirmación.
     * @param {string} confirmText - El texto del botón de confirmación.
     * @param {string} successTitle - El título del mensaje de éxito.
     * @param {string} successIcon - El icono del mensaje de éxito.
     */
    async function toggleServicioStatus(id, endpoint, title, text, confirmText, successTitle, successIcon) {
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
                const response = await fetch(`/servicios/${id}/${endpoint}`, {
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

        dataTable = $('#tablaServicios').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
            dom: '<"row"<"col-sm-12 col-md-6 d-flex justify-content-start"f><"col-sm-12 col-md-6 d-flex justify-content-end align-items-center"l<"botones_datatable_servicios d-flex align-items-center">>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: { url: dataTableAjaxUrl, type: "GET" },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'clave', name: 'clave' },
                { data: 'nombre', name: 'nombre' },
                { data: 'precio', name: 'precio' },
                { data: 'laboratorio', name: 'laboratorio' },
                { data: 'duracion', name: 'duracion' },
                { data: 'estatus', name: 'estatus' },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ],
            autoWidth: false,
            scrollX: false,
            initComplete: function () {
                var addButton = $('#agregarServicioBtn');
                var exportButton = $('#exportarServiciosBtn');

                $('.botones_datatable_servicios').append(addButton);
                $('.botones_datatable_servicios').append(exportButton);

                exportButton.addClass('ms-2');

                $('.dataTables_length label').contents().filter(function() {
                    return this.nodeType === 3;
                }).remove();

                var searchDiv = $('.dataTables_filter');
                searchDiv.css({
                    display: 'flex',
                    alignItems: 'center',
                    gap: '10px'
                });
            }
        });
    }

    function setupEventListeners() {
        // Formulario de agregar servicio
        if (formAgregarServicio) {
            formAgregarServicio.addEventListener('submit', async function(event) {
                event.preventDefault();
                const success = await submitForm(this, this.action);
                if (success) {
                    agregarServicioModal.hide();
                    updateUI();
                }
            });
        }

        // Delegación de eventos para la tabla
        $(document).on('click', '.btn-dar-de-baja', function() {
            const id = $(this).data('id');
            toggleServicioStatus(id, 'baja', '¿Estás seguro?', '¡El servicio será dado de baja!', 'Sí, ¡dar de baja!', '¡Servicio dado de baja!', 'warning');
        });

        $(document).on('click', '.btn-dar-de-alta', function() {
            const id = $(this).data('id');
            toggleServicioStatus(id, 'alta', '¿Estás seguro?', '¡El servicio será dado de alta de nuevo!', 'Sí, ¡dar de alta!', '¡Servicio dado de alta!', 'question');
        });

        $(document).on('click', '.btn-edit-unidad', function() {
            const id = $(this).data('id');
            showEditModal(id);
        });

        $(document).on('click', '.btn-view-unidad', function() {
            const id = $(this).data('id');
            showViewModal(id);
        });

        // --- Código para agregar/eliminar requisitos
        const agregarRequisitoBtn = document.getElementById('agregar-requisito-btn');
        const requisitosContenedor = document.getElementById('requisitos-contenedor');

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
                if (e.target.classList.contains('eliminar-requisito-btn') || e.target.closest('.eliminar-requisito-btn')) {
                    const btn = e.target.closest('.eliminar-requisito-btn');
                    const item = btn.closest('.requisito-item');
                    item.remove();
                }
            });
        }
    }

    // --- Lógica para campos dinámicos: Muestra y Acreditación ---
    const requiereMuestraSelect = document.getElementById('requiereMuestra');
    const metodoField = document.getElementById('metodoField');
    const tipoMuestraField = document.getElementById('tipoMuestraField');
    const tipoMuestraInput = document.getElementById('tipoMuestra');
    const acreditacionSelect = document.getElementById('acreditacion');

    function handleMuestraSelection() {
        if (!requiereMuestraSelect || !tipoMuestraField || !tipoMuestraInput || !metodoField) return;

        if (requiereMuestraSelect.value === 'si') {
            metodoField.style.display = 'block';
            tipoMuestraField.style.display = 'block';
            tipoMuestraInput.disabled = false;
        } else {
            metodoField.style.display = 'none';
            tipoMuestraField.style.display = 'none';
            tipoMuestraInput.disabled = true;
            tipoMuestraInput.value = '';
        }
    }

    function handleAcreditacionSelection() {
        if (!acreditacionSelect || !metodoField) return;
        const selectedValue = acreditacionSelect.value;
        if (selectedValue !== 'No acreditado' && selectedValue !== '') {
            metodoField.style.display = 'block';
        } else {
            if (requiereMuestraSelect.value !== 'si') {
                metodoField.style.display = 'none';
            }
        }
    }

    if (requiereMuestraSelect) {
        $(requiereMuestraSelect).on('change', handleMuestraSelection);
        handleMuestraSelection();
    }
    if (acreditacionSelect) {
        $(acreditacionSelect).on('change', handleAcreditacionSelection);
        handleAcreditacionSelection();
    }
    
    // --- Lógica para precio y precio por laboratorio ---
    const precioInput = document.getElementById('precio');
    const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');
    const agregarLaboratorioBtn = document.getElementById('agregar-laboratorio-btn');
    const primerSelectLaboratorio = document.getElementById('primerLaboratorioResponsable');
    const selectClave = document.getElementById('clave');

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
            laboratoriosData.forEach(lab => {
                optionsHtml += `<option value="${lab.id_laboratorio}">${lab.laboratorio}</option>`;
            });
            
            nuevoLaboratorio.innerHTML = `
                <div class="form-floating form-floating-outline flex-grow-1">
                    <input type="text" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" />
                    <label>Precio *</label>
                </div>
                <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                    <select name="laboratorios_responsables[]" class="form-select select2">
                        ${optionsHtml}
                    </select>
                    <label>Laboratorio responsable *</label>
                </div>
                <button type="button" class="btn btn-danger eliminar-laboratorio-btn ms-2">
                    <i class="ri-subtract-line"></i>
                </button>
            `;
            
            laboratoriosContenedor.appendChild(nuevoLaboratorio);
            
            $(nuevoLaboratorio).find('.select2').select2({
                dropdownParent: $('#agregarServicioModal')
            });

            const newPrecioInput = nuevoLaboratorio.querySelector('.precio-lab');
            if (newPrecioInput) {
                newPrecioInput.addEventListener('input', updatePrecioTotal);
            }
        });
    }

    if (laboratoriosContenedor) {
        laboratoriosContenedor.addEventListener('click', function(e) {
            if (e.target.classList.contains('eliminar-laboratorio-btn') || e.target.closest('.eliminar-laboratorio-btn')) {
                const btn = e.target.closest('.eliminar-laboratorio-btn');
                const item = btn.closest('.laboratorio-item');
                if (laboratoriosContenedor.children.length > 1) {
                    item.remove();
                    updatePrecioTotal();
                } else {
                    console.log("No se puede eliminar el último laboratorio.");
                }
            }
        });

        laboratoriosContenedor.querySelectorAll('.precio-lab').forEach(input => {
            input.addEventListener('input', updatePrecioTotal);
        });

        updatePrecioTotal();
    }

    if (selectClave && primerSelectLaboratorio) {
        $(selectClave).on('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value !== "") {
                const idLaboratorio = selectedOption.getAttribute('data-id-lab');
                $(primerSelectLaboratorio).val(idLaboratorio).trigger('change');
            } else {
                $(primerSelectLaboratorio).val('').trigger('change');
            }
        });
    }

    if (typeof dataTableAjaxUrl !== 'undefined') {
        initializeDataTable();
    }
    setupEventListeners();
});
