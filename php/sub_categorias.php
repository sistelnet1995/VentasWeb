<?php

    require 'get.php';

    $IdCategoria = $_POST['IdCategoria'];

    $get = new get();
    $resultP = $get->getSP("get_SubCategoriasxCategoria('$IdCategoria')");

    $html= "<option value='' disabled selected>Seleccione</option>";
	
	while($rowP = $resultP->fetch_assoc())
	{
		$html.= "<option value='".$rowP['IdSubCategoria']."'>".$rowP['SubCategoria']."</option>";
	}
	
	echo $html;

?>