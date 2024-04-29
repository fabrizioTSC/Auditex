<?php
	include('connection.php');
	$response=new stdClass();

	$operadores=array();
	$i=0;
	$sql="BEGIN SP_APC_SELECT_PERSONAL(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$operador=new stdClass();
		$operador->CODPER=$row['CODPER'];
		$operador->NOMPER=utf8_encode($row['NOMPER'])." (".$row['CODPER'].")";
		$operadores[$i]=$operador;
		$i++;
	}
	$response->operadores=$operadores;
	
	$operaciones=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_OPERACIONES(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$operacion=new stdClass();
		$operacion->CODOPE=$row['CODOPE'];
		$operacion->DESOPE=utf8_encode($row['DESOPE'])." (".$row['CODOPE'].")";
		$operaciones[$i]=$operacion;
		$i++;
	}
	$response->operaciones=$operaciones;
	
	$defectos=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$defecto=new stdClass();
		$defecto->CODDEF=$row['CODDEF'];
		$defecto->CODDEFAUX=$row['CODDEFAUX'];
		$defecto->DESDEF=utf8_encode($row['DESDEF'])." (".$row['CODDEFAUX'].")";;
		$defectos[$i]=$defecto;
		$i++;
	}
	$response->defectos=$defectos;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>