<?php

    session_start();

    require '../config.php';

    $ArrayUsuario = $_SESSION['usuario'];

    $con = new Connection();
    $cmd = $con->getConnection();
    $resultU = $cmd->query("CALL set_ListaDeseo_IdCliente_IdPrecioVenta (".$ArrayUsuario[0]['IdCliente'].", ".$_POST['IdPrecioVenta'].")");
    $cmd->close();
    if($resultU){
        echo 1;
    }

?>