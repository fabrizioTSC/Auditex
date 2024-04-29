<?php 
	$img = $_POST['img1'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['codusu'].'-'.$_POST['codtll'].'-tmp';
	$fileName = '../assets/tmp/'.$tmp_name.'-1.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img2'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-2.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img3'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-3.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img4'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-4.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img5'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-5.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img6'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-6.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img7'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-7.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img8'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-8.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img9'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-9.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img10'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$fileName = '../assets/tmp/'.$tmp_name.'-10.png';
	file_put_contents($fileName, $fileData);
	echo $tmp_name;
?>