<div class="modal fade" id="editPedidoExportacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de pedidos para exportación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8 bg-light">
                <p class="solicitud badge bg-primary"></p>
                <form id="editPedidoExportacionForm">
                    <input type="hidden" name="id_solicitud" class="id_solicitud" id="solicitud_id_pedidos">
                    <input type="hidden" name="form_type" value="pedidosExportacion">
                    <div class="card" id="pedidos_Ex">
                        <div class="badge rounded-2 bg-label-primary  fw-bold fs-6 px-4 py-4 mb-5">
                            Información de la solicitud
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select id="tipo_solicitud_edit" class="form-select" name="tipo_solicitud">
                                            <option value="1">Inspección y certificado de exportación</option>
                                            <!--<option value="2">Inspección</option>-->
                                            <option value="2">Inspección y certificado de exportación (Combinado)
                                            </option>
                                            <!--<option value="4">Certificado de exportación</option>
                                    <option value="5">Certificado de exportación (combinado)</option>-->
                                        </select>
                                        <label for="tipo_solicitud">Tipo de solicitud</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select id="id_empresa_solicitud_exportacion_edit" name="id_empresa"
                                            class="select2 form-select" onchange="cargarDatosClienteEdit()">
                                            <option value="" disabled selected>Selecciona cliente</option>
                                            @foreach ($empresas as $empresa)
                                                <option value="{{ $empresa->id_empresa }}">
                                                    {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                                    | {{ $empresa->razon_social }}</option>
                                            @endforeach
                                        </select>
                                        <label for="id_empresa">Cliente</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-5">
                                        <input id="fecha_visita_edit_exportacion" placeholder="YYYY-MM-DD"
                                            class="form-control flatpickr-datetime" type="datetime-local"
                                            name="fecha_visita" autocomplete="off" />
                                        <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-floating form-floating-outline mb-5">
                                        <select class="select2 form-select" id="id_instalacion_exportacion_edit"
                                            name="id_instalacion" aria-label="id_instalacion" required>
                                            <option value="" selected>Lista de instalaciones</option>
                                        </select>
                                        <label for="id_predio">Domicilio de inspección</label>
                                    </div>
                                </div>

                            </div>
                            <!-- Sección: Pedidos para exportación -->


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select onchange="cargarMarcasEdit();" class="form-select select2"
                                            name="direccion_destinatario" id="direccion_destinatario_ex_edit">
                                            <option value="" disabled selected>Seleccione una dirección</option>
                                        </select>
                                        <label for="direccion_destinatario">Domicilio del destinatario</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2 aduana_salida" name="aduana_salida">
                                            @foreach ($aduanas as $aduana)
                                                <option value="{{ $aduana->aduana }}">{{ $aduana->aduana }}</option>
                                            @endforeach
                                        </select>
                                        <label for="aduana_salida">Aduana de salida</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control no_pedido" name="no_pedido"
                                            placeholder="Ej. Número de pedido">
                                        <label for="no_pedido">No. de pedido</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="file" class="form-control" id="factura_proforma_edit"
                                            name="factura_proforma">
                                        <input type="hidden" name="id_documento_factura" value="55">
                                        <input type="hidden" name="nombre_documento_factura" value="Factura proforma">
                                        <label for="factura_proforma">Adjuntar Factura/Proforma</label>
                                        <div id="factura_proforma_display"></div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="file" class="form-control" id="factura_proforma_cont_edit"
                                            name="factura_proforma_cont">
                                        <input type="hidden" name="id_documento_factura_cont" value="55">
                                        <input type="hidden" name="nombre_documento_factura_cont"
                                            value="Factura proforma (Continuación)">
                                        <label for="factura_proforma_cont">Adjuntar Factura/Proforma
                                            (Continuación)</label>
                                        <div id="factura_proforma_cont_display"></div>
                                    </div>

                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="select2 form-select" id="id_nstalaciones_envasado_2_edit"
                                            name="id_nstalaciones_envasado_2_edit"
                                            aria-label="id_nstalaciones_envasado_2_edit" required>
                                            <option value="" disabled selected>Lista de instalaciones de envasado
                                            </option>
                                        </select>
                                        <label for="id_nstalaciones_envasado_2_edit">Domicilio de envasado</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="sections-container2">
                        <!-- Sección original: Características del Producto -->
                        <div class="card mt-4" id="caracteristicas_Ex_edit_">
                            <div class="badge rounded-2 bg-label-primary  fw-bold fs-6 px-4 py-4 mb-5">
                                Características del Producto
                            </div>
                            <div class="card-body">

                                <div class="row caracteristicas-row">
                                    <div class="col-md-8">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select onchange="cargarDetallesLoteEnvasadoEdit2(this.value)"
                                                name="lote_envasado[0]" id="lote_envasado_edit_0"
                                                class="select2 form-select evasado_export_edit lote-envasado-edit">
                                                <option value="" disabled selected>Selecciona un lote envasado
                                                </option>
                                                <!-- Opciones dinámicas -->
                                            </select>
                                            <label for="lote_envasado">Selecciona el lote envasado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" disabled name="lote_granel[0]"
                                                id="lote_granel_edit_0" class="form-control lotes_granel_export_edit">
                                            </input>
                                            <label for="lote_granel">Lote a granel</label>
                                        </div>
                                    </div>
                                    <span id="seccionCajasBotellasCombinadoEdit" class="row">
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="number" class="form-control cantidad_botellas0"
                                                    id="cantidad_botellas_edit0" name="cantidad_botellas[0]"
                                                    placeholder="Cantidad de botellas">
                                                <label for="cantidad_botellas">Cantidad de botellas</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="number" class="form-control cantidad_cajas_edit0"
                                                    id="cantidad_cajas_edit0" name="cantidad_cajas[0]"
                                                    placeholder="Cantidad de cajas">
                                                <label for="cantidad_cajas">Cantidad de cajas</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control presentacion"
                                                    id="presentacion_edit0" name="presentacion[0]"
                                                    placeholder="Ej. 750ml">
                                                <label for="presentacion">Presentación</label>
                                            </div>
                                        </div>
                                    </span>
                                    <div class="p-2">
                                        <table id="tablaLotes" class="table table-bordered mb-2 table-sm"
                                            style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre del Lote</th>
                                                    <th>SKU</th>
                                                    <th>Presentación</th>
                                                    <th>Cantidad de botellas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí se insertarán dinámicamente los datos -->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <!-- Botones -->
                    <div id="botones_characteristics_edit" class="d-none">
                        <button type="button" id="add-characteristics_edit" class="btn btn-primary btn-sm mb-2">
                            <i class="ri-add-line me-1"></i> Agregar Tabla
                        </button>
                        <button type="button" id="delete-characteristics_edit"
                            class="btn btn-danger btn-sm mb-2 float-end">
                            <i class="ri-delete-bin-6-fill me-1"></i> Eliminar tabla
                        </button>
                    </div>


                    <div id="seccionCajasBotellasEdit" class="card d-none">
                        <div class="badge rounded-2 bg-label-warning fw-bold fs-6 px-4 py-4 mb-5">
                            <span>Información de los lotes</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <input type="number" class="form-control cantidad_botellas0"
                                            id="2cantidad_botellas_edit0" placeholder="Cantidad de botellas">
                                        <label for="cantidad_botellas">Cantidad de botellas</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <input type="number" class="form-control cantidad_cajas_edit0"
                                            id="2cantidad_cajas_edit0" placeholder="Cantidad de cajas">
                                        <label for="cantidad_cajas">Cantidad de cajas</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <input type="text" class="form-control presentacion"
                                            id="2presentacion_edit0" placeholder="Ej. 750ml">
                                        <label for="presentacion">Presentación</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    <!-- Sección: Elegir Etiquetas y Corrugados -->
                    <div class="card mt-4" id="etiquetas_Ex">
                        <div class="badge rounded-2 bg-label-primary  fw-bold fs-6 px-4 py-4 mb-5">
                            <span id="encabezado_etiquetas_edit">Elegir Etiquetas y Corrugados</span>
                        </div>
                        <div class="card-body table-responsive text-nowrap">

                            <table class="table table-striped small table-sm" id="tabla_marcas">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>

                                        <th>SKU</th>
                                        <th>Tipo</th>
                                        <th>Presentación</th>
                                        <th>Clase</th>
                                        <th>Categoría</th>
                                        <th>Etiqueta</th>
                                        <th>Corrugado</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    {{-- aqui seria el foreach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-floating form-floating-outline mb-5 mt-4">
                                    <textarea name="info_adicional" class="form-control h-px-150" id="comentarios_edit"
                                        placeholder="Información adicional sobre la actividad..."></textarea>
                                    <label for="comentarios">Información adicional sobre la actividad</label>
                                </div>
                            </div>
                            <input type="hidden" class="instalacion_id">
                            <input type="hidden" class="direccion_id">
                            <input type="hidden" class="instalacion_envasado_id">
                            <input type="hidden" class="lote_envasado_id">
                            <input type="hidden" class="etiqueta_id">
                            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                                <button disabled class="btn btn-primary me-1 d-none" type="button"
                                    id="btnSpinnerPedidosExportacionEdit">
                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                    Actualizando...
                                </button>
                                <button type="submit" class="btn btn-primary" id="btnEditExport"><i
                                        class="ri-pencil-fill me-1"></i> Editar</button>
                                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"
                                    aria-label="Close"><i class="ri-close-line me-1"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>
</div>



<script>
    function cargarDatosClienteEdit() {
        var empresa = $("#id_empresa_solicitud_exportacion_edit").val();

        if (empresa !== "" && empresa !== null && empresa !== undefined) {

            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    cargarInstalacionesEdit(response.instalaciones_comercializadora);
                    cargarInstalacionesEnvasadoEdit(response.instalaciones_envasadora);
                    cargarDireccionesEdit(response.direcciones);
                    cargarLotesEnvasadoEdit(response.lotes_envasado, response.marcas);
                    cargarMarcasEdit();
                    /* compararLotesConSelects(); */
                    /* cargarLotesGranelEdit(response.lotes_granel); */

                },
                error: function() {
                    console.error('Error al cargar los datos.');
                }
            });
        }
    }

    // Función para cargar instalaciones
    function cargarInstalacionesEdit(instalaciones) {
        if (instalaciones !== "" && instalaciones !== null && instalaciones !== undefined) {
            var contenidoInstalaciones = "";
            let seleccionado = "";
            var instalacion_id = $(".instalacion_id").val();

            for (let index = 0; index < instalaciones.length; index++) {
                // Limpia el campo tipo usando la función limpiarTipo
                var tipoLimpio = limpiarTipo(instalaciones[index].tipo);

                if (instalacion_id == instalaciones[index].id_instalacion) {
                    seleccionado = "selected";
                } else {
                    seleccionado = ""; // Asegúrate de limpiar este valor si no coincide
                }

                contenidoInstalaciones = '<option ' + seleccionado + ' value="' + instalaciones[index]
                    .id_instalacion + '">' +
                    tipoLimpio + ' | ' + instalaciones[index].direccion_completa +
                    '</option>' + contenidoInstalaciones;
            }
            if (instalaciones.length === 0) {
                contenidoInstalaciones = '<option value="" disabled selected>Sin instalaciones registradas</option>';
            }
            contenidoInstalaciones =
                '<option value="" disabled selected>Seleccione un domicilio de inspección</option>' +
                contenidoInstalaciones;
            $('#id_instalacion_exportacion_edit').html(contenidoInstalaciones);
        }
    }

    function cargarInstalacionesEnvasadoEdit(instalaciones) {
        if (instalaciones !== "" && instalaciones !== null && instalaciones !== undefined) {
            var contenidoInstalaciones = "";
            let seleccionado = "";
            var instalacion_envasado_id = $(".instalacion_envasado_id").val();

            for (let index = 0; index < instalaciones.length; index++) {
                var tipoLimpio = limpiarTipo(instalaciones[index].tipo);

                if (instalacion_envasado_id == instalaciones[index].id_instalacion) {
                    seleccionado = "selected";
                } else {
                    seleccionado = ""; //
                }

                contenidoInstalaciones += `
            <option ${seleccionado} value="${instalaciones[index].id_instalacion}">
                ${tipoLimpio} | ${instalaciones[index].direccion_completa}
            </option>`;
            }
            if (instalaciones.length === 0) {
                contenidoInstalaciones = '<option value="" disabled selected>Sin instalaciones registradas</option>';
            }
            contenidoInstalaciones = '<option value="" disabled selected>Seleccione un domicilio de envasado</option>' +
                contenidoInstalaciones;
            $('#id_nstalaciones_envasado_2_edit').html(contenidoInstalaciones);
        }
    }

    // Función para cargar direcciones
    function cargarDireccionesEdit(direcciones) {
        if (direcciones !== "" && direcciones !== null && direcciones !== undefined) {
            var contenidoDirecciones = "";
            let seleccionado = "";
            var direccion_id = $(".direccion_id").val();

            for (let index = 0; index < direcciones.length; index++) {

                if (direccion_id == direcciones[index].id_direccion) {
                    seleccionado = "selected";
                } else {
                    seleccionado = ""; // Asegúrate de limpiar este valor si no coincide
                }

                let destinatario = direcciones[index].destinatario || "Sin destinatario";
                contenidoDirecciones += `
            <option ${seleccionado} value="${direcciones[index].id_direccion}">
                ${destinatario} | ${direcciones[index].direccion}
            </option>`;
            }
            if (direcciones.length === 0) {
                contenidoDirecciones = '<option value="" disabled selected>Sin direcciones registradas</option>';
            }
            contenidoDirecciones =
                '<option value="" disabled selected>Seleccione un domicililio del destinatario</option>' +
                contenidoDirecciones;
            $('#direccion_destinatario_ex_edit').html(contenidoDirecciones);
            //cargarMarcas();
        }
    }


    // Función para cargar lotes envasados
    function cargarLotesEnvasadoEdit(lotesEnvasado, marcas) {
        var contenidoLotes = "";
        for (let index = 0; index < lotesEnvasado.length; index++) {
            var skuLimpiot = limpiarSku(lotesEnvasado[index].sku);
            var skuLimpio = (skuLimpiot === '{"inicial":""}') ? "SKU no definido" : skuLimpiot;
            var marcaEncontrada = marcas.find(marca => marca.id_marca === lotesEnvasado[index].id_marca);
            var nombreMarca = marcaEncontrada ? marcaEncontrada.marca : "Sin marca";
            var dictamenEnvasado = lotesEnvasado[index].dictamen_envasado?.num_dictamen ??
                "Sin dictamen de envasado";


            contenidoLotes += `
            <option data-id-marca-edit="${marcaEncontrada ? marcaEncontrada.id_marca : ''}" value="${lotesEnvasado[index].id_lote_envasado}">
                ${skuLimpio} ${lotesEnvasado[index].nombre} ${nombreMarca} ${dictamenEnvasado}
            </option>`;
        }
        if (lotesEnvasado.length === 0) {
            contenidoLotes = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
        }
        $('.evasado_export_edit').html(contenidoLotes);
        const idlotePrevio = $('#lote_envasado_edit_0').data('selected');
        if (idlotePrevio) {
            $('#lote_envasado_edit_0').val(idlotePrevio);
        } else if (response.lotesEnvasado.length == 0) {}

        /*  cargarDetallesLoteEnvasadoEdit($(".evasado_export_edit").val()); */
    }

    function compararLotesConSelects() {
        var idsLotes = $('.lote_envasado_id').val().split(',');

        $('.evasado_export').each(function() {
            var $select = $(this);
            var opciones = $select.find('option');

            var encontrado = false;

            opciones.each(function() {
                var valorOption = $(this).val();

                if (idsLotes.includes(valorOption)) {
                    $(this).prop('selected',
                        true); // <<< Aquí hacemos que se seleccione automáticamente
                    encontrado = true;
                    //console.log('Seleccionado lote envasado:', valorOption);
                    return false; // Ya encontró, no sigue revisando
                }
            });

            if (!encontrado) {
                $select.prop('selectedIndex', 0); // Si no encuentra, deja el primero (o ninguno)
            }

            $select.trigger('change'); // Disparar el evento por si necesitas recargar detalles
        });
    }


    // Función para cargar lotes a granel
    function cargarLotesGranelEdit(lotesGranel) {
        /* ESTA FUNCION NO SE OCUPA */
        if (lotesGranel !== "" && lotesGranel !== null && lotesGranel !== undefined) {
            var contenidoLotesGraneles = "";
            for (let index = 0; index < lotesGranel.length; index++) {
                contenidoLotesGraneles += `
            <option value="${lotesGranel[index].id_lote_granel}">
                ${lotesGranel[index].nombre_lote}
            </option>`;
            }
            if (lotesGranel.length === 0) {
                contenidoLotesGraneles = '<option value="" disabled selected>Sin lotes granel registrados</option>';
            }
            $('.lotes_granel_export_edit').html(contenidoLotesGraneles);
        }
    }


    function cargarDetallesLoteEnvasadoEdit2(idLoteEnvasado) {
        if (!$('#editPedidoExportacion').is(':visible')) {
            return; // No hagas nada si el modal no está abierto
        }
        if (idLoteEnvasado) {
            $.ajax({
                url: '/getDetalleLoteEnvasado/' + idLoteEnvasado,
                method: 'GET',
                success: function(response) {
                    console.log(response); // Verifica la respuesta en la consola
                    console.log("Entro en el de modal edit");

                    let tbody = $('#tablaLotes tbody');
                    tbody.empty(); // Limpia los datos anteriores

                    // Verifica si existe lote_envasado y lo muestra en la tabla
                    if (response.lote_envasado) {
                        $(".presentacion").val(response.lote_envasado.presentacion + " " + response
                            .lote_envasado.unidad);
                        $(".cantidad_botellas0").val(response.lote_envasado.cant_botellas);
                        let filaEnvasado = `
                        <tr>
                            <td>1</td>
                            <td>${response.lote_envasado.nombre}</td>
                            <td>${limpiarSku(response.lote_envasado.sku) == '{"inicial":""}' ? "SKU no definido" : limpiarSku(response.lote_envasado.sku)}</td>
                            <td>${response.lote_envasado.presentacion || 'N/A'} ${response.lote_envasado.unidad || ''}</td>

                            <td>Botellas: ${response.lote_envasado.cant_botellas}
                        </tr>`;
                        tbody.append(filaEnvasado);
                    }

                    // Verifica si hay lotes a granel asociados y los muestra
                    if (response.detalle && response.detalle.length > 0) {
                        tbody.append(`
                          <tr style="background-color: #f5f5f7;">
                              <th>#</th>
                              <th>Nombre de lote a granel</th>
                              <th>Folio FQ</th>
                              <th>Cont. Alc.</th>
                              <th>Categoría / Clase / Tipos de Maguey</th>
                          </tr>`);
                        let nombre_lote_granel = "";
                        response.detalle.forEach((lote, index) => {
                            let filaGranel = `
                            <tr>
                                <td>${index + 2}</td>
                                <td>
                                ${lote.nombre_lote}<br>
                                <b>Certificado: </b>
                                ${lote.certificado_granel ? lote.certificado_granel.num_certificado : 'Sin definir'}
                                </td>
                                  <td>
                                    <input type="text" class="form-control form-control-sm" name="folio_fq[]" value="${lote.folio_fq || ''}" />
                                  </td>

                                  <td>
                                    <input type="text" class="form-control form-control-sm" name="cont_alc[]" value="${lote.cont_alc || ''}" />
                                  </td>
                               <td>
                                ${lote.categoria.categoria || 'N/A'}<br>
                                ${lote.clase.clase || 'N/A'}<br>
                                ${lote.tiposMaguey.length ? lote.tiposMaguey.map(tipo => tipo.nombre + ' (<i>'+tipo.cientifico+'</i>)').join('<br>') : 'N/A'}
                            </td>

                            </tr>`;
                            tbody.append(filaGranel);
                            nombre_lote_granel += lote.nombre_lote;
                        });

                        $('.lotes_granel_export_edit').val(nombre_lote_granel);


                    } else {
                        tbody.append(
                            `<tr><td colspan="4" class="text-center">No hay lotes a granel asociados</td></tr>`
                        );
                    }
                    cargarMarcasEdit();
                },
                error: function() {
                    console.error('Error al cargar el detalle del lote envasado.');
                }
            });
        }
    }


    // Función para limpiar el campo tipo
    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }

    // Función para limpiar SKU
    function limpiarSku(sku) {
        try {
            let parsedSku = JSON.parse(sku);
            return parsedSku && parsedSku.inicial ? parsedSku.inicial : sku;
        } catch (e) {
            return 'Sin definir';
        }
    }



    function cargarMarcasEdit() {
        var id_empresa = $('#id_empresa_solicitud_exportacion_edit').val();
        var id_marca = $('.evasado_export_edit').find(':selected').data('id-marca-edit');
        var id_direccion = $('#direccion_destinatario_ex_edit').val();
        //alert('/marcas/' + id_marca + '/' + id_direccion)
        let seleccionado = "";
        var etiqueta_id = $(".etiqueta_id").val();
        if (id_empresa) {

            $.ajax({
                url: '/marcas/' + id_marca + '/' + id_direccion,
                method: 'GET',
                success: function(marcas) {
                    var tbody = '';

                    // Verificar si hay datos disponibles
                    if (marcas.length > 0 && marcas[0].destinos.length > 0) {
                        $("#encabezado_etiquetas_edit").text(marcas[0].destinos[0].direccion);
                    }

                    tbody = "";

                    // Asegurar que 'etiquetado' es un objeto



                    // Iterar sobre los SKU en 'etiquetado'
                    for (var i = 0; i < marcas.length; i++) {

                        if (etiqueta_id == marcas[i].id_etiqueta) {
                            seleccionado = 'checked';
                        } else {
                            seleccionado = '';
                        }

                        tbody += '<tr>';

                        // Radio button
                        tbody += `
                            <td class="mb-4">
                                <div class="form-check form-check-inline">
                                    <input ${seleccionado} class="form-check-input" type="radio" name="id_etiqueta" id="radio_${marcas[i].id_etiqueta}" value="${marcas[i].id_etiqueta}" />
                                </div>
                            </td>
                        `;

                        // SKU
                        tbody += `<td>${marcas[i].sku || 'N/A'}</td>`;

                        // Tipo
                        tbody +=
                            `<td>${
                            marcas[i].tipos_info && marcas[i].tipos_info.length
                              ? marcas[i].tipos_info.map(
                                  tipo => `${tipo.nombre} (<i>${tipo.cientifico}</i>)`
                                ).join(', ')
                              : 'N/A'
                          }</td>`;


                        // Presentación
                        tbody += `<td>${marcas[i].presentacion || 'N/A'} ${marcas[i].unidad || ''}</td>`;

                        // Clase
                        tbody += `<td>${marcas[i].clase.clase || 'N/A'}</td>`;

                        // Categoría
                        tbody += `<td>${marcas[i].categoria.categoria || 'N/A'}</td>`;

                        // Función para generar enlace de documentos
                        function generarEnlaceDocumento(documento, nombre) {
                            if (documento && documento.url) {
                                let url =
                                    `/files/${marcas[i].marca.empresa.empresa_num_clientes[0].numero_cliente}/${documento.url}`;
                                return `<td><a href="${url}" target="_blank"><i class="ri-file-pdf-2-line ri-20px"></i></a></td>`;
                            }
                            return `<td>--</td>`;
                        }

                        // Enlaces a Etiqueta y Corrugado
                        tbody += generarEnlaceDocumento(marcas[i].url_etiqueta, "Etiqueta");
                        tbody += generarEnlaceDocumento(marcas[i].url_corrugado, "Corrugado");

                        tbody += '</tr>';
                    }


                    // Si no hay datos, mostrar mensaje
                    if (!tbody) {
                        tbody =
                            '<tr><td colspan="8" class="text-center">No hay datos disponibles.</td></tr>';
                    }

                    // Insertar las filas en la tabla
                    $('#tabla_marcas tbody').html(tbody);
                },
                error: function(xhr) {
                    console.error('Error al obtener marcas:', xhr);
                    $('#tabla_marcas tbody').html(
                        '<tr><td colspan="8">Error al cargar los datos</td></tr>');
                }
            });
        } else {
            $('#tabla_marcas tbody').html('<tr><td colspan="8">Seleccione una empresa para ver los datos</td></tr>');
        }
    }

    // Función para llenar campos en editar
    function cargarDetallesLoteEnvasadoDinamicoEdit(select, sectionCountEdit) {
        var idLoteEnvasado = $(select).val();
        if (idLoteEnvasado) {
            $.ajax({
                url: '/getDetalleLoteEnvasado/' + idLoteEnvasado,
                method: 'GET',
                success: function(response) {
                    $(`#lote_granel_edit_${sectionCountEdit}`).val(
                        response.detalle && response.detalle.length > 0 ?
                        response.detalle.map(lote => lote.nombre_lote).join(', ') :
                        ''
                    );
                    // Genera la tabla de lotes a granel asociados en la sección correspondiente
                    let $tabla = $(`#tablaLotes_edit_${sectionCountEdit}`);
                    if ($tabla.length === 0) {
                        // Si no existe la tabla, créala dinámicamente en el contenedor correcto
                        $(`#caracteristicas_Ex_edit_${sectionCountEdit} .card-body`).append(`
                          <table id="tablaLotes_edit_${sectionCountEdit}" class="table table-bordered table-sm mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Certificado</th>
                                    <th>Folio FQ</th>
                                    <th>Cont. Alc.</th>
                                    <th>Categoría / Clase / Tipos de Maguey</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    `);
                        $tabla = $(`#tablaLotes_edit_${sectionCountEdit}`);
                    }
                    let $tbody = $tabla.find('tbody');
                    $tbody.empty();

                    if (response.detalle && response.detalle.length > 0) {
                        response.detalle.forEach((lote, index) => {
                            $tbody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    ${lote.nombre_lote}<br>
                                    <b>Certificado: </b>
                                    ${lote.certificado_granel ? lote.certificado_granel.num_certificado : 'Sin definir'}
                                </td>
                                <td>${lote.folio_fq || ''}</td>
                                <td>${lote.cont_alc || ''}</td>
                                <td>
                                    ${lote.categoria?.categoria || 'N/A'}<br>
                                    ${lote.clase?.clase || 'N/A'}<br>
                                    ${
                                        lote.tiposMaguey && lote.tiposMaguey.length
                                            ? lote.tiposMaguey.map(tipo => `${tipo.nombre} (<i>${tipo.cientifico}</i>)`).join('<br>')
                                            : 'N/A'
                                    }
                                </td>
                            </tr>
                        `);
                        });
                    } else {
                        $tbody.append(
                            `<tr><td colspan="8" class="text-center">No hay lotes a granel asociados</td></tr>`
                        );
                    }

                },
                error: function() {
                    console.error('Error al cargar el detalle del lote envasado.');
                }
            });
        }
    }

    // Función para llenar campos en editar
    /*     function cargarDetallesLoteEnvasadoDinamicoEdit2(select, sectionCountEdit) {
            var idLoteEnvasado = $(select).val();
            if (idLoteEnvasado) {
                $.ajax({
                    url: '/getDetalleLoteEnvasado/' + idLoteEnvasado,
                    method: 'GET',
                    success: function(response) {
                        $(`#lote_granel_edit_${sectionCountEdit}`).val(
                            response.detalle && response.detalle.length > 0 ?
                            response.detalle.map(lote => lote.nombre_lote).join(', ') :
                            ''
                        );

                        // Genera la tabla de lotes a granel asociados en la sección correspondiente
                          let $tabla = $(`#tablaLotes_edit_${sectionCountEdit}`);
                    if ($tabla.length === 0) {
                        // Si no existe la tabla, créala dinámicamente en el contenedor correcto
                        $(`#caracteristicas_Ex_edit_ .card-body`).append(`
                            <table id="tablaLotes_edit_${sectionCountEdit}" class="table table-bordered table-sm mt-3">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Certificado</th>
                                        <th>Folio FQ</th>
                                        <th>Cont. Alc.</th>
                                        <th>Categoría / Clase / Tipos de Maguey</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        `);
                        $tabla = $(`#tablaLotes_edit_${sectionCountEdit}`);
                    }
                    let $tbody = $tabla.find('tbody');
                    $tbody.empty();

                    if (response.detalle && response.detalle.length > 0) {
                        response.detalle.forEach((lote, index) => {
                            $tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>
                                        ${lote.nombre_lote}<br>
                                        <b>Certificado: </b>
                                        ${lote.certificado_granel ? lote.certificado_granel.num_certificado : 'Sin definir'}
                                    </td>
                                    <td>${lote.folio_fq || ''}</td>
                                    <td>${lote.cont_alc || ''}</td>
                                    <td>
                                        ${lote.categoria?.categoria || 'N/A'}<br>
                                        ${lote.clase?.clase || 'N/A'}<br>
                                        ${
                                            lote.tiposMaguey && lote.tiposMaguey.length
                                                ? lote.tiposMaguey.map(tipo => `${tipo.nombre} (<i>${tipo.cientifico}</i>)`).join('<br>')
                                                : 'N/A'
                                        }
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $tbody.append(
                            `<tr><td colspan="8" class="text-center">No hay lotes a granel asociados</td></tr>`
                        );
                    }
                    },
                    error: function() {
                        console.error('Error al cargar el detalle del lote envasado.');
                    }
                });
            }
        } */
</script>
