<?php
	set_time_limit(480);
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_PCVA_INSERT_CAJALOTEVEZ(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:LOTE,:NUMVEZLOTE,:NUMCAJERP,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['color']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':LOTE',$_POST['lote']);
	oci_bind_by_name($stmt,':NUMVEZLOTE',$_POST['numvezlote']);
	oci_bind_by_name($stmt,':NUMCAJERP',$_POST['numcajerp']);
	session_start();
	oci_bind_by_name($stmt,':CODUSU',$_SESSION['user']);
	$result=oci_execute($stmt);
	if($result){
		$response->state=true;
		
		$cajas=[];
		$sql="BEGIN SP_PCVA_SELECT_BUSCACAJALOVEZ(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:LOTE,:NUMVEZLOTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':LOTE',$_POST['lote']);
		oci_bind_by_name($stmt,':NUMVEZLOTE',$_POST['numvezlote']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->NROCAJAPPL=$row['NROCAJAPPL'];
			$obj->NROCAJAERP=$row['NROCAJAERP'];
			$obj->DESTAL=utf8_encode($row['DESTAL']);
			$obj->TOTAL=$row['TOTAL'];
			$obj->CANTIDAD=$row['CANTALLA'];
			$obj->SKU=$row['SKU'];
			$obj->DIRECCION=utf8_encode($row['DIRECCION']);
			array_push($cajas,$obj);
		}
		$response->cajas=$cajas;

		$cajasaud=[];
		$sql="BEGIN SP_PCVA_SELECT_AUDCAJALOTEVEZ(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:LOTE,:NUMVEZLOTE,:ESTADO,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':LOTE',$_POST['lote']);
		oci_bind_by_name($stmt,':NUMVEZLOTE',$_POST['numvezlote']);
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
		
		$lotes=[];
		$sql="BEGIN SP_PCVA_SELECT_LISTALOTE(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->NROLOTE=$row['NROLOTE'];
			$obj->NUMVEZLOTE=$row['NUMVEZLOTE'];
			$obj->DESCEL=utf8_encode($row['DESCEL']);
			$obj->NUMCAJLOTE=$row['NUMCAJLOTE'];
			$obj->NUMCAJAUDLOTE=$row['NUMCAJAUDLOTE'];
			$obj->ESTADO=$row['ESTADO'];
			$obj->RESULTADO=$row['RESULTADO'];
			$obj->CODUSU=$row['CODUSU'];
			$obj->FECINI=$row['FECINI'];
			$obj->FECFIN=$row['FECFIN'];
			array_push($lotes,$obj);
		}
		$response->lotes=$lotes;
		
		$paclis=[];
		/*
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
		}*/
		$response->paclis=$paclis;
	}else{
		$response->state=false;
		$response->detail="No se pudo agregar el carton";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>