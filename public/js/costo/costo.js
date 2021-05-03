$(document).ready( function () {
    
    var maskOptions = {
        mask: Number,  // enable number mask
    
        // other options are optional with defaults below
        scale: 2,  // digits after point, 0 for integers
        signed: false,  // disallow negative
        thousandsSeparator: ',',  // any single char
        padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
        normalizeZeros: false,  // appends or removes zeros at ends
        radix: '.',  // fractional delimiter
        mapToRadix: ['.'],  // symbols to process as radix
    
        // additional number interval options (e.g.)
        min: 0,
        max: 99999.99,
    };

    $.fn.dataTable.ext.errMode = 'none';
    datatableCosto = $('#tablaCosto').DataTable({
        "autoWidth": false,
        "processing": true,
        "responsive": false,
        "serverSide": true,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },  
        "searching": true,       
        "ajax": {
            type: "POST",
            url: "listarCostos",
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
                "width": "1%",
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '',
            },
            {
                "data": "costo",
                render: $.fn.dataTable.render.number( ',', '.', 2, '$ ' ),
            }, {
                "data": "fecha",
                // render: function ( data, type, row ) {
                //     var fechaYhora = data.split(' ');
                //     var dateSplit = fechaYhora[0].split('-');
                //     return type === "display" || type === "filter" ?
                //         dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] + ' / ' + fechaYhora[1]:
                //         data;
                // }
            },{
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
        ],
        "order": [[ 2, "desc" ]],
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
    $('#tablaCosto tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = datatableCosto.row( tr );

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


    ////////////////////////// CREAR COSTO //////////////////////////
    
    var maskCrearCosto = IMask( document.getElementById('costoCrear'), maskOptions);
    var fechaCrear=0;
    $('#btn_nuevoCosto').click(function(event) {

        event.preventDefault();
    
        $('#formularioCrearCostoModal')[0].reset();
        $('#modalCrearCosto').modal('show');
        maskCrearCosto.updateValue();

        $('#fechaCrear').daterangepicker({
            opens: 'left',
            "singleDatePicker": true,
            "showDropdowns": true,
            "timePicker": true,
            parentEl: "#modalCrearCosto .modal-body",
            "locale": {
                "format": "DD-MM-YYYY HH:mm",
                "separator": " - ",
                "applyLabel": "Aceptar",
                "cancelLabel": "Cancelar",
                "fromLabel": "De",
                "toLabel": "A",
                "customRangeLabel": "Custom",
                "weekLabel": "Sem",
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Deciembre"
                ],
                "firstDay": 7,
            },
            }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD HH:mm:ss') + ' to ' + end.format('YYYY-MM-DD HH:mm:ss'));
            console.log(fechaCrear = start.format('YYYY-MM-DD HH:mm:ss'));
        });
       
    });


    $('#formularioCrearCostoModal').on('submit', function(e){

        e.preventDefault();
    
        formDataCrearCosto = new FormData($('#formularioCrearCostoModal')[0]);

        if(fechaCrear!=0){
            formDataCrearCosto.set('fecha', fechaCrear);
        }
        else{
            // console.log("fecha editar " + $('#fechaEditar').val());
            // console.log("Otra forma de formatear "+moment($('#fechaEditar').val(), 'DD-MM-YYYY HH:mm').format('YYYY-MM-DD HH:mm:ss'));
            
            formDataCrearCosto.set('fecha', moment( $('#fechaCrear').val(), 'DD-MM-YYYY HH:mm').format('YYYY-MM-DD HH:mm:ss'));
        }

        formDataCrearCosto.set('costo', maskCrearCosto.masked.number);
    
        $.ajax({
            url: 'crearCosto',
            type: 'POST',
            dataType: 'json',
            data: formDataCrearCosto,
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
                                        
                $('#tablaCosto').DataTable().ajax.reload(null, false);
                $('#modalCrearCosto').modal('hide');
                $('#formularioCrearCostoModal')[0].reset();                                    
                    
                
            } else {
                muestraErrores(response, '');
            }
        })
        .fail(function(response) {
            mensajeOcurrioIncidente();
        });
    });


    ////////////////////////// EDITAR COSTO //////////////////////////

    var maskEditarCosto = IMask( document.getElementById('costoEditar'), maskOptions);
    var fechaEditar=0;
    $('#tablaCosto tbody').off('click', 'button.btn-editar');
    $('#tablaCosto tbody').on('click', 'button.btn-editar', function(event) {
        event.preventDefault();
        
        $('#formularioEditarCostoModal')[0].reset();
        $('#modalEditarCosto').modal('show');

        var currentRow = $(this).closest("tr");
        var data = $('#tablaCosto').DataTable().row(currentRow).data();

        maskEditarCosto.unmaskedValue = data['costo'];
        $('#costoEditar').val(maskEditarCosto.value);
        $('#fechaEditar').val(data['fecha']);
        $('#descripcionEditar').val(data['descripcion']);
        $('#idEditar').val(data['id']);

        $('#fechaEditar').daterangepicker({
            opens: 'left',
            "singleDatePicker": true,
            "showDropdowns": true,
            "timePicker": true,
            parentEl: "#modalEditarCosto .modal-body",
            "locale": {
                "format": "DD-MM-YYYY HH:mm",
                "separator": " - ",
                "applyLabel": "Aceptar",
                "cancelLabel": "Cancelar",
                "fromLabel": "De",
                "toLabel": "A",
                "customRangeLabel": "Custom",
                "weekLabel": "Sem",
                "daysOfWeek": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Deciembre"
                ],
                "firstDay": 7,
            },
            }, function(start, end, label) {
            // console.log("A new date selection was made: " + start.format('YYYY-MM-DD HH:mm:ss') + ' to ' + end.format('YYYY-MM-DD HH:mm:ss'));
            fechaEditar= start.format('YYYY-MM-DD HH:mm:ss');
            console.log(fechaEditar);
        });
    });


    $('#formularioEditarCostoModal').on('submit', function(e){
        e.preventDefault();
        
        formDataEditarCosto = new FormData($('#formularioEditarCostoModal')[0]);

        if(fechaEditar!=0){
            formDataEditarCosto.set('fecha', fechaEditar);
        }
        else{
            // console.log("fecha editar " + $('#fechaEditar').val());
            // console.log("Otra forma de formatear "+moment($('#fechaEditar').val(), 'DD-MM-YYYY HH:mm').format('YYYY-MM-DD HH:mm:ss'));
            
            formDataEditarCosto.set('fecha', moment( $('#fechaEditar').val(), 'DD-MM-YYYY HH:mm').format('YYYY-MM-DD HH:mm:ss'));
        }
        
        formDataEditarCosto.set('costo', maskEditarCosto.masked.number);
    
        $.ajax({
            url: 'editarCosto',
            type: 'POST',
            dataType: 'json',
            data: formDataEditarCosto,
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
                    
                $('#tablaCosto').DataTable().ajax.reload(null, false);
                $('#modalEditarCosto').modal('hide');
                $('#formularioEditarCostoModal')[0].reset();
                
            } else {
                muestraErrores(response, '');
            }
        })
        .fail(function() {
            mensajeOcurrioIncidente();
        });
    });


    ////////////////////////// BLOQUEAR COSTO //////////////////////////

    $('#tablaCosto tbody').off('click', 'button.btn-bloquear');
    $('#tablaCosto tbody').on('click', 'button.btn-bloquear', function(event) {
        
        var me=$(this),
        id=me.attr('value');
        Swal.fire({
            title: '¿Desea continuar?',
            text: "El costo será bloqueado",
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
                        url: 'bloquearCosto',
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
                $('#tablaCosto').DataTable().ajax.reload(null, false);
                mensajeToast("El costo se bloqueó exitosamente");
            } else {
                muestraErrores(data.value, '');
            }
        });
    });


    ////////////////////////// DESBLOQUEAR COSTO //////////////////////////
    $('#tablaCostotbody').off('click', 'button.btn-desbloquear');
    $('#tablaCosto tbody').on('click', 'button.btn-desbloquear', function(event) {
        
        var me=$(this),
        id=me.attr('value');
        Swal.fire({
            title: '¿Desea continuar?',
            text: "El costo será desbloqueado",
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
                        url: 'desbloquearCosto',
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
                $('#tablaCosto').DataTable().ajax.reload(null, false);
                mensajeToast("El costo se desbloqueó exitosamente");
            } else {
                muestraErrores(data.vlaue, '');
            }
        });
    });


    ////////////////////////// ELIMINAR COSTO //////////////////////////
    $('#tablaCosto tbody').off('click', 'button.btn-eliminar');
    $('#tablaCosto tbody').on('click', 'button.btn-eliminar', function(event) {
        
        var me=$(this),
        id=me.attr('value');
        Swal.fire({
            title: '¿Desea continuar?',
            text: "El costo será eliminado",
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
                        url: 'eliminarCosto',
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
                $('#tablaCosto').DataTable().ajax.reload(null, false);
            } else {
                muestraErrores(data.value, '');
            }
        });
    });

    
} );