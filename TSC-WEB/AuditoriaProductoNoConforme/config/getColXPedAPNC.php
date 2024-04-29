<?php
	include('connection.php');
	$response=new stdClass();

	$colores=[];
	$sql="BEGIN SP_APNC_SELECT_COLOR_PED(:PEDIDO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODFIC=$row['FICHA'];
		$obj->DSCCOL=utf8_encode($row['DSCCOL']);
		array_push($colores, $obj);
	}
	if (oci_num_rows($OUTPUT_CUR)==0) {
		$response->state=false;
		$response->detail="Pedido no existe";
	}else{
		$response->state=true;
		$response->colores=$colores;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>