<?php
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

	$anio="";
	if(isset($_POST['anio'])){
		$anio=$_POST['anio'];
	}
	$mes="";
	if(isset($_POST['mes'])){
		$mes=$_POST['mes'];
	}
	$semana="";
	if(isset($_POST['semana'])){
		$semana=$_POST['semana'];
	}
	$fecini="";
	if(isset($_POST['fecini'])){
		$fecini=$_POST['fecini'];
	}
	$fecfin="";
	if(isset($_POST['fecfin'])){
		$fecfin=$_POST['fecfin'];
	}

	if ($_POST['option']=="1") {
		$titulo.=$_POST['anio']." / ";
	}
	if ($_POST['option']=="2") {
		$titulo.=$_POST['anio']." / Semana ".$_POST['semana'];
	}
	if ($_POST['option']=="3") {
		$ar_fecini=explode("-", $_POST['fecini']);
		$ar_fecfin=explode("-", $_POST['fecfin']);

		$titulo.="De ".$ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." a ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];

		$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
		$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
	}

	$talleres=[];
	$i=0;
	$sql="BEGIN SP_AT_REPORTE_RANKINGLINEA(:CODSED,:CODTIPSER,:OPCION,:ANIO,:MES,:SEMANA,:FECINI,:FECFIN,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':OPCION', $_POST['option']);
	oci_bind_by_name($stmt, ':ANIO', $anio);
	oci_bind_by_name($stmt, ':MES', $mes);
	oci_bind_by_name($stmt, ':SEMANA', $semana);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODTLL=$row['CODTLL'];
		$obj->DESCOM=utf8_encode($row['DESCOM']);
		$obj->DESTLL=utf8_encode($row['DESTLL']);
		$obj->DESSEDE=utf8_encode($row['DESSEDE']);
		$obj->DESTIPSERV=utf8_encode($row['DESTIPSERV']);
		$obj->PORCENTAJE=$row['PORCENTAJE'];
		$obj->AUD_TOT=$row['AUD_TOT'];
		$obj->AUD_REC=$row['AUD_REC'];
		$talleres[$i]=$obj;
		$i++;
	}
	$response->talleres=$talleres;

	$response->titulo=$titulo;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>