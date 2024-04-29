<?php
	include('connection.php');
	$response=new stdClass();

	$defectos=[];
	$i=0;
	$sql="BEGIN SP_INSP_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->CODDEFAUX=$row['CODDEFAUX'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$defectos[$i]=$obj;
		$i++;			
	}
	$response->defectos=$defectos;

	$operaciones=[];
	$i=0;
	$sql="BEGIN SP_INSP_SELECT_OPERACIONES(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODOPE=$row['CODOPE'];
		$obj->DESOPE=utf8_encode($row['DESOPE']);
		$operaciones[$i]=$obj;
		$i++;			
	}
	$response->operaciones=$operaciones;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>