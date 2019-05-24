<?php
    session_start();
    require '../php/get.php';

    if(isset($_POST['IdProd'])){
        $_SESSION['IdProd'] = $_POST['IdProd'];
    }

    $IdProducto = $_SESSION['IdProd'];
    $NombreTienda = $_SESSION['tienda'];
    
    $get = new get();
    $result = $get->getSP("get_ProductosxIdProductoxTiendaxTipoVenta('$IdProducto', '$NombreTienda')");

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <?php include '../include/head.php'; ?>
    <title><?php echo $_SESSION['Sistema'] . 'Detalles del Producto'; ?></title>
</head>

<body>
    <?php include '../include/header.php'; ?>
    <?php require '../include/sidenav.php'; ?>

    <div class="container">
        <div class="row">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4 mt-5 d-flex align-items-center justify-content-center">
                <img src="<?php echo $row['Imagen']; ?>" style="width: 20rem;" alt="" class="img-thumbnail Responsive image zoom border border-info"  />
            </div>
            <div class="col-md-8 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-info"><?php echo $row['Producto']; ?></h4>
                        <h6 class="card-title">Precio exclusivo en web</h6>
                        <h5 class="card-text">Precio por Cantidad:</h5>
                        <div class="col-md-8 text-center m-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Unidades</th>
                                        <th scope="col">Precio por Unidad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                        $Cant = $row['Cantidades'];
                                        $ArrayCant = explode(",", $Cant);
                                        $Prec = $row['Precios'];
                                        $ArrayPrec = explode(",", $Prec);
                                        $Num = count($ArrayCant);
                                        for ($i= 0; $i < $Num; $i ++) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i + 1 ?></th>
                                            <td><?php echo $ArrayCant[$i]; ?> a más</td>
                                            <td>S/.<?php echo number_format($ArrayPrec[$i],2); ?> por Ud.</td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <p class="card-text">Por la comprar del producto via web, te da <b><?php echo $row['Bonos']; ?></b> puntos bonus</p>
                        <hr>
                        <p class="card-text"><?php echo $row['Descripcion']; ?></p>
                    </div>
                    <div class="card-footer d-flex flex-wrap justify-content-around">
                        <button type="button" class="btn btn-outline-primary btnAgregar mt-2" id="<?php echo $row['IdProducto']; ?>"><i class="fas fa-shopping-cart"></i> Agregar al carrito</button>
                        <button type="button" class="btn btn-outline-warning btnFavorito mt-2"><i class="far fa-star"></i> Agregar a mis deseos</button>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>



    <?php include '../include/footer.php'; ?>
    <?php include '../include/script.php'; ?>
</body>

</html>