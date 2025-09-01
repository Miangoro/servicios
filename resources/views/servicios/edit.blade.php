@extends('layouts/layoutMaster')

@section('title', 'Editar Servicio')

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
                                            <label for="unidades">Unidades</label>
                                        </div>
                                    </div>
                                    <div class="col-12" id="descripcionMuestraField" style="display: {{ old('requiere_muestra', $servicio->id_requiere_muestra ? 'si' : 'no') == 'si' ? 'block' : 'none' }};">
                                        <div class="form-floating form-floating-outline">
                                            <textarea id="descripcionMuestra" name="descripcion_muestra" class="form-control" placeholder="Descripción de Muestra" style="height: 100px;">{{ old('descripcion_muestra', $servicio->descripcion_muestra !== '0' ? $servicio->descripcion_muestra : '') }}</textarea>
                                            <label for="descripcionMuestra">Descripción de Muestra</label>
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
                                            <input type="text" id="nombreAcreditacion" name="nombre_acreditacion" class="form-control" placeholder="Nombre de la Acreditación" value="{{ old('nombre_acreditacion', $servicio->nombre_acreditacion !== '0' ? $servicio->nombre_acreditacion : '') }}" />
                                            <label for="nombreAcreditacion">Nombre de la Acreditación</label>
                                        </div>
                                    </div>
                                    <div class="col-12" id="campoDescripcionAcreditacion" style="display: {{ old('acreditacion', $servicio->id_acreditacion == 1 ? 'Acreditado' : 'No acreditado') == 'Acreditado' ? 'block' : 'none' }};">
                                        <div class="form-floating form-floating-outline">
                                            <textarea id="descripcionAcreditacion" name="descripcion_acreditacion" class="form-control" placeholder="Descripción de la Acreditación" style="height: 100px;">{{ old('descripcion_acreditacion', $servicio->descripcion_acreditacion !== '0' ? $servicio->descripcion_acreditacion : '') }}</textarea>
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
                                        @foreach ($servicio->laboratorios as $laboratorio)
                                            <div class="row g-3 mb-3 laboratorio-item align-items-center">
                                                <div class="col-12 col-md-5">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="number" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" value="{{ $laboratorio->pivot->precio }}" required />
                                                        <label>Precio *</label>
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
                                                        <label for="select2-laboratorio">Laboratorio responsable *</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-2 d-flex justify-content-end">
                                                    <button type="button" class="btn btn-danger eliminar-laboratorio-btn w-100">
                                                        <i class="ri-subtract-line"></i> Eliminar
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
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
        const requiereMuestraSelect = $('#requiereMuestra');
        const descripcionMuestraField = document.getElementById('descripcionMuestraField');
        const acreditacionSelect = $('#acreditacion');
        const campoNombreAcreditacion = document.getElementById('campoNombreAcreditacion');
        const campoDescripcionAcreditacion = document.getElementById('campoDescripcionAcreditacion');
        const agregarLaboratorioBtn = document.getElementById('agregar-laboratorio-btn');
        const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');

        // Function to calculate the total price
        function calcularTotal() {
            let total = 0;
            const preciosLabs = document.querySelectorAll('.precio-lab');
            preciosLabs.forEach(input => {
                const valor = parseFloat(input.value) || 0;
                total += valor;
            });
            precioTotalInput.value = total.toFixed(2);
        }

        // Function to initialize Select2 elements
        function initSelect2Elements(container = document) {
            $('.select2', container).select2({
                placeholder: 'Selecciona una opción',
                allowClear: true,
                dropdownParent: $(container).find('.select2').parent() // Ensure dropdown renders correctly
            });
            $('.select2-laboratorio', container).select2({
                placeholder: 'Selecciona un laboratorio',
                allowClear: true,
                dropdownParent: $(container).find('.select2-laboratorio').parent() // Ensure dropdown renders correctly
            });
        }

        // Initialize Select2 on existing elements on page load
        initSelect2Elements();

        // Toggle 'Descripción de Muestra' field based on selection
        function toggleDescripcionMuestraField() {
            const requiereMuestraValue = requiereMuestraSelect.val();
            if (requiereMuestraValue === 'si') {
                descripcionMuestraField.style.display = 'block';
            } else {
                descripcionMuestraField.style.display = 'none';
                const textareaMuestra = document.getElementById('descripcionMuestra');
                if (textareaMuestra) textareaMuestra.value = '';
            }
        }

        // Toggle 'Acreditación' fields based on selection
        function toggleAcreditacionFields() {
            const acreditacionValue = acreditacionSelect.val();
            if (acreditacionValue === 'Acreditado') {
                campoNombreAcreditacion.style.display = 'block';
                campoDescripcionAcreditacion.style.display = 'block';
            } else {
                campoNombreAcreditacion.style.display = 'none';
                campoDescripcionAcreditacion.style.display = 'none';
                const inputNombreAcreditacion = document.getElementById('nombreAcreditacion');
                const textareaDescripcionAcreditacion = document.getElementById('descripcionAcreditacion');
                if (inputNombreAcreditacion) inputNombreAcreditacion.value = '';
                if (textareaDescripcionAcreditacion) textareaDescripcionAcreditacion.value = '';
            }
        }
        
        // Initial state on page load
        toggleDescripcionMuestraField();
        toggleAcreditacionFields();
        calcularTotal();

        // Event listeners for changes
        requiereMuestraSelect.on('change.select2', toggleDescripcionMuestraField);
        acreditacionSelect.on('change.select2', toggleAcreditacionFields);
        laboratoriosContenedor.addEventListener('input', function(e) {
            if (e.target.classList.contains('precio-lab')) {
                calcularTotal();
            }
        });

        // Add a new laboratory field
        agregarLaboratorioBtn.addEventListener('click', function() {
            const nuevoLaboratorio = document.createElement('div');
            nuevoLaboratorio.classList.add('row', 'g-3', 'mb-3', 'laboratorio-item', 'align-items-center');
            nuevoLaboratorio.innerHTML = `
                <div class="col-12 col-md-5">
                    <div class="form-floating form-floating-outline">
                        <input type="number" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required />
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
            laboratoriosContenedor.appendChild(nuevoLaboratorio);

            // Initialize Select2 for the newly added elements
            initSelect2Elements(nuevoLaboratorio);
            
            // Recalculate total after adding a field
            calcularTotal();
        });

        // Remove a laboratory field
        laboratoriosContenedor.addEventListener('click', function(e) {
            if (e.target.closest('.eliminar-laboratorio-btn')) {
                const item = e.target.closest('.laboratorio-item');
                if (item) {
                    item.remove();
                    // Recalculate total after removing a field
                    calcularTotal();
                }
            }
        });
    });
</script>
@endpush