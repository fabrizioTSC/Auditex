<?php
	include('connection.php');
	$response=new stdClass();

	$talleres=[];
	$i=0;
	
	$stmt = oci_parse($conn,'BEGIN SP_INSP_SELECT_TALLERES(:OUTPUT_CUR); END;');
	// Declare your cursor         
	$OUTPUT_CUR = oci_new_cursor($conn);
	oci_bind_by_name($stmt,":OUTPUT_CUR", $OUTPUT_CUR, -1, OCI_B_CURSOR);    
	// Execute statement               
	$result=oci_execute($stmt); 
	// Execute the cursor
	oci_execute($OUTPUT_CUR);
	while ($row = oci_fetch_assoc($OUTPUT_CUR)) {		
		$obj=new stdClass();
		$obj->CODTLL=$row['CODTLL'];
		$obj->DESTLL=utf8_encode($row['DESTLL']);
		$obj->DESCOM=utf8_encode($row['DESCOM']);
		$talleres[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->talleres=$talleres;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>