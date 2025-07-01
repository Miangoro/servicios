@extends('layouts/layoutMaster')

@section('title', 'Resumen de datos')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/impi.js'])
@endsection


@section('content')


    <div class="row g-6">
        <div class="col-md-12 col-xxl-12">
            <div class="card h-100">

                {{-- <img src="{{ asset('assets/img/branding/banner_documentos.png') }}" alt="timeline-image" class="card-img-top img-fluid" style="object-fit: cover;"> --}}
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h2 class="m-0 me-2">Resumen de información del cliente</h2>
                </div>

                <div class="card-body p-0">
                    <form id="uploadForm" enctype="multipart/form-data">

                        <div class="form-floating form-floating-outline m-5 col-md-6">
                            <select id="id_empresa" class="form-select select2">
                                <option value="" disabled selected>Selecciona la empresa</option>
                                @foreach ($empresas as $cliente)
                                    <option value="{{ $cliente->id_empresa }}">
                                        {{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }}
                                        | {{ $cliente->razon_social }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="ClienteMessage" class="d-flex justify-content-center align-items-center" style="height: 200px;">
                            <div class="text-center">
                                <i class="fas fa-info-circle fa-2x text-info mb-3"></i>
                                <h2 class="text-secondary">Por favor seleccione un cliente.</h2>
                            </div>
                        </div>

                        <!--CARDS-->
                        <div id="tarjetas" class="form-floating-outline m-2 row">
                            {{-- <!-- TARJETA 1 -->
            <div class="col-md-6 col-xl-4 mb-3">
               <div class="accordion">
                  <div class="accordion-item">
                        <!-- Título -->
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white {{ $empresa && $empresa->instalaciones->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                INSTALACIONES ({{ $empresa->instalaciones->count() }}) <br><br>
                                @if ($empresa && $empresa->instalaciones->count() > 0)
                                    Despliega para ver instalaciones
                                @else
                                    Sin registros
                                @endif
                            </button>
                        </h5>
                        <!-- Contenido que despliega -->
                        <div id="collapseOne" class="accordion-collapse collapse p-3">
                            <div class="row">
                            @if ($empresa && $empresa->instalaciones->count() > 0)
                                @foreach ($empresa->instalaciones as $instalacion)
                                    <div class="col-lg-6 mb-3" style="font-size: 14px">
                                        <div class="card bg-label-primary">
                                            <div class="card-body">
                                                <p class="card-title"><b> {{ implode(', ', json_decode($instalacion->tipo, true)) }} </b></p>
                                                <p class="card-text">
                                                    Direccion: {{ $instalacion->direccion_completa }} <span class="d-block mt-2">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No hay instalaciones registradas para esta empresa.</p>
                            @endif
                            </div>
                        </div>
                  </div>
               </div>
            </div>
            <!-- TARJETA 2 -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="accordion">
                    <div class="accordion-item">
                        <!-- Título -->
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white {{ $empresa && $empresa->users->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                USUARIOS ({{ $empresa->users->count() }}) <br><br>
                                @if ($empresa && $empresa->users->count() > 0)
                                    Despliega para ver los usuarios
                                @else
                                    Sin registros
                                @endif
                            </button>
                        </h5>
                        <!-- Contenido que despliega -->
                        <div id="collapseTwo" class="accordion-collapse collapse row p-3">
                            @if ($empresa && $empresa->users->count() > 0)
                                @foreach ($empresa->users as $usuarios)
                                    <div class="col-lg-6 mb-3" style="font-size: 14px">
                                        <div class="card bg-label-info">
                                            <div class="card-body">
                                                <p class="card-title"><b>{{ $usuarios->name }}</b></p>
                                                <p class="card-text">
                                                    Correo: {{ $usuarios->email }} <span class="d-block mt-2">
                                                    Teléfono: {{ $usuarios->telefono ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No hay usuarios registrados para esta empresa.</p>
                            @endif
                        </div>
                  </div>
               </div>
            </div> --}}
                        </div><!--CARDS FIN-->

                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-------- SCRIPT -------->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#id_empresa').change(function() {
                var id_empresa = $(this).val();
                if (id_empresa) {
                    //solicitud AJAX para obtener los datos de la empresa seleccionada
                    $.ajax({
                        url: '/get-datos-empresa/' + id_empresa,
                        type: 'GET',
                        success: function(response) {
                          
                            $('#ClienteMessage').addClass('d-none'); // Ocultar el mensaje de selección
                            console.log(response);
                            updateTarjetas(response); //Actualizar las tarjetas con la respuesta
                        },
                        error: function(xhr, status, error) {
                            console.error("Error al obtener los datos");
                        }
                    });
                }
            });


            function updateTarjetas(empresa) { //Actualiza las tarjetas
                var tarjetasHTML = '';

                //DOMICILIO FISCAL
                var fiscal = empresa.domicilio_fiscal ?
                    `<div class="col-md-12 p-6">
                        <div class="accordion-item">
                            <h5 class="accordion-header">
                                ${empresa.domicilio_fiscal}
                            </h5>
                        </div>
                    </div>` :
                    '<p>No hay domicilio fiscal registrado para esta empresa.</p>';
                tarjetasHTML += `${fiscal}`;


                // INSTALACIONES
                var instalaciones = empresa.instalaciones.length > 0 ?
                    empresa.instalaciones.map(function(instalacion) {
                        var tipos = JSON.parse(instalacion.tipo).join(', '); // tipo de instalación
                        var dictamenesHTML = ''; // Variable para almacenar los dictámenes
                        var tipoDictamenMap = { //relaciona el tipo numérico con el nombre del tipo de dictamen
                            1: 'Productor',
                            2: 'Envasador',
                            3: 'Comercializador',
                            4: 'Almacén y Bodega',
                            5: 'Área de maduración'
                        };

                        // Iteramos sobre los dictámenes de la instalación por tipo
                        Object.keys(instalacion.dictamenes).forEach(function(tipo) {
                            var dictamen = instalacion.dictamenes[tipo];
                            var dictamenTexto = dictamen.num_dictamen;
                            var certificado =
                                '<span class="badge rounded-pill bg-danger">Sin certificado</span>'; // Valor por defecto
                            var dictamenStatus =
                                '<span class="badge rounded-pill bg-danger">Sin dictamen</span>'; // Valor por defecto
                            var fechaActual = new Date();
                            var fechaVigenciaDictamen = new Date(dictamen.fecha_vigencia);
                            //var id_certificado = '';

                            // Verificamos si el dictamen está vencido o vigente
                            if (fechaVigenciaDictamen < fechaActual) {
                                dictamenStatus =
                                    `${dictamenTexto} <span class="badge rounded-pill bg-danger">Vencido</span>`;
                            } else {
                                dictamenStatus = `${dictamenTexto}`;
                            }

                            // Verificamos si hay un certificado relacionado con el dictamen
                            if (dictamen.certificado) {
                                var fechaVigenciaCertificado = new Date(dictamen.certificado
                                    .fecha_vencimiento);
                                //var id_certificado = dictamen.certificado.id_certificado;

                                if (fechaVigenciaCertificado < fechaActual) {
                                    certificado = `
                    <a href="#" class="pdfCertificado" data-id="${dictamen.certificado.id_certificado}" data-tipo="${dictamen.tipo_dictamen}" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
                        ${dictamen.certificado.num_certificado}
                    </a> <span class="badge rounded-pill bg-danger">Vencido</span>`;
                                } else {
                                    certificado = `
                    <a href="#" class="pdfCertificado" data-id="${dictamen.certificado.id_certificado}" data-tipo="${dictamen.tipo_dictamen}" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
                        ${dictamen.certificado.num_certificado} </a>`;
                                }
                            }

                            // Usamos el mapa para obtener el tipo de dictamen correspondiente
                            var tipoDictamenNombre = tipoDictamenMap[tipo] || 'Desconocido';
                            // Añadimos el dictamen y certificado a la variable dictamenesHTML
                            dictamenesHTML += `
            <span style='border: 1px solid #7ee07c; padding: 1px; display: inline-block;'>
            <a href="#" class="pdfDictamen" data-id="${dictamen.id_dictamen}" data-tipo="${dictamen.tipo_dictamen}" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal">
                Dictamen ${tipoDictamenNombre}: <u>${dictamenStatus}</u>
            </a>
                Certificado ${tipoDictamenNombre}: <u>${certificado}</u>
            </span>  <span class="d-block mt-2"></span>`;
                        });

                        // Si no hay dictámenes, mostramos un mensaje por defecto
                        if (dictamenesHTML === '') {
                            dictamenesHTML = '<span class="badge rounded-pill bg-danger">Sin dictamen</span>';
                        }

                        // Retornamos el HTML para mostrarlo en la interfaz
                        return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                  <div class="card bg-label-primary">
                     <div class="card-body">
                        <b class="card-title">${tipos}</b>
                        <span class="d-block mt-2">Dirección: ${instalacion.direccion_completa}</span>
                        <span class="d-block mt-2">${dictamenesHTML}</span>
                     </div>
                  </div>
                </div>`;

                    }).join('') : `<div class="text-center">
     <p>No hay instalaciones registradas para esta empresa.</p>
     <a href="/domicilios/instalaciones" class="btn btn-sm btn-primary mt-2" target="_blank">
       Registrar instalación
     </a>
   </div>`;




                tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                  <div class="accordion">
                     <div class="accordion-item">
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white ${empresa.instalaciones.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                INSTALACIONES (${empresa.instalaciones.length}) <br><br>
                                ${empresa.instalaciones.length > 0 ? 'Despliega para ver instalaciones' : 'Sin registros'}
                            </button>
                        </h5>
                        <div id="collapseOne" class="accordion-collapse collapse p-3 row">
                            ${instalaciones}
                        </div>
                     </div>
                  </div>
                </div>`;

                //PREDIOS
                var predios = empresa.predios.length > 0 ?
                    empresa.predios.map(function(predios) {
                        return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                  <div class="card bg-label-warning">
                     <div class="card-body">
                        <b class="card-title">${predios.nombre_predio}</b> <span class="d-block mt-2">
                        No. de predio: ${predios.num_predio}
                     </div>
                  </div>
                </div> `;
                    }).join('') :
                    `<div class="text-center">
     <p>No hay predios registrados para esta empresa.</p>
     <a href="/domicilios/predios" class="btn btn-sm btn-primary mt-2" target="_blank">
       Registrar predio
     </a>
   </div>`;

                tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                  <div class="accordion">
                     <div class="accordion-item">
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white ${empresa.predios.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion6">
                                PREDIOS (${empresa.predios.length}) <br><br>
                                ${empresa.predios.length > 0 ? 'Despliega para ver los predios' : 'Sin registros'}
                            </button>
                        </h5>
                        <div id="coleccion6" class="accordion-collapse collapse p-3 row">
                            ${predios}
                        </div>
                     </div>
                  </div>
                </div>`;

                //DIRECCION DESTINOS
                var destinos = empresa.direccion_destino.length > 0 ?
                    empresa.direccion_destino.map(function(destino) {
                        var tipoDireccion = '';
                        switch (destino.tipo_direccion) {
                            case 1:
                                tipoDireccion = 'Exportación';
                                color = 'bg-info';
                                break;
                            case 2:
                                tipoDireccion = 'Venta Nacional';
                                color = 'bg-primary';
                                break;
                            case 3:
                                tipoDireccion = 'Hologramas';
                                color = 'bg-danger';
                                break;
                            default:
                                tipoDireccion = 'Tipo desconocido';
                                break;
                        }
                        return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                  <div class="card bg-label-warning">
                     <div class="card-body">
                        <b class="card-title">${destino.destinatario}</b> <span class="d-block mt-2">
                        Tipo direccion: <span class="badge rounded-pill ${color}">${tipoDireccion} </span> <span class="d-block mt-3">
                        Domicilio: ${destino.direccion}
                     </div>
                  </div>
                </div> `;
                    }).join('') :
                    `<div class="text-center">
    <p>No hay direcciones de destino registradas para esta empresa.</p>
     <a href="/domicilios/destinos" class="btn btn-sm btn-primary mt-2" target="_blank">
       Registrar dirección
     </a>
   </div>`;

                tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                  <div class="accordion">
                     <div class="accordion-item">
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white ${empresa.direccion_destino.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion7">
                                DIRECCION DESTINOS (${empresa.direccion_destino.length}) <br><br>
                                ${empresa.direccion_destino.length > 0 ? 'Despliega para ver las direcciones' : 'Sin registros'}
                            </button>
                        </h5>
                        <div id="coleccion7" class="accordion-collapse collapse p-3 row">
                            ${destinos}
                        </div>
                     </div>
                  </div>
                </div>`;

                //USUARIOS
                var usuarios = empresa.users.length > 0 ?
                    empresa.users.map(function(usuario) {
                        return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                    <div class="card bg-label-info">
                        <div class="card-body">
                            <b class="card-title">${usuario.name}</b> <span class="d-block mt-2">
                                Correo: ${usuario.email} <span class="d-block mt-3">
                                Teléfono: ${usuario.telefono || ''}
                        </div>
                    </div>
                </div> `;
                    }).join('') :
                    `<div class="text-center">
    <p>No hay usuarios registrados para esta empresa.</p>
     <a href="/usuarios/clientes" class="btn btn-sm btn-primary mt-2" target="_blank">
       Registrar usuario
     </a>
   </div>`;

                tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                  <div class="accordion">
                     <div class="accordion-item">
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white ${empresa.users.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion2">
                                USUARIOS (${empresa.users.length}) <br><br>
                                ${empresa.users.length > 0 ? 'Despliega para ver los usuarios' : 'Sin registros'}
                            </button>
                        </h5>
                        <div id="coleccion2" class="accordion-collapse collapse p-3 row">
                            ${usuarios}
                        </div>
                     </div>
                  </div>
                </div>`;

                //MARCAS
                var marcas = empresa.marcas.length > 0 ?
                    empresa.marcas.map(function(marca) {
                        return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                  <div class="card bg-label-warning">
                     <div class="card-body">
                        <b class="card-title">${marca.marca}</b> <span class="d-block mt-2">
                        Folio: ${marca.folio}
                     </div>
                  </div>
                </div> `;
                    }).join('') :
                    `<div class="text-center">
    <p>No hay marcas registradas para esta empresa.</p>
     <a href="/catalogo/marcas" class="btn btn-sm btn-primary mt-2" target="_blank">
       Registrar marca
     </a>
   </div>`;

                tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                  <div class="accordion">
                     <div class="accordion-item">
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white ${empresa.marcas.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion3">
                                MARCAS (${empresa.marcas.length}) <br><br>
                                ${empresa.marcas.length > 0 ? 'Despliega para ver las marcas' : 'Sin registros'}
                            </button>
                        </h5>
                        <div id="coleccion3" class="accordion-collapse collapse p-3 row">
                            ${marcas}
                        </div>
                     </div>
                  </div>
                </div>`;

                //ETIQUETAS
                var totalEtiquetas = empresa.marcas.reduce((count, marca) => {
                    return count + marca.etiquetas.length; // Sumar la cantidad de etiquetas por cada marca
                }, 0);
                //${full['numero_cliente']}/${full['url_etiqueta']}
                /*URL: ${etiqueta.url_etiqueta ? etiqueta.url_etiqueta.url : 'SIN URL'}
                NUM-CLIENTE: ${empresa.numero_cliente}*/
                var etiquetas = empresa.marcas.some(marca => marca.etiquetas.length > 0) ?
                    empresa.marcas.map(function(marca) {
                        return marca.etiquetas.length > 0 ?
                            marca.etiquetas.map(function(etiqueta) {
                                return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                            <div class="card bg-label-warning">
                                <div class="card-body">
                                    <b class="card-title">${etiqueta.marca.marca}</b> <span class="d-block mt-2">
                                    Descripción: ${etiqueta.sku || 'Sin descripción'} <span class="d-block mt-2">
                                <i class="pdfEtiqueta ri-file-pdf-2-fill text-danger ri-20px cursor-pointer" data-url="${empresa.numero_cliente}/${etiqueta.url_etiqueta ? etiqueta.url_etiqueta.url : ''}"></i>
                                </div>
                            </div>
                        </div>`;
                            }).join('') :
                            '<p>No hay etiquetas registradas para esta marca.</p>';
                    }).join('') :
                    `<div class="text-center">
    <p>No hay etiquetas registradas para esta empresa.</p>
     <a href="/catalogo/etiquetas" class="btn btn-sm btn-primary mt-2" target="_blank">
       Registrar etiquetas
     </a>
   </div>`;

                tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                  <div class="accordion">
                     <div class="accordion-item">
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white ${empresa.marcas.some(marca => marca.etiquetas.length > 0) ?  'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion8">
                                ETIQUETAS (${totalEtiquetas})<br><br>
                                ${empresa.marcas.some(marca => marca.etiquetas.length > 0) ? 'Despliega para ver las etiquetas' : 'Sin registros'}
                            </button>
                        </h5>
                        <div id="coleccion8" class="accordion-collapse collapse p-3 row">
                            ${etiquetas}
                        </div>
                     </div>
                  </div>
                </div>`;

                //LOTES GRANEL
                var lotesGranel = empresa.lotes_granel.length > 0 ?
                    empresa.lotes_granel.map(function(lote) {
                        return ` <div class="col-lg-6 mb-3" style="font-size: 14px">
                        <div class="card bg-label-danger">
                            <div class="card-body">
                                <b class="card-title">${lote.nombre_lote}</b> <span class="d-block mt-2">
                                Volumen: ${lote.volumen}
                            </div>
                        </div>
                    </div>  `;
                    }).join('') :
                    `<div class="text-center">
  <p>No hay lotes granel registrados para esta empresa.</p>
     <a href="/catalogo/lotes_granel" class="btn btn-sm btn-primary mt-2" target="_blank">
       Registrar lote granel
     </a>
   </div>`;

                tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                  <div class="accordion">
                     <div class="accordion-item">
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white ${empresa.lotes_granel.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion4">
                                LOTES GRANEL (${empresa.lotes_granel.length}) <br><br>
                                ${empresa.lotes_granel.length > 0 ? 'Despliega para ver los lotes granel' : 'Sin registros'}
                            </button>
                        </h5>
                        <div id="coleccion4" class="accordion-collapse collapse p-3 row">
                            ${lotesGranel}
                        </div>
                     </div>
                  </div>
                </div>`;

                //LOTES ENVASADOS
                var lotesEnvasado = empresa.lotes_envasado.length > 0 ?
                    empresa.lotes_envasado.map(function(loteEnv) {
                        return ` <div class="col-lg-6 mb-3" style="font-size: 14px">
                    <div class="card bg-label-dark">
                        <div class="card-body">
                            <b class="card-title">${loteEnv.nombre}</b> <span class="d-block mt-2">
                                Marca: ${loteEnv.marca && loteEnv.marca.marca ? loteEnv.marca.marca : 'Sin marca'}
                        </div>
                    </div>
                </div> `;
                    }).join('') :
                    `<div class="text-center">
 <p>No hay lotes envasados registrados para esta empresa.</p>
     <a href="/catalogo/lotes" class="btn btn-sm btn-primary mt-2" target="_blank">
       Registrar lote envasado
     </a>
   </div>`;
                tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                  <div class="accordion">
                     <div class="accordion-item">
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white ${empresa.lotes_envasado.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion5">
                                LOTES ENVASADOS (${empresa.lotes_envasado.length}) <br><br>
                                ${empresa.lotes_envasado.length > 0 ? 'Despliega para ver los lotes envasado' : 'Sin registros'}
                            </button>
                        </h5>
                        <div id="coleccion5" class="accordion-collapse collapse p-3 row">
                            ${lotesEnvasado}
                        </div>
                     </div>
                  </div>
                </div>`;


                // Insertar las tarjetas en el HTML
                $('#tarjetas').html(tarjetasHTML);
            }

        }); //FIN (document).ready(function()



        ///PDF DICTAMEN
        $(document).on('click', '.pdfDictamen', function() {
            var id = $(this).data('id'); //ID del atributo "data-id"
            var tipo = $(this).data('tipo'); //ID del atributo "data-tipo"
            var iframe = $('#pdfViewer');
            var spinner = $('#cargando');

            if (tipo == 1) { // Productor
                var tipo_dictamen = '../dictamen_productor/' + id;
                var titulo = "Dictamen de productor";
            }
            if (tipo == 2) { // Envasador
                var tipo_dictamen = '../dictamen_envasador/' + id;
                var titulo = "Dictamen de envasador";
            }
            if (tipo == 3) { // Comercializador
                var tipo_dictamen = '../dictamen_comercializador/' + id;
                var titulo = "Dictamen de comercializador";
            }
            if (tipo == 4) { // Almacén y bodega
                var tipo_dictamen = '../dictamen_almacen/' + id;
                var titulo = "Dictamen de almacén y bodega";
            }
            if (tipo == 5) { // Área de maduración
                var tipo_dictamen = '../dictamen_maduracion/' + id;
                var titulo = "Dictamen de área de maduración de mezcal";
            }

            //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
            spinner.show();
            iframe.hide();

            //Cargar el PDF con ID
            iframe.attr('src', tipo_dictamen);
            //Configurar el botón para abrir PDF en una nueva pestaña
            $("#NewPestana").attr('href', tipo_dictamen).show();
            $("#titulo_modal").text(titulo);

            //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
            iframe.on('load', function() {
                spinner.hide();
                iframe.show();
            });
        });


        ///PDF CERTIFICADOS
        $(document).on('click', '.pdfCertificado', function() {
            var id = $(this).data('id');
            var tipo = $(this).data('tipo');
            var iframe = $('#pdfViewer');
            var spinner = $('#cargando');

            if (tipo == 1) { // Productor
                var tipo_certificado = '../certificado_productor_mezcal/' + id;
                titulo = "Certificado de productor";
            }
            if (tipo == 2) { // Envasador
                var tipo_certificado = '../certificado_envasador_mezcal/' + id;
                titulo = "Certificado de envasador";
            }
            if (tipo == 3) { // Comercializador
                var tipo_certificado = '../certificado_comercializador/' + id;
                titulo = "Certificado de comercializador";
            }
            if (tipo == 4) { // Almacén y bodega
                var tipo_certificado = '../dictamen_almacen/' + id;
                var titulo = "Certificado de almacén y bodega";
            }
            if (tipo == 5) { // Área de maduración
                var tipo_certificado = '../dictamen_maduracion/' + id;
                var titulo = "Certificado de área de maduración de mezcal";
            }

            //Mostrar el spinner y ocultar el iframe antes de cargar el PDF
            spinner.show();
            iframe.hide();

            //Cargar el PDF con ID
            iframe.attr('src', tipo_certificado);
            //Configurar el botón para abrir PDF en una nueva pestaña
            $("#NewPestana").attr('href', tipo_certificado).show();
            $("#titulo_modal").text(titulo);

            //Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
            iframe.on('load', function() {
                spinner.hide();
                iframe.show();
            });
        });


        ///ETIQUETAS
        $(document).on('click', '.pdfEtiqueta', function() {
            var url = $(this).data("url");
            var iframe = $('#pdfViewer');
            var spinner = $('#cargando');

            spinner.show();
            iframe.hide();
            iframe.attr('src', "/files/" + url); // Asegurarse de que la URL esté bien formada

            // Configurar el botón para abrir el PDF en una nueva pestaña
            $('#NewPestana').attr('href', "/files/" + url);
            //$('#pdfViewer').attr('href', "/files/"+url).show();
            $('#mostrarPdf').modal('show'); // Mostrar el modal

            // Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
            iframe.on('load', function() {
                console.log('PDF cargado en el iframe');
                spinner.hide();
                iframe.show();
            });
        });
    </script>


    <!-------- MODAL -------->
    @include('_partials/_modals/modal-pdfs-frames')

@endsection
