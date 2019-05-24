<?php
    $resultSCId = $get->getSP("get_SubCategoriaxIdSubCategoria('$IdSubCategoria')");
     while ($rowSCId = $resultSCId->fetch_assoc()) {
        echo $rowSCId['SubCategoria'];
    }
?>