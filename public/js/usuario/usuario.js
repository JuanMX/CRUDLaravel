$(document).ready( function () {
    datatableUsuario = $('#tablaUsuario').DataTable({
        "searching": true,       
        "ajax": {
            type: "POST",
            url: "listaUsuario",
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
                "data": "name",
            }, {
                "data": "email",
            },{
                "data": "id",
                "orderable": false,
                render: function ( data, type, row ) {
                    return `<button type="button" class="btn btn-sm btn-primary btn-editar" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Editar usuario"><i class="fa fa-edit" aria-hidden="true"></i></button>&nbsp;
                        <button type="button" class="btn btn-sm btn-warning btn-bloquear" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Inactivar usuario"><i class="fa fa-lock" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-sm btn-danger btn-eliminar" value="${data}" data-toggle="tooltip" data-placement="bottom" title="Eliminar usuario"><i class="fa fa-trash" aria-hidden="true"></i></button>`;   
                }
                
            }
        ]
    });

    // $('#tablaUsuario').DataTable().ajax.reload(null, false);
} );