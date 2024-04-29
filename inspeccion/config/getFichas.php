<?php
	include('connection.php');
	$response=new stdClass();

	$fichas=[];
	$i=0;
	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_FICHASXTALLER(:CODTLL,:OUTPUT_CUR); END;');
	oci_bind_by_name($stmt,':CODTLL',$_POST['codtll']);
	$OUTPUT_CUR = oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);    
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
		$obj=new stdClass();
		$obj->CODFIC=$row['CODFIC'];
		$obj->CANPAR=$row['CANPAR'];
		$obj->ESTTSC=$row['ESTTSC'];
		$fichas[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->fichas=$fichas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>