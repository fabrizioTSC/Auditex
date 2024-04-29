<?php
	include('connection.php');
	$response=new stdClass();

	$ar_fecini=explode("-",$_POST['fecini']);
	$ar_fecfin=explode("-",$_POST['fecfin']);

	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

	$info=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_REPORTE_GENERAL(:FECINI,:FECFIN,:CODPRV,:TIPO,:RESULTADO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':TIPO', $_POST['estado']);
	oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->PARTIDA=$row['PARTIDA'];
		$obj->DESPRV=utf8_encode($row['DESPRV']);
		$obj->CODTEL=$row['CODTEL'];
		$obj->CODTAD=$row['CODTAD'];
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->PARTE=$row['PARTE'];
		$obj->FECINIAUD=$row['FECINIAUDF'];
		$obj->FECFINAUD=$row['FECFINAUDF'];
		$obj->RESULTADO=$row['RESULTADOF'];
		$obj->ESTADO=$row['ESTADO'];
		$obj->CODUSU=$row['CODUSU'];
		$obj->CODUSUEJE=$row['CODUSUEJE'];
		$obj->RESTONTSC=$row['RESTONTSCF'];
		$obj->RESAPATSC=$row['RESAPATSCF'];
		$obj->RESESTDIMTSC=$row['RESESTDIMTSCF'];
		$obj->ROLLOS=$row['ROLLOS'];
		$obj->ROLLOSAUD=$row['ROLLOSAUD'];
		$obj->CALIFICACION=$row['CALIFICACION'];
		$obj->PUNTOS=$row['PUNTOS'];
		$obj->TIPO=$row['TIPO'];
		$obj->PESO=str_replace(",",".",$row['PESO']);
		$obj->PESOAUD=str_replace(",",".",$row['PESOAUD']);
		$obj->PESOAPRO=str_replace(",",".",$row['PESOAPRO']);
		$obj->PESOCAI=str_replace(",",".",$row['PESOCAI']);
		$obj->PORKGCAIDA=str_replace(",",".",$row['PORKGCAIDA']);

		$obj->CLIENTE=$row['CLIENTE'];
		$obj->PROGRAMA=$row['PROGRAMA'];
		$obj->DESTEL=$row['DESTEL'];
		$obj->CODCOL=$row['CODCOL'];
		$obj->DSCCOL=$row['DSCCOL'];



		$info[$i]=$obj;
		$i++;
	}
	$response->info=$info;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>