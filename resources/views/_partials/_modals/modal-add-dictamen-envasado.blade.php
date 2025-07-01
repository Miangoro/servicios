<!-- MODAL AGREGAR -->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Nuevo dictamen de envasado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormAgregar" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="cargarLotes()" id="id_inspeccion" name="id_inspeccion"
                                    class="select2 form-select" data-placeholder="Selecciona el número de servicio">
                                    <option value="" disabled selected></option>
                                    @foreach ($inspecciones as $insp)
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} |
                                            {{ $insp->solicitud->folio }} |
                                            {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="">No. de servicio</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="num_dictamen" name="num_dictamen"
                                    placeholder="No. de dictamen" value="UME-">
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_firmante" name="id_firmante" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona un firmante</option>
                                    @foreach ($inspectores as $inspector)
                                        <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                    @endforeach
                                </select>
                                <label for="">Selecciona un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control flatpickr-datetime" id="fecha_emision" name="fecha_emision"
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" id="fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mt-2 text-center fw-bold">Información del Lote envasado</h5>
                    <hr>
                    <div class="row mt-6">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control nombre_lote" name="nombre_lote">
                                <label for="">Nombre del lote envasado</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control cant_botellas" type="number" placeholder="Ingrese un valor"
                                    id="cantidad_botellas" name="cant_botellas" min="1" required />
                                <label for="cantidad_botellas">Cantidad de botellas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control presentacion" name="presentacion">
                                <label for="">Presentación</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class=" form-select unidad" id="unidad" name="unidad" aria-label="Unidad">
                                    <option value="mL">Mililitros</option>
                                    <option value="L">Litros</option>
                                    <option value="cL">Centrilitros</option>
                                </select>
                                <label for="unidad">Unidad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control volumen_total" name="volumen_total">
                                <label for="">Volumen total</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class=" form-select id_marca" name="id_marca" aria-label="Marca">
                                    <option value="" selected>Selecciona una marca</option>
                                </select>
                                <label for="id_marca">Marca</label>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i>
                            Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<!-- MODAL EDITAR -->
<div class="modal fade" id="ModalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar dictamen de envasado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormEditar" method="POST">
                    <div class="row">
                        <input type="hidden" id="edit_id_dictamen" name="id_dictamen">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="cargarLotes()" id="edit_id_inspeccion" name="id_inspeccion" class="select2 form-select"
                                    data-placeholder="Selecciona el número de servicio">
                                    @foreach ($inspecciones as $insp)
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} |
                                            {{ $insp->solicitud->folio }} |
                                            {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="">No. de servicio</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="edit_num_dictamen"
                                    name="num_dictamen" placeholder="No. de dictamen">
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_firmante" name="id_firmante" class="select2 form-select">
                                    @foreach ($inspectores as $inspector)
                                        <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                    @endforeach
                                </select>
                                <label for="">Selecciona un firmante</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control flatpickr-datetime" id="edit_fecha_emision"
                                    name="fecha_emision" placeholder="YYYY-MM-DD">
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" id="edit_fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mt-2 text-center fw-bold">Información del Lote envasado</h5>
                    <hr>
                    <div class="row mt-6">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control nombre_lote" name="nombre_lote">
                                <label for="">Nombre del lote envasado</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control cant_botellas" type="number" placeholder="Ingrese un valor"
                                    id="edit_cantidad_botellas" name="cant_botellas" min="1" />
                                <label for="cantidad_botellas">Cantidad de botellas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control presentacion" name="presentacion">
                                <label for="">Presentación</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class=" form-select unidad" id="edit_unidad" name="unidad" aria-label="Unidad">
                                    <option value="mL">Mililitros</option>
                                    <option value="L">Litros</option>
                                    <option value="cL">Centrilitros</option>
                                </select>
                                <label for="unidad">Unidad</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control volumen_total" name="volumen_total">
                                <label for="">Volumen total</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-floating form-floating-outline">
                                <select class=" form-select id_marca" id="edit_id_marca" name="id_marca" aria-label="Marca">
                                    <option value="" selected>Selecciona una marca</option>
                                </select>
                                <label for="id_marca">Marca</label>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-pencil-fill"></i>
                            Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function cargarLotes() {
    var id_inspeccion = $('#id_inspeccion').val() || $('#edit_id_inspeccion').val();
    if (id_inspeccion) {
        $.ajax({
            url: '/getDatosLotesEnv/' + id_inspeccion,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Primero vacía el select para evitar duplicados
                var $selectMarca = $('.id_marca');
                $selectMarca.empty();
                // Agrega la opción default
                $selectMarca.append('<option value="">Selecciona una marca</option>');
                // Llena las opciones con las marcas del response
                if (response.marcas && response.marcas.length > 0) {
                    response.marcas.forEach(function(marca) {
                        $selectMarca.append('<option value="' + marca.id_marca + '">' + marca.marca + '</option>');
                    });
                }
                // Ahora sí asigna la marca seleccionada
                if (response.solicitud && response.solicitud.lote_envasado) {
                    var lote = response.solicitud.lote_envasado;
                    $('.nombre_lote').val(lote.nombre);
                    $('.cant_botellas').val(lote.cant_botellas || '');
                    $('.volumen_total').val(lote.volumen_total || '');
                    $('.presentacion').val(lote.presentacion || '');
                    $('.unidad').val(lote.unidad || '');
                    // Marca
                    $selectMarca.val(lote.id_marca).trigger('change');
                } else {
                    console.warn("No se encontraron lotes envasados.");
                }
            },
            error: function(xhr) {
                console.error('Error al obtener lotes envasados:', xhr);
            }
        });
    } else {
        $('.nombre_lote, .cant_botellas, .volumen_total, .presentacion, .unidad').val('');
        $('.id_marca').empty().append('<option value="">Selecciona una marca</option>');
    }
}


</script>
