<?php 
	$img = $_POST['imgBase64'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp';
	$fileName = '../assets/tmp2/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);
	
	echo $tmp_name_main;
?>