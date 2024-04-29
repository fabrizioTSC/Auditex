<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['request'])) {
		$sql="select * from USUARIO where ESTADO='A' and CODROL!=0";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$talleres=array();
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$taller=new stdClass();
			$taller=$row;
			$talleres[$i]=$taller;
			$i++;
		}
		$response->state=true;
		$response->usuarios=$talleres;
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->err=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>