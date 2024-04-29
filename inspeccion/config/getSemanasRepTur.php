<?php
	include('connection.php');
	$response=new stdClass();

	$semanas=[];
	$i=0;	
	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_SEMTUR(:ANIO,:OUTPUT_CUR); END;');
	oci_bind_by_name($stmt,":ANIO", $_POST['anio']);
	$OUTPUT_CUR = oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);   
	$result=oci_execute($stmt); 
	oci_execute($OUTPUT_CUR);
	while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
		$obj=new stdClass();
		$obj->SEMANA=$row['SEMANA'];
		$semanas[$i]=$obj;
		if($i==0){
			$semana=$row['SEMANA'];
		}
		$i++;
	}
	$response->semanas=$semanas;	
	$response->semana=$semana;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>