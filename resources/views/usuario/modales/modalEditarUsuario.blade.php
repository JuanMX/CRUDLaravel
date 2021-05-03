
    <div class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" data-bs-backdrop="static" data-keyboard="false" aria-labelledby="modalEditarUsuario" id="modalEditarUsuario" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title h5" >Editar usuario</p>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <form method="POST" id="formularioEditarUsuarioModal" >
                        @csrf
                        
                        <input type="hidden" name="idEditar" id="idEditar" value="">
                        {{--
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label  class="col-form-label" for="nombreUsuarioEditar">Nombre del usuario<span title="Campo obligatorio" class="requerido"> * </span></label>
                                <input type="text" class="form-control form-control-md" size="100" maxlength="50" style="width: 100%" name="nombreUsuario" id="nombreUsuarioEditar"  required="true" autocomplete="off">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label  class="col-form-label" for="emailEditar">Correo electrónico<span title="Campo obligatorio" class="requerido"> * </span></label>
                                <input type="text" class="form-control form-control-md" size="100" maxlength="100" style="width: 100%" name="email" id="emailEditar"  required="true" autocomplete="off">
                            </div>
                        </div>
                        --}}
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label  class="col-form-label" for="nickEditar">Nick<span title="Campo obligatorio" class="requerido"> * </span></label>
                                <input type="text" class="form-control form-control-md" size="100" maxlength="50" style="width: 100%" name="nick" id="nickEditar"  required="true" autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label  class="col-form-label" for="rolEditar">Rol del usuario <span title="Campo obligatorio" class="requerido"> * </span></label>

                                <select class="form-control form-control-md form-select" style="width: 100%" name="rol" required="true" id="rolEditar" >
                                    <option value="ROL_BASICO">Rol básico</option>
                                    <option value="ROL_ADMINISTRADOR">Rol administrador</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label  class="col-form-label" for="generoEditar">Género<span title="Campo obligatorio" class="requerido"> * </span></label>

                                <select class="form-control form-control-md form-select" style="width: 100%" name="genero" required="true" id="generoEditar" >
                                    <option value="MASCULINO">Masculino</option>
                                    <option value="FEMENINO">Femenino</option>
                                    <option value="OTRO">Otro</option>
                                </select>
                            </div>
                        </div>
                        
                    </form>
                    <br>
                    <label ><small> <span title="Campos obligatorios" class="requerido"> * </span>Campos obligatorios </small></label>
                    <label ><small> <span> * </span>No se cambia la contraseña porque debería ser en una sección aparte </small></label>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm mt-0" data-bs-dismiss="modal"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-sm mt-0" form="formularioEditarUsuarioModal" id="btn_guardarEdicion"><i class="far fa-save"></i> Guardar </button>
                </div>
            </div>
        </div>
    </div>
