<?php
	include("connection.php");
	$response=new stdClass();

	$state=false;
	$ficha=new stdClass();
	$sql="BEGIN SP_INSP_SELECT_FICHAINFO(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
		$obj=new stdClass();
		$obj->codtll=$row['CODTLL'];
		$obj->linea=utf8_encode($row['DESTLL']);
		$obj->estilo=$row['ESTTSC'];
		$obj->cliente=utf8_encode($row['DESCLI']);
		$obj->color=$row['DESCOL'];	
		$ficha=$obj;
		$state=true;
	}
	$response->state=$state;	
	$response->ficha=$ficha;
	if (!$state) {
		$response->detail="No se encuetra la ficha!";
	}

	$sql="BEGIN SP_INSP_SELECT_TALLER(:CODTLL,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODTLL', $_POST['codtll']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	$row=oci_fetch_assoc($OUTPUT_CUR);
	$response->TALLER=utf8_encode($row['DESTLL']);	

	oci_close($conn);
	header("Content-Type:application/json");
	echo json_encode($response);
?>