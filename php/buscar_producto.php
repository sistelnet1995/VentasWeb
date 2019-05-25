<?php

    session_start();

    require 'get.php';
    $get = new get();
    $Producto = $_POST['Producto'];
    $tienda = $_SESSION['tienda'];

    $resultPF = $get->getSP("get_ProductosxProductoxIdCategoriaxIdSubCategoria('$Producto', null, null, null, null, '$tienda')");
    $html = "";
    if(mysqli_num_rows($resultPF) > 0) {
        while ($rowPF = $resultPF->fetch_assoc()) {
            $ArrayPrec = explode(",", $rowPF['Precios']);
            $html .= "<div class='col s10 m6 l3 offset-s1'>
                    <div class='card hoverable medium'>
                        <div class='card-image'>
                            <img src='".$rowPF['Imagen']."' class='responsive-img materialboxed'>
                        </div>
                        <div class='card-stacked center'>
                            <div class='card-content'>
                                <span class='card-title Detalle cursor-pointer light-blue-text' style='cursor:pointer' data-id=".$rowPF['IdPrecioVenta'].">".$rowPF['Producto']."</span>
                            </div>
                            <div class='card-action'>
                                <p class='font-weight-bold'>S/. ".number_format($ArrayPrec[0],2)."</p>
                            </div>
                        </div>
                    </div>
                </div>
                ";
        }$resultPF->free_result();
    } else {
        $html = "
        <div class='center'>
            <h3>No se encontro ningun producto</h3>
        </div>
        ";
    }

    echo $html;
    
?>