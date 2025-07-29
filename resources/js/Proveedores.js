$(function () {
  $('.prov_datatable').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
    },
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: '/catalogos/proveedores',
      type: 'GET'
    },
    dataType: 'json',
    columns: [
      { data: 'DT_RowIndex', name: 'num', orderable: false, searchable: false },
      { data: 'razon_social', name: 'Razón Social' },
      { data: 'direccion', name: 'Dirección' },
      { data: 'rfc', name: 'RFC' },
      { data: 'Datos Bancarios', name: 'Datos Bancarios', orderable: false, searchable: false },
      { data: 'Contacto', name: 'Contacto', orderable: false, searchable: false },
      { data: 'tipo', name: 'Tipo de Compra' },
      { data: 'Evaluacion del Proveedor', name: 'Evaluación del Proveedor', orderable: false, searchable: false },
      { data: 'action', name: 'action', orderable: true, searchable: false }
    ]
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

function reloadTableOrPage() {
  if ($.fn.DataTable.isDataTable('#tablaProveedores')) {
    $('#tablaProveedores').DataTable().ajax.reload();
  } else {
    location.reload();
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('agregarProveedorForm');
  const contactosBody = document.querySelector('#contactosTable tbody');
  const addRowBtn = document.getElementById('addContactRow');
  let fvAdd;
  const registeredFields = new Set();

  const registerField = (name, rules) => {
    if (fvAdd) {
      fvAdd.addField(name, { validators: rules });
      registeredFields.add(name);
    }
  };

  const unregisterField = name => {
    if (fvAdd && registeredFields.has(name)) {
      fvAdd.removeField(name);
      registeredFields.delete(name);
    }
  };

  const createInput = (type, name, placeholder, labelText, required = false) => {
    return `
      <div class="form-floating form-floating-outline">
        <input type="${type}" name="${name}" class="form-control" placeholder="${placeholder}" ${required ? 'required' : ''} />
        <label>${labelText}</label>
      </div>`;
  };

  const addContactRow = () => {
    const index = contactosBody.querySelectorAll('tr').length;
    const row = document.createElement('tr');

    row.innerHTML = `
      <td>${createInput('text', `contactos[${index}][nombre]`, 'Nombre del contacto', 'Nombre', true)}</td>
      <td>${createInput('text', `contactos[${index}][telefono]`, 'Número de celular', 'Celular', true)}</td>
      <td>${createInput('email', `contactos[${index}][email]`, 'Correo electrónico', 'Correo')}</td>
      <td>
        <button type="button" class="btn btn-danger remove-contact-row">
          <i class="ri-close-line ri-24px"></i>
        </button>
      </td>
    `;

    contactosBody.appendChild(row);

    const inputs = row.querySelectorAll('input');
    inputs.forEach(input => {
      const name = input.name;
      if (name.includes('[nombre]')) {
        registerField(name, { notEmpty: { message: 'El nombre del contacto no puede estar vacío.' } });
      } else if (name.includes('[telefono]')) {
        registerField(name, {
          notEmpty: { message: 'El teléfono del contacto no puede estar vacío.' },
          digits: { message: 'El teléfono debe contener solo dígitos.' }
        });
      } else if (name.includes('[email]')) {
        registerField(name, {
          emailAddress: { message: 'El email no es una dirección válida.' }
        });
      }
    });

    if (typeof mdb !== 'undefined' && mdb.Input) {
      new mdb.Input(row.querySelector('.form-floating input'));
    }
  };

  const clearDynamicFields = () => {
    contactosBody.querySelectorAll('input').forEach(input => unregisterField(input.name));
    contactosBody.innerHTML = '';
  };

  addRowBtn?.addEventListener('click', addContactRow);

  contactosBody.addEventListener('click', e => {
    if (e.target.closest('.remove-contact-row')) {
      const row = e.target.closest('tr');
      row.querySelectorAll('input').forEach(input => unregisterField(input.name));
      row.remove();
    }
  });

  fvAdd = FormValidation.formValidation(form, {
    fields: {
      nombreProveedor: { validators: { notEmpty: { message: 'Por favor, introduce el nombre del proveedor.' } } },
      direccionProveedor: { validators: { notEmpty: { message: 'Por favor, introduce la dirección del proveedor.' } } },
      rfcProveedor: { validators: { notEmpty: { message: 'Por favor, introduce el RFC del proveedor.' } } },
      nombreBanco: { validators: { notEmpty: { message: 'Por favor, introduce el nombre del banco.' } } },
      clabeInterbancaria: {
        validators: {
          notEmpty: { message: 'Por favor, introduce la CLABE.' },
          digits: { message: 'La CLABE debe contener solo dígitos.' }
        }
      },
      selectTipoCompra: { validators: { notEmpty: { message: 'Por favor, selecciona un tipo de compra.' } } }
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

    fetch('/catalogos/proveedores', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    })
      .then(response => {
        if (!response.ok) return response.json().then(err => { throw new Error(JSON.stringify(err)); });
        return response.json();
      })
      .then(data => {
        showAlert('Proveedor agregado correctamente.', 'success');
        bootstrap.Modal.getInstance(document.getElementById('agregarProv'))?.hide();

        clearDynamicFields();
        form.reset();
        fvAdd.resetForm(true);
        addContactRow();
        reloadTableOrPage();
      })
      .catch(error => {
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

  document.getElementById('agregarProv')?.addEventListener('hidden.bs.modal', () => {
    clearDynamicFields();
    registeredFields.clear();
    form.reset();
    fvAdd.resetForm(true);
    addContactRow();
  });

  // Fila inicial al cargar
  addContactRow();
});
