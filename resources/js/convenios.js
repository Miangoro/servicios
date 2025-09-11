document.addEventListener('DOMContentLoaded', function() {
    // Other DataTable initialization code...

    const addConvenioForm = document.getElementById('formAddConvenio'); // Corregido el ID del formulario
    if (addConvenioForm) {
        addConvenioForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío del formulario por defecto

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Si la respuesta no es 200 OK (ej. 422 de validación), la tratamos como error
                    return response.json().then(errorData => Promise.reject(errorData));
                }
                return response.json();
            })
            .then(data => {
                // Manejar la respuesta de éxito
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: 'El convenio se ha registrado correctamente.',
                        showConfirmButton: false, // Oculta el botón de confirmación
                        timer: 2000 // La alerta se cierra automáticamente después de 2 segundos
                    }).then(() => {
                        // Recarga solo la tabla de DataTables en lugar de toda la página
                        const table = $('#tablaConvenios').DataTable();
                        if (table) {
                            table.ajax.reload();
                        }
                    });
                    
                    // Ocultar el modal después de un registro exitoso
                    const modalElement = document.getElementById('addConvenioModal');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }

                } else {
                    // Manejar otros casos de no-éxito que no sean errores de validación
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Hubo un problema al agregar el convenio.'
                    });
                }
            })
            .catch(error => {
                // Manejar los errores, incluyendo los de validación
                let errorMessages = 'Ocurrió un error inesperado.';
                if (error.errors) {
                    errorMessages = Object.values(error.errors).flat().join('\n');
                } else if (error.message) {
                    errorMessages = error.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: errorMessages
                });

                // Vuelve a mostrar el modal para que el usuario pueda corregir
                const modalElement = document.getElementById('addConvenioModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.show();
                }
            });
        });
    }
});