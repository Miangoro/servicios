   {{--  modal de edicion equisde --}}
   <div class="modal fade" id="modalAddPredioInspeccion" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-xl">
           <div class="modal-content">
               <div class="modal-header bg-primary pb-4">
                   <h5 class="modal-title text-white">Agregar Inspección del Predio</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body py-8">
                   <form id="addAddPredioInspeccionForm">
                       @csrf
                       <input type="hidden" id="inspeccion_id_predio" name="id_predio" value="">
                       <input type="hidden" id="inspeccion_id_empresa" name="id_empresa">
                       {{--  --}}
                       <!-- Datos del Predio -->

                       <h6 class="mb-4">Datos del Predio</h6>
                       <div class="row">
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control" id="inspeccion_ubicacion_predio"
                                       autocomplete="off" name="ubicacion_predio"
                                       placeholder="Ubicación del predio"></input>
                                   <label for="ubicacion_predio">Ubicación del Predio</label>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control" id="localidad" autocomplete="off"
                                       name="localidad" placeholder="Localidad">
                                   <label for="localidad">Localidad</label>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline">
                                   <input type="text" class="form-control" id="municipio" autocomplete="off"
                                       name="municipio" placeholder="Municipio">
                                   <label for="municipio">Municipio</label>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control" id="distrito" autocomplete="off"
                                       name="distrito" placeholder="Distrito">
                                   <label for="distrito">Distrito</label>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline">
                                   <select class="form-select select2" name="estado" id="estado">
                                       <option value="" disabled selected>Selecciona un estado</option>
                                       @foreach ($estados as $estado)
                                           <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                       @endforeach
                                   </select>
                                   <label for="estado">Estado</label>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control" id="nombreParaje" autocomplete="off"
                                       name="nombre_paraje" placeholder="Nombre del Paraje">
                                   <label for="nombreParaje">Nombre del Paraje</label>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline">
                                   <select class="form-select" id="zonaDom" name="zona_dom" aria-label="Zona DOM">
                                       <option value="" disabled selected>Selecciona una opción</option>
                                       <option value="si">Sí</option>
                                       <option value="no">No</option>
                                   </select>
                                   <label for="zonaDom">Predio en zona DOM</label>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-12">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="file" class="form-control" id="documentoGeo"
                                       name="inspeccion_geo_Doc" value="136">
                                   <label for="inspeccion_geo_Doc">Subir Inspección Geo-referenciación</label>
                               </div>
                           </div>
                       </div>
                       <div class="d-flex justify-content-center mt-3">
                           <button disabled class="btn btn-primary me-2 d-none" type="button" id="btnSpinnerPredioInspeccion">
                               <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                               Registrando...
                           </button>
                           <button type="submit" class="btn btn-primary me-2" id="btnAddPredioInspeccion"><i class="ri-add-line me-1"></i>
                               Registrar</button>
                           <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"><i
                                   class="ri-close-line me-1"></i> Cancelar</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
