<?php
	$conn = oci_connect("AUDITEX", "oracle", "(DESCRIPTION =    (ADDRESS_LIST =      (ADDRESS = (PROTOCOL = TCP)(HOST = 172.16.88.137)(PORT = 1521))    )    (CONNECT_DATA =      (SERVER = DEDICATED)      (SERVICE_NAME = dbsystex)    )  )"); 
	$response=new stdClass();

	$i=0;
	$sql="BEGIN SP_AT_SELECT_USUBYDNI(:DNI,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':DNI', $_POST['dni']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->ALIUSU=$row['ALIUSU'];
		$obj->NOMUSU=utf8_encode($row['NOMUSU']);
		$response->datos=$obj;
		$i++;
	}
	if($i>0){
		$response->state=true;
	}else{
		$response->state=false;
		$response->detail="DNI no encontrado!";
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>