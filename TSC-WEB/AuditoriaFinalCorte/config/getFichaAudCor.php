<?php
	include('connection.php');
	$response=new stdClass();

	$fichas=[];
	$i=0;
	$sql="BEGIN SP_AFC_SELECT_FICHA(:CODFIC,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_assoc($OUTPUT_CUR)){
		$ficha=new stdClass();
		$ficha=$row;
		$fichas[$i]=$ficha;
		$i++;
	}
	if (oci_num_rows($OUTPUT_CUR)==0) {
		$response->state=false;
		$response->detail="No existe ficha!";
		$response->fichas=$fichas;
	}else{
		$response->state=true;
		$response->fichas=$fichas;
	}			

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>