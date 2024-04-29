<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$anios=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_ANIOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$anio=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ((int)date("Y")>=(int)$row['ANIO']) {
			$anio=(int)$row['ANIO'];
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$anios[$i]=$obj;
			$i++;
		}
	}
	$response->anios=$anios;
	$response->anio=$anio;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>