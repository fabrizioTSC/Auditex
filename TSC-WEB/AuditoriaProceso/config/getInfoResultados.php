<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['request'])) {
		$sql="select distinct ae.codtll,tl.destll 
			from auditoriaenvio ae 
			inner join fichaauditoria fa
			on ae.codfic=fa.codfic
			inner join taller tl
			on ae.codtll=tl.codtll
			where fa.estado='T' and tl.estado='A'
			order by tl.DESTLL";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$talleres=[];
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$taller=new stdClass();
			$taller->CODTLL=$row['CODTLL'];
			$taller->DESTLL=utf8_encode($row['DESTLL']);
			$talleres[$i]=$taller;
			$i++;
		}
		$sql2="select * from USUARIO where ESTADO='A' and CODROL=3";
		$stmt=oci_parse($conn, $sql2);
		$result=oci_execute($stmt);
		$auditor=[];
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$taller=new stdClass();
			$taller->NOMUSU=utf8_encode($row['NOMUSU']);
			$taller->CODUSU=$row['CODUSU'];
			$auditor[$i]=$taller;
			$i++;
		}
		
		$sql="select * from TIPOAUDITORIA where ESTADO='A'";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$tipoauditoria=[];
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$taller=new stdClass();
			$taller->DESTAD=utf8_encode($row['DESTAD']);
			$taller->CODTAD=$row['CODTAD'];
			$tipoauditoria[$i]=$taller;
			$i++;
		}

		$response->tipoauditoria=$tipoauditoria;
		$response->auditor=$auditor;		
		$response->talleres=$talleres;
		$response->state=true;
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