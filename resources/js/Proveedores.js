$(function() {
    var table = $('.prov_datatable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        },
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/catalogos/proveedores",
            type: "GET",
        },
        dataType: 'json',
        columns: [{
            data: 'DT_RowIndex', // para contar el número de fila
            name: 'num',
            orderable: false,
            searchable: false
        }, {
            data: 'razon_social',
            name: 'Razón Social'
        }, {
            data: 'direccion',
            name: 'Dirección'
        }, {
            data: 'rfc',
            name: 'RFC'
        },{
            data: 'Datos Bancarios',
            name: 'Datos Bancarios',
            orderable: false,
            searchable: false
        },{
            data: 'Contacto',
            name: 'Contacto',
            orderable: false,
            searchable: false
        },{
            data: 'tipo',
            name: 'Tipo de Compra',
        },{
            data: 'Evaluacion del Proveedor',
            name: 'Evaluación del Proveedor',
            orderable: false,
            searchable: false
        }, {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: false
        }, ]
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
    if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tablaProveedores')) {
        $('#tablaProveedores').DataTable().ajax.reload();
    } else {
        location.reload();
    }
}

    // validar datos antes de agregar o editar un proveedor
    document.addEventListener('DOMContentLoaded', function() {
    const agregarProveedorForm = document.getElementById('agregarProveedorForm');
    const editLaboratorioForm = document.getElementById('editLaboratorio');
    let fvAdd;

    if (agregarProveedorForm) {
        fvAdd = FormValidation.formValidation(agregarProveedorForm, {
            fields: {
                nombreProveedor: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, introduce el nombre del proveedor.'
                        }
                    }
                },
                direccionProveedor: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, introduce la dirección del proveedor.'
                        }
                    }
                },
                rfcProveedor: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, introduce el RFC del proveedor.'
                        }
                    }
                },
                nombreBanco: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, introduce el nombre del banco.'
                        }
                    }
                },
                clabeInterbancaria: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, introduce la Clabe Interbancaria del proveedor.'
                        },
                        digits: {
                            message: 'La CLABE debe contener solo dígitos.'
                        }
                    }
                },
                selectTipoCompra: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor, selecciona un tipo de compra.'
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

        fvAdd.on('core.form.valid', function() {
            // El formulario de agregar es válido, procede con el envío AJAX
            const formData = new FormData(agregarProveedorForm);

            fetch('/catalogos/proveedores', { // Ruta para guardar nuevos proveedores
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
                    showAlert("Proveedor agregado correctamente.", 'success');
                    var addModal = bootstrap.Modal.getInstance(document.getElementById('agregarProv'));
                    if (addModal) {
                        addModal.hide();
                    }
                    agregarProveedorForm.reset();
                    fvAdd.resetForm(true);
                    reloadTableOrPage();
                })
                .catch(error => {
                    console.error('Error al guardar el proveedor:', error);
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
        const addModalElement = document.getElementById('agregarProv');
        if (addModalElement) {
            addModalElement.addEventListener('hidden.bs.modal', function() {
                fvAdd.resetForm(true);
                agregarProveedorForm.reset();
            });
        }
    }


    if (editLaboratorioForm) {
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
            // El formulario de editar es válido, procede con el envío AJAX
            const laboratorioId = document.getElementById('id_laboratorio_modal').value;
            const formData = new FormData(editLaboratorioForm);

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
                    showAlert(data.message, 'success');
                    var editModal = bootstrap.Modal.getInstance(document.getElementById('editLabModal'));
                    if (editModal) {
                        editModal.hide();
                    }
                    reloadTableOrPage();
                })
                .catch(error => {
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

 $(function () {
  var maxlengthInput = $('.bootstrap-maxlength-example'),
    formRepeater = $('.form-repeater');

  // Bootstrap Max Length
  // --------------------------------------------------------------------
  if (maxlengthInput.length) {
    maxlengthInput.each(function () {
      $(this).maxlength({
        warningClass: 'label label-success bg-success text-white',
        limitReachedClass: 'label label-danger',
        separator: ' out of ',
        preText: 'You typed ',
        postText: ' chars available.',
        validate: true,
        threshold: +this.getAttribute('maxlength')
      });
    });
  }

  // Form Repeater
  // -----------------------------------------------------------------------------------------------------------------

   if (formRepeater.length) {
        var repeaterItemCount = 0;

        formRepeater.repeater({
            show: function () {
                repeaterItemCount++;

                var currentRepeaterItem = $(this);
                var formControls = currentRepeaterItem.find('.form-control, .form-select');
                var formLabels = currentRepeaterItem.find('.form-label');

                formControls.each(function (i) {
                    var uniqueId = 'form-repeater-contact-' + repeaterItemCount + '-' + i;

                    $(this).attr('id', uniqueId);
                    $(formLabels[i]).attr('for', uniqueId);
                });

                $(this).slideDown();
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    }
});