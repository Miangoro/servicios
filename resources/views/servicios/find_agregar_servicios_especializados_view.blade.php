@extends('layouts/layoutMaster')

@section('title', 'Agregar Nuevo Servicio')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/select2/select2.scss')
    @vite('resources/assets/vendor/libs/animate-css/animate.scss')
    @vite('resources/assets/vendor/libs/sweetalert2/sweetalert2.scss')
    @vite('resources/assets/vendor/libs/spinkit/spinkit.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/select2/select2.js')
    @vite('resources/assets/vendor/libs/sweetalert2/sweetalert2.js')
@endsection

@section('page-script')
    @vite('resources/assets/js/forms-selects.js')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title">Agregar Nuevo Servicio</h3>
                </div>
                <div class="card-body">
                    {{-- Bloque para mostrar errores de validación --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h4><i class="icon ri-alert-fill"></i> ¡Atención!</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="formAgregarServicio" class="row g-5" action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Fila 1: Clave, Clave Adicional, Nombre del Servicio, Precio --}}
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ri-key-2-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="clave" name="clave" class="form-control" placeholder="Clave" readonly />
                                    <label for="clave">Clave (automática)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ri-edit-2-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="claveAdicional" name="clave_adicional" class="form-control" placeholder="Clave adicional" />
                                    <label for="claveAdicional">Clave adicional</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="nombreServicio" name="nombre" class="form-control" placeholder="Ejemplo: Análisis de Bacillus Subtilis" required />
                                <label for="nombreServicio">Nombre del servicio *</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ri-money-dollar-box-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="precio" name="precio" class="form-control" placeholder="Ejemplo: 400.00" readonly required />
                                    <label for="precio">Precio *</label>
                                </div>
                            </div>
                        </div>

                        {{-- Fila 2: Duración, ¿Se requiere muestra?, Acreditación, Estatus --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="duracion" name="duracion" class="form-control" placeholder=" " required />
                                <label for="duracion">Duración *</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="requiereMuestra" name="requiere_muestra" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity" required>
                                    <option value="">Selecciona una opción *</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                                <label for="requiereMuestra">¿Se requiere muestra? *</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="acreditacion" name="acreditacion" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity" required>
                                    <option value="">Selecciona una opción *</option>
                                    <option value="No acreditado">No acreditado</option>
                                    <option value="Acreditado">Acreditado</option>
                                </select>
                                <label for="acreditacion">Acreditación *</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="estatus" name="id_habilitado" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity" required>
                                    <option value="1">Habilitado</option>
                                    <option value="0">No habilitado</option>
                                </select>
                                <label for="estatus">Estatus *</label>
                            </div>
                        </div>

                        {{-- Fila 3: Análisis --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="analisis" name="analisis" class="form-control" placeholder="Ejemplo: Coliformes Totales" required />
                                <label for="analisis">Análisis *</label>
                            </div>
                        </div>

                        {{-- Fila 4: Unidades --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="unidades" name="unidades" class="form-control" placeholder="Ejemplo: NMP/100mL" required />
                                <label for="unidades">Unidades *</label>
                            </div>
                        </div>

                        {{-- Fila 5: Nombre de la Acreditación (oculto por defecto) --}}
                        <div class="col-12" id="campoNombreAcreditacion" style="display: none;">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="nombreAcreditacion" name="nombre_acreditacion" class="form-control" placeholder="Nombre de la Acreditación" />
                                <label for="nombreAcreditacion">Nombre de la Acreditación</label>
                            </div>
                        </div>

                        {{-- Fila 6: Descripción de la Acreditación (oculto por defecto) --}}
                        <div class="col-12" id="campoDescripcionAcreditacion" style="display: none;">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="descripcionAcreditacion" name="descripcion_acreditacion" class="form-control" placeholder="Descripción de la Acreditación" />
                                <label for="descripcionAcreditacion">Descripción de la Acreditación</label>
                            </div>
                        </div>
                        
                        {{-- Fila 7: Prueba --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea id="prueba" name="prueba" class="form-control" placeholder="Prueba" required></textarea>
                                <label for="prueba">Prueba *</label>
                            </div>
                        </div>

                        {{-- Fila 8: Descripción de Muestra --}}
                        <div class="col-12" id="descripcionMuestraField" style="display: none;">
                            <div class="form-floating form-floating-outline">
                                <textarea id="descripcionMuestra" name="descripcion_muestra" class="form-control" placeholder="Descripción de Muestra"></textarea>
                                <label for="descripcionMuestra">Descripción de Muestra</label>
                            </div>
                        </div>

                        {{-- Fila 9: Archivo WORD-PDF de requisitos (Opcional) --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white rounded-top-4 py-3">
                                    <h5 class="fw-bold text-dark mb-0">Archivo WORD-PDF de requisitos (Opcional)</h5>
                                </div>
                                <div class="card-body bg-white py-3">
                                    <div class="input-group">
                                        <label class="input-group-text" for="archivoRequisitos">
                                            <i class="ri-file-text-line"></i>
                                        </label>
                                        <input type="file" class="form-control" id="archivoRequisitos" name="archivo_requisitos" accept=".doc,.docx,.pdf">
                                    </div>
                                    <div class="form-text mt-2" id="archivoInfo">No se ha seleccionado ningún archivo</div>
                                </div>
                            </div>
                        </div>

                        {{-- Sección de Precio por laboratorio --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white rounded-top-4 py-3">
                                    <h5 class="fw-bold text-dark mb-0">Precio por laboratorio *</h5>
                                </div>
                                <div class="card-body bg-white py-3" id="laboratorios-contenedor">
                                    <div class="input-group mb-3 laboratorio-item">
                                        <div class="form-floating form-floating-outline flex-grow-1">
                                            <input type="number" step="0.01" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required/>
                                            <label>Precio *</label>
                                        </div>
                                        <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                                            <select class="form-select select-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true" required>
                                                <option value="">Selecciona un laboratorio *</option>
                                                @foreach ($laboratorios as $laboratorio)
                                                    <option value="{{ $laboratorio->id_laboratorio }}" data-clave="{{ $laboratorio->clave }}">{{ $laboratorio->laboratorio }}</option>
                                                @endforeach
                                            </select>
                                            <label>Laboratorio responsable *</label>
                                        </div>
                                        <button type="button" class="btn btn-danger eliminar-laboratorio-btn ms-2">
                                            <i class="ri-subtract-line"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-footer bg-white rounded-bottom-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-success me-2" id="agregar-laboratorio-btn">
                                            <i class="ri-add-line"></i>
                                        </button>
                                        <span class="fs-5 fw-bold text-dark">Agregar Laboratorio</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <button type="submit" id="agregar-servicio-btn" class="btn btn-primary me-2">
                                <i class="ri-add-line"></i> Agregar
                            </button>
                            <a href="{{ route('servicios.index') }}" class="btn btn-danger">
                                <i class="ri-close-line"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar Select2 en todos los selectores
            $('.select-laboratorio').select({
                placeholder: 'Selecciona un laboratorio',
                allowClear: true,
                width: '100%'
            });

            $('#requiereMuestra, #acreditacion, #estatus').select({
                placeholder: 'Selecciona una opción',
                allowClear: true,
                minimumResultsForSearch: Infinity,
                width: '100%'
            });

            // Lógica para agregar y eliminar campos de "Precio por laboratorio"
            document.getElementById('agregar-laboratorio-btn').addEventListener('click', function() {
                const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');
                const nuevoLaboratorio = document.createElement('div');
                nuevoLaboratorio.classList.add('input-group', 'mb-3', 'laboratorio-item');
                nuevoLaboratorio.innerHTML = `
                    <div class="form-floating form-floating-outline flex-grow-1">
                        <input type="number" step="0.01" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required/>
                        <label>Precio *</label>
                    </div>
                    <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                        <select class="form-select select-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true" required>
                            <option value="">Selecciona un laboratorio *</option>
                            @foreach ($laboratorios as $laboratorio)
                                <option value="{{ $laboratorio->id_laboratorio }}" data-clave="{{ $laboratorio->clave }}">{{ $laboratorio->laboratorio }}</option>
                            @endforeach
                        </select>
                        <label>Laboratorio responsable *</label>
                    </div>
                    <button type="button" class="btn btn-danger eliminar-laboratorio-btn ms-2">
                        <i class="ri-subtract-line"></i>
                    </button>
                `;
                laboratoriosContenedor.appendChild(nuevoLaboratorio);
                
                // Inicializar Select2 en el nuevo select
                $(nuevoLaboratorio).find('.select-laboratorio').select({
                    placeholder: 'Selecciona un laboratorio',
                    allowClear: true,
                    width: '100%'
                });
                
                // Agregar evento para actualizar la clave cuando se seleccione un laboratorio
                $(nuevoLaboratorio).find('.select-laboratorio').on('change', function() {
                    actualizarClave();
                });
                
                calcularTotal();
            });

            document.getElementById('laboratorios-contenedor').addEventListener('click', function(e) {
                if (e.target.closest('.eliminar-laboratorio-btn')) {
                    const item = e.target.closest('.laboratorio-item');
                    if (item && document.querySelectorAll('.laboratorio-item').length > 1) {
                        $(item).find('.select-laboratorio').select('destroy');
                        item.remove();
                        calcularTotal();
                        actualizarClave();
                    } else if (document.querySelectorAll('.laboratorio-item').length === 1) {
                        alert('Debe haber al menos un laboratorio asignado.');
                    }
                }
            });

            // Variables para los elementos del DOM
            const precioTotalInput = document.getElementById('precio');
            const claveInput = document.getElementById('clave');
            const requiereMuestraSelect = $('#requiereMuestra');
            const descripcionMuestraField = document.getElementById('descripcionMuestraField');
            const acreditacionSelect = $('#acreditacion');
            const campoNombreAcreditacion = document.getElementById('campoNombreAcreditacion');
            const campoDescripcionAcreditacion = document.getElementById('campoDescripcionAcreditacion');
            const archivoInput = document.getElementById('archivoRequisitos');
            const archivoInfo = document.getElementById('archivoInfo');
            
            // Evento para el cambio de archivo
            archivoInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    archivoInfo.textContent = this.files[0].name;
                } else {
                    archivoInfo.textContent = 'No se ha seleccionado ningún archivo';
                }
            });

            // Función para mostrar/ocultar el campo de descripción de muestra
            function toggleDescripcionMuestraField() {
                if (requiereMuestraSelect.val() === 'si') {
                    descripcionMuestraField.style.display = 'block';
                    document.getElementById('descripcionMuestra').setAttribute('required', 'required');
                } else {
                    descripcionMuestraField.style.display = 'none';
                    document.getElementById('descripcionMuestra').removeAttribute('required');
                }
            }
            
            // Inicializar y agregar evento para el campo de muestra
            toggleDescripcionMuestraField();
            requiereMuestraSelect.on('change', function() {
                toggleDescripcionMuestraField();
            });

            // Función para mostrar/ocultar campos de acreditación
            function toggleAcreditacionFields() {
                if (acreditacionSelect.val() === 'Acreditado') {
                    campoNombreAcreditacion.style.display = 'block';
                    campoDescripcionAcreditacion.style.display = 'block';
                    document.getElementById('nombreAcreditacion').setAttribute('required', 'required');
                    document.getElementById('descripcionAcreditacion').setAttribute('required', 'required');
                } else {
                    campoNombreAcreditacion.style.display = 'none';
                    campoDescripcionAcreditacion.style.display = 'none';
                    document.getElementById('nombreAcreditacion').removeAttribute('required');
                    document.getElementById('descripcionAcreditacion').removeAttribute('required');
                }
            }
            
            // Inicializar y agregar evento para campos de acreditación
            toggleAcreditacionFields();
            acreditacionSelect.on('change', function() {
                toggleAcreditacionFields();
            });

            // Función para calcular el precio total
            function calcularTotal() {
                let total = 0;
                const preciosLabs = document.querySelectorAll('.precio-lab');
                preciosLabs.forEach(input => {
                    const valor = parseFloat(input.value) || 0;
                    total += valor;
                });
                precioTotalInput.value = total.toFixed(2);
            }

            // Función para actualizar la clave automáticamente
            function actualizarClave() {
                const primerLaboratorioSelect = document.querySelector('.select-laboratorio');
                if (primerLaboratorioSelect && primerLaboratorioSelect.value) {
                    const selectedOption = primerLaboratorioSelect.options[primerLaboratorioSelect.selectedIndex];
                    const claveBase = selectedOption.getAttribute('data-clave');
                    
                    if (claveBase) {
                        // Generar número consecutivo (podrías mejorar esto consultando la BD)
                        const numeroServicios = document.querySelectorAll('.laboratorio-item').length;
                        claveInput.value = `${claveBase}-${numeroServicios}`;
                    }
                } else {
                    claveInput.value = '';
                }
            }

            // Eventos para actualizar el total y la clave
            document.getElementById('laboratorios-contenedor').addEventListener('input', function(e) {
                if (e.target.classList.contains('precio-lab')) {
                    calcularTotal();
                }
            });

            // Evento para actualizar la clave cuando cambia la selección de laboratorio
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('select-laboratorio')) {
                    actualizarClave();
                }
            });

            // Inicializar cálculos
            calcularTotal();
            actualizarClave();
            
            // Validación del formulario antes de enviar
            document.getElementById('formAgregarServicio').addEventListener('submit', function(e) {
                let isValid = true;
                const requiredFields = this.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                // Validar que haya al menos un laboratorio
                const laboratorios = document.querySelectorAll('.select-laboratorio');
                let hasLaboratorio = false;
                
                laboratorios.forEach(select => {
                    if (select.value) {
                        hasLaboratorio = true;
                    }
                });
                
                if (!hasLaboratorio) {
                    isValid = false;
                    alert('Debe asignar al menos un laboratorio responsable.');
                }
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Por favor, complete todos los campos obligatorios.');
                }
            });
        });
    </script>

    <style>
        .is-invalid {
            border-color: #ff3e1d !important;
        }
        .estatus-label.habilitado {
            color: #28a745;
            font-weight: bold;
        }
        .estatus-label.deshabilitado {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
@endsection