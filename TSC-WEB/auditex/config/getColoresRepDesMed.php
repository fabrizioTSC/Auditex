<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	
	$colores=array();
	$sql="BEGIN SP_AA_SELECT_COLORESEPDESMED(:PEDIDO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODCOL=$row['DSCCOL'];
		$obj->DESCOL=$row['DSCCOL'];
		array_push($colores,$obj);
	}
	$response->state=true;
	$response->colores=$colores;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>