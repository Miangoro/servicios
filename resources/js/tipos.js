  $(function() {
        var table = $('.lab_datatable').DataTable({

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
        url: "/catalogos/laboratorios",
        type: "GET",
        data: function (d) {
        }
        },
            dataType: 'json',
            type: "POST",
            columns: [
                {
                    data: 'id_laboratorio',
                    name: 'id_laboratorio'
                },
                
               
                {
                    data: 'clave',
                    name: 'clave'
                }, 
                
                {
                    data: 'laboratorio',
                    name: 'laboratorio'
                },
                {
                    data: 'descripcion',
                    name: 'descripcion'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]

        });
       
    });

      $(function() {
        var table = $('.unidades_datatable').DataTable({

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
        url: "/catalogos/unidades",
        type: "GET",
        data: function (d) {
        }
        },
            dataType: 'json',
            type: "POST",
            columns: [
                {
                    data: 'id_unidad',
                    name: 'id_unidad'
                },
                
               
                {
                    data: 'nombre',
                    name: 'nombre'
                }, 
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]

        });
       
    });