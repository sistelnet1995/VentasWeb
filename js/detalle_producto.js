$('.AgregarCarrito').click(function (e) {
    e.preventDefault();
    $('.progress').removeClass('hide');
    $.ajax({
        type: "POST",
        url: "carrito.php",
        data: {
            Id: $(this).attr('id')
        },
        success: function (response) {
            $('.progress').addClass('hide');
            $('.CantProd').load(' .CantProd');
            Swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Bien. Se agrego al carrito',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
});

$('.AgregarFavorito').click(function (e) {
    e.preventDefault();
    $('.progress').removeClass('hide');
    var IdPrecioVenta = $(this).siblings('.AgregarCarrito').attr('id');
    $.ajax({
        type: "POST",
        url: "php/favorito/set_favorito.php",
        data: {
            IdPrecioVenta: IdPrecioVenta
        },
        success: function (response) {
            $('.progress').addClass('hide');
            if (response == 1)
                alertify.success('Bien. Se agrego a mis favoritos');
        }
    });
});