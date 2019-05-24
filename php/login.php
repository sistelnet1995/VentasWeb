<?php
    session_start();

    require 'get.php';

    $UserName = strtolower($_POST['UserName']);
    $UserPass = $_POST['UserPass'];

    $get = new get();
    $result = $get->getSP("get_UsuarioxUserNamexUserPass('$UserName', '$UserPass')");
    if(mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()){
            $arreglo[] = array(
                'IdCliente' => $row['IdCliente'],
                'Email' => $row['Email'],
                'UserName' => $row['UserName'],
                'Nombre' => $row['Nombre'],
                'Direccion' => $row['Direccion'],
                'Coordenada' => $row['Coordenada'],
                'MontoCredito' => $row['MontoCredito'],
                'Bonos' => $row['Bonos']
            );
        }
        $_SESSION['usuario'] = $arreglo;
        echo 1;
    } else {
        echo 0;
    }
?>