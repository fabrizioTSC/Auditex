<?php
	set_time_limit(120);
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

	$ar_fecha=explode('-', $_POST['fecha']);
	$fecha=$ar_fecha[2].$ar_fecha[1].$ar_fecha[0];

	$response->titulo=$titulo." / ".$ar_fecha[2]."-".$ar_fecha[1]."-".$ar_fecha[0];

	$anios=[];
	$i=0;
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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
		$anios[$i]=$row;
		$i++;
	}
	$response->anios=$anios;
	
	$meses=[];
	$i=0;
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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
		$meses[$i]=$row;
		$i++;
	}
	$response->meses=$meses;

	$semanas=[];
	$i=0;
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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

	////////////// RESULTADO DE LOS 2 MAYORES - Semana
	$defuno=[];
	$i=0;
	$sumDefectosU=0;
	$sumaOtros=0;
	$activate=false;
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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
		if($i<15){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			if ($row['SUMA']==null) {
				$sumDefectosU+=0;
				$obj->SUMA=0;
			}else{
				$sumDefectosU+=(int)$row['SUMA'];
				$obj->SUMA=$row['SUMA'];
			}
			$defuno[$i]=$obj;
			$i++;
		}else{
			$sumDefectosU+=(int)$row['SUMA'];
			$activate=true;
			$sumaOtros+=(int)$row['SUMA'];
		}
	}
	if($activate){
		$obj=new stdClass();
		$obj->CODDEF="0";
		$obj->DESDEF="OTROS";
		$obj->SUMA=$sumaOtros;
		$defuno[$i]=$obj;
	}
	$response->defectosU=$defuno;
	$response->sumDefectosU=$sumDefectosU;

	//SEGUNDO FAMDEFECTO MAS GRANDE
	$defuno=[];
	$i=0;
	$sumDefectosD=0;
	$sumaOtros=0;
	$activate=false;
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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
		if($i<15){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			if ($row['SUMA']==null) {
				$sumDefectosD+=0;
				$obj->SUMA=0;
			}else{
				$sumDefectosD+=(int)$row['SUMA'];
				$obj->SUMA=$row['SUMA'];
			}
			$defuno[$i]=$obj;
			$i++;
		}else{
			$sumDefectosD+=(int)$row['SUMA'];
			$activate=true;
			$sumaOtros+=(int)$row['SUMA'];
		}
	}
	if($activate){
		$obj=new stdClass();
		$obj->CODDEF="0";
		$obj->DESDEF="OTROS";
		$obj->SUMA=$sumaOtros;
		$defuno[$i]=$obj;
	}
	$response->defectosD=$defuno;
	$response->sumDefectosD=$sumDefectosD;

	//////////////////////////////////////////////////////////////////////////////
	////////////// RESULTADO DE LOS 2 MAYORES - Mes
	$defuno=[];
	$i=0;
	$sumDefectosUM=0;
	$sumaOtros=0;
	$activate=false;
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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
		if($i<15){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			if ($row['SUMA']==null) {
				$sumDefectosUM+=0;
				$obj->SUMA=0;
			}else{
				$sumDefectosUM+=(int)$row['SUMA'];
				$obj->SUMA=$row['SUMA'];
			}
			$defuno[$i]=$obj;
			$i++;
		}else{
			$sumDefectosUM+=(int)$row['SUMA'];
			$activate=true;
			$sumaOtros+=(int)$row['SUMA'];
		}
	}
	if($activate){
		$obj=new stdClass();
		$obj->CODDEF="0";
		$obj->DESDEF="OTROS";
		$obj->SUMA=$sumaOtros;
		$defuno[$i]=$obj;
	}
	$response->defectosUM=$defuno;
	$response->sumDefectosUM=$sumDefectosUM;

	//SEGUNDO FAMDEFECTO MAS GRANDE
	$defuno=[];
	$i=0;
	$sumDefectosDM=0;
	$sumaOtros=0;
	$activate=false;
	$sql="BEGIN SP_INSP_INDICADOR_RESULTADOS2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
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
		if($i<15){
			$obj=new stdClass();
			$obj->CODDEF=$row['CODDEF'];
			$obj->DESDEF=utf8_encode($row['DESDEF']);
			$obj->SUMA=$row['SUMA'];
			$defuno[$i]=$obj;
			$i++;
			$sumDefectosDM+=(int)$row['SUMA'];
		}else{
			$sumDefectosDM+=(int)$row['SUMA'];
			$activate=true;
			$sumaOtros+=(int)$row['SUMA'];
		}
	}
	if($activate){
		$obj=new stdClass();
		$obj->CODDEF="0";
		$obj->DESDEF="OTROS";
		$obj->SUMA=$sumaOtros;
		$defuno[$i]=$obj;
	}
	$response->defectosDM=$defuno;
	$response->sumDefectosDM=$sumDefectosDM;

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