<?php

    session_start();

    require 'config.php';

    $IdTipoPago = $_POST['IdTipoPago'];
    $IdCliente = $_POST['IdCliente'];
    $TipoEntrega = $_POST['TipoEntrega'];
    $Direccion = $_POST['Direccion'];
    $Distrito = $_POST['Distrito'];
    $Provincia = $_POST['Provincia'];
    $Departamento = $_POST['Departamento'];
    $Longitud = $_POST['Longitud'];
    $Latitud = $_POST['Latitud'];
    $CostoAdicional = $_POST['CostoAdicional'];

    if(isset($_SESSION['carrito'])) {
        $datos = $_SESSION['carrito'];
    
        $con = new Connection();
        $cmd = $con->getConnection();

        $NombreTienda = $_SESSION['tienda'];
        $BonosGan = 0;
        $cmd->query("CALL set_VentasWeb ('$IdTipoPago', '$IdCliente', '$CostoAdicional', '$NombreTienda')");
        for($i = 0; $i <count($datos); $i++) {
            $IdProducto = $datos[$i]['Id'];
            $Cantidad = $datos[$i]['Cantidad'];
            $PrecioVenta = $datos[$i]['PrecioVenta'];
            $BonosGan = $BonosGan + $datos[$i]['Bono'] * $datos[$i]['Cantidad'];

            $cmd->query("CALL set_DetallesVentaWeb ('$Cantidad', '$IdProducto', '$PrecioVenta', '$NombreTienda')");
        }
        $cmd->query("CALL up_Bonos_IdCliente ('$IdCliente', '$BonosGan')");
        if($TipoEntrega == 2) {
            $cmd->query("CALL set_EntregasWeb ('$IdCliente', '$Direccion', '$Departamento', '$Provincia', '$Distrito', '$Longitud','$Latitud', '$TipoEntrega')");
        } else {
            $cmd->query("CALL set_EntregasWeb ('$IdCliente', null, null, null, null, null, null, '$TipoEntrega')");
        }
        
        if($IdTipoPago == 2) {
            $cmd->query("CALL up_Monto_IdCliente_IdVenta ('$IdCliente')");
        }
        unset($_SESSION['carrito']);
        echo '1';
    } else {
        echo '0';
    }
?>