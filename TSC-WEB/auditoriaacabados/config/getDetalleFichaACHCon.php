<?php
	include('connection.php');
	$response=new stdClass();
	
	$partidaclass=new stdClass();
	/*$sql="BEGIN SP_APNC_VAL_FICINFTEL(:CODFIC,:CONTADOR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CONTADOR',$contador,40);
	$result=oci_execute($stmt);
	if ($contador>0) {*/
		$sql="BEGIN SP_APNC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$partidaclass->partida=$row['PARTIDA'];
		$partidaclass->articulo=$row['ARTICULO'];
		$partidaclass->color=$row['COLORPRENDA'];
		$partidaclass->codtel=$row['CODTEL'];
		$partidaclass->tallercos=utf8_encode($row['TALLERCOS']);
		$partidaclass->tallercor=utf8_encode($row['TALLERCOR']);
		$partidaclass->esttsc=$row['ESTTSC'];
		$partidaclass->estcli=$row['ESTCLI'];
		$partidaclass->pedido=$row['PEDIDO'];
		
		$sql="BEGIN SP_APCR_GET_INFOPARTIDA2(:PARTIDA,:CODTEL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PARTIDA',$partidaclass->partida);
		oci_bind_by_name($stmt,':CODTEL',$partidaclass->codtel);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$partidaclass->codprv=$row['CODPRV'];
		$partidaclass->numvez=$row['NUMVEZ'];
		$partidaclass->parte=$row['PARTE'];
		$partidaclass->codtad=$row['CODTAD'];
	//}
	$response->partida=$partidaclass;

	$sql="BEGIN SP_ACH_SELECT_FICHADETALLE(:CODFIC,:CANTIDAD); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	//oci_bind_by_name($stmt,':CODENV',$codenv,40);
	oci_bind_by_name($stmt,':CANTIDAD',$cantidad,40);
	//oci_bind_by_name($stmt,':CANAUDTER',$canaudter,40);
	$result=oci_execute($stmt);
	$ficha=new stdClass();
	//$ficha->CODENV=$codenv;
	$ficha->CANTIDAD=$cantidad;
	//$ficha->CANAUDTER=$canaudter;
	$response->ficha=$ficha;

	$sql="BEGIN SP_ACH_INSERT_FICHA(:CODFIC,:CODUSU,:CANTIDAD); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	//oci_bind_by_name($stmt,':CODENV',$codenv);
	oci_bind_by_name($stmt,':CODUSU',$_POST['codusu']);
	oci_bind_by_name($stmt,':CANTIDAD',$cantidad);
	//oci_bind_by_name($stmt,':CANAUDTER',$canaudter);
	$result=oci_execute($stmt);

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
	$obj->codusu=$row['CODUSU'];
	$obj->estado=$row['ESTADO'];
	$response->detficaud=$obj;

	session_start();
	if ($_SESSION['user']==$response->detficaud->codusu) {
		$response->isEditable=true;
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

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>