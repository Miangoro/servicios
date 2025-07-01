<!-- MODAL AGREGAR -->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Nuevo dictamen a granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormAgregar" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select onchange="cargarLotes()" id="id_inspeccion" name="id_inspeccion"
                                    class="select2 form-select" data-placeholder="Selecciona el número de servicio">
                                    <option value="" disabled selected> </option>
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
                                    placeholder="No. de dictamen" value="UMG-">
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
                                <input class="form-control" id="fecha_vigencia" name="fecha_vigencia"
                                    placeholder="YYYY-MM-DD" readonly>
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mt-2 text-center fw-bold">Información del Lote a granel</h5>
                    <hr>
                    <div class="row mt-6">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input required class="form-control nombre_lote" name="nombre_lote">
                                <label for="">Nombre de lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input required class="form-control volumen" name="volumen">
                                <label for="">Volumen del lote</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select name="id_categoria" class="form-select id_categoria">
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}</option>
                                    @endforeach
                                </select>
                                <label for="id_categoria">Categoría de Mezcal</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select name="id_clase" class="form-select id_clase" data-error-message="Por favor selecciona una clase">
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                <label for="clase_agave">Clase de mezcal</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                              <div class="form-floating form-floating-outline mb-4">
                                  <select name="id_tipo[]" class="select2 form-select id_tipo" multiple>
                                      @foreach ($tipos as $tipo)
                                          <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }} ({{ $tipo->cientifico }})</option>
                                      @endforeach
                                  </select>
                                  <label for="tipo_agave">Tipo de Agave</label>
                              </div>
                          </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input required class="form-control folio_fq" name="folio_fq">
                                <label for="">Análisis FQ</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input required class="form-control cont_alc" name="cont_alc">
                                <label for="">% Alc. Vo.</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control edad" name="edad" placeholder="Edad no obligatoria">
                                <label for="">Edad</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control ingredientes" name="ingredientes" placeholder="Ingrediente no obligatorio">
                                <label for="">Ingredientes</label>
                            </div>
                        </div>
                    </div>

                   <div class="row">
                    <!-- Columna: Análisis FQ completo -->
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="file" class="form-control form-control-sm" name="analisis_completo">
                            <label for="">Archivo de análisis FQ completo</label>
                        </div>
                        <div class="archivo_fq_completo d-flex align-items-center gap-3 mt-2 flex-wrap"></div>
                    </div>

                    <!-- Columna: Análisis FQ ajuste -->
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="file" class="form-control form-control-sm" name="analisis_ajuste">
                            <label for="">Archivo de análisis FQ de ajuste</label>
                        </div>
                        <div class="archivo_fq_ajuste d-flex align-items-center gap-3 mt-2 flex-wrap"></div>
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
                <h5 class="modal-title text-white">Editar dictamen a granel</h5>
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
                                    <option value="" disabled selected> </option>
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
                                <input class="form-control" id="edit_fecha_vigencia" name="fecha_vigencia"
                                    placeholder="YYYY-MM-DD" readonly>
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>

                   <hr>
                    <h5 class="mt-2 text-center fw-bold">Información del Lote a granel</h5>
                    <hr>
                    <div class="row mt-6">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input required class="form-control nombre_lote" name="nombre_lote">
                                <label for="">Nombre de lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input required class="form-control volumen" name="volumen">
                                <label for="">Volumen del lote</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select name="id_categoria" class="form-select id_categoria">
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}</option>
                                    @endforeach
                                </select>
                                <label for="id_categoria">Categoría de Mezcal</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select name="id_clase" class="form-select id_clase" data-error-message="Por favor selecciona una clase">
                                    @foreach ($clases as $clase)
                                        <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                    @endforeach
                                </select>
                                <label for="clase_agave">Clase de mezcal</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                              <div class="form-floating form-floating-outline mb-4">
                                  <select name="id_tipo[]" class="select2 form-select id_tipo" multiple>
                                      @foreach ($tipos as $tipo)
                                          <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }} ({{ $tipo->cientifico }})</option>
                                      @endforeach
                                  </select>
                                  <label for="tipo_agave">Tipo de Agave</label>
                              </div>
                          </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input required class="form-control folio_fq" name="folio_fq">
                                <label for="">Análisis FQ</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input required class="form-control cont_alc" name="cont_alc">
                                <label for="">% Alc. Vo.</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control edad" name="edad" placeholder="Edad no obligatoria">
                                <label for="">Edad</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control ingredientes" name="ingredientes" placeholder="Ingrediente no obligatorio">
                                <label for="">Ingredientes</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                    <!-- Columna: Análisis FQ completo -->
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="file" class="form-control form-control-sm" name="analisis_completo">
                            <label for="">Archivo de análisis FQ completo</label>
                        </div>
                        <div class="archivo_fq_completo d-flex align-items-center gap-3 mt-2 flex-wrap"></div>
                    </div>

                    <!-- Columna: Análisis FQ ajuste -->
                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="file" class="form-control form-control-sm" name="analisis_ajuste">
                            <label for="">Archivo de análisis FQ de ajuste</label>
                        </div>
                        <div class="archivo_fq_ajuste d-flex align-items-center gap-3 mt-2 flex-wrap"></div>
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
        console.log('/getDatosLotes/' + id_inspeccion);
        if (id_inspeccion) {
            $.ajax({
                url: '/getDatosLotes/' + id_inspeccion,
                method: 'GET',
                dataType: 'json', // Especificar que la respuesta es JSON
                success: function(response) {
                    if (response && response.solicitud && response.solicitud.lote_granel) {
                        const lote = response.solicitud.lote_granel;

                        $('.nombre_lote').val(lote.nombre_lote);
                        $('.folio_fq').val(lote.folio_fq.replace(/,\s*$/, ''));
                        $('.volumen').val(lote.volumen);
                        $('.cont_alc').val(lote.cont_alc);
                        $('.edad').val(lote.edad);
                        $('.ingredientes').val(lote.ingredientes);
                        $('.id_categoria').val(lote.id_categoria);
                        $('.id_clase').val(lote.id_clase);
                        let tipos = JSON.parse(lote.id_tipo); // Convierte "[\"8\"]" en ["8"]
                        $('.id_tipo').val(tipos).change();    
                       /* let valorOriginal = lote.folio_fq || '';
                        let valoresLimpios = valorOriginal
                            .trim()
                            .replace(/,\s*$/, '')
                            .split(',')
                            .map(v => v.trim())
                            .filter(v => v !== '');

                      
                        $('.fq_completo').val(valoresLimpios[0] || ''); // Primer valor, si existe
                        $('.fq_ajuste').val(valoresLimpios[1] || '');   // Segundo valor, si existe*/

                        if(lote.fqs[0]){
                         $('.archivo_fq_completo').html('<a href="/files/'+response.solicitud.empresa.empresa_num_clientes[0].numero_cliente+'/fqs/'+lote.fqs[0].url +'" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>'); // Primer valor, si existe
                            
                         }else{
                              $('.archivo_fq_completo').empty();
                         }

                         if(lote.fqs[1]){
                         $('.archivo_fq_ajuste').html('<a href="/files/'+response.solicitud.empresa.empresa_num_clientes[0].numero_cliente+'/fqs/'+lote.fqs[1].url +'" target="_blank"><i class="ri-file-pdf-2-fill ri-40px text-danger"></i></a>'); // Primer valor, si existe
                            
                         }else{
                              $('.archivo_fq_ajuste').empty();
                         }

                    } else {
                        console.warn("No se encontró el lote_granel en la respuesta.");
                    }
                },
                error: function(xhr) {
                    console.error('Error al obtener marcas:', xhr);
                    $('#tabla_marcas tbody').html(
                        '<tr><td colspan="8">Error al cargar los datos</td></tr>');
                }
            });
        }else{
            $('.nombre_lote').val('');
            $('.folio_fq').val('');
            $('.volumen').val('');
            $('.cont_alc').val('');
            $('.edad').val('');
            $('.ingredientes').val('');
            $('.id_categoria').val('');
            $('.id_clase').val('');
            $('.id_tipo').val([]).change();
            $('.archivo_fq_completo').empty();
            $('.archivo_fq_ajuste').empty();

        }
    }
</script>
