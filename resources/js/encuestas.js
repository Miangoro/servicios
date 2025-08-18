$(function () {
  $('.enc_datatable').DataTable({
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
    },
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: '/encuestas',
      type: 'GET'
    },
    dataType: 'json',
    columns: [
      { data: 'DT_RowIndex', name: 'num', orderable: true, searchable: false },
      { data: 'encuesta', name: 'encuesta', searchable: true },
      { data: 'tipo', name: 'tipo', searchable: true },
      { data: 'action', name: 'action', orderable: true, searchable: false }
    ]
  }).on('init.dt', function () {
    var boton = $('#addEncuestaBTN').clone();

    var searchDiv = $('.dataTables_filter');

    // Contenedor con flexbox
    searchDiv.css({
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'right',
      gap: '10px'
    });

    // Mover el botón a la derecha del input de búsqueda
    searchDiv.append(boton);

    // Eliminar el botón original para evitar duplicados
    $('#addEncuestaBTN').remove();
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
  if ($.fn.DataTable.isDataTable('#tablaEncuestas')) {
    $('#tablaEncuestas').DataTable().ajax.reload();
  } else {
    location.reload();
  }
}

// Variable global para mantener un registro del número de preguntas
let questionCounter = document.querySelectorAll('.question-item').length;

window.addQuestion = function() {
    const questionsContainer = document.getElementById('questions-container');
    
    const noQuestionsMessage = document.getElementById('no-questions-message');
    if (noQuestionsMessage) {
        noQuestionsMessage.style.display = 'none';
    }

    const questionTemplate = document.getElementById('question-template').innerHTML;
    const newQuestion = questionTemplate.replace(/QUESTION_INDEX/g, questionCounter);
    
    const div = document.createElement('div');
    div.innerHTML = newQuestion.trim();
    
    const newQuestionElement = div.firstChild;
    newQuestionElement.className = 'question-item border card  rounded m-2 position-relative p-5';
    newQuestionElement.setAttribute('data-question-index', questionCounter);
    
    questionsContainer.appendChild(newQuestionElement);
    
    // contador para la próxima pregunta
    questionCounter++;
    
    updateQuestionNumbers();
}

window.removeQuestion = function (button) {
    const questionItem = button.closest('.question-item');
    questionItem.remove();
    updateQuestionNumbers();
};

function updateQuestionNumbers() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((question, index) => {
        // actualiza el número visible de la pregunta
        const label = question.querySelector('h3');
        if (label) {
            label.textContent = `Pregunta ${index + 1}`;
        }
        
        // actualiza los atributos 'name' y 'data-question-index'
        const inputs = question.querySelectorAll('input, select, textarea, button');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name && name.includes('questions[')) {
                const newName = name.replace(/questions\[\d+\]/, `questions[${index}]`);
                input.setAttribute('name', newName);
            }
        });

        // actualiza el data-question-index en el contenedor
        question.setAttribute('data-question-index', index);
    });
}

window.changeQuestionType = function(select) {
    const questionItem = select.closest('.question-item');
    const optionsContainer = questionItem.querySelector('.options-container');
    const questionIndex = questionItem.getAttribute('data-question-index');

    if (select.value === '1') { // Pregunta Abierta
        optionsContainer.style.display = 'none';
    } else {
        optionsContainer.style.display = 'block';

        // Verifica si el options-list existe antes de añadir opciones
        let optionsList = optionsContainer.querySelector('.options-list');
        if (!optionsList) {
            // Si no, lo crea
            const newOptionsListHtml = `
                <div class="d-flex flex-column m-5 col-md-12">
                    <div class="row">
                        <h5 class="">Opciones de Respuesta</h5>
                    </div>
                    <div class="options-list d-flex flex-column col-md-12"></div>
                    <div class="col-md-12 d-flex flex-row">
                        <button type="button" 
                                onclick="addOption(this.closest('.question-item'))"
                                class="add-new btn btn-text-info waves-effect">
                            <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                            Agregar Opción
                        </button>
                    </div>
                </div>
            `;
            optionsContainer.innerHTML = newOptionsListHtml;
            optionsList = optionsContainer.querySelector('.options-list');
        }

        // Si la lista está vacía, añadimos una opción por defecto
        if (optionsList.children.length === 0) {
            addOption(questionItem);
        }
    }
    updatePreview(questionItem);
}

window.addOption = function(questionItem) {
    // verifica que optionsList exista antes de continuar
    const optionsList = questionItem.querySelector('.options-list');
    if (!optionsList) {
        // En caso de que no exista, salimos de la función o mostramos un error
        console.error("El contenedor de opciones no existe para esta pregunta.");
        return;
    }
    
    const questionIndex = questionItem.getAttribute('data-question-index');
    const optionIndex = optionsList.children.length;

    const optionTemplate = `
        <div class="d-flex justify-content-center gap-2 m-2 option-item">
            <input type="text"
                    name="questions[${questionIndex}][options][]" 
                    placeholder="Opción ${optionIndex + 1}"
                    class="form-control"
                    oninput="updatePreview(this.closest('.question-item'))">
            <button type="button" 
                    onclick="removeOption(this)"
                    class="btn btn-icon btn-danger">
                <i class="ri-delete-bin-2-fill"></i>
            </button>
        </div>
    `;

    optionsList.insertAdjacentHTML('beforeend', optionTemplate);
    updatePreview(questionItem);
}

window.removeOption = function (button) {
    const optionItem = button.closest('.option-item');
    const questionItem = button.closest('.question-item');
    optionItem.remove();
    updatePreview(questionItem);
};

window.updatePreview = function (questionItem) {
    const questionText = questionItem.querySelector('textarea[name*="question_text"]').value;
    const questionType = questionItem.querySelector('select[name*="question_type"]').value;
    const options = Array.from(questionItem.querySelectorAll('input[name*="options"]'))
        .map(input => input.value)
        .filter(val => val.trim());

    const previewContainer = questionItem.querySelector('.preview-container');

    if (!questionText.trim()) {
        previewContainer.innerHTML = '';
        return;
    }
    
    let previewHtml = `
        <div class="card-footer bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium mb-3">Vista previa:</h4>
            <p class="mb-3">${questionText}</p>
    `;

    if (questionType === '1') { // Abierta
        previewHtml +=
            '<textarea placeholder="Respuesta del usuario..." disabled rows="2" class="form-control bg-gray-100"></textarea>';
    } else if (questionType === '2' && options.length > 0) { // Cerrada (Radio)
        options.forEach((option, index) => {
            previewHtml += `
                <div class="form-check">
                    <input type="radio" disabled id="preview_radio_${questionItem.getAttribute('data-question-index')}_${index}" name="preview_radio_${questionItem.getAttribute('data-question-index')}" class="form-check-input">
                    <label class="form-check-label" for="preview_radio_${questionItem.getAttribute('data-question-index')}_${index}">${option}</label>
                </div>
            `;
        });
    } else if (questionType === '3' && options.length > 0) { // Múltiple (Checkbox)
        options.forEach((option, index) => {
            previewHtml += `
                <div class="form-check">
                    <input type="checkbox" disabled id="preview_check_${questionItem.getAttribute('data-question-index')}_${index}" class="form-check-input">
                    <label class="form-check-label" for="preview_check_${questionItem.getAttribute('data-question-index')}_${index}">${option}</label>
                </div>
            `;
        });
    }

    previewHtml += '</div>';
    previewContainer.innerHTML = previewHtml;
}

  //pantalla de carga
  const loadingSpinner = document.getElementById('loading-spinner');

  //boton de crear encuesta
  const openModalBtn = document.getElementById('addEncuestaBTN');

  openModalBtn.addEventListener('click', () => {
    // 1. Mostrar el spinner
    loadingSpinner.classList.remove('d-none');
    
    // 2. Simular una carga de datos con setTimeout (aquí pondrías tu llamada AJAX)
    setTimeout(() => {
        // 3. Ocultar el spinner después de que los datos "cargaron"
        loadingSpinner.classList.add('d-none');
        
        // 4. Abrir el modal
        myModal.show();
    }, 2000); // 2000 milisegundos = 2 segundos
});


document.addEventListener('DOMContentLoaded', function () {
  updateQuestionNumbers();
  document.querySelectorAll('.question-item').forEach(updatePreview);

  const form = document.getElementById('encuestaForm');

  if (form) {
    form.addEventListener('submit', function (e) {
      const errors = [];

      // Validar título y tipo de encuesta
      const title = form.querySelector('#title');
      const type = form.querySelector('#target_type');

      if (!title.value.trim()) {
        errors.push('El título de la encuesta es obligatorio.');
      }

      if (!type.value) {
        errors.push('Debe seleccionar un tipo de evaluación.');
      }

      // Validar preguntas
      const questions = form.querySelectorAll('.question-item');
      if (questions.length === 0) {
        errors.push('Debe agregar al menos una pregunta.');
      }

      questions.forEach((question, index) => {
        const questionText = question.querySelector('textarea[name*="[question_text]"]');
        const questionType = question.querySelector('select[name*="[question_type]"]');
        
        if (!questionText || !questionText.value.trim()) {
          errors.push(`La Pregunta ${index + 1} no debe estar vacía.`);
        }

        // Validar opciones si aplica
        if (questionType && questionType.value !== '1') {
          const options = question.querySelectorAll('input[name*="[options][]"]');
          if (options.length === 0) {
            errors.push(`La Pregunta ${index + 1} debe tener al menos una opción.`);
          } else {
            options.forEach((opt, i) => {
              if (!opt.value.trim()) {
                errors.push(`La opción ${i + 1} de la Pregunta ${index + 1} está vacía.`);
              }
            });
          }
        }
      });

      if (errors.length > 0) {
        e.preventDefault();

        Swal.fire({
          icon: 'error',
          title: 'Errores en el formulario',
          html: `<ul style="text-align:left;">${errors.map(e => `<li>${e}</li>`).join('')}</ul>`,
          confirmButtonText: 'Corregir',
          customClass: {
            popup: 'text-start',
            confirmButton: 'btn btn-primary me-3',
          }
        });
      }else{
        var timerInterval;
        Swal.fire({
          title: 'Guardando encuesta',
          html: '',
          timer: 5000,
        customClass: {
        },
        buttonsStyling: true,
          willOpen: function () {
            Swal.showLoading();
            timerInterval = setInterval(function () {
              Swal.getHtmlContainer().querySelector('strong').textContent = Swal.getTimerLeft();
            }, 100);
          },
          willClose: function () {
            clearInterval(timerInterval);
          }
        }).then(function (result) {
        });
      }
    });
  }
});
