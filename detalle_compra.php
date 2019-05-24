<?php
    session_start();

    if(!isset($_SESSION['usuario'])) {
        header("Location: login.php");
    } elseif(isset($_POST['IdVenta'])) {
        $_SESSION['IdVenta'] = $_POST['IdVenta'];
        $_SESSION['CostoAdicional'] = $_POST['CostoAdicional'];
    } else {
        require 'php/get.php';
        $get = new get();
        $IdVenta = $_SESSION['IdVenta'];
        $resultDV = $get->getSP("get_DetallesVentaxIdVenta('$IdVenta')");
        $resultRP = $get->getSP("get_EntregaxIdVenta('$IdVenta')");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php'; ?>
    <title>uMarket - Detalle Compra</title>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <main class="container">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content black-text">
                        <blockquote><h5 class="light-blue-text font-weight-bold uppercase">Detalle Compra</h5></blockquote>
                        <div class="center">
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
                            <table class="highlight centered responsive-table">
                                <thead>
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
                                        $i = 1; $PrecioTotal = 0;
                                        while($rowDV = $resultDV->fetch_assoc()) { 
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td><img src="<?php echo $rowDV['Imagen']; ?>" style="width: 3rem;" class="responsive-img materialboxed"></td>
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
                            <div class="row">
                                <div class="col s12">
                                    <div >
                                        <div class="row">
                                            <div class="col s4 m3 l3 offset-l7 offset-m6 offset-s3" style="text-align:right">
                                                SubTotal
                                            </div>
                                            <div class="col s5 m3 l2" style="text-align:right">
                                                <b>S/. </b>
                                                <b style="font-size: 1.2rem"><?php echo number_format($PrecioTotal,2); ?></b><span id="PagoRe" hidden><?php echo $Subtotal; ?></span><span id="TotalPago" hidden><?php echo round($Subtotal * 0.329 ,2); ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s4 m3 l3 offset-l7 offset-m6 offset-s3" style="text-align:right">
                                                Costo Adiconal
                                            </div>
                                            <div class="col s5 m3 l2" style="text-align:right">
                                                <b>S/. </b>
                                                <b style="font-size: 1.2rem"><?php echo number_format($_SESSION['CostoAdicional'],2); ?></b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col s4 m3 l3 offset-l7 offset-m6 offset-s3" style="text-align:right">
                                                Total
                                            </div>
                                            <div class="col s5 m3 l2 red-text" style="text-align:right">
                                                <b>S/. </b>
                                                <b style="font-size: 1.2rem"><?php echo number_format($_SESSION['CostoAdicional']  + $PrecioTotal,2); ?></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script src="js/detalle_compra.js"></script>
    
</body>
</html>
<?php } ?>