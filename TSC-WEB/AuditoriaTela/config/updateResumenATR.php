<?php
/*
	include('connection.php');
	$response=new stdClass();			

	$sql="BEGIN SP_ATR_SELECT_RESULTADOS(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :PESO, :PESOAUD, :PESOAPRO, :PESOCAI, :CALIFICACION, :TIPO, :RESULTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':PESO', $peso,40);
	oci_bind_by_name($stmt, ':PESOAUD', $pesoaud,40);
	oci_bind_by_name($stmt, ':PESOAPRO', $pesoapro,40);
	oci_bind_by_name($stmt, ':PESOCAI', $pesocai,40);
	oci_bind_by_name($stmt, ':CALIFICACION', $calificacion,40);
	oci_bind_by_name($stmt, ':TIPO', $tipo,40);
	oci_bind_by_name($stmt, ':RESULTADO', $resultado,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->peso=str_replace(",", ".", $peso);
		$response->pesoaud=str_replace(",", ".", $pesoaud);
		$response->pesoapro=str_replace(",", ".", $pesoapro);
		$response->pesocai=str_replace(",", ".", $pesocai);
		$response->calificacion=$calificacion;
		$response->tipo=$tipo;
		$response->resultado=$resultado;
	}else{
		$response->state=false;
		$response->detail="No se pudo obtener el resumen de la partida";
	}



	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>*/

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

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>