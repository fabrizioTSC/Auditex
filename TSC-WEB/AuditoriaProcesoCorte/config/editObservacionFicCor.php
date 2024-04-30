<?php
	include('connection.php');
	$response=new stdClass();


	$codfic = $_POST['codfic'];
	$numvez = $_POST['numvez'];
	$parte = $_POST['parte'];
	$codtad = $_POST['codtad'];
	$sec = $_POST['sec'];
	$obs = $_POST['obs'];

	
	$sql="EXEC AUDITEX.SP_AFC_UPDATE_OBSFICCOR ?, ?, ?, ?, ?, ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(&$codfic, &$numvez, &$parte, &$codtad, &$sec, &$obs));
	$result=sqlsrv_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Observacion editada!";
	}else{
		$response->state=false;
		$response->detail="No se pudo editar la Observacion!";
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>