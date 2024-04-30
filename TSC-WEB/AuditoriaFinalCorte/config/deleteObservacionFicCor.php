<?php
	include('connection.php');
	$response=new stdClass();

	$sql="EXEC AUDITEX.SP_AFC_DELETE_OBSFICCOR ?, ?, ?, ?, ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(
		&$_POST['codfic'], 
		&$_POST['numvez'], 
		&$_POST['parte'], 
		&$_POST['codtad'], 
		&$_POST['sec']
	));
	$result=sqlsrv_execute($stmt);

	if ($result) {
		$response->state=true;
		$response->detail="¡Observación eliminada!";
	}else{
		$response->state=false;
		$response->detail="¡No se pudo eliminar la observación!";
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);


/*	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AFC_DELETE_OBSFICCOR(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:SEC); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':SEC',$_POST['sec']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Observacion eliminada!";
	}else{
		$response->state=false;
		$response->detail="No se pudo eliminar la Observacion!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response); */
?>