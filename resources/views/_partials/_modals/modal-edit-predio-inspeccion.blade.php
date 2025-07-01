   {{--  modal de edicion equisde --}}
   <div class="modal fade" id="modalEditPredioInspeccion" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-xl">
           <div class="modal-content">
               <div class="modal-header bg-primary pb-4">
                   <h5 class="modal-title text-white">Editar inspección del Predio</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body py-8">
                   <form id="EditPredioInspeccionForm">
                       @csrf
                       <input type="hidden" id="edit_inspeccion_id_predio" name="id_predio" value="">
                       <input type="hidden" id="edit_inspeccion_id_empresa" name="id_empresa">
                       {{--  --}}
                       <!-- Datos del Predio -->

                       <h6 class="mb-4">Datos del Predio</h6>
                       <div class="row">
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control" id="edit_inspeccion_ubicacion_predio"
                                       autocomplete="off" name="ubicacion_predio"
                                       placeholder="Ubicación del predio"></input>
                                   <label for="ubicacion_predio">Ubicación del Predio</label>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control" id="edit_localidad" autocomplete="off"
                                       name="localidad" placeholder="Localidad">
                                   <label for="localidad">Localidad</label>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-floating form-floating-outline">
                                   <input type="text" class="form-control" id="edit_municipio" autocomplete="off"
                                       name="municipio" placeholder="Municipio">
                                   <label for="municipio">Municipio</label>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline mb-4">
                                   <input type="text" class="form-control" id="edit_distrito" autocomplete="off"
                                       name="distrito" placeholder="Distrito">
                                   <label for="distrito">Distrito</label>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline">
                                   <select class="form-select select2" name="estado" id="edit_estado">
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
                                   <input type="text" class="form-control" id="edit_nombreParaje" autocomplete="off"
                                       name="nombre_paraje" placeholder="Nombre del Paraje">
                                   <label for="nombreParaje">Nombre del Paraje</label>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-floating form-floating-outline">
                                   <select class="form-select" id="edit_zonaDom" name="zona_dom" aria-label="Zona DOM">
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
                                   <input type="file" class="form-control" id="edit_documentoGeo"
                                       name="inspeccion_geo_Doc" value="136">
                                   <label for="inspeccion_geo_Doc">Subir Inspección Geo-referenciación</label>
                               </div>
                           </div>
                           <div id="url_documento_geo_edit" class="url_documento mb-2">
                           </div>
                       </div>
                       <div class="d-flex justify-content-center mt-3">
                           <button disabled class="btn btn-primary me-2 d-none" type="button"
                               id="btnSpinnerEditPredioInspeccion">
                               <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                               Actualizando...
                           </button>
                           <button type="submit" class="btn btn-primary me-2" id="btnEditInspeccionPredio"><i class="ri-pencil-fill me-1"></i>
                               Editar</button>
                           <button type="reset" class="btn btn-danger" data-bs-dismiss="modal"><i
                                   class="ri-close-line me-1"></i> Cancelar</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>
