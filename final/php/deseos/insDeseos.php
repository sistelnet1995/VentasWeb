<?php

    require '../../php/config.php';

    $IdUsuario = $_POST['IdUsuario'];
    $IdProducto = $_POST['IdProducto'];

    $con = new Connection();
    $cmd = $con->getConnection();
    $resultU = $cmd->query("CALL set_ListaDeseo_IdUsuario_IdProducto ('$IdUsuario', '$IdProducto')");
    $cmd->close();
    if($resultU){
        echo 1;
    }
    else {
        echo 0;
    }

?>