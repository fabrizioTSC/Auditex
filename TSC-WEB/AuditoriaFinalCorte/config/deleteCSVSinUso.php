<?php
	$response=new stdClass();
	unlink("CSV_tmp/".$_POST['filename']);
	$response->state=true;
	
	header('Content-Type: application/json');
	echo json_encode($response);