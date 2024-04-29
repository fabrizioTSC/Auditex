<?php
	include('connection.php');
	$response=new stdClass();

	$codcel=$_POST['codcel'];
	if ($_POST['codtipser']=="3") {
		$codcel=$_POST['codtll'];
	}
	$sql="begin SP_AA_INSERT_AUDACABADOS(:CODFIC,:CANTIDAD,:CODTLL,:CODCEL,:CODUSU); END;";
	$stmt=oci_parse($conn,$sql);
	oci_bind_by_name($stmt,':CODFIC', $_POST['codfic']);
	oci_bind_by_name($stmt,':CANTIDAD', $_POST['cantidad']);
	oci_bind_by_name($stmt,':CODTLL', $_POST['codtll']);
	oci_bind_by_name($stmt,':CODCEL', $codcel);
	session_start();
	oci_bind_by_name($stmt,':CODUSU', $_SESSION['user']);
	$result=oci_execute($stmt);
	if ($result) {
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
		$response->state=false;
		$response->detail="No se pudo guardar la parte";
	}
	

	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);
?>