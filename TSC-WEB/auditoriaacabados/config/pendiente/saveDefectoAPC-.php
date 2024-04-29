<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="SELECT * FROM FICHAAUDITORIACORTE ".
		" where CODFIC=".$_POST['codfic'].
		" and CODTAD=".$_POST['codtad']." and NUMVEZ=".$_POST['numvez']." and PARTE=".$_POST['parte'].
		" and CODAQL=".$_POST['codaql']." and CODUSU='".$_POST['usuario']."'";
		$stmt=oci_parse($conn, $sql);
		$resultFicha=oci_execute($stmt);
		$rowTest=oci_fetch_array($stmt);
		if(oci_num_rows($stmt)==0){
			$sqlUpdate="UPDATE FICHAAUDITORIACORTE set CODUSU='".$_POST['usuario']."'".
			" where CODFIC=".$_POST['codfic'].
			" and CODTAD=".$_POST['codtad']." and NUMVEZ=".$_POST['numvez']." and PARTE=".$_POST['parte'].
			" and CODAQL=".$_POST['codaql'];
			$stmt=oci_parse($conn, $sqlUpdate);
			$resultUpdate=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
		}

		$sql="select * from AUDITORIACORTEDETALLEDEFECTO where CODFIC=".$_POST['codfic'].
		" and CODTAD=".$_POST['codtad']." and NUMVEZ=".$_POST['numvez']." and PARTE=".$_POST['parte'].
		" and CODOPE=".$_POST['codope']." and CODDEF=".$_POST['coddef'];

		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$row=oci_fetch_array($stmt);

		if (oci_num_rows($stmt)==0) {
			$sqlInsert="INSERT INTO AUDITORIACORTEDETALLEDEFECTO ".
			"VALUES ".
			"(".$_POST['codfic'].","
			.$_POST['codtad'].",'"
			.$_POST['numvez']."',".$_POST['parte'].",".$_POST['coddef'].",".$_POST['codope'].",".$_POST['candef'].")";
			
			$stmt=oci_parse($conn, $sqlInsert);
			$resultInsert=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);
			if($resultInsert){
				$response->state=true;
				$response->description="Registro guardado!";
			}else{
				oci_rollback($conn);
				$response->state=false;
				$error->code=2;
				$error->description="No se pudo guardar registro!";
				$response->error=$error;
			}
		}else{
			$response->state=false;
			$error->code=3;
			$error->description="Ya registro ese defecto!";
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