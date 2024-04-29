<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sedes=array();
	$obj=new stdClass();
	$obj->CODSEDE="0";
	$obj->DESSEDE="(TODOS)";
	$sedes[0]=$obj;
	$i=1;
	$sql="BEGIN SP_AT_SELECT_SEDES(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODSEDE=$row['CODSEDE'];
		$obj->DESSEDE=utf8_encode($row['DESSEDE']);
		$sedes[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->sedes=$sedes;

	
	$tipser=array();
	$obj=new stdClass();
	$obj->CODTIPSERV="0";
	$obj->DESTIPSERV="(TODOS)";
	$tipser[0]=$obj;
	$i=1;
	$sql="BEGIN SP_AT_SELECT_TIPSERS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTIPSERV=$row['CODTIPSERV'];
		$obj->DESTIPSERV=utf8_encode($row['DESTIPSERV']);
		$tipser[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->tipser=$tipser;

	$talleres=array();
	$obj=new stdClass();
	$obj->CODTLL="0";
	$obj->DESTLL="(TODOS)";
	$obj->CODSEDE="0";
	$obj->CODTIPSERV="0";
	$talleres[0]=$obj;
	$i=1;
	$sql="BEGIN SP_AT_SELECT_TALLERESXREP(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTLL=$row['CODTLL'];
		$obj->DESTLL=utf8_encode($row['DESTLL']);
		$obj->CODSEDE=$row['CODSEDE'];
		$obj->CODTIPSERV=$row['CODTIPOSERV'];
		$talleres[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->talleres=$talleres;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>