<?php

    session_start();

    require '../config.php';

    $ArrayUsuario = $_SESSION['usuario'];
    $IdCliente = $ArrayUsuario[0]['IdCliente'];
    $IdPrecioVenta = $_POST['IdPrecioVenta'];

    $con = new Connection();
    $cmd = $con->getConnection();
    $resultU = $cmd->query("CALL set_ListaDeseo_IdCliente_IdPrecioVenta ('$IdCliente', '$IdPrecioVenta')");
    $cmd->close();
    if($resultU){
        echo 1;
    }

?>