document.addEventListener('DOMContentLoaded', function () {
    const tabs = {
        'tab-mezcal': 'mezcal',
        'tab-alcoholicas': 'alcoholicas',
        'tab-no-alcoholicas': 'no-alcoholicas'
    };

// Función Icono por ID
function obtenerIcono(id_tipo) {
    const id_tipoStr = id_tipo.toString();
   // console.log('ID recibido:', id_tipoStr); 
    switch (id_tipoStr) {
        case '1': 
            return 'assets/img/solicitudes/muestreoDeAgave.png'; 
        case '2': 
            return 'assets/img/solicitudes/Vigilancia en la producción de lote.png'; 
        case '3': 
            return 'assets/img/solicitudes/muestreo de lote a granel.png'; 
        case '4': 
            return 'assets/img/solicitudes/Vigilancia en el transaldo.png'; 
        case '5': 
            return 'assets/img/solicitudes/inspección de envasado.png'; 
        case '6': 
            return 'assets/img/solicitudes/muestreo de lote envasado.png'; 
        case '7': 
            return 'assets/img/solicitudes/Inspección de ingreso.png'; 
        case '8': 
            return 'assets/img/solicitudes/liberación de producto.png';  
        case '9': 
            return 'assets/img/solicitudes/Inspección en la liberación.png'; 
        case '10': 
            return 'assets/img/solicitudes/geo.png'; 
        case '11': 
            return 'assets/img/solicitudes/pedidos para exportacion.png'; 
        case '12': 
            return 'assets/img/solicitudes/certificado_granel.png'; 
        case '13': 
            return 'assets/img/solicitudes/certificado_granel.png'; 
        case '14': 
        return 'assets/img/solicitudes/Dictaminación de instalaciones.png'; 
        case '15': 
            return 'assets/img/icons/brands/vue.png'; 
        default:
            return 'assets/img/icons/brands/reddit-rounded.png'; 
    }
}
    
    function cargarCards(tipo) { 
        fetch(`${obtenerSolicitudesTiposUrl}?tipo=${tipo}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Red no disponible');
                }
                return response.json();
            })
            .then(data => {
                const contentContainerId = Object.keys(tabs).find(key => tabs[key] === tipo) + '-content';
                const contentContainer = document.getElementById(contentContainerId);
                contentContainer.innerHTML = ''; 

                var solicitudesMap = {                    
                    1: "#addSolicitudMuestreoAgave",
                    2: "#addVigilanciaProduccion",         
                    3: "#addMuestreoLoteAgranel",         
                    4: "#addVigilanciaTraslado",         
                    5: "#addInspeccionEnvasado",         
                    6: "#addMuestreoLoteEnvasado",         
                    7: "#addInspeccionIngresoBarricada",         
                    8: "#addLiberacionProducto",   
                    9: "#addInspeccionLiberacion",         
                    10: "#addSolicitudGeoreferenciacion",
                    11: "#addPedidoExportacion",    
                    12: "#addEmisionCetificado",    
                    13: "#addEmisionCetificadoVentaNacional",    
                    14: "#addSolicitudDictamen",    
                    15: "#addRenovacionDictamenInstalaciones", 
                  
                };

                
                
                if (Array.isArray(data) && data.length > 0) {
                    data.forEach((item, index) => {
                        const solicitud = solicitudesMap[item.id_tipo] || "#defaultSolicitud";
                        const icono = obtenerIcono(item.id_tipo); 
                        //console.log('Ícono asignado:', icono);
                    
                        // Crear la tarjeta
                        const card = document.createElement('div');
                        card.className = 'col-sm-12 col-md-6 col-lg-4 col-xl-3';
                        card.innerHTML = ` 
                            <div data-bs-target="${solicitud}" data-bs-toggle="modal" data-bs-dismiss="modal" class="card card-hover shadow-sm border-light">
                                <div class="card-body text-center d-flex flex-column align-items-center">
                                    <img src="${icono}" alt="Icono" class="img-fluid mb-3" style="max-width: 80px;"/>
                                    <h5 class="card-title mb-4">${item.tipo || 'Tipo no disponible'}</h5>
                                </div>
                            </div>
                        `;
                    
                        // Agregar la tarjeta al contenedor
                        contentContainer.appendChild(card);
                    
                        // Agregar un "salto de línea" después de las primeras dos tarjetas
                        if (index === 1) { // Después de la segunda tarjeta
                            const clearfix = document.createElement('div');
                            clearfix.className = 'w-100 d-md-none'; // w-100 rompe la fila, d-md-none lo oculta en pantallas medianas y más grandes
                            contentContainer.appendChild(clearfix);
                        }
                    });
                    
                } else {
                    contentContainer.innerHTML = '<p>No se encontraron datos.</p>';
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos:', error);
                const contentContainerId = Object.keys(tabs).find(key => tabs[key] === tipo) + '-content';
                document.getElementById(contentContainerId).innerHTML = '<p class="text-danger">No se pudo cargar la información.</p>';
            });
    }

    // Cargar datos para la pestaña activa por defecto
    cargarCards('mezcal');

    document.querySelectorAll('#myTab a[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', (event) => {
            const tipo = tabs[event.target.id];
            cargarCards(tipo);
        });
    });

    // Escuchar el clic en el botón de cancelar
$(".btnCancelar").on('click', function () {
    // Obtener el modal actual desde el botón que se hizo clic
    const modal = $(this).closest('.modal');

    // Buscar un formulario dentro de ese modal
    const form = modal.find('form')[0]; // obtiene el primer <form> dentro del modal

    if (form && typeof form.reset === 'function') {
        form.reset(); // Limpia inputs, textareas, etc.
    }

    // Limpiar Select2 dentro del modal
    modal.find('.select2').val(null).trigger('change');

    // Opcional: limpiar errores de validación visual (Bootstrap)
    modal.find('.is-invalid').removeClass('is-invalid');
    // No eliminar, solo limpiar y ocultar los mensajes de error
    modal.find('.invalid-feedback').text('');

    // Ocultar el modal actual
    modal.modal('hide');

    // Mostrar el modal anterior (ajusta si usas varios niveles)
    $("#verSolicitudes").modal('show');
});



});