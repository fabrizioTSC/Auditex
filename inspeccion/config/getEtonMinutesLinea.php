<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

		$sql="select * from LINEA_ETON_HORA where to_char(fecha,'DDMMYYYY')=to_char(sysdate,'DDMMYYYY') and LINEA=".$_POST['linea'];
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt);
		$linea_hora=[];
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$obj=new stdClass();
			$obj->LINEA=$row['LINEA'];
			$obj->HORA=$row['HORA'];
			$obj->MIN_ASIGNADOS=$row['MIN_ASIGNADOS'];
			$linea_hora[$i]=$obj;
			$i++;
		}
		$response->linea_hora=$linea_hora;

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>