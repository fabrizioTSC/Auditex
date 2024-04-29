<?php
set_time_limit(120);
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
		//return array(round($this->pixelsToMM($scale * $width)),round($this->pixelsToMM($scale * $height)));
	}
	function get_max_width_to_white() {
		return self::MAX_WIDTH_TO_WHITE;
	}
}

$ar_fecha=explode("-", $_GET['fecha']);
$fecha=$ar_fecha[2].$ar_fecha[1].$ar_fecha[0];

include("../config/connection.php");

/*
$sql="select * from taller";
$stmt=oci_parse($conn, $sql);
$result=oci_execute($stmt);

$pdf->Ln();

$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(128,0,0);
$pdf->SetLineWidth(.3);
$pdf->Cell(50,6,"COD. TALLER",1,0,'C');
$pdf->Cell(110,6,"NOMBRE",1,0,'C');
$pdf->Ln();

$i=0;
while($row=oci_fetch_array($stmt) and $i<10){
    $pdf->Cell(50,6,$row[0],'LR');
    $pdf->Cell(110,6,$row[1],'LR');
    $pdf->Ln();
	$i++;
}
$pdf->Cell(160,0,'','T');
*/

$headers=[];
$headers[0]="DETALLE GENERAL";
$aud_apr=[];
$aud_apr[0]="# AUD. APRO.";
$aud_rec=[];
$aud_rec[0]="# AUD. RECH.";
$aud_tot=[];
$aud_tot[0]="# AUDITORIAS";
$por_apr=[];
$por_apr[0]="% APRO.";
$por_rec=[];
$por_rec[0]="% RECH.";
$pre_apr=[];
$pre_apr[0]="PRENDAS APRO.";
$pre_rec=[];
$pre_rec[0]="PRENDAS RECH.";
$pre_tot=[];
$pre_tot[0]="TOTAL PRENDAS";
$por_pre_apr=[];
$por_pre_apr[0]="% APRO.";
$por_pre_rec=[];
$por_pre_rec[0]="% RECH.";

$headersps=[];
$headersps[0]="DETALLE GENERAL";
$aud_prips=[];
$aud_prips[0]="# AUD. APR. 1RA";
$aud_segps=[];
$aud_segps[0]=utf8_decode("# AUD. APR. 2DA Ó MÁS");
$aud_totps=[];
$aud_totps[0]="# AUDITORIAS APR.";
$por_prips=[];
$por_prips[0]="% APR. 1RA";
$por_segps=[];
$por_segps[0]=utf8_decode("% APR. 2DA Ó MÁS");
$pre_prips=[];
$pre_prips[0]="PRE. APR. 1RA";
$pre_segps=[];
$pre_segps[0]=utf8_decode("PRE. APR. 2DA Ó MÁS");
$pre_totps=[];
$pre_totps[0]="TOTAL PRENDAS APR.";
$por_pre_prips=[];
$por_pre_prips[0]="% APR. 1RA";
$por_pre_segps=[];
$por_pre_segps[0]=utf8_decode("% APR. 2DA Ó MÁS");
$por_totps=[];
$por_totps[0]="% TOTAL";
$l=1;

$sql="BEGIN SP_APCR_INDRES(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=$row['ANHO'];
	$aud_apr[$l]=number_format($row['AUD_APR']);
	$aud_rec[$l]=number_format($row['AUD_REC']);
	$aud_tot[$l]=number_format($row['AUD_TOT']);
	$por_apr[$l]=(round($row['AUD_APR']*10000/$row['AUD_TOT'])/100)."%";
	$por_rec[$l]=(round($row['AUD_REC']*10000/$row['AUD_TOT'])/100)."%";
	$pre_apr[$l]=number_format($row['PREN_APR']);
	$pre_rec[$l]=number_format($row['PREN_REC']);
	$pre_tot[$l]=number_format($row['PREN_TOT']);
	$por_pre_apr[$l]=(round($row['PREN_APR']*10000/$row['PREN_TOT'])/100)."%";
	$por_pre_rec[$l]=(round($row['PREN_REC']*10000/$row['PREN_TOT'])/100)."%";

	$headersps[$l]=$row['ANHO'];
	$aud_prips[$l]=number_format($row['AUD_APR1']);
	$aud_segps[$l]=number_format($row['AUD_APR2']);
	$aud_totps[$l]=number_format($row['AUD_APR']);
	if ($row['AUD_APR']==0) {
		$por_prips[$l]="0%";
		$por_segps[$l]="0%";
	}else{
		$por_prips[$l]=(round($row['AUD_APR1']*10000/$row['AUD_APR'])/100)."%";
		$por_segps[$l]=(round($row['AUD_APR2']*10000/$row['AUD_APR'])/100)."%";
	}
	$pre_prips[$l]=number_format($row['PREN_APR1']);
	$pre_segps[$l]=number_format($row['PREN_APR2']);
	$pre_totps[$l]=number_format($row['PREN_APR']);
	if ($row['PREN_APR']==0) {
		$por_pre_prips[$l]="0%";
		$por_pre_segps[$l]="0%";
	}else{
		$por_pre_prips[$l]=(round($row['PREN_APR1']*10000/$row['PREN_APR'])/100)."%";
		$por_pre_segps[$l]=(round($row['PREN_APR2']*10000/$row['PREN_APR'])/100)."%";
	}
	$por_totps[$l]="100%";
	$l++;
}

$sql="BEGIN SP_APCR_INDRES(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]=format_text_month($row['MES']);
	$aud_apr[$l]=number_format($row['AUD_APR']);
	$aud_rec[$l]=number_format($row['AUD_REC']);
	$aud_tot[$l]=number_format($row['AUD_TOT']);
	$por_apr[$l]=(round($row['AUD_APR']*10000/$row['AUD_TOT'])/100)."%";
	$por_rec[$l]=(round($row['AUD_REC']*10000/$row['AUD_TOT'])/100)."%";
	$pre_apr[$l]=number_format($row['PREN_APR']);
	$pre_rec[$l]=number_format($row['PREN_REC']);
	$pre_tot[$l]=number_format($row['PREN_TOT']);
	$por_pre_apr[$l]=(round($row['PREN_APR']*10000/$row['PREN_TOT'])/100)."%";
	$por_pre_rec[$l]=(round($row['PREN_REC']*10000/$row['PREN_TOT'])/100)."%";

	$headersps[$l]=format_text_month($row['MES']);
	$aud_prips[$l]=number_format($row['AUD_APR1']);
	$aud_segps[$l]=number_format($row['AUD_APR2']);
	$aud_totps[$l]=number_format($row['AUD_APR']);
	if ($row['AUD_APR']==0) {
		$por_prips[$l]="0%";
		$por_segps[$l]="0%";
	}else{
		$por_prips[$l]=(round($row['AUD_APR1']*10000/$row['AUD_APR'])/100)."%";
		$por_segps[$l]=(round($row['AUD_APR2']*10000/$row['AUD_APR'])/100)."%";
	}
	$pre_prips[$l]=number_format($row['PREN_APR1']);
	$pre_segps[$l]=number_format($row['PREN_APR2']);
	$pre_totps[$l]=number_format($row['PREN_APR']);
	if ($row['PREN_APR']==0) {
		$por_pre_prips[$l]="0%";
		$por_pre_segps[$l]="0%";
	}else{
		$por_pre_prips[$l]=(round($row['PREN_APR1']*10000/$row['PREN_APR'])/100)."%";
		$por_pre_segps[$l]=(round($row['PREN_APR2']*10000/$row['PREN_APR'])/100)."%";
	}
	$por_totps[$l]="100%";
	$l++;
}

$sql="BEGIN SP_APCR_INDRES(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=2;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$headers[$l]='Sem. '.$row['NUMERO_SEMANA'];
	$aud_apr[$l]=number_format($row['AUD_APR']);
	$aud_rec[$l]=number_format($row['AUD_REC']);
	$aud_tot[$l]=number_format($row['AUD_TOT']);
	$por_apr[$l]=(round($row['AUD_APR']*10000/$row['AUD_TOT'])/100)."%";
	$por_rec[$l]=(round($row['AUD_REC']*10000/$row['AUD_TOT'])/100)."%";
	$pre_apr[$l]=number_format($row['PREN_APR']);
	$pre_rec[$l]=number_format($row['PREN_REC']);
	$pre_tot[$l]=number_format($row['PREN_TOT']);
	$por_pre_apr[$l]=(round($row['PREN_APR']*10000/$row['PREN_TOT'])/100)."%";
	$por_pre_rec[$l]=(round($row['PREN_REC']*10000/$row['PREN_TOT'])/100)."%";

	$headersps[$l]='Sem. '.$row['NUMERO_SEMANA'];
	$aud_prips[$l]=number_format($row['AUD_APR1']);
	$aud_segps[$l]=number_format($row['AUD_APR2']);
	$aud_totps[$l]=number_format($row['AUD_APR']);
	if ($row['AUD_APR']==0) {
		$por_prips[$l]="0%";
		$por_segps[$l]="0%";
	}else{
		$por_prips[$l]=(round($row['AUD_APR1']*10000/$row['AUD_APR'])/100)."%";
		$por_segps[$l]=(round($row['AUD_APR2']*10000/$row['AUD_APR'])/100)."%";
	}
	$pre_prips[$l]=number_format($row['PREN_APR1']);
	$pre_segps[$l]=number_format($row['PREN_APR2']);
	$pre_totps[$l]=number_format($row['PREN_APR']);
	if ($row['PREN_APR']==0) {
		$por_pre_prips[$l]="0%";
		$por_pre_segps[$l]="0%";
	}else{
		$por_pre_prips[$l]=(round($row['PREN_APR1']*10000/$row['PREN_APR'])/100)."%";
		$por_pre_segps[$l]=(round($row['PREN_APR2']*10000/$row['PREN_APR'])/100)."%";
	}
	$por_totps[$l]="100%";
	$l++;
}

$file_path_dir='../assets/tmp/';
$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'-8.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("Auditorías aprobadas a la primera - segunda o más"),0,0,'C');
$pdf->Ln();
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=50;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/(count($headersps)-1);

for ($i=0; $i < count($headersps); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$headersps[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$headersps[$i],1,0,'L',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
for ($i=0; $i < count($aud_prips); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_prips[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_prips[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($aud_segps); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_segps[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_segps[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($aud_totps); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_totps[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_totps[$i],1,0);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_prips); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_prips[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($por_prips[$i]);
		if ($porcen<85) {			
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=95){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$por_prips[$i],1,0,'L',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_segps); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_segps[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_segps[$i],1,0);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_totps); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_totps[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_totps[$i],1,0);
	}
}
$pdf->Ln(10);
$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
for ($i=0; $i < count($pre_prips); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_prips[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_prips[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($pre_segps); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_segps[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_segps[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($pre_totps); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_totps[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_totps[$i],1,0);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_pre_prips); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_pre_prips[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($por_pre_prips[$i]);
		if ($porcen<85) {			
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=95){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$por_pre_prips[$i],1,0,'L',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_pre_segps); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_pre_segps[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_pre_segps[$i],1,0);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_totps); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_totps[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_totps[$i],1,0);
	}
}

////////// PAGINA 1-2

////////// PAGINA 1-2

$pdf->AddPage();

$pdf->SetFont('Arial','B',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("INDICADORES DE RESULTADOS DE AUDITORÍA PROCESO DE CORTE"),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',13);

$file_path=$file_path_dir.$_GET['n'].'.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=40;
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
for ($i=0; $i < count($aud_apr); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_apr[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_apr[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($aud_rec); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_rec[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_rec[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($aud_tot); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$aud_tot[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$aud_tot[$i],1,0);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_apr); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_apr[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($por_apr[$i]);
		if ($porcen<85) {			
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=95){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$por_apr[$i],1,0,'L',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_rec); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_rec[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_rec[$i],1,0);
	}
}
$pdf->Ln(10);
$pdf->SetFillColor(200);
$pdf->SetTextColor(0);
for ($i=0; $i < count($pre_apr); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_apr[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_apr[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($pre_rec); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_rec[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_rec[$i],1,0);
	}
}
$pdf->Ln();
for ($i=0; $i < count($pre_tot); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$pre_tot[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$pre_tot[$i],1,0);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_pre_apr); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_pre_apr[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$porcen=getPercentValue($por_pre_apr[$i]);
		if ($porcen<85) {			
			$pdf->SetFillColor(220,20,30);
		}else{
			if($porcen>=95){
				$pdf->SetFillColor(90,195,40);
			}else{
				$pdf->SetFillColor(220,160,10);				
			}
		}
		$pdf->Cell($width_by_cell,6,$por_pre_apr[$i],1,0,'L',true);
	}
}
$pdf->Ln();
$pdf->SetFillColor(10,70,150);
for ($i=0; $i < count($por_pre_rec); $i++) { 
	if ($i==0) {
		$pdf->SetTextColor(255);
		$pdf->Cell($first_col_width,6,$por_pre_rec[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);
		$pdf->Cell($width_by_cell,6,$por_pre_rec[$i],1,0);
	}
}

/////////// PAGINA 2

$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 1"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t2']),0,0,'C');

$file_path=$file_path_dir.$_GET['n'].'-2.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDU=0;
$coddefuno=0;
$coddefdos=0;
$sql="BEGIN SP_APCR_INDRES(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=3;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if ($i==0) {
		$coddefuno=$row['CODFAMILIA'];
	}
	if ($i==1) {
		$coddefdos=$row['CODFAMILIA'];
	}
	$obj=new stdClass();
	$obj->CODFAMILIA=$row['CODFAMILIA'];
	$obj->DSCFAMILIA=utf8_encode($row['DSCFAMILIA']);
	$obj->SUMA=$row['SUMA'];
	$defuno[$i]=$obj;
	$i++;
	$sumDU+=(int)$row['SUMA'];
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[80,40,30,40];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) { 
	$porcen=round($defuno[$i]->SUMA*10000/$sumDU)/100;
	$sumPorce+=$porcen;
	if ($sumPorce>100) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DSCFAMILIA),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Ln();
}

/////////////PAGINA 3
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 1"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t3']),0,0,'C');

$file_path=$file_path_dir.$_GET['n'].'-3.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defunomes=[];
$i=0;
$sumDUM=0;
$coddefunoM=0;
$coddefdosM=0;
$sql="BEGIN SP_APCR_INDRES(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
$opcion=4;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	if ($i==0) {
		$coddefunoM=$row['CODFAMILIA'];
	}
	if ($i==1) {
		$coddefdosM=$row['CODFAMILIA'];
	}
	$obj=new stdClass();
	$obj->CODFAMILIA=$row['CODFAMILIA'];
	$obj->DSCFAMILIA=utf8_encode($row['DSCFAMILIA']);
	$obj->SUMA=$row['SUMA'];
	$defunomes[$i]=$obj;
	$i++;
	$sumDUM+=(int)$row['SUMA'];
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[80,40,30,40];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defunomes); $i++) { 
	$porcen=round($defunomes[$i]->SUMA*10000/$sumDUM)/100;
	$sumPorce+=$porcen;
	if ($sumPorce>100) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defunomes[$i]->DSCFAMILIA),1,0);
	$pdf->Cell($width_by_cell[1],6,$defunomes[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Ln();
}

/////////////////PAGINA 4
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 2"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t4']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. ".utf8_decode($_GET['t4_1'])." (1er Mayor Defecto)",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-4.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);


$defuno=[];
$i=0;
$sumDefectosU=0;
$sql="BEGIN SP_APCR_INDRES2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODFAM', $coddefuno);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$obj=new stdClass();
	$obj->CODDEF=$row['CODDEF'];
	$obj->DESDEF=utf8_encode($row['DESDEF']);
	if ($row['CANDEF']==null) {
		$sumDefectosU+=0;
		$obj->SUMA=0;
	}else{
		$sumDefectosU+=(int)$row['CANDEF'];
		$obj->SUMA=$row['CANDEF'];
	}
	$defuno[$i]=$obj;
	$i++;
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[75,25,25,25,10,30];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO","","% DEL GENERAL"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);
$pdf->Cell($width_by_cell[4],6,$headers[4],0,0);
$pdf->Cell($width_by_cell[5],6,$headers[5],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) { 
	if ($sumDefectosU!=0) {
		$porcen=round($defuno[$i]->SUMA*10000/$sumDefectosU)/100;
	}else{
		$porcen=0;		
	}
	if ($sumDU!=0) {
		$porcen2=round($defuno[$i]->SUMA*10000/$sumDU)/100;
	}else{
		$porcen2=0;		
	}
	$sumPorce+=$porcen;
	if ($sumPorce>100 || $i==count($defuno)-1) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DESDEF),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Cell($width_by_cell[4],6,"",0,0);
	$pdf->Cell($width_by_cell[5],6,$porcen2."%",1,0);
	$pdf->Ln();
}

/////////////////PAGINA 5
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 2"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t4']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. ".utf8_decode($_GET['t4_2'])." (2do Mayor Defecto)",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-5.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosD=0;
$sql="BEGIN SP_APCR_INDRES2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODFAM', $coddefdos);
$opcion=0;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$obj=new stdClass();
	$obj->CODDEF=$row['CODDEF'];
	$obj->DESDEF=utf8_encode($row['DESDEF']);
	$obj->SUMA=$row['CANDEF'];
	$defuno[$i]=$obj;
	$i++;
	$sumDefectosD+=(int)$row['CANDEF'];
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[75,25,25,25,10,30];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO","","% DEL GENERAL"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);
$pdf->Cell($width_by_cell[4],6,$headers[4],0,0);
$pdf->Cell($width_by_cell[5],6,$headers[5],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) { 
	if($sumDefectosD!=0){
		$porcen=round($defuno[$i]->SUMA*10000/$sumDefectosD)/100;
	}else{
		$porcen=0;
	}
	if($sumDU!=0){
		$porcen2=round($defuno[$i]->SUMA*10000/$sumDU)/100;
	}else{
		$porcen2=0;
	}
	$sumPorce+=$porcen;
	if ($sumPorce>100 || $i==count($defuno)-1) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DESDEF),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Cell($width_by_cell[4],6,"",0,0);
	$pdf->Cell($width_by_cell[5],6,$porcen2."%",1,0);
	$pdf->Ln();
}

/////////////////PAGINA 6
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 2"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t5']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"1. ".utf8_decode($_GET['t5_1'])." (1er Mayor Defecto)",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-6.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosUM=0;
$sql="BEGIN SP_APCR_INDRES2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODFAM', $coddefunoM);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$obj=new stdClass();
	$obj->CODDEF=$row['CODDEF'];
	$obj->DESDEF=utf8_encode($row['DESDEF']);
	if ($row['CANDEF']==null) {
		$sumDefectosUM+=0;
		$obj->SUMA=0;
	}else{
		$sumDefectosUM+=(int)$row['CANDEF'];
		$obj->SUMA=$row['CANDEF'];
	}
	$defuno[$i]=$obj;
	$i++;
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[75,25,25,25,10,30];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO","","% DEL GENERAL"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);
$pdf->Cell($width_by_cell[4],6,$headers[4],0,0);
$pdf->Cell($width_by_cell[5],6,$headers[5],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) {
	if ($sumDefectosUM==0) {
		$porcen=0;
	}else{
		$porcen=round($defuno[$i]->SUMA*10000/$sumDefectosUM)/100;
	}
	if ($sumDUM==0) {
		$porcen2=0;
	}else{
		$porcen2=round($defuno[$i]->SUMA*10000/$sumDUM)/100;
	}
	
	$sumPorce+=$porcen;
	if ($sumPorce>100 || $i==count($defuno)-1) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DESDEF),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Cell($width_by_cell[4],6,"",0,0);
	$pdf->Cell($width_by_cell[5],6,$porcen2."%",1,0);
	$pdf->Ln();
}

/////////////////PAGINA 7
$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("DIAGRAMA DE PARETO GENERAL - NIVEL N° 2"),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t5']),0,0,'C');
$pdf->Ln();
$pdf->Cell($pdf->get_max_width_to_white(),6,"2. ".utf8_decode($_GET['t5_2'])." (2do Mayor Defecto)",0,0,'L');

$file_path=$file_path_dir.$_GET['n'].'-7.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Ln();
$pdf->Image($file_path , $array[2],30,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$defuno=[];
$i=0;
$sumDefectosDM=0;
$sql="BEGIN SP_APCR_INDRES2(:CODTLL,:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':CODTLL', $_GET['ct']);
oci_bind_by_name($stmt, ':CODSED', $_GET['cs']);
oci_bind_by_name($stmt, ':CODTIPSER', $_GET['cts']);
oci_bind_by_name($stmt, ':FECHA', $fecha);
oci_bind_by_name($stmt, ':CODFAM', $coddefdosM);
$opcion=1;
oci_bind_by_name($stmt, ':OPCION', $opcion);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while ($row=oci_fetch_assoc($OUTPUT_CUR)) {
	$obj=new stdClass();
	$obj->CODDEF=$row['CODDEF'];
	$obj->DESDEF=utf8_encode($row['DESDEF']);
	$obj->SUMA=$row['CANDEF'];
	$defuno[$i]=$obj;
	$i++;
	$sumDefectosDM+=(int)$row['CANDEF'];
}

$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);
$width_by_cell=[75,25,25,25,10,30];
$headers=["DEFECTOS","FRECUENCIA","%","% ACUMULADO","","% DEL GENERAL"];
$pdf->Cell($width_by_cell[0],6,$headers[0],1,0,'L',true);
$pdf->Cell($width_by_cell[1],6,$headers[1],1,0,'L',true);
$pdf->Cell($width_by_cell[2],6,$headers[2],1,0,'L',true);
$pdf->Cell($width_by_cell[3],6,$headers[3],1,0,'L',true);
$pdf->Cell($width_by_cell[4],6,$headers[4],0,0);
$pdf->Cell($width_by_cell[5],6,$headers[5],1,0,'L',true);

$pdf->Ln();
$pdf->SetTextColor(0);
$sumPorce=0;
for ($i=0; $i < count($defuno); $i++) {
	if($sumDefectosDM!=0){
		$porcen=round($defuno[$i]->SUMA*10000/$sumDefectosDM)/100;
	}else{
		$porcen=0;
	}
	if($sumDUM!=0){
		$porcen2=round($defuno[$i]->SUMA*10000/$sumDUM)/100;
	}else{
		$porcen2=0;
	}
	$sumPorce+=$porcen;
	if ($sumPorce>100 || $i==count($defuno)-1) {
		$sumPorce=100;
	}
	$pdf->Cell($width_by_cell[0],6,($i+1).". ".utf8_decode($defuno[$i]->DESDEF),1,0);
	$pdf->Cell($width_by_cell[1],6,$defuno[$i]->SUMA,1,0);
	$pdf->Cell($width_by_cell[2],6,$porcen."%",1,0);
	$pdf->Cell($width_by_cell[3],6,$sumPorce."%",1,0);
	$pdf->Cell($width_by_cell[4],6,"",0,0);
	$pdf->Cell($width_by_cell[5],6,$porcen2."%",1,0);
	$pdf->Ln();
}

$pdf->Output('D','Indicar de Resultados - '.str_replace("/","-",$_GET['t']).'.pdf',true);
//$pdf->Output('','',true);

oci_close($conn);

//// DELETE FILES
$files = glob("../assets/tmp/*"); 
foreach($files as $file){
    if(is_file($file) && strpos($file,$_GET['n'])){
        unlink($file);
    }
}
?>