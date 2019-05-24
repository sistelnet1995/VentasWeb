<?php
    session_start();

    $CantProd = 0;
    if(isset($_SESSION['carrito'])) {
        $arreglo = $_SESSION['carrito'];
        for($i = 0; $i < count($arreglo); $i++) {
            $CantProd  = $CantProd  + $arreglo[$i]['Cantidad'];
        }
        $_SESSION['CantProd'] = $CantProd;
        echo $CantProd;
    } else echo 0;
?>