<?php
/*
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['option'])) {
		$sql="";
		if ($_POST['option']=="delete") {
			$sql="DELETE FROM AUDITORIADETALLEDEFECTO".
			" WHERE CODFIC=".$_POST['codfic'].
			" and CODTAD=".$_POST['codtad'].
			" and NUMVEZ=".$_POST['numvez'].
			" and PARTE=".$_POST['parte'].
			" and CODDEF=".$_POST['coddef'].
			" and CODOPE=".$_POST['codope'];
			$stmt=oci_parse($conn,$sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
		}else{
			$sql="UPDATE AUDITORIADETALLEDEFECTO set CANDEF=".$_POST['candef'].",".
			" CODDEF=".$_POST['newcoddef'].", CODOPE=".$_POST['newcodope'].
			" WHERE CODFIC=".$_POST['codfic'].
			" and CODTAD=".$_POST['codtad'].
			" and NUMVEZ=".$_POST['numvez'].
			" and PARTE=".$_POST['parte'].
			" and CODDEF=".$_POST['coddef'].
			" and CODOPE=".$_POST['codope'];
			$stmt=oci_parse($conn,$sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
		}
		if($result){
			//PARECE QUE FALTA EL CODAQL EN LOS DEFECTOS
			$sqlValidar="SELECT SUM(CANDEF) AS SUMA FROM AUDITORIADETALLEDEFECTO".
			" WHERE CODFIC=".$_POST['codfic'].
				" and CODTAD=".$_POST['codtad'].
				" and NUMVEZ=".$_POST['numvez'].
				" and PARTE=".$_POST['parte'];
			$stmtValidar=oci_parse($conn,$sqlValidar);
			$resultValidar=oci_execute($stmtValidar);
			$rowValidar=oci_fetch_array($stmtValidar);
			$sumaDefectos=$rowValidar['SUMA'];

			$sqlDefectos="SELECT * FROM FICHAAUDITORIA".
			" WHERE CODFIC=".$_POST['codfic'].
				" and CODTAD=".$_POST['codtad'].
				" and NUMVEZ=".$_POST['numvez'].
				" and PARTE=".$_POST['parte'].
				" and CODAQL=".$_POST['codaql'];
			$stmtDefectos=oci_parse($conn,$sqlDefectos);
			$resultDefectos=oci_execute($stmtDefectos);
			$rowDatoFicha=oci_fetch_array($stmtDefectos);
			$resultadoAnterior=$rowDatoFicha['RESULTADO'];

			if(!is_null($sumaDefectos)){
				$canDefectos=$rowDatoFicha['CANDEFMAX'];

				$resultado='A';
				if ($sumaDefectos>$canDefectos) {
					$resultado='R';
				}

				$response->resultadoActual=$resultado;
				$response->resultadoAnterior=$resultadoAnterior;
				$sqlUpdateFicha="UPDATE FICHAAUDITORIA set CANDEF=".$sumaDefectos.",".
					" RESULTADO='".$resultado."'".
					" WHERE CODFIC=".$_POST['codfic'].
					" and CODTAD=".$_POST['codtad'].
					" and NUMVEZ=".$_POST['numvez'].
					" and PARTE=".$_POST['parte'].
					" and CODAQL=".$_POST['codaql'];
				$stmtUpdateFicha=oci_parse($conn,$sqlUpdateFicha);
				$resultUpdate=oci_execute($stmtUpdateFicha,OCI_COMMIT_ON_SUCCESS);
				if ($resultUpdate) {
					if ($resultado!=$resultadoAnterior) {
						if ($resultado=="A") {
							$sqlDelete="DELETE FROM FICHAAUDITORIA ".
								" WHERE CODFIC=".$_POST['codfic'].
								" and CODTAD=".$_POST['codtad'].
								" and NUMVEZ=".(((int)$_POST['numvez'])+1).
								" and PARTE=".$_POST['parte'].
								" and CODAQL=".$_POST['codaql'];
							$stmtDelete=oci_parse($conn,$sqlDelete);
							$result=oci_execute($stmtDelete,OCI_COMMIT_ON_SUCCESS);
						}else{
							$sqlInsert="INSERT INTO FICHAAUDITORIA(CODFIC, CODTAD, NUMVEZ, PARTE, CODENV, CODUSU, FECINIAUD, FECFINAUD, ORDEN, TIPAUD, CODAQL, AQL, CANTIDAD, CANPAR, CANAUD, CANDEFMAX, CANDEF, ESTADO, COMENTARIOS, RESULTADO)".
								" VALUES(".
								$_POST['codfic'].",".
								$_POST['codtad'].",".
								($rowDatoFicha['NUMVEZ']+1).",".
								$rowDatoFicha['PARTE'].",".
								$rowDatoFicha['CODENV'].
								",NULL,CURRENT_DATE,NULL,".
								$rowDatoFicha['ORDEN'].",'".
								$rowDatoFicha['TIPAUD']."',".
								$rowDatoFicha['CODAQL'].",".
								$rowDatoFicha['AQL'].",".$rowDatoFicha['CANTIDAD'].",".$rowDatoFicha['CANPAR'].",".
								$rowDatoFicha['CANAUD'].",".$rowDatoFicha['CANDEFMAX'].",0,'P','','')";
							$stmtInsert=oci_parse($conn,$sqlInsert);
							$result=oci_execute($stmtInsert,OCI_COMMIT_ON_SUCCESS);	
						}
					}
					$response->state=true;
					$response->description="Registro editado/borrado!";
				}else{
					$response->state=false;
					$error->code=5;
					$response->description="No se pudo editar/eliminar el registro!";	
					$response->error=$error;
				}
			}else{
				$sqlUpdateFicha="UPDATE FICHAAUDITORIA set CANDEF=0,".
					" RESULTADO='A'".
					" WHERE CODFIC=".$_POST['codfic'].
					" and CODTAD=".$_POST['codtad'].
					" and NUMVEZ=".$_POST['numvez'].
					" and PARTE=".$_POST['parte'].
					" and CODAQL=".$_POST['codaql'];
				$stmtUpdateFicha=oci_parse($conn,$sqlUpdateFicha);
				$resultUpdate=oci_execute($stmtUpdateFicha,OCI_COMMIT_ON_SUCCESS);
				if ($resultUpdate) {
					if ($resultadoAnterior=="R") {
						$sqlDelete="DELETE FROM FICHAAUDITORIA ".
							" WHERE CODFIC=".$_POST['codfic'].
							" and CODTAD=".$_POST['codtad'].
							" and NUMVEZ=".(((int)$_POST['numvez'])+1).
							" and PARTE=".$_POST['parte'].
							" and CODAQL=".$_POST['codaql'];
						$stmtDelete=oci_parse($conn,$sqlDelete);
						$result=oci_execute($stmtDelete,OCI_COMMIT_ON_SUCCESS);
					}
					$response->state=true;
					$response->description="Registro agregado! ";
				}else{
					$response->state=false;
					$error->code=5;
					$response->description="No se pudo agregar el defecto!";	
					$response->error=$error;
				}
			}
		}else{
			$response->state=false;
			$error->code=2;
			$error->description="No se pudo agregar el defecto!";
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
	echo json_encode($response);*/

	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

		$sql="";
		if ($_POST['option']=="delete") {
			$sql="BEGIN SP_AFC_DELETE_AUDDETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODDEF,:CODOPE); END;";
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt, ':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt, ':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt, ':CODDEF',$_POST['coddef']);
			oci_bind_by_name($stmt, ':CODOPE',$_POST['codope']);
			$result=oci_execute($stmt);
		}else{
			$sql="BEGIN SP_AFC_UPDATE_AUDDETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODOPE,:CODDEF,:NEWCODOPE,:NEWCODDEF,:CANDEF,:ESTADO); END;";
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt, ':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt, ':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt, ':CODDEF',$_POST['coddef']);
			oci_bind_by_name($stmt, ':CODOPE',$_POST['codope']);
			oci_bind_by_name($stmt, ':NEWCODDEF',$_POST['newcoddef']);
			oci_bind_by_name($stmt, ':NEWCODOPE',$_POST['newcodope']);
			oci_bind_by_name($stmt, ':CANDEF',$_POST['candef']);
			oci_bind_by_name($stmt, ':ESTADO',$estado);

			$result=oci_execute($stmt);
		}
		if($result){
			$sql="BEGIN SP_AFC_CORRECT_FICAUDCOR(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL); END;";
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt, ':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt, ':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt, ':CODAQL',$_POST['codaql']);
			$result=oci_execute($stmt);
			if($result){
				$response->state=true;
			}else{
				$response->state=false;
				$error->code=3;
				$error->description="No se pudo corregir la ficha!";
				$response->error=$error;
			}
		}else{
			$response->state=false;
			$error->code=2;
			$error->description="No se pudo agregar el defecto!";
			$response->error=$error;
		}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>