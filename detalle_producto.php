<?php
    session_start();

    if(isset($_POST['IdPrecioVenta'])){
        $_SESSION['IdPrecioVenta'] = $_POST['IdPrecioVenta'];
    } else {

        require 'php/get.php';
        $get = new get();
        
        $IdPrecioVenta = $_SESSION['IdPrecioVenta'];
        $NombreTienda = $_SESSION['tienda'];

        $result = $get->getSP("get_DetalleProductoxIdPrecioVentaxTiendaxTipoVenta('$IdPrecioVenta', '$NombreTienda')");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php'; ?>
    <title>uMarket - Detalle Producto</title>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <main class="container mt-5">
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col m4 s12">
                    <img src="<?php echo $row['Imagen']; ?>" class="responsive-img materialboxed">
                </div>
                <div class="col m8 s12">  
                    <div class="card">
                        <div class="card-content black-text">
                            <blockquote><h5 class="light-blue-text font-weight-bold uppercase"><?php echo $row['Producto']; ?></h5></blockquote>
                            <p>Precio exclusivo en web</p>
                            <h6>Precio por Cantidad:</h6>
                            <div class="center">
                                <table class="highlight centered responsive-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Unidades</th>
                                            <th scope="col">Precio por Unidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $ArrayIdPrec = explode(",", $row['IdPreciosVenta']);
                                            $ArrayCant = explode(",", $row['Cantidades']);
                                            $ArrayPrec = explode(",", $row['Precios']);
                                            $Num = count($ArrayCant);
                                            for ($i= 0; $i < $Num; $i ++) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo $i + 1 ?></th>
                                                <td><?php echo $ArrayCant[$i]; ?> a más</td>
                                                <td><b>S/. <?php echo number_format($ArrayPrec[$i],2); ?></b> por Unidad</td>
                                            </tr>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <blockquote>Por la comprar del producto via web, te da <b><?php echo $row['Bonos']; ?></b> puntos bonus</blockquote>
                            <p><?php echo $row['Descripcion']; ?></p>
                        </div>
                        <div class="card-action center">
                            <button class="btn waves-effect waves-light blue mt-1 tooltipped AgregarCarrito" data-position="top" data-tooltip="Agregar al Carrito" id="<?php echo $ArrayIdPrec[0]; ?>"><i class="material-icons left">add_shopping_cart</i>Agregar</button>
                            <button class="btn waves-effect waves-light red mt-1 tooltipped AgregarFavorito <?php echo isset($_SESSION['usuario']) ? '' : 'disabled' ; ?>" data-position="top" data-tooltip="Agregar a mis favoritos"><i class="material-icons left">favorite</i>Agregar</button>
                        </div>
                        <div class="progress hide" id="PreloaderV">
                            <div class="indeterminate"></div>
                        </div>
                    </div>
                </div>
            <?php } $result->free_result(); ?>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script src="js/detalle_producto.js"></script>    
</body>
</html>

<?php } ?>