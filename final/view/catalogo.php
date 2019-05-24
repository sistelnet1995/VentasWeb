<?php
    session_start();

	if(isset($_SESSION['usuario'])) {
        
    } else {
        $_SESSION['usuario'] = null;
    }

    require '../php/get.php';
    $get = new get();

    $tienda = $_SESSION['tienda'];
    $resultC = $get->getSP("get_categorias()");

    if(isset($_POST['NombreProducto'])){
        $NombreProducto = $_POST['NombreProducto'];
        $resultPV = $get->getSP("get_ProductosxProductoxTienda('$NombreProducto', '$tienda')");
    } else {
        $resultPV = $get->getSP("get_ProductosxIdProductoxTiendaxTipoVenta(NULL, '$tienda')");
        $IdCategoria = 0; $IdSubCategoria = 0; $pMin = null; $pMax = null;

        if(isset($_POST['Categoria']) && isset($_POST['SubCategoria']) && isset($_POST['pMin']) && isset($_POST['pMax'])){
            $IdCategoria = $_POST['Categoria'];
            $IdSubCategoria = $_POST['SubCategoria'];
            $pMin = $_POST['pMin'];
            $pMax = $_POST['pMax'];            

            if($pMin == NULL && $pMax == NULL){
                $resultPV = $get->getSP("get_ProductoxIdCategoriaxIdSubCategoriaxPMinxPMaxxTienda('$IdCategoria', '$IdSubCategoria', NULL, NULL,'$tienda')");
            }

            if($IdSubCategoria == 0 && $pMin == NULL && $pMax == NULL){
                $resultPV = $get->getSP("get_ProductoxIdCategoriaxIdSubCategoriaxPMinxPMaxxTienda('$IdCategoria', NULL, NULL, NULL,'$tienda')");
            }

            if($IdCategoria == 0 && $IdSubCategoria == 0 && $pMin == NULL && $pMax == NULL){
                $resultPV = $get->getSP("get_ProductosxIdProductoxTiendaxTipoVenta(NULL, '$tienda')");
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <?php require '../include/head.php'; ?>
    <title><?php echo $_SESSION['Sistema'] . 'Catalogo de Productos'; ?></title>

</head>

<body>

    <?php require '../include/header.php'; ?>
    <?php require '../include/sidenav.php'; ?>

    <section class="container-fluid">
        <h4 class="text-center font-weight-bold mt-5">CÁTALOGO DE PRODUCTOS</h4>
        <hr class="my-4">
        <div class="form-row mt-5">

            <form name="BuscarProducto" action="catalogo.php" method="POST" class="col-md-3">
                <div class="form-group col-md-8 m-auto">
                    <div class="row">
                        <label>Categoria</label>
                    </div>
                    <div class="row">
                        <select name="Categoria" id="Categoria" class="form-control">
                            <option value="0">Todo</option>
                            <?php while ($rowC = $resultC->fetch_assoc()) { ?>
                                <option value="<?php echo $rowC['IdCategoria']; ?>" > 
                                    <?php echo $rowC['Categoria']; ?>
                                </option>
                            <?php }  $resultC->free_result(); ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-8 ml-auto mr-auto mt-3">
                    <div class="row">
                        <label>Sub Categoria</label>
                    </div>
                    <div class="row">
                        <select name="SubCategoria" id="SubCategoria" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-8 ml-auto mr-auto mt-3">
                    <div class="row">
                        <label>Precio</label>
                    </div>
                    <div class="row">
                        <input type="number" name="pMin" min="0" max="10000" id="pMin" class="form-control col-md-5" placeholder="Min">
                        <p class="col-md-2"></p>
                        <input type="number" name="pMax" min="0" max="10000" id="pMax" class="form-control col-md-5" placeholder="Max">
                    </div>
                </div>
                <div class="form-group col-md-8 ml-auto mr-auto mt-3">
                    <div class="row">
                        <button class="btn btn-outline-primary col-md-5" type="submit"><i class="fas fa-search"></i></button>
                        <p class="col-md-2"></p>
                        <button class="btn btn-outline-primary col-md-5" type="reset"><i class="fas fa-broom"></i></button>
                    </div>
                </div>
            </form>

            <div class="col-md-9">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <?php 
                            if(isset($_POST['NombreProducto'])) {
                        ?>
                            <li class="breadcrumb-item active" aria-current="page">Filtrado por: <?php echo $_POST['NombreProducto']; ?></li>
                        <?php }
                        
                            elseif($IdCategoria == 0 && $IdSubCategoria == 0 && $pMin == null && $pMax == null) { ?>
                            <li class="breadcrumb-item active" aria-current="page">Todo</li>
                        <?php } elseif ($IdCategoria != 0 && $IdSubCategoria == 0 && $pMin == null && $pMax == null) { ?>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php include '../php/incCategoria.php'; ?>
                             </li>
                            
                        <?php } elseif ($IdCategoria != 0 && $IdSubCategoria != 0 && $pMin == null && $pMax == null) { ?>
                            <li class="breadcrumb-item" aria-current="page">
                                <?php include '../php/incCategoria.php'; ?>
                             </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php include '../php/incSubCategoria.php'; ?>
                            </li>
                        <?php } else {?>
                            <li class="breadcrumb-item" aria-current="page">
                                <?php include '../php/incCategoria.php'; ?>
                             </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <?php include '../php/incSubCategoria.php'; ?>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Desde: S/.<?php echo $pMin . ' - S/.'. $pMax;  ?></li>
                        <?php } ?>
                    </ol>
                </nav>
                
                <div class="d-flex justify-content-around flex-wrap text-center">
                    <?php while ($rowPV = $resultPV->fetch_assoc()) { ?>
                        <div class="card mt-3 card-index card-width-height">
                            <a href="" class="DetalleProd">
                                <img class="card-img-top img-fluid" src="<?php echo $rowPV['Imagen']; ?>" alt="">
                                <label class="IdProd" hidden><?php echo $rowPV['IdProducto'] ?></label>
                            </a>
                            <div class="card-body d-flex justify-content-center align-items-end">
                                <h6 class="card-title font-weight-bold linkNomre"><a href="" class="text-info DetalleProd" ><?php echo $rowPV['Producto']; ?><label class="IdProd" hidden><?php echo $rowPV['IdProducto'] ?></label></a></h6>
                            </div>
                            <div class="card-footer bg-white">
                                <h5>
                                    <span>
                                    <?php        
                                        $Prec = $rowPV['Precios'];
                                        $ArrayPrec = explode(",", $Prec);
                                        echo 'S/.' . number_format($ArrayPrec[0],2); 
                                    ?>
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <?php } $resultPV->free_result(); ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php require '../include/footer.php'; ?>
    <?php require '../include/script.php'; ?>
</body>

</html>