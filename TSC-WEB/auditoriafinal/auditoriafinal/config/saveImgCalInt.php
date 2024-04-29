<?php
	set_time_limit(0);
	ini_set('upload_max_filesize', '500M');
	ini_set('post_max_size', '500M');
	ini_set('max_input_time', 4000);
	ini_set('max_execution_time', 4000);
	include('connection.php');
	$response="";

	$_FILES['file']['tmp_name'];
	session_start();
	$nombre = date("YmdHis").$_SESSION['user'].".jpg";
	if (move_uploaded_file($_FILES['file']['tmp_name'], "../assets/imgcalint/".$nombre)) {
		$sql="BEGIN SP_AF_INSERT_IMACALINT(:PEDIDO,:COLOR,:PARTE,:NUMVEZ,:RUTIMA,:OBS); END;";
		$stmt=oci_parse($conn, $sql);
		oci_bind_by_name($stmt,':PEDIDO',$_POST['pedido']);
		oci_bind_by_name($stmt,':COLOR',$_POST['dsccol']);
		oci_bind_by_name($stmt,':PARTE',$_POST['parte']);
		oci_bind_by_name($stmt,':NUMVEZ',$_POST['numvez']);
		oci_bind_by_name($stmt,':RUTIMA',$nombre);
		$obs=utf8_decode($_POST['obs']);
		oci_bind_by_name($stmt,':OBS',$obs);
		$result=oci_execute($stmt);
		$response="1";
	}else{
		$response="2";
	}

	oci_close($conn);
	echo $response;
?>