$(document).ready(function() {
    $.fn.dataTable.ext.errMode = 'none';

    // $('#tablaBitacora tfoot th').each(function() { // cuando los inputs estan abajo de la tabla
    //     var title = $(this).text();
    //     if(title!=""){
    //         $(this).html('<input type="text" maxlength="100" size="13" placeholder="Buscar ' + title + '" />');
    //     }
    // });
    // $('#tablaBitacora thead tr').clone(true).appendTo( '#tablaBitacora thead' );
    // $('#tablaBitacora thead tr:eq(1) th').each( function (i) {
    //     var title = $(this).text();
    //     if(title!="Descripción"){
    //         $(this).html( '<input type="text" maxlength="100" size="13" placeholder="Buscar '+title+'" id="'+title+'" />' );
    //         $(this).css("background-color", "#f0f0f0");
    //     }
    //     else{
    //         $(this).html('');
    //         $(this).css("background-color", "#f0f0f0");
    //     }
 
    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( tableTablaBitacora.column(i).search() !== this.value ) {
    //             tableTablaBitacora
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );
    
    tableTablaBitacora = $('#tablaBitacora').DataTable({
        // orderCellsTop: true,
        // fixedHeader: true,
        // fixedHeader: {
        //     headerOffset: $('#navbarSupportedContent').outerHeight()
        // },
        "serverSide": true,
        // "autoWidth": true,
        "processing": true,
        "searching": true,
        "searchDelay": 1000,
        "language": {
            // "url": "https://lib.morelos.gob.mx/DataTables/Spanish.json",
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Filtrar por acción, tabla o usuario:",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },  
        "ajax": {
            type: "POST",
            url: "bitacoraDataTable",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
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
                "width": "1%",
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            }, {
                "data": "tipoAccion",
            }, {
                "data": "tabla",
            }, {
                "data": "idUsuario",
            }, {
                "data": "ip",
                // "orderable": false,
            }, {
                "data": "created_at",
                render: function ( data, type, row ) {

                    // return moment(data).format('DD-MM-YYYY HH:mm:ss');
                    fecha = new Date(data);
                    return fecha.toLocaleString();
                }
            }, 
        ],
        "order": [[ 5, "desc" ]],
        // initComplete: function() { //cuando los inputs de busqueda se hace en el footer de la tabla
        //     var api = this.api();
        //     // Apply the search
        //     api.columns().every(function() {
        //         var that = this;
        //         $('input', this.footer()).on('keyup change', function() {
        //             if (that.search() !== this.value) {
        //                 that.search(this.value).draw();
        //             }
        //         });
        //     });
        // },
    }).on('error.dt', function(e, settings, techNote, message) {
        if (typeof techNote === 'undefined') {

        } else {
            // Se imprime este error en consola, para no mostrar al usuario
            console.error(message);
        }
        return true;
    });

    /* Formatting function for row details - modify as you need */
    function format ( d ) {
        // `d` is the original data object for the row
        return '<div>'+d.descripcion+'</div>';
    }

    // Add event listener for opening and closing details
    $('#tablaBitacora tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableTablaBitacora.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );

    // $('#btn_limpiaBusqueda').on('click', function(){
    //     $('#tablaBitacora thead tr:eq(0) th').each( function (i) {
    //         var title = $(this).text();
    //         $("#"+title).val("");
    //     } );
    //     tableTablaBitacora.search( '' ).columns().search( '' ).draw();
    // });
});