<?php

    session_start();

    require 'get.php';

    $get = new get();

    $total = $_POST['total'];
    $ArrayUsuario = $_SESSION['usuario'];
    $IdCliente = $ArrayUsuario[0]['IdCliente'];

    $result = $get->getSP("get_MontoxIdClientexTotal('$IdCliente', '$total')");
    while($row = $result->fetch_array()) {
       $Estado = $row['Estado'];
    }
    $result->free_result();

    echo $Estado;
?>