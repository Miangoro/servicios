<!-- Modal para agregar nuevo lote -->
<div class="modal fade" id="offcanvasAddLote" tabindex="-1" aria-labelledby="offcanvasAddLoteLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 {{-- id="offcanvasAddLoteLabel" --}} class="modal-title text-white">Registro de Lote a Granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                {{--  --}}
                <form id="loteForm" method="POST" action="{{ route('lotes-register.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Nombre del lote -->
                    <div class="form-section mb-4 p-3 border rounded">
                        <h6 class="mb-3">Información del Lote</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select onchange="obtenerDatosEmpresa()" id="id_empresa" name="id_empresa"
                                        class="select2 form-select"
                                        data-error-message="por favor selecciona la empresa">
                                        <option value="" disabled selected>Selecciona el cliente</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id_empresa }}">
                                                {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                                | {{ $empresa->razon_social }}</option>
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_empresa" class="form-label">Cliente</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="nombre_lote" name="nombre_lote" class="form-control"
                                        autocomplete="off" placeholder="Nombre del lote"
                                        data-error-message="por favor selecciona el lote" />
                                    <label for="nombre_lote">Nombre del Lote</label>
                                </div>
                            </div>

                        </div>
                        <!-- Campo para seleccionar lote original -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="tipo_lote" name="tipo_lote" class=" form-select"
                                        data-error-message="Por favor selecciona el tipo de lote">
                                        <option value="" disabled selected>Selecciona el tipo de lote</option>
                                        <option value="1">Certificación por OC CIDAM</option>
                                        <option value="2">Certificado por otro organismo</option>
                                    </select>
                                    <label for="tipo_lote">Tipo de Lote</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="es_creado_a_partir" name="es_creado_a_partir" class="form-select">
                                        <option value="" disabled selected>¿Creado a partir de otro lote?</option>
                                        <option value="no">No</option>
                                        <option value="si">Sí</option>
                                    </select>
                                    <label for="es_creado_a_partir" class="form-label">¿Creado a partir de otro
                                        lote?</label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="id_tanque" name="id_tanque"
                                        placeholder="ID del Tanque(s)" aria-label="ID del Tanque">
                                    <label for="id_tanque">ID del Tanque(s)</label>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div id="addLotes" class="d-none">
                        <table class="table table-bordered shadow-lg">
                            <thead>
                                <tr>
                                    <th style="width: 30px"><button type="button"
                                            class="btn btn-primary add-row-lotes"> <i class="ri-add-line"></i> </button>
                                    </th>
                                    <th style="width: 70%">Lote a granel</th>
                                    <th>Volumen parcial</th>
                                </tr>
                            </thead>
                            <tbody id="contenidoGraneles">
                                {{--                               <tr data-row-index="0">
                                  <th>
                                      <button type="button" class="btn btn-danger" disabled>
                                          <i class="ri-delete-bin-5-fill"></i>
                                      </button>
                                  </th>
                                  <td>
                                      <select class="id_lote_granel select2" name="lote[0][id]" id="id_lote_granel_0">
                                          <!-- Opciones -->
                                      </select>
                                  </td>
                                  <td>
                                      <input type="text" class="form-control form-control-sm volumen-parcial"
                                             name="volumenes[0][volumen_parcial]" id="volumen_parcial_0">
                                  </td>
                              </tr> --}}
                            </tbody>
                        </table>
                    </div>


                    <div class="form-section mb-4 p-3 border rounded">
                        <!-- Sección para información del lote -->
                        <h6 class="mb-3">Detalles del Lote</h6>
                        <div class="row">
                            <div class="col-md-6 d-none" id="mostrar_guias">
                                <div class="d-flex align-items-center mb-3 input-group input-group-merge">
                                    <div class="flex-grow-1">
                                        <select id="id_guia" name="id_guia[]" class="select2 form-select" multiple
                                            data-error-message="Por favor selecciona una guia">
                                            {{-- <option value="" disabled selected>Seleccione una guía</option> --}}
                                        </select>
                                    </div>
                                    <a href="../guias/guias_de_agave" class="btn btn-primary"
                                        style="padding: 0.75rem 1.5rem;" target="_blank" role="button">
                                        <i class="ri-menu-search-line"></i> Ver guías
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12" id="volmen_in">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" step="0.01" id="volumen" name="volumen"
                                        class="form-control" placeholder="Volumen de Lote Inicial (litros)"
                                        autocomplete="off" data-error-message="Por favor selecciona el volumen" />
                                    <label for="volumen">Volumen de Lote Inicial (litros)</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" step="0.01" id="cont_alc" name="cont_alc"
                                        class="form-control" placeholder="Contenido Alcohólico" autocomplete="off"
                                        data-error-message="Por favor seleccione el contenido alcoholico" />
                                    <label for="cont_alc">Contenido Alcohólico</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="id_categoria" name="id_categoria" class=" form-select">
                                        <option value="" disabled selected
                                            data-error-message="Por favor seleccione una categoria">Selecciona la
                                            categoría
                                            de agave
                                        </option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id_categoria }}">
                                                {{ $categoria->categoria }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_categoria">Categoría de Mezcal</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="clase_agave" name="id_clase" class=" form-select"
                                        data-error-message="Por favor selecciona una clase">
                                        <option value="" disabled selected>Selecciona la clase de agave
                                        </option>
                                        @foreach ($clases as $clase)
                                            <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                        @endforeach
                                    </select>
                                    <label for="clase_agave">Clase de Agave</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="tipo_agave" name="id_tipo[]" class="select2 form-select" multiple>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }}
                                                ({{ $tipo->cientifico }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_agave">Tipo de Agave</label>
                                </div>
                            </div>


                        </div>

                        <!-- Campos para "Certificación por OC CIDAM" -->
                        <div id="oc_cidam_fields" class="d-none">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" id="ingredientes" name="ingredientes"
                                            class="form-control" placeholder="Ingredientes" autocomplete="off" />
                                        <label for="ingredientes">Ingredientes</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" id="edad" name="edad" class="form-control"
                                            placeholder="Edad" autocomplete="off" />
                                        <label for="edad">Edad</label>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <!-- Campos para "Certificado por otro organismo" -->
                        <div id="otro_organismo_fields" class="d-none">

                            <div class="row">
                                <!-- Campo de archivo ocupando toda la fila -->
                                <div class="col-md-12 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control form-control-sm" type="file" id="file-59"
                                            name="documentos[0][url]">
                                        <input value="59" class="form-control" type="hidden"
                                            name="documentos[0][id_documento]">
                                        <input value="Certificado de lote a granel" class="form-control"
                                            type="hidden" name="documentos[0][nombre_documento]">
                                        <label for="certificado_lote">Adjuntar Certificado de Lote a Granel</label>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <!-- Campos en filas de dos -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="folio_certificado" name="folio_certificado"
                                            class="form-control" placeholder="Folio/Número de Certificado"
                                            autocomplete="off" />
                                        <label for="folio_certificado">Folio/Número de Certificado</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="id_organismo" name="id_organismo" class="select2 form-select">
                                            <option value="" disabled selected>Selecciona el organismo de
                                                certificación</option>
                                            @foreach ($organismos as $organismo)
                                                <option value="{{ $organismo->id_organismo }}">
                                                    {{ $organismo->organismo }}</option>
                                            @endforeach
                                        </select>
                                        <label for="id_organismo">Organismo de Certificación</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="fecha_emision" name="fecha_emision"
                                            autocomplete="off" class="form-control datepicker"
                                            placeholder="Fecha de Emisión" />
                                        <label for="fecha_emision">Fecha de Emisión</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="fecha_vigencia" name="fecha_vigencia"
                                            autocomplete="off" class="form-control datepicker"
                                            placeholder="Fecha de Vigencia" />
                                        <label for="fecha_vigencia">Fecha de Vigencia</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tipo de análisis</th>
                                    <th>No. de Análisis Fisicoquímico</th>
                                    <th>Documento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentos as $documento)
                                    <!-- Primer bloque -->
                                    <tr>
                                        <td>
                                            <span>Análisis completo</span>
                                            <input hidden readonly value="Análisis completo" type="text"
                                                class="form-control form-control-sm"
                                                id="date{{ $documento->id_documento }}" name="tipo_analisis[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                id="date{{ $documento->id_documento }}" name="folio_fq_completo"
                                                autocomplete="off">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="file"
                                                id="file-58" name="documentos[1][url]">
                                            <input value="58" class="form-control"
                                                type="hidden" name="documentos[1][id_documento]">
                                            <input value="{{ $documento->nombre }}" class="form-control"
                                                type="hidden" name="documentos[1][nombre_documento]">
                                        </td>
                                    </tr>

                                    <!-- Segundo bloque -->
                                    <tr>
                                        <td>
                                            <span>Ajuste de grado</span>
                                            <input hidden readonly value="Ajuste de grado" type="text"
                                                class="form-control form-control-sm"
                                                id="date{{ $documento->id_documento }}" name="tipo_analisis[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                id="date{{ $documento->id_documento }}-2" name="folio_fq_ajuste"
                                                autocomplete="off">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="file"
                                                id="file-134" name="documentos[2][url]">
                                            <input value="134" class="form-control"
                                                type="hidden" name="documentos[2][id_documento]">
                                            <input value="{{ $documento->nombre }}" class="form-control"
                                                type="hidden" name="documentos[2][nombre_documento]">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                    <!-- Botones -->
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line me-1"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger"
                            data-bs-dismiss="modal"><i class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtenerDatosEmpresa() {
        var empresa = $("#id_empresa").val();


        // Verifica si el valor de empresa es válido
        if (!empresa) {
            return; // No hacer la petición si el valor es inválido
        }

        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                // Limpiar el contenido previo del select de guías
                var $selectGuias = $('#id_guia');
                $selectGuias.empty();

                if (response.guias.length > 0) {
                    // Recorrer las guías y añadirlas al select
                    response.guias.forEach(function(guia) {
                        $selectGuias.append(
                            `<option value="${guia.id_guia}">${guia.folio}</option>`);
                    });
                } else {
                    // Mostrar opción "Sin guías registradas" si no hay guías
                    $selectGuias.append(
                        '<option value="" disabled selected>Sin guías registradas</option>');
                }

                // Limpiar el contenido previo del select de lotes
                var $selectLotes = $('#lote_original_id');
                $selectLotes.empty();

                if (response.lotes_granel.length > 0) {
                    // Recorrer los lotes y añadirlos al select
                    response.lotes_granel.forEach(function(lotes_granel) {
                        $selectLotes.append(
                            `<option value="${lotes_granel.id_lote_granel}">${lotes_granel.nombre_lote}</option>`
                        );
                    });
                } else {
                    // Mostrar opción "Sin lotes registrados" si no hay lotes
                    $selectLotes.append(
                        '<option value="" disabled selected>Sin lotes registrados</option>');
                }

                // Disparar un evento global para que el otro script pueda usar los lotes
                $(document).trigger('lotesCargados', [response.lotes_granel]);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar los datos de la empresa:', error);
                alert('Error al cargar los datos. Por favor, intenta nuevamente.');
            }
        });
    }

    // Llamar a obtenerDatosEmpresa cuando se selecciona la empresa
    $('#id_empresa').change(function() {
        obtenerDatosEmpresa();
    });
</script>
