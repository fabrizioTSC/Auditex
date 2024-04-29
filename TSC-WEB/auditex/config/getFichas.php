<?php
	include('connection.php');
	
	// EJECUTAMOS CARGA DEL SIGE
    	require_once '../../../tsc/models/modelo/core.modelo.php';

    	$objModelo = new CoreModelo();
	$codtll =  $_POST['codtll'];

	// // ELIMINAMOS SI NO TIENE REGISTRADO
	// $responsereload = $objModelo->setAll("AUDITEX.RELOADSIGETOAUDITEX_COSTURA",[$codtll],"Recargado correctamente");

	// // CARGAMOS SIGE
	// $responsecargasige = $objModelo->setAllSQL("uspCargaAuditoriaEnvioTallerToAuditex",[$codtll,null],"Correcto");
	
	$response=new stdClass();
	
	$fichas=array();
	$i=0;
	$sql="begin SP_AT_SELECT_FICHASXTALLER(:CODTLL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODTLL', $_POST['codtll']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
		
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$ficha=new stdClass();
		$ficha->CODFIC=$row['CODFIC'];
		$ficha->CANPAR=$row['CANPAR'];
		$ficha->PARTE=$row['PARTE'];
		$ficha->NUMVEZ=$row['NUMVEZ'];
		$ficha->CODAQL=$row['CODAQL'];
		$ficha->AQL=$row['AQL'];
		$ficha->CODTAD=$row['CODTAD'];
		$ficha->TIPAUD=$row['TIPAUD'];
		$fichas[$i]=$ficha;
		$i++;
	}

	if (oci_num_rows($OUTPUT_CUR)==0) {			
		$response->state=false;
		$response->description="No hay fichas para el taller!";
	}else{
		$response->state=true;
		$response->fichas=$fichas;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>