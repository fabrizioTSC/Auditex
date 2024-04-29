<?php
	include('connection.php');
	$response=new stdClass();

	$partidas=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_PARAUD(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->PARTIDA=$row['PARTIDA'];
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->PARTE=$row['PARTE'];
		$obj->CODTAD=$row['CODTAD'];
		$obj->CODPRV=$row['CODPRV'];
		$obj->DESPRV=utf8_encode($row['DESCLI']);
		$obj->CODTEL=$row['CODTEL'];
		$partidas[$i]=$obj;
		$i++;
	}
	$response->partidas=$partidas;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>