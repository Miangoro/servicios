<div class="modal fade" id="editVigilanciaProduccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Editar solicitud de Vigilancia en producción de lote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <p class="solicitud badge bg-primary"></p>
                <form id="editVigilanciaProduccionForm">
                    <input type="hidden" name="id_solicitud" id="edit_id_solicitud_vig">
                    <input type="hidden" name="form_type" value="vigilanciaenproduccion">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="obtenerGranelesInsta2(this.value);" id="edit_id_empresa_vig"
                                    name="id_empresa" class="select2 form-select">
                                    <option value="" selected disabled>Selecciona Empresa</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Empresa</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime"
                                    id="edit_fecha_visita_vig" type="text" name="fecha_visita" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6 ">
                                <select class=" form-select select2 id_instalacion" id="edit_id_instalacion_vig"
                                    name="id_instalacion" aria-label="id_instalacion">
                                    <option value="" disabled selected>Lista de instalaciones</option>
                                </select>
                                <label for="id_instalacion">Instalaciones</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_nombre_produccion"
                                    name="nombre_produccion" placeholder="Nombre de la producción o tapada" required />
                                <label for="nombre_produccion">Nombre de la producción o tapada</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_etapa_proceso" name="etapa_proceso"
                                    placeholder="Etapa del proceso" required />
                                <label for="etapa_proceso">Etapa del proceso (cocción, molienda, etc.)</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_cantidad_pinas"
                                    name="cantidad_pinas" placeholder="Cantidad de piñas" required />
                                <label for="cantidad_pinas">Cantidad de piñas</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="file" class="form-control" id="edit_documento_guias"
                                    name="documento_guias[]" multiple>
                                <label for="documento_guias">Adjuntar guía(s) en PDF</label>
                            </div>
                        </div>
                        <div class="linksGuias mb-3">

                        </div>
                    </div>

                    {{--                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="obtenerDatosGranelesedit();" id="edit_id_lote_granel_vig"
                                    name="id_lote_granel" class="select2 form-select">
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($LotesGranel as $lotesgra)
                                        <option value="{{ $lotesgra->id_lote_granel }}">{{ $lotesgra->nombre_lote }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_lote_granel">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select form-select " id="edit_id_categoria_vig" name="id_categoria"
                                    aria-label="id_categoria">
                                    <option value="">Lista de categorias</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_categoria">Categoria</label>
                            </div>
                        </div>
                    </div> --}}
                    {{--
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class="select form-select " id="edit_id_clase_vig" name="id_clase"
                                    aria-label="id_clase">
                                    <option value="">Lista de clases</option>
                                    @foreach ($clases as $clases)
                                        <option value="{{ $clases->id_clase }}">{{ $clases->clase }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_clase">Clase</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class="select2 form-select" id="edit_id_tipo_vig" name="edit_id_tipo_vig[]"
                                    aria-label="id_tipo" multiple>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }} |
                                            {{ $tipo->cientifico }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_tipo">Ingresa tipo de Maguey</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_analisis_vig" name="analisis"
                                    placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis">Ingresa Análisis fisicoquímico</label>
                            </div>
                        </div>
                    </div> --}}
                    {{--                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_volumen_vig" name="volumen"
                                    placeholder="Ingresa el volumen" />
                                <label for="volumen">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime"
                                    id="edit_fecha_corte_vig" type="text" name="fecha_corte" />
                                <label for="fecha_corte">Fecha de corte</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_kg_maguey_vig" name="kg_maguey"
                                    placeholder="Ingresa la cantidad de maguey" />
                                <label for="kg_maguey">Kg. de maguey</label>
                            </div>
                        </div>
                    </div> --}}
                    {{--                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_cant_pinas_vig"
                                    name="cant_pinas" placeholder="Ingrese la cantidad de piñas">
                                <label for="cant_pinas">Cantidad de piñas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="edit_art_vig" name="art"
                                    placeholder="Ingrese la cantidad de azúcares" step="0.01">
                                <label for="art">% de azúcares ART totales</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_etapa_vig" name="etapa"
                                    placeholder="Ingrese la etapa de proceso">
                                <label for="etapa">Etapa de proceso en la que se encuentra</label>
                            </div>
                        </div>
                    </div> --}}
                    {{--                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <!-- Select para seleccionar múltiples guías -->
                                <select multiple class="select2 form-select" id="edit_edit_id_guias_vigiP"
                                    name="id_guias[]">

                                </select>
                                <label for="edit_edit_id_guias_vigiP">Guías de agave expedidas por OC CIDAM</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="edit_nombre_predio_vig"
                                    name="nombre_predio" placeholder="Ingrese el predio de procedencia">
                                <label for="nombre_predio">Predio de la procedencia</label>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="edit_info_adicional_vig"
                                placeholder="Observaciones..."></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary me-1 d-none" type="button"
                            id="btnSpinnerEditVigilanciaProduccion">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Actualizando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnEditVigiProd"><i
                                class="ri-pencil-fill me-1"></i> Editar</button>
                        <button type="reset" class="btn btn-danger " data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
            </div>

            </form>
        </div>
    </div>
</div>

<script>
    function obtenerGranelesInsta2(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = "";
                    for (let index = 0; index < response.instalaciones.length; index++) {
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);
                        contenido = '<option value="' + response.instalaciones[index].id_instalacion +
                            '">' +
                            tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>' +
                            contenido;
                    }
                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }
                    $('.id_instalacion').html(contenido);

                    const idInsPrevio = $('#edit_id_instalacion_vig').data('selected');
                    if (idInsPrevio) {
                        $('#edit_id_instalacion_vig').val(idInsPrevio);
                    }

                },
                error: function() {
                    console.error('Error al obtener las instalaciones.');
                }
            });
        }
    }

    /*     function limpiarTipo(tipo) {
            try {
                return JSON.parse(tipo).join(', ');
            } catch (e) {
                return tipo;
            }
        } */
</script>
