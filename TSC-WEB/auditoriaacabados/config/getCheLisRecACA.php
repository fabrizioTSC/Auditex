<?php
	include('connection.php');
	$response=new stdClass();

	$fichas=[];
	$sql="begin SP_AA_SELECT_AUDACAREC(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$taller=new stdClass();
		$taller->CODFIC=$row['CODFIC'];
		$taller->PARTE=$row['PARTE'];
		$taller->NUMVEZ=$row['NUMVEZ'];
		$taller->FECINIAUD=$row['FECINIAUD'];
		$taller->FECFINAUD=$row['FECFINAUD'];
		$taller->CODUSU=$row['CODUSU'];
		$taller->CANTIDAD=$row['CANTIDAD'];
		$taller->CANAUD=$row['CANAUD'];
		$taller->CANDEFMAX=$row['CANDEFMAX'];
		$taller->CANDEF=$row['CANDEF'];
		$taller->DESTLL=utf8_decode($row['DESTLL']);
		$taller->DESCEL=utf8_decode($row['DESCEL']);
		$taller->MOTIVO=utf8_decode($row['MOTIVO']);
		array_push($fichas, $taller);
	}
	if (oci_num_rows($OUTPUT_CUR)==0) {
		$response->state=false;
	}else{
		$response->state=true;
		$response->fichas=$fichas;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>