<div class="modal fade" id="etiquetas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-add-new-address">
        <div class="modal-content">

            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2"> Subir etiquetas</h4>
                    <p class="subtitulo badge bg-primary"></p>
                </div> --}}
            <div class="modal-header bg-primary pb-4">
                <h5 id="titleSubirEtiquetas" class="modal-title text-white">Subir etiquetas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <form id="etiquetasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <input type="hidden" id="id_etiqueta" name="id_etiqueta">
                        <input type="hidden" id="modo_formulario" value="registrar">

                        <div class="col-sm-12">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="id_empresa" onchange="obtenerdestinos(this.value);" name="id_empresa"
                                    class="select2 form-select">
                                    <option value="" disabled selected>Selecciona el cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-floating form-floating-outline mb-5">
                                <select multiple id="id_destino" name="id_destino[]" class="select2 form-select">
                                    {{-- <option value="" disabled selected> selecciona un destino</option> --}}
                                    {{--                                     @foreach ($destinos as $destino)
                                        <option value="{{ $destino->id_direccion }}">{{ $destino->destinatario }} |
                                            {{ $destino->direccion }}</option>
                                    @endforeach --}}
                                </select>
                                <label for="id_destino">Destinos</label>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-floating form-floating-outline mb-5">
                                <select id="id_marca" name="id_marca" class="select2 form-select" required>
                                  <option value="" disabled selected>Seleccione una marca</option>
{{--                                     @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id_marca }}">{{ $marca->marca }}</option>
                                    @endforeach --}}
                                </select>
                                <label for="id_marca">Marca</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input id="sku" type="text" name="sku" class="form-control"
                                    placeholder="Introduce el sku" />
                                <label for="sku">SKU</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input id="presentacion" type="text" name="presentacion" class="form-control"
                                    placeholder="Introduce el cont. neto" />

                                <label for="presentacion">Cont. Neto</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select id="unidad" class="form-control form-control-sm" name="unidad">
                                    <option value="mL">mL</option>
                                    <option value="L">L</option>
                                    <option value="cL">cL</option>
                                </select>
                                <label for="unidad">Unidad</label>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input id="alc_vol" type="text" name="alc_vol" class="form-control"
                                    placeholder="Introduce el %Alc. Vol." />
                                <label for="alc_vol">%Alc. Vol.</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <select id="id_categoria" name="id_categoria" class="form-select" required>
                                    <option value="" disabled selected>Categoría de mezcal</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_norma">Categoría de mezcal</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <select id="id_clase" name="id_clase" class="select2 form-select" required>
                                    <option value="" disabled selected>Clase de mezcal</option>
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                <label for="id_norma">Clase de agave</label>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-floating form-floating-outline mb-5 select2-primary">
                                <select id="id_tipo" name="id_tipo[]" class="select2 form-select" multiple required>
                                    {{-- <option value="" disabled selected>Tipos de agave</option> --}}
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }}
                                            ({{ $tipo->cientifico }})
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_tipo">Tipos de agave</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input id="botellas_caja" name="botellas_caja" type="number" min="1"
                                    class="form-control" placeholder="Botellas por caja" />
                                <label for="botellas_caja">Botellas por caja</label>
                            </div>
                        </div>


                        <div class="col-md-10  mb-5">
                            <label for="file60" class="form-label">Etiqueta</label>
                            <input class="form-control" type="file" id="file60" data-id="60"
                                name="url_etiqueta">
                            <input value="60" class="form-control" type="hidden" name="id_documento_etiqueta">
                            <input value="Etiqueta" class="form-control" type="hidden"
                                name="nombre_documento_etiqueta">

                        </div>

                        <div class="col-md-2" id="doc_etiqueta"></div>

                        <div class="col-md-10  mb-5">
                            <label for="file75" class="form-label">Corrugado</label>
                            <input class="form-control" type="file" id="file75" data-id="75"
                                name="url_corrugado">
                            <input value="75" class="form-control" type="hidden" name="id_documento_corrugado">
                            <input value="Corrugado" class="form-control" type="hidden"
                                name="nombre_documento_corrugado">
                        </div>
                        <div class="col-md-2" id="doc_corrugado"></div>



                    </div>

                    {{-- <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancelar</button>
                        </div> --}}
                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" id="subirBtnEtiqueta" class="btn btn-primary me-2"><i class="ri-add-line mb-1"></i>
                            Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>

function obtenerdestinos(empresa, destinoSeleccionado = null, marcaSeleccionada = null) {
    if (empresa !== "" && empresa !== null && empresa !== undefined) {
        $.ajax({
            url: '/destinos-por-empresa/' + empresa,
            method: 'GET',
            success: function(data) {
                // Llenar destinos
                const $destinoSelect = $('#id_destino');
                let opcionesDestino = '';
                $destinoSelect.val(null).trigger('change');
                if (!data.destinos.length) {
                    opcionesDestino = '<option value="" disabled selected>Sin direcciones registradas</option>';
                } else {
                    data.destinos.forEach(destino => {
                        opcionesDestino += `<option value="${destino.id_direccion}">${destino.destinatario} | ${destino.direccion}</option>`;
                    });
                }

                $destinoSelect.html(opcionesDestino);

                // ✅ Reasignar destino si viene como parámetro
                if (destinoSeleccionado) {
                    $destinoSelect.val(destinoSeleccionado).trigger('change');
                }

                // Llenar marcas
                const $marcaSelect = $('#id_marca');
                let opcionesMarca = '';

                if (!data.marcas.length) {
                    opcionesMarca = '<option value="" disabled selected>Sin marcas registradas</option>';
                } else {
                    data.marcas.forEach(marca => {
                        opcionesMarca += `<option value="${marca.id_marca}">${marca.marca}</option>`;
                    });
                }

                $marcaSelect.html(opcionesMarca);

                // ✅ Reasignar marca si viene como parámetro
                if (marcaSeleccionada) {
                    $marcaSelect.val(marcaSeleccionada).trigger('change');
                }
            },
            error: function() {
                alert('Error al cargar direcciones de destino y marcas.');
            }
        });
    }
}

</script>
