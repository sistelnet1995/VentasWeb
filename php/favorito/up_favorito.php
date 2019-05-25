<?php

    session_start();

    require '../config.php';

    $ArrayUsuario = $_SESSION['usuario'];
    
    $con = new Connection();
    $cmd = $con->getConnection();
    $resultU = $cmd->query("CALL up_ListaDeseo (".$_POST['IdPrecioVenta'].", ".$ArrayUsuario[0]['IdCliente'].")");
    $cmd->close();
    if($resultU){
        echo 1;
    }

?>