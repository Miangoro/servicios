<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F7.1-04-04 Carta asignación del número de cliente NMX-V-052-NORMEX-2016 Ed 0 Vigente</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 15px;
            color:#000000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .text_marge{
            margin: 25px;
        }

        .header img {
            width: 250px;
            float: left;
            
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header h2 {
            font-size: 14px;
            margin: 0;
            font-weight: normal;
        }

        .header h6 {
            font-size: 10px;
            margin: 0;
        }

        .section {
            margin-top: 20px;
            margin-bottom: 3rem;
        }

        .section p {
            margin: 0px 5px;
        }

        .text_al {
            text-align: right;
            margin: 0; padding: 0;

        }


        .section .bold {
            font-weight: bold;
        }



        .text_c{
            color: rgb(4, 57, 78);
            margin: 2px 0; /* Ajusta el margen según sea necesario */

        }
        .content {
            margin-left: 20rem; /* Adjust this value as needed to ensure enough space on the right */
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM">
        <h2 class="text_c font-weight-bold">Centro de Innovación y Desarrollo Agroalimentario <br> de Michoacán, A.C.</h2>
        <h2>Acreditado como organismo de certificación de producto con <br>
             número de acreditación 144/18 ante la Entidad Mexicana <br> 
             de Acreditación, A.C.</h2>

    </div>

    <div class="section content">
        <p class="text_al left">Oficio:<strong>CIDAM052/OC/____/20__</strong></p>
        <p class="text_al left">Morelia, Michoacán. a __ de _____ del 20__</p>
        <p class="text_al left">ASUNTO: Asignación del número de cliente.</p>
    </div>

    <div class="section">
        <strong>C. REPRESENTANTE LEGAL</strong> <br>
        <span class="font-weight-bold" style="text-decoration: underline;"> {{ !empty($datos[0]->representante) && $datos[0]->representante !== 'No aplica' ? $datos[0]->representante : $datos[0]->razon_social }}</span> <br>
        <strong>PRESENTE</strong>
    </div>

    <div class="section">
        <p style="text-align: justify; text-indent: 40px;">Por medio de la presente el Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. acreditado como Organismo de Certificación de Producto, con número 144/18 ante la Entidad Mexicana de Acreditación, A.C. de acuerdo con los criterios establecidos en la Norma Mexicana NMX-EC-17065-IMNC-2014/ISO/IEC 17065:2012 para las actividades de certificación. Se le informa que a partir de esta fecha queda inscrito como cliente del Organismo Certificador del CIDAM, como parte de la cadena productiva de Bebidas alcohólicas que contienen
Mezcal (Bebidas alcohólicas preparadas, Cócteles, Licores o cremas) en los eslabones 
            @php
                $total = count($datos);
                $i = 0;
            @endphp
            @foreach ($datos as $eslabon)
            
            <strong>{{$eslabon->actividad}}</strong>@if ($i > 0),@endif
            @php
            $i++;
        @endphp
            @endforeach
            
            por consiguiente se le designa el número:</p>
        <div class=" text-center">
            <strong>{{$datos[0]->numero_cliente}}</strong>
        </div>
        <div style="margin-bottom: 40px;">
            <p>Sin otro en particular le envío un cordial saludo.</p>

        </div  >

        

    </div>
    <div class="text_marge text-center">
        <p>Atentamente.</p>

    </div>
    <div style="margin-bottom: 50px; text-align: center">
        <img style="display: block; margin: 0 auto;" height="60px" src="{{ storage_path('app/public/firmas/firma_mayra.png') }}">
        <p class="text_al text-center">GERENTE TÉCNICO DEL ORGANISMO</p>
        <p class="text_al text-center">CERTIFICADOR CIDAM A.C.</p>
    </div>
    
    <div style="margin-bottom: 20px;">
        <p class="text_al">Carta asignación del número de cliente NMX-V-052-NORMEX-2016 F7.1-04-04</p>
        <p class="text_al">Ed 0 Entrada en vigor. 12-09-2022</p>
    </div>
    <div>
        <p class="text-center" style="font-size: 10px;">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede <br> 
            ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
        </p>
    </div>
    
    
</body>

</html>
