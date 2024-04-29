<?php
	include('connection.php');
	$response=new stdClass();

	$usuarios=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_USUCONROL(:OUTPUR_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUR_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODUSU=$row['CODUSU'];
		$obj->NOMUSU=utf8_encode($row['NOMUSU']);
		$usuarios[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->usuarios=$usuarios;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>