<?php
	include('connection.php');
	$response=new stdClass();


	$codfic = $_POST['codfic'];
	$numvez = $_POST['numvez'];
	$parte = $_POST['parte'];
	$codtad = $_POST['codtad'];
	$sec = $_POST['sec'];

	
	$sql="EXEC AUDITEX.SP_AFC_DELETE_OBSFICCOR ?, ?, ?, ?, ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(&$codfic, &$numvez, &$parte, &$codtad, &$sec));
	$result=sqlsrv_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Observacion eliminada!";
	}else{
		$response->state=false;
		$response->detail="No se pudo eliminar la Observacion!";
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>