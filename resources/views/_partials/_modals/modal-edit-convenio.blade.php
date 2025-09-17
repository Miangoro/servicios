<div class="modal fade" id="addConvenioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary pb-4">
        <h4 class="modal-title text-white" id="addConvenioModalLabel">Registrar Nuevo Convenio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAddConvenio" class="row g-3" method="POST" novalidate>
          @csrf
          <input type="hidden" id="convenioId" name="convenio_id">

          <div class="col-12 mb-3">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="ri-key-2-line"></i></span>
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="clave" name="clave" class="form-control" placeholder="01-PROY" required />
                    <label for="clave">Clave</label>
                  </div>
                </div>
                <div class="form-text text-muted ms-1">Campo obligatorio para nuevos convenios.</div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="ri-flask-line"></i></span>
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="nombreProyecto" name="nombre_proyecto" class="form-control" placeholder="Análisis de Bacillus Subtilis" required />
                    <label for="nombreProyecto">Nombre del Proyecto</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 mb-3">
            <div class="row g-3">
              <div class="col-md-4">
                <div class="input-group input-group-merge">
                  <span class="input-group-text"><i class="ri-user-line"></i></span>
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="investigadorResponsable" name="investigador_responsable" class="form-control" placeholder="Dra. Citlali Colín" required />
                    <label for="investigadorResponsable">Investigador responsable</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                  <input type="number" id="duracion" name="duracion" class="form-control" placeholder="Ej. 12" required />
                  <label for="duracion">Duración</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                  <select id="tipoDuracion" name="tipo_duracion" class="form-select" required>
                    <option value="" selected disabled>Selecciona una opción</option>
                    <option value="mes">Mes</option>
                    <option value="año">Año</option>
                    <option value="semanas">Semanas</option>
                    <option value="dias">Días</option>
                  </select>
                  <label for="tipoDuracion">Tipo Duración</label>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 text-end mt-4">
            <button type="submit" id="submitButton" class="btn btn-primary me-2">
              <i class="ri-add-line"></i> Registrar
            </button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
              <i class="ri-close-line"></i> Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(function() {
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  const table = $('#tablaConvenios').DataTable({
    processing: true,
    serverSide: true,
    ajax: { url: $('#tablaConvenios').data('url'), type: 'GET' },
    columns: [
      { data: 'DT_RowIndex', orderable:false, searchable:false },
      { data: 'clave' },
      { data: 'nombre_proyecto' },
      { data: 'investigador_responsable' },
      { data: 'duracion' },
      { data: 'tipo_duracion' },
      { data: 'acciones', orderable:false, searchable:false }
    ],
    language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' }
  });

  const form = $('#formAddConvenio')[0];
  const modal = new bootstrap.Modal('#addConvenioModal');
  const modalTitle = $('#addConvenioModalLabel');
  const submitBtn = $('#submitButton');

  function resetForm(){
    form.reset();
    $('#convenioId').val('');
    $('.is-invalid').removeClass('is-invalid');
    modalTitle.text('Registrar Nuevo Convenio');
    submitBtn.html('<i class="ri-add-line"></i> Registrar');
    $('#clave').attr('required',true).attr('placeholder','01-PROY');
  }

  $('#tablaConvenios').on('click','.btn-edit',function(){
    $('#convenioId').val($(this).data('id'));
    $('#clave').val($(this).data('clave')).removeAttr('required');
    $('#nombreProyecto').val($(this).data('nombre'));
    $('#investigadorResponsable').val($(this).data('investigador'));
    $('#duracion').val($(this).data('duracion'));
    $('#tipoDuracion').val($(this).data('tipo-duracion'));
    $('#clave').attr('placeholder','Dejar vacío para mantener clave actual');
    modalTitle.text('Editar Convenio');
    submitBtn.html('<i class="ri-pencil-line"></i> Actualizar');
    modal.show();
  });

  $('#formAddConvenio').on('submit',function(e){
    e.preventDefault();
    const id = $('#convenioId').val();
    const edit = id !== '';
    let url = edit ? `/convenios/${id}` : this.action;
    let formData = new FormData(this);
    if(edit){
      formData.append('_method','PUT');
      if($('#clave').val().trim()===''){ formData.delete('clave'); }
    }
    fetch(url,{
      method:'POST',
      body:formData,
      headers:{ 'Accept':'application/json','X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') }
    })
    .then(r=>r.ok?r.json():r.json().then(err=>Promise.reject(err)))
    .then(d=>{
      if(d.success){
        Swal.fire({ icon:'success', title:'¡Guardado!', text:d.message, timer:2000, showConfirmButton:false })
        .then(()=>{ table.ajax.reload(); modal.hide(); resetForm(); });
      }else{
        Swal.fire({ icon:'error', title:'Error', text:d.message||'Hubo un problema al guardar el convenio.' });
      }
    })
    .catch(err=>{
      if(err.errors){
        let html='';
        for(const f in err.errors){
          const id = f==='investigador_responsable'?'investigadorResponsable': f==='nombre_proyecto'?'nombreProyecto': f==='tipo_duracion'?'tipoDuracion': f;
          $('#'+id).addClass('is-invalid');
          html+=err.errors[f].join('<br>')+'<br>';
        }
        Swal.fire({ icon:'error', title:'Error de validación', html });
      }else{
        Swal.fire({ icon:'error', title:'¡Error!', text: err.message || 'Ocurrió un error inesperado.' });
      }
    });
  });

  $('#addConvenioModal').on('hidden.bs.modal',resetForm);
});
</script>
