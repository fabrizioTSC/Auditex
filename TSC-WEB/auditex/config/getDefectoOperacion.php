<?php
	ini_set('max_execution_time', 240);
	include('connection.php');
	$response=new stdClass();

	$defectos=array();
	$i=0;
	$sqlDefectos="BEGIN SP_AT_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sqlDefectos);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$defecto=new stdClass();
		$defecto->coddef=$row['CODDEF'];
		$defecto->desdef=utf8_encode($row['DESDEF']);
		$defecto->estado=$row['ESTADO'];
		$defectos[$i]=$defecto;
		$i++;
	}
	$response->defectos=$defectos;
	if (!isset($_GET['onlydefect'])) {
		$operaciones=array();
		$i=0;
		$sqlDefectos="BEGIN SP_AT_SELECT_OPERACIONES(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sqlDefectos);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$defecto=new stdClass();			
			$defecto->codope=$row['CODOPE'];
			$defecto->desope=utf8_encode($row['DESOPE']);
			$operaciones[$i]=$defecto;
			$i++;
		}
		$response->operaciones=$operaciones;		
	}
	$response->state=true;
	
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>