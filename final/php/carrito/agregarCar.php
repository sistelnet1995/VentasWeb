<?php

    session_start();

    require '../php/get.php';

    $NombreTienda = $_SESSION['tienda'];

    $get = new get();

    if(isset($_POST['Id'])) {
        $Id = $_POST['Id'];
        if(isset($_SESSION['carrito'])) {
            $arreglo = $_SESSION['carrito'];
            $encontrado = false;
            $numero = 0;

            for ($i=0; $i < count($arreglo); $i++) { 
                if ($arreglo[$i]['Id'] == $Id) {
                    $encontrado = true;
                    $numero = $i;
                }
            }

            if ($encontrado == false) {
                $resultn = $get->getSP("get_ProductosxIdProductoxTiendaxTipoVenta('$Id', '$NombreTienda')");
                while($row = $resultn->fetch_array()) {
                    $Producto = $row['Producto'];
                    $Imagen = $row['Imagen'];
                    $Prec = $row['Precios'];
                    $ArrayPrec = explode(",", $Prec);
                    $PrecioVenta = $ArrayPrec[0];
                    $PrecioCompra = $row['PrecioCompra'];
                    $Bono = $row['Bonos'];
                }
                $resultn->free_result();
                $datosNuevos = array(
                    'Id' => $Id,
                    'Producto' => $Producto,
                    'Imagen' => $Imagen,
                    'PrecioVenta' => $PrecioVenta,
                    'PrecioCompra' => $PrecioCompra,
                    'Bono' => $Bono,
                    'Cantidad' => 1
                );
                array_push($arreglo, $datosNuevos);
                $_SESSION['carrito'] = $arreglo;
            }
        } else {

            $result = $get->getSP("get_ProductosxIdProductoxTiendaxTipoVenta('$Id', '$NombreTienda')");
            while($row = $result->fetch_array()) {
                $Producto = $row['Producto'];
                $Imagen = $row['Imagen'];
                $Prec = $row['Precios'];
                $ArrayPrec = explode(",", $Prec);
                $PrecioVenta = $ArrayPrec[0];
                $PrecioCompra = $row['PrecioCompra'];
                $Bono = $row['Bonos'];
            }
            $result->free_result();     
            
            $arreglo[] = array(
                'Id' => $Id,
                'Producto' => $Producto,
                'Imagen' => $Imagen,
                'PrecioVenta' => $PrecioVenta,
                'PrecioCompra' => $PrecioCompra,
                'Bono' => $Bono,
                'Cantidad' => 1
            );
            $_SESSION['carrito'] = $arreglo;
        }
    }

?>