{{-- resources/views/clientes/export_clientes_empresas_view.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar Clientes/Empresas</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap/bootstrap.css') }}" />
    {{-- @extends('layouts/layoutMaster') --}}
    {{-- @section('content') --}}
</head>
<body>
    <div class="container mt-5">
        <h1>Opciones de Exportación de Clientes</h1>
        <p>Selecciona el formato en el que deseas exportar los datos de tus clientes.</p>

        <div class="d-flex gap-3 mt-4">
            {{-- Ejemplo de botón para exportar a Excel (Necesitarás una ruta y función en el controlador para esto) --}}
            <a href="#" class="btn btn-success">
                <i class="ri-file-excel-line me-2"></i> Exportar a Excel
            </a>

            {{-- Ejemplo de botón para exportar a PDF (Necesitarás una ruta y función en el controlador para esto) --}}
            <a href="#" class="btn btn-danger">
                <i class="ri-file-pdf-line me-2"></i> Exportar a PDF
            </a>

            {{-- Puedes añadir más opciones aquí, como un formulario para filtrar fechas, etc. --}}
        </div>

        <p class="mt-5">Aquí podrías añadir un previsualizador de datos o más controles de filtro.</p>
    </div>

    <script src="{{ asset('assets/vendor/libs/bootstrap/bootstrap.js') }}"></script>
    {{-- @endsection --}}
</body>
</html>