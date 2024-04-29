<?php 
	$img = $_POST['imgBase64'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name_main=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp';
	$fileName = '../assets/tmp/'.$tmp_name_main.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img2'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp-2';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img3'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp-3';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img4'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp-4';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img5'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp-5';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img6'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp-6';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img7'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp-7';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	/*$img = $_POST['img8'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['codusu'].'-'.$_POST['codtll'].'-'.$_POST['codtipser'].'-'.$_POST['codsede'].'-tmp-8';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);*/
	echo $tmp_name_main;
?>