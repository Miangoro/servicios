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
      { data: 'DT_RowIndex', name: 'num', orderable: true, searchable: false },
      { data: 'razon_social', name: 'Razón Social', searchable: true },
      { data: 'direccion', name: 'Dirección', searchable: true },
      { data: 'rfc', name: 'RFC',  searchable: true  },
      { data: 'Datos Bancarios', name: 'Datos Bancarios', orderable: false, searchable: true },
      { data: 'Contacto', name: 'Contacto', orderable: false, searchable: true },
      { data: 'tipo', name: 'Tipo de Compra', searchable: true  },
      { data: 'Evaluacion del Proveedor', name: 'Evaluación del Proveedor', orderable: false, searchable: true },
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

/**
 * Abre el modal de edición y carga los datos del proveedor.
 * @param {number} id - El ID del proveedor a editar.
 */
window.editProveedor = function(id) {
    fetch(`/proveedores/${id}/edit`)
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(JSON.stringify(errorData));
                });
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('id_proveedor_edit').value = data.id_proveedor;
            document.getElementById('nombre_Proveedor_Edit').value = data.razon_social;
            document.getElementById('direccion_Proveedor_Edit').value = data.direccion;
            document.getElementById('rfc_Proveedor_Edit').value = data.rfc;
            document.getElementById('n_Banco_Edit').value = data.n_banco;
            document.getElementById('clabe_Interbancaria_Edit').value = data.clave;
            document.getElementById('url_Adjunto_Edit').value = '';
            document.getElementById('select_Tipo_Compra_Edit').value = data.tipo;

            // Lógica para poblar la tabla de contactos
            const contactosBody = document.querySelector('#editContactosTable tbody');
            const editForm = document.getElementById('editarProveedorForm');
            contactosBody.innerHTML = '';
            editForm.querySelectorAll('input[name="contactos_eliminados[]"]').forEach(input => input.remove());

            if (data.contactos && data.contactos.length > 0) {
                data.contactos.forEach(contacto => {
                    const row = document.createElement('tr');
                    row.dataset.contactId = contacto.id_contacto; 
                    row.innerHTML = `
                        <td><input type="text" class="form-control" name="contactos_edit[${contacto.id_contacto}][nombre]" value="${contacto.contacto}"></td>
                        <td><input type="text" class="form-control" name="contactos_edit[${contacto.id_contacto}][telefono]" value="${contacto.telefono}"></td>
                        <td><input type="email" class="form-control" name="contactos_edit[${contacto.id_contacto}][email]" value="${contacto.correo || ''}"></td>
                        <td><button type="button" class="btn btn-danger remove-contact-row-edit">X</button></td>
                    `;
                    contactosBody.appendChild(row);
                });
            }

            var editModal = new bootstrap.Modal(document.getElementById('EditProv'));
            editModal.show();
        })
        .catch(error => {
            console.error('Error al obtener los datos del proveedor:', error);
            showAlert('No se pudo cargar la información del proveedor.', 'error');
        });
}

function resetEditModal() {
    const form = document.getElementById('editarProveedorForm');
    if (!form) return;

    const title = document.getElementById('editarProveedorText');
    if (title) title.textContent = 'Editar Proveedor';

    form.querySelectorAll('input, select').forEach(el => {
        el.removeAttribute('readonly');
        el.removeAttribute('disabled');
    });

    const addBtn = document.getElementById('EditContactRow');
    const saveBtn = document.getElementById('EditProveedorSubmit');
    if (addBtn) addBtn.classList.remove('d-none');
    if (saveBtn) saveBtn.classList.remove('d-none');

    const cancelBtn = document.getElementById('cancelarBtn');
    if (cancelBtn) cancelBtn.textContent = 'Cancelar';

    const contactosBody = document.querySelector('#editContactosTable tbody');
    if (contactosBody) contactosBody.innerHTML = '';
}

/**
 * Abre el modal en modo de "solo visualización".
 * Deshabilita campos y oculta botones de acción.
 * @param {number} id - El ID del proveedor a visualizar.
 */
window.visualizar = function(id) {
    fetch(`/proveedores/${id}/edit`)
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(JSON.stringify(errorData));
                });
            }
            return response.json();
        })
        .then(data => {
            resetEditModal();

            document.getElementById('editarProveedorText').textContent = 'Visualizar Proveedor';
            document.getElementById('cancelarBtn').textContent = 'Cerrar';

            document.getElementById('EditContactRow').classList.add('d-none');
            document.getElementById('EditProveedorSubmit').classList.add('d-none');

            document.getElementById('id_proveedor_edit').value = data.id_proveedor;
            document.getElementById('nombre_Proveedor_Edit').value = data.razon_social;
            document.getElementById('direccion_Proveedor_Edit').value = data.direccion;
            document.getElementById('rfc_Proveedor_Edit').value = data.rfc;
            document.getElementById('n_Banco_Edit').value = data.n_banco;
            document.getElementById('clabe_Interbancaria_Edit').value = data.clave;
            document.getElementById('url_Adjunto_Edit').value = "";
            document.getElementById('select_Tipo_Compra_Edit').value = data.tipo;

            const form = document.getElementById('editarProveedorForm');
            form.querySelectorAll('input').forEach(input => input.setAttribute('readonly', true));
            form.querySelector('select').setAttribute('disabled', true);

            const contactosBody = document.querySelector('#editContactosTable tbody');
            contactosBody.innerHTML = '';

            if (data.contactos && data.contactos.length > 0) {
                data.contactos.forEach(contacto => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><input type="text" class="form-control" value="${contacto.contacto}" readonly></td>
                        <td><input type="text" class="form-control" value="${contacto.telefono}" readonly></td>
                        <td><input type="email" class="form-control" value="${contacto.correo || ''}" readonly></td>
                        <td></td> <!-- Columna de acción vacía -->
                    `;
                    contactosBody.appendChild(row);
                });
            }

            // Muestra el modal
            const editModal = new bootstrap.Modal(document.getElementById('EditProv'));
            editModal.show();
        })
        .catch(error => {
            console.error('Error al obtener los datos del proveedor:', error);
            showAlert('No se pudo cargar la información del proveedor.', 'error');
        });
}


document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('agregarProveedorForm');
  const contactosBody = document.querySelector('#contactosTable tbody');
  const addRowBtn = document.getElementById('addContactRow');
  let fvAdd;
  const registeredFields = new Set();

  const editModalEl = document.getElementById('EditProv');
    if (editModalEl) {
        // Asigna la función de reseteo al evento 'hidden.bs.modal'
        editModalEl.addEventListener('hidden.bs.modal', resetEditModal);
  }

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

  window.deleteProv = function(id) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-danger me-3',
                cancelButton: 'btn btn-outline-secondary'
            },
            buttonsStyling: false
        }).then(function(result) {
            if (result.value) {
                fetch(`/proveedores/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
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
                        showAlert(data.message, 'success');
                        reloadTableOrPage();
                    })
                    .catch(error => {
                        console.error('Error al eliminar el proveedor:', error);
                        let errorMessage = 'Error al eliminar el proveedor. Por favor, intente de nuevo.';
                        try {
                            const parsedError = JSON.parse(error.message);
                            if (parsedError.error) {
                                errorMessage = 'Error del servidor: ' + parsedError.error;
                            }
                        } catch (e) { /* ignore */ }
                        showAlert(errorMessage, 'error');
                    });
            }
        });
    } else {
        if (confirm('¿Estás seguro de que quieres eliminar este proveedor? Esta acción no se puede deshacer.')) {
            fetch(`/proveedores/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
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
                    showAlert(data.message, 'success');
                    reloadTableOrPage();
                })
                .catch(error => {
                    console.error('Error al eliminar el proveedor:', error);
                    let errorMessage = 'Error al eliminar el proveedor. Por favor, intente de nuevo.';
                    try {
                        const parsedError = JSON.parse(error.message);
                        if (parsedError.error) {
                            errorMessage = 'Error del servidor: ' + parsedError.error;
                        }
                    } catch (e) { /* ignore */ }
                    showAlert(errorMessage, 'error');
                });
        }
    }
}

  document.getElementById('agregarProv')?.addEventListener('hidden.bs.modal', () => {
    clearDynamicFields();
    registeredFields.clear();
    form.reset();
    fvAdd.resetForm(true);
    addContactRow();
  });

  // Fila inicial al cargar
  addContactRow();

  // Lógica para el modal de edición de proveedores
  const editContactosTable = document.querySelector('#editContactosTable');
    if (editContactosTable) {
        const editContactosBody = editContactosTable.querySelector('tbody');
        const addRowBtnEdit = document.getElementById('EditContactRow');
        const editForm = document.getElementById('editarProveedorForm');

        const addContactRowEdit = () => {
            const newIndex = 'new_' + Date.now(); // Índice único para nuevos contactos
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" class="form-control" name="contactos_nuevos[${newIndex}][nombre]" placeholder="Nombre" required></td>
                <td><input type="text" class="form-control" name="contactos_nuevos[${newIndex}][telefono]" placeholder="Teléfono" required></td>
                <td><input type="email" class="form-control" name="contactos_nuevos[${newIndex}][email]" placeholder="Email" required></td>
                <td><button type="button" class="btn btn-danger remove-contact-row-edit">X</button></td>
            `;
            editContactosBody.appendChild(row);
        };

        // Asigna el evento click al botón de agregar en el modal de edición
        addRowBtnEdit?.addEventListener('click', addContactRowEdit);

        // remover contactos en el modal de edición
        editContactosBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-contact-row-edit') || e.target.closest('.remove-contact-row-edit')) {
                const button = e.target.closest('.remove-contact-row-edit');
                const row = button.closest('tr');
                const contactId = row.dataset.contactId;

                // Si la fila corresponde a un contacto existente (tiene data-contact-id)
                if (contactId) {
                    //input hidden para notificar al backend que debe eliminar este contacto
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'contactos_eliminados[]';
                    hiddenInput.value = contactId;
                    editForm.appendChild(hiddenInput);
                }

                // Elimina la fila de la vista
                row.remove();
            }
        });
    }

    //LÓGICA DE ENVÍO DEL FORMULARIO DE EDICIÓN
    const editForm = document.getElementById('editarProveedorForm');

    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const proveedorId = document.getElementById('id_proveedor_edit').value;
            const formData = new FormData(editForm);
            
            fetch(`/proveedores/${proveedorId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
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
                showAlert('Proveedor actualizado correctamente.', 'success');
                const editModal = bootstrap.Modal.getInstance(document.getElementById('EditProv'));
                editModal.hide();
                $('.prov_datatable').DataTable().ajax.reload();
            })
            .catch(error => {
                console.error('Error al actualizar el proveedor:', error);
                let errorMessage = 'No se pudo actualizar el proveedor. Intente de nuevo.';
                
                 try {
                    const parsedError = JSON.parse(error.message);
                    if (parsedError.message) {
                        errorMessage = parsedError.message;
                    }
                 } catch (e) { /* No hacer nada si no es JSON */ }

                showAlert(errorMessage, 'error');
            });
        });
    }


});

window.verGraficas = function () {

  window.location.href = "{{ route('proveedores.graficas') }}";

  // Color Variables
  const purpleColor = '#836AF9',
    yellowColor = '#ffe800',
    cyanColor = '#28dac6',
    orangeColor = '#FF8132',
    orangeLightColor = '#ffcf5c',
    oceanBlueColor = '#299AFF',
    greyColor = '#4F5D70',
    greyLightColor = '#EDF1F4',
    blueColor = '#2B9AFF',
    blueLightColor = '#84D0FF';

  let cardColor, headingColor, labelColor, borderColor, legendColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    labelColor = config.colors_dark.textMuted;
    legendColor = config.colors_dark.bodyColor;
    borderColor = config.colors_dark.borderColor;
  } else {
    cardColor = config.colors.cardColor;
    headingColor = config.colors.headingColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
  }


// Set height according to their data-height
  // --------------------------------------------------------------------
  const chartList = document.querySelectorAll('.chartjs');
  chartList.forEach(function (chartListItem) {
    chartListItem.height = chartListItem.dataset.height;
  });

  // Bar Chart
  // --------------------------------------------------------------------
  const barChart = document.getElementById('barChart');
  if (barChart) {
    const barChartVar = new Chart(barChart, {
      type: 'bar',
      data: {
        labels: [
          '7/12',
          '8/12',
          '9/12',
          '10/12',
          '11/12',
          '12/12',
          '13/12',
          '14/12',
          '15/12',
          '16/12',
          '17/12',
          '18/12',
          '19/12'
        ],
        datasets: [
          {
            data: [275, 90, 190, 205, 125, 85, 55, 87, 127, 150, 230, 280, 190],
            backgroundColor: orangeLightColor,
            borderColor: 'transparent',
            maxBarThickness: 15,
            borderRadius: {
              topRight: 15,
              topLeft: 15
            }
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 500
        },
        plugins: {
          tooltip: {
            rtl: isRtl,
            backgroundColor: cardColor,
            titleColor: headingColor,
            bodyColor: legendColor,
            borderWidth: 1,
            borderColor: borderColor
          },
          legend: {
            display: false
          }
        },
        scales: {
          x: {
            grid: {
              color: borderColor,
              drawBorder: false,
              borderColor: borderColor
            },
            ticks: {
              color: labelColor
            }
          },
          y: {
            min: 0,
            max: 400,
            grid: {
              color: borderColor,
              drawBorder: false,
              borderColor: borderColor
            },
            ticks: {
              stepSize: 100,
              color: labelColor
            }
          }
        }
      }
    });
  }
}