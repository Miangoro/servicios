$(function() {
    // Verifica que la variable dataTableAjaxUrl esté definida (viene de la vista Blade)
    if (typeof dataTableAjaxUrl === 'undefined') {
        console.error("Error: 'dataTableAjaxUrl' no está definida. Asegúrate de definirla en tu vista Blade.");
        return; // Detener la ejecución si la URL no está disponible
    }

    // Inicializa DataTables usando el ID de la tabla
    var table = $('#tablaHistorial').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        },
        processing: true,
        serverSide: true,
        responsive: false, // Deshabilita el comportamiento de colapsar columnas
        // scrollX: true,     // Se ha quitado el desplazamiento horizontal, la tabla no tendrá su propia barra de desplazamiento
        ajax: {
            url: dataTableAjaxUrl,
            type: "GET",
            data: function(d) {
                // Puedes añadir parámetros adicionales a la solicitud AJAX aquí si es necesario
            }
        },
        dataType: 'json',
        columns: [
            {
                data: 'DT_RowIndex', // Para contar el número de fila
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '25px', // Ancho fijo para la columna NO, aún más pequeño
                className: 'text-center' // Centrar el texto
            },
            {
                data: 'nombre',
                name: 'nombre',
                width: '100px', // Ancho sugerido para el nombre de la empresa, más pequeño
                className: 'text-wrap' // Permite que el texto se envuelva si es muy largo
            },
            {
                data: 'rfc',
                name: 'rfc',
                width: '80px', // Ancho fijo para RFC, más pequeño
                className: 'text-center'
            },
            {
                data: 'calle',
                name: 'calle',
                width: '100px', // Ancho sugerido para la calle, más pequeño
                className: 'text-wrap'
            },
            {
                data: 'colonia',
                name: 'colonia',
                width: '80px', // Ancho sugerido para la colonia, más pequeño
                className: 'text-wrap'
            },
            {
                data: 'localidad',
                name: 'localidad',
                width: '70px', // Ancho sugerido para la localidad, más pequeño
                className: 'text-wrap'
            },
            {
                data: 'municipio',
                name: 'municipio',
                width: '70px', // Ancho sugerido para el municipio, más pequeño
                className: 'text-wrap'
            },
            {
                data: 'constancia',
                name: 'constancia',
                width: '40px', // Ancho sugerido para la constancia, aún más pequeño
                className: 'text-wrap text-center' // Permite envolver y centrar
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '80px', // Ancho fijo para las acciones, más pequeño
                className: 'text-center' // Centrar los botones de acción
            }
        ],
        // Deshabilitar el ajuste automático de ancho de columna para usar los anchos definidos
        autoWidth: false,
        // Puedes ajustar la paginación si lo deseas
        // pageLength: 10,
        // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });

    // Funciones editUnidad y deleteUnidad (pueden estar vacías por ahora)
    window.editUnidad = function(id) {
        console.log('Función editar llamada para ID:', id);
    };

    window.deleteUnidad = function(id) {
        console.log('Función eliminar llamada para ID:', id);
    };
});
