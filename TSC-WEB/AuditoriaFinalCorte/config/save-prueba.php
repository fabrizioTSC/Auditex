<?php
	set_time_limit(480);
	include('connection.php');

	$j=1;
	for ($i=$j; $i < 31; $i++) { 
	$sql="BEGIN SP_AFC_SELECT_AUDBYEC(:ESTTSC,:CODMED,:AUDITABLE); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_GET['esttsc']);
	oci_bind_by_name($stmt, ':CODMED', $i);
	oci_bind_by_name($stmt, ':AUDITABLE', $auditable,40);
	$result=oci_execute($stmt);

	$sql="BEGIN SP_AFC_INSERT_ESTTSCMED_JV2(:ESTTSC,:CODMED,:DESMED,:DESMEDCOR,:TOLERANCIAMENOS,:TOLERANCIAMAS,:AUDITABLE,:PARTE,:HILO,:TRAVEZ,:LARGMANGA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':ESTTSC', $_GET['esttsc']);
	oci_bind_by_name($stmt, ':CODMED', $i);
	$desmed="Prueba";
	oci_bind_by_name($stmt, ':DESMED', $desmed);
	$desmedcor="A";
	oci_bind_by_name($stmt, ':DESMEDCOR', $desmedcor);
	$tolmen="1/4";
	oci_bind_by_name($stmt, ':TOLERANCIAMENOS', $tolmen);
	$tolmas="5/16";
	oci_bind_by_name($stmt, ':TOLERANCIAMAS', $tolmas);
	if ($auditable==null) {
		$auditable='';
	}else{
		if ($auditable=='-') {
			$auditable='A';
			/*
			if (trim($array[$i][3])==""){
				$auditable='';
			}*/
		}
	}
	oci_bind_by_name($stmt, ':AUDITABLE', $auditable);
	$parte='P';
	oci_bind_by_name($stmt, ':PARTE', $parte);

	//AGREGADO
	$hilo=intval($_GET['hilo']);
	oci_bind_by_name($stmt, ':HILO', $hilo);
	$travez=intval($_GET['travez']);
	oci_bind_by_name($stmt, ':TRAVEZ', $travez);
	$largmanga=intval($_GET['largmanga']);
	oci_bind_by_name($stmt, ':LARGMANGA', $largmanga);

	$result=oci_execute($stmt);
	}

?>