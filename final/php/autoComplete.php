<?php
    require 'get.php';

    $get = new get();

    if(isset($_POST['Producto'])) {
        $NombreProducto = $_POST['Producto'];
        $NomTienda = $_POST['NomTienda'];
        $data = array();
        $result = $get->getSP("get_ProductosxProductoxTiendaxIdTipoVenta('$NombreProducto', '$NomTienda')");
        while($row = $result->fetch_assoc()) {
            $data[] = $row['Producto'];
        }
        echo json_encode($data);
    }

?>