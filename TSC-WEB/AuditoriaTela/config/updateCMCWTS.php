<?php
	include('connection.php');
	$response=new stdClass();

	session_start();
	$codusu=$_SESSION['user'];
	$sql="BEGIN SP_AUDTEL_UPDATE_PARAUDCMCWTS (:PARTIDA, :CODTEL, :CODPRV,:CODTAD, :NUMVEZ, :PARTE,:CMCWTS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':CMCWTS', $_POST['cmcwts']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="CMC WTS guardado";
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar CMC WTS";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);