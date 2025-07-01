<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>R-UNIIC-005, Lista de Verificación NOM-051-SCFI_SSA1-2010 y MOD 27.03.2020 SOL-REV-005</title>
    <style>
        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 14px;
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
            width: 150px;
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
            font-size: 13px;
            margin-top: -45;
        }

        .img img {
            width: 100px;
            height: auto;
            display: block;
            margin-left: 20px;
            /* Centra la imagen horizontalmente */
        }

        p {
            margin: 0;
        }

        p+p {
            margin-top: 3px;
            /* Ajusta este valor según sea necesario */
        }

        .container {
/*             padding-left: 45px;
            padding-right: 45px; */
            padding-top: 100px;
            margin-left: 35px;
            margin-right: 35px;
            border: 2px solid black;
        }

        .titulo {
            padding-left: 150px;
            padding-right: 150px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        /* tabla1 */
        .mi-tabla {
            padding-left: 80px;
            padding-right: 80px;
            border-collapse: collapse;
            width: 100%;
        }

        /* .mi-tabla, */
        .mi-tabla td {
            border: 1.5px solid black;
        }

        .mi-tabla td {
            padding: 1px;
            text-align: center;
        }



        .N {
            font-weight: bold;
            font-size: 12px;
        }

        .table-largue {
            border-collapse: collapse;
            width: 100%;
        }

        /* .mi-tabla, */
        .table-largue td {
            border: 1.5px solid black;
        }

        .table-largue td {
            padding: 1px;
           text-align: center;
            /*             font-weight: bold;
            font-size: 13px; */
        }
        .green {
            background-color: #A8D08D;
        }

        .yellow {
            background-color: #F6FB63;
            font-weight: bold;
            font-size: 12px;
        }
        .gray {
            background-color: #E7E6E6;
        }
        .gray2{
            background-color: #ECECEC;
        }
        .fondo {
            background-color: #a7a7a7;
        }

        .yellow-2 {
            background-color: #FFE699;
        }
        .blue{
            background-color: #DEEAF6;
        }

        /* .mi-tabla, */

        .table-fin {
            border-collapse: collapse;
            width: 100%;
        }

        .table-fin td {
            border: 1.5px solid black;
        }

        .table-fin td {
            padding: 1px;
            text-align: center;
            /*             font-weight: bold;
            font-size: 13px; */
        }


        .table-fin img {
            max-width: 100px;
            /* Limita el ancho máximo de las imágenes dentro de la tabla */
            height: auto;
            display: block;
            /* Hace que la imagen esté en su propio bloque, separada del texto */
            margin: 0 auto;
            /* Centra la imagen y añade un pequeño margen inferior */
        }

        .inspector img,
        .director img {
            max-width: 80px;
            /* Tamaño específico para las firmas */
        }

        .imagen {
            text-align: center;
            margin-top: 10px;
        }

        .imagen img {
            max-width: 450px;
            /* Ajusta el tamaño máximo de la imagen */
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- cabecera --}}
        <div class="header">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
            <div class="header-text">
                <p style=" margin: 0;">Lista de Verificación NOM-051-SCFI/SSA1-2010 y MOD 27.03.2020 R-UNIIC005</p>
                <p style=" margin: 0;">Edición 0, 28/05/2024</p>
            </div>
            <div class="line"></div>
        </div>

        <p class="titulo">Lista de verificación de la NOM-051-SCFI/SSA1-2010 y MOD 27.03.2020</p>
        <br>
        <table class="mi-tabla">
            <tr>
                <td class="yellow" style="font-weight:normal;">Inspector asignado:</td>
                <td colspan="3">Andres Alejandro Vidales Aroche</td>
                <td class="green" style="width: 90px;">Fecha de revisión</td>
                <td>12/09/2024</td>d>
            </tr>
            <tr>
                <td class="yellow" style="font-weight:normal;">Producto:</td>
                <td colspan="3">Mix de Semillas con Miel</td>
                <td class="green">OSC</td>
                <td>no aplica</td>
            </tr>
            <tr>
                <td class="yellow" style="font-weight:normal;">Marca:</td>
                <td colspan="3">Sarayu Productos nutritivos(marca en tramite)</td>
                <td class="green">No. de servicio</td>
                <td>SOL-REV-005</td>
            </tr>
            <tr>
                <td>No. Revisión</td>
                <td colspan="3"></td>
                <td rowspan="2" class="green">Sólido / líquido</td>
                <td rowspan="2">Sólido</td>
            </tr>
            <tr style="border: none;">
                <td colspan="4" style="border: none;"></td>
            </tr>
            <tr style="border: none;">
                <td class="N" style="width: 35px;">C = CUMPLE</td>
                <td class="N" style="width: 40px;">NC = NO CUMPLE</td>
                <td class="N" style="width: 50px;">NA = NO APLICA</td>
                <td style="border: none;"></td>
                <td class="green">Bebida sin calorías</td>
                <td class="green">No</td>
            </tr>

        </table>
        <br>
        <table class="table-largue">
            <tr class="green">
                <td><b style="font-size: 12px;">No.</b></td>
                <td><b style="font-size: 12px;">Especificaciones</b></td>
                <td><b style="font-size: 12px;">C/NC/ NA</b></td>
                <td><b style="font-size: 12px;">Observaciones</b></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">1</b></td>
                <td colspan="3" class="yellow" style="text-align:center;">Generalidades</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">1</b> (4.2.10.1.4)</td>
                <td class="gray" style="text-align: left;">En caso de que el envase esté cubierto por una envoltura,
                    debe figurar en ésta toda la información aplicable, a menos
                    de que la etiqueta pueda leerse fácilmente a través de la
                    envoltura exterior.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">1.2</b> (4.2.10.1.1)</td>
                <td class="gray" style="text-align: left;">La etiqueta debe fijarse de manera tal que permanezcan
                    disponibles hasta el momento del consumo en condiciones
                    normales.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">1.3 </b>(4.1.11.1)</td>
                <td class="gray" style="text-align: left;">Los alimentos y bebidas no alcohólicas deben ostentar la
                    informacion obligatoria que se refiere a la NOM-051-
                    SCFI/SSA1-2010 en idioma español, sin prejuicio de que se
                    exprese en otros idiomas.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">1.4</b> (4.2.11.2)</td>
                <td class="gray" style="text-align: left;">La información o representación gráfica adicional en la
                    etiqueta que puede estar presente en otro idioma, no debe
                    sustituir, sino añadirse a los requisitos de etiquetado,
                    siempre y cuando dicha información resulte necesaria para
                    evitar que se induzca a error o engaño al consumidor</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- fin parte pagina 1 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">1.5</b> (4.2.10.1.3)</td>
                <td class="gray" style="text-align: left;">Los datos que aparecen en la etiqueta deben indicarse con
                    caracteres claros, visibles, indelebles y en colores
                    contrastantes, fáciles de leer por el consumidor en
                    circunstancias normales de compra y uso.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">1.6</b> (4.2.10.1.2)</td>
                <td class="gray">Cuando el alimento o bebida no alcohólica se presenta en
                    envase múltiple o colectivo, la información comercial
                    obligatoria no será necesaria que aparezca en la superficie
                    del producto individual. El lote y fecha de caducidad deben
                    aparecer en el producto individual.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">1.7</b> (4.2.10.1.2)</td>
                <td class="gray" style="text-align: left;">Se debe indicar la leyenda "No etiquetado para su venta
                    individual" o similar cuando los alimentos o bebidas no
                    alcohólicas no tengan la información obligatoria.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2</b></td>
                <td colspan="3" class="yellow" style="text-align:center;">Superficie Principal de Exhibición (SPE)</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.1</b> (4.2.10.1.5)</td>
                <td  style="text-align: left;">Debe aparecer en la SPE del producto cuando menos la
                    marca, la declaración de cantidad y la denominación del
                    alimento o bebida no alcohólica.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.2</b> (4.2.10.1.5)</td>
                <td style="text-align: left;">El cálculo de la superficie principal de exhibición coincide con
                    lo indicado en el punto <b style="font-size: 12px;">4.3</b> de la NOM-030-SCFI-2006. (Ver hoja
                    cálculo SPE)
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.3</b> (4.2.8.3.1)</td>
                <td  style="text-align: left;">Las unidades de medida son acordes a lo establecido en la
                    NOM-008-SCFI-2002. Masa: <b style="font-size: 12px;">kg, g.</b> Volumen: <b style="font-size: 12px;">L,l, mL, ml.</b></td>
                <td class="yellow-2"><b style="font-size:12px;">NC</b></td>
                <td class="yellow-2">los gramos se representan con
                    la letra g (separada del dato
                    cuantitativo) y sin punto</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.4</b></td>
                <td  style="text-align: left;">El dato cuantitativo y la unidad declarado en el contenido
                    neto corresponden a las caracteristícas del mismo (si es un:
                    líquido = L, l, mL, ml; Sólido =kg, g).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.5</b></td>
                <td style="text-align: left;">El dato cuantitativo y la unidad se ubican en la SPE y se
                    encuentra libre de cualquier información que pueda
                    impedir su lectura.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.6</b></td>
                <td style="text-align: left;">El dato cuantitativo y la unidad debe tener como mínimo el
                    tamaño con base a la SPE (ver tabla 1 NOM-030-SCFI-2006)
                </td>
                <td class="yellow-2"  style="font-size: 12px;"><b>NC</b></td>
                <td class="yellow-2">el dato cuantitativo debe
                    medir al menos 3 mm de
                    altura
                </td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.7</b></td>
                <td style="text-align: left;">La leyenda de contenido se expresa: <b style="font-size: 12px;">CONTENIDO,
                    CONTENIDO NETO, CONT., CONT. NET. y CONT. NETO.</b>
                    Pueden ser escritas con letra mayúsculas y/o minúsculas
                    acompañando al dato cuantitativo y la unidad. </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.8</b></td>
                <td style="text-align: left;">La leyenda <b>"Masa Drenada</b> o <b>Masa drenada"</b> debe ir junto a
                    la declaración de contenido neto, solo cuando aplique.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- pagina 3 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">2.9</b> (4.2.1.1)</td>
                <td style="text-align: left;">El nombre o denominación del producto debe corresponder
                    con la establecida en los ordenamientos juridicos; en
                    ausencia de éstos, indicar el nombre de uso común, o bien,
                    emplear una descripción acorde a las características básica
                    de la composición y naturaleza del alimento o bebida.</td>
                <td class="yellow-2" style="font-size: 12px;"><b>NC</b></td>
                <td class="yellow-2">La denominacion deberia ser
                    "Barra de Amaranto con
                    Cacahuate, Semilla de
                    Calabaza, Pasas, Almendra,
                    Nuez, Miel y Panela"</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.10</b></td>
                <td style="text-align: left;">La denominación del producto tiene un tamaño igual o
                    mayor al del dato cuantitativo del contenido neto conforme
                    a la NOM-030-SCFI-2006.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.11</b> (4.2.1.1-M)</td>
                <td style="text-align: left;">La denominación del producto se encuentra en negrillas
                    dentro de la SPE.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.12</b> (4.2.1.1-M)</td>
                <td style="text-align: left;">La denominación del prodcuto se encuentra en linea
                    paralela a la base .</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.13</b> (4.1.1)</td>
                <td style="text-align: left;">La información contenida en la etiqueta debe ser veraz,
                    clara y no confunde al consumidor sobre su naturaleza y
                    caracteristicas</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.14</b> (4.1.2)</td>
                <td style="text-align: left;">La etiqueta describe o emplea palabras o ilustraciones que
                    hacen referencia al producto. Pueden incorporar
                    descripción gráfica o descriptiva de la sugerencia de uso,
                    empleo o preparación</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.15</b></td>
                <td style="text-align: left;">No deben describirse ni presentarse palabras, textos,
                    ilustraciones, imagenes o denominaciones de origen que
                    confundan al consumidor con otro producto.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.16</b></td>
                <td style="text-align: left;">El nombre de uso común o descripción del producto no
                    engaña al consumidor. Si tuvo algún tratamiento, puede
                    indicarse el nombre de éste, a excepción de los que sean de
                    carácter obligatorio.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.17</b> (4.2.1.1-M)</td>
                <td style="text-align: left;">Para productos<b> IMITACION,</b>  la leyenda debe aparacer en la
                    parte superior izquierda, en negrillas, en mayúsculas con
                    fondo claro y con tamaño al doble del resto de la
                    denominación.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.18</b> (4.2.1.1-M)</td>
                <td style="text-align: left;">No se permite el uso de la palabra imitación a productos
                    que cuenten con denominación de origen o indicación
                    geográfica protegida o reconocida por el Estado mexicano.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">2.19</b> (4.2.1.1.2)</td>
                <td style="text-align: left;">Los productos imitación no deben hacer uso de las palabras
                    "tipo", "estilo" o algún otro término similar, en la
                    denominación del producto o dentro de la etiqueta.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3</b></td>
                <td colspan="3" class="yellow" style="text-align:center;">LISTA DE INGREDIENTES</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.1</b> (4.2.2.1)</td>
                <td style="text-align: left;">En productos cuya comercialización se haga de forma
                    individual debe contener lista de ingredientes. A excepción
                    cuando se trate de productos de un solo ingrediente.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- pagina 4 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">3.2</b> (4.2.2.1.1)</td>
                <td style="text-align: left;">La lista de ingredientes debe ir encabezada o precedida por
                    el término "ingrediente".</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.3</b> (4.2.2.1.2)</td>
                <td  style="text-align: left;">Los ingredientes deben enumerarse por orden cuantitativo
                    decreciente (m/m).
                </td>
                <td class="N">C</td>
                <td>Confirmar con el cliente que se
                    encuentran enlistados en
                    orden decreciente</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.4</b> (4.2.2.1.3)</td>
                <td  style="text-align: left;">Se debe declarar un ingrediente compuesto cuando
                    constituya más del 5% del alimento o bebida no alcohólica.
                    Por ejemplo leche condensada utilizada para hacer un
                    alimento o bebida no alcohólica).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.5</b> (4.2.2.1.4)</td>
                <td>El ingrediente compuesto debe ir acompañado de sus
                    ingredientes constitutivos entre paréntesis.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.6</b> (4.2.2.1.3)</td>
                <td  style="text-align: left;">Los ingredientes compuestos declaran sus ingredientes
                    constitutivos en orden decreciente (m/m) incluyendo los
                    aditivos que desempeñen una función tecnológica en el
                    producto o que se asocien a reacciones alérgicas.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.7</b> (4.2.2.1.4)</td>
                <td  style="text-align: left;">Se indica en la lista de ingredientes el agua añadida por
                    orden de predominio, excepto cuando forme parte de un
                    ingrediente compuesto. Por ejemplo: Salmuera, jarabe o
                    caldo, la utilizada en procesos de cocción y reconstitución.
                    No es necesario declarar el agua u otros ingredientes
                    volátiles que se evaporan durante la fabricación.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.8</b> (4.2.2.1.5)</td>
                <td  style="text-align: left;">Los productos deshidratados o condensados, destinados a
                    ser reconstituidos, pueden enumerar sus ingredientes por
                    orden cuantitativo decreciente (m/m) en el producto
                    reconstituido, Siempre que se incluya las indicaciones de
                    preparación.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.9</b> (4.2.2.1.6)</td>
                <td style="text-align: left;">En la lista de ingredientes debe emplearse una
                    denominación específica, con excepción de los ingredientes
                    con denominación genérica señalados en la <b>tabla 1</b> de la
                    NOM-051-SCFI/SSA1-2010.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.10</b> (4.2.2.1.7)</td>
                <td style="text-align: left;">La manteca de cerdo, la grasa de bovino o sebo deben
                    declararse por sus denominaciones específicas.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.11</b> (4.2.2.1.8-M)</td>
                <td style="text-align: left;">a) Los azúcares añadidos se deben declarar agrupados
                    anteponiendo las palabras "azúcares añadidos" seguido de
                    la lista entre paréntesis con sus denominaciones especificas
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.12</b> (4.2.2.1.9)</td>
                <td style="text-align: left;">b) Los azúcares añadidos se declaran en orden cuantitativo
                    decreciente m/m.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- pagina 5 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">3.13</b> (4.2.2.1.8-M)</td>
                <td style="text-align: left;">Ingredientes compuestos en los que formen parte varios
                    azúcares añadidos, éstos tambien deben declararse
                    conforme lo establecido en los incisos a) y b)</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.14</b> (4.2.2.2.1 )</td>
                <td class="blue" style="text-align: left;">Los aditivos empleados en un alimento o bebida no
                    alcohólica que se transfiera en cantidad notable o suficiente
                    para desempeñar en él una función tecnológica debe ser
                    incluido en la lista de ingredientes. <i>Un aditivo es aquella
                    sustancia que normalmente no se consume como alimento
                    ni tampoco se utiliza como ingrediente básico, puede o no
                    tener valor nutritivo y solo se adiciona en cualquier etapa del
                    proceso de producción con fines tecnológicos, por ejemplo:
                    glutamato monosódico</i></td>
                <td class="N">C</td>
                <td>Confirmar que no añade
                    ningun tipo de aditivo?</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.15</b> (4.2.2.2.3 )</td>
                <td class="blue" style="text-align: left;">Se deben declarar todos aquellos ingredientes o aditivos
                    que causan hipersensibilidad, intolerancia o alergia (ver
                    4.2.2.2.3 NOM-051-SCFI/SSA1-2010) deben declararse.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.16</b> (4.2.2.2.3-M)</td>
                <td  style="text-align: left;" class="blue">Cuando el alimentos, ingrediente o derivado sea o contenga
                    algún causante de hipersensibilidad deben declararse al final
                    de la lista de ingredientes anteponiendo la palabra
                    <b style="font-size: 12px;">"CONTIENE".</b>
                </td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">Debe indicar al final de la lista
                    de ingredientes que contiene
                    Cacahuate, Almendra y Nuez
                    en negritas</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.17</b> (4.2.2.2.3-M)</td>
                <td class="blue" style="text-align: left;">Alimentos, ingredientes o derivados sea o contenga algún
                    causante de hipersensibilidad se declara en negrillas de
                    igual o mayor tamaño a las letras de los ingredientes
                    generales.</td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">Debe indicar en la lista de
                    ingredientes El Cacahuate,
                    Almendra y Nuez en negritas</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.18</b> (4.2.2.2.3-M)</td>
                <td class="blue" style="text-align: left;">Si el alimento pudo ser contaminado con ingredientes que
                    causan hipersensibilidad o con trazas de estos durante su
                    producción o elaboración hasta el envasado, debe declararse
                    al final de la lista de ingredientes con la precedidos de la
                    leyenda <b style="font-size: 12px;">"PUEDE CONTENER"</b> en negrillas.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.19</b> (4.2.2.2.3-M)</td>
                <td class="blue" style="text-align: left;">Si el ingrediente es un derivado que contiene albúmina,
                    caseína o gluten puede rotularse declarando su origen. Por
                    ejemplo: contiene caseína (leche) o caseína de leche</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.2</b> (4.2.2.2.4)</td>
                <td class="blue" style="text-align: left;">Los aditivos deben declararse con su nombre común. Las
                    enzimas y saborizantes, saboreador o aromatizantes podran
                    ser declarados genericamente. Los saborizantes,
                    saboreadores o aromatizantes podrán estar calificados con
                    términos "naturales", "idénticos a los naturales",
                    "artificiales".</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- pagina 6 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">3.21</b> (4.2.2.3.1)</td>
                <td class="gray2" style="text-align: left;">En todo alimento o bebida no alcoholica preenvasada que
                    se venda como mezcla o combinacion, se declara el
                    porcentaje del ingrediente, ya sea al peso o volumen según
                    corresponda al momento de la elaboración del alimento,
                    cuando:
                   <p> a) El porcentaje del ingrediente se enfatiza en la etiqueta
                    por medio de palabras o imágenes o gráficos.</p>
                    <p>b) El ingrediente no se menciona en el nombre o
                    denominacion del alimento o bebida no alcoholica y es
                    esencial para caracterizar al mismo, ya que los
                    consumidores asumen la presencia de este ingrediente en el
                    producto.</p>
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.22</b> (4.2.2.3.2)</td>
                <td class="gray2" style="text-align: left;">El porcentaje del ingrediente se declara en la etiqueta cerca
                    de las palabras o imágenes o gráficos que enfatizan el
                    ingrediente particular, o al lado del nombre común o
                    denominación del alimento o bebida no alcohólica, o
                    adyacente al ingrediente que corresponda en la lista de
                    ingredientes.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">3.23</b></td>
                <td class="gray2" style="text-align: left;">Si el alimento perdió humedad luego de un tratamiento
                    térmico u otro, el porcentaje corresponderá a la cantidad
                    del ingrediente o ingredientes usados, cuando se tiene el
                    producto terminado.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"></td>
                <td colspan="3"><b style="font-size: 12px;">Nota:</b> <span style="font-size: 12px;">no se requiere la declaración del porcentaje del ingrediente
                    cuando es utilizado en pequeñas cantidades
                    con el propósito de impartir sabor y/o aroma. La referencia en el nombre del alimento, el
                    ingrediente no
                    requiere de una declaración cuantitativa si es que la referencia del ingrediente no conduce a un
                    error o
                    engaño o crea una impresión erronea en el consumidor, respecto de su naturaleza ya que la cantidad
                    del
                    ingrediente no es necesaria para caracterizar al producto o distinguirlo de similares.</span></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">4</b></td>
                <td class="yellow" colspan="3" style="text-align:center;"><b>Nombre, denominación o razón social y domicilio fiscal</b>
                </td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">4.1 </b>(4.2.4.1)</td>
                <td style="text-align: left;">Se indica el nombre, denominación o razón social y
                    domicilio fiscal del responsable del producto (calle, número,
                    código postal y entidad federativa en que se encuentre.</td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">Debe indicarl el nombre del
                    Estado y el Codigo Postal debe
                    indicarse con puntos eb ambas
                    letras C.P.</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">4.2</b> (4.2.4.2)</td>
                <td style="text-align: left;">Productos importados. Nombre, razón social y domicilio del
                    responsable del producto, en ambos casos, puede incluirse
                    la expresión "fabricado o envasado por o para", seguido por
                    el nombre y domicilio.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- pagina 7 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">4.3 </b>(4.2.5.1)</td>
                <td style="text-align: left;">Los alimentos y bebidas no alcohólicas nacionales o de
                    procedencia extranjera deben incorporar la leyenda que
                    identifique al país de origen del producto. Por ejemplo:
                    "Hecho en...","Producto de...".,"Fabricado en...", u otras
                    análogas, seguida del país de origen. Se permite el uso de
                    gentilicios siempre y cuando no induzcan a error en cuanto
                    al origen del producto. Por ejemplo: "Producto español",
                    "Producto estadounidense", etc. </td>
                <td class="N">C</td>
                <td>Comprobar que cuenta con los
                    permisos para usar el
                    emblema "Hecho en México"
                    de lo contrario se debe retirar
                    el logo y sustituirlo porla
                    leyenda "Hecho en México"</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">5</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Identificación del lote</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">5.1</b> (4.2.6.1)</td>
                <td style="text-align: left;">Cada envase debe llevar grabada o marcada la identificación
                    del lote al que pertenece, con una indicación en clave que
                    permita su rastreabilidad.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">5.2</b> (4.2.6.2)</td>
                <td style="text-align: left;">La identificación del lote debe marcarse en forma indeleble
                    y permanente evitando que pueda ser alterada u ocultada
                    hasta que sea adquirido por el consumidor. (puede estar
                    colocada en cualquier parte del envase).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">5.3</b> (4.2.6.3)
                </td>
                <td style="text-align: left;">La clave del lote es precedida por cualquiera de las
                    siguientes indicaciones: LOTE, Lot, L, Lote, lote, lot, l, lt, LT,
                    LOT. o bien, incluir una referencia al lugar donde aparece.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6</b></td>
                <td class="yellow" colspan="3" style="text-align:center;"><b>Fecha de caducidad o consumo preferente</b>
                </td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.1</b></td>
                <td style="text-align: left;">Se declara en la etiqueta o en el envase.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.2</b> (4.2.7.1 - i)</td>
                <td style="text-align: left;">Cuenta con el día y el mes para productos de duración
                    máxima a tres meses.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.3</b> (4.2.7.1 - i)</td>
                <td style="text-align: left;">Cuenta con el mes y el año para productos de duración
                    superior a tres meses</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.4</b> (4.2.7.1 - ii)</td>
                <td style="text-align: left;">La fecha esta precedida por una leyenda "consumo
                    preferente" si es menor a tres meses, "fecha de caducidad"
                    si es mayor a tres meses., o bien, una referencia al lugar
                    donde aparece la fecha. (puede estar colocada en cualquier
                    parte del envase).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.5</b> (4.2.7.1 - ii)</td>
                <td style="text-align: left;">Para fecha de caducidad debe utilizarse: "Fecha de
                    caducidad___", "Caducidad___","Fech Cad___", CAD, Cad,
                    cad, Fecha de expiración, Expira, Exp, EXP, exp, Fecha de
                    vencimiento, Vencimiento.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.6</b> (4.2.7.1 - ii)</td>
                <td style="text-align: left;">Para consumo preferente debe indicarse alguna de las
                    siguientes: "Consumir preferentemente antes del__","Cons.
                    Pref. antes del__". y "Cons Pref".</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- pagina 8 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">7</b> (4.2.7.1 - iii)</td>
                <td style="text-align: left;">Para productos importados, si el codificado de la fecha de
                    caducidad o consumo preferente no corresponde al
                    formato, éste podrá ajustarse a efecto de cumplir con la
                    formalidad establecida, o en su caso, el envase debe
                    contener la interpretación de la fecha señalada. En ninguno
                    de estos casos los ajustes serán considerado como
                    alteración.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.8</b> (4.2.7.2)</td>
                <td style="text-align: left;">Al declarar fecha de caducidad o consumo preferente, debe
                    indicarse en la etiqueta cualquier condición especial que se
                    requiera para conservación del alimento o bebida no
                    alcohólica. En caso de que su cumplimiento depende la
                    validez de la fecha. Por ejemplo: "mantenganse en
                    refrigeración".</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.9</b> (4.2.7.3) </td>
                <td style="text-align: left;">La fecha de caducidad o consumo preferente debe
                    incorporarse de tal forma que se evite su alteración. </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">6.1</b> (4.2.7.4) </td>
                <td style="text-align: left;">No se requerirá la declaración de fecha de caducidad o
                    consumo preferente, para: vinagre, sal de calidad
                    alimentaria, azúcar sólido, productos de confitería
                    consistentes en azúcar aromatizados y/o coloreados, y
                    gomas de mascar.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">7</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Productos preenvasados con Norma Oficial Mexicana
                </td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">7.1</b></td>
                <td style="text-align: left;">Los productos preenvasados deben exhibir su contraseña
                    oficial cuando asi lo determine su Norma Oficial Mexicana
                    que regula su denominación o la Ley Federal sobre
                    Metrología y Normalización. (ver NOM-106-SCFI-2017)</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">7.2</b></td>
                <td style="text-align: left;">Los productos que se encuentran en empaque múltiple o
                    colectivo y requieren de una contraseña oficial, se indica
                    únicamente en el empaque múltiple o colectivo.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">7.3</b></td>
                <td style="text-align: left;">Los productos que ostenten la contraseña oficial, deben
                    incluir debajo de esta o del lado derecho de la misma, los
                    tres dígitos correspondientes a la clave o código de la NOM
                    específica para la denominación de producto, con la misma
                    proporcionalidad y tipografía. </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">8</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Instrucciones para el uso</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">8.1</b> (4.3-M)</td>
                <td style="text-align: left;">La etiqueta debe contener instrucciones de uso cuando
                    sean necesarias sobre el modo de empleo para asegurar el
                    correcto uso del producto preenvasado.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Información nutrimental
                </td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.1 </b>(4.2.8.1)</td>
                <td style="text-align: left;">La declaración nutrimental es obligatoria</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{--  pagina 9 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">9.2</b></td>
                <td style="text-align: left;">Los valores de bromatologicos que figuran en la declaración
                    nutrimental deben ser valores medios ponderados
                    derivados por análisis, bases de datos o tablas reconocidas
                    internacionalmente.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.3</b> (4.2.8.2.1)</td>
                <td style="text-align: left;">Es obligatorio declarar:
                    <p>a) Contenido energético;</p>
                    <p>b) La cantidad de proteínas;</p>
                   <p>c) La cantidad de hidratos de carbono disponibles, indicando la cantidad correspondiente a azúcares;</p>
                   <p>d) La cantidad de grasas o lípidos, especificando la cantidad que corresponda a grasa saturada;</p>
                   <p>e) La cantidad de fibra dietética;</p>
                   <p>f) La cantidad de sodio;</p>
                  <p>g) La cantidad de cualquier otro nutrimento acerca del cual se haga una declaración de propiedades;</p>
                   <p>h) La cantidad de cualquier otro nutrimento que se
                    considere importante, regulado por los ordenamientos
                    jurídicos aplicables.</p>
                </td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">Debe indicar la cantidad
                    correspondiente a azúcares</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.4</b> (4.2.8.2.4)</td>
                <td  style="text-align: left;">Quedan excentos de incluir información nutrimental los
                    siguietes productos siempre y cuando no incluyan alguna
                    declaración de propiedades:
                    <p>I. Productos que incluyan un solo ingrediente</p>
                    <p>II. Hierbas, especias, o mezclas de ellas, III.
                    Extractos de café, granos de café enteros o molidos
                    descafeínados o no, IV.
                    Infusiones de hierbas, té descafeinado o no, instantáneo y/o
                    soluble que no contenga ingredientes añadidos,</p>
                    <p>V. Vinagres fermentados y secedáneos VI.
                    Aguas purificadas embotelladas, aguas minerales naturales.</p>
                    <p>VII. Los productos con una superficie inferior a 78 cm2,
                    siempre y cuando se incluya un número telefónico o página
                    web donde el consumidor puede obtener la información
                    sobre la declaración nutrimental.</p>
                </td>
                <td class="N">C</td>
                <td></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.5</b></td>
                <td style="text-align: left;">La inclusión de uno de los siguientes no obliga a incluir a los
                    otros: Almidones (g), polialcoholes (g), polidextrosas (g).
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.6</b></td>
                <td style="text-align: left;">Todos o ninguno de los siguientes: Grasa poliinsaturada (g),
                    monoinsaturasa (g), colesterol (mg).
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.7 </b>(4.2.8.3.1)</td>
                <td style="text-align: left;">La declaración nutrimental debe presentarse en unidades
                    correspondientes al Sistema General de Unidades de
                    Medida (ver NOM-008-SCFI-2002). Para la fibra dietética,
                    vitaminas y nutrimentos inorgánicos (minerales) deben
                    estar sujetos a los establecido en el inciso 4.2.8.3.5 de la
                    NOM-051-SCFI/SSA1-2010.</td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">las k cal se indican sin espacio</td>
            </tr>
            {{-- pagina 10 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">9.8 </b>(4.2.8.3.2)</td>
                <td style="text-align: left;">La declaración del contenido energético debe expresarse en
                    kcal por 100 g, o por 100 ml, así como por el contenido
                    total del envase. Adicionalmente se puede declarar por
                    porción.
                </td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">1.- Las "k cal" se deben indicar
                    sin espacio
                    2.- Los "KJ" se deben indicar
                    con la "k" minúscula y la "J"
                    mayúscula "kJ"
                    3.- Los gramos se deben
                    indicar con la letra "g" sin
                    punto
                    4.- La gasa trans se debe
                    indicar en "mg"
                </td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.9 </b>(4.2.8.3.3)</td>
                <td style="text-align: left;">La declaración de la cantidad de proteínas, hidratos de
                    carbono disponibles, de grasas, de fibra dietética y de sodio
                    contenidas en el alimento o bebida no alcohólica debe
                    expresarse en unidades de medida por 100 g o por 100 ml.
                    Puede declararse por porción cuando el envase contiene
                    varías porcines, o por envase cuando éste contiene sólo una
                    porción.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.10 </b>(4.2.8.3.4)</td>
                <td style="text-align: left;">La declaración numérica sobre fibra dietética, vitaminas y
                    nutrimetnos inorgánicos (minerales) debe expresarse en
                    unidades de medida por 100 g o por 100 ml o en porcentaje
                    de los valores nutrimentales de referencia por porción.
                    Puede declararse por porción en envases que contengan
                    varias porciones, o por envase cuando éste contiene sólo una
                    porción. (ver 4.5.2.4.5 de la Modificación de la NOM-051).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.11</b></td>
                <td style="text-align: left;">En productos destinados a ser reconstituidos o que
                    requieran preparación antes de ser consumidos, la
                    declaración nutrimental debe realizarse de acuerdo con las
                    instrucciones para el uso indicadas en la etiqueta.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.12</b></td>
                <td style="text-align: left;">La declaración nutrimental puede expresarse como se
                    establece en la tabla 3 (NOM-051-SCFI/SSA1-2010) o en
                    cualquier otro formato que contenga la información
                    requerida conforme lo indicado en la tabla 3.
                </td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">Debe indicar la cantidad
                    correspondiente a azúcares</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.13</b></td>
                <td style="text-align: left;">La información impresa en la declaración nutrimental se
                    presenta en un tamaño de fuente de cuando menos 1.5 mm
                    de altura.
                </td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">la tipografia debe medir al
                    menos 1.5 mm de altura</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.14</b></td>
                <td style="text-align: left;">La información impresa en la declaración nutrimental se
                    destaca en negrillas la declaración y la cantidad de
                    contenido energético, la cantidad de grasa saturada, la
                    cantidad de azúcares añadidos, la cantidad de grasas trans y
                    la cantidad de sodio.</td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">Debe indicar el Sodio en
                    negrillas
                </td>
            </tr>
            {{-- pagina 11 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">9.15</b></td>
                <td style="text-align: left;">La declaración nutrimental debe mostrarse, al menos, en un
                    tamaño de fuente de 1 mm de altura en los siguientes
                    casos:
                    a) Productos cuya SPE sea igual o inferior a 32 cm2
                    b) Productos obligados a declarar más de 20 nutrimentos, y
                    su SPE sea igual o inferior a 161 cm2, y
                    c) En envases retornables en los que la información se
                    encuentra en la corcholata o taparrosca.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.16</b></td>
                <td style="text-align: left;">Para cumplir con el contenido declarado de vitaminas y
                    minerales al final de la vida útil, se acepta una cantidad
                    superior a lo declarado dentro de las BPM, siempre y
                    cuando las empresas mantengan los antecedentes técnicos
                    que lo justifiquen.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.17</b></td>
                <td style="text-align: left;">La declaración del contenido de vitaminas y de minerales es
                    opcional, excepto cuando el alimento o bebida se modifico
                    en su composición, debiendo cumplir con la NOM-086-SSA1-
                    1996.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">9.18</b></td>
                <td style="text-align: left;">La inclusión de uno de los nutrimentos mencionados en el
                    punto 4.5.2.4.9 (Modificación de la NOM-051) no obliga
                    incluir uno de los otros, y sólo si se tiene asignado un VNR y
                    el contenido de la porción sea igual o esté por arriba del 5%
                    del VNR (ya sea IDR o IDS).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">10</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Cálculo de nutrimentos</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">10.1</b> (5.1.1-M)</td>
                <td style="text-align: left;">La cantidad de energía debe calcularse utilizando el siguiente
                    factor de conversión:
                    <b style="font-size: 12px;">
                        Carbohidratos disponibles: 4 kcal/g --- 17 kJ/g
                        Proteínas: 4 kcal/g --- 17 kJ/g
                        Grasas: 9 kcal/g --- 37 kJ/g</b>
                </td>
                <td><b style="font-size: 12px;">NC</b></td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">10.2</b></td>
                <td style="text-align: left;">La cantidad de proteínas que se indica, debe calcularse
                    utilizando la siguiente fórmula:
                    <b style="font-size: 12px;">Proteína = contenido total de nitrógeno kjeldahl x 6.25</b>
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">10.3</b></td>
                <td colspan="3"><b style="font-size: 12px;">Nota:</b> <span style="font-size: 12px;">Para la expresión de la declaración nutrimental se puede utilizar los
                    parámetros de redondeo de la tabla
                    5 (Modificación a la NOM-051).</span></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">11</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Información nutrimental complementaria</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">11.1 </b>(4.5.3-M)</td>
                <td style="text-align: left;">Debe incluirse la información nutrimental complementaria
                    en la etiqueta los productos que contengan añadidos:
                    azúcares libres, grasas o sodio.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">11.2</b> (4.5.3-M)</td>
                <td style="text-align: left;">Debe incluir la información nutrimental complementaria los
                    productos que su valor de energía, la cantidad de azúcares
                    libres, de grasa saturada, grasas trans y de sodio cumplan
                    con los perfiles nutrimentales establecidos en la tabla 6 (ver
                    Modificación de NOM-051).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- pagina 12 --}}
            <tr>
                <td class="green"></td>
                <td colspan="3"><b style="font-size: 12px;">Nota:</b> <span style="font-size: 12px;">>para los efectos del punto anterior se entiende por: a)
                    Producto preenvasado añadido de azúcares libres, aquellos a los que durante el proceso de
                    elaboración se les
                    haya añadido azúcares libres, e ingredientes que contengan agregados azúcares libres.
                    b) Producto preenvasado añadido de grasas, aquellos a los que durante el proceso de elaboración se
                    haya
                    añadido grasas vegetales o animales, aceites vegetales parcialmente hidrogenados o productos e
                    ingredientes
                    que los contenga agregados; y c) Producto
                    preenvasado añadido de sodio, aquellos a los que durante el proceso de elaboración se haya utilizado
                    como
                    ingrediente o aditivo cualquier sal que contenga sodio o cualquier ingrediente que contenga sales de
                    sodio
                    agregadas. </span</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">11.3</b></td>
                <td style="text-align: left;">En los productos destinados a ser reconstituidos o que
                    requieran preparación antes de ser consumidos, la
                    información nutrimental complementaria debe declararse
                    conforme a los contenidos de energía, de azúcares libres,
                    grasas saturadas, grasas trans (con excepción de las
                    presetes en productos lácteos y cárnicos de manera natural
                    para el caso de las grasas trans), de sodio del producto tal
                    como se consume.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">12</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Sistema de etiquetado frontal</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">12.1</b> (4.5.3.4.1-M) </td>
                <td style="text-align: left;">La información nutrimental complementaria debe realizarse
                    utilizando los sellos, segun corresponda y conforme a lo
                    establecido en la tabla <b style="font-size: 12px;">A1-Tamaño de los sellos</b> del Apéndice
                    A (Normativo) (Modificiación de NOM-051).</td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">los sellos no son los correctos
                    y deben llevar acentos</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">12.2 </b>(4.5.3.4.2-M)</td>
                <td style="text-align: left;">Los productos cuya SPE sea ≤40 cm2 sólo deben incluir un
                    sello con el número que corresponda a la cantidad de
                    nutrimentos como se establece en la tabla A1 del Apéndice
                    A (Modificación de NOM-051).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">12.3 </b>(4.5.3.4.2-M)</td>
                <td style="text-align: left;">Los productos cuya SPE sea ≤ 5 cm2 el sello aplicable debe
                    cumplir con las características descritas en el numeral A.4.5
                    del Apéndice A (Modificación de NOM-051).</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">12.4 </b>(4.5.3.4.3-M)</td>
                <td style="text-align: left;">Para productos con envases retornables y que se utilizan
                    como contenedores para más de un tipo de producto o
                    sabor, expresar en la parte externa de la tapa el sello
                    correspondiente como se establece en 4.5.3.4.2
                    (Modificación NOM-051).
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">12.5</b> (4.5.3.4.4-M)</td>
                <td style="text-align: left;">Los productos etiquetados con la leyenda "No etiquetado
                    para su venta individual" o similar, debe incluirse los sellos
                    que correspondan en el envase colectivo o múltiple.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">12.6</b> (4.5.3.4.5-M)</td>
                <td style="text-align: left;">Cuando el envase colectivo o múltiple contenga más de un
                    tipo de producto, debe estar etiquetado de manera
                    individual. </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Ubicación y orden de los sellos y leyendas</td>
            </tr>
            {{-- pagina 13 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">13.1 </b>(4.5.3.4.6-M)</td>
                <td style="text-align: left;">El o los sellos se encuentran en la esquina superior derecha
                    de la SPE.</td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">La SPE mide 48 cm2</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.2 </b>(4.5.3.4.6-M)</td>
                <td style="text-align: left;">Producto con SPE menor a 60 cm2, los sellos pueden
                    aplicarse en cualquier área de dicha superficie.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.3 </b>(4.5.3.4.6-M)</td>
                <td style="text-align: left;">Productos con más de un sello, el orden de inclusión debe
                    ser izquierda a derecha el siguiente:
                    <p>1) EXCESO DE CALORÍAS 2)
                    EXCESO DE AZÚCARES</p>
                    <p>3) EXCESO DE GRASAS SATURADAS 4)
                    EXCESO DE GRASAS TRANS 5)
                    EXCESO DE SODIO</p>
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.4 </b>(4.5.3.4.7-M)</td>
                <td style="text-align: left;">En la lista de ingredientes se declaran edulcorantes o el
                    producto preenvasado contiene cafeína en cualquier
                    cantidad indicar las leyendas "COTIENE CAFEÍNA EVITAR EN
                    NIÑOS" o "CONTIENE EDULCORANTES - NO RECOMENDABLE
                    EN NIÑOS"
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.5 </b>(4.5.3.4.7-M)</td>
                <td style="text-align: left;">Las leyendas "CONTIENE CAFEÍNA EVITAR EN NIÑOS" o
                    "CONTIENE EDULCORANTES - NO RECOMENDABLE EN
                    NIÑOS", deben ir en la parte superior derecha de la SPE, en
                    caso de que contenga sellos, las leyendas deben ir debajo
                    de los sellos.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.6 </b>(6.3D - M)</td>
                <td style="text-align: left;">Si el producto contiene sellos o leyendas mencionadas en
                    los puntos anteriores, no debe realizarse declaraciones de
                    propiedades saludables.
                </td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2"><b style="font-size: 12px;">Retirar la leyenda "Productos nutritivos"</b></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.7</b> (6.3D - M)</td>
                <td style="text-align: left;">Si el producto contiene sellos o leyendas mencionadas en
                    los puntos anteriores, no debe realizarse declaraciones de
                    propiedades nutrimentales relacionadas directamente con
                    el sello que haya declarado en la etiqueta.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.8</b></td>
                <td style="text-align: left;">Si la etiqueta del producto preenvasado no contiene sellos y
                    leyendas precautorias, puede declararlo únicamente de
                    forma escrita con la frase "Este producto no contiene sellos
                    ni leyendas".</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.9</b></td>
                <td style="text-align: left;">El producto contiene la frase "Este producto no contiene
                    sellos ni leyendas", ésta debe ser colocada en la SPE y su
                    tipografía y tamaño debe ser igual o menor al tamaño
                    mínimo cuantitativo del contenido neto conforme a la NOM030-SCFI-2006.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- pagina 14 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">13.1 </b>(6.3D - M) </td>
                <td style="text-align: left;">En caso de que puedan realizarse declaraciones de
                    propiedades nutrimentales, deben fijarse en la superficie de
                    información con una altura máxima correspondiente a la
                    altura mínima del dato cuantitativo y la unidad de medida.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.11 </b>(4.1.5.-M)</td>
                <td style="text-align: left;">Si el producto cuenta con leyendas de edulcorantes o sellos
                    de advertencia, no deben incluir en la etiqueta personajes
                    infantiles, animaciones, dibujos animados, celebridades,
                    deportistas o mascotas, elementos interactivos (juegos
                    visuales - espaciales o para descargar), que vayan dirigidos a
                    niños, inciten, promueven o fomentes su consumo, compra
                    o elección.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">13.12 </b>(4.1.5.-M)</td>
                <td style="text-align: left;">No se debe hacer referencia en la etiqueta a elementos
                    ajenos al producto preenvasado con las mismas finalidades
                    del párrafo anterior.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">14</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Información adicional
                </td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">14.1</b></td>
                <td style="text-align: left;">Puede presentarse cualquier información o representación
                    gráfica, siempre que no esté en contradicción con los
                    requisitos obligatorios de esta norma, sea veraz y no
                    induzca a error al consumidor con respecto a la naturaleza y
                    características del producto.
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">14.2</b></td>
                <td style="text-align: left;">Cuando se empleen designaciones de calidad, éstas deben
                    ser fácilmente comprensibles, evitando
                    ser equívocas o engañosas en forma alguna para el
                    consumidor.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">14.3</b></td>
                <td style="text-align: left;">Puede presentarse cualquier información o representación
                    gráfica indicada en el envase que no se afecta al ambiente,
                    evitando que sea falta o equivoca para el consumidor. Por
                    ejemplo: Símbolo de reciclaje </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">14.4</b></td>
                <td style="text-align: left;">Pueden incluirse sellos o leyendas de recomendaciones o
                    reconocimiento por organizaciones, siempre y cuando se
                    presente la documentación apropiada. Por ejemplo:
                    Certificaciones como Halal o Kosher, Orgánico, TIF,
                    ecológico, asi como las denominaciones con prefijos "bio-"
                    o "eco-".</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">15</b></td>
                <td class="yellow" colspan="3" style="text-align:center;">Declaración de propiedades</td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">15.1</b></td>
                <td style="text-align: left;">Se prohíbe el uso de declaraciones que hagan suponer al
                    consumidor que se trata de un alimento equilibrado,
                    declaraciones que no pueden comprobarse, que es útil para
                    prevenir, aliviar, tratar o curar una enfermedad, trastorno o
                    estado fisiológico, declaraciones que puedan suscitar o
                    provocar miedo en el consumidor. o que afirme que el
                    alimento es fuente de todos los nutrimentos esenciales.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            {{-- paginA 15 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">15.2</b></td>
                <td style="text-align: left;">Se prohíbe el uso de declaraciones que puedan ser
                    engañosas, que carecen de sentido, incluidos los
                    comparativos y superlativos incompletos. Declaraciones
                    respecto a prácticas correctas de higiene o comercio como:
                    "genuidad","salubridad","sanidad","sano","saludable",
                    excepto las señaladas en otros ordenamientos jurídicos
                    aplicables.</td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2"><b style="font-size: 12px;">Retirar la leyenda "Productos nutritivos"</b></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">15.3</b></td>
                <td style="text-align: left;">Se permiten las declaraciones de propiedades condicionales
                    como: a) Que un
                    alimento ha adquirido un valor nutritivo especial o superior.
                    (ver 7. especificaciones nutrimentales, NOM-086-SSA1-
                    1994</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">15.4</b></td>
                <td style="text-align: left;">Se permiten las declaraciones de propiedades condicionales
                    como: b) Las indicaciones
                    de que el alimento tiene cualidades nutricionales especiales
                    gracias a la reducción u omisión de un nutrimento. (ver 7.
                    especificaciones nutrimentales, NOM-086-SSA1-1994).
                </td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">15.5</b></td>
                <td style="text-align: left;">Se prohíbe las declaraciones de propiedades que afirmen
                    que el alimento tiene características especiales cuando
                    todos los de su tipo también las tienen.</td>
                <td class="yellow-2"><b style="font-size: 12px;">NC</b></td>
                <td class="yellow-2">Retirar la leyenda "Productos
                    nutritivos"
                </td>
            </tr>
            {{-- pagina 16 --}}
            <tr>
                <td class="green"><b style="font-size: 12px;">15.6</b></td>
                <td style="text-align: left;">Puede utiizarse declaraciones de propiedades que
                    destaquen la ausencia o no adición de sustancias a los
                    alimentos, siempre y cuando: a)
                    no sea engañosa b)
                    no esté sujeta a requisitos específicos en ninguna norma.
                    c) sea una de las que el consumidor espera encontrar
                    normalmente en el alimento. d)
                    no haya sido sustituida por otra que confiera al alimento
                    características equivalentes a menos que la naturaleza de la
                    sustitución se declare explícitamente
                    con igual prominencia; y e)
                    sea un ingrediente cuya presencia o adición en el alimento
                    esté permitida.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green"><b style="font-size: 12px;">15.7</b></td>
                <td style="text-align: left;">f) Las declaraciones de propiedades que pongan de relieve
                    la ausencia o no adición de uno o más nutrimentos deberán
                    considerarse como declaraciones de propiedades
                    nutrimentales y, por consiguiente, deberán ajustarse a la
                    declaración obligatoria de nutrimentos, estipulada en el
                    marco jurídico aplicable.</td>
                <td class="N">C</td>
                <td class="fondo"></td>
            </tr>
        </table>
        <table class="table-fin">
            <tr>
                <td colspan="4" style="height: 12px;"></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 40%;">Comentarios y observaciones de la revisión</td>
                <td colspan="2" style="width: 60%;">observación</td>
            </tr>
            <tr>
                <td class="gray" colspan="2">Resolución</td>
                <td class="gray" colspan="2">No Cumple</td>
            </tr>
            <tr>
                <td rowspan="2" class="inspector" style="height: 20px;">
                    <img src="{{ public_path('img_pdf/4-a.png') }}" alt="Firma Inspector">
                    <br>Andres Alejandro Vidales Aroche
                    <br>Nombre y firma del inspector
                </td>
                <td colspan="3" class="director" style="height: 20px;">
                    <img src="{{ public_path('img_pdf/2-s.png') }}" alt="Firma Director">
                    <br>Mtra. Sylvana Figueroa Silva
                </td>
            </tr>
            <tr>
                <td colspan="3">Nombre y firma del Director Ejecutivo</td>
            </tr>
        </table>
    </div>{{-- fin del container --}}
    {{-- imagen fuera del contenedor --}}
    <div class="imagen">
      <img src="{{ public_path('img_pdf/3-img.png') }}" alt="Mix semillas">
  </div>



</body>

</html>
