<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="select * from FICHAAUDITORIA fa ".
		" inner join AUDITORIAENVIO ae on ae.CODENV=fa.CODENV".
		" inner join TALLER t on t.CODTLL=ae.CODTLL".
		" where fa.CODFIC=".$_POST['codfic']." and fa.ESTADO='P'";
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt);
		
		if (isset($_POST['typepost'])) {
			$fichas=array();
			$i=0;
			while ($row=oci_fetch_array($stmt,OCI_ASSOC)) {
				$ficha=new stdClass();
				$ficha=$row;
				$fichas[$i]=$ficha;
				$i++;
			}
			$response->fichas=$fichas;
		}else{
			$row=oci_fetch_array($stmt,OCI_ASSOC);
			$ficha=new stdClass();
			$ficha=$row;
			$response->ficha=$ficha;
		}

		$count=oci_num_rows($stmt);
		if ($count==0) {
			$response->state=false;
			$error->code=2;
			$error->description="No existe ficha";
			$response->error=$error;
		}else{
			$response->state=true;
		}
		
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->error=$error;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
?>