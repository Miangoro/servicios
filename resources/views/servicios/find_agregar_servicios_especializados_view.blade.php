<div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header bg-primary pb-4">
            <h4 class="modal-title text-white">Detalles del Servicio</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{-- Formulario de solo lectura para mostrar detalles --}}
            <form id="viewServicioForm" class="row g-5">
                {{-- Fila 1 --}}
                <div class="col-12 col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="clave-view" class="form-control" value="{{ $servicio->clave }}" readonly disabled />
                        <label for="clave-view">Clave</label>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-edit-2-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="claveAdicional-view" class="form-control" value="{{ $servicio->clave_adicional }}" readonly disabled />
                            <label for="claveAdicional-view">Clave adicional</label>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="nombreServicio-view" class="form-control" value="{{ $servicio->nombre }}" readonly disabled />
                        <label for="nombreServicio-view">Nombre del servicio</label>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="ri-money-dollar-box-line"></i></span>
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="precio-view" class="form-control" value="{{ $servicio->precio }}" readonly disabled />
                            <label for="precio-view">Precio</label>
                        </div>
                    </div>
                </div>

                {{-- Fila 2 --}}
                <div class="col-12 col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="duracion-view" class="form-control" value="{{ $servicio->duracion }}" readonly disabled />
                        <label for="duracion-view">Duración</label>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="requiereMuestra-view" class="form-control" value="{{ $servicio->tipo_muestra }}" readonly disabled />
                        <label for="requiereMuestra-view">¿Se requiere muestra?</label>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="acreditacion-view" class="form-control" value="{{ $servicio->acreditacion }}" readonly disabled />
                        <label for="acreditacion-view">Acreditación</label>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="estatus-view" class="form-control" value="{{ $servicio->id_habilitado }}" readonly disabled />
                        <label for="estatus-view">Estatus</label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="analisis-view" name="analisis" class="form-control" value="{{ $servicio->analisis }}" readonly disabled />
                        <label for="analisis-view">Análisis</label>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="unidades-view" name="unidades" class="form-control" value="{{ $servicio->unidades }}" readonly disabled />
                        <label for="unidades-view">Unidades</label>
                    </div>
                </div>
                @if ($servicio->metodo)
                    <div class="col-12" id="metodoField-view">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="metodo-view" name="metodo" class="form-control" value="{{ $servicio->metodo }}" readonly disabled />
                            <label for="metodo-view">Método</label>
                        </div>
                    </div>
                @endif
                @if ($servicio->cant_muestra)
                    <div class="col-12" id="tipoMuestraField-view">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="tipoMuestra-view" name="cant_muestra" class="form-control" value="{{ $servicio->cant_muestra }}" readonly disabled />
                            <label for="tipoMuestra-view">Cantidad de Muestra</label>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="form-floating form-floating-outline">
                        <textarea id="prueba-view" name="prueba" class="form-control" readonly disabled>{{ $servicio->prueba }}</textarea>
                        <label for="prueba-view">Prueba</label>
                    </div>
                </div>
                
                {{-- Sección de Requisitos --}}
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3">
                        <span class="fs-5 fw-bold text-dark me-2">Requisitos</span>
                    </div>
                    <div id="requisitos-contenedor-view">
                        @foreach ($servicio->requisitos as $requisito)
                            <div class="input-group mb-3 requisito-item">
                                <div class="form-floating form-floating-outline flex-grow-1">
                                    <input type="text" class="form-control" value="{{ $requisito->nombre }}" readonly disabled />
                                    <label>Requisito</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Sección de Precio por laboratorio --}}
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white rounded-top-4 py-3">
                            <h5 class="fw-bold text-dark mb-0">Precio por laboratorio</h5>
                        </div>
                        <div class="card-body bg-white py-3">
                            @foreach ($servicio->preciosLaboratorio as $precioLaboratorio)
                                <div class="input-group mb-3 laboratorio-item">
                                    <div class="form-floating form-floating-outline flex-grow-1">
                                        <input type="text" class="form-control" value="${{ $precioLaboratorio->precio_laboratorio }}" readonly disabled />
                                        <label>Precio</label>
                                    </div>
                                    <div class="form-floating form-floating-outline flex-grow-1 ms-2">
                                        <input type="text" class="form-control" value="{{ $precioLaboratorio->laboratorio->laboratorio }}" readonly disabled />
                                        <label>Laboratorio responsable</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                <i class="ri-close-line"></i> Cerrar
            </button>
        </div>
    </div>
</div>
