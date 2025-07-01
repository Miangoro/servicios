<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F4.1-01-01 Contrato de prestación de servicios NOM 070 Ed 4 VIGENTE</title>
    <style>


        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            margin: 15;
            margin-top: 100px;
            padding-bottom: 60px;
            font-size: 14px;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            background-color: #fff;
            text-align: right;
            z-index: 1;
            margin-bottom: 30px;
        }


        .header img {
            width: 150px;
            float: left;
            margin-right: 10px;
        }

        .line {
            position: absolute;
            top: 80px;
            right: 10px;
            width: 68%;
            border-bottom: 1.5px solid black;
        }

        td {
            padding: 20px;
            text-align: justify;
            vertical-align: top;
            line-height: 1.5;
            /* Ajustado para separación normal */
        }

        .texto {
            font-size: 14px;
            text-align: justify;
            line-height: 1.5;
            /* Ajustado para separación normal */
        }

        .containers {
            padding: 15px;
        }

        .si {
            padding: 15px;
        }

        .bold {
            font-weight: bold;
        }

        .small-column {
            width: 50%;
        }

        .large-column {
            width: 50%;
        }

        p {
            margin: 0;
        }

        p+p {
            margin-top: 5px;
            /* Ajusta este valor según sea necesario */
        }

        ul.custom-list {
            line-height: 1.5;
            /* Ajustado para separación normal */
            padding-left: 0;
            /* Elimina el relleno adicional del ul */
        }

        ul.custom-list li {
            margin-bottom: 5px;
            /* Ajusta la separación vertical entre los elementos de la lista */
            text-indent: 1.5em;
            /* Ajusta el valor para separar la viñeta del texto */
            margin-left: 1em;
            /* Aumenta el margen izquierdo para crear espacio adicional */
        }



        .content {
            margin: 60px;
            padding: 15px;
            /* Ajusta este valor según sea necesario */
        }


        /* Estilos para el nuevo encabezado más pequeño */
        .new-header {
            margin-top: 0px;
            padding: 10px;
            /* Menos padding para ser más pequeño */
            text-align: right;
            position: relative;
        }

        .new-header img {
            margin-top: 0px;
            width: 100px;
            /* Imagen más pequeña */
            float: left;
        }

        .header-text {
            line-height: 1.5;
            font-size: 9px;
            margin-top: 0;
            padding: 0;
        }

        /* Estilos específicos para un td */
        .td-especifico {
            padding: 10px;
            /* Diferente padding */
            text-align: justify;
            /* Diferente alineación de texto */
            vertical-align: middle;
            /* Diferente alineación vertical */
            line-height: 1.4;
            /* Diferente line-height */
            word-spacing: normal;
            /* Diferente word-spacing */
            width: 50%;
            font-weight: lighter;
            /* Grosor de letra mas delgado */
            font-size: 9px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: -40;
            width: 100%;
            font-size: 10.5px;
           
        }

        .footer-text {
            text-align: center;
           
            
            margin: 0;
            
        }

        .footer-page {
        text-align: right;
        margin-top: 5px;
        font-size: 12px;
    }

    .footer .page:after {
        content: counter(page);
    }
    </style>


</head>

<body>
    {{-- seccion 1/11 --}}
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        Contrato de prestación de servicios F4.1-01-01 <br> NOM-070-SCFI-2016 <br> Edición 4 <br>
        Entrada en vigor 10/04/2024<br>
        <div class="line"></div>
    </div>
    <div class="footer">
        <p class="footer-text">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
        </p>
        <p class="footer-page">
            Página <span class="page"></span> de 11
        </p>
    </div>
    <br>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td style="width: 51%;">
                                <p class="bold" style="font-size: 13px;">CONTRATO DE PRESTACIÓN DE SERVICIOS
                                    QUE CELEBRAN POR UNA PARTE EL CENTRO
                                    DE INNOVACIÓN Y DESARROLLO
                                    AGROALIMENTARIO DE MICHOACÁN, A.C. A
                                    QUIEN EN LO SUCESIVO SE LE DENOMINARÁ
                                    “EL CIDAM, A.C.”, REPRESENTADO EN ESTE
                                    ACTO POR SU REPRESENTANTE LEGAL LA
                                    MTRA. SYLVANA FIGUEROA SILVA Y POR LA
                                    OTRA <u>{{ mb_strtoupper($datos[0]->razon_social) ?? 'Sin especificar' }}</u>, REPRESENTADO EN ESTE
                                    ACTO POR SU REPRESENTANTE LEGAL EL C.
                                    <u>{{ mb_strtoupper($datos[0]->representante) ?? 'Sin especificar' }}</u> Y A QUIEN EN LO SUCESIVO SE LE
                                    DENOMINARÁ “EL CLIENTE”, AL TENOR DE
                                    LOS ANTECEDENTES, DECLARACIONES Y
                                    CLÁUSULAS SIGUIENTES:
                                </p>
                                <br>
                                <strong>
                                    <p style="text-align: center;">ANTECEDENTES</p>
                                </strong>
                                <p>
                                    Con fecha del día 31 de enero de 2017 la
                                    Universidad Michoacana de San Nicolás de
                                    Hidalgo recibió la acreditación indefinida
                                    de parte de la Entidad Mexicana de
                                    Acreditación, Asociación Civil (en lo
                                    conducente <strong>EMA, A.C.</strong>) bajo la norma
                                    NMX-EC-17020-IMNC-2014
                                </p>
                                <p>
                                    ISO/IEC17020:2012. Requisitos para el
                                    funcionamiento de diferentes tipos de
                                    unidades (organismos) que realizan la
                                    verificación (inspección), para la materia
                                    de Producto con numero de Acreditación
                                    Número: UVNOM 129, Número de
                                    referencia: 17UV2010 y con fecha de
                                    actualización: 2017/07/10, y con
                                    aprobación por la Dirección General de
                                    Normas en su oficio: DGN.312.01.2019.1446
                                </p>
                            </td>

                            <td>
                                <p>de fecha 06 de mayo de 2019 de manera
                                    indefinida mientras se mantenga la
                                    acreditación No. UVNOM 145 otorgada por
                                    la EMA, A.C. con alcance a la
                                    NOM-070-SCFI-2016, Bebidas
                                    alcohólicas-Mezcal-NOM-070-SCFI-2016,
                                    Especificaciones. Por otro lado, la
                                    Universidad Michoacana de San Nicolás de
                                    Hidalgo es Asociado Propietario de
                                    <strong> “CIDAM, A.C.”</strong> según se establece en la
                                    escritura pública número 2,551, volumen 73,
                                    de fecha 11 de enero del año 2012.
                                    Además, se tiene firmado un contrato de
                                    colaboración vigente para operar la
                                    Unidad de verificación UVEM NOM 129 de
                                    la UMSNH en las Instalaciones del CIDAM
                                    <strong>“EL CIDAM, A.C.”</strong> solicitará a la Unidad de
                                    Verificación de la UMSNH el servicio de
                                    Verificación cada vez que lo requiera
                                    <br>
                                    <strong>“EL CIDAM, A.C.”</strong>, cuenta con la
                                    acreditación por la EMA, A.C. bajo la
                                    norma NMX-EC-17065-IMNC-2014 ISO/IEC
                                    17065:2012. Evaluación de la conformidad -
                                    requisitos para organismos que certifican
                                    productos, procesos y servicios, para el
                                    programa de Productos, con la
                                    Acreditación Número: 144/18 de fecha
                                    2018/12/06 y con Fecha de actualización:
                                    2019/05/16, y aprobados por la DGN en su
                                    oficio: Of. No. DGN.312.01.2018.3927 de
                                    fecha 11 de diciembre de 2018 con la
                                    autorización de forma indefinida mientras
                                    <br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- seccion 2/11 --}}
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="small-column">
                                <p>
                                    se mantenga la Acreditación Número:
                                    144/18 otorgada por la EMA, A.C.
                                </p> <br>
                                <p style="text-align: center;"> <strong>DECLARACIONES</strong></p>
                                <p><strong>I. DECLARA “EL CIDAM, A.C.”</strong></p>
                                <p><strong>I.I</strong> Mediante las escrituras públicas número
                                    2,551, volumen 73, de fecha 11 de enero
                                    del año 2012 y número 4304, vol.104, de
                                    fecha 25 de febrero del 2015, pasadas ante
                                    la fe de la Lic. Columba Arias Solís, Notario
                                    Público número 128, en el estado de
                                    Michoacán, se hizo constar la constitución
                                    de la asociación civil denominada “Centro
                                    de Innovación y Desarrollo Agroalimentario
                                    de Michoacán, Asociación Civil” bajo la
                                    figura de asociación estratégica de
                                    acuerdo a la Ley de Ciencia y Tecnología,
                                    para realizar un fin lícito y no lucrativo, cuyo
                                    objeto social es el fungir como una
                                    organización articuladora del
                                    conocimiento cuyo quehacer será definido
                                    por la problemática de las cadenas
                                    agroalimentarias del estado de
                                    Michoacán.
                                </p> <br>
                                <p><strong>I.II</strong> Que su apoderada legal la Mtra.
                                    Sylvana Figueroa Silva, Directora Ejecutiva;
                                    acredita su personalidad con el
                                    nombramiento otorgado a su favor por la
                                    Asamblea de Asociados propietarios del
                                    <strong>“CIDAM, A.C.”</strong>, de fecha 03 de marzo de
                                    2022, mismo que es protocolizado en la
                                    Escritura Publica número 20,803, volumen
                                    número 618, ante Notario Público no. 30 del
                                </p>
                            </td>
                            <td>
                                <p>
                                    estado de Michoacán, el Lic. Juan Carlos
                                    Bolaños Abraham con fecha 16 de mayo
                                    de 2019, en el cual se le otorgan las
                                    facultades suficientes para representar al
                                    “Centro de Innovación y Desarrollo
                                    Agroalimentario de Michoacán, A. C.”,

                                </p>

                                <p>
                                    <strong>I. III</strong> Así mismo manifiesta
                                    <strong>“EL CIDAM, A.C.”</strong> que tiene como domicilio
                                    social el ubicado en Kilometro 8 antigua
                                    carretera a Pátzcuaro s/n Col. Otra no
                                    especificada en el catálogo C.P. 58341
                                    Morelia Michoacán.
                                </p>
                                <p></p>
                                <p></p>
                                <p>
                                    <strong>II.- DECLARA “EL CLIENTE”:</strong>
                                </p>
                                <p> <strong>II.I.</strong>
                                    Que es una sociedad mercantil
                                    <strong>“{{ mb_strtoupper($datos[0]->sociedad_mercantil) ?? 'Sin especificar' }}”</strong>
                                    constituida como lo indica el instrumento
                                    público número <strong>{{ mb_strtoupper($datos[0]->num_instrumento) ?? 'Sin especificar' }}</strong>,
                                    volumen <strong>{{ mb_strtoupper($datos[0]->vol_instrumento) ?? 'Sin especificar' }}</strong>, el
                                    <strong>{{ $fecha_cedula }}</strong>, del Protocolo a cargo del
                                    Licenciado <strong>{{ mb_strtoupper($datos[0]->nombre_notario) ?? 'Sin especificar' }}</strong>, el
                                    <strong>, Notario público número
                                        <strong>{{ mb_strtoupper($datos[0]->num_notario) }}</strong> del Estado de
                                        <strong>{{ mb_strtoupper($datos[0]->estado_notario) }}</strong>; número de
                                        permiso: <strong>{{ mb_strtoupper($datos[0]->num_permiso) ?? 'Sin especificar' }}</strong> (clave
                                        única del
                                        documento) emitido por la Secretaria de
                                        Economía - Dirección General de
                                        Normatividad Mercantil Autorización de
                                        Uso de Denominación o Razón Social.
                                </p>

                                <p>
                                    <strong>II.II. </strong>
                                    Que su representante legal es el C.
                                    <strong>{{ mb_strtoupper($datos[0]->representante) ?? 'Sin especificar' }}</strong>,
                                    acredita su personalidad con el instrumento
                                    público número {{ mb_strtoupper($datos[0]->num_instrumento) ?? 'Sin especificar' }}, volumen
                                    {{ mb_strtoupper($datos[0]->vol_instrumento) }} del {{ $fecha_cedula }}, del
                                    Protocolo a
                                    cargo del Licenciado {{ mb_strtoupper($datos[0]->nombre_notario) ?? 'Sin especificar' }}, Notario
                                    público
                                    número {{ mb_strtoupper($datos[0]->num_permiso) ?? 'Sin especificar' }} del Estado de
                                    {{ mb_strtoupper($datos[0]->estado_notario) ?? 'Sin especificar' }},
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    {{-- seccion 3/11 --}}
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>

                            <td class="small-column">
                                <p>
                                    con la cual se les otorgan facultades
                                    suficientes para representar a <strong>“EL CLIENTE”</strong>.
                                </p>
                                <p></p>
                                <p>
                                    <strong>II.III.</strong> Que su registro federal de causantes
                                    es: <strong>{{ mb_strtoupper($datos[0]->rfc) ?? 'Sin especificar' }}</strong>.
                                </p>
                                <p></p>
                                <p>
                                    <strong>II.IV.</strong> Que su domicilio legal se encuentra
                                    ubicado en <strong>{{ $datos[0]->domicilio_fiscal }}</strong>, mismo que señala
                                    para
                                    todos los fines y efectos del presente
                                    contrato.
                                </p>
                                <p><strong>III. DECLARAN “LAS PARTES”</strong></p>
                                <p>
                                    <strong>III.I</strong> Que reconocen mutuamente su
                                    personalidad y capacidad legal para
                                    convenir y manifiestan estar conformes con
                                    las declaraciones que anteceden.

                                </p>
                                <p></p>
                                <strong>III.II</strong> Que, en virtud de las anteriores
                                declaraciones, las partes manifiestan que
                                es su voluntad celebrar el presente
                                contrato de servicios obligándose
                                recíprocamente en sus términos y
                                someterse a lo dispuesto en los diversos
                                ordenamientos encargados de regular los
                                actos jurídicos de esta naturaleza.

                                <p></p>
                                <p>Que los titulares sin transferir lo estipulado a
                                    terceras personas desean celebrar el
                                    presente Contrato al efecto de las
                                    siguientes:
                                </p>
                                <p></p>
                                <p style="text-align: center;"> <strong>CLÁUSULAS</strong></p>
                                <p></p>
                                <p><strong>PRIMERA.</strong> OBJETO. Es objeto del presente
                                    contrato definir las condiciones mediante
                                    las cuales el Organismo Certificador “OC”</p>
                            </td>
                            <td>

                                <p>
                                    del <strong>“CIDAM, A.C.”</strong> prestará sus servicios de
                                    certificación”.
                                </p>
                                <p>
                                    SEGUNDA. <strong>“EL CIDAM, A.C.”</strong> se
                                    compromete a prestar sus servicios de
                                    certificación mientras <strong>“EL CLIENTE”</strong> cumpla
                                    con las obligaciones contraídas en el
                                    presente contrato y cubra los costos de los
                                    servicios correspondientes.
                                </p>
                                <p></p>
                                <p>
                                    <strong>TERCERA.</strong> OBLIGACIONES DE <strong>“EL CLIENTE”</strong>.
                                </p>
                                <p>
                                    a) A cumplir con los requisitos de
                                    certificación, incluyendo la
                                    implementación de los cambios
                                    adecuados cuando sean comunicados por
                                    parte del <strong>“CIDAM, A.C.”</strong>.
                                </p>
                                <p>
                                    b) <strong>“EL CLIENTE”</strong> deberá sujetarse al
                                    formato F7.1-02-09 Manual de certificación
                                    F7.1-01-01 Manual de certificación
                                    NOM-070-SCFI-2016, para no incumplir con
                                    las obligaciones estipuladas en el presente
                                    documento, si <strong>“EL CLIENTE”</strong> no cumple con
                                    estos requisitos señalados en el Manual de
                                    certificación, está en el entendido que
                                    estará quebrantando lo pactado en este
                                    instrumento jurídico y será sujeto a
                                    sanciones legales atendiendo además con
                                    lo señalado en la cláusula OCTAVA del
                                    presente documento. Este Manual de
                                    certificación, lo podrá consultar en el sitio
                                    web <a href="https://www.cidam.org/sitio/"><b
                                            style="color: blue;">www.cidam.org.</a></b>
                                </p>
                                <p>c) Que el producto dictaminado y
                                    certificado continúe cumpliendo con los
                                    requisitos desde la materia prima hasta el</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>

            </div>
        </div>
    </div>
    <br>


    {{-- seccion 4/11 --}}

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="small-column">
                                <p>
                                    producto final, por lo que la certificación
                                    aplica a la producción en curso.
                                </p>
                                <p>
                                    d) <strong>“El CLIENTE”</strong> se compromete a
                                    cumplir con los parámetros fisicoquímicos
                                    de la NOM-070-SCFI-2016, Bebidas
                                    alcohólicas-Mezcal-especificaciones,
                                    considerando que tanto el resultado
                                    informado como su incertidumbre
                                    expandida deberán estar dentro de los
                                    rangos permitidos por dicha norma.
                                </p>
                                <p>
                                    e) <strong>“EL CLIENTE”</strong> se compromete a
                                    cumplir con lo estipulado en el formato
                                    F7.2-01-06 Política de venta de hologramas,
                                    (Anexo a este contrato), en donde se
                                    establecen las bases de devolución del
                                    material impreso en caso de que no se
                                    cumplan los requisitos de certificación, y lo
                                    relacionado a la NOM-070-SCFI-2016,
                                    Bebidas alcohólicas-MezcalEspecificaciones.
                                </p>
                                <p>
                                    f) <strong>“El CLIENTE”</strong> se compromete a
                                    adquirir y/o utilizar materia prima permitida
                                    por la normativa aplicable.

                                </p>
                                <p>
                                    g) Dar las facilidades para que se
                                    realicen las evaluaciones y vigilancias, estar
                                    disponibles para la inspección la
                                    documentación, registros, equipos, áreas,
                                    personal y subcontratistas que sean
                                    pertinentes.
                                </p>
                                <p>
                                    h) Atender los incumplimientos
                                    marcados por <strong>“EL CIDAM, A.C.”</strong> y dar
                                    facilidades para investigar las quejas
                                    interpuestas por las partes interesadas.
                                </p>
                            </td>

                            <td>
                                <p>i) Permitir la participación de
                                    observadores durante las evaluaciones si
                                    fuera necesario.
                                </p>
                                <p>j) En caso de emitir alguna
                                    declaración sobre la certificación, será
                                    coherente con su alcance certificado.</p>
                                <p>k) No utilizar la certificación otorgada
                                    de manera que ocasione mala reputación
                                    para <strong>“EL CIDAM, A.C.”</strong> y a no utilizar
                                    declaraciones que puedan determinarse
                                    engañosas o no autorizadas.</p>
                                <p>l) <strong>“El CLIENTE”</strong> se compromete a
                                    cumplir con el Instructivo para el uso de
                                    certificados y marcas I4.1-01-01, así como el
                                    Manual de identidad corporativa del OC
                                    CIDAM F4.1-01-02, los cuales serán enviados
                                    por personal del Organismo Certificador
                                    “OC” por lo cual se le pide firmar el formato
                                    que se encuentra anexa a éste contrato
                                    para confirmar de enterado. En caso de no
                                    cumplir con lo estipulado en esta cláusula
                                    se procederá a denegar o cancelar la
                                    certificación.
                                </p>
                                <p>m) Inmediatamente después de retirar,
                                    suspender o finalizar la certificación dejar
                                    de utilizar toda publicidad que haga
                                    referencia a la certificación otorgada por
                                    <strong>“EL CIDAM, A.C.”</strong>
                                </p>
                                <p>n) Si <strong>“EL CLIENTE”</strong> suministra copias de
                                    los documentos de certificación a otros, los
                                    documentos se deben reproducir en su
                                    totalidad, no de manera parcial, con el fin
                                    de mantener la estructura original de los
                                    documentos.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>



    {{-- seccion 5/11 --}}
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>

                            <td>
                                <p>o) A hacer referencia a la
                                    certificación de producto en medios
                                    publicitarios únicamente cuando cumpla
                                    con los requisitos de <strong>“EL CIDAM, A.C.”</strong>
                                    relacionados al esquema de certificación.
                                </p>
                                <p>
                                    p) Cumplir con los requisitos que
                                    establece el esquema de certificación con
                                    relación al uso de marcas de conformidad
                                    y a la información relacionada con el
                                    producto.
                                </p>
                                <p>
                                    q) Cuando <strong>“EL CLIENTE”</strong> emita una
                                    queja y esta proceda, <strong>“EL CIDAM, A.C.”</strong>,
                                    enviará al reclamante una notificación
                                    formal sobre el resultado y la finalización
                                    del proceso de reclamación, <strong>“EL CIDAM, A.C.”</strong> debe proporcionar al
                                    apelante una
                                    notificación formal del resultado y la
                                    finalización del proceso de apelación, para
                                    que <strong>“EL CLIENTE”</strong> conozca el proceso de
                                    atención de quejas y apelaciones <strong>“EL CLIENTE”</strong> podrá revisar el
                                    documento
                                    PR-UGII-008 el cual puede solicitarlo a los
                                    miembros del Organismo de Certificación
                                    para su consulta.

                                </p>

                                <p>r) Informar a <strong>“EL CIDAM, A.C.”</strong>, sin
                                    retraso, acerca de los cambios que
                                    pueden afectar a su capacidad para
                                    cumplir con los requisitos de la certificación,
                                    entre ellos los cambios en la condición
                                    legal, comercial, cambio de personal
                                    directivo, modificaciones en el producto,
                                    direcciones de contacto y sitios de
                                    producción.
                                </p>
                            </td>
                            <td style=" width: 52%;">
                                <p>
                                    s) A cumplir con los requisitos de
                                    confidencialidad y demás obligaciones
                                    establecidas en el presente Contrato.
                                </p>
                                <p>
                                    t) <strong>“EL CLIENTE”</strong> acepta de
                                    conformidad el servicio de los laboratorios
                                    subcontratados por <strong>“EL CIDAM, A.C.”</strong>, los
                                    cuales se encuentran debidamente
                                    acreditados por la EMA A.C. bajo la norma
                                    NMX-EC-17025-IMNC-2018 Requisitos
                                    Generales para la Competencia de los
                                    Laboratorios de Ensayo y Calibración, y
                                    aprobados por la DGN. Así mismo <strong>“EL CLIENTE”</strong> será el encargado de
                                    enviar y
                                    cubrir el gasto por la prueba que efectúe el
                                    laboratorio subcontratado, de
                                    conformidad con los artículos 52, 66, 91 y
                                    142 de la Ley de Infraestructura de Calidad.
                                </p>
                                <p>
                                    u) Es responsabilidad del cliente
                                    contar con las evidencias de las
                                    actividades evaluadas y aprobadas por un
                                    Organismo de Certificación acreditado
                                    ante la EMA A.C., distinto al Organismo de
                                    Certificación del CIDAM.
                                </p>
                                <p>
                                    v) <strong>“EL CLIENTE”</strong> reconoce y acepta
                                    que la falsedad de documentos o
                                    declaración sobre estos, entregados como
                                    requisitos a <strong>“EL CIDAM, A.C.”</strong> causará la
                                    cancelación del (de los) certificado(s)
                                    emitido(s) por <strong>“EL CIDAM, A.C.”</strong>.
                                </p>
                                <p>
                                    w) <strong>“EL CLIENTE”</strong> debe mostrar al <strong>“EL CIDAM, A.C.”</strong>
                                    las bitácoras de registros,
                                    completas y sin tachaduras o
                                    enmendaduras. Permitir el acceso del
                                    Organismo de Certificación para revisiones
                                    no programadas
                                </p>
                            </td>
                        </tr>
                    </tbody>

                </table>
                <br>

            </div>
        </div>
    </div>

    {{-- seccion 6/11 --}}

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="small-column">
                                <p>x) Pagar la cuota vigente por los
                                    servicios del “CIDAM, A.C.”, en alguna de
                                    las cuentas 1190246090 Clabe:
                                    072470011902460900, Banco Banorte o
                                    cuenta 187127416 Clabe:
                                    062470001871274166 Banco Afirme,
                                    mediante la factura emitida previamente,
                                    siendo estas últimas susceptibles a cambio
                                    según lo disponga “EL CIDAM, A.C.”.
                                    Acepta que la falta de cumplimiento de las
                                    obligaciones de pago traerá como
                                    consecuencia la suspensión del servicio.
                                </p> <br>
                                <p>
                                    <strong>CUARTA.</strong> OBLIGACIONES DE <strong>“EL CIDAM”</strong>.
                                </p> <br>
                                <p>
                                    a) Mantener vigente la acreditación
                                    del Organismo de Certificación ante la
                                    EMA, A.C.
                                </p>
                                <p>b) Cubrir los costos que permitan
                                    mantener vigente la acreditación del
                                    Organismo de Certificación con la EMA,
                                    A.C.
                                </p>
                                <p>c) <strong>“EL CIDAM, A.C.”</strong> se compromete a
                                    guardar la confidencialidad, con la
                                    confianza de que sus datos no serán
                                    divulgados. En caso contrario <strong>“EL CLIENTE”</strong>
                                    podrá ejercer sus derechos legales.
                                </p>
                                <p>
                                    d) <strong>“EL CIDAM, A.C.”</strong> se compromete a
                                    actuar en todo momento bajo un marco
                                    de imparcialidad, respeto, armonía, verdad
                                    y honestidad con <strong>“EL CLIENTE”</strong>, siempre
                                    apegados a los manuales y procedimientos
                                    establecidos.
                                </p>
                                <p>
                                    e) Informar oportunamente sobre
                                    algún cambio en lo relativo a los servicios
                                </p>
                            </td>
                            <td>
                                <p>
                                    del <strong>“EL CIDAM, A.C.”</strong>, así como a recibir y
                                    resolver quejas y apelaciones.
                                </p>
                                <p>
                                    f) <strong>“EL CIDAM, A.C.”</strong> se obliga a que la
                                    información acerca de las actividades de
                                    certificación del producto mediante la
                                    NOM-070-SCFI-2016, Bebidas
                                    alcohólicas-Mezcal-Especificaciones. no
                                    será revelada a una tercera parte, sin el
                                    consentimiento por escrito del <strong>“CLIENTE”</strong>, a
                                    excepción de que por Ley se requiera que
                                    la información sea revelada a una tercera
                                    parte, casos en los que <strong>“EL CLIENTE”</strong> deberá
                                    ser notificado de la información
                                    proporcionada, como lo permita la Ley.
                                </p>
                                <p>
                                    g) Las situaciones por las cuales <strong>“EL CIDAM, A.C.”</strong> notificará a las
                                    autoridades
                                    competentes tales como la DGN, ema,
                                    COFECE, COFEPRIS y Tribunales en relación
                                    a su competencia, se dará cuando se
                                    tengan incumplimientos o no
                                    conformidades a la evaluación de la
                                    conformidad. Así mismo se notificará al
                                    Servicio de Administración Tributaria (SAT)
                                    con fines aduanales los certificados de
                                    exportación vigentes y cancelados, así
                                    como la descripción de los productos
                                    amparados por los mismos.
                                </p>
                                <p>
                                    h) <strong>“EL CIDAM, A.C.”</strong> entregará al
                                    <strong>“CLIENTE”</strong> los resultados de evaluación de
                                    la conformidad NOM-070-SCFI-2016,
                                    Bebidas
                                <p></p>
                                alcohólicas-Mezcal-especificaciones, tanto
                                el resultado informado como su
                                incertidumbre expandida según lo
                                indicado en su catálogo de servicios.
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    {{-- seccion 7/11 --}}
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>

                            <td class=" width: 51%;">
                                <p>i) <strong>“EL CIDAM, A.C.”</strong> se compromete a
                                    dar cabal cumplimiento al Código de Ética
                                    vigente.
                                </p>
                                <p>
                                    j) <strong>“EL CIDAM, A.C.”</strong> se obliga a que el
                                    personal, Director Ejecutivo y entidades
                                    que operan bajo el control organizacional
                                    del “OC”, se comprometen a no incurrir en
                                    cualquier actividad no permitida, que se
                                    especifica en la política para evitar
                                    intervenir en actividades que puedan
                                    disminuir la confianza que especifica que el
                                    OC no deberá ofrecer ni suministrar
                                    consultoría de sistemas de gestión ni
                                    auditoría interna a sus clientes, cuando el
                                    esquema de certificación exige la
                                    evaluación del sistema de gestión del
                                    cliente.
                                </p>
                                <p>
                                    k) <strong>“EL CIDAM, A.C.”</strong> se obliga a no
                                    proporciona servicios de consultoría en
                                    certificaciones dentro del alcance de
                                    acreditación. Se encuentra prohibido para
                                    el personal de <strong>“EL CIDAM”</strong> establecer o
                                    dejar implícito que la certificación sería más
                                    sencilla, más fácil, más rápida o menos
                                    costosa si se utilizara una organización de
                                    consultoría determinada. En los casos en los
                                    que el personal hubiera proporcionado
                                    consultoría, se evitará que este personal
                                    participe en actividades relacionadas
                                    directamente con la decisión de
                                    certificación.
                                </p>
                                <p><strong>QUINTA.</strong> DERECHOS DE <strong>“EL CIDAM”</strong> .
                                    Recibir el importe mediante transferencia
                                    bancaria y/o cheque a cualquiera de las
                                    cuentas del <strong>“CIDAM, A.C.”</strong> 1190246090
                                </p>
                            </td>

                            <td>
                                <p>
                                    Clabe: 072470011902460900, Banco Banorte
                                    o cuenta 187127416 Clabe:
                                    062470001871274166 Banco Afirme,
                                    mediante la factura emitida previamente,
                                    podrán aceptase pagos en su totalidad o
                                    bien el 50% de costo vigente de los servicios
                                    de la certificación para iniciar con el
                                    servicio y para finalizar el servicio se
                                    solicitará el 50% restante.
                                </p>
                                <p>
                                    <strong>SEXTA.</strong> VIGENCIA. El presente contrato
                                    estará vigente a partir del día {{ $fecha_vigencia }} y será por tiempo indefinido,
                                    hasta
                                    que el cliente deje de cumplir con los
                                    requisitos de la certificación.
                                </p>
                                <p>
                                    <strong>SEPTIMA</strong>. RESCISIÓN. <strong>“LAS PARTES”</strong> podrán
                                    rescindir el presente contrato por
                                    incumpliendo de una de <strong>“LAS PARTES”</strong> en
                                    alguna de sus cláusulas, o por común
                                    acuerdo siempre y cuando se haga la
                                    solicitud con 30 días naturales de
                                    anticipación, en casos de incumplimiento
                                    con los requisitos de certificación el plazo
                                    de rescisión del presente contrato será de 3
                                    días hábiles
                                </p>
                                <p>
                                    <strong>OCTAVA.</strong> JURISDICCIÓN. Para todo lo
                                    relativo a la interpretación, cumplimiento y
                                    ejecución del presente contrato, las partes
                                    convienen en sujetarse a la jurisdicción de
                                    los juzgados y Tribunales competentes de la
                                    Ciudad de México, renunciando
                                    expresamente a la competencia que les
                                    corresponda por razón de su domicilio
                                    presente o futuro o por cualquier otra
                                    causa.

                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>




    {{-- seccion 8/11 --}}

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="small-column">
                                <p>Las partes firman el presente contrato por
                                    duplicado, en la ciudad de Morelia,
                                    Michoacán; el {{ $fecha_vigencia }}.
                                </p> <br><br>
                                <p style="text-align: center; font-size: 10;"><strong>POR “EL CLIENTE”</strong></p>
                                <br><br><br><br>
                                <p style="text-align: center; font-size: 10;">
                                    <strong>{{ mb_strtoupper($datos[0]->representante) }}</strong>
                                </p>
                                <p style="text-align: center; font-size: 10;">Representante Legal</p>
                            </td>
                            <td>
                                <br><br><br><br><br><br>
                                <p style="text-align: center; font-size: 10;"><strong>POR “EL CIDAM”</strong></p>
                                <br><br><br>
                                <img height="60px"
                                    src="{{ storage_path('app/public/firmas/firma_mtra_sylvana.png') }}"
                                    alt="">
                                <p style="text-align: center; font-size: 10;"><strong>MTRA. SYLVANA FIGUEROA
                                        SILVA</strong></p>
                                <p style="text-align: center; font-size: 10;">Representante Legal</p>
                            </td>
                        </tr>
                    </tbody>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                </table>

            </div>
        </div>
    </div>
    <br>


    {{-- seccion 9/11  --}}

    <p style="text-align: center; font-size: 16px;">ANEXOS</p>
    <br>

    <div style="text-align: left; padding-left: 10px;">
        <b style="font-size: 13px;">PO-UGII-011 Política de venta de hologramas</b>
    </div>

    <div class="content">
        <div class="new-header">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
            <span class="header-text">
                PO-UGII-011 Política de venta de hologramas <br>
                Ed 0, 31/08/2022 <br>
            </span>
        </div>

        <table>
            <p></p>
            <p></p>
            <tr>
                <td colspan="2" style="text-align: center; padding: 10px; font-size: 10.5px;"><b>PO-UGII-011
                        Política de venta de hologramas</b></td>
            </tr>
            <tr>
                <td class="td-especifico">
                    <p>
                        La presente Política establece los términos y condiciones del uso, venta e Impresión de
                        hologramas a los clientes del Organismo de Certificación CIDAM.
                    </p>
                    <p>
                        Los hologramas que sean enviados son designados como generales y utilizables para uno o varios
                        lotes (de la misma marca), ya que estos hologramas no se encuentran activados, para la
                        activación de los mismos se deberá solicitar servicios de inspección de envasado e inspección de
                        producto terminado.
                    </p>
                    <p>
                        En caso de que la razón social cuente con 2 o más registros de marca se le asignará un folio
                        especifico a cada una, los hologramas destinados a una marca no se deberán usar en otra.
                    </p>
                    <p>
                        El pedido de hologramas se realizará de 3 a 5 días hábiles. Estando sujetos a tlempos de
                        paquetería.
                    </p>
                    <p>
                        Se deberá liquidar en su totalidad el precio de la cotización de los hologramas para que sea
                        liberado el paquete.
                    </p>
                    <p>
                        <strong style="font-size: 9px;">Stock de hologramas:</strong> Se podrá solicitar hologramas al
                        personal del Organismo Certificador o por medio de plataforma OC CIDAM, resguardo para mantener
                        en por el cliente, sólo Y únicamente cuando se cuente ya con un certificado de granel.
                    </p>
                    <p>
                        <strong style="font-size: 9px;">Motivos de retorno definitivo de hologramas:</strong> En el
                        caso de cancelación o suspensión de la certificación del cliente se deberá regresar en SU
                        totalidad los hologramas al Organismo de Certificación.
                    </p>
                    <p>
                        Para ser elegible para una devolución monetaria, los hologramas deben devolverse en perfecto
                        estado. El artículo no se debió usar y deben mantener la misma condición en la que se recibió.
                        De igual manera deben ser
                        devueltos a CIDAM en el embalaje en el que fueron enviados. En caso de que los
                    </p>
                </td>
                <td class="td-especifico">
                    <p>
                        hologramas hayan sido pegados, se tendrán que despegar e Igualmente ser regresados al Organismo
                        Certificador. Para términos Y condiciones de reembolso consulte la Política de venta de
                        servicios CIDAM PO-UGII-010, en su edición vigente.
                    </p>
                    <p>
                        Dichos hologramas se entregarán al Organismo de Certificación haciéndolos llegar de forma
                        personal O por paqueteria.
                    </p>
                    <p>
                        <strong style="font-size: 9px;">Reposiciones de hologramas:</strong> En el caso de que la
                        materia prima contenga mermas (comprobables) por error en la impresión se hará la reposición del
                        material con un follo nuevo, el follo a reponer se cancelará a través de la plataforma del OC
                        CIDAM. Quedando invalidado el código QR.. Una vez devueltos los hologramas haremos una revisión
                        y análisis sobre el producto para poder definir si es sujeto a cambio por fallas en nuestra
                        producción o si fue dañado o expuesto a un mal uso.
                    </p>
                    <p>
                        <strong style="font-size: 9px;">Envíos:</strong> Los envíos de hologramas podrán ser a
                        domicilio con la posibilidad también de enviarse a sucursales DHL. En el caso de que el envío
                        sea a sucursal, el cliente tlene la responsabilidad de recoger el paquete el cuál se encontrará
                        en resguardo por un plazo de 4 semanas, una vez transcurrido este tiempo se destruirá Y no sera
                        seleccionable para la reposición ni del material ni del pago realizado.
                    </p>
                    <p>
                        No nos hacemos responsables de daños al producto por parte de la paqueteria, el producto se
                        envía con un embalaje óptimo para realizar el traslado, cualquier manejo y traslado inadecuado
                        es responsabilidad de la paquetería que presta el servicio de envío. Nos reservamos el derecho
                        de actualizar, cambiar reemplazar cualquier parte de estos Términos de Servicio mediante la
                        publicación de actualizaciones y/o cambios en nuestro sitio web.
                    </p>
                </td>
            </tr>
        </table>

        <p style="text-align: center; margin-top: 0px; font-size: 7px;">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
            puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
        </p>
    </div>
    <br>
    <br>

    {{-- seccion 10/11  --}}
    <div class="containers">
        <p style="text-align: center; font-size: 12px;">ANEXOS</p>
        <br>
        <div style="text-align: left; padding: 5px;">
            <p>Carta de aceptación de términos y condiciones.</p>
        </div>
        <div style="text-align: right;">
            <p style="font-size: 10px;">F4.1-01-08 Edición 1</p>
            <p></p>
            <p style="font-size: 10px;">Entrada en vigor 15/02/2024</p>
        </div>
        <br><br>
        <p>
            Organismo Certificador del Centro de Innovación y
        </p>
        <p></p>
        <p>
            Desarrollo Agroalimentario de Michoacán A.C.
        </p>
        <p></p>
        <p>
            P R E S E N T E.
        </p>
        <p></p>
        <p class="texto">
            Por medio de la presente, yo el/la C. {{ $datos[0]->representante }} me permito notificar al OC CIDAM de la
            aceptación
            de los términos y condiciones que se describen en el contrato de prestación de servicios, así
            como también hago de su conocimiento el haber leído detenidamente los documentos
            señalados en dicho instrumento jurídico, con código I4.1-01-01 Instructivo para el uso de
            certificados y marcas y F4.1-01-02 Manual de identidad corporativa del OC CIDAM, que me
            fueron enviados por algún medio electrónico.
        </p>
        <p></p>
        <p class="texto">
            Además de lo anterior, me comprometo a realizar y mantener actualizados antes las instancias
            correspondientes los siguientes documentos:
        </p>
        <p>
        <ul class="custom-list">
            <li>
                <p> Constancia de Situación Fiscal emitida por el SAT.</p>
            </li>
            <li>
                <p> Inscripción al Padrón de Bebidas alcohólicas y/o Inscripción al padrón de exportadores, según
                    aplique.</p>
            </li>
            <li>
                <p> Opinión de cumplimiento al corriente, utilizando el formato 32D.</p>
            </li>
            <li>
                <p> Acta constitutiva actualizada, en caso de que hubiesen surgido cambios en sus representantes legales
                    o cambio en su denominación, se firmará de nueva cuenta un contrato de prestación de servicios.</p>
            </li>
            <li>
                <p> Contrato de arrendamiento, se deberá actualizar en caso de que ya no esté vigente.</p>
            </li>
            <li>
                <p> Domicilio de instalaciones actualizado, en caso de que haya surgido alguna modificación a éste.</p>
            </li>
        </ul>
        </p>
    </div>
    <br>
    <br><br><br>
    </div>
    <br>
    <br>

    {{-- seccion 11/11 --}}
    <div class="containers">

        <p class="texto">
            Asimismo, manifiesto que es mi responsabilidad el mantener actualizados cada uno de los
            trámites mencionados anteriormente, y que eximo de toda responsabilidad al Organismo
            Certificador del CIDAM (OC CIDAM), comprometiéndome a presentar cada uno de los
            documentos actualizados y acepto entregar toda la documentación requerida por el OC
            CIDAM, de no cumplir con dichos requisitos, acepto se tomen las medidas pertinentes
            referentes al proceso de certificación del producto, si no cumplo con ello.
        </p>
        <p></p>
        <p class="texto">
            Esta carta de aceptación de términos y condiciones entrara en vigor a partir de la fecha de
            firma de la misma, teniendo en cuenta que las fechas de vigencia serán las equivalentes tanto
            en el contrato como en el presente documento, a partir del día {{ $fecha_vigencia }} y será por tiempo
            indefinido, hasta que el cliente deje de cumplir con los requisitos de la certificación como se
            señala en el contrato.
        </p>
        <br><br><br>
        <p>
        </p>
        <p class="texto">
            Atentamente
        </p>
        <br><br><br><br>
        <p class="texto">
            {{ $datos[0]->representante }}
        </p><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>

    </div>
    <br>
</body>

</html>
