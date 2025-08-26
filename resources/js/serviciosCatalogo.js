$(function () {
  $('.servCat_datatable').DataTable({
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
    },
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: '/serviciosCatalogo',
      type: 'GET'
    },
    dataType: 'json',
    columns: [
      { data: 'DT_RowIndex', name: 'num', orderable: true, searchable: false },
      { data: 'clave', name: 'clave', searchable: true },
      { data: 'nombre', name: 'nombre', searchable: true },
      { data: 'precio', name: 'precio', searchable: true },
      { data: 'laboratorio', name: 'laboratorio', searchable: true },
      { data: 'metodo', name: 'metodo', searchable: true },
      { data: 'duracion', name: 'duracion', searchable: true },
      { data: 'habilitado', name: 'habilitado', searchable: true },
      { data: 'action', name: 'action', orderable: true, searchable: false }
    ]
  }).on('init.dt', function () {
    var boton = $('#addServicioBTN').clone();
    var botonExp = $('#exportarExcelBtn').clone();

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
    searchDiv.append(botonExp);

    // Eliminar el botón original para evitar duplicados
    $('#addServicioBTN').remove();
    $('#exportarExcelBtn').remove();
  });
});

// Abrir modal de exportar
$('#exportarExcelBtn').on('click', function () {
    $('#exportarServiciosExcel').modal('show');
});

// Abrir modal de agregar servicio
$('#addServicioBTN').on('click', function () {
    $('#modalAddServiciosCatalogo').modal('show');
});