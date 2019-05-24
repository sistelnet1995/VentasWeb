<?php
    session_start();

    $tienda = $_POST['tienda'];

    $_SESSION['tienda'] = $tienda;

    unset($_SESSION['carrito']);