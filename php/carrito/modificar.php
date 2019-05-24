<?php

    session_start();
    require '../get.php';
    $arreglo = $_SESSION['carrito'];
    $Subtotal=0;
    $numero = 0;
    $IdPrecioVenta = $_POST['Id'];
    $Cantidad = $_POST['Cantidad'];
    $Tienda = $_SESSION['tienda'];
    $get = new get();
    

    for($i = 0; $i < count($arreglo); $i++) {
        if($arreglo[$i]['Id'] == $IdPrecioVenta) {
            $arreglo[$i]['Cantidad'] = $Cantidad;
            $result = $get->getSP("get_DetalleProductoxIdPrecioVentaxTiendaxTipoVenta('$IdPrecioVenta', '$Tienda')");

            while ($row = $result->fetch_assoc()) {
                $IdPrec = $row['IdPreciosVenta'];
                $ArrayIdPrec = explode(",", $IdPrec);
                $Cant = $row['Cantidades'];
                $ArrayCant = explode(",", $Cant);
                $Prec = $row['Precios'];
                $ArrayPrec = explode(",", $Prec);
                $Num = count($ArrayCant);
                for ($j= 0; $j < $Num; $j ++) {
                    if($Cantidad >= $ArrayCant[$j]){
                        $IdPrecioVenta = $ArrayIdPrec[$j];
                        $PrecioVenta = $ArrayPrec[$j];
                    }            
                }
            }
            $arreglo[$i]['Id'] = $IdPrecioVenta;
            $arreglo[$i]['PrecioVenta'] = $PrecioVenta;
        }
        $Subtotal = $Subtotal + ($arreglo[$i]['Cantidad'] * $arreglo[$i]['PrecioVenta']);
    }

    $_SESSION['carrito'] = $arreglo;

    echo number_format($Subtotal,2);

?>