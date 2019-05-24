$(document).ready(function () {
    setInterval(function(){
        $('.CantProd').load('../php/carrito/cantProd.php');
    }, 1000);
    inicio();
});

function Autentificacion() {
    var UserName = $('#UserName').val();
    var UserPass = $('#UserPass').val();

    if(UserName === '' || UserPass === '') {
        if(UserName === '') {
            $('#UserName').addClass('is-invalid');
        }
        if(UserPass === '') {
            $('#UserPass').addClass('is-invalid');
        }
        alertify.error('Ingrese sus Credenciales');
    } else {
        $.ajax({
            type: "POST",
            url: "../php/login.php",
            data: {
                UserName: UserName,
                UserPass: UserPass
            },
            success: function (response) {
                if (response === 0) {
                    alertify.error('Error Datos Incorrectos');
                } else {
                    location.href = 'index.php';
                }
            }
        });
    }
}
$('#UserName').keydown(function (e) { 
    $(this).removeClass('is-invalid');
});
$('#UserPass').keydown(function (e) { 
    $(this).removeClass('is-invalid');
});


function inicio() {

    // Validad la cantidad de productos canje
    $('#cantCP').change(function (e) { 
        e.preventDefault();
        var cantCP = $('#cantCP').val();
        if (cantCP < 1){
            $('#cantCP').val(1);
        }
    });

    $('.Canjear').click(function (e) { 
        e.preventDefault();
        var BonosPN = $('#BonosPN').text();
        var cantCP = $('#cantCP').val();
        var IdProd = $(this).attr('id');

        $.ajax({
            type: "POST",
            url: "../php/canjear.php",
            data: { BonosPN: BonosPN, cantCP: cantCP, IdProd: IdProd },
            success: function (response) {
                alertify.alert(response, function(){
                    location.reload();
                });
            }
        });
    });
    
    // Ocultar LoadPage
    $('.loadPage').fadeOut('slow');

    // Detecta la tecla Enter
    $("#UserPass").keypress(function(e) {
        if(e.which == 13) {
            Autentificacion();
        }
    });

    $(document).bind("contextmenu",function(e){
        return false;
    });

    var user = $('#usuario').text();
    
    if (user != 0) {
        $('.sidenav').sidenav();
    }

    $('.sidenav-trigger').click(function (e) {
        $('.sidenav').addClass('true');
    });

    // AutoComplete de buscar por nombre

    $('#NombreProducto').typeahead({
        source: function(Producto, resultado) {
            $.ajax({
                type: "POST",
                url: "../php/autoComplete.php",
                data: {Producto: Producto, NomTienda: $('#NomTienda').text()},
                dataType: "json",
                success: function (response) {
                    resultado($.map(response, function (item) {
                        return item;
                    }));
                }
            });
        }
    });
    

    // Boton Cambiar Tienda
    $('.btnTienda').click(function () {
        var Tienda = $(this).text();
        $.ajax({
            type: "POST",
            url: "../php/Tienda.php",
            data: {
                Tienda: Tienda
            },
            success: function (response) {
                if (response == 1)
                    location.reload();
            }
        });
    });


    // Botón Agregar Carrito

    $('.btnAgregar').click(function () {
        $.ajax({
            type: "POST",
            url: "carrito.php",
            data: {
                Id: $(this).attr('id')
            },
            success: function (response) {
                alertify.success('Bien. Se agrego al carrito');
                $('.CantProd').load(' .CantProd');
            }
        });
    });

    // Botón Favorito

    $('.btnFavorito').click(function () {
        var IdUsuario = $('#usuario').text();
        var IdProducto = $(this).siblings('.btnAgregar').attr('id');
        if ($.isNumeric(IdUsuario)) {
            if ($(this).children('i').hasClass('far fa-star')) {
                $(this).children('i').removeClass('far fa-star');
                $(this).children('i').addClass('fas fa-star');

                $.ajax({
                    type: "POST",
                    url: "../php/deseos/insDeseos.php",
                    data: {
                        IdUsuario: IdUsuario,
                        IdProducto: IdProducto
                    },
                    success: function (response) {
                        if (response == 1)
                            alertify.success('Bien. Se agrego a productos deseados');
                    }
                });
            } else {
                $(this).children('i').removeClass('fas fa-star');
                $(this).children('i').addClass('far fa-star');

                $.ajax({
                    type: "POST",
                    url: "../php/deseos/eliDeseos.php",
                    data: {
                        IdUsuario: IdUsuario,
                        IdProducto: IdProducto
                    },
                    success: function (response) {
                        if (response == 1)
                            alertify.warning('Bien. Se elimino de productos deseados');
                    }
                });
            }
        } else {
            alertify.error('Error. Debe iniciar sesión');
        }
    });

    // Fin

    // Eliminar Favorito

    $('.btnFavoritoEli').click(function () {
        var IdUsuario = $('#usuario').text();
        var IdProducto = $(this).siblings('.btnAgregar').attr('id');

        $.ajax({
            type: "POST",
            url: "../php/deseos/eliDeseos.php",
            data: {
                IdUsuario: IdUsuario,
                IdProducto: IdProducto
            },
            success: function (response) {
                if (response == 1)
                    location.reload();
            }
        });
    });

    // Fin

    // Eliminar Producto del Carrito
    $('.eliminar').click(function (e) {
        e.preventDefault();
        var Id = $(this).attr('data-id');
        var tr = $(this).closest('tr');
        
        alertify.confirm("¿Esta seguro de eliminar el producto del carrito?",
        function(){
            tr.remove();
            $('#SubTotal').text($('tr').length - 1);

            $.ajax({
                type: "POST",
                url: "../php/carrito/eliminarProdCar.php",
                data: {
                    Id: Id
                },
                success: function (response) {
                    location.reload();
                }
            });
        },
        function(){
            alertify.error('Cancelado');
        });
    });

    // Fin

    function CambiarCant(Id, Cantidad, Precio) {
        $.ajax({
            type: "POST",
            url: "../php/carrito/modificarDatCar.php",
            data: {
                Id: Id,
                Cantidad: Cantidad,
                Precio: Precio
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
        var Precio = $(this).attr('data-precio');

        if (Cantidad.length == 0 || Cantidad == 0) {
            Cantidad = 1;
            $(this).val(Cantidad);
        }

        $.ajax({
            type: "POST",
            url: "../php/carrito/comprobarStock.php",
            data: { Id: Id },
            success: function (response) { 
                var stock = parseInt(response);
                if(stock < Cantidad) {
                    alertify.alert('No hay Stock', 'Por favor ingrese una cantidad inferior o igual a: ' + stock);
                    CambiarCant(Id, stock, Precio);
                } else {
                    CambiarCant(Id, Cantidad, Precio);
                }
            }
        });
    });

    // Fin

    // Iniciar Sesión

    $('#Login').click(function (e) {
        e.preventDefault();
        Autentificacion();
    });

    // Fin

    // Cerrar Sesión

    $('#Cerrar').click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../php/CerrarSesion.php",
            data: {
                Session: 'Session'
            },
            success: function (response) {
                location.href = 'index.php';
            }
        });
    });

    // Fin

    // Validación solo números

    $('.number').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g,'');
    });
    // Fin

    // Rellenar SubCategoria
    $('#Categoria').change(function (e) { 
        e.preventDefault();
        IdCategoria = $(this).val();
        $('#SubCategoria').find('option').remove().end().append('<option value="0">Seleccione</option>');
        $('#Categoria').each(function () {
            $.post("../php/getSubCategoria.php", {
                IdCategoria: IdCategoria
            },
            function (data) {
                $('#SubCategoria').html(data);
            });
        });
    });
    // Fin

    $('#cTienda').click(function (e) { 
        e.preventDefault();
        $('#Delivery').addClass('d-none');
        $('#Tienda').removeClass('d-none');
    });

    $('#cDelivery').click(function (e) { 
        e.preventDefault();
        $('#Tienda').addClass('d-none');
        $('#Delivery').removeClass('d-none');
    });

    // Cambiar Direccion de entrega

    $('#GuardarCambios').click(function (e) { 
        e.preventDefault();
        var sDireccion = $('#Direccion').val();
        var sDepartamento = $('select[name="Departamento"] option:selected').text();
        var sProvincia = $('select[name="Provincia"] option:selected').text();
        var sDistrito = $('select[name="Distrito"] option:selected').text();
        var sLongitud = $('#Longitud').val();
        var sLatitud = $('#Latitud').val();


        $('#lblDireccion').html(sDireccion);
        $('#lblDistrito').html(sDistrito);
        $('#lblProvincia').html(sProvincia);
        $('#lblDepartamento').html(sDepartamento);
        $('#lblLongitud').html(sLongitud);
        $('#lblLatitud').html(sLatitud);
    });

    // Enviamos el IdVenta a la vista Detalle Compra
    $('.VerMas').click(function (e) { 
        e.preventDefault();
        var IdVenta = $(this).children('.IdVenta').text();
        $.ajax({
            type: "POST",
            url: "detallesCompra.php",
            data: { IdVenta: IdVenta },
            success: function (response) {
                $(location).attr('href', 'detallesCompra.php');
            }
        });
    });

    // Envia el IdVenta para cancelar la venta
    $('.btnEstadoCompra').click(function (e) { 
        e.preventDefault();
        if(!$(this).hasClass('disabled')) {
            var IdVenta = $(this).children('.IdVenta').text();
            var EstadoEntrega = $(this).children('.EstadoEntrega').text();

            alertify.confirm("¿Esta seguro de cancelar su compra?",
            function(){
                $.ajax({
                    type: "POST",
                    url: "../php/CancelarVenta.php",
                    data: { IdVenta: IdVenta, EstadoEntrega: EstadoEntrega },
                    success: function (response) {
                        alertify.alert(response, function(){
                            location.reload();
                        });
                    }
                });
            },
            function(){
                alertify.error('Cancelado');
            });
        }
    });

    // Enviamos el IdProducto a la vista Detalle Producto
    $('.DetalleProd').click(function (e) { 
        e.preventDefault();
        var IdProd = $(this).children('.IdProd').text();
        $.ajax({
            type: "POST",
            url: "detallesProducto.php",
            data: { IdProd: IdProd },
            success: function (response) {
                $(location).attr('href', 'detallesProducto.php');
            }
        });
    });

    $('.CanjeB').click(function (e) { 
        e.preventDefault();
        var IdProd = $(this).children('.IdProd').text();
        $.ajax({
            type: "POST",
            url: "canjeBonus.php",
            data: { IdProd: IdProd },
            success: function (response) {
                $(location).attr('href', 'canjeBonus.php');
            }
        });
    });

    $('#PagoCredito').click(function (e) { 
        e.preventDefault();
        var MontoCredito = $('#MontoCredito').text();
        var PagoRe = $('#PagoRe').text();
        if(MontoCredito >= PagoRe) {
            if ($('#Tienda').hasClass('d-none')) {
                // Delivery
                var TipoEntrega = 2;
                var DireccionUbigeo = $('#DireccionC').text().split(', ');            
                var Coordenada = $('#CoordenadaC').text().split(', ');
                var CostoAdicional = 15;
                
            } else{
                // Tienda
                var TipoEntrega = 1;
                var DireccionUbigeo = $('#DireccionT').text().split(', ');
                var Coordenada = $('#CoordenadaT').text().split(', ');
                var CostoAdicional = 0;
        
            }
        
            var Direccion = DireccionUbigeo[0];
            var Departamento = DireccionUbigeo[1];
            var Provincia = DireccionUbigeo[2];
            var Distrito = DireccionUbigeo[3];
            var Longitud = Coordenada[0];
            var Latitud = Coordenada[1];
            var IdTipoPago = 2;
        
            $.ajax({
                type: "POST",
                url: "../php/insVenta.php",
                data: {
                    IdTipoPago: IdTipoPago,
                    IdCliente: $('#IdCliente').text(),
                    TipoEntrega: TipoEntrega,
                    Direccion: Direccion,
                    Distrito: Distrito,
                    Provincia: Provincia,
                    Departamento: Departamento,
                    Longitud: Longitud,
                    Latitud: Latitud,
                    CostoAdicional: CostoAdicional
                },
                success: function (response) {
                    if(response == 1) {
                        alertify.alert("Compra concluida con éxito", function(){
                            location.reload();
                        });
                    } else {
                        alertify.alert("Carrito de compras vacio");
                    }
                }
            });
        } else {
            alertify.alert("No cuentas con suficiente crédito");
        }
    });
}