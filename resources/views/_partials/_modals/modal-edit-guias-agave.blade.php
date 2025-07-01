<div class="modal fade" id="editGuias" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button id="btnCloseModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Llenar Guía de Traslado Agave/Maguey</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="editGuiaForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <input type="hidden" id="editt_id_guia" name="id_guia">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="editobtenerNombrePredio(); editobtenerPlantacionPredio();"
                                    id="edit_id_empresa" name="empresa" class="select2 form-select" required>
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($empresa as $id_cliente)
                                        <option value="{{ $id_cliente->id_empresa }}">
                                            {{ $id_cliente->empresaNumClientes[0]->numero_cliente ?? $id_cliente->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $id_cliente->razon_social }}</option>
                                        </option>
                                    @endforeach
                                </select>
                                <label for="edit_id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control bg-light text-muted" type="number"
                                    placeholder="Número de guías solicitadas" id="edit_numero_guias" name="numero_guias"
                                    readonly style="pointer-events: none;" />
                                <label for="edit_numero_guias">Número de guías solicitadas</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select" id="edit_nombre_predio" name="predios" aria-label="Predio"
                            required>
                            /*Se puede quitar*/
                            @foreach ($predios as $id_predio)
                                <option value="{{ $id_predio->id_empresa }}">{{ $id_predio->nombre_predio }}</option>
                            @endforeach
                            <option value="" selected>Lista de predios</option>
                        </select>
                        <label for="edit_nombre_predio">Lista de predios</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select" id="edit_id_plantacion" name="plantacion"
                            aria-label="Plantación" required>
                            <option value="" selected>Plantación del predio</option>
                        </select>
                        <label for="edit_id_plantacion">Características del predio</label>
                    </div>
                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Datos para Guía de Traslado</h4>
                        <p class="address-subtitle"> <b style="color: red"> (DATOS NO OBLIGATORIOS SI NO CUENTA CON
                                ELLOS DEJAR LOS ESPACIOS VACÍOS)</b></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Número de plantas anterior"
                                    id="edit_num_anterior" name="anterior" oninput="editcalcularPlantasActualmente()"
                                    readonly />
                                <label for="edit_num_anterior">Número de plantas anterior</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number"
                                    placeholder="Número de plantas comercializadas" id="edit_num_comercializadas"
                                    name="comercializadas" oninput="editcalcularPlantasActualmente()" />
                                <label for="edit_num_comercializadas">Número de plantas comercializadas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Mermas plantas"
                                    id="edit_mermas_plantas" name="mermas"
                                    oninput="editcalcularPlantasActualmente()" />
                                <label for="edit_mermas_plantas">Mermas plantas</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" placeholder="Número de plantas actualmente"
                                    id="edit_numero_plantas" name="plantas" readonly />
                                <label for="edit_numero_plantas">Número de plantas actualmente</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control" type="text" placeholder="Ingrese la edad" id="edit_edad"
                            name="edad" />
                        <label for="edit_edad">Edad</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input step="any" class="form-control" type="number" placeholder="%ART"
                            id="edit_id_art" name="art" />
                        <label for="edit_id_art">%ART</label>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input step="any" class="form-control" type="number"
                                    placeholder="Ingrese la cantiad de maguey" id="edit_kg_magey" name="kg_maguey" />
                                <label for="edit_kg_magey">KG de maguey</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="text"
                                    placeholder="Ingrese un numero de lote o tapada" id="edit_no_lote_pedido"
                                    name="no_lote_pedido" />
                                <label for="edit_no_lote_pedido">No. de lote o No. de tapada</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control datepicker" id="edit_fecha_corte"
                                    placeholder="fecha_corte" name="fecha_corte" aria-label="fechacorte" readonly>
                                <label for="edit_fecha_corte">Fecha de corte</label>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="observaciones" class="form-control h-px-100" id="edit_id_observaciones"
                                placeholder="Observaciones..."></textarea>
                            <label for="edit_id_observaciones">Observaciones</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control form-control-sm" type="file" name="url[]">
                            <input value="71" class="form-control" type="hidden" name="id_documento[]">
                            <input value="Guía de traslado de agave" class="form-control" type="hidden"
                                name="nombre_documento[]">
                            <label for="Guía de traslado de agave">Adjuntar Guia escaneada</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input class="form-control form-control-sm" type="file" name="url[]">
                            <input value="132" class="form-control" type="hidden" name="id_documento[]">
                            <input value="Resultados ART" class="form-control" type="hidden"
                                name="nombre_documento[]" step="0.01">
                            <label for="Resultados ART">Adjuntar resultados de ART</label>
                        </div>
                    </div>
                    <div class="text-center mb-6">
                        <h4 class="address-title mb-2">Datos del comprador</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="text"
                                    placeholder="Ingrese el nombre del cliente/comprador" id="edit_nombre_cliente"
                                    name="nombre_cliente" min="1" />
                                <label for="edit_nombre_cliente">Nombre del cliente/comprador</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number"
                                    placeholder="Ingrese el No. del cliente/comprador" id="edit_no_cliente"
                                    name="no_cliente" />
                                <label for="edit_no_cliente">No del cliente/comprador</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="date" class="form-control datepicker" id="edit_fecha_ingreso"
                                    placeholder="fecha_ingreso" name="fecha_ingreso" aria-label="fecha_ingreso"
                                    readonly>
                                <label for="edit_fecha_ingreso">Fecha de ingreso</label>

                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control" type="text" placeholder="Ingrese el domicilio de entrega"
                            id="edit_domicilio" name="domicilio" />
                        <label for="edit_domicilio">Domicilio de entrega</label>
                    </div>
            </div>
            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <button id="btnCancelModal" type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Cancelar</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>


<script>
    function editobtenerNombrePredio() {
        var empresa = $("#edit_id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);
                var contenido = "";
                for (let index = 0; index < response.predios.length; index++) {
                    contenido = '<option value="' + response.predios[index].id_predio + '">' + response
                        .predios[index].nombre_predio + '</option>' + contenido;
                }
                if (response.predios.length == 0) {
                    contenido = '<option value="">Sin predios registradas</option>';
                }
                $('#edit_nombre_predio').html(contenido);
            },
            error: function() {}
        });
    }

    function editobtenerPlantacionPredio() {
        var empresa = $("#edit_id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);
                var contenido = "";
                for (let index = 0; index < response.predio_plantacion.length; index++) {
                    contenido = '<option value="' + response.predio_plantacion[index].id_plantacion +
                        '">Número de plantas: ' + response
                        .predio_plantacion[index].num_plantas + ' | Tipo de agave: ' + response
                        .predio_plantacion[index].nombre + ' ' + response
                        .predio_plantacion[index].cientifico + ' | Año de platanción: ' + response
                        .predio_plantacion[index].anio_plantacion + '</option>' + contenido;
                }
                if (response.predio_plantacion.length == 0) {
                    contenido = '<option value="">Sin predios registradas</option>';
                }
                $('#edit_id_plantacion').html(contenido);
            },
            error: function() {}
        });
    }

    // Función para restar los campos
    function editcalcularPlantasActualmente() {
        // Obtener los valores de los inputs
        const numAnterior = parseFloat(document.getElementById('edit_num_anterior').value) || 0;
        const numComercializadas = parseFloat(document.getElementById('edit_num_comercializadas').value) || 0;
        const mermasPlantas = parseFloat(document.getElementById('edit_mermas_plantas').value) || 0;
        // Calcular el número de plantas actualmente
        let plantasActualmente = numAnterior - numComercializadas - mermasPlantas;
        // Evitar números negativos
        if (plantasActualmente < 0) {
            plantasActualmente = 0;
        }
        document.getElementById('edit_numero_plantas').value = plantasActualmente;
    }

    //funcion para reditrigir a otra vista
    document.addEventListener("DOMContentLoaded", function() {
        // Selecciona los botones por su id
        const closeModalButtons = [document.getElementById("btnCloseModal"), document.getElementById(
            "btnCancelModal")];
        closeModalButtons.forEach(button => {
            button.addEventListener("click", function(event) {
                // Encuentra el modal padre del botón de cierre
                const modalElement = button.closest('.modal');

                // Asegúrate de que no sea el modal #verGuiasRegistardas
                if (modalElement && modalElement.id !== "verGuiasRegistardas") {
                    // Espera a que el modal actual se cierre antes de abrir el nuevo modal
                    setTimeout(() => {
                            // Abre el modal de guías registradas
                            const verGuiasRegistardasModal = new bootstrap.Modal(document
                                .getElementById("verGuiasRegistardas"));
                            verGuiasRegistardasModal.show();
                        },
                        300
                    ); // Ajusta el tiempo para asegurar que el modal anterior se cierre completamente
                }
            });
        });
    });
</script>
