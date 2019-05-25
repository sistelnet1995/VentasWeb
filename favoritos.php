<?php
    session_start();

    if(!isset($_SESSION['usuario'])) {
        header("Location: login.php");
    } else {

        require 'php/get.php';
        $get = new get();
        $ArrayTiendas = $_SESSION['tiendas'];
        $IdCliente = $_SESSION['usuario'][0]['IdCliente'];
        $result = $get->getSP("get_ListaDeseoxIdCliente('$IdCliente')");
        
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

    <!-- Enlazamos Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/logo/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logo/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/logo/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/logo/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>uMarket - Mis Favoritos</title>
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

    <main class="container">
        <div class="row">
            <div class="card-panel">
                <blockquote><h5 class="light-blue-text font-weight-bold uppercase">Mis Favoritos</h5></blockquote>
                <div class="progress hide" id="PreloaderV">
                    <div class="indeterminate"></div>
                </div>
                <div class="row">
                    <?php while ($row = $result->fetch_assoc()) {
                        $IdPrecioVenta = $row['FkIdPrecioVenta'];
                        $resultDP = $get->getSP("get_ProductosDeseoxIdPrecioVenta('$IdPrecioVenta')");
                        while ($row = $resultDP->fetch_assoc()){
                    ?>
                        <div class="col s10 m4 l3 offset-s1">
                            <div class="card hoverable medium">
                                <div class="card-image">
                                    <img src="<?php echo $row['Imagen']; ?>" class="materialboxed img-card">
                                </div>
                                <div class="card-stacked center">
                                    <div class="card-content">
                                        <a href="" class="card-title detalle_prod">
                                            <?php echo $row['Producto']; ?>
                                            <span class="IdPrecioVenta" hidden><?php echo $row['IdPrecioVenta'] ?></span>
                                        </a>
                                    </div>
                                    <div class="card-action">
                                        <p class="font-weight-bold">
                                            S/. 
                                            <?php
                                                $ArrayPrec = explode(",", $row['Precios']);
                                                echo number_format($ArrayPrec[0],2); 
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }} $result->free_result(); ?>
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
    <script src="js/favoritos.js"></script>    
</body>
</html>

<?php } ?>