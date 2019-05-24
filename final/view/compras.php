<?php
	session_start();

	if(!isset($_SESSION['usuario'])) {
        header("Location: login.php?Debe Iniciar Sesion");
    }

    require '../php/get.php';
    $get = new get();

    $IdUsuario = $_SESSION['usuario'][0]['Id'];

    $resultCC = $get->getSP("get_VentasxIdUsuario('$IdUsuario')");
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require '../include/head.php'; ?>
	<title><?php echo $_SESSION['Sistema'] . 'Mis Compras'; ?></title>
</head>
<body>

    <?php require '../include/header.php'; ?>
    <?php require '../include/sidenav.php'; ?>
	
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-5">
                <div class="card text-center">
                    <div class="card-header">Mis Compras</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed text-center" id="IdDataTable">
                                <thead class="bg-dark text-white font-weight-bold">
                                    <tr>
                                        <td>#</td>
                                        <td>Código de Entrega</td>
                                        <td>Estado de Entrega</td>
                                        <td>Tienda</td>
                                        <td>Más</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tfoot class="bg-secondary text-white font-weight-bold">
                                    <tr>
                                        <td>#</td>
                                        <td>Código de Entrega</td>
                                        <td>Estado de Entrega</td>
                                        <td>Tienda</td>
                                        <td>Más</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        while ($rowCC = $resultCC->fetch_assoc()) {
                                            if($rowCC['FkIdEstadoVenta'] == 1){
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td><?php echo $rowCC['CodigoEntrega'] ?></td>
                                            <td class="font-weight-bold text-uppercase EstadoEntrega">
                                                <?php
                                                    $Estado = $rowCC['EstadoEntrega'];
                                                    if($Estado == 'Pendiente')
                                                        echo "<label class=\"text-primary\">$Estado</label>";
                                                    else if ($Estado == 'Completo')
                                                        echo "<label class=\"text-success\">Enviado</label>";
                                                ?>   
                                            </td>
                                            <td><?php echo $rowCC['NombreTienda'] ?></td>
                                            <td class="text-center">
                                                <a href="" class="VerMas text-info">Ver más<label class="IdVenta" hidden><?php echo $rowCC['IdVenta'] ?></label></a>
                                            </td>
                                            <td class="text-center">
                                                <?php

                                                        if($Estado == 'Pendiente'){
                                                            $BtnEstadoCompra = 'Cancelar Pedido';
                                                            $ClassBtnEstadoCompra = 'btn-danger';
                                                            $HabilitadoBtn = '';
                                                        } else {
                                                            $HabilitadoBtn = 'disabled';
                                                        }
                                                    
                                                ?>
                                                <button class="btn <?php echo $ClassBtnEstadoCompra . ' ' . $HabilitadoBtn; ?> col-10 btnEstadoCompra"><?php echo $BtnEstadoCompra; ?>
                                                    <label class="IdVenta" hidden><?php echo $rowCC['IdVenta']; ?></label>
                                                    <label class="EstadoEntrega" hidden><?php echo $Estado; ?></label>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php }} ?>
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