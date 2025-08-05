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

        function addQuestion() {
            questionCounter++;
            const questionsContainer = document.getElementById('questions-container');
            const questionTemplate = document.getElementById('question-template').innerHTML;
            const newQuestion = questionTemplate.replace(/QUESTION_INDEX/g, questionCounter);
            
            const div = document.createElement('div');
            div.innerHTML = newQuestion;
            div.className = 'question-item';
            div.setAttribute('data-question-index', questionCounter);
            
            questionsContainer.appendChild(div);
            updateQuestionNumbers();
        }

        function removeQuestion(button) {
            const questionItem = button.closest('.question-item');
            questionItem.remove();
            updateQuestionNumbers();
        }

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

        function changeQuestionType(select) {
            const questionItem = select.closest('.question-item');
            const optionsContainer = questionItem.querySelector('.options-container');
            const previewContainer = questionItem.querySelector('.preview-container');
            
            if (select.value === 'open') {
                optionsContainer.style.display = 'none';
                optionsContainer.innerHTML = '';
            } else {
                optionsContainer.style.display = 'block';
                if (optionsContainer.children.length === 0) {
                    addOption(questionItem);
                }
            }
            updatePreview(questionItem);
        }

        function addOption(questionItem) {
            const optionsContainer = questionItem.querySelector('.options-container .options-list');
            const questionIndex = questionItem.getAttribute('data-question-index');
            const optionIndex = optionsContainer.children.length;
            
            const optionHtml = `
                <div class="flex items-center gap-2 option-item">
                    <input type="text" 
                           name="questions[${questionIndex}][options][]" 
                           placeholder="Opción ${optionIndex + 1}"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           onchange="updatePreview(this.closest('.question-item'))">
                    <button type="button" 
                            onclick="removeOption(this)"
                            class="px-3 py-2 text-red-600 hover:text-red-700 hover:bg-red-50 border border-red-300 rounded-md">
                        ✕
                    </button>
                </div>
            `;
            
            optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
        }

        function removeOption(button) {
            const optionItem = button.closest('.option-item');
            const questionItem = button.closest('.question-item');
            optionItem.remove();
            updatePreview(questionItem);
        }

        function updatePreview(questionItem) {
            const questionText = questionItem.querySelector('textarea[name*="question_text"]').value;
            const questionType = questionItem.querySelector('select[name*="question_type"]').value;
            const options = Array.from(questionItem.querySelectorAll('input[name*="options"]')).map(input => input.value).filter(val => val.trim());
            
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
                previewHtml += '<textarea placeholder="Respuesta del usuario..." disabled rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"></textarea>';
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
        document.addEventListener('DOMContentLoaded', function() {
            // Actualizar previews existentes
            document.querySelectorAll('.question-item').forEach(updatePreview);
        });