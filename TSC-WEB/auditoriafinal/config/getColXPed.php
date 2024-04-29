<?php
	include('connection.php');
	$response=new stdClass();

	$colores=[];
	$i=0;
	$sql="BEGIN SP_ACA_SELECT_PED_X_COL(:PEDIDO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->DSC_COLOR=utf8_encode($row['DSC_COLOR']);
		$obj->CANPEDCOL=$row['CANPEDCOL'];
		$obj->CANFICHA=$row['CANFICHA'];
		$obj->CANFICHAAUDITADA=$row['CANFICHAAUDITADA'];
		array_push($colores,$obj);

		$response->PO_CLI=utf8_encode($row['PO_CLI']);
		$response->ESTILO_CLI=utf8_encode($row['ESTILO_CLI']);
	}

	if (oci_num_rows($OUTPUT_CUR)!=0) {
		$response->state=true;
		$response->colores=$colores;
	}else{
		$response->state=false;
		$response->detail="No hay colores disponibles!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>