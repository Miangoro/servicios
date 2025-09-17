<div class="modal fade" id="addConvenioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h4 class="modal-title text-white" id="addConvenioModalLabel">Registrar Nuevo Convenio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddConvenio" class="row g-3" action="{{ route('convenios.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="col-12 mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ri-key-2-line"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="clave" name="clave" class="form-control" placeholder="01-PROY" required />
                                        <label for="clave">Clave</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ri-flask-line"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="nombreProyecto" name="nombre_proyecto" class="form-control" placeholder="Análisis de Bacillus Subtilis" required />
                                        <label for="nombreProyecto">Nombre del Proyecto</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="ri-user-line"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="investigadorResponsable" name="investigador_responsable" class="form-control" placeholder="Dra. Citlali Colín" required />
                                        <label for="investigadorResponsable">Investigador responsable</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="duracion" name="duracion" class="form-control" placeholder="Ej. 12" required />
                                    <label for="duracion">Duración</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <select id="tipoDuracion" name="tipo_duracion" class="form-select" required>
                                        <option value="" selected disabled>Selecciona una opción</option>
                                        <option value="mes">Mes</option>
                                        <option value="año">Año</option>
                                        <option value="semanas">Semanas</option>
                                        <option value="dias">Días</option>
                                    </select>
                                    <label for="tipoDuracion">Tipo Duración</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ri-add-line"></i> Registrar
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