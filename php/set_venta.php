<?php

    session_start();

    $TipoEntrega = $_POST['envio'];
    $IdTipoPago = $_POST['tipopago'];
    $MontoAdicional = 0;
    if($TipoEntrega == 2) {
        $MontoAdicional = 20;
    }

    if(isset($_SESSION['carrito'])) {
        require 'get.php';

        $con = new Connection();
        $cmd = $con->getConnection();

        $ArrayCarrito = $_SESSION['carrito'];
        $ArrayUsuario = $_SESSION['usuario'];
        $IdCliente = $ArrayUsuario[0]['IdCliente'];
        $NombreTienda = $_SESSION['tienda'];

        $cmd->query("CALL set_VentasWeb ('$IdTipoPago', '$IdCliente', '$MontoAdicional', '$NombreTienda')");
        
        $BonosGan = 0;

        for($i = 0; $i <count($ArrayCarrito); $i++) {
            do {
                $res = 0;

                $IdPrecioVenta = $ArrayCarrito[$i]['Id'];
                $Cantidad = $ArrayCarrito[$i]['Cantidad'];
                $BonosGan = $BonosGan + $ArrayCarrito[$i]['Bono'] * $ArrayCarrito[$i]['Cantidad'];
    
                $resp = $cmd->query("CALL set_DetallesVentaWeb ('$IdPrecioVenta', '$Cantidad', '$NombreTienda')");

                if($resp) {
                    $res = 1;
                }
                
            } while($res == 0);
        }

        $cmd->query("CALL set_EntregasWeb ('$IdCliente', '$TipoEntrega', '$IdTipoPago', '$BonosGan')");

        if($IdTipoPago == 2) {
            $result = $cmd->query("CALL get_MontoCreditoxIdCliente ('$IdCliente')");
            while ($row = $result->fetch_assoc()) {
                $ArrayUsuario[0]['MontoCredito'] = $row['Producto'];
            }
            $_SESSION['usuario'] = $ArrayUsuario;
        }
        
        unset($_SESSION['carrito']);
        echo 1;
    } else {
        echo 0;
    }

?>