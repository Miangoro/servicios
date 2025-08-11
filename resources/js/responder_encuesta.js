document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#formResponderEncuesta'); // tu formulario
    const selectEvaluado = document.querySelector('#a_Evaluar');

    form.addEventListener('submit', function (e) {
        let valid = true;
        let message = '';

        // Validar que se seleccionó un evaluado
        if (!selectEvaluado.value) {
            valid = false;
            message = 'Debe seleccionar a quién evaluar.';
        }

        // Validar cada pregunta
        if (valid) {
            document.querySelectorAll('.pregunta-item').forEach(function (preguntaDiv) {
                const tipo = preguntaDiv.dataset.tipo;
                const inputs = preguntaDiv.querySelectorAll('input, textarea');
                let respondida = false;

                if (tipo === '1') {
                    // Textarea
                    const textarea = preguntaDiv.querySelector('textarea');
                    if (textarea && textarea.value.trim() !== '') {
                        respondida = true;
                    }
                }
                else if (tipo === '2') {
                    // Radio
                    if (preguntaDiv.querySelector('input[type="radio"]:checked')) {
                        respondida = true;
                    }
                }
                else if (tipo === '3') {
                    // Checkbox
                    if (preguntaDiv.querySelectorAll('input[type="checkbox"]:checked').length > 0) {
                        respondida = true;
                    }
                }

                if (!respondida) {
                    valid = false;
                    message = 'Debe responder todas las preguntas antes de enviar.';
                }
            });
        }

        if (!valid) {
            e.preventDefault();
            showAlert(message, 'error');
        }
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
