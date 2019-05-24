<?php
	session_start();

	if(!isset($_SESSION['usuario'])) {
        header("Location: login.php?Debe Iniciar Sesion");
    }

    require '../php/get.php';
    $get = new get();

    $IdUsuario = $_SESSION['usuario'][0]['Id'];

    $resultCC = $get->getSP("get_CanjexIdUsuario('$IdUsuario')");
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require '../include/head.php'; ?>
	<title><?php echo $_SESSION['Sistema'] . 'Mis Canjes'; ?></title>
</head>
<body>

    <?php require '../include/header.php'; ?>
    <?php require '../include/sidenav.php'; ?>
	
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-5">
                <div class="card text-center">
                    <div class="card-header">Mis Canjes</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed text-center" id="IdDataTable">
                                <thead class="bg-dark text-white font-weight-bold">
                                    <tr>
                                        <td>#</td>
                                        <td>Imagen</td>
                                        <td>Producto</td>
                                        <td>Cantidad</td>
                                        <td>Fecha</td>
                                        <td>Hora</td>
                                    </tr>
                                </thead>
                                <tfoot class="bg-secondary text-white font-weight-bold">
                                    <tr>
                                        <td>#</td>
                                        <td>Imagen</td>
                                        <td>Producto</td>
                                        <td>Cantidad</td>
                                        <td>Fecha</td>
                                        <td>Hora</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        while ($rowCC = $resultCC->fetch_assoc()) { ?>
                                        <tr>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td><img src="<?php echo $rowCC['Imagen']; ?>" style="width: 3rem;"></td>
                                            <td><?php echo $rowCC['Producto'] ?></td>
                                            <td><?php echo $rowCC['CantidadCanjeada'] ?></td>
                                            <td><?php echo $rowCC['FechaCanje'] ?></td>
                                            <td><?php echo $rowCC['HoraCanje'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php require '../include/footer.php'; ?>
    <?php require '../include/script.php'; ?>
    <script src="../js/datatable.js"></script>

</body>
</html>