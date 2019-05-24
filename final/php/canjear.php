<?php
    session_start();
    require '../php/get.php';
    $get = new get();

    $BonosPN = $_POST['BonosPN'];
    $cantCP = $_POST['cantCP'];
    $IdProd = $_POST['IdProd'];

    if(isset($_SESSION['usuario'])){
        $IdUsuario = $_SESSION['usuario'][0]['Id'];
        $resultCU = $get->getSP("get_ClientexIdUsuario('$IdUsuario')");

        while ($rowCU = $resultCU->fetch_assoc()) { 
            $BonosTC = $rowCU['Bonos'];
        }

        $BonosN = $BonosPN * $cantCP;

        if($BonosN > $BonosTC) {
            echo "No tiene los bonos necesarios para canjear el producto.";
        } else {
            $get->getSP("set_CanjeBono_IdUsuario_IdProducto_CantidadCanjeada('$IdUsuario', '$IdProd', '$cantCP', '$BonosPN')");
            echo "Canje realizado con exito";
        }
    } else {
        echo "Debe Iniciar Sesión";
    }

    

?>