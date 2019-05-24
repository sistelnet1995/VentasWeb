<?php
    session_start();

    require 'php/get.php';
    $get = new get();

    $resultT = $get->getSP("get_Tiendas()");

    if(!isset($_SESSION['tienda'])){
        $ArrayTiendas[] = array();
        while ($rowT = $resultT->fetch_array()) {
            $datosNuevos = array(
                'NombreTienda' => $rowT['NombreTienda']
            );
            array_push($ArrayTiendas, $datosNuevos);
        } $resultT->free_result();
    
        $_SESSION['tiendas'] = $ArrayTiendas;
        $_SESSION['tienda'] = $ArrayTiendas[1]['NombreTienda'];
    }

    $tienda = $_SESSION['tienda'];

    $resultLMV = $get->getSP("get_ProductosxIdPrecioVentaxTiendaxTipoVenta(NULL,'$tienda')");
    $resultLMT = $get->getSP("get_ProductosxIdPrecioVentaxTiendaxTipoVenta(NULL,'$tienda')");
    $resultBan = $get->getSP("get_Banner('$tienda')");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php'; ?>
    <title>uMarket - Inicio</title>
</head>
<body>
    <?php include 'include/header.php'; ?>
    <?php if(mysqli_num_rows($resultBan) > 0) { ?>
    <div class="carousel carousel-slider center" data-indicators="true">
        <?php while ($rowB = $resultBan->fetch_assoc()) { ?>
        <div class="carousel-item green white-text">
            <a href="" class="detalle_prod_Banner">
                <span class="IdPrecioVenta" hidden><?php echo $rowB['IdPrecioVenta'] ?></span>
                <img src="<?php echo $rowB['Imagen']; ?>" height="100%" width="100%" alt="">
            </a>
        </div>
        <?php } $resultBan->free_result();   ?>
    </div>
    <div class="progress hide" id="PreloaderBanner">
        <div class="indeterminate"></div>
    </div>
    <?php } ?>

    <main class="container">
        <?php if(mysqli_num_rows($resultLMV) > 0) { ?>
        <section class="mt-4">
            <blockquote><h5 class="font-weight-bold light-blue-text uppercase">Lo más vendido</h5></blockquote>
            <div class="progress hide" id="PreloaderV">
                <div class="indeterminate"></div>
            </div>
            <div class="row">
                <?php while ($rowLMV = $resultLMV->fetch_assoc()) { 
                    if($rowLMV['Prioridad'] == 2){ ?>
                    <div class="col s8 m4 l3 offset-s2">
                        <div class="card hoverable medium">
                            <div class="card-image">
                                <img src="<?php echo $rowLMV['Imagen']; ?>" class="materialboxed img-card">
                            </div>
                            <div class="card-stacked center">
                                <div class="card-content">
                                    <a href="" class="card-title detalle_prod">
                                        <?php echo $rowLMV['Producto']; ?>
                                        <span class="IdPrecioVenta" hidden><?php echo $rowLMV['IdPrecioVenta'] ?></span>
                                    </a>
                                </div>
                                <div class="card-action">
                                    <p class="font-weight-bold">
                                        S/. 
                                        <?php
                                            $ArrayPrec = explode(",", $rowLMV['Precios']);
                                            echo number_format($ArrayPrec[0],2); 
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }} $resultLMV->free_result(); ?>
            </div>
        </section>
        <?php } ?>
        <?php if(mysqli_num_rows($resultLMT) > 0) { ?>
        <section class="mt-4">
            <blockquote><h5 class="font-weight-bold light-blue-text uppercase">Canje puntos bonus (PB)</h5></blockquote>
            <div class="progress hide" id="PreloaderB">
                <div class="indeterminate"></div>
            </div>
            <div class="row">
                <?php while ($rowLMT = $resultLMT->fetch_assoc()) { 
                    if($rowLMT['CanjeBonos'] != NULL){ ?>
                    <div class="col s10 m4 l3 offset-s1">
                        <div class="card medium">
                            <div class="card-image">
                                <img src="<?php echo $rowLMT['Imagen']; ?>" class=" materialboxed img-card">
                            </div>
                            <div class="card-stacked center">
                                <div class="card-content">
                                    <a href="" class="card-title detalle_prod">
                                        <?php echo $rowLMT['Producto']; ?>
                                        <span class="IdPrecioVenta" hidden><?php echo $rowLMT['IdPrecioVenta'] ?></span>
                                    </a>
                                </div>
                                <div class="card-action">
                                    <p class="font-weight-bold">
                                        <?php
                                            $ArrayPunto = explode(",", $rowLMT['CanjeBonos']);
                                            echo $ArrayPunto[0]; 
                                        ?> PB
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }} $resultLMT->free_result(); ?>
            </div>
        </section>
        <?php } ?>
    </main>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script src="js/index.js"></script>
    
</body>
</html>