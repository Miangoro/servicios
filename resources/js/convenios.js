$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const dataTableUrl = $('#tablaConvenios').data('url');
    const table = $('#tablaConvenios').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: dataTableUrl,
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'clave', name: 'clave' },
            { data: 'nombre_proyecto', name: 'nombre_proyecto' },
            { data: 'investigador_responsable', name: 'investigador_responsable' },
            { data: 'duracion', name: 'duracion' },
            { data: 'tipo_duracion', name: 'tipo_duracion' },
            { data: 'acciones', name: 'acciones', orderable: false, searchable: false },
        ],
        // Se corrige la configuración de 'dom' y se agrega 'language' y 'responsive'
        dom: '<"top d-flex justify-content-between align-items-center flex-wrap"f<"d-flex align-items-center"lB>>rtip',
        buttons: [
            {
                text: '<i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i> <span class="d-none d-sm-inline-block">Agregar Convenio</span>',
                className: 'btn btn-success waves-effect waves-light',
                action: function(e, dt, node, config) {
                    resetForm();
                    $('#addConvenioModal').modal('show');
                }
            }
        ],
        order: [[1, 'asc']],
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
    });

    $('.dataTables_length label').contents().filter(function() {
        return this.nodeType === 3;
    }).remove();

    const formConvenio = document.getElementById('formAddConvenio');
    const modalTitle = document.getElementById('addConvenioModalLabel');
    const submitButton = formConvenio.querySelector('button[type="submit"]');
    const addModal = new bootstrap.Modal(document.getElementById('addConvenioModal'));
    const viewModal = new bootstrap.Modal(document.getElementById('viewConvenioModal'));

    if (!$('#convenioId').length) {
        $('<input>').attr({
            type: 'hidden',
            id: 'convenioId',
            name: 'id'
        }).appendTo(formConvenio);
    }

    function resetForm() {
        formConvenio.reset();
        $('#convenioId').val('');
        $(formConvenio).find('.is-invalid').removeClass('is-invalid');
        modalTitle.textContent = 'Registrar Nuevo Convenio';
        submitButton.innerHTML = '<i class="ri-add-line"></i> Registrar';
        
        $('#clave').attr('placeholder', '01-PROY');
        $('#clave').attr('required', 'required');
    }

    window.visualizarConvenio = function(id) {
        $.ajax({
            url: '/convenios/' + id,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#viewClave').val(response.data.clave || 'N/A');
                    $('#viewNombreProyecto').val(response.data.nombre_proyecto || 'N/A');
                    $('#viewInvestigador').val(response.data.investigador_responsable || 'N/A');
                    $('#viewDuracion').val(response.data.duracion || 'N/A');
                    $('#viewTipoDuracion').val(response.data.tipo_duracion || 'N/A');
                    
                    viewModal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo cargar la información del convenio.'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información del convenio. Error: ' + error
                });
            }
        });
    };

    $('#tablaConvenios').on('click', '.btn-edit', function() {
        const convenioId = $(this).data('id');
        const convenioClave = $(this).data('clave');
        const convenioNombre = $(this).data('nombre');
        const convenioInvestigador = $(this).data('investigador');
        const convenioDuracion = $(this).data('duracion');
        const convenioTipoDuracion = $(this).data('tipo-duracion');

        $('#convenioId').val(convenioId);
        $('#clave').val(convenioClave);
        $('#nombreProyecto').val(convenioNombre);
        $('#investigadorResponsable').val(convenioInvestigador);
        $('#duracion').val(convenioDuracion);
        $('#tipoDuracion').val(convenioTipoDuracion);

        $('#clave').attr('placeholder', 'Dejar vacío para mantener la clave actual');
        $('#clave').removeAttr('required');

        modalTitle.textContent = 'Editar Convenio';
        submitButton.innerHTML = '<i class="ri-pencil-line"></i> Actualizar';

        $(formConvenio).find('.is-invalid').removeClass('is-invalid');
        
        addModal.show();
    });
    
    $('#tablaConvenios').on('click', '.btn-view', function() {
        const convenioId = $(this).data('id');
        visualizarConvenio(convenioId);
    });

    if (formConvenio) {
        formConvenio.addEventListener('submit', function(event) {
            event.preventDefault();

            const allFormControls = this.querySelectorAll('.form-control, .form-select');
            allFormControls.forEach(control => {
                control.classList.remove('is-invalid');
            });

            const convenioId = $('#convenioId').val();
            const isEditMode = convenioId !== '';

            if (isEditMode) {
                if (isNaN(parseInt(convenioId))) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de actualización',
                        text: 'No se pudo obtener un ID válido para el convenio.'
                    });
                    return; 
                }
            } else {
                if ($('#clave').val().trim() === '') {
                    $('#clave').addClass('is-invalid');
                    Swal.fire({
                        icon: 'error',
                        title: 'Campo requerido',
                        text: 'La clave es obligatoria para nuevos convenios.'
                    });
                    return;
                }
            }
            
            let formIsValid = true;
            const requiredFields = ['nombreProyecto', 'investigadorResponsable', 'duracion', 'tipoDuracion'];
            
            requiredFields.forEach(field => {
                const fieldElement = document.getElementById(field);
                if (fieldElement && !fieldElement.value.trim()) {
                    fieldElement.classList.add('is-invalid');
                    formIsValid = false;
                }
            });
            
            if (!formIsValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    text: 'Por favor, complete todos los campos requeridos.'
                });
                return;
            }

            let url = '';
            let method = '';
            
            if (isEditMode) {
                url = `/convenios/${convenioId}`;
                method = 'PUT';
            } else {
                url = this.action;
                method = 'POST';
            }

            const formDataObj = {
                clave: isEditMode && $('#clave').val().trim() === '' ? null : $('#clave').val().trim(),
                nombre_proyecto: $('#nombreProyecto').val().trim(),
                investigador_responsable: $('#investigadorResponsable').val().trim(),
                duracion: $('#duracion').val().trim(),
                tipo_duracion: $('#tipoDuracion').val().trim(),
                _method: method === 'PUT' ? 'PUT' : 'POST'
            };
            
            if (formDataObj.clave === null) {
                delete formDataObj.clave;
            }
            
            fetch(url, {
                method: 'POST',
                body: JSON.stringify(formDataObj),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => Promise.reject(errorData));
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        table.ajax.reload();
                        addModal.hide();
                        resetForm();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Hubo un problema al guardar el convenio.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.errors) {
                    let errorMessages = '';
                    for (const field in error.errors) {
                        const fieldId = field === 'investigador_responsable' ? 'investigadorResponsable' : 
                                       field === 'nombre_proyecto' ? 'nombreProyecto' : 
                                       field === 'tipo_duracion' ? 'tipoDuracion' : field;
                                       
                        const fieldElement = document.getElementById(fieldId);
                        if (fieldElement) {
                            fieldElement.classList.add('is-invalid');
                        }
                        errorMessages += error.errors[field].join('<br>') + '<br>';
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de validación',
                        html: errorMessages
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: error.message || 'Ha ocurrido un error inesperado al actualizar el convenio.'
                    });
                }
                addModal.show();
            });
        });
    }
    
    $('.btn-danger[data-bs-dismiss="modal"]').on('click', function() {
        addModal.hide();
        resetForm();
    });
    
    $('#addConvenioModal').on('hidden.bs.modal', function () {
        resetForm();
    });
    
    $('#tablaConvenios').on('click', '.btn-delete', function() {
        const convenioId = $(this).data('id');

        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/convenios/${convenioId}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                table.ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message || 'Ha ocurrido un error inesperado al eliminar el convenio.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: '¡Error!',
                            text: 'Ha ocurrido un error inesperado al eliminar el convenio.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});