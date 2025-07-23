$(function() {
    var table = $('.prov_datatable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
        },
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "/catalogos/proveedores",
            type: "GET",
        },
        dataType: 'json',
        columns: [{
            data: 'DT_RowIndex', // para contar el número de fila
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
            data: 'Datos Bancarios',
            name: 'Datos Bancarios',
            orderable: false,
            searchable: false
        },{
            data: 'Contacto',
            name: 'Contacto',
            orderable: false,
            searchable: false
        },{
            data: 'tipo',
            name: 'Tipo de Compra',
        },{
            data: 'Evaluacion del Proveedor',
            name: 'Evaluación del Proveedor',
            orderable: false,
            searchable: false
        }, {
            data: 'action',
            name: 'action',
            orderable: true,
            searchable: false
        }, ]
    });
});

 $(function () {
        var maxlengthInput = $('.bootstrap-maxlength-example'),
            formRepeater = $('.form-repeater');

        // Bootstrap Max Length
        // --------------------------------------------------------------------
        if (maxlengthInput.length) {
            maxlengthInput.each(function () {
                $(this).maxlength({
                    warningClass: 'label label-success bg-success text-white',
                    limitReachedClass: 'label label-danger',
                    separator: ' out of ',
                    preText: 'You typed ',
                    postText: ' chars available.',
                    validate: true,
                    threshold: +this.getAttribute('maxlength')
                });
            });
        }

        // Form Repeater
        // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
        // -----------------------------------------------------------------------------------------------------------------

        if (formRepeater.length) {
            var row = 2;
            var col = 1;
            formRepeater.repeater({
                show: function () {
                    var fromControl = $(this).find('.form-control, .form-select');
                    var formLabel = $(this).find('.form-label');

                    fromControl.each(function (i) {
                        var id = 'form-repeater-' + row + '-' + col;
                        $(fromControl[i]).attr('id', id);
                        $(formLabel[i]).attr('for', id);
                        col++;
                    });

                    row++;

                    $(this).slideDown();
                },
                hide: function (e) {
                    confirm('Are you sure you want to delete this element?') && $(this).slideUp(e);
                }
            });
        }
    });