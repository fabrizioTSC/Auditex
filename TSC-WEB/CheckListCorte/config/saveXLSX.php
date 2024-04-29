<?php
$info = pathinfo($_FILES['file']['name']);
$ext = $info['extension']; // get the extension of the file

$fechahora = date('YmdHis');

$newname = $fechahora.".".$ext; 
$target = 'XLSX_tmp/'.$newname;

move_uploaded_file( $_FILES['file']['tmp_name'], $target);

require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';

if (!file_exists("XLSX_tmp/".$newname)) {
	header("Location: ../CargarMedidas.php?e=1");
}else{
	$objPHPExcel = PHPExcel_IOFactory::load($target);
	$nameCSV=str_replace($info['extension'], "csv", $newname);
	$targetCSV = 'CSV_tmp/'.$nameCSV;
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV')->setDelimiter(';')
                                                                  ->setEnclosure('')
                                                                  ->setSheetIndex(0)
                                                                  ->save($targetCSV);
    unlink($target);
	header("Location: ../CargarMedidas.php?file=".$nameCSV);
}
