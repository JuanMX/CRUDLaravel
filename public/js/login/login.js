$(document).ready(function() {

	$('#formLoginUsuario').on('submit', function(event) {
	    event.preventDefault();
        $('#btn_submit').prop('disabled',true);
        $('#btn_submit').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Iniciando sesión...');

        formDataLogin = new FormData($('#formLoginUsuario')[0]);

        $.ajax({
            url: 'loginUsuario',
            type: 'POST',
            dataType: 'json',
            data: formDataLogin,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
        })
        .always(function() {
            $('#btn_submit').prop('disabled',false);
            $('#btn_submit').html('<i class="fas fa-sign-in-alt"></i>&nbsp;Acceder');
        })
        .done(function(response) {
            if(response.success) {
                if(response.data.resetPass){
                    swal.fire({
                        html: '<li>Parece que solictó un cambio de contraseña</li><li>Será redireccionado a restablecerla</li><li>Por seguridad no puede conservar la generada por el sistema</li>',
                        type: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        location.href="cambiaContrasenia/"+response.data.nomUsuario;
                    });
                    
                }
                else{
                    swal.fire({
                        text: 'Bienvenido, espere por favor...',
                        icon: 'success',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        if(result.dismiss === 'timer') {
                            // Redirección a /inicio
                            location.href=response.data.inicio;
                        }
                    });
                }
            } else {
                muestraErrores(response, '');
            }
        })
        .fail(function() {
            mensajeOcurrioIncidente();
        });
	    
	});
});

    
