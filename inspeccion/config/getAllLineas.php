<?php
	include('connection.php');
	$response=new stdClass();

		$sql="select * from LINEA_ETON";		
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt);
		$lineas=array();
		$i=0;
		
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$obj=new stdClass();
			$obj->LINEA=$row['LINEA'];
			$lineas[$i]=$obj;
			$i++;
		}
		$response->lineas=$lineas;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>