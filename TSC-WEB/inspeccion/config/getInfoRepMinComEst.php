<?php
	include("connection.php");
	$response=new stdClass();

	$titulo="";
	if ($_POST['esttsc']=="0") {
		$titulo.="TODOS / ";
	}else{
		$titulo.=$_POST['esttsc']." / ";
	}
	if ($_POST['codfic']=="0") {
		$titulo.="TODOS / ";
	}else{
		$titulo.=$_POST['codfic']." / ";
	}

	$ar_fecini=explode("-",$_POST['fecini']);
	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$ar_fecfin=explode("-",$_POST['fecfin']);
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];

	$mincom=[];
	$i=0;
	$sql="BEGIN SP_INSP_REP_MINCOMEST(:FECINI,:FECFIN,:ESTTSC,:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':FECINI', $fecini);
	oci_bind_by_name($stmt, ':FECFIN', $fecfin);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->FECHA=$row['FECHA'];
		$obj->CODUSU=$row['CODUSU'];
		$obj->ESTCLI=$row['ESTCLI'];
		$obj->ESTTSC=$row['ESTTSC'];
		$obj->ALTERNATIVA=$row['ALTERNATIVA'];
		$obj->RUTA=$row['RUTA'];
		$obj->TIESTD=str_replace(",",".",$row['TIESTD']);
		$obj->TIECOM=intval(floatval(str_replace(",",".",$row['TIECOM']))*1000)/1000;
		$obj->TIETOT=str_replace(",",".",$row['TIETOT']);
		$obj->OBS=utf8_encode($row['OBS']);
		$obj->TIEORI=str_replace(",",".",$row['TIEORI']);
		$mincom[$i]=$obj;
		$i++;
	}
	$response->mincom=$mincom;
	$response->titulo=$titulo;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>