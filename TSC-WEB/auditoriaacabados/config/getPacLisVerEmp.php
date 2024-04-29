<?php
	set_time_limit(480);
	include('connection.php');
	$response=new stdClass();

		$response->state=true;		
		$paclis=[];
		$sql="BEGIN SP_PCVA_SELECT_PACKINGLIST(:PEDIDO,:COLOR,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->NROCAJAPPL=$row['NROCAJAPPL'];
			$obj->NROCAJAERP=utf8_encode($row['NROCAJAERP']);
			$obj->DESTAL=utf8_encode($row['DESTAL']);
			$obj->TOTAL=utf8_encode($row['TOTAL']);
			$obj->CANTALLA=utf8_encode($row['CANTALLA']);
			$obj->SKU=utf8_encode($row['SKU']);
			$obj->DIRECCION=utf8_encode($row['DIRECCION']);
			$obj->NROLOTE=utf8_encode($row['NROLOTE']);
			$obj->LLENADO=utf8_encode($row['LLENADO']);
			$obj->ALMACEN=utf8_encode($row['ALMACEN']);
			$obj->CAJASELAUD=utf8_encode($row['CAJASELAUD']);
			array_push($paclis,$obj);
		}
		$response->paclis=$paclis;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>