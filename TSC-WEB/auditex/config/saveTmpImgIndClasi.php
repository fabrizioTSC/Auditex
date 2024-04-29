<?php 
	$img = $_POST['img1'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-1';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img2'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-2';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img3'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-3';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img4'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-4';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img5'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-5';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img6'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-6';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img7'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-7';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img8'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-8';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	// AGREGADO

	$img = $_POST['img9'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-9';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img10'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-10';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img11'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-11';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img12'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-12';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img13'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-13';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);

	$img = $_POST['img14'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$fileData = base64_decode($img);
	$tmp_name=$_POST['name'].'-14';
	$fileName = '../assets/tmp/'.$tmp_name.'.png';
	file_put_contents($fileName, $fileData);


	
	echo true;
?>