<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Dictámenes</title>


    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Barra de navegación */
        .nav_bar {
            background-color: #062e61;
            color: white;
            padding: 15px;
            text-align: center;
        }

        #texto1 {
            font-size: 20px;
            font-weight: bold;
        }

        #texto2 {
            font-size: 16px;
        }

        /* Estilos para el panel */
        .panel {
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        
            padding: 20px;
        }

        .panel-heading {
            background-color: #062e61;
            color: white;
            font-size: 22px;
            text-align: center;
            padding: 10px 0;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .alert {
            background-color: #062e61;
            color: white;
            font-size: 18px;
            margin: 10px 0;
            padding: 15px;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #243868;
            color: white;
        }

        .table td {
            background-color: #f9f9f9;
        }



        #footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: #062e61;
            color: white;
            padding: 15px;
            font-size: 14px;
        }

        #footer a {
            color: #2adc9f;
            text-decoration: none;
        }

        .panel-footer {
            position: fixed;
            bottom: 42px;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            z-index: 999;

            text-align: center;
            margin-top: 20px
        }

        .panel-footer img {
            max-width: 80%;
            height: auto;
        }


        @media only screen and (max-width: 600px) {
            .panel {
                padding: 15px;
            }

            .panel-heading {
                font-size: 20px;
            }

            .table th,
            .table td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>

    <div class="nav_bar">
        <div id="texto1">VALIDACIÓN DE DICTÁMENES</div>
        <div id="texto2">UNIDAD DE INSPECCIÓN CIDAM</div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8" style="float:none;margin:auto; margin-bottom:80px">
                <div class="panel panel-default">

                    <div class="alert">
                        <strong>Dictamen de cumplimiento de Instalaciones como Comercializador</strong>
                    </div>

                    <div class="alert">
                        <strong>No: UMC-005/2025</strong>
                    </div>

                    <table class="table">
                        <tbody>
                            <tr>
                                <td><b>CERTIFICADO DE LOTE A GRANEL</b></td>
                                <td>CIDAM C-GRA-057/2024</td>
                            </tr>
                            <tr>
                                <td><b>CATEGORÍA</b></td>
                                <td>Mezcal Ancestral</td>
                            </tr>
                            <tr>
                                <td><b>CLASE</b></td>
                                <td>Blanco O Joven</td>
                            </tr>
                            <tr>
                                <td><b>MARCA</b></td>
                                <td>Envido 29</td>
                            </tr>
                            <tr>
                                <td><b>LOTE A GRANEL</b></td>
                                <td>ES-0224</td>
                            </tr>
                            <tr>
                                <td><b>LOTE ENVASADO</b></td>
                                <td>ES-0224</td>
                            </tr>
                            <tr>
                                <td><b>TIPO DE AGAVE</b></td>
                                <td>Maguey Espadín (a. Angustifolia)</td>
                            </tr>
                            <tr>
                                <td><b>PRODUCIDO EN</b></td>
                                <td>Oaxaca</td>
                            </tr>
                            <tr>
                                <td><b>ENVASADO EN</b></td>
                                <td>Oaxaca</td>
                            </tr>
                            <tr>
                                <td><b>CONTENIDO ALCOHÓLICO</b></td>
                                <td>50 % Alc. Vol</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" style="font-size: 23px; text-align: center;">Comercializador o
                                    Licenciatario de Marca</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>NOMBRE / EMPRESA</b></td>
                                <td>PEDRO RODRÍGUEZ DÍAZ</td>
                            </tr>
                            <tr>
                                <td><b>RFC</b></td>
                                <td>RODP830905D51</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <img src="{{ asset('assets/img/illustrations/banner_oc_cidam.png') }}" alt="">
        </div>

        <div id="footer">
            <div>2024 © Todos los derechos reservados a <a href="https://cidam.org/sitio/">CIDAM</a></div>
        </div>
    </div>

</body>

</html>
