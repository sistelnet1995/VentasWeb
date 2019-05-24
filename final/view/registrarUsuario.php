<?php

    session_start();

    if(isset($_SESSION['usuario'])) {
        
    } else {
        $_SESSION['usuario'] = null;
    }
    require '../php/get.php';
    $get = new get();
    $resultD = $get->getSP("get_Departamentos()");
    $resultG = $get->getSP("get_Generos()");
    $resultEC = $get->getSP("get_EstadosCivil()");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../include/head.php'; ?>
    <title><?php echo $_SESSION['Sistema'] . 'Registrarse'; ?></title>
</head>

<body>
    <?php include '../include/header.php'; ?>

    <div class="container col-md-5 mt-5">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_user" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Datos Usuario</h5>
                        <hr>
                        <div class="form-group">
                            <label for="UserName">Usuario</label>
                            <input type="text" name="UserName" id="UserName" class="form-control text-lowercase" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" name="Email" id="Email" class="form-control text-lowercase" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="UserPass">Contraseña</label>
                            <input type="password" name="UserPass" id="UserPass" class="form-control" placeholder="Contraseña">
                        </div>
                        <div class="form-group">
                            <label for="ConfUserPass">Confirmar Contraseña</label>
                            <input type="password" name="ConfUserPass" id="ConfUserPass" class="form-control" placeholder="Confirmar Contraseña">
                            <div class="valid-feedback">Contraseña confirmada</div>
                            <div class="invalid-feedback">Las contraseñas no coinciden</div>
                        </div>
                        <ul class="nav nav-tabs d-flex justify-content-center" role="tablist">
                            <li class="nav-item"></li>
                                <a class="nav-link disabled" id="user" data-toggle="tab" href="#tab_location" role="tab">Siguente</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_location" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Ubicación</h5>
                        <hr>
                        <div class="form-group">
                            <label for="Departamento">Departamento</label>
                            <select name="Departamento" id="Departamento" class="custom-select">
                                <option value="0">Seleccione</option>
                                <?php while ($rowD = $resultD->fetch_assoc()) { ?>
                                    <option value="<?php echo $rowD['IdDepartamento']; ?>">
                                        <?php echo $rowD['Departamento']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Provincia">Provincia</label>
                            <select name="Provincia" id="Provincia" class="custom-select">
                                <option value="0" Enabled="true">Seleccione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Distrito">Distrito</label>
                            <select name="Distrito" id="Distrito" class="custom-select">
                                <option value="0" Enabled="true">Seleccione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Direccion">Dirección</label>
                            <input type="text" name="Direccion" id="Direccion" class="form-control text-capitalize" placeholder="Dirección">
                        </div>
                        <div class="form-group">
                            <label>Ubicación</label>
                            <div class="d-flex flex-wrap justify-content-between">
                                <input type="text" name="Longitud" id="Longitud" class="form-control mb-3 col-md-3" readonly>
                                <input type="text" name="Latitud" id="Latitud" class="form-control mb-3 col-md-3" readonly>
                                <a href="#" class="btn btn-primary mb-3 col-md-4" data-toggle="modal" data-target="#mapsModalCenter"><i
                                        class="fas fa-map-marker-alt"></i> Seleccionar</a>
                                <div class="modal fade" id="mapsModalCenter" tabindex="-1" role="dialog"
                                    aria-labelledby="mapsModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="mapsModalCenterTitle">Seleccione su
                                                    domicilio en el mapa</h5>
                                                <button type="button" class="close cerrar" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="map" style="width: 100%; height: 300px;"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary cerrar" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-tabs d-flex justify-content-center" role="tablist">
                            <li class="nav-item"></li>
                                <a class="nav-link disabled" id="location" data-toggle="tab" href="#tab_person" role="tab">Siguente</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab_person" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Datos Personales</h5>
                        <hr>
                        <div class="form-group">
                            <label for="TipoUsuario">Tipo Usuario</label>
                            <select name="TipoUsuario" id="TipoUsuario" class="custom-select is-valid">
                                <option value="1" Enabled="true">Persona</option>
                                <option value="2">Empresa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="IdCliente" id="lId">DNI</label>
                            <input type="num" name="IdCliente" id="IdCliente" class="form-control" placeholder="DNI"
                                require="true">
                        </div>
                        <div class="form-group" id="gRazonSocial">
                            <label for="RazonSocial">Razón Social</label>
                            <input type="text" name="RazonSocial" id="RazonSocial" class="form-control text-capitalize" placeholder="Razón Social">
                        </div>
                        <div class="form-group">
                            <label for="ApellidoP">Apellido Paterno</label>
                            <input type="text" name="ApellidoP" id="ApellidoP" class="form-control text-capitalize" placeholder="Apellido Paterno">
                        </div>
                        <div class="form-group">
                            <label for="ApellidoM">Apellido Materno</label>
                            <input type="text" name="ApellidoM" id="ApellidoM" class="form-control text-capitalize" placeholder="Apellido Materno">
                        </div>
                        <div class="form-group">
                            <label for="Nombre">Nombres</label>
                            <input type="text" name="Nombre" id="Nombre" class="form-control text-capitalize" placeholder="Nombres">
                        </div>
                        <div class="form-group">
                            <label for="FechaNacimiento">Fecha Nacimiento</label>
                            <input type="date" name="FechaNacimiento" id="FechaNacimiento" class="form-control"
                                placeholder="Fecha Nacimiento">
                        </div>
                        <div class="form-group">
                            <label for="EstadoCivil">Estado Civil</label>
                            <select name="EstadoCivil" id="EstadoCivil" class="custom-select">
                                <option value="0">Seleccione</option>
                                <?php while ($rowEC = $resultEC->fetch_assoc()) { ?>
                                    <option value="<?php echo $rowEC['IdEstadoCivil']; ?>">
                                        <?php echo $rowEC['EstadoCivil']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Genero">Genero</label>
                            <select name="Genero" id="Genero" class="custom-select">
                                <option value="0">Seleccione</option>
                                <?php while ($rowG = $resultG->fetch_assoc()) { ?>
                                    <option value="<?php echo $rowG['IdGenero']; ?>">
                                        <?php echo $rowG['Genero']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success RegistrarUsuario disabled" id="person">Registrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <?php include '../include/footer.php'; ?>
    <?php include '../include/script.php'; ?>
    <script src="../js/maps.js"></script>
    <script src="../js/usuario.js"></script>
    <script src="../js/ubigeo.js"></script>
    <!-- <script>
        

        $('#ConfUserPass').keyup(function (e) {
            if($('#UserPass').val() != $('#ConfUserPass').val()) {
                $('#ConfUserPass').addClass('is-invalid');
            } else {
                $('#ConfUserPass').removeClass('is-invalid');
            }
        });

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
            var ArrayUsuario =[Email, UserName, UserPass, Departamento, Provincia, Distrito, Latitud,
               Longitud, IdCliente, Nombre, ApellidoP, ApellidoM, Genero, EstadoCivil,
               FechaNacimiento, RazonSocial, Direccion];
            var ArrayInput =['#Email', '#UserName', '#UserPass', '#Departamento', '#Provincia', '#Distrito', '#Latitud',
                '#Longitud', '#IdCliente', '#Nombre', '#ApellidoP', '#ApellidoM', '#Genero', '#EstadoCivil',
                '#FechaNacimiento', '#Direccion'];
            

            if(Email === '' || UserName === '' || UserPass === '' || Departamento === 0 || Provincia === 0 || Distrito === 0 || Latitud === '' ||
               Longitud === '' || IdCliente === '' || Nombre === '' || ApellidoP === '' || ApellidoM === '' || Genero === 0 || EstadoCivil === 0 ||
               FechaNacimiento === '' || Direccion=== '') {
                   for(var i = 0; i < ArrayUsuario.length; i++) {
                       if(ArrayUsuario[i] === '' || ArrayUsuario[i] === 0) {
                        $(ArrayInput[i]).addClass('is-invalid');
                       }
                   }
                alertify.error('Complete los Campos');
                
            } else {
                if(!$('#ConfUserPass').hasClass('is-invalid')) {
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
            }            
        });
    
    </script> -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
</body>

</html>