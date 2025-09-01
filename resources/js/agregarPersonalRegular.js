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
  const addBtn = document.getElementById('AddEmpleadoBtn'); // Prevent the form from submitting immediately

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
    url: '/personal/regular/uploadPhoto',
    paramName: 'file',
    maxFiles: 1,
    maxFilesize: 2,
    acceptedFiles: 'image/*',
    thumbnailWidth: null,
    thumbnailHeight: null,
    autoProcessQueue: false // Prevent automatic upload
  }); // If a file is added, process the upload queue

  dropzone.on('addedfile', function (file) {
    // If a new file is added, remove any existing one
    if (this.files.length > 1) {
      this.removeFile(this.files[0]);
    } // Now that a file is in the queue, we can process it
    // We will not do this automatically, but on button click
  }); // Handle the successful upload of the photo

  dropzone.on('success', function (file, response) {
    // Set the value of the hidden input
    $('#fotoEmpleadoInput').val(response.path); // Now that we have the path, submit the form with a new FormData
    submitForm();
  }); // Handle upload errors

  dropzone.on('error', function (file, message) {
    showAlert('Error al subir la imagen: ' + message, 'error');
    addBtn.disabled = false;
    Span.remove();
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
  }); // When the form is validated, check if an image needs to be uploaded

  fvAdd.on('core.form.valid', function () {
    addBtn.appendChild(Span);
    addBtn.disabled = true;

    if (dropzone.files.length > 0) {
      // If a file exists, process the Dropzone queue.
      // The form submission will happen in the 'success' event handler of Dropzone.
      dropzone.processQueue();
    } else {
      // No file to upload, proceed with form submission immediately.
      submitForm();
    }
  });

  function submitForm() {
    document.getElementById('descripcionEmp').value = quill.root.innerHTML;
    const formData = new FormData(formAgregarEmpleado);

    fetch('/personal/regular/post', {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json'
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
        fvAdd.resetForm(true); // Remove Dropzone preview
        dropzone.removeAllFiles(true);
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

  nombreEmpleadoInput.typeahead(
    {
      hint: false,
      highlight: true,
      minLength: 1
    },
    {
      name: 'users',
      display: 'name',
      source: usuariosBH,
      templates: {
        suggestion: function (data) {
          return '<div><strong>' + data.name + '</strong></div>';
        }
      }
    }
  );

  nombreEmpleadoInput.bind('typeahead:select', function (event, suggestion) {
    event.preventDefault();
    $(this).val(suggestion.name);
    $('#correoEmpleadoInput').val(suggestion.email);
    $('#id_usuario_input').val(suggestion.id);
  });
});
