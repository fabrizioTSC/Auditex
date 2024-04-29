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
			break;
	}
	return $text;
}
function get_vez($vez){
	switch ($vez) {
		case '1':
			return $vez.'st';
			break;
		case '2':
			return $vez.'nd';
			break;
		case '3':
			return $vez.'rd';
			break;
		default:
			break;
	}
}

require('fpdf181/fpdf.php');
class PDF extends FPDF {
	const A4_HEIGHT = 297;
	const A4_WIDTH = 210;
	const MAX_WIDTH = 	2450;
	const MAX_WIDTH_TO_WHITE = 190;
	const MAX_HEIGHT_TO_WHITE = 277;

	function get_max_width_to_white($orientation) {
		if ($orientation=='P') {
			return self::MAX_WIDTH_TO_WHITE;
		}else{
			return self::MAX_HEIGHT_TO_WHITE;
		}		
	}
}
include("../config/connection.php");
$sql="BEGIN SP_RLE_SELECT_POPLCAL(:PO,:PACLIS,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':PO', $_GET['po']);
oci_bind_by_name($stmt, ':PACLIS', $_GET['paclis']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
$obj=new stdClass();
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	$obj->PO=$row['PO'];
	$obj->ESTCLI=$row['ESTCLI'];
	$obj->FECGEN=$row['FECGEN'];
	$obj->FECAPR=$row['FECAPR'];
	$obj->CODUSU=$row['CODUSU'];
	$obj->FORM=utf8_encode($row['FORM']);
	$obj->VERSION=utf8_encode($row['VERSION']);
	$obj->FECHA=$row['FECHA'];
	$obj->VENDOR=utf8_encode($row['VENDOR']);
	$obj->FACTORY=$row['FACTORY'];
	$obj->CODAQL=$row['CODAQL'];
	$obj->CANTIDAD=$row['CANTIDAD'];
	$obj->CODWARDES=$row['CODWARDES'];
	$obj->CANAUD=$row['CANAUD'];
	$obj->CANDEFMAX=$row['CANDEFMAX'];
	$obj->CANDEF=$row['CANDEF'];
	$obj->DESPRE=utf8_encode($row['DESPRE']);
	$obj->DESCOL=utf8_encode($row['DESCOL']);
	$obj->CODAUD=$row['CODAUD'];
	$obj->NUMCAJ=$row['NUMCAJ'];
	$obj->RESULTADO=utf8_encode($row['RESULTADO']);
	$obj->CARINSPULL=utf8_encode($row['CARINSPULL']);
	$obj->CARINSMOISTURE=utf8_encode($row['CARINSMOISTURE']);
	$obj->COMENTARIOS=utf8_encode($row['COMENTARIOS']);
	$obj->AQL=str_replace(",",".",$row['AQL']);
	$obj->NOMAUD=utf8_encode($row['NOMAUD']);
	$obj->CATEGORIA=utf8_encode($row['CATEGORIA']);
	$obj->DESCOLREP=utf8_encode($row['DESCOLREP']);
	$obj->FINALAUDIT=utf8_encode($row['FINALAUDIT']);
	$obj->PREFINAL=utf8_encode($row['PREFINAL']);
	$obj->INLINE=utf8_encode($row['INLINE']);
	$obj->INLINEVEZ=utf8_encode($row['INLINEVEZ']);
	$obj->REAUDIT=utf8_encode($row['REAUDIT']);
	$obj->REAUDITVEZ=utf8_encode($row['REAUDITVEZ']);
	$obj->CERTIFIEDAUD=utf8_encode($row['CERTIFIEDAUD']);
	$obj->TRAINEE=utf8_encode($row['TRAINEE']);
	$obj->PRECERTIFIEDAUD=utf8_encode($row['PRECERTIFIEDAUD']);
	$obj->CORRELATIONAUD=utf8_encode($row['CORRELATIONAUD']);
	$obj->LEAUDITOR=utf8_encode($row['LEAUDITOR']);
}

$orientation_page='L';
$logo_width=52;
$margin_logo=4;
$logo_height=8;
$pdf = new PDF();
$pdf->AddPage($orientation_page,'A4');
$pdf->SetFont('Arial','B',18);
$x=$pdf->GetX();
$pdf->SetX($x);
$pdf->Cell($logo_width+$margin_logo*2,12,'',0,'L');
$pdf->Cell($pdf->get_max_width_to_white($orientation_page)-$logo_width-$margin_logo*2,16,'FINAL INSPECTION SUMMARY',0,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$pdf->Cell(4,30,'',0,'L');
$pdf->Cell(30,30,$obj->FORM,0,'L');
$pdf->Cell(60,30,'Version: '.$obj->VERSION,0,'L');
$pdf->Cell($pdf->get_max_width_to_white($orientation_page)-98,30,'PAGE __1__ OF __1__',0,0,'R');
/*Primera fila*/
$pdf->SetX($x);
$pdf->Cell($pdf->get_max_width_to_white($orientation_page),18,'','LTRB',0,'L',0);
$pdf->Ln();
/*2da fila*/
$array_fila2=[35,70,70,25,15,62];
$x_bigrow=$pdf->GetX();
$x=$pdf->GetX();
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[0],	6,'DATE (M/D/Y)',0,'L');
$pdf->Cell($array_fila2[1],	6,'Vendor Name / #',0,'L');
$pdf->Cell($array_fila2[2],	6,'Factory Name / #',0,'L');
$pdf->Cell($array_fila2[3],	6,'AQL Level / #',0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell($array_fila2[4],	6,$obj->AQL,0,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','B',10);
$pdf->Cell($array_fila2[0],	18,$obj->FECGEN,0,'L');
$pdf->Cell($array_fila2[1],	18,$obj->VENDOR,0,'L');
$pdf->Cell($array_fila2[2],	18,$obj->FACTORY,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[3],	18,'Lote Size',0,'L');
$pdf->Cell($array_fila2[4],	18,$obj->CANTIDAD,0,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[0],	12,'','LTRB','L');
$pdf->Cell($array_fila2[1],	12,'','LTRB','L');
$pdf->Cell($array_fila2[2],	12,'','LTRB','L');
$pdf->Cell($array_fila2[3]+$array_fila2[4],	6,'','LTRB','L');
$pdf->SetX($x);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3]+$array_fila2[4],	12,'','LTRB','L');
$pdf->Ln();
/*3era fila*/
$x=$pdf->GetX();
$pdf->SetX($x);
$pdf->Cell($array_fila2[0],	6,'Warehouse',0,'L');
$pdf->Cell($array_fila2[1]+$array_fila2[2],	6,'Dodge D.C.             LE UK D.C.                        Reedsburg D.C.                    Japan',0,'L');
$pdf->Cell($array_fila2[3],	6,'Sample Size',0,'L');
$pdf->Cell($array_fila2[4],	6,$obj->CANAUD,0,'L');
$pdf->SetX($x);
$pdf->Cell($array_fila2[0],	18,'Destination DVDC',0,'L');
$pdf->Cell($array_fila2[1]+$array_fila2[2],18,'LEJ D.C..                LE Bussiness Outfitters D.C.                Retail',0,'L');
$pdf->Cell($array_fila2[3],	18,'A/R Level',0,'L');
$pdf->Cell($array_fila2[4],	18,$obj->CANDEFMAX."/".(intval($obj->CANDEFMAX)+1),0,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[0],	12,'','LTRB','L');
$pdf->Cell($array_fila2[1]+$array_fila2[2],	12,'','LTRB','L');
$pdf->Cell($array_fila2[3]+$array_fila2[4],	6,'','LTRB','L');
$pdf->SetX($x);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3]+$array_fila2[4],	12,'','LTRB','L');
$pdf->Ln();
/*4ta fila*/
$array_fila2=[105,20,20,30,40,62];
$x=$pdf->GetX();
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[0],	6,'Style #    '.$obj->ESTCLI,0,'L');
$pdf->Cell($array_fila2[1],	6,'',0,'L');
$pdf->Cell($array_fila2[2],	6,'CAT #',0,'L');
$pdf->Cell($array_fila2[3],	6,$obj->CATEGORIA,0,'L');
$pdf->Cell($array_fila2[4],	6,'NON-CONF. Units: '.$obj->CANDEF,0,'L');
$pdf->SetX($x);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3]+$array_fila2[4],	6,'','LTRB','L');
$pdf->SetX($x);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3],	6,'','LTRB','L');
$pdf->Ln();
/*5ta fila*/
$array_fila2=[70,20,30,55,40,62];
$x=$pdf->GetX();
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[0],	6,'PO #    '.$_GET['po'],0,'L');
$pdf->Cell($array_fila2[1],	6,'Auditor(s):',0,'L');
$pdf->Cell($array_fila2[2]+$array_fila2[3],	6,utf8_decode($obj->NOMAUD),0,'L');
$pdf->SetFont('Arial','B',10);
$resultado="PASS";
if ($obj->RESULTADO=="R") {
	$resultado="FAIL";
}
$pdf->Cell($array_fila2[4],	6,'Total Cartons: '.$obj->NUMCAJ	,0,'L');
$pdf->Cell($array_fila2[5],	6,'STATUS: '.$resultado	,0,'L');
$pdf->SetX($x);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3]+$array_fila2[4],	6,'','LTRB','L');
$pdf->Cell($array_fila2[5],	6,'','LTRB','L');
$pdf->SetX($x);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3],	6,'','LTRB','L');
$pdf->Ln();
/*6ta fila*/
$array_fila2=[85,15,20,55,40,62];
$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[0]+$array_fila2[1],	6,'Item Description: '.$obj->DESPRE,0,'L');
$pdf->Cell($array_fila2[2],	6,'',0,'L');
$pdf->Cell($array_fila2[3],	6,'',0,'L');
$pdf->Cell($array_fila2[4],	6,'',0,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$descolrep_size=38;
$descolrep=$obj->DESCOLREP;

if (strlen($descolrep)>$descolrep_size) {
	$descolrep=$obj->DESCOLREP;
}

// $descolrep=$obj->DESCOLREP;


$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3]+$array_fila2[4],	18,'Color(s): '.$descolrep,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->SetX($x);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3]+$array_fila2[4]+$array_fila2[5],	6,'','LTRB','L');
$pdf->Ln();
$array_fila2=[105,20,20,30,40,62];
$y_esp=30;
$pdf->SetY($y_esp);
$pdf->SetX(235);
$pdf->SetFont('Arial','',8);
$pdf->Cell(23,	4,'Final Audit',0,'L');
$pdf->Cell(23,	4,'Correlation Audit',0,'L');
$y_esp+=4;
$pdf->SetY($y_esp);
$pdf->SetX(235);
$pdf->Cell(23,	4,'Pre-Final',0,'L');
$pdf->Cell(23,	4,'LE Auditor',0,'L');
$y_esp+=4;
$pdf->SetY($y_esp);
$pdf->SetX(235);
//$pdf->Cell(46,	4,'In-Line: 1st, 2nd, 3rd: _______',0,'L');
$inlinevez='______';
if ($obj->INLINE!="0") {
	$inlinevez=get_vez($obj->INLINEVEZ);
}
$pdf->Cell(46,	4,'In-Line: '.$inlinevez,0,'L');
$y_esp+=4;
$pdf->SetY($y_esp);
$pdf->SetX(235);
//$pdf->Cell(46,	4,'Re-Audit: 1st, 2nd, 3rd _______',0,'L');
$reauditvez='______';
if ($obj->INLINE!="0") {
	$reauditvez=get_vez($obj->REAUDITVEZ);
}
$pdf->Cell(46,	4,'Re-Audit: '.$reauditvez,0,'L');
$y_esp+=4;
$pdf->SetY($y_esp);
$pdf->SetX(235);
$pdf->Cell(46,	4,'Certified Auditor',0,'L');
$y_esp+=4;
$pdf->SetY($y_esp);
$pdf->SetX(235);
$pdf->Cell(46,	4,'Trainee',0,'L');
$y_esp+=4;
$pdf->SetY($y_esp);
$pdf->SetX(235);
$pdf->Cell(46,	4,'Pre-Certified Auditor',0,'L');
$y_esp+=5;
$pdf->SetY($y_esp);
$pdf->SetX(235);
$pdf->SetFont('Arial','B',10);
$pdf->SetY(28);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3]+$array_fila2[4]+$array_fila2[5],	48,'','LTRB','L');
$pdf->SetY(28);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3]+$array_fila2[4]+$array_fila2[5],	36,'','LTRB','L');
/*7ma fila*/
$array_fila2=[215,62];
$pdf->SetY($y+12);
$x=$pdf->GetX();
$pdf->SetX($x);
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[0],	6,'Classification of Defects           Sewing - S    Fabric - F    Dirt/Oil - D/O    Pkg/Label - P/L    Color - C    Measure - M',0,'L');
$pdf->Cell($array_fila2[1],	6,'LE Audit # '.$obj->CODAUD,0,'L');
$pdf->SetX($x);
$pdf->Cell($array_fila2[0]+$array_fila2[1],	6,'','LTRB','L');
$pdf->Ln(8);
/*Inicio tabla defectos*/
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell($array_fila2[0]+$array_fila2[1],	6,'Defect Description','LTRB',0,'L',true);
$pdf->Ln();
/*Cabecera defectos*/
$array_fila2=[22,15,150,90];
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell($array_fila2[0],	6,'Defect Code','LTRB',0,'C');
$pdf->Cell($array_fila2[1],	6,'Qty','LTRB',0,'C');
$pdf->Cell($array_fila2[2],	6,'Defect Description','LTRB',0,'L');
$pdf->Cell($array_fila2[3],	6,'Corrective Action','LTRB',0,'L');
$pdf->Ln();
/*Cuerpo defectos*/
$defectos=[];
$sql="BEGIN SP_RLE_SELECT_POPLCALDEF(:PO,:PACLIS,:OUTPUT_CUR); END;";
$stmt=oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':PO', $_GET['po']);
oci_bind_by_name($stmt, ':PACLIS', $_GET['paclis']);
$OUTPUT_CUR=oci_new_cursor($conn);
oci_bind_by_name($stmt, ':OUTPUT_CUR', $OUTPUT_CUR,-1,OCI_B_CURSOR);
$result=oci_execute($stmt);
oci_execute($OUTPUT_CUR);
while($row=oci_fetch_assoc($OUTPUT_CUR)){
	if (intval($row['CANDEFREP'])>0) {
		$def=new stdClass();
		$def->CODE=$row['CODDEFCLI'];
		$def->QTY=$row['CANDEFREP'];
		$def->DESDEF=utf8_encode($row['DESDEF']);
		$def->CORACT=utf8_encode($row['CORRECTIVEACTION']);
		array_push($defectos, $def);
	}
}
$max_defects=7;
$iteraton=count($defectos);
$complement=0;
if (count($defectos)<$max_defects) {
	$iteraton=$max_defects;
	$complement=$max_defects-count($defectos);
}
for ($i=0; $i < count($defectos) ; $i++) { 
	$pdf->Cell($array_fila2[0],	6,$defectos[$i]->CODE,'LTRB',0,'C');
	$pdf->Cell($array_fila2[1],	6,$defectos[$i]->QTY,'LTRB',0,'C');
	$pdf->Cell($array_fila2[2],	6,$defectos[$i]->DESDEF,'LTRB',0,'L');
	$pdf->Cell($array_fila2[3],	6,$defectos[$i]->CORACT,'LTRB',0,'L');
	$pdf->Ln();
}
for ($i=0; $i < $complement ; $i++) { 
	$pdf->Cell($array_fila2[0],	6,'','LTRB',0,'L');
	$pdf->Cell($array_fila2[1],	6,'','LTRB',0,'L');
	$pdf->Cell($array_fila2[2],	6,'','LTRB',0,'L');
	$pdf->Cell($array_fila2[3],	6,'','LTRB',0,'L');
	$pdf->Ln();
}
$pdf->SetFont('Arial','',8);
$pdf->Cell($array_fila2[0]+$array_fila2[1],	6,'Carton # Inspection Pull','LTRB',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell($array_fila2[2]+$array_fila2[3],	6,utf8_decode($obj->CARINSPULL),'LTRB',0,'L');
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$pdf->Cell($array_fila2[0]+$array_fila2[1],	6,'Carton # Inspection Moisture','LTRB',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell($array_fila2[2]+$array_fila2[3],	6,utf8_decode($obj->CARINSMOISTURE),'LTRB',0,'L');
$pdf->Ln(8);

/*Inicio tabla secundaria*/
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','',10);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3],	6,'General Comments:','LTRB',0,'L',true);
$pdf->Ln();
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3],	12,utf8_encode($obj->COMENTARIOS),'LTRB',0,'L');
$pdf->Ln();
$pdf->Cell($array_fila2[0]+$array_fila2[1]+$array_fila2[2]+$array_fila2[3],	6,'MOISTURE READINGS ATTACHED FOR REFERENCE','LTRB',0,'L');
$pdf->Ln(7);

/*Firmas*/
$array_fila2=[130,17,130];
$pdf->SetFont('Arial','',9);
$pdf->Cell($array_fila2[0],6,'Land\'s End Certified Auditor\'s Name: '.utf8_encode($obj->NOMAUD),'',0,'R');
$pdf->Cell($array_fila2[1],6,'','',0,'L');
$pdf->Cell($array_fila2[2],6,'Land\'s End Certified Auditor ID # '.utf8_encode($obj->CODAUD),'',0,'L');
$pdf->Ln();
/*
$pdf->Cell($array_fila2[0],6,'Trainee Certified Auditor\'s Name: ______________________','',0,'R');
$pdf->Cell($array_fila2[1],6,'','',0,'L');
$pdf->Cell($array_fila2[2],6,'      Trainee Certified Auditor ID # ______________________','',0,'L');
$pdf->Ln();*/

/*IMAGENES INSERTADAS*/
$file_path='../assets/img/logo_le.jpeg';
$pdf->Image($file_path, 14,14,$logo_width,$logo_height,'JPG');
if ($obj->CODWARDES=="1") {
	$file_path='../assets/img/radio-active.png';
}else{
	$file_path='../assets/img/radio.png';
}
$pdf->Image($file_path, 68,41,4,4,'PNG');
if ($obj->CODWARDES=="2") {
	$file_path='../assets/img/radio-active.png';
}else{
	$file_path='../assets/img/radio.png';
}
$pdf->Image($file_path, 100,41,4,4,'PNG');
if ($obj->CODWARDES=="3") {
	$file_path='../assets/img/radio-active.png';
}else{
	$file_path='../assets/img/radio.png';
}
$pdf->Image($file_path, 152,41,4,4,'PNG');
if ($obj->CODWARDES=="4") {
	$file_path='../assets/img/radio-active.png';
}else{
	$file_path='../assets/img/radio.png';
}
$pdf->Image($file_path, 68,46.5,4,4,'PNG');
if ($obj->CODWARDES=="5") {
	$file_path='../assets/img/radio-active.png';
}else{
	$file_path='../assets/img/radio.png';
}
$pdf->Image($file_path, 123,46.5,4,4,'PNG');
if ($obj->CODWARDES=="6") {
	$file_path='../assets/img/radio-active.png';
}else{
	$file_path='../assets/img/radio.png';
}
$pdf->Image($file_path, 152,46.5,4,4,'PNG');
if ($obj->CODWARDES=="7") {
	$file_path='../assets/img/radio-active.png';
}else{
	$file_path='../assets/img/radio.png';
}
$pdf->Image($file_path, 178,41,4,4,'PNG');

/*FINAL AUDIT*/
if ($obj->FINALAUDIT=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 232,30.5,2.5,2.5,'PNG');
/*CORRELATION AUDIT*/
if ($obj->CORRELATIONAUD=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 255,30.5,2.5,2.5,'PNG');
/*PREFINAL*/
if ($obj->PREFINAL=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 232,34.5,2.5,2.5,'PNG');
/*LEAUDITOR*/
if ($obj->LEAUDITOR=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 255,34.5,2.5,2.5,'PNG');
/*INLINE*/
if ($obj->INLINE=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 232,38.5,2.5,2.5,'PNG');
/*REAUDIT*/
if ($obj->REAUDIT=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 232,42.5,2.5,2.5,'PNG');
/*CERTIFIEDAUD*/
if ($obj->CERTIFIEDAUD=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 232,46.5,2.5,2.5,'PNG');
/*TRAINEE*/
if ($obj->TRAINEE=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 232,50.5,2.5,2.5,'PNG');
/*PRECERTIFIEDAUD*/
if ($obj->PRECERTIFIEDAUD=="1") {
	$file_path='../assets/img/check-active.png';
}else{
	$file_path='../assets/img/check.png';
}
$pdf->Image($file_path, 232,54.5,2.5,2.5,'PNG');

//$pdf->Output('D','Reporte_Defectos.pdf',true);
$pdf->Output('','',true);

oci_close($conn);

?>