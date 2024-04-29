<?php
	set_time_limit(480);
	include("connection.php");
	$response=new stdClass();


	require_once '../../../tsc/models/modelo/core.modelo.php';
    $objModelo = new CoreModelo();

	// RECALCULAMOS
	$responsereload = $objModelo->setAllSQLSIGE("WebSige.uspMigrarDataIndicadorNoConforme",[],"Recargado correctamente");


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
	$ar_fecha=explode("-", $_POST['fecha']);
	$fecha=$ar_fecha[2].$ar_fecha[1].$ar_fecha[0];
	$fechafor=$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];
	$response->titulo=$titulo." ".$fechafor;

	function num_percent($text){
		$text=str_replace(",",".",$text);
		if (strlen($text)>0) {
			if ($text[0]==".") {
				return "0".$text;
			}else{
				return $text;
			}
		}else{
			return $text;
		}
	}

	if ($_POST['codsede']=="0" && $_POST['codtipser']=="0") {
		
		$anios=[];
		$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=0;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$obj->CANCLA=$row['CANCLA'];
			$obj->CANPRO=$row['CANPRO'];
			$obj->PORCLA=num_percent($row['PORCLA']);
			$obj->OBJETIVO=num_percent($row['OBJETIVO']);
			$obj->CANCLAPLACHI=$row['CANCLAPLACHI'];
			$obj->CANCLASERCHI=$row['CANCLASERCHI'];
			$obj->CANCLASERLIM=$row['CANCLASERLIM'];
			$obj->CANPROCHI=$row['CANPROCHI'];
			$obj->CANPROLIM=$row['CANPROLIM'];
			$obj->PORCLAPLACHI=num_percent($row['PORCLAPLACHI']);
			$obj->PORCLASERCHI=num_percent($row['PORCLASERCHI']);
			$obj->PORCLASERLIM=num_percent($row['PORCLASERLIM']);
			array_push($anios,$obj);
		}
		$response->anios=$anios;

		$meses=[];
		$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=1;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$obj->MES=$row['MES'];
			$obj->CANCLA=$row['CANCLA'];
			$obj->CANPRO=$row['CANPRO'];
			$obj->PORCLA=num_percent($row['PORCLA']);
			$obj->OBJETIVO=num_percent($row['OBJETIVO']);
			$obj->CANCLAPLACHI=$row['CANCLAPLACHI'];
			$obj->CANCLASERCHI=$row['CANCLASERCHI'];
			$obj->CANCLASERLIM=$row['CANCLASERLIM'];
			$obj->CANPROCHI=$row['CANPROCHI'];
			$obj->CANPROLIM=$row['CANPROLIM'];
			$obj->PORCLAPLACHI=num_percent($row['PORCLAPLACHI']);
			$obj->PORCLASERCHI=num_percent($row['PORCLASERCHI']);
			$obj->PORCLASERLIM=num_percent($row['PORCLASERLIM']);
			array_push($meses,$obj);
		}
		$response->meses=$meses;

		$semanas=[];
		$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=2;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
			$obj->CANCLA=$row['CANCLA'];
			$obj->CANPRO=$row['CANPRO'];
			$obj->PORCLA=num_percent($row['PORCLA']);
			$obj->OBJETIVO=num_percent($row['OBJETIVO']);
			$obj->CANCLAPLACHI=$row['CANCLAPLACHI'];
			$obj->CANCLASERCHI=$row['CANCLASERCHI'];
			$obj->CANCLASERLIM=$row['CANCLASERLIM'];
			$obj->CANPROCHI=$row['CANPROCHI'];
			$obj->CANPROLIM=$row['CANPROLIM'];
			$obj->PORCLAPLACHI=num_percent($row['PORCLAPLACHI']);
			$obj->PORCLASERCHI=num_percent($row['PORCLASERCHI']);
			$obj->PORCLASERLIM=num_percent($row['PORCLASERLIM']);
			array_push($semanas,$obj);
		}
		$response->semanas=$semanas;
	}else{
		$anios=[];
		$i=0;
		$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=0;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$obj->CANCLA=$row['CANCLA'];
			$obj->CANPRO=$row['CANPRO'];
			$obj->PORCLA=num_percent($row['PORCLA']);
			$obj->OBJETIVO=num_percent($row['OBJETIVO']);
			array_push($anios,$obj);
		}
		$response->anios=$anios;
		
		$meses=[];
		$i=0;
		$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=1;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$obj->MES=$row['MES'];
			$obj->CANCLA=$row['CANCLA'];
			$obj->CANPRO=$row['CANPRO'];
			$obj->PORCLA=num_percent($row['PORCLA']);
			$obj->OBJETIVO=num_percent($row['OBJETIVO']);
			array_push($meses,$obj);
		}
		$response->meses=$meses;

		$semanas=[];
		$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':FECHA', $fecha);
		$opcion=2;
		oci_bind_by_name($stmt, ':OPCION', $opcion);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
			$obj=new stdClass();
			$obj->ANIO=$row['ANIO'];
			$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
			$obj->CANCLA=$row['CANCLA'];
			$obj->CANPRO=$row['CANPRO'];
			$obj->PORCLA=num_percent($row['PORCLA']);
			$obj->OBJETIVO=num_percent($row['OBJETIVO']);
			array_push($semanas,$obj);
		}
		$response->semanas=$semanas;
	}

	//DETALLE NIVEL 1 - SEMANA
	$defuno=[];
	$i=0;
	$sumDU=0;
	$coddefuno=0;
	$coddefdos=0;
	$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=3;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
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

	//DETALLE NIVEL 1 - MES
	$defunomes=[];
	$i=0;
	$sumDUM=0;
	$coddefunoM=0;
	$coddefdosM=0;
	$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	$opcion=4;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if ($i==0) {
			$coddefunoM=$row['CODFAMILIA'];
		}
		if ($i==1) {
			$coddefdosM=$row['CODFAMILIA'];
		}
		$obj=new stdClass();
		$obj->CODFAMILIA=$row['CODFAMILIA'];
		$obj->DSCFAMILIA=utf8_encode($row['DSCFAMILIA']);
		$obj->SUMA=$row['SUMA'];
		$defunomes[$i]=$obj;
		$i++;
		$sumDUM+=(int)$row['SUMA'];
	}
	$response->defunomes=$defunomes;
	$response->sumDUM=$sumDUM;

////////////
	////////////// RESULTADO DE LOS 2 MAYORES - Semana
	$defuno=[];
	$i=0;
	$sumDefectosU=0;
	$sql="BEGIN SP_APNC_INDICADOR_RESULTADOS2(:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	oci_bind_by_name($stmt, ':CODFAM', $coddefuno);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
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

	/*SEGUNDO FAMDEFECTO MAS GRANDE*/
	$defuno=[];
	$i=0;
	$sumDefectosD=0;
	$sql="BEGIN SP_APNC_INDICADOR_RESULTADOS2(:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	oci_bind_by_name($stmt, ':CODFAM', $coddefdos);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
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

	//////////////////////////////////////////////////////////////////////////////
	////////////// RESULTADO DE LOS 2 MAYORES - Mes
	$defuno=[];
	$i=0;
	$sumDefectosUM=0;
	$sql="BEGIN SP_APNC_INDICADOR_RESULTADOS2(:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	oci_bind_by_name($stmt, ':CODFAM', $coddefunoM);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		if ($row['CANDEF']==null) {
			$sumDefectosUM+=0;
			$obj->SUMA=0;
		}else{
			$sumDefectosUM+=(int)$row['CANDEF'];
			$obj->SUMA=$row['CANDEF'];
		}
		$defuno[$i]=$obj;
		$i++;
	}
	$response->defectosUM=$defuno;
	$response->sumDefectosUM=$sumDefectosUM;

	/*SEGUNDO FAMDEFECTO MAS GRANDE*/
	$defuno=[];
	$i=0;
	$sumDefectosDM=0;
	$sql="BEGIN SP_APNC_INDICADOR_RESULTADOS2(:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	oci_bind_by_name($stmt, ':FECHA', $fecha);
	oci_bind_by_name($stmt, ':CODFAM', $coddefdosM);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
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
		$sumDefectosDM+=(int)$row['CANDEF'];
	}
	$response->defectosDM=$defuno;
	$response->sumDefectosDM=$sumDefectosDM;

	$param=[];
	$i=0;
	$sql="BEGIN SP_APCR_SELECT_PARAMETROS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
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