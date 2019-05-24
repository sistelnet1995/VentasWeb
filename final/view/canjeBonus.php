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
            <div class="col-md-8 mt-5 d-flex align-items-center justify-content-center">
                <img src="<?php echo $row['Imagen']; ?>" style="width: 20rem;" alt="" class="img-thumbnail Responsive image zoom border border-info"  />
            </div>
            <div class="col-md-4 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-info"><?php echo $row['Producto']; ?></h4>
                        <h5 class="card-text">Cantidad de PB Necesario:</h5>
                        <p class="card-text">
                            <?php        
                                $CantBonos = $row['CanjeBonos'];
                                $ArrayCantBonos = explode(",", $CantBonos);
                                ?> <label id="BonosPN"><?php echo $ArrayCantBonos[0] ?></label> PB <?php
                            ?>
                        </p>
                        <hr>
                        <p class="card-text"><?php echo $row['Descripcion']; ?></p>
                        <p class="card-text form-group">
                            <label for="cantCP">Cantidad: </label>
                            <input type="number" name="cantCP" id="cantCP" class="form-control" value="1" min="1" aria-describedby="cantCPHelp">
                            <small id="cantCPHelp" class="form-text text-muted">Cantidad de productos a canjear.</small>
                        </p>
                    </div>
                    <div class="card-footer text-center mt-2">
                        <button type="button" class="btn btn-outline-primary Canjear" id="<?php echo $row['IdProducto']; ?>"><i class="fas fa-gift"></i> Canjear</button>
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