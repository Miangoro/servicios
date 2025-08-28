document.addEventListener('DOMContentLoaded', function () {
    // Definición de elementos principales del formulario de agregar servicio
    const formAgregarServicio = document.getElementById('formAgregarServicio');
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
            const finalFormData = new FormData(form);

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

    // Asocia los eventos al formulario
    if (formAgregarServicio) {
        formAgregarServicio.addEventListener('submit', async function(event) {
            event.preventDefault();
            await submitForm(this, this.action);
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
                    <input type="text" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" />
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

    $('.select2').select2();

    // Agrega el código de DataTables aquí
    const dt_servicios_table = $('.tablaServicios_datatable');

    if (dt_servicios_table.length) {
        const dt_servicios = dt_servicios_table.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: dataTableAjaxUrl,
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'clave', name: 'clave' },
                { data: 'nombre', name: 'nombre' },
                { data: 'precio', name: 'precio' },
                { data: 'laboratorio', name: 'laboratorio', orderable: false, searchable: false },
                { data: 'duracion', name: 'duracion' },
                { data: 'id_habilitado', name: 'id_habilitado' },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },

            // --- MODIFICACIÓN CLAVE AQUÍ ---
            // Solo muestra la tabla, la información y la paginación.
            // Los elementos 'l' (length) y 'f' (filter) se eliminan de la configuración.
            dom: 't<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',

            // Se eliminan los botones ya que se usará un botón manual en el HTML
            buttons: [],

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
    }
});