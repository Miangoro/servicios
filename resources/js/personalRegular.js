$(function () {
  $('.personalR_datatable').DataTable({
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
    },
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: '/personal/regular',
      type: 'GET'
    },
    dataType: 'json',
    columns: [
      { data: 'DT_RowIndex', name: 'num', orderable: true, searchable: false },
      { data: 'folio', name: 'folio', searchable: true },
      { data: 'foto', name: 'foto', searchable: true },
      { data: 'nombre', name: 'nombre', searchable: true },
      { data: 'fecha_ingreso', name: 'fecha_ingreso', searchable: true },
      { data: 'descripcion', name: 'descripcion', searchable: true },
      { data: 'correo', name: 'correo', searchable: true },
      { data: 'action', name: 'action', orderable: true, searchable: false }
    ]
  }).on('init.dt', function () {
    var boton = $('#addEmpleadoR').clone();

    var searchDiv = $('.dataTables_filter');

    // Contenedor con flexbox
    searchDiv.css({
      display: 'flex',
      alignItems: 'center',
      justifyContent: 'right',
      gap: '10px'
    });

    // Mover el botón a la derecha del input de búsqueda
    searchDiv.append(boton);

    // Eliminar el botón original para evitar duplicados
    $('#addEmpleadoR').remove();
  });
});