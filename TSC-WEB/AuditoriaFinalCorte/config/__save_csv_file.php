<?php
	include('connection.php');
	session_start();
	$response=new stdClass();

	if ($_FILES['file']) {
        $tmp_name = $_FILES["file"]["tmp_name"];
        $name = basename($_FILES["file"]["name"]);

		$sql="BEGIN SP_AFC_INSERT_LOGCARCSV(:ESTTSC,:HILO,:TRAVEZ,:LARGMANGA,:CODUSU,:CARGADO,:NOMARC,:FECHA); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':ESTTSC', $_POST['esttsc']);
		oci_bind_by_name($stmt, ':HILO', $_POST['hilo']);
		oci_bind_by_name($stmt, ':TRAVEZ', $_POST['travez']);
		oci_bind_by_name($stmt, ':LARGMANGA', $_POST['largmanga']);
		oci_bind_by_name($stmt, ':CODUSU', $_SESSION['user']);
		oci_bind_by_name($stmt, ':CARGADO', $_POST['cargado']);
		oci_bind_by_name($stmt, ':NOMARC', $name);
		oci_bind_by_name($stmt, ':FECHA', $fecha,40);
		$result=oci_execute($stmt);

		if (!file_exists('../../carga-csv-afc')) {
		    mkdir('../../carga-csv-afc', 0777, true);
		}
		if (move_uploaded_file($tmp_name,"../../carga-csv-afc/".
			$_POST['esttsc']."-".
			$_POST['hilo']."-".
			$_POST['travez']."-".
			$_POST['largmanga']."-".$fecha.".csv")) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="Archivo CSV no se guardo";
		}
	}else{
		$response->state=false;
		$response->detail="No existe el CSV";
	}

	header('Content-Type: application/json');
	echo json_encode($response);