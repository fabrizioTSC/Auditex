<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="SELECT MAX(PARTE) as MAXPARTE FROM FICHAAUDITORIA ".
		" where CODAQL=".$_POST['codaql'].
		" and CODFIC=".$_POST['codfic'].
		" and CODTAD=".$_POST['codtad'];
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$row=oci_fetch_array($stmt);

		$sql="SELECT * FROM FICHAAUDITORIA ".
		" where CODAQL=".$_POST['codaql'].
		" and CODFIC=".$_POST['codfic'].
		" and CODTAD=".$_POST['codtad'].
		" and NUMVEZ=".$_POST['numvez'].
		" and PARTE=".$_POST['parte'];		
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$rowItem=oci_fetch_array($stmt);

		// SE CAMBIO EL ORDEN - ACTUALZAR VA CON LA VARIABLE NEWCANTIDAD Y VICEVERSA
		$cantidadUpdate=$rowItem['CANPAR']-$_POST['newcantidad'];
		$sqlAql="SELECT * FROM AQLDETALLE WHERE CANTIDAD>=".$cantidadUpdate." and CODAQL=".$_POST['codaql'].
		" and ESTADO='A' order by CANTIDAD asc";
		$stmt=oci_parse($conn, $sqlAql);
		$result=oci_execute($stmt);
		$rowAql=oci_fetch_array($stmt);

		$sql="INSERT INTO FICHAAUDITORIA(CODFIC, CODTAD, NUMVEZ, PARTE, CODENV, CODUSU, FECINIAUD, FECFINAUD, ORDEN, TIPAUD, CODAQL, AQL, CANTIDAD, CANPAR, CANAUD, CANDEFMAX, CANDEF, ESTADO, COMENTARIOS, RESULTADO)".
			" VALUES(".$_POST['codfic'].",".$_POST['codtad'].",".$_POST['numvez'].",".($row['MAXPARTE']+1).",".
			$rowItem['CODENV'].",NULL,CURRENT_DATE,NULL,".$rowItem['ORDEN'].",'".$rowItem['TIPAUD']."',".
			$rowItem['CODAQL'].",".$rowItem['AQL'].",".$rowItem['CANTIDAD'].",".$cantidadUpdate.",".$rowAql['CANAQL'].","
			.$rowAql['CANDEFMAX'].",0,'P','','')";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);

		$sqlAql="SELECT * FROM AQLDETALLE WHERE ".$_POST['newcantidad']."<=CANTIDAD and CODAQL=".$_POST['codaql'].
		" and ESTADO='A' order by CANTIDAD asc";
		$stmt=oci_parse($conn, $sqlAql);
		$result=oci_execute($stmt);
		$rowAql=oci_fetch_array($stmt);

		$sqlUpdate="UPDATE FICHAAUDITORIA set CANPAR=".$_POST['newcantidad'].", CANAUD=".$rowAql['CANAQL'].
		", CANDEFMAX=".$rowAql['CANDEFMAX'].
		" where CODAQL=".$_POST['codaql'].
		" and CODFIC=".$_POST['codfic'].
		" and CODTAD=".$_POST['codtad'].
		" and NUMVEZ=".$_POST['numvez'].
		" and PARTE=".$_POST['parte'];
		$stmt=oci_parse($conn, $sqlUpdate);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);

		if ($result) {
			$response->state=true;
			$error->description="Ficha partida!";
		}else{
			$response->state=false;
			$error->code=3;
			$error->description="No se pudo partir la ficha! ".$sql;
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