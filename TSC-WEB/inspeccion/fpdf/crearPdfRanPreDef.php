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

function to_number($text){
	$text=str_replace(",",".",$text);
	if ($text[0]==".") {
		return "0".$text;
	}else{
		return $text;
	}
}

$file_path_dir='../assets/tmp3/';
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Ranking de Prendas Defectos por linea - turno"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['n'].'.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
$pdf->Image($file_path , $array[2],28,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=20;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/5;

$pdf->Cell($first_col_width,6,"#",1,0,'L',true);
$pdf->Cell($width_by_cell,6,"Linea",1,0,'L',true);
$pdf->Cell($width_by_cell,6,"Turno",1,0,'L',true);
$pdf->Cell($width_by_cell,6,"Pre. Def.",1,0,'L',true);
$pdf->Cell($width_by_cell,6,"Pre. Ins.",1,0,'L',true);
$pdf->Cell($width_by_cell,6,"% Def.",1,0,'L',true);
$pdf->Ln();

$pdf->SetFillColor(255);
$pdf->SetTextColor(0);

$anio="";
if(isset($_GET['anio'])){
	$anio=$_GET['anio'];
}
$mes="";
if(isset($_GET['mes'])){
	$mes=$_GET['mes'];
}
$semana="";
if(isset($_GET['semana'])){
	$semana=$_GET['semana'];
}
$fecini="";
if(isset($_GET['fecini'])){
	$fecini=$_GET['fecini'];
}
$fecfin="";
if(isset($_GET['fecfin'])){
	$fecfin=$_GET['fecfin'];
}

if ($_GET['option']=="3") {
	$ar_fecini=explode("-", $_GET['fecini']);
	$ar_fecfin=explode("-", $_GET['fecfin']);

	$fecini=$ar_fecini[0].$ar_fecini[1].$ar_fecini[2];
	$fecfin=$ar_fecfin[0].$ar_fecfin[1].$ar_fecfin[2];
}

$i=1;
$sql="BEGIN SP_INSP_REP_RANKINGLTDEFAUX(:OPCION,:ANIO,:MES,:SEMANA,:FECINI,:FECFIN,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':OPCION', $_GET['option']);
oci_bind_by_name($stmt, ':ANIO', $anio);
oci_bind_by_name($stmt, ':MES', $mes);
oci_bind_by_name($stmt, ':SEMANA', $semana);
oci_bind_by_name($stmt, ':FECINI', $fecini);
oci_bind_by_name($stmt, ':FECFIN', $fecfin);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$pdf->Cell($first_col_width,6,$i,1,0,'L',true);
	$pdf->Cell($width_by_cell,6,$row['LINEA'],1,0,'L',true);
	$pdf->Cell($width_by_cell,6,$row['TURNO'],1,0,'L',true);
	$pdf->Cell($width_by_cell,6,number_format($row['PRE_DEF']),1,0,'R',true);
	$pdf->Cell($width_by_cell,6,number_format($row['PRE_INS']),1,0,'R',true);
	$pdf->Cell($width_by_cell,6,(round(floatval(to_number($row['POR_DEF']))*10000)/100)."%",1,0,'R',true);
	$pdf->Ln();
	$i++;
}


$pdf->Output('D','Ranking de Prendas Defectos por linea - turno ('.$_GET['t'].').pdf',true);
//$pdf->Output('','',true);

oci_close($conn);

//// DELETE FILES
$files = glob("../assets/tmp3/*"); 
foreach($files as $file){
    if(is_file($file) && strpos($file,$_GET['n'])){
        unlink($file);
    }
}
?>