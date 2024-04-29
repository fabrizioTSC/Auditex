<?php
	set_time_limit(480);
	include('connection.php');
	$response=new stdClass();

	$detalle=[];
	$i=0;
	$sql="BEGIN SP_ACA_SELECT_PEDCOL_X_FIC(:PEDIDO,:DSCCOL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':DSCCOL', $_POST['dsccol']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODFIC=$row['CODFIC'];
		$obj->CANFICHA=$row['CANFICHA'];
		$obj->CANFICHAAUDITADA=$row['CANFICHAAUDITADA'];
		array_push($detalle,$obj);
	}

	if (oci_num_rows($OUTPUT_CUR)!=0) {
		$response->state=true;
		$response->detalle=$detalle;
	}else{
		$response->state=false;
		$response->detail="No hay fichas disponibles!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>