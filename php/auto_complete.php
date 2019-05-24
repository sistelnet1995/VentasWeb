<?php

    session_start();
    require 'get.php';

    $get = new get();

    $tienda = $_SESSION['tienda'];
    $resultPN = $get->getSP("get_ProductoxTienda('$tienda')");
    $productos = '{';
    if($resultPN->num_rows>0){
        while($row = $resultPN->fetch_assoc()){
            $productos .= $row["Producto"].': null, ';
        }
    }
    $productos = substr($productos,0,-2)."}";

    echo $productos;
?>