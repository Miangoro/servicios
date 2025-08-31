/**
 * Este script maneja la lógica para la inicialización y el comportamiento de la tabla de servicios DataTables,
 * y la validación y envío del formulario para agregar o editar un servicio.
 */
document.addEventListener("DOMContentLoaded", () => {
    // Definición de elementos principales y variables
    const formAgregarServicio = document.getElementById("formAgregarServicio");
    const formEditServicio = document.getElementById("editServicioForm");
    const selectClave = document.getElementById("clave");
    const precioInput = document.getElementById("precio");
    const laboratoriosContenedor = document.getElementById("laboratorios-contenedor");
    const requisitosContenedor = document.getElementById("requisitos-contenedor");
    const agregarLaboratorioBtn = document.getElementById("agregar-laboratorio-btn");
    const agregarRequisitoBtn = document.getElementById("agregar-requisito-btn");
    const requiereMuestraSelect = document.getElementById("requiereMuestra");
    const metodoField = document.getElementById("metodoField");
    const tipoMuestraField = document.getElementById("tipoMuestraField");
    const tipoMuestraInput = document.getElementById("tipoMuestra");
    const acreditacionSelect = document.getElementById("acreditacion");

    let dt_servicios = null;
    let laboratoriosData = [];

    // SweetAlert and jQuery
    const Swal = window.Swal;
    const $ = window.$;

    try {
        const dataString = formAgregarServicio?.getAttribute("data-laboratorios");
        if (dataString) laboratoriosData = JSON.parse(dataString);
    } catch (error) {
        console.error("Error al parsear los datos de laboratorios:", error);
    }

    /**
     * Muestra un SweetAlert para errores.
     * @param {string} title - El título del error.
     * @param {string} message - El mensaje de error.
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
     * Limpia los errores de validación de un formulario.
     * @param {HTMLElement} formElement - El elemento del formulario.
     */
    const clearValidationErrors = (formElement) => {
        if (!formElement) return;
        formElement.querySelectorAll(".is-invalid").forEach((el) => el.classList.remove("is-invalid"));
        $(formElement).find(".select2-container .select2-selection--single").removeClass("is-invalid");
        formElement.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());
    };

    /**
     * Muestra los errores de validación.
     * @param {object} errors - Objeto con los errores.
     * @param {HTMLElement} formElement - El formulario.
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
                console.warn(`Elemento HTML no encontrado para el campo: ${fieldName}`);
            }
        }
        firstInvalidField?.scrollIntoView({ behavior: "smooth", block: "center" });
        firstInvalidField?.focus();
    };

    /**
     * Envía una petición de formulario mediante AJAX.
     * @param {HTMLFormElement} form - El formulario a enviar.
     * @param {string} url - La URL del endpoint.
     * @param {string} method - El método HTTP ('POST' o 'PUT').
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
                Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: responseData.message,
                    customClass: { confirmButton: "btn btn-success" },
                }).then(() => {
                    // Si se está editando y todo sale bien, redirige o recarga la página.
                    if (method === "PUT") {
                        // Aquí puedes decidir si rediriges o simplemente recargas la página para ver los cambios.
                        window.location.reload(); 
                    } else if (dt_servicios) {
                        dt_servicios.ajax.reload();
                    }
                    if (form.id === "formAgregarServicio") {
                        form.reset();
                        clearValidationErrors(form);
                        $(".select2").val(null).trigger("change");
                        laboratoriosContenedor.innerHTML = "";
                        requisitosContenedor.innerHTML = "";
                        agregarLaboratorioBtn.click();
                        updatePrecioTotal();
                    }
                });
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

    // Asocia los eventos a los formularios
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

    // --- Lógica de campos dinámicos: Requisitos y Laboratorios ---
    const updatePrecioTotal = () => {
        const total = Array.from(laboratoriosContenedor.querySelectorAll(".precio-lab")).reduce(
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

    const addLaboratorio = () => {
        const nuevoLaboratorio = document.createElement("div");
        nuevoLaboratorio.classList.add("input-group", "mb-3", "laboratorio-item");
        const optionsHtml = laboratoriosData.map(lab => `<option value="${lab.id_laboratorio}">${lab.laboratorio}</option>`).join("");
        
        nuevoLaboratorio.innerHTML = `
            <div class="form-floating form-floating-outline flex-grow-1">
                <input type="number" step="0.01" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" />
                <label>Precio *</label>
            </div>
            <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                <select class="form-select select2-laboratorio" name="laboratorios_responsables[]">
                    <option value="">Seleccione un laboratorio</option>
                    ${optionsHtml}
                </select>
                <label for="select2-laboratorio">Laboratorio responsable *</label>
            </div>
            <button type="button" class="btn btn-danger eliminar-laboratorio-btn ms-2">
                <i class="ri-subtract-line"></i>
            </button>
        `;
        laboratoriosContenedor?.appendChild(nuevoLaboratorio);

        const newSelect = nuevoLaboratorio.querySelector(".select2-laboratorio");
        $(newSelect).select2({ placeholder: "Seleccione un laboratorio", allowClear: true });
        newSelect?.addEventListener("change", updatePrecioTotal);
        updatePrecioTotal();
    };

    agregarRequisitoBtn?.addEventListener("click", addRequisito);
    agregarLaboratorioBtn?.addEventListener("click", addLaboratorio);

    requisitosContenedor?.addEventListener("click", (e) => e.target.closest(".eliminar-requisito-btn")?.closest(".requisito-item")?.remove());

    laboratoriosContenedor?.addEventListener("click", (e) => {
        const btn = e.target.closest(".eliminar-laboratorio-btn");
        if (btn) {
            if (laboratoriosContenedor.children.length > 1) {
                btn.closest(".laboratorio-item")?.remove();
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
    });

    laboratoriosContenedor?.addEventListener("input", (e) => {
        if (e.target.classList.contains("precio-lab")) updatePrecioTotal();
    });

    // Lógica para la selección de clave y autocompletado del laboratorio
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

    // Lógica para mostrar/ocultar campos de muestra y método
    const handleMuestraSelection = () => {
        const isSiSelected = requiereMuestraSelect?.value === "si";
        const isAcreditadoSelected = acreditacionSelect?.value.includes("Acreditado");

        if (tipoMuestraField && tipoMuestraInput) {
            tipoMuestraField.style.display = isSiSelected ? "block" : "none";
            tipoMuestraInput.disabled = !isSiSelected;
            if (!isSiSelected) tipoMuestraInput.value = "";
        }

        if (metodoField) metodoField.style.display = isAcreditadoSelected ? "block" : "none";
    };

    requiereMuestraSelect?.addEventListener("change", handleMuestraSelection);
    acreditacionSelect?.addEventListener("change", handleMuestraSelection);
    handleMuestraSelection();

    // Inicializar Select2 en todos los selectores con la clase 'select2'
    $(".select2").select2({ placeholder: "Selecciona una opción", allowClear: true });

    // --- LÓGICA DE FILTROS DEL MODAL DE EXPORTACIÓN ---
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

                let nombreFiltro = 'Todos_los_servicios';
                let urlFiltros = '';

                if (claveExport) {
                    nombreFiltro = `Servicios_Clave_${claveExport}`;
                    urlFiltros = `clave=${claveExport}`;
                } else if (laboratorioExport) {
                    const lab = laboratoriosData.find(l => l.id_laboratorio == laboratorioExport);
                    const nombreLab = lab ? lab.laboratorio.replace(/[^a-z0-9]/gi, '_').toLowerCase() : 'Laboratorio_desconocido';
                    nombreFiltro = `Servicios_Lab_${nombreLab}`;
                    urlFiltros = `laboratorio=${laboratorioExport}`;
                }
                const fecha = new Date().toISOString().slice(0, 10);
                const nombreArchivo = `${nombreFiltro}_${fecha}.xlsx`;
                const exportUrl = `/servicios/exportar?${urlFiltros}&nombre_archivo=${nombreArchivo}`;
                window.location.href = exportUrl;
                bootstrap.Modal.getInstance(exportModal)?.hide();
            });
        }
    }

    // --- CÓDIGO DE DATATABLES ---
    const initDataTables = () => {
        const dt_servicios_table = $("#tablaServicios");
        const dataTableAjaxUrl = window.dataTableAjaxUrl;

        if (!dt_servicios_table.length || typeof dataTableAjaxUrl === "undefined") {
            console.error("La tabla o la URL de AJAX no están disponibles.");
            return;
        }

        dt_servicios = dt_servicios_table.DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: dataTableAjaxUrl,
                type: "GET",
                error: (xhr, _, thrown) => {
                    console.error("Error al cargar datos con DataTables:", thrown);
                    showSweetAlertError("Error de Carga", `Problema al cargar los datos. Error: ${thrown}`);
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
                    data: null,
                    name: "acciones",
                    orderable: false,
                    searchable: false,
                    render: (data, _, row) => {
                        const isDisabled = row.id_habilitado == 0;
                        const statusText = isDisabled ? "Habilitar" : "Deshabilitar";
                        const statusIcon = isDisabled ? "ri-check-line" : "ri-close-line";
                        return `
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Opciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/servicios/${row.id_servicio}">
                                        <i class="ri-eye-line me-2"></i>Visualizar
                                    </a></li>
                                    <li><a class="dropdown-item" href="/servicios/${row.id_servicio}/edit">
                                        <i class="ri-edit-line me-2"></i>Editar
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><button class="dropdown-item toggle-status-btn" data-id="${row.id_servicio}" data-status="${row.id_habilitado}">
                                        <i class="${statusIcon} me-2"></i>${statusText}
                                    </button></li>
                                </ul>
                            </div>
                        `;
                    },
                },
            ],
            language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" },
            dom: 't<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            responsive: true,
            // Solución del FOUC
            initComplete: function() {
                // Selecciona el contenedor principal de la tabla o la tabla misma
                // En este caso, el contenedor principal de la tabla es #tablaServicios
                $("#tablaServicios").css("visibility", "visible");
            }
        });

        // Eventos para la tabla
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
    };
    initDataTables();

    // Lógica para los modales
    const handleModal = (selector, urlFunction, callback) => {
        $(document).on('click', selector, function (e) {
            e.preventDefault();
            const servicioId = $(this).data('id');
            const modalContent = $(this).closest('.modal').find('.modal-content-container');
            const modalTitle = $(this).closest('.modal').find('.modal-title');
            modalContent.html(`
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>
                    <p class="mt-2">Cargando detalles del servicio...</p>
                </div>
            `);
            fetch(urlFunction(servicioId))
                .then(response => { if (!response.ok) throw new Error('Error al cargar la vista parcial'); return response.text(); })
                .then(html => { modalContent.html(html); callback && callback(modalContent); })
                .catch(error => {
                    console.error('Error:', error);
                    modalContent.html(`<div class="modal-header"><h5 class="modal-title">Error</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body text-center"><p class="text-danger">Hubo un error al cargar los detalles del servicio.</p></div>`);
                });
        });
    };
    // Desactivado el manejo de modales con clases de botón por la nueva estructura del menú
    // handleModal('.view-servicio-btn', id => `/servicios/${id}/show`);
    // handleModal('.edit-servicio-btn', id => `/servicios/${id}/edit`, modalContent => {
    //     initEditFormScripts(modalContent);
    // });
    
    // Función para reinicializar scripts en el modal de edición
    const initEditFormScripts = (modalContent) => {
        const formEditServicio = modalContent.find("#editServicioForm")[0];
        if (!formEditServicio) return;

        $(formEditServicio).find('.select2').select2({ placeholder: "Selecciona una opción", allowClear: true, dropdownParent: $('#editServicioModal') });

        $(formEditServicio).on('input', '.precio-lab', updatePrecioTotal);
        
        const laboratoriosContenedorEdit = formEditServicio.querySelector("#laboratorios-contenedor-edit");
        const requisitosContenedorEdit = formEditServicio.querySelector("#requisitos-contenedor-edit");
        
        formEditServicio.querySelector("#agregar-laboratorio-btn-edit")?.addEventListener('click', addLaboratorio);
        formEditServicio.querySelector("#agregar-requisito-btn-edit")?.addEventListener('click', addRequisito);
        
        laboratoriosContenedorEdit?.addEventListener("click", e => {
            const btn = e.target.closest(".eliminar-laboratorio-btn");
            if (btn) {
                if (laboratoriosContenedorEdit.children.length > 1) {
                    btn.closest(".laboratorio-item")?.remove();
                    updatePrecioTotal();
                } else {
                    Swal.fire({ icon: "warning", title: "No se puede eliminar", text: "Debe haber al menos un laboratorio responsable.", customClass: { confirmButton: "btn btn-warning" } });
                }
            }
        });
        
        requisitosContenedorEdit?.addEventListener("click", e => e.target.closest(".eliminar-requisito-btn")?.closest(".requisito-item")?.remove());

        const requiereMuestraSelectEdit = formEditServicio.querySelector("#requiereMuestra-edit");
        const acreditacionSelectEdit = formEditServicio.querySelector("#acreditacion-edit");
        const metodoFieldEdit = formEditServicio.querySelector("#metodoField-edit");
        const tipoMuestraFieldEdit = formEditServicio.querySelector("#tipoMuestraField-edit");
        const tipoMuestraInputEdit = formEditServicio.querySelector("#tipoMuestra-edit");
        
        const handleEditMuestraSelection = () => {
            const isSiSelected = requiereMuestraSelectEdit?.value === "si";
            const isAcreditadoSelected = acreditacionSelectEdit?.value.includes("Acreditado");
            tipoMuestraFieldEdit.style.display = isSiSelected ? "block" : "none";
            tipoMuestraInputEdit.disabled = !isSiSelected;
            if (!isSiSelected) tipoMuestraInputEdit.value = "";
            metodoFieldEdit.style.display = isAcreditadoSelected ? "block" : "none";
        };
        
        $(requiereMuestraSelectEdit).on("change", handleEditMuestraSelection);
        $(acreditacionSelectEdit).on("change", handleEditMuestraSelection);
        handleEditMuestraSelection();

        formEditServicio.addEventListener("submit", async function (e) {
            e.preventDefault();
            const servicioId = this.querySelector('input[name="id_servicio"]').value;
            await submitForm(this, this.action || `/servicios/${servicioId}`, "PUT");
        });
    };
});
