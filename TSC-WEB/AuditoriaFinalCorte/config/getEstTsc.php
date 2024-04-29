<?php
	include('connection.php');
	$response=new stdClass();

	$esttsc=[];
	$i=0;
	$sql="BEGIN SP_AFC_SELECT_ESTTSCFOR(:ESTTSC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODMED=$row['CODMED'];
		$obj->DESMED=utf8_encode($row['DESMED']);
		$obj->DESMEDCOR=$row['DESMEDCOR'];
		$obj->PARTE=$row['PARTE'];
		$obj->AUDITABLE=$row['AUDITABLE'];
		$esttsc[$i]=$obj;
		$i++;
	}
	$response->esttsc=$esttsc;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>