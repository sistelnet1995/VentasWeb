<?php
    session_start();

    if(!isset($_SESSION['usuario'])) {
        header("Location: login.php");
    } else {
        require 'php/get.php';
        $get = new get();

        $IdCliente = $_SESSION['usuario'][0]['IdCliente'];

        $resultVC = $get->getSP("get_VentasxIdCliente('$IdCliente')");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'include/head.php'; ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <title>uMarket - Mis Compras</title>
</head>
<body>
    <?php include 'include/header.php'; ?>

    <main class="container">
        <div class="row">
            <div class="col s12">
                <div class="card">
                    <div class="card-content black-text">
                        <blockquote><h5 class="light-blue-text font-weight-bold uppercase">Mis Compras</h5></blockquote>
                        <div class="center">
                            <table class="highlight centered responsive-table" id="IdDataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Código de Entrega</th>
                                        <th scope="col">Estado de Entrega</th>
                                        <th scope="col">Tienda</th>
                                        <th scope="col">Más</th>
                                        <th scope="col">Cancelar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 1;
                                        while ($rowCC = $resultVC->fetch_assoc()) {
                                            if($rowCC['FkIdEstadoVenta'] == 1){
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td><?php echo $rowCC['CodigoEntrega'] ?></td>
                                            <td class="font-weight-bold text-uppercase EstadoEntrega">
                                                <?php
                                                    $Estado = $rowCC['EstadoEntrega'];
                                                    if($Estado == 'Pendiente')
                                                        echo "<label class=\"light-blue-text accent-3\">$Estado</label>";
                                                    else if ($Estado == 'Completo')
                                                        echo "<label class=\"teal-text accent-3\">Enviado</label>";
                                                ?>   
                                            </td>
                                            <td><?php echo $rowCC['NombreTienda'] ?></td>
                                            <td class="text-center">
                                                <a href="" class="VerMas cyan-text accent-4">Ver más<label class="IdVenta" hidden><?php echo $rowCC['IdVenta'] ?></label><label class="CostoAdicional" hidden><?php echo $rowCC['CostoAdicional']; ?></label></a>
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
                                                <button class="btn <?php echo $ClassBtnEstadoCompra . ' ' . $HabilitadoBtn;?> red btnEstadoCompra"><?php echo $BtnEstadoCompra; ?>
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
    </main>

    <?php include 'include/footer.php'; ?>
    <?php include 'include/scripts.php'; ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="js/compras.js"></script>
    
</body>
</html>
<?php } ?>