$(document).ready(function () {
    M.AutoInit();
    if($(window).width() <= 992) {
        $('#user').hide();
    }
    setInterval(function(){ $('.CantProd').load('php/carrito/cantidad.php') }, 1000);
});

$('.Cerrar').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "php/cerrar_sesion.php",
        data: {
            Session: 'Session'
        },
        success: function (response) {
            location.href = 'index.php';
        }
    });
});

$('.tiendas').click(function (e) { 
    e.preventDefault();
    tienda = $(this).text();
    $.ajax({
        type: "POST",
        url: "php/tienda.php",
        data: { tienda: tienda },
        success: function (response) {
            location.reload();
        }
    });
});

$('.detalle_prod').click(function (e) { 
    e.preventDefault();
    $('#PreloaderV').removeClass('hide');
    IdPrecioVenta = $(this).children('.IdPrecioVenta').text();
    $.ajax({
        type: "POST",
        url: "detalle_producto.php",
        data: { IdPrecioVenta: IdPrecioVenta },
        success: function (response) {
            $(location).attr('href', 'detalle_producto.php');
        }
    });
});

$('.number').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g,'');
});

$('.text').on('input', function () {
    this.value = this.value.replace(/[^a-zA-Z]/g,'');
});

$('#user').click(function (e) { 
    e.preventDefault();
    $('.ocultar').hide();
});