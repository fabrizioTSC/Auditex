<?php
	include('connection.php');
	$response=new stdClass();

	$tallas=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_TALXFIC_N(:CODFIC,:PARTE,:OUTPUR_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt, ':PARTE',$_POST['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUR_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->CANTAL=$row['CANTAL'];
		$tallas[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->tallas=$tallas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>