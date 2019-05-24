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
        data: {envio: envio, tipopago: 4}
    });
}