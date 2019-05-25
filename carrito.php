<?php

    session_start();

    require 'php/get.php';

    $get = new get();
    $NombreTienda = $_SESSION['tienda'];
    $ArrayTiendas = $_SESSION['tiendas'];

    if(isset($_POST['Id'])) {
        $Id = $_POST['Id'];
        if(isset($_SESSION['carrito'])) {
            $arreglo = $_SESSION['carrito'];
            $encontrado = false;
            $numero = 0;

            for ($i=0; $i < count($arreglo); $i++) { 
                if ($arreglo[$i]['Id'] == $Id) {
                    $encontrado = true;
                    $numero = $i;
                }
            }

            if ($encontrado == false) {
                $resultn = $get->getSP("get_ProductosxIdPrecioVentaxTiendaxTipoVenta('$Id', '$NombreTienda')");
                while($row = $resultn->fetch_array()) {
                    $ArrayPrec = explode(",", $row['Precios']);
                    $datosNuevos = array(
                        'Id' => $Id,
                        'Producto' => $row['Producto'],
                        'Imagen' => $row['Imagen'],
                        'PrecioVenta' => $ArrayPrec[0],
                        'PrecioCompra' => $row['PrecioCompra'],
                        'Bono' => $row['Bonos'],
                        'Cantidad' => 1
                    );
                }
                $resultn->free_result();
                array_push($arreglo, $datosNuevos);
                $_SESSION['carrito'] = $arreglo;
            }
        } else {
            $result = $get->getSP("get_ProductosxIdPrecioVentaxTiendaxTipoVenta('$Id', '$NombreTienda')");
            while($row = $result->fetch_array()) {
                $ArrayPrec = explode(",", $row['Precios']);
                $arreglo[] = array(
                    'Id' => $Id,
                    'Producto' => $row['Producto'],
                    'Imagen' => $row['Imagen'],
                    'PrecioVenta' => $ArrayPrec[0],
                    'PrecioCompra' => $row['PrecioCompra'],
                    'Bono' => $row['Bonos'],
                    'Cantidad' => 1
                );
            }
            $result->free_result();     
            
            $_SESSION['carrito'] = $arreglo;
        }
    } else {
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
    <link rel="stylesheet" href="css/paypal.css">
    <!-- Enlazamos Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/logo/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logo/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/logo/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/logo/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    
    <title>uMarket - Carito de Productos</title>
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
            <div class="col m12">
                <div class="card-panel">
                    <blockquote><h5 class="light-blue-text font-weight-bold uppercase">Tipo de envio</h5></blockquote>
                    <div class="row">
                        <div class="col m6">
                            <label>
                                <input class="with-gap t_envio" name="t_envio" id="t_envio_d" value="1" type="radio" checked/>
                                <span>DESPACHO A DOMICILIO</span>
                            </label>

                            <div>
                                <?php if(isset($_SESSION['usuario'])) { ?>
                                <span>Dirección: </span><label><?php echo $ArrayUsuario[0]['Direccion']; ?></label>
                                <?php } ?>
                            </div>
                            <blockquote>Todos los envios a domicilio genera un costo adicional de S/. 20.00</blockquote>
                        </div>
                        <div class="col m6">
                            <label>
                                
                                <input class="with-gap t_envio" name="t_envio" value="2" type="radio"/>
                                <span>RETIRO EN TIENDA</span>
                            </label>
                            <div>
                                <?php
                                    if(isset($_SESSION['usuario'])) { 
                                        $resultDT = $get->getSP("get_DireccionxNombreTienda('$NombreTienda')");
                                        while ($row = $resultDT->fetch_assoc()){
                                            $direccion = $row['Direccion'];
                                        }
                                        $resultDT->free_result();
                                ?>
                                <span>Dirección: </span><label><?php echo $direccion; ?></label>
                                <?php } ?>
                            </div>
                            <blockquote>Entrega gratis</blockquote>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col m12">
                <div class="card">
                    <div class="card-content black-text">
                        <blockquote><h5 class="light-blue-text font-weight-bold uppercase">Carrito de compras</h5></blockquote>
                        <table class="highlight centered responsive-table">
                            <?php
                                if(isset($_SESSION['carrito'])) {
                                    $datos = $_SESSION['carrito'];
                                    $Subtotal = 0;
                                    ?>
                                    <thead class="">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Imagen</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        for($i = 0; $i <count($datos); $i++) { 
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $i +1 ?></th>
                                            <td><img src="<?php echo $datos[$i]['Imagen']; ?>" style="width: 3rem;" class="responsive-img materialboxed"></td>
                                            <td><p><?php echo $datos[$i]['Producto']; ?></p></td>
                                            <td>
                                                <input type="number" class="Cantidad number" min="1" data-id="<?php echo $datos[$i]['Id']; ?>" value="<?php echo $datos[$i]['Cantidad']; ?>" required>
                                            </td>
                                            <td>
                                                <p class="PrecioV">S/. <?php echo number_format($datos[$i]['PrecioVenta'],2); ?></p>
                                            </td>
                                            <td>
                                                <button class="btn waves-effect waves-light red eliminar" data-id="<?php echo $datos[$i]['Id']; ?>"><i class="material-icons left">remove_shopping_cart</i></button>
                                            </td>
                                        </tr>

                                    <?php
                                        
                                        $Subtotal = $Subtotal + $datos[$i]['Cantidad']* $datos[$i]['PrecioVenta'];
                                    } ?>
                                    </tbody>
                                <?php
                                    } else {
                                        echo '<center><h2>El carrito de compras esta vacio</h2></center>';
                                    }
                                ?>
                        </table>
                        <?php if(isset($_SESSION['carrito'])) { ?>
                        <div class="row">
                            <div class="col s12">
                                <div >
                                    <div class="row">
                                        <div class="col s3 m1 l1 offset-l9 offset-m8 offset-s2">
                                            SubTotal
                                        </div>
                                        <div class="col s5 m3 l2" style="text-align:right">
                                            <b>S/. </b>
                                            <b id="SubTotal" style="font-size: 1.2rem"><?php echo $Subtotal; ?></b><span id="PagoRe" hidden><?php echo $Subtotal; ?></span><span id="TotalPago" hidden><?php echo round($Subtotal * 0.329 ,2); ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s3 m1 l1 offset-l9 offset-m8 offset-s2">
                                            Total
                                        </div>
                                        <div class="col s5 m3 l2 red-text" style="text-align:right">
                                            <b>S/. </b>
                                            <b id="Total" style="font-size: 1.2rem"></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="card-action center">
                        <a href="catalogo.php" class="waves-effect waves-light btn"><i class="fas fa-tags"></i> VER CATÁLOGO</a>
                    </div>
                </div>
            </div>
            <div class="center">
                <?php if(isset($_SESSION['usuario'])) { ?>
                <div id="paypal-button-container"></div>
                <button class="btn waves-effect waves-light blue" id="PagoCredito"><i class="fas fa-credit-card"></i> uMarket</button>
                <?php } else { ?>
                <a href="login.php" class="btn waves-effect waves-light amber">Iniciar Sesión</a>
                <?php } ?>
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
    <script src="https://www.paypal.com/sdk/js?client-id=AZyceNz3mWPNGCkd2NjI3Dx3ul9Y54DgP76nbPn0U3tqFMjfsIBoPjn6wsL9o2XPfZfujqKzpisIL9EM&currency=USD"></script>
    <script src="js/paypal.js"></script>
    <script src="js/carrito.js"></script>
</body>
</html>
<?php } ?>