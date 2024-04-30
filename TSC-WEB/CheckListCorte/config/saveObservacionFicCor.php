<?php
	include('connection.php');
	$response = new stdClass();
	
	// Llamada al procedimiento almacenado para insertar observación
	$sql = "EXEC AUDITEX.SP_AFC_INSERT_OBSFICCOR ?, ?, ?, ?, ?";
	$params = array(
		$_POST['codfic'], 
		$_POST['numvez'], 
		$_POST['parte'], 
		$_POST['codtad'], 
		$_POST['obs']
	);
	$stmt = sqlsrv_prepare($conn, $sql, $params);
	$result = sqlsrv_execute($stmt);
	
	// Manejo de respuesta
	if ($result) {
		$response->state = true;
		$response->detail = "¡Observación guardada!";
	} else {
		$response->state = false;
		$response->detail = "¡No se pudo guardar la Observación!";
	}
	
	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);


/*	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AFC_INSERT_OBSFICCOR(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OBS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':OBS',$_POST['obs']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->detail="Observacion guardada!";
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar la Observacion!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response); */
?>