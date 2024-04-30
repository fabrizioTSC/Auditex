<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="EXEC AUDITEX.SP_AFC_SELECT_VALUSUFICAUD ?, ?, ?, ?, ?, ?;";
	$stmt=sqlsrv_prepare($conn, $sql, array(
		&$_POST['codfic'], 
		&$_POST['numvez'], 
		&$_POST['parte'], 
		&$_POST['codtad'], 
		&$_POST['codaql'], 
		&$_POST['usuario']));
	$result=sqlsrv_execute($stmt);

	$sql="EXEC AUDITEX.SP_AFC_INSERT_AUDFINCORDETDEF ?, ?, ?, ?, ?, ?, ?";
	$stmt=sqlsrv_prepare($conn, $sql, array(
		&$_POST['codfic'], 
		&$_POST['numvez'], 
		&$_POST['parte'], 
		&$_POST['codtad'], 
		&$_POST['codope'], 
		&$_POST['coddef'], 
		&$_POST['candef']
	));
	$result=sqlsrv_execute($stmt);
	$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	$estado=$row['ESTADO'];
	if ($result) {
		if($estado==1){
			$response->state=false;
			$error->code=3;
			$error->description="Ya se registró ese defecto. Agregue desde la tabla de resumen!";
			$response->error=$error;
		}else{
			$response->state=true;
			$response->description="¡Registro guardado!";
		}
	}else{
		$response->state=false;
		$error->code=2;
		$error->description="¡No se pudo guardar el registro!";
		$response->error=$error;
	}

	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);


/*	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="BEGIN SP_AFC_SELECT_VALUSUFICAUD(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:CODUSU); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
	oci_bind_by_name($stmt,':CODUSU',$_POST['usuario']);
	$result=oci_execute($stmt);

	$sql="BEGIN SP_AFC_INSERT_AUDFINCORDETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODOPE,:CODDEF,:CANDEF,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODOPE',$_POST['codope']);
	oci_bind_by_name($stmt,':CODDEF',$_POST['coddef']);
	oci_bind_by_name($stmt,':CANDEF',$_POST['candef']);
	oci_bind_by_name($stmt,':ESTADO',$estado,40);
	$result=oci_execute($stmt);
	if ($result) {
		if($estado==1){
			$response->state=false;
			$error->code=3;
			$error->description="Ya registro ese defecto. Añada desde la tabla de resumen!";
			$response->error=$error;
		}else{
			$response->state=true;
			$response->description="Registro guardado!";
		}
	}else{
		$response->state=false;
		$error->code=2;
		$error->description="No se pudo guardar registro!";
		$response->error=$error;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response); */
?>