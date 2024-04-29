<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_ATR_FINISH(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo finalizar la auditoria!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>