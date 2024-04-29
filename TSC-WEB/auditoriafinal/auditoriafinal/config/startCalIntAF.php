<?php
	include('connection.php');
	$response=new stdClass();

	$sql="begin SP_AF_UPDATE_STACALINT(:PEDIDO,:DSCCOL,:PARTE,:NUMVEZ,:CODUSU); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt,':DSCCOL', $_POST['dsccol']);
	oci_bind_by_name($stmt,':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ', $_POST['numvez']);
	session_start();
	oci_bind_by_name($stmt,':CODUSU', $_SESSION['user']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se pudo iniciar la auditoria";
	}	

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>