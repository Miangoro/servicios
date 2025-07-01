<!-- Add New Address Modal -->
<div class="modal fade" id="asignarInspector" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Asignar inspector</h4>
                    <p class="solicitud badge bg-primary"></p>
                </div>

                <!-- <div class="card mb-6">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Cras justo odio</li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
          </div>-->
                <form id="addAsignarInspector" class="row g-5" onsubmit="return false">
                    <input name="id_solicitud" type="hidden" id="id_solicitud">

                    <div id="datosSolicitud" class="mt-3 mb-3"></div>


                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select id="id_inspector" name="id_inspector" class="select2 form-select"
                                data-allow-clear="true">
                                @foreach ($inspectores as $inspector)
                                    <option value="{{ $inspector->id }}">{{ $inspector->name }}</option>
                                @endforeach
                            </select>
                            <label for="id_inspector">Inspector de la unidad de inspección</label>
                        </div>
                    </div>

                    <!--<hr class="my-2">
            <h5 class="mb-4">Información para la inspección</h5>-->

                    <div class="col-md-6 col-sm-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" id="num_servicio" name="num_servicio" class="form-control"
                                placeholder="Número de servicio" />
                            <label for="num_servicio">Número de servicio</label>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-floating form-floating-outline">
                            <input type="datetime-local" id="fecha_servicio" name="fecha_servicio" class="form-control"
                                placeholder="Fecha y hora de visita" />
                            <label for="fecha_servicio">Fecha y hora de visita</label>
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-4">
                        <textarea name="observaciones" class="form-control h-px-100" id="observaciones" placeholder="Indicaciones..."></textarea>
                        <label for="observaciones">Indicaciones u observaciones para la inspección</label>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline">
                            <select multiple id="solInspecciones" name="solInspecciones[]" class="select2 form-select">
                                @foreach ($solcitudesSinInspeccion as $solicitud)
                                    <option value="{{ $solicitud->id_solicitud }}">
                                        {{ $solicitud->folio }}
                                    </option>
                                @endforeach

                            </select>
                            <label for="solInspecciones">Elegir a que otra solicitud aplica el mismo
                                inspector</label>
                        </div>
                    </div>



                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary me-1 d-none" type="button" id="btnSpinnerAsigInspec">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Asignando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnAsignarInspec"><i
                                class="ri-user-add-line me-1"></i> Asignar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line me-1"></i>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Add New Address Modal -->
