<?php
	include('connection.php');
	$response=new stdClass();

	$err=0;
	$array=$_POST['array'];
	for ($i=0; $i < count($array); $i++) { 
		$sql="BEGIN SP_AF_UPDATE_DETHUM(:PEDIDO,:DESCOL,:IDREG,:HUMEDAD); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
		oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
		oci_bind_by_name($stmt, ':IDREG', $array[$i][0]);
		oci_bind_by_name($stmt, ':HUMEDAD', $array[$i][1]);
		$result=oci_execute($stmt);
		if (!$result) {
			$err++;
		}
	}
	if ($err==0) {
		$sql="BEGIN SP_AF_UPDATE_PROCONHUM(:PEDIDO,:DESCOL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
		oci_bind_by_name($stmt, ':DESCOL', $_POST['dsccol']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$response->HUMPRO=str_replace(",",".",$row['HUMPRO']);
			$response->RESULTADO=$row['RESULTADO'];
		}
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="Hubo un error al guardar las humedades";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);