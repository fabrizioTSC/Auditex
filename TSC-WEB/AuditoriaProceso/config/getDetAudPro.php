<?php
	include('connection.php');
	$response=new stdClass();

	$detalle=[];
	$i=0;
	$sql="BEGIN SP_APC_SELECT_AUDPROOPEDET(:CODFIC,:SECUEN,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':SECUEN', $_POST['secuen']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$detalles=new stdClass();
		$detalles->CODPER=$row['CODPER'];
		$detalles->NOMPER=utf8_encode($row['NOMPER']);
		$detalles->CODOPE=$row['CODOPE'];
		$detalles->DESOPE=utf8_encode($row['DESOPE']);
		$detalles->CODDEF=$row['CODDEF'];
		$detalles->DESDEF=utf8_encode($row['DESDEF']);
		$detalles->CANDEF=$row['CANDEF'];

		$detalles->NUMVEZ=utf8_encode($row['NUMVEZ']);
		$detalles->USUARIOFIN=utf8_encode($row['USUARIOFIN']);
		$detalles->ESTADO=utf8_encode($row['ESTADO']);
		$detalles->DESTLL=utf8_encode($row['DESTLL']);
		$detalles->FECHAFIN=utf8_encode($row['FECHAFIN']);




		$detalle[$i]=$detalles;
		$i++;
	}
	$response->state=true;
	$response->detalle=$detalle;

	$partida=new stdClass();
	$sql="BEGIN SP_AFC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$partida->PARTIDA=$row['PARTIDA'];
	$partida->CODTEL=$row['CODTEL'];
	$partida->DESTLL=$row['DESTLL'];
	if ($partida->CODTEL!="") {
		$sql="BEGIN SP_AFC_GET_INFOPARTIDA2(:CODFIC,:CODTEL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $partida->PARTIDA);
		oci_bind_by_name($stmt, ':CODTEL', $partida->CODTEL);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$partida->CODPRV=$row['CODPRV'];
		$partida->NUMVEZ=$row['NUMVEZ'];
		$partida->PARTE=$row['PARTE'];
		$partida->CODTAD=$row['CODTAD'];
	}

	$response->partida=$partida;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>