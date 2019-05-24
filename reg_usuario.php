<?php

    session_start();

    require 'php/get.php';

    $get = new get();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php'; ?>
    <title>uMarket - Registro Usuario</title>
</head>
<body>
    
    <?php include 'include/header.php'; ?>

    <main class="container mt-5">
        <div class="row">
            <div class="col m12 center">
                <div class="col m3"></div>
                <div class="col m6">
                    <div class="card">
                        <div class="card-content black-text">
                            <h3 class="light-blue-text accent-3">Inicio de Sesión</h3>
                            <div class="input-field">
                                <i class="material-icons prefix">account_box</i>
                                <input type="text" name="UserName" id="UserName" class="">
                                <label for="UserName">Usuario o Email</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">https</i>
                                <input type="password" name="UserPass" id="UserPass" class="">
                                <label for="UserPass">Contraseña</label>
                            </div>
                        </div>
                        <div class="card-action">
                        <a href="registrar_cliente.php" class="btn blue waves-effect waves-light mt-1" >Registrarse</a>
                        <button id="Login" class="btn waves-effect waves-light mt-1">Iniciar Sesión</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script src="js/login.js"></script>    
</body>
</html>