<?php
	include('connection.php');
	$response=new stdClass();

	$titulo="";
	if ($_POST['codprv']=="0") {
		$titulo.="PROVEEDOR: (TODOS)";
	}else{
		$sql="BEGIN SP_AUDTEL_SELECT_PRVIND(:CODPRV,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.="PROVEEDOR: ".utf8_encode($row['DESPRV']);
	}
	if ($_POST['codcli']=="0") {
		$titulo.=" / CLIENTE: (TODOS)";
	}else{
		$sql="BEGIN SP_AUDTEL_SELECT_PRVIND(:CODCLI,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		$titulo.=" / CLIENTE: ".utf8_encode($row['DESPRV']);
	}

	$ar_fecini=explode("-",$_POST['fecini']);
	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$ar_fecfin=explode("-",$_POST['fecfin']);
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

	$response->titulo=$titulo." / Del ".$ar_fecini[2]."-".$ar_fecini[1]."-".$ar_fecini[0]." al ".$ar_fecfin[2]."-".$ar_fecfin[1]."-".$ar_fecfin[0];

	$tono=[];
	$sql="BEGIN SP_AUDTEL_REP_CONCES(:FECINI,:FECFIN,:CODPRV,:CODCLI,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sum_tono=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->RESPONSABLE=utf8_encode($row['RESPONSABLE']);
		$obj->PESO=str_replace(",",".",$row['PESO']);
		$sum_tono+=floatval(str_replace(",",".",$row['PESO']));
		array_push($tono,$obj);
	}
	$response->tono=$tono;
	$response->sum_tono=$sum_tono;

	$apariencia=[];
	$sql="BEGIN SP_AUDTEL_REP_CONCES(:FECINI,:FECFIN,:CODPRV,:CODCLI,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	$opcion=2;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sum_apariencia=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->RESPONSABLE=utf8_encode($row['RESPONSABLE']);
		$obj->PESO=str_replace(",",".",$row['PESO']);
		$sum_apariencia+=floatval(str_replace(",",".",$row['PESO']));
		array_push($apariencia,$obj);
	}
	$response->apariencia=$apariencia;
	$response->sum_apariencia=$sum_apariencia;

	$estdim=[];
	$sql="BEGIN SP_AUDTEL_REP_CONCES(:FECINI,:FECFIN,:CODPRV,:CODCLI,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	$opcion=3;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sum_estdim=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->RESPONSABLE=utf8_encode($row['RESPONSABLE']);
		$obj->PESO=str_replace(",",".",$row['PESO']);
		$sum_estdim+=floatval(str_replace(",",".",$row['PESO']));
		array_push($estdim,$obj);
	}
	$response->estdim=$estdim;
	$response->sum_estdim=$sum_estdim;

	$defecto=[];
	$sql="BEGIN SP_AUDTEL_REP_CONCES(:FECINI,:FECFIN,:CODPRV,:CODCLI,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	$opcion=4;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$sum_defecto=0;
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->RESPONSABLE=utf8_encode($row['RESPONSABLE']);
		$obj->PESO=str_replace(",",".",$row['PESO']);
		$sum_defecto+=floatval(str_replace(",",".",$row['PESO']));
		array_push($defecto,$obj);
	}
	$response->defecto=$defecto;
	$response->sum_defecto=$sum_defecto;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>