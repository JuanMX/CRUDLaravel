$(document).ready( function () {
    $.fn.dataTable.ext.errMode = 'none';
    datatableUsuario = $('#tablaUsuario').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },  
        "searching": true,       
        "ajax": {
            type: "POST",
            url: "listarUsuarios",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json'
        },
        fail: function (data) {
            console.log(data);
        },
        done: function (data)
        {
            console.log(data);
        },
        "columns": [
            {
                "data": "nick",
            }, {
                "data": "rol",
                render: function ( data, type, row ) {

                    if (data=='ROL_ADMINISTRADOR'){
                        return '<span class="badge badge-primary">Administrador<span>';
                    }
                    if (data=='ROL_BASICO'){
                        return '<span class="badge badge-secondary">Básico<span>';
                    }
                }
            }, {
                "data": "genero",
                render: function ( data, type, row ) {

                    if (data=='MASCULINO'){
                        return 'Masculino';
                    }
                    else if (data=='FEMENINO'){
                        return 'Femenino';
                    }
                    else {
                        return 'Otro';
                    }
                }
            }, {
                "data": "id",
                "orderable": false,
                render: function ( data, type, row ) {
                    if(row.bloqueado){
                        return `<button type="button" class="btn btn-sm btn-primary btn-editar" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fa fa-edit" aria-hidden="true"></i></button>&nbsp;
                            <button type="button" class="btn btn-sm btn-warning btn-desbloquear" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Desbloquear"><i class="fa fa-unlock" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-sm btn-danger btn-eliminar" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Eliminar "><i class="fa fa-trash" aria-hidden="true"></i></button>`;
                    }
                    else{
                        return `<button type="button" class="btn btn-sm btn-primary btn-editar" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="fa fa-edit" aria-hidden="true"></i></button>&nbsp;
                            <button type="button" class="btn btn-sm btn-warning btn-bloquear" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Bloquear"><i class="fa fa-lock" aria-hidden="true"></i></button>
                            <button type="button" class="btn btn-sm btn-danger btn-eliminar" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>`;
                    }
                    
                }
            }
        ]
    }).on('error.dt', function(e, settings, techNote, message) {
        
        if (typeof techNote === 'undefined') {

        } else {
            // Se imprime este error en consola, para no mostrar al usuario
            console.error(message);
        }
        return true;
    });


    ////////////////////////// CREAR USUARIO //////////////////////////
    
    $('#btn_nuevoUsuario').click(function(event) {

        event.preventDefault();
    
        $('#formularioCrearUsuarioModal')[0].reset();
        $('#modalCrearUsuario').modal('show');
    });

    $('#formularioCrearUsuarioModal').on('submit', function(e){

        e.preventDefault();
    
        formDataCrearUsuarioModal = new FormData($('#formularioCrearUsuarioModal')[0]);
    
        $.ajax({
            url: 'crearUsuario',
            type: 'POST',
            dataType: 'json',
            data: formDataCrearUsuarioModal,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            beforeSend: function() {
                
                $('#btn_guardarCreacion').prop('disabled',true);
                $('#btn_guardarCreacion').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Guardando...');
            }
        })
        .always(function() {
            
            $('#btn_guardarCreacion').prop('disabled',false);
            $('#btn_guardarCreacion').html('<i class="far fa-save"></i> Guardar');
        })
        .done(function(response) {
            if(response.success) {
                                        
                $('#tablaUsuario').DataTable().ajax.reload(null, false);
                $('#modalCrearUsuario').modal('hide');
                $('#formularioCrearUsuarioModal')[0].reset();                                    
                    
                
            } else {
                muestraErrores(response, '');
            }
        })
        .fail(function(response) {
            mensajeOcurrioIncidente();
        });
    });



    ////////////////////////// EDITAR USUARIO //////////////////////////

    $('#tablaUsuario tbody').off('click', 'button.btn-editar');
    $('#tablaUsuario tbody').on('click', 'button.btn-editar', function(event) {
        event.preventDefault();
        
        $('#formularioEditarUsuarioModal')[0].reset();
        $('#modalEditarUsuario').modal('show');

        var currentRow = $(this).closest("tr");
        var data = $('#tablaUsuario').DataTable().row(currentRow).data();

        // $('#nombreUsuarioEditar').val(data['name']);
        // $('#emailEditar').val(data['email']);
        $('#nickEditar').val(data['nick']);
        $('#rolEditar').val(data['rol']);
        $('#generoEditar').val(data['genero']);
        $('#idEditar').val(data['id']);
    });

    $('#formularioEditarUsuarioModal').on('submit', function(e){
        e.preventDefault();
        
        formularioDatos = new FormData();
        // formularioDatos.append("nombre", $('#nombreUsuarioEditar').val());
        // formularioDatos.append("email", $('#emailEditar').val());
        formularioDatos.append("nick", $('#nickEditar').val());
        formularioDatos.append("rol", $('#rolEditar').val());
        formularioDatos.append("genero", $('#generoEditar').val());
        formularioDatos.append("_token", $("#_token").val());
        formularioDatos.append("id", $("#idEditar").val());
    
        $.ajax({
            url: 'editarUsuario',
            type: 'POST',
            dataType: 'json',
            data: formularioDatos,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            beforeSend: function() {
                
                $('#btn_guardarEdicion').prop('disabled',true);
                $('#btn_guardarEdicion').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Guardando...');
                
            }
        })
        .always(function() {
            
            $('#btn_guardarEdicion').prop('disabled',false);
            $('#btn_guardarEdicion').html('<i class="far fa-save"></i> Guardar');
        })
        .done(function(response) {
            if(response.success) {
                    
                $('#tablaUsuario').DataTable().ajax.reload(null, false);
                $('#modalEditarUsuario').modal('hide');
                $('#formularioEditarUsuarioModal')[0].reset();
                
            } else {
                muestraErrores(response, '');
            }
        })
        .fail(function() {
            mensajeOcurrioIncidente();
        });
    });

    
    ////////////////////////// BLOQUEAR USUARIO //////////////////////////
    $('#tablaUsuario tbody').off('click', 'button.btn-bloquear');
    $('#tablaUsuario tbody').on('click', 'button.btn-bloquear', function(event) {
        
        var me=$(this),
        id=me.attr('value');
        Swal.fire({
            title: '¿Desea continuar?',
            text: "El usuario será bloqueado",
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            confirmButtonColor: '#28A745',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            reverseButtons: true,
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: 'bloquearUsuario',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token:  $("#_token").val(),
                            id: id
                        }
                    }).done(function(data) {
                        resolve(data);
                    }).fail(function() {
                        mensajeOcurrioIncidente();
                    });
                });
            }
        }).then(function(data) {
            if (data.value.success) {
                $('#tablaUsuario').DataTable().ajax.reload(null, false);
                mensajeToast("El usuario se bloqueó exitosamente");
            } else {
                muestraErrores(data.value, '');
            }
        });
    });


    ////////////////////////// DESBLOQUEAR USUARIO //////////////////////////
    $('#tablaUsuario tbody').off('click', 'button.btn-desbloquear');
    $('#tablaUsuario tbody').on('click', 'button.btn-desbloquear', function(event) {
        
        var me=$(this),
        id=me.attr('value');
        Swal.fire({
            title: '¿Desea continuar?',
            text: "El usuario será desbloqueado",
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            confirmButtonColor: '#28A745',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            reverseButtons: true,
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: 'desbloquearUsuario',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token:  $("#_token").val(),
                            id: id
                        }
                    }).done(function(data) {
                        resolve(data);
                    }).fail(function() {
                        mensajeOcurrioIncidente();
                    });
                });
            }
        }).then(function(data) {
            if (data.value.success) {
                $('#tablaUsuario').DataTable().ajax.reload(null, false);
                mensajeToast("El usuario se desbloqueó exitosamente");
            } else {
                muestraErrores(data.vlaue, '');
            }
        });
    });


    ////////////////////////// ELIMINAR USUARIO //////////////////////////
    $('#tablaUsuario tbody').off('click', 'button.btn-eliminar');
    $('#tablaUsuario tbody').on('click', 'button.btn-eliminar', function(event) {
        
        var me=$(this),
        id=me.attr('value');
        Swal.fire({
            title: '¿Desea continuar?',
            text: "El usuario será eliminado",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Confirmar',
            confirmButtonColor: '#28A745',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            reverseButtons: true,
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: 'eliminarUsuario',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            _token:  $("#_token").val(),
                            id: id
                        }
                    }).done(function(data) {
                        resolve(data);
                    }).fail(function() {
                        mensajeOcurrioIncidente();
                    });
                });
            }
        }).then(function(data) {
            if (data.value.success) {
                $('#tablaUsuario').DataTable().ajax.reload(null, false);
            } else {
                muestraErrores(data.value, '');
            }
        });
    });
} );