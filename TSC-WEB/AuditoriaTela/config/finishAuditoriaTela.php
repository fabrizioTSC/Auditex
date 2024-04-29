<?php
	include('connection.php');
	$response=new stdClass();

	$sql="BEGIN SP_AUDTEL_VALUSU(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CODUSU, :PERUSU,:VAL); END;";
	$stmt=oci_parse($conn, $sql);
	oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
	oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
	oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
	oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
	oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
	oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
	oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
	oci_bind_by_name($stmt, ':PERUSU', $_POST['perusu']);
	oci_bind_by_name($stmt, ':VAL', $validar,40);
	$result=oci_execute($stmt);
	if ($validar>0) {
		if ($_POST['perusu']=="2") {
			$obs="";
			if (isset($_POST['obs'])) {
				$obs=utf8_decode($_POST['obs']);
			}
			$sql="BEGIN SP_AUDTEL_END_AUDITORIA2SUP(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CODUSU,:RESULTADO,:CODRES,:OBS,:TRYEND); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
			oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
			oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
			oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
			oci_bind_by_name($stmt, ':CODRES', $_POST['codres']);
			oci_bind_by_name($stmt, ':OBS', $obs);
			oci_bind_by_name($stmt, ':TRYEND', $tryend,40);
			$result=oci_execute($stmt);
			if($result){
				$response->state=true;
				$response->tryend=$tryend;
			}else{
				$response->state=false;
				$response->detail="No se puede guardar la información!";
			}
		}else{
			$sql="BEGIN SP_AUDTEL_END_AUDITORIA(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CODUSU,:CONTADOR,:RESULTADO); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
			oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
			oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
			oci_bind_by_name($stmt, ':CONTADOR', $contador,40);
			oci_bind_by_name($stmt, ':RESULTADO', $res,40);
			$result=oci_execute($stmt);
			if($contador!=0){
				$response->state=false;
				$response->detail="Complete la información de todos los rollos!";
			}else{
				$response->state=true;	
				$response->res=$res;
				$response->contador=$contador;			

				$sql="BEGIN SP_AUDTEL_SELECT_RESULTADOS(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :PESO, :PESOAUD, :PESOAPRO, :PESOCAI, :CALIFICACION, :TIPO, :RESULTADO); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
				oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
				oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
				oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
				oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
				oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
				oci_bind_by_name($stmt, ':PESO', $peso,40);
				oci_bind_by_name($stmt, ':PESOAUD', $pesoaud,40);
				oci_bind_by_name($stmt, ':PESOAPRO', $pesoapro,40);
				oci_bind_by_name($stmt, ':PESOCAI', $pesocai,40);
				oci_bind_by_name($stmt, ':CALIFICACION', $calificacion,40);
				oci_bind_by_name($stmt, ':TIPO', $tipo,40);
				oci_bind_by_name($stmt, ':RESULTADO', $resultado,40);
				$result=oci_execute($stmt);
				$response->peso=str_replace(",", ".", $peso);
				$response->pesoaud=str_replace(",", ".", $pesoaud);
				$response->pesoapro=str_replace(",", ".", $pesoapro);
				$response->pesocai=str_replace(",", ".", $pesocai);
				$response->calificacion=$calificacion;
				$response->tipo=$tipo;
				$response->resultado=$resultado;

				//if ($res=='A') {
					$sql="BEGIN SP_AUDTEL_VAL_ENDAUDV2(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CONTADOR); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
					oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
					oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
					oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
					oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
					oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
					oci_bind_by_name($stmt, ':CONTADOR', $cont,40);
					$result=oci_execute($stmt);
					if ($cont>0) {
						$response->tryend=true;
					}else{
						$response->tryend=false;
					}
				/*}else{
					$response->tryend=false;
				}*/
			}
		}		
	}else{
		$response->state=false;
		if ($_POST['perusu']!=2) {
			$response->detail="La partida fue tomada por otro auditor!";
		}else{
			$response->detail="La partida fue tomada por otro supervisor!";
		}
	}

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>