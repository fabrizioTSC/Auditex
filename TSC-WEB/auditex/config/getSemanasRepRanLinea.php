<?php
	include('connection.php');
	$response=new stdClass();

	$semanas=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_SEMANASXANIO(:ANIO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':ANIO', $_POST['anio']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
		$obj->MIN=$row['MIN'];
		$obj->MAX=$row['MAX'];
		$semanas[$i]=$obj;
		$i++;
	}
	$response->semanas=$semanas;
	$response->state=true;
		
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>