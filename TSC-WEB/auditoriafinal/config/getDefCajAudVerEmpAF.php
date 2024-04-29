<?php
	include('connection.php');
	$response=new stdClass();

	$detalle_defecto=[];
	$sql="BEGIN SP_AF_SELECTAUDCAJADEF(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:NUMCAJERP,:NUMVEZCAJA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['color']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':NUMCAJERP',$_POST['numcajerp']);
	oci_bind_by_name($stmt,':NUMVEZCAJA',$_POST['numvezcaj']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->DESFAM=utf8_encode($row['DESFAM']);
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->CODDEFAUX=$row['CODDEFAUX'];
		$obj->CANDEF=$row['CANDEF'];
		$obj->CODDEF=$row['CODDEF'];
		array_push($detalle_defecto,$obj);
	}
	$response->detalle_defecto=$detalle_defecto;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>