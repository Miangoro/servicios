$(function () {
  $('.enc_datatable').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
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
      { data: 'encuesta', name: 'Nombre de la encuesta', searchable: true },
      { data: 'tipo', name: 'Tipo', searchable: true },
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
  if ($.fn.DataTable.isDataTable('#tablaEncuestas')) {
    $('#tablaEncuestas').DataTable().ajax.reload();
  } else {
    location.reload();
  }
}

// Funciones JavaScript para manejo dinámico
let questionCounter = 0;

window.addQuestion = function() {
    questionCounter++;
    
    const questionsContainer = document.getElementById('questions-container');
    
    const noQuestionsMessage = document.getElementById('no-questions-message');
    if (noQuestionsMessage) {
        noQuestionsMessage.style.display = 'none';
    }

    const questionTemplate = document.getElementById('question-template').innerHTML;
    const newQuestion = questionTemplate.replace(/QUESTION_INDEX/g, questionCounter);
    
    const div = document.createElement('div');
    div.innerHTML = newQuestion;
    div.className = 'question-item';
    div.setAttribute('data-question-index', questionCounter);
    
    questionsContainer.appendChild(div);
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
    const label = question.querySelector('.question-number');
    if (label) {
      label.textContent = `Pregunta ${index + 1}`;
    }

    // Actualizar nombres de los inputs
    const inputs = question.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
      const name = input.getAttribute('name');
      if (name && name.includes('questions[')) {
        const newName = name.replace(/questions\[\d+\]/, `questions[${index}]`);
        input.setAttribute('name', newName);
      }
    });
  });
}

window.changeQuestionType = function(select) {
    const questionItem = select.closest('.question-item');
    const optionsContainer = questionItem.querySelector('.options-container');
    const previewContainer = questionItem.querySelector('.preview-container');

    if (select.value === 'open') {
        optionsContainer.style.display = 'none';
        optionsContainer.innerHTML = ''; // Esto es lo que causa el problema
    } else {
        optionsContainer.style.display = 'block';

        // Solución: Asegurarnos de que options-list existe antes de añadir opciones
        let optionsList = optionsContainer.querySelector('.options-list');
        if (!optionsList) {
            // Si no existe, creamos el HTML necesario
            optionsContainer.innerHTML = `
                <div class="d-flex flex-column m-5 col-md-12">
                    <div class="row">
                        <h5 class="">
                            Opciones de Respuesta
                        </h5>
                    </div>
                    <div class="options-list d-flex flex-column col-md-12"></div>
                    <div class="col-md-12 d-flex flex-row align-items-center justify-content-center">
                        <button type="button" 
                                onclick="addOption(this.closest('.question-item'))"
                                class="add-new btn rounded-pill btn-outline-primary waves-effect waves-light">
                            <i class="ri-add-line ri-16px me-0 me-sm-2 align-baseline"></i>
                            Agregar Opción
                        </button>
                    </div>
                </div>
            `;
            optionsList = optionsContainer.querySelector('.options-list');
        }

        if (optionsList.children.length === 0) {
            addOption(questionItem);
        }
    }
    updatePreview(questionItem);
}

window.addOption = function(questionItem) {
    const optionsContainer = questionItem.querySelector('.options-container .options-list');
    const questionIndex = questionItem.getAttribute('data-question-index');
    const optionIndex = optionsContainer.children.length;

    const optionHtml = `
        <div class="d-flex flex-row align-items-center col-md-11 m-2 option-item">
            <input type="text" 
                   name="questions[${questionIndex}][options][]" 
                   placeholder="Opción ${optionIndex + 1}"
                   class="form-control col-md-8"
                   onchange="updatePreview(this.closest('.question-item'))">
            <button type="button" 
                    onclick="removeOption(this)"
                    class="btn btn-icon btn-outline-danger col-md-2 m-2">
                X
            </button>
        </div>
    `;
    
    optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
    updatePreview(questionItem);
}

window.removeOption = function (button) {
  const optionItem = button.closest('.option-item');
  const questionItem = button.closest('.question-item');
  optionItem.remove();
  updatePreview(questionItem);
};

function updatePreview(questionItem) {
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
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-medium mb-3">Vista previa:</h4>
                    <p class="mb-3">${questionText}</p>
            `;

  if (questionType === 'open') {
    previewHtml +=
      '<textarea placeholder="Respuesta del usuario..." disabled rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"></textarea>';
  } else if (questionType === 'closed' && options.length > 0) {
    options.forEach((option, index) => {
      previewHtml += `
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="radio" disabled id="preview_radio_${questionItem.getAttribute('data-question-index')}_${index}">
                            <label for="preview_radio_${questionItem.getAttribute('data-question-index')}_${index}">${option}</label>
                        </div>
                    `;
    });
  } else if (questionType === 'multiple' && options.length > 0) {
    options.forEach((option, index) => {
      previewHtml += `
                        <div class="flex items-center space-x-2 mb-2">
                            <input type="checkbox" disabled id="preview_check_${questionItem.getAttribute('data-question-index')}_${index}">
                            <label for="preview_check_${questionItem.getAttribute('data-question-index')}_${index}">${option}</label>
                        </div>
                    `;
    });
  }

  previewHtml += '</div>';
  previewContainer.innerHTML = previewHtml;
}

// Inicializar eventos cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
  // Actualizar previews existentes
  document.querySelectorAll('.question-item').forEach(updatePreview);
});
