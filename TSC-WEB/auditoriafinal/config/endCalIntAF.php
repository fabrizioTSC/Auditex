<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AF_UPDATE_ENDCALINT(:PEDIDO,:DSCCOL,:PARTE,:NUMVEZ,:OBS,:CODUSU,:RESULTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
	oci_bind_by_name($stmt,':DSCCOL',$_POST['dsccol']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	$obs=utf8_decode($_POST['obs']);
	oci_bind_by_name($stmt,':OBS',$obs);
	session_start();
	$codusu=$_SESSION['user'];	
	oci_bind_by_name($stmt,':CODUSU',$codusu);
	oci_bind_by_name($stmt,':RESULTADO',$resultado,40);
	$result=oci_execute($stmt);
	if ($result) {
		$response->state=true;
		$response->RESULTADO=$resultado;
		if ($resultado=="R") {
			$response->detail="Auditoría rechazada";
		}else{
			$response->detail="Auditoría aprobada";
		}		
		$response->ESTADO='T';
	}else{
		$response->state=false;
		$response->detail="Hubo un error al guardar los datos";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);