<?php
	include('connection.php');
	$response=new stdClass();

	$i=0;
	$partidas=[];
	$sql="BEGIN SP_ATR_SELECT_BUSPAR(:PARTIDA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_array($OUTPUT_CUR)){
		$obj = new stdClass();
		$obj->CODTEL=$row['CODTEL'];
		$obj->CODPRV=$row['CODPRV'];
		$obj->DESCLI=utf8_encode($row['DESCLI']);
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->CODTAD=$row['CODTAD'];
		$obj->PARTE=$row['PARTE'];
		$partidas[$i]=$obj;
		$i++;
	}

	if ($i>0) {
		$response->state=true;
		$response->partidas=$partidas;
	}else{		
		$response->state=false;
		$response->detail="No se encontro la ficha!";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>