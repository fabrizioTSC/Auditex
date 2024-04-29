<?php
	include('connection.php');
	$response=new stdClass();

	$partidas=array();
	$i=0;
	$sql="BEGIN SP_ATT_SELECT_PARTIDAS(:PARTIDA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_array($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODPRV=$row['CODPRV'];
		$obj->DESPRV=utf8_encode($row['DESPRV']);
		$obj->CODTEL=$row['CODTEL'];
		$obj->CODTAD=$row['CODTAD'];
		$obj->PARTE=$row['PARTE'];
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->RESULTADO=$row['RESULTADOT'];
		array_push($partidas,$obj);
	}
	$response->partidas=$partidas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>