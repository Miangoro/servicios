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
  const form = document.getElementById('form-agregar-conflicto-interes');
  const Span = document.createElement('span');
  Span.className = 'spinner-border me-1 m-1';
  Span.role = 'status';
  Span.ariaHidden = 'true';
  const addBtn = document.getElementById('AddConflictoInteresBtn');
  let fvAdd;
  const area = { area: document.getElementsByName('area')[0].value || null };

  const observerCallback = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        if (area.area === null) {
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          });
          swalWithBootstrapButtons
            .fire({
              title:
                'El empleado no tiene un nombramiento registrado. Por favor, registre un nombramiento antes de agregar un conflicto de interés.',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Volver',
              reverseButtons: true
            })
            .then(result => {
              if (result.isConfirmed) {
                window.location.href = '/personal/regular';
              } else if (
                result.dismiss === Swal.DismissReason.cancel
              ) {
                window.location.href = '/personal/regular';
              }
            });
        } else {
          document.getElementsByName('area')[0].value = area.area;
        }
      }
    });
  };

  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
  };

  const observer = new IntersectionObserver(observerCallback, observerOptions);
  observer.observe(form);

  fvAdd = FormValidation.formValidation(form, {
    fields: {
      fecha: { validators: { notEmpty: { message: 'Por favor, selecciona la fecha.' } } },
      version: { validators: { notEmpty: { message: 'Por favor, escribe la versión.' } } },
      negocio: { validators: { notEmpty: { message: 'Selecciona una opción.' } } },
      negocio_cliente: { validators: { notEmpty: { message: 'Selecciona una opción.' } } },
      relacion: { validators: { notEmpty: { message: 'Selecciona una opción.' } } },
      familiar_negocio: { validators: { notEmpty: { message: 'Selecciona una opción.' } } },
      familiar_cliente: { validators: { notEmpty: { message: 'Selecciona una opción.' } } },
      laborado: { validators: { notEmpty: { message: 'Selecciona una opción.' } } },
      masPuesto: { validators: { notEmpty: { message: 'Selecciona una opción.' } } },
      parentesco: { validators: { notEmpty: { message: 'Selecciona una opción.' } } }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: '', rowSelector: '.form-floating' }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  });

  fvAdd.on('core.form.valid', function () {
    const formData = new FormData(form);

    addBtn.appendChild(Span);
    addBtn.disabled = true;

    fetch('/personal/regular/conflictoInteresPost', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    })
      .then(response => {
        if (!response.ok)
          return response.json().then(err => {
            throw new Error(JSON.stringify(err));
          });
        return response.json();
      })
      .then(data => {
        addBtn.disabled = false;
        addBtn.removeChild(Span);
        showAlert('Conflicto de interés agregado correctamente.', 'success');
        form.reset();
        fvAdd.resetForm(true);
        window.location.href = '/personal/regular';
      })
      .catch(error => {
        addBtn.disabled = false;
        addBtn.removeChild(Span);
        console.error('Error al guardar el conflicto de interés:', error);
        let msg = 'Ocurrió un error inesperado.';
        if (typeof error.message === 'string' && error.message.startsWith('{')) {
          try {
            const parsed = JSON.parse(error.message);
            if (parsed.error) msg = 'Error del servidor: ' + parsed.error;
            else if (parsed.errors) {
              msg =
                'Errores de validación:\n' +
                Object.entries(parsed.errors)
                  .map(([k, v]) => ` - ${k}: ${v.join(', ')}`)
                  .join('\n');
            }
          } catch (_) {}
        }
        showAlert(msg, 'error');
      });
  });
});
