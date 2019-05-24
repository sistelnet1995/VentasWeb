<?php
    $resultCId = $get->getSP("get_CategoriaxIdCategoria('$IdCategoria')");
    while ($rowCId = $resultCId->fetch_assoc()) {
        echo $rowCId['Categoria'];
    }
?>