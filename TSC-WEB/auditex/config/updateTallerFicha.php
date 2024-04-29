<?php
	session_start();
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AT_ASIGNAR_FICAUDTAL(:CODFIC,:PARTE,:CODTAD,:CODTLL,:NUECODTLL,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':NUECODTLL', $_POST['nuecodtll']);
	oci_bind_by_name($stmt, ':CODUSU', $_SESSION['user']);
	$result=oci_execute($stmt);
	if($result){			
		$response->state=true;
		$response->detail="Ficha actualizada";
	}else{
		$response->state=false;
		$response->detail="No se pudo actualizar la ficha";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>