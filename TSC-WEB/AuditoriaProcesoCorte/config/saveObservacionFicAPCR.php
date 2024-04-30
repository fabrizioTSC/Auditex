<?php
include('connection.php');
$response=new stdClass();

$codfic = $_POST['codfic'];
$numvez = $_POST['numvez'];
$parte = $_POST['parte'];
$codtad = $_POST['codtad'];
$obs = $_POST['obs'];

$sql="EXEC AUDITEX.SP_AFC_INSERT_OBSFICCOR ?, ?, ?, ?, ?;";
$stmt=sqlsrv_prepare($conn, $sql, array(&$codfic, &$numvez, &$parte, &$codtad, &$obs));

$result=sqlsrv_execute($stmt);
if ($result) {
	$response->state=true;
	$response->detail="Observacion guardada!";
}else{
	$response->state=false;
	$response->detail="No se pudo guardar la Observacion!";
}

sqlsrv_close($conn);
header('Content-Type: application/json');
echo json_encode($response);
?>