<?php

    session_start();

    require 'config.php';

    $Email = strtolower($_POST['Email']);
    $UserName = strtolower($_POST['UserName']);
    $UserPass = $_POST['UserPass'];
    $Departamento = $_POST['Departamento'];
    $Provincia = $_POST['Provincia'];
    $Distrito = $_POST['Distrito'];
    $Latitud = $_POST['Latitud'];
    $Longitud = $_POST['Longitud'];
    $IdCliente = $_POST['IdCliente'];
    $Nombre = ucwords($_POST['Nombre']);
    $ApellidoP = ucwords($_POST['ApellidoP']);
    $ApellidoM = ucwords($_POST['ApellidoM']);
    $Genero = $_POST['Genero'];
    $EstadoCivil = $_POST['EstadoCivil'];
    $FechaNacimiento = $_POST['FechaNacimiento'];
    $RazonSocial = ucwords($_POST['RazonSocial']);
    $Direccion = ucwords($_POST['Direccion']);

    $con = new Connection();
    $cmd = $con->getConnection();
    $result = $cmd->query("CALL set_Usuario_Ubigeo_Coordenada_Cliente_Bono('$Email', '$UserName', '$UserPass', '$Departamento', '$Provincia', '$Distrito', '$Latitud', '$Longitud', '$IdCliente', '$Nombre', '$ApellidoP', '$ApellidoM', '$Genero', '$EstadoCivil', '$FechaNacimiento', '$RazonSocial', '$Direccion')");
    $cmd->close();
    if($result)
        echo 'Cuenta creada con exito';
    else
        echo 'No se creo su cuenta, vuelva a intentarlo';
    

?>