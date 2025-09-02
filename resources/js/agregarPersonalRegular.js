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

document.addEventListener('DOMContentLoaded', function () {
    const formAgregarEmpleado = document.getElementById('form-agregar-empleado');
    let fvAdd;
    const Span = document.createElement('span');
    Span.className = 'spinner-border me-1 m-1';
    Span.role = 'status';
    Span.ariaHidden = 'true';
    const addBtn = document.getElementById('AddEmpleadoBtn');

    formAgregarEmpleado.addEventListener('submit', function (e) {
        e.preventDefault();
    });

    Dropzone.autoDiscover = false;

    const previewTemplate = `
        <div class="dz-preview dz-file-preview w-100 h-100">
            <div class="dz-image w-100 h-100">
                <img data-dz-thumbnail class="w-100 h-100 object-fit-cover rounded" />
            </div>
        </div>
    `;

    const dropzone = new Dropzone('#dropzone-basic', {
        previewTemplate: previewTemplate,
        url: "/personal/regular/store",
        paramName: 'fotoEmpleado',
        maxFiles: 1,
        maxFilesize: 2,
        acceptedFiles: 'image/*',
        thumbnailWidth: null,
        thumbnailHeight: null,
        autoProcessQueue: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });

    dropzone.on('addedfile', function (file) {
        if (this.files.length > 1) {
            this.removeFile(this.files[0]);
        }
    });
    
    dropzone.on('removedfile', function (file) {
        const fotoInput = document.getElementById('fotoEmpleadoInput');
        if (fotoInput) {
            fotoInput.value = '';
        }
    });

    var quill = new Quill('#snow-editor', {
        theme: 'snow',
        modules: {
            toolbar: '#snow-toolbar'
        }
    });

    fvAdd = FormValidation.formValidation(formAgregarEmpleado, {
        fields: {
            nombreEmpleado: {
                validators: {
                    notEmpty: {
                        message: 'Por favor, introduce el nombre del empleado o selecciónalo.'
                    }
                }
            },
            folioEmpleado: {
                validators: {
                    notEmpty: {
                        message: 'Por favor, introduce el folio del empleado.'
                    }
                }
            },
            correoEmpleado: {
                validators: {
                    notEmpty: {
                        message: 'Por favor, introduce el correo del empleado.'
                    }
                }
            },
            fechaIngreso: {
                validators: {
                    notEmpty: {
                        message: 'Por favor, introduce la fecha de ingreso del empleado.'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: ''
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    });

    fvAdd.on('core.form.valid', function () {
        addBtn.appendChild(Span);
        addBtn.disabled = true;

        const formData = new FormData(formAgregarEmpleado);
        
        // Agrega el archivo de Dropzone al FormData
        if (dropzone.files.length > 0) {
            formData.append('fotoEmpleado', dropzone.files[0]);
        }
        
        // Agrega el contenido del editor de texto
        formData.append('descripcionEmpleado', quill.root.innerHTML);

        submitForm(formData);
    });

    function submitForm(formData) {
        fetch('/personal/regular/post', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
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
            Span.remove();
            showAlert('Empleado agregado correctamente.', 'success');
            formAgregarEmpleado.reset();
            fvAdd.resetForm(true);
            quill.root.innerHTML = '';
            dropzone.removeAllFiles(true);
            window.location.href = '/personal/regular';
        })
        .catch(error => {
            addBtn.disabled = false;
            Span.remove();
            console.error('Error al guardar el empleado:', error);
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
            } catch (e) {
                /* ignore */
            }
            showAlert(errorMessage, 'error');
        });
    }

    const nombreEmpleadoInput = $('#nombreEmpleadoInput');

    var usuariosBH = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: usuarios
    });

    usuariosBH.initialize();

    nombreEmpleadoInput.typeahead({
            hint: false,
            highlight: true,
            minLength: 1
        }, {
            name: 'users',
            display: 'name',
            source: usuariosBH,
            templates: {
                suggestion: function (data) {
                    return '<div><strong>' + data.name + '</strong></div>';
                }
            }
        });

    nombreEmpleadoInput.bind('typeahead:select', function (event, suggestion) {
        event.preventDefault();
        $(this).val(suggestion.name);
        $('#correoEmpleadoInput').val(suggestion.email);
        $('#id_usuario_input').val(suggestion.id);
    });
});