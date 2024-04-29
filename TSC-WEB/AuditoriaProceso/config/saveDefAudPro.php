<?php
	include('connection.php');
	$response = new stdClass();

	$sql="BEGIN SP_APC_INSERT_AUDPROOPEDET_NEW(:CODFIC,:SECUEN,:CODPER,:CODOPE,:NUMVEZ,:USUARIOFIN,:CODDEF,:CANDEF,:OBSERVACION,:ESTADO,:MAXDEFECTOS); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':SECUEN', $_POST['secuen']);
	oci_bind_by_name($stmt, ':CODPER', $_POST['codper']);
	oci_bind_by_name($stmt, ':CODOPE', $_POST['codope']);

	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':USUARIOFIN', $_POST['usuario']);


	$candef = (float)$_POST['candef'];

	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	oci_bind_by_name($stmt, ':CANDEF', $candef );
	oci_bind_by_name($stmt, ':OBSERVACION', $_POST['observacion']);

	$estado=0;
	$maxdefectos=0;


	oci_bind_by_name($stmt, ':ESTADO', $estado,32);
	oci_bind_by_name($stmt, ':MAXDEFECTOS', $maxdefectos,32);


	$result=oci_execute($stmt);
	if ($estado==0) {
		$response->state=true;
		$response->detail="Guardado!";
		$response->maxdefectos=$maxdefectos;

	}else{
		$response->state=true;
		$response->maxdefectos=$maxdefectos;
		$response->detail="Actualizado!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>