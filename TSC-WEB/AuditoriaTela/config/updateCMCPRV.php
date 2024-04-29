<?php
	include('connection.php');
	$response=new stdClass();

	session_start();
	$codusu=$_SESSION['user'];
	$sql="BEGIN SP_AUDTEL_UPDATE_PARAUDCMCPRV (:PARTIDA, :CODTEL, :CODPRV,:CODTAD, :NUMVEZ, :PARTE,:CMCPRV); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':CMCPRV', $_POST['cmcprv']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="CMC proveedor guardado";
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar CMC proveedor";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);