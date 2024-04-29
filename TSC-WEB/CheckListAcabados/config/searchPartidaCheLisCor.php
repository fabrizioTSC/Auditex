<?php
	include('connection.php');
	$response=new stdClass();

	$partidas=array();
	$i=0;		
	$sql="BEGIN SP_CLC_SELECT_PARTIDACLC(:PARTIDA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$partida=new stdClass();
		$partida->CODTEL=$row['CODTEL'];
		$partida->DSCCOL=$row['DSCCOL'];
		$partida->DESTEL=utf8_encode($row['DESTEL']);
		$partidas[$i]=$partida;
		$i++;
	}
	if ($i==0) {			
		$response->state=false;
		$response->description="Partida no encontrada!";
	}else{
		$response->state=true;
		$response->partidas=$partidas;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>