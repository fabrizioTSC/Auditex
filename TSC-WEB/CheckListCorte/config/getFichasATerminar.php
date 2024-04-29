<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="select distinct tll.codtll, tll.DESTLL || ' (' || tll.DESCOM || ')' destll from TALLER tll".
		" inner join fichacosturaavance fca".
		" on tll.codtll=fca.codtll".
		" where fca.estado='I'".
		" order by destll";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$defectos=array();
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$defecto=new stdClass();
			$defecto=$row;
			$defectos[$i]=$defecto;
			$i++;
		}
		$response->state=true;
		$response->fichas=$defectos;		
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