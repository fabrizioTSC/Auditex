<?php
	include('connection.php');
	$response = new stdClass();
	$error = new stdClass();
	if (isset($_POST['codfic'])) {
		$sql = "EXEC AUDITEX.SP_AFC_SELECT_AUDCORTEDTLLDEF ?, ?, ?, ?";
		
		$stmt = sqlsrv_prepare($conn, $sql, array(
			$_POST['codfic'], 
			$_POST['numvez'], 
			$_POST['parte'], 
			$_POST['codtad']
		));
		$result= sqlsrv_execute($stmt);
		$error->code = $result;
		if ($result) {
			$defectos = array();
			$i = 0;
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$defecto=new stdClass();
				$defecto=$row;
				$defectos[$i]=$defecto;
				$i++;
			}
			$response->state = true;
			$response->defectos = $defectos;
		} else {
			$response->state = false;
			$error->code = 2;
			$error->description = "Error al ejecutar la consulta.";
			$response->err = $error;
		}
	} else {
		$response->state = false;
		$error->code = 1;
		$error->description = "No es un método POST.";
		$response->err = $error;
	}
	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);


/*	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['codfic'])) {
		$sql="select * from AUDITORIACORTEDETALLEDEFECTO auddd".
		" inner join DEFECTO d on d.CODDEF=auddd.CODDEF".
		" where auddd.CODFIC=".$_POST['codfic']." and auddd.NUMVEZ=".$_POST['numvez'].
		" and auddd.PARTE=".$_POST['parte']." and auddd.CODTAD=".$_POST['codtad'];
		$stmt=oci_parse($conn, $sql);
		$result=oci_execute($stmt);
		$defectos=array();
		$i=0;
		while($row=oci_fetch_array($stmt,OCI_ASSOC)){
			$defecto=new stdClass();
			$defecto=$row;
			$defectos[$i]=$defecto;
			$i++;
		}
		$response->state=true;
		$response->defectos=$defectos;		
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->err=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response); */
?>