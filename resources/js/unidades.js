class UnidadesHandler {
    constructor() {
        this.initValidators();
        this.bindEvents();
    }

    initValidators() {
        // Validación para el formulario de agregar
        this.fvAdd = FormValidation.formValidation(document.getElementById('formAgregarUnidad'), {
            fields: {
                nombreUnidad: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor introduce el nombre de la unidad'
                        },
                        
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: function(field, ele) {
                        return '.mb-3';
                    }
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            }
        }).on('core.form.valid', () => {
            this.submitAddForm();
        });

        // Validación para el formulario de editar
        this.fvEdit = FormValidation.formValidation(document.getElementById('editarunidad'), {
            fields: {
                nombre_Unidad: {
                    validators: {
                        notEmpty: {
                            message: 'Por favor introduce el nombre de la unidad'
                        },
                        stringLength: {
                            min: 3,
                            max: 255,
                            message: 'El nombre debe tener entre 3 y 255 caracteres'
                        }
                    }
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    eleValidClass: '',
                    rowSelector: function(field, ele) {
                        return '.mb-3';
                    }
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus()
            }
        }).on('core.form.valid', () => {
            this.submitEditForm();
        });
    }

    bindEvents() {
        // Limpiar formularios cuando se cierran los modales
        document.getElementById('agregarUnidades').addEventListener('hidden.bs.modal', () => {
            this.fvAdd.resetForm(true);
            document.getElementById('formAgregarUnidad').reset();
        });

        document.getElementById('editUnidadesModal').addEventListener('hidden.bs.modal', () => {
            this.fvEdit.resetForm(true);
            document.getElementById('editarunidad').reset();
        });
    }

    submitAddForm() {
        const formData = new FormData(document.getElementById('formAgregarUnidad'));
        
        this.showLoading('Registrando unidad...');
        
        fetch('/catalogos/unidades', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            this.showSuccess('Unidad registrada correctamente');
            this.reloadDataTable();
            bootstrap.Modal.getInstance(document.getElementById('agregarUnidades')).hide();
        })
        .catch(error => {
            this.handleError(error, 'Error al registrar la unidad');
        });
    }

    submitEditForm() {
        const form = document.getElementById('editarunidad');
        const formData = new FormData(form);
        const id = document.getElementById('idUnidad').value;
        
        this.showLoading('Actualizando unidad...');
        
        fetch(`/unidades/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            this.showSuccess('Unidad actualizada correctamente');
            this.reloadDataTable();
            bootstrap.Modal.getInstance(document.getElementById('editUnidadesModal')).hide();
        })
        .catch(error => {
            this.handleError(error, 'Error al actualizar la unidad');
        });
    }

    deleteUnidad(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            // Eliminamos cualquier configuración que pudiera agregar el botón "No"
            focusConfirm: true,
            focusCancel: false,
            buttons: {
                cancel: {
                    text: "Cancelar",
                    value: null,
                    visible: true
                },
                confirm: {
                    text: "Sí, eliminar",
                    value: true,
                    visible: true
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                this.showLoading('Eliminando unidad...');
                
                fetch(`/unidades/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    this.showSuccess('Unidad eliminada correctamente');
                    this.reloadDataTable();
                })
                .catch(error => {
                    this.handleError(error, 'Error al eliminar la unidad');
                });
            }
        });
    }

    reloadDataTable() {
        if ($.fn.DataTable.isDataTable('#tablaUnidades')) {
            $('#tablaUnidades').DataTable().ajax.reload(null, false);
        } else {
            location.reload();
        }
    }

    showLoading(message) {
        Swal.fire({
            title: message,
            allowEscapeKey: false,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    showSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    }

    handleError(error, defaultMessage) {
        console.error('Error:', error);
        
        let errorMessage = defaultMessage;
        if (error.errors) {
            errorMessage = Object.values(error.errors).join('<br>');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: errorMessage,
            confirmButtonText: 'Entendido',
            // Solo mostrar botón de confirmación
            showCancelButton: false,
            showDenyButton: false
        });
    }
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    window.unidadesHandler = new UnidadesHandler();
    
    // Asignar la función de eliminar al ámbito global
    window.deleteUnidad = (id) => {
        window.unidadesHandler.deleteUnidad(id);
    };
    
    // Función para editar (ya existente)
    window.editUnidad = function(id) {
        fetch(`/getUnidad/${id}`)
            .then(response => {
                if (!response.ok) throw new Error('Error en la red');
                return response.json();
            })
            .then(data => {
                if (data.error) throw new Error(data.error);
                
                document.getElementById('idUnidad').value = data.id_unidad;
                document.getElementById('nombre_Unidad').value = data.nombre_Unidad;
                
                const modal = new bootstrap.Modal(document.getElementById('editUnidadesModal'));
                modal.show();
            })
            .catch(error => {
                window.unidadesHandler.handleError(error, 'Error al cargar la unidad');
            });
    };
});