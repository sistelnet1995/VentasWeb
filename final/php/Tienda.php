<?php

    session_start();

    $Tienda = $_POST['Tienda'];

    $_SESSION['tienda'] = $Tienda;

    unset($_SESSION['carrito']);

    echo 1;

?>