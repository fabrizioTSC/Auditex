<?php
	include('connection.php');
	$response=new stdClass();

	$sqlDefectos="BEGIN SP_AT_UPDATE_PARAMETRO(:CODTAD,:CODRAN,:VALOR); END;";
	$stmt=oci_parse($conn, $sqlDefectos);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':CODRAN', $_POST['codran']);
	oci_bind_by_name($stmt, ':VALOR', $_POST['valor']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail=utf8_encode("No se pudo guardar el parámetro!");
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>