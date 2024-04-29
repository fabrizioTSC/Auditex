<?php

	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();

		$sql="";
		if ($_POST['option']=="delete") {
			$sql="BEGIN SP_APCR_DELETE_DETDEF(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODDEF,:CODOPE); END;";
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt, ':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt, ':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt, ':CODDEF',$_POST['coddef']);
			oci_bind_by_name($stmt, ':CODOPE',$_POST['codope']);
			$result=oci_execute($stmt);
		}else{
			$sql="BEGIN SP_APCR_UPDATE_DETDEF2(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODOPE,:CODDEF,:NEWCODDEF,:CANDEF,:ESTADO); END;";
			$stmt=oci_parse($conn,$sql);
			oci_bind_by_name($stmt, ':CODFIC',$_POST['codfic']);
			oci_bind_by_name($stmt, ':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt, ':CODTAD',$_POST['codtad']);
			oci_bind_by_name($stmt, ':CODOPE',$_POST['codope']);
			oci_bind_by_name($stmt, ':CODDEF',$_POST['coddef']);
			oci_bind_by_name($stmt, ':NEWCODDEF',$_POST['newcoddef']);
			oci_bind_by_name($stmt, ':CANDEF',$_POST['candef']);
			oci_bind_by_name($stmt, ':ESTADO',$estado);

			$result=oci_execute($stmt);
		}
		if($result){
			$sql="BEGIN SP_APCR_CORRECT_FICHA(:CODFIC,:NUMVEZ,:PARTE,:CODTAD,:CODAQL); END;";
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