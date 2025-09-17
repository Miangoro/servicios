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

(function () {
    'use strict';
    const flatpickrDate2 = document.querySelector('#flatpickr-date2');
    
  if (flatpickrDate2) {
    flatpickrDate2.flatpickr({
      monthSelectorType: 'static'
    });
  }

})();

document.addEventListener('DOMContentLoaded', function(){
    const formAgregarNombramiento = document.getElementById('form-agregar-nombramiento');
    const Span = document.createElement('span');
    Span.className = 'spinner-border me-1 m-1';
    Span.role = 'status';
    Span.ariaHidden = 'true';
    const addBtn = document.getElementById('AddNombramientoBtn');
    let fvAdd;

    fvAdd = FormValidation.formValidation(formAgregarNombramiento, {
    fields: {
      puesto: { validators: { notEmpty: { message: 'Por favor, selecciona el puesto.' } } },
      area: { validators: { notEmpty: { message: 'Por favor, introduce el área.' } } },
      fechaNombramiento: { validators: { notEmpty: { message: 'Por favor, introduce la fecha de nombramiento.' } } },
      fechaEfectivo: { validators: { notEmpty: { message: 'Por favor, introduce la fecha efectiva.' } } },
      responsable: { validators: { notEmpty: { message: 'Por favor, selecciona al responsable.' } } },
      suplente: { validators: { notEmpty: { message: 'Por favor, introduce el suplente.' } } },
      supervisor: { validators: { notEmpty: { message: 'Por favor, selecciona al supervisor' } } }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: '', rowSelector: '.form-floating' }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  });

  fvAdd.on('core.form.valid', function () {
    const formData = new FormData(formAgregarNombramiento);

    addBtn.appendChild(Span);
    addBtn.disabled = true;

    fetch('/personal/regular/nombramientoPost', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    })
      .then(response => {
        if (!response.ok) return response.json().then(err => { throw new Error(JSON.stringify(err)); });
        return response.json();
      })
      .then(data => {
        addBtn.disabled = false;
        addBtn.removeChild(Span);
        showAlert('Nombramiento agregado correctamente.', 'success');
        form.reset();
        fvAdd.resetForm(true);
        window.location.href = '/personal/regular';
      })
      .catch(error => {
        addBtn.disabled = false;
        addBtn.removeChild(Span);
        console.error('Error al guardar el proveedor:', error);
        let msg = 'Ocurrió un error inesperado.';
        if (typeof error.message === 'string' && error.message.startsWith('{')) {
          try {
            const parsed = JSON.parse(error.message);
            if (parsed.error) msg = 'Error del servidor: ' + parsed.error;
            else if (parsed.errors) {
              msg = 'Errores de validación:\n' + Object.entries(parsed.errors)
                .map(([k, v]) => ` - ${k}: ${v.join(', ')}`).join('\n');
            }
          } catch (_) {}
        }
        showAlert(msg, 'error');
      });
  });

});