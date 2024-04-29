<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_SELECT_PEDCOL(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':COLOR',$_POST['color']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	$numvez=$_POST['numvez'];
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
		$numvez=$row['NUMVEZ'];
		$response->NUMVEZ=$row['NUMVEZ'];
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
		$response->PORAUD=$row['PORAUD'];
		$response->CANTIDAD=$row['CANTIDAD'];
	}
	$response->state=true;
	if (!$response->btnstart) {
		$veces=[];
		$sql="BEGIN SP_AF_SELECT_AUDFINVERVEZ(:PEDIDO,:COLOR,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->NUMVEZ=$row['NUMVEZ'];
			$obj->ESTADO=$row['ESTADO'];
			$obj->RESULTADO=$row['RESULTADO'];
			$obj->CODUSU=$row['CODUSU'];
			$obj->FECINIAUD=$row['FECINIAUD'];
			$obj->FECFINAUD=$row['FECFINAUD'];
			$obj->COMENTARIOS=utf8_decode($row['COMENTARIOS']);
			array_push($veces,$obj);
		}
		$response->veces=$veces;

		$grupos=[];
		$sql="BEGIN SP_AF_SELECT_GRPCHKLISVEREMP(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->CODGRPCLPRO=$row['CODGRPCLPRO'];
			$obj->DESGRPCLPRO=utf8_encode($row['DESGRPCLPRO']);
			array_push($grupos,$obj);
		}
		$response->grupos=$grupos;

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
		$sql="BEGIN SP_AF_SELECT_BUSCACAJA(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$numvez);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->NROCAJAPPL=$row['NROCAJAPPL'];
			$obj->NROCAJAERP=$row['NROCAJAERP'];
			$obj->DESTAL=utf8_encode($row['DESTAL']);
			$obj->CANTIDAD=$row['CANTIDAD'];
			$obj->SKU=$row['SKU'];
			$obj->DIRECCION=utf8_encode($row['DIRECCION']);
			array_push($cajas,$obj);
		}
		$response->cajas=$cajas;

		$cajasaud=[];
		$sql="BEGIN SP_AF_SELECT_AUDCAJA(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:ESTADO,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$numvez);
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
		$response->cajasaud=$cajasaud;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>