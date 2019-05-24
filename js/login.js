function Autentificacion() {
    var UserName = $('#UserName').val();
    var UserPass = $('#UserPass').val();

    if(UserName === '' || UserPass === '') {
        if(UserName === '') {
            $('#UserName').addClass('invalid');
        }
        if(UserPass === '') {
            $('#UserPass').addClass('invalid');
        }
        alertify.error('Ingrese sus Credenciales');
    } else {
        $.ajax({
            type: "POST",
            url: "php/login.php",
            data: {
                UserName: UserName,
                UserPass: UserPass
            },
            success: function (response) {
                if (response == 0) {
                    alertify.error('Error Datos Incorrectos');
                } else {
                    location.href = 'index.php';
                }
            }
        });
    }
}

$('#Login').click(function (e) {
    e.preventDefault();
    Autentificacion();
});

$("#UserPass").keypress(function(e) {
    if(e.which == 13) {
        Autentificacion();
    }
});