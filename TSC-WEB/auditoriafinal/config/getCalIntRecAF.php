<?php
	include('connection.php');
	$response=new stdClass();

	$pedcol=[];
	$sql="begin SP_AF_SELECT_AUDFINCALIDADREC(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$taller=new stdClass();
		$taller->PEDIDO=$row['PEDIDO'];
		$taller->DESCOL=$row['DESCOL'];
		$taller->NUMVEZ=$row['NUMVEZ'];
		$taller->FECFINAUD=$row['FECFINAUD'];
		$taller->CODUSU=$row['CODUSU'];
		$taller->CODUSUEJE=$row['CODUSUEJE'];
		$taller->CANAUD=$row['CANAUD'];
		$taller->CANDEFMAX=$row['CANDEFMAX'];
		$taller->CANDEF=$row['CANDEF'];
		array_push($pedcol, $taller);
	}
	if (oci_num_rows($OUTPUT_CUR)==0) {
		$response->state=false;
	}else{
		$response->state=true;
		$response->pedcol=$pedcol;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>