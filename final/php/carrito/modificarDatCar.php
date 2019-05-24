<?php

    session_start();
    require '../get.php';
    $arreglo = $_SESSION['carrito'];
    $Subtotal=0;
    $numero = 0;
    $IdProducto = $_POST['Id'];
    $Cantidad = $_POST['Cantidad'];
    $Tienda = $_SESSION['tienda'];
    $get = new get();
    

    for($i = 0; $i < count($arreglo); $i++) {
        if($arreglo[$i]['Id'] == $IdProducto) {
            $arreglo[$i]['Cantidad'] = $Cantidad;
            $result = $get->getSP("get_ProductosxIdProductoxTiendaxTipoVenta('$IdProducto', '$Tienda')");

            while ($row = $result->fetch_assoc()) {
                $Cant = $row['Cantidades'];
                $ArrayCant = explode(",", $Cant);
                $Prec = $row['Precios'];
                $ArrayPrec = explode(",", $Prec);
                $Num = count($ArrayCant);
                for ($j= 0; $j < $Num; $j ++) {
                    if($Cantidad >= $ArrayCant[$j]){
                        $PrecioVenta = $ArrayPrec[$j];
                    }            
                }
            }
            $arreglo[$i]['PrecioVenta'] = $PrecioVenta;
        }
        $Subtotal = $Subtotal + ($arreglo[$i]['Cantidad'] * $arreglo[$i]['PrecioVenta']);
    }

    $_SESSION['carrito'] = $arreglo;

    echo number_format($Subtotal,2);

?>