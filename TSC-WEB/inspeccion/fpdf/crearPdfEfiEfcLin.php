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
	return floatval($value);
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

$file_path_dir='../assets/tmp3/';
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("INDICADORES DE EFICIENCIA Y EFICACIA DE LINEAS"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['n'].'.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
$pdf->Image($file_path , $array[2],28,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$headers=[];
$headers[0]="DETALLE GENERAL";
$min_efi=[];
$min_efi[0]="MIN. EFICIENCIA";
$min_efc=[];
$min_efc[0]="MIN. EFICACIA";
$min_asi=[];
$min_asi[0]="MIN. ASI.";
$efi=[];
$efi[0]="EFICACIA";
$efc=[];
$efc[0]="EFICACIA";
$l=1;

$ar_fecha=explode("-", $_GET['fecha']);
$fecha=$ar_fecha[2].$ar_fecha[1].$ar_fecha[0];

$sql="BEGIN SP_MONI_INDICADOR_RESULTADOS(:LINEA,:TURNO,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':LINEA', $_GET['linea']);
oci_bind_by_name($stmt, ':TURNO', $_GET['turno']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=$row['ANHO'];
	$min_efi[$l]=str_replace(",",".",$row['MINEFICIENCIA']);
	$min_efc[$l]=str_replace(",",".",$row['MINEFICACIA']);
	$min_asi[$l]=str_replace(",",".",$row['MINASIGNADOS']);
	$efi[$l]=round((floatval($row['MINEFICIENCIA'])/floatval($row['MINASIGNADOS']))*10000)/100;
	$efc[$l]=round((floatval($row['MINEFICACIA'])/floatval($row['MINASIGNADOS']))*10000)/100;
	$l++;
}

$sql="BEGIN SP_MONI_INDICADOR_RESULTADOS(:LINEA,:TURNO,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':LINEA', $_GET['linea']);
oci_bind_by_name($stmt, ':TURNO', $_GET['turno']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {	
	$headers[$l]=format_text_month($row['MES']);
	$min_efi[$l]=str_replace(",",".",$row['MINEFICIENCIA']);
	$min_efc[$l]=str_replace(",",".",$row['MINEFICACIA']);
	$min_asi[$l]=str_replace(",",".",$row['MINASIGNADOS']);
	$efi[$l]=round((floatval($row['MINEFICIENCIA'])/floatval($row['MINASIGNADOS']))*10000)/100;
	$efc[$l]=round((floatval($row['MINEFICACIA'])/floatval($row['MINASIGNADOS']))*10000)/100;
	$l++;
}

$sql="BEGIN SP_MONI_INDICADOR_RESULTADOS(:LINEA,:TURNO,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':LINEA', $_GET['linea']);
oci_bind_by_name($stmt, ':TURNO', $_GET['turno']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=2;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]="Sem. ".$row['NUMERO_SEMANA'];
	$min_efi[$l]=str_replace(",",".",$row['MINEFICIENCIA']);
	$min_efc[$l]=str_replace(",",".",$row['MINEFICACIA']);
	$min_asi[$l]=str_replace(",",".",$row['MINASIGNADOS']);
	$efi[$l]=round((floatval($row['MINEFICIENCIA'])/floatval($row['MINASIGNADOS']))*10000)/100;
	$efc[$l]=round((floatval($row['MINEFICACIA'])/floatval($row['MINASIGNADOS']))*10000)/100;
	$l++;
}

$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=27;
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
for ($i=0; $i < count($min_efi); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$min_efi[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,number_format($min_efi[$i]),1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($min_efc); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$min_efc[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,number_format($min_efc[$i]),1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($min_asi); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$min_asi[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,number_format($min_asi[$i]),1,0,'R');
	}
}
$pdf->Ln();
for ($i=0; $i < count($efi); $i++) { 
	if ($i==0) {
		$pdf->SetFillColor(200);
		$pdf->Cell($first_col_width,6,$efi[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($efi[$i]);
		if ($porcen<number_format($_GET['ran2'])) {
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=number_format($_GET['ran1'])){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$efi[$i]."%",1,0,'R',true);
	}
}
$pdf->Ln();
for ($i=0; $i < count($efc); $i++) { 
	if ($i==0) {
		$pdf->SetFillColor(200);
		$pdf->Cell($first_col_width,6,$efc[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($efc[$i]);
		if ($porcen<number_format($_GET['ran2'])) {			
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=number_format($_GET['ran1'])){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$efc[$i]."%",1,0,'R',true);
	}
}


$pdf->Output('D','INDICADORES DE EFICIENCIA Y EFICACIA DE LINEAS - '.$_GET['t'].'.pdf',true);
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