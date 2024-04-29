<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_INSERT_CHPEDCOL(:PEDIDO,:DSCCOL,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':DSCCOL',$_POST['dsccol']);
	session_start();
	oci_bind_by_name($stmt,':CODUSU',$_SESSION['user']);
	$result=oci_execute($stmt);

	$datos=new stdClass();
	$sql="BEGIN SP_AF_SELECT_CHPEDCOLCONHUM(:PEDIDO,:DSCCOL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':DSCCOL',$_POST['dsccol']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$datos->DESCLI=utf8_encode($row['DESCLI']);
	$datos->PO=utf8_encode($row['PO']);
	$datos->ESTTSC=utf8_encode($row['ESTTSC']);
	$datos->ESTCLI=utf8_encode($row['ESTCLI']);
	$datos->CODUSU=$row['CODUSU'];
	if ($row['ESTADO']=="T"){
		$response->close=true;
	}
	$datos->ESTADO=$row['ESTADO'];
	$datos->RESULTADO=$row['RESULTADO'];
	$datos->FECINIAUD=$row['FECINIAUD'];
	$datos->FECFINAUD=$row['FECFINAUD'];
	$datos->PRENDA=utf8_encode($row['PRENDA']);
	$datos->CANDEF=$row['CANDEF'];
	$datos->CANTIDAD=$row['CANTIDAD'];
	$datos->TEMAMB=str_replace(",",".",$row['TEMAMB']);
	$datos->HUMMAX=str_replace(",",".",$row['HUMMAX']);
	$datos->HUMPRO=str_replace(",",".",$row['HUMPRO']);
	$datos->HUMAMB=str_replace(",",".",$row['HUMAMB']);
	$datos->OBSERVACION=utf8_encode($row['OBSERVACION']);
	$datos->OBSFOT=utf8_encode($row['OBSIMAGEN']);
	$datos->RUTIMA=utf8_encode($row['RUTIMA']);

	$response->datos=$datos;

	$detalle_humedad=array();
	$sql="BEGIN SP_AF_SELECT_CHPEDCOLCONHUMDET(:PEDIDO,:DSCCOL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':DSCCOL',$_POST['dsccol']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->IDREG=$row['IDREG'];
		$obj->HUMEDAD=str_replace(",",".",$row['HUMEDAD']);
		array_push($detalle_humedad,$obj);
	}
	$response->detalle_humedad=$detalle_humedad;

/*

	$sql="BEGIN SP_ACH_SELECT_FICHA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$obj=new stdClass();
	$codtad=$row['CODTAD'];
	$obj->codtad=$row['CODTAD'];
	$numvez=$row['NUMVEZ'];
	$obj->numvez=$row['NUMVEZ'];
	$parte=$row['PARTE'];
	$obj->parte=$row['PARTE'];
	$obj->feciniaud=$row['FECINIAUD'];
	$obj->estado=$row['ESTADO'];
	$response->detficaud=$obj;
	if ($row['ESTADO']=="T") {
		$response->close=true;
	}

	$sql="BEGIN SP_ACH_SELECT_FICDATHUM(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODTAD',$codtad);
	oci_bind_by_name($stmt,':NUMVEZ',$numvez);
	oci_bind_by_name($stmt,':PARTE',$parte);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$response->TEMAMB=str_replace(",",".",$row['TEMAMB']);
		$response->HUMAMB=str_replace(",",".",$row['HUMAMB']);
		$response->HUMMAX=str_replace(",",".",$row['HUMMAX']);
		$response->RESULTADO=$row['RESULTADO'];
		$response->OBS=$row['OBSERVACION'];
		$response->HUMPRO=str_replace(",",".",$row['HUMPRO']);
	}

	$detalle_humedad=array();
	$sql="BEGIN SP_ACH_SELECT_DETHUM(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODTAD',$codtad);
	oci_bind_by_name($stmt,':NUMVEZ',$numvez);
	oci_bind_by_name($stmt,':PARTE',$parte);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->IDREG=$row['IDREG'];
		$obj->HUMEDAD=str_replace(",",".",$row['HUMEDAD']);
		array_push($detalle_humedad,$obj);
	}
	$response->detalle_humedad=$detalle_humedad;
*/
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>