<?php
	set_time_limit(480);
	include("connection.php");
	$response=new stdClass();
	
	$anios=[];
	$i=0;
	$sql="BEGIN SP_AUDTEL_IND_DEFECTOS_V2(:CODPRV,:CODCLI,:CODPRO,:OPCION,:CODDEF,:FECHA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', 	$_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', 	$_POST['codcli']);
	oci_bind_by_name($stmt, ':CODPRO', 	$_POST['codpro']);
	$opcion=0;
	oci_bind_by_name($stmt, ':OPCION', 	$opcion);
	oci_bind_by_name($stmt, ':CODDEF', 	$_POST['coddef']);
	$fechafiltro = $_POST['fecha'] == '' ? null : $_POST['fecha'];
	//var_dump($fechafiltro);
	oci_bind_by_name($stmt, ':FECHA', 	$fechafiltro);

	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->ANHO=$row['ANHO'];
		$obj->SUMDEF=$row['SUMDEF'];
		$obj->SUMCODDEF=$row['SUMCODDEF'];
		$obj->SUMCANMUE=$row['SUMCANMUE'];
		$anios[$i]=$obj;
		$i++;
	}
	$response->anios=$anios;

	$meses=[];
	$i=0;
	// $sql="BEGIN SP_AUDTEL_IND_DEFECTOS(:CODPRV,:CODCLI,:CODPRO,:OPCION,:CODDEF,:OUTPUT_CUR); END;";
	$sql="BEGIN SP_AUDTEL_IND_DEFECTOS_V2(:CODPRV,:CODCLI,:CODPRO,:OPCION,:CODDEF,:FECHA,:OUTPUT_CUR); END;";

	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODPRO', $_POST['codpro']);
	$opcion=1;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	oci_bind_by_name($stmt, ':FECHA', 	$_POST['fecha']);

	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->ANHO=$row['ANHO'];
		$obj->MES=$row['MES'];
		$obj->SUMDEF=$row['SUMDEF'];
		$obj->SUMCODDEF=$row['SUMCODDEF'];
		$obj->SUMCANMUE=$row['SUMCANMUE'];
		$meses[$i]=$obj;
		$i++;
	}
	$response->meses=$meses;

	$semanas=[];
	$i=0;
	// $sql="BEGIN SP_AUDTEL_IND_DEFECTOS(:CODPRV,:CODCLI,:CODPRO,:OPCION,:CODDEF,:OUTPUT_CUR); END;";
	$sql="BEGIN SP_AUDTEL_IND_DEFECTOS_V2(:CODPRV,:CODCLI,:CODPRO,:OPCION,:CODDEF,:FECHA,:OUTPUT_CUR); END;";

	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODCLI', $_POST['codcli']);
	oci_bind_by_name($stmt, ':CODPRO', $_POST['codpro']);
	$opcion=2;
	oci_bind_by_name($stmt, ':OPCION', $opcion);
	oci_bind_by_name($stmt, ':CODDEF', $_POST['coddef']);
	oci_bind_by_name($stmt, ':FECHA', 	$_POST['fecha']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->SEMANA=$row['SEMANA'];
		$obj->SUMDEF=$row['SUMDEF'];
		$obj->SUMCODDEF=$row['SUMCODDEF'];
		$obj->SUMCANMUE=$row['SUMCANMUE'];
		$semanas[$i]=$obj;
		$i++;
	}
	$response->semanas=$semanas;

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