<?php
	ini_set('max_execution_time', 240);
	include('connection.php');
	$response=new stdClass();
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
	}
	if (!isset($_GET['onlydefect'])) {
		$sqlOperaciones="select * from OPERACION where ESTADO='A'";
		$stmt=oci_parse($conn, $sqlOperaciones);
		$result=oci_execute($stmt);
		$operaciones=array();
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$defecto=new stdClass();			
			$defecto->codope=$row['CODOPE'];
			$defecto->desope=utf8_encode($row['DESOPE']);
			$operaciones[$i]=$defecto;
			$i++;
		}
		$response->operaciones=$operaciones;		
	}
	$response->state=true;
	$response->defectos=$defectos;	
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>