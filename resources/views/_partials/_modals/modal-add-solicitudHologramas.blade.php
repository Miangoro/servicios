<div class="modal fade" id="addHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nueva Solicitud de Hologramas</h4>
                    <p class="address-subtitle"> <b style="color: red"> (EL FOLIO SE GENERARÁ AUTOMÁTICAMENTE)</b></p>
                </div>
                <form id="addHologramasForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="id_empresa" name="id_empresa" class="select2 form-select" required>
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($Empresa as $cliente)
                                        <option value="{{ $cliente->id_empresa }}">
                                            {{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select id_marca" id="id_marca" name="id_marca" required>
                                    <option value="" selected>Selecciona una marca</option>
                                </select>
                                <label for="id_marca">Marca</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" id="cantidad_hologramas"
                                    name="cantidad_hologramas" placeholder="Número de hologramas solicitados"
                                    required />
                                <label for="cantidad_hologramas">Número de hologramas solicitados</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class="form-select" name="tipo" >
                                    <option value="A">A - Por imprimir</option>
                                    <option value="J">J - Impresos</option>
                                    
                                </select>
                                <label for="cantidad_hologramas">Tipo</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select id_direccion" id="id_direccion" name="id_direccion" required>
                            <option value="" selected>Selecciona una dirección</option>
                        </select>
                        <label for="id_direccion">Dirección a la que se enviará</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <textarea name="comentarios" class="form-control h-px-100" id="comentarios" placeholder="Observaciones..."></textarea>
                        <label for="comentarios">Comentarios</label>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
