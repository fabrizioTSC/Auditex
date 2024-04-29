<?php
	include('connection.php');
	$response=new stdClass();

	// EJECUTAMOS CARGA DEL SIGE
	require_once '../../../tsc/models/modelo/core.modelo.php';

	$objModelo = new CoreModelo();

	$partida = $_POST['partida'];
	$responsecargasige = $objModelo->setAllSQLSIGE("uspSetGeneraDataAuditex",[9,null,null,null,null,$partida],"Correcto");


	$partidasauditoria=array();
	$i=0;
	$sql="BEGIN SP_AUDTEL_SELECT_PARTIDAS(:PARTIDA,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	$OUTPUT_CUR=oci_new_cursor($conn);
	oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
	$result=oci_execute($stmt);
	oci_execute($OUTPUT_CUR);
	while($row=oci_fetch_array($OUTPUT_CUR)){
		$obj=new stdClass();
		$obj->CODPRV=$row['CODPRV']; 
		$obj->DESPRV=utf8_encode($row['DESCLI']);
		$obj->NUMVEZ=$row['NUMVEZ'];
		$obj->PARTE=$row['PARTE'];
		$obj->CODTEL=$row['CODTEL'];
		$obj->CODTAD=$row['CODTAD'];
		$obj->RESULTADO=$row['RESULTADO'];
		$partidasauditoria[$i]=$obj;
		$i++;
	}
	$contador_exists=oci_num_rows($OUTPUT_CUR);

	if ($contador_exists>0) {
		if ($contador_exists==1) {
			$response->state=true;
			$response->state_confirm=false;
			$response->state_lista=false;
		}else{
			$response->state=true;
			$response->state_lista=true;
			$response->partidasauditoria=$partidasauditoria;
		}
	}else{
		/*
		$sql="BEGIN SP_AUDTEL_VALPARTER(:PARTIDA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_array($OUTPUT_CUR);
		$response->cont=$row['CONTADOR'];
		if ($row['CONTADOR']>0) {

		}else{
			$response->state=false;
			$response->state_confirm=false;
			$response->detail="La partida no existe!";
		}
			}else{
				$sql="BEGIN SP_AUDTEL_VALPAR2(:PARTIDA,:OUTPUT_CUR); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
				$OUTPUT_CUR=oci_new_cursor($conn);
				oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
				$result=oci_execute($stmt);
				oci_execute($OUTPUT_CUR);
				$row=oci_fetch_array($OUTPUT_CUR);
				if ($row['CONTADOR2']>0) {
					$response->detail="La partida está a espera de supervisión!";
					$response->state_confirm=false;
				}else{
					$response->detail="No hay auditorías pendientes para la partida ".$_POST['partida']."! Desea crear otro intento de auditoría?";
					$response->state_confirm=true;
				}
				$response->state=false;
				$response->cont2=$row['CONTADOR2'];
			}*/			
		$response->state=false;
		$response->state_lista=false;
		$sql="BEGIN SP_AUDTEL_SELECT_PARAUDCONFIR(:PARTIDA,:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		$row=oci_fetch_array($OUTPUT_CUR);
		$numrows=oci_num_rows($OUTPUT_CUR);
		if ($numrows==0) {
			$response->state_confirm=false;
		}else{
			$response->state_confirm=true;
		}
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>