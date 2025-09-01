/**
 * This script handles the logic for the initialization and behavior of the DataTables services table,
 * and the validation and submission of the form to add or edit a service.
 */
document.addEventListener("DOMContentLoaded", () => {
    // Definition of main elements and variables
    const formAgregarServicio = document.getElementById("formAgregarServicio");
    const formEditServicio = document.getElementById("editServicioForm");
    const selectClave = document.getElementById("clave");
    const precioInput = document.getElementById("precio");
    const laboratoriosContenedor = document.getElementById("laboratorios-contenedor");
    const requisitosContenedor = document.getElementById("requisitos-contenedor");
    const requiereMuestraSelect = document.getElementById("requiereMuestra");
    const metodoField = document.getElementById("metodoField");
    const tipoMuestraField = document.getElementById("tipoMuestraField");
    const tipoMuestraInput = document.getElementById("tipoMuestra");
    const acreditacionSelect = document.getElementById("acreditacion");
    const nombreAcreditacionField = document.getElementById("nombreAcreditacionField");
    const descripcionAcreditacionField = document.getElementById("descripcionAcreditacionField");
    const nombreAcreditacionInput = document.getElementById('nombreAcreditacion');
    const descripcionAcreditacionInput = document.getElementById('descripcionAcreditacion');
    
    // Selectores para botones de agregar dinámicamente
    const agregarLaboratorioBtn = document.getElementById("agregar-laboratorio-btn");
    const agregarRequisitoBtn = document.getElementById("agregar-requisito-btn");

    let dt_servicios = null;
    let laboratoriosData = [];

    // SweetAlert and jQuery
    const Swal = window.Swal;
    const $ = window.$;

    // Se asume que esta variable global se llena en la vista Blade.
    if (window.laboratoriosData) {
        laboratoriosData = window.laboratoriosData;
    } else {
        console.error("Variable 'laboratoriosData' no definida en la vista Blade.");
    }

    // --- UTILITY FUNCTIONS ---
    
    /**
     * Shows a SweetAlert for errors.
     * @param {string} title - The error title.
     * @param {string} message - The error message.
     */
    const showSweetAlertError = (title, message) => {
        Swal.fire({
            icon: "error",
            title,
            html: message,
            customClass: { confirmButton: "btn btn-danger" },
        });
    };

    /**
     * Clears validation errors from a form.
     * @param {HTMLElement} formElement - The form element.
     */
    const clearValidationErrors = (formElement) => {
        if (!formElement) return;
        formElement.querySelectorAll(".is-invalid").forEach((el) => el.classList.remove("is-invalid"));
        $(formElement).find(".select2-container .select2-selection--single").removeClass("is-invalid");
        formElement.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());
    };

    /**
     * Displays validation errors.
     * @param {object} errors - Object with errors.
     * @param {HTMLElement} formElement - The form.
     */
    const displayValidationErrors = (errors, formElement) => {
        clearValidationErrors(formElement);
        let firstInvalidField = null;

        for (const [fieldName, messages] of Object.entries(errors)) {
            let inputElement = formElement.querySelector(`[name="${fieldName}"]`);

            if (fieldName.includes(".")) {
                const parts = fieldName.split(".");
                const index = parts[1];
                if (parts[0] === "precios_laboratorio") {
                    inputElement = formElement.querySelectorAll(".precio-lab")[index];
                } else if (parts[0] === "laboratorios_responsables") {
                    inputElement = formElement.querySelectorAll(".laboratorio-item select")[index];
                } else if (parts[0] === "requisitos") {
                    inputElement = formElement.querySelectorAll('input[name="requisitos[]"]')[index];
                }
            }

            if (inputElement) {
                inputElement.classList.add("is-invalid");
                $(inputElement).hasClass("select2") && $(inputElement).next(".select2-container").find(".select2-selection--single").addClass("is-invalid");

                let feedbackElement = inputElement.nextElementSibling;
                if (!feedbackElement || !feedbackElement.classList.contains("invalid-feedback")) {
                    feedbackElement = document.createElement("div");
                    feedbackElement.classList.add("invalid-feedback");
                    inputElement.parentNode.insertBefore(feedbackElement, inputElement.nextSibling);
                }
                feedbackElement.innerHTML = messages.join("<br>");

                if (!firstInvalidField) firstInvalidField = inputElement;
            } else {
                console.warn(`HTML element not found for field: ${fieldName}`);
            }
        }
        firstInvalidField?.scrollIntoView({ behavior: "smooth", block: "center" });
        firstInvalidField?.focus();
    };

    /**
     * Submits a form request via AJAX.
     * @param {HTMLFormElement} form - The form to submit.
     * @param {string} url - The endpoint URL.
     * @param {string} method - The HTTP method ('POST' or 'PUT').
     */
    const submitForm = async (form, url, method = "POST") => {
        const submitButton = form.querySelector('button[type="submit"]');
        if (!submitButton) return false;

        const originalButtonHtml = submitButton.innerHTML;
        const loadingHtml = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
        submitButton.innerHTML = loadingHtml;
        submitButton.disabled = true;
        clearValidationErrors(form);

        try {
            const finalFormData = new FormData(form);
            if (method === "PUT") finalFormData.append("_method", "PUT");

            const response = await fetch(url, {
                method: "POST",
                body: finalFormData,
                headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"), Accept: "application/json" },
            });

            const responseData = await response.json();
            if (!response.ok) {
                if (response.status === 422 && responseData.errors) {
                    displayValidationErrors(responseData.errors, form);
                    showSweetAlertError("Faltan campos", "Por favor, completa los campos obligatorios. 🚨");
                } else {
                    throw new Error(responseData.message || "Error inesperado.");
                }
            } else {
                if (form.id === "formAgregarServicio") {
                    window.location.href = "{{ route('servicios.index') }}";
                } else if (method === "PUT") {
                    window.location.reload();
                } else if (dt_servicios) {
                    dt_servicios.ajax.reload();
                }
                return true;
            }
        } catch (error) {
            console.error("Error en la petición:", error);
            showSweetAlertError("¡Error!", `Hubo un problema al guardar los datos: ${error.message}`);
        } finally {
            submitButton.innerHTML = originalButtonHtml;
            submitButton.disabled = false;
        }
        return false;
    };

    // --- DYNAMIC FIELDS LOGIC: LABORATORIES AND REQUIREMENTS ---

    const updatePrecioTotal = () => {
        const total = Array.from(laboratoriosContenedor?.querySelectorAll(".precio-lab") || []).reduce(
            (sum, input) => sum + (Number.parseFloat(input.value) || 0), 0);
        if (precioInput) {
            precioInput.value = total.toFixed(2);
        }
    };

    if (precioInput) {
        precioInput.disabled = true;
        precioInput.readOnly = true;
    }

    const addRequisito = () => {
        const nuevoRequisito = document.createElement("div");
        nuevoRequisito.classList.add("input-group", "mb-3", "requisito-item");
        nuevoRequisito.innerHTML = `
            <div class="form-floating form-floating-outline flex-grow-1">
                <input type="text" class="form-control" name="requisitos[]" placeholder="Requisitos" />
                <label>Requisitos</label>
            </div>
            <button type="button" class="btn btn-danger eliminar-requisito-btn ms-2">
                <i class="ri-subtract-line"></i>
            </button>
        `;
        requisitosContenedor?.appendChild(nuevoRequisito);
    };

    const addLaboratorio = (laboratorioId = null, precio = null) => {
        const nuevoLaboratorio = document.createElement("div");
        nuevoLaboratorio.classList.add("row", "g-3", "mb-3", "laboratorio-item", "align-items-center");

        const optionsHtml = laboratoriosData.map(lab => {
            const selected = (lab.id_laboratorio == laboratorioId) ? 'selected' : '';
            return `<option value="${lab.id_laboratorio}" ${selected}>${lab.laboratorio}</option>`;
        }).join("");
        
        nuevoLaboratorio.innerHTML = `
            <div class="col-12 col-md-5">
                <div class="form-floating form-floating-outline">
                    <input type="number" step="0.01" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" value="${precio || ''}" required />
                    <label>Precio *</label>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <div class="form-floating form-floating-outline">
                    <select class="form-select select2-laboratorio" name="laboratorios_responsables[]" required>
                        <option value="">Seleccione un laboratorio</option>
                        ${optionsHtml}
                    </select>
                    <label>Laboratorio responsable *</label>
                </div>
            </div>
            <div class="col-12 col-md-2 d-flex justify-content-end">
                <button type="button" class="btn btn-danger eliminar-laboratorio-btn w-100">
                    <i class="ri-subtract-line"></i> Eliminar
                </button>
            </div>
        `;
        laboratoriosContenedor?.appendChild(nuevoLaboratorio);

        const newSelect = nuevoLaboratorio.querySelector(".select2-laboratorio");
        $(newSelect).select2({ placeholder: "Seleccione un laboratorio", allowClear: true });
        
        const precioInputLab = nuevoLaboratorio.querySelector(".precio-lab");
        precioInputLab.addEventListener("input", updatePrecioTotal);
        $(newSelect).on("change", updatePrecioTotal);
        
        updatePrecioTotal();
    };

    // --- EVENT LISTENERS FOR DYNAMIC ELEMENTS ---
    
    // Asocia los eventos de clic con los botones, si existen
    if (agregarLaboratorioBtn) {
        agregarLaboratorioBtn.addEventListener("click", () => addLaboratorio());
    }
    
    if (agregarRequisitoBtn) {
        agregarRequisitoBtn.addEventListener("click", addRequisito);
    }
    
    // Delega el evento de clic para los botones de eliminar
    document.body.addEventListener("click", (e) => {
        const btnEliminarLab = e.target.closest(".eliminar-laboratorio-btn");
        const btnEliminarReq = e.target.closest(".eliminar-requisito-btn");

        if (btnEliminarLab) {
            const container = btnEliminarLab.closest("#laboratorios-contenedor");
            if (container && container.children.length > 1) {
                btnEliminarLab.closest(".laboratorio-item")?.remove();
                updatePrecioTotal();
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "No se puede eliminar",
                    text: "Debe haber al menos un laboratorio responsable.",
                    customClass: { confirmButton: "btn btn-warning" },
                });
            }
        }

        if (btnEliminarReq) {
            btnEliminarReq.closest(".requisito-item")?.remove();
        }
    });

    // Delegación de eventos para los inputs de precio
    document.body.addEventListener("input", (e) => {
        if (e.target.classList.contains("precio-lab")) {
            updatePrecioTotal();
        }
    });

    // --- FORM SUBMISSION LOGIC ---
    formAgregarServicio?.addEventListener("submit", (e) => {
        e.preventDefault();
        submitForm(e.target, e.target.action, "POST");
    });

    formEditServicio?.addEventListener("submit", (e) => {
        e.preventDefault();
        const servicioId = e.target.querySelector('input[name="id_servicio"]').value;
        const editUrl = e.target.action || `/servicios/${servicioId}`;
        submitForm(e.target, editUrl, "PUT");
    });

    // --- OTHER LOGIC FOR SELECTS AND DATA TABLES ---
    
    // Logic for key selection and laboratory autocompletion
    selectClave?.addEventListener("change", (e) => {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const idLaboratorio = selectedOption?.getAttribute("data-id-lab");
        const nombreLaboratorio = selectedOption?.getAttribute("data-nombre-lab");

        const laboratorioResponsableInput = document.getElementById("laboratorioResponsableInput");
        const laboratorioResponsableId = document.getElementById("laboratorioResponsableId");
        const firstLabSelect = document.querySelector('select[name="laboratorios_responsables[]"]');

        if (selectedOption?.value) {
            if (laboratorioResponsableInput) laboratorioResponsableInput.value = nombreLaboratorio;
            if (laboratorioResponsableId) laboratorioResponsableId.value = idLaboratorio;
            if (firstLabSelect) $(firstLabSelect).val(idLaboratorio).trigger("change");
        } else {
            if (laboratorioResponsableInput) laboratorioResponsableInput.value = "";
            if (laboratorioResponsableId) laboratorioResponsableId.value = "";
            if (firstLabSelect) $(firstLabSelect).val("").trigger("change");
        }
    });

    // Logic for showing/hiding sample and method fields
    const handleMuestraSelection = () => {
        const isMuestraVisible = requiereMuestraSelect?.value === "si" || requiereMuestraSelect?.value === "1" || requiereMuestraSelect?.value === 1;
        
        if (tipoMuestraField) {
            tipoMuestraField.style.display = isMuestraVisible ? "block" : "none";
        }
        if (tipoMuestraInput) {
            tipoMuestraInput.disabled = !isMuestraVisible;
            if (!isMuestraVisible) {
                tipoMuestraInput.value = "";
            }
        }
        
        const isAcreditadoVisible = acreditacionSelect?.value === "Acreditado" || acreditacionSelect?.value === "1" || acreditacionSelect?.value === 1;
        
        if (metodoField) {
            metodoField.style.display = isAcreditadoVisible ? "block" : "none";
        }
        if (nombreAcreditacionField) {
            nombreAcreditacionField.style.display = isAcreditadoVisible ? "block" : "none";
        }
        if (descripcionAcreditacionField) {
            descripcionAcreditacionField.style.display = isAcreditadoVisible ? "block" : "none";
        }

        if (!isAcreditadoVisible) {
            if (nombreAcreditacionInput) nombreAcreditacionInput.value = "";
            if (descripcionAcreditacionInput) descripcionAcreditacionInput.value = "";
        }
    };

    // Attach event listeners to the selects
    requiereMuestraSelect?.addEventListener("change", handleMuestraSelection);
    acreditacionSelect?.addEventListener("change", handleMuestraSelection);
    handleMuestraSelection(); // Initial check on page load

    // Initialize Select2 on all selectors with the 'select2' class
    $(".select2").select2({ placeholder: "Selecciona una opción", allowClear: true });
    
    // Initial setup for existing dynamic fields
    updatePrecioTotal();
    
    // --- EXPORT MODAL FILTERS LOGIC ---
    // (This code remains unchanged as it's not related to the main issue)
    const exportModal = document.getElementById('exportModal');
    if (exportModal) {
        const populateLabFilters = () => {
            const claveSelect = document.getElementById('clave_export');
            const laboratorioSelect = document.getElementById('nombre_laboratorio');
            claveSelect.innerHTML = '<option value="">Todas las claves</option>';
            laboratorioSelect.innerHTML = '<option value="">Todos los laboratorios</option>';

            laboratoriosData.forEach(lab => {
                const claveOption = document.createElement('option');
                claveOption.value = lab.clave;
                claveOption.textContent = lab.clave;
                claveSelect.appendChild(claveOption);

                const labOption = document.createElement('option');
                labOption.value = lab.id_laboratorio;
                labOption.textContent = lab.laboratorio;
                laboratorioSelect.appendChild(labOption);
            });
        };

        const toggleSelectState = (checkbox, selectId) => {
            const selectElement = document.getElementById(selectId);
            const labelElement = exportModal.querySelector(`label[for="${checkbox.id}"]`);
            if (!selectElement) return;

            const isDisabled = !checkbox.checked;
            $(selectElement).prop('disabled', isDisabled).trigger('change.select2');
            labelElement?.classList.toggle('text-muted', isDisabled);
        };

        $(exportModal).on('shown.bs.modal', () => {
            populateLabFilters();
            exportModal.querySelectorAll('select').forEach(select => {
                $(select).select2({ dropdownParent: exportModal, placeholder: select.getAttribute('placeholder') || 'Selecciona una opción', allowClear: true });
            });
            exportModal.querySelectorAll('.form-check-input[type="checkbox"]').forEach(checkbox => {
                toggleSelectState(checkbox, checkbox.id.replace('activar_', ''));
            });
        });

        exportModal.querySelectorAll('.form-check-input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => toggleSelectState(e.target, e.target.id.replace('activar_', '')));
        });

        const exportarBtn = document.getElementById('exportarBtn');
        if (exportarBtn) {
            exportarBtn.addEventListener('click', () => {
                const claveExport = document.getElementById('clave_export').value;
                const laboratorioExport = document.getElementById('nombre_laboratorio').value;
                const estatusExport = document.getElementById('estatus_export').value;
                const acreditadoExport = document.getElementById('acreditado_export').value;
                const precioExport = document.getElementById('precio_export').value;

                let nombreFiltro = 'Todos_los_servicios';
                const urlParams = new URLSearchParams();

                if (claveExport) {
                    nombreFiltro = `Servicios_Clave_${claveExport}`;
                    urlParams.set('clave', claveExport);
                }
                
                if (laboratorioExport) {
                    const lab = laboratoriosData.find(l => l.id_laboratorio == laboratorioExport);
                    const nombreLab = lab ? lab.laboratorio.replace(/[^a-z0-9]/gi, '_').toLowerCase() : 'Laboratorio_desconocido';
                    nombreFiltro = `Servicios_Lab_${nombreLab}`;
                    urlParams.set('nombre_laboratorio', laboratorioExport);
                }

                if (estatusExport) urlParams.set('estatus', estatusExport);
                if (acreditadoExport) urlParams.set('acreditado', acreditadoExport);
                if (precioExport) urlParams.set('precio', precioExport);

                const fecha = new Date().toISOString().slice(0, 10);
                const nombreArchivo = `${nombreFiltro}_${fecha}.xlsx`;
                urlParams.set('nombre_archivo', nombreArchivo);

                const exportUrl = `/servicios/exportar?${urlParams.toString()}`;
                window.location.href = exportUrl;
                bootstrap.Modal.getInstance(exportModal)?.hide();
            });
        }
    }

    // --- DATATABLES CODE ---
    // (This code remains unchanged as it's not related to the main issue)
    const initDataTables = () => {
        const dt_servicios_table = $("#tablaServicios");
        const dataTableAjaxUrl = window.dataTableAjaxUrl;

        if (!dt_servicios_table.length || typeof dataTableAjaxUrl === "undefined") {
            console.error("The table or the AJAX URL are not available.");
            return;
        }

        dt_servicios = dt_servicios_table.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: dataTableAjaxUrl,
                type: "GET",
                error: (xhr, _, thrown) => {
                    console.error("Error loading data with DataTables:", thrown);
                    showSweetAlertError("Loading Error", `Problem loading data. Error: ${thrown}`);
                },
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
                { data: "clave", name: "clave" },
                { data: "nombre", name: "nombre" },
                { data: "precio", name: "precio" },
                { data: "laboratorio", name: "laboratorio", orderable: false, searchable: false },
                { data: "duracion", name: "duracion" },
                { data: "id_habilitado", name: "id_habilitado" },
                {
                    data: "acciones",
                    name: "acciones",
                    orderable: false,
                    searchable: false,
                    render: (data, _, row) => {
                        return data;
                    },
                },
            ],
            columnDefs: [
                {
                    targets: 3, // Columna de Precio (índice 3)
                    render: function (data, type, row) {
                        return `$${data}`;
                    }
                },
                {
                    targets: 6, // Columna de Estatus (índice 6)
                    render: function (data, type, row) {
                        if (data === 1 || data === '1') {
                            return `<span class="badge bg-success">Habilitado</span>`;
                        }
                        return `<span class="badge bg-danger">Deshabilitado</span>`;
                    }
                }
            ],
            language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" },
            dom: 't<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            responsive: true,
            initComplete: function() {
                $("#tablaServicios").css("visibility", "visible");
            }
        });

        // Table events
        $("#buscar").on("keyup", function () { dt_servicios.search(this.value).draw(); });
        $('select[name="tablaServicios_length"]').on("change", function () { dt_servicios.page.len(this.value).draw(); });

        $(document).on("click", ".toggle-status-btn", function (e) {
            e.preventDefault();
            const { id: servicioId, status: currentStatus } = $(this).data();
            const newStatus = currentStatus === 1 ? 0 : 1;
            const statusAction = newStatus === 1 ? "Habilitar" : "Deshabilitar";
            Swal.fire({
                title: "¿Estás seguro?",
                text: `¿Estás seguro de que quieres ${statusAction.toLowerCase()} este servicio?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: `Sí, ${statusAction.toLowerCase()}`,
                cancelButtonText: "Cancelar",
                customClass: { confirmButton: `btn btn-lg btn-${newStatus === 1 ? "success" : "warning"}`, cancelButton: "btn btn-lg btn-secondary" },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/servicios/${servicioId}/toggle-status`, {
                        method: "PUT",
                        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), "Content-Type": "application/json", Accept: "application/json" },
                        body: JSON.stringify({ status: newStatus }),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                dt_servicios.ajax.reload(null, false);
                                Swal.fire({ icon: "success", title: "¡Actualizado!", text: `El servicio ha sido ${statusAction.toLowerCase()} correctamente.`, customClass: { confirmButton: "btn btn-success" } });
                            } else {
                                showSweetAlertError("Error", data.message || "Problema al actualizar el estado.");
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            showSweetAlertError("Error", "No se pudo completar la operación. Inténtalo de nuevo.");
                        });
                }
            });
        });

        // Event listeners for view and edit modals
        $(document).on("click", ".view-servicio-btn", function () {
            const servicioId = $(this).data('id');
            const modalContent = $('#viewServicioModalContent');
            modalContent.html(`
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando vista previa...</p>
                </div>
            `);
            $('#viewServicioModal').modal('show');
            $.ajax({
                url: `/servicios/${servicioId}`,
                method: 'GET',
                success: function(response) {
                    modalContent.html(response);
                    modalContent.find('.select2').select2({ placeholder: "Selecciona una opción", allowClear: true });
                },
                error: function() {
                    modalContent.html('<div class="alert alert-danger">No se pudo cargar la vista. Inténtelo de nuevo.</div>');
                }
            });
        });

        $(document).on("click", ".edit-servicio-btn", function () {
            const servicioId = $(this).data('id');
            const modalContent = $('#editServicioModalContent');
            modalContent.html(`
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando formulario de edición...</p>
                </div>
            `);
            $('#editServicioModal').modal('show');
            $.ajax({
                url: `/servicios/${servicioId}/edit`,
                method: 'GET',
                success: function(response) {
                    modalContent.html(response);
                    const editForm = modalContent.find('#editServicioForm')[0];
                    if (editForm) {
                        editForm.addEventListener("submit", (e) => {
                            e.preventDefault();
                            const url = editForm.action || `/servicios/${servicioId}`;
                            submitForm(editForm, url, "PUT");
                        });

                        const currentServiceData = $(editForm).data('service');
                        const labsContainer = editForm.querySelector('#laboratorios-contenedor');
                        
                        if (labsContainer) {
                            while (labsContainer.firstChild) {
                                labsContainer.removeChild(labsContainer.firstChild);
                            }
                        }

                        if (currentServiceData && currentServiceData.laboratorios_pivot) {
                            currentServiceData.laboratorios_pivot.forEach(lab => {
                                addLaboratorio(lab.id_laboratorio, lab.precio);
                            });
                        } else {
                            addLaboratorio();
                        }
                    }
                    modalContent.find(".select2").select2({ placeholder: "Selecciona una opción", allowClear: true });
                    // Re-evaluate field visibility after modal content is loaded
                    const requiereMuestraSelectModal = document.getElementById("requiereMuestra");
                    const acreditacionSelectModal = document.getElementById("acreditacion");

                    if (requiereMuestraSelectModal) {
                        const isMuestraVisible = requiereMuestraSelectModal.value === "si" || requiereMuestraSelectModal.value === "1";
                        const tipoMuestraFieldModal = document.getElementById("tipoMuestraField");
                        if (tipoMuestraFieldModal) tipoMuestraFieldModal.style.display = isMuestraVisible ? "block" : "none";
                    }

                    if (acreditacionSelectModal) {
                        const isAcreditadoVisible = acreditacionSelectModal.value === "Acreditado" || acreditacionSelectModal.value === "1";
                        const metodoFieldModal = document.getElementById("metodoField");
                        const nombreAcreditacionFieldModal = document.getElementById("nombreAcreditacionField");
                        const descripcionAcreditacionFieldModal = document.getElementById("descripcionAcreditacionField");
                        if (metodoFieldModal) metodoFieldModal.style.display = isAcreditadoVisible ? "block" : "none";
                        if (nombreAcreditacionFieldModal) nombreAcreditacionFieldModal.style.display = isAcreditadoVisible ? "block" : "none";
                        if (descripcionAcreditacionFieldModal) descripcionAcreditacionFieldModal.style.display = isAcreditadoVisible ? "block" : "none";
                    }
                },
                error: function() {
                    modalContent.html('<div class="alert alert-danger">No se pudo cargar el formulario de edición. Inténtelo de nuevo.</div>');
                }
            });
        });
    };
    initDataTables();
    //modificado
});