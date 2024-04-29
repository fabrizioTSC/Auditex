<?php
	ini_set('max_execution_time', 300);
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	$sql="select * from AQL where ESTADO='A' and CODAQL=".$_POST['codaql'];
	$stmt=oci_parse($conn,$sql);
	$result=oci_execute($stmt);
	$rowAql=oci_fetch_array($stmt);

	$sqlFichas="SELECT * FROM FICHAAUDITORIA where ESTADO='P' and CODTAD=".$_POST['codtad'];
	$stmt2=oci_parse($conn,$sqlFichas);
	$result=oci_execute($stmt2);
	$i=0;
	while($rowFichas=oci_fetch_array($stmt2,OCI_ASSOC)){
		$sqlDetalleAql="SELECT CANDEFMAX,CANAQL FROM AQLDETALLE where CODAQL=".$_POST['codaql'].
		" and ESTADO='A' and CANTIDAD>".$rowFichas['CANPAR'].
		" order by CANTIDAD";
		$stmtDetalleAql=oci_parse($conn,$sqlDetalleAql);
		$resultDetalleAql=oci_execute($stmtDetalleAql);	
		$rowDetalleAql=oci_fetch_array($stmtDetalleAql);
		
		$sqlUpdate="UPDATE FICHAAUDITORIA set CODAQL=".$rowAql['CODAQL'].", AQL=".$rowAql['AQL'].", ".
			"CANDEFMAX=".$rowDetalleAql['CANDEFMAX'].", CANAUD=".$rowDetalleAql['CANAQL'].
			" where CODFIC=".$rowFichas['CODFIC'].
			" and PARTE=".$rowFichas['PARTE'].
			" and NUMVEZ=".$rowFichas['NUMVEZ'].
			" and CODTAD=".$_POST['codtad'].
			" and CODAQL=".$rowFichas['CODAQL'];
		$stmtUpdate=oci_parse($conn,$sqlUpdate);
		$resultUpdate=oci_execute($stmtUpdate,OCI_COMMIT_ON_SUCCESS);
		if (!$resultUpdate) {
			$i++;
			$response->num_error=$i;
		}
	}
	$response->state=true;
	$response->description="Fichas actualizadas!";
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>