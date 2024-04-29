<?php
	include("connection.php");
	$response=new stdClass();

	$sql="BEGIN SP_INSP_DELETE_LINETOTUR_V2(:LINEA,:TURNO,:FECHA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
	oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
	oci_bind_by_name($stmt, ':FECHA', $_POST['fecha']);
	$result=oci_execute($stmt);
	if ($result==true) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo eliminar el turno ".$_POST['turno']." de la línea ".$_POST['linea']." para el día ".$_POST['fecha']."!";
	}

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>