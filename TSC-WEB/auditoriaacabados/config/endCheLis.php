<?php
	set_time_limit(240);
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AA_UPDATE_ENDCHELISPARVEZ(:CODFIC,:PARTE,:NUMVEZ,:CODUSU,:ESTADO); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	session_start();
	$codusu=$_SESSION['user'];
	oci_bind_by_name($stmt, ':CODUSU', $codusu);
	oci_bind_by_name($stmt, ':ESTADO', $estado,40);
	$result=oci_execute($stmt);

	if ($result) {
		if ($estado==0) {
			$audchelis=[];
			$sql="BEGIN SP_AA_SELECT_AUDACAALL(:CODFIC,:OUTPUT_CUR); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':CODFIC',$_POST['codfic']);
			$OUTPUT_CUR=oci_new_cursor($conn);
			oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
			$result=oci_execute($stmt);
			oci_execute($OUTPUT_CUR);
			while($row=oci_fetch_assoc($OUTPUT_CUR)){
				$obj=new stdClass();
				$obj->PARTE=$row['PARTE'];
				$obj->NUMVEZ=$row['NUMVEZ'];
				$obj->FECINIAUD=$row['FECINIAUD'];
				$obj->FECFINAUD=$row['FECFINAUD'];
				$obj->DESTLL=utf8_encode($row['DESTLL']);
				$obj->DESCEL=utf8_encode($row['DESCEL']);
				$obj->CANTIDAD=$row['CANTIDAD'];
				$obj->CODUSU=$row['CODUSU'];
				$obj->ESTADO=$row['ESTADO'];
				$obj->RESULTADO=$row['RESULTADO'];
				array_push($audchelis, $obj);
			}
			$response->audchelis=$audchelis;
			$response->state=true;
		}else{
			if ($estado==1) {
				$response->state=false;
				$response->detail="Debe terminar la validación de documentación";
			}else{				
				$response->state=false;
				$response->detail="Debe terminar el proceso de acabados";
			}
		}
	}else{
		$response->state=false;
		$response->detail="No se pudo guardar el defecto";
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

?>