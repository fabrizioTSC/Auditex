<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_CLC_VALIDATE_FICTER(:CODFIC,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	$result=oci_execute($stmt);

	if ($estado==0) {
		$response->state=false;
		$response->detail="Ficha no existe o en proceso de auditoria!";
	}else{
		$response->state=true;

		$fichas=array();
		$i=0;		
		$sql="BEGIN SP_CLC_SELECT_VERFICAUD(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$ficha=new stdClass();
		$ficha->CODFIC=$row['CODFIC'];
		$ficha->CODTAD=$row['CODTAD'];
		$ficha->PARTE=$row['PARTE'];
		$ficha->NUMVEZ=$row['NUMVEZ'];
		$ficha->PARTIDA=$row['PARTIDA'];
		$response->ficha=$ficha;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>