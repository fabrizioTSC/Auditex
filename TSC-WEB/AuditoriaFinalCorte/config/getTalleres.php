<?php
	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$talleres=array();
		$i=0;
		$sql="EXEC AUDOTEX.SP_AFC_SELECT_TALLERES;";
		$stmt=sqlsrv_query($conn, $sql);
		if ($stmt) {
			while($row=sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
				$obj=new stdClass();
				$obj->CODTLL=$row['CODTLL'];
				$obj->DESTLL=utf8_encode($row['DESTLL']);
				$talleres[$i]=$obj;
				$i++;
			}
			$response->state=true;
			$response->talleres=$talleres;
			sqlsrv_free_stmt($stmt);
		} else {
			$response->state=false;
			$error->code=2;
			$error->description="Error al ejecutar la consulta.";
			$response->err=$error;
		}
	} else {
		$response->state=false;
		$error->code=1;
		$error->description="No es un método POST.";
		$response->err=$error;
	}
	sqlsrv_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response);

/*	include('connection.php');
	$response=new stdClass();
	$error=new stdClass();
	if (isset($_POST['request'])) {
		$talleres=array();
		$i=0;
		$sql="BEGIN SP_AFC_SELECT_TALLERES(:OUTPUT_CUR); END;";
		$stmt=oci_parse($conn, $sql);
		$OUTPUT_CUR=oci_new_cursor($conn);
		oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
		$result=oci_execute($stmt);
		oci_execute($OUTPUT_CUR);
		while($row=oci_fetch_assoc($OUTPUT_CUR)){
			$obj=new stdClass();
			$obj->CODTLL=$row['CODTLL'];
			$obj->DESTLL=utf8_encode($row['DESTLL']);
			$talleres[$i]=$obj;
			$i++;
		}
		$response->state=true;
		$response->talleres=$talleres;
	}else{
		$response->state=false;
		$error->code=1;
		$error->description="No es un metodo POST.";
		$response->err=$error;
	}
	oci_close($conn);
	header('Content-Type: application/json');
	echo json_encode($response); */
?>