<?php

    session_start();

    require 'php/get.php';

    $get = new get();
    $ArrayTiendas = $_SESSION['tiendas'];
    $resultD = $get->getSP("get_Departamentos()");
    $resultG = $get->getSP("get_Generos()");
    $resultEC = $get->getSP("get_EstadosCivil()");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Import Google Icon Font-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.4/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/default.min.css"/>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/reg_usuario.css">

    <!-- Enlazamos Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/logo/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logo/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/logo/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/logo/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    
    <title>uMarket - Registro Usuario</title>
</head>
<body>
    
    <header>
        <nav id="navbar">
            <div class="nav-wrapper light-blue accent-3" >
                <a href="#!" class="brand-logo left"><img class="responsive-img" src="img/logo/logo.png" alt="uMarket"></a>
                <a href="#" data-target="mobile" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="index.php"><i class="material-icons left">home</i>Inicio</a></li>
                    <li><a href="carrito.php"><i class="material-icons left">shopping_cart</i>Carrito<span class="new badge white black-text CantProd" data-badge-caption="">0</span></a></li>
                    <li><a href="catalogo.php"><i class="material-icons left">style</i>Catálogo</a></li>
                    <li><a class="dropdown-trigger" href="#!" data-target="tiendasW"><i class="material-icons left">location_on</i><span id="tienda"><?php echo $_SESSION['tienda']; ?></span><i class="material-icons right">arrow_drop_down</i></a></li>
                    <?php if(!isset($_SESSION['usuario'])) { ?>
                        <li id="Inicio">
                            <a href="login.php"><i class="material-icons left">person</i>Iniciar Sesión</a>
                        </li>
                    <?php } ?>
                </ul>      
            </div>
        </nav>
        <ul class="sidenav" id="mobile">
        <?php
            if(isset($_SESSION['usuario'])) { 
                $ArrayUsuario = $_SESSION['usuario'];
        ?>
            <li>
                <div class="user-view">
                    <div class="background">
                        <img src="img/users/fondo/fondo-default.jpg" class="responsive-img">
                    </div>
                    <a href="#user"><img class="circle responsive-img" src="img/users/user/usuario-default.jpg"/></a>
                    <a href="#name"><span class="white-text name"><?php echo $ArrayUsuario[0]['Nombre']; ?></span></a>
                    <a href="#email"><span class="white-text email"><?php echo $ArrayUsuario[0]['Email']; ?></span></a>
                </div>
            </li>
        <?php }?>
        <li class="ocultar" id="menu"><a href="index.php"><i class="material-icons left">home</i>Inicio</a></li>
        <li class="ocultar"><a href="carrito.php"><i class="material-icons left">shopping_cart</i>Carrito<span class="badge white black-text CantProd" data-badge-caption="">0</span></a></li>
        <li class="ocultar"><a href="catalogo.php"><i class="material-icons left">style</i>Catálogo</a></li>
        <li class="ocultar"><a class="dropdown-trigger" href="#!" data-target="tiendasM"><i class="material-icons left">location_on</i><span id="tienda"><?php echo $_SESSION['tienda']; ?></span><i class="material-icons right">arrow_drop_down</i></a></li>
        <?php if(isset($_SESSION['usuario'])) { ?>
            <li><a href="#" class="Cerrar"><i class="material-icons left">power_settings_new</i>Cerrar Sesión</a></li>
            <li class="ocultar"><div class="divider"></div></li>
            <li><a class="subheader">Cuenta de Credito: S/. <?php echo number_format($ArrayUsuario[0]['MontoCredito'],2); ?></a></li>
            <li><a class="subheader">Puntos Bontos Ac.: <?php echo $ArrayUsuario[0]['Bonos']; ?> (PB)</a></li>
            <?php } else { ?>
            <li id="Inicio">
                <a href="login.php"><i class="material-icons left">person</i>Iniciar Sesión</a>
            </li>
        <?php } ?>
        </ul>

        <ul id="usuario" class="dropdown-content">
            <li><a class="Cerrar">Cerrar Sesión</a></li>  
        </ul>

        <ul id="tiendasW" class="dropdown-content">
            <?php for ($i=1; $i < count($ArrayTiendas); $i++) { ?>
                <li><a href="#" class="tiendas"><?php echo $ArrayTiendas[$i]['NombreTienda']; ?></a></li>
            <?php } ?>
        </ul>

        <ul id="tiendasM" class="dropdown-content">
            <?php for ($i=1; $i < count($ArrayTiendas); $i++) { ?>
                <li><a href="#" class="tiendas"><?php echo $ArrayTiendas[$i]['NombreTienda']; ?></a></li>
            <?php } ?>
        </ul>

        <?php if(isset($_SESSION['usuario'])) { ?>
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large red">
                    <i class="large material-icons">account_circle</i>
                </a>
                <ul>
                    <li><a href="#" data-target="mobile" class="btn-floating sidenav-trigger blue tooltipped" id="user" data-position="left" data-tooltip="Mi Perfil"><i class="fas fa-user"></i></a></li>
                    <li><a href="favoritos.php" class="btn-floating red darken-1 tooltipped" data-position="left" data-tooltip="Mis Favoritos"><i class="fas fa-heart"></i></a></li>
                    <li><a href="compras.php" class="btn-floating green tooltipped" data-position="left" data-tooltip="Mis Compras"><i class="fas fa-clipboard-list"></i></a></li>
                    <li><a href="canjes.php" class="btn-floating cyan tooltipped" data-position="left" data-tooltip="Mis Canjes"><i class="fas fa-gift"></i></a></li>
                </ul>
            </div>
        <?php } ?>
        
    </header>

    <main class="container mt-5">
        <div class="row">
            <div class="col s12 m10 offset-m1">
                <div class="card" data-id="1">
                    <div class="card-content">
                        <blockquote><h5 class="font-weight-bold light-blue-text uppercase">Datos Usuario</h5></blockquote>
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="UserName" type="text" class="validate">
                                    <label for="UserName">Usuario</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="Email" type="email" class="validate">
                                    <label for="Email">Email</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="UserPass" type="password" class="validate">
                                    <label for="UserPass">Contraseña</label>   
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="ConfUserPass" type="password">
                                    <label for="ConfUserPass">Confirmar Contraseña</label>
                                    <span class="helper-text" data-error="Las contraseñas no coinciden" data-success="Contraseña confirmada"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button class="waves-effect waves-light btn blue siguiente">Siguiente</button>
                    </div>
                </div>
                <div class="card" data-id="2">
                    <div class="card-content">
                        <blockquote><h5 class="font-weight-bold light-blue-text uppercase">Ubicación</h5></blockquote>
                        <div class="row">
                            <div class="col s12 m6">
                                <label>Departamento</label>  
                                <select class="browser-default" name="Departamento" id="Departamento">
                                    <option value="" disabled selected>Seleccione</option>
                                    <?php while ($rowD = $resultD->fetch_assoc()) { ?>
                                        <option value="<?php echo $rowD['IdDepartamento']; ?>">
                                            <?php echo $rowD['Departamento']; ?>
                                        </option>
                                    <?php } ?>
                                </select>      
                            </div>
                            <div class="col s12 m6">
                                <label>Provincia</label>  
                                <select class="browser-default" name="Provincia" id="Provincia">
                                    <option value="" disabled selected>Seleccione</option>
                                </select>      
                            </div>
                            <div class="col s12 m6">
                                <label>Distrito</label>  
                                <select class="browser-default" name="Distrito" id="Distrito">
                                    <option value="" disabled selected>Seleccione</option>
                                </select>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="Direccion" type="text" class="validate">
                                    <label for="Direccion">Dirección</label>   
                                </div>
                            </div>
                            <div class="col s12">
                                <div class="row">
                                    <div class="col s12 center">
                                        <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Ubicar Longitud y Latitud</a>
                                        <div id="modal1" class="modal">
                                            <div class="modal-content">
                                                <h4>Indique su domicilio en el mapa</h4>
                                                <div id="map" style="height: 300px;"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col m6">
                                        <div class="input-field">
                                            <input name="Longitud" id="Longitud" type="text" placeholder="Longitud" readonly>
                                            <label for="Longitud">Longitud</label>   
                                        </div>   
                                    </div>
                                    <div class="col m6">
                                        <div class="input-field">
                                            <input name="Latitud" id="Latitud" type="text" placeholder="Latitud" readonly>
                                            <label for="Latitud">Latitud</label> 
                                        </div>      
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button class="waves-effect waves-light btn blue anterior">Anterior</button>
                        <button class="waves-effect waves-light btn blue siguiente">Siguiente</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <blockquote><h5 class="font-weight-bold light-blue-text uppercase">Datos Personales</h5></blockquote>
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="IdCliente" type="text" class="validate">
                                    <label for="IdCliente">DNI</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="Nombre" type="text" class="validate">
                                    <label for="Nombre">Nombres</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="ApellidoP" type="text" class="validate">
                                    <label for="ApellidoP">Apellido Paterno</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="ApellidoM" type="text" class="validate">
                                    <label for="ApellidoM">Apellido Materno</label>
                                </div>
                            </div>
                            <div class="col s12 m6">
                                <label>Estado Civil</label>  
                                <select class="browser-default" id="EstadoCivil" class="validate">
                                    <option value="" disabled selected>Seleccione</option>
                                    <?php while ($rowEC = $resultEC->fetch_assoc()) { ?>
                                        <option value="<?php echo $rowEC['IdEstadoCivil']; ?>">
                                            <?php echo $rowEC['EstadoCivil']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col s12 m6">
                                <label>Género</label>  
                                <select class="browser-default" id="Genero" class="validate">
                                    <option value="" disabled selected>Seleccione</option>
                                    <?php while ($rowG = $resultG->fetch_assoc()) { ?>
                                        <option value="<?php echo $rowG['IdGenero']; ?>">
                                            <?php echo $rowG['Genero']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col s12 m6">
                                <div class="input-field">
                                    <input id="FechaNacimiento" type="date" class="validate" placeholder="">
                                    <label for="FechaNacimiento">Fecha Nacimiento</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action center">
                        <button class="waves-effect waves-light btn blue anterior">Anterior</button>
                        <button class="waves-effect waves-light btn green" id="Registrar">Registrarse</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="page-footer light-blue accent-3">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text"><strong>uMarket</strong></h5>
                    <ul>
                        <li><a id="white-text" href=""><i class="fa fa-envelope mr-3"></i> contacto@umarket.com</a></li>
                        <li><a id="white-text" href=""><i class="fa fa-users mr-3"></i> Nuestro equipo</a></li>
                        <li><a id="white-text" href=""><i class="fa fa-bullhorn mr-3"></i> Datos de la compañia</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container"> &copy; 2019 Copyright: Taller de Consultoria</div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.4/dist/sweetalert2.min.js"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/funciones.js"></script>
    <script src="js/reg_usuario.js"></script>
    <script src="js/login.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
    <script src="js/maps.js"></script>
</body>
</html>