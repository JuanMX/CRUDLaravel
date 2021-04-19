
    <div class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" data-bs-backdrop="static" data-keyboard="false" aria-labelledby="modalCrearUsuario" id="modalCrearUsuario" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title h5" >Nuevo usuario</p>
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                
                <div class="modal-body">
                    <form method="POST" id="formularioCrearUsuarioModal" >
                        @csrf
                        

                        <div class="row">
                            <div class="form-group col-md-12" >
                                <label  class="col-form-label" for="nombreCrear">Nombre del usuario <span title="Campo obligatorio" class="requerido"> * </span></label>
                                <input type="text" class="form-control form-control-md" size="100" maxlength="50" style="width: 100%" name="nombre" id="nombreCrear"  required="true" autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12" >
                                <label  class="col-form-label" for="emailCrear">Correo electrónico <span title="Campo obligatorio" class="requerido"> * </span></label>
                                <input type="text" class="form-control form-control-md" size="100" maxlength="100" style="width: 100%" name="email" id="emailCrear"  required="true" autocomplete="off">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                
                                <label class="col-form-label" for="contraseniaCrear">Contraseña (mínimo 8 caracteres, al menos una mayúscula, al menos una minúscula y al menos un número) <span title="Campo obligatorio" class="requerido"> * </span></label>
                                <input type="password" class="form-control form-control-md" size="100" style="width: 100%" name="contrasenia" id="contraseniaCrear"  required="true" >
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="col-form-label" for="contraseniaConfirmationCrear">Confirme su contraseña <span title="Campo obligatorio" class="requerido"> * </span></label>
                                <input type="password" class="form-control form-control-md" size="100" style="width: 100%" name="contrasenia_confirmation" id="contraseniaConfirmationCrear" required="true" >
                            </div>
                        </div>
                    </form>
                    <label ><small> <span title="Campos obligatorios" class="requerido"> * </span>Campos obligatorios </small></label>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm mt-0" data-bs-dismiss="modal"><i class="far fa-times-circle"></i>&nbsp;Cerrar</button>
                    
                    <button type="submit" class="btn btn-primary btn-sm mt-0" form="formularioCrearUsuarioModal" id="btn_guardarCreacion"><i class="far fa-save"></i> Guardar </button>
                </div>
            </div>
        </div>
    </div>
