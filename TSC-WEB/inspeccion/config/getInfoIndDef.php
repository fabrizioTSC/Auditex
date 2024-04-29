<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

/*
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
	$response->titulo=$titulo;	*/

	$titulo="Linea ";
	if ($_POST['codlin']=="0") {
		$titulo.="(TODOS)";
	}else{
		$titulo.=$_POST['codlin'];
	}

	function process_percent($value){
		$value=str_replace(",",".",$value);
		if ($value[0]==".") {
			return "0".$value;
		}else{
			return $value;
		}
	}

	$ar_fecini=explode("-", $_POST['fecini']);
	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$ar_fecfin=explode("-", $_POST['fecfin']);
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
	$defectos=[];
	$i=0;
	$sql="BEGIN SP_INSP_INDICADOR_DEFECTOS_ALL(:CODLIN,:CODSED,:CODTIPSER,:OUTPUT_CUR,:OPCION,:NUMANIO,:NUMSEM,:FECINI,:FECFIN); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODLIN', $_POST['codlin']);
	oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
	oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	oci_bind_by_name($stmt, ':OPCION', $_POST['opcion']);
	oci_bind_by_name($stmt, ':NUMANIO', $_POST['anio']);
	oci_bind_by_name($stmt, ':NUMSEM', $_POST['semana']);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumtot=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODDEF=$row['CODDEF'];
		$obj->DESDEF=utf8_encode($row['DESDEF']);
		$obj->SUMDEF=$row['SUMDEF'];
		$obj->CANINS=$row['CANINS'];
		$obj->PORDEF=process_percent($row['PORDEF']);
		$defectos[$i]=$obj;
		$i++;
	}
	$response->titulo=$titulo;
	$response->defectos=$defectos;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>