@extends('layouts/layoutMaster')

@section('title', 'Agregar Nuevo Servicio')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/select2/select2.scss')
    @vite('resources/assets/vendor/libs/form-validation/form-validation.scss')
    @vite('resources/assets/vendor/libs/animate-css/animate.scss')
    @vite('resources/assets/vendor/libs/sweetalert2/sweetalert2.scss')
    @vite('resources/assets/vendor/libs/spinkit/spinkit.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/select2/select2.js')
    @vite('resources/assets/vendor/libs/form-validation/form-validation.js')
    @vite('resources/assets/vendor/libs/form-validation/auto-focus.js')
    @vite('resources/assets/vendor/libs/sweetalert2/sweetalert2.js')
@endsection

@section('page-script')
    @vite('resources/js/servicios_create.js')
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
                    <form id="formAgregarServicio" class="row g-5" action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Fila 1: Clave, Clave Adicional, Nombre del Servicio, Precio --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="clave" name="clave" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="">Selecciona una clave</option>
                                    @foreach ($claves as $clave)
                                        <option value="{{ $clave->clave }}" data-nombre-lab="{{ $clave->laboratorio }}" data-id-lab="{{ $clave->id_laboratorio }}">
                                            {{ $clave->clave }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="clave">Clave</label>
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
                                <input type="text" id="nombreServicio" name="nombre" class="form-control" placeholder="Ejemplo: Análisis de Bacillus Subtilis" />
                                <label for="nombreServicio">Nombre del servicio</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ri-money-dollar-box-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="precio" name="precio" class="form-control" placeholder="Ejemplo: 400.00" readonly />
                                    <label for="precio">Precio</label>
                                </div>
                            </div>
                        </div>

                        {{-- Fila 2: Duración, ¿Se requiere muestra?, Acreditación, Estatus --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="duracion" name="duracion" class="form-control" placeholder=" " />
                                <label for="duracion">Duración</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="requiereMuestra" name="requiere_muestra" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="">Selecciona una opción</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                                <label for="requiereMuestra">¿Se requiere muestra?</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="acreditacion" name="acreditacion" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="">Selecciona una opción</option>
                                    <option value="No acreditado">No acreditado</option>
                                    <option value="Acreditado">Acreditado</option>
                                </select>
                                <label for="acreditacion">Acreditación</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="estatus" name="id_habilitado" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="1">Habilitado</option>
                                    <option value="0">No habilitado</option>
                                </select>
                                <label for="estatus">Estatus</label>
                            </div>
                        </div>

                        {{-- Fila 3: Análisis --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="analisis" name="analisis" class="form-control" placeholder="Ejemplo: Coliformes Totales" />
                                <label for="analisis">Análisis</label>
                            </div>
                        </div>

                        {{-- Fila 4: Unidades --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="unidades" name="unidades" class="form-control" placeholder="Ejemplo: NMP/100mL" />
                                <label for="unidades">Unidades</label>
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
                                <label for="prueba">Prueba</label>
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
                                    <h5 class="fw-bold text-dark mb-0">Precio por laboratorio</h5>
                                </div>
                                <div class="card-body bg-white py-3" id="laboratorios-contenedor">
                                    <div class="input-group mb-3 laboratorio-item">
                                        <div class="form-floating form-floating-outline flex-grow-1">
                                            <input type="text" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" />
                                            <label>Precio *</label>
                                        </div>
                                        <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                                            <select class="form-select select-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true">
                                                <option value="">Selecciona un laboratorio</option>
                                                @foreach ($laboratorios as $laboratorio)
                                                    <option value="{{ $laboratorio->id_laboratorio }}">{{ $laboratorio->laboratorio }}</option>
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
            const form = document.getElementById('formAgregarServicio');
            const claveSelect = $('#clave');
            const precioTotalInput = document.getElementById('precio');
            const requiereMuestraSelect = $('#requiereMuestra');
            const descripcionMuestraField = document.getElementById('descripcionMuestraField');
           
            const acreditacionSelect = $('#acreditacion');
            const campoNombreAcreditacion = document.getElementById('campoNombreAcreditacion');
            const campoDescripcionAcreditacion = document.getElementById('campoDescripcionAcreditacion');

            const agregarLaboratorioBtn = document.getElementById('agregar-laboratorio-btn');
            const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');
           
            // Inicializar select2 para TODOS los campos de laboratorio (incluyendo el primero)
            function inicializarSelect2Laboratorios() {
                $('.select2-laboratorio').select2({
                    placeholder: 'Selecciona un laboratorio',
                    allowClear: true,
                    width: '100%'
                });
            }
            
            // Inicializar todos los selects de laboratorio al cargar la página
            inicializarSelect2Laboratorios();

            // Control para mostrar el nombre del archivo seleccionado
            const archivoInput = document.getElementById('archivoRequisitos');
            const archivoInfo = document.getElementById('archivoInfo');
           
            archivoInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    archivoInfo.textContent = this.files[0].name;
                } else {
                    archivoInfo.textContent = 'No se ha seleccionado ningún archivo';
                }
            });

            // Lógica para mostrar/ocultar el campo "Descripción de Muestra"
            function toggleDescripcionMuestraField() {
                if (requiereMuestraSelect.val() === 'si') {
                    descripcionMuestraField.style.display = 'block';
                } else {
                    descripcionMuestraField.style.display = 'none';
                }
            }
            toggleDescripcionMuestraField();
            requiereMuestraSelect.on('change.select2', function() {
                toggleDescripcionMuestraField();
            });

            // Lógica para mostrar/ocultar los campos de acreditación
            function toggleAcreditacionFields() {
                if (acreditacionSelect.val() === 'Acreditado') {
                    campoNombreAcreditacion.style.display = 'block';
                    campoDescripcionAcreditacion.style.display = 'block';
                } else {
                    campoNombreAcreditacion.style.display = 'none';
                    campoDescripcionAcreditacion.style.display = 'none';
                }
            }
            toggleAcreditacionFields();
            acreditacionSelect.on('change.select2', function() {
                toggleAcreditacionFields();
            });

            // Lógica de suma para los precios
            function calcularTotal() {
                let total = 0;
                const preciosLabs = document.querySelectorAll('.precio-lab');
                preciosLabs.forEach(input => {
                    const valor = parseFloat(input.value) || 0;
                    total += valor;
                });
                precioTotalInput.value = total.toFixed(2);
            }

            laboratoriosContenedor.addEventListener('input', function(e) {
                if (e.target.classList.contains('precio-lab')) {
                    calcularTotal();
                }
            });

            // Lógica para agregar y eliminar campos de "Precio por laboratorio"
            agregarLaboratorioBtn.addEventListener('click', function() {
                const nuevoLaboratorio = document.createElement('div');
                nuevoLaboratorio.classList.add('input-group', 'mb-3', 'laboratorio-item');
                nuevoLaboratorio.innerHTML = `
                    <div class="form-floating form-floating-outline flex-grow-1">
                        <input type="text" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" />
                        <label>Precio *</label>
                    </div>
                    <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                        <select class="form-select select2-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true">
                            <option value="">Selecciona un laboratorio</option>
                            @foreach ($laboratorios as $laboratorio)
                                <option value="{{ $laboratorio->id_laboratorio }}">{{ $laboratorio->laboratorio }}</option>
                            @endforeach
                        </select>
                        <label>Laboratorio responsable *</label>
                    </div>
                    <button type="button" class="btn btn-danger eliminar-laboratorio-btn ms-2">
                        <i class="ri-subtract-line"></i>
                    </button>
                `;
                laboratoriosContenedor.appendChild(nuevoLaboratorio);

                // Inicializar el nuevo select2
                $(nuevoLaboratorio).find('.select2-laboratorio').select2({
                    placeholder: 'Selecciona un laboratorio',
                    allowClear: true,
                    width: '100%'
                });

                calcularTotal();
            });

            laboratoriosContenedor.addEventListener('click', function(e) {
                if (e.target.closest('.eliminar-laboratorio-btn')) {
                    const item = e.target.closest('.laboratorio-item');
                    if (item) {
                        // Destruir el select2 antes de eliminar el elemento
                        $(item).find('.select2-laboratorio').select2('destroy');
                        item.remove();
                        calcularTotal();
                    }
                }
            });

            calcularTotal();

            // Lógica de validación y mensajes del formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let camposVacios = false;
                const camposRequeridos = [
                    'clave',
                    'nombre',
                    'duracion',
                    'requiere_muestra',
                    'analisis',
                    'unidades',
                    'prueba'
                ];
               
                // Validar campos principales
                camposRequeridos.forEach(campo => {
                    const input = document.querySelector(`[name="${campo}"]`);
                    if (input && !input.value.trim()) {
                        camposVacios = true;
                    }
                });

                // Validar el campo de "Descripción de Muestra" si es visible
                if (requiereMuestraSelect.val() === 'si') {
                    const descripcionMuestra = document.getElementById('descripcionMuestra');
                    if (!descripcionMuestra.value.trim()) {
                        camposVacios = true;
                    }
                }

                // Validar campos de acreditación si están visibles
                if (acreditacionSelect.val() === 'Acreditado') {
                    const nombreAcreditacion = document.getElementById('nombreAcreditacion');
                    const descripcionAcreditacion = document.getElementById('descripcionAcreditacion');
                    if (!nombreAcreditacion.value || !descripcionAcreditacion.value) {
                        camposVacios = true;
                    }
                }

                // Validar campos de laboratorios
                const preciosLab = document.querySelectorAll('.precio-lab');
                const laboratoriosResp = document.querySelectorAll('[name="laboratorios_responsables[]"]');
                if (preciosLab.length === 0) {
                    camposVacios = true;
                } else {
                    for (let i = 0; i < preciosLab.length; i++) {
                        if (!preciosLab[i].value.trim() || !laboratoriosResp[i].value.trim()) {
                            camposVacios = true;
                            break;
                        }
                    }
                }

                // Mostrar mensajes de alerta
                if (camposVacios) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Faltan campos por llenar.',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                } else {
                    // Si todo está lleno, enviar el formulario
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'Servicio agregado correctamente.',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        },
                        buttonsStyling: false
                    }).then(() => {
                        form.submit();
                    });
                }
            });
        });
    </script>
@endsection