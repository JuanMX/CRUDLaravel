function muestraErrores(data, url = '') {
    var html = '';
    $.each(data.error, function(index, val) {
        html += `<li>${val}</li>`;
    });
    Swal.fire({
        icon: 'info',
        html: html,
        confirmButtonText: `Aceptar`
    }).then(function() {
        if(url !== '') {
            location.href = url;    
        }
    });
}

function mensajeOcurrioIncidente() {
    swal.fire({
        title: 'Ocurrió un incidente',
        text: "Intente de nuevo más tarde",
        icon: 'warning',
        allowOutsideClick: false,
        confirmButtonText: 'Aceptar',
    });
}

function mensajeToast(data){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        icon: 'success',
        title: `${data}`,
    });
}