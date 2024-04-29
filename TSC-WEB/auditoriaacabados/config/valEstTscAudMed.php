<?php

	require_once '../../../TSC/models/modelo/core.modelo.php';
	include('connection.php');


	$response=new stdClass();
	$objModelo 	= new CoreModelo();


	// CARGAMOS MEDIDAS SI NO EXISTEN
	// EJECUTAMOS CARGA DEL SIGE
	$responsesige = $objModelo->setAllSQLSIGE("uspGetSetMedidasAuditex",[4,null,$_POST['codfic'],null],"Correcto");


	$val_round=1;
	$sql="BEGIN SP_AA_VAL_ESTTSCXCODFIC(:CODFIC,:CONTADOR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CONTADOR', $contador,40);
	$result=oci_execute($stmt);
	if($contador!=0){
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No hay medidas para la ficha";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>