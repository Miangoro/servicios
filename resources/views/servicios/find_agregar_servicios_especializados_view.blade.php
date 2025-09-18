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
                    <form id="formAgregarServicio" class="row g-5" action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Fila 1: Clave, Clave Adicional, Nombre del Servicio, Precio --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="clave" name="clave" class="select2 form-select" data-allow-clear="true">
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
                                <select id="requiereMuestra" name="requiere_muestra" class="select2 form-select" data-allow-clear="true">
                                    <option value="">Selecciona una opción</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                                <label for="requiereMuestra">¿Se requiere muestra?</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="acreditacion" name="acreditacion" class="select2 form-select" data-allow-clear="true">
                                    <option value="">Selecciona una opción</option>
                                    <option value="No acreditado">No acreditado</option>
                                    <option value="Acreditado">Acreditado</option>
                                </select>
                                <label for="acreditacion">Acreditación</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="estatus" name="id_habilitado" class="select2 form-select" data-allow-clear="true">
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
                                            <input type="text" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required/>
                                            <label>Precio *</label>
                                        </div>
                                        <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                                            <select class="form-select select2-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true" required>
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
                            <button type="submit" class="btn btn-primary me-2">
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
            // Inicializar Select en todos los selectores
            $('.select').select({
                placeholder: 'Selecciona una opción',
                allowClear: true,
                width: '100%'
            });

            $('.select-laboratorio').select({
                placeholder: 'Selecciona un laboratorio',
                allowClear: true,
                width: '100%'
            });

            // Lógica para agregar y eliminar campos de "Precio por laboratorio"
            document.getElementById('agregar-laboratorio-btn').addEventListener('click', function() {
                const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');
                const nuevoLaboratorio = document.createElement('div');
                nuevoLaboratorio.classList.add('input-group', 'mb-3', 'laboratorio-item');
                nuevoLaboratorio.innerHTML = `
                    <div class="form-floating form-floating-outline flex-grow-1">
                        <input type="text" class="form-control precio-lab" name="precios_laboratorio[]" placeholder="Precio" required/>
                        <label>Precio *</label>
                    </div>
                    <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                        <select class="form-select select-laboratorio" name="laboratorios_responsables[]" data-allow-clear="true" required>
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
                
                // Inicializar Select en el nuevo select
                $(nuevoLaboratorio).find('.select-laboratorio').select({
                    placeholder: 'Selecciona un laboratorio',
                    allowClear: true,
                    width: '100%'
                });
                
                calcularTotal();
            });

            document.getElementById('laboratorios-contenedor').addEventListener('click', function(e) {
                if (e.target.closest('.eliminar-laboratorio-btn')) {
                    const item = e.target.closest('.laboratorio-item');
                    if (item) {
                        $(item).find('.select-laboratorio').select('destroy');
                        item.remove();
                        calcularTotal();
                    }
                }
            });

            const precioTotalInput = document.getElementById('precio');
            const requiereMuestraSelect = $('#requiereMuestra');
            const descripcionMuestraField = document.getElementById('descripcionMuestraField');
            const acreditacionSelect = $('#acreditacion');
            const campoNombreAcreditacion = document.getElementById('campoNombreAcreditacion');
            const campoDescripcionAcreditacion = document.getElementById('campoDescripcionAcreditacion');
            const archivoInput = document.getElementById('archivoRequisitos');
            const archivoInfo = document.getElementById('archivoInfo');
            
            archivoInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    archivoInfo.textContent = this.files[0].name;
                } else {
                    archivoInfo.textContent = 'No se ha seleccionado ningún archivo';
                }
            });

            function toggleDescripcionMuestraField() {
                if (requiereMuestraSelect.val() === 'si') {
                    descripcionMuestraField.style.display = 'block';
                    document.getElementById('descripcionMuestra').setAttribute('required', 'required');
                } else {
                    descripcionMuestraField.style.display = 'none';
                    document.getElementById('descripcionMuestra').removeAttribute('required');
                }
            }
            toggleDescripcionMuestraField();
            requiereMuestraSelect.on('change', function() {
                toggleDescripcionMuestraField();
            });

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
            toggleAcreditacionFields();
            acreditacionSelect.on('change', function() {
                toggleAcreditacionFields();
            });

            function calcularTotal() {
                let total = 0;
                const preciosLabs = document.querySelectorAll('.precio-lab');
                preciosLabs.forEach(input => {
                    const valor = parseFloat(input.value) || 0;
                    total += valor;
                });
                precioTotalInput.value = total.toFixed(2);
            }

            document.getElementById('laboratorios-contenedor').addEventListener('input', function(e) {
                if (e.target.classList.contains('precio-lab')) {
                    calcularTotal();
                }
            });

            calcularTotal();
        });
    </script>
@endsection