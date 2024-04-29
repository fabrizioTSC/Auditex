<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql2="SELECT * FROM FICHAAUDITORIA".
			" where CODFIC=".$_POST['codfic']." and NUMVEZ=".$_POST['numvez'].
			" and PARTE=".$_POST['parte']." and CODTAD=".$_POST['codtad']." and CODAQL=".$_POST['codaql'];
		$stmt=oci_parse($conn,$sql2);
		$resultAux=oci_execute($stmt);
		$rowAux=oci_fetch_array($stmt);

		if(is_null($rowAux['CODUSU'])){
			$sql="";
			if($_POST['tipaud']=="aql"){
				$sql="update FICHAAUDITORIA set COMENTARIOS='".$_POST['tipaud']."'".
				//",FECINIAUD=to_date('".date("d/m/Y")."','dd/mm/yyyy')".
				",FECINIAUD=SYSDATE".
				" where CODFIC=".$_POST['codfic']." and NUMVEZ=".$_POST['numvez'].
				" and PARTE=".$_POST['parte']." and CODTAD=".$_POST['codtad']." and CODAQL=".$_POST['codaql'];
			}else{
				$sql="update FICHAAUDITORIA set COMENTARIOS='".$_POST['tipaud']."',CANAUD=".$_POST['newnumero'].
				//",FECINIAUD=to_date('".date("d/m/Y")."','dd/mm/yyyy')".
				",FECINIAUD=SYSDATE".
				" where CODFIC=".$_POST['codfic']." and NUMVEZ=".$_POST['numvez'].
				" and PARTE=".$_POST['parte']." and CODTAD=".$_POST['codtad']." and CODAQL=".$_POST['codaql'];
			}
			$stmt=oci_parse($conn,$sql);
			$result=oci_execute($stmt,OCI_COMMIT_ON_SUCCESS);			
			if($result){			
				$response->state=true;
				$response->description="Exito";
			}else{
				oci_rollback($conn);
				$response->state=false;
				$error->code=2;
				$error->description="No se actualizo ficha.";
				$response->err=$error;
			}
			$response->sql=$sql;
		}else{
			if($rowAux['CODUSU']==$_POST['usuario']){
				$response->state=true;
				$response->description="Exito";
			}else{
				$response->state=false;
				$response->row=$rowAux;
				$error->code=5;
				$error->description="La ficha ya fue tomada por otro auditor!";
				$response->err=$error;
			}
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