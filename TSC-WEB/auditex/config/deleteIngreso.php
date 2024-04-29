<?php
	session_start();
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AT_DEL_INIFICHAS(:CODFIC,:PARTE,:CODTLL,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt, ':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt, ':CODTLL',$_POST['codtll']);
	oci_bind_by_name($stmt, ':CODUSU',$_SESSION['usuario']);
	$result=oci_execute($stmt);
	if (!$result) {
		$response->state=false;
		$response->detail="No se pudo eliminar ingreso!";
	}else{
		$response->state=true;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>