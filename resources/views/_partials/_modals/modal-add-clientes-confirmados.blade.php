<!-- Modal para agregar nuevo cliente -->
<div class="modal fade" id="AddClientesConfirmados" tabindex="-1" aria-labelledby="AddClientesConfirmados">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddClientesConfirmados">Registro de clientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ClientesConfirmadosForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="razon_social" name="razon_social" class="form-control"
                                    autocomplete="off" placeholder="Nombre" required />
                                <label for="razon_social">Nombre cliente/empresa</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="regimen" name="regimen" class="form-select" required>
                                    <option value="" disabled selected>Selecciona tipo de persona</option>
                                    <option value="Persona física">Persona Física</option>
                                    <option value="Persona moral">Persona Moral</option>
                                </select>
                                <label for="regimen">Tipo de persona</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="domicilio_fiscal" name="domicilio_fiscal" class="form-control"
                                    autocomplete="off" placeholder="Domicilio fiscal" required />
                                <label for="Domicilio fiscal">Domicilio fiscal</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-3 select2-primary">
                                <select class="form-select select2" id="normas" name="normas[]"
                                    data-placeholder="Seleccione una o más normas" aria-label="Normas" multiple>
                                    <option value="">Seleccione una o más normas</option>
                                    @foreach ($normas as $norma)
                                        <option value="{{ $norma->id_norma }}">{{ $norma->norma }}</option>
                                    @endforeach
                                </select>
                                <label for="normas">Normas</label>
                            </div>
                        </div>
                    </div>
                    <div id="normas-info"></div>
                    <!-- Sección de estado y representante -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input maxlength="5" type="number" id="cp" name="cp" class="form-control"
                                    autocomplete="off" placeholder="Código postal" required/>
                                <label for="cp">Código postal</label>
                            </div>
                        </div>
                        <!-- Estado -->
                        <div id="EstadosClass" class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="estado" name="estado"
                                    data-placeholder="Seleccione un estado" aria-label="Estado" required>
                                    <option value="">Seleccione un estado</option>
                                    <!-- Opción de estado -->
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Representante Legal (Oculto por defecto) -->
                        <div id="MostrarRepresentante" class="d-none col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="representante" name="representante" class="form-control"
                                    autocomplete="off" placeholder="Representante" required />
                                <label for="Representante">Representante</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-3 select2-primary">
                                <select class="form-select select2" id="actividad" name="actividad[]"
                                    data-placeholder="Seleccione una o más normas" aria-label="actividad" multiple>
                                    <option value="">Seleccione una actividad</option>
                                    @foreach ($actividadesClientes as $actividad)
                                        <option value="{{ $actividad->id_actividad }}">{{ $actividad->actividad }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="normas">Actividad</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="rfc" name="rfc" class="form-control"
                                    autocomplete="off" placeholder="RFC" required />
                                <label for="rfc">RFC</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="email" id="correo" name="correo" class="form-control"
                                    autocomplete="off" placeholder="Correo electrónico" required />
                                <label for="correo">Correo electrónico</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="tel" id="telefono" name="telefono" class="form-control"
                                    autocomplete="off" placeholder="Teléfono" required />
                                <label for="telefono">Teléfono</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="id_contacto" name="id_contacto" class="select2 form-select" required>
                                    <option value="" disabled selected>Selecciona una persona de contacto
                                    </option>
                                    @foreach ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                    @endforeach
                                </select>
                                <label for="id_contacto">Persona de contacto CIDAM</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input maxlength="5" type="text" id="registro_productor" name="registro_productor" class="form-control"
                                    autocomplete="off" placeholder="Registro de Productor Autorizado (Uso de la DOM)" />
                                <label for="registro_productor">Registro de Productor Autorizado (Uso de la DOM)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input maxlength="5" type="text" id="convenio_corresp" name="convenio_corresp" class="form-control"
                                    autocomplete="off" placeholder="Número de Convenio de corresponsabilidad"  />
                                <label for="convenio_corresp">Número de Convenio de corresponsabilidad</label>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="maquilador(this.value)"  name="es_maquilador" class="form-select" required>
                                        <option value="No">No</option>
                                        <option value="Si">Si</option>
                                </select>
                                <label for="es_maquilador">¿Es un maquilador?</label>
                            </div>
                        </div>
                        <div style="display: none" class="col-md-6 maquiladora">
                            <div class="form-floating form-floating-outline mb-4">
                                <select name="id_maquiladora" class="select2 form-select" required>
                                    @foreach ($empresas_confirmadas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_maquiladora">Empresa maquiladora</label>
                            </div>
                        </div>
                      </div>
    
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select name="estatus" class="form-select" required>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                </select>
                                <label for="id_contacto">Estatus</label>
                            </div>
                        </div>
                      </div>
                    <!-- Botones -->
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#normas').on('change', function() {
            const selectedNormas = $(this).val(); // Obtener las normas seleccionadas
            const normasData = @json($normas); // Pasar las normas al JavaScript
            $('#normas-info').empty(); // Limpiar campos previos

            selectedNormas.forEach((normaId) => {
                // Buscar el nombre de la norma correspondiente
                const norma = normasData.find(n => n.id_norma == normaId);

                if (norma) {
                    const normaField = `
                <div class="input-group mb-4 input-group-merge">
                    <span class="input-group-text">${norma.norma}</span>
                    <input type="text" class="form-control" name="numeros_clientes[]" placeholder="Número de Cliente">
                </div>`;
                    $('#normas-info').append(normaField); // Añadir el nuevo campo
                }
            });
        });
    });
</script>
