<?php
	include('connection.php');
	$response=new stdClass();

	$operaciones=[];
	$i=0;
	$sql="BEGIN SP_INSP_REP_DEF_OPELINHOR(:FECHA,:CODDEF,:LINEA,:HORA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt, ':FECHA', $_POST['fecha']);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	oci_bind_by_name($stmt, ':LINEA', $_POST['linea']);
	oci_bind_by_name($stmt, ':HORA', $_POST['hora']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DESOPE=utf8_encode($row['DESOPE']);
		$obj->CANTIDAD=$row['CANTIDAD'];
		$operaciones[$i]=$obj;
		$i++;			
	}
	$response->operaciones=$operaciones;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>