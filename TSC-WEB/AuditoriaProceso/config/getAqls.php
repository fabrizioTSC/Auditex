<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['aql'])) {
		$aqls=array();
		$i=0;
		$sql="SELECT * FROM AQL where ESTADO='A' order by AQL";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$aql=new stdClass();
			$aql=$row;
			$aqls[$i]=$aql;
			$i++;
		}
		$response->state=true;
		$response->aqls=$aqls;
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->error=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>