<?php
	include('connection.php');
	$response=new stdClass();

	$sql="begin SP_AF_VALPEDCOLAUDMED(:PEDIDO,:DSCCOL,:CONTADOR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt,':DSCCOL', $_POST['dsccol']);
	oci_bind_by_name($stmt,':CONTADOR', $contador,40);
	$result=oci_execute($stmt);
	if ($contador!=0) {
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="No se encontro estilo para el pedido - color";
	}	

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>