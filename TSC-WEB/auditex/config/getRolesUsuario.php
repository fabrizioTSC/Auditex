<?php
	include('connection.php');
	$response=new stdClass();

	$roles=array();
	$i=0;
	$obj=new stdClass();
	$obj->CODROL="0";
	$obj->DESROL="SIN ACCESO";
	$roles[$i]=$obj;
	$i++;
	$sql="BEGIN SP_AT_SELECT_ROLES(:OUTPUR_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUR_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODROL=$row['CODROL'];
		$obj->DESROL=utf8_encode($row['DESROL']);
		$roles[$i]=$obj;
		$i++;
	}
	$response->roles=$roles;

	$usuarioroles=array();
	$i=0;
	$sql="BEGIN SP_AT_SELECT_ROLBYUSU(:CODUSU,:OUTPUR_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODUSU',$_POST['codusu']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUR_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODTAD=$row['CODTAD'];
		$obj->CODROL=$row['CODROL'];
		$obj->ESTADO=$row['ESTADO'];
		$obj->DESTAD=utf8_encode($row['DESTAD']);
		$usuarioroles[$i]=$obj;
		$i++;
	}
	$response->usuarioroles=$usuarioroles;
	$response->state=true;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>