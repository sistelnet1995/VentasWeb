$(document).ready(function () {
    $('.carousel.carousel-slider').carousel({ fullWidth: true });
    function autoplay() { $('.carousel').carousel('next'); }
    setInterval(autoplay, 4500);
    if($(window).width() > 992) {
        $('.carousel').css('margin-top', '-6px');
    }
});

$('.detalle_prod_Banner').click(function (e) { 
    e.preventDefault();
    $('#PreloaderBanner').removeClass('hide');
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