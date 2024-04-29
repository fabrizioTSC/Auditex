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

function formato_porcentaje($value){
	$value=str_replace(",",".",$value);
	if ($value[0]==".") {
		return "0".$value;
	}else{
		return $value;
	}
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


$headersps=[];
$headersps[0]="DETALLE GENERAL";
$preclasplachi=[];
$preclasplachi[0]="PRE. CLAS. PLANTA CHINCHA";
$preclasserchi=[];
$preclasserchi[0]="PRE. CLAS. SERV. CHINCHA";
$preclasserlim=[];
$preclasserlim[0]="PRE. CLAS. SERV. LIMA";
$preclatsc=[];
$preclatsc[0]="PRENDAS CLASIFICADAS TSC";
$preprochi=[];
$preprochi[0]="PRE. PROD. CHINCHA";
$preprolim=[];
$preprolim[0]="PRE. PROD. LIMA";
$preprotsc=[];
$preprotsc[0]="PRENDAS PRODUCIDAS TSC";
$porpreclasplachi=[];
$porpreclasplachi[0]="% CLAS. PLANTA CHINCHA";
$porpreclasserchi=[];
$porpreclasserchi[0]="% CLAS. SERV. CHINCHA";
$porpreclasserlim=[];
$porpreclasserlim[0]="% CLAS. SERV. LIMA";
$porpreclatsc=[];
$porpreclatsc[0]="% PRENDAS CLASIFICADAS TSC";
$objetivo=[];
$objetivo[0]="OBJETIVO";
$l=1;

if ($_GET['cs']=="0" && $_GET['cts']=="0") {
	$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
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
		$headersps[$l]=$row['ANIO'];
		$preclasplachi[$l]=number_format($row['CANCLAPLACHI']);
		$preclasserchi[$l]=number_format($row['CANCLASERCHI']);
		$preclasserlim[$l]=number_format($row['CANCLASERLIM']);
		$preclatsc[$l]=number_format($row['CANCLA']);
		$preprochi[$l]=number_format($row['CANPROCHI']);
		$preprolim[$l]=number_format($row['CANPROLIM']);
		$preprotsc[$l]=number_format($row['CANPRO']);
		$porpreclasplachi[$l]=formato_porcentaje($row['PORCLAPLACHI'])."%";
		$porpreclasserchi[$l]=formato_porcentaje($row['PORCLASERCHI'])."%";
		$porpreclasserlim[$l]=formato_porcentaje($row['PORCLASERLIM'])."%";
		$porpreclatsc[$l]=formato_porcentaje($row['PORCLA'])."%";
		$objetivo[$l]=formato_porcentaje($row['OBJETIVO'])."%";
		$l++;
	}

	$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
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
		$headersps[$l]=format_text_month($row['MES']);
		$preclasplachi[$l]=number_format($row['CANCLAPLACHI']);
		$preclasserchi[$l]=number_format($row['CANCLASERCHI']);
		$preclasserlim[$l]=number_format($row['CANCLASERLIM']);
		$preclatsc[$l]=number_format($row['CANCLA']);
		$preprochi[$l]=number_format($row['CANPROCHI']);
		$preprolim[$l]=number_format($row['CANPROLIM']);
		$preprotsc[$l]=number_format($row['CANPRO']);
		$porpreclasplachi[$l]=formato_porcentaje($row['PORCLAPLACHI'])."%";
		$porpreclasserchi[$l]=formato_porcentaje($row['PORCLASERCHI'])."%";
		$porpreclasserlim[$l]=formato_porcentaje($row['PORCLASERLIM'])."%";
		$porpreclatsc[$l]=formato_porcentaje($row['PORCLA'])."%";
		$objetivo[$l]=formato_porcentaje($row['OBJETIVO'])."%";
		$l++;
	}

	$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
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
		$headersps[$l]="Sem. ".$row['NUMERO_SEMANA'];
		$preclasplachi[$l]=number_format($row['CANCLAPLACHI']);
		$preclasserchi[$l]=number_format($row['CANCLASERCHI']);
		$preclasserlim[$l]=number_format($row['CANCLASERLIM']);
		$preclatsc[$l]=number_format($row['CANCLA']);
		$preprochi[$l]=number_format($row['CANPROCHI']);
		$preprolim[$l]=number_format($row['CANPROLIM']);
		$preprotsc[$l]=number_format($row['CANPRO']);
		$porpreclasplachi[$l]=formato_porcentaje($row['PORCLAPLACHI'])."%";
		$porpreclasserchi[$l]=formato_porcentaje($row['PORCLASERCHI'])."%";
		$porpreclasserlim[$l]=formato_porcentaje($row['PORCLASERLIM'])."%";
		$porpreclatsc[$l]=formato_porcentaje($row['PORCLA'])."%";
		$objetivo[$l]=formato_porcentaje($row['OBJETIVO'])."%";
		$l++;
	}
}else{
	$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
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
		$headersps[$l]=$row['ANIO'];
		$preclatsc[$l]=number_format($row['CANCLA']);
		$preprotsc[$l]=number_format($row['CANPRO']);
		$porpreclatsc[$l]=formato_porcentaje($row['PORCLA'])."%";
		$objetivo[$l]=formato_porcentaje($row['OBJETIVO'])."%";
		$l++;
	}

	$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
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
		$headersps[$l]=format_text_month($row['MES']);
		$preclatsc[$l]=number_format($row['CANCLA']);
		$preprotsc[$l]=number_format($row['CANPRO']);
		$porpreclatsc[$l]=formato_porcentaje($row['PORCLA'])."%";
		$objetivo[$l]=formato_porcentaje($row['OBJETIVO'])."%";
		$l++;
	}

	$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
	$stmt=oci_parse($conn, $sql);
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
		$headersps[$l]="Sem. ".$row['NUMERO_SEMANA'];
		$preclatsc[$l]=number_format($row['CANCLA']);
		$preprotsc[$l]=number_format($row['CANPRO']);
		$porpreclatsc[$l]=formato_porcentaje($row['PORCLA'])."%";
		$objetivo[$l]=formato_porcentaje($row['OBJETIVO'])."%";
		$l++;
	}
}

$file_path_dir='../assets/tmp/';
$pdf = new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial','',13);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode($_GET['t']),0,0,'C');
$pdf->Ln();
$file_path=$file_path_dir.$_GET['n'].'.png';
$array=$pdf->resizeToFit($file_path);
$pdf->Cell($pdf->get_max_width_to_white(),6,utf8_decode("INDICADORES DE RESULTADOS DE PRODUCTOS NO CONFORME"),0,0,'C');
$pdf->Ln();
$pdf->Image($file_path , $array[2],22,$array[0] ,$array[1],'PNG');
$pdf->Ln($array[1]);

$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->SetFillColor(10,70,150);
$pdf->SetTextColor(255);

$first_col_width=45;
$width_by_cell=($pdf->get_max_width_to_white()-$first_col_width)/(count($headersps)-1);

for ($i=0; $i < count($headersps); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$headersps[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$headersps[$i],1,0,'R',true);
	}
}
if (count($preclasplachi)>1) {
	$pdf->Ln();
	$pdf->SetFillColor(200);
	$pdf->SetTextColor(0);
	for ($i=0; $i < count($preclasplachi); $i++) { 
		if ($i==0) {
			$pdf->Cell($first_col_width,6,$preclasplachi[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$preclasplachi[$i],1,0,'R');
		}
	}
	$pdf->Ln();
	for ($i=0; $i < count($preclasserchi); $i++) { 
		if ($i==0) {
			$pdf->Cell($first_col_width,6,$preclasserchi[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$preclasserchi[$i],1,0,'R');
		}
	}
	$pdf->Ln();
	for ($i=0; $i < count($preclasserlim); $i++) { 
		if ($i==0) {
			$pdf->Cell($first_col_width,6,$preclasserlim[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$preclasserlim[$i],1,0,'R');
		}
	}
}
$pdf->Ln();
$pdf->SetTextColor(0);
$pdf->SetFillColor(200);
for ($i=0; $i < count($preclatsc); $i++) { 
	if ($i==0) {
		$pdf->SetFillColor(200);
		$pdf->Cell($first_col_width,6,$preclatsc[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);			
		$pdf->SetFillColor(255,220,45);
		$pdf->Cell($width_by_cell,6,$preclatsc[$i],1,0,'R',true);
	}
}

if (count($preprochi)>1) {
	$pdf->Ln();
	$pdf->SetFillColor(200);
	for ($i=0; $i < count($preprochi); $i++) { 
		if ($i==0) {
			$pdf->Cell($first_col_width,6,$preprochi[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$preprochi[$i],1,0,'R');
		}
	}
	$pdf->Ln();
	for ($i=0; $i < count($preprolim); $i++) { 
		if ($i==0) {
			$pdf->Cell($first_col_width,6,$preprolim[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$preprolim[$i],1,0,'R');
		}
	}
}
$pdf->Ln();
$pdf->SetTextColor(0);
$pdf->SetFillColor(200);
for ($i=0; $i < count($preprotsc); $i++) { 
	if ($i==0) {
		$pdf->SetFillColor(200);
		$pdf->Cell($first_col_width,6,$preprotsc[$i],1,0,'L',true);
	}else{
		$pdf->SetTextColor(0);			
		$pdf->SetFillColor(255,220,45);
		$pdf->Cell($width_by_cell,6,$preprotsc[$i],1,0,'R',true);
	}
}

if (count($porpreclasplachi)>1) {
	$pdf->Ln();
	$pdf->SetFillColor(200);
	for ($i=0; $i < count($porpreclasplachi); $i++) { 
		if ($i==0) {
			$pdf->Cell($first_col_width,6,$porpreclasplachi[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$porpreclasplachi[$i],1,0,'R');
		}
	}
	$pdf->Ln();
	for ($i=0; $i < count($porpreclasserchi); $i++) { 
		if ($i==0) {
			$pdf->Cell($first_col_width,6,$porpreclasserchi[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$porpreclasserchi[$i],1,0,'R');
		}
	}
	$pdf->Ln();
	for ($i=0; $i < count($porpreclasserlim); $i++) { 
		if ($i==0) {
			$pdf->Cell($first_col_width,6,$porpreclasserlim[$i],1,0,'L',true);
		}else{
			$pdf->Cell($width_by_cell,6,$porpreclasserlim[$i],1,0,'R');
		}
	}
}
$pdf->Ln();
$pdf->SetTextColor(0);
$pdf->SetFillColor(200);
for ($i=0; $i < count($porpreclatsc); $i++) { 
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$porpreclatsc[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$porpreclatsc[$i],1,0,'R');
	}
}
$pdf->Ln();
$pdf->SetFillColor(255,0,0);
$pdf->SetTextColor(255,220,45);	
for ($i=0; $i < count($objetivo); $i++) {  
	if ($i==0) {
		$pdf->Cell($first_col_width,6,$objetivo[$i],1,0,'L',true);
	}else{
		$pdf->Cell($width_by_cell,6,$objetivo[$i],1,0,'R',true);
	}
}

/////////// PAGINA 2

$pdf->AddPage();
$pdf->SetFont('Arial','',13);
$pdf->SetTextColor(0);
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
$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
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
$sql="BEGIN SP_APNC_INDICADOR_NC(:CODSED,:CODTIPSER,:FECHA,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
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
$sql="BEGIN SP_APNC_INDICADOR_RESULTADOS2(:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
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
$sql="BEGIN SP_APNC_INDICADOR_RESULTADOS2(:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
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
$sql="BEGIN SP_APNC_INDICADOR_RESULTADOS2(:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
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
$sql="BEGIN SP_APNC_INDICADOR_RESULTADOS2(:CODSED,:CODTIPSER,:FECHA,:CODFAM,:OPCION,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
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