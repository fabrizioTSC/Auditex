<?php
	$accesos=json_decode($_SESSION['accesos']);
	$permiso=0;
	for ($i=0; $i < count($accesos); $i++) {
		if ($accesos[$i]->CODTAD==$appcod) {
			$_SESSION['perfil']=$accesos[$i]->CODROL;
			$permiso++;
		}
	}
	if ($permiso==0) {
		echo "<h2>No tiene permisos para esta aplicación.</h2>";
		exit;
	}
