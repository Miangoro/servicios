<div class="modal fade" id="exportarServiciosExcel">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="exportarVentasModalLabel">
                    <span class="iconify me-0 me-sm-2" data-icon="ri:file-excel-2-fill" data-inline="false"></span> Exportar servicios
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formExportarServiciosCatalogo" action="{{ route('clientes.empresas.exportExcel') }}" method="GET">
                <div class="modal-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h6 class="mb-4 text-muted">Filtros de Exportación</h6>
                    <div class="row g-4">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-check-label mb-2" for="filtroEmpresa">Filtro por clave</label>
                                <select class="select2 form-select form-select-sm" data-allow-clear="true" id="filtroClave" name="clave">
                                    <option value="todos">Todas</option>
                                    @isset($servicios)
                                        @foreach($servicios as $servicio)
                                            <option value="{{ $servicio->clave }}">{{ $servicio->clave }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>
        
                        <div class="col-md-6">
                            <div class="form-group">
                                <span>Estatus</span>
                                <select class="form-select" id="filtroEstatus" name="estatus">
                                    <option value="">Todos los estatus</option>
                                    <option value="1">Habilitado</option>
                                    <option value="2">No Habilitado</option>
                                    <option value="3">Observado</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <span>Acreditación</span>
                                <select class="form-select" id="filtroAcreditado" name="acreditado">
                                    <option value="0">Todas</option>
                                    <option value="1">No acreditado</option>
                                    <option value="2">Acreditado para alimentos</option>
                                    <option value="3">Acreditado para sanidad</option>
                                    <option value="4">Acreditado para información comercial</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
                        <span class="iconify me-0 me-sm-2" data-icon="ri:file-excel-2-fill" data-inline="false"></span> Exportar Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>