<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="BEGIN SP_APC_INSERT_AUDPROOPE_NEW(:CODFIC,:SECUEN,:CODPER,:CODOPE,:CANTPREN,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':SECUEN', $_POST['secuen']);
	oci_bind_by_name($stmt, ':CODPER', $_POST['codper']);
	oci_bind_by_name($stmt, ':CODOPE', $_POST['codope']);
	oci_bind_by_name($stmt, ':CANTPREN', $_POST['cantpren']);

	$estado=0;
	oci_bind_by_name($stmt, ':ESTADO', $estado);
	$result=oci_execute($stmt);
	if ($estado==0) {
		$response->state=true;
	}else{
		$response->state=false;
		$error->detail="Ya existe la operacion con el operador!";
		$response->error=$error;
	}
	
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>