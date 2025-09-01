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
                            <label class="form-label" for="clave">Filtro por clave</label>
                            <select class="form-select" id="clave" name="clave">
                                <option value="todos" selected>Todas las claves</option>
                                @foreach($claves as $clave)
                                    <option value="{{ $clave }}">{{ $clave }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label" for="estatus">Estatus</label>
                            <select class="form-select" id="estatus" name="estatus">
                                <option value="" selected>Todos los estatus</option>
                                <option value="1">Habilitado</option>
                                <option value="0">Deshabilitado</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="acreditado">Acreditación</label>
                            <select class="form-select" id="acreditado" name="acreditado">
                                <option value="todos" selected>Todas</option>
                                <option value="0">No Acreditado</option>
                                <option value="1">Acreditado</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="laboratorio_nombre">Nombre de laboratorio</label>
                            <select class="form-select" id="laboratorio_nombre" name="laboratorio_nombre">
                                <option value="todos" selected>Todos los laboratorios</option>
                                @foreach($laboratorios as $lab)
                                    <option value="{{ $lab->id_laboratorio }}">{{ $lab->laboratorio }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Campo oculto para enviar el nombre del archivo -->
                    <input type="hidden" id="nombreArchivo" name="nombreArchivo">
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Exportar Excel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para armar el nombre del archivo según filtros -->
<script>
document.getElementById('formExportarServiciosCatalogo').addEventListener('submit', function(e) {
    let clave = document.getElementById('clave').value;
    let estatus = document.getElementById('estatus').value;
    let acreditado = document.getElementById('acreditado').value;
    let laboratorio = document.getElementById('laboratorio_nombre').options[document.getElementById('laboratorio_nombre').selectedIndex].text;

    // Construimos nombre dinámico
    let nombre = "Servicios";

    if(clave !== "todos") nombre += "_Clave" + clave;
    if(estatus !== "") nombre += "_Estatus" + (estatus == 1 ? "Habilitado" : "Deshabilitado");
    if(acreditado !== "todos") nombre += "_Acreditado" + (acreditado == 1 ? "Si" : "No");
    if(laboratorio !== "Todos los laboratorios") nombre += "_Lab" + laboratorio.replace(/\s+/g, '');

    // Si no se eligió nada específico
    if(nombre === "Servicios") nombre += "_General";

    document.getElementById('nombreArchivo').value = nombre;
});
</script>
