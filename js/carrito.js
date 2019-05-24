$(document).ready(function () {
    SubTotal = parseFloat($('#SubTotal').text());
    $('#Total').text(SubTotal + 20);
});

$('.t_envio').change(function (e) { 
    e.preventDefault();
    SubTotal = parseFloat($('#SubTotal').text());
    if($(this).val() == 2) {
        $('#Total').text($('#SubTotal').text());
    } else {
        $('#Total').text(SubTotal + 20);
    }
});

$('.eliminar').click(function (e) {
    e.preventDefault();
    Id = $(this).attr('data-id');
    tr = $(this).closest('tr');
    
    alertify.confirm("¿Esta seguro de eliminar el producto del carrito?",
    function(){
        tr.remove();
        $('#SubTotal').text($('tr').length - 1);

        $.ajax({
            type: "POST",
            url: "php/carrito/eliminar.php",
            data: {
                Id: Id
            },
            success: function (response) {
                location.reload();
            }
        });
    },
    function(){
        Swal.fire({
            position: 'top-end',
            type: 'error',
            title: 'No se elimino el producto',
            showConfirmButton: false,
            timer: 1500
        })
    });
});

function CambiarCant(Id, Cantidad) {
    $.ajax({
        type: "POST",
        url: "php/carrito/modificar.php",
        data: {
            Id: Id,
            Cantidad: Cantidad
        },
        success: function (response) {
            $('#SubTotal').text('S/. ' + response);
            location.reload();
        }
    });
}

// Cambiar la Cantidad
$('.Cantidad').change(function (e) {
    e.preventDefault();
    var Cantidad = $(this).val();
    var Id = $(this).attr('data-id');

    if (Cantidad.length == 0 || Cantidad == 0) {
        Cantidad = 1;
        $(this).val(Cantidad);
    }

    $.ajax({
        type: "POST",
        url: "php/carrito/stock.php",
        data: { Id: Id },
        success: function (response) { 
            var stock = parseInt(response);
            if(stock < Cantidad) {
                alertify.alert('No hay Stock', 'Por favor ingrese una cantidad inferior o igual a: ' + stock);
                CambiarCant(Id, stock);
            } else {
                CambiarCant(Id, Cantidad);
            }
        }
    });
});

$('#PagoCredito').click(function (e) { 
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "php/credito.php",
        data: {total: $('#Total').text()},
        success: function (response) {
            if(response == 0) {
                alertify.alert("Monto de credito insuficiente");
            } else {
                SubTotal = $('#SubTotal').text();
                Total = $('#Total').text();

                if(SubTotal == Total) {
                    envio = 1;
                } else {
                    envio = 2;
                }

                $.ajax({
                    type: "POST",
                    url: "php/set_venta.php",
                    data: {envio: envio, tipopago: 2},
                    success: function (response) {
                        if(response == 0) {
                            alertify.alert("Carrito de compras vacio");
                        } else {
                            alertify.alert("Compra concluida con éxito", function(){
                                location.reload();
                            });
                        }
                    }
                });
            }
        }
    });
});