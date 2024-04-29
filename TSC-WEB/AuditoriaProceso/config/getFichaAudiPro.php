<?php
	include('connection.php');
	$response=new stdClass();

	
	$sql="BEGIN SP_APC_INSERT_FICHAAUDITORIA(:CODFIC,:CODUSU,:CODTLL); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	$result=oci_execute($stmt);

	$sql="BEGIN SP_APC_SELECT_AUDITORIAENVIO(:CODFIC,:CODTLL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_array($OUTPUT_CUR);
	$taller=new stdClass();
	$taller->DESTLL=utf8_encode($row['DESTLL']);
	$taller->DESCLI=utf8_encode($row['DESCLI']);
	$taller->DESCOL=utf8_encode($row['DESCOL']);
	$taller->CODTIPOSERV=$row['CODTIPOSERV'];
	$response->taller=$taller;

	// $sql="BEGIN SP_APC_INSERT_AUDITORIAPROCESO(:CODFIC,:CODTLL,:CODUSU,:TURNO,:SECUEN,:NEWSECUEN); END;";
	// $stmt=oci_parse($conn, $sql);
	// oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	// oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	// oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	// oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
	// oci_bind_by_name($stmt, ':SECUEN', $_POST['secuen']);
	// $secuen=0;
	// oci_bind_by_name($stmt, ':NEWSECUEN', $secuen,40);
	// $result=oci_execute($stmt);
	// $response->secuen=$secuen;

	$sql="BEGIN SP_APC_INSERT_AUDIPROCESO_NEW(:CODFIC,:CODTLL,:CODUSU,:TURNO,:SECUEN,:NEWSECUEN); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':TURNO', $_POST['turno']);
	oci_bind_by_name($stmt, ':SECUEN', $_POST['secuen']);
	$secuen=0;
	oci_bind_by_name($stmt, ':NEWSECUEN', $secuen,40);
	$result=oci_execute($stmt);
	$response->secuen=$secuen;

	
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