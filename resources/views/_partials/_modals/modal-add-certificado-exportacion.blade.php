<!-- MODAL AGREGAR -->
<div class="modal fade" id="ModalAgregar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Nuevo certificado de exportación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormAgregar" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="form-select select2" id="id_dictamen" name="id_dictamen"
                                    data-placeholder="Selecciona un dictamen">
                                    <option value="" disabled selected>NULL</option>
                                    @foreach ($dictamen as $dic)
                                        <option value="{{ $dic->id_dictamen }}">{{ $dic->num_dictamen }} |
                                            {{ $dic->inspeccione->solicitud->folio }}</option>
                                    @endforeach
                                </select>
                                <label for="">No. de dictamen</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" name="num_certificado"
                                    placeholder="No. de certificado" value="CIDAM C-EXP25-">
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
                                <input class="form-control" id="fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="YYYY-MM-DD">
                                <label for="">Fecha de vigencia</label>
                            </div>
                        </div>
                    </div>


                    <div class="row" id="contenedor-lotes-dinamicos">
                        <!-- Aquí se generarán los inputs -->
                        {{-- <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="form-select select2" id="holograma1" name="holograma1"
                                    data-placeholder="Selecciona una opcion" multiple>
                                    <option value="1">primero</option>
                                    <option value="2">segundo</option>
                                </select>
                                <label for="">Holograma1</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <input type="text" class="form-control" id="holograma2" name="holograma2"
                                    placeholder="No. de certificado">
                                <label for="">Holograma2</label>
                            </div>
                        </div> --}}
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
                <h5 class="modal-title text-white">Editar certificado de exportación <span class="badge bg-info" id="badge-certificado"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="FormEditar" method="POST">
                    <div class="row">
                        <input type="hidden" name="id_certificado" id="edit_id_certificado">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="form-select select2" name="id_dictamen" id="edit_id_dictamen">
                                    @foreach ($dictamen as $dic)
                                        <option value="{{ $dic->id_dictamen }}">{{ $dic->num_dictamen }} |
                                            {{ $dic->inspeccione->solicitud->folio }}</option>
                                    @endforeach
                                </select>
                                <label for="">No. de dictamen</label>
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
                                <input class="form-control" id="edit_fecha_vigencia" name="fecha_vigencia" readonly
                                    placeholder="YYYY-MM-DD">
                                <label for="">Vigencia hasta</label>
                            </div>
                        </div>
                    </div>


                    <!-- Aquí se generarán los inputs -->
                    <div class="row" id="contenedor-lotes-dinamicos-editar"></div>


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




<!--SCRIPT PARA CAMPOS DE HOLOGRAMAS DINAMICOS-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"> </script>


@php
    $opcionesHologramas = [];
    foreach ($hologramas as $holo) {
        $folios = json_decode($holo->folios, true);
        $iniciales = $folios['folio_inicial'] ?? [];
        $finales = $folios['folio_final'] ?? [];

        foreach ($iniciales as $idx => $inicio) {
            $final = $finales[$idx] ?? '';
            $valor = "{$holo->id}|{$inicio}|{$final}";
            $texto = "Activación {$holo->folio_activacion}: {$inicio} - {$final}";
            $opcionesHologramas[] = ['valor' => $valor, 'texto' => $texto];
        }
    }
@endphp


<script>
    const hologramasDisponibles = @json($hologramas);
    const opcionesHologramas = @json($opcionesHologramas);

$(document).ready(function () {

//PARA FORMULARIO DE AGREGAR
    $('#id_dictamen').on('change', function () {
        const id = $(this).val();
        const contenedor = $('#contenedor-lotes-dinamicos');
        contenedor.empty();
        if (!id) return;

        $.ajax({
            url: `/certificados/contar-lotes/${id}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                const total = response.count || 0;

                if (total === 0) {
                    contenedor.append('<div class="alert alert-warning">No se encontraron lotes envasados.</div>');
                    return;
                }

                for (let i = 0; i < total; i++) {

                    let options = `
                        @foreach ($opcionesHologramas as $op)
                            <option value="{{ $op['valor'] }}">{{ $op['texto'] }}</option>
                        @endforeach
                    `;

                    contenedor.append(`
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6 select2-primary">
                            <select class="form-select select2" name="hologramas[${i}][tipo][]" multiple>
                                ${options}
                            </select>
                            <label for="">Holograma ${i + 1} - tipo</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="text" class="form-control" name="hologramas[${i}][descripcion]" placeholder="Descripción del holograma ${i + 1}">
                            <label for="">Holograma ${i + 1} - descripción</label>
                        </div>
                    </div>
                    `);
                }

                contenedor.find('.select2').select2({//inicializar select multiple
                    dropdownParent: $('#ModalAgregar') // o tu modal
                });
            },
            error: function (xhr) {
                console.error('Error al obtener los lotes:', xhr.responseText);
            }
        });
    });



// PARA EL FORMULARIO DE EDICIÓN
$('#edit_id_dictamen').on('change', function () {
    if (window.esEdicion) {
        window.esEdicion = false; // Lo desactivas y no haces nada más
        return;
    }

    const id = $(this).val();
    const contenedor = $('#contenedor-lotes-dinamicos-editar');
    contenedor.empty();
    if (!id) return;

    $.ajax({
        url: `/certificados/contar-lotes/${id}`,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            const total = response.count || 0;

            if (total === 0) {
                contenedor.append('<div class="alert alert-warning">No se encontraron lotes envasados.</div>');
                return;
            }

            for (let i = 0; i < total; i++) {
                let options = '';
                opcionesHologramas.forEach(op => {
                    options += `<option value="${op.valor}">${op.texto}</option>`;
                });

                contenedor.append(`
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6 select2-primary">
                            <select class="form-select select2" name="hologramas[${i}][tipo][]" multiple>
                                ${options}
                            </select>
                            <label for="">Holograma ${i + 1} - tipo</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="text" class="form-control" name="hologramas[${i}][descripcion]" placeholder="Descripción del holograma ${i + 1}">
                            <label for="">Holograma ${i + 1} - descripción</label>
                        </div>
                    </div>
                `);
            }

            // Inicializar Select2
            contenedor.find('.select2').select2({
                dropdownParent: $('#ModalEditar') // IMPORTANTE: que apunte al modal de edición
            });
        },
        error: function (xhr) {
            console.error('Error al obtener los lotes:', xhr.responseText);
        }
    });
});




});//fin de document-function

</script>