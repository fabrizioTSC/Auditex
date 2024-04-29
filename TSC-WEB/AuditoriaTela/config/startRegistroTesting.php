<?php
	include('connection.php');
	$response=new stdClass();

	$partida=new stdClass();
	$sql="BEGIN SP_AUDTEL_SELECT_PARTIDA2(:PARTIDA,:CODTEL,:CODPRV,:CODTAD,:NUMVEZ,:PARTE,:OUTPUT_CUR); END;";
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
		$obj->PARTIDA=$row['PARTIDA'];
		$obj->DSCCOL=utf8_encode($row['DSCCOL']);
		$obj->DESTEL=utf8_encode($row['DESTEL']);
		$obj->DESCLI=utf8_encode($row['DESCLI']);
		$obj->COMPOS=utf8_encode($row['COMPOS']);
		$obj->TIPO=$row['TIPO'];
		$obj->DESPRV=utf8_encode($row['DESPRV']);
		$obj->CALIFICACION=$row['CALIFICACION'];
		$obj->TIPO=$row['TIPO'];
		$obj->PROGRAMA=utf8_encode($row['PROGRAMA']);
		$obj->XFACTORY=$row['FECEMB'];
		$obj->DESTINO=utf8_encode($row['DESTINO']);
		$obj->PESO=str_replace(",",".",$row['PESO']);
		$obj->PESOAPRO=str_replace(",",".",$row['PESOAPRO']);
		$obj->PESOAUD=str_replace(",",".",$row['PESOAUD']);
		$obj->PESOCAI=str_replace(",",".",$row['PESOCAI']);
		$obj->RESULTADO=$row['RESULTADO'];
		$obj->CODCOL=utf8_encode($row['CODCOL']);
		$obj->PESOPRG=str_replace(",",".",$row['PESOPRG']);
		$obj->RENDIMIENTO=str_replace(",",".",$row['RENDIMIENTO']);
		$obj->RENMET=str_replace(",",".",$row['RENMET']);
		$obj->CODUSU=$row['CODUSU'];
		$obj->CODUSUEJE=$row['CODUSUEJE'];
		$obj->FECINIAUD=$row['FECINIAUDF'];
		$obj->FECFINAUD=$row['FECFINAUDF'];
		$obj->RUTA=$row['RUTA'];
		$partida=$obj;
	}
	$response->partida=$partida;

	$estdim=[];
	$sql="BEGIN SP_ATT_SELECT_ESTDIM_PARTEVEZ(:PARTIDA,:CODTEL,:CODPRV,:PARTE,:NUMVEZ,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODESTDIM=$row['CODESTDIM'];
		$obj->DESESTDIM=utf8_encode($row['DESESTDIM']);
		$obj->VALORTSC=$row['VALORTSC'];
		$obj->TESTING=$row['TESTING'];
		array_push($estdim,$obj);
	}
	$response->estdim=$estdim;

	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>