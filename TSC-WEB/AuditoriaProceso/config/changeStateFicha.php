<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="update FICHAAUDITORIA set ESTADO='T',FECFINAUD=SYSDATE,".
		" RESULTADO='".$_POST['resultado']."',CANDEF=".$_POST['defectos'].",CODUSU='".$_POST['codusu']."'".
		" where CODFIC=".$_POST['codfic']." and NUMVEZ=".$_POST['numvez'].
		" and PARTE=".$_POST['parte']." and CODTAD=".$_POST['codtad']." and CODAQL=".$_POST['codaql'];
		
		$stmt=oci_parse($conn,$sql);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
		if($result){			
			if ($_POST['resultado']=="R") {
				$sql="SELECT * FROM FICHAAUDITORIA ".
					" where CODAQL=".$_POST['codaql'].
					" and CODFIC=".$_POST['codfic'].
					" and CODTAD=".$_POST['codtad'].
					" and NUMVEZ=".$_POST['numvez'].
					" and PARTE=".$_POST['parte'];
				$stmt=oci_parse($conn,$sql);
				$result=oci_execute($stmt);
				$rowItem=oci_fetch_array($stmt);

				$sql="INSERT INTO FICHAAUDITORIA(CODFIC, CODTAD, NUMVEZ, PARTE, CODENV, CODUSU, FECINIAUD, FECFINAUD, ORDEN, TIPAUD, CODAQL, AQL, CANTIDAD, CANPAR, CANAUD, CANDEFMAX, CANDEF, ESTADO, COMENTARIOS, RESULTADO)".
					" VALUES(".$_POST['codfic'].",".$_POST['codtad'].",".($rowItem['NUMVEZ']+1).",".$_POST['parte'].",".
					$rowItem['CODENV'].",NULL,CURRENT_DATE,NULL,".$rowItem['ORDEN'].",'".$rowItem['TIPAUD']."',".
					$rowItem['CODAQL'].",".$rowItem['AQL'].",".$rowItem['CANTIDAD'].",".$rowItem['CANPAR'].",".
					$rowItem['CANAUD'].",".$rowItem['CANDEFMAX'].",0,'P','','')";
				$stmt2=oci_parse($conn,$sql);
				$resultInsert=oci_execute($stmt2,OCI_COMMIT_ON_SUCCESS);		

				if ($resultInsert) {
					$response->state=true;
					$response->description="Exito";
				}else{
					$response->state=false;
					$error->description="No se guardo la nueva parte de la ficha!";
					$response->error=$error;
				}
				$response->sqlInsertNew=$sql;
			}else{
				$response->state=true;
				$response->description="Exito";
			}
		}else{
			$response->state=false;
			$error->code=2;
			$error->description="No se actualizo ficha.";
			$response->error=$error;
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