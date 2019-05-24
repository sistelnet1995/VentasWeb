<?php
    session_start();

    require 'get.php';

    $UserName = strtolower($_POST['UserName']);
    $UserPass = $_POST['UserPass'];

    $get = new get();
    $result = $get->getSP("get_UsuarioxUserNamexUserPass('$UserName', '$UserPass')");

    while ($row = $result->fetch_assoc()){
        $IdUsuario = $row['IdUsuario'];
        $Email = $row['Email'];
        $UserName = $row['UserName'];
    }

    if(isset($IdUsuario)){

        $arreglo[] = array(
            'Id' => $IdUsuario,
            'UserName' => $UserName,
        );
        $_SESSION['usuario'] = $arreglo;
        echo $_SESSION['usuario'];
    } else {
        echo '0';
    }

?>