<?php $ArrayTiendas = $_SESSION['tiendas']; ?>
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
                <?php if(isset($_SESSION['usuario'])) { ?>
                    <li><a class="dropdown-trigger" href="#!" data-target="usuario"><i class="material-icons left">account_circle</i>Bienvenido: <?php echo $_SESSION['usuario'][0]['UserName']; ?><i class="material-icons right">arrow_drop_down</i></a></li>     
                    <?php } else { ?>
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
    <li class="invisible" id="menu"><a href="index.php"><i class="material-icons left">home</i>Inicio</a></li>
    <li class="invisible"><a href="carrito.php"><i class="material-icons left">shopping_cart</i>Carrito<span class="badge white black-text CantProd" data-badge-caption="">0</span></a></li>
    <li class="invisible"><a href="catalogo.php"><i class="material-icons left">style</i>Catálogo</a></li>
    <li class="invisible"><a class="dropdown-trigger" href="#!" data-target="tiendasM"><i class="material-icons left">location_on</i><span id="tienda"><?php echo $_SESSION['tienda']; ?></span><i class="material-icons right">arrow_drop_down</i></a></li>
    <?php if(isset($_SESSION['usuario'])) { ?>
        <li class="invisible"><a href="#" class="Cerrar"><i class="material-icons left">power_settings_new</i>Cerrar Sesión</a></li>
        <li class="invisible"><div class="divider"></div></li>
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