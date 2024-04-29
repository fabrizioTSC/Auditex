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
		
		$porpedcol=array();
		$i=0;
		$sql="BEGIN SP_APNC_SELECT_PORPORFICPEDCOL(:CODFIC,:PEDIDO,:COLOR,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		oci_bind_by_name($stmt,':PEDIDO',$row['PEDIDO']);
		oci_bind_by_name($stmt,':COLOR',$row['COLORPRENDA']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->can2=str_replace(",",".",$row['CAN2']);
			$obj->can3=str_replace(",",".",$row['CAN3']);
			$obj->can4=str_replace(",",".",$row['CAN4']);
			$obj->canter=str_replace(",",".",$row['CANTER']);
			$obj->por2=str_replace(",",".",$row['POR2']);
			$obj->por3=str_replace(",",".",$row['POR3']);
			$obj->por4=str_replace(",",".",$row['POR4']);
			$porpedcol[$i]=$obj;
			$i++;
		}
		$response->porpedcol=$porpedcol;

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

	$sql="BEGIN SP_APNC_SELECT_FICHADETALLE(:CODFIC,:CODENV,:CANTIDAD,:CANAUDTER); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODENV',$codenv,40);
	oci_bind_by_name($stmt,':CANTIDAD',$cantidad,40);
	oci_bind_by_name($stmt,':CANAUDTER',$canaudter,40);
	$result=oci_execute($stmt);
	$ficha=new stdClass();
	$ficha->CODENV=$codenv;
	$ficha->CANTIDAD=$cantidad;
	$ficha->CANAUDTER=$canaudter;
	$response->ficha=$ficha;

	$sql="BEGIN SP_APNC_SELECT_FICHACON(:CODFIC,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$obj=new stdClass();
	$obj->codtad=$row['CODTAD'];
	$obj->numvez=$row['NUMVEZ'];
	$parte=$row['PARTE'];
	$obj->parte=$row['PARTE'];
	$obj->feciniaud=$row['FECINIAUD'];
	$obj->estado=$row['ESTADO'];
	$obj->CANMUE=$row['CANMUE'];
	$obj->CANRECUP=$row['CANRECUP'];
	$response->detficaud=$obj;
	if ($row['ESTADO']=="T") {
		$response->close=true;
	}

	$ubidef=array();
	$sql="BEGIN SP_APNC_SELECT_UBIDEF(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODUBIDEF=$row['CODUBIDEF'];
		$obj->DESUBIDEF=utf8_encode($row['DESUBIDEF']);
		array_push($ubidef,$obj);
	}
	$response->ubidef=$ubidef;

	$tallas=array();
	$j=0;
	$dettal=array();
	$i=0;
	$sql="BEGIN SP_APNC_SELECT_DETTALFICCONV2(:CODFIC,:PARTE,:CODENV,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':PARTE',$parte);
	oci_bind_by_name($stmt,':CODENV',$codenv);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$talla_ant="";
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->CANPRE=$row['CANPRE'];
		$obj->CANTOT=$row['CANTOT'];
		$obj->CANAUD=$row['CANAUD'];
		$obj->CANDEF=$row['CANDEF'];
		$obj->CANPED=$row['CANPED'];
		$obj->CANDEFPED=$row['CANDEFPED'];				
		$dettal[$i]=$obj;
		$i++;
		if ($talla_ant!=$row['CODTAL']) {
			$obj=new stdClass();
			$obj->CODTAL=$row['CODTAL'];
			$obj->DESTAL=utf8_encode($row['DESTAL']);
			$tallas[$j]=$obj;
			$j++;
		}
	}
	$response->dettal=$dettal;
	$response->tallas=$tallas;

	$dettaltot=array();
	$i=0;
	$sql="BEGIN SP_APNC_SELECT_DETTALTOTFIC(:CODFIC,:CODENV,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODENV',$codenv);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$talla_ant="";
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->CANDEF=$row['CANDEF'];
		$dettaltot[$i]=$obj;
		$i++;
	}
	$response->dettaltot=$dettaltot;

	$detfictal=array();
	$i=0;
	$sql="BEGIN SP_APNC_SELECT_DETFICTALDEF(:CODFIC,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CODTAD',$response->detficaud->codtad);
	oci_bind_by_name($stmt,':NUMVEZ',$response->detficaud->numvez);
	oci_bind_by_name($stmt,':PARTE',$response->detficaud->parte);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$talla_ant="";
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->CODDEF=$row['CODDEF'];
		$obj->CODDEFAUX=$row['CODDEFAUX'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->CODUBIDEF=$row['CODUBIDEF'];
		$obj->UBIDEF=utf8_encode($row['DESUBIDEF']);
		$obj->OBS=utf8_encode($row['OBS']);
		$obj->CANINI2=$row['CANINI2'];
		$obj->CANINI3=$row['CANINI3'];
		$obj->CANINI4=$row['CANINI4'];
		$obj->CANFIN1=$row['CANFIN1'];
		$obj->CANFIN2=$row['CANFIN2'];
		$obj->CANFIN3=$row['CANFIN3'];
		$obj->CANFIN4=$row['CANFIN4'];
		$detfictal[$i]=$obj;
		$i++;
	}
	$response->detfictal=$detfictal;

	/* DEFECTOS */
	$defectos=array();
	$i=0;
	$sql="BEGIN SP_APNC_SELECT_DEFECTOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$defecto=new stdClass();
		$defecto->coddef=$row['CODDEF'];
		$defecto->desdef=utf8_encode($row['DESDEF']);
		$defecto->coddefaux=$row['CODDEFAUX'];
		$defectos[$i]=$defecto;
		$i++;
	}
	$response->defectos=$defectos;

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>