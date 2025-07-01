<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-02-02 ACTA CIRCUNSTANCIADA V6</title>
    <style>
        @page {
            size: 216mm 279mm;
            /* Establece el tamaño de página a 216mm de ancho por 279mm de alto */
            margin: 0;
            /* Elimina todos los márgenes */
        }

        @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');

        }

        body {
            font-family: 'Century Gothic', sans-serif;
            margin: 30px;
            padding: 10px;
            margin-top: 100px;
            margin-bottom: 55px;
            font-size: 15px;
        }

        strong,
        b {

            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            text-align: left;
            vertical-align: middle;
            position: relative;

        }

        .header {
            position: fixed;
            top: 0px;
            left: 40px;
            width: 84%;
            padding: 10px;
            text-align: right;
            z-index: 1;
            margin-bottom: 30px;

        }


        .header img {
            width: 200px;
            height: 80px;
            margin-right: 450px;
        }

        .line {
            position: absolute;
            top: 90px;
            right: 10px;
            width: 68%;
            border-bottom: 1.5px solid black;
        }

        .header-text {
            right: 10px;
            font-size: 12px;
            margin-top: -30;
            padding: 0;
            line-height: 1;
        }

        .img img {
            width: 100px;
            height: auto;
            display: block;
            margin-left: 20px;
            /* Centra la imagen horizontalmente */
        }

        .text-titulo {
            width: 41%;
            text-align: center;
            /* Asegura que el contenido esté centrado */
            vertical-align: top;
            /* Alinea el contenido en la parte superior */
        }

        .text-center {
            width: 25%;
        }

        .text-bold {
            font-weight: bold;
        }

        .content-table td {
            text-align: center;
            height: 3%;
            width: 100%;
            border: none;
        }

        .contenedor {
            margin-left: 40px;
            margin-right: 40px;
            position: relative;
            /* Asegura que la posición sea relativa para que la marca de agua se posicione correctamente */
        }

        .sign-table td {
            border: 2px solid #2B8080;
            text-align: center;
            vertical-align: middle;
        }

        .table-sign td {
            border: 1px solid #31849B;
        }

        p {
            margin: 0;
        }

        p+p {
            margin-top: 5px;
            /* Ajusta este valor según sea necesario */
        }

        .texto {
            text-align: justify;
            word-spacing: 1px;
            line-height: 14px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            /* Ajusta la posición verticalmente */
            left: 50%;
            /* Ajusta la posición horizontalmente */
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
            /* Rotación y escala para mejor apariencia */
            opacity: 0.1;
            /* Ajusta la opacidad según sea necesario */
            letter-spacing: 3px;
            font-size: 68px;
            /* Tamaño del texto de la marca de agua */
            white-space: nowrap;
            /* Evita que el texto se divida en múltiples líneas */
            z-index: -1;
        }

        .footer {
            position: fixed;
            bottom: 15px;
            left: 75px;
            width: 80%;
            font-size: 10.5px;
        }

        .footer-text {
            margin: 0;
            text-align: center;
            width: 85%;
            position: relative;
        }

        .footer-page {
            position: absolute;
            left: 580px;
            top: 0;
            font-size: 10.5px;
        }

        .footer-text2 {
            width: 100%;
            text-align: right;
            margin-top: 15px;
            font-weight: bold;
            color: #1f4b90;
        }

        .footer .page:after {
            content: counter(page);
        }

        .cat {

            margin-bottom: -3;
        }

        /* Clase para la celda con la línea diagonal */
        .diagonal-cell {
            position: relative;
        }

        .diagonal-cell::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-top: 2px solid black;

            transform: rotate(60deg);
            transform-origin: center;
        }
    </style>
</head>

<body>
    <div class="watermark">Acta circunstanciada</div>
    {{-- cabecera --}}
    <div class="header">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo CIDAM">
        <div class="header-text">
            Acta circunstanciada para unidades de producción F-UV-02-02 <br> Edición 7, 15-07-2024<br></div>
        <div class="line"></div>
    </div>

    <div class="footer">
        <p class="footer-text">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
            puede ser distribuido externamente sin la autorización escrita del Ejecutivo.
        </p>
        <p class="footer-page">
            Página <span class="page"></span> de 4
        </p>
        <p class="footer-text2">No. de acreditación UVNOM129 Aprobación por DGN 312.01.2017.1017</p>
    </div>



    {{-- contenedor --}}
    <div class="contenedor">
        <div style="text-align: center;  font-size: 21px ">
            <span style=" font-family: 'Century Gothic Negrita'; !important">
                Acta circunstanciada para Unidades de producción
            </span>
        </div>
        <table class="content-table" style="margin-top: 15px;">
            <tr>
                <td style="border: 2px solid #31849B; width: 80%; padding: 0px;">Acta número: <span
                        style="font-size: 13.5px;  font-family: Century Gothic Negrita;">{{ $datos->actas_inspeccion->num_acta ?? 'Sin asignar' }}</span>
                </td>
                <td style="border: 2px solid ##31849B;">

                </td>
            </tr>
        </table>
        <br>
        <div class="texto">
            <p class="cat">En la categoría de:</p>
            <p class="cat">Unidad de producción de Agave ( @if ($datos->actas_inspeccion->categoria_acta == 'Productora de Agave')
                    X
                @else
                    &nbsp;
                @endif), </p>
            <p class="cat">Unidad de producción de Mezcal (@if ($datos->actas_inspeccion->categoria_acta == 'Productora')
                    X
                @else
                    &nbsp;
                @endif )</p>
            <p class="cat">Planta de Envasado (@if ($datos->actas_inspeccion->categoria_acta == 'Envasadora')
                    X
                @else
                    &nbsp;
                @endif )</p>
            <p class="cat">Comercializadora ( @if ($datos->actas_inspeccion->categoria_acta == 'Comercializadora')
                    X
                @else
                    &nbsp;
                @endif)</p>
            <p class="cat">Almacén ( @if ($datos->actas_inspeccion->categoria_acta == 'Almacén')
                X
            @else
                &nbsp;
            @endif)</p>
            <br>
            <p>En <u>{{$datos->actas_inspeccion->lugar_inspeccion ?? 'Sin datos'}}</u> siendo las <u>{{$hora_llenado }}</u> horas del día {{$fecha_llenado }}.
            </p> <br>
            <p>El suscrito Inspector comisionado por la Unidad de Inspección CIDAM A.C. con domicilio en Kilómetro 8
                Antigua Carretera a Pátzcuaro, S/N Colonia Otra no Especificada en el Catálogo, C.P. 58341, Morelia,
                Michoacán., me encuentro en la Unidad de producción.</p>
            <br>
            <table class="table-sign">
                <tr>
                    <td colspan="2" style="text-align: center; font-family: Century Gothic Negrita;">Datos de la
                        Unidad de Producción</td>
                    <td style="border: none;">
                    </td>
                </tr>
                <tr>
                    <td style="width: ; font-family:Century Gothic Negrita;">Denominación social:</td>
                    <td style="width: 450px;">
                        {{ $datos->solicitud->empresa->razon_social ?? 'Sin datos'}}
                    </td>
                    <td style="border: none;">

                    </td>
                </tr>
                <tr>
                    <td style="width: 200px; font-family:Century Gothic Negrita;">Dirección:</td>
                    <td style="width: 450px">Janamoro , S/N, Libramiento Norte Km 6+800, Ciudad Hidalgo, Hidalgo,
                        Michoacán de Ocampo, C.P. 61040.</td>
                    <td style="border: none;"></td>
                </tr>
                <tr>
                    <td style="width: 200px; font-family:Century Gothic Negrita;">RFC</td>
                    <td></td>
                    <td style="border: none;"></td>
                </tr>
            </table>
            <br>
            <p>Para practicar la visita de inspección para generación del Dictamen de cumplimiento de instalaciones (X)
                en términos de la:</p>
            <br>
            <table class="table-sign">
                <tr>
                    <td style="width: 200px;"><b>Orden de servicio número</b></td>
                    <td style="width: 200px;">{{$datos->num_servicio ?? 'Sin datos'}}</td>
                    <td style="border: none;">

                    </td>
                </tr>
                <tr>
                    <td><b>De fecha:</b></td>
                    <td>
                        {{$fecha_llenado ?? 'Sin datos'}}
                    </td>
                    <td style="border: none;">

                    </td>
                </tr>
                <tr>
                    <td><b>Numero de cliente:</b>
                    </td>
                    <td>{{$datos->empresa_num_cliente->numero_cliente ?? 'Sin datos'}}</td>
                    <td style="border: none;">

                    </td>
                </tr>
            </table>
            <br>
            <p>Cuyo original se entrega en el presente acto al C.<u>{{$datos->actas_inspeccion->encargado ?? 'Sin datos'}} </u>, quien dijo tener el
                cargo de responsable de instalaciones y ante quien me identifiqué debidamente exhibiendo la credencial
                vigente número {{ $datos->actas_inspeccion->num_credencial_encargado ?? 'Sin datos' }}, expedida por
                CIDAM A.C. misma que la persona con quien se entiende la
                diligencia tiene a la vista, examina y devuelve al Inspector.</p>
            <br>
            <b>Designación de testigos</b>
            <br>
            <br>
            <p>Acto seguido se requiere al visitado nombrar a dos testigos, a lo cual manifiesta de conformidad que los
                designó, comunicándome que:</p>

            <table class="table-sign">
                <tr>
                    <td style="width: 5%;">SI</td>
                    <td style="width: 5%;">
                        @if ($datos->actas_inspeccion->testigos == 1)
                            X
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td style="width: 5%;">NO</td>
                    <td style="width: 5%;">
                        @if ($datos->actas_inspeccion->testigos == 2)
                            X.
                        @else
                            &nbsp;
                        @endif
                    </td>
                    </td>
                    <td style="border: none;">designa testigos</td>
                    <td style="border: none;"></td>
                </tr>
            </table>
        </div>
        <br>
        <p>En caso de ausencia o negativa de los suscritos, se procederá con la actividad encomendada, a lo cual
            manifiesta que se puede proceder con la diligencia.</p>
        <br>
        <p>En caso contrario las personas designadas por el interesado son las siguientes:</p>
        <br>
        <table class="sign-table" style="margin-top: 10px; font-size: 10;">
            <tr>
                <td style="width: 80px; height: 40px;">No. de testigo.</td>
                <td>Nombre y firma del testigo</td>
                <td style="width: 280px;">Domicilio</td>
            </tr>

            @foreach ($datos->actas_inspeccion->actas_testigo AS $testigo)
                <tr>
                    <td style="height: 28px;">{{ $testigo->id_acta_testigo ?? '- -' }}</td> <!-- Mostrar "vacío" si el id es nulo -->
                    <td>{{ $testigo->nombre_testigo ?? '- -' }}</td> <!-- Mostrar "vacío" si el nombre es nulo -->
                    <td>{{ $testigo->domicilio ?? '- -' }}</td> <!-- Mostrar "vacío" si el domicilio es nulo -->
                </tr>
            @endforeach

        </table>

    </div>
    <br>
    {{-- contenedor --}}

    <div class="contenedor">
        <div class="texto">
            <p><strong>Parte I Unidad de producción de Agave.</strong></p>
            <br>
            <p>Se constató físicamente la existencia de la unidad de producción de agave: </p>
        </div>
        <table class="sign-table" style="margin-top: 20px; font-size: 10;">
            <tr>
                <td style="width: 90px; height: 55px;">Nombre del predio</td>
                <td>Especie de agave</td>
                <td>Superficie (hectáreas)</td>
                <td>Madurez del agave (años)</td>
                <td>Plagas en el cultivo</td>
                <td>Cantidad de Plantas</td>
{{--                 <td style="width: 90px;">Coordenadas</td>
 --}}            </tr>

           @foreach ($datos->actas_inspeccion->actas_produccion AS $plantacion)
            <tr>
                <td >{{$plantacion->predio_plantacion->predio->nombre_predio ?? '- -'}}</td>
                <td>{{$plantacion->predio_plantacion->predio->catalogo_tipo_agave->nombre ?? '- -'}}</td>
                <td>{{$plantacion->predio_plantacion->predio->superficie ?? '- -'}}</td>
                <td>{{$plantacion->predio_plantacion->anio_plantacion ?? '- -'}}</td>
                <td>{{ $plantacion->plagas ?? '- -' }}</td>
                <td >{{ $plantacion->predio_plantacion->num_plantas ?? '- -' }}</td> <!-- Mostrar "vacío" si el id es nulo -->

            </tr>
        @endforeach
        </table>
        <br>
        <div class="texto">
            <p><strong>Parte II Unidad de producción de Mezcal.</strong></p>
            <br>
            <p>Se constató físicamente la existencia del siguiente de las áreas y equipo:</p>
        </div>
        <table class="sign-table" >
            <thead>
                <tr>
                    <td style="width: 90px; height: 60px;">Recepción (materia prima)</td>
                    <td>Área de pesado</td>
                    <td>Área de cocción</td>
                    <td>Área de maguey cocido</td>
                    <td>Área de molienda</td>
                    <td>Área de fermentación</td>
                    <td style="width: 90px;">Área de destilación</td>
                    <td>Almacén a graneles</td>
                </tr>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 0; // Contador para las respuestas
                @endphp

                @foreach ($datos->actas_inspeccion->acta_produccion_mezcal AS $area)
                    @if ($counter % 8 == 0) <!-- Si el contador es múltiplo de 8, empieza un nuevo <tr> -->
                        <tr>
                    @endif

                    <td>{{ $area->respuesta ?? '- -' }}</td> <!-- Mostrar "vacío" si la respuesta es nula -->

                    @php
                        $counter++; // Incrementar el contador
                    @endphp

                    @if ($counter % 8 == 0) <!-- Si el contador es múltiplo de 8, cierra el <tr> -->
                        </tr>
                    @endif
                @endforeach

                @if ($counter % 8 != 0) <!-- Si no hemos cerrado el último <tr>, ciérralo aquí -->
                    </tr>
                @endif

                <!-- Si deseas agregar una fila adicional si hay respuestas restantes -->
                @if ($counter % 8 != 0)
                    <tr>
                        @for ($i = $counter % 8; $i < 8; $i++)
                            <td></td> <!-- Rellenar celdas vacías si no se llenaron -->
                        @endfor
                    </tr>
                @endif
            </tbody>
        </table>

        <br>
        <div class="texto">
            <p>Se constató físicamente la existencia de los siguientes equipos: </p>
        </div>
        <table class="sign-table" style="margin-top: 20px; font-size: 10;">
            <thead>
                <tr>
                    <td style="width: 240px; height: 40px;">Equipo</td>
                    <td style="width: 120px;">Cantidad</td>
                    <td>Capacidad</td>
                    <td>Tipo de material</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos->actas_inspeccion->actas_equipo_mezcal AS $equipo_maezcal)
                <tr>
                    <td style="height: 28px;">{{ $equipo_maezcal->equipo ?? '- -' }}</td> <!-- Mostrar "vacío" si el id es nulo -->
                    <td>{{ $equipo_maezcal->cantidad ?? '- -' }}</td> <!-- Mostrar "vacío" si el nombre es nulo -->
                    <td>{{ $equipo_maezcal->capacidad ?? '- -' }}</td> <!-- Mostrar "vacío" si el domicilio es nulo -->
                    <td>{{ $equipo_maezcal->tipo_material ?? '- -' }}</td> <!-- Mostrar "vacío" si el domicilio es nulo -->
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    <br><br>



    {{-- seccion 3 --}}

    <br>
    {{-- contenedor --}}
    <div class="contenedor">
        <div class="texto">
            <p>Se constató que ( ) cuenta con la infraestructura y equipo para producir _______</p>
            <br>
            <p>Categoría(s): ____________________ Clase(s): _________________ Otra: ______________.</p>
            <br>
            <p><strong>Parte III Unidad de envasado</strong></p>
            <br>
            <p>Se constató físicamente la existencia del siguiente de las áreas y equipo:</p>
        </div>

        <table class="sign-table" style="margin-top: 20px; font-size: 10;">
            <thead>
                <td style="width: 90px; height: 80px;">Almacén de insumos</td>
                <td style="width: 105px;">Almacén a gráneles</td>
                <td>Sistema de filtrado</td>
                <td>Área de envasado</td>
                <td>Área de tiquetado</td>
                <td>Almacén de producto terminado</td>
                <td style="width: 115px;">Área de aseo personal</td>
            </thead>
            <tbody>
                @php
                    $counter = 0; // Contador para las respuestas
                @endphp

                @foreach ($datos->actas_inspeccion->actas_unidad_envasado AS $envasado)
                    @if ($counter % 7 == 0) <!-- Si el contador es múltiplo de 8, empieza un nuevo <tr> -->
                        <tr>
                    @endif

                    <td>{{ $envasado->respuestas ?? '- -' }}</td> <!-- Mostrar "vacío" si la respuesta es nula -->

                    @php
                        $counter++; // Incrementar el contador
                    @endphp

                    @if ($counter % 7 == 0) <!-- Si el contador es múltiplo de 8, cierra el <tr> -->
                        </tr>
                    @endif
                @endforeach

                @if ($counter % 7 != 0) <!-- Si no hemos cerrado el último <tr>, ciérralo aquí -->
                    </tr>
                @endif

                <!-- Si deseas agregar una fila adicional si hay respuestas restantes -->
                @if ($counter % 7 != 0)
                    <tr>
                        @for ($i = $counter % 7; $i < 7; $i++)
                            <td></td> <!-- Rellenar celdas vacías si no se llenaron -->
                        @endfor
                    </tr>
                @endif
            </tbody>
        </table>
        <br>
        <div class="texto">
            <p>Se constató que la unidad de envasado, ( ) cumple con los requisitos de infraestructura y
                equipamiento indispensables para el envasado de mezcal.</p>
            <br>
            <p>Se constató físicamente la existencia de los siguientes equipos: </p>
        </div>

        <table class="sign-table" style="margin-top: 20px; font-size: 10;">
            <thead>
                <tr>
                    <td style="width: 240px; height: 45px;">Equipo</td>
                    <td style="width: 120px;">Cantidad</td>
                    <td>Capacidad</td>
                    <td>Tipo de material</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($datos->actas_inspeccion->actas_equipo_envasado AS $equipo_envasado)
                <tr>
                    <td style="height: 28px;">{{ $equipo_envasado->equipo_envasado ?? '- -' }}</td> <!-- Mostrar "vacío" si el id es nulo -->
                    <td>{{ $equipo_envasado->cantidad_envasado ?? '- -' }}</td> <!-- Mostrar "vacío" si el nombre es nulo -->
                    <td>{{ $equipo_envasado->capacidad_envasado ?? '- -' }}</td> <!-- Mostrar "vacío" si el domicilio es nulo -->
                    <td>{{ $equipo_envasado->tipo_material_envasado ?? '- -' }}</td> <!-- Mostrar "vacío" si el domicilio es nulo -->
                </tr>
            @endforeach
            </tbody>
        </table>
        <br>

        <div class="texto">
            <p><b>Parte IV Unidad de comercialización</b></p>
            <br>
            <p>Se constató físicamente la existencia del siguiente de las áreas y equipo:</p>
            <br>
        </div>

        <table class="sign-table" style=" font-size: 10;">
            <thead>
                <td style="width: 180px; height: 55px;">Bodega o almacén</td>
                <td>Tarimas</td>
                <td>Bitácoras</td>
                <td style="width: 120px;">Otro:</td>
                <td style="width: 120px;">Otro:</td>
            </thead>
            <tbody>
                @php
                    $counter = 0; // Contador para las respuestas
                @endphp

                @foreach ($datos->actas_inspeccion->actas_unidad_comercializacion AS $comercio)
                    @if ($counter % 5 == 0) <!-- Si el contador es múltiplo de 8, empieza un nuevo <tr> -->
                        <tr>
                    @endif

                    <td>{{ $comercio->respuestas_comercio ?? '- -' }}</td> <!-- Mostrar "vacío" si la respuesta es nula -->

                    @php
                        $counter++; // Incrementar el contador
                    @endphp

                    @if ($counter % 5 == 0) <!-- Si el contador es múltiplo de 8, cierra el <tr> -->
                        </tr>
                    @endif
                @endforeach

                @if ($counter % 5 != 0) <!-- Si no hemos cerrado el último <tr>, ciérralo aquí -->
                    </tr>
                @endif

                <!-- Si deseas agregar una fila adicional si hay respuestas restantes -->
                @if ($counter % 5 != 0)
                    <tr>
                        @for ($i = $counter % 5; $i < 5; $i++)
                            <td></td> <!-- Rellenar celdas vacías si no se llenaron -->
                        @endfor
                    </tr>
                @endif
            </tbody>
        </table>
        <br>
        <div class="texto">
            <p>Se procede a tomar evidencias fotográficas de la infraestructura y equipo relacionadas a la actividad
                realizada, las cuales serán integradas en su expediente.</p>
            <br>
        </div>
    </div>



    {{-- seccion 4 --}}

    <br>
    <div class="contenedor">
        <div class="texto">
            <p>Se cierra la presente acta. - Respecto a los hechos consignados en el presente acta y de
                conformidad con los artículos 53, 54, 55, 56, 57 y 69 de la Ley de Infraestructura de la
                Calidad, la Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas alcohólicas-Mezcal-
                Especificaciones y el apartado 7.4 de la Norma Mexicana NMX-EC-17020-IMNC-2014
                “Evaluación de la conformidad- Requisitos para el funcionamiento de diferentes tipos de
                unidades (organismos) que realizan la verificación (Inspección)”, se da oportunidad al
                visitado para que haga las observaciones y ofrezca pruebas en relación con los hechos
                contenidos en ella o por escrito hacer uso de tal derecho dentro del término de cinco días
                hábiles siguientes a la fecha en que se haya levantado la presente acta.</p>
            <br>
            <p>Se da por terminada la presente diligencia siendo las <u>{{$hora_llenado_fin }}</u> horas del día {{$fecha_llenado_fin }}.
            </p>
        </div>

        <div style="padding: 20px;">
            <table class="sign-table" style="font-size: 12;">
                <tr>
                    <td style="width: 45%; height: 10px;">Nombre del interesado</td>
                    <td>Nombre del Inspector</td>
                </tr>
                <tr>
                    <td style="height: 90px;">{{ $datos->actas_inspeccion->encargado ?? 'Sin datos'}}</td>
                    <td style="text-align: center;">{{ $datos->inspector->name ?? 'Sin datos'}}</td>
                </tr>
            </table>

            <br>

            <table class="sign-table">
                <tr>
                    <td colspan="2" style="height: 35px;">No conformidades identificadas en la inspección</td>
                </tr>
                <tr>
                    <td style="width: 45%; height: 35px; text-align: start;  vertical-align: top;">Infraestructura</td>
                    <td style="height: 35px; text-align: start;  vertical-align: top;">Equipo</td>
                </tr>
                <tr>
                    <td style="height: 35px;">{{ $datos->actas_inspeccion->no_conf_infraestructura ?? 'Sin datos' }}
                    </td>
                    <td style="height: 35px;">{{ $datos->actas_inspeccion->no_conf_equipo ?? 'Sin datos' }}</td>
                </tr>
            </table>
        </div>
    </div>
    <br>



</body>

</html>
