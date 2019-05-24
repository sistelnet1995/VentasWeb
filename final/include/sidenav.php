<?php
    $IdUsuario = $_SESSION['usuario'][0]['Id'];
    $resultCU = $get->getSP("get_ClientexIdUsuario('$IdUsuario')");
?>

<ul id="slide-side" class="sidenav">
    <?php while ($rowCU = $resultCU->fetch_assoc()) { ?>
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="../img/users/fondo/fondo-default.jpg" />
                </div>
                <a href="#user" class="a-sidenav"><img class="circle" src="../img/users/user/usuario-default.jpg"/></a>
                <a href="#name" class="a-sidenav"><span class="white-text name"><?php echo $rowCU['NombreC']; ?></span></a>
                <a href="#email" class="a-sidenav"><span class="white-text email"><?php echo $rowCU['Email']; ?></span></a>
            </div>
        </li>
        <li><a class="subheader">Dirección: <?php echo $rowCU['Direccion']; ?></a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader">Cuenta: (<?php echo 'S/. '.number_format($rowCU['Monto'],2); ?>)<span id="MontoCredito" hidden><?php echo $rowCU['Monto']; ?></span></a></li>
        <li><a class="subheader">Puntos Bonus: (<?php echo $rowCU['Bonos'] . ' PB'; ?>)</a></li>
    <?php } $resultCU->free_result(); ?>
</ul>