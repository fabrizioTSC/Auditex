<?php
	include('connection.php');
	$response = new stdClass();

	$codfic = $_POST['codfic'];
	$codenv = $_POST['codenv'];
	$codtll = $_POST['codtll'];
	$codcel = $_POST['codcel'];

	$sql = "EXEC AUDITEX.SP_CLC_UPDATE_TLLXFIC ?, ?, ?, ?";
	$stmt = sqlsrv_prepare($conn, $sql, array($codfic, $codenv, $codtll, $codcel));
	$result = sqlsrv_execute($stmt);

	if ($result) {
		$response->state = true;
	} else {
		$response->state = false;
		$response->detail = "No se pudo actualizar la ficha";
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>