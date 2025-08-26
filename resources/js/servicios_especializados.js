document.addEventListener('DOMContentLoaded', function() {
    // Inicializar select2 en todos los select que tengan la clase .select2
    $('.select2').select2();

    // Lógica para Requisitos
    const requiereMuestraSelect = document.getElementById('requiereMuestra');
    const agregarRequisitoBtn = document.getElementById('agregar-requisito-btn');
    const requisitosContenedor = document.getElementById('requisitos-contenedor');
    const tipoMuestraField = document.getElementById('tipoMuestraField');
    const tipoMuestraInput = document.getElementById('tipoMuestra');

    // La estructura de la fila a clonar
    const filaRequisitoTemplate = `
        <div class="input-group mb-3 requisito-item">
            <div class="form-floating form-floating-outline flex-grow-1">
                <input type="text" class="form-control" name="requisitos[]" placeholder="Requisitos" />
                <label>Requisitos</label>
            </div>
            <button type="button" class="btn btn-danger eliminar-requisito-btn ms-2">
                <i class="ri-subtract-line"></i>
            </button>
        </div>
    `;

    // Función para manejar el estado de los campos de requisitos
    const toggleRequisitos = () => {
        const requiereMuestra = requiereMuestraSelect.value === 'si';
        
        agregarRequisitoBtn.disabled = !requiereMuestra;
        tipoMuestraField.style.display = requiereMuestra ? 'block' : 'none';
        tipoMuestraInput.disabled = !requiereMuestra;

        // Habilitar/deshabilitar los campos de requisitos existentes
        requisitosContenedor.querySelectorAll('input.form-control').forEach(input => {
            input.disabled = !requiereMuestra;
        });
        requisitosContenedor.querySelectorAll('button.eliminar-requisito-btn').forEach(button => {
            button.disabled = !requiereMuestra;
        });

        // Limpiar el valor del campo si se deshabilita
        if (!requiereMuestra) {
            tipoMuestraInput.value = '';
        }
    };

    // Escuchar el evento 'change' en el select2
    $('#requiereMuestra').on('change', function() {
        toggleRequisitos();
    });
    
    // Llamar a la función al cargar la página para establecer el estado inicial correcto
    toggleRequisitos();

    // Lógica para agregar y eliminar campos de requisitos
    agregarRequisitoBtn.addEventListener('click', function() {
        const nuevaFila = document.createRange().createContextualFragment(filaRequisitoTemplate);
        nuevaFila.querySelectorAll('input').forEach(input => {
            input.value = '';
            input.disabled = false; // El nuevo campo debe estar habilitado
        });
        requisitosContenedor.appendChild(nuevaFila);
    });

    requisitosContenedor.addEventListener('click', function(event) {
        if (event.target.classList.contains('eliminar-requisito-btn') || event.target.closest('.eliminar-requisito-btn')) {
            const boton = event.target.closest('.eliminar-requisito-btn');
            const item = boton.closest('.requisito-item');
            if (item) {
                item.remove();
            }
        }
    });

    // Lógica para Laboratorios
    const precioPrincipalInput = document.getElementById('precio');
    const agregarLaboratorioBtn = document.getElementById('agregar-laboratorio-btn');
    const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');
    const formAgregarServicio = document.getElementById('formAgregarServicio');

    // Función para calcular la suma de todos los precios de laboratorio
    const calcularPrecioTotal = () => {
        let total = 0;
        // Selecciona todos los inputs con la clase 'precio-lab'
        document.querySelectorAll('.precio-lab').forEach(input => {
            // Convierte el valor a número, si no es un número, se trata como 0
            const valor = parseFloat(input.value) || 0;
            total += valor;
        });
        // Actualiza el campo de precio principal
        precioPrincipalInput.value = total.toFixed(2);
    };

    // La estructura de la fila a clonar para laboratorios
    const filaLaboratorioTemplate = `
        <div class="input-group mb-3 laboratorio-item">
            <div class="form-floating form-floating-outline flex-grow-1">
                <input type="text" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" />
                <label>Precio *</label>
            </div>
            <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                <select name="laboratorios_responsables[]" class="form-select" data-allow-clear="true">
                    <option value="">Seleccione un laboratorio</option>
                    <option value="Fitopatología">Fitopatología</option>
                </select>
                <label>Laboratorio responsable *</label>
            </div>
            <button type="button" class="btn btn-danger eliminar-laboratorio-btn ms-2">
                <i class="ri-subtract-line"></i>
            </button>
        </div>
    `;

    agregarLaboratorioBtn.addEventListener('click', function() {
        const nuevaFila = document.createRange().createContextualFragment(filaLaboratorioTemplate);
        nuevaFila.querySelectorAll('input').forEach(input => { input.value = ''; });
        nuevaFila.querySelectorAll('select').forEach(select => { select.selectedIndex = 0; });
        laboratoriosContenedor.appendChild(nuevaFila);
        // Volver a inicializar select2 en los nuevos campos
        $(nuevaFila).find('.select2').select2();
        // Recalcular el total después de agregar un campo
        calcularPrecioTotal();
    });

    // Evento para eliminar laboratorio
    laboratoriosContenedor.addEventListener('click', function(event) {
        if (event.target.classList.contains('eliminar-laboratorio-btn') || event.target.closest('.eliminar-laboratorio-btn')) {
            const boton = event.target.closest('.eliminar-laboratorio-btn');
            const item = boton.closest('.laboratorio-item');
            if (item) {
                item.remove();
                // Recalcular el total después de eliminar un campo
                calcularPrecioTotal();
            }
        }
    });

    // Evento para detectar cambios en los campos de precio de laboratorio
    laboratoriosContenedor.addEventListener('input', function(event) {
        if (event.target.classList.contains('precio-lab')) {
            calcularPrecioTotal();
        }
    });

    // Lógica para el campo de Acreditación
    const acreditacionSelect = document.getElementById('acreditacion');
    const metodoField = document.getElementById('metodoField');
    const metodoInput = document.getElementById('metodo');

    // Función para manejar la visibilidad del campo de método
    const toggleMetodo = () => {
        const esAcreditado = acreditacionSelect.value !== 'No acreditado';
        metodoField.style.display = esAcreditado ? 'block' : 'none';
        metodoInput.required = esAcreditado; // Hace el campo requerido si es visible
    };

    // Escuchar el evento 'change' en el select2 de Acreditación
    $('#acreditacion').on('change', function() {
        toggleMetodo();
    });

    // Llamar a la función al cargar la página para establecer el estado inicial correcto
    toggleMetodo();

    calcularPrecioTotal();

    // Lógica de validación del formulario
    formAgregarServicio.addEventListener('submit', function(event) {
        // Campos a validar (puedes agregar o quitar según tus necesidades)
        const camposObligatorios = [
            document.getElementById('clave'),
            document.getElementById('nombreServicio'),
            document.getElementById('precio'),
            document.getElementById('duracion'),
            document.getElementById('requiereMuestra'),
            document.getElementById('estatus'),
            document.getElementById('acreditacion'),
            document.getElementById('analisis'),
            document.getElementById('unidades')
        ];

        let formularioValido = true;

        // Validar campos de texto y select normales
        camposObligatorios.forEach(campo => {
            if (campo.value.trim() === '') {
                formularioValido = false;
                campo.classList.add('is-invalid');
            } else {
                campo.classList.remove('is-invalid');
            }
        });

        // Validar campos de precio por laboratorio
        const preciosLab = document.querySelectorAll('.precio-lab');
        const laboratoriosLab = document.querySelectorAll('select[name="laboratorios_responsables[]"]');
        let laboratoriosValidos = true;

        if (preciosLab.length === 0) {
            laboratoriosValidos = false;
        } else {
            preciosLab.forEach(input => {
                if (input.value.trim() === '') {
                    laboratoriosValidos = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            laboratoriosLab.forEach(select => {
                if (select.value.trim() === '') {
                    laboratoriosValidos = false;
                    // Aquí puedes añadir una clase de error para select2 si lo deseas
                    $(select).next('.select2-container').find('.select2-selection').addClass('is-invalid-select2');
                } else {
                    $(select).next('.select2-container').find('.select2-selection').removeClass('is-invalid-select2');
                }
            });
        }

        if (!laboratoriosValidos) {
            formularioValido = false;
        }

        // Validar el campo de método si es visible
        if (metodoField.style.display !== 'none' && metodoInput.value.trim() === '') {
            metodoInput.classList.add('is-invalid');
            formularioValido = false;
        } else {
            metodoInput.classList.remove('is-invalid');
        }

        if (!formularioValido) {
            event.preventDefault(); // Evita el envío del formulario si la validación falla
        }
    });

    // Se agrega un listener para quitar la clase de error al escribir en los inputs
    formAgregarServicio.addEventListener('input', function(event) {
        if (event.target.classList.contains('form-control') || event.target.classList.contains('form-select')) {
            if (event.target.value.trim() !== '') {
                event.target.classList.remove('is-invalid');
            }
        }
    });
});