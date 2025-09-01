@extends('layouts/layoutMaster')

@section('title', 'Editar Servicio')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/select2/select2.scss')
    @vite('resources/assets/vendor/libs/form-validation/form-validation.scss')
    @vite('resources/assets/vendor/libs/animate-css/animate.scss')
    @vite('resources/assets/vendor/libs/sweetalert2/sweetalert2.scss')
    @vite('resources/assets/vendor/libs/spinkit/spinkit.scss')
    <style>
        .file-preview {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .file-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .file-actions {
            display: flex;
            gap: 10px;
        }
        .laboratorio-item {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
    </style>
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
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Servicios /</span> Editar
        </h4>

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Editar Servicio</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <span class="badge badge-center rounded-pill bg-success me-2"><i class="ri-check-line"></i></span>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <span class="badge badge-center rounded-pill bg-danger me-2"><i class="ri-close-line"></i></span>
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <span class="badge badge-center rounded-pill bg-warning me-2"><i class="ri-error-warning-line"></i></span>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="formEditarServicio" class="row g-4" action="{{ route('servicios.update', $servicio->id_servicio) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id_servicio" value="{{ $servicio->id_servicio }}">

                            <div class="col-12">
                                <h5 class="mb-3">Información General del Servicio</h5>
                                <div class="row g-4">
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="clave" name="clave" class="form-control" placeholder="Clave" value="{{ old('clave', $servicio->clave) }}" required readonly />
                                            <label for="clave">Clave</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="ri-edit-2-line"></i></span>
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="claveAdicional" name="clave_adicional" class="form-control" placeholder="Clave adicional" value="{{ old('clave_adicional', $servicio->clave_adicional) }}" />
                                                <label for="claveAdicional">Clave adicional</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="nombreServicio" name="nombre" class="form-control" placeholder="Ejemplo: Análisis de Bacillus Subtilis" value="{{ old('nombre', $servicio->nombre) }}" required />
                                            <label for="nombreServicio">Nombre del servicio</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="ri-money-dollar-box-line"></i></span>
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="precio" name="precio" class="form-control" placeholder="Ejemplo: 400.00" value="{{ old('precio', $servicio->precio) }}" readonly />
                                                <label for="precio">Precio Total</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="duracion" name="duracion" class="form-control" placeholder=" " value="{{ old('duracion', $servicio->duracion) }}" required />
                                            <label for="duracion">Duración</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="requiereMuestra" name="requiere_muestra" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity" required>
                                                <option value="">Selecciona una opción</option>
                                                <option value="si" {{ old('requiere_muestra', $servicio->id_requiere_muestra ? 'si' : 'no') == 'si' ? 'selected' : '' }}>Sí</option>
                                                <option value="no" {{ old('requiere_muestra', $servicio->id_requiere_muestra ? 'si' : 'no') == 'no' ? 'selected' : '' }}>No</option>
                                            </select>
                                            <label for="requiereMuestra">¿Se requiere muestra?</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="estatus" name="id_habilitado" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity" required>
                                                <option value="1" {{ old('id_habilitado', $servicio->id_habilitado) == 1 ? 'selected' : '' }}>Habilitado</option>
                                                <option value="0" {{ old('id_habilitado', $servicio->id_habilitado) == 0 ? 'selected' : '' }}>No habilitado</option>
                                                <option value="2" {{ old('id_habilitado', $servicio->id_habilitado) == 2 ? 'selected' : '' }}>Observado</option>
                                            </select>
                                            <label for="estatus">Estatus</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="analisis" name="analisis" class="form-control" placeholder="Ejemplo: Coliformes Totales" value="{{ old('analisis', $servicio->analisis) }}" required />
                                            <label for="analisis">Análisis</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="unidades" name="unidades" class="form-control" placeholder="Ejemplo: NMP/100mL" value="{{ old('unidades', $servicio->unidades) }}" required />
                                            <label for='unidades'>Unidades</label>
                                        </div>
                                    </div>
                                    <div class="col-12" id="descripcionMuestraField" style="display: {{ old('requiere_muestra', $servicio->id_requiere_muestra ? 'si' : 'no') == 'si' ? 'block' : 'none' }};">
                                        <div class="form-floating form-floating-outline">
                                            <textarea id="descripcionMuestra" name="descripcion_muestra" class="form-control" placeholder="Descripción de Muestra" style="height: 100px;">{{ old('descripcion_muestra', $servicio->descripcion_Muestra !== '0' ? $servicio->descripcion_Muestra : '') }}</textarea>
                                            <label for="descripcionMuestra">Descripción de Muestra</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="col-12">
                                <h5 class="mb-3">Archivo de requisitos (Opcional)</h5>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="file-upload-container">
                                            @if($servicio->url_requisitos)
                                                <div class="file-preview mb-3">
                                                    <p class="mb-1 fw-bold">Archivo actual:</p>
                                                    <div class="file-info">
                                                        <div>
                                                            <i class="ri-file-text-line me-1"></i>
                                                            <span>{{ basename($servicio->url_requisitos) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <div class="form-floating form-floating-outline">
                                                <input type="file" id="url_requisitos" name="url_requisitos" class="form-control" accept=".doc,.docx,.pdf" />
                                                <label for="url_requisitos">Subir nuevo archivo (WORD o PDF)</label>
                                            </div>
                                            <div class="form-text">Formatos permitidos: .doc, .docx, .pdf. Tamaño máximo: 5MB</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="col-12">
                                <h5 class="mb-3">Información de Acreditación</h5>
                                <div class="row g-4">
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <select id="acreditacion" name="acreditacion" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity" required>
                                                <option value="No acreditado" {{ old('acreditacion', $servicio->id_acreditacion == 1 ? 'Acreditado' : 'No acreditado') == 'No acreditado' ? 'selected' : '' }}>No acreditado</option>
                                                <option value="Acreditado" {{ old('acreditacion', $servicio->id_acreditacion == 1 ? 'Acreditado' : 'No acreditado') == 'Acreditado' ? 'selected' : '' }}>Acreditado</option>
                                            </select>
                                            <label for="acreditacion">Acreditación</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6" id="campoNombreAcreditacion" style="display: {{ old('acreditacion', $servicio->id_acreditacion == 1 ? 'Acreditado' : 'No acreditado') == 'Acreditado' ? 'block' : 'none' }};">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="nombreAcreditacion" name="nombre_acreditacion" class="form-control" placeholder="Nombre de la Acreditación" value="{{ old('nombre_acreditacion', $servicio->nombre_Acreditacion !== '0' ? $servicio->nombre_Acreditacion : '') }}" />
                                            <label for="nombreAcreditacion">Nombre de la Acreditación</label>
                                        </div>
                                    </div>
                                    <div class="col-12" id="campoDescripcionAcreditacion" style="display: {{ old('acreditacion', $servicio->id_acreditacion == 1 ? 'Acreditado' : 'No acreditado') == 'Acreditado' ? 'block' : 'none' }};">
                                        <div class="form-floating form-floating-outline">
                                            <textarea id="descripcionAcreditacion" name="descripcion_acreditacion" class="form-control" placeholder="Descripción de la Acreditación" style="height: 100px;">{{ old('descripcion_acreditacion', $servicio->descripcion_Acreditacion !== '0' ? $servicio->descripcion_Acreditacion : '') }}</textarea>
                                            <label for="descripcionAcreditacion">Descripción de la Acreditación</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating form-floating-outline">
                                            <textarea id="prueba" name="prueba" class="form-control" placeholder="Prueba" required style="height: 100px;">{{ old('prueba', $servicio->prueba) }}</textarea>
                                            <label for="prueba">Prueba</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating form-floating-outline">
                                            <textarea id="motivoEdicion" name="motivo_edicion" class="form-control" placeholder="Motivo de la Edición" required style="height: 80px;">{{ old('motivo_edicion') }}</textarea>
                                            <label for="motivoEdicion">Motivo de la Edición *</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-header bg-white rounded-top-4 py-3">
                                        <h5 class="fw-bold text-dark mb-0">Precio por laboratorio</h5>
                                    </div>
                                    <div class="card-body bg-white py-3" id="laboratorios-contenedor">
                                        @if(count($servicio->laboratorios) > 0)
                                            @foreach ($servicio->laboratorios as $index => $laboratorio)
                                                <div class="row g-3 mb-3 laboratorio-item align-items-center">
                                                    <div class="col-12 col-md-5">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="number" step="0.01" min="0" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" value="{{ $laboratorio->pivot->precio }}" required />
                                                            <label>Precio </label>
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
                                                            <label>Laboratorio responsable *</label>
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
                                                <div class="col-12 col-md-5">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="number" step="0.01" min="0" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required />
                                                        <label>Precio *</label>
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
                                                        <label>Laboratorio responsable *</label>
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
                                            <button type="button" class="btn btn-success me-2" id="agregar-laboratorio-btn-edit">
                                                <i class="ri-add-line"></i> Agregar
                                            </button>
                                            <span class="fs-5 fw-bold text-dark">Agregar Laboratorio</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" id="editar-servicio-btn" class="btn btn-primary me-2">
                                    <i class="ri-save-line"></i> Guardar Cambios
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
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const precioTotalInput = document.getElementById('precio');
        const requiereMuestraSelect = document.getElementById('requiereMuestra');
        const descripcionMuestraField = document.getElementById('descripcionMuestraField');
        const acreditacionSelect = document.getElementById('acreditacion');
        const campoNombreAcreditacion = document.getElementById('campoNombreAcreditacion');
        const campoDescripcionAcreditacion = document.getElementById('campoDescripcionAcreditacion');
        const agregarLaboratorioBtn = document.getElementById('agregar-laboratorio-btn-edit');
        const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');
        const archivoRequisitosInput = document.getElementById('url_requisitos');

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

        // Función para inicializar Select2 y listeners para una fila
        function setupLaboratorioListenersAndSelect2(item) {
            // Inicializar Select2 para el select dentro de la fila
            const selectElement = item.querySelector('.select2-laboratorio');
            if (selectElement) {
                $(selectElement).select2({
                    placeholder: 'Selecciona un laboratorio',
                    allowClear: true,
                    dropdownParent: $(selectElement).parent()
                });
            }

            // Configurar listener para el campo de precio
            const precioInput = item.querySelector('.precio-lab');
            if (precioInput) {
                precioInput.addEventListener('input', calcularTotal);
            }

            // Configurar listener para el botón de eliminar
            const eliminarBtn = item.querySelector('.eliminar-laboratorio-btn');
            if (eliminarBtn) {
                eliminarBtn.addEventListener('click', function() {
                    item.remove();
                    calcularTotal();
                });
            }
        }

        // Inicializar Select2 y listeners para los elementos existentes al cargar la página
        document.querySelectorAll('.laboratorio-item').forEach(item => {
            setupLaboratorioListenersAndSelect2(item);
        });
        calcularTotal();
        
        // Listener para el botón de "Agregar Laboratorio"
        agregarLaboratorioBtn.addEventListener('click', function() {
            const nuevoLaboratorioDiv = document.createElement('div');
            nuevoLaboratorioDiv.classList.add('row', 'g-3', 'mb-3', 'laboratorio-item', 'align-items-center');
            nuevoLaboratorioDiv.innerHTML = `
                <div class="col-12 col-md-5">
                    <div class="form-floating form-floating-outline">
                        <input type="number" step="0.01" min="0" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required />
                        <label>Precio *</label>
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
                        <label>Laboratorio responsable *</label>
                    </div>
                </div>
                <div class="col-12 col-md-2 d-flex justify-content-end">
                    <button type="button" class="btn btn-danger eliminar-laboratorio-btn w-100">
                        <i class="ri-subtract-line"></i> Eliminar
                    </button>
                </div>
            `;
            
            laboratoriosContenedor.appendChild(nuevoLaboratorioDiv);

            // Inicializar Select2 y listeners para la nueva fila
            setupLaboratorioListenersAndSelect2(nuevoLaboratorioDiv);
            
            // Recalcular el total después de agregar un campo
            calcularTotal();
        });

        // Alternar la visibilidad de los campos de muestra
        function toggleDescripcionMuestraField() {
            if (requiereMuestraSelect.value === 'si') {
                descripcionMuestraField.style.display = 'block';
            } else {
                descripcionMuestraField.style.display = 'none';
                document.getElementById('descripcionMuestra').value = '';
            }
        }

        // Alternar la visibilidad de los campos de acreditación
        function toggleAcreditacionFields() {
            if (acreditacionSelect.value === 'Acreditado') {
                campoNombreAcreditacion.style.display = 'block';
                campoDescripcionAcreditacion.style.display = 'block';
            } else {
                campoNombreAcreditacion.style.display = 'none';
                campoDescripcionAcreditacion.style.display = 'none';
                document.getElementById('nombreAcreditacion').value = '';
                document.getElementById('descripcionAcreditacion').value = '';
            }
        }

        // Validar el tipo de archivo al seleccionar
        if (archivoRequisitosInput) {
            archivoRequisitosInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                    const maxSize = 5 * 1024 * 1024; // 5MB
                    
                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tipo de archivo no válido',
                            text: 'Solo se permiten archivos PDF y Word (.doc, .docx)'
                        });
                        this.value = '';
                    } else if (file.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Archivo demasiado grande',
                            text: 'El tamaño máximo permitido es 5MB'
                        });
                        this.value = '';
                    }
                }
            });
        }
        
        // Asigna listeners a los selectores principales
        requiereMuestraSelect.addEventListener('change', toggleDescripcionMuestraField);
        acreditacionSelect.addEventListener('change', toggleAcreditacionFields);

        // Inicializar estados iniciales de los campos
        toggleDescripcionMuestraField();
        toggleAcreditacionFields();
    });
</script>
@endpush