<?php
	include('connection.php');
	$response=new stdClass();
	
	/*$sql="BEGIN SP_AFC_VAL_FICINFTEL(:CODFIC,:CONTADOR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':CONTADOR',$contador,40);
	$result=oci_execute($stmt);
	if ($contador>0) {	*/
		$partidaclass=new stdClass();
		$sql="BEGIN SP_AFC_GET_INFOPARTIDA(:CODFIC,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$partidaclass->partida=$row['PARTIDA'];
		$partidaclass->tiptel=$row['ARTICULO'];
		$partidaclass->color=$row['COLOR'];
		$partidaclass->codtel=$row['CODTEL'];
		$partidaclass->descli=utf8_encode($row['DESCLI']);

		$sql="BEGIN SP_AFC_GET_INFOPARTIDA2(:PARTIDA,:CODTEL,:OUTPUT_CUR); END;";
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
	
	$sql="BEGIN SP_GEN_SELECT_NOMCEL(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$response->DESCEL=utf8_encode($row['DESTLL']);

	$sql="BEGIN SP_APCR_SELECT_DETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$defectos=[];
	$i=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$defecto=new stdClass();
		$defecto->coddef=$row['CODDEF'];
		$defecto->desdef=utf8_encode($row['DESDEF']);
		$defecto->codope=$row['CODOPE'];
		$defecto->desope=utf8_encode($row['DESOPE']);
		$defecto->candef=$row['CANDEF'];
		$defectos[$i]=$defecto;
		$i++;
	}
	$response->defectos=$defectos;

	$sql="BEGIN SP_APCR_SELECT_DETFIC(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);

	$row=oci_fetch_assoc($OUTPUT_CUR);
	$ficha=new stdClass();
	$ficha->ESTADO=$row['ESTADO'];
	$ficha->DESTLL=utf8_encode($row['DESTLL']);
	$ficha->CANPRE=$row['CANPRE'];
	$ficha->CANPAR=$row['CANPAR'];
	$ficha->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
	$ficha->AQL=$row['AQL'];
	$ficha->CANAUD=$row['CANAUD'];
	$ficha->RESULTADO=$row['RESULTADO'];
	$ficha->PEDIDO=$row['PEDIDO'];
	$ficha->ESTTSC=$row['ESTTSC'];
	$ficha->ESTCLI=$row['ESTCLI'];
	
	$response->state=true;
	$response->ficha=$ficha;

	$fichatallas=array();
	$sql="BEGIN SP_APCR_SELECT_FICHATALLAS(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$fichatalla=new stdClass();
		$fichatalla=$row;
		array_push($fichatallas,$fichatalla);
	}
	$response->fichatallas=$fichatallas;	
	
	$sql="BEGIN SP_AFC_SELECT_OBSFICCOR(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$obs=[];
	$i=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){				
		$obj=new stdClass();
		$obj->SEC=$row['SEC'];
		$obj->OBS=utf8_encode($row['OBS']);
		$obs[$i]=$obj;
		$i++;
	}
	$response->obs=$obs;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>