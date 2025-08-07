<div class="modal fade" id="exportarVentasModal" tabindex="-1" aria-labelledby="exportarVentasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="exportarVentasModalLabel">
                    <i class="ri-file-excel-2-line me-2"></i> Exportar Clientes
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formExportarClientes" action="{{ route('clientes.empresas.exportExcel') }}" method="GET">
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
                                <label class="form-check-label mb-2" for="filtroEmpresa">Filtro por Empresa</label>
                                <select class="form-select" id="filtroEmpresa" name="empresa_id">
                                <option value="todos">Todas las empresas</option>
                                @isset($empresas)
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                    @endforeach
                                @endisset
                            </select>
                            </div>
                        </div>
                        {{-- Filtro por Régimen Fiscal con Checkbox --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="form-check m-0">
                                        <input class="form-check-input" type="checkbox" id="enableFiltroRegimen" name="enableFiltroRegimen">
                                        <label class="form-check-label" for="enableFiltroRegimen">Habilitar filtro de Régimen Fiscal</label>
                                    </div>
                                </div>
                                <select class="form-select" id="filtroRegimen" name="regimen_fiscal" disabled>
                                    <option value="todos">Todos los regímenes</option>
                                    @isset($regimenes)
                                        @foreach($regimenes as $regimen)
                                            <option value="{{ $regimen->id }}">{{ $regimen->regimen }}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>

                        {{-- Filtro por Crédito con Checkbox --}}
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="enableFiltroCredito" name="enableFiltroCredito">
                                <label class="form-check-label" for="enableFiltroCredito">Habilitar filtro de Crédito</label>
                            </div>
                            <div class="form-group">
                                <select class="form-select" id="filtroCredito" name="credito" disabled>
                                    <option value="todos">Todos los créditos</option>
                                    <option value="con_credito">Con crédito</option>
                                    <option value="sin_credito">Sin crédito</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <h6 class="mb-4 text-muted">Filtros por Fecha de Registro</h6>
                    <div class="row g-4">
                        {{-- Filtro por Día (Registro) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="filtroDia" class="form-label">
                                    <i class="ri-calendar-line me-1"></i> Día
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="filtroDia" name="dia" placeholder="dd" min="1" max="31">
                                    <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                </div>
                            </div>
                        </div>

                        {{-- Filtro por Mes (Registro) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="filtroMes" class="form-label">
                                    <i class="ri-calendar-event-line me-1"></i> Mes
                                </label>
                                <select class="form-select" id="filtroMes" name="mes">
                                    <option value="todos">Todos los meses</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>

                        {{-- Filtro por Año (Registro) --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="filtroAnio" class="form-label">
                                    <i class="ri-calendar-check-line me-1"></i> Año
                                </label>
                                <select class="form-select" id="filtroAnio" name="anio">
                                    <option value="todos">Todos los años</option>
                                    @for ($i = date('Y'); $i >= 2020; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
                        <i class="ri-file-excel-2-line me-1"></i> Exportar a Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formExportarClientes = document.getElementById('formExportarClientes');
        const exportarVentasModal = document.getElementById('exportarVentasModal');

        function setupFilterToggle(checkboxId, selectId) {
            const checkbox = document.getElementById(checkboxId);
            const select = document.getElementById(selectId);
            
            if (!checkbox || !select) return;

            select.disabled = !checkbox.checked;

            checkbox.addEventListener('change', function() {
                select.disabled = !this.checked;
                if (select.disabled) {
                    select.value = 'todos';
                }
            });
        }

        
        setupFilterToggle('enableFiltroRegimen', 'filtroRegimen');
        setupFilterToggle('enableFiltroCredito', 'filtroCredito');

        formExportarClientes.addEventListener('submit', function (event) {
        });

        @if(session('error'))
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var exportModal = bootstrap.Modal.getInstance(exportarVentasModal) || new bootstrap.Modal(exportarVentasModal);
                exportModal.show();
                exportarVentasModal.querySelector('.modal-body').scrollTop = 0;
            }
        @endif
    });
</script>