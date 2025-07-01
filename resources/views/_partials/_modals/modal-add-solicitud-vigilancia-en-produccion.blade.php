<div class="modal fade" id="addVigilanciaProduccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Registrar nueva solicitud de vigilancia en producción de lote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form id="addVigilanciaProduccionForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_vigilancia" onchange="obtenerGranelesInsta(this.value);"
                                    name="id_empresa" class="id_empresa select2 form-select" required>
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
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime"
                                    id="fecha_visita_vigi" type="text" name="fecha_visita" autocomplete="off" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class=" form-select select2 id_instalacion" name="id_instalacion"
                                    aria-label="id_instalacion" id="id_instalacion_vigi">
                                    <option value="" disabled selected>Lista de instalaciones</option>
                                </select>
                                <label for="id_instalacion">Instalaciones</label>
                            </div>
                        </div>
                    </div>
                    {{-- segunda sección correcion --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="nombre_produccion"
                                    name="nombre_produccion" placeholder="Nombre de la producción o tapada" required />
                                <label for="nombre_produccion">Nombre de la producción o tapada</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="etapa_proceso" name="etapa_proceso"
                                    placeholder="Etapa del proceso" required />
                                <label for="etapa_proceso">Etapa del proceso (cocción, molienda, etc.)</label>
                            </div>
                        </div>
                    </div>

                    {{--                   <div class="row">
                      <div class="col-md-6">
                          <div class="form-floating form-floating-outline mb-5">
                              <select multiple class="select2 form-select" id="id_guias_vigilancia" name="id_guias[]" required>
                                  <!-- Opciones se llenan dinámicamente -->
                              </select>
                              <label for="id_guias_vigilancia">Guías de agave empleadas</label>
                          </div>
                      </div>
                  </div> --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="cantidad_pinas" name="cantidad_pinas"
                                    placeholder="Cantidad de piñas" required />
                                <label for="cantidad_pinas">Cantidad de piñas</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="file" class="form-control" id="documento_guias" name="documento_guias[]"
                                    multiple>
                                <label for="documento_guias">Adjuntar guía(s) en PDF</label>
                            </div>
                        </div>
                    </div>

                    {{--                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select form-select " id="id_categoria" name="id_categoria"
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

                    {{--                     <div class="row">

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class="select2 form-select" id="id_tipo_maguey" name="id_tipo_maguey[]"
                                    aria-label="id_tipo" multiple>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }} |
                                            {{ $tipo->cientifico }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_tipo_maguey">Ingresa tipo de Maguey</label>
                            </div>
                        </div>

                    </div> --}}
                    {{--                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="volumen" name="volumen"
                                    placeholder="Ingresa el volumen" />
                                <label for="volumen">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime"
                                    id="fecha_corte" type="text" name="fecha_corte" autocomplete="off"/>
                                <label for="fecha_corte">Fecha de corte</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="kg_maguey" name="kg_maguey"
                                    placeholder="Ingresa la cantidad de maguey" autocomplete="off"/>
                                <label for="kg_maguey">Kg. de maguey</label>
                            </div>
                        </div>
                    </div> --}}
                    {{--                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="cant_pinas" name="cant_pinas"
                                    placeholder="Ingrese la cantidad de piñas" autocomplete="off">
                                <label for="cant_pinas">Cantidad de piñas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="art" name="art"
                                    placeholder="Ingrese la cantidad de azúcares" step="0.01" autocomplete="off">
                                <label for="art">% de azúcares ART totales</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="etapa" name="etapa"
                                    placeholder="Ingrese la etapa de proceso" autocomplete="off">
                                <label for="etapa">Etapa de proceso en la que se encuentra</label>
                            </div>
                        </div>
                    </div> --}}
                    {{--                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <!-- Select para seleccionar múltiples guías -->
                                <select multiple class="select2 form-select" id="edit_id_guias_vigiP"
                                    name="id_guias[]">

                                </select>
                                <label for="edit_id_guias_vigiP">Guías de agave expedidas por OC CIDAM</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="nombre_predio" name="nombre_predio"
                                    placeholder="Ingrese el predio de procedencia" autocomplete="off">
                                <label for="nombre_predio">Predio de la procedencia</label>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="info_adicional" placeholder="Observaciones..."
                                autocomplete="off"></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary me-1 d-none" type="button"
                            id="btnSpinnerVigilanciaProduccion">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Registrando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnRegisVigiPro"><i
                                class="ri-add-line me-1"></i>
                            Registrar</button>
                        <button type="reset" class="btn btn-danger btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
            </div>


            </form>
        </div>
    </div>
</div>

<script>
    function obtenerGranelesInsta(empresa) {
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
                },
                error: function() {
                    console.error('Error al obtener las instalaciones.');
                }
            });
        }
    }

    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }
</script>
