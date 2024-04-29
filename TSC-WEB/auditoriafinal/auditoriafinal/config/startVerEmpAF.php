<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_UPDATE_AUD(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:CODUSU,:PORAUD); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['color']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	session_start();
	$codusu=$_SESSION['user'];
	oci_bind_by_name($stmt,':CODUSU',$codusu);
	oci_bind_by_name($stmt,':PORAUD',$_POST['poraud']);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
	}else{
		$response->detail="No se pudo iniciar el verificado de empaque";
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>