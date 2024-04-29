<?php
	include('connection.php');
	$response=new stdClass();

	$array=$_POST['array'];
	$ec=0;
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_AF_UPDATE_DETCHELIS(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:CODCL,:VALOR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':CODCL',$array[$i][0]);
		oci_bind_by_name($stmt,':VALOR',$array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$ec++;
		}
	}
	if ($ec==0) {
		$response->state=true;
	}else{
		$response->detail="No se pudieron guardar algunos detalles";
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>