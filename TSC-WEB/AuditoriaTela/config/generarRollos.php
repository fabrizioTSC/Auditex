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
		$sql="BEGIN SP_AUDTEL_UPDATE_PARAUDROLAUX(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :TIPO, :NUMROL, :CODAQL,:CODUSU,:CANAUD); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
		oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
		oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
		oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
		oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
		oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
		oci_bind_by_name($stmt, ':TIPO', $_POST['tipo']);
		oci_bind_by_name($stmt, ':NUMROL', $_POST['numrol']);
		oci_bind_by_name($stmt, ':CODAQL', $_POST['codaql']);
		oci_bind_by_name($stmt, ':CODUSU', $_POST['codusu']);
		oci_bind_by_name($stmt, ':CANAUD', $canaud,40);
		$result=oci_execute($stmt);
		
		if ($result) {
			$response->state=true;
			$response->canaud=$canaud;
			$numeros=array();
			if($_POST['rolaut']=="1"){
				//todos
				if ($_POST['tipo']=="2") {
					for ($i=0; $i < $_POST['numrol']; $i++) { 
						$numeros[$i]=$i+1;
					}	
				}else{
					$validador=false;
					while($validador==false){
						$aux_num=random_int(1,$_POST['numrol']);
						$ex_num=false;
						for ($i=0; $i < count($numeros); $i++) { 
							if($numeros[$i]==$aux_num){
								$ex_num=true;
							}
						}
						if (!$ex_num) {
							$numeros[count($numeros)]=$aux_num;
						}
						if (count($numeros)==$canaud) {
							$validador=true;
						}			
					}
				}
				for ($i=0; $i < count($numeros); $i++) { 
					$sql="BEGIN SP_AUDTEL_INSERT_PARROL(:PARTIDA, :CODTEL, :CODPRV, :CODTAD, :NUMVEZ, :PARTE, :NUMROL); END;";
					$stmt=oci_parse($conn, $sql);
					oci_bind_by_name($stmt, ':PARTIDA', $_POST['partida']);
					oci_bind_by_name($stmt, ':CODTEL', $_POST['codtel']);
					oci_bind_by_name($stmt, ':CODPRV', $_POST['codprv']);
					oci_bind_by_name($stmt, ':CODTAD', $_POST['codtad']);
					oci_bind_by_name($stmt, ':NUMVEZ', $_POST['numvez']);
					oci_bind_by_name($stmt, ':PARTE', $_POST['parte']);
					oci_bind_by_name($stmt, ':NUMROL', $numeros[$i]);
					$result=oci_execute($stmt);
				}
			}
			$response->numeros=$numeros;
		}else{
			$response->state=false;
			$response->detail="No se pudo guardar el número de rollos!";
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