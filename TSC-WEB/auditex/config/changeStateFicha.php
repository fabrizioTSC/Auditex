<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

	$sql="BEGIN SP_AT_UPDATE_FICHAAUDITORIA_V2(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:CODUSU,:RESULTADO,:CANDEF,:OBSERVACIONES,:TIPOAUDITORIA); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
	oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
	oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
	oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
	oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);
	oci_bind_by_name($stmt,':CODUSU',$_POST['codusu']);
	oci_bind_by_name($stmt,':RESULTADO',$_POST['resultado']);
	oci_bind_by_name($stmt,':CANDEF',$_POST['defectos']);
	oci_bind_by_name($stmt,':OBSERVACIONES',$_POST['observacion']);

	// AGREGADO - TIPO AUDITORIA
	oci_bind_by_name($stmt,':TIPOAUDITORIA',$_POST['tipoauditoria']);


	$result=oci_execute($stmt);
	if($result){			
		if ($_POST['resultado']=="R") {
			$sql="BEGIN SP_AT_INSERT_FICHAAUDIREC_V2(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL,:TIPOAUDITORIA); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt,':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt,':CODAQL',$_POST['codaql']);

			// AGREGADO - TIPO AUDITORIA
			oci_bind_by_name($stmt,':TIPOAUDITORIA',$_POST['tipoauditoria']);

			$result=oci_execute($stmt);
			if ($result) {
				$response->state=true;
				$response->description="Éxito";
			}else{
				$response->state=false;
				$error->description="No se guardó la nueva parte de la ficha!";
				$response->error=$error;
			}
		}else{
			$response->state=true;
			$response->description="Éxito";
		}
	}else{
		$response->state=false;
		$error->code=2;
		$error->description="No se actualizó ficha.";
		$response->error=$error;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>