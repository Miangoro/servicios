$(function() {
    var table = $('.lab_datatable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        },
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/catalogos/proveedores", // Asegúrate de que esta URL apunte al método `getProveedores` en tu controlador
            type: "GET",
            // data: function(d) {} // No necesitas esto a menos que envíes filtros adicionales
        },
        dataType: 'json',
        // type: "POST", // DataTables server-side con GET es común, si tu backend espera POST, manténlo.
        columns: [{
            data: 'DT_RowIndex', // Esto es lo que `addIndexColumn()` de Yajra DataTables devuelve por defecto
            name: 'num',
            orderable: false,
            searchable: false
        }, {
            data: 'razon_social',
            name: 'Razón Social'
        }, {
            data: 'direccion',
            name: 'Dirección'
        }, {
            data: 'rfc',
            name: 'RFC'
        },{
            data: 'Datos Bancarios', // Nombre de la columna generada en el controlador
            name: 'Datos Bancarios',
            orderable: false, // Probablemente no quieras ordenar por este texto HTML
            searchable: false // Probablemente no quieras buscar por este texto HTML
        },{
            data: 'Contacto', // Nombre de la columna generada en el controlador
            name: 'Contacto',
            orderable: false,
            searchable: false
        },{
            data: 'tipo',
            name: 'Tipo de Compra',
        },{
            data: 'Evaluacion del Proveedor', // Nombre de la columna generada en el controlador
            name: 'Evaluación del Proveedor',
            orderable: false,
            searchable: false
        }, {
            data: 'action',
            name: 'action',
            orderable: true, // Si tus botones de acción no afectan el orden, déjalo true.
            searchable: false
        }, ]
    });
});