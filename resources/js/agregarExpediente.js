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
    const formAgregarExpediente = document.getElementById('form-agregar-expediente');
    const Span = document.createElement('span');
    Span.className = 'spinner-border me-1 m-1';
    Span.role = 'status';
    Span.ariaHidden = 'true';
    const addBtn = document.getElementById('AddExpedienteBtn');

    const datosPersonalesInput = document.getElementById('d_personales');
    datosPersonalesInput.value = empleado.d_personales || '';
    const profesionInput = document.getElementById('profesion');
    profesionInput.value = empleado.profesion || '';
    const experienciaInput = document.getElementById('experiencia');
    experienciaInput.value = empleado.experiencia || '';
    const cursosInput = document.getElementById('cursos');
    cursosInput.value = empleado.cursos || '';
    const actividadesInput = document.getElementById('actividades');
    actividadesInput.value = empleado.actividades || '';
    const habilidadesInput = document.getElementById('habilidades');
    habilidadesInput.value = empleado.habilidades || '';

    var quill1 = new Quill('#snow-editor1', {
        theme: 'snow',
        modules: {
            toolbar: '#snow-toolbar1'
        }
    });
    quill1.root.innerHTML = datosPersonalesInput.value;

    var quill2 = new Quill('#snow-editor2', {
        theme: 'snow',
        modules: {
            toolbar: '#snow-toolbar2'
        }
    });
    quill2.root.innerHTML = profesionInput.value;

    var quill3 = new Quill('#snow-editor3', {
        theme: 'snow',
        modules: {
            toolbar: '#snow-toolbar3'
        }
    });
    quill3.root.innerHTML = experienciaInput.value;

    var quill4 = new Quill('#snow-editor4', {
        theme: 'snow',
        modules: {
            toolbar: '#snow-toolbar4'
        }
    });
    quill4.root.innerHTML = cursosInput.value;

    var quill5 = new Quill('#snow-editor5', {
        theme: 'snow',
        modules: {
            toolbar: '#snow-toolbar5'
        }
    });
    quill5.root.innerHTML = actividadesInput.value;

    var quill6 = new Quill('#snow-editor6', {
        theme: 'snow',
        modules: {
            toolbar: '#snow-toolbar6'
        }
    });
    quill6.root.innerHTML = habilidadesInput.value;

    addBtn.onclick = function() {
        addBtn.appendChild(Span);
        addBtn.disabled = true;

        const formData = new FormData(formAgregarExpediente);

        // Agrega el contenido del editor de texto
        formData.append('d_personales', quill1.root.innerHTML);
        formData.append('profesion', quill2.root.innerHTML);
        formData.append('experiencia', quill3.root.innerHTML);
        formData.append('cursos', quill4.root.innerHTML);
        formData.append('actividades', quill5.root.innerHTML);
        formData.append('habilidades', quill6.root.innerHTML);

        submitForm(formData);
    }

    function submitForm(formData) {
        fetch('/personal/regular/expedientePost', {
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
            showAlert('Expediente actualizado correctamente.', 'success');
            formAgregarExpediente.reset();
            quill1.root.innerHTML = '';
            quill2.root.innerHTML = '';
            quill3.root.innerHTML = '';
            quill4.root.innerHTML = '';
            quill5.root.innerHTML = '';
            quill6.root.innerHTML = '';
            window.location.href = '/personal/regular';
        })
        .catch(error => {
            addBtn.disabled = false;
            Span.remove();
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

});