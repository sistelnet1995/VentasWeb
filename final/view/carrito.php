<?php 
require '../php/carrito/agregarCar.php';

$resultD = $get->getSP("get_Departamentos()");
$tienda = $_SESSION['tienda'];
$resultTD = $get->getSP("get_DireccionxTienda('$tienda')");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require '../include/head.php'; ?>
    <title><?php echo $_SESSION['Sistema'] . 'Carrito de Compras'; ?></title>
    <link rel="stylesheet" href="../css/paypal.css">
</head>

<body>

        <?php require '../include/header.php'; ?>
        <?php require '../include/sidenav.php'; ?>
        
        <section class="container">
            <div class="card text-center mt-5">
                <div class="card-header text-uppercase">
                    <i class="fas fa-shopping-cart"></i> Carrito de Compras
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-md">
                        <?php
                            if(isset($_SESSION['carrito'])) {
                                $datos = $_SESSION['carrito'];
                                $Subtotal = 0;
                                ?>
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio</th>
                                        <th scope="col">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    for($i = 0; $i <count($datos); $i++) { 
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $i + 1 ?></th>
                                        <td><img src="<?php echo $datos[$i]['Imagen']; ?>" style="width: 3rem;"></td>
                                        <td><p><?php echo $datos[$i]['Producto']; ?></p></td>
                                        <td>
                                            <input type="number" class="form-control col-md-8 m-auto Cantidad number" min="1" data-id="<?php echo $datos[$i]['Id']; ?>" value="<?php echo $datos[$i]['Cantidad']; ?>" required>
                                        </td>
                                        <td>
                                            <p class="PrecioV"><?php echo 'S/. ' . number_format($datos[$i]['PrecioVenta'],2); ?></p>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger eliminar" data-id="<?php echo $datos[$i]['Id']; ?>"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>

                                <?php
                                    
                                    $Subtotal = $Subtotal + $datos[$i]['Cantidad']* $datos[$i]['PrecioVenta'];
                            } ?>
                                </tbody>
                            <?php
                                } else {
                                    echo '<center><h2>El carrito de compras esta vacio</h2></center>';
                                }
                                
                                if(isset($Subtotal) && isset($i)){
                                    $Subtotal = $Subtotal;
                                    $item = $i;
                                } else {
                                    $Subtotal = 0;
                                    $item = 0;
                                }
                            ?>
                    </table>
                </div>
                <div class="card-footer text-muted">
                    <div class="text-right">
                        <p>SUBTOTAL (<b class="CantProd"></b> ITEMS): <b id="SubTotal"><?php echo 'S/. '.number_format($Subtotal,2); ?></b><span id="PagoRe" hidden><?php echo $Subtotal; ?></span><span id="TotalPago" hidden><?php echo round($Subtotal * 0.329 ,2); ?></span></p>
                        <a href="catalogo.php" class="btn btn-info"><i class="fas fa-tags"></i> VER CATÁLOGO</a>
                    </div>
                </div>
            </div>
            <?php if(isset($_SESSION['usuario'])) {
                $IdUsuario = $_SESSION['usuario'][0]['Id'];
                $resultDC = $get->getSP("get_DireccionxCliente('$IdUsuario')");
            ?>
                <div class="form-row">
                    <div class="col-md-12 mt-5">
                        <div class="card text-center">
                            <div class="card-header">Datos de Entrega</div>
                            <div id="Delivery" class="form-row mt-5 mb-5">
                                <div class="col-md-8">
                                    <p class="font-weight-bold">Dirección de Entrega</p>
                                    <?php while ($rowDC = $resultDC->fetch_assoc()) { ?>
                                        <div hidden>
                                            <label id="IdCliente"><?php echo $rowDC['IdCliente']; ?></label>
                                        </div>
                                        <div>
                                            <p id="DireccionC"><label id="lblDireccion"><?php echo $rowDC['Direccion']; ?></label>, <label id="lblDepartamento"><?php echo $rowDC['Departamento']; ?></label>, <label id="lblProvincia"><?php echo $rowDC['Provincia']; ?></label>, <label id="lblDistrito"><?php echo $rowDC['Distrito']; ?></label></p>
                                        </div>
                                        <div hidden>
                                            <p id="CoordenadaC"><label id="lblLongitud"><?php echo $rowDC['Latitud']; ?></label>, <label id="lblLatitud"><?php echo $rowDC['Longitud']; ?></label></p>
                                        </div>
                                    <?php } $resultDC->free_result(); ?>
                                    <!-- Boton Modal -->
                                    <button type="button" id="cDireccion" class="btn btn-outline-success" data-toggle="modal" data-target="#CambiarDireccion"><i class="fas fa-map-marker-alt"></i> Cambiar dirección</button>

                                    <!-- Modal -->
                                    <div class="modal fade text-left" id="CambiarDireccion" tabindex="-1" role="dialog" aria-labelledby="CambiarDireccionLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="CambiarDireccionLabel">Cambiar Dirección</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Dirección:</label>
                                                    <input type="text" name="Direccion" id="Direccion" class="form-control" placeholder="Dirección">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Departamento">Departamento</label>
                                                    <select name="Departamento" id="Departamento" class="custom-select">
                                                        <option value="0">Seleccione</option>
                                                        <?php while ($rowD = $resultD->fetch_assoc()) { ?>
                                                        <option value="<?php echo $rowD['IdDepartamento']; ?>">
                                                            <?php echo $rowD['Departamento']; ?>
                                                        </option>
                                                        <?php } $resultD->free_result(); ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Provincia">Provincia</label>
                                                    <select name="Provincia" id="Provincia" class="custom-select">
                                                        <option value="0" Enabled="true">Seleccione</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Distrito">Distrito</label>
                                                    <select name="Distrito" id="Distrito" class="custom-select">
                                                        <option value="0" Enabled="true">Seleccione</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Ubicación</label>
                                                    <div class="d-flex flex-wrap justify-content-between">
                                                        <input type="text" name="Longitud" id="Longitud" class="form-control mb-3 col-md-3"
                                                            readonly>
                                                        <input type="text" name="Latitud" id="Latitud" class="form-control mb-3 col-md-3"
                                                            readonly>
                                                        <a href="#" class="btn btn-primary mb-3 col-md-4" data-toggle="modal" data-target="#mapsModalCenter"><i
                                                                class="fas fa-map-marker-alt"></i> Seleccionar</a>
                                                        <div class="modal fade" id="mapsModalCenter" tabindex="-1" role="dialog"
                                                            aria-labelledby="mapsModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="mapsModalCenterTitle">Seleccione su
                                                                            domicilio en el mapa</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div id="map" style="width: 100%; height: 300px;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="button" id="GuardarCambios" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4 mt-5">
                                    <button id="cTienda" class="btn btn-primary" style="height:50px; width:200px"><i class="fas fa-store-alt"></i> Recoger en tienda</button>
                                </div>
                            </div>
                            <div id="Tienda" class="form-row mt-5 mb-5 d-none">
                                <div class="col-md-8">
                                    <p class="font-weight-bold">Tienda de Entrega</p>
                                    <div class="table-responsive col-md-11 m-auto">
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Dirección</th>
                                                    <th>Ubicanos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($rowTD = $resultTD->fetch_assoc()) { ?>
                                                    <tr>
                                                        <th>
                                                            <p><label><?php echo $rowTD['NombreTienda']; ?></label></p>
                                                        </th>   
                                                        <td>
                                                            <p id="DireccionT"><label><?php echo $rowTD['Direccion']; ?></label></p>
                                                        </td>
                                                        <td>
                                                            <a href="https://www.google.com.pe/maps/@<?php echo $rowTD['Latitud'] ?>,<?php echo $rowTD['Longitud'] ?>,15.25z?hl=es" target="_bank"><i class="fas fa-map-marker-alt"></i> Ir a Google Maps</a>
                                                            <p id="CoordenadaT" hidden><?php echo $rowTD['Latitud']; ?>, <?php echo $rowTD['Longitud']; ?></p>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-5">
                                    <button id="cDelivery" class="btn btn-primary" style="height:50px; width:200px"><i class="fas fa-truck"></i> Delivery</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div id="paypal-button-container"></div>
                            <button class="btn btn-primary" id="PagoCredito"><i class="fas fa-credit-card"></i> uMarket</button>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="m-3 d-flex justify-content-center">
                    <a href="login.php" class="btn btn-warning">Iniciar Sesión para Comprar</a>
                </div>
            <?php } ?>

            
        </section>
    <?php require '../include/footer.php'; ?>
    <?php require '../include/script.php'; ?>

    <script src="../js/maps.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?callback=initMap"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AZyceNz3mWPNGCkd2NjI3Dx3ul9Y54DgP76nbPn0U3tqFMjfsIBoPjn6wsL9o2XPfZfujqKzpisIL9EM&currency=USD"></script>
    <script src="../js/paypal.js"></script>
    <script src="../js/ubigeo.js"></script>
</body>
</html>