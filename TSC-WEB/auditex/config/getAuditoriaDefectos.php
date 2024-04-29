<?php
	include('connection.php');
	$response=new stdClass();


	$tipoauditoria = isset($_POST['fichatipoauditoria'])  ?  $_POST['fichatipoauditoria'] : "N";

	$sql="BEGIN SP_AT_SELECT_AUDDETDEF_V2(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:TIPOAUDITORIA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':TIPOAUDITORIA', $tipoauditoria);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$defectos=[];
	$i=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$defecto=new stdClass();
		$defecto->CODDEF=$row['CODDEF'];
		$defecto->DESDEF=utf8_encode($row['DESDEF']);
		$defecto->CODOPE=$row['CODOPE'];
		$defecto->DESOPE=utf8_encode($row['DESOPE']);
		$defecto->CANDEF=$row['CANDEF'];
		$defectos[$i]=$defecto;
		$i++;
	}
	$response->state=true;
	$response->defectos=$defectos;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>