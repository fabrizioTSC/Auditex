<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$titulo="";
	if ($_POST['codsede']=="0") {
		$titulo.="(TODOS) / ";
	}else{
		$sql="BEGIN SP_AT_SELECT_SEDE(:CODSED,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.=utf8_encode($row['DESSEDE'])." / ";
	}
	if ($_POST['codtipser']=="0") {
		$titulo.="(TODOS) / ";
	}else{
		$sql="BEGIN SP_AT_SELECT_TIPSER(:CODTIPSER,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.=utf8_encode($row['DESTIPSERV'])." / ";
	}
	if ($_POST['codtll']=="0") {
		$titulo.="(TODOS)";
	}else{
		$sql="BEGIN SP_AT_SELECT_TALLER(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.=utf8_encode($row['DESTLL']);
	}
	$response->titulo=$titulo;

	$anios=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_ANIOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$anio=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ((int)date("Y")>=(int)$row['ANIO']) {
			$anio=(int)$row['ANIO'];
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$anios[$i]=$obj;
			$i++;
		}
	}
	$response->anios=$anios;
	$response->anio=$anio;

	$semanas=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_SEMANAS_A_HOY(:ANIO,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ANIO', $anio);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$semana=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($i==0) {
			$semana=(int)$row['NUMERO_SEMANA'];
		}
		$obj=new stdClass();
		$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
		$obj->MIN=$row['MIN'];
		$obj->MAX=$row['MAX'];
		$semanas[$i]=$obj;
		$i++;
	}
	$response->semanas=$semanas;
	$response->semana=$semana;

	$defectos=[];
	$i=0;
	$sql="BEGIN SP_AFC_INDICADOR_DEFECTOS_ALL(:CODTLL,:CODSED,:CODTIPSER,:OUTPUT_CUR,:NUMANIO,:NUMSEM); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	oci_bind_by_name($stmt, ':NUMANIO', $anio);
	oci_bind_by_name($stmt, ':NUMSEM', $semana);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumtot=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->SUMDEF=$row['SUMDEF'];
		$sumtot+=$row['SUMDEF'];
		$defectos[$i]=$obj;
		$i++;
	}
	$response->defectos=$defectos;
	$response->sumtot=$sumtot;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>