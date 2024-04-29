<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_INSP_SELECT_HORFINLIN(:LINEA,:ANTERIOR,:HORFIN,:TURNO); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':LINEA',$_POST['linea']);
	oci_bind_by_name($stmt,':ANTERIOR',$_POST['anterior']);
	oci_bind_by_name($stmt,':HORFIN',$hor_fin,40);
	oci_bind_by_name($stmt,':TURNO',$turno,40);
	$result=oci_execute($stmt);

	$response->hor_fin=$hor_fin;
	$response->turno=$turno+1;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>