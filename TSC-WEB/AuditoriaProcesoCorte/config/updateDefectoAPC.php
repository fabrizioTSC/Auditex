<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$codfic = $_POST['codfic'];
	$numvez = $_POST['numvez'];
	$parte = $_POST['parte'];
	$codtad = $_POST['codtad'];
	$codope = $_POST['codope'];
	$coddef = $_POST['coddef'];
	$candef = $_POST['candef'];
	$estado = null;

	$sql="EXEC AUDITEX.SP_APCR_UPDATE_DETDEF ?, ?, ?, ?, ?, ?, ?";
	$stmt=sqlsrv_prepare($conn, $sql, array(
		&$codfic, 
		&$numvez, 
		&$parte, 
		&$codtad, 
		&$codope, 
		&$coddef, 
		&$candef
	));

	$result=sqlsrv_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->description="Defecto actualizado!";
	}else{
		$response->state=false;
		$error->description="No se pudo actualizar defecto!";
		$response->error=$error;
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

/*	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="BEGIN SP_APCR_UPDATE_DETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODOPE,:CODDEF,:CANDEF,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODOPE',$_POST['codope']);
	oci_bind_by_name($stmt,':CODDEF',$_POST['coddef']);
	oci_bind_by_name($stmt,':CANDEF',$_POST['candef']);
	oci_bind_by_name($stmt,':ESTADO',$estado,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->description="Defecto actualizado!";
	}else{
		$response->state=false;
		$error->description="No se pudo actualizar defecto!";
		$response->error=$error;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response); */
?>