<!-- MODAL AGREGAR -->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Nuevo dictamen de exportación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormAgregar" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_inspeccion" name="id_inspeccion" class="select2 form-select" 
                                    data-placeholder="Selecciona el número de servicio">
                                    <option value="" disabled selected></option>
                                    @foreach ($inspeccion as $insp)
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->folio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}
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
                                    placeholder="No. de dictamen" value="UMEXP25-">
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select  id="id_firmante" name="id_firmante" class="select2 form-select">
                                <option value="" disabled selected>Selecciona un firmante</option>
                                @foreach ($users as $inspector)
                                    <option value="{{ $inspector->id }}" {{ $inspector->id == 9 ? 'selected' : '' }}>
                                        {{ $inspector->name }}
                                    </option>
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
                                <input class="form-control" id="fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line"></i> Registrar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
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
                <h5 class="modal-title text-white">Editar dictamen de exportación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormEditar" method="POST">
                    <div class="row">
                        <input type="hidden" id="edit_id_dictamen" name="id_dictamen">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="edit_id_inspeccion" name="id_inspeccion" class="select2 form-select" 
                                    data-placeholder="Selecciona el número de servicio">
                                    @foreach ($inspeccion as $insp)
                                        <option value="{{ $insp->id_inspeccion }}">{{ $insp->num_servicio }} | {{ $insp->solicitud->folio }} | {{ $insp->solicitud->instalacion->direccion_completa ?? '' }}
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
                                <input type="text" class="form-control" id="edit_num_dictamen" name="num_dictamen"
                                    placeholder="No. de dictamen">
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select  id="edit_id_firmante" name="id_firmante" class="select2 form-select">
                                    @foreach ($users as $inspector)
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
                                <input class="form-control flatpickr-datetime" id="edit_fecha_emision" name="fecha_emision"
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de emisión</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input class="form-control" id="edit_fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-pencil-fill"></i> Editar</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"
                            aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>