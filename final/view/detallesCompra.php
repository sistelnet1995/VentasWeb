<?php

    session_start();

    if(!isset($_SESSION['usuario'])) {
        header("Location: login.php?Debe Iniciar Sesion");
    } elseif(isset($_POST['IdVenta'])){
        $_SESSION['IdVenta'] = $_POST['IdVenta'];
    }

    require '../php/get.php';
    $get = new get();
    $PrecioTotal = 0;
    $IdVenta = $_SESSION['IdVenta'];
    $resultDV = $get->getSP("get_DetallesVentaxIdVenta('$IdVenta')");
    $resultRP = $get->getSP("get_EntregaxIdVenta('$IdVenta')");

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<?php require '../include/head.php'; ?>
	<title><?php echo $_SESSION['Sistema'] . 'Detalle compra'; ?></title>
</head>
<body>

    <?php require '../include/header.php'; ?>
    <?php require '../include/sidenav.php'; ?>
	
    <div class="container">
    
        <div class="card text-center mt-5">
            <div class="card-header text-uppercase">
                <i class="fas fa-shopping-cart"></i> Detalle Compra
            </div>
            <div class="card-body table-responsive">
                <?php while($rowRP = $resultRP->fetch_assoc()) {  ?>
                    <div class="row m-2 d-flex justify-content-between">
                        <label>Fecha de Compra: <span class="badge badge-success"><?php echo is_null($rowRP['FechaHoraVenta']) ? 'Por designar': $rowRP['FechaHoraVenta']; ?></span></label>
                        <label>Fecha de Envio: <span class="badge badge-primary"><?php echo is_null($rowRP['FechaHoraEntrega']) ? 'Por designar': $rowRP['FechaHoraEntrega']; ?></span></label>
                        <label>Fecha de Entrega: <span class="badge badge-warning"><?php echo is_null($rowRP['FechaEnvio']) ? 'Por designar': $rowRP['FechaEnvio']; ?></span></label>
                    </div>
                    <div class="row m-2">
                        <label>Repartidor: <span class="badge badge-info"><?php echo is_null($rowRP['Empleado']) ? 'Por designar': $rowRP['Empleado']; ?></span></label>
                    </div>
                <?php } ?>
                <table class="table table-hover table-md">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            while($rowDV = $resultDV->fetch_assoc()) { 
                        ?>
                            <tr>
                                <th scope="row"><?php echo $i++; ?></th>
                                <td><img src="<?php echo $rowDV['Imagen']; ?>" style="width: 3rem;"></td>
                                <td><p><?php echo $rowDV['Producto']; ?></p></td>
                                <td><p><?php echo $rowDV['Cantidad']; ?></p></td>
                                <td><p>S/. <?php echo number_format($rowDV['precio_venta'],2); ?></p></td>
                            </tr>
                        <?php
                                $PrecioTotal = $PrecioTotal + ($rowDV['Cantidad'] * $rowDV['precio_venta']);
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted">
                <div class="text-right">
                    <p>Precio Total: <b>S/. <?php echo number_format($PrecioTotal,2); ?></b></p>
                    </div>
                </div>
            </div>
            <div class="m-3 d-flex justify-content-center">
            <a href="compras.php" class="btn btn-info"><i class="fas fa-clipboard-list"></i> Lista de Compras</a>
            </div>
            
        </div>
    </div>

    
    <?php require '../include/footer.php'; ?>
    <?php require '../include/script.php'; ?>

</body>
</html>