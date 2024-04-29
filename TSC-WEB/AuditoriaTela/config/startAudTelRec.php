<?php
	include('connection.php');
	$response=new stdClass();

	$partida=new stdClass();
	$sql="BEGIN SP_ATR_SELECT_INFPAR(:PARTIDA,:CODPRV,:CODTEL,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->DESCLI=utf8_encode($row['DESCLI']);
		$obj->DESPRV=utf8_encode($row['DESPRV']);
		$obj->CODCOL=$row['CODCOL'];
		$obj->DESCOL=utf8_encode($row['DSCCOL']);
		$obj->DESTEL=utf8_encode($row['DESTEL']);
		$obj->COMPOS=utf8_encode($row['COMPOS']);
		$obj->PROGRAMA=utf8_encode($row['PROGRAMA']);
		$obj->XFACTORY=$row['FECEMB'];
		$obj->CANPRG=str_replace(",",".",$row['CANPRG']);
		$obj->PESO=str_replace(",",".",$row['PESOVAL']);
		$obj->PESOPRG=str_replace(",",".",$row['PESOPRG']);
		$obj->CODUSU=$row['CODUSU'];
		$obj->FECINIAUD=$row['FECINIAUD'];
		$obj->FECFINAUD=$row['FECFINAUD'];
		$obj->RESTONTSC=$row['RESTONTSC'];
		$obj->RESAPATSC=$row['RESAPATSC'];
		$obj->RESMEDTSC=$row['RESMEDTSC'];
		$obj->RESDEFTSC=$row['RESDEFTSC'];
		$partida=$obj;
	}
	$response->partida=$partida;

	$tonos=array();
	$i=0;
	$sql="BEGIN SP_ATR_SELECT_TONO(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTON=$row['CODTON'];
		$obj->DESTON=utf8_encode($row['DESTON']);
		$tonos[$i]=$obj;
		$i++;
	}
	$response->tonos=$tonos;

	$apariencia=array();
	$i=0;
	$sql="BEGIN SP_ATR_SELECT_APARIENCIA(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODAPA=$row['CODAPA'];
		$obj->CODAREAD=$row['CODAREAD'];
		$obj->DSCAREAD=utf8_encode($row['DSCAREAD']);
		$obj->DESAPA=utf8_encode($row['DESAPA']);
		$obj->CODGRPREC=$row['CODGRPREC'];
		$apariencia[$i]=$obj;
		$i++;
	}
	$response->apariencia=$apariencia;

	$detalle_tono=array();
	if($partida->RESTONTSC!=null){
		$sql="BEGIN SP_ATR_SELECT_PARAUDTRTON(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTON=$row['CODTON'];
			$obj->DESTON=utf8_encode($row['DESTON']);
			$obj->RESTSC=$row['RESTSC'];
			$obj->DESREC1=utf8_encode($row['DESREC1']);
			$obj->DESREC2=utf8_encode($row['DESREC2']);
			array_push($detalle_tono,$obj);
		}
	}
	$response->detalle_tono=$detalle_tono;

	$detalle_apariencia=array();
	if($partida->RESAPATSC!=null){
		$sql="BEGIN SP_ATR_SELECT_PARAUDTRCOLAPA(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->DESAPA=utf8_encode($row['DESAPA']);
			$obj->DSCAREAD=utf8_encode($row['DSCAREAD']);
			$obj->CODAPA=$row['CODAPA'];
			$obj->RESTSC=$row['RESTSC'];
			$obj->DESREC1=utf8_encode($row['DESREC1']);
			$obj->CM=str_replace(",",".",$row['CM']);
			$obj->CAIDA=str_replace(",",".",$row['CAIDA']);
			array_push($detalle_apariencia,$obj);
		}
	}
	$response->detalle_apariencia=$detalle_apariencia;

	$detalle=array();
	$i=0;
	$sql="BEGIN SP_ATR_SELECT_DETRECTALMED(:PARTIDA,:CODPRV,:CODTEL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CANPRGTAL=str_replace(",",".",$row['CANPRGTAL']);
		$obj->CODTAL=$row['CODTAL'];
		$obj->DESTAL=utf8_encode($row['DESTAL']);
		$obj->LARGO=$row['LARGO'];
		$obj->TOLLARGO=$row['TOLLARGO'];
		$obj->ALTO=$row['ALTO'];
		$obj->TOLALTO=$row['TOLALTO'];
		$detalle[$i]=$obj;
		$i++;
	}
	$response->detalle=$detalle;

	$guardado=array();
	$i=0;
	$sql="BEGIN SP_ATR_SELECT_DETRECTALMEDGUA(:PARTIDA,:CODPRV,:CODTEL,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTAL=$row['CODTAL'];
		$obj->LARGO=$row['LARGO'];
		$obj->ALTO=$row['ALTO'];
		$obj->CANAUD=str_replace(",",".",$row['CANAUD']);
		$obj->CANSEG=str_replace(",",".",$row['CANSEG']);
		$obj->OBS=utf8_encode($row['COMENTARIOS']);
		$guardado[$i]=$obj;
		$i++;
	}
	$response->guardado=$guardado;

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>