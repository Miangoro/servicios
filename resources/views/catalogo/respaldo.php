<style>
  /* Aplica solo a la clase que contiene la tabla */
.lab_datatable td {
    white-space: nowrap;
}

</style>

<!-- Modal de Confirmación  de eliminación-->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">¡Importante!</h5>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que quieres eliminar esta solicitud?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para mostrar el PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfModalLabel">Vista Previa del PDF</h5>
        <a id="btnAbrirPdf" target="_Blank" href="" class="btn btn-info">Abrir en nueva pestaña</a>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="loading-spinner" class="text-center my-3" style="display: flex; height: 70vh;   justify-content: center;  align-items: center;">
          <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;"> 
            <i class="fa fa-spinner fa-spin fa-4x"></i>
          </div>
        </div>
        <iframe id="pdfIframe" src="" style="width:100%; height:80vh;" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h1 class="mb-0"><b>Informes 070 Nacional</b></h1>
                        </div>
                        <div class="col-6 text-right">
                        
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive p-3">
                    <table class="table table-flush table-bordered lab_datatable table-striped table-sm">
                       
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-white">No.</th>
                                <th scope="col" class="text-white">Clave</th>
                                <th scope="col" class="text-white">Nombre de laboratorio</th>
                                <th scope="col" class="text-white">Descripción</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="..."></nav>
                </div>
            </div>
        </div>
    </div>

</div>

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endpush
<script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>

<script type="text/javascript">
    $(function() {
        var table = $('.lab_datatable').DataTable({

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            },
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
        url: "{{ route('laboratorios.index') }}",
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
</script>