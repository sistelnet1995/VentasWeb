$(document).ready(function(){
    var producto = $('#producto').val();
    var Categoria = $('#Categoria').val();
    var SubCategoria = $('#SubCategoria').val();
    var precio_min = $('#precio_min').val();
    var precio_max = $('#precio_max').val();

    $('.progress').removeClass('invisible');
    addAEvent();
    $.ajax({
        type: "POST",
        url: "php/catalogo.php",
        data: {producto: producto, Categoria: Categoria, SubCategoria: SubCategoria, precio_min: precio_min, precio_max: precio_max},
        success: function (response) {
            $('#productos').html(response);
            addAEvent();
            $('.progress').addClass('invisible');
        }
    });
});

$('#Filtrar').click(function (e) {
    var producto = $('#producto').val();
    var Categoria = $('#Categoria').val();
    var SubCategoria = $('#SubCategoria').val();
    var precio_min = $('#precio_min').val();
    var precio_max = $('#precio_max').val();
    $('.progress').removeClass('invisible');
    
    $.ajax({
        type: "POST",
        url: "php/catalogo.php",
        data: {producto: producto, Categoria: Categoria, SubCategoria: SubCategoria, precio_min: precio_min, precio_max: precio_max},
        success: function (response) {
            $('#productos').html(response);
            addAEvent();
            $('.progress').addClass('invisible');
        }
    });
});

$('#Limpiar').click(function (e) { 
	e.preventDefault();
	location.reload();
});

function addAEvent() {
    $('.Detalle').unbind();

    $('.Detalle').on('click', function () {
        IdPrecioVenta = $(this).data('id');
        // console.log(IdPrecioVenta);
        $.ajax({
            type: "POST",
            url: "detalle_producto.php",
            data: { IdPrecioVenta: IdPrecioVenta },
            success: function (response) {
                $(location).attr('href', 'detalle_producto.php');
            }
        });
    });
}

$('#Categoria').change(function (e) { 
	e.preventDefault();
	IdCategoria = $(this).val();
	if(IdCategoria !== '') {
		$('#SubCategoria').removeAttr('disabled');
	}
	$('#SubCategoria').find('option').remove().end().append('<option value="" disabled selecte>Seleccione</option>');
	$.ajax({
		type: "POST",
		url: "php/sub_categorias.php",
		data: {IdCategoria: IdCategoria},
		success: function (response) {
			$('#SubCategoria').html(response);
		}
	});
});

