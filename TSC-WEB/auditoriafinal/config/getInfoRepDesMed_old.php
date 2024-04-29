<?php
	include('connection.php');
	$response=new stdClass();

	$header=array();
	$i=0;
	$sql="BEGIN SP_AF_REPORTE_MEDIDAS(:ESTTSC,:PEDIDO,:COLOR,:TIPO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':COLOR', $_POST['color']);
	$tipo=1;
	oci_bind_by_name($stmt, ':TIPO', $tipo);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->ESTCLI=$row['ESTCLI'];
		$obj->DESCLI=utf8_encode($row['DESCLI']);
		$header[$i]=$obj;
		$i++;
	}
	$response->header=$header;

	$datos=array();
	$i=0;
	$sql="BEGIN SP_AF_REPORTE_MEDIDAS(:ESTTSC,:PEDIDO,:COLOR,:TIPO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':PEDIDO', $_POST['pedido']);
	oci_bind_by_name($stmt, ':COLOR', $_POST['color']);
	$tipo=2;
	oci_bind_by_name($stmt, ':TIPO', $tipo);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODMED=$row['CODMED'];
		$obj->DESMED=utf8_encode($row['DESMED']);
		$obj->CODDES=$row['CODDES'];
		$obj->SECUENCIA=$row['SECUENCIA'];
		$obj->VALPUL=$row['VALPUL'];
		$obj->VALCM=$row['VALCM'];
		$obj->TOLVAL=$row['TOLVAL'];
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->ORDEN=$row['ORDEN'];
		$obj->TOTAL=$row['TOTAL'];
		$datos[$i]=$obj;
		$i++;
	}
	$response->datos=$datos;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>