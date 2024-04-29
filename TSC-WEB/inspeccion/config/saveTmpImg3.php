<?php 
	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$hoy=date("Ymd-His", time());
	$tmp_name_main=$hoy.'-tmp';
	$fileName = '../assets/tmp3/'.$tmp_name_main.'.png';	
	file_put_contents($fileName, $fileData);

	echo $tmp_name_main;
?>