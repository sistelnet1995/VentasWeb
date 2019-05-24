<?php
    session_start();
    require '../get.php';
    $get = new get();
    $IdPrecioVenta = $_POST['Id'];

    $result = $get->getSP("get_StockxIdPrecioVenta('$IdPrecioVenta')");

    while ($row = $result->fetch_assoc()) {
        $StockTienda = $row['StockTienda'];
    }

    echo $StockTienda;
?>