<?php 
	$name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-tmp';

	$img = $_POST['img1'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-tmp-1';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img2'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-tmp-2';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img3'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-tmp-3';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img4'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-tmp-4';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	echo $name_main;
?>