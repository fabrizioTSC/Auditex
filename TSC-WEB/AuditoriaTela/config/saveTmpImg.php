<?php 
	$img = $_POST['img1'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-'.$_POST['bloque'].'-tmp';
	$f_name=$tmp_name_main;
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img2'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-'.$_POST['bloque'].'-tmp-2';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img3'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-'.$_POST['bloque'].'-tmp-3';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img4'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-'.$_POST['bloque'].'-tmp-4';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img5'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-'.$_POST['bloque'].'-tmp-5';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img6'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-'.$_POST['bloque'].'-tmp-6';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img7'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codprv'].'-'.$_POST['codusu'].'-'.$_POST['codusueje'].'-'.$_POST['bloque'].'-tmp-7';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	echo $f_name;
?>