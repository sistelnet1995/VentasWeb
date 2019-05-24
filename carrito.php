<?php

    session_start();

    require 'php/get.php';

    $get = new get();
    $NombreTienda = $_SESSION['tienda'];

    if(isset($_POST['Id'])) {
        $Id = $_POST['Id'];
        if(isset($_SESSION['carrito'])) {
            $arreglo = $_SESSION['carrito'];
            $encontrado = false;
            $numero = 0;

            for ($i=0; $i < count($arreglo); $i++) { 
                if ($arreglo[$i]['Id'] == $Id) {
                    $encontrado = true;
                    $numero = $i;
                }
            }

            if ($encontrado == false) {
                $resultn = $get->getSP("get_ProductosxIdPrecioVentaxTiendaxTipoVenta('$Id', '$NombreTienda')");
                while($row = $resultn->fetch_array()) {
                    $ArrayPrec = explode(",", $row['Precios']);
                    $datosNuevos = array(
                        'Id' => $Id,
                        'Producto' => $row['Producto'],
                        'Imagen' => $row['Imagen'],
                        'PrecioVenta' => $ArrayPrec[0],
                        'PrecioCompra' => $row['PrecioCompra'],
                        'Bono' => $row['Bonos'],
                        'Cantidad' => 1
                    );
                }
                $resultn->free_result();
                array_push($arreglo, $datosNuevos);
                $_SESSION['carrito'] = $arreglo;
            }
        } else {
            $result = $get->getSP("get_ProductosxIdPrecioVentaxTiendaxTipoVenta('$Id', '$NombreTienda')");
            while($row = $result->fetch_array()) {
                $ArrayPrec = explode(",", $row['Precios']);
                $arreglo[] = array(
                    'Id' => $Id,
                    'Producto' => $row['Producto'],
                    'Imagen' => $row['Imagen'],
                    'PrecioVenta' => $ArrayPrec[0],
                    'PrecioCompra' => $row['PrecioCompra'],
                    'Bono' => $row['Bonos'],
                    'Cantidad' => 1
                );
            }
            $result->free_result();     
            
            $_SESSION['carrito'] = $arreglo;
        }
    } else {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php'; ?>
    <link rel="stylesheet" href="css/paypal.css">
    <title>uMarket - Carito de Productos</title>
</head>
<body>
    
    <?php include 'include/header.php'; ?>

    <main class="container mt-5">
        <div class="row">
            <div class="col m12">
                <div class="card-panel">
                    <blockquote><h5 class="light-blue-text font-weight-bold uppercase">Tipo de envio</h5></blockquote>
                    <div class="row">
                        <div class="col m6">
                            <label>
                                <input class="with-gap t_envio" name="t_envio" id="t_envio_d" value="1" type="radio" checked/>
                                <span>DESPACHO A DOMICILIO</span>
                            </label>

                            <div>
                                <?php if(isset($_SESSION['usuario'])) { ?>
                                <span>Dirección: </span><label><?php echo $ArrayUsuario[0]['Direccion']; ?></label>
                                <?php } ?>
                            </div>
                            <blockquote>Todos los envios a domicilio genera un costo adicional de S/. 20.00</blockquote>
                        </div>
                        <div class="col m6">
                            <label>
                                
                                <input class="with-gap t_envio" name="t_envio" value="2" type="radio"/>
                                <span>RETIRO EN TIENDA</span>
                            </label>
                            <div>
                                <?php
                                    if(isset($_SESSION['usuario'])) { 
                                        $resultDT = $get->getSP("get_DireccionxNombreTienda('$NombreTienda')");
                                        while ($row = $resultDT->fetch_assoc()){
                                            $direccion = $row['Direccion'];
                                        }
                                        $resultDT->free_result();
                                ?>
                                <span>Dirección: </span><label><?php echo $direccion; ?></label>
                                <?php } ?>
                            </div>
                            <blockquote>Entrega gratis</blockquote>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col m12">
                <div class="card">
                    <div class="card-content black-text">
                        <blockquote><h5 class="light-blue-text font-weight-bold uppercase">Carrito de compras</h5></blockquote>
                        <table class="highlight centered responsive-table">
                            <?php
                                if(isset($_SESSION['carrito'])) {
                                    $datos = $_SESSION['carrito'];
                                    $Subtotal = 0;
                                    ?>
                                    <thead class="">
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
                                            <th scope="row"><?php echo $i +1 ?></th>
                                            <td><img src="<?php echo $datos[$i]['Imagen']; ?>" style="width: 3rem;" class="responsive-img materialboxed"></td>
                                            <td><p><?php echo $datos[$i]['Producto']; ?></p></td>
                                            <td>
                                                <input type="number" class="Cantidad number" min="1" data-id="<?php echo $datos[$i]['Id']; ?>" value="<?php echo $datos[$i]['Cantidad']; ?>" required>
                                            </td>
                                            <td>
                                                <p class="PrecioV">S/. <?php echo number_format($datos[$i]['PrecioVenta'],2); ?></p>
                                            </td>
                                            <td>
                                                <button class="btn waves-effect waves-light red eliminar" data-id="<?php echo $datos[$i]['Id']; ?>"><i class="material-icons left">remove_shopping_cart</i></button>
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
                                ?>
                        </table>
                        <?php if(isset($_SESSION['carrito'])) { ?>
                        <div class="row">
                            <div class="col s12">
                                <div >
                                    <div class="row">
                                        <div class="col s3 m1 l1 offset-l9 offset-m8 offset-s2">
                                            SubTotal
                                        </div>
                                        <div class="col s5 m3 l2" style="text-align:right">
                                            <b>S/. </b>
                                            <b id="SubTotal" style="font-size: 1.2rem"><?php echo $Subtotal; ?></b><span id="PagoRe" hidden><?php echo $Subtotal; ?></span><span id="TotalPago" hidden><?php echo round($Subtotal * 0.329 ,2); ?></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s3 m1 l1 offset-l9 offset-m8 offset-s2">
                                            Total
                                        </div>
                                        <div class="col s5 m3 l2 red-text" style="text-align:right">
                                            <b>S/. </b>
                                            <b id="Total" style="font-size: 1.2rem"></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="card-action center">
                        <a href="catalogo.php" class="waves-effect waves-light btn"><i class="fas fa-tags"></i> VER CATÁLOGO</a>
                    </div>
                </div>
            </div>
            <div class="center">
                <?php if(isset($_SESSION['usuario'])) { ?>
                <div id="paypal-button-container"></div>
                <button class="btn waves-effect waves-light blue" id="PagoCredito"><i class="fas fa-credit-card"></i> uMarket</button>
                <?php } else { ?>
                <a href="login.php" class="btn waves-effect waves-light amber">Iniciar Sesión</a>
                <?php } ?>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script src="https://www.paypal.com/sdk/js?client-id=AZyceNz3mWPNGCkd2NjI3Dx3ul9Y54DgP76nbPn0U3tqFMjfsIBoPjn6wsL9o2XPfZfujqKzpisIL9EM&currency=USD"></script>
    <script src="js/paypal.js"></script>
    <script src="js/carrito.js"></script>
</body>
</html>
<?php } ?>