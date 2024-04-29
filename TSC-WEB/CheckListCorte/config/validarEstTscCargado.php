<?php
/*
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AFC_SELECT_ESTTSC(:ESTTSC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	if($row['CANTIDAD']=="0"||$row['CANTIDAD']==0){
		$response->state=true;
	}else{
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);	*/

	include('connection.php');
	$response=new stdClass();


	// var_dump($_POST['esttsc']);
	// var_dump($_POST['hilo']);
	// var_dump($_POST['travez']);
	// var_dump($_POST['largmanga']);


	$sql="BEGIN SP_AFC_SELECT_ESTTSC_J(:ESTTSC,:HILO,:TRAVEZ,:LARGMANGA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	$hilo=intval($_POST['hilo']);
	oci_bind_by_name($stmt, ':HILO', $hilo);
	$travez=intval($_POST['travez']);
	oci_bind_by_name($stmt, ':TRAVEZ', $travez);
	$largmanga=intval($_POST['largmanga']);
	oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);

	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	if($row['CANTIDAD']=="0"||$row['CANTIDAD']==0){
		$response->state=true;
	}else{
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);	
?>