// Render the PayPal button into #paypal-button-container
paypal.Buttons({

    // Set up the transaction
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: $('#TotalPago').text()
                }
            }]
        });
    },

    // Finalize the transaction
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            alertify.alert("Compra concluida con éxito", function(){
                ComprarAhora();
                location.reload();
            });
           
            // Call your server to save the transaction
            return fetch('/paypal-transaction-complete', {
                method: 'post',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify({
                    orderID: data.orderID
                })
            });
        });
    }

}).render('#paypal-button-container');


// Funcion para comprar
function ComprarAhora() {
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
    var IdTipoPago = 4;

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
        }
    });
}