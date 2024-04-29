<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	$titulo="";
	if ($_POST['codsede']=="0") {
		$titulo.="SEDE: (TODOS) / ";
	}else{
		$sql="BEGIN SP_AT_SELECT_SEDE(:CODSED,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="SEDE: ".utf8_encode($row['DESSEDE'])." / ";
	}
	if ($_POST['codtipser']=="0") {
		$titulo.="TIPO SERVICIO: (TODOS) / ";
	}else{
		$sql="BEGIN SP_AT_SELECT_TIPSER(:CODTIPSER,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="TIPO SERVICIO: ".utf8_encode($row['DESTIPSERV'])." / ";
	}
	if ($_POST['codtll']=="0") {
		$titulo.="TALLER: (TODOS)";
	}else{
		$sql="BEGIN SP_AT_SELECT_TALLER(:CODTLL,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="TALLER: ".utf8_encode($row['DESTLL']);
	}
	$response->titulo=$titulo;

	$semanas=[];
	$i=0;
	$sql="BEGIN SP_AT_EVOINDRES(:CODTLL,:CODSED,:CODTIPSER,:NUM,:TYPE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':NUM', $_POST['num']);
	oci_bind_by_name($stmt, ':TYPE', $_POST['type']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$semanas[$i]=$row;	
		$i++;
	}
	$response->semanas=$semanas;

	//DETALLE NIVEL 1 - SEMANA
	$defuno=[];
	$i=0;
	$sumDU=0;
	$coddefuno=0;
	$coddefdos=0;
	$sql="BEGIN SP_AT_EVOINDRES_DET1(:CODTLL,:CODSED,:CODTIPSER,:NUM,:TYPE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':NUM', $_POST['num']);
	oci_bind_by_name($stmt, ':TYPE', $_POST['type']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($i==0) {
			$coddefuno=$row['CODFAMILIA'];
		}
		if ($i==1) {
			$coddefdos=$row['CODFAMILIA'];
		}
		$obj=new stdClass();
		$obj->CODFAMILIA=$row['CODFAMILIA'];
		$obj->DSCFAMILIA=utf8_encode($row['DSCFAMILIA']);
		$obj->SUMA=$row['SUMA'];
		$defuno[$i]=$obj;
		$i++;
		$sumDU+=(int)$row['SUMA'];
	}
	$response->defuno=$defuno;
	$response->sumDU=$sumDU;


	////////////// RESULTADO DE LOS 2 MAYORES - Semana
	$defuno=[];
	$i=0;
	$sumDefectosU=0;
	$sql="BEGIN SP_AT_EVOINDRED_DET2(:CODTLL,:CODSED,:CODTIPSER,:NUM,:CODFAM,:TYPE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':NUM', $_POST['num']);
	oci_bind_by_name($stmt, ':CODFAM', $coddefuno);
	oci_bind_by_name($stmt, ':TYPE', $_POST['type']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		if ($row['CANDEF']==null) {
			$sumDefectosU+=0;
			$obj->SUMA=0;
		}else{
			$sumDefectosU+=(int)$row['CANDEF'];
			$obj->SUMA=$row['CANDEF'];
		}
		$defuno[$i]=$obj;
		$i++;
	}
	$response->defectosU=$defuno;
	$response->sumDefectosU=$sumDefectosU;

	//SEGUNDO FAMDEFECTO MAS GRANDE
	$defuno=[];
	$i=0;
	$sumDefectosD=0;
	$sql="BEGIN SP_AT_EVOINDRED_DET2(:CODTLL,:CODSED,:CODTIPSER,:NUM,:CODFAM,:TYPE,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':NUM', $_POST['num']);
	oci_bind_by_name($stmt, ':CODFAM', $coddefdos);
	oci_bind_by_name($stmt, ':TYPE', $_POST['type']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->SUMA=$row['CANDEF'];
		$defuno[$i]=$obj;
		$i++;
		$sumDefectosD+=(int)$row['CANDEF'];
	}
	$response->defectosD=$defuno;
	$response->sumDefectosD=$sumDefectosD;

	$param=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_PARAMETROSREPORTE(:CODTAD,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$codtad=10;
	oci_bind_by_name($stmt, ':CODTAD', $codtad);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODRAN=$row['CODRAN'];
		$obj->VALOR=$row['VALOR'];
		$param[$i]=$obj;
		$i++;
	}
	$response->param=$param;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>