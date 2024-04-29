<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="select * from AUDITORIACORTEDETALLEDEFECTO auddd".
		" inner join DEFECTO d on d.CODDEF=auddd.CODDEF".
		" where auddd.CODFIC=".$_POST['codfic']." and auddd.NUMVEZ=".$_POST['numvez'].
		" and auddd.PARTE=".$_POST['parte']." and auddd.CODTAD=".$_POST['codtad'];
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
		$response->defectos=$defectos;		
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