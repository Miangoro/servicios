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
  const formEditarEmpleado = document.getElementById('form-editar-empleado');
  let fvAdd;
  const Span = document.createElement('span');
  Span.className = 'spinner-border me-1 m-1';
  Span.role = 'status';
  Span.ariaHidden = 'true';
  const addBtn = document.getElementById('EditEmpleadoBtn');

  const fotoInput = document.getElementById('fotoEmpleadoInputEdit');
  const Id = document.getElementById('id_usuario_inputEdit');
  const nombre = document.getElementById('nombreEmpleadoInputEdit');
  const folio = document.getElementById('folioEmpleadoInputEdit');
  const correo = document.getElementById('correoEmpleadoInputEdit');
  const fecha = document.getElementById('flatpickr-date');
  const firma = document.getElementById('firma');
  const firCorreo = document.getElementById('firmaCorreo');
  const descripcionInput = document.getElementById('descripcionEmpEdit');

  formEditarEmpleado.addEventListener('submit', function (e) {
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

  const dropzone = new Dropzone('#dropzone-basic-edit', {
    previewTemplate: previewTemplate,
    url: '/personal/regular/store',
    paramName: 'fotoEmpleadoEdit',
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

//mostrar los datos
  if (empleado.foto) {
    var mockFile = { name: 'Foto actual', size: 12345 };

    var imageUrl = `/${empleado.foto}`;

    dropzone.emit('addedfile', mockFile);
    dropzone.emit('thumbnail', mockFile, imageUrl);
    dropzone.emit('complete', mockFile);

    dropzone.files.push(mockFile);
  }

  nombre.value = empleado.nombre;
  folio.value = empleado.folio;
  correo.value = empleado.correo;
  fecha.value = empleado.fecha_ingreso;
//

  dropzone.on('addedfile', function (file) {
    if (this.files.length > 1) {
      this.removeFile(this.files[0]);
    }
  });

  dropzone.on('removedfile', function (file) {
    if (fotoInput) {
      fotoInput.value = '';
    }
  });

  var quill = new Quill('#snow-editor-edit', {
    theme: 'snow',
    modules: {
      toolbar: '#snow-toolbar'
    }
  });

  if (empleado.descripcion) {
    quill.root.innerHTML = empleado.descripcion;
  }

  fvAdd = FormValidation.formValidation(formEditarEmpleado, {
    fields: {
      nombreEmpleadoEdit: {
        validators: {
          notEmpty: {
            message: 'Por favor, introduce el nombre del empleado o selecciónalo.'
          }
        }
      },
      folioEmpleadoEdit: {
        validators: {
          notEmpty: {
            message: 'Por favor, introduce el folio del empleado.'
          }
        }
      },
      correoEmpleadoEdit: {
        validators: {
          notEmpty: {
            message: 'Por favor, introduce el correo del empleado.'
          }
        }
      },
      fechaIngresoEdit: {
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
      formData.append('fotoEmpleadoEdit', dropzone.files[0]);
    }

    // Agrega el contenido del editor de texto
    formData.append('descripcionEmpleadoEdit', quill.root.innerHTML);

    submitForm(formData);
  });

  var id = Id.value;

  function submitForm(formData) {
    fetch(`/personal/regular/${id}`, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        Accept: 'application/json',
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
        showAlert('Editado correctamente.', 'success');
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
