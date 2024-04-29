<?php
	set_time_limit(480);
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_PCVA_SELECT_PEDCOL(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
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
		$response->DESCLI=utf8_encode($row['DESCLI']);
		$response->PO=$row['PO'];
		$response->ESTTSC=$row['ESTTSC'];
		$response->ESTCLI=$row['ESTCLI'];
		$response->CODUSU=$row['CODUSU'];
		if ($row['CODUSU']==null) {
			$response->btnstart=true;
		}else{
			$response->btnstart=false;
		}
		$response->ESTADO=$row['ESTADO'];
		if ($row['ESTADO']=='T') {
			$response->audter=true;
		}else{
			$response->audter=false;
		}
		$response->FECINIAUD=$row['FECINIAUD'];
		$response->FECFINAUD=$row['FECFINAUD'];
		$response->NUMCAJPEDCOL=$row['NUMCAJPEDCOL'];
		$response->NUMCAJAUD=$row['NUMCAJAUD'];
	}
	$response->state=true;
	if (!$response->btnstart) {
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

		$detalle=[];
		$sql="BEGIN SP_PCVA_SELECT_PEDCOLCHKLST(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
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
			$obj->DESCHKLSTACA=utf8_encode($row['DESCHKLSTACA']);
			$obj->DESCHKLSTACAING=utf8_encode($row['DESCHKLSTACAING']);
			$obj->DESCHKLSTACADOS=utf8_encode($row['DESCHKLSTACADOS']);
			$obj->VALOR=$row['VALOR'];
			$obj->CODGRP=$row['CODGRPCHKLSTACA'];
			$obj->CODCHKLSTACA=$row['CODCHKLSTACA'];
			array_push($detalle,$obj);
		}
		$response->detalle=$detalle;

		$defectos=[];
		$sql="BEGIN SP_PCVA_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->DESFAM=utf8_encode($row['DESFAM']);
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			$obj->CODDEFAUX=$row['CODDEFAUX'];
			$obj->CODDEF=$row['CODDEF'];
			array_push($defectos,$obj);
		}
		$response->defectos=$defectos;

		$cajas=[];
		$sql="BEGIN SP_PCVA_SELECT_CAJADISPO(:PEDIDO,:COLOR,:OUTPUT_CUR); END;";
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
			$obj->NROCAJAERP=$row['NROCAJAERP'];
			$obj->DESTAL=utf8_encode($row['DESTAL']);
			$obj->TOTAL=$row['TOTAL'];
			$obj->CANTIDAD=$row['CANTALLA'];
			$obj->SKU=$row['SKU'];
			$obj->DIRECCION=utf8_encode($row['DIRECCION']);
			array_push($cajas,$obj);
		}
		$response->cajas=$cajas;

		$celulas=[];
		$sql="BEGIN SP_CLC_SELECT_CELULAS(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->CODTLL=$row['CODTLL'];
			$obj->DESTLL=utf8_encode($row['DESTLL']);
			array_push($celulas,$obj);
		}
		$response->celulas=$celulas;

/*
		$cajasaud=[];
		$sql="BEGIN SP_PCVA_SELECT_AUDCAJA(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:ESTADO,:OUTPUT_CUR); END;";
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
			$obj->NRO_CAJA_ERP=$row['NRO_CAJA_ERP'];
			$obj->NROCAJAPPL=$row['NROCAJAPPL'];
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
		$response->cajasaud=$cajasaud;*/		
/*
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
		$response->paclis=$paclis;*/

		$sql="BEGIN SP_AA_SELECT_CONCAJDIS(:PEDIDO,:COLOR,:CANTIDAD); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':CANTIDAD',$cantidad,40);
		$result=oci_execute($stmt);
		$response->cajdis=$cantidad;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>