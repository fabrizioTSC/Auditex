<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codtll'])) {
		// Para auditoria final de costura
		$sql="select * from TALLER t ".
			"inner join AUDITORIAENVIO ae on t.CODTLL=ae.CODTLL ".
			"inner join FICHAAUDITORIA fa on ae.CODENV=fa.CODENV ".
			" where t.CODTLL=".$_POST['codtll']." and fa.ESTADO='P' and fa.CODTAD=10 order by fa.CODFIC,fa.PARTE,fa.NUMVEZ";
		
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt);
		$fichas=array();
		$i=0;
		
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$ficha=new stdClass();
			$ficha->CODFIC=$row['CODFIC'];
			$ficha->CANPAR=$row['CANPAR'];
			$ficha->PARTE=$row['PARTE'];
			$ficha->NUMVEZ=$row['NUMVEZ'];
			$ficha->CODAQL=$row['CODAQL'];
			$ficha->AQL=$row['AQL'];
			$ficha->CODTAD=$row['CODTAD'];
			$fichas[$i]=$ficha;
			$i++;
		}

		if (oci_num_rows($stmt)==0) {			
			$response->state=false;
			$response->description="No hay fichas para el taller!";
		}else{
			$response->state=true;
			$response->fichas=$fichas;
		}
		
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