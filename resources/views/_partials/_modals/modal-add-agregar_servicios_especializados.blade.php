<div class="modal fade" id="agregarServicioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h4 class="modal-title text-white" id="agregarEmpresaLabel">Registrar Nuevo Servicio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarServicio" class="row g-5" action="{{ route('servicios.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf {{-- Protección CSRF --}}

                    {{-- Fila 1 --}}
                    <div class="col-12 col-md-3">
                        <div class="form-floating form-floating-outline">
                            {{-- Se ha añadido un onchange para que llame a la función JavaScript --}}
                            <select id="clave" name="clave" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                <option value="">Seleccione una clave</option>
                                {{-- Se ha añadido un atributo data-nombre-lab para guardar el nombre del laboratorio --}}
                                @foreach ($laboratorios as $laboratorio)
                                    <option value="{{ $laboratorio->clave }}" data-nombre-lab="{{ $laboratorio->laboratorio }}" data-id-lab="{{ $laboratorio->id_laboratorio }}">{{ $laboratorio->clave }}</option>
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
                            {{-- CAMBIADO name="nombre_servicio" a name="nombre" para coincidir con la DB --}}
                            <input type="text" id="nombreServicio" name="nombre" class="form-control" placeholder="Ejemplo: Análisis de Bacillus Subtilis" />
                            <label for="nombreServicio">Nombre del servicio</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ri-money-dollar-box-line"></i></span>
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="precio" name="precio" class="form-control" placeholder="Ejemplo: 400.00" />
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
                            {{-- CAMBIADO name="requiere_muestra" a name="tipo_muestra" para coincidir con la DB --}}
                            <select id="requiereMuestra" name="tipo_muestra" class="select2 form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
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
                            {{-- CAMBIADO name="estatus" a name="id_habilitado" para coincidir con la DB --}}
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
                    <div class="col-12" id="tipoMuestraField" style="display: none;">
                        <div class="form-floating form-floating-outline">
                            {{-- CAMBIADO name="tipo_muestra" a name="cant_muestra" para coincidir con la DB --}}
                            <input type="text" id="tipoMuestra" name="cant_muestra" class="form-control" placeholder="Cantidad de Muestra" disabled />
                            <label for="tipoMuestra">Cantidad de Muestra *</label>
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
                                        <label for="precios_laboratorio">Precio *</label>
                                    </div>
                                    <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                                        {{-- Se ha añadido un id al primer select para poder seleccionarlo desde JS --}}
                                        <select name="laboratorios_responsables[]" id="primerLaboratorioResponsable" class="form-select" data-allow-clear="true" data-minimum-results-for-search="Infinity">
                                            <option value="">Seleccione un laboratorio</option>
                                            @foreach ($laboratorios as $laboratorio)
                                                <option value="{{ $laboratorio->id_laboratorio }}">{{ $laboratorio->laboratorio }}</option>
                                            @endforeach
                                        </select>
                                        <label for="laboratorios_responsables">Laboratorio responsable *</label>
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
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="ri-close-line"></i> Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


