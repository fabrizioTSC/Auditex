<?php
	include('connection.php');

	// EJECUTAMOS CARGA DEL SIGE
	require_once '../../../tsc/models/modelo/core.modelo.php';

	$response=new stdClass();
    $objModelo = new CoreModelo();
	$codtll =  $_POST['codtll'];


	// ELIMINAMOS SI NO TIENE REGISTRADO
	// $responsereload = $objModelo->setAll("AUDITEX.RELOADSIGETOAUDITEX_COSTURA",[$codtll],"Recargado correctamente");

	// CARGAMOS SIGE
	// $responsecargasige = $objModelo->setAllSQL("uspCargaAuditoriaEnvioTallerToAuditex",[$codtll,null],"Correcto");

	$fichas=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_FICXTALINITER(:CODTLL,:ESTADO,:OUTPUR_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL',$_POST['codtll']);
	oci_bind_by_name($stmt, ':ESTADO',$_POST['estado']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUR_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj=$row;
		$fichas[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->fichas=$fichas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>