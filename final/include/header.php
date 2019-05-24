<?php

    // Listar tiendas
    $resultT = $get->getSP("get_Tiendas()");

    // Listar Categorias
    $resultC = $get->getSP("get_Categorias()");
?>

<div class="loadPage">
    <div class="loader">
        <div class="inner one"></div>
        <div class="inner two"></div>
        <div class="inner three"></div>
    </div>
</div>

<header>
    <nav class="navbar navbar-expand-lg navbar-dark info-color-dark">

        <a class="navbar-brand" href="index.php"><img src="../img/logo/logo.png" style="height: 50px;" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div role="separator" class="dropdown-divider mr-auto"></div>
            <form name="ProdNom" action="catalogo.php" method="POST" class="form-inline ml-auto mr-auto">
                <div class="input-group mb-0">
                    <input type="text" name="NombreProducto" id="NombreProducto" class="form-control" autocomplete="off"
                        placeholder="Hola! qué buscas?">
                    <div class="input-group-append">
                        <button class="btn btn-outline-light" type="submit" id="btnBuscar"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="carrito.php"><i class="fas fa-shopping-cart"></i> Carrito <span class="badge badge-light CantProd">0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="catalogo.php"><i class="fas fa-tags"></i> Catálogo</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-map-marker-alt"></i> <span id="NomTienda"><?php echo $_SESSION['tienda']; ?></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php 
                            $tienda = 0;
                            while ($rowT = $resultT->fetch_assoc()) { ?>
                                <button class="dropdown-item btnTienda cursor-pointer"><?php echo $rowT['NombreTienda']; ?></button>
                            <?php } $resultT->free_result(); 
                        ?>
                    </div>
                </li>
                <?php 
                    if(isset($_SESSION['usuario'])) {?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle cursor-pointer" data-toggle="dropdown" aria-expanded="false"><i
                            class="fas fa-user-circle"></i> <span>
                            <?php echo $_SESSION['usuario'][0]['UserName']; ?></span></a>
                    <label class="d-none" id="usuario"><?php echo isset($_SESSION['usuario'][0]['Id']) ? $_SESSION['usuario'][0]['Id'] : '0'; ?></label>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lbtnUsuario">
                        <a class="dropdown-item sidenav-trigger" href="#" data-target="slide-side"><i class="fas fa-user"></i> Mi Perfil</a>
                        <a class="dropdown-item" href="deseos.php"><i class="far fa-star"></i> Lista de deseos</a>
                        <a class="dropdown-item" href="compras.php"><i class="fas fa-clipboard-list"></i> Mis Compras</a>
                        <a class="dropdown-item" href="canjes.php"><i class="fas fa-gift"></i> Mis Canjes</a>
                        <a class="dropdown-item" href="login.php" id="Cerrar"><i class="fas fa-power-off"></i> Cerrar Sesión</a>
                    </div>
                </li>
                <?php } else { ?>
                <li class="nav-item" id="Inicio">
                    <a class="nav-link" href="login.php">Iniciar Sesión</a>
                </li>
                <?php }
                ?>
            </ul>
        </div>
    </nav>
</header>