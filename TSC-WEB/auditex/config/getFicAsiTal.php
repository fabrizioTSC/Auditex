<?php
	include('connection.php');
	$response=new stdClass();

	$fichas=[];	
	$sql="BEGIN SP_AT_SELECT_FICHAXASIGTALLER(:CODFIC,:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$codtad=10;
	oci_bind_by_name($stmt,':CODTAD',$codtad);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODFIC=$row['CODFIC'];
		$obj->PARTE=$row['PARTE'];
		$obj->CODTLL=$row['CODTLL'];
		$obj->DESTLL=$row['DESTLL'];
		$obj->CANPAR=$row['CANPAR'];
		$obj->CANTOT=$row['CANTOT'];
		array_push($fichas,$obj);
	}
	$response->fichas=$fichas;	
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>