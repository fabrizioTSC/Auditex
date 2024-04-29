<?php
	include('connection.php');
	$response=new stdClass();

	if ($_POST['numcajaud']!="0") {
		$sql="BEGIN SP_AF_SELECT_AUDCAJA(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:ESTADO,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['color']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		$estado='P';
		oci_bind_by_name($stmt,':ESTADO',$estado);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt,':OUTPUT_CUR',$OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_assoc($OUTPUT_CUR);
		if (oci_num_rows($OUTPUT_CUR)==0) {
			$sql="BEGIN SP_AF_UPDATE_ENDVERCAJ(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:OBS); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
			oci_bind_by_name($stmt,':COLOR',$_POST['color']);
			oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
			oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
			oci_bind_by_name($stmt,':OBS',$_POST['obs']);
			$result=oci_execute($stmt);
			if($result){
				$response->state=true;
			}else{
				$response->detail="No se pudo terminar el verificado";
				$response->state=false;
			}
		}else{
			$response->detail="Debe auditar todas las cajas";
			$response->state=false;
		}
	}else{
		$response->detail="Debe agregar cajas a auditar primero";
		$response->state=false;
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>