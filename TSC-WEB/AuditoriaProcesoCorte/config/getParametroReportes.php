<?php
	include('connection.php');
	$response=new stdClass();

	$parametrosreportes=[];
	$i=0;
	$sqlDefectos="BEGIN SP_APCR_SELECT_PARAMETROS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sqlDefectos);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTAD=$row['CODTAD'];
		$obj->DESTAD=utf8_encode($row['DESTAD']);
		$obj->CODRAN=$row['CODRAN'];
		$obj->VALOR=$row['VALOR'];
		$parametrosreportes[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->parametrosreportes=$parametrosreportes;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>