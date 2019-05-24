<?php
    session_start();

    if(!isset($_SESSION['usuario'])) {
        header("Location: login.php");
    } else {

        require 'php/get.php';
        $get = new get();

        $IdCliente = $_SESSION['usuario'][0]['IdCliente'];
        $result = $get->getSP("get_ListaDeseoxIdCliente('$IdCliente')");
        
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php'; ?>
    <title>uMarket - Mis Favoritos</title>
</head>
<body>
    <?php include 'include/header.php'; ?>

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

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script src="js/favoritos.js"></script>    
</body>
</html>

<?php } ?>