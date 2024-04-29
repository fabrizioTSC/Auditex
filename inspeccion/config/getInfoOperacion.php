<?php
	include('connection.php');
	$response=new stdClass();
	
		$sql="select * from defecto def
	    inner join familiadefecto fd
	    on def.CODFAM=fd.CODFAMILIA
		WHERE def.coddef=".$_POST['coddef'];
		
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt);
		
		$row=oci_fetch_array($stmt,OCI_ASSOC);
		$defecto=new stdClass();
		$defecto->CODDEF=$row['CODDEF'];
		$defecto->CODDEFAUX=$row['CODDEFAUX'];
		$defecto->CODFAM=$row['CODFAM'];
		$defecto->DESDEF=utf8_encode($row['DESDEF']);
		$defecto->DSCFAMILIA=utf8_encode($row['DSCFAMILIA']);

		$response->defecto=$defecto;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>