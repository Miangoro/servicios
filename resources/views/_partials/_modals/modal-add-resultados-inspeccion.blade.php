<!-- Add New Address Modal -->
<div class="modal fade" id="resultadosInspeccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-1">
                    <h4 class="address-title mb-2">Registrar/Visualizar resultados de inspección</h4>
                    <p class="mb-2 nombre_empresa badge bg-primary"></p>
                    <p class="mb-2 text-uppercase inspectorName badge bg-primary"></p>
                </div>
                <div class="text-center mb-2">
                   <p class="mb-2 fw-bold text-black num_servicio badge bg-info"></p>
                    <p class="mb-2 folio_solicitud badge bg-info"></p>
                </div>

                <!-- <div class="card mb-6">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Cras justo odio</li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
          </div>-->
                <form id="addResultadosInspeccion" class="row g-5" onsubmit="return false">
                    <input name="id_solicitud" type="hidden" class="id_solicitud">



                    <div id="datosOpcion2">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th style="width: 20px"><button type="button" class="btn btn-primary add-row"> <i
                                                class="ri-add-line"></i> </button></th>
                                    <th>Nombre del documento</th>
                                    <th>Adjuntar</th>
                                </tr>
                            </thead>
                            <tbody id="contenidoGraneles">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row"> <i
                                                class="ri-delete-bin-5-fill"></i> </button>
                                    </th>
                                    <td>
                                        <input id="nombre_documento" value="Acta de inspección"
                                            class="form-control form-control-sm" type="text"
                                            name="nombre_documento[]">
                                    </td>
                                    <td>
                                        <input class="form-control form-control-sm" type="file" id="file69"
                                            data-id="69" name="url[]">
                                        <input value="69" class="form-control" type="hidden" name="id_documento[]">

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="form-floating form-floating-outline mb-6">
                        <textarea name="observaciones" class="form-control h-px-100" id="observaciones" placeholder="Indicaciones..."></textarea>
                        <label for="observaciones">Observaciones acerca de este servicio</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <select multiple class="select2 form-select" name="solicitudes_adicionales[]">

                            @foreach ($todasSolicitudes as $solicitud)
                                <option value="{{ $solicitud->id_solicitud }}">{{ $solicitud->folio }}
                                    {{ $solicitud->inspeccion->num_servicio ?? '' }}</option>
                            @endforeach

                        </select>
                        <label for="domicilio">Elegir a que otra solicitudes aplica esta documentación</label>
                    </div>




                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary" id="btnSubirInsp"><i
                                class="ri-upload-2-fill me-1"></i> Subir</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add New Address Modal -->
