<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$esttsc=array();
	$obj=new stdClass();
	$obj->ESTTSC="0";
	$obj->DESESTTSC="(TODOS)";
	$esttsc[0]=$obj;
	$i=1;
	$sql="BEGIN SP_AFC_SELECT_ESTTSCREP(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->ESTTSC=$row['ESTTSC'];
		$obj->DESESTTSC=utf8_encode($row['ESTTSC']);
		$esttsc[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->esttsc=$esttsc;

	
	$usuario=array();
	$obj=new stdClass();
	$obj->CODUSU="0";
	$obj->DESUSU="(TODOS)";
	$usuario[0]=$obj;
	$i=1;
	$sql="BEGIN SP_AT_SELECT_USUARIOS(:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODUSU=utf8_encode($row['ALIUSU']);
		$obj->DESUSU=utf8_encode($row['NOMUSU']);
		$usuario[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->usuario=$usuario;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>