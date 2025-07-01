<div class="modal fade" id="editLoteEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-2">
                <h5 class="address-title text-white">Editar lote envasado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form id="editLoteEnvasadoForm" method="POST" onsubmit="return false">
                    <input type="hidden" id="edit_id_lote_envasado" name="id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange=" edit_obtenerGraneles();" id="edit_cliente" name="edit_cliente"
                                    class="select2 form-select" required>
                                    <option value="" disabled>Selecciona cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id_empresa }}">
                                            {{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_cliente">Cliente</label>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="edit_nombre"
                                placeholder="Introduce el nombre del lote" name="edit_nombre"
                                aria-label="Nombre del lote" required />
                            <label for="name">Nombre del lote</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_destino_lote" name="edit_destino_lote" class="form-select">
                                    <option value="" disabled selected>Selecciona el destino del lote</option>
                                    <option value="1">Nacional</option>
                                    <option value="2">Exportación</option>
                                    <option value="3">Stock</option>
                                </select>
                                <label for="edit_destino_lote">Destino lote</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" id="edit_sku" class="form-control"
                                    placeholder="No. de pedido/SKU" aria-label="No. de pedido/SKU" name="edit_sku" />
                                <label for="edit_sku">No. de pedido/SKU</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select " id="edit_marca" name="edit_marca"
                                    aria-label="Marca">
                                    <option value="" selected>Selecciona una marca</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id_marca }}">{{ $marca->marca }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_marca">Marca</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" placeholder="Ingrese un valor"
                                    id="edit_cant_botellas" name="edit_cant_botellas" min="0" />
                                <label for="cantidad_botellas">Cantidad de botellas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" placeholder="Presentación de la botella"
                                    id="edit_presentacion" name="edit_presentacion" min="0" />
                                <label for="edit_presentacion">Presentación de la botella</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" id="edit_unidad" name="edit_unidad" aria-label="Unidad">
                                    <option value="mL">Mililitros</option>
                                    <option value="L">Litros</option>
                                    <option value="cL">Centrilitros</option>
                                </select>
                                <label for="edit_unidad">Unidad</label>
                            </div>
                        </div>
                    </div>

                    <div id="edit_datosOpcion2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><button type="button" class="btn btn-primary add-row-edit"> <i
                                                class="ri-add-line"></i> </button></th>
                                    <th>Lote a granel</th>
                                    <th>Volumen parcial</th>
                                </tr>
                            </thead>
                            <tbody id="edit_contenidoGraneles">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row"> <i
                                                class="ri-delete-bin-5-fill"></i> </button>
                                    </th>
                                    <td>
                                        <select class="edit_lote_granel form-control select2"
                                            name="edit_lote_granel[]" id="edit_lote_granel">
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            name="edit_volumen_parcial[]" id="edit_volumen_parcial">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="basic-default-password42">Instalación de envasado
                                certificada</label>
                            <div class="form-floating form-floating-outline mb-6">
                                <select placeholder="Selecciona el cliente"
                                    class="form-select select2 edit_Instalaciones" id="edit_Instalaciones"
                                    name="edit_Instalaciones" aria-label="Default select example">
                                    <option value="" disabled selected>Seleccione un cliente</option>
                                </select>
                                <!-- <a href="/domicilios/instalaciones" class="btn btn-outline-primary waves-effect"
                                        type="button"><i class="ri-add-circle-fill"></i> Registrar instalación de
                                        envasado</a>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" type="number" step="0.01"
                                    placeholder="Volumen total" id="edit_volumen_total" name="edit_volumen_total" />
                                <label for="edit_volumen_total">Volumen total</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select" name="tipo" aria-label="tipo">
                                    <option value="Con etiqueta">Con etiqueta</option>
                                    <option value="Sin etiqueta">Sin etiqueta</option>
                                </select>
                                <label for="tipo">Etiqueta</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary d-none" type="button" id="btnSpinnerEdit">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Actualizando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnEditEnvasado"><i
                                class="ri-pencil-fill me-1"></i>Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line me-1"></i>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function edit_obtenerGraneles() {
        var empresa = $("#edit_cliente").val();
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                // Iterar por cada select de lotes granel en el modal
                $('.edit_lote_granel').each(function() {
                    var selectElement = $(this);
                    var selectedValue = selectElement.val(); // Obtener el valor seleccionado actual
                    var contenido = "";
                    response.lotes_granel.forEach(function(lote) {
                        contenido += `<option value="${lote.id_lote_granel}"
                        ${lote.id_lote_granel == selectedValue ? "selected" : ""}>
                        ${lote.nombre_lote}</option>`;
                    });
                    if (response.lotes_granel.length === 0) {
                        contenido = '<option value="">Sin lotes a granel registrados</option>';
                    }
                    // Actualizar el contenido del select sin perder la selección
                    selectElement.html(contenido).trigger('change');
                    /*  */
                    var contenidomar = "";
                    for (let index = 0; index < response.marcas.length; index++) {
                        contenidomar = '<option value="' + response.marcas[index].id_marca + '">' +
                            response
                            .marcas[index].marca + '</option>' + contenidomar;
                    }
                    if (response.marcas.length == 0) {
                        contenidomar = '<option value="">Sin marcas registradas</option>';
                    }
                    $('#edit_marca').html(contenidomar);
                    const edit_ma = $('#edit_marca').data('selected');
                    if (edit_ma) {
                        $('#edit_marca').val(edit_ma);
                    }

                    var contenidoDierc = "";
                    for (let index = 0; index < response.instalaciones.length; index++) {
                        contenidoDierc = '<option value="' + response.instalaciones[index]
                            .id_instalacion + '">' +
                            response.instalaciones[index].direccion_completa + '</option>' +
                            contenidoDierc;
                    }
                    if (response.instalaciones.length == 0) {
                        contenidoDierc =
                            '<option value="">Sin instalaciones de envasado registrados</option>';
                    }
                    $('.edit_Instalaciones').html(contenidoDierc);

                    const edit_instalacion = $('.edit_Instalaciones').data('selected');
                    if (edit_instalacion) {
                        $('.edit_Instalaciones').val(edit_instalacion);
                    }

                });
            },
            error: function() {}
        });
    }





    document.addEventListener('DOMContentLoaded', function() {
        function calcularVolumenTotal() {
            var cantidadBotellas = parseFloat(document.getElementById('edit_cant_botellas').value) || 0;
            var edit_presentacion = parseFloat(document.getElementById('edit_presentacion').value) || 0;
            var edit_unidad = document.getElementById('edit_unidad').value;
            var volumenTotal;
            if (edit_unidad === "Litros") {
                volumenTotal = cantidadBotellas * edit_presentacion;
            } else if (edit_unidad === "Mililitros") {
                volumenTotal = (cantidadBotellas * edit_presentacion) / 1000;
            } else if (edit_unidad === "Centrilitros") {
                volumenTotal = (cantidadBotellas * edit_presentacion) / 100;
            } else {
                volumenTotal = '';
            }
            document.getElementById('edit_volumen_total').value = volumenTotal ? volumenTotal.toFixed(2) : '';
        }
        document.getElementById('edit_cant_botellas').addEventListener('input', calcularVolumenTotal);
        document.getElementById('edit_presentacion').addEventListener('input', calcularVolumenTotal);
        document.getElementById('edit_unidad').addEventListener('change', calcularVolumenTotal);
    });
</script>
