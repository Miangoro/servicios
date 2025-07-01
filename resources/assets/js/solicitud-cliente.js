document.addEventListener('DOMContentLoaded', function () {

  const mezcalCheckbox = document.getElementById('customRadioIcon1');
  const bebidaCheckbox = document.getElementById('customRadioIcon2');
  const coctelCheckbox = document.getElementById('customRadioIcon3');
  const licorCheckbox = document.getElementById('customRadioIcon4');
  const nom070Checkbox = document.getElementById('customRadioIcon5');
  const nom251Checkbox = document.getElementById('customRadioIcon6');
  const normexCheckbox = document.getElementById('customRadioIcon7');
  const norm199Checkbox = document.getElementById('customRadioIcon68');
  const otrabebida = document.getElementById('customRadioIcon65');

  const checkboxes = [
    mezcalCheckbox, bebidaCheckbox, coctelCheckbox, licorCheckbox,
    nom070Checkbox, nom251Checkbox, normexCheckbox, norm199Checkbox, otrabebida
  ];

  function updateBorder(checkbox) {
    const parentDiv = checkbox.closest('.custom-option');
    if (checkbox.checked) {
      parentDiv.classList.add('active');
      // Asegúrate de que el borde sea el color del botón en el tema actual
      parentDiv.style.borderColor = getComputedStyle(document.body).getPropertyValue('--primary-color').trim();
    } else {
      parentDiv.classList.remove('active');
      parentDiv.style.borderColor = ''; // Eliminar el color de borde si no está activo
    }
  }


  function mostrarSecciones() {

    console.log('mezcalCheckbox:', mezcalCheckbox.checked);
    console.log('bebidaCheckbox:', bebidaCheckbox.checked);
    console.log('coctelCheckbox:', coctelCheckbox.checked);
    console.log('licorCheckbox:', licorCheckbox.checked);
    console.log('norm199Checkbox:', norm199Checkbox.checked);


    // Asignar el estado de los checkboxes de normas basado en otros checkboxes
    nom070Checkbox.checked = mezcalCheckbox.checked; // NMX-V-052-NORMEX-2016
    nom251Checkbox.checked = bebidaCheckbox.checked || coctelCheckbox.checked || licorCheckbox.checked; // NMX-V-251-SCFI-2015
    norm199Checkbox.checked = otrabebida.checked; // Marcar norm199Checkbox si se selecciona Otras bebidas
    normexCheckbox.checked = otrabebida.checked || (bebidaCheckbox.checked || coctelCheckbox.checked || licorCheckbox.checked);


    updateBorder(nom070Checkbox);
    updateBorder(nom251Checkbox);
    updateBorder(normexCheckbox);
    updateBorder(norm199Checkbox);

    toggleSectionVisibility('nom070-section', nom070Checkbox.checked);
    toggleSectionVisibility('normex-section', normexCheckbox.checked);

  }

  function toggleSectionVisibility(sectionId, shouldShow) {
    let section = document.getElementById(sectionId);
    if (section) {
      section.style.display = shouldShow ? 'block' : 'none';
    } else if (shouldShow) {
      section = (sectionId === 'nom070-section') ? crearNOM070Section() : crearNormexSection();
      const socialLinks = document.getElementById('social-links');
      socialLinks.insertBefore(section, socialLinks.lastElementChild);
      section.querySelectorAll('.form-check-input').forEach(input => {
        input.addEventListener('change', function () {
          updateBorder(input);
        });
      });
    }
  }

  function mostrarRepresentante() {
    const regimen = document.getElementById("regimen").value;
    const representante = document.getElementById('representante');
    const nombreRepresentante = document.getElementById('nombreRepresentante');

    if (regimen === "Persona moral") {
      representante.style.display = "block";
      nombreRepresentante.setAttribute("required", "required");
    } else {
      representante.style.display = "none";
      nombreRepresentante.removeAttribute("required");
    }
  }

  function crearNormexSection() {
    const normexSection = document.createElement('div');
    normexSection.id = 'normex-section';

    normexSection.innerHTML = `
          <h6 class="my-4">Actividad del cliente NMX-V-052-NORMEX-2016:</h6>
          <div class="row gy-3 align-items-start">
              <div class="col-md">
                  <div class="form-check custom-option custom-option-icon">
                      <label class="form-check-label custom-option-content" for="customRadioIcon12">
                          <span class="custom-option-body">
                              <i class="ri-ink-bottle-fill"></i>
                              <small>Productor de bebidas alcohólicas que contienen Mezcal</small>
                          </span>
                          <input name="actividad[]" class="form-check-input" type="checkbox" value="5" id="customRadioIcon12" />
                      </label>
                  </div>
              </div>
              <div class="col-md">
                  <div class="form-check custom-option custom-option-icon">
                      <label class="form-check-label custom-option-content" for="customRadioIcon13">
                          <span class="custom-option-body">
                              <i class="ri-ink-bottle-fill"></i>
                              <small>Envasador de bebidas alcohólicas que contienen Mezcal</small>
                          </span>
                          <input name="actividad[]" class="form-check-input" type="checkbox" value="6" id="customRadioIcon13" />
                      </label>
                  </div>
              </div>
              <div class="col-md">
                  <div class="form-check custom-option custom-option-icon">
                      <label class="form-check-label custom-option-content" for="customRadioIcon15">
                          <span class="custom-option-body">
                              <i class="ri-ink-bottle-fill"></i>
                              <small>Comercializador de bebidas alcohólicas que contienen Mezcal</small>
                          </span>
                          <input name="actividad[]" class="form-check-input" type="checkbox" value="7" id="customRadioIcon15" />
                      </label>
                  </div>
              </div>
          </div>
          <hr>
      `;
    return normexSection;
  }

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function () {
      updateBorder(checkbox);
      mostrarSecciones();
    });
  });

  document.getElementById('regimen').addEventListener('change', mostrarRepresentante);

  mostrarSecciones();

  // Sección del switch
  const switchInput = document.querySelector('.switch-input');
  const localidad1 = document.getElementById('localidad1');
  const estado = document.getElementById('estado');

  function copyAddress() {
    const addressContainers = [
      document.getElementById('domiProductAgace'),
      document.getElementById('domiEnvasaMezcal'),
      document.getElementById('domiProductMezcal'),
      document.getElementById('domiComerMezcal')
    ];

    addressContainers.forEach(container => {
      const localidadInput = container.querySelector('input[type="text"]');
      const estadoSelect = container.querySelector('select');

      if (switchInput.checked) {
        if (localidadInput) localidadInput.value = localidad1.value;
        if (estadoSelect) estadoSelect.value = estado.value;
      } else {
        if (localidadInput) localidadInput.value = '';
        if (estadoSelect) estadoSelect.selectedIndex = 0;
      }
    });
  }

  switchInput.addEventListener('change', copyAddress);
});

// Resto del código para wizard y Cleave sigue aquí...

window.estadosOptions = `
    @foreach ($estados as $estado)
        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
    @endforeach
`;

import Stepper from 'bs-stepper/dist/js/bs-stepper';

const bsStepper = document.querySelectorAll('.bs-stepper');

// Adds crossed class
bsStepper.forEach(el => {
  el.addEventListener('show.bs-stepper', function (event) {
    var index = event.detail.indexStep;
    var numberOfSteps = el.querySelectorAll('.line').length;
    var line = el.querySelectorAll('.step');

    for (let i = 0; i < index; i++) {
      line[i].classList.add('crossed');
      for (let j = index; j < numberOfSteps; j++) {
        line[j].classList.remove('crossed');
      }
    }
    if (event.detail.to == 0) {
      for (let k = index; k < numberOfSteps; k++) {
        line[k].classList.remove('crossed');
      }
      line[0].classList.remove('crossed');
    }
  });
});

try {
  window.Stepper = Stepper;
} catch (e) { }

export { Stepper };


document.addEventListener('DOMContentLoaded', function () {

  const wizard = document.querySelector('.wizard-icons-example');
  if (!wizard) return;
  const stepper = new Stepper(wizard, { linear: true, animation: true });
  const form = wizard.querySelector('form');

  // PASO 1: Información del cliente
  const fvStep1 = FormValidation.formValidation(
    document.getElementById('account-details'),
    {
      fields: {
        regimen: { validators: { notEmpty: { message: 'Por favor selecciona un régimen' } } },
        rfc: {
          validators: {
            notEmpty: { message: 'Por favor ingresa el RFC' },
            stringLength: {
              min: 12,
              max: 13,
              message: 'El RFC debe tener 12 o 13 caracteres'
            }
          }
        },
        razon_social: { validators: { notEmpty: { message: 'Por favor ingresa el nombre' } } },
        correo: {
          validators: {
            notEmpty: { message: 'Por favor ingresa el correo' },
            emailAddress: { message: 'Correo inválido' }
          }
        },
        telefono: {
          validators: {
            notEmpty: { message: 'Por favor ingresa el teléfono' },
            callback: {
              message: 'El teléfono debe tener 10 dígitos numéricos',
              callback: function (input) {
                // Elimina todos los caracteres que no sean dígitos
                const digits = (input.value || '').replace(/\D/g, '');
                return digits.length === 10;
              }
            }
          }
        },
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: ''
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }
  ).on('core.form.valid', function () {
    stepper.next();
  });

  // PASO 2: Producto a certificar
  const fvStep2 = FormValidation.formValidation(
    document.getElementById('social-links'),
    {
      fields: {
        'producto[]': { validators: { notEmpty: { message: 'Por favor selecciona al menos un producto' } } },
        // Puedes agregar más validaciones si lo necesitas
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: ''
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }
  ).on('core.form.valid', function () {
    stepper.next();
  });

  // PASO 3: Domicilio Fiscal
  const fvStep3 = FormValidation.formValidation(
    document.getElementById('address'),
    {
      fields: {
        domicilio_fiscal: { validators: { notEmpty: { message: 'Por favor ingresa el domicilio fiscal' } } },
        estado_fiscal: { validators: { notEmpty: { message: 'Por favor selecciona un estado' } } }
        // Puedes agregar más validaciones para los domicilios adicionales si son requeridos
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: ''
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }
  ).on('core.form.valid', function () {
    stepper.next();
  });

  // PASO 4: Información sobre los procesos y productos
  const fvStep4 = FormValidation.formValidation(
    document.getElementById('personal-info-icon'),
    {
      fields: {
        certificacion: { validators: { notEmpty: { message: 'Por favor selecciona una opción' } } },
        info_procesos: { validators: { notEmpty: { message: 'Por favor describe los procesos' } } }
        // Puedes agregar más validaciones si lo necesitas
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: ''
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }
  ).on('core.form.valid', function () {
    form.submit();
  });

  // Botones de navegación
  const btnNextList = wizard.querySelectorAll('.btn-next');
  btnNextList.forEach(btn => {
    btn.addEventListener('click', function (event) {
      event.preventDefault();
      switch (stepper._currentIndex) {
        case 0: fvStep1.validate(); break;
        case 1: fvStep2.validate(); break;
        case 2: fvStep3.validate(); break;
        case 3: fvStep4.validate(); break;
      }
    });
  });

  const btnPrevList = wizard.querySelectorAll('.btn-prev');
  btnPrevList.forEach(btn => {
    btn.addEventListener('click', function () {
      stepper.previous();
    });
  });
  // ...existing code...

  // Validar antes de enviar en el último paso
  const btnSubmit = wizard.querySelector('.btn-submit');
  if (btnSubmit) {
    btnSubmit.addEventListener('click', function (event) {
      event.preventDefault();
      fvStep4.validate();
    });
  }
});


// ...existing code...
new Cleave(".phone-number-mask", {
  phone: true,
  phoneRegionCode: "US"
});

document.addEventListener('DOMContentLoaded', () => {
  function toggleSection() {
    // Obtener el estado de cada checkbox
    const agaveCheckbox = document.getElementById('customRadioIcon8');
    const envasadorCheckbox = document.getElementById('customRadioIcon9');
    const productorMezcalCheckbox = document.getElementById('customRadioIcon10');
    const comercializadorCheckbox = document.getElementById('customRadioIcon11');
    const norm199Checkbox = document.getElementById('customRadioIcon68');
    const otrasBebidasCheckbox = document.getElementById('customRadioIcon65');
    const nom070Checkbox = document.getElementById('customRadioIcon5');

    // Mostrar u ocultar secciones basadas en los checkboxes seleccionados
    const domiProductAgace = document.getElementById('domiProductAgace');
    if (domiProductAgace && agaveCheckbox) {
      domiProductAgace.style.display = agaveCheckbox.checked ? 'block' : 'none';
      if (!agaveCheckbox.checked) {
        domiProductAgace.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
        domiProductAgace.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
      }
    }
    const domiEnvasaMezcal = document.getElementById('domiEnvasaMezcal');
    if (domiEnvasaMezcal && envasadorCheckbox) {
      domiEnvasaMezcal.style.display = envasadorCheckbox.checked ? 'block' : 'none';
      if (!envasadorCheckbox.checked) {
        domiEnvasaMezcal.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
        domiEnvasaMezcal.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
      }
    }
    const domiProductMezcal = document.getElementById('domiProductMezcal');
    if (domiProductMezcal && productorMezcalCheckbox) {
      domiProductMezcal.style.display = productorMezcalCheckbox.checked ? 'block' : 'none';
      if (!productorMezcalCheckbox.checked) {
        domiProductMezcal.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
        domiProductMezcal.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
      }
    }
    const domiComerMezcal = document.getElementById('domiComerMezcal');
    if (domiComerMezcal && comercializadorCheckbox) {
      domiComerMezcal.style.display = comercializadorCheckbox.checked ? 'block' : 'none';
      if (!comercializadorCheckbox.checked) {
        domiComerMezcal.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
        domiComerMezcal.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
      }
    }

    // Lógica para mostrar u ocultar la sección específica
    const nom199Section = document.getElementById('nom199-section');
    if (nom199Section && (norm199Checkbox || otrasBebidasCheckbox)) {
      if ((norm199Checkbox && norm199Checkbox.checked) || (otrasBebidasCheckbox && otrasBebidasCheckbox.checked)) {
        nom199Section.classList.remove('d-none');
      } else {
        nom199Section.classList.add('d-none');
      }
    }

    // Lógica para mostrar/ocultar la sección de NMX-V-052-NORMEX-2016
    const normexSection = document.getElementById('normex-section');
    if (normexSection && (nom070Checkbox || norm199Checkbox || otrasBebidasCheckbox)) {
      if (
        (nom070Checkbox && nom070Checkbox.checked) ||
        (norm199Checkbox && norm199Checkbox.checked) ||
        (otrasBebidasCheckbox && otrasBebidasCheckbox.checked)
      ) {
        normexSection.classList.add('d-none');
      } else {
        normexSection.classList.remove('d-none');
      }
    }
  }

  // Añadir event listeners a los checkboxes (solo si existen)
  ['customRadioIcon8', 'customRadioIcon9', 'customRadioIcon10', 'customRadioIcon11', 'customRadioIcon68', 'customRadioIcon65'].forEach(id => {
    const checkbox = document.getElementById(id);
    if (checkbox) {
      checkbox.addEventListener('change', toggleSection);
    }
  });

  // Inicializa el estado de las secciones al cargar la página
  toggleSection();
});


/* seccion del switch */

document.addEventListener('DOMContentLoaded', () => {
  const switchInput = document.querySelector('.switch-input');
  const localidad1 = document.getElementById('localidad1');
  const estado = document.getElementById('estado');

  // Función para copiar los datos del primer domicilio a las secciones visibles
  function copyAddress() {
    // Obtener todos los contenedores de domicilio fiscal
    const addressContainers = [
      document.getElementById('domiProductAgace'),
      document.getElementById('domiEnvasaMezcal'),
      document.getElementById('domiProductMezcal'),
      document.getElementById('domiComerMezcal')
    ];

    if (switchInput.checked) {
      // Copiar datos si el switch está marcado
      addressContainers.forEach(container => {
        if (container.style.display !== 'none') {
          const localidadInput = container.querySelector('input[type="text"]');
          const estadoSelect = container.querySelector('select');

          if (localidadInput && estadoSelect) {
            localidadInput.value = localidad1.value;
            estadoSelect.value = estado.value;
          }
        }
      });
    } else {
      // Vaciar campos si el switch no está marcado
      addressContainers.forEach(container => {
        if (container.style.display !== 'none') {
          const localidadInput = container.querySelector('input[type="text"]');
          const estadoSelect = container.querySelector('select');

          if (localidadInput && estadoSelect) {
            localidadInput.value = '';
            estadoSelect.selectedIndex = 0; // Resetea la selección del <select>
          }
        }
      });
    }
  }

  // Escuchar cambios en el switch
  switchInput.addEventListener('change', copyAddress);
});


$(document).ready(function () {
  // Mapeamos los valores de los checkboxes a sus respectivas secciones
  const sections = {
    1: '#clasificacion-bebidas-section',     // Bebidas Alcohólicas Fermentadas (2% a 20%)
    2: '#clasificacion-bebidas-section-2',   // Bebidas Alcohólicas Destiladas (32% a 55%)
    3: '#clasificacion-bebidas-section-3',   // Licores o cremas (13.5% a 55%)
    4: '#clasificacion-bebidas-section-4',   // Bebidas Alcohólicas Destiladas (32% a 55%)
    5: '#clasificacion-cocteles-section-5',    // Cócteles (12% a 32%)
    6: '#clasificacion-bebidas-section-6'
  };

  // Escuchar el cambio en los checkboxes
  $('input[name="clasificacion[]"]').on('change', function () {
    // Recorremos cada sección y la mostramos u ocultamos dependiendo del checkbox seleccionado
    $.each(sections, function (value, section) {
      // Si el checkbox con el valor 'value' está seleccionado, mostramos la sección
      if ($(`input[name="clasificacion[]"][value="${value}"]`).is(':checked')) {
        $(section).removeClass('d-none');
      } else {
        // Si no está seleccionado, ocultamos la sección
        $(section).addClass('d-none');
      }
    });
  });

});


$(document).ready(function () {
  $('#customRadioIcon32').on('change', function () {
    if ($(this).is(':checked')) {
      $('#otroBebidaInput').slideDown(); // Animación para mostrar
    } else {
      $('#otroBebidaInput').slideUp(function () {
        $(this).find('input').val(''); // Limpia después de ocultar
      });
    }
  });

  $('#customRadioIcon52').on('change', function () {
    if ($(this).is(':checked')) {
      $('#otroBebidaInput52').slideDown();
    } else {
      $('#otroBebidaInput52').slideUp(function () {
        $(this).find('input').val('');
      });
    }
  });
});




