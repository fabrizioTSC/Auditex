<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_UPDATE_CAJAUD(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:NUMCAJERP,:NUMVEZCAJ,:RESUTADO,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['color']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':NUMCAJERP',$_POST['numcajerp']);
	oci_bind_by_name($stmt,':NUMVEZCAJ',$_POST['numvezcaj']);
	oci_bind_by_name($stmt,':RESUTADO',$_POST['resultado']);
	session_start();
	oci_bind_by_name($stmt,':CODUSU',$_SESSION['user']);
	$result=oci_execute($stmt);
	if($result){
		$response->state=true;
		$cajasaud=[];
		$sql="BEGIN SP_AF_SELECT_AUDCAJA(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:ESTADO,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':ESTADO',$_POST['estado']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->NUMVEZCAJA=$row['NUMVEZCAJA'];
			$obj->NROCAJAPPL=$row['NROCAJAPPL'];
			$obj->NRO_CAJA_ERP=$row['NRO_CAJA_ERP'];
			$obj->DESTAL=utf8_encode($row['DESTAL']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$obj->SKU=$row['SKU'];
			$obj->DIRECCION=utf8_encode($row['DIRECCION']);
			$obj->ESTADO=$row['ESTADO'];
			$obj->RESULTADO=$row['RESULTADO'];
			$obj->CODUSU=$row['CODUSU'];
			$obj->FECFIN=$row['FECFIN'];
			array_push($cajasaud,$obj);
		}
		$response->cajasaud=$cajasaud;
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar los datos de la caja";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>