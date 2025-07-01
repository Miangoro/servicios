<!-- MODAL AGREGAR -->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Nuevo certificado de instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormAgregar">

                    <!-- Selección de Dictamen -->
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select" name="id_dictamen" data-placeholder="Selecciona un dictamen">
                            <option value="" disabled selected></option>
                            @foreach($dictamenes as $dictamen)
                                <option value="{{ $dictamen->id_dictamen }}" data-tipo-dictamen="{{ $dictamen->tipo_dictamen }}">
                                    {{ $dictamen->num_dictamen }} | 
                                    @if((string) $dictamen->tipo_dictamen === '1')
                                                Productor
                                    @elseif((string) $dictamen->tipo_dictamen === '2')
                                                Envasador
                                    @elseif((string) $dictamen->tipo_dictamen === '3')
                                                Comercializador
                                    @elseif((string) $dictamen->tipo_dictamen === '4')
                                                Almacén y bodega
                                    @elseif((string) $dictamen->tipo_dictamen === '5')
                                                Área de maduración
                                    @else
                                        {{ $dictamen->tipo_dictamen }} 
                                    @endif
                                    | {{ $dictamen->inspeccione->solicitud->folio }}
                                </option>
                            @endforeach
                        </select>
                        <label for="">Selecciona un dictamen</label>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" name="num_certificado" placeholder="No. de certificado"
                                    value="CIDAM C-INS25-">
                                <label for="">No. de certificado</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="select2 form-select" name="id_firmante">
                                    <option value="" disabled selected>Selecciona un firmante</option>
                                    @foreach($users as $user)
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
                                <input class="form-control" id="fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>

                    <!-- CAMPOS CONDICIONALES -->
                    <div class="row" id="CamposCondicionales_tipo" style="display: none;">
                        <div class="col-md-12"><!-- Maestro Mezcalero -->
                            <div class="form-floating form-floating-outline mb-6" >
                                <input type="text" class="form-control" id="maestro_mezcalero" placeholder="Maestro Mezcalero" name="maestro_mezcalero">
                                <label for="">Maestro mezcalero</label>
                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="no_autorizacion" placeholder="No. de Autorización" name="num_autorizacion">
                                <label for="">No. de autorización</label>
                            </div>
                        </div> --}}
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
                <h5 class="modal-title text-white">Editar certificado de instalaciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormEditar" method="POST">

                    <input type="hidden" id="edit_id_certificado" name="id_certificado">

                    <!-- Selección de Dictamen -->
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select" id="edit_id_dictamen" name="id_dictamen" >
                            @foreach($dictamenes as $dictamen)
                                <option value="{{ $dictamen->id_dictamen }}" data-tipo-dictamen="{{ $dictamen->tipo_dictamen }}">
                                    {{ $dictamen->num_dictamen }} | 
                                    @if((string) $dictamen->tipo_dictamen === '1')
                                                Productor
                                    @elseif((string) $dictamen->tipo_dictamen === '2')
                                                Envasador
                                    @elseif((string) $dictamen->tipo_dictamen === '3')
                                                Comercializador
                                    @elseif((string) $dictamen->tipo_dictamen === '4')
                                                Almacén y bodega
                                    @elseif((string) $dictamen->tipo_dictamen === '5')
                                                Área de maduración
                                    @else
                                        {{ $dictamen->tipo_dictamen }}
                                    @endif
                                    | {{ $dictamen->inspeccione->solicitud->folio }}
                                </option>
                            @endforeach
                        </select>
                        <label for="">Seleccione un dictamen</label>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" name="num_certificado" 
                                    id="edit_num_certificado"  placeholder="no. certificado">
                                <label for="">No. de certificado</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="select2 form-select" name="id_firmante"
                                    id="edit_id_firmante">
                                    @foreach($users as $user)
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

                    <!-- CAMPOS CONDICIONALES -->
                    <div class="row" id="Edit_CamposCondicionales_tipo" style="display: none;">
                        <div class="col-md-12"><!-- Maestro Mezcalero -->
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="edit_maestro_mezcalero" placeholder="Maestro Mezcalero" name="maestro_mezcalero">
                                <label for="">Maestro Mezcalero</label>
                            </div>
                        </div>
                        {{-- <div class="col-md-6"><!-- Número de Autorización -->
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="edit_num_autorizacion" placeholder="No. de Autorización" name="num_autorizacion">
                                <label for="">No. de Autorización</label>
                            </div>
                        </div> --}}
                    </div>

                    <!-- Botones -->
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
