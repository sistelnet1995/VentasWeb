<?php
    session_start();
    
    $_SESSION['Sistema'] = 'uMarket - ';

	if(isset($_SESSION['usuario'])) {
        
    } else {
        $_SESSION['usuario'] = null;
    }
    if(!isset($_SESSION['CantProd'])){
        $_SESSION['CantProd'] = 0;
    }

    require '../php/get.php';
    $get = new get();

    // Si no existe la varible de sesion tienda buscamos el nombre de la primera tienda
    if(!isset($_SESSION['tienda'])) {
        $resultTP = $get->getSP("get_TiendaxPrimero()");
        while ($rowTP = $resultTP->fetch_assoc()) {
            $_SESSION['tienda'] = $rowTP['NombreTienda'];
        }
        $resultTP->free_result();
    }
    $tienda = $_SESSION['tienda'];
    $Producto = NULL;

    $resultLMV = $get->getSP("get_ProductosxIdProductoxTiendaxTipoVenta(NULL,'$tienda')");
    $resultLMT = $get->getSP("get_ProductosxIdProductoxTiendaxTipoVenta(NULL,'$tienda')");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    
	<?php require '../include/head.php'; ?>
    <title><?php echo $_SESSION['Sistema'] . 'Inicio'; ?></title>
</head>
<body>

	<?php require '../include/header.php'; ?>
    <?php // require '../include/carousel.php'; ?>
    <?php require '../include/sidenav.php'; ?>
	
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12 header-products font-weight-bold d-flex align-items-center">
                <h4 class="text-white">LO MAS VENDIDO</h4>
            </div>
        </div>
        <div class="row mt-2 d-flex justify-content-around flex-wrap text-center">

                <?php while ($rowLMV = $resultLMV->fetch_assoc()) { 
                    if($rowLMV['Prioridad'] == 1){ ?>

                        <div class="card card-index card-width-height mt-3">
                            <a href="" class="DetalleProd">
                                <img class="card-img-top img-fluid" src="<?php echo $rowLMV['Imagen']; ?>" alt="">
                                <label class="IdProd" hidden><?php echo $rowLMV['IdProducto'] ?></label>
                            </a>
                            <div class="card-body d-flex justify-content-center align-items-end">
                                <a href="" class="text-info DetalleProd">
                                    <?php echo $rowLMV['Producto']; ?>
                                    <label class="IdProd" hidden><?php echo $rowLMV['IdProducto'] ?></label>
                                </a>
                            </div>
                            <div class="card-footer bg-white">
                                <h5>
                                    <span>
                                    <?php        
                                        $Prec = $rowLMV['Precios'];
                                        $ArrayPrec = explode(",", $Prec);
                                        echo 'S/.' . number_format($ArrayPrec[0],2); 
                                    ?>
                                    </span>
                                </h5>
                            </div>
                        </div>
                <?php }} $resultLMV->free_result(); ?>
        </div>
        <hr>
        <div class="row mt-5">
            <div class="col-md-12 header-products font-weight-bold d-flex align-items-center">
                <h4 class="text-white">CANJE PUNTOS BONUS (PB)</h4>
            </div>
        </div>
        <div class="row mt-2 d-flex justify-content-around flex-wrap text-center">
                <?php while ($rowLMT = $resultLMT->fetch_assoc()) { 
                    if($rowLMT['CanjeBonos'] != NULL){ ?>
                        <div class="card card-index card-width-height mt-3">
                            <a href="" class="CanjeB">
                                <img class="card-img-top img-fluid" src="<?php echo $rowLMT['Imagen']; ?>" alt="">
                                <label class="IdProd" hidden><?php echo $rowLMT['IdProducto'] ?></label>
                            </a>
                            <div class="card-body d-flex justify-content-center align-items-end">
                                <a href="" class="text-info CanjeB">
                                    <?php echo $rowLMT['Producto']; ?>
                                    <label class="IdProd" hidden><?php echo $rowLMT['IdProducto'] ?></label>
                                </a>
                            </div>
                            <div class="card-footer bg-white">
                                <h5>
                                    <span>
                                    <?php        
                                        $Prec = $rowLMT['CanjeBonos'];
                                        $ArrayPrec = explode(",", $Prec);
                                        echo $ArrayPrec[0] . ' PB'; 
                                    ?>
                                    </span>
                                </h5>
                            </div>
                        </div>
                <?php }} $resultLMT->free_result(); ?>
        </div>
        <hr>
    </div>
	
    <?php require '../include/footer.php'; ?>
    <?php require '../include/script.php'; ?>
   
</body>
</html>