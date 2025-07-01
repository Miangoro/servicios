<!-- Add New Address Modal -->
<div class="modal fade" id="editCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0">
          <div class="text-center mb-6">
            <h4 class="address-title mb-2">Editar cliente</h4>
             <!-- <p class="address-subtitle">Convertir a cliente confirmado del Organismo Certificador</p> -->
          </div>
          <form id="editClienteForm" class="row g-5" onsubmit="return false">
            
            <input name="id_empresa" type="hidden" id="empresaID">
            <input type="hidden" id="edit_id_guia" name="id_guia">
            <input name="id" type="hidden" id="edit_id">
            

            <div class="col-12">
              <div class="form-floating form-floating-outline">
                  <input type="text" id="numero_cliente" name="numero_cliente" class="form-control" placeholder="Número de Cliente" />
                  <label for="numero_cliente">Número de cliente para la norma NOM-070-SCFI-2016</label>
              </div>
          </div>
            
            <div class="col-12">
              <div class="form-floating form-floating-outline">
                <select id="id_contacto" name="id_contacto" class="select2 form-select" data-allow-clear="true">
                 @foreach ($usuarios as $usuario)
                   <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                 @endforeach
                </select>
                <label for="id_contacto">Persona de contacto CIDAM</label>
              </div>
            </div>
          
            <hr class="my-6">
            <h5 class="mb-5">Información para el contrato</h5>
  
            <div class="col-md-6 col-sm-12">
              <div class="form-floating form-floating-outline">
                <input type="date" id="modalAddressAddress1" name="fecha_cedula" class="form-control" placeholder="12, Business Park" />
                <label for="modalAddressAddress1">Fecha de Cédula de Identificación Fiscal</label>
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressAddress2" name="idcif" class="form-control" placeholder="Mall Road" />
                <label for="modalAddressAddress2">idCIF del Servicio deAdministración Tributaria</label>
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
              <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressLandmark" name="clave_ine" class="form-control" placeholder="Nr. Hard Rock Cafe" />
                <label for="modalAddressLandmark">Clave de elector del INE</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating form-floating-outline">
                <select id="modalAddressCountry" name="sociedad_mercantil" class="select2 form-select" data-allow-clear="true">
                  <option value="">Selecciona la opción</option>
                  <option value="Sociedad de responsabilidad limitada">Sociedad de responsabilidad limitada</option>
                  <option value="Sociedad por acciones simplificada">Sociedad por acciones simplificada</option>
                  <option value="Sociedad anónima promotora de inversión (SAPI)">Sociedad anónima promotora de inversión (SAPI)</option>
                  <option value="Sociedad anónima promotora de inversión de capital variable (SAPI de CV)">Sociedad anónima promotora de inversión de capital variable (SAPI de CV)</option>
                  <option value="Sociedad anónima de capital variable (empresa SA de CV)">Sociedad anónima de capital variable (empresa SA de CV)</option>
                </select>
                <label for="modalAddressCountry">Sociedad mercantil</label>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressCity" name="num_instrumento" class="form-control" placeholder="Los Angeles" />
                <label for="modalAddressCity">Número de instrumento público</label>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-floating form-floating-outline">
                <input type="text" id="modalAddressState" name="vol_instrumento" class="form-control" placeholder="California" />
                <label for="modalAddressLandmark">Volúmen de instrumento público</label>
              </div>
            </div>
            <div class="col-12 col-md-4">
              <div class="form-floating form-floating-outline">
                <input type="date" name="fecha_instrumento" class="form-control" placeholder="99950" />
                <label for="modalAddressZipCode">Fecha instrumento público</label>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" name="nombre_notario" class="form-control" placeholder="99950" />
                <label for="modalAddressZipCode">Nombre del notario público</label>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text"name="num_notario" class="form-control" placeholder="99950" />
                <label for="modalAddressZipCode">Número de notario público</label>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text"name="estado_notario" class="form-control" placeholder="99950" />
                <label for="modalAddressZipCode">Estado del notario público</label>
              </div>
            </div>
  
            <div class="col-12 col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" name="num_permiso" class="form-control" placeholder="99950" />
                <label for="modalAddressZipCode">Número de permiso</label>
                <div id="floatingInputHelp" class="form-text">(Clave única del documento) emitido por la Secretaria de Economía.</div>
              </div>
            </div>
            
            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
              <button type="submit" class="btn btn-primary">Editar</button>
              <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--/ Add New Address Modal -->
  