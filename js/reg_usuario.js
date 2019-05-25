$(document).ready(function () {
    $('select').formSelect();
    $('.modal').modal();
});

$('#ConfUserPass').keyup(function (e) { 
    e.preventDefault();
    var UserPass = $('#UserPass').val();
    var ConfUserPass = $('#ConfUserPass').val();

    if (UserPass != ConfUserPass) {
        console.log(0);
        $('#ConfUserPass').removeClass('valid');
        $('#ConfUserPass').addClass('invalid');
    } else {
        console.log(1);
        $('#ConfUserPass').removeClass('invalid');
        $('#ConfUserPass').addClass('valid');
    }
});

$('.siguiente').click(function (e) { 
    e.preventDefault();
    const Elemt = $(this).parent().parent();
    validar(Elemt);
});

$('.anterior').click(function (e) { 
    e.preventDefault();
    const Elemt = $(this).parent().parent();
    Elemt.hide();
    Elemt.prev().fadeIn().show();
});

function validar(Elemt) {
    var valor = $(Elemt).data('id');

    if(valor == 1) {
        var UserName = $('#UserName').val();
        var Email = $('#Email').val();
        var UserPass = $('#UserPass').val();
        var ConfUserPass = $('#ConfUserPass').val();

        if(UserPass == ConfUserPass && UserPass != '' && UserName != '' && Email != '') {
            Elemt.hide();
            Elemt.next().fadeIn().show();
        } else {
            alertify.error('Completa los campos');
        }
    } else {
        var Departamento = $('#Departamento').val();
        var Provincia = $('#Provincia').val();
        var Distrito = $('#Distrito').val();
        var Direccion = $('#Direccion').val();
        var Longitud = $('#Longitud').val();
        var Latitud = $('#Latitud').val();
        if (Departamento != null && Provincia != null && Distrito != null && Direccion != '' && Longitud != '' && Latitud != '') {
            Elemt.hide();
            Elemt.next().fadeIn().show();
        } else {
            alertify.error('Completa los campos');
        }
    }
}

$('#Departamento').change(function (e) {
    e.preventDefault();
    IdDepartamento = $(this).val();
    // console.log(IdDepartamento);
    $('#Distrito').find('option').remove().end().append('<option value="0">Seleccione</option>');
    $('#Departamento').each(function () {
        $.post("php/provincias.php", {
                IdDepartamento: IdDepartamento
            },
            function (data) {
                $('#Provincia').html(data);
            });
    });
});

$('#Provincia').change(function (e) {
    e.preventDefault();
    $("#Provincia").each(function () {
        IdProvincia = $(this).val();
        $.post("php/distritos.php", {
            IdProvincia: IdProvincia
        }, function (data) {
            $("#Distrito").html(data);
        });
    });
});

$('#Registrar').click(function (e) { 
    e.preventDefault();
    var IdCliente = $('#IdCliente').val();
    var Nombre = $('#Nombre').val();
    var ApellidoP = $('#ApellidoP').val();
    var ApellidoM = $('#ApellidoM').val();
    var Genero = $('#Genero').val();
    var EstadoCivil = $('#EstadoCivil').val();
    var FechaNacimiento = $('#FechaNacimiento').val();

    if (IdCliente != '' && Nombre != '' && ApellidoP != '' && ApellidoM != '' && Genero != null && EstadoCivil != null && FechaNacimiento != '') {
        var Email = $('#Email').val();
        var UserName = $('#UserName').val();
        var UserPass = $('#UserPass').val();
        var Departamento = $('#Departamento').val();
        var Provincia = $('#Provincia').val();
        var Distrito = $('#Distrito').val();
        var Latitud = $('#Latitud').val();
        var Longitud = $('#Longitud').val();
        var Direccion = $('#Direccion').val();
    
        
        $.ajax({
            type: "POST",
            url: "php/set_usuario.php",
            data: {
                Email: Email,
                UserName: UserName,
                UserPass: UserPass,
                Departamento: Departamento,
                Provincia: Provincia,
                Distrito: Distrito,
                Latitud: Latitud,
                Longitud: Longitud,
                IdCliente: IdCliente,
                Nombre: Nombre,
                ApellidoP: ApellidoP,
                ApellidoM: ApellidoM,
                Genero: Genero,
                EstadoCivil: EstadoCivil,
                FechaNacimiento: FechaNacimiento,
                RazonSocial: null,
                Direccion: Direccion
            },
            success: function (response) {
                alertify.alert(response, function(){
                    location.href = 'login.php';
                }); 
            }
        });
    } else {
        alertify.error('Completa los campos');
    }
});