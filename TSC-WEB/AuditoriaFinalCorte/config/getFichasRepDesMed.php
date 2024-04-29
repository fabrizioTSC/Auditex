<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	
	$ficha=array();
	$obj=new stdClass();
	$obj->CODFIC="0";
	$obj->DESFIC="(TODOS)";
	$obj->ESTTSC="";
	$ficha[0]=$obj;
	$i=1;
	$sql="BEGIN SP_AFC_SELECT_FICHAREP(:ESTTSC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODFIC=$row['CODFIC'];
		$obj->DESFIC=$row['CODFIC'];
		$ficha[$i]=$obj;
		$i++;
	}
	$response->state=true;
	$response->ficha=$ficha;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>