<?php
	include('connection.php');
	$response=new stdClass();

	// EJECUTAMOS CARGA DEL SIGE
	require_once '../../../tsc/models/modelo/core.modelo.php';

	$objModelo = new CoreModelo();

	$partida = $_POST['partida'];
	$responsecargasige = $objModelo->setAllSQLSIGE("uspSetGeneraDataAuditex",[9,null,null,null,null,$partida],"Correcto");

	$sql="BEGIN SP_AUDTEL_SELECT_PARAUDCON(:PARTIDA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$partidas=[];
	$i=0;
	while($row=oci_fetch_array($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTEL=$row['CODTEL'];
		$obj->CODPRV=$row['CODPRV'];
		$obj->DESPRV=utf8_decode($row['DESPRV']);
		$obj->CODTAD=$row['CODTAD'];
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->PARTE=$row['PARTE'];
		$obj->ESTADO=$row['ESTADO'];
		$obj->RESULTADO=$row['RESULTADO'];
		$obj->RESTONTSC=$row['RESTONTSC'];
		$obj->RESAPATSC=$row['RESAPATSC'];
		$obj->RESESTDIMTSC=$row['RESESTDIMTSC'];
		$partidas[$i]=$obj;
		$i++;
	}
	if(oci_num_rows($OUTPUT_CUR)==0){
		$response->state=false;
		$response->detail="Partida no encontrada!";
	}else{
		$response->state=true;
		$response->partidas=$partidas;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>