<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
		$sql="select * from TIPOAUDITORIA where ESTADO='A' order by DESTAD";
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt);
		$tipos=array();
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$taller=new stdClass();
			$taller=$row;
			$tipos[$i]=$taller;
			$i++;
		}
		$sql="select * from AQL where ESTADO='A' order by AQL";
		$stmt2=oci_parse($conn,$sql);
		$result=oci_execute($stmt2);
		$aqls=array();
		$i=0;
		while($row=oci_fetch_array($stmt2,OCI_ASSOC)){
			$taller=new stdClass();
			$taller=$row;
			$aqls[$i]=$taller;
			$i++;
		}
	$response->state=true;
	$response->tipos=$tipos;
	$response->aqls=$aqls;
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>