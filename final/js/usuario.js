$(document).ready(function () {
    $('#UserName').focus();
    var valid = 0;
    var cliente = $('#TipoUsuario').val();
    TipoCliente(cliente);
});

function validar_input(IdInput, Tab) {
    var IdInput = '#' + IdInput;
    var IdTab = '#' + Tab;
    var input = $(IdInput).val();
    if(IdInput == '#Email') {
        var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
        if(input === '' || caract.test(input) == false) {
            $(IdInput).removeClass('is-valid');
            $(IdInput).addClass('is-invalid');
            valid = 0;
        } else {
            $(IdInput).removeClass('is-invalid');
            $(IdInput).addClass('is-valid');
            valid = 1;
        }
    } else {
        if(input === '' || input == 0) {
            $(IdInput).removeClass('is-valid');
            $(IdInput).addClass('is-invalid');
            valid = 0;
        } else {
            if(IdInput == '#ConfUserPass' || IdInput == '#UserPass') {
                if(IdInput == '#UserPass'){
                    $(IdInput).removeClass('is-invalid');
                    $(IdInput).addClass('is-valid');
                    valid = 1;
                }
                if($('#UserPass').val() != $('#ConfUserPass').val()) {
                    $('#ConfUserPass').removeClass('is-valid');
                    $('#ConfUserPass').addClass('is-invalid');
                    valid = 0;
                } else {
                    $('#ConfUserPass').removeClass('is-invalid');
                    $('#ConfUserPass').addClass('is-valid');
                    valid = 1;
                }
            } else {
                $(IdInput).removeClass('is-invalid');
                $(IdInput).addClass('is-valid');
                valid = 1;
            }
        }
    }

    
    if(Tab == 'Departamento' || Tab == 'Provincia' || Tab == 'Distrito' || Tab == 'EstadoCivil' || Tab == 'Genero') {
        $('#tab_' + Tab +' option').each(function(){
            if($('option:selected', this).hasClass('is-valid')){
                $(IdTab).removeClass('disabled');
                alert('rem');
            } else {
                $(IdTab).addClass('disabled');
                alert('an');
            }
        });
    } else {
        $('#tab_' + Tab +' input').each(function(){
            if($(this).hasClass('is-valid')){
                $(IdTab).removeClass('disabled');
            } else {
                $(IdTab).addClass('disabled');
            }
        });
    }
}

// Validación de campos de usuario

$('#UserName').blur(function() {
    validar_input('UserName', 'user');
});

$('#Email').blur(function() {
    validar_input('Email', 'user');
});

$('#UserPass').blur(function() {
    validar_input('UserPass', 'user');
});

$('#ConfUserPass').blur(function() {
    validar_input('ConfUserPass', 'user');
});

// Validación de campos Ubicación

$('#Departamento').blur(function() {
    validar_input('Departamento', 'location');
});

$('#Provincia').blur(function() {
    validar_input('Provincia', 'location');
});

$('#Distrito').blur(function() {
    validar_input('Distrito', 'location');
});

$('#Direccion').blur(function() {
    validar_input('Direccion', 'location');
});

$('.cerrar').click(function (e) { 
    validar_input('Longitud', 'location');
    validar_input('Latitud', 'location'); 
});

// Validación de campos datos personales

function TipoCliente(cliente) {
    if(cliente == 2) {
        $('#RazonSocial').blur(function() {
            validar_input('RazonSocial', 'person');
        });
    } else {
        $('#RazonSocial').removeClass('is-invalid');
        $('#RazonSocial').addClass('is-valid');
    }

    $('#IdCliente').blur(function() {
        validar_input('IdCliente', 'person');
    });

    $('#RazonSocial').blur(function() {
        validar_input('RazonSocial', 'person');
    });

    $('#ApellidoP').blur(function() {
        validar_input('ApellidoP', 'person');
    });

    $('#ApellidoM').blur(function() {
        validar_input('ApellidoM', 'person');
    });

    $('#Nombre').blur(function() {
        validar_input('Nombre', 'person');
    });

    $('#FechaNacimiento').blur(function() {
        validar_input('FechaNacimiento', 'person');
    });

    $('#EstadoCivil').blur(function() {
        validar_input('EstadoCivil', 'person');
    });

    $('#Genero').blur(function() {
        validar_input('Genero', 'person');
    });
}

TipoUsuario();

$('#TipoUsuario').change(function (e) { 
    e.preventDefault();
    TipoUsuario();
    if($('#TipoUsuario option:selected').val() == 2) {
        $('#RazonSocial').removeClass('is-valid');
    } else {
        $('#RazonSocial').removeClass('is-invalid');
        $('#RazonSocial').addClass('is-valid');
    }
});

function TipoUsuario() {
    var TipoUsuario = $("#TipoUsuario option:selected").val();
    if (TipoUsuario == 1) {
        $('#lId').text('DNI');
        $('#IdCliente').attr('placeholder', 'DNI');
        $("#gRazonSocial").css("display", "none");
    } else {
        $('#lId').text('RUC');
        $('#IdCliente').attr('placeholder', 'RUC');
        $("#gRazonSocial").css("display", "block");
    }
};

$('.RegistrarUsuario').click(function (e) { 
    e.preventDefault();
    var Email = $('#Email').val();
    var UserName = $('#UserName').val();
    var UserPass = $('#UserPass').val();
    var ConfUserPass = $('#ConfUserPass').val();
    var Departamento = $('#Departamento').val();
    var Provincia = $('#Provincia').val();
    var Distrito = $('#Distrito').val();
    var Latitud = $('#Latitud').val();
    var Longitud = $('#Longitud').val();
    var IdCliente = $('#IdCliente').val();
    var Nombre = $('#Nombre').val();
    var ApellidoP = $('#ApellidoP').val();
    var ApellidoM = $('#ApellidoM').val();
    var Genero = $('#Genero').val();
    var EstadoCivil = $('#EstadoCivil').val();
    var FechaNacimiento = $('#FechaNacimiento').val();
    var RazonSocial = $('#RazonSocial').val();
    var Direccion = $('#Direccion').val();
    

    if(Email === '' || UserName === '' || UserPass === '' || Departamento == 0 || Provincia == 0 || Distrito == 0 || Latitud === '' ||
       Longitud === '' || IdCliente === '' || Nombre === '' || ApellidoP === '' || ApellidoM === '' || Genero == 0 || EstadoCivil == 0 ||
       FechaNacimiento === '' || Direccion=== '') {
        alert('com');
        alertify.error('Complete los Campos');
        
    } else {
        $.ajax({
            type: "POST",
            url: "../php/insUsuarioCliente.php",
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
                RazonSocial: RazonSocial,
                Direccion: Direccion
            },
            success: function (response) {
                alertify.alert(response, function(){
                    location.href = 'login.php';
                }); 
            }
        });
    }            
});