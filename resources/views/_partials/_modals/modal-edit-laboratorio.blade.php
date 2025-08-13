
<div class="modal fade" id="editLabModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      
      <div class="modal-header bg-primary pb-4">
        <h4 class="modal-title text-white" id="agregarLabLabel">Editar Laboratorio</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-4">
        <form id="editLaboratorio" class="row g-5" >
          @csrf
          @method('PUT')
          <span>Informacipon principal</span>
          <input type="hidden" id="id_laboratorio_modal" name="id_laboratorio">
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="clave_laboratorio_modal" name="clave" class="form-control"/>
              <label for="clave_laboratorio_modal">Clave</label>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="nombre_laboratorio_modal" name="laboratorio" class="form-control"/>
              <label for="nombre_laboratorio_modal">Nombre</label>
            </div>
          </div>
          <div class="mb-4">
              <select id="selectUnidadesEdit" class="form-select data-submit" name="selectUnidadesEdit" data-fvalidate="notEmpty">
                  <option value="">Seleccione una unidad</option>
                </select>
          </div>
           <div class="col-12">
            <span>Descripción</span>
            <input type="hidden" name="descripcion" id="descripcion_laboratorio_modal">
              <div class="form-floating form-floating-outline mb-6">
                  <div id="snow-toolbar-edit">
                            <span class="ql-formats">
                                <select class="ql-font"></select>
                                <select class="ql-size"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-script" value="sub"></button>
                                <button class="ql-script" value="super"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-header" value="1"></button>
                                <button class="ql-header" value="2"></button>
                                <button class="ql-blockquote"></button>
                                <button class="ql-code-block"></button>
                            </span>
                    </div>
                        <div id="snow-editor-edit"></div>
              </div>
          </div>
          
          <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                  <button id="modalEditLabBtn" type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">
                    <i class="ri-save-line"></i> Guardar
                  </button>
                  <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                     <i class="ri-close-line"></i> Cancelar
                  </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>