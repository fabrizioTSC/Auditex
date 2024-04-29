<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_DELETE_IMACALINT(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:RUTIMA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['dsccol']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':RUTIMA',$_POST['rutima']);
	$result=oci_execute($stmt);
	if ($result) {
		unlink("../assets/imgcalint/".$_POST['rutima']);
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Hubo un error al guardar los datos";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);