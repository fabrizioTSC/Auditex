<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="SELECT * FROM AuditoriaProceso where CODFIC=".$_POST['codfic'];
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$fichas=[];
		$i=0;
		while ($row=oci_fetch_array($stmt)) {
			$fichas[$i]=$row;
			$i++;
		}
		$response->state=true;
		$response->fichas=$fichas;
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