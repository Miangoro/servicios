<div class="modal fade" id="agregarEmpresa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h4 class="modal-title text-white" id="agregarEmpresaLabel">Registrar Nueva Empresa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form id="formAgregarContacto" class="row g-5" onsubmit="return false">

          <span>INFORMACION DEL CLIENTE</span>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressCodigoCliente" name="modalAddressCodigoCliente" class="form-control" placeholder=" " />
              <label for="modalAddressCodigoCliente">Codigo Cliente</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressRazonSocial" name="modalAddressRazonSocial" class="form-control" placeholder=" " />
              <label for="modalAddressRazonSocial">Razón Social (Nombre de la empresa o Cliente)</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressRFC" name="modalAddressRFC" class="form-control" placeholder=" " />
              <label for="modalAddressRFC">RFC</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <select id="modalAddressRegimen" name="modalAddressRegimen" class="select2 form-select" data-allow-clear="true">
                <option value="">Selecciona un Regímen</option>
                <option value="Australia">Australia</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Belarus">Belarus</option>
                <option value="Brazil">Brazil</option>
                <option value="Canada">Canada</option>
                <option value="China">China</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Japan">Japan</option>
                <option value="Korea">Korea, Republic of</option>
                <option value="Mexico">Mexico</option>
                <option value="Philippines">Philippines</option>
                <option value="Russia">Russian Federation</option>
                <option value="South Africa">South Africa</option>
                <option value="Thailand">Thailand</option>
                <option value="Turkey">Turkey</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
              </select>
              <label for="modalAddressRegimen">Régimen Fiscal</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <select id="modalAddressCredito" name="modalAddressCredito" class="select2 form-select" data-allow-clear="true">
                <option value="">Selecciona una Opción</option>
                <option value="">Con Crédito</option>
                <option value="Australia">Sin Crédito</option>
                
              </select>
              <label for="modalAddressCredito">Crédito</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressEstado" name="modalAddressEstado" class="form-control" placeholder=" " />
              <label for="modalAddressEstado">Estado</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressCiudad" name="modalAddressCiudad" class="form-control" placeholder=" " />
              <label for="modalAddressCiudad">Ciudad</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressLocalidad" name="modalAddressLocalidad" class="form-control" placeholder=" " />
              <label for="modalAddressLocalidad">Localidad</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressCalle" name="modalAddressCalle" class="form-control" placeholder=" " />
              <label for="modalAddressCalle">Calle</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressNo" name="modalAddressNo" class="form-control" placeholder=" # " />
              <label for="modalAddressNo">No</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressColonia" name="modalAddressColonia" class="form-control" placeholder=" " />
              <label for="modalAddressColonia">Colonia</label>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressCodigo" name="modalAddressCodigo" class="form-control" placeholder=" " />
              <label for="modalAddressCodigo">Código Postal</label>
            </div>
          </div>
          
          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressTelefono" name="modalAddressTelefono" class="form-control" placeholder=" " />
              <label for="modalAddressTelefono">Teléfono</label>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="text" id="modalAddressCorreo" name="modalAddressCorreo" class="form-control" placeholder=" " />
              <label for="modalAddressCorreo">Correo</label>
            </div>
          </div>
        <span>DOCUMENTOS</span>
        <div class="col-12 col-md-4">
            <div class="form-floating form-floating-outline">
              <input type="file" id="modalAddressConstancia" name="modalAddressConstancia" class="form-control" placeholder=" " />
              <label for="modalAddressConstancia">Constancia de situación fiscal</label>
            </div>
          </div>

                    <div class="col-12 text-end mt-4">

                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ri-add-line"></i> Agregar Contacto
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