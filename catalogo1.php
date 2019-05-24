<?php
    session_start();

    require 'php/get.php';
    $get = new get();

    
    $resultC = $get->getSP("get_categorias()");
    $tienda = $_SESSION['tienda'];

    if(isset($_POST['Categoria']) || isset($_POST['SubCategoria']) || isset($_POST['precio_min']) || isset($_POST['precio_max'])) {
        $tienda = $_SESSION['tienda'];
        if(!isset($_POST['Categoria'])) {
            $Categoria = 'null';
        } else {
            $Categoria = $_POST['Categoria'];
        }

        if(!isset($_POST['SubCategoria'])) {
            $SubCategoria = 'null';
        } else {
            $SubCategoria = $_POST['SubCategoria'];
        }

        if($_POST['precio_min'] == '') {
            $precio_min = 'null';
        } else {
            $precio_min = $_POST['precio_min'];
        }

        if($_POST['precio_max'] == '') {
            $precio_max = 'null';
        } else {
            $precio_max = $_POST['precio_max'];
        }

        $resultNC = $get->getSP("get_CategoriaxIdCategoria($Categoria)");
        while ($row = $resultNC->fetch_assoc()) {
            $NombreCategoria = $row['Categoria'];
        }
        $resultNC->free_result();

        $resultNSC = $get->getSP("get_SubCategoriaxIdSubCategoria($SubCategoria)");
        while ($row = $resultNSC->fetch_assoc()) {
            $NombreSubCategoria = $row['SubCategoria'];
        }
        $resultNSC->free_result();

        $resultPF = $get->getSP("get_ProductosxProductoxIdCategoriaxIdSubCategoria(null, $Categoria, $SubCategoria, $precio_min, $precio_max, '$tienda')");
    } else {
        $resultPF = $get->getSP("get_ProductosxProductoxIdCategoriaxIdSubCategoria(null, null, null, null, null, '$tienda')");
        $Categoria = 'null';
        $SubCategoria = 'null';
        $precio_min = 'null';
        $precio_max = 'null';
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php'; ?>
    <title>uMarket - Catálogo</title>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <main class="row">
        <div class="col s12 m3">
            <div class="card-panel">
                <div class="row">
                    <blockquote><h5 class="light-blue-text font-weight-bold uppercase">Catálogo</h5></blockquote>
                    <form action="catalogo.php" method="POST">
                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">search</i>
                                    <input type="text" id="producto" class="autocomplete">
                                    <label for="producto">Producto</label>
                                </div>
                            </div>
                        </div>
                        <div class="col s12">
                            <label>Categoria</label>
                            <select id="Categoria" name="Categoria" class="browser-default">
                                <option value="" disabled selected>Seleccione</option>
                                <?php while ($rowC = $resultC->fetch_assoc()) { ?>
                                    <option value="<?php echo $rowC['IdCategoria']; ?>"><?php echo $rowC['Categoria']; ?></option>
                                <?php } $resultC->free_result(); ?>
                            </select>
                        </div>
                        <div class="col s12">
                            <label>Sub Categoria</label>
                            <select id="SubCategoria" name="SubCategoria" class="browser-default" disabled>
                                <option value="" disabled selected>Seleccione</option>
                            </select>
                        </div>
                        <div class="input-field col s6">
                            <input id="precio_min" name="precio_min" type="number" class="number">
                            <label for="precio_min">Precio Min</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="precio_max" name="precio_max" type="number" class="number">
                            <label for="precio_max">Precio Max</label>
                        </div>
                        <div class="col s6">
                            <button class="waves-effect waves-light btn" id="Filtrar" type="submit" style="width:100%"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="col s6">
                            <a class="waves-effect waves-light btn" id="Limpiar" style="width:100%"><i class="fas fa-broom"></i></a>
                        </div>
                        <div class="col s12">
                            <div class="progress hide" id="Preloader">
                                <div class="indeterminate"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col s12 m9">
            <div class="card-panel">
                <nav>
                    <div class="nav-wrapper light-blue accent-3 black-text">
                        <div class="col s12">
                            <?php if($Categoria == 'null' && $SubCategoria == 'null' && $precio_min == 'null' && $precio_max == 'null') { ?>
                                <a class="breadcrumb">Todos los Productos</a>
                            <?php } ?>
                            <?php
                                if($Categoria != 'null') { ?>
                                <a class="breadcrumb"><?php echo $NombreCategoria; ?></a>
                            <?php } ?>
                            <?php if($SubCategoria != 'null') { ?>
                                <a class="breadcrumb"><?php echo $NombreSubCategoria; ?></a>
                            <?php } ?>
                            <?php if($precio_min != 'null' || $precio_max != 'null') { ?>
                                <a class="breadcrumb">Precio: <?php echo ($precio_min== 'null') ? 'S/. ' . number_format(0,2) : 'S/. ' . number_format($precio_min,2); ?><?php echo ($precio_max == 'null') ? ' a Más' : ' - S/. ' . number_format($precio_max,2); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </nav>
                <div class="row">
                    <?php 
                        if(mysqli_num_rows($resultPF) > 0) {
                        while ($rowPF = $resultPF->fetch_assoc()) { ?>
                        <div class="col s10 m6 l3 offset-s1">
                            <div class="card hoverable medium">
                                <div class="card-image">
                                    <img src="<?php echo $rowPF['Imagen']; ?>" class="responsive-img materialboxed">
                                </div>
                                <div class="card-stacked center">
                                    <div class="card-content">
                                        <a href="" class="card-title detalle_prod">
                                            <?php echo $rowPF['Producto']; ?>
                                            <span class="IdPrecioVenta" hidden><?php echo $rowPF['IdPrecioVenta'] ?></span>
                                        </a>
                                    </div>
                                    <div class="card-action">
                                        <p class="font-weight-bold">
                                            S/. 
                                            <?php
                                                $ArrayPrec = explode(",", $rowPF['Precios']);
                                                echo number_format($ArrayPrec[0],2); 
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                        $resultPF->free_result();} else { ?>
                        <div class="center">
                            <h3>No se encontro ningun producto</h3>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script src="js/catalogo.js"></script>
    
</body>
</html>