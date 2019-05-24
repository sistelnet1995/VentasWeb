<?php
    session_start();

    require 'php/get.php';
    $get = new get();

    $resultC = $get->getSP("get_categorias()"); 
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
                        <button class="waves-effect waves-light btn" id="Filtrar" style="width:100%"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="col s6">
                        <a class="waves-effect waves-light btn" id="Limpiar" style="width:100%"><i class="fas fa-broom"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 m9">
            <div class="card-panel">
                <nav>
                    <div class="nav-wrapper light-blue accent-3 black-text">
                        <div class="col s12">
                        </div>
                    </div>
                </nav>
                <div class="progress invisible">
                    <div class="indeterminate"></div>
                </div>
                <div class="row" id="productos"></div>
            </div>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script src="js/catalogo.js"></script>
    
</body>
</html>