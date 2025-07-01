<!-- MODAL AGREGAR -->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Nuevo certificado de venta nacional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormAgregar" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="form-select select2" id="id_solicitud" name="id_solicitud"
                                    data-placeholder="Selecciona una solicitud">
                                    <option value="" disabled selected>NULL</option>
                                    @foreach ($solicitud as $soli)
                                        <option value="{{ $soli->id_solicitud }}">
                                            {{ $soli->folio }} | {{ $soli->lote_envasado->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Folio de solicitud</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" name="num_certificado"
                                    placeholder="No. de certificado" value="CIDAM C-NAL25-">
                                <label for="">No. de certificado</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="select2 form-select" name="id_firmante">
                                    <option value="" disabled selected>Selecciona un firmante</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                                <input class="form-control flatpickr-datetime" id="fecha_vigencia" name="fecha_vigencia"
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-12">
                            <select class="form-select select2" multiple name="id_activacion[]"
                                data-placeholder="Selecciona un holograma">
                                @foreach ($hologramas as $hol)
                                    @php
                                        // Decodificar el campo JSON
                                        $folios = is_string($hol->folios)
                                            ? json_decode($hol->folios, true)
                                            : $hol->folios;

                                        $iniciales = $folios['folio_inicial'] ?? [];
                                        $finales = $folios['folio_final'] ?? [];
                                    @endphp

                                    @for ($i = 0; $i < count($iniciales); $i++)
                                        @php
                                            $inicio = $iniciales[$i] ?? null;
                                            $fin = $finales[$i] ?? null;
                                        @endphp

                                        @if ($inicio && $fin)
                                            <option value="{{ $hol->id }}">
                                                {{ $hol->folio_activacion }} ({{ $inicio }} a {{ $fin }})
                                            </option>
                                        @endif
                                    @endfor
                                @endforeach

                            </select>
                        </div>
                    </div> --}}




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
                <h5 class="modal-title text-white">Editar certificado de venta nacional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormEditar" method="POST">
                    <div class="row">
                        <input type="hidden" name="id_certificado" id="edit_id_certificado">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="form-select select2" name="id_solicitud" id="edit_id_solicitud">
                                    @foreach ($solicitud as $soli)
                                        <option value="{{ $soli->id_solicitud }}">
                                            {{ $soli->folio }} | {{ $soli->lote_envasado->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="">Folio de solicitud</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" name="num_certificado"
                                    id="edit_num_certificado" placeholder="no. certificado">
                                <label for="">No. de certificado</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="select2 form-select" name="id_firmante" id="edit_id_firmante">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <label for="">Seleccione un firmante</label>
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
                                <input class="form-control flatpickr-datetime" id="edit_fecha_vigencia" name="fecha_vigencia"
                                    placeholder="YYYY-MM-DD">
                                <label for="">Vigencia hasta</label>
                            </div>
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
