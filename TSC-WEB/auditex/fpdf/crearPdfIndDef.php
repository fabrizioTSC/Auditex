<?php
set_time_limit(240);
function format_text_month($text){
	switch ($text) {
		case '01':
			$text='Ene.';
			break;
		case '02':
			$text='Feb.';
			break;
		case '03':
			$text='Mar.';
			break;
		case '04':
			$text='Abr.';
			break;
		case '05':
			$text='May.';
			break;
		case '06':
			$text='Jun.';
			break;
		case '07':
			$text='Jul.';
			break;
		case '08':
			$text='Ago.';
			break;
		case '09':
			$text='Set.';
			break;
		case '10':
			$text='Oct.';
			break;
		case '11':
			$text='Nov.';
			break;
		case '12':
			$text='Dic.';
			break;
		default:
			# code...
			break;
	}
	return $text;
}

function getPercentValue($value){
	$value=str_replace("%","",$value);
	return (float)$value;
}

require('fpdf181/fpdf.php');
class PDF extends FPDF {
	const DPI = 96;
	const MM_IN_INCH = 25.4;
	const A4_HEIGHT = 297;
	const A4_WIDTH = 210;
	const WIDTH_MARGIN = 5;
	// tweak these values (in pixels)
	const MAX_WIDTH = 	2450;
	const MAX_WIDTH_TO_WHITE = 190;

	function resizeToFit($imgFilename) {
		list($width, $height) = getimagesize($imgFilename);
		$width=2100;
		$height=1050;
		$widthScale = self::A4_WIDTH/self::MAX_WIDTH;
		$scale = $widthScale;
		$posX=(self::A4_WIDTH-($scale * $width)-self::WIDTH_MARGIN)/2;
		return array(round($scale * $width),round($scale * $height),$posX);
	}
	function get_max_width_to_white() {
		return self::MAX_WIDTH_TO_WHITE;
	}
}
include("../config/connection.php");

$file_path_dir='../assets/tmp2/';
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("INDICADORES DE DEFECTOS DE AUDITORÍA FINAL DE COSTURA"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['n'].'.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t2']),0,0,'C');
$pdf->Ln(5);
$pdf->Image($file_path , $array[2],28,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$headers=[];
$headers[0]="DETALLE GENERAL";
$num_def=[];
$num_def[0]="# DEF.";
$pre_mue=[];
$pre_mue[0]="# PRE. MUE.";
$num_def_tot=[];
$num_def_tot[0]="# DEF. TOT.";
$por_def=[];
$por_def[0]="% DEF.";
$por_rec=[];
$l=1;

$sql="BEGIN SP_AT_INDICADOR_DEFECTOS(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
oci_bind_by_name($stmt, ':CODDEF', $_GET['cd']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=$row['ANHO'];
	$num_def[$l]=number_format($row['SUMCODDEF']);
	$pre_mue[$l]=number_format($row['SUMCANMUE']);
	$num_def_tot[$l]=number_format($row['SUMDEF']);
	$por_def[$l]=(round($row['SUMCODDEF']*10000/$row['SUMDEF'])/100)."%";
	$l++;
}

$sql="BEGIN SP_AT_INDICADOR_DEFECTOS(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
oci_bind_by_name($stmt, ':CODDEF', $_GET['cd']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=format_text_month($row['MES']);
	$num_def[$l]=number_format($row['SUMCODDEF']);
	$pre_mue[$l]=number_format($row['SUMCANMUE']);
	$num_def_tot[$l]=number_format($row['SUMDEF']);
	$por_def[$l]=(round($row['SUMCODDEF']*10000/$row['SUMDEF'])/100)."%";
	$l++;
}

$sql="BEGIN SP_AT_INDICADOR_DEFECTOS(:CODTLL,:CODSED,:CODTIPSER,:OPCION,:CODDEF,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
$opcion=2;
oci_bind_by_name($stmt, ':OPCION', $opcion);
oci_bind_by_name($stmt, ':CODDEF', $_GET['cd']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]='Sem. '.$row['SEMANA'];
	$num_def[$l]=number_format($row['SUMCODDEF']);
	$pre_mue[$l]=number_format($row['SUMCANMUE']);
	$num_def_tot[$l]=number_format($row['SUMDEF']);
	$por_def[$l]=(round($row['SUMCODDEF']*10000/$row['SUMDEF'])/100)."%";
	$l++;
}

$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=34;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/(count($headers)-1);

for ($i=0; $i < count($headers); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$headers[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$headers[$i],1,0,'L',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
for ($i=0; $i < count($num_def); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$num_def[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$num_def[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($pre_mue); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_mue[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_mue[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($num_def_tot); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$num_def_tot[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$num_def_tot[$i],1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($por_def); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$por_def[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$por_def[$i],1,0,'R');
	}
}

$pdf->Output('D','Indicar de Defectos - '.str_replace("/","-",$_GET['t']).'.pdf',true);

oci_close($conn);

//// DELETE FILES
$files = glob("../assets/tmp2/*"); 
foreach($files as $file){
    if(is_file($file) && strpos($file,$_GET['n'])){
        unlink($file);
    }
}
?>