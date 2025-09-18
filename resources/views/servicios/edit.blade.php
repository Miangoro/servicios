@extends('layouts/layoutMaster')

@section('title', 'Editar Servicio')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/select2/select2.scss')
 {{-- {{--@vite('resources/assets/vendor/libs/form-validation/form-validation.scss') --}}
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
    @vite('resources/js/servicios_edit.js')
    @vite('resources/assets/js/forms-selects.js')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title">Editar Servicio</h3>
                </div>
                <div class="card-body">
                    <form id="formEditarServicio" class="row g-5" action="{{ route('servicios.update', $servicio->id_servicio) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- Fila 1: Clave, Clave Adicional, Nombre del Servicio, Precio --}}
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-merge">
                                 <span class="input-group-text"><i class="ri-key-fill"></i></span>
                                 <div class="form-floating form-floating-outline">
                                <input type="text" id="clave" name="clave" class="form-control" placeholder="Ejemplo: CLAVE-001" value="{{ $servicio->clave }}" required/>
                                <label for="clave">Clave</label>
                            </div>
                        </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ri-edit-2-fill"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="claveAdicional" name="clave_adicional" class="form-control" placeholder="Clave adicional" value="{{ $servicio->clave_adicional }}" />
                                    <label for="claveAdicional">Clave adicional</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="nombreServicio" name="nombre" class="form-control" placeholder="Ejemplo: Análisis de Bacillus Subtilis" value="{{ $servicio->nombre }}" />
                                <label for="nombreServicio">Nombre del servicio</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ri-money-dollar-circle-line"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="precio" name="precio" class="form-control" placeholder="Ejemplo: 400.00" readonly value="{{ $servicio->precio }}" />
                                    <label for="precio">Precio</label>
                                </div>
                            </div>
                        </div>

                        {{-- Fila 2: Duración, ¿Se requiere muestra?, Acreditación, Estatus --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="duracion" name="duracion" class="form-control" placeholder=" " value="{{ $servicio->duracion }}" />
                                <label for="duracion">Duración</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="requiereMuestra" name="requiere_muestra" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="">Selecciona una opción</option>
                                    <option value="si" {{ $servicio->id_requiere_muestra == 1 ? 'selected' : '' }}>Sí</option>
                                    <option value="no" {{ $servicio->id_requiere_muestra == 0 ? 'selected' : '' }}>No</option>
                                </select>
                                <label for="requiereMuestra">¿Se requiere muestra?</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="acreditacion" name="acreditacion" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="">Selecciona una opción</option>
                                    <option value="Acreditado" {{ $servicio->id_acreditacion == 1 ? 'selected' : '' }}>Acreditado</option>
                                    <option value="No acreditado" {{ $servicio->id_acreditacion == 0 ? 'selected' : '' }}>No acreditado</option>
                                </select>
                                <label for="acreditacion">Acreditación</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="estatus" name="id_habilitado" class="select form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="1" {{ $servicio->id_habilitado == 1 ? 'selected' : '' }}>Habilitado</option>
                                    <option value="0" {{ $servicio->id_habilitado == 0 ? 'selected' : '' }}>No habilitado</option>
                                </select>
                                <label for="estatus">Estatus</label>
                            </div>
                        </div>

                        {{-- Fila 3: Análisis --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="analisis" name="analisis" class="form-control" placeholder="Ejemplo: Coliformes Totales" value="{{ $servicio->analisis }}" />
                                <label for="analisis">Análisis</label>
                            </div>
                        </div>

                        {{-- Fila 4: Unidades --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="unidades" name="unidades" class="form-control" placeholder="Ejemplo: NMP/100mL" value="{{ $servicio->unidades }}" />
                                <label for='unidades'>Unidades</label>
                            </div>
                        </div>

                        {{-- Fila 5: Nombre de la Acreditación (oculto por defecto) --}}
                        <div class="col-12" id="campoNombreAcreditacion" style="display: {{ $servicio->id_acreditacion == 1 ? 'block' : 'none' }};">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="nombreAcreditacion" name="nombre_acreditacion" class="form-control" placeholder="Nombre de la Acreditación" value="{{ $servicio->nombre_Acreditacion !== '0' ? $servicio->nombre_Acreditacion : '' }}" />
                                <label for="nombreAcreditacion">Nombre de la Acreditación</label>
                            </div>
                        </div>

                        {{-- Fila 6: Descripción de la Acreditación (oculto por defecto) --}}
                        <div class="col-12" id="campoDescripcionAcreditacion" style="display: {{ $servicio->id_acreditacion == 1 ? 'block' : 'none' }};">
                            <div class="form-floating form-floating-outline">
                                <textarea id="descripcionAcreditacion" name="descripcion_acreditacion" class="form-control" placeholder="Descripción de la Acreditación">{{ $servicio->descripcion_Acreditacion !== '0' ? $servicio->descripcion_Acreditacion : '' }}</textarea>
                                <label for="descripcionAcreditacion">Descripción de la Acreditación</label>
                            </div>
                        </div>
                        
                        {{-- Fila 7: Prueba --}}
                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea id="prueba" name="prueba" class="form-control" placeholder="Prueba" required>{{ $servicio->prueba }}</textarea>
                                <label for="prueba">Prueba</label>
                            </div>
                        </div>

                        {{-- Fila 8: Descripción de Muestra --}}
                        <div class="col-12" id="descripcionMuestraField" style="display: {{ $servicio->id_requiere_muestra == 1 ? 'block' : 'none' }};">
                            <div class="form-floating form-floating-outline">
                                <textarea id="descripcionMuestra" name="descripcion_muestra" class="form-control" placeholder="Descripción de Muestra">{{ $servicio->descripcion_Muestra !== '0' ? $servicio->descripcion_Muestra : '' }}</textarea>
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
                                    @if($servicio->url_requisitos && $servicio->url_requisitos != '0')
                                    <div class="mb-3">
                                        <span class="badge bg-success">Archivo actual:</span>
                                        <a href="{{ $servicio->url_requisitos }}" target="_blank" class="ms-2">
                                            {{ basename($servicio->url_requisitos) }}
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2" id="eliminar-archivo-btn">
                                            <i class="ri-delete-bin-line"></i> Eliminar
                                        </button>
                                        <input type="hidden" name="eliminar_archivo" id="eliminar_archivo" value="0">
                                    </div>
                                    @endif
                                    <div class="input-group">
                                        <label class="input-group-text" for="url_requisitos">
                                            <i class="ri-file-text-line"></i>
                                        </label>
                                        <input type="file" class="form-control" id="url_requisitos" name="url_requisitos" accept=".doc,.docx,.pdf">
                                    </div>
                                    <div class="form-text mt-2" id="archivoInfo">
                                        {{ $servicio->url_requisitos && $servicio->url_requisitos != '0' ? 'Seleccione un nuevo archivo para reemplazar el actual' : 'No se ha seleccionado ningún archivo' }}
                                    </div>
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
                                    @php
                                        $laboratoriosAsociados = $servicio->laboratorios;
                                    @endphp
                                    
                                    @if(count($laboratoriosAsociados) > 0)
                                        @foreach ($laboratoriosAsociados as $index => $laboratorio)
                                            <div class="row g-3 mb-3 laboratorio-item align-items-center">
                                                <input type="hidden" name="lab_servicio_ids[]" value="{{ $laboratorio->pivot->id_lab_servicio }}">
                                                <div class="col-12 col-md-5">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="number" step="0.01" min="0" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" value="{{ $laboratorio->pivot->precio }}" required />
                                                        <label class="requerido">Precio</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <div class="form-floating form-floating-outline">
                                                        <select class="form-select select2-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true" required>
                                                            <option value="">Selecciona un laboratorio</option>
                                                            @foreach ($laboratorios as $lab)
                                                                <option value="{{ $lab->id_laboratorio }}" {{ $laboratorio->id_laboratorio == $lab->id_laboratorio ? 'selected' : '' }}>
                                                                    {{ $lab->laboratorio }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label class="requerido">Laboratorio responsable</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2 d-flex justify-content-end">
                                                    @if($index > 0)
                                                        <button type="button" class="btn btn-danger eliminar-laboratorio-btn w-100">
                                                            <i class="ri-subtract-line"></i> Eliminar
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-secondary w-100" disabled>
                                                            <i class="ri-lock-line"></i> Fijo
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row g-3 mb-3 laboratorio-item align-items-center">
                                            <input type="hidden" name="lab_servicio_ids[]" value="new">
                                            <div class="col-12 col-md-5">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="number" step="0.01" min="0" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required />
                                                    <label class="requerido">Precio</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <div class="form-floating form-floating-outline">
                                                    <select class="form-select select2-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true" required>
                                                        <option value="">Selecciona un laboratorio</option>
                                                        @foreach ($laboratorios as $lab)
                                                            <option value="{{ $lab->id_laboratorio }}">{{ $lab->laboratorio }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label class="requerido">Laboratorio responsable</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-2 d-flex justify-content-end">
                                                <button type="button" class="btn btn-secondary w-100" disabled>
                                                    <i class="ri-lock-line"></i> Fijo
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer bg-white rounded-bottom-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-success me-2" id="agregar-laboratorio-btn">
                                            <i class="ri-add-line"></i> Agregar Laboratorio
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Campo para Motivo de edición --}}
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white rounded-top-4 py-3">
                                    <h5 class="fw-bold text-dark mb-0">Motivo de edición</h5>
                                </div>
                                <div class="card-body bg-white py-3">
                                    <div class="form-floating form-floating-outline">
                                        <textarea id="motivo_edicion" name="motivo_edicion" class="form-control" placeholder="Describa el motivo por el cual está editando este servicio" rows="4" required minlength="10"></textarea>
                                        <label for="motivo_edicion" class="requerido">Motivo de edición *</label>
                                    </div>
                                    <div class="form-text">
                                        Por favor, describa detalladamente el motivo por el cual está realizando cambios en este servicio.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-end mt-4">
                            <button type="submit" id="editar-servicio-btn" class="btn btn-primary me-2">
                                <i class="ri-edit-line"></i> Actualizar
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
            const form = document.getElementById('formEditarServicio');
            const precioTotalInput = document.getElementById('precio');
            const requiereMuestraSelect = $('#requiereMuestra');
            const descripcionMuestraField = document.getElementById('descripcionMuestraField');
            
            const acreditacionSelect = $('#acreditacion');
            const campoNombreAcreditacion = document.getElementById('campoNombreAcreditacion');
            const campoDescripcionAcreditacion = document.getElementById('campoDescripcionAcreditacion');

            const agregarLaboratorioBtn = document.getElementById('agregar-laboratorio-btn');
            const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');
            
            // Botón para eliminar archivo
            const eliminarArchivoBtn = document.getElementById('eliminar-archivo-btn');
            const eliminarArchivoInput = document.getElementById('eliminar_archivo');
            
            if (eliminarArchivoBtn) {
                eliminarArchivoBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "El archivo actual será eliminado",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            eliminarArchivoInput.value = '1';
                            document.querySelector('.mb-3 .badge').style.display = 'none';
                            eliminarArchivoBtn.style.display = 'none';
                            Swal.fire(
                                '¡Eliminado!',
                                'El archivo ha sido marcado para eliminación.',
                                'success'
                            );
                        }
                    });
                });
            }

            // Inicializar select2 para TODOS los campos de laboratorio
            function inicializarSelect2Laboratorios() {
                $('.select2-laboratorio').each(function() {
                    // Destruir select2 si ya está inicializado
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2('destroy');
                    }
                    
                    // Inicializar select2
                    $(this).select2({
                        placeholder: 'Selecciona un laboratorio',
                        allowClear: true,
                        width: '100%'
                    });
                    
                    // Forzar la actualización del valor seleccionado
                    const selectedValue = $(this).val();
                    if (selectedValue) {
                        $(this).val(selectedValue).trigger('change.select2');
                    }
                });
            }

            // Inicializar todos los selects de laboratorio al cargar la página
            setTimeout(function() {
                inicializarSelect2Laboratorios();
            }, 300);

            // Control para mostrar el nombre del archivo seleccionado
            const archivoInput = document.getElementById('url_requisitos');
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
                nuevoLaboratorio.classList.add('row', 'g-3', 'mb-3', 'laboratorio-item', 'align-items-center');
                nuevoLaboratorio.innerHTML = `
                    <input type="hidden" name="lab_servicio_ids[]" value="new">
                    <div class="col-12 col-md-5">
                        <div class="form-floating form-floating-outline">
                            <input type="number" step="0.01" min="0" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required />
                            <label class="requerido">Precio</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-floating form-floating-outline">
                            <select class="form-select select2-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true" required>
                                <option value="">Selecciona un laboratorio</option>
                                @foreach ($laboratorios as $laboratorio)
                                    <option value="{{ $laboratorio->id_laboratorio }}">{{ $laboratorio->laboratorio }}</option>
                                @endforeach
                            </select>
                            <label class="requerido">Laboratorio responsable</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-danger eliminar-laboratorio-btn w-100">
                            <i class="ri-subtract-line"></i> Eliminar
                        </button>
                    </div>
                `;
                
                laboratoriosContenedor.appendChild(nuevoLaboratorio);

                // Inicializar Select2 para la nueva fila después de un breve delay
                setTimeout(function() {
                    const selectElement = nuevoLaboratorio.querySelector('.select2-laboratorio');
                    if (selectElement) {
                        $(selectElement).select2({
                            placeholder: 'Selecciona un laboratorio',
                            allowClear: true,
                            width: '100%'
                        });
                    }
                }, 100);

                // Configurar listener para el campo de precio
                const precioInput = nuevoLaboratorio.querySelector('.precio-lab');
                if (precioInput) {
                    precioInput.addEventListener('input', calcularTotal);
                }

                // Configurar listener para el botón de eliminar
                const eliminarBtn = nuevoLaboratorio.querySelector('.eliminar-laboratorio-btn');
                if (eliminarBtn) {
                    eliminarBtn.addEventListener('click', function() {
                        nuevoLaboratorio.remove();
                        calcularTotal();
                    });
                }

                calcularTotal();
            });

            // Configurar listeners para los botones de eliminar existentes
            document.querySelectorAll('.eliminar-laboratorio-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const item = this.closest('.laboratorio-item');
                    if (item) {
                        // Destruir el select2 antes de eliminar el elemento
                        const selectElement = item.querySelector('.select2-laboratorio');
                        if (selectElement) {
                            $(selectElement).select2('destroy');
                        }
                        item.remove();
                        calcularTotal();
                    }
                });
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
                    'prueba',
                    'motivo_edicion' // Agregar motivo_edicion a la validación
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

                // Validar longitud mínima del motivo de edición
                const motivoEdicion = document.getElementById('motivo_edicion');
                if (motivoEdicion && motivoEdicion.value.trim().length < 10) {
                    camposVacios = true;
                    Swal.fire({
                        title: 'Error!',
                        text: 'El motivo de edición debe tener al menos 10 caracteres.',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                    return;
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
                        title: '¿Estás seguro?',
                        text: 'Se actualizará la información del servicio',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, actualizar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
@endsection