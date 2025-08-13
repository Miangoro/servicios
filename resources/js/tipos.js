// public/js/laboratorios.js

$(function() {
    var table = $('.lab_datatable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        },
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/catalogos/laboratorios",
            type: "GET",
            data: function(d) {}
        },
        dataType: 'json',
        type: "POST",
        columns: [{
            data: null,
            name: 'num',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
                return meta.row + 1;
            }
        }, {
            data: 'clave',
            name: 'clave'
        }, {
            data: 'laboratorio',
            name: 'laboratorio'
        }, {
            data: 'descripcion',
            name: 'descripcion'
        }, {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: false
        }, ]
    }).on('init.dt', function() {
        var boton = $('#addLabBtn').clone();

        var searchDiv = $('.dataTables_filter');

        // Contenedor con flexbox
        searchDiv.css({
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'right',
            gap: '10px'
        });

        // Mover el botón a la derecha
        searchDiv.append(boton);

        // Eliminar el botón original para evitar duplicados
        $('#addLabBtn').remove();
    });
});

function showAlert(message, type = 'success') {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                confirmButton: `btn btn-${type}`
            }
        });
    } else {
        alert(message);
    }
}

// Función auxiliar para recargar la tabla o la página
function reloadTableOrPage() {
    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tablaLaboratorios')) {
        $('#tablaLaboratorios').DataTable().ajax.reload();
    } else {
        location.reload();
    }
}

var quillEdit = new Quill('#snow-editor-edit', {
    theme: 'snow',
    modules: {
        toolbar: '#snow-toolbar-edit'
    }
});

/**
 * Abre el modal de edición y carga los datos del laboratorio.
 * @param {number} id - El ID del laboratorio a editar.
 */
window.editLab = function(id) {
    // Primero, carga las unidades para el select
    fetch('/laboratorios/unidades')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar las unidades');
            }
            return response.json();
        })
        .then(unidadesData => {
            const select = document.getElementById('selectUnidadesEdit');
            select.innerHTML = '<option value="">Seleccione una unidad</option>';
            for (const key in unidadesData) {
                if (unidadesData.hasOwnProperty(key)) {
                    const option = document.createElement('option');
                    option.value = key;
                    option.text = unidadesData[key];
                    select.appendChild(option);
                }
            }
            return fetch(`/laboratorios/${id}/edit`);
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(JSON.stringify(errorData));
                });
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('id_laboratorio_modal').value = data.id_laboratorio;
            document.getElementById('nombre_laboratorio_modal').value = data.nombre;
            document.getElementById('clave_laboratorio_modal').value = data.clave;
            // Asignar el valor de la unidad después de cargar las opciones
            document.getElementById('selectUnidadesEdit').value = data.id_unidad;
            document.getElementById('descripcion_laboratorio_modal').value = data.descripcion;

            // Mostrar descripcion en el editor Quill
            quillEdit.clipboard.dangerouslyPasteHTML(data.descripcion || '');

            var editModal = new bootstrap.Modal(document.getElementById('editLabModal'));
            editModal.show();
        })
        .catch(error => {
            console.error('Error al obtener los datos del laboratorio:', error);
            let errorMessage = 'No se pudo cargar la información del laboratorio. Por favor, intente de nuevo.';
            try {
                const parsedError = JSON.parse(error.message);
                if (parsedError.error) {
                    errorMessage = 'Error del servidor: ' + parsedError.error;
                }
            } catch (e) {}
            showAlert(errorMessage, 'error');
        });
};

/**
 * Elimina un laboratorio después de la confirmación del usuario.
 * @param {number} id - El ID del laboratorio a eliminar.
 */
window.deleteLab = function(id) {

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-danger me-3',
                cancelButton: 'btn btn-outline-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                fetch(`/laboratorios/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(JSON.stringify(errorData));
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        showAlert(data.message, 'success');
                        reloadTableOrPage();
                    })
                    .catch(error => {
                        console.error('Error al eliminar el laboratorio:', error);
                        let errorMessage = 'Error al eliminar el laboratorio. Por favor, intente de nuevo.';
                        try {
                            const parsedError = JSON.parse(error.message);
                            if (parsedError.error) {
                                errorMessage = 'Error del servidor: ' + parsedError.error;
                            }
                        } catch (e) { /* ignore */ }
                        showAlert(errorMessage, 'error');
                    });
            }
        });
    } else {
        if (confirm('¿Estás seguro de que quieres eliminar este laboratorio? Esta acción no se puede deshacer.')) {
            fetch(`/laboratorios/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(JSON.stringify(errorData));
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    showAlert(data.message, 'success');
                    reloadTableOrPage();
                })
                .catch(error => {
                    console.error('Error al eliminar el laboratorio:', error);
                    let errorMessage = 'Error al eliminar el laboratorio. Por favor, intente de nuevo.';
                    try {
                        const parsedError = JSON.parse(error.message);
                        if (parsedError.error) {
                            errorMessage = 'Error del servidor: ' + parsedError.error;
                        }
                    } catch (e) { /* ignore */ }
                    showAlert(errorMessage, 'error');
                });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const agregarLaboratorioForm = document.getElementById('agregarLaboratorioForm');
    const editLaboratorioForm = document.getElementById('editLaboratorio');
    let fvAdd;

    const Span = document.createElement('span');
    Span.className = 'spinner-border me-1 m-1';
    Span.role = 'status';
    Span.ariaHidden = 'true';
    const addBtn = document.getElementById('modalAddLabBtn');
    const saveBtn = document.getElementById('modalEditLabBtn');

    var quill = new Quill('#snow-editor', {
        theme: 'snow',
        modules: {
            toolbar: '#snow-toolbar'
        }
    });


    if (agregarLaboratorioForm) {

        document.getElementById('agregarLaboratorioForm').addEventListener('submit', function(e) {
            document.getElementById('descripcion').value = quill.root.innerHTML; // Cambiado a innerHTML para guardar el formato
        });

        fvAdd = FormValidation.formValidation(agregarLaboratorioForm, {
            fields: {
                nombre: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, introduce el nombre del laboratorio.'
                        }
                    }
                },
                clave: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, introduce la clave.'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: '.form-floating'
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            }
        });

        fetch('/laboratorios/unidades')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('selectUnidades');
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const option = document.createElement('option');
                        option.value = key;
                        option.text = data[key];
                        select.appendChild(option);
                    }
                }

                fvAdd.addField('selectUnidades', {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, seleccione una unidad.'
                        }
                    }
                });
            })
            .catch(error => console.error('Error al obtener datos:', error));

        fvAdd.on('core.form.valid', function() {
            document.getElementById('descripcion').value = quill.root.innerHTML;
            // El formulario de agregar es válido, procede con el envío AJAX
            const formData = new FormData(agregarLaboratorioForm);

            addBtn.appendChild(Span);
            addBtn.disabled = true;

            fetch('/catalogos/laboratorios', { // Ruta para guardar nuevos laboratorios
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(JSON.stringify(errorData));
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    addBtn.disabled = false;
                    addBtn.removeChild(Span);

                    showAlert("Laboratorio agregado correctamente.", 'success');
                    var addModal = bootstrap.Modal.getInstance(document.getElementById('agregarLab'));
                    if (addModal) {
                        addModal.hide();
                    }
                    agregarLaboratorioForm.reset();
                    fvAdd.resetForm(true);
                    reloadTableOrPage();
                })
                .catch(error => {
                    addBtn.disabled = false;
                    addBtn.removeChild(Span);

                    console.error('Error al guardar el laboratorio:', error);
                    let errorMessage = 'Ocurrió un error inesperado al guardar. Por favor, intente de nuevo.';
                    try {
                        const parsedError = JSON.parse(error.message);
                        if (parsedError.error) {
                            errorMessage = 'Error del servidor: ' + parsedError.error;
                        } else if (parsedError.errors) {
                            let validationErrors = 'Errores de validación:\n';
                            for (const field in parsedError.errors) {
                                validationErrors += ` - ${field}: ${parsedError.errors[field].join(', ')}\n`;
                            }
                            errorMessage = validationErrors;
                        }
                    } catch (e) { /* ignore */ }
                    showAlert(errorMessage, 'error');
                });
        });

        // Limpiar la validación cuando el modal se oculta
        const addModalElement = document.getElementById('agregarLab');
        if (addModalElement) {
            addModalElement.addEventListener('hidden.bs.modal', function() {
                fvAdd.resetForm(true);
                agregarLaboratorioForm.reset();
            });
        }
    }


    if (editLaboratorioForm) {

        document.getElementById('editLaboratorio').addEventListener('submit', function(e) {
            // CORRECCIÓN: Usa el objeto quillEdit para obtener el HTML
            document.getElementById('descripcion_laboratorio_modal').value = quillEdit.root.innerHTML;
        });


        const fvEdit = FormValidation.formValidation(editLaboratorioForm, {
            fields: {
                laboratorio: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, introduce el nombre del laboratorio.'
                        }
                    }
                },
                clave: {
                    validators: {
                        stringLength: {
                            max: 50,
                            message: 'La clave no debe exceder los 50 caracteres.'
                        },
                        notEmpty: {
                            message: 'Por favor, introduce una clave.'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: '.form-floating'
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            }
        });

        fetch('/laboratorios/unidades')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('selectUnidadesEdit');
                for (const key in data) {
                    if (data.hasOwnProperty(key)) {
                        const option = document.createElement('option');
                        option.value = key;
                        option.text = data[key];
                        select.appendChild(option);
                    }
                }

                fvEdit.addField('selectUnidadesEdit', {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, seleccione una unidad.'
                        }
                    }
                });
            })
            .catch(error => console.error('Error al obtener datos:', error));

        fvEdit.on('core.form.valid', function() {
            // CORRECCIÓN: Usa el objeto quillEdit para obtener el HTML y asignarlo al campo oculto
            document.getElementById('descripcion_laboratorio_modal').value = quillEdit.root.innerHTML;

            const laboratorioId = document.getElementById('id_laboratorio_modal').value;
            const formData = new FormData(editLaboratorioForm);

            modalEditLabBtn.appendChild(Span);
            modalEditLabBtn.disabled = true;

            fetch(`/laboratorios/${laboratorioId}`, { // Ruta para actualizar laboratorio
                    method: 'POST', // Laravel usa POST con @method('PUT')
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(JSON.stringify(errorData));
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    modalEditLabBtn.disabled = false;
                    modalEditLabBtn.removeChild(Span);

                    showAlert(data.message, 'success');
                    var editModal = bootstrap.Modal.getInstance(document.getElementById('editLabModal'));
                    if (editModal) {
                        editModal.hide();
                    }
                    reloadTableOrPage();
                })
                .catch(error => {
                    modalEditLabBtn.disabled = false;
                    modalEditLabBtn.removeChild(Span);

                    console.error('Error al actualizar el laboratorio:', error);
                    let errorMessage = 'Ocurrió un error inesperado al actualizar. Por favor, intente de nuevo.';
                    try {
                        const parsedError = JSON.parse(error.message);
                        if (parsedError.error) {
                            errorMessage = 'Error del servidor: ' + parsedError.error;
                        } else if (parsedError.errors) {
                            let validationErrors = 'Errores de validación:\n';
                            for (const field in parsedError.errors) {
                                validationErrors += ` - ${field}: ${parsedError.errors[field].join(', ')}\n`;
                            }
                            errorMessage = validationErrors;
                        }
                    } catch (e) { /* ignore */ }
                    showAlert(errorMessage, 'error');
                });
        });

        const editModalElement = document.getElementById('editLabModal');
        if (editModalElement) {
            editModalElement.addEventListener('hidden.bs.modal', function() {
                fvEdit.resetForm(true); // Resetear la validación
            });
        }
    }
});

$(function() {
    var table = $('.unidades_datatable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        },
        dom: '<"row"<"col-sm-12 col-md-6 d-flex justify-content-start"f><"col-sm-12 col-md-6 d-flex justify-content-end align-items-center"l<"botones_datatable d-flex align-items-center">>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/catalogos/unidades",
            type: "GET",
            data: function(d) {}
        },
        dataType: 'json',
        type: "POST",
        columns: [{
            data: null,
            name: 'num',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
                return meta.row + 1;
            }
        }, {
            data: 'nombre',
            name: 'nombre'
        }, {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }, ]
    }).on('init.dt', function() {
        var boton = $('#agregarUnidadBtn').clone();
    }).on('init.dt', function() {
        var boton = $('#agregarUnidadBtn').clone();

        // Mueve el botón al nuevo contenedor
        $('.botones_datatable').append(boton);

        // Agrega la clase de margen al botón
        boton.addClass('ms-2');

        // Elimina el botón original para evitar duplicados
        $('#agregarUnidadBtn').remove();

        // Oculta el texto "Mostrar" y los "registros"
        $('.dataTables_length label').contents().filter(function() {
            return this.nodeType === 3;
        }).remove();

        // Mueve el filtro de búsqueda para alinear el botón y el mostrar
        var searchDiv = $('.dataTables_filter');
        searchDiv.css({
            display: 'flex',
            alignItems: 'center',
            gap: '10px'
        });
    });
});