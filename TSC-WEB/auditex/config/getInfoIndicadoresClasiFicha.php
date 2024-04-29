<?php
	set_time_limit(480);
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

	$clasi=[];
	$i=0;
	$sql="BEGIN SP_AT_SELECT_CLAREC(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODCLAREC=$row['CODCLAREC'];
		$obj->DESCLAREC=utf8_encode($row['DESCLAREC']);
		$clasi[$i]=$obj;
		$i++;
	}
	$response->clasi=$clasi;

	$anios=[];
	$i=0;
	$sumaAnios=[];
	$value=0;
	$anio_ant="";
	$j=0;
	$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->ANHO=$row['ANHO'];
		$obj->DESCLAREC=utf8_encode($row['DESCLAREC']);
		$obj->CODCLAREC=$row['CODCLAREC'];
		$obj->CANPRE=$row['CANPRE'];
		$anios[$i]=$obj;
		$i++;
		if($anio_ant==""){
			$anio_ant=$row['ANHO'];
			$value+=(int)$row['CANPRE'];
		}else{
			if ($anio_ant!=$row['ANHO']) {
				$sumaAnios[$j]=$value;
				$j++;
				$anio_ant=$row['ANHO'];
				$value=(int)$row['CANPRE'];
			}else{
				$value+=(int)$row['CANPRE'];		
			}
		}
	}
	$sumaAnios[$j]=$value;
	$response->sumaAnios=$sumaAnios;
	$response->anios=$anios;

	$meses=[];
	$i=0;
	$sumaMeses=[];
	$value=0;
	$anio_ant="";
	$j=0;
	$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		if (!is_null($row['DESCLAREC'])) {
			$obj=new stdClass();
			$obj->ANHO_MES=$row['ANHO_MES'];
			$obj->DESCLAREC=utf8_encode($row['DESCLAREC']);
			$obj->CODCLAREC=$row['CODCLAREC'];
			$obj->CANPRE=$row['CANPRE'];
			$meses[$i]=$obj;
			$i++;
			if($anio_ant==""){
				$anio_ant=$row['ANHO_MES'];
				$value+=(int)$row['CANPRE'];
			}else{
				if ($anio_ant!=$row['ANHO_MES']) {
					$sumaMeses[$j]=$value;
					$j++;
					$anio_ant=$row['ANHO_MES'];
					$value=(int)$row['CANPRE'];
				}else{
					$value+=(int)$row['CANPRE'];		
				}
			}
		}
	}
	$sumaMeses[$j]=$value;
	$response->sumaMeses=$sumaMeses;
	$response->lastMes=$anio_ant;
	$response->meses=$meses;

	$semanas=[];
	$i=0;
	$sumaSemanas=[];
	$value=0;
	$anio_ant="";
	$j=0;
	$sql="BEGIN SP_AT_INDICADOR_CLASIFICHA(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	$opcion=2;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->ANHO=$row['ANHO'];
		$obj->NUMERO_SEMANA=$row['NUMERO_SEMANA'];
		$obj->DESCLAREC=utf8_encode($row['DESCLAREC']);
		$obj->CODCLAREC=$row['CODCLAREC'];
		$obj->CANPRE=$row['CANPRE'];
		$semanas[$i]=$obj;
		$i++;
		if($anio_ant==""){
			$anio_ant=$row['NUMERO_SEMANA'];
			$value+=(int)$row['CANPRE'];
		}else{
			if ($anio_ant!=$row['NUMERO_SEMANA']) {
				$sumaSemanas[$j]=$value;
				$j++;
				$anio_ant=$row['NUMERO_SEMANA'];
				$value=(int)$row['CANPRE'];
			}else{
				$value+=(int)$row['CANPRE'];		
			}
		}
	}
	$sumaSemanas[$j]=$value;
	$response->sumaSemanas=$sumaSemanas;
	$response->lastSem=$anio_ant;
	$response->semanas=$semanas;
	
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>