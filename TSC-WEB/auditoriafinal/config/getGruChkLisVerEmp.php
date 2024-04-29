<?php
	include('connection.php');
	$response=new stdClass();

	$chklis=[];
	$sql="BEGIN SP_AF_SELECT_PEDCOLCHKLSTAVI(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:COD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['color']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':COD',$_POST['cod']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->TIPOAVIO=utf8_encode($row['TIPOAVIO']);
		$obj->TALLA=utf8_encode($row['TALLA']);
		$obj->CODAVIO=utf8_encode($row['CODAVIO']);
		$obj->DESITEM=utf8_encode($row['DESITEM']);
		$obj->VALOR=$row['VALOR'];
		$obj->DESGRPCLPRO=utf8_encode($row['DESGRPCLPRO']);
		array_push($chklis,$obj);
	}
	$response->chklis=$chklis;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>