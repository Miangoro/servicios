<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Validación</title>
    <style>
        /* Estilo General */
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            border-top: 4px solid #0C1444;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #0C1444;
            margin-bottom: 20px;
            font-weight: 600;
        }

        p {
            font-size: 14px;
            margin: 10px 0;
            color: #555;
        }

        p strong {
            color: #0C1444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0C1444;
            color: #fff;
            font-weight: 600;
        }

        .validado {
            color: #4CAF50;
            font-weight: bold;
        }

        .no-validado {
            color: #F44336;
            font-weight: bold;
        }

        /* Estilo para los estados aprobados o no aprobados */
        .estado {
            font-size: 16px;
            padding: 4px 8px;
            border-radius: 50px;
            display: inline-block;
        }

        .validado .estado {
            background-color: #4CAF50;
            color: white;
        }

        .no-validado .estado {
            background-color: #F44336;
            color: white;
        }

        /* Línea separadora */
        .linea-separadora {
            height: 1px;
            background-color: #ddd;
            margin: 20px 0;
        }

        footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Validación</h1>
        <p><strong>Cliente:</strong> {{ $datos->solicitud->empresa->razon_social }}</p>
        <p><strong>Solicitud:</strong> {{ $datos->solicitud->folio }} {{ $datos->solicitud->tipo_solicitud->tipo }}</p>
        <p><strong>Fecha de validación:</strong> {{ $fecha }}</p>
        <p><strong>Responsable de validación:</strong> {{ $datos->responsable->name }}</p>

        <div class="linea-separadora"></div>

        <h2>Detalles de Validación</h2>
        <table>
            <tr>
                <th>Campo</th>
                <th>Estado</th>
            </tr>
            @foreach($datos['validacion'] as $campo => $estado)
                <tr>
                    <td>{{ ucfirst($campo) }}</td>
                    <td class="{{ $estado == 'si' ? 'validado' : 'no-validado' }}">
                        <span class="estado">
                            {{ $estado == 'si' ? 'Aprobado' : 'No Aprobado' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="linea-separadora"></div>

        <footer>
            <p>Este es un reporte generado automáticamente.</p>
        </footer>
    </div>
</body>
</html>
