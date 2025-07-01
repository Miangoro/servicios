@extends('layouts/layoutMaster')

@section('title', 'Documentación')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/spinkit/spinkit.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/select2/select2.js'
])
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@section('page-script')
@vite([
  'resources/assets/js/cards-advance.js',
  'resources/assets/js/modal-add-new-cc.js'
])
@endsection

@section('content')
<div class="row g-6">

    <div class="col-md-12 col-xxl-12">
        <div class="card h-100">
          <img src="{{ asset('assets/img/branding/banner_documentos.png') }}" alt="timeline-image" class="card-img-top img-fluid" style="object-fit: cover;">
          <!-- <div class="card-header d-flex align-items-center justify-content-between">
           <div class="card-title mb-0">
              <h2 class="m-0 me-2">Requisitos documentales</h2>
              
            </div>
            
            
          </div>-->
          <div class="card-body p-0">

         

           
            <form id="uploadForm" enctype="multipart/form-data">
              <div class="form-floating form-floating-outline m-5 col-md-6">
                <select name="id_empresa" id="id_empresa" class="select2 form-select">
                  <option value="">Seleccione un cliente</option>
                  @foreach ($empresas as $cliente)
                  <option value="{{ $cliente->id_empresa }}">{{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }} | {{ $cliente->razon_social }}</option>
              @endforeach
                
               
                </select>
                
              </div>

              <!-- Contenedor para la barra de progreso -->

            
           
                <div class="" id="contenido"></div>
                
                <div class="row m-4">
                  <div class="col-md-3">
                  <button type="submit" class="btn btn-primary waves-effect waves-light">Subir documentación</button>
                </div>
                </div>
               
            </form>

          </div>
        </div>
      </div>
      <!--/ Orders by Countries -->
</div>

@include('_partials/_modals/modal-pdfs-frames')
<!-- /Modal -->
<script type="module">
// Check selected custom option
window.Helpers.initCustomOptionCheck();

</script>

<script>
$(document).ready(function() {

  
  initializeSelect2($('.select2'));
    // Función para cargar los datos de la normativa
    function cargarNormas(clienteId) {

      if (clienteId === "") {
        // Si seleccionó "Seleccione un cliente"
        $('#contenido').html(`
          <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
            <div class="text-center">
              <i class="fas fa-info-circle fa-2x text-info mb-3"></i>
              <h2 class="text-secondary">Por favor seleccione un cliente.</h2>
            </div>
          </div>
        `);

        return; // Salir de la función, no hace falta hacer la petición AJAX
    }

    if (clienteId) {
        $.ajax({
            url: '{{ route('documentacion.getNormas') }}',
            method: 'GET',
            data: { cliente_id: clienteId },
            success: function(data) {
                $('#contenido').html(data.tabs); // Mostrar contenido si se recibe correctamente
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar las normas:', error);
                $('#contenido').html('Hubo un error al cargar las normas.');
            }
        });
    } 
}




    // Cargar datos cuando el valor de #id_empresa cambia
    $('#id_empresa').change(function() {
        var clienteId = $(this).val();
        cargarNormas(clienteId);  // Llamada para cargar las normas según el cliente seleccionado
    });

    // Cargar datos al cargar la página por primera vez, usando el valor seleccionado inicialmente
    var clienteIdInicial = $('#id_empresa').val();
    cargarNormas(clienteIdInicial);  // Llamada para cargar las normas al cargar la página

});


function abrirModal(url,idDocumento) { 

    
    var iframe = $('#pdfViewer');
    var spinner = $('#cargando');
    var modalHeader = $("#encabezado_modal"); // Selecciona la cabecera del modal
    
    spinner.show();
    iframe.hide();

    // Cargar el PDF en el iframe
    iframe.attr('src', url);
    
    // Configurar el botón para abrir el PDF en una nueva pestaña
    $("#NewPestana").attr('href', url).show();

    // Eliminar botón anterior si ya existe
    $("#btnEliminarDocumento").remove();

    // Crear botón dinámicamente
    var btnEliminar = $('<button>', {
        id: "btnEliminarDocumento",
        class: "btn btn-danger btn-sm ms-auto waves-effect waves-light",
        html: '<i class="ri-delete-bin-6-line"></i> Eliminar Documento',
        click: function () {
            eliminarDocumento(idDocumento);
        }
    });

    // Insertar botón en la cabecera del modal
    modalHeader.prepend(btnEliminar);

    // Ocultar el spinner y mostrar el iframe cuando el PDF esté cargado
    iframe.on('load', function () {
        spinner.hide();
        iframe.show();
    });
}

function eliminarDocumento(idDocumento) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/eliminar-documento/' + idDocumento,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        title: "Eliminado",
                        text: "El documento ha sido eliminado correctamente.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $("#btnEliminarDocumento").remove(); // Elimina el botón
                    $("#pdfViewer").attr('src', ''); // Limpia el iframe
                    $('i.ri-file-pdf-2-fill[data-id="' + idDocumento + '"]').remove();
                    $('#mostrarPdf').modal('hide'); // Cierra el modal
                },
                error: function () {
                    Swal.fire({
                        title: "Error",
                        text: "Hubo un problema al eliminar el documento.",
                        icon: "error"
                    });
                }
            });
        }
    });
}






  document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita el envío normal del formulario

    let form = document.getElementById('uploadForm');
    let formData = new FormData(form);
     // Añadir el token CSRF
     formData.append('_token', '{{ csrf_token() }}');

let xhr = new XMLHttpRequest();

xhr.open('POST', '{{ route('upload') }}', true);

// Configurar SweetAlert con barra de progreso
Swal.fire({
        title: 'Subiendo...',
        html: `
            Por favor, espera mientras subimos tus documentos.
            <br><br>
            <div class="swal2-progress-bar" style="width: 0%; background: green; height: 25px;"></div>
            <b>0%</b>
        `,
        allowOutsideClick: false,
        customClass: {
                    showCancelButton: false,
                    confirmButtonText: 'Salir',
                    confirmButton: 'btn btn-success'
        },
        didOpen: () => {
            Swal.showLoading();

            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    let percentage = (e.loaded / e.total) * 100;
                    Swal.getContent().querySelector('b').textContent = Math.round(percentage) + '%';

                    // Actualiza la barra de progreso
                    Swal.getContent().querySelector('.swal2-progress-bar').style.width = percentage + '%';
                }
            };
        }
    });

    // Manejador de la respuesta
    xhr.onload = function() {
        if (xhr.status === 200) {
            Swal.fire({
                icon: 'success',
                title: '¡Carga exitosa!',
                text: 'Tus documentos se han subido con éxito.',
                customClass: {
                    confirmButtonText: 'Salir',
                    confirmButton: 'btn btn-success'
                  },
                showCancelButton: false,
                showDenyButton: false, 
            });
            let response = JSON.parse(xhr.responseText);
            for (let i = 0; i < response.id_documento.length; i++) {
              $('input[type="file"]').val('');
                  $("#mostrar"+response.id_documento[i]).append('<i onclick="abrirModal(\'files/' +response.folder+ '/' +response.files[i]+ '\','+response.id[i]+')" data-id="'+response.id[i]+'" class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal"  data-registro=""></i>');
              }
        } else {
            Swal.fire({
                icon: 'error',
                title: '¡Carga falló!',
                text: 'Hubo un error al subir tus documentos.',
                customClass: {
                    confirmButtonText: 'Salir',
                    confirmButton: 'btn btn-danger'
                  },
                showCancelButton: false,
                showDenyButton: false, 
            });
        }
    };

    // Manejo de errores
    xhr.onerror = function() {
        Swal.fire({
            icon: 'error',
            title: '¡Carga falló!',
            text: 'Hubo un error al subir tus documentos.'
        });
    };

    // Envía la solicitud
    xhr.send(formData);
});

function initializeSelect2($elements) {
    $elements.each(function () {
      var $this = $(this);
   
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent()
      });
    });
  }



</script>
@endsection
