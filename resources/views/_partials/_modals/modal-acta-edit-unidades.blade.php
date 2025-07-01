<!-- Add New Lote Envasado Modal -->
<style>
    .modal-custom-size {
        max-width: 90%;
        /* Ajusta este valor para hacerlo más grande */
        width: 90%;
        /* Ajusta según tus necesidades */
    }
</style>
<div class="modal fade" id="editActaUnidades" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar acta circunstanciada para Unidades de producción</h4>
                </div>
                <form id="editActaUnidadesForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <input type="hidden" class="id_inspeccion" name="edit_id_inspeccion">
                    <input type="hidden" class="id_empresa" name="edit_acta_id_empresa">  
                    <input type="hidden" class="edit_id_acta" name="id_acta">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 mb-5">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="edit_num_acta" name="edit_num_acta"
                                    placeholder="Ingresa el No. de acta" aria-label="Ingresa el No. guia" />
                                <label for="edit_num_acta">Acta número:</label>
                            </div>
                        </div>



                        <div class="col-md-5">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="edit_categoria_acta" name="edit_categoria_acta"
                                    class="form-control edit_tipo_instalacion" required oninput="edit_tablasCategorias()"
                                    readonly>
                                <label for="edit_categoria_acta">En la categoría de:</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="edit_testigos" name="edit_testigos" class="form-select" required
                                    onchange="edit_Testigos()">
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                                <label for="edit_testigos">Testigos:</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control " id="edit_encargado" name="edit_encargado"
                                    placeholder="Ingresa el nombre del encargado" aria-label="Ingresa el No. guia" />
                                <label for="edit_encargado">Encargado</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-5">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control" id="edit_num_credencial_encargado"
                                    name="edit_num_credencial_encargado" placeholder="Ingresa el No. de la credencial"
                                    aria-label="Ingresa el No. guia" />
                                <label for="edit_num_credencial_encargado">Credencial vigente número</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control direccion_completa" id="edit_lugar_inspeccion"
                            name="edit_lugar_inspeccion" placeholder="Lugar de inspeccion:"
                            aria-label="Ingresa el No. guia" />
                        <label for="edit_lugar_inspeccion">Lugar de inspeccion:</label>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <div class="form-floating form-floating-outline">
                                <input type="datetime-local" class="form-control " id="edit_fecha_inicio" name="edit_fecha_inicio"
                                    aria-label="Fecha de Emisión">
                                <label for="edit_fecha_inicio">Fecha de inicio</label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-5">
                            <div class="form-floating form-floating-outline">
                                <input type="datetime-local" class="form-control" id="edit_fecha_fin" name="edit_fecha_fin"
                                    aria-label="Fecha de Emisión">
                                <label for="edit_fecha_fin">Fecha de final</label>
                            </div>
                        </div>
                    </div>
                    {{-- Tabla testigos --}}
                    <p class="address-subtitle" id="edit_tabla-testigos-label"><b style="color: red">Designacion:
                        </b>Testigos
                    </p>
                    <table class="table table-bordered" id="edit_tabla-testigos">
                        <thead>
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-primary add-row" data-target="#edit_testigoss"
                                        data-name-prefix="edit_nombre_testigo[]" data-name-suffix="edit_domicilio[]">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </th>
                                <th>Nombre del testigo</th>
                                <th>Domicilio</th>
                            </tr>
                        </thead>
                        <tbody id="edit_testigoss">
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-danger remove-row" disabled>
                                        <i class="ri-delete-bin-5-fill"></i>
                                    </button>
                                </th>
                                <td>
                                    <input type="text" class="form-control form-control-sm"
                                        name="edit_nombre_testigo[]" id="edit_nombre_testigo" />
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" name="edit_domicilio[]"
                                        id="edit_domicilio" />
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- tabla de produccion Agave--}}
                    <div id="edit_tablaProduccionAgave" style="display: block;">
                        <div style="padding: 10px"></div>
                        <p class="address-subtitle"><b style="color: red">Unidad: </b>De producción</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><button type="button" class="btn btn-primary add-row-produccion"> <i
                                                class="ri-add-line"></i>
                                        </button></th>
                                    <th>Nombre del Predio/Plantación</th>
                                    <th>Plagas en el cultivo</th>
                                </tr>
                            </thead>
                            <tbody id="edit_unidadProduccion">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row" disabled>
                                            <i class="ri-delete-bin-5-fill"></i>
                                        </button>
                                    </th>
                                    <td><select class="form-control select2 plantacion" name="edit_id_plantacion[]">
                                            <!-- Opciones -->
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control form-control-sm" name="edit_plagas[]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Tabla de produccion de mezcal --}}
                    <div id="edit_tablaProduccionMezcal" style="display: block;">
                        <div style="padding: 10px"></div>
                        <p class="address-subtitle"><b style="color: red">Unidad: </b>De producción de Mezcal</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>

                                    <th>Recepción (materia prima)</th>
                                    <th>Área de pesado</th>
                                    <th>Área de cocción</th>
                                    <th>Área de maguey cocido</th>
                                    <th>Área de molienda</th>
                                    <th>Área de fermentación</th>
                                    <th>Área de destilación</th>
                                    <th>Almacén a graneles</th>
                                </tr>
                            </thead>
                            <tbody id="edit_unidadMezcal">
                                <tr>

                                    <!-- Indexado por fila (0) y columna (áreas) -->
                                    <td>
                                        <select class="form-control select" name="edit_respuesta[0][0]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuesta[0][1]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuesta[0][2]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuesta[0][3]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuesta[0][4]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuesta[0][5]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuesta[0][6]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuesta[0][7]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- tabla de equipos mezcal --}}
                    <div id="edit_tablaProduccionEquipo" style="display: block;">
                        <div style="padding: 10px"></div>
                        <p class="address-subtitle"><b style="color: red">Unidad: </b>Equipo de Mezcal</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-primary add-row-equipoMezcal">
                                            <i class="ri-add-line"></i>
                                        </button>
                                    </th>
                                    <th>Equipo</th>
                                    <th>Cantidad</th>
                                    <th>Capacidad</th>
                                    <th>Tipo de material</th>
                                </tr>
                            </thead>
                            <tbody id="edit_equipoMezcal">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row" disabled>
                                            <i class="ri-delete-bin-5-fill"></i>
                                        </button>
                                    </th>
                                    <td>
                                        <select class="form-control select2 equipo" name="edit_equipo[]">
                                            <option value="">Selecciona equipo</option>
                                            @foreach ($equipos as $equipo)
                                                <option value="{{ $equipo->edit_equipo }}">{{ $equipo->equipo }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm"
                                            name="edit_cantidad[]" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            name="edit_capacidad[]" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            name="edit_tipo_material[]" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- UNIDAD ENVASADSO --}}
                    <div id="edit_tablaEnvasadora" style="display: block;">
                        <div style="padding: 20px"></div>
                        <p class="address-subtitle"><b style="color: red">Unidad: </b>De Envasado</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>

                                    <th>Almacén de insumos</th>
                                    <th>Almacén a gráneles
                                    </th>
                                    <th>Sistema de filtrado</th>
                                    <th>Área de envasado</th>
                                    <th>Área de tiquetado</th>
                                    <th>Almacén de producto terminado</th>
                                    <th>Área de aseo personal</th>
                                </tr>
                            </thead>
                            <tbody id="edit_unidadEnvasado">
                                <tr>

                                    <td>
                                        <select class="form-control select" name="edit_respuestas[0][0]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas[0][1]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas[0][2]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas[0][3]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas[0][4]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas[0][5]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas[0][6]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- UNIDAD EQUIPO ENVASADO --}}
                    <div id="edit_tablaEnvasadoraEquipo" style="display: block;">
                        <div style="padding: 20px"></div>
                        <p class="address-subtitle"><b style="color: red">Unidad: </b>Equipo de Envasado</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-primary add-row-equipoEnvasado">
                                            <i class="ri-add-line"></i>
                                        </button>
                                    </th>
                                    <th>Equipo</th>
                                    <th>Cantidad</th>
                                    <th>Capacidad</th>
                                    <th>Tipo de material</th>
                                </tr>
                            </thead>
                            <tbody id="edit_equipoEnvasado">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row" disabled>
                                            <i class="ri-delete-bin-5-fill"></i>
                                        </button>
                                    </th>
                                    <td>
                                        <select class="form-control select2 equipo2" name="edit_equipo_envasado[]">
                                            <option value="" selected>Selecciona equipo</option>
                                            @foreach ($equipos as $equipoEnva)
                                                <option value="{{ $equipoEnva->edit_equipo_envasado }}">{{ $equipoEnva->equipo }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm"
                                            name="edit_cantidad_envasado[]" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            name="edit_capacidad_envasado[]" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            name="edit_tipo_material_envasado[]" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- UNIDAD COMERCIALIZADORA --}}
                    <div id="edit_tablaComercializadora" style="display: block;">

                        <div style="padding: 20px"></div>
                        <p class="address-subtitle"><b style="color: red">Unidad: </b>De Comercialización</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>

                                    <th>Bodega o almacén</th>
                                    <th>Tarimas</th>
                                    <th>Bitácoras</th>
                                    <th>Otro:</th>
                                    <th>Otro</th>
                                </tr>
                            </thead>
                            <tbody id="edit_unidadComercializadora">
                                <tr>

                                    <td>
                                        <select class="form-control select" name="edit_respuestas_comercio[0][0]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas_comercio[0][1]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas_comercio[0][2]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas_comercio[0][3]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control select" name="edit_respuestas_comercio[0][4]">
                                            <option value="" selected>Selecciona</option>
                                            <option value="C">C</option>
                                            <option value="NC">NC</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="text-align: center; color: black; font-size: 20px; padding: 20px"><b
                            style="color: red">Anote: </b>No conformidades identificadas en la inspección</div>
                    <div class="form-floating form-floating-outline mb-5">
                        <textarea name="edit_no_conf_infraestructura" class="form-control h-px-100" id="edit_no_conf_infraestructura"
                            placeholder="Observaciones..."></textarea>
                        <label for="edit_no_conf_infraestructura">Infraestructura</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <textarea name="edit_no_conf_equipo" class="form-control h-px-100" id="edit_no_conf_equipo" placeholder="Observaciones..."></textarea>
                        <label for="edit_no_conf_equipo">Equipo</label>
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




<script>
/*         $(document).ready(function() {


}); */

/* function edit_obtenerNombrePredio() {
    var empresa = $(".id_empresa").val();

    // Hacer una petición AJAX para obtener los detalles de la empresa
    $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function(response) {
            console.log(response);

            // Cargar los detalles en el modal
            var contenido = "";
            for (let index = 0; index < response.predio_plantacion.length; index++) {
                contenido =
                    '<option value="' + response.predio_plantacion[index].id_plantacion + '">' +
                    response.predio_plantacion[index].nombre_predio + ' | ' +
                    response.predio_plantacion[index].nombre + ' | Superficie: ' +
                    response.predio_plantacion[index].superficie + ' | Año: ' +
                    response.predio_plantacion[index].anio_plantacion + ' | ' +
                    response.predio_plantacion[index].num_plantas +
                    ' Plantas</option>' +

                    contenido;
                // console.log(response.normas[index].norma);
            }

            if (response.predio_plantacion.length == 0) {
                contenido = '<option value="">Sin predios registrados</option>';
            }
            $('.plantacion').html(contenido);
        },
        error: function() {
            //alert('Error al cargar los lotes a granel.');
        }
    });
}  */

function edit_Testigos() {
    // Obtener el valor seleccionado en el select
    const edit_tipoLote = document.getElementById('edit_testigos').value;

    // Obtener la tabla y el label de testigos
    const edittablaTestigos = document.getElementById('edit_tabla-testigos');
    const edittablaTestigosLabel = document.getElementById('edit_tabla-testigos-label');

    // Mostrar u ocultar la tabla dependiendo del valor seleccionado
    if (edit_tipoLote === '1') {
        // Mostrar la tabla si elige "Por un solo lote a granel"
        edittablaTestigos.style.display = 'table';
        edittablaTestigosLabel.style.display = 'block';
    } else {
        // Ocultar la tabla si elige "Por más de un lote a granel"
        edittablaTestigos.style.display = 'none';
        edittablaTestigosLabel.style.display = 'none';
    }
}

 
 function iniciarCategorias() {
    // Función para mostrar u ocultar la tabla dependiendo del valor de "categoria_acta"
    function edit_tablasCategorias() {
            const edit_tipo_instalacion = document.getElementById('edit_categoria_acta').value;
            const edit_tablaProduccionAgave = document.getElementById('edit_tablaProduccionAgave');
            const edit_tablaProduccionMezcal = document.getElementById('edit_tablaProduccionMezcal');
            const edit_tablaProduccionEquipo = document.getElementById('edit_tablaProduccionEquipo');
            const edit_tablaEnvasadora = document.getElementById('edit_tablaEnvasadora');
            const edit_tablaEnvasadoraEquipo = document.getElementById('edit_tablaEnvasadoraEquipo');
            const edit_tablaComercializadora = document.getElementById('edit_tablaComercializadora');

            if (edit_tipo_instalacion === 'Productora de Agave') {
                edit_tablaProduccionAgave.style.display = 'block';
            } else if (edit_tipo_instalacion === 'Productora') {
                edit_tablaProduccionMezcal.style.display = 'block';
                edit_tablaProduccionEquipo.style.display = 'block';
            } else if (edit_tipo_instalacion === 'Envasadora') {
                edit_tablaEnvasadora.style.display = 'block';
                edit_tablaEnvasadoraEquipo.style.display = 'block';
            } else if (['Comercializadora', 'Almacén'].includes(edit_tipo_instalacion)) {
                edit_tablaComercializadora.style.display = 'block';
            } else {
                edit_tablaProduccionAgave.style.display = 'none';
                edit_tablaProduccionMezcal.style.display = 'none';
                edit_tablaProduccionEquipo.style.display = 'none';
                edit_tablaEnvasadora.style.display = 'none';
                edit_tablaEnvasadoraEquipo.style.display = 'none';
                edit_tablaComercializadora.style.display = 'none';
            }
    }

    // Asegúrate de que el evento se vincule al modal correcto
    const modalElement = document.getElementById('editActaUnidades');

    if (modalElement) {
        // Se ejecuta cuando el modal se muestra completamente
        modalElement.addEventListener('shown.bs.modal', function() {
            edit_tablasCategorias(); // Llamar a la función cuando se abra el modal
        });

        // Llamar a la función también cuando el usuario cambie el valor del input
        const categoriaInput = document.getElementById('edit_categoria_acta');
        if (categoriaInput) {
            categoriaInput.addEventListener('input', edit_tablasCategorias);
        }
    }
} 

// Iniciar la funcionalidad cuando se cargue el DOM
document.addEventListener('DOMContentLoaded', initializeModalFunctionality); 
</script>



