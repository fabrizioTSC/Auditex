<?php
	set_time_limit(240);
	include("connection.php");
	$response=new stdClass();

	function process_percent($value){
		$value=str_replace(",",".",$value);
		if ($value[0]==".") {
			return "0".$value;
		}else{
			return $value;
		}
	}

	$talleres=[];
	$i=0;
	if ($_POST['tipo']=="1") {
		$sql="BEGIN SP_INSP_INDICADOR_DEF_RD_ALL(:CODLIN,:CODSED,:CODTIPSER,:CODDEF,:OUTPUT_CUR,:NUMANIO,:NUMSEM); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODLIN', $_POST['codlin']);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		oci_bind_by_name($stmt, ':NUMANIO', $_POST['anio']);
		oci_bind_by_name($stmt, ':NUMSEM', $_POST['semana']);
	}else{		
		$sql="BEGIN SP_INSP_INDICADOR_DEF_RD_RF (:CODLIN,:CODSED,:CODTIPSER,:CODDEF,:OUTPUT_CUR,:FECINI,:FECFIN); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODLIN', $_POST['codlin']);
		oci_bind_by_name($stmt, ':CODSED', $_POST['codsede']);
		oci_bind_by_name($stmt, ':CODTIPSER', $_POST['codtipser']);
		oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$ar_fecini=explode("-",$_POST['fecini']);
		$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
		oci_bind_by_name($stmt, ':FECINI', $fecini);
		$ar_fecfin=explode("-",$_POST['fecfin']);
		$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
		oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	}
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sumtot=0;
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->CODTLL=$row['CODTLL'];
		$obj->DESTLL=utf8_encode($row['DESTLL']);
		$obj->CANMUE=$row['CANMUE'];
		$obj->SUMDEF=$row['SUMDEF'];
		$obj->PORDEF=process_percent($row['PORDEF']);

		$sumtot+=$row['SUMDEF'];
		$talleres[$i]=$obj;
		$i++;
	}
	$response->talleres=$talleres;
	$response->sumtot=$sumtot;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>