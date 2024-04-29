<?php
	include('connection.php');
	$response=new stdClass();

	function convert_float($text){
		$text=str_replace(".",",",$text);
		//return floatval($text);
		return $text;
	}
	
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
		$cont=0;
		if (isset($_POST['array'])) {
			$array=$_POST['array'];
			for ($i=0; $i < count($array); $i++) {
				$sql="BEGIN SP_AUDTEL_INSERT_PARAUDED(:PARTIDA, :CODTEL, :CODPRV,:CODTAD, :NUMVEZ, :PARTE, :CODESTDIM, :VALORTSC, :RESTSC,:CODREC1,:CAIDA,:PERUSU); END;";
				$stmt=oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
				oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
				oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
				oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
				oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
				oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
				oci_bind_by_name($stmt, ':CODESTDIM', $array[$i][0]);
				oci_bind_by_name($stmt, ':RESTSC', $array[$i][1]);

//				$valor_format=convert_float($array[$i][2]);
				$valor_format = floatval($array[$i][2]);

				//$valor_format=$array[$i][2];
				oci_bind_by_name($stmt, ':VALORTSC', $valor_format);
				oci_bind_by_name($stmt, ':CODREC1', $array[$i][3]);
				$valor_format2=0;//convert_float($array[$i][4]);
				//$valor_format2=$array[$i][4];
				oci_bind_by_name($stmt, ':CAIDA', $valor_format2);
				oci_bind_by_name($stmt, ':PERUSU', $_POST['perusu']);
				$result=oci_execute($stmt);
				if (!$result) {
					$cont++;
				}
			}
		}
		if ($cont==0) {
			$obs="";
			if (isset($_POST['obs'])) {
				$obs=$_POST['obs'];
			}
			$sql="BEGIN SP_AUDTEL_UPDATE_PARAUD3(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :RESULTADO,:CODUSU,:PERUSU,:OBS,:CODRES); END;";
			$stmt=oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
			oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
			oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
			oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
			oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
			oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
			oci_bind_by_name($stmt, ':RESULTADO', $_POST['resultado']);
			oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
			oci_bind_by_name($stmt, ':PERUSU', $_POST['perusu']);
			oci_bind_by_name($stmt, ':OBS', $obs);
			oci_bind_by_name($stmt, ':CODRES', $_POST['codres']);
			$result=oci_execute($stmt);
			
			$response->state=true;
			$response->detail="Auditoría guardada!";			
			
			if ($_POST['resultado']=='A' and $_POST['perusu']!=2) {
				$sql="BEGIN SP_AUDTEL_VAL_ENDAUD(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CONTADOR); END;";
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
			}else{
				if ($_POST['perusu']==2 and $_POST['resultado']=='R') {
					$response->tryend=true;
				}else{
					$sql="BEGIN SP_AUDTEL_VAL_ENDAUD(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :CONTADOR); END;";
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
				}
			}
		}else{
			$response->state=false;
			$response->detail="No se pudo guardar la información!";
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