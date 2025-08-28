@extends('layouts/layoutMaster')

@section('title', 'Agregar Nuevo Servicio')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/form-validation/form-validation.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/spinkit/spinkit.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/form-validation/form-validation.js',
        'resources/assets/vendor/libs/form-validation/popular.js',
        'resources/assets/vendor/libs/form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/form-validation/auto-focus.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
    ])
@endsection

@section('page-script')
    @vite([
        'resources/js/servicios_create.js',
        'resources/assets/js/forms-selects.js'
    ])
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
                        {{-- Fila 1 --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="clave" name="clave" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="">Seleccione una clave</option>
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

                        {{-- Fila 2 --}}
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="duracion" name="duracion" class="form-control" placeholder=" " />
                                <label for="duracion">Duración</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="requiereMuestra" name="requiere_muestra" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="">Selecciona una opción</option>
                                    <option value="si">Sí</option>
                                    <option value="no">No</option>
                                </select>
                                <label for="requiereMuestra">¿Se requiere muestra?</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="acreditacion" name="acreditacion" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="No acreditado">No acreditado</option>
                                    <option value="Acreditado para alimentos">Acreditado para alimentos</option>
                                    <option value="Acreditado para sanidad">Acreditado para sanidad</option>
                                    <option value="Acreditado para Información Comercial">Acreditado para Información Comercial</option>
                                </select>
                                <label for="acreditacion">Acreditación</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-floating form-floating-outline">
                                <select id="estatus" name="id_habilitado" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                    <option value="1">Habilitado</option>
                                    <option value="0">No habilitado</option>
                                    <option value="2">Observado</option>
                                </select>
                                <label for="estatus">Estatus</label>
                            </div>
                        </div>

                        {{-- Fila 3 --}}
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="analisis" name="analisis" class="form-control" placeholder="Ejemplo: Coliformes Totales" />
                                <label for="analisis">Análisis</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="unidades" name="unidades" class="form-control" placeholder="Ejemplo: NMP/100mL" />
                                <label for="unidades">Unidades</label>
                            </div>
                        </div>
                        <div class="col-12" id="metodoField" style="display: none;">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="metodo" name="metodo" class="form-control" placeholder="Ejemplo: Método NXHGS (Acreditado bajo la norma 763CS de la EMA)" />
                                <label for="metodo">Método (Especificar si está acreditado si es el caso) *</label>
                            </div>
                        </div>
                        
                        {{-- Campo Tipo de Muestra, ahora como textarea y con el estilo solicitado --}}
                        <div class="col-12" id="tipoMuestraField" style="display: none;">
                            <div class="form-floating form-floating-outline">
                                <textarea id="tipoMuestra" name="tipo_muestra" class="form-control" placeholder="Tipo de Muestra"></textarea>
                                <label for="tipoMuestra">Tipo de Muestra</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating form-floating-outline">
                                <textarea id="prueba" name="prueba" class="form-control" placeholder="Prueba"></textarea>
                                <label for="prueba">Prueba</label>
                            </div>
                        </div>

                        {{-- Sección de Requisitos --}}
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-3">
                                <span class="fs-5 fw-bold text-dark me-2">Requisitos</span>
                                <button type="button" class="btn btn-success" id="agregar-requisito-btn">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                            <div id="requisitos-contenedor">
                                <div class="input-group mb-3 requisito-item">
                                    <div class="form-floating form-floating-outline flex-grow-1">
                                        <input type="text" class="form-control" name="requisitos[]" placeholder="Requisitos" />
                                        <label>Requisitos</label>
                                    </div>
                                    <button type="button" class="btn btn-danger eliminar-requisito-btn ms-2">
                                        <i class="ri-subtract-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Sección para subir archivo --}}
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="file_requisitos" class="form-label fw-bold">Archivo WORD-PDF de requisitos(Opcional)</label>
                                <input class="form-control" type="file" id="file_requisitos" name="file_requisitos">
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
                                            <input type="text" class="form-control" name="laboratorio_responsable_nombre[]" placeholder="Laboratorio responsable" />
                                            <input type="hidden" name="laboratorios_responsables[]" />
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
            const claveSelect = $('#clave');
            const precioTotalInput = document.getElementById('precio');
            const requiereMuestraSelect = $('#requiereMuestra');
            const tipoMuestraField = document.getElementById('tipoMuestraField');
            const acreditacionSelect = $('#acreditacion');
            const metodoField = document.getElementById('metodoField');
            const agregarRequisitoBtn = document.getElementById('agregar-requisito-btn');
            const requisitosContenedor = document.getElementById('requisitos-contenedor');
            const agregarLaboratorioBtn = document.getElementById('agregar-laboratorio-btn');
            const laboratoriosContenedor = document.getElementById('laboratorios-contenedor');

            // Autocompletado del primer laboratorio
            claveSelect.on('change.select2', function() {
                const selectedOption = $(this).find('option:selected');
                const firstLaboratorioItem = document.querySelector('.laboratorio-item');
                if (selectedOption.val() && firstLaboratorioItem) {
                    const nombreLab = selectedOption.data('nombre-lab');
                    const idLab = selectedOption.data('id-lab');
                    const nombreInput = firstLaboratorioItem.querySelector('[name="laboratorio_responsable_nombre[]"]');
                    const idInput = firstLaboratorioItem.querySelector('[name="laboratorios_responsables[]"]');
                    if (nombreInput) nombreInput.value = nombreLab || '';
                    if (idInput) idInput.value = idLab || '';
                } else if (firstLaboratorioItem) {
                    const nombreInput = firstLaboratorioItem.querySelector('[name="laboratorio_responsable_nombre[]"]');
                    const idInput = firstLaboratorioItem.querySelector('[name="laboratorios_responsables[]"]');
                    if (nombreInput) nombreInput.value = '';
                    if (idInput) idInput.value = '';
                }
            });

            // Lógica para mostrar/ocultar el campo "Tipo de Muestra"
            function toggleTipoMuestraField() {
                if (requiereMuestraSelect.val() === 'si') {
                    tipoMuestraField.style.display = 'block';
                } else {
                    tipoMuestraField.style.display = 'none';
                }
            }
            toggleTipoMuestraField();
            requiereMuestraSelect.on('change.select2', function() {
                toggleTipoMuestraField();
            });

            // Lógica para mostrar/ocultar el campo "Método"
            function toggleMetodoField() {
                if (acreditacionSelect.val().includes('Acreditado')) {
                    metodoField.style.display = 'block';
                } else {
                    metodoField.style.display = 'none';
                }
            }
            toggleMetodoField();
            acreditacionSelect.on('change.select2', function() {
                toggleMetodoField();
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

            // Lógica para agregar y eliminar campos de "Requisitos"
            agregarRequisitoBtn.addEventListener('click', function() {
                const nuevoRequisito = document.createElement('div');
                nuevoRequisito.classList.add('input-group', 'mb-3', 'requisito-item');
                nuevoRequisito.innerHTML = `
                    <div class="form-floating form-floating-outline flex-grow-1">
                        <input type="text" class="form-control" name="requisitos[]" placeholder="Requisitos" />
                        <label>Requisitos</label>
                    </div>
                    <button type="button" class="btn btn-danger eliminar-requisito-btn ms-2">
                        <i class="ri-subtract-line"></i>
                    </button>
                `;
                requisitosContenedor.appendChild(nuevoRequisito);
            });

            requisitosContenedor.addEventListener('click', function(e) {
                if (e.target.closest('.eliminar-requisito-btn')) {
                    const item = e.target.closest('.requisito-item');
                    if (item) {
                        item.remove();
                    }
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
                        <label for="select2-laboratorio">Laboratorio responsable *</label>
                    </div>
                    <button type="button" class="btn btn-danger eliminar-laboratorio-btn ms-2">
                        <i class="ri-subtract-line"></i>
                    </button>
                `;
                laboratoriosContenedor.appendChild(nuevoLaboratorio);

                const newSelect = nuevoLaboratorio.querySelector('.select2-laboratorio');
                $(newSelect).select2({
                    placeholder: 'Selecciona un laboratorio',
                    allowClear: true
                });

                calcularTotal();
            });

            laboratoriosContenedor.addEventListener('click', function(e) {
                if (e.target.closest('.eliminar-laboratorio-btn')) {
                    const item = e.target.closest('.laboratorio-item');
                    if (item) {
                        item.remove();
                        calcularTotal();
                    }
                }
            });

            calcularTotal();
        });
    </script>
@endsection