<?php
	ini_set('max_execution_time', 240);
	include('connection.php');
	$response=new stdClass();/*
	$sqlDefectos="select * from DEFECTO where ESTADO='A'";
	$stmt=oci_parse($conn, $sqlDefectos);
	$result=oci_execute($stmt);
	$defectos=array();
	$i=0;
	while($row=oci_fetch_array($stmt,OCI_ASSOC)){
		$defecto=new stdClass();
		$defecto->coddef=$row['CODDEF'];
		$defecto->desdef=utf8_encode($row['DESDEF']);
		$defecto->estado=$row['ESTADO'];
		$defectos[$i]=$defecto;
		$i++;
	}*/
	$defectos=[];
	$i=0;
	$sql="BEGIN SP_AFC_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$defecto=new stdClass();
		$defecto->CODDEF=$row['CODDEF'];
		$defecto->DESDEF=utf8_encode($row['DESDEF']);
		//array_push($defectos,$defecto);
		$defectos[$i]=$defecto;
		$i++;
	}
	$response->state=true;
	$response->defectos=$defectos;	

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>