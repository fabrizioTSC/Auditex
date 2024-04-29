<?php
	include('connection.php');
	$response=new stdClass();	

	$lineas=[];
	$i=0;
	$obj=new stdClass();
	$obj->LINEA="0";
	$obj->DESLIN="(TODOS)";
	$lineas[$i]=$obj;
	$i++;
	$sql="BEGIN SP_INSP_SELECT_LINEASETON(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);	
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->LINEA=$row['LINEA'];
		$obj->DESLIN=$row['LINEA'];
		$lineas[$i]=$obj;
		$i++;
	}		
	$response->lineas=$lineas;
	$response->state=false;
		
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>