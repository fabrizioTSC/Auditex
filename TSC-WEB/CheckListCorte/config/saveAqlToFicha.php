<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="SELECT * FROM AQL where CODAQL=".$_POST['newaql'];
		$stmt=oci_parse($conn, $sql);
		$resultAql=oci_execute($stmt);
		$row=oci_fetch_array($stmt);

		$sqlFicha="SELECT CANPAR FROM FICHAAUDITORIA ".
		" WHERE CODFIC=".$_POST['codfic']." and CODTAD=".$_POST['codtad'].
		" and NUMVEZ=".$_POST['numvez']." and PARTE=".$_POST['parte']." and CODAQL=".$_POST['codaql'];
		$stmt=oci_parse($conn, $sqlFicha);
		$result=oci_execute($stmt);
		$rowFicha=oci_fetch_array($stmt);
		$canpar=$rowFicha['CANPAR'];

		$sqlDetalleAql="SELECT CANDEFMAX,CANAQL FROM AQLDETALLE where CODAQL=".$_POST['codaql']." and ESTADO='A'".
		" and CANTIDAD>".$canpar.
		" order by CANTIDAD asc";

		$stmt=oci_parse($conn, $sqlDetalleAql);
		$result=oci_execute($stmt);
		$rowDetalleAql=oci_fetch_array($stmt);

		$sql="UPDATE FICHAAUDITORIA set CODAQL=".$_POST['newaql'].", AQL='".$row['AQL']."',".
		" CANAUD=".$rowDetalleAql['CANAQL'].", CANDEFMAX=".$rowDetalleAql['CANDEFMAX'].
		" WHERE CODFIC=".$_POST['codfic']." and CODTAD=".$_POST['codtad'].
		" and NUMVEZ=".$_POST['numvez']." and PARTE=".$_POST['parte']." and CODAQL=".$_POST['codaql'];

		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);

		if ($result) {
			$response->state=true;
			$error->description="Ficha modificada!";
		}else{
			$response->state=false;
			$error->code=3;
			$error->description="No se pudo modificar ficha!";
			$response->error=$error;			
		}
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->error=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>