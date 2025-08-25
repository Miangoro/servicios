<div class="modal fade" id="agregarEmpresa" tabindex="-1" aria-hidden="true">
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
                            <select id="clave" name="clave" class="select2 form-select" data-allow-clear="true">
                                <option value="">Clave *</option>
                                {{-- Opciones de clave --}}
                            </select>
                            <label for="clave">Clave *</label>
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
                            <input type="text" id="nombreServicio" name="nombre_servicio" class="form-control" placeholder="Ejemplo: Análisis de Bacillus Subtilis" />
                            <label for="nombreServicio">Nombre del servicio *</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="precio" name="precio" class="form-control" placeholder="Ejemplo: 400.00" />
                            <label for="precio">Precio *</label>
                        </div>
                    </div>

                    {{-- Fila 2 --}}
                    <div class="col-12 col-md-3">
                        <div class="form-floating form-floating-outline">
                            <select id="duracion" name="duracion" class="select2 form-select" data-allow-clear="true">
                                <option value="">Según Servicio *</option>
                                {{-- Opciones de duración --}}
                            </select>
                            <label for="duracion">Duración *</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-floating form-floating-outline">
                            <select id="tipoDuracion" name="tipo_duracion" class="select2 form-select" data-allow-clear="true">
                                <option value="">Año</option>
                                {{-- Opciones de tipo de duración --}}
                            </select>
                            <label for="tipoDuracion">Tipo Duración *</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-floating form-floating-outline">
                            <select id="requiereMuestra" name="requiere_muestra" class="select2 form-select" data-allow-clear="true">
                                <option value="">Selecciona una opción *</option>
                                <option value="si">Si</option>
                                <option value="no">No</option>
                            </select>
                            <label for="requiereMuestra">¿Se requiere muestra? *</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-floating form-floating-outline">
                            <select id="estatus" name="estatus" class="select2 form-select" data-allow-clear="true">
                                <option value="">Habilitado *</option>
                                {{-- Opciones de estatus --}}
                            </select>
                            <label for="estatus">Estatus *</label>
                        </div>
                    </div>

                    {{-- Fila 3 --}}
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="acreditacion" name="acreditacion" class="form-control" placeholder="No acreditado" />
                            <label for="acreditacion">Acreditación *</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="analisis" name="analisis" class="form-control" placeholder="Ejemplo: Coliformes Totales" />
                            <label for="analisis">Análisis *</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="unidades" name="unidades" class="form-control" placeholder="Ejemplo: NMP/100mL" />
                            <label for="unidades">Unidades *</label>
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

