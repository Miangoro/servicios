<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Exportar Servicios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formExportarServiciosCatalogo" action="{{ route('servicios.exportExcel') }}" method="GET">
                <div class="modal-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h6 class="mb-4 text-muted">Filtros de Exportación</h6>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="activar_clave" name="activar_clave">
                                <label class="form-check-label" for="activar_clave">Filtro por clave</label>
                            </div>
                            <select class="form-select" id="clave" name="clave" disabled>
                                <option value="todos" selected>Todas las claves</option>
                                @foreach($claves as $clave)
                                    <option value="{{ $clave }}">{{ $clave }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="activar_estatus" name="activar_estatus">
                                <label class="form-check-label" for="activar_estatus">Estatus</label>
                            </div>
                            <select class="form-select" id="estatus" name="estatus" disabled>
                                <option value="" selected>Todos los estatus</option>
                                <option value="1">Habilitado</option>
                                <option value="0">Deshabilitado</option>
                                {{-- <option value="2">Observado</option> --}}
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="activar_acreditado" name="activar_acreditado">
                                <label class="form-check-label" for="activar_acreditado">Acreditación</label>
                            </div>
                            <select class="form-select" id="acreditado" name="acreditado" disabled>
                                <option value="todos" selected>Todas</option>
                                <option value="0">No Acreditado</option>
                                <option value="1">Acreditado</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="activar_laboratorio_nombre" name="activar_laboratorio_nombre">
                                <label class="form-check-label" for="activar_laboratorio_nombre">Nombre de laboratorio</label>
                            </div>
                            <select class="form-select" id="laboratorio_nombre" name="laboratorio_nombre" disabled>
                                <option value="todos" selected>Todos los laboratorios</option>
                                @foreach($laboratorios as $lab)
                                    <option value="{{ $lab->id_laboratorio }}">{{ $lab->laboratorio }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="activar_precio" name="activar_precio">
                                <label class="form-check-label" for="activar_precio">Precio</label>
                            </div>
                            <select class="form-select" id="precio" name="precio" disabled>
                                <option value="todos" selected>Todos los precios</option>
                                @foreach($precios as $precio)
                                    <option value="{{ $precio }}">{{ $precio }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Exportar Excel</button>
                </div>
            </form>
        </div>
    </div>
</div>