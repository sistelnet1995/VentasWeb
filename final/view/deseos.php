<?php
	session_start();

    if(isset($_SESSION['usuario'])) {
        
    } else {
        header("Location: index.php?Debe Iniciar Sesion");
    }

    require '../php/get.php';
    $get = new get();
    $IdUsuario = $_SESSION['usuario'][0]['Id'];
	$result = $get->getSP("get_ListaDeseoxIdUsuario('$IdUsuario')");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require '../include/head.php'; ?>
    <title><?php echo $_SESSION['Sistema'] . 'Mi Lista de Deseos'; ?></title>
</head>

<body>

    <?php require '../include/header.php'; ?>
    <?php require '../include/sidenav.php'; ?>

    <div class="container">
        <h4 class="text-center font-weight-bold mt-5">LISTA DE DESEOS</h4>
        <hr class="my-4">
        <div class="d-flex justify-content-around flex-wrap">
            <?php while ($row = $result->fetch_assoc()) { 
                $IdProducto = $row['FkIdProducto'];
                $resultDP = $get->getSP("get_ProductosDeseoxIdProducto('$IdProducto')");
                while ($rowDP = $resultDP->fetch_assoc()){ ?>

                <div class="card card-widht mt-3">
                    <a href="" class="DetalleProd">
                        <img class="card-img-top" src="<?php echo $rowDP['Imagen']; ?>" alt="">
                        <label class="IdProd" hidden><?php echo $rowDP['IdProducto'] ?></label>
                    </a>
                    <div class="card-body text-center">
                        <h6 class="card-title font-weight-bold linkNomre">
                            <a href="" class="text-info DetalleProd">
                                <?php echo $rowDP['Producto']; ?>
                                <label class="IdProd" hidden><?php echo $rowDP['IdProducto'] ?></label>
                            </a>
                        </h6>
                        <p class="card-text">
                            <?php        
                                $Prec = $rowDP['Precios'];
                                $ArrayPrec = explode(",", $Prec);
                                echo 'S/.' . number_format($ArrayPrec[0],2); 
                            ?>
                        </p>
                    </div>
                    <div class="card-footer d-flex justify-content-around">
                        <button type="button" class="btn btn-outline-primary btnAgregar" id="<?php echo $rowDP['IdProducto']; ?>"><i class="fas fa-cart-plus"></i></button>
                        <button type="button" class="btn btn-outline-danger btnFavoritoEli"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            <?php }} $result->free_result(); ?>
        </div>
    </div>
                
    <?php require '../include/footer.php'; ?>
    <?php require '../include/script.php'; ?>
</body>

</html>