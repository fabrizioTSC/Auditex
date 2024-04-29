<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codtad'])) {
		$sql="Insert into AUDITORIADETALLEDEFECTO values(".
		$_POST['codfic'].",".
		$_POST['codtad'].",".
		$_POST['numvez'].",".
		$_POST['parte'].",".
		$_POST['coddef'].",".
		$_POST['codope'].",".
		$_POST['candef'].
		")";
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
		if($result){
			//PARECE QUE FALTA EL CODAQL EN LOS DEFECTOS
			$sqlValidar="SELECT SUM(CANDEF) AS SUMA FROM AUDITORIADETALLEDEFECTO".
			" WHERE CODFIC=".$_POST['codfic'].
				" and CODTAD=".$_POST['codtad'].
				" and NUMVEZ=".$_POST['numvez'].
				" and PARTE=".$_POST['parte'];
			$stmt=oci_parse($conn, $sqlValidar);
			$resultValidar=oci_execute($stmt);
			$rowValidar=oci_fetch_array($stmt);
			$sumaDefectos=$rowValidar['SUMA'];
			if(!is_null($sumaDefectos)){
				$sqlDefectos="SELECT CANDEFMAX FROM FICHAAUDITORIA".
				" WHERE CODFIC=".$_POST['codfic'].
					" and CODTAD=".$_POST['codtad'].
					" and NUMVEZ=".$_POST['numvez'].
					" and PARTE=".$_POST['parte'].
					" and CODAQL=".$_POST['codaql'];
				$stmt=oci_parse($conn, $sqlDefectos);
				$resultDefectos=oci_execute($stmt);
				$rowDefectos=oci_fetch_array($stmt);
				$canDefectos=$rowDefectos['CANDEFMAX'];

				$estado='A';
				if ($sumaDefectos>$canDefectos) {
					$estado='R';
				}
				$sqlUpdateFicha="UPDATE FICHAAUDITORIA set CANDEF=".$sumaDefectos.",".
					" RESULTADO='".$estado."'".
					" WHERE CODFIC=".$_POST['codfic'].
					" and CODTAD=".$_POST['codtad'].
					" and NUMVEZ=".$_POST['numvez'].
					" and PARTE=".$_POST['parte'].
					" and CODAQL=".$_POST['codaql'];
				$stmt=oci_parse($conn, $sqlUpdateFicha);
				$resultUpdate=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
				if ($resultUpdate) {
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
				$stmt=oci_parse($conn, $sqlUpdateFicha);
				$resultUpdate=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
				if ($resultUpdate) {
					$response->state=true;
					$response->description="Registro agregado!";
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
	echo json_encode($response);
?>